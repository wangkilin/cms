<?php
/**
 * $Rev: 2234 $
 * $LastChangedDate: 2010-01-16 23:39:28 +0800 (Sat, 16 Jan 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Request.php 2234 2010-01-16 15:39:28Z kwu $
 */

/**
 *
 */
class Streamwide_Web_Webservice_Request extends Zend_XmlRpc_Request
{
    /**
     *
     */
    private $_requestOptions   = array();

    /**
     *
     */
    public function __construct($method = null, array $params = null)
    {
        parent::__construct($method,$params);
        if (extension_loaded('WebServices')) {
            $this->_params = $params;
            $this->_requestOptions = array (
                'version'  => WS_XMLRPC,
                'encoding' => $this->_encoding
            );
        }
    }

    /**
     *
     */
    public function saveXML()
    {
        $xml = '';
        if (extension_loaded('WebServices')) {
            $xml = rpc_encode_request($this->_method, $this->_params,$this->_requestOptions);
            $xml = preg_replace("/>\n(\s*)?(<?)/", '>$2', $xml);
        } else {
            $xml = parent::saveXML();
        }
        return $xml;
    }
}
/* EOF */
