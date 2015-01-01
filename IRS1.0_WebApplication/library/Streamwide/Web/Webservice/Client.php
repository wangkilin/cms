<?php
/**
 * $Rev: 2664 $
 * $LastChangedDate: 2010-06-13 21:26:19 +0800 (Sun, 13 Jun 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Web_Webservice
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Client.php 2664 2010-06-13 13:26:19Z kwu $
 */

/**
 * An XML-RPC client implementation
 *
 * extend (@link Zend_XmlRpc_Client) and implement (@link Streamwide_Web_Model_Interface)
 */
class Streamwide_Web_Webservice_Client extends Zend_XmlRpc_Client
                                       implements Streamwide_Web_Model_Interface
{
    /**
     * configuration on this client instance
     *
     * var array
     */
    private $_options = array();

    /**
     * Create a new XML-RPC client to a remote server
     *
     * @param  string $server                     Full address of the WebService
     *                                            (e.g. http://www.streamwide.com/xmlrpc.php)
     * @param  array|Zend_Config|mixed $options   configuration on this client instance
     * @param  Zend_Http_Client $httpClient       HTTP Client to use for requests
     *
     * @return void
     */
    public function __construct($server, $options = null, Zend_Http_Client $httpClient = null)
    {
        parent::__construct($server,$httpClient);

        if (null !== $options) {
            if (is_string($options)) {
                $options = $this->_loadConfig($options);
            } elseif ($options instanceof Zend_Config) {
                $options = $options->toArray();
            } elseif (!is_array($options)) {
                throw new Streamwide_Exception('Invalid options provided; must be location of config file, a config object, or an array');
            }
            $this->_options = $options;
            if (isset($this->_options['auth']) && is_array($this->_options['auth'])) {
                $this->setAuth($this->_options['auth']);
            }
            if (isset($this->_options['introspection']) && is_array($this->_options['introspection'])) {
                $introspector = new Streamwide_Web_Webservice_Introspection_Ini($this,$this->_options['introspection']); 
                $this->setIntrospector($introspector);
            }
        }
        $this->setSkipSystemLookup();
    }

    /**
     * Wrap on (@link Zend_Http_Client::setAuth()
     * Set HTTP authentication parameters, and stored in this instance
     *
     * @param array $auth  The authentication information.
     *
     * @return void
     */
    public function setAuth(array $auth)
    {
        $this->_options['auth'] = $auth;
        $this->_httpClient->setAuth($this->_options['auth']['user'],$this->_options['auth']['password']);
    }

    /**
     * To get the authentication parameters
     *
     * @return array|null getting an array like while initiliazed the auth options
     */
    public function getAuth()
    {
        return isset($this->_options['auth']) ? $this->_options['auth'] : null;
    }

    /**
     * Override (@link Zend_XmlRpc_Client::call())
     *
     * Send an XML-RPC request to the service (for a specific method),
     * before transfer the data via Zend_Http_Client,
     * convert the params to the right type (@see _convert())
     *
     * @param  string $method Name of the method we want to call
     * @param  array $params Array of parameters for the method
     *
     * @return mixed
     * @throws Zend_XmlRpc_Client_FaultException
     */
    public function call($method, array $params = array())
    {
        //Verify against introspection (method = 'Foo.Bar')
        $signature = $this->getIntrospector()->getMethodSignature($method);
        if (is_array($signature)) {
            $params = $this->_convert($params,$signature);
        }

        $request = new Streamwide_Web_Webservice_Request($method,$params);
        $response = new Streamwide_Web_Webservice_Response();
        $this->doRequest($request,$response);

        if ($this->_lastResponse->isFault()) {
            $fault = $this->_lastResponse->getFault();
            /**
             * Exception thrown when an XML-RPC fault is returned
             * @see Zend_XmlRpc_Client_FaultException
             */
            throw new Zend_XmlRpc_Client_FaultException($fault->getMessage(),
                                                        $fault->getCode());
        }
        return $this->_lastResponse->getReturnValue();
    }

    /**
     * To convert the parameters with the provided signature types
     *
     * example <code>
     * $params = array(
     *         0 => '1',
     *         1 => array('0','1','10','3'),
     *         2 => array(
     *                 'key1' => '1',
     *                 'key2' => 'a',
     *                 'key3' => '5',
     *                 'key4' => array('x','y','z'),
     *                 'key5' => array(
     *                              'sub1' => '1',
     *                              'sub2' => 'b',
     *                              'sub3' => array('2')
     *                           )
     *              ),
     *         3 => '9',
     *         4 => array('99','22'),
     *         5 => array(array('a'=>'1','b'=>array('x','y')),array('a'=>'4','b'=>array('m','n')))
     *      );
     * 
     * $signiture = array(
     *         0 => 'int',
     *         1 => array('int'),
     *         2 => array(
     *                 'key1' => 'int',
     *                 'key2' => 'string',
     *                 'key3' => 'int',
     *                 'key4' => array('string'),
     *                 'key5' => array(
     *                              'sub1' => 'int',
     *                              'sub2' => 'string',
     *                              'sub3' => array('int')
     *                           )
     *              ),
     *         3 => 'int',
     *         4 => array('int'),
     *         5 => array(array('a'=>'int','b'=>array('string')))
     *      );
     * </code>
     * The above signature defination can be writen in an ini file with formatting 
     * <code>
     * method.0 = 'int'
     * method.1.0 = 'int'
     * method.2.key1 = 'int'
     * method.2.key2 = 'string'
     * method.2.key3 = 'int'
     * method.2.key4.0 = 'string'
     * method.2.key5.sub1 = 'int'
     * method.2.key5.sub2 = 'string'
     * method.2.key5.sub3.0 = 'int'
     * method.3 = 'int'
     * method.4.0 = 'int'
     * method.5.0.a = 'int'
     * method.5.0.b.0 = 'string'
     * </code>
     *
     * @param  array $params    The parameter we want to convert
     * @param  array $signiture The signature definations
     *
     * @return mixed
     */
    protected function _convert(array $params, array $signiture)
    {
        static $lastScalarType = null;
        static $lastComplexType = null;

        foreach ($params as $key => &$value) {
            $type = $signiture[$key];
            if (is_array($type)) {
                $value = $this->_convert($params[$key], $type);
                $lastComplexType = $type;
            } else {
                if (is_array($value) && !is_null($lastComplexType)) {
                    $value = $this->_convert($params[$key], $lastComplexType);
                } else {
                    if (is_null($type) && !is_null($lastScalarType)) {
                        $type = $lastScalarType;
                    }
                    $value = $type == 'int' && is_string($value) ? (int) $value : $value; //to extend with more types
                    $lastScalarType = $type;
                }
            }
        }
        return $params;
    }

    /**
     * Load the signature configuration.
     *
     * @param  string $file The path of the signature configuration file.
     *
     * @return array
     * @throws Streamwide_Exception
     */
    protected function _loadConfig($file)
    {
        $environment = APPLICATION_ENV;
        $suffix      = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        switch ($suffix) {
            case 'ini':
                $config = new Zend_Config_Ini($file, $environment);
                break;

            case 'xml':
                $config = new Zend_Config_Xml($file, $environment);
                break;

            case 'php':
            case 'inc':
                $config = include $file;
                if (!is_array($config)) {
                    throw new Streamwide_Exception('Invalid configuration file provided; PHP file does not return array value');
                }
                return $config;
                break;

            default:
                throw new Streamwide_Exception('Invalid configuration file provided; unknown config type');
        }

        return $config->toArray();
    }
}

/* EOF */
