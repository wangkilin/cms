<?php
/**
 * Event listener interface.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Event
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Interface.php 1962 2009-09-24 20:49:25Z rgasler $
 */

interface Streamwide_Event_Listener_Interface
{
    /**
     * Execute the action that was attached to a certain event
     *
     * @param Streamwide_Event_Interface|null $event event
     * @return mixed
     */
    public function execute( Streamwide_Event_Interface $event = null );

    /**
     * Determines if a listener instance is equal to another
     *
     * @param Streamwide_Event_Listener_Interface $listener event listener
     * @return boolean
     */
    public function equals( Streamwide_Event_Listener_Interface $listener );

    /**
     * Retrieve the execution priority for the current instance
     *
     * @return integer
     */
    public function getPriority();
}

/* EOF */