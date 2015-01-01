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
 * @subpackage Streamwide_Engine_Widget
 * @version 1.0
 *
 */

/**
 * Puts a SIP call leg on hold
 */
class Streamwide_Engine_Sip_Call_Leg_Suspender extends Streamwide_Engine_Widget
{
    
    /**
     * Error codes
     */
    const MOVED_SIGNAL_SEND_ERR_CODE = 'SIPCALLLEGSUSPENDER-100';
    const OKMOVED_SIGNAL_SEND_ERR_CODE = 'SIPCALLLEGSUSPENDER-101';
    const CALL_LEG_UPDATE_FAILED_ERR_CODE = 'SIPCALLLEGSUSPENDER-200';
    const CALL_LEG_DIED_ERR_CODE = 'SIPCALLLEGSUSPENDER-201';
    
    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::CALL_LEG_ON_HOLD,
        Streamwide_Engine_Events_Event::ERROR
    );
    
    /**
     * The call leg to put on hold
     *
     * @var Streamwide_Engine_Call_Leg_Abstract
     */
    protected $_callLeg;
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::MOVED_SIGNAL_SEND_ERR_CODE => 'Unable to send MOVED signal to SW Engine',
        self::OKMOVED_SIGNAL_SEND_ERR_CODE => 'Unable to send OKMOVED signal to SW Engine',
        self::CALL_LEG_UPDATE_FAILED_ERR_CODE => 'Call leg update failed',
        self::CALL_LEG_DIED_ERR_CODE => 'Call leg died (CHILD signal received)'
    );
    
    /**
     * Destructor
     */
    public function destroy()
    {
        if ( isset( $this->_callLeg ) ) {
            unset( $this->_callLeg );
        }
        
        parent::destroy();
    }
    
    /**
     * Set the call leg to be put on hold.
     *
     * @param Streamwide_Engine_Call_Leg_Abstract $callLeg
     * @return void
     */
    public function setCallLeg( Streamwide_Engine_Call_Leg_Abstract $callLeg )
    {
        if ( !$callLeg instanceof Streamwide_Engine_Sip_Call_Leg ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be an instanceof Streamwide_Engine_Sip_Call_Leg' );
        }
        if ( !$callLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive call leg' );
        }
        if ( !$callLeg->hasSentOrReceivedOk() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be a call leg that has sent or received the OK signal' );
        }
        $this->_callLeg = $callLeg;
    }
    
    /**
     * Retrieve the call leg instance
     *
     * @return Streamwide_Engine_Call_Leg_Abstract|null
     */
    public function getCallLeg()
    {
        return $this->_callLeg;
    }
    
    /**
     * Put the call leg on hold
     *
     * @return boolean
     */
    public function suspend()
    {
        $movedSignal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::MOVED,
            $this->_callLeg->getName(),
            array( 'sdp' => $this->_callLeg->getParam( 'sdp' ) )
        );
        
        if ( false === $movedSignal->send() ) {
            $this->dispatchErrorEvent( self::MOVED_SIGNAL_SEND_ERR_CODE );
            return false;
        }
        
        $this->_subscribeToEngineEvents();
        return true;
    }
    
    /**
     * Deals with any signals received from the call leg during the suspension process. We improve
     * the code from the parent method by listening to a MOVED signal that can come after receiving
     * OKMOVED in response to the MOVED we sent to start the suspension process.
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onSignalReceived( Streamwide_Engine_Events_Event $event )
    {
        $eventType = $event->getEventType();
        $signal = $event->getParam( 'signal' );
        
        switch ( $eventType ) {
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
     * Handle a MOVED received from the call leg AFTER OKMOVED has been received in response to
     * the MOVED we sent to start the suspension process.
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $params = $signal->getParams();
        
        $okMovedSignal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::OKMOVED,
            $this->_callLeg->getName(),
            array( 'sdp' => $params['sdp'] )
        );
        
        if ( false === $okMovedSignal->send() ) {
            return $this->dispatchErrorEvent( self::OKMOVED_SIGNAL_SEND_ERR_CODE );
        }
    }
    
    /**
     * To put a call leg on hold we start by sending a MOVED. If the call leg answers with OKMOVED
     * we deal with it in this method
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleOkMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $params = $signal->getParams();
        $this->_callLeg->setParams( $params );
        return $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::CALL_LEG_ON_HOLD ) );
    }
    
    /**
     * To put a call leg on hold we start by sending a MOVED. If the call leg answers with FAILMOVED
     * we deal with it in this method
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleFailMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();
        return $this->dispatchErrorEvent( self::CALL_LEG_UPDATE_FAILED_ERR_CODE );
    }
    
    /**
     * Handle the call leg death
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleChildSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();
        return $this->dispatchErrorEvent( self::CALL_LEG_DIED_ERR_CODE );
    }
    
    /**
     * Subscribe to engine events (OKMOVED,FAILMOVED,MOVED)
     *
     * @return void
     */
    protected function _subscribeToEngineEvents()
    {
        $events = array(
            Streamwide_Engine_Events_Event::MOVED,
            Streamwide_Engine_Events_Event::OKMOVED,
            Streamwide_Engine_Events_Event::FAILMOVED,
            Streamwide_Engine_Events_Event::CHILD,
        );
        
        $controller = $this->getController();
        foreach ( new ArrayIterator( $events ) as $event ) {
            $controller->addEventListener(
                $event,
                array(
                    'callback' => array( $this, 'onSignalReceived' ),
                    'options' => array(
                        'notifyFilter' =>  Streamwide_Engine_NotifyFilter_Factory::factory(
                            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
                            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
                            $this->_callLeg->getName()
                        )
                    )
                )
            );
        }
    }
    
    /**
     * Unsubscribe from engine events (OKMOVED,FAILMOVED,MOVED)
     *
     * @return void
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $events = array(
            Streamwide_Engine_Events_Event::MOVED,
            Streamwide_Engine_Events_Event::OKMOVED,
            Streamwide_Engine_Events_Event::FAILMOVED,
            Streamwide_Engine_Events_Event::CHILD,
        );
        
        $controller = $this->getController();
        foreach ( new ArrayIterator( $events ) as $event ) {
            $controller->removeEventListener( $event, array( 'callback' => array( $this, 'onSignalReceived' ) ) );
        }
    }
    
}
 
/* EOF */
