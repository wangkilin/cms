<?php
/**
 * $Rev: 2604 $
 * $LastChangedDate: 2010-05-17 23:05:54 +0800 (Mon, 17 May 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Webservice.php 2604 2010-05-17 15:05:54Z kwu $
 */

/**
 * Resource for setting Webservice options
 */
class Streamwide_Web_Application_Resource_Webservice extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * Instance of Zend_XmlRpc_Client
     *
     * @var Zend_XmlRpc_Client
     */
    protected $_client = null;

    /**
     * Introspection definition path
     *
     * @var string
     */
    protected $_config = '/configs/webservice.ini';

    /**
     * Defined by Zend_Application_Resource_Resource
     *
     * @return Zend_XmlRpc_Client
     * @throws Streamwide_Exception when application module directory invalid, throw
     *                                                          Streamwide_Exception
     */
    public function init()
    {
        $this->getBootstrap()->bootstrap('FrontController');

        $front = $this->getBootstrap()->getResource('FrontController');
        $modulesDirectory = dirname($front->getModuleDirectory()); //modules directory

        $this->_options['introspection'] = array();

        try{
            $dir = new DirectoryIterator($modulesDirectory);
        }catch(Exception $e){
            throw new Streamwide_Exception("Directory $modulesDirectory not readable");
        }
        foreach ($dir as $file) {
            if ($file->isDot() || !$file->isDir()) {
                continue;
            }

            $module    = $file->getFilename();

            // Don't use SCCS directories as modules
            if (preg_match('/^[^a-z]/i', $module) || ('CVS' == $module)) {
                continue;
            }

            $moduleConfig = $file->getPathname() . $this->_config;
            $introspection = $this->_getIntrospection($moduleConfig);
            $this->_options['introspection'] = array_merge($this->_options['introspection'],$introspection);
        }

        if (empty($this->_options['introspection'])) {
            unset($this->_options['introspection']);
        }

        $client = $this->getWebserviceClient();
        if ($this->_options['model']) {
            Streamwide_Web_Model::setModel($client);
        } else {
            $stub = $this->_options['stub'];
            if (!empty($stub)) {
                Streamwide_Web_Model::setModel(new Streamwide_Web_Model_Stub($stub));
            }
        }
        return $client;
    }

    /**
     * Retrieve client object
     *
     * @return Zend_XmlRpc_Client
     */
    public function getWebserviceClient()
    {
        if (is_null($this->_client)) {
            if ($this->_options['so']) {
                $this->_client = new Streamwide_Web_Webservice_Client($this->_options['serverUrl'],$this->getOptions());
            } else {
                $this->_client = new Zend_XmlRpc_Client($this->_options['serverUrl']);
                $this->_client->setSkipSystemLookup(true);
            }
        }
        return $this->_client;
    }

    /**
     * Get and parse the introspection definition
     *
     * @param string $file   Introspection definition path
     *
     * @return array
     */
    protected function _getIntrospection($file)
    {
        $environment = APPLICATION_ENV;
        $config = new Zend_Config_Ini($file, $environment);
        $config = $config->toArray();
        return $config;
    }
}

/* EOF */
