<?php
/**
 * Abstract db adapter decorator.
 *
 * $Rev: 1954 $
 * $LastChangedDate: 2009-09-24 23:27:45 +0800 (Thu, 24 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Db
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Abstract.php 1954 2009-09-24 15:27:45Z rgasler $
 */

abstract class Streamwide_Db_Adapter_Decorator_Abstract extends Zend_Db_Adapter_Abstract
{
    /**
     * The wrapped adapter
     *
     * @var Zend_Db_Adapter_Abstract|Streamwide_Db_Adapter_Decorator_Abstract
     */
    protected $_adapter;
    
    /**
     * Constructor
     *
     * @param Zend_Db_Adapter_Abstract $adapter db adapter object
     */
    public function __construct( Zend_Db_Adapter_Abstract $adapter )
    {
        $this->_adapter = $adapter;
    }
    
    /**
     * Returns the underlying database connection object or resource.
     * If not presently connected, this initiates the connection.
     *
     * @return object|resource|null
     */
    public function getConnection()
    {
        return $this->_adapter->getConnection();
    }
    
    /**
     * Returns the configuration variables in this adapter.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->_adapter->getConfig();
    }
    
    /**
     * Set the adapter's profiler object.
     *
     * The argument may be a boolean, an associative array, an instance of
     * Zend_Db_Profiler, or an instance of Zend_Config.
     *
     * A boolean argument sets the profiler to enabled if true, or disabled if
     * false.  The profiler class is the adapter's default profiler class,
     * Zend_Db_Profiler.
     *
     * An instance of Zend_Db_Profiler sets the adapter's instance to that
     * object.  The profiler is enabled and disabled separately.
     *
     * An associative array argument may contain any of the keys 'enabled',
     * 'class', and 'instance'. The 'enabled' and 'instance' keys correspond to the
     * boolean and object types documented above. The 'class' key is used to name a
     * class to use for a custom profiler. The class must be Zend_Db_Profiler or a
     * subclass. The class is instantiated with no constructor arguments. The 'class'
     * option is ignored when the 'instance' option is supplied.
     *
     * An object of type Zend_Config may contain the properties 'enabled', 'class', and
     * 'instance', just as if an associative array had been passed instead.
     *
     * @param Zend_Db_Profiler|Zend_Config|array|boolean $profiler db profiler
     * @return Zend_Db_Adapter_Abstract Provides a fluent interface
     * @throws Zend_Db_Profiler_Exception if the object instance or class specified
     *         is not Zend_Db_Profiler or an extension of that class.
     */
    public function setProfiler( $profiler )
    {
        return $this->_adapter->setProfiler( $profiler );
    }

    /**
     * Returns the profiler for this adapter.
     *
     * @return Zend_Db_Profiler
     */
    public function getProfiler()
    {
        return $this->_adapter->getProfiler();
    }
    
    /**
     * Get the default statement class.
     *
     * @return string
     */
    public function getStatementClass()
    {
        return $this->_adapter->getStatementClass();
    }

