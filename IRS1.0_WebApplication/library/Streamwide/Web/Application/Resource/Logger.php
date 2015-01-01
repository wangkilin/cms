<?php
/**
 * $Rev: 2503 $
 * $LastChangedDate: 2010-04-15 15:17:36 +0800 (Thu, 15 Apr 2010) $
 * $LastChangedBy: junzhang $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Logger.php 2503 2010-04-15 07:17:36Z junzhang $
 */

/**
 * Resource for settings Logger options
 */
class Streamwide_Web_Application_Resource_Logger extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * Instance of Streamwide_Log
     *
     * @var Streamwide_Log
     */
    private $_logger = null;

    /**
     * Instance of Streamwide_Log_Writer_File
     *
     * @var Streamwide_Log_Writer_File
     */
    private $_writer = null;

    /**
     * Path of save file
     *
     * @var string
     */
    private $_file = '/swweb.log';

    /**
     * Format specifier for log messages
     *
     * @var string
     */
    private $_header = '%timestamp%.%milliseconds%|%pid%|%memory%|%role%|%http%|%module%|%controller%|%action%|%priorityName%|';

    /**
     * Defined by Zend_Application_Resource_Resource
     *
     * @return Streamwide_Log
     */
    public function init()
    {
        $this->getBootstrap()->bootstrap('FrontController');
        $front = $this->getBootstrap()->getResource('FrontController');

        if (!$front->hasPlugin('Streamwide_Web_Controller_Plugin_Log')) {
            $front->registerPlugin(new Streamwide_Web_Controller_Plugin_Log(),1); //1: the very first plugin
        }

        $logpath = $this->_options['log']['path'];
        $logpath = is_null($logpath) || empty($logpath) ? '/tmp' : $logpath;

        $priority = $this->_options['log']['level'];
        $priorities = array (
            'EMERG' => Zend_Log::EMERG,
            'ALERT' => Zend_Log::ALERT,
            'ERR' => Zend_Log::ERR,
            'ERROR' => Zend_Log::ERR,
            'WARN' => Zend_Log::WARN,
            'WARNING' => Zend_Log::WARN,
            'NOTICE' => Zend_Log::NOTICE,
            'INFO' => Zend_Log::INFO,
            'DEBUG' => Zend_Log::DEBUG
        );
        $loglevel = is_null($priority) || !isset($priorities[$priority]) ? Zend_Log::NOTICE : $priorities[$priority];

        $this->_writer = new Streamwide_Log_Writer_File($logpath . $this->_file);
        $filter = new Zend_Log_Filter_Priority($loglevel);
        $this->_writer->addFilter($filter);
        $format = new Streamwide_Log_Formatter_Standard($this->_header);
        $this->_writer->setFormatter($format);

        return $this->getLogger();
    }

    /**
     * Retrieve logger object
     *
     * @return Streamwide_Log
     */
    public function getLogger()
    {
        if (is_null($this->_logger)) {
            $this->_logger = new Streamwide_Log($this->_writer);
        }
        return $this->_logger;
    }
}

/* EOF */