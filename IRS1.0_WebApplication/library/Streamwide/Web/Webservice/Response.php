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
 * @version    $Id: Response.php 2234 2010-01-16 15:39:28Z kwu $
 */

/**
 *
 */
class Streamwide_Web_Webservice_Response extends Zend_XmlRpc_Response
{
    /**
     *
     */
    public function __construct($return = null, $type = null)
    {
        parent::__construct($return,$type);
    }

    /**
     *
     */
    public function loadXML($response)
    {
        $valid = true;
        if (extension_loaded('WebServices')) {
            if (!is_string($response)) {
                $this->_fault = new Zend_XmlRpc_Fault(650);
                $this->_fault->setEncoding($this->getEncoding());
                return false;
            }

            try {
                $xml = @new SimpleXMLElement($response);
            } catch (Exception $e) {
                // Not valid XML
                $this->_fault = new Zend_XmlRpc_Fault(651);
                $this->_fault->setEncoding($this->getEncoding());
                return false;
            }

            if (!empty($xml->fault)) {
                // fault response
                $this->_fault = new Zend_XmlRpc_Fault();
                $this->_fault->setEncoding($this->getEncoding());
                $this->_fault->loadXml($response);
                return false;
            }

            if (empty($xml->params)) {
                // Invalid response
                $this->_fault = new Zend_XmlRpc_Fault(652);
                $this->_fault->setEncoding($this->getEncoding());
                return false;
            }

            $value = rpc_decode($response);
            $this->setReturnValue($value);
        } else {
            $valid = parent::loadXML($response);
        }
        return $valid;
    }
}
/* EOF */
