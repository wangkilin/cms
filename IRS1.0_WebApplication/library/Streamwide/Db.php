<?php
/**
 * Streamwide Db adapter factory class.
 *
 * $Rev: 1981 $
 * $LastChangedDate: 2009-09-28 19:07:50 +0800 (Mon, 28 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Db
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Db.php 1981 2009-09-28 11:07:50Z rgasler $
 */

/*
 * Needed because all class constants used by the adapters are setup in here.
 *
 * @see Zend_Db
 */
require_once 'Zend/Db.php';

class Streamwide_Db
{
    /**
     * @var string The adapter string (mysql or oracle)
     */
    protected $_adapter;

    /**
     * Allowed adapter strings
     *
     * @var array
     */
    protected $_allowedAdapters = array( 'mysql', 'oracle' );

    /**
     * The connection configuration array
     *
     * @var array
     */
    protected $_config = array();

    /**
     * Constructor. Made private to prevent instantiation.
     *
     * @param string $adapter The adapter string (mysql or oracle)
     * @param array  $config  (optional) The connection configuration array
     */
    private function __construct( $adapter, $config = array() )
    {
        $this->_adapter = $adapter;
        $this->_config = $config;
    }

    /**
     * Factory method. Builds a connection object and returns it.
     *
     * @param string            $adapter The adapter string (mysql or oracle)
     * @param Zend_Config|array $config  (optional) The connection configuration array
     * @return Zend_Db_Abstract The database connection object.
     */
    public static function factory( $adapter, $config = array() )
    {
        $self = new self( $adapter, $config );
        return $self->_constructAdapter();
    }

    /**
     * Get the adapter name and the configuration array from a Zend_Config object
     *
     * @return void
     */
    protected function _initFromZendConfig()
    {
        /*
         * Convert Zend_Config argument to plain string
         * adapter name and separate config object.
         */
        if ( $this->_adapter instanceof Zend_Config ) {
            if ( isset( $this->_adapter->params ) ) {
                $this->_config = $this->_adapter->params->toArray();
            }
            if ( isset( $this->_adapter->adapter ) ) {
                $this->_adapter = (string)$this->_adapter->adapter;
            } else {
                $this->_adapter = null;
            }
        }
    }

    /**
     * Validates the provided connection configuration parameters
     *
     * @return void
     */
    protected function _validateConfiguration()
    {
        $this->_adapter = strtolower( $this->_adapter );
        $this->_ensure( is_array( $this->_config ), 'Adapter parameters must be specified in an array or a Zend_Config object' );
        $this->_ensure( is_string( $this->_adapter ) && ! empty( $this->_adapter ), 'Adapter name must be specified in a string' );
        $this->_ensure( in_array( $this->_adapter, $this->_allowedAdapters ), 'Allowed adapters are "' . implode( '", "', $this->_allowedAdapters ) . '", "' . $this->_adapter . '"  given' );
    }

    /**
     * Creates the database connection object
     *
     * @return Zend_Db_Adapter_Abstract The database connection object.
     */
    protected function _constructAdapter()
    {
        $this->_initFromZendConfig();
        $this->_validateConfiguration();

        $base = 'Streamwide_Db_Adapter';
        $adapter = $this->_adapter;
        $class = $base . '_' . ucfirst( $adapter );

        Zend_Loader::loadClass( $class );
        $dbAdapter = new $class( $this->_config );
        $this->_ensure( $dbAdapter instanceof Zend_Db_Adapter_Abstract, 'Adapter class "' . $class . '" does not extend Zend_Db_Adapter_Abstract' );

        switch ( $adapter ) {
            case 'mysql':
                $dbAdapter = new Streamwide_Db_Adapter_Decorator_ValuesSet( $dbAdapter );
                break;
                
            case 'oracle':
                $dbAdapter = new Streamwide_Db_Adapter_Decorator_Insert( // add insert queries enhancements
                    new Streamwide_Db_Adapter_Decorator_ValuesSet( // add enhancements for sql functions that require sets of values
                        new Streamwide_Db_Adapter_Decorator_PositionalParamsConversion( // add conversion for positional parameters
                            new Streamwide_Db_Adapter_Decorator_LastInsertId( // add last insert id enhancement
                                $dbAdapter
                            )
                        )
                    )
                );
                break;
                
            default:
                // do nothing;
                break;
        }

        return $dbAdapter;
    }


    /**
     * Convenience method. Verifies if $assertion is true an throws an exception with $message
     *
     * @param boolean $assertion Assertion to check.
     * @param string  $message   Message to add to the exception.
     * @return void
	 * @throws Zend_Db_Exception when assertion is false
     */
    protected function _ensure( $assertion, $message )
    {
        if ( false === $assertion ) {
            require_once 'Zend/Db/Exception.php';
            throw new Zend_Db_Exception( $message );
        }
    }
}

/* EOF */