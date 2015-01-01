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
 * Decorates connectors with the capability to start a relayer after the two call legs have been
 * linked. If you want specific settings for the relayer, please set them before using this decorator
 * otherwise the default settings of the relayer will be used.
 */
class Streamwide_Engine_Call_Leg_Connector_Relayer_Decorator extends Streamwide_Engine_Widget_Decorator
{

    /**
     * The relayer to be started
     *
     * @var Streamwide_Engine_Automatic_Signal_Relayer
     */
    protected $_relayer;
    
    /**
     * Destructor
     */
    public function destroy()
    {
        if ( isset( $this->_relayer ) ) {
            $this->_relayer->destroy();
            unset( $this->_relayer );
        }
        
        parent::destroy();
    }
    
    /**
     * Set the relayer object
     *
     * @param Streamwide_Engine_Automatic_Signal_Relayer $relayer
     * @return void
     */
    public function setRelayer( Streamwide_Engine_Automatic_Signal_Relayer $relayer )
    {
        $this->_relayer = $relayer;
    }
    
    /**
     * Retrieve the relayer object
     *
     * @return Streamwide_Engine_Automatic_Signal_Relayer
     */
    public function getRelayer()
    {
        return $this->_relayer;
    }
    
    /**
     * Attach ourselves to the CONNECTED event dispatched by the decorated widget
     *
     * @return boolean
     */
    public function connect()
    {
        $this->_widget->addEventListener(
            Streamwide_Engine_Events_Event::CONNECTED,
            array(
                'callback' => array( $this, 'onConnect' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        
        return $this->_widget->connect();
    }
    
    /**
     * Starts the relayer object
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onConnect( Streamwide_Engine_Events_Event $event )
    {
        $this->_relayer->setLeftCallLeg( $this->_widget->getLeftCallLeg() );
        $this->_relayer->setRightCallLeg( $this->_widget->getRightCallLeg() );
        
        if ( !$this->_relayer->isRunning() ) {
            $this->_relayer->start();
        }
        
        // Do we need to treat a MOVED signal?
        $specification = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_PARAM,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_INSTANCE_OF,
            array( 'moved', 'Streamwide_Engine_Signal' )
        );
        if ( $specification->isSatisfiedBy( $event ) ) {
            $movedSignal = $event->getParam( 'moved' );
            $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::MOVED );
            $event->setParam( 'signal', $movedSignal );
            return $this->_relayer->onSignalReceived( $event );
        }
    }
    
}
 
/* EOF */
