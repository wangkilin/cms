<?php
/**
 *
 * $Rev: 2560 $
 * $LastChangedDate: 2010-04-23 15:49:53 +0800 (Fri, 23 Apr 2010) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Registry
 * @version 1.0
 *
 */

/**
 * Global place for accessing various components needed in the framework
 */
final class Streamwide_Engine_Registry
{

    /**
     * Sole instance of this class
     *
     * @var Streamwide_Engine_Registry
     */
    private static $_instance = null;

    /**
     * All values are stored in this array
     *
     * @var array
     */
    protected $_registry = array();

    /**
     * Constructor. Declared private to prevent instantiation
     */
    private function __construct()
    {}

    /**
     * Prevent cloning
     *
     * @throws Exception
     */
    public function __clone()
    {
    	throw new Exception( __CLASS__ . ' is a singleton, thus it cannot be cloned' );
    }

    /**
     * Retrieve the sole instance of this class
     *
     * @return Streamwide_Engine_Registry
     */
    public static function getInstance()
    {
    	if ( null === self::$_instance ) {
    		self::$_instance = new self();
    	}
        return self::$_instance;
    }

    /**
     * Add a value to the registry
     *
     * @param string $offset
     * @param mixed $value
     * @param boolean $overwrite
     * @return void
     */
    public function set( $offset, $value, $overwrite = true )
    {
        if ( $this->_offsetExists( $offset ) && false === $overwrite ) {
        	return null;
        }
        $this->_registry[$offset] = $value;
    }

    /**
     * Retrieve the value at $offset from the registry
     *
     * @param string $offset
     * @param boolean $copy If the registry has an object at $offset and $copy is set to true a clone will be returned
     * @return mixed
     */
    public function get( $offset, $copy = false )
    {
        $ret = null;
        if ( $this->_offsetExists( $offset ) ) {
        	$ret = $this->_registry[$offset];
        }
        if ( true === $copy && is_object( $ret ) ) {
        	return clone $ret;
        }
        return $ret;
    }

    /**
     * Resets the registry (used for testing purposes)
     *
     * @return void
     */
    public function reset()
    {
        $this->_registry = array();
        self::$_instance = null;
    }
    
    /**
     * Verifies if $offset exists in the registry
     *
     * @param string $offset
     * @return boolean
     */
    protected function _offsetExists( $offset )
    {
    	return array_key_exists( $offset, $this->_registry );
    }

}

/* EOF */