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
 * Decorates a (No)Sdp IVR call connector with capability to play media before
 * the OK signal from the MS call leg is relayed to the SIP call leg (this is
 * known as early media).
 */
class Streamwide_Engine_Call_Leg_Connector_EarlyMedia_Decorator extends Streamwide_Engine_Widget_Decorator
{

    /**
     * The OK event dispatched by the controller.
     *
     * @var Streamwide_Engine_Events_Event
     */
    protected $_event;
    
    /**
     * Flag to indicate if early media is available or not
     *
     * @var boolean
     */
    protected $_earlyMediaAvailable = false;
    
    /**
     * Destructor
     */
    public function destroy()
    {
        if ( isset( $this->_event ) ) {
            unset( $this->_event );
        }
        
        parent::destroy();
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
     * Send a PROGRESS a signal to the SIP call leg and
     * dispatch an EARLY_MEDIA_AVAILABLE event
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onSignalReceived( Streamwide_Engine_Events_Event $event )
    {
        // store the received event
        $this->_event = $event;
        
        // send PROGRESS to the SIP call leg
        $this->_sendProgress();
        
        // raise the earlyMediaAvailable flag
        $this->_earlyMediaAvailable = true;
        
        // dispatch the EARLY_MEDIA_AVAILABLE event
        return $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::EARLY_MEDIA_AVAILABLE ) );
    }
    
    /**
     * Lower the _blockOkSignalRelaying flag in the decorated widget to allow
     * the relay of the OK signal to the SIP call leg.
     *
     * @return void
     */
    public function endEarlyMedia()
    {
        if ( !$this->_earlyMediaAvailable ) {
            return null;
        }
        
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
        $this->_event = null;
        $this->_earlyMediaAvailable = false;
    }
    
    /**
     * Send PROGRESS to the SIP call leg
     *
     * @return void
     */
    protected function _sendProgress()
    {
        // extract the OK signal parameters
        $okSignal = $this->_event->getParam( 'signal' );
        $params = $okSignal->getParams();
        
        // get a reference to the SIP call leg
        $sipCallLeg = $this->_widget->getLeftCallLeg();
        
        // send the PROGRESS signal to the SIP call leg
        $progressSignal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::PROGRESS,
            $sipCallLeg->getName(),
            array(
                'proto' => 'SIP',
                'sdp' => $params['sdp']
            )
        );
        $progressSignal->send();
    }
    
}
 
/* EOF */
