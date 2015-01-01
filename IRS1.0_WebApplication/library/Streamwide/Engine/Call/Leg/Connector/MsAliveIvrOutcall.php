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
 * A connector widget that creates a SIP call leg and links it with an alive media
 * server call leg
 */
class Streamwide_Engine_Call_Leg_Connector_MsAliveIvrOutcall extends Streamwide_Engine_Call_Leg_Connector {
    
    /**
     * Error codes
     */
    const MOVED_SIGNAL_SEND_ERR_CODE = 'MSALIVEIVROUTCALL-100';
    const CREATE_SIGNAL_SEND_ERR_CODE = 'MSALIVEIVROUTCALL-101';
    const OKSDP_SIGNAL_SEND_ERR_CODE = 'MSALIVEIVROUTCALL-102';
    const FAILSDP_SIGNAL_SEND_ERR_CODE = 'MSALIVEIVROUTCALL-103';
    const MS_NOT_UPDATED_ERR_CODE = 'MSALIVEIVROUTCALL-200';
    const SIP_NOT_CREATED_ERR_CODE = 'MSALIVEIVROUTCALL-201';
    const CALL_LEG_DIED_ERR_CODE = 'MSALIVEIVROUTCALL-202';
    
    /**
     * A reference to a MOVED signal (can be received from SIP call leg
     * before we receive OK from media server)
     *
     * @var Streamwide_Engine_Signal
     */
    protected $_movedSignal;
    
    /**
     * Whether or not to trigger an ERROR event if SIP call leg send
     * a FAIL signal
     *
     * @var boolean
     */
    protected $_triggerErrorEventOnRemoteSipFailure = true;
    
    /**
     * @var boolean
     */
    protected $_sipCallLegCreationFailed = false;
    
