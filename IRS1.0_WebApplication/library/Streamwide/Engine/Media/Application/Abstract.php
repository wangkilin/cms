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
 * @subpackage Streamwide_Engine_Media_Application
 * @version 1.0
 *
 */

/**
 * Base class for media applications. You can think of a media application as being the sum
 * of all things that happen during a call
 */
abstract class Streamwide_Engine_Media_Application_Abstract implements Streamwide_Engine_Callback_Interface
{

    /**
     * The name of the application
     *
     * @var string
     */
    protected $_name;

    /**
     * A unique id to identify an instance of this class if it is used as a callback
     *
     * @var string
     */
    protected $_callbackId;

    /**
     * Enter the application
     *
     * @return void
     */
    abstract public function start();


    /**
     * End the application
     *
     * @return void
     */
    abstract public function end();


    /**
     * Retrieve the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }


    /**
     * Set a unique id for this callback
     *
     * @return void
     */
    public function setCallbackId()
    {
        if ( null === $this->_callbackId ) {
            $this->_callbackId = md5( uniqid( rand(), true ) );
        }
    }


    /**
     * Retrieve the unique id that was set with setCallbackId()
     *
     * @return string
     */
    public function getCallbackId()
    {
        return $this->_callbackId;
    }


}

/* EOF */
