<?php
/**
 *
 * $Rev: 2154 $
 * $LastChangedDate: 2009-11-24 22:30:11 +0800 (Tue, 24 Nov 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Widget
 * @version 1.0
 *
 */

/**
 * Allows recording of media
 */
class Streamwide_Engine_Media_Recorder extends Streamwide_Engine_Widget
{
    
    /**
     * READY state for the recorder widget
     */
    const STATE_READY = 'READY';
    
    /**
     * RECORDING state for the recorder widget
     */
    const STATE_RECORDING = 'RECORDING';
    
    /**
     * Delay the dispatch of the RECORDER_STOPPED event a number of seconds until the recorded media is written to disk (SW Engine issue)
     */
    const OPT_RECORDER_STOPPED_EVENT_DISPATCH_DELAY = 'recorder_stopped_event_dispatch_delay';

    /**
     * Default option values
     */
    const RECORDER_STOPPED_EVENT_DISPATCH_DEFAULT_DELAY = 0;
    
    /**
     * Error codes
     */
    const RECORDSTART_SIGNAL_SEND_FAILURE_ERR_CODE = 'MEDIARECORDER-100';
    const RECORDSTOP_SIGNAL_SEND_FAILURE_ERR_CODE = 'MEDIARECORDER-101';
    const NOT_RECORDING_ERR_CODE = 'MEDIARECORDER-300';
    const ALREADY_RECORDING_ERR_CODE = 'MEDIARECORDER-301';

    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::ERROR,
        Streamwide_Engine_Events_Event::RECORDING,
        Streamwide_Engine_Events_Event::STOPPED
    );
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::RECORDSTART_SIGNAL_SEND_FAILURE_ERR_CODE => 'Sending of signal RECORDSTART failed',
        self::RECORDSTOP_SIGNAL_SEND_FAILURE_ERR_CODE => 'Sending of signal RECORDSTOP failed',
        self::NOT_RECORDING_ERR_CODE => 'Media recorder not recording',
        self::ALREADY_RECORDING_ERR_CODE => 'Media recorder is already recording'
    );
    
    /**
     * A created (alive) media server call leg name
     *
     * @var Streamwide_Engine_Call_Leg_Abstract
     */
    protected $_mediaServerCallLeg;
    
    /**
     * File (allowed extensions are "al", "ul", "3gp") or buffer where the media should be recorded
     *
     * @var Streamwide_Engine_Media
     */
    protected $_storage;
    
    /**
     * A timer used to delay the dispatch of the RECORDER_STOPPED event to allow the recorded file to
     * be written to disk (SW Engine issue)
     *
     * @var Streamwide_Engine_Timer_Timeout
     */
    protected $_timer;
    
    /**
     * The time when we started recording
     *
     * @var integer
     */
    protected $_recordingStartTime = 0;
    
    /**
     * The time when we stopped recording
     *
     * @var integer
     */
    protected $_recordingStopTime = 0;
    
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct( Streamwide_Engine_Media_Server_Call_Leg $mediaServerCallLeg = null )
    {
        parent::__construct();
        if ( null !== $mediaServerCallLeg ) {
            $this->setMediaServerCallLeg( $mediaServerCallLeg );
        }
        $this->_stateManager = new Streamwide_Engine_Widget_State_Manager(
            array(
                self::STATE_READY,
                self::STATE_RECORDING
            )
        );
        $this->_initDefaultOptions();
    }
    
    /**
     * Destructor
     */
    public function destroy()
    {
        if ( isset( $this->_timer ) ) {
            $this->_timer->destroy();
            unset( $this->_timer );
        }
        
        if ( isset( $this->_mediaServerCallLeg ) ) {
            unset( $this->_mediaServerCallLeg );
        }
        
        if ( isset( $this->_storage ) ) {
            unset( $this->_storage );
        }
        
        parent::destroy();
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#setOptions()
     */
    public function setOptions( Array $options )
    {
        $recorderStoppedEventDispatchDelay = isset( $options[self::OPT_RECORDER_STOPPED_EVENT_DISPATCH_DELAY] ) ? $options[self::OPT_RECORDER_STOPPED_EVENT_DISPATCH_DELAY] : null;
        $this->_treatRecorderStoppedEventDispatchDelayOption( $recorderStoppedEventDispatchDelay );
    }
    
    /**
     * File (allowed extensions are "al", "ul", "3gp") or buffer where the media should be recorded
     *
     * @param Streamwide_Engine_Media $storage
     * @return void
     */
    public function setStorage( Streamwide_Engine_Media $storage )
    {
        if ( $storage instanceof Streamwide_Engine_Media_File_Image || $storage instanceof Streamwide_Engine_Media_Fax_Tone ) {
            throw new InvalidArgumentException( __CLASS__ . ' can only use audio or video files or buffers for recording' );
        }
        $this->_storage = $storage;
    }

    /**
     * Retrieve the storage object
     *
     * @return Streamwide_Engine_Media|null
     */
    public function getStorage()
    {
        return $this->_storage;
    }
    
    /**
     * Set the media server call leg used by this media player
     *
     * @param Streamwide_Engine_Media_Server_Call_Leg $mediaServerCallLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setMediaServerCallLeg( Streamwide_Engine_Media_Server_Call_Leg $mediaServerCallLeg )
    {
        if ( !$mediaServerCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive media server call leg' );
        }
        $this->_mediaServerCallLeg = $mediaServerCallLeg;
    }
    
    /**
     * Retrieve the media server call leg object
     *
     * @return Streamwide_Engine_Media_Server_Call_Leg|null
     */
    public function getMediaServerCallLeg()
    {
        return $this->_mediaServerCallLeg;
    }
    
    /**
     * Set the timer object that will be used for delaying the dispatch of the STOPPED event
     *
     * @param $timer
     * @return void
     */
    public function setTimer( Streamwide_Engine_Timer_Timeout $timer )
    {
        $this->_timer = $timer;
    }
    
    /**
     * Retrieve the timer widget (if any) used by the recorder
     *
     * @return Streamwide_Engine_Timer_Timeout
     */
    public function getTimer()
    {
        return $this->_timer;
    }
    
    /**
     * Start recording
     *
     * @return boolean
     * @throws RuntimeException
     */
    public function start()
    {
        if ( $this->isRecording() ) {
            $this->dispatchErrorEvent( self::ALREADY_RECORDING_ERR_CODE );
            return false;
        }
        
        if ( null === $this->_mediaServerCallLeg ) {
            throw new RuntimeException( 'Media server call leg has not been set' );
        }
        
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::RECORDSTART,
            $this->_mediaServerCallLeg->getName(),
            $this->_storage->toArray()
        );
        
        if ( false === $signal->send() ) {
            $this->dispatchErrorEvent( self::RECORDSTART_SIGNAL_SEND_FAILURE_ERR_CODE );
            return false;
        }
        
        $this->_recordingStartTime = time();
        
        $this->_stateManager->setState( self::STATE_RECORDING );
        
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::RECORDING );
        $event->setParam( 'recordStartTime', $this->_recordingStartTime );
        $this->dispatchEvent( $event );
        
        return true;
    }
    
    /**
     * Stop recording
     *
     * @return boolean
     */
    public function stop()
    {
        if ( !$this->isRecording() ) {
            $this->dispatchErrorEvent( self::NOT_RECORDING_ERR_CODE );
            return false;
        }
        
        if ( null === $this->_mediaServerCallLeg ) {
            throw new RuntimeException( 'Media server call leg has not been set' );
        }
        
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::RECORDSTOP,
            $this->_mediaServerCallLeg->getName(),
            $this->_storage->toArray()
        );

        if ( false === $signal->send() ) {
            $this->dispatchErrorEvent( self::RECORDSTOP_SIGNAL_SEND_FAILURE_ERR_CODE );
            return false;
        }
        
        $this->_recordingStopTime = time();
        
        $this->_stateManager->setState( self::STATE_READY );
        
        return $this->_delayRecorderStoppedEventDispatch();
    }
    
    /**
     * Reset the recorder
     *
     * @see Engine/Streamwide_Engine_Widget#reset()
     */
    public function reset()
    {
        parent::reset();
        
        if ( $this->isRecording() ) {
            $this->stop();
        }
        
        if ( isset( $this->_timer ) ) {
            $this->_timer->reset();
        }
        
        $this->_storage = null;
        $this->_recordingStartTime = 0;
        $this->_recordingStopTime = 0;
    }
    
    /**
     * Get the period of time (in seconds) of recording
     *
     * @return integer
     */
    public function getRecordingDuration()
    {
        if ( $this->_recordingStopTime <= $this->_recordingStartTime ) {
            return 0;
        }
        return ( $this->_recordingStopTime - $this->_recordingStartTime );
    }
    
    /**
     * Is the media recorder ready for recording?
     *
     * @return boolean
     */
    public function isReady()
    {
        return ( $this->_stateManager->getState() === self::STATE_READY );
    }
    
    /**
     * Is the media recorder recording?
     *
     * @return boolean
     */
    public function isRecording()
    {
        return ( $this->_stateManager->getState() === self::STATE_RECORDING );
    }
    
    /**
     * Handle the delaying of the RECORDER_STOPPED event (if it's the case). This is a workaround for a problem
     * in SW Engine where the recorded file is not immediately available after sending the RECORDSTOP signal
     *
     * @return void
     * @throws RuntimeException
     */
    protected function _delayRecorderStoppedEventDispatch()
    {
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::STOPPED );
        $event->setParam( 'recordStartTime', $this->_recordingStartTime );
        $event->setParam( 'recordStopTime', $this->_recordingStopTime );
        
        $delay = $this->_options[self::OPT_RECORDER_STOPPED_EVENT_DISPATCH_DELAY];
        if ( 0 === $delay ) {
            $this->dispatchEvent( $event );
            return true;
        }
            
        if ( null === $this->_timer ) {
            throw new RuntimeException( 'Timer object not set' );
        }
        
        $this->_timer->reset();
        $this->_timer->setOptions( array( Streamwide_Engine_Timer_Timeout::OPT_DELAY => $delay ) );
        $this->_timer->addEventListener(
            Streamwide_Engine_Events_Event::TIMEOUT,
            array(
                'callback' => array( $this, 'dispatchEvent' ),
                'args' => $event,
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        
        $armed = $this->_timer->arm();
        if ( !$armed ) {
            $this->_timer->flushEventListeners();
            return false;
        }
        
        return true;
    }
    
    /**
     * Initialize options defaults
     *
     * @return void
     */
    protected function _initDefaultOptions()
    {
        $this->_options[self::OPT_RECORDER_STOPPED_EVENT_DISPATCH_DELAY] = self::RECORDER_STOPPED_EVENT_DISPATCH_DEFAULT_DELAY;
    }
    
    /**
     * Treat the delay of recorder stopped event dispatch option
     *
     * @param float|integer|null $recorderStoppedEventDispatchDelay
     * @return void
     */
    protected function _treatRecorderStoppedEventDispatchDelayOption( $recorderStoppedEventDispatchDelay = null )
    {
        if ( null === $recorderStoppedEventDispatchDelay ) {
            // exit and use the default value
            return;
        }
        
        if ( is_int( $recorderStoppedEventDispatchDelay ) ) {
            $recorderStoppedEventDispatchDelay = (float)$recorderStoppedEventDispatchDelay;
        } elseif ( is_string( $recorderStoppedEventDispatchDelay ) && preg_match( '~^(?:0|[1-9][0-9]*)(?:\.[0-9]+)?$~', $recorderStoppedEventDispatchDelay ) === 1 ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to float', self::OPT_RECORDER_STOPPED_EVENT_DISPATCH_DELAY ) );
            $recorderStoppedEventDispatchDelay = (float)$recorderStoppedEventDispatchDelay;
        }
        
        if ( is_float( $recorderStoppedEventDispatchDelay ) ) {
            $this->_options[self::OPT_RECORDER_STOPPED_EVENT_DISPATCH_DELAY] = $recorderStoppedEventDispatchDelay;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_RECORDER_STOPPED_EVENT_DISPATCH_DELAY ) );
        }
    }
    
}

/* EOF */
