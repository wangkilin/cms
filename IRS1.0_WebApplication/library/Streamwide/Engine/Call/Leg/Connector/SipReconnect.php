<?php
/**
 *
 * $Rev: 2171 $
 * $LastChangedDate: 2009-12-07 17:47:29 +0800 (Mon, 07 Dec 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Call_Leg_Connector
 * @version 1.0
 *
 */

class Streamwide_Engine_Call_Leg_Connector_SipReconnect extends Streamwide_Engine_Call_Leg_Connector
{

    const MOVED_SIGNAL_SEND_ERR_CODE = 'SIPRECONNECT-100';
    const OKSDP_SIGNAL_SEND_ERR_CODE = 'SIPRECONNECT-102';
    const FAILMOVED_SIGNAL_SEND_ERR_CODE = 'SIPRECONNECT-103';
    const CALL_LEG_UPDATE_FAILED_ERR_CODE = 'SIPRECONNECT-200';
    const CALL_LEG_DIED_ERR_CODE = 'SIPRECONNECT-201';
  
    /**
     * Reference to a MOVED signal that we may receive during the reconnection process
     *
     * @var Streamwide_Engine_Signal
     */
    protected $_movedSignal;
    
    /**
     * Flag to indicate whether an OKMOVED signal has been received from the right call leg
     *
     * @var boolean
     */
    protected $_rightOkMovedReceived = false;
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::MOVED_SIGNAL_SEND_ERR_CODE => 'Unable to send MOVED signal to SW Engine',
        self::OKSDP_SIGNAL_SEND_ERR_CODE => 'Unable to send OKSDP signal to SW Engine',
        self::FAILMOVED_SIGNAL_SEND_ERR_CODE => 'Unable to send FAILMOVED signal to SW Engine',
        self::CALL_LEG_UPDATE_FAILED_ERR_CODE => 'One of the call legs involved in the connection process could not be updated',
        self::CALL_LEG_DIED_ERR_CODE => 'One of the call legs involved in the connection process has died (CHILD signal received)',
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
     * Set the left SIP call leg
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
        if ( !$leftCallLeg->hasSentOrReceivedOk() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive SIP call leg that has received the OK signal' );
        }
        parent::setLeftCallLeg( $leftCallLeg );
    }
    
    /**
     * Set the right SIP call leg
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
        if ( !$rightCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive SIP call leg' );
        }
        if ( !$rightCallLeg->hasSentOrReceivedOk() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive SIP call leg that has received the OK signal' );
        }
        parent::setRightCallLeg( $rightCallLeg );
    }
    
    /**
     * Reconnect the 2 SIP call legs
     *
     * @return boolean
     */
    public function connect()
    {
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::MOVED,
            $this->_leftCallLeg->getName()
        );
        
        if ( false === $signal->send() ) {
            $this->dispatchErrorEvent( self::MOVED_SIGNAL_SEND_ERR_CODE );
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
        $this->_rightOkMovedReceived = false;
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
     * Handle all the signals involved in the reconnection process
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
     * We have sent MOVED to the left SIP call leg and the response was an SDP signal.
     * We need to send MOVED to the right SIP call leg with the sdp from SDP signal.
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleSdpSignal( Streamwide_Engine_Signal $signal )
    {
        $params = $signal->getParams();
        
        $movedSignal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::MOVED,
            $this->_rightCallLeg->getName(),
            array( 'sdp' => $params['sdp'] )
        );
        
        if ( false === $movedSignal->send() ) {
            $this->_unsubscribeFromEngineEvents();
            return $this->dispatchErrorEvent( self::MOVED_SIGNAL_SEND_ERR_CODE );
        }
    }
    
    /**
     * If we received OKMOVED from the right SIP call leg, we need to send an OKSDP to
     * the left SIP call leg. If we received OKMOVED from left SIP call leg reconnect
     * was successfull and we need to dispatch the CONNECTED event
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleOkMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $params = $signal->getParams();
        $remoteName = $signal->getRemote();
        
        if ( $remoteName === $this->_rightCallLeg->getName() ) {
        	$this->_rightOkMovedReceived = true;
        	
        	$this->_rightCallLeg->setParams( $params );
        	
        	$okSdpSignal = Streamwide_Engine_Signal::factory(
                Streamwide_Engine_Signal::OKSDP,
        	    $this->_leftCallLeg->getName(),
                array( 'sdp' => $params['sdp'] )
            );
        
            if ( false === $okSdpSignal->send() ) {
                $this->_unsubscribeFromEngineEvents();
                return $this->dispatchErrorEvent( self::OKSDP_SIGNAL_SEND_ERR_CODE );
            }
            
            return null;
        }
        
        if ( $remoteName === $this->_leftCallLeg->getName() ) {
        	$this->_unsubscribeFromEngineEvents();
        
        	$this->_leftCallLeg->setParams( $params );
        	
	        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::CONNECTED );
	        $event->setParam( 'signal', $signal );
	        if ( null !== $this->_movedSignal ) {
	            $event->setParam( 'moved', $this->_movedSignal );
	        }
	        return $this->dispatchEvent( $event );
        }
    }
    
    /**
     * FAILMOVED can come from both ends and in both cases we need to dispatch
     * an error event
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleFailMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();
        
        $remote = $signal->getRemote();
        $callLeg = (
            $remote === $this->_leftCallLeg->getName()
            ? $this->_leftCallLeg
            : $this->_rightCallLeg
        );
        
        return $this->dispatchErrorEvent(
            self::CALL_LEG_UPDATE_FAILED_ERR_CODE,
            array( 'callLeg' => $callLeg )
        );
    }
    
    /**
     * During the reconnect process we can receive a MOVED from the right SIP call leg. If this occurs
     * before we received OKMOVED from the right SIP call leg we need to reply with a FAILMOVED.
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleMovedSignal( Streamwide_Engine_Signal $signal )
    {
     	if ( $this->_rightOkMovedReceived ) {
     	    $this->_movedSignal = $signal;
    	} else {
        	$failMovedSignal = Streamwide_Engine_Signal::factory(
	            Streamwide_Engine_Signal::FAILMOVED,
        	    $this->_rightCallLeg->getName(),
	            array( 'code' => '491' )
	        );
        
	        if ( false === $failMovedSignal->send() ) {
	            $this->_unsubscribeFromEngineEvents();
                return $this->dispatchErrorEvent( self::FAILMOVED_SIGNAL_SEND_ERR_CODE );
	        }
    	}
    }
  
    /**
     * A CHILD signal can come from both ends signifying that one of the call legs has been
     * terminated. In both cases we need to dispatch an error event.
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleChildSignal( Streamwide_Engine_Signal $signal )
    {
        return parent::_handleChildSignal( $signal, self::CALL_LEG_DIED_ERR_CODE );
    }
    
    /**
     * Subscribe to SDP, CHILD, MOVED, OKMOVED, FAILMOVED events
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
            $this->_leftCallLeg->getName()
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
        
        // Start listen to MOVED signal
        $movedNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_rightCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::MOVED,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array( 'notifyFilter' => $movedNotifyFilter )
            )
        );
        // End listen to MOVED signal
        
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
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $failMovedNotifyFilter
                )
            )
        );
        // End listen to FAILMOVED signal
    }
    
    /**
     * Unsubscribe from SDP, CHILD, MOVED, OKMOVED, FAILMOVED events
     *
     * @return void
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $events = array(
            Streamwide_Engine_Events_Event::SDP,
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
