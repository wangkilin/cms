<?php
/**
 * Abastract class for adding logging feature to SwFramework.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Log
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Vicentiu COSTACHE <vcostache@streamwide.ro>
 * @version    $Id: Abstract.php 1962 2009-09-24 20:49:25Z rgasler $
 */

require_once 'Streamwide/Log.php';
require_once 'Zend/Log/Writer/Stream.php';

/**
 * Abstract class for debugging classes (CORE).
 * Example:
 *
 * class DB extends Logger_Abstract
 * {}
 *
 * In constructor: parent::__construct();
 *
 * Remeber:  call setupLogger() or overide the function
 * to customize the logger
 *
 */
abstract class Streamwide_Log_Abstract
{
    /**
     * Logger object
     */
    protected $_logger;
    
    /**
     * The constructor should always call setupLog() method
     */
    public function __construct()
    {
        $this->_setupLog();
    }

    /**
     * Initialize the logger. You may want to override the function
     *
     * @return void
     */
    protected function _setupLog()
    {
        $this->logger = new Streamwide_Log();
        $this->logger->setEventItem("class", get_class($this));

        $writer = new Zend_Log_Writer_Stream("php://output");

        $format = "SW | %class% | %timestamp% | %pid% | %memory% | %duration% | %priorityName%: %message%<br/>" . PHP_EOL;
        
        $formater = new Zend_Log_Formatter_Simple($format);
        $writer->setFormatter($formater);

        //$writer->addFilter(new Streamwide_Log_Filter_Priority(LOGGER_INFO));

        $this->logger->addWriter($writer);
    }

    /**
     * Undefined method handler allows a shortcut:
     *  $this->priorityName('message') instead of $this->logger->log('message', Logger::PRIORITY_NAME)
     *
     * @param string $method priority name
     * @param string $params message to log
     * @return void
     * @throws Streamwide_Log_Exception
     */
    protected function __call($method, $params)
    {
        if (!is_object($this->logger)) {
            return;
        }

        $priorities = array (
            'EMERG' => Zend_Log::EMERG,
            'ALERT' => Zend_Log::ALERT,
            'ERROR' => Zend_Log::ERR,
            'ERR' => Zend_Log::ERR,
            'WARNING' => Zend_Log::WARN,
            'WARN' => Zend_Log::WARN,
            'NOTICE' => Zend_Log::NOTICE,
            'INFO' => Zend_Log::INFO,
            'DEBUG' => Zend_Log::DEBUG
        );
        $priority = strtoupper($method);

        if (!isset ($priorities[$priority])) {
            throw new Streamwide_Log_Exception('Bad log priority or undefined function name');
        }

        $this->logger->log(array_shift($params), $priorities[$priority]);
    }
    
    /**
     * Shortcut for $this->logger->dump($var, $label)
     *
     * @param mixed  $var   variable to dump
     * @param string $label (optional) label
     * @return void
     */
    protected function _dump($var, $label = null)
    {
        if (is_object($this->logger)) {
            $this->logger->dump($var, $label);
        }
    }
}

/* EOF */