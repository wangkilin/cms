<?php
/**
 *
 * $Rev: 2135 $
 * $LastChangedDate: 2009-11-23 17:53:15 +0800 (Mon, 23 Nov 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Call_Leg_Connector
 * @version 1.0
 *
 */

class Streamwide_Engine_Call_Leg_Connector_SdpDirectCall extends Streamwide_Engine_Call_Leg_Connector
{

    /**
     * Error codes
     */
    const CREATE_SIGNAL_SEND_ERR_CODE = 'SDPDIRECTCALL-100';
    const FAIL_SIGNAL_RELAY_ERR_CODE = 'SDPDIRECTCALL-101';
    const OK_SIGNAL_RELAY_ERR_CODE = 'SDPDIRECTCALL-102';
    const RING_SIGNAL_RELAY_ERR_CODE = 'SDPDIRECTCALL-103';
    const PROGRESS_SIGNAL_RELAY_ERR_CODE = 'SDPDIRECTCALL-104';
    const PROK_SIGNAL_RELAY_ERR_CODE = 'SDPDIRECTCALL-105';
    const SIP_NOT_CREATED_ERR_CODE = 'SDPDIRECTCALL-200';
    const CALL_LEG_DIED_ERR_CODE = 'SDPDIRECTCALL-201';
    
