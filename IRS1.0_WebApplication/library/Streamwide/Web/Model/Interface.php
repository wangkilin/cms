<?php
/**
 * $Rev: 2492 $
 * $LastChangedDate: 2010-04-09 18:34:11 +0800 (Fri, 09 Apr 2010) $
 * $LastChangedBy: junzhang $
 *
 * @category   Streamwide
 * @package    Streamwide_Web_Model
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Interface.php 2492 2010-04-09 10:34:11Z junzhang $
 */

/**
 * Interface class for Streamwide_Web_Model
 */
interface Streamwide_Web_Model_Interface
{
    /**
     * Wrap on Streamwide_Web_Webservice_Client::call method.
     * Send an XML-RPC request to the service (for a specific method).
     *
     * @param  string $method Name of the method we want to call
     * @param  array $params Array of parameters for the method
     *
     * @return mixed
     * @throw Zend_XmlRpc_Client_FaultException
     */
    public function call($method,array $params = array());
}

/* EOF */