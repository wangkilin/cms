<?php
/**
 *
 * $Rev: 2063 $
 * $LastChangedDate: 2009-10-22 19:11:11 +0800 (Thu, 22 Oct 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Callback
 * @version 1.0
 *
 */

/**
 * Every class that provides methods that can be attached as callbacks for various events in the system
 * must implement this interface. This will help preventing removal of wrong listeners from a listeners
 * list.
 *
 * setCallbackId() must set a property inside your class that will provide a unique id for the instance of that class
 * Example:
 *
 * public function setCallbackId()
    {
 *     $this->_callbackId = uniqid();
 * }
 *
 * That property must be retrievable through a call to getCallbackId()
 * Example:
 *
 * public function getCallbackId()
    {
 *     return $this->_callbackId;
 * }
 *
 * You don't need to call this methods yourself, they will be called when
 * attaching/comparing instances of Streamwide_Engine_Events_Event_Listener class
 */
interface Streamwide_Engine_Callback_Interface
{

    /**
     * Set a unique id for this callback
     *
     * @return void
     */
    public function setCallbackId();

    /**
     * Retrieve the unique id that was set with setCallbackId()
     *
     * @return mixed
     */
    public function getCallbackId();

}

/* EOF */