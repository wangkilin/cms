<?php
/**
 * WebService Server class.
 *
 *
 * $Rev: 2087 $
 * $LastChangedDate: 2009-10-30 19:23:37 +0800 (Fri, 30 Oct 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_WebService
 * @subpackage Streamwide_WebService_Server
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Exception.php 1953 2009-09-24 14:02:35Z rgasler $
 */

/**
 * WebService Server class.
 *
 * Can be used as a layer over the StreamWIDE WebServices
 * extension to create a web services Server.
 */
class Streamwide_WebService_Server
{
    /**
     * the extension server handle
     *
     * @var resource
     */
    private $_serverHandle = null;

    /**
     * this holds the request
     *
     * @var string
     */
    private $_request = null;

    /**
     * this holds the response
     *
     * @var string|mixed
     */
    private $_response = null;

    /**
     * an array holding the methods registered on the service
     * e.g. [ methodName1 => functionName1, methodName2 => functionName2, ... ]
     *
     * @var array
     */
    private $_methodsRegistered = array();

    /**
     * true if introspection data has been added, false if not
     *
     * @var boolean
     */
    private $_introspectionDataAdded = false;

    /**
     * the extension name
     *
     * @var string
     */
    private $_wsExtensionName = 'WebServices';

    /**
     * the extension filename
     *
     * @var string
     */
    private $_wsExtensionFileName = 'webservices.so';


    /**
     * Constructor
     *
     * @param array   $methodsData       Array of { methodName => functionName, ... }
     * @param array   $introspectionData Instrospection data array
     * @param boolean $runService        If true starts the service
     * @param array   $outputOptions     Used to set ecoding and other options
     * @throws Streamwide_WebService_Exception when WebService extension cannot be loaded
     */
    public function __construct(array $methodsData = null, array $introspectionData = null, $runService = false, array $outputOptions = null)
    {
        if (!extension_loaded($this->_wsExtensionName)) {
            if (!dl($this->_wsExtensionFileName)) {
                // extension cannot be loaded
                require_once 'Streamwide/WebService/Exception.php';
                throw new Streamwide_WebService_Exception($this->_wsExtensionName .'('. $this->_wsExtensionFileName .') extension cannot be loaded');
            }
        }

        // This creates a server and sets the handle
        $this->_serverHandle = rpc_server_create();

        if (isset($_SERVER['CONTENT_TYPE']) && !headers_sent()) {
            header("Content-Type: " . $_SERVER['CONTENT_TYPE']);
        }

        if (isset($methodsData)) {
            $this->registerMethods($methodsData);
        }
        if (isset($introspectionData)) {
            $this->addIntrospectionData($introspectionData);
        }
        if ($runService) {
            $this->run($outputOptions);
        }
    }

    /**
     * Registers a PHP function as a WebService method
     *
     * @param string $methodName   Method name on the service
     * @param string $functionName Function name to register
     * @return void
     * @throws Streamwide_WebService_Exception when $methodName or $functionName are not strings
     */
    public function registerMethod($methodName, $functionName)
    {
        if (!is_string($functionName) || !is_string($methodName)) {
            require_once 'Streamwide/WebService/Exception.php';
            throw new Streamwide_WebService_Exception("Parameters of registerMethod must be strings");
        }

        rpc_server_register_method($this->_serverHandle, $methodName, $functionName);

        // just to keep track of the methods registered
        $this->_methodsRegistered[$methodName] = $functionName;
    }

    /**
     * Registers an array of methods on the service
     *
     * @param array $methodsData Array of { methodName => functionName, ... }
     * @return void
     */
    public function registerMethods(array $methodsData)
    {
        foreach ($methodsData as $methodName => $functionName) {
            $this->registerMethod($methodName, $functionName);
        }
    }

