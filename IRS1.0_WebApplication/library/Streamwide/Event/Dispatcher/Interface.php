<?php
/**
 * Event dispatcher interface.
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

interface Streamwide_Event_Dispatcher_Interface
{
    /**
     * Dispatches an event. This means notifying all listeners and passing them the event object
     *
     * @param Streamwide_Event_Interface $event event to dispatch
     * @return void
     */
    public function dispatchEvent( Streamwide_Event_Interface $event );

    /**
     * Adds an event listener to the listeners list
     *
     * @param string $eventType event type
     * @param array  $callback  callback
     * @return boolean
     */
    public function addEventListener( $eventType, Array $callback );

    /**
     * Removes an event listener from the listeners list
     *
     * @param string $eventType event type
     * @param array  $callback  callback
     * @return boolean
     */
    public function removeEventListener( $eventType, Array $callback );

    /**
     * Is the provided event listener attached to the provided event type?
     *
     * @param string $eventType event type
     * @param array  $callback  callback
     * @return boolean
     */
    public function hasEventListener( $eventType, Array $callback );
    
    /**
     * Do we have any event listeners attached for the specified event type?
     *
     * @param string $eventType (optional) event type
     * @return boolean
     */
    public function hasEventListeners( $eventType = null );

    /**
     * Retrieves the internal event listeners list
     *
     * @return array
     */
    public function getEventListeners();

    /**
     * Clears the event listeners list
     *
     * @param array $criteria (optional) an array of criteria to clear event listeners
     * @return void
     */
    public function flushEventListeners( Array $criteria = null );
}

/* EOF */