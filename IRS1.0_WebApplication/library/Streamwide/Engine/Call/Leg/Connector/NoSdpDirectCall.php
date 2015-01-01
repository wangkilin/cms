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

class Streamwide_Engine_Call_Leg_Connector_NoSdpDirectCall extends Streamwide_Engine_Call_Leg_Connector
{

    /**
     * Error codes
     */
    const CREATE_SIGNAL_SEND_ERR_CODE = 'NOSDPDIRECTCALL-100';
    const FAIL_SIGNAL_RELAY_ERR_CODE = 'NOSDPDIRECTCALL-101';
    const OK_SIGNAL_RELAY_ERR_CODE = 'NOSDPDIRECTCALL-102';
    const RING_SIGNAL_RELAY_ERR_CODE = 'NOSDPDIRECTCALL-103';
    const PROGRESS_SIGNAL_RELAY_ERR_CODE = 'NOSDPDIRECTCALL-104';
    const SDP_SIGNAL_RELAY_ERR_CODE = 'NOSDPDIRECTCALL-105';
    const PRSDP_SIGNAL_RELAY_ERR_CODE = 'NOSDPDIRECTCALL-106';
    const FAILSDP_SIGNAL_RELAY_ERR_CODE = 'NOSDPDIRECTCALL-107';
    const OKSDP_SIGNAL_RELAY_ERR_CODE = 'NOSDPDIRECTCALL-108';
    const SIP_NOT_CREATED_ERR_CODE = 'NOSDPDIRECTCALL-200';
    const CALL_LEG_DIED_ERR_CODE = 'NOSDPDIRECTCALL-201';
    
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
        Streamwide_Engine_Events_Event::CONNECTED,
        Streamwide_Engine_Events_Event::RINGING,
        Streamwide_Engine_Events_Event::PROGRESS,
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
        self::SDP_SIGNAL_RELAY_ERR_CODE => 'Unable to relay SDP signal to caller SIP call leg',
        self::PRSDP_SIGNAL_RELAY_ERR_CODE => 'Unable to relay PRSDP signal to caller SIP call leg',
        self::FAILSDP_SIGNAL_RELAY_ERR_CODE => 'Unable to relay FAILSDP signal to callee SIP call leg',
        self::OKSDP_SIGNAL_RELAY_ERR_CODE => 'Unable to relay OKSDP signal to callee SIP call leg',
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
            case Streamwide_Engine_Events_Event::RING:
                return $this->_handleRingSignal( $signal );
            case Streamwide_Engine_Events_Event::PROGRESS:
                return $this->_handleProgressSignal( $signal );
            case Streamwide_Engine_Events_Event::SDP:
                return $this->_handleSdpSignal( $signal );
            case Streamwide_Engine_Events_Event::PRSDP:
                return $this->_handlePrsdpSignal( $signal );
            case Streamwide_Engine_Events_Event::OKSDP:
                return $this->_handleOkSdpSignal( $signal );
            case Streamwide_Engine_Events_Event::FAILSDP:
                return $this->_handleFailSdpSignal( $signal );
            case Streamwide_Engine_Events_Event::CHILD:
                return $this->_handleChildSignal( $signal );
        }
        
        return null;
    }
    
    /**
     * Validate the connection parameters
     *
     * @param array $connectionParams
     * @throws UnexpectedValueException
     * @return void
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
     * We have send the CREATE signal and the SW Engine replied with FAIL. We need to
     * relay the FAIL signal to the caller SIP call leg and dispatch an error event
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleFailSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();
        $this->_rightCallLeg->setDead();
        
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
     * After negotiating the SDP, the SW Engine lets us know that the callee
     * SIP call leg has been created. We need to cleanup the listeners list
     * and dispatch a CONNECTED event
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
     * Handle the SDP signal
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleSdpSignal( Streamwide_Engine_Signal $signal )
    {
        if ( false === $signal->relay( $this->_leftCallLeg->getName() ) ) {
            $this->_unsubscribeFromEngineEvents();
            return $this->dispatchErrorEvent( self::SDP_SIGNAL_RELAY_ERR_CODE );
        }
    }
    
    /**
     * Handle the PRSDP signal
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handlePrsdpSignal( Streamwide_Engine_Signal $signal )
    {
        if ( false === $signal->relay( $this->_leftCallLeg->getName() ) ) {
            $this->_unsubscribeFromEngineEvents();
            return $this->dispatchErrorEvent( self::PRSDP_SIGNAL_RELAY_ERR_CODE );
        }
    }
    
    /**
     * Handle the OKSDP signal
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleOkSdpSignal( Streamwide_Engine_Signal $signal )
    {
        if ( false === $signal->relay( $this->_rightCallLeg->getName() ) ) {
            $this->_unsubscribeFromEngineEvents();
            return $this->dispatchErrorEvent( self::OKSDP_SIGNAL_RELAY_ERR_CODE );
        }
    }
    
    /**
     * Handle the FAILSDP signal
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleFailSdpSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();
        
        if ( false === $signal->relay( $this->_rightCallLeg->getName() ) ) {
            return $this->dispatchErrorEvent( self::FAILSDP_SIGNAL_RELAY_ERR_CODE );
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
     * Subscribe to receival of FAIL, OK, RING, PROGRESS, PRSDP, SDP, FAILSDP, OKSDP signals
     * from SW Engine
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
        
        // Start listen to PRSDP signal
        $prsdpNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_rightCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::PRSDP,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $prsdpNotifyFilter
                )
            )
        );
        // End listen to PRSDP signal
        
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
        
        // Start listen to OKSDP signal
        $okSdpNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_leftCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::OKSDP,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $okSdpNotifyFilter
                )
            )
        );
        // End listen to OKSDP signal
        
        // Start listen to FAILSDP signal
        $failSdpNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_leftCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::FAILSDP,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $failSdpNotifyFilter
                )
            )
        );
        // End listen to FAILSDP signal
        
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
        // End listen to CHILD signal
    }
    
    /**
     * Unsubscribe from FAIL, OK, RING, PROGRESS, PRSDP, SDP, FAILSDP, OKSDP signals
     *
     * @return void
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $callback = array( 'callback' => array( $this, 'onSignalReceived' ) );
        
        $events = array(
            Streamwide_Engine_Events_Event::FAIL,
            Streamwide_Engine_Events_Event::OK,
            Streamwide_Engine_Events_Event::RING,
            Streamwide_Engine_Events_Event::PROGRESS,
            Streamwide_Engine_Events_Event::PRSDP,
            Streamwide_Engine_Events_Event::SDP,
            Streamwide_Engine_Events_Event::OKSDP,
            Streamwide_Engine_Events_Event::FAILSDP,
            Streamwide_Engine_Events_Event::CHILD
        );
        
        $controller = $this->getController();
        foreach ( $events as $event ) {
            $controller->removeEventListener( $event, $callback );
        }
    }

}

/* EOF */