    /**
     * Set the default class name for a DB statement.
     *
     * @param string $class the class name
     * @return Zend_Db_Adapter_Abstract Fluent interface
     */
    public function setStatementClass( $class )
    {
        return $this->_adapter->setStatementClass( $class );
    }

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
        return $this->_adapter->query( $sql, $bind );
    }

    /**
     * Begin a transaction.
     *
     * @return Zend_Db_Adapter_Abstract
     */
    public function beginTransaction()
    {
        return $this->_adapter->beginTransaction();
    }
    
    /**
     * Commit a transaction and return to autocommit mode.
     *
     * @return Zend_Db_Adapter_Abstract
     */
    public function commit()
    {
        return $this->_adapter->commit();
    }
    
    /**
     * Roll back a transaction and return to autocommit mode.
     *
     * @return Zend_Db_Adapter_Abstract
     */
    public function rollBack()
    {
        return $this->_adapter->rollBack();
    }
    
    /**
     * Get the fetch mode.
     *
     * @return int
     */
    public function getFetchMode()
    {
        return $this->_adapter->getFetchMode();
    }
    
    /**
     * Following methods must not be declared because they use the query() method.
     *
     * public function insert( $table, array $bind ) {}
     *
     * public function update( $table, array $bind, $where = '' ) {}
     *
     * public function delete( $table, $where = '' ) {}
     *
     * public function select() {}
     *
     * public function fetchAll( $sql, $bind = array(), $fetchMode = null ) {}
     *
     * public function fetchRow( $sql, $bind = array(), $fetchMode = null ) {}
     *
     * public function fetchAssoc( $sql, $bind = array() ) {}
     *
     * public function fetchCol( $sql, $bind = array() ) {}
     *
     * public function fetchPairs( $sql, $bind = array() ) {}
     *
     * public function fetchOne( $sql, $bind = array() ) {}
     *
     */
    
    /**
     * Safely quotes a value for an SQL statement.
     *
     * If an array is passed as the value, the array values are quoted
     * and then returned as a comma-separated string.
     *
     * @param mixed $value The value to quote.
     * @param mixed $type  (optional) the SQL datatype name, or constant, or null.
     * @return mixed An SQL-safe quoted value (or string of separated values).
     */
    public function quote( $value, $type = null )
    {
        return $this->_adapter->quote( $value, $type );
    }
    
    /**
     * Quotes a value and places into a piece of text at a placeholder.
     *
     * The placeholder is a question-mark; all placeholders will be replaced
     * with the quoted value.   For example:
     *
     * <code>
     * $text = "WHERE date < ?";
     * $date = "2005-01-02";
     * $safe = $sql->quoteInto($text, $date);
     * // $safe = "WHERE date < '2005-01-02'"
     * </code>
     *
     * @param string  $text  The text with a placeholder.
     * @param mixed   $value The value to quote.
     * @param string  $type  (optional) SQL datatype
     * @param integer $count (optional) count of placeholders to replace
     * @return string An SQL-safe quoted value placed into the original text.
     */
    public function quoteInto( $text, $value, $type = null, $count = null )
    {
        return $this->_adapter->quoteInto( $text, $value, $type, $count );
    }
    
    /**
     * Quotes an identifier.
     *
     * Accepts a string representing a qualified indentifier. For Example:
     * <code>
     * $adapter->quoteIdentifier('myschema.mytable')
     * </code>
     * Returns: "myschema"."mytable"
     *
     * Or, an array of one or more identifiers that may form a qualified identifier:
     * <code>
     * $adapter->quoteIdentifier(array('myschema','my.table'))
     * </code>
     * Returns: "myschema"."my.table"
     *
     * The actual quote character surrounding the identifiers may vary depending on
     * the adapter.
     *
     * @param string|array|Zend_Db_Expr $ident The identifier.
     * @param boolean                   $auto  (optional) If true, heed the AUTO_QUOTE_IDENTIFIERS config option.
     * @return string The quoted identifier.
     */
    public function quoteIdentifier( $ident, $auto = false )
    {
        return $this->_adapter->quoteIdentifier( $ident, $auto );
    }

    /**
     * Quote a column identifier and alias.
     *
     * @param string|array|Zend_Db_Expr $ident The identifier or expression.
     * @param string                    $alias An alias for the column.
     * @param boolean                   $auto  (optional) If true, heed the AUTO_QUOTE_IDENTIFIERS config option.
     * @return string The quoted identifier and alias.
     */
    public function quoteColumnAs( $ident, $alias, $auto = false )
    {
        return $this->_adapter->quoteColumnAs( $ident, $alias, $auto );
    }

    /**
     * Quote a table identifier and alias.
     *
     * @param string|array|Zend_Db_Expr $ident The identifier or expression.
     * @param string                    $alias An alias for the table.
     * @param boolean                   $auto  (optional) If true, heed the AUTO_QUOTE_IDENTIFIERS config option.
     * @return string The quoted identifier and alias.
     */
    public function quoteTableAs( $ident, $alias = null, $auto = false )
    {
        return $this->_adapter->quoteTableAs( $ident, $alias, $auto );
    }

    /**
     * Returns the symbol the adapter uses for delimited identifiers.
     *
     * @return string
     */
    public function getQuoteIdentifierSymbol()
    {
        return $this->_adapter->getQuoteIdentifierSymbol();
    }

    /**
     * Return the most recent value from the specified sequence in the database.
     * This is supported only on RDBMS brands that support sequences
     * (e.g. Oracle, PostgreSQL, DB2).  Other RDBMS brands return null.
     *
     * @param string $sequenceName sequence name
     * @return string
     */
    public function lastSequenceId( $sequenceName )
    {
        return $this->_adapter->lastSequenceId( $sequenceName );
    }

    /**
     * Generate a new value from the specified sequence in the database, and return it.
     * This is supported only on RDBMS brands that support sequences
     * (e.g. Oracle, PostgreSQL, DB2).  Other RDBMS brands return null.
     *
     * @param string $sequenceName sequence name
     * @return string
     */
    public function nextSequenceId( $sequenceName )
    {
        return $this->_adapter->nextSequenceId( $sequenceName );
    }

    /**
     * Helper method to change the case of the strings used
     * when returning result sets in FETCH_ASSOC and FETCH_BOTH
     * modes.
     *
     * This is not intended to be used by application code,
     * but the method must be public so the Statement class
     * can invoke it.
     *
     * @param string $key key string
     * @return string
     */
    public function foldCase( $key )
    {
        return $this->_adapter->foldCase( $key );
    }

    /**
     * Returns a list of the tables in the database.
     *
     * @return array
     */
    public function listTables()
    {
        return $this->_adapter->listTables();
    }

    /**
     * Returns the column descriptions for a table.
     *
     * The return value is an associative array keyed by the column name,
     * as returned by the RDBMS.
     *
     * The value of each array element is an associative array
     * with the following keys:
     *
     * SCHEMA_NAME => string; name of database or schema
     * TABLE_NAME  => string;
     * COLUMN_NAME => string; column name
     * COLUMN_POSITION => number; ordinal position of column in table
     * DATA_TYPE   => string; SQL datatype name of column
     * DEFAULT     => string; default expression of column, null if none
     * NULLABLE    => boolean; true if column can have nulls
     * LENGTH      => number; length of CHAR/VARCHAR
     * SCALE       => number; scale of NUMERIC/DECIMAL
     * PRECISION   => number; precision of NUMERIC/DECIMAL
     * UNSIGNED    => boolean; unsigned property of an integer type
     * PRIMARY     => boolean; true if column is part of the primary key
     * PRIMARY_POSITION => integer; position of column in primary key
     *
     * @param string $tableName  table name
     * @param string $schemaName (optional) schema name
     * @return array
     */
    public function describeTable( $tableName, $schemaName = null )
    {
        return $this->_adapter->describeTable( $tableName, $schemaName );
    }

    /**
     * Test if a connection is active
     *
     * @return boolean
     */
    public function isConnected()
    {
        return $this->_adapter->isConnected();
    }

    /**
     * Force the connection to close.
     *
     * @return void
     */
    public function closeConnection()
    {
        return $this->_adapter->closeConnection();
    }

    /**
     * Prepare a statement and return a PDOStatement-like object.
     *
     * @param string|Zend_Db_Select $sql SQL query
     * @return Zend_Db_Statement|PDOStatement
     */
    public function prepare( $sql )
    {
        return $this->_adapter->prepare( $sql );
    }

    /**
     * Gets the last ID generated automatically by an IDENTITY/AUTOINCREMENT column.
     *
     * As a convention, on RDBMS brands that support sequences
     * (e.g. Oracle, PostgreSQL, DB2), this method forms the name of a sequence
     * from the arguments and returns the last id generated by that sequence.
     * On RDBMS brands that support IDENTITY/AUTOINCREMENT columns, this method
     * returns the last value generated for such a column, and the table name
     * argument is disregarded.
     *
     * @param string $tableName  (optional) Name of table.
     * @param string $primaryKey (optional) Name of primary key column.
     * @return string
     */
    public function lastInsertId( $tableName = null, $primaryKey = null )
    {
        return $this->_adapter->lastInsertId( $tableName, $primaryKey );
    }

    /**
     * Set the fetch mode.
     *
     * @param integer $mode fetch mode
     * @return void
     * @throws Zend_Db_Adapter_Exception
     */
    public function setFetchMode( $mode )
    {
        return $this->_adapter->setFetchMode( $mode );
    }

    /**
     * Adds an adapter-specific LIMIT clause to the SELECT statement.
     *
     * @param mixed   $sql    sql clause
     * @param integer $count  count
     * @param integer $offset offset
     * @return string
     */
    public function limit( $sql, $count, $offset = 0 )
    {
        return $this->_adapter->limit( $sql, $count, $offset );
    }

    /**
     * Check if the adapter supports real SQL parameters.
     *
     * @param string $type 'positional' or 'named'
     * @return bool
     */
    public function supportsParameters( $type )
    {
        return $this->_adapter->supportsParameters( $type );
    }

    /**
     * Retrieve server version in PHP style
     *
     * @return string
     */
    public function getServerVersion()
    {
        return $this->_adapter->getServerVersion();
    }
    
    /**
     * Route all non-existent calls to the wrapped object
     *
     * @param string $method method name
     * @param array  $args   arguments
     * @return mixed
     */
    public function __call( $method, $args )
    {
        return call_user_func_array( array( $this->_adapter, $method ), $args );
    }
    
    /**
     * Constructs a sequence name based on a table name
     *
     * @param string $tableName table name
     * @return string
     * @throws Streamwide_Db_Adapter_Decorator_Exception
     */
    protected function _getSequenceName( $tableName )
    {
        $config = $this->_adapter->getConfig();
        
        if ( !is_array( $config ) ) {
            require_once 'Streamwide/Db/Adapter/Decorator/Exception.php';
            throw new Streamwide_Db_Adapter_Decorator_Exception( 'Retrieved an invalid adapter configuration format' );
        }
        
        if ( !isset( $config['options']['sequenceGetter'] ) ) {
            return false;
        }
        
        $sequenceGetter = Streamwide_Db_SequenceGetter::factory( $config['options']['sequenceGetter'] );
        if ( false === ( $sequenceName = $sequenceGetter->getSequenceName( $tableName ) ) ) {
            return false;
        }

        return $sequenceName;
    }
    
    
    /**
     * Needed because it is declared abstract in Zend_Db_Adapter_Abstract
     *
     * Creates a connection to the database.
     *
     * @return void
     */
    protected function _connect()
    {
    }
    
    /**
     * Needed because it is declared abstract in Zend_Db_Adapter_Abstract
     *
     * Begin a transaction.
     *
     * @return void
     */
    protected function _beginTransaction()
    {
    }

    /**
     * Needed because it is declared abstract in Zend_Db_Adapter_Abstract
     *
     * Commit a transaction.
     *
     * @return void
     */
    protected function _commit()
    {
    }
    
    /**
     * Needed because it is declared abstract in Zend_Db_Adapter_Abstract
     *
     * Roll-back a transaction.
     *
     * @return void
     */
    protected function _rollBack()
    {
    }
}

/* EOF */