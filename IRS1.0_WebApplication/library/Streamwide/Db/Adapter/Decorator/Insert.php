<?php
/**
 * Streamwide adapter insert decorator.
 *
 * $Rev: 1954 $
 * $LastChangedDate: 2009-09-24 23:27:45 +0800 (Thu, 24 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Db
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Insert.php 1954 2009-09-24 15:27:45Z rgasler $
 */

class Streamwide_Db_Adapter_Decorator_Insert extends Streamwide_Db_Adapter_Decorator_Abstract
{
    
    /**
     * Prepares and executes an SQL statement with bound data.
     *
     * @param mixed $sql  The SQL statement with placeholders.
     *                    May be a string or Zend_Db_Select.
     * @param mixed $bind An array of data to bind to the placeholders.
     * @return Zend_Db_Statement_Interface
     */
    public function query( $sql, $bind = array() )
    {
        // is the $sql a Zend_Db_Select object?
        if ( $sql instanceof Zend_Db_Select ) {
            $sql = $sql->assemble();
        }
        $sql = trim( $sql );
        
        // some checks to see if we should add the enhancement
        if ( !$this->_isInsert( $sql ) ) {
            return parent::query( $sql, $bind );
        }
        
        // if the query is executed without any parameters there's no point in adding enhancements
        if ( empty( $bind ) ) {
            return parent::query( $sql, $bind );
        }
        
        // the first parameter of the $bind array must be set to null
        // if it isn't we don't add the enhancement
        reset( $bind );
        list( $key, $first ) = each( $bind );
        if ( null !== $first ) {
            return parent::query( $sql, $bind );
        }
        
        // attempt to build the sequence name from the table name
        $table = $this->_extractTableName( $sql );
        if ( false === ( $sequence = $this->_getSequenceName( $table ) ) ) {
            return parent::query( $sql, $bind );
        }
        
        // add the enhancement (which is setting the first parameter in the $bind array
        // to the next sequence value)
        $bind[$key] = parent::nextSequenceId( $sequence );
        reset( $bind );
        
        return parent::query( $sql, $bind );
    }
    
    /**
     * Verifies that an SQL query is an INSERT query
     *
     * @param string $sql sql statement
     * @return boolean
     */
    protected function _isInsert( $sql )
    {
        return ( strpos( strtolower( $sql ), 'insert' ) === 0 );
    }
    
    /**
     * Extracts the table name from a INSERT query
     *
     * @param string $sql sql query
     * @return string
     * @throws Streamwide_Db_Adapter_Decorator_Exception
     */
    protected function _extractTableName( $sql )
    {
        $ret = preg_match( '~^\s*insert\s+into\s+(\S+?)\s+~im', $sql, $matches );
        if ( $ret === 1 && isset( $matches[1] ) ) {
            $config = $this->_adapter->getConfig();
            $isAutoQuoteOn = $config['options'][Zend_Db::AUTO_QUOTE_IDENTIFIERS];
            if ( $isAutoQuoteOn ) {
                $quoteIdentifierSymbol = $this->_adapter->getQuoteIdentifierSymbol();
                if ( !empty( $quoteIdentifierSymbol ) ) {
                    return trim( $matches[1], $quoteIdentifierSymbol );
                }
            }
            return $matches[1];
        }
        
        require_once 'Streamwide/Db/Adapter/Decorator/Exception.php';
        throw new Streamwide_Db_Adapter_Decorator_Exception( 'Unable to extract table name from sql string' );
    }
}

/* EOF */