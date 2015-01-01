<?php
/**
 * Oracle statement class.
 *
 * $Rev: 1954 $
 * $LastChangedDate: 2009-09-24 23:27:45 +0800 (Thu, 24 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Db
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Oracle.php 1954 2009-09-24 15:27:45Z rgasler $
 */

class Streamwide_Db_Statement_Oracle extends Zend_Db_Statement_Oracle
{
    /**
     * Fetches a row from the result set.
     *
     * @param int $style  (optional) Fetch mode for this fetch operation.
     * @param int $cursor (optional) Absolute, relative, or other.
     * @param int $offset (optional) Number for absolute or relative cursors.
     * @return mixed Array, object or scalar depending on fetch mode.
     * @throws Zend_Db_Statement_Exception
     */
    public function fetch( $style = null, $cursor = null, $offset = null )
    {
        $row = parent::fetch( $style, $cursor, $offset );
        
        if ( is_scalar( $row ) ) {
            return $row;
        }
        if ( is_array( $row ) ) {
            return $this->_caseFoldArray( $row );
        }
        if ( is_object( $row ) ) {
            return $this->_caseFoldObject( $row );
        }
    }
    
    /**
     * Returns an array containing all of the result set rows.
     *
     * @param int $style (optional) Fetch mode.
     * @param int $col   (optional) Column number, if fetch mode is by column.
     * @return array Collection of rows, each in a format by the fetch mode.
     * @throws Zend_Db_Statement_Exception
     */
    public function fetchAll( $style = null, $col = 0 )
    {
        $retval = parent::fetchAll( $style, $col );
        if ( false === $retval ) {
            return false;
        }
        if ( is_array( $retval ) ) {
            return array_map( array( $this, '_caseFoldingCallback' ), $retval );
        }
        return $retval;
    }
    
    /**
     * Fetches the next row and returns it as an object.
     *
     * @param string $class  (optional) Name of the class to create.
     * @param array  $config (optional) Constructor arguments for the class.
     * @return mixed One object instance of the specified class.
     * @throws Zend_Db_Statement_Exception
     */
    public function fetchObject( $class = 'stdClass', array $config = array() )
    {
        return $this->_caseFoldObject( parent::fetchObject( $class, $config ) );
    }
    
    /**
     * Apply the case folding to an array
     *
     * @param array $array array to apply case folding to
     * @return array
     */
    protected function _caseFoldArray( $array )
    {
        $keys = array_keys( $array );
        $keys = array_map( array( $this->_adapter, 'foldCase' ), $keys );
        
        return array_combine( $keys, array_values( $array ) );
    }
    
    /**
     * Apply the case folding to an object
     *
     * @param mixed $object object to apply case folding to
     * @return mixed
     */
    protected function _caseFoldObject( $object )
    {
        /**
         * @todo Handle case folding for objects
         */
        return $object;
    }
    
    /**
     * Case folding callback to be used with the array returned by fetchAll()
     *
     * @param mixed $row row to apply case folding
     * @return mixed
     */
    protected function _caseFoldingCallback( $row )
    {
        if ( is_array( $row ) ) {
            return $this->_caseFoldArray( $row );
        }
        if ( is_object( $row ) ) {
            return $this->_caseFoldObject( $row );
        }
        return $row;
    }
}

/* EOF */