    /**
     * Adds the introspection data array to the extension
     *
     * @param array $introspectionData Instrospection data array
     * @return void
     * @throws Streamwide_WebService_Exception when introspection data has already been added
    */
    public function addIntrospectionData(array $introspectionData)
    {
        // if introspection data isn't added & $introspectionData defined
        // then we add it to the extension
        if ($this->_introspectionDataAdded === false && !empty($introspectionData)) {
            // this can be called only one time during a session;
            // a second call is ignored by the extension
            rpc_server_add_introspection_data($this->_serverHandle, $introspectionData);
            $this->_introspectionDataAdded = true;
        } else {
            require_once 'Streamwide/WebService/Exception.php';
            throw new Streamwide_WebService_Exception("IntrospectionData already added.");
        }

        return;
    }

    /**
     * Register a PHP function to generate introspection
     *
     * @param string $introspectionFunction Instrospection generator function name
     * @return void
     * @throws Streamwide_WebService_Exception when introspection data has already been added
     */
    public function addIntrospectionCallback($introspectionFunction)
    {
        // if introspection data isn't added & $introspectionFunction defined
        // then we add it to the extension
        if ($this->_introspectionDataAdded === false && !empty($introspectionFunction)) {
            // this can be called only one time during a session;
            // a second call is ignored by the extension
            rpc_server_register_introspection_callback($this->_serverHandle, $introspectionFunction);
            $this->_introspectionDataAdded = true;
        } else {
            require_once 'Streamwide/WebService/Exception.php';
            throw new Streamwide_WebService_Exception("IntrospectionData already added.");
        }

        return;
    }
    
    /**
     * Gets the response from $HTTP_RAW_POST_DATA and returns it
     *
     * @return string Request
     */
    private static function _getRequestFromPOST()
    {
        if (!isset($GLOBALS['HTTP_RAW_POST_DATA'])) {
            $request = '';
        } else {
            $request = $GLOBALS['HTTP_RAW_POST_DATA'];
        }
        
        return $request;
    }

    /**
     * Calls the method from request
     *
     * Available options:
     * 'output_type' => {WS_PHP|WS_ENCODED}
     * 'verbosity'   => {no_white_space|newlines_only|pretty}
     * 'escaping'    => {cdata|non-ascii|non-print|markup}
     * 'encoding'    => {iso-8859-1|utf-8}
     *
     * @param array $outputOptions Associative array used to set encoding and other options
     * @return string|mixed Response depending on the value of output_type (default = WS_ENCODED)
     */
    public function call(array $outputOptions = null)
    {
        $this->_response = rpc_server_call_method($this->_serverHandle, $this->_request, '', $outputOptions);

        return $this->_response;
    }

    /**
     * Starts the WebService
     *
     * Available options:
     * 'output_type' => {WS_PHP|WS_ENCODED}
     * 'verbosity'   => {no_white_space|newlines_only|pretty}
     * 'escaping'    => {cdata|non-ascii|non-print|markup}
     * 'encoding'    => {iso-8859-1|utf-8}
     *
     * @param array $outputOptions Associative array used to set encoding and other options
     * @return string|mixed Response depending on the value of output_type (default = WS_ENCODED)
     */
    public function run(array $outputOptions = null)
    {
        $this->getRequest();

        $this->call($outputOptions);

        return $this->_response;
    }

    /**
     * Gets the server handle (useful for debugging)
     *
     * @return resource Handle of the server
     */
    public function getServerHandle()
    {
        return $this->_serverHandle;
    }

    /**
     * Gets the method response
     *
     * @return string Response
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * Gets the method request (useful for debugging)
     *
     * @return string Request
     */
    public function getRequest()
    {
        if (is_null($this->_request)) {
            $this->_request = self::_getRequestFromPOST();
        }
        
        return $this->_request;
    }

    /**
     * Sets the request from parameter instead of POST (useful for debugging)
     *
     * @param string $request The request to be set
     * @return void
     */
    public function setRequest($request)
    {
        $this->_request = $request;
    }
    
