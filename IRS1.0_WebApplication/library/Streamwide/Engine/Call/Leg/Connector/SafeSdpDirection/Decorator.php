<?php
/**
 *
 * $Rev: 2080 $
 * $LastChangedDate: 2009-10-26 21:53:16 +0800 (Mon, 26 Oct 2009) $
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
 * Decorates any of the connectors that create a MS call leg with capability to distinguish
 * between a "safe" SDP direction and a "non-safe" SDP direction
 */
class Streamwide_Engine_Call_Leg_Connector_SafeSdpDirection_Decorator extends Streamwide_Engine_Widget_Decorator
{
    
    /**
     * Current direction of the MS call leg
     *
     * @var string
     */
    protected $_direction;
    
    /**
     * List of directions that are safe for playing media
     *
     * @var array
     */
    protected $_safeDirections = array(
        Streamwide_Engine_SdpDirection::DIRECTION_SENDONLY,
        Streamwide_Engine_SdpDirection::DIRECTION_SENDRECV
    );
    
    /**
     * Set the "safe directions" list
     *
     * @param string|array $safeDirections
     * @return void
     */
    public function setSafeDirections( $safeDirections )
    {
        if ( !is_array( $safeDirections ) ) {
            $safeDirections = array( $safeDirections );
        }
        
        $this->_safeDirections = $safeDirections;
    }
    
    /**
     * Listen for the CONNECTED event dispatched by the decorated widget
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
     * Saves the direction parameter (if there is one)
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onConnect( Streamwide_Engine_Events_Event $event )
    {
        $okSignal = $event->getParam( 'signal' );
        $params = $okSignal->getParams();
        
        if ( array_key_exists( 'direction', $params ) ) {
            $this->_direction = $params['direction'];
        }
    }
    
    /**
     * Retrieve the current direction value
     *
     * @return string|null
     */
    public function getDirection()
    {
        return $this->_direction;
    }
    
    /**
     * Is the current direction a safe one?
     *
     * @return boolean
     */
    public function isSafeDirection()
    {
        if ( $this->_direction === null ) {
            return false;
        }
        
        if ( empty( $this->_safeDirections ) ) {
            return false;
        }
        
        return in_array( $this->_direction, $this->_safeDirections );
    }
    
}
 
/* EOF */