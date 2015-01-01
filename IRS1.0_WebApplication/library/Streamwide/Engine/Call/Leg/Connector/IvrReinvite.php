<?php
/**
 *
 * $Rev:$
 * $LastChangedDate:$
 * $LastChangedBy:$
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Call_Leg_Connector
 * @version 1.0
 *
 */

class Streamwide_Engine_Call_Leg_Connector_IvrReinvite extends Streamwide_Engine_Call_Leg_Connector
{

    const CREATE_SIGNAL_SEND_ERR_CODE = 'IVRREINVITE-100';
    const MOVED_SIGNAL_SEND_ERR_CODE = 'IVRREINVITE-101';
    const OKSDP_SIGNAL_SEND_ERR_CODE = 'IVRREINVITE-102';
    const FAILMOVED_SIGNAL_SEND_ERR_CODE = 'IVRREINVITE-103';
    const SIP_UPDATE_FAILED_ERR_CODE = 'IVRREINVITE-200';
    const MS_NOT_CREATED_ERR_CODE = 'IVRREINVITE-201';
    const CALL_LEG_DIED_ERR_CODE = 'IVRREINVITE-202';
    
    /**
     * A reference to a MOVED signal
     *
     * @var Streamwide_Engine_Signal
     */
    protected $_movedSignal;
    
    /**
     * Flag to tell us if an OKMOVED has been received from the left call leg
     *
     * @var boolean
     */
    protected $_leftOkMovedReceived = false;
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::CREATE_SIGNAL_SEND_ERR_CODE => 'Unable to send CREATE signal to SW Engine',
        self::MOVED_SIGNAL_SEND_ERR_CODE => 'Unable to send MOVED signal to SW Engine',
        self::OKSDP_SIGNAL_SEND_ERR_CODE => 'Unable to send OKMOVED signal to SW Engine',
        self::FAILMOVED_SIGNAL_SEND_ERR_CODE => 'Unable to send FAILMOVED signal to SW Engine',
        self::SIP_UPDATE_FAILED_ERR_CODE => 'SIP call leg could not be updated',
        self::MS_NOT_CREATED_ERR_CODE => 'MS call leg could not be created',
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
     * Set the SIP call leg
     *
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
        if ( !$leftCallLeg->hasSentOrReceivedOk() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 the be an alive SIP call leg that has received the OK signal' );
        }
        parent::setLeftCallLeg( $leftCallLeg );
    }
    
    /**
     * Set the media server call leg
     *
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
     * Starts the reinvite process by sending CREATE to the media server call leg
     *
     * @return void
     */
    public function connect()
    {
        $params = array();
        $params['name'] = $this->_rightCallLeg->getName();
        $params['proto'] = 'MS';
        if ( isset( $this->_connectionParams['msProtocol'] ) ) {
            $params['proto'] = $this->_connectionParams['msProtocol'];
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
     * @see Engine/Streamwide_Engine_Widget#reset()
     */
    public function reset()
    {
        parent::reset();
        $this->_movedSignal = null;
        $this->_leftOkMovedReceived = false;
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
     * Handles the signals involved in the reinvite process
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
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
            case Streamwide_Engine_Events_Event::OK:
                return $this->_handleOkSignal( $signal );
            case Streamwide_Engine_Events_Event::CHILD:
                return $this->_handleChildSignal( $signal );
            case Streamwide_Engine_Events_Event::OKMOVED:
                return $this->_handleOkMovedSignal( $signal );
            case Streamwide_Engine_Events_Event::MOVED:
                return $this->_handleMovedSignal( $signal );
            case Streamwide_Engine_Events_Event::FAILMOVED:
                return $this->_handleFailMovedSignal( $signal );
        }
        
        return null;
    }
    
    /**
     * We have sent the CREATE signal to the MS call leg and the MS call leg
     * replied with SDP. We need to send MOVED to the SIP call leg
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
     * The SIP call leg replied with OKMOVED. We need to send OKSDP to the MS call leg
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleOkMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_leftOkMovedReceived = true;
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
     * The SIP call leg replied with FAILMOVED. We need to dispatch an error event.
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
     * We have received a MOVED signal from the SIP call leg. We need to store it
     * to give client code the chance to handle it
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleMovedSignal( Streamwide_Engine_Signal $signal )
    {
        if ( $this->_leftOkMovedReceived ) {
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
     * We have received a FAIL signal from the MS call leg. We can consider
     * the reinvite as being unsuccessfull.
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleFailSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();
        
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
     * We can receive CHILD from both ends signifying the termination of one of the call legs
     * involded in the reinvite proces. We need to dispatch an error event.
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleChildSignal( Streamwide_Engine_Signal $signal )
    {
        return parent::_handleChildSignal( $signal, self::CALL_LEG_DIED_ERR_CODE );
    }
    
    /**
     * We have received OK from the MS call leg. We can consider the reinivite was successfull,
     * so we dispatch the CONNECTED event.
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
     * Subscribe to all engine events that are expected to be dispatched during the reinvite proces
     *
     * @return void
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
    
    /**
     * Unsubscribe to all engine events that are expected to be dispatched during the reinvite proces
     *
     * @return void
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $events = array(
            Streamwide_Engine_Events_Event::SDP,
            Streamwide_Engine_Events_Event::FAIL,
            Streamwide_Engine_Events_Event::OK,
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
