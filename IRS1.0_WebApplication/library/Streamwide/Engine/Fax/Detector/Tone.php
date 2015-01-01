<?php
/**
 *
 * $Rev: 2560 $
 * $LastChangedDate: 2010-04-23 15:49:53 +0800 (Fri, 23 Apr 2010) $
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
 * Provides fax tone detection capabilities
 */
class Streamwide_Engine_Fax_Detector_Tone extends Streamwide_Engine_Detector
{
    
    /**
     * The time (in seconds) the detection is active
     *
     * @var float
     */
    const OPT_DETECTION_DURATION = 'detection_duration';
    
    /**
     * How many seconds to delay the dispatching of the FAX_TONE_DETECTED event
     *
     * @var float
     */
    const OPT_FAX_TONE_DETECTED_EVENT_DISPATCH_DELAY = 'fax_tone_detected_event_dispatch_delay';
    
    /**
     * Default value for the "detection_duration" option
     *
     * @var integer
     */
    const DEFAULT_DETECTION_DURATION = 20;
    
    /**
     * Default value for the "fax_tone_detected_event_dispath_delay" option (0 means no delay)
     *
     * @var integer
     */
    const DEFAULT_FAX_TONE_DETECTED_EVENT_DISPATCH_DELAY = 0;
    
    /**
     * Unable to send the SET signal to SW Engine
     *
     * @var string
     */
    const SET_SIGNAL_SEND_ERR_CODE = 'FAXTONEDETECTOR-100';
    
    /**
     * The media server call leg died during the detection process
     *
     * @var string
     */
    const CALL_LEG_DIED_ERR_CODE = 'FAXTONEDETECTOR-200';
    
    /**
     * An attempt to start the detection process was made, but the widget was already running another detection process
     *
     * @var string
     */
    const ALREADY_DETECTING_ERR_CODE = 'FAXTONEDETECTOR-300';
    
    /**
     * An attempt to stop the detection process was made, but the widget was running no other detection process
     *
     * @var string
     */
    const NOT_DETECTING_ERR_CODE = 'FAXTONEDETECTOR-301';
    
