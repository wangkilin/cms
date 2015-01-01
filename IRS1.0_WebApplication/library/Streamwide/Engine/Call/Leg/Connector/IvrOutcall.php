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
 * @subpackage Streamwide_Engine_Call_Leg_Connector
 * @version 1.0
 *
 */

class Streamwide_Engine_Call_Leg_Connector_IvrOutcall extends Streamwide_Engine_Call_Leg_Connector
{

    /**
     * Options
     */
    const OPT_PERFORM_MS_NEGOTIATION = 'perform_ms_negotiation';
    
    /**
     * Default values for options
     */
    const PERFORM_MS_NEGOTIATION_DEFAULT = false;
    
    /**
     * Error codes
     */
    const CREATE_SIGNAL_SEND_ERR_CODE = 'IVROUTCALL-100';
    const OKSDP_SIGNAL_SEND_ERR_CODE = 'IVROUTCALL-101';
    const MOVED_SIGNAL_SEND_ERR_CODE = 'IVROUTCALL-102';
    const MS_NOT_CREATED_ERR_CODE = 'IVROUTCALL-200';
    const MS_NOT_UPDATED_ERR_CODE = 'IVROUTCALL-201';
    const SIP_NOT_CREATED_ERR_CODE = 'IVROUTCALL-202';
    const CALL_LEG_DIED_ERR_CODE = 'IVROUTCALL-203';
    
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
     * Is the negotiation with the media server call leg active?
     *
     * @var boolean
     */
    protected $_msNegotiationActive = false;
    
    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::RINGING,
        Streamwide_Engine_Events_Event::PROGRESS,
        Streamwide_Engine_Events_Event::EARLY_MEDIA_NEGOTIATED,
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
        self::OKSDP_SIGNAL_SEND_ERR_CODE => 'Unable to send OKSDP signal to SW Engine',
        self::MOVED_SIGNAL_SEND_ERR_CODE => 'Unable to send MOVED signal to SW Engine',
        self::MS_NOT_CREATED_ERR_CODE => 'MS call leg could not be created',
        self::MS_NOT_UPDATED_ERR_CODE => 'MS call leg could not be updated',
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
        $this->_initDefaultOptions();
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
     * @param array $options
     * @return void
     */
    public function setOptions( Array $options )
    {
        $performMsNegotiation = isset( $options[self::OPT_PERFORM_MS_NEGOTIATION] ) ? $options[self::OPT_PERFORM_MS_NEGOTIATION] : null;
        $this->_treatPerformMsNegotiationOption( $performMsNegotiation );
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
        if ( $rightCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be a dead MS call leg' );
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
        if ( isset( $this->_connectionParams['msExtraParams'] ) && is_array( $this->_connectionParams['msExtraParams'] ) ) {
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
     * Attempt to perform the connection again. Kills the MS call leg
     * in case it is created.
     *
     * @param $options array|null
     * @return void
     */
    public function retryConnect( Array $options = null ) {
        // KILL the MS call leg
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::KILL,
            $this->_rightCallLeg->getName()
        );
        $signal->send();
        
        return parent::retryConnect( $options );
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#reset()
     */
    public function reset()
    {
        parent::reset();
        $this->_movedSignal = null;
        $this->_triggerErrorEventOnRemoteSipFailure = true;
        $this->_msNegotiationActive = false;
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
            case Streamwide_Engine_Events_Event::FAIL:
                return $this->_handleFailSignal( $signal );
            case Streamwide_Engine_Events_Event::SDP:
                return $this->_handleSdpSignal( $signal );
            case Streamwide_Engine_Events_Event::RING:
                return $this->_handleRingSignal( $signal );
            case Streamwide_Engine_Events_Event::PROGRESS:
                return $this->_handleProgressSignal( $signal );
            case Streamwide_Engine_Events_Event::MOVED:
                return $this->_handleMovedSignal( $signal );
            case Streamwide_Engine_Events_Event::OKMOVED:
                return $this->_handleOkMovedSignal( $signal );
            case Streamwide_Engine_Events_Event::FAILMOVED:
                return $this->_handleFailMovedSignal( $signal );
            case Streamwide_Engine_Events_Event::OK:
                return $this->_handleOkSignal( $signal );
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
     * Two CREATE signals are sent by this object to the SW Engine: one to request the creation
     * of a media server call leg and another to request the creation of a sip call leg. Both
     * requests can reply with a FAIL signal. This method handles failure by dispatching error
     * events and removing all previously attached listeners.
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleFailSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();
        $remoteName = $signal->getRemote();
        $params = $signal->getParams();
        
        if ( $remoteName === $this->_rightCallLeg->getName() ) {
            $this->_rightCallLeg->setDead();
            $failureCode = isset( $params['code'] ) ? $params['code'] : null;
            return $this->dispatchErrorEvent(
                self::MS_NOT_CREATED_ERR_CODE,
                array(
                    'failureCode' => $failureCode,
                    'signal' => $signal
                )
            );
        }
        
        if ( $remoteName === $this->_leftCallLeg->getName() ) {
            $this->_leftCallLeg->setDead();
            
            if ( !$this->_triggerErrorEventOnRemoteSipFailure ) {
                return;
            }
            
            $failureCode = isset( $params['code'] ) ? $params['code'] : null;
            return $this->dispatchErrorEvent(
                self::SIP_NOT_CREATED_ERR_CODE,
                array(
                    'failureCode' => $failureCode,
                    'signal' => $signal
                )
            );
        }
    }
    
    /**
     * Because we have sent the CREATE signal to the SW Engine requesting to create a media server call
     * leg WITHOUT sdp the media server call leg has to reply with SDP signal. When we receive the SDP
     * signal from SW Engine we have to send another CREATE to SW Engine requesting to create a sip call
     * leg
     *
     * @param Streamwide_Engine_Signal $signal
     * @return unknown_type
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
        
        $create = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::CREATE,
            $this->_leftCallLeg->getName(),
            $params
        );
        
        if ( false === $create->send() ) {
            $this->_unsubscribeFromEngineEvents();
            return $this->dispatchErrorEvent( self::CREATE_SIGNAL_SEND_ERR_CODE );
        }
    }
    
    /**
     * After sending the CREATE signal to request SW Engine to create a sip call leg
     * we can receive a RING signal. This method fires a RINGING event.
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleRingSignal( Streamwide_Engine_Signal $signal )
    {
        $activateMsNegotiation = $this->_options[self::OPT_PERFORM_MS_NEGOTIATION];
        $params = $signal->getParams();
        
        if ( is_array( $params )
            && array_key_exists( 'sdp', $params )
            && $activateMsNegotiation )
        {
            $okSdp = Streamwide_Engine_Signal::factory(
                Streamwide_Engine_Signal::OKSDP,
                $this->_rightCallLeg->getName(),
                array( 'sdp' => $params['sdp'] )
            );
            if ( false === $okSdp->send() ) {
                $this->_unsubscribeFromEngineEvents();
                return $this->dispatchErrorEvent( self::OKSDP_SIGNAL_SEND_ERR_CODE );
            }
            
            $this->_msNegotiationActive = true;
        } else {
            $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::RINGING );
            $event->setParam( 'signal', $signal );
            return $this->dispatchEvent( $event );
        }
    }
    
    /**
     * After sending the CREATE signal to request SW Engine to create a sip call leg
     * we can receive a PROGRESS signal. This method fires a PROGRESS event.
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleProgressSignal( Streamwide_Engine_Signal $signal )
    {
        $activateMsNegotiation = $this->_options[self::OPT_PERFORM_MS_NEGOTIATION];
        $params = $signal->getParams();
        
        if ( is_array( $params )
            && array_key_exists( 'sdp', $params )
            && $activateMsNegotiation )
        {
            $okSdp = Streamwide_Engine_Signal::factory(
                Streamwide_Engine_Signal::OKSDP,
                $this->_rightCallLeg->getName(),
                array( 'sdp' => $params['sdp'] )
            );
            if ( false === $okSdp->send() ) {
                $this->_unsubscribeFromEngineEvents();
                return $this->dispatchErrorEvent( self::OKSDP_SIGNAL_SEND_ERR_CODE );
            }
            
            $this->_msNegotiationActive = true;
        } else {
            $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::PROGRESS );
            $event->setParam( 'signal', $signal );
            return $this->dispatchEvent( $event );
        }
    }
    
    /**
     * We can receive a MOVED signal from the SIP call leg before we received
     * the OK signal from the MS call leg
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_movedSignal = $signal;
    }
    
    /**
     * We received an OKMOVED signal from the MS call leg (this happens if the
     * MS negotiation has been started), the MS negotiation has completed successfully.
     * We need to dispatch the CONNECTED event
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleOkMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();

        $this->_rightCallLeg->setParams( $signal->getParams() );
        
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::CONNECTED );
        $event->setParam( 'signal', $signal );
        if ( null !== $this->_movedSignal ) {
            $event->setParam( 'moved', $this->_movedSignal );
        }
        return $this->dispatchEvent( $event );
    }
    
    /**
     * We received a FAILMOVED signal from the MS call leg (this happens if the MS
     * negotiation has been started), the MS negotiation failed to complete. We
     * need to dispatch an ERROR event
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleFailMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();

        $params = $signal->getParams();
        
        $failureCode = isset( $params['code'] ) ? $params['code'] : null;
        return $this->dispatchErrorEvent(
            self::MS_NOT_UPDATED_ERR_CODE,
            array(
                'failureCode' => $failureCode,
                'signal' => $signal
            )
        );
    }
    
    /**
     * Because we are sending 2 CREATE signals, we can receive two OK signals as response (if
     * everything is well). On OK received from the SIP call leg we send an OKSDP signal
     * to the MS call leg. On OK received from the MS call leg we dispatch the CONNECTED event
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleOkSignal( Streamwide_Engine_Signal $signal )
    {
        $remoteName = $signal->getRemote();
        $params = $signal->getParams();
        
        if ( $remoteName === $this->_rightCallLeg->getName() ) {
            // The OK came from the media server call leg
            $this->_rightCallLeg->setAlive();
            $this->_rightCallLeg->okSent();
            $this->_rightCallLeg->setParams( $params );
            
            if ( $this->_msNegotiationActive ) {
                if ( $this->_leftCallLeg->hasSentOrReceivedOk() ) {
                    $params = $this->_leftCallLeg->getParams();
                    
                    $moved = Streamwide_Engine_Signal::factory(
                        Streamwide_Engine_Signal::MOVED,
                        $this->_rightCallLeg->getName(),
                        array( 'sdp' => $params['sdp'] )
                    );
                    if ( false === $moved->send() ) {
                        $this->_unsubscribeFromEngineEvents();
                        return $this->dispatchErrorEvent( self::MOVED_SIGNAL_SEND_ERR_CODE );
                    }
                }
                
                $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::EARLY_MEDIA_NEGOTIATED );
                return $this->dispatchEvent( $event );
            } else {
                $this->_unsubscribeFromEngineEvents();
                
                $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::CONNECTED );
                $event->setParam( 'signal', $signal );
                if ( null !== $this->_movedSignal ) {
                    $event->setParam( 'moved', $this->_movedSignal );
                }
                return $this->dispatchEvent( $event );
            }
        }
        
        if ( $remoteName === $this->_leftCallLeg->getName() ) {
            // The OK came from the sip call leg
            $this->_leftCallLeg->setAlive();
            $this->_leftCallLeg->okSent();
            $this->_leftCallLeg->setParams( $params );
            
            if ( $this->_msNegotiationActive ) {
                if ( $this->_rightCallLeg->hasSentOrReceivedOk() ) {
                    $moved = Streamwide_Engine_Signal::factory(
                        Streamwide_Engine_Signal::MOVED,
                        $this->_rightCallLeg->getName(),
                        array( 'sdp' => $params['sdp'] )
                    );
                    if ( false === $moved->send() ) {
                        $this->_unsubscribeFromEngineEvents();
                        return $this->dispatchErrorEvent( self::MOVED_SIGNAL_SEND_ERR_CODE );
                    }
                }
                
                return;
            } else {
                $okSdp = Streamwide_Engine_Signal::factory(
                    Streamwide_Engine_Signal::OKSDP,
                    $this->_rightCallLeg->getName(),
                    array( 'sdp' => $params['sdp'] )
                );
                
                if ( false === $okSdp->send() ) {
                    $this->_unsubscribeFromEngineEvents();
                    return $this->dispatchErrorEvent( self::OKSDP_SIGNAL_SEND_ERR_CODE );
                }
            }
        }
    }
    
    /**
     * A CHILD signal can come from both the SIP call leg or the MS call leg. In this case we dispatch an
     * ERROR event
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleChildSignal( Streamwide_Engine_Signal $signal )
    {
        return parent::_handleChildSignal( $signal, self::CALL_LEG_DIED_ERR_CODE );
    }
    
    /**
     * Subscribe to the receival of FAIL, SDP, RING, PROGRESS and OK signal from SW Engine
     *
     * @return void
     */
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        
        // Start listen to FAIL signal
        $failNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_IN_ARRAY,
            array( array( $this->_leftCallLeg->getName(), $this->_rightCallLeg->getName() ) )
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
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $ringNotifyFilter
                )
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
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $progressNotifyFilter
                )
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
        
        // Start listen to OK signal
        $okNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_IN_ARRAY,
            array( array( $this->_leftCallLeg->getName(), $this->_rightCallLeg->getName() ) )
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::OK,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array( 'notifyFilter' => $okNotifyFilter )
            )
        );
        // End listen to OK signal
        
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
        // Start listen to CHILD signal
    }
    
    /**
     * Unsubscribe from the receival of FAIL, SDP, RING, PROGRESS and OK signal from SW Engine
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
            Streamwide_Engine_Events_Event::OKMOVED,
            Streamwide_Engine_Events_Event::FAILMOVED,
            Streamwide_Engine_Events_Event::OK,
            Streamwide_Engine_Events_Event::CHILD
        );
        
        $controller = $this->getController();
        foreach ( $events as $event ) {
            $controller->removeEventListener( $event, $callback );
        }
    }
    
    /**
     * @param mixed $performMsNegotiation
     * @return void
     */
    protected function _treatPerformMsNegotiationOption( $performMsNegotiation = null )
    {
        if ( null === $performMsNegotiation ) {
            return null;
        }
        
        if ( is_int( $performMsNegotiation ) || is_string( $performMsNegotiation ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to boolean', self::OPT_PERFORM_MS_NEGOTIATION ) );
            $performMsNegotiation = (bool)$performMsNegotiation;
        }
        
        if ( is_bool( $performMsNegotiation ) ) {
            $this->_options[self::OPT_PERFORM_MS_NEGOTIATION] = $performMsNegotiation;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_PERFORM_MS_NEGOTIATION ) );
        }
    }
    
    /**
     * Initialize options with default values
     *
     * @return void
     */
    protected function _initDefaultOptions()
    {
        $this->_options[self::OPT_PERFORM_MS_NEGOTIATION] = self::PERFORM_MS_NEGOTIATION_DEFAULT;
    }
    
}

/* EOF */