    /**
     * Gets the request type from POST:
     *
     * @return string one of WS_XMLRPC, WS_SOAP or WS_JSONRPC or false
     */
    public static function getRequestType()
    {
        $request = self::_getRequestFromPOST();

        libxml_use_internal_errors(true);
        
        // if request is a valid xml-rpc string
        if ($xml = simplexml_load_string($request)) {
            if ($xml->getName() == 'methodCall') {
                return WS_XMLRPC;
            }
        } else if ($xml = simplexml_load_string($request, 'SimpleXMLElement', 0, 'http://schemas.xmlsoap.org/soap/envelope/')) {
            // if request is a valid soap string
            return WS_SOAP;
        } else {
            // if request is a json string
            $json = json_decode($request, true);
            if (is_array($json)) {
                return WS_JSONRPC;
            }
        }
        
        return false;
    }

    /**
     * Gets the response Content-Type based on request type.
     *
     * @return string one of 'text/xml', 'application/json' or false
     */
    public static function getContentType()
    {
        $requestTypeToContentType = array(
            WS_XMLRPC => 'text/xml',
            WS_SOAP => 'text/xml',
            WS_JSONRPC => 'application/json'
        );
        
        if ($requestType = self::getRequestType()) {
            return $requestTypeToContentType[$requestType];
        }
        
        return false;
    }
    
    /**
     * Encodes php values to xmlrpc, jsonrpc or soap.
     *
     * @param mixed  $value      Value to encode
     * @param string $outputType Output type, can be one of WS_XMLRPC, WS_SOAP or WS_JSONRPC
     * @return string Encoded value
     */
    public static function rpcEncode($value, $outputType)
    {
        return rpc_encode($value, $outputType);
    }

    /**
     * Decodes xmlrpc or jsonrpc to php values.
     *
     * @param string $value    Value to decode
     * @param string $encoding (optional) The encoding of the charset (ex: 'utf-8')
     * @return mixed Decoded php value
     */
    public static function rpcDecode($value, $encoding = null)
    {
        return rpc_decode($value, $encoding);
    }

    /**
     * Encodes rpc request to xmlrpc, jsonrpc or soap.
     *
     *  Available options:
     * 'version'   => {WS_XMLRPC|WS_SOAP|WS_JSONRPC}
     * 'verbosity' => {no_white_space|newlines_only|pretty}
     * 'escaping'  => {cdata|non-ascii|non-print|markup}
     * 'encoding'  => {iso-8859-1|utf-8}
     *
     * @param string $method        Method name
     * @param mixed  $params        Method parameters
     * @param string $outputType    Output type, can be one of WS_XMLRPC, WS_SOAP or WS_JSONRPC
     * @param array  $outputOptions Associative array with options
     * @return string Encoded request
     * @deprecated Please use Streamwide_WebService_Client::rpcEncodeRequest instead.
     */
    public static function rpcEncodeRequest($method, $params, $outputType, $outputOptions = array())
    {
        // set output type in 'version' option
        $outputOptions['version'] = $outputType;

        return rpc_encode_request($method, $params, $outputOptions);
    }

    /**
     * Decodes rpc request to php native values.
     *
     * @param string $request  Request string
     * @param string &$method  Method name
     * @param string $encoding The encoding of the charset (ex: utf-8)
     * @return array Decoded request
     */
    public static function rpcDecodeRequest($request, &$method, $encoding = null)
    {
        return rpc_decode_request($request, $method, $encoding);
    }

    /**
     * Sets RPC type for a PHP value.
     *
     * @param mixed  &$value Reference to a PHP value
     * @param string $type   RPC Type to set: WS_TYPE_BASE64|WS_TYPE_DATETIME|WS_TYPE_LONG
     * @return boolean Returns true on success or false on failure.
     *                 If successful, value is converted to an webservice object.
     */
    public static function rpcSetType(&$value, $type)
    {
        return rpc_set_type($value, $type);
    }

    /**
     * Destroys everything related to this session in extension
     */
    function __destruct()
    {
        rpc_server_destroy($this->_serverHandle);
    }
}

/* EOF */