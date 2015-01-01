<?php
/**
 * Extension of Zend_Log class.
 *
 * Adds support for memory profiling.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Log
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Vicentiu COSTACHE <vcostache@streamwide.ro>
 * @version    $Id: Log.php 1962 2009-09-24 20:49:25Z rgasler $
 */

require_once 'Zend/Log.php';
require_once 'Log/Exception.php';

/**
 * Logger class.
 * Simple usage: $logger= new Streamwide_Log(new Streamwide_Log_Writer_File ('log.txt'));
 */
class Streamwide_Log extends Zend_Log
{
    /**
     * last timestamp
     */
    private $_last;
    
    /**
     * stores the minumum memory used
     */
    private $_memMin;
    
    /**
     * stores the maximum memory used
     */
    private $_memMax;
    
    /**
     * the initial timestamp
     */
    private $_start;
    
    /**
     * Class constructor. Create a new logger.
     *
     * @param Streamwide_Log_Writer_Abstract $writer (optional) Default writer.
     */
    public function __construct($writer = null)
    {
        parent::__construct($writer);
        $this->_priorities[Zend_Log::ERR] = 'ERROR';
        $this->_priorities[Zend_Log::WARN] = 'WARNING';
        $this->_start = $this->_last = $this->_getmicrotime();
        $this->_memMin = $this->_memMax = memory_get_usage();
    }
    
    /**
     * Log a message at a priority.
     *
     * @param string  $message  Message to log
     * @param integer $priority Priority of message
     * @return void
     * @throws Streamwide_Log_Exception when no writers were added or priority is wrong
     */
    public function log($message, $priority)
    {
        // sanity checks
        if (empty($this->_writers)) {
            throw new Streamwide_Log_Exception('No writers were added');
        }
        if (! isset($this->_priorities[$priority])) {
            throw new Streamwide_Log_Exception('Bad log priority');
        }
        
        $mtime = $this->_getMicrotime();
        $lastDuration = $mtime - $this->_last;
        $this->_last = $mtime;
        // pack into event required by filters and writers
        $timestamp = date('Ymd H:i:s', $this->_last);
        $microseconds = intval(($this->_last - intval($this->_last)) * 1000000);
        $microseconds = str_pad($microseconds, 6, '0', STR_PAD_LEFT);
        $milliseconds = sprintf('%03.3s', (int) ($microseconds / 1000));
        $event = array_merge(
            array(
                'timestamp'    => $timestamp,
                'microseconds' => $microseconds,
                'milliseconds' => $milliseconds,
                'message'      => $message,
                'priority'     => $priority,
                'priorityName' => $this->_priorities[$priority],
                'duration'     => sprintf("%05fs", $lastDuration),
                'memory'       => sprintf("%dKB", floor(memory_get_usage() / 1024)),
                'pid'          => getmypid(),
                'label'        => ''
            ),
            $this->_extras
         );
        // abort if rejected by the global filters
        foreach ($this->_filters as $filter) {
            if (! $filter->accept($event)) {
                return;
            }
        }
        // send to each writer
        foreach ($this->_writers as $writer) {
            $writer->write($event);
        }
        $mem = memory_get_usage();
        if ($mem > $this->_memMax) {
            $this->_memMax = $mem;
        }
        if ($mem < $this->_memMin) {
            $this->_memMin = $mem;
        }
    }
    
    /**
     * Continued support for 'err' method like Zend.
     *
     * @param string $message Message to log
     * @return void
     */
    public function err($message)
    {
        $this->log($message, Zend_Log::ERR);
    }
    
    /**
     * Continued support for 'warn' method like Zend
     *
     * @param string $message Message to log
     *
     * @return void
     */
    public function warn($message)
    {
        $this->log($message, Zend_Log::WARN);
    }
    /**
     * Wrapper for Zend_Debug::Dump. Set automaticaly the priority to DEBUG.
     *
     * @param mixed  $var   Variable
     * @param string $label Variable label
     *
     * @return void
     */
    public function dump($var, $label = null)
    {
        $this->log(Zend_Debug::dump($var, $label, false), Zend_Log::DEBUG);
    }
    /**
     * Returns the elapsed time from the logger initialization
     *
     * @return float
     */
    public function getElapsedTime()
    {
        $total = $this->_getMicrotime() - $this->_start;
        return sprintf("%05f", $total);
    }
    /**
     * Return the references of min & max memory used in Kb
     *
     * @param integer &$min referenced variable to store the minimum value
     * @param integer &$max referenced variable to store the maximum value
     *
     * @return void
     */
    public function getMemStats(&$min, &$max)
    {
        $min = floor($this->_memMin / 1024);
        $max = floor($this->_memMax / 1024);
    }

    /**
     * Return the time in microseconds
     *
     * @return float
     */
    private function _getMicrotime()
    {
        $t = gettimeofday();
        return doubleval($t['sec'] + $t['usec'] / 1000000.0);
    }
}

/* EOF */