<?php
/**
 * WebService Client class.
 *
 * $Rev: 2016 $
 * $LastChangedDate: 2009-10-05 20:24:45 +0800 (Mon, 05 Oct 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_WebService
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Client.php 2016 2009-10-05 12:24:45Z rgasler $
 */

/**
 * WebService Client class.
 *
 * Can be used as a layer over the StreamWIDE WebServices
 * extension to encode/decode RPC requests.
 */
class Streamwide_WebService_Client
{
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
}