<?php
/**
 * Db adapter for PDO oci.
 *
 * $Rev: 1954 $
 * $LastChangedDate: 2009-09-24 23:27:45 +0800 (Thu, 24 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Db
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Oci.php 1954 2009-09-24 15:27:45Z rgasler $
 */

require_once 'Zend/Db/Adapter/Pdo/Oci.php';

class Streamwide_Db_Adapter_Oci extends Zend_Db_Adapter_Pdo_Oci
{
    /**
     * Constructor
     *
     * @param  array|Zend_Config $config An array or instance of Zend_Config having configuration data
     * @throws Zend_Db_Adapter_Exception
     */
    public function __construct( $config = array() )
    {
        parent::__construct( $config );
    }

    /**
     * Connect to the database
     *
     * @return void
     * @throws Streamwide_Db_Adapter_Exception
     */
    protected function _connect()
    {
        if ( $this->_connection ) {
            return;
        }

        if ( ! extension_loaded( 'pdo_oci' ) ) {
            require_once( 'Streamwide/Db/Adapter/Exception.php' );
            throw new Streamwide_Db_Adapter_Exception( 'pdo_oci extension is not installed' );
        }

        parent::_connect();
    }

    /**
     * Checks if the required options have been provided into the $config array
     *
     * @param array $config array of options
     * @return void
     * @throws Streamwide_Db_Adapter_Exception
     */
    protected function _checkRequiredOptions( Array $config )
    {
        if ( ! array_key_exists( 'host', $config ) ) {
            require_once( 'Streamwide/Db/Adapter/Exception.php' );
            throw new Streamwide_Db_Adapter_Exception( "Configuration array must have a key for 'host' naming the hostname or ip of the database server for mysql or the service name for oracle" );
        }
        parent::_checkRequiredOptions( $config );
    }

    /**
     * Builds the DSN string for connection to oracle. In Streamwide products a service name is used
     * that will be provided into the 'dbname' key inside $config
     *
     * @return string
     */
    protected function _dsn()
    {
        $dsn = 'dbname=' . $this->_config['host'] . ';charset=utf8';
        return $this->_pdoType . ':' . $dsn;
    }

    /**
     * Returns the symbol the adapter uses for delimited identifiers.
     *
     * @return string
     */
    public function getQuoteIdentifierSymbol()
    {
        return "";
    }
}

/* EOF */