<?php
/**
 * Streamwide adapter positional parameters conversion decorator.
 *
 * $Rev: 1954 $
 * $LastChangedDate: 2009-09-24 23:27:45 +0800 (Thu, 24 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Db
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: PositionalParamsConversion.php 1954 2009-09-24 15:27:45Z rgasler $
 */

class Streamwide_Db_Adapter_Decorator_PositionalParamsConversion extends Streamwide_Db_Adapter_Decorator_Abstract
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

        
        // if the query doesn't have positional parameters, exit early.
        if ( false === strpos( $sql, '?' ) && !empty( $bind ) ) {
            return parent::query( $sql, $bind );
        }
        
        // replace positional parameters with named parameters
        // E.g. SELECT FROM TABLE WHERE x = ? and y = ? will be
        // transformed into SELECT FROM TABLE WHERE x = :bind_0001 and y = :bind_0002
        $this->_tmp = 0;
        $sql = preg_replace_callback( '~\?~', array( $this, '_replaceQuestionMarks' ), $sql, -1, $count );
        unset( $this->_tmp );
        
        if ( $count < 1 ) {
            return parent::query( $sql, $bind );
        }
        
        // modifiy the $bind array into an associative array
        for ( $i = 1; $i <= $count; $i++ ) {
            $keys[] = sprintf( ':bind_%04d', $i );
        }
        $bind = array_combine( $keys, array_values( $bind ) );
        
        // execute the parent method
        return parent::query( $sql, $bind );
    }
    
    /**
     * Callback function to be used with preg_replace_callback to replace question marks with
     * named parameters format (e.g ":param_0001")
     *
     * @param array $matches array of matches
     * @return string
     */
    protected function _replaceQuestionMarks( $matches )
    {
        return sprintf( ':bind_%04d', ++$this->_tmp );
    }
}

/* EOF */