<?php
/**
 * $Rev: 2492 $
 * $LastChangedDate: 2010-04-09 18:34:11 +0800 (Fri, 09 Apr 2010) $
 * $LastChangedBy: junzhang $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Model.php 2492 2010-04-09 10:34:11Z junzhang $
 */

/**
 * Application layer on the XML-RPC client implementation
 */
class Streamwide_Web_Model
{
    /**
     * Instances of Streamwide_Web_Webservice_Client
     *
     * @var Streamwide_Web_Webservice_Client
     */
    protected static $_model = null;

    /**
     * Set the available model instance to execute the call()
     *
     * @param Streamwide_Web_Model_Interface $model 
     *
     * @return void
     */
    public static function setModel(Streamwide_Web_Model_Interface $model)
    {
        self::$_model = $model;
    }

    /**
     * Wrap on Streamwide_Web_Webservice_Client::call method.
     * Send an XML-RPC request to the service (for a specific method).
     *
     * @param  string $method Name of the method we want to call
     * @param  array $params Array of parameters for the method
     *
     * @return mixed
     * @throw Streamwide_Exception|Zend_XmlRpc_Client_FaultException  while none available model, 
     *                                                                throwed Streamwide_Exception
     */
    public static function call($method,array $params = array())
    {
        if (is_null(self::$_model)) {
            throw new Streamwide_Exception('Invalid model provided; must be a valid model instance');
        }
        return self::$_model->call($method,$params);
    }
}

/* EOF */