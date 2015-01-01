<?php
/**
 * Console log writer.
 *
 * $Rev: 2457 $
 * $LastChangedDate: 2010-03-27 00:21:19 +0800 (Sat, 27 Mar 2010) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Log
 * @subpackage Streamwide_Log_Writer
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Vicentiu COSTACHE <vcostache@streamwide.ro>
 * @version    $Id: Console.php 2457 2010-03-26 16:21:19Z rgasler $
 */

require_once 'Zend/Log/Writer/Abstract.php';
require_once 'Zend/Log/Formatter/Simple.php';
require_once 'Zend/Debug.php';

/**
 * Class for displaying the log.
 */
class Streamwide_Log_Writer_Console extends Zend_Log_Writer_Abstract
{
    /**
     * shutdown called?
     */
    public $shutdown = false;
    
    /**
     * Constructor Class - set the Simple Formatter
     */
    public function __construct()
    {
        $this->_formatter = new Zend_Log_Formatter_Simple();
    }
    
    /**
     * Write a message to the log.
     *
     * @param array $event event data
     * @return void
     */
    protected function _write($event)
    {
        $line = $this->_formatter->format($event);

        if (Zend_Debug::getSapi() == 'cli') {
            if (substr($line, -strlen(PHP_EOL)) != PHP_EOL ) {
                $line .= PHP_EOL;
            }
        } else {
            $line = '<pre>' . htmlspecialchars($line) . '</pre>';
        }
        echo $line;
    }
    
    /**
     * Create a new instance of Zend_Log_Writer_Console
     *
     * @param  array|Zend_Config $config
     * @return Zend_Log_Writer_Console
     * @throws Zend_Log_Exception
     */
    static public function factory($config)
    {
        return new self();
    }

    /**
     * Record shutdown
     *
     * @return void
     */
    public function shutdown()
    {
        $this->shutdown = true;
    }
}

/* EOF */