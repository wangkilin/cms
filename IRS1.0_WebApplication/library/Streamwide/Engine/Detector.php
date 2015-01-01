<?php
/**
 *
 * $Rev: 2560 $
 * $LastChangedDate: 2010-04-23 15:49:53 +0800 (Fri, 23 Apr 2010) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Package
 * @subpackage SubPackage
 * @version 1.0
 *
 */

/**
 * Base class for all detectors in the system (fax tone detector, voice detector, silence detector)
 */
abstract class Streamwide_Engine_Detector extends Streamwide_Engine_Widget
{

    /**
     * The widget is ready to start the detection process
     *
     * @var string
     */
    const STATE_READY = 'READY';
    
    /**
     * The widget is in the middle of the detection process
     *
     * @var string
     */
    const STATE_DETECTING = 'DETECTING';
    
    /**
     * Fax tone detector type
     *
     * @var string
     */
    const T_TONE_DETECTOR = 'TONE_DETECTOR';
    
    /**
     * Voice activity detection type
     *
     * @var string
     */
    const T_VAD = 'VAD';
    
    /**
     * @var Streamwide_Engine_Media_Server_Call_Leg
     */
    protected $_msCallLeg;
    
    /**
     * @var Streamwide_Engine_Timer_Timeout
     */
    protected $_timer;
    
    /**
     * The name of the detection we are performing (for example VAD or TONE_DETECTOR)
     *
     * @var string
     */
    protected $_detectorName;
    
    /**
     * The name of the type parameter inside the EVENT signal (for example
     * FAXDETECTED, VOICE_DETECTED, SILENCE_DETECTED)
     *
     * @var string
     */
    protected $_eventSignalTypeParameter;
    
    /**
     * The name of the event to dispatch when the detection goal has been
     * attained (for example FAX_TONE_DETECTED, VOICE_DETECTED, SILENCE_DETECTED)
     *
     * @var string
     */
    protected $_detectionGoalAttainedEventName;
    
    /**
     * The name of the event to dispatch when the detection goal has not been
     * attained (for example FAX_TONE_NOT_DETECTED, VOICE_NOT_DETECTED, SILENCE_NOT_DETECTED)
     *
     * @var string
     */
    protected $_detectionGoalUnattainedEventName;
    
    /**
     * The name of the event to dispatch when the detection process has been started
     * (for example FAX_TONE_DETECTION_STARTED, VOICE_DETECTION_STARTED, SILENCE_DETECTION_STARTED)
     *
     * @var string
     */
    protected $_detectionStartedEventName;
    