    /**
     * An attempt was made to start or stop the detection process, but the media server call is dead
     *
     * @var string
     */
    const DEAD_CALL_LEG_ERR_CODE = 'FAXTONEDETECTOR-302';
    
    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::FAX_TONE_DETECTION_STARTED,
        Streamwide_Engine_Events_Event::FAX_TONE_DETECTION_STOPPED,
        Streamwide_Engine_Events_Event::FAX_TONE_DETECTED,
        Streamwide_Engine_Events_Event::FAX_TONE_NOT_DETECTED,
        Streamwide_Engine_Events_Event::ERROR
    );
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::SET_SIGNAL_SEND_ERR_CODE => 'Unable to send the SET signal to SW Engine',
        self::CALL_LEG_DIED_ERR_CODE => 'The media server call leg died in the middle of the detection process',
        self::ALREADY_DETECTING_ERR_CODE => 'The fax tone detector is already running',
        self::NOT_DETECTING_ERR_CODE => 'The fax tone detector is not running',
        self::DEAD_CALL_LEG_ERR_CODE => 'Attempt to start/stop the detection process on a dead media server call leg'
    );
    
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->_detectorName = self::T_TONE_DETECTOR;
        $this->_detectionGoalAttainedEventName = Streamwide_Engine_Events_Event::FAX_TONE_DETECTED;
        $this->_detectionGoalUnattainedEventName = Streamwide_Engine_Events_Event::FAX_TONE_NOT_DETECTED;
        $this->_detectionStartedEventName = Streamwide_Engine_Events_Event::FAX_TONE_DETECTION_STARTED;
        $this->_detectionStoppedEventName = Streamwide_Engine_Events_Event::FAX_TONE_DETECTION_STOPPED;
        
        $this->_initDefaultOptions();
    }
    
    /**
     * Set widget options
     *
     * @param Array $options
     * @return void
     */
    public function setOptions( Array $options )
    {
        $detectionDuration = isset( $options[self::OPT_DETECTION_DURATION] )
            ? $options[self::OPT_DETECTION_DURATION]
            : null;
        $this->_treatDetectionDurationOption( $detectionDuration );
        
        $faxToneDetectedEventDispatchDelay = isset( $options[self::OPT_FAX_TONE_DETECTED_EVENT_DISPATCH_DELAY] )
            ? $options[self::OPT_FAX_TONE_DETECTED_EVENT_DISPATCH_DELAY]
            : null;
        $this->_treatFaxToneDetectedEventDispatchDelayOption( $faxToneDetectedEventDispatchDelay );
    }
    
    /**
     * Fax tone detection has timed out, we need to dispatch an event
     * to announce that a fax tone has not been detected
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onFaxToneDetectionTimeout( Streamwide_Engine_Events_Event $event )
    {
        $this->_unsubscribeFromEngineEvents();
        $this->_stateManager->setState( self::STATE_READY );
        return $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::FAX_TONE_NOT_DETECTED ) );
    }
    
    /**
     * Treat the receiving of the EVENT signal from SW Engine
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onEvent( Streamwide_Engine_Events_Event $event )
    {
        if ( isset( $this->_timer ) && $this->_timer->isArmed() ) {
            $this->_timer->disarm();
        }
        
        return $this->_delayFaxDetectedEventDispatch();
    }
    
    /**
     * The allocated time for delaying the dispatching of the FAX_TONE_DETECTED event has elapsed.
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onTimeout( Streamwide_Engine_Events_Event $event )
    {
        $this->_unsubscribeFromEngineEvents();
        $this->_stateManager->setState( self::STATE_READY );
        
        return $this->dispatchEvent( new Streamwide_Engine_Events_Event( $this->_detectionGoalAttainedEventName ) );
    }
    
    /**
     * @see Engine/Streamwide_Engine_Detector#onCallLegDeath($event, $errorCode)
     */
    public function onCallLegDeath( Streamwide_Engine_Events_Event $event )
    {
        return parent::onCallLegDeath( $event, self::CALL_LEG_DIED_ERR_CODE );
    }
    
    /**
     * @see Engine/Streamwide_Engine_Detector#_ensureAliveMediaServerCallLeg($errorCode)
     */
    protected function _ensureAliveMediaServerCallLeg()
    {
        return parent::_ensureAliveMediaServerCallLeg( self::DEAD_CALL_LEG_ERR_CODE );
    }

    /**
     * @see Engine/Streamwide_Engine_Detector#_ensureStartDetectionCorrectState($errorCode)
     */
    protected function _ensureStartDetectionCorrectState()
    {
        return parent::_ensureStartDetectionCorrectState( self::ALREADY_DETECTING_ERR_CODE );
    }

    /**
     * @see Engine/Streamwide_Engine_Detector#_ensureStopDetectionCorrectState($errorCode)
     */
    protected function _ensureStopDetectionCorrectState()
    {
        return parent::_ensureStopDetectionCorrectState( self::NOT_DETECTING_ERR_CODE );
    }
    
    /**
     * @see Engine/Streamwide_Engine_Detector#_activateDetection($errorCode, $params)
     */
    protected function _activateDetection()
    {
        $errorCode = self::SET_SIGNAL_SEND_ERR_CODE;
        $params = array( 'duration' => $this->_options[self::OPT_DETECTION_DURATION] );
        
        return parent::_activateDetection( $errorCode, $params );
    }

    /**
     * @see Engine/Streamwide_Engine_Detector#_armDetectionDurationTimer($detectionDuration, $callback)
     */
    protected function _armDetectionDurationTimer()
    {
        $detectionDuration = $this->_options[self::OPT_DETECTION_DURATION];

        return parent::_armDetectionDurationTimer( $detectionDuration, 'onFaxToneDetectionTimeout' );
    }
    
    /**
     * Delay the dispatch of the FAX_TONE_DETECTED event
     *
     * @return void
     */
    protected function _delayFaxDetectedEventDispatch()
    {
        $faxToneDetectedEventDispatchDelay = $this->_options[self::OPT_FAX_TONE_DETECTED_EVENT_DISPATCH_DELAY];
        if ( $faxToneDetectedEventDispatchDelay > 0 ) {
            $this->_timer->reset();
            $this->_timer->setOptions( array( Streamwide_Engine_Timer_Timeout::OPT_DELAY => $faxToneDetectedEventDispatchDelay ) );
            $this->_timer->addEventListener(
                Streamwide_Engine_Events_Event::TIMEOUT,
                array(
                    'callback' => array( $this, 'onTimeout' ),
                    'options' => array( 'autoRemove' => 'before' )
                )
            );
            $this->_timer->arm();
        } else {
            $this->_unsubscribeFromEngineEvents();
            $this->_stateManager->setState( self::STATE_READY );
            return $this->dispatchEvent( new Streamwide_Engine_Events_Event( $this->_detectionGoalAttainedEventName ) );
        }
    }
    
    /**
     * Initialize options to their default values
     *
     * @return void
     */
    protected function _initDefaultOptions()
    {
        $this->_options[self::OPT_DETECTION_DURATION] = self::DEFAULT_DETECTION_DURATION;
        $this->_options[self::OPT_FAX_TONE_DETECTED_EVENT_DISPATCH_DELAY] = self::DEFAULT_FAX_TONE_DETECTED_EVENT_DISPATCH_DELAY;
    }
    
    /**
     * Treat the detection duration option
     *
     * @param mixed $detectionDuration
     * @return void
     */
    protected function _treatDetectionDurationOption( $detectionDuration = null )
    {
        if ( null === $detectionDuration ) {
            return null;
        }
        
        if ( is_int( $detectionDuration ) ) {
            $detectionDuration = (float)$detectionDuration;
        } elseif (
            is_string( $detectionDuration )
            && preg_match( '~^(?:0|[1-9][0-9]*)(?:\.[0-9]+)?$~', $detectionDuration ) === 1 )
        {
            trigger_error(
                sprintf(
                    'Unexpected data type for option "%s". Value will be automatically converted to float',
                    self::OPT_DETECTION_DURATION
                )
            );
            $detectionDuration = (float)$detectionDuration;
        }

        if ( is_float( $detectionDuration ) ) {
            $this->_options[self::OPT_DETECTION_DURATION] = $detectionDuration;
        } else {
            trigger_error(
                sprintf(
                    'Option "%s" was provided with an invalid value. Using default value',
                    self::OPT_DETECTION_DURATION
                )
            );
        }
    }
    
    /**
     * Treat the fax detected event dispatch delay option
     *
     * @param mixed $faxToneDetectedEventDispatchDelay
     * @return void
     */
    protected function _treatFaxToneDetectedEventDispatchDelayOption( $faxToneDetectedEventDispatchDelay = null )
    {
        if ( null === $faxToneDetectedEventDispatchDelay ) {
            return null;
        }
        
        if ( is_int( $faxToneDetectedEventDispatchDelay ) ) {
            $faxToneDetectedEventDispatchDelay = (float)$faxToneDetectedEventDispatchDelay;
        } elseif (
            is_string( $faxToneDetectedEventDispatchDelay )
            && preg_match( '~^(?:0|[1-9][0-9]*)(?:\.[0-9]+)?$~', $faxToneDetectedEventDispatchDelay ) === 1 )
        {
            trigger_error(
                sprintf(
                    'Unexpected data type for option "%s". Value will be automatically converted to float',
                    self::OPT_FAX_TONE_DETECTED_EVENT_DISPATCH_DELAY
                )
            );
            $faxToneDetectedEventDispatchDelay = (float)$faxToneDetectedEventDispatchDelay;
        }

        if ( is_float( $faxToneDetectedEventDispatchDelay ) ) {
            $this->_options[self::OPT_FAX_TONE_DETECTED_EVENT_DISPATCH_DELAY] = $faxToneDetectedEventDispatchDelay;
        } else {
            trigger_error(
                sprintf(
                    'Option "%s" was provided with an invalid value. Using default value',
                    self::OPT_FAX_TONE_DETECTED_EVENT_DISPATCH_DELAY
                )
            );
        }
    }
    
}

/* EOF */
