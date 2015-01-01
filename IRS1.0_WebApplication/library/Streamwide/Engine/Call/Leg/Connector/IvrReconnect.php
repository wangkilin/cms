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

class Streamwide_Engine_Call_Leg_Connector_IvrReconnect extends Streamwide_Engine_Call_Leg_Connector
{

    /**
     * Error codes
     */
    const MOVED_SIGNAL_SEND_ERR_CODE = 'MSALIVEIVRREINVITE-100';
    const FAILMOVED_SIGNAL_SEND_ERR_CODE = 'MSALIVEIVRREINVITE-101';
    const OKSDP_SIGNAL_SEND_ERR_CODE = 'MSALIVEIVRREINVITE-102';
    const FAILSDP_SIGNAL_SEND_ERR_CODE = 'MSALIVEIVRREINVITE-103';
    const MS_NOT_UPDATED_ERR_CODE = 'MSALIVEIVRREINVITE-200';
    const SIP_NOT_UPDATED_ERR_CODE = 'MSALIVEIVRREINVITE-201';
    const CALL_LEG_DIED_ERR_CODE = 'MSALIVEIVRREINVITE-202';
    
    /**
     * A reference to a MOVED signal that can be received from the SIP call leg
     * and needs to be treated
     *
     * @var Streamwide_Engine_Signal
     */
    protected $_movedSignal;
    
    /**
     * Has the OKMOVED been received from the SIP call leg?
     *
     * @var boolean
     */
    protected $_leftOkMovedReceived = false;
    
    /**
     * @var boolean
     */
    protected $_sipCallLegUpdateFailed = false;
    
    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
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
        self::FAILMOVED_SIGNAL_SEND_ERR_CODE => 'Unable to send FAILMOVED signal to SW Engine',
        self::OKSDP_SIGNAL_SEND_ERR_CODE => 'Unable to send OKSDP signal to SW Engine',
        self::FAILSDP_SIGNAL_SEND_ERR_CODE => 'Unable to send FAILSDP signal to SW Engine',
        self::MS_NOT_UPDATED_ERR_CODE => 'Media server call leg could not be updated',
        self::SIP_NOT_UPDATED_ERR_CODE => 'SIP call leg could not be updated',
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
        if ( !$leftCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive SIP call leg' );
        }
        if ( !$leftCallLeg->hasSentOrReceivedOk() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive SIP call leg that has sent or received the OK signal' );
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
        if ( !$rightCallLeg->hasSentOrReceivedOk() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive MS call leg that has sent or received the OK signal' );
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
        
        return $this->connect();
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#reset()
     */
    public function reset()
    {
        parent::reset();
        $this->_movedSignal = null;
        $this->_sipCallLegUpdateFailed = false;
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
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Connector#onSignalReceived()
     */
    public function onSignalReceived( Streamwide_Engine_Events_Event $event )
    {
        $eventType = $event->getEventType();
        $signal = $event->getParam( 'signal' );
        
        switch ( $eventType ) {
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
        
        return null;
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
        
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::MOVED,
            $this->_leftCallLeg->getName(),
            $params
        );
        
        if ( false === $signal->send() ) {
            $this->_unsubscribeFromEngineEvents();
            return $this->dispatchErrorEvent( self::MOVED_SIGNAL_SEND_ERR_CODE );
        }
    }
    
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
    
    protected function _handleOkMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $remote = $signal->getRemote();
        $params = $signal->getParams();
        
        if ( $remote === $this->_leftCallLeg->getName() ) {
            $this->_leftOkMovedReceived = true;
            
            $signal = Streamwide_Engine_Signal::factory(
                Streamwide_Engine_Signal::OKSDP,
                $this->_rightCallLeg->getName(),
                array( 'sdp' => $params['sdp'] )
            );
            
            if ( false === $signal->send() ) {
                $this->_unsubscribeFromEngineEvents();
                return $this->dispatchErrorEvent( self::OKSDP_SIGNAL_SEND_ERR_CODE );
            }
            
            return;
        }
        
        if ( $remote === $this->_rightCallLeg->getName() ) {
            $this->_unsubscribeFromEngineEvents();
            
            $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::CONNECTED );
            $event->setParam( 'signal', $signal );
            if ( null !== $this->_movedSignal ) {
                $event->setParam( 'moved', $this->_movedSignal );
            }
            
            return $this->dispatchEvent( $event );
        }
    }
    
    protected function _handleFailMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $remote = $signal->getRemote();
        $params = $signal->getParams();
        $failureCode = isset( $params['code'] ) ? $params['code'] : null;
        
        if ( $remote === $this->_leftCallLeg->getName() ) {
            $this->_sipCallLegUpdateFailed = true;
            
            $signal = Streamwide_Engine_Signal::factory(
                Streamwide_Engine_Signal::FAILSDP,
                $this->_rightCallLeg->getName(),
                ( null !== $failureCode ? array( 'code' => $failureCode ) : $failureCode )
            );
    
            if ( false === $signal->send() ) {
                $this->_unsubscribeFromEngineEvents();
                $this->dispatchErrorEvent( self::FAILSDP_SIGNAL_SEND_ERR_CODE );
            }
            
            return;
        }
        
        if ( $remote === $this->_rightCallLeg->getName() ) {
            $this->_unsubscribeFromEngineEvents();
            
            $errorCode = self::MS_NOT_UPDATED_ERR_CODE;
            if ( $this->_sipCallLegUpdateFailed ) {
                $errorCode = self::SIP_NOT_UPDATED_ERR_CODE;
            }
            
            return $this->dispatchErrorEvent(
                $errorCode,
                array(
                    'failureCode' => $failureCode,
                    'signal' => $signal
                )
            );
        }
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
            Streamwide_Engine_NotifyFilter_Factory::FILTER_IN_ARRAY,
            array( array( $this->_leftCallLeg->getName(), $this->_rightCallLeg->getName() ) )
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::OKMOVED,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array( 'notifyFilter' => $okMovedNotifyFilter )
            )
        );
        // End listen to OKMOVED signal
        
        // Start listen to FAILMOVED signal
        $failMovedNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_IN_ARRAY,
            array( array( $this->_leftCallLeg->getName(), $this->_rightCallLeg->getName() ) )
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::FAILMOVED,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array( 'notifyFilter' => $failMovedNotifyFilter )
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
     * Unsubscribe from SDP, OK, OKMOVED, FAILMOVED and CHILD events
     *
     * @return void
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $callback = array( 'callback' => array( $this, 'onSignalReceived' ) );
        
        $events = array(
            Streamwide_Engine_Events_Event::SDP,
            Streamwide_Engine_Events_Event::MOVED,
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