    /**
     * The name of the event to dispatch when the detection process has been stopped
     * (for example FAX_TONE_DETECTION_STOPPED, VOICE_DETECTION_STOPPED, SILENCE_DETECTION_STOPPED)
     *
     * @var string
     */
    protected $_detectionStoppedEventName;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->_stateManager = new Streamwide_Engine_Widget_State_Manager(
            array(
                self::STATE_READY,
                self::STATE_DETECTING
            )
        );
    }
    
    /**
     * Destructor
     */
    public function destroy()
    {
        if ( isset( $this->_msCallLeg ) ) {
            unset( $this->_msCallLeg );
        }
        
        if ( isset( $this->_timer ) ) {
            $this->_timer->destroy();
            unset( $this->_timer );
        }
        
        parent::destroy();
    }
    
    /**
     * Reset the widget
     *
     * @return void
     */
    public function reset()
    {
        parent::reset();
        
        if ( $this->isDetecting() ) {
            $this->stopDetection();
        }
    }
    
    /**
     * @param Streamwide_Engine_Timer_Timeout $timer
     * @return void
     */
    public function setTimer( Streamwide_Engine_Timer_Timeout $timer )
    {
        $this->_timer = $timer;
    }
    
    /**
     * @return Streamwide_Engine_Timer_Timeout|null
     */
    public function getTimer()
    {
        return $this->_timer;
    }
    
    /**
     * @param Streamwide_Engine_Media_Server_Call_Leg $msCallLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setMediaServerCallLeg( Streamwide_Engine_Media_Server_Call_Leg $msCallLeg )
    {
        if ( !$msCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be an alive media server call leg' );
        }
        
        $this->_msCallLeg = $msCallLeg;
    }
    
    /**
     * @return Streamwide_Engine_Media_Server_Call_Leg|null
     */
    public function getMediaServerCallLeg()
    {
        return $this->_msCallLeg;
    }
    
    /**
     * Is the widget ready to start the detection process
     *
     * @return boolean
     */
    public function isReady()
    {
        return ( $this->_stateManager->getState() === self::STATE_READY );
    }
    
    /**
     * Is the detection process running?
     *
     * @return boolean
     */
    public function isDetecting()
    {
        return ( $this->_stateManager->getState() === self::STATE_DETECTING );
    }
    
    /**
     * Start the detection process
     *
     * @return boolean
     */
    public function startDetection()
    {
        if ( false === $this->_ensureAliveMediaServerCallLeg() ) {
            return false;
        }
        
        if ( false === $this->_ensureStartDetectionCorrectState() ) {
            return false;
        }
        
        if ( false === $this->_activateDetection() ) {
            return false;
        }
        
        if ( false === $this->_armDetectionDurationTimer() ) {
            $this->_deactivateDetection();
            return false;
        }
        
        $this->_subscribeToEngineEvents();
        
        $this->_stateManager->setState( self::STATE_DETECTING );
        
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( $this->_detectionStartedEventName ) );
        return true;
    }
    
    /**
     * Stop the detection process
     *
     * @return boolean
     */
    public function stopDetection()
    {
        if ( false === $this->_ensureAliveMediaServerCallLeg() ) {
            return false;
        }
        
        if ( false === $this->_ensureStopDetectionCorrectState() ) {
            return false;
        }
        
        $this->_deactivateDetection();
        
        $this->_resetDetectionDurationTimer();
        
        $this->_unsubscribeFromEngineEvents();
        
        $this->_stateManager->setState( self::STATE_READY );
        
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( $this->_detectionStoppedEventName ) );
        return true;
    }
    
    /**
     * Callback. Treat the EVENT signal
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onEvent( Streamwide_Engine_Events_Event $event )
    {
        $this->_resetDetectionDurationTimer();
        $this->_stateManager->setState( self::STATE_READY );
        
        return $this->dispatchEvent( new Streamwide_Engine_Events_Event( $this->_detectionGoalAttainedEventName ) );
    }
    
    /**
     * Callback. The allocated time for detecting silence has elapsed.
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onTimeout( Streamwide_Engine_Events_Event $event )
    {
        $this->_unsubscribeFromEngineEvents();
        $this->_stateManager->setState( self::STATE_READY );
        
        return $this->dispatchEvent( new Streamwide_Engine_Events_Event( $this->_detectionGoalUnattainedEventName ) );
    }
    
    /**
     * Callback. Deal with the death of the media server call leg
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onCallLegDeath( Streamwide_Engine_Events_Event $event, $errorCode )
    {
        if ( $this->isDetecting() ) {
            $this->stopDetection();
        }
        
        $this->_msCallLeg->setDead();
        
        return $this->dispatchErrorEvent( $errorCode );
    }
    
    /**
     * Ensure the media server call is alive
     *
     * @param string $errorCode
     * @return boolean
     */
    protected function _ensureAliveMediaServerCallLeg( $errorCode )
    {
        if ( !$this->_msCallLeg->isAlive() ) {
            $this->dispatchErrorEvent( $errorCode );
            return false;
        }
        
        return true;
    }
    
    /**
     * Ensure the widget is in the correct state for starting the detection process
     *
     * @param string $errorCode
     * @return boolean
     */
    protected function _ensureStartDetectionCorrectState( $errorCode )
    {
        if ( $this->isReady() ) {
            return true;
        }
        
        $this->dispatchErrorEvent( $errorCode );
        return false;
    }
    
    /**
     * Ensure the widget is in the correct state for stopping the detection process
     *
     * @param string $errorCode
     * @return boolean
     */
    protected function _ensureStopDetectionCorrectState( $errorCode )
    {
        if ( $this->isDetecting() ) {
            return true;
        }
        
        $this->dispatchErrorEvent( $errorCode );
        return false;
    }
    
    /**
     * Send the SET signal to SW Engine to activate detection
     *
     * @param string $errorCode
     * @param array|null $params
     * @return boolean
     */
    protected function _activateDetection( $errorCode, Array $params = null )
    {
        $invariantParams = array(
            'name' => $this->_detectorName,
            'activate' => 'true'
        );

        if ( is_array( $params ) && !empty( $params ) ) {
            $params = array_merge( $invariantParams, $params );
        }
        else {
            $params = $invariantParams;
        }
        
        $setSignal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::SET,
            $this->_msCallLeg->getName(),
            $params
        );
        
        if ( false === $setSignal->send() ) {
            $this->dispatchErrorEvent( $errorCode );
            return false;
        }
        
        return true;
    }
    
    /**
     * Send the SET signal to SW Engine to deactivate detection
     *
     * @param array|null $params
     * @return void
     */
    protected function _deactivateDetection( Array $params = null )
    {
        $invariantParams = array(
            'name' => $this->_detectorName,
            'activate' => 'false'
        );
        
        if ( is_array( $params ) && !empty( $params ) ) {
            $params = array_merge( $invariantParams, $params );
        }
        else {
            $params = $invariantParams;
        }
        
        $setSignal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::SET,
            $this->_msCallLeg->getName(),
            $params
        );
        $setSignal->send();
    }
    
    /**
     * @param float|integer $detectionDuration
     * @param string $callback
     * @return boolean
     */
    protected function _armDetectionDurationTimer( $detectionDuration, $callback = 'onTimeout' )
    {
        if ( isset( $this->_timer ) && $detectionDuration > 0 ) {
            $this->_timer->reset();
            $this->_timer->setOptions( array( Streamwide_Engine_Timer_Timeout::OPT_DELAY => $detectionDuration ) );
            $this->_timer->addEventListener(
                Streamwide_Engine_Events_Event::TIMEOUT,
                array(
                    'callback' => array( $this, $callback ),
                    'options' => array( 'autoRemove' => 'before' )
                )
            );
            
            $armed = $this->_timer->arm();
            if ( !$armed ) {
                $this->_timer->flushEventListeners();
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * @return void
     */
    protected function _resetDetectionDurationTimer()
    {
        if ( isset( $this->_timer ) ) {
            $this->_timer->reset();
        }
    }
    
    /**
     * Subscribe to the EVENT signal
     *
     * @see Engine/Streamwide_Engine_Widget#_subscribeToEngineEvents()
     */
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        
        $eventNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_PARAM,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            array( 'name', $this->_eventSignalTypeParameter )
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::EVENT,
            array(
                'callback' => array( $this, 'onEvent' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $eventNotifyFilter
                )
            )
        );
        
        $childNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_msCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::CHILD,
            array(
                'callback' => array( $this, 'onCallLegDeath' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $childNotifyFilter
                )
            )
        );
    }
    
    /**
     * Unsubscribe from the EVENT signal
     *
     * @see Engine/Streamwide_Engine_Widget#_unsubscribeFromEngineEvents()
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $controller = $this->getController();
        
        $controller->removeEventListener(
            Streamwide_Engine_Events_Event::EVENT,
            array( 'callback' => array( $this, 'onEvent' ) )
        );
        
        $controller->removeEventListener(
            Streamwide_Engine_Events_Event::CHILD,
            array( 'callback' => array( $this, 'onCallLegDeath' ) )
        );
    }
    
}
 
/* EOF */