    /**
     * Whether or not to trigger an ERROR event if SIP call leg send
     * a FAIL signal
     *
     * @var boolean
     */
    protected $_triggerErrorEventOnRemoteSipFailure = true;
    
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
        self::CREATE_SIGNAL_SEND_ERR_CODE => 'Unable to send CREATE signal to SW Engine',
        self::FAIL_SIGNAL_RELAY_ERR_CODE => 'Unable to relay FAIL signal to caller SIP call leg',
        self::OK_SIGNAL_RELAY_ERR_CODE => 'Unable to relay OK signal to caller SIP call leg',
        self::RING_SIGNAL_RELAY_ERR_CODE => 'Unable to relay RING signal to caller SIP call leg',
        self::PROGRESS_SIGNAL_RELAY_ERR_CODE => 'Unable to relay PROGRESS signal to caller SIP call leg',
        self::PROK_SIGNAL_RELAY_ERR_CODE => 'Unable to relay PROK signal to caller SIP call leg',
        self::SIP_NOT_CREATED_ERR_CODE => 'Callee SIP call leg could not be created',
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
        $this->_type = self::CONNECTOR_SIPSIP;
    }

    /**
     * Set the left call leg
     *
     * @param Streamwide_Engine_Call_Leg_Abstract $leftCallLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setLeftCallLeg( Streamwide_Engine_Call_Leg_Abstract $leftCallLeg )
    {
        if ( !$leftCallLeg instanceof Streamwide_Engine_Sip_Call_Leg ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an instance of Streamwide_Engine_Sip_Call_Leg' );
        }
        if ( !$leftCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive SIP call leg' );
        }
        if ( $leftCallLeg->hasSentOrReceivedOk() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive SIP call leg that has not received the OK signal' );
        }
        parent::setLeftCallLeg( $leftCallLeg );
    }
    
    /**
     * Set the right call leg
     *
     * @param Streamwide_Engine_Call_Leg_Abstract $rightCallLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setRightCallLeg( Streamwide_Engine_Call_Leg_Abstract $rightCallLeg )
    {
        if ( !$rightCallLeg instanceof Streamwide_Engine_Sip_Call_Leg ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an instance of Streamwide_Engine_Sip_Call_Leg' );
        }
        if ( $rightCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be a dead SIP call leg' );
        }
        parent::setRightCallLeg( $rightCallLeg );
    }
    
    /**
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Connexant#connect()
     */
    public function connect()
    {
        $params = array();
        $params['name'] = $this->_rightCallLeg->getName();
        $params['proto'] = 'SIP';
        if ( isset( $this->_connectionParams['outgoingProtocol'] ) ) {
            $params['proto'] = $this->_connectionParams['outgoingProtocol'];
        }
        $params['sdp'] = $this->_connectionParams['sdp'];
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
            $this->_rightCallLeg->getName(),
            $params
        );
        
        if ( false === $signal->send() ) {
            $this->dispatchErrorEvent( self::CREATE_SIGNAL_SEND_ERR_CODE );
            return false;
        }
        
        $this->_subscribeToEngineEvents();
        return true;
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
     * Handle the receival of a signal from SW Engine
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onSignalReceived( Streamwide_Engine_Events_Event $event )
    {
        $eventType = $event->getEventType();
        $signal = $event->getParam( 'signal' );
        
        switch ( $eventType ) {
            case Streamwide_Engine_Events_Event::FAIL:
                return $this->_handleFailSignal( $signal );
            case Streamwide_Engine_Events_Event::OK:
                return $this->_handleOkSignal( $signal );
            case Streamwide_Engine_Events_Event::PROK:
                return $this->_handleProkSignal( $signal );
            case Streamwide_Engine_Events_Event::RING:
                return $this->_handleRingSignal( $signal );
            case Streamwide_Engine_Events_Event::PROGRESS:
                return $this->_handleProgressSignal( $signal );
            case Streamwide_Engine_Events_Event::CHILD:
                return $this->_handleChildSignal( $signal );
        }
        
        return null;
    }
    
    /**
     * Validate connection parameters
     *
     * @param array $connectionParams
     * @return void
     * @throws UnexpectedValueException
     */
    protected function _validateConnectionParams( Array $connectionParams )
    {
        // check the sdp parameter
        if ( !array_key_exists( 'sdp', $connectionParams ) ) {
            throw new UnexpectedValueException( 'Required "sdp" parameter not provided' );
        }
        if ( empty( $connectionParams['sdp'] ) ) {
            throw new UnexpectedValueException( 'Empty SDP detected' );
        }
        // check the source number
        if ( !array_key_exists( 'sourceNumber', $connectionParams ) ) {
            throw new UnexpectedValueException( 'Required "sourceNumber" parameter not provided' );
        }
        if ( empty( $connectionParams['sourceNumber'] ) ) {
            throw new UnexpectedValueException( 'Empty source number detected' );
        }
        // check the destination number
        if ( !array_key_exists( 'destinationNumber', $connectionParams ) ) {
            throw new UnexpectedValueException( 'Required "destinationNumber" parameter not provided' );
        }
        if ( empty( $connectionParams['destinationNumber'] ) ) {
            throw new UnexpectedValueException( 'Empty destination number detected' );
        }
        // check the ip
        if ( !array_key_exists( 'ip', $connectionParams ) ) {
            throw new UnexpectedValueException( 'Required "ip" parameter not provided' );
        }
        if ( empty( $connectionParams['ip'] ) ) {
            throw new UnexpectedValueException( 'Empty IP detected' );
        }
    }
    
    /**
     * Handle the FAIL signal
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleFailSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();
        
        if ( false === $signal->relay( $this->_leftCallLeg->getName() ) ) {
            return $this->dispatchErrorEvent( self::FAIL_SIGNAL_RELAY_ERR_CODE );
        }
        
        if ( !$this->_triggerErrorEventOnRemoteSipFailure ) {
            return;
        }
        
        $params = $signal->getParams();
        $failureCode = isset( $params['code'] ) ? $params['code'] : null;
        return $this->dispatchErrorEvent(
            self::SIP_NOT_CREATED_ERR_CODE,
            array(
                'failureCode' => $failureCode,
                'signal' => $signal
            )
        );
    }
    
    /**
     * Handle the RING signal
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleRingSignal( Streamwide_Engine_Signal $signal )
    {
        if ( false === $signal->relay( $this->_leftCallLeg->getName() ) ) {
            $this->_unsubscribeFromEngineEvents();
            return $this->dispatchErrorEvent( self::RING_SIGNAL_RELAY_ERR_CODE );
        }
        
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::RINGING );
        $event->setParam( 'signal', $signal );
        return $this->dispatchEvent( $event );
    }
    
    /**
     * Handle the PROGRESS signal
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleProgressSignal( Streamwide_Engine_Signal $signal )
    {
        if ( false === $signal->relay( $this->_leftCallLeg->getName() ) ) {
            $this->_unsubscribeFromEngineEvents();
            return $this->dispatchErrorEvent( self::PROGRESS_SIGNAL_RELAY_ERR_CODE );
        }
        
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::PROGRESS );
        $event->setParam( 'signal', $signal );
        return $this->dispatchEvent( $event );
    }
    
    /**
     * Handle the OK signal
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleOkSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();

        $this->_rightCallLeg->setAlive();
        $this->_rightCallLeg->okSent();
        $this->_rightCallLeg->setParams( $signal->getParams() );
        
        if ( false === $signal->relay( $this->_leftCallLeg->getName() ) ) {
            return $this->dispatchErrorEvent( self::OK_SIGNAL_RELAY_ERR_CODE );
        }
        
        $this->_leftCallLeg->okReceived();
        
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::CONNECTED );
        $event->setParam( 'signal', $signal );
        return $this->dispatchEvent( $event );
    }
    
    /**
     * Handle the PROK signal
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleProkSignal( Streamwide_Engine_Signal $signal )
    {
        if ( false === $signal->relay( $this->_leftCallLeg->getName() ) ) {
            $this->_unsubscribeFromEngineEvents();
            return $this->dispatchErrorEvent( self::PROK_SIGNAL_RELAY_ERR_CODE );
        }
    }
    
    /**
     * Handle the CHILD signal
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleChildSignal( Streamwide_Engine_Signal $signal )
    {
        return parent::_handleChildSignal( $signal, self::CALL_LEG_DIED_ERR_CODE );
    }
    
    /**
     * Subscribe to receival of signals FAIL, OK, PROK,  RING and PROGRESS from SW Engine
     *
     * @return void
     */
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        
        // Start listen to FAIL signal
        $failNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_rightCallLeg->getName()
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
        
        // Start listen to OK signal
        $okNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_rightCallLeg->getName()
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
        
        // Start listen to PROK signal
        $prokNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_rightCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::PROK,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $prokNotifyFilter
                )
            )
        );
        // End listen to PROK signal
        
        // Start listen to RING signal
        $ringNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_rightCallLeg->getName()
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
            $this->_rightCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::PROGRESS,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array( 'notifyFilter' => $progressNotifyFilter )
            )
        );
        // End listen to PROGRESS signal
        
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
                'options' => array( 'notifyFilter' => $childNotifyFilter )
            )
        );
        // End listen to CHILD signal
    }
    
    /**
     * Remove all listeners
     *
     * @return void
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $callback = array( 'callback' => array( $this, 'onSignalReceived' ) );
        
        $events = array(
            Streamwide_Engine_Events_Event::FAIL,
            Streamwide_Engine_Events_Event::OK,
            Streamwide_Engine_Events_Event::PROK,
            Streamwide_Engine_Events_Event::RING,
            Streamwide_Engine_Events_Event::PROGRESS,
            Streamwide_Engine_Events_Event::CHILD,
        );
        
        $controller = $this->getController();
        foreach ( $events as $event ) {
            $controller->removeEventListener( $event, $callback );
        }
    }
    
}

/* EOF */