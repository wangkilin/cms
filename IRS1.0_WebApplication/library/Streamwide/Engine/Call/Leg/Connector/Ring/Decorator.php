<?php
/**
 *
 * $Rev: 2154 $
 * $LastChangedDate: 2009-11-24 22:30:11 +0800 (Tue, 24 Nov 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Call_Leg_Connector_Decorator
 * @version 1.0
 *
 */

/**
 * Decorates any of the connectors that create a MS call leg with capability to send
 * a RING signal to the SIP call leg before the OK from the MS call leg is relayed to
 * the SIP call leg.
 */
class Streamwide_Engine_Call_Leg_Connector_Ring_Decorator extends Streamwide_Engine_Widget_Decorator
{

    /**
     * The CONNECTED event dispatched by the decorated widget
     *
     * @var Streamwide_Engine_Events_Event
     */
    protected $_event;
    
    /**
     * A timeout timer
     *
     * @var Streamwide_Engine_Timer_Timeout
     */
    protected $_timer;
    
    /**
     * How long to wait after sending the RING to relay the OK signal to the SIP call leg
     *
     * @var integer
     */
    protected $_ringDuration;
    
    /**
     * Destructor
     */
    public function destroy()
    {
        if ( isset( $this->_event ) ) {
            unset( $this->_event );
        }
        
        if ( isset( $this->_timer ) ) {
            $this->_timer->destroy();
            unset( $this->_timer );
        }
        
        parent::destroy();
    }
    
    /**
     * Set the timer object
     *
     * @param Streamwide_Engine_Timer_Timeout $timer
     * @return void
     */
    public function setTimer( Streamwide_Engine_Timer_Timeout $timer )
    {
        $this->_timer = $timer;
    }
    
    /**
     * Retrieve the timer widget (if any) used by the recorder
     *
     * @return Streamwide_Engine_Timer_Timeout
     */
    public function getTimer()
    {
        return $this->_timer;
    }
    
    /**
     * Set the ring duration
     *
     * @param integer $ringDuration
     * @return void
     */
    public function setRingDuration( $ringDuration )
    {
        $this->_ringDuration = $ringDuration;
    }
    
    /**
     * Get ring duration
     *
     * @return integer|null
     */
    public function getRingDuration()
    {
        return $this->_ringDuration;
    }
    
    /**
     * Add ourselves as a listener to the OK event dispatched by the controller.
     * We attach with a low priority to let the decorated widget execute its
     * callback first. We raise the _blockOkSignalRelaying flag in the decorated
     * widget to prevent relaying of the OK signal to the SIP call leg.
     *
     * @return boolean
     */
    public function connect()
    {
        // Get a reference to the MS call leg
        $msCallLeg = $this->_widget->getRightCallLeg();
        
        $controller = $this->getController();

        // subscribe to receive a notification when we receive OK from controller
        $notifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $msCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::OK,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'priority' => -1,
                    'notifyFilter' => $notifyFilter
                )
            )
        );
        
        // do not allow the decorated widget to relay the OK signal
        $this->_widget->blockOkSignalRelaying();
        // call connect on the decorated widget
        return $this->_widget->connect();
    }
    
    /**
     * Send a RING signal to the SIP call leg and arm the timer
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return unknown_type
     */
    public function onSignalReceived( Streamwide_Engine_Events_Event $event )
    {
        // store the received event
        $this->_event = $event;
        // send the RING signal to the SIP call leg
        $this->_sendRing();
        // arm the timer
        $this->_armTimer();
    }
    
    /**
     * Lower the _blockOkSignalRelaying flag in the decorated widget to allow
     * relaying of the OK signal
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onTimeout( Streamwide_Engine_Events_Event $event )
    {
        $this->_widget->unblockOkSignalRelaying();
        $this->_widget->onSignalReceived( $this->_event );
    }
    
    /**
     * @see Engine/Widget/Streamwide_Engine_Widget_Decorator#reset()
     */
    public function reset()
    {
        parent::reset();
        $controller = $this->getController();
        $controller->removeEventListener(
            Streamwide_Engine_Events_Event::OK,
            array( 'callback' => array( $this, 'onSignalReceived' ) )
        );
        if ( null !== $this->_timer ) {
            $this->_timer->reset();
        }
        $this->_event = null;
    }
    
    /**
     * Arm the timer
     *
     * @return void
     */
    protected function _armTimer()
    {
        $this->_timer->reset();
        $this->_timer->setOptions( array( Streamwide_Engine_Timer_Timeout::OPT_DELAY => $this->_ringDuration ) );
        $this->_timer->addEventListener(
            Streamwide_Engine_Events_Event::TIMEOUT,
            array(
                'callback' => array( $this, 'onTimeout' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $this->_timer->arm();
    }
    
    /**
     * Send a RING signal to the SIP call leg
     *
     * @return void
     */
    protected function _sendRing()
    {
        // retrieve the OK signal from the event object
        $okSignal = $this->_event->getParam( 'signal' );
        
        // get a reference to the SIP call leg
        $sipCallLeg = $this->_widget->getLeftCallLeg();
        
        // send the RING signal
        $ringSignal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::RING,
            $sipCallLeg->getName(),
            $okSignal->getParams()
        );
        $ringSignal->send();
    }

}
 
/* EOF */
