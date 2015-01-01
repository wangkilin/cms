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

class Streamwide_Engine_Call_Leg_Connector_NoSdpIvrCall extends Streamwide_Engine_Call_Leg_Connector
{

    /**
     * Error codes
     */
    const CREATE_SIGNAL_SEND_ERR_CODE = 'NOSDPIVRCALL-100';
    const PROGRESS_SIGNAL_SEND_ERR_CODE = 'NOSDPIVRCALL-101';
    const FAIL_SIGNAL_SEND_ERR_CODE = 'NOSDPIVRCALL-102';
    const OK_SIGNAL_RELAY_ERR_CODE = 'NOSDPIVRCALL-103';
    const FAIL_SIGNAL_RELAY_ERR_CODE = 'NOSDPIVRCALL-104';
    const SDP_SIGNAL_RELAY_ERR_CODE = 'NOSDPIVRCALL-105';
    const OKSDP_SIGNAL_RELAY_ERR_CODE = 'NOSDPIVRCALL-106';
    const FAILSDP_SIGNAL_RELAY_ERR_CODE = 'NOSDPIVRCALL-107';
    const MS_NOT_CREATED_ERR_CODE = 'NOSDPIVRCALL-200';
    const CALL_LEG_DIED_ERR_CODE = 'NOSDPIVRCALL-201';
    
    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::ERROR,
        Streamwide_Engine_Events_Event::CONNECTED,
        Streamwide_Engine_Events_Event::EARLY_MEDIA_AVAILABLE
    );
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::CREATE_SIGNAL_SEND_ERR_CODE => 'Unable to send CREATE signal to SW Engine',
        self::PROGRESS_SIGNAL_SEND_ERR_CODE => 'Unable to send PROGRESS signal to SW Engine',
        self::FAIL_SIGNAL_SEND_ERR_CODE => 'Unable to send FAIL signal to SW Engine',
        self::OK_SIGNAL_RELAY_ERR_CODE => 'Unable to relay the OK signal to the SIP call leg',
        self::FAIL_SIGNAL_RELAY_ERR_CODE => 'Unable to relay the FAIL signal to the SIP call leg',
        self::SDP_SIGNAL_RELAY_ERR_CODE => 'Unable to relay the SDP signal to the SIP call leg',
        self::OKSDP_SIGNAL_RELAY_ERR_CODE => 'Unable to relay the OKSDP signal to the MS call leg',
        self::FAILSDP_SIGNAL_RELAY_ERR_CODE => 'Unable to relay the FAILSDP signal to the MS call leg',
        self::MS_NOT_CREATED_ERR_CODE => 'Media server call leg could not be created',
        self::CALL_LEG_DIED_ERR_CODE => 'One of the call legs involved in the connection process has died (CHILD signal received)'
    );
    
    /**
     * Flag to indicate that the relaying of the OK signal received from
     * the MS call leg should not be relayed to the SIP call leg
     *
     * @var boolean
     */
    protected $_blockOkSignalRelaying = false;
    
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
     * Setter for the _leftCallLeg property
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
     * Setter for the _rightCallLeg property
     *
     * @param Streamwide_Engine_Call_Leg_Abstract $rightCallLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setRightCallLeg( Streamwide_Engine_Call_Leg_Abstract $rightCallLeg )
    {
        if ( !$rightCallLeg instanceof Streamwide_Engine_Media_Server_Call_Leg ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an instance of Streamwide_Engine_Media_Server_Call_Leg' );
        }
        if ( $rightCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be a dead MS call leg' );
        }
        parent::setRightCallLeg( $rightCallLeg );
    }
    
    /**
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Connexant#connect()
     */
    public function connect()
    {
        // set CREATE signal parameters
        $params = array();
        $params['name'] = $this->_rightCallLeg->getName();
        $params['proto'] = 'MS';
        if ( isset( $this->_connectionParams['msProtocol'] ) ) {
            $params['proto'] = $this->_connectionParams['msProtocol'];
        }
        if ( isset( $this->_connectionParams['inbanddtmf'] ) ) {
            $params['inbanddtmf'] = $this->_connectionParams['inbanddtmf'];
        }
        if ( isset( $this->_connectionParams['policy'] ) ) {
            $params['policy'] = $this->_connectionParams['policy'];
        }
        $canAddExtraParams = (
            isset( $this->_connectionParams['msExtraParams'] ) &&
            is_array( $this->_connectionParams['msExtraParams'] ) &&
            !empty( $this->_connectionParams['msExtraParams'] )
        );
        if ( $canAddExtraParams ) {
            foreach ( $this->_connectionParams['msExtraParams'] as $parameterName => $parameterValue ) {
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
     * Raise the _blockOkSignalRelaying flag
     *
     * @return void
     */
    public function blockOkSignalRelaying()
    {
        $this->_blockOkSignalRelaying = true;
    }
    
    /**
     * Lower the _blockOkSignalRelaying flag
     *
     * @return void
     */
    public function unblockOkSignalRelaying()
    {
        $this->_blockOkSignalRelaying = false;
    }
    
    /**
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Connexant#onSignalReceived()
     */
    public function onSignalReceived( Streamwide_Engine_Events_Event $event )
    {
        $eventType = $event->getEventType();
        $signal = $event->getParam( 'signal' );
        
        // delegate to internal methods to handle the OK and FAIL signals
        switch ( $eventType ) {
            case Streamwide_Engine_Events_Event::OK:
                return $this->_handleOkSignal( $signal );
            case Streamwide_Engine_Events_Event::FAIL:
                return $this->_handleFailSignal( $signal );
            case Streamwide_Engine_Events_Event::CHILD:
                return $this->_handleChildSignal( $signal );
            case Streamwide_Engine_Events_Event::SDP:
                return $this->_handleSdpSignal( $signal );
            case Streamwide_Engine_Events_Event::OKSDP:
                return $this->_handleOkSdpSignal( $signal );
            case Streamwide_Engine_Events_Event::FAILSDP:
                return $this->_handleFailSdpSignal( $signal );
        }
        
        return null;
    }
    
    /**
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Connexant#reset()
     */
    public function reset()
    {
        parent::reset();
        $this->_okSignal = null;
    }
    
    /**
     * We have received the OK signal from the MS call leg, we need to
     * relay it to the SIP call leg, and dispatch the CONNECTED event
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleOkSignal( Streamwide_Engine_Signal $signal )
    {
        // unsubscribe from the OK, FAIL, SDP, OKSDP and FAILSDP signals
        $this->_unsubscribeFromEngineEvents();
        
        // set MS call leg as alive and set the call leg params
        $params = $signal->getParams();
        $this->_rightCallLeg->setAlive();
        $this->_rightCallLeg->okSent();
        $this->_rightCallLeg->setParams( $params );
        
        // If the _blockOkSignalRelaying flag has been raised
        // exit the callback without relaying the OK signal
        if ( $this->_blockOkSignalRelaying ) {
            return null;
        }
        
        // relay the OK signal to the SIP call leg
        if ( false === $signal->relay( $this->_leftCallLeg->getName() ) ) {
            return $this->dispatchErrorEvent( self::OK_SIGNAL_RELAY_ERR_CODE );
        }
        
        // mark the SIP call leg as having received the OK signal
        $this->_leftCallLeg->okReceived();
        
        // dispatch the CONNECTED event
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::CONNECTED );
        $event->setParam( 'signal', $signal );
        return $this->dispatchEvent( $event );
    }
    
    /**
     * We have received the FAIL signal from the MS call leg, we need to
     * relay it to the SIP call leg and dispatch an error event
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleFailSignal( Streamwide_Engine_Signal $signal )
    {
        // unsubscribe from the OK, FAIL, SDP, OKSDP and FAILSDP signals
        $this->_unsubscribeFromEngineEvents();
        
        if ( false === $signal->relay( $this->_leftCallLeg->getName() ) ) {
            return $this->dispatchErrorEvent( self::FAIL_SIGNAL_RELAY_ERR_CODE );
        }
        
        $params = $signal->getParams();
        $failureCode = isset( $params['code'] ) ? $params['code'] : null;
        return $this->dispatchErrorEvent(
            self::MS_NOT_CREATED_ERR_CODE,
            array(
                'failureCode' => $failureCode,
                'signal' => $signal
            )
        );
    }
    
    /**
     * We have received CHILD signal from the MS call leg, we need to send
     * FAIL to the SIP call leg and dispatch an error event
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleChildSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();
        
        $remote = $signal->getRemote();
        
        if ( $remote === $this->_leftCallLeg->getName() ) {
            if ( $this->_leftCallLeg->isAlive() ) {
                $this->_leftCallLeg->setDead();
            }
            
            return $this->dispatchErrorEvent(
                self::CALL_LEG_DIED_ERR_CODE,
                array( 'callLeg' => $this->_leftCallLeg )
            );
        }
        
        if ( $remote === $this->_rightCallLeg->getName() ) {
            $failSignal = Streamwide_Engine_Signal::factory( Streamwide_Engine_Signal::FAIL, $this->_leftCallLeg->getName() );
            if ( false === $failSignal->send() ) {
                return $this->dispatchErrorEvent( self::FAIL_SIGNAL_SEND_ERR_CODE );
            }
            
            if ( $this->_rightCallLeg->isAlive() ) {
                $this->_rightCallLeg->setDead();
            }
            
            return $this->dispatchErrorEvent(
                self::CALL_LEG_DIED_ERR_CODE,
                array( 'callLeg' => $this->_rightCallLeg )
            );
        }
    }
    
    /**
     * We have received the SDP signal from the MS call leg, we need to relay it
     * to the SIP call leg
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleSdpSignal( Streamwide_Engine_Signal $signal )
    {
        if ( false === $signal->relay( $this->_leftCallLeg->getName() ) ) {
            $this->_unsubscribeFromEngineEvents();
            $this->dispatchErrorEvent( self::SDP_SIGNAL_RELAY_ERR_CODE );
        }
    }
    
    /**
     * We have received the OKSDP signal from the SIP call leg we need to
     * relay it to the MS call leg
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleOkSdpSignal( Streamwide_Engine_Signal $signal )
    {
        if ( false === $signal->relay( $this->_rightCallLeg->getName() ) ) {
            $this->_unsubscribeFromEngineEvents();
            $this->dispatchErrorEvent( self::OKSDP_SIGNAL_RELAY_ERR_CODE );
        }
    }
    
    /**
     * We have received the FAILSDP signal from the SIP call leg we need to
     * relay it to the MS call leg and dispatch an error event
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
            self::MS_NOT_CREATED_ERR_CODE,
            array(
                'failureCode' => $failureCode,
                'signal' => $signal
            )
        );
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#_subscribeToEngineEvents()
     */
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        
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
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#_unsubscribeFromEngineEvents()
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $callback = array( 'callback' => array( $this, 'onSignalReceived' ) );
        
        $events = array(
            Streamwide_Engine_Events_Event::OK,
            Streamwide_Engine_Events_Event::FAIL,
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