    /**
     * The error code present in the FAIL signal
     *
     * @var string
     */
    protected $_sipCallLegCreationFailureCode;
    
    
    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::RINGING,
        Streamwide_Engine_Events_Event::PROGRESS,
        Streamwide_Engine_Events_Event::CONNECTED,
        Streamwide_Engine_Events_Event::ERROR
    );
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::MOVED_SIGNAL_SEND_ERR_CODE => 'Unable to send MOVED signal to SW Engine',
        self::CREATE_SIGNAL_SEND_ERR_CODE => 'Unable to send CREATE signal to SW Engine',
        self::OKSDP_SIGNAL_SEND_ERR_CODE => 'Unable to send OKSDP signal to SW Engine',
        self::FAILSDP_SIGNAL_SEND_ERR_CODE => 'Unable to send FAILSDP signal to SW Engine',
        self::MS_NOT_UPDATED_ERR_CODE => 'Media server call leg could not be updated',
        self::SIP_NOT_CREATED_ERR_CODE => 'SIP call leg could not be created',
        self::CALL_LEG_DIED_ERR_CODE => 'One of the call legs involved in the connection process has died (CHILD signal received)'
    );
    
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_type = self::CONNECTOR_SIPMS;
    }
    
    /**
     * Destructor
     */
    public function destroy()
    {
        if ( isset( $this->_movedSignal ) ) {
            unset( $this->_movedSignal );
        }
        
        parent::destroy();
    }
    
    /**
     * Set the left call leg
     *
     * @param Streamwide_Engine_Call_Leg_Abstract $leftCallLeg
     * @return void
     */
    public function setLeftCallLeg( Streamwide_Engine_Call_Leg_Abstract $leftCallLeg )
    {
        if ( !$leftCallLeg instanceof Streamwide_Engine_Sip_Call_Leg ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an instance of Streamwide_Engine_Sip_Call_Leg' );
        }
        if ( $leftCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be a dead SIP call leg' );
        }
        parent::setLeftCallLeg( $leftCallLeg );
    }
    
    /**
     * Set the right call leg
     *
     * @param Streamwide_Engine_Call_Leg_Abstract $rightCallLeg
     * @return void
     */
    public function setRightCallLeg( Streamwide_Engine_Call_Leg_Abstract $rightCallLeg )
    {
        if ( !$rightCallLeg instanceof Streamwide_Engine_Media_Server_Call_Leg ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an instance of Streamwide_Engine_Media_Server_Call_Leg' );
        }
        if ( !$rightCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive MS call leg' );
        }
        parent::setRightCallLeg( $rightCallLeg );
    }
    
    /**
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Connector#connect()
     */
    public function connect()
    {
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::MOVED,
            $this->_rightCallLeg->getName()
        );
        
        if ( false === $signal->send() ) {
            $this->dispatchErrorEvent( self::MOVED_SIGNAL_SEND_ERR_CODE );
            return false;
        }
        
        $this->_subscribeToEngineEvents();
        return true;
    }
    
    /**
     * Attempt to perform the connection again.
     *
     * @param $options array|null
     * @return void
     */
    public function retryConnect( Array $options = null ) {
        // remove engine event listeners
        $this->_unsubscribeFromEngineEvents();
        
        $this->_leftCallLeg->generateName();
        
        return $this->connect();
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#reset()
     */
    public function reset()
    {
        parent::reset();
        $this->_movedSignal = null;
        $this->_sipCallLegCreationFailed = false;
        $this->_sipCallLegCreationFailureCode = null;
    }
    
    /**
     * Did we received a moved during the connection process?
     *
     * @return boolean
     */
    public function hasReceivedMoved()
    {
        return (
            $this->_movedSignal instanceof Streamwide_Engine_Signal
            && $this->_movedSignal->getName() === Streamwide_Engine_Signal::MOVED
        );
    }
    
    /**
     * Retrieve the MOVED signal that we received during the connection process
     *
     * @return Streamwide_Engine_Signal|null
     */
    public function getMovedSignal()
    {
        return $this->_movedSignal;
    }
    
    /**
     * Raise/lower the flag that lets us know if we should
     * dispatch an ERROR event if remote SIP call leg sends
     * us a FAIL. Typically you won't need this functionality.
     * It is here because it's used by the MultiOutgoingIps decorator
     *
     * @param boolean $bool
     * @return void
     */
    public function triggerErrorEventOnRemoteSipFailure( $bool )
    {
        $this->_triggerErrorEventOnRemoteSipFailure = (bool)$bool;
    }
    
    /**
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Connexant#onSignalReceived()
     */
    public function onSignalReceived( Streamwide_Engine_Events_Event $event )
    {
        $eventType = $event->getEventType();
        $signal = $event->getParam( 'signal' );
        
        switch ( $eventType ) {
            case Streamwide_Engine_Events_Event::SDP:
                return $this->_handleSdpSignal( $signal );
            case Streamwide_Engine_Events_Event::FAIL:
                return $this->_handleFailSignal( $signal );
            case Streamwide_Engine_Events_Event::RING:
                return $this->_handleRingSignal( $signal );
            case Streamwide_Engine_Events_Event::PROGRESS:
                return $this->_handleProgressSignal( $signal );
            case Streamwide_Engine_Events_Event::MOVED:
                return $this->_handleMovedSignal( $signal );
            case Streamwide_Engine_Events_Event::OK:
                return $this->_handleOkSignal( $signal );
            case Streamwide_Engine_Events_Event::OKMOVED:
                return $this->_handleOkMovedSignal( $signal );
            case Streamwide_Engine_Events_Event::FAILMOVED:
                return $this->_handleFailMovedSignal( $signal );
            case Streamwide_Engine_Events_Event::CHILD:
                return $this->_handleChildSignal( $signal );
        }
        
        return null;
    }
    
    /**
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Connector#_validateConnectionParams($connectionParams)
     */
    protected function _validateConnectionParams( Array $connectionParams )
    {
        if ( !array_key_exists( 'sourceNumber', $connectionParams ) ) {
            throw new UnexpectedValueException( 'Required "sourceNumber" parameter not provided' );
        }
        if ( empty( $connectionParams['sourceNumber'] ) ) {
            throw new UnexpectedValueException( 'Empty source number detected' );
        }

        if ( !array_key_exists( 'destinationNumber', $connectionParams ) ) {
            throw new UnexpectedValueException( 'Required "destinationNumber" parameter not provided' );
        }
        if ( empty( $connectionParams['destinationNumber'] ) ) {
            throw new UnexpectedValueException( 'Empty destination number detected' );
        }
        
        if ( !array_key_exists( 'ip', $connectionParams ) ) {
            throw new UnexpectedValueException( 'Required "ip" parameter not provided' );
        }
        if ( empty( $connectionParams['ip'] ) ) {
            throw new UnexpectedValueException( 'Empty IP detected' );
        }
    }
    
    /**
     * The media server call leg answered with SDP to MOVED
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleSdpSignal( Streamwide_Engine_Signal $signal )
    {
        $params = $signal->getParams();
        $sdp = $params['sdp'];
        
        $params = array();
        $params['name'] = $this->_leftCallLeg->getName();
        $params['sdp'] = $sdp;
        $params['proto'] = 'SIP';
        if ( isset( $this->_connectionParams['outgoingProtocol'] ) ) {
            $params['proto'] = $this->_connectionParams['outgoingProtocol'];
        }
        $params['srcnum'] = $this->_connectionParams['sourceNumber'];
        $params['destnum'] = $this->_connectionParams['destinationNumber'];
        $params['ip'] = $this->_connectionParams['ip'];
        if ( isset( $this->_connectionParams['uri'] ) ) {
            $params['uri'] = $this->_connectionParams['uri'];
        }
        $canAddExtraParams = (
            isset( $this->_connectionParams['sipExtraParams'] ) &&
            is_array( $this->_connectionParams['sipExtraParams'] ) &&
            !empty( $this->_connectionParams['sipExtraParams'] )
        );
        if ( $canAddExtraParams ) {
            foreach ( $this->_connectionParams['sipExtraParams'] as $parameterName => $parameterValue ) {
                $params[$parameterName] = $parameterValue;
            }
        }
        
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::CREATE,
            $this->_leftCallLeg->getName(),
            $params
        );
        
        if ( false === $signal->send() ) {
            $this->_unsubscribeFromEngineEvents();
            return $this->dispatchErrorEvent( self::CREATE_SIGNAL_SEND_ERR_CODE );
        }
    }
    
    protected function _handleFailSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_sipCallLegCreationFailed = true;
        
        $this->_leftCallLeg->setDead();
        
        $params = $signal->getParams();
        $this->_sipCallLegCreationFailureCode = isset( $params['code'] ) ? $params['code'] : null;
        
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::FAILSDP,
            $this->_rightCallLeg->getName()
        );

        if ( false === $signal->send() ) {
            $this->_unsubscribeFromEngineEvents();
            $this->dispatchErrorEvent( self::FAILSDP_SIGNAL_SEND_ERR_CODE );
        }
    }
    
    protected function _handleRingSignal( Streamwide_Engine_Signal $signal )
    {
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::RINGING );
        $event->setParam( 'signal', $signal );
        return $this->dispatchEvent( $event );
    }
    
    protected function _handleProgressSignal( Streamwide_Engine_Signal $signal )
    {
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::PROGRESS );
        $event->setParam( 'signal', $signal );
        return $this->dispatchEvent( $event );
    }
    
    protected function _handleMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_movedSignal = $signal;
    }
    
    protected function _handleOkSignal( Streamwide_Engine_Signal $signal )
    {
        $params = $signal->getParams();
        $this->_leftCallLeg->setAlive();
        $this->_leftCallLeg->okSent();
        $this->_leftCallLeg->setParams( $params );
        
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::OKSDP,
            $this->_rightCallLeg->getName(),
            array( 'sdp' => $params['sdp'] )
        );
        
        if ( false === $signal->send() ) {
            $this->_unsubscribeFromEngineEvents();
            return $this->dispatchErrorEvent( self::OKSDP_SIGNAL_SEND_ERR_CODE );
        }
    }
    
    protected function _handleOkMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();
        
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::CONNECTED );
        $event->setParam( 'signal', $signal );
        if ( null !== $this->_movedSignal ) {
            $event->setParam( 'moved', $this->_movedSignal );
        }
        
        return $this->dispatchEvent( $event );
    }
    
    protected function _handleFailMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();
        
        if ( $this->_sipCallLegCreationFailed ) {
            if ( !$this->_triggerErrorEventOnRemoteSipFailure ) {
                return;
            }
            
            $errorCode = self::SIP_NOT_CREATED_ERR_CODE;
            $failureCode = $this->_sipCallLegCreationFailureCode;
        }
        else {
            $errorCode = self::MS_NOT_UPDATED_ERR_CODE;
            
            $params = $signal->getParams();
            $failureCode = isset( $params['code'] ) ? $params['code'] : null;
            
            $killSignal = Streamwide_Engine_Signal::factory(
                Streamwide_Engine_Signal::KILL,
                $this->_leftCallLeg->getName()
            );
            $killSignal->send();
        }
        
        $this->dispatchErrorEvent(
            $errorCode,
            array(
                'failureCode' => $failureCode,
                'signal' => $signal
            )
        );
    }
    
    protected function _handleChildSignal( Streamwide_Engine_Signal $signal )
    {
        return parent::_handleChildSignal( $signal, self::CALL_LEG_DIED_ERR_CODE );
    }
    
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        
        // Start listen to SDP signal
        $sdpNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_rightCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::SDP,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $sdpNotifyFilter
                )
            )
        );
        // End listen to SDP signal
        
        // Start listen to FAIL signal
        $failNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_leftCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::FAIL,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $failNotifyFilter
                )
            )
        );
        // End listen to FAIL signal
        
        // Start listen to RING signal
        $ringNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_leftCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::RING,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array( 'notifyFilter' => $ringNotifyFilter )
            )
        );
        // End listen to RING signal
        
        // Start listen to PROGRESS signal
        $progressNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_leftCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::PROGRESS,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array( 'notifyFilter' => $progressNotifyFilter )
            )
        );
        // End listen to PROGRESS signal
        
        // Start listen to MOVED signal
        $movedNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_leftCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::MOVED,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $movedNotifyFilter
                )
            )
        );
        // End listen to MOVED signal
        
        // Start listen to OK signal
        $okNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_leftCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::OK,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $okNotifyFilter
                )
            )
        );
        // End listen to OK signal
        
        // Start listen to OKMOVED signal
        $okMovedNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_rightCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::OKMOVED,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $okMovedNotifyFilter
                )
            )
        );
        // End listen to OKMOVED signal
        
        // Start listen to FAILMOVED signal
        $failMovedNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_rightCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::FAILMOVED,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $failMovedNotifyFilter
                )
            )
        );
        // End listen to FAILMOVED signal
        
        // Start listen to CHILD signal
        $childNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_IN_ARRAY,
            array( array( $this->_leftCallLeg->getName(), $this->_rightCallLeg->getName() ) )
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::CHILD,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $childNotifyFilter
                )
            )
        );
        // Start listen to CHILD signal
    }
    
    /**
     * Unsubscribe from the receival of FAIL, SDP, RING, PROGRESS, OK, OKMOVED and FAILMOVED signal from SW Engine
     *
     * @return void
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $callback = array( 'callback' => array( $this, 'onSignalReceived' ) );
        
        $events = array(
            Streamwide_Engine_Events_Event::FAIL,
            Streamwide_Engine_Events_Event::SDP,
            Streamwide_Engine_Events_Event::RING,
            Streamwide_Engine_Events_Event::PROGRESS,
            Streamwide_Engine_Events_Event::MOVED,
            Streamwide_Engine_Events_Event::OK,
            Streamwide_Engine_Events_Event::OKMOVED,
            Streamwide_Engine_Events_Event::FAILMOVED,
            Streamwide_Engine_Events_Event::CHILD
        );
        
        $controller = $this->getController();
        foreach ( $events as $event ) {
            $controller->removeEventListener( $event, $callback );
        }
    }
    
}
 
/* EOF */