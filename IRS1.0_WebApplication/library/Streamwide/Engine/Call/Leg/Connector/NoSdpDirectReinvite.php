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

class Streamwide_Engine_Call_Leg_Connector_NoSdpDirectReinvite extends Streamwide_Engine_Call_Leg_Connector
{
    
    /**
     * Error codes
     */
    const CREATE_SIGNAL_SEND_ERR_CODE = 'NOSDPDIRECTREINVITE-100';
    const FAILMOVED_SIGNAL_SEND_ERR_CODE = 'NOSDPDIRECTREINVITE-101';
    const MOVED_SIGNAL_SEND_ERR_CODE = 'NOSDPDIRECTREINVITE-102';
    const OKSDP_SIGNAL_SEND_ERR_CODE = 'NOSDPDIRECTREINVITE-103';
    const RING_SIGNAL_RELAY_ERR_CODE = 'NOSDPDIRECTREINVITE-104';
    const PROGRESS_SIGNAL_RELAY_ERR_CODE = 'NOSDPDIRECTREINVITE-105';
    const PRSDP_SIGNAL_RELAY_ERR_CODE = 'NOSDPDIRECTREINVITE-106';
    const SIP_NOT_CREATED_ERR_CODE = 'NOSDPDIRECTREINVITE-200';
    const SIP_UPDATE_FAILED_ERR_CODE = 'NOSDPDIRECTREINVITE-201';
    const CALL_LEG_DIED_ERR_CODE = 'NOSDPDIRECTREINVITE-202';
    
    /**
     * A reference to a MOVED signal (can be received from left SIP call leg
     * before we receive OKMOVED from right SIP call leg)
     *
     * @var Streamwide_Engine_Signal
     */
    protected $_movedSignal;
    
    /**
     * Whether we have received OKMOVED or not
     *
     * @var boolean
     */
    protected $_okMovedReceived = false;
    
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
        self::FAILMOVED_SIGNAL_SEND_ERR_CODE => 'Unable to send FAILMOVED signal to SW Engine',
        self::MOVED_SIGNAL_SEND_ERR_CODE => 'Unable to send MOVED signal to SW Engine',
        self::OKSDP_SIGNAL_SEND_ERR_CODE => 'Unable to send OKSDP signal to SW Engine',
        self::RING_SIGNAL_RELAY_ERR_CODE => 'Unable to relay the RING signal to the caller SIP call leg',
        self::PROGRESS_SIGNAL_RELAY_ERR_CODE => 'Unable to relay the PROGRESS signal to the caller SIP call leg',
        self::PRSDP_SIGNAL_RELAY_ERR_CODE => 'Unable to relay the PRSDP signal to the caller SIP call leg',
        self::SIP_NOT_CREATED_ERR_CODE => 'SIP call leg could not be created',
        self::SIP_UPDATE_FAILED_ERR_CODE => 'SIP call leg could not be updated',
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
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Connector#setLeftCallLeg($leftCallLeg)
     */
    public function setLeftCallLeg( Streamwide_Engine_Call_Leg_Abstract $leftCallLeg )
    {
        if ( !$leftCallLeg instanceof Streamwide_Engine_Sip_Call_Leg ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an instance of Streamwide_Engine_Sip_Call_Leg' );
        }
        if ( !$leftCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive SIP call leg' );
        }
        if ( !$leftCallLeg->hasSentOrReceivedOk() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive SIP call leg that has received the OK signal' );
        }
        parent::setLeftCallLeg( $leftCallLeg );
    }

    /**
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Connector#setRightCallLeg($rightCallLeg)
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
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Connector#connect()
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
     * @see Engine/Streamwide_Engine_Widget#reset()
     */
    public function reset()
    {
        parent::reset();
        $this->_movedSignal = null;
        $this->_okMovedReceived = false;
        $this->_triggerErrorEventOnRemoteSipFailure = true;
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
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Connector#onSignalReceived($event)
     */
    public function onSignalReceived( Streamwide_Engine_Events_Event $event )
    {
        $eventType = $event->getEventType();
        $signal = $event->getParam( 'signal' );
        
        switch ( $eventType ) {
            case Streamwide_Engine_Events_Event::OK:
                return $this->_handleOkSignal( $signal );
            case Streamwide_Engine_Events_Event::FAIL:
                return $this->_handleFailSignal( $signal );
            case Streamwide_Engine_Events_Event::RING:
                return $this->_handleRingSignal( $signal );
            case Streamwide_Engine_Events_Event::PROGRESS:
                return $this->_handleProgressSignal( $signal );
            case Streamwide_Engine_Events_Event::PRSDP:
                return $this->_handlePrsdpSignal( $signal );
            case Streamwide_Engine_Events_Event::SDP:
                return $this->_handleSdpSignal( $signal );
            case Streamwide_Engine_Events_Event::MOVED:
                return $this->_handleMovedSignal( $signal );
            case Streamwide_Engine_Events_Event::OKMOVED:
                return $this->_handleOkMovedSignal( $signal );
            case Streamwide_Engine_Events_Event::FAILMOVED:
                return $this->_handleFailMovedSignal( $signal );
            case Streamwide_Engine_Events_Event::CHILD:
                return $this->_handleChildSignal( $signal );
        }
    }
    
    /**
     * We received OK from the left SIP call leg. We need to dispatch a CONNECTED event
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleOkSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();
        
        $params = $signal->getParams();
        $this->_rightCallLeg->setAlive();
        $this->_rightCallLeg->okSent();
        $this->_rightCallLeg->setParams( $params );
        
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::CONNECTED );
        $event->setParam( 'signal', $signal );
        if ( null !== $this->_movedSignal ) {
            $event->setParam( 'moved', $this->_movedSignal );
        }
        return $this->dispatchEvent( $event );
    }
    
    /**
     * We received FAIL signal. The right SIP call leg could not be created. We need
     * to dispatch the ERROR event
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleFailSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();
        
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
     * We received PRSDP signal. PRACK is not supported yet in the framework so
     * we just relay it to the caller SIP call leg
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
     * We received SDP signal from the callee SIP call leg. We need to send a
     * MOVED to the right SIP call leg.
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleSdpSignal( Streamwide_Engine_Signal $signal )
    {
        $params = $signal->getParams();
        
        $movedSignal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::MOVED,
            $this->_leftCallLeg->getName(),
            array( 'sdp' => $params['sdp'] )
        );
        
        if ( false === $movedSignal->send() ) {
            $this->_unsubscribeFromEngineEvents();
            return $this->dispatchErrorEvent( self::MOVED_SIGNAL_SEND_ERR_CODE );
        }
    }
    
    /**
     * We received RING signal from the callee SIP call leg. We need to relay it to
     * the caller SIP call leg and dispatch a RINGING event
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
     * We received PROGRESS signal from the callee SIP call leg. We need to relay it to
     * the caller SIP call leg and dispatch a PROGRESS event
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
     * We have received MOVED from the caller SIP call leg. If an OKMOVED was received
     * from the right call leg we store the signal and let it be handled by the client.
     * If an OKMOVED was not received we answer with FAILMOVED
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleMovedSignal( Streamwide_Engine_Signal $signal )
    {
        if ( $this->_okMovedReceived ) {
            $this->_movedSignal = $signal;
        } else {
            $failMovedSignal = Streamwide_Engine_Signal::factory(
                Streamwide_Engine_Signal::FAILMOVED,
                $this->_leftCallLeg->getName(),
                array( 'code' => '491' )
            );
        
            if ( false === $failMovedSignal->send() ) {
                $this->_unsubscribeFromEngineEvents();
                return $this->dispatchErrorEvent( self::FAILMOVED_SIGNAL_SEND_ERR_CODE );
            }
        }
    }
    
    /**
     * We have received OKMOVED from the callee SIP call leg. We need to send
     * OKSDP to caller SIP call leg.
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleOkMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_okMovedReceived = true;
        $params = $signal->getParams();
        
        $okSdpSignal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::OKSDP,
            $this->_rightCallLeg->getName(),
            array( 'sdp' => $params['sdp'] )
        );
        
        if ( false === $okSdpSignal->send() ) {
            $this->_unsubscribeFromEngineEvents();
            return $this->dispatchErrorEvent( self::OKSDP_SIGNAL_SEND_ERR_CODE );
        }
    }
    
    /**
     * We have received FAILMOVED from the callee SIP call leg. We need to dispatch
     * an ERROR event
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleFailMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();
        return $this->dispatchErrorEvent( self::SIP_UPDATE_FAILED_ERR_CODE );
    }
    
    /**
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Connector#_handleChildSignal($signal, $errorCode)
     */
    protected function _handleChildSignal( Streamwide_Engine_Signal $signal )
    {
        return parent::_handleChildSignal( $signal, self::CALL_LEG_DIED_ERR_CODE );
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
     * Subscribe to OK, FAIL, SDP, PRSDP, RING, PROGRESS, MOVED, OKMOVED, FAILMOVED, CHILD
     *
     * @see Engine/Streamwide_Engine_Widget#_subscribeToEngineEvents()
     */
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
        
        // Start listen to OKMOVED signal
        $okMovedNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_leftCallLeg->getName()
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
        
        // Start listen to FAILMOVED signal
        $failMovedNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_leftCallLeg->getName()
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
    }
    
    /*
     * Unsubscribe from OK, FAIL, SDP, PRSDP, RING, PROGRESS, MOVED, OKMOVED, FAILMOVED, CHILD
     *
     * @return void
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $events = array(
            Streamwide_Engine_Events_Event::SDP,
            Streamwide_Engine_Events_Event::FAIL,
            Streamwide_Engine_Events_Event::OK,
            Streamwide_Engine_Events_Event::RING,
            Streamwide_Engine_Events_Event::PROGRESS,
            Streamwide_Engine_Events_Event::PRSDP,
            Streamwide_Engine_Events_Event::CHILD,
            Streamwide_Engine_Events_Event::OKMOVED,
            Streamwide_Engine_Events_Event::MOVED,
            Streamwide_Engine_Events_Event::FAILMOVED
        );
        
        $controller = $this->getController();
        foreach ( $events as $event ) {
            $controller->removeEventListener( $event, array( 'callback' => array( $this, 'onSignalReceived' ) ) );
        }
    }
    
}
 
/* EOF */