<?php
/**
 * Db adapter for Oracle.
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

require_once 'Zend/Db/Adapter/Oracle';

class Streamwide_Db_Adapter_Oracle extends Zend_Db_Adapter_Oracle
{
    
    /**
     * User-provided configuration.
     *
     * Basic keys are:
     *
     * username => (string) Connect to the database as this username.
     * password => (string) Password associated with the username.
     * dbname   => (string) The oracle service name
     * host     => (string) The IP address of the machine on which Oracle runs
     * @var array
     */
    protected $_config = array(
        'dbname'       => null,
        'username'     => null,
        'password'     => null,
        'host'         => null
    );
    
    /**
     * Default class name for a DB statement.
     *
     * @var string
     */
    protected $_defaultStmtClass = 'Streamwide_Db_Statement_Oracle';
    
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
        if ( is_array( $bind ) ) {
            foreach ( $bind as $name => $value ) {
                if ( !is_int( $name ) && ':' !== $name[0] ) {
                    $newName = ":$name";
                    unset( $bind[$name] );
                    $bind[$newName] = $value;
                }
            }
        }
        return parent::query( $sql, $bind );
    }
    
    /**
     * Check for config options that are mandatory.
     * Throw exceptions if any are missing.
     *
     * @param array $config array of config options
     * @throws Zend_Db_Adapter_Exception
     * @return void
     */
    protected function _checkRequiredOptions( Array $config )
    {
        if ( ! array_key_exists( 'host', $config ) ) {
            require_once 'Zend/Db/Adapter/Oracle/Exception.php';
            throw new Zend_Db_Adapter_Oracle_Exception( "Configuration array must have a key for 'host' naming the hostname or ip of the database server" );
        }
        parent::_checkRequiredOptions( $config );
    }
    
    /**
     * Creates a connection to the database.
     *
     * @return void
     */
    protected function _connect()
    {
        if ( is_resource( $this->_connection ) ) {
            // connection already exists
            return;
        }

        if ( !extension_loaded( 'oci8' ) ) {
            /**
             * @see Zend_Db_Adapter_Oracle_Exception
             */
            require_once 'Zend/Db/Adapter/Oracle/Exception.php';
            throw new Zend_Db_Adapter_Oracle_Exception( 'The OCI8 extension is required for this adapter but the extension is not loaded' );
        }

        $tnsAdmin = getenv( 'TNS_ADMIN' );
        if ( !empty( $tnsAdmin ) ) {
            $this->_connection = oci_connect(
                $this->_config['username'],
                $this->_config['password'],
                $this->_config['dbname'],
                'utf8'
            );
        } else {
            $this->_connection = oci_connect(
                $this->_config['username'],
                $this->_config['password'],
                $this->_config['host'] . '/' . $this->_config['dbname'],
                'utf8'
            );
        }

        // check the connection
        if ( !$this->_connection ) {
            /**
             * @see Zend_Db_Adapter_Oracle_Exception
             */
            require_once 'Zend/Db/Adapter/Oracle/Exception.php';
            throw new Zend_Db_Adapter_Oracle_Exception( oci_error() );
        }
    }
}

/* EOF */