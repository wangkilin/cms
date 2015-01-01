<?php
/**
 * Container class.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Container
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Container.php 1962 2009-09-24 20:49:25Z rgasler $
 */

/**
 * Generic container for heterogenous values
 */
class Streamwide_Container extends ArrayObject
{
    /**
     * Values of the container
     *
     * @var array
     */
    protected $_values = array();

    /**
     * Constructor
     *
     * @param array $values (optional) Array of values
     */
    public function __construct( Array $values = null )
    {
        if ( is_array( $values ) && !empty( $values ) ) {
            foreach ( new ArrayIterator( $values ) as $offset => $val ) {
                if ( is_array( $val ) ) {
                    $this->_values[$offset] = new self( $val );
                } else {
                    $this->_values[$offset] = $val;
                }
            }
        }

        parent::__construct( $this->_values );
    }

    /**
     * This method will be called when this object is used in string context
     *
     * @return void
     */
    public function __toString()
    {
    }
    
    /**
     * This method will be called when this object will be cloned
     *
     * @return void
     */
    public function __clone()
    {
        foreach ( $this->_values as $offset => $value ) {
            if ( is_object( $value ) ) {
                $this->_values[$offset] = clone $value;
            }
        }
        $this->exchangeArray( $this->_values );
    }
    
    /**
     * This method will be called when calling isset() or empty() on a property of this object
     *
     * @param string $offset offset
     * @return boolean
     */
    public function __isset( $offset )
    {
        return isset( $this->_values[$offset] );
    }
    
    /**
     * This method will be called when calling unset() on a property of this object
     *
     * @param string $offset offset
     * @return void
     */
    public function __unset( $offset )
    {
        return $this->offsetUnset( $offset );
    }
    
    /**
     * Retrieves a value from the container using a convenient notation
     *
     * @param string $offset offset
     * @return mixed value of the offset
     */
    public function __get( $offset )
    {
        return $this->offsetGet( $offset );
    }

    /**
     * Set a value in the container using a convenient notation
     *
     * @param string $offset offset
     * @param mixed  $value  value
     * @return void
     */
    public function __set( $offset, $value )
    {
        $this->offsetSet( $offset, $value );
    }
    
    /**
     * Set an value in the container
     *
     * @param string $offset offset
     * @param mixed  $value  value
     * @return void
     */
    public function offsetSet( $offset, $value )
    {
        return $this->_offsetSet( $offset, $value );
    }

    /**
     * Retrieve a value from the container
     *
     * @param string $offset offset
     * @return mixed
     */
    public function offsetGet( $offset )
    {
        if ( $this->offsetExists( $offset ) ) {
            return $this->_values[$offset];
        }
    }

    /**
     * Whether or not a $offset exists in the container
     *
     * @param string $offset offset
     * @return boolean true if offset exists in container, false otherwise
     */
    public function offsetExists( $offset )
    {
        return array_key_exists( $offset, $this->_values );
    }

    /**
     * Deletes value at $offset from the container
     *
     * @param string $offset offset
     * @return void
     */
    public function offsetUnset( $offset )
    {
        if ( $this->offsetExists( $offset ) ) {
            unset( $this->_values[$offset] );
            $this->exchangeArray( $this->_values );
        }
    }

    /**
     * Counts the number of entries in the container
     *
     * @return integer number of entries in the container
     */
    public function count()
    {
        return count( $this->_values );
    }

    /**
     * Retrieve an iterator for the properties of this object
     *
     * @param boolean $recursive (optional) Whether iterator should be recursive or not
     *                           Defaults to false.
     * @return ArrayIterator|RecursiveIteratorIterator Iterator for the properties of this object
     */
    public function getIterator( $recursive = false )
    {
        if ( false === $recursive ) {
            return new ArrayIterator( $this->_values );
        }
        return new RecursiveIteratorIterator( new RecursiveArrayIterator( $this->_values ) );
    }
    
    /**
     * Retrieve an array representation of this object
     *
     * @return array an array representation of this object
     */
    public function toArray()
    {
        $ret = array();
        foreach ( $this->_values as $offset => $value ) {
            if ( $value instanceof self ) {
                $ret[$offset] = $value->toArray();
            } else {
                $ret[$offset] = $value;
            }
        }
        return $ret;
    }
    
    /**
     * Set a value in the container.
     *
     * @param string $offset offset
     * @param mixed  $value  value
     * @return void
     */
    protected function _offsetSet( $offset, $value )
    {
        if ( is_array( $value ) ) {
            $this->_values[$offset] = new self( $value );
        } else {
            $this->_values[$offset] = $value;
        }
        $this->exchangeArray( $this->_values );
    }
}

/* EOF */