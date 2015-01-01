<?php
/**
 *
 * $Rev: 2066 $
 * $LastChangedDate: 2009-10-22 20:18:09 +0800 (Thu, 22 Oct 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Proxy
 * @version 1.0
 *
 */

/**
 * Links the SW Engine with the php script (using the as_next_event
 * and as_send_event functions)
 */
class Streamwide_Engine_Proxy
{

    /**
     * Retrieve the next event from SW Engine's queue
     *
     * @param integer $timeout
     * @return array|boolean
     */
    public function nextEvent( $timeout = -1 )
    {
        $array = as_next_event( $timeout );
        if ( empty( $array ) ) {
            return false;
        }
        return $array;
    }
    
    /**
     * Send a signal to the SW Engine
     *
     * @param array $event
     * @return boolean
     */
    public function sendEvent( Array $event )
    {
        return (bool)as_send_event( $event );
    }
    
}

/* EOF */