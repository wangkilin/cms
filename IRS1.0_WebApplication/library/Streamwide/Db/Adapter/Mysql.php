<?php
/**
 * Db adapter for PDO MySql.
 *
 * $Rev: 1954 $
 * $LastChangedDate: 2009-09-24 23:27:45 +0800 (Thu, 24 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Db
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Mysql.php 1954 2009-09-24 15:27:45Z rgasler $
 */

require_once 'Zend/Db/Adapter/Pdo/Mysql.php';

class Streamwide_Db_Adapter_Mysql extends Zend_Db_Adapter_Pdo_Mysql
{
    /**
     * Flag to check if some connection parameters have already been set
     *
     * @var boolean
     */
    protected $_connectionFlagsSet = false;

    /**
     * Connects to the database. This method is overridden because we need to set
     * some connection params that are not set by default, and that developers might
     * forget to set. Also addional checks are provided
     *
     * @return void
     * @throws Zend_Db_Adapter_Exception
     */
    protected function _connect()
    {
        if ( $this->_connection ) {
            return;
        }

        if ( ! extension_loaded( 'pdo_mysql' ) ) {
            require_once 'Zend/Db/Adapter/Exception.php';
            throw new Zend_Db_Adapter_Exception('pdo_mysql extension is not installed');
        }

        if ( array_key_exists( 'host', $this->_config ) ) {
            if ( strpos( $this->_config['host'], '/' ) !== false ) {
                $this->_config['unix_socket'] = $this->_config['host'];
                unset( $this->_config['host'] );
            } elseif ( strpos( $this->_config['host'], ':' ) !== false ) {
                list( $this->_config['host'], $this->_config['port'] ) = explode( ':', $this->_config['host'] );
            }
        }

        parent::_connect();

        /** @link http://bugs.mysql.com/bug.php?id=18551 */
        // dont know if we want this behaviour, check the link above
        $this->_connection->query( "SET SQL_MODE=''" );
        $this->_connection->query( "SET NAMES 'utf8'" );

        if ( ! $this->_connectionFlagsSet ) {
            $this->_connection->setAttribute( PDO::ATTR_EMULATE_PREPARES, true );
            $this->_connectionFlagsSet = true;
        }
    }

    /**
     * Checks if the required options have been provided into the $config array
     *
     * @param array $config configuration options
     * @return void
     * @throws Streamwide_Db_Adapter_Exception
     */
    protected function _checkRequiredOptions( Array $config )
    {
        if ( ! array_key_exists( 'host', $config ) ) {
            require_once 'Zend/Db/Adapter/Exception.php';
            throw new Zend_Db_Adapter_Exception( "Configuration array must have a key for 'host' naming the hostname or ip of the database server" );
        }
        parent::_checkRequiredOptions( $config );
    }

    /**
     * Destructor. Disconnects from database (called when $dbConn object is nulled ex. $dbConn = null;)
     */
    public function __destruct()
    {
        $this->_connection = null;
    }
}

/* EOF */