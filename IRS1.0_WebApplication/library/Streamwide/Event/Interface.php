<?php
/**
 * Event interface.
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

interface Streamwide_Event_Interface
{
    /**
     * Retrieves the event type
     *
     * @return string
     */
    public function getEventType();

    /**
     * Saves the source of the event
     *
     * @param mixed $source event source
     * @return void
     */
    public function setEventSource( $source );

    /**
     * Retrieves the event source
     *
     * @return mixed
     */
    public function getEventSource();

}

/* EOF */