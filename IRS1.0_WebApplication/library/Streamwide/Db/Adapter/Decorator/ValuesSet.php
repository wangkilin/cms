<?php
/**
 * Streamwide adapter values set decorator.
 *
 * $Rev: 2457 $
 * $LastChangedDate: 2010-03-27 00:21:19 +0800 (Sat, 27 Mar 2010) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Db
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: ValuesSet.php 2457 2010-03-26 16:21:19Z rgasler $
 */

class Streamwide_Db_Adapter_Decorator_ValuesSet extends Streamwide_Db_Adapter_Decorator_Abstract
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
        
        if ( !$this->_canAddEnhancement( $sql, $bind ) ) {
            return parent::query( $sql, $bind );
        }
        
        $sqlParametersType = $this->_getSqlParametersType( $bind );
        switch ( $sqlParametersType ) {
            case 'named':
                $this->_updateSqlWithNamedParameters( $sql, $bind );
                break;
            case 'positional':
                $this->_updateSqlWithPositionalParameters( $sql, $bind );
                break;
        }
        
        return parent::query( $sql, $bind );
    }
    
    /**
     * Check if we can add the enhancement
     *
     * @param string $sql  sql statement
     * @param array  $bind sql parameters
     * @return boolean
     */
    protected function _canAddEnhancement( $sql, $bind = array() )
    {
        // no point in going further if no query parameters are provided
        if ( empty( $bind ) ) {
            return false;
        }

        $words = explode( ' ', $sql );
        list( $word ) = $words;
        // skip CREATE, DROP, TRUNCATE, ALTER queries because they don't
        // use WHERE clauses (if I'm mistaking please modify
        // the piece of code below)
        if ( in_array( strtolower( $word ), array( 'create', 'drop', 'truncate', 'alter' ) ) ) {
            return false;
        }

        return true;
    }
    
    /**
     * Attempt to determine the type of parameters used for the SQL query (named or positional)
     *
     * @param array $bind sql parameters
     * @return string
     * @throws Streamwide_Db_Adapter_Decorator_Exception
     */
    protected function _getSqlParametersType( $bind )
    {
        // move the cursor to the beginning of the array (just in case it's not there)
        reset( $bind );
        // extract the key of the first element of the array
        list( $key ) = each( $bind );
        
        if ( is_int( $key ) ) {
            // if the key of the first element is an integer, filter out all non integer keys
            $filtered = array_filter( array_keys( $bind ), array( $this, '_filterOutNonIntegers' ) );
            // if the count of the filtered elements doesn't match the count of the $bind array
            // we have invalid parameters
            if ( count( $filtered ) !== count( $bind ) ) {
                require_once 'Streamwide/Db/Adapter/Decorator/Exception.php';
                throw new Streamwide_Db_Adapter_Decorator_Exception( 'Bad SQL parameter format detected' );
            }
            // we have positional parameters
            return 'positional';
        } else {
            // if the key of the first element is a non integer, filter out all integer keys
            $filtered = array_filter( array_keys( $bind ), array( $this, '_filterOutIntegers' ) );
            // if the count of filtered elements doesn't match the count of the $bind array
            // we have invalid parameters
            if ( count( $filtered ) !== count( $bind ) ) {
                require_once 'Streamwide/Db/Adapter/Decorator/Exception.php';
                throw new Streamwide_Db_Adapter_Decorator_Exception( 'Bad SQL parameter format detected' );
            }
            // we have named parameters
            return 'named';
        }
    }
    
    /**
     * Reduce a multidimensional array to a single dimensional array
     *
     * @param array $bind sql parameters
     * @return array
     * @throws Streamwide_Db_Adapter_Decorator_Exception
     */
    protected function _flattenArray( $bind )
    {
        try {
            $tmp = array();
            foreach ( new RecursiveIteratorIterator( new RecursiveArrayIterator( $bind ) ) as $elem ) {
                $tmp[] = $elem;
            }
            return $tmp;
        }
        catch ( Exception $e ) {
            require_once 'Streamwide/Db/Adapter/Decorator/Exception.php';
            throw new Streamwide_Db_Adapter_Decorator_Exception( $e->getMessage() );
        }
    }
    
    /**
     * Modify (if the case) an SQL query that uses positional parameters.
     * E.g SELECT * FROM table WHERE id IN ( ? ) becomes SELECT * FROM table WHERE id IN ( ?, ?, ? )
     * if the the $bind array is bidimensional (for example array( 0 => array( 10, 20, 30 ) )) after
     * which $bind becomes array( 10, 20, 30 ).
     *
     * @param string &$sql  Reference to the provided sql
     * @param array  &$bind Reference to the provided sql parameters
     * @return void
     */
    protected function _updateSqlWithPositionalParameters( &$sql, &$bind )
    {
        // split the sql by the '?' character
        $sqlParts = explode( '?', $sql );
        $sqlPartsCount = count( $sqlParts );
        
        // check possible conditions that trigger the abortion of the update
        // 1. a count less than or equal to 1 means there are no "?" in the query
        // 2. a different count for the pieces than that of the $bind array
        if ( $sqlPartsCount <= 1 || ( $sqlPartsCount - 1 ) !== count( $bind ) ) {
            return null;
        }
        
        // update the sql
        $sql = '';
        foreach ( $bind as $elem ) {
            $sql .= array_shift( $sqlParts );
            $sqlPartsCount--;
            
            $placeholders = '?';
            if ( is_array( $elem ) ) {
                $placeholders = str_repeat( '?, ', count( $elem ) );
                $placeholders = substr( $placeholders, 0, -2 );
            }
            $sql .= $placeholders;
        }
        
        // check if we have any parts left
        if ( $sqlPartsCount > 0 && isset( $sqlParts[0] ) ) {
            $sql .= $sqlParts[0];
        }

        // update the $bind array
        $bind = $this->_flattenArray( $bind );
    }
    
    /**
     * Modify (if the case) an SQL query that uses named parameters
     * E.g SELECT * FROM table WHERE id IN ( :list ) becomes SELECT * FROM table WHERE id IN ( :list_0001, :list_0002, :list_0003 )
     * if $bind is bidimensional (for example array( ':list' => array( 10, 20, 30 ) )) after which $bind becomes
     * array( ':list_0001' => 10, ':list_0002' => 20, ':list_0003' => 30 )
     *
     * @param string &$sql  Reference to the provided sql
     * @param array  &$bind Reference to the provided sql parameters
     * @return void
     * @throws Streamwide_Db_Adapter_Decorator_Exception
     */
    protected function _updateSqlWithNamedParameters( &$sql, &$bind )
    {
        $bindKeys = array_keys( $bind );
        $bindValues = array_values( $bind );
        
        $counter = 0;
        foreach ( $bind as $sqlParamName => $sqlParamValue ) {
            if ( is_array( $sqlParamValue ) ) {
                $count = count( $sqlParamValue );
                if ( $count < 1 ) {
                    require_once 'Streamwide/Db/Adapter/Decorator/Exception.php';
                    throw new Streamwide_Db_Adapter_Decorator_Exception( 'Empty array detected inside provided query parameters' );
                }
                
                if ( ':' !== $sqlParamName[0] ) {
                    $sqlParamName = ":$sqlParamName";
                }
                
                $replacement = '';
                $substitutes = array();
                
                // build the replacement string
                for ( $i = 1; $i <= $count; $i++ ) {
                    // will provide something like ":sqlParamName_0001", where "sqlParamName" is the name
                    // of the current treated  sql parameter
                    $piece = sprintf( '%s_%04d', $sqlParamName, $i );
                    $substitutes[] = $piece;
                    
                    // will provide something like ":sqlParamName_0001, sqlParamName_0002, sqlParamName_0003 ..."
                    // where "sqlParamName" is the name of the current treated  sql parameter
                    $replacement .= $piece;
                    if ( $i < $count ) {
                        $replacement .= ', ';
                    }
                }
                
                // replace the current sql parameter name with the replacement string
                // will change something like SELECT * FROM table WHERE x IN ( :list ) into
                // SELECT * FROM table WHERE x IN ( :list_0001, :list_0002, :list_0003 ... )
                $sql = str_replace( $sqlParamName, $replacement, $sql );
                // update the $bind keys and values
                array_splice( $bindKeys, $counter, 1, $substitutes );
                array_splice( $bindValues, $counter, 1, $sqlParamValue );
                
                // update the counter (Mathieu Grandjean)
                $counter += $count - 1;
            }
            
            $counter++;
        }
        
        // update the $bind array
        $bind = array_combine( $bindKeys, $bindValues );
    }
    
    /**
     * Callback to be used with array_filter for filtering out non integer elements
     *
     * @param mixed $element element to filter
     * @return boolean
     */
    protected function _filterOutNonIntegers( $element )
    {
        return is_int( $element );
    }
    
    /**
     * Callback to be used with array_filter for filtering out integer elements
     *
     * @param mixed $element element to filter
     * @return boolean
     */
    protected function _filterOutIntegers( $element )
    {
        return !is_int( $element );
    }
    
}

/* EOF */