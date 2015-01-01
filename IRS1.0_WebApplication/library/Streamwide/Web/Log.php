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
 * @version    $Id: Log.php 2503 2010-04-15 07:17:36Z junzhang $
 */

/**
 * Logger class.
 *
 * Usage example: <code>
 * Streamwide_Web_Log::debug('hello world');
 * </code>
 */
class Streamwide_Web_Log
{
    /**
     * Retrieve logger object
     *
     * @return Streamwide_Log
     */
    private static function _getLogger()
    {
        $front = Zend_Controller_Front::getInstance();
        return $front->getParam('bootstrap')->getResource('logger');
    }

    /**
     * Wrapper for Streamwide_Log::log with the priority Zend_Log::DEBUG.
     *
     * @param string  $message  Message to log
     * @return void
     */
    public static function debug($message)
    {
        $log = self::_getLogger();
        is_null($log) || $log->log($message,Zend_Log::DEBUG);
    }

    /**
     * Wrapper for Streamwide_Log::log with the priority Zend_Log::INFO.
     *
     * @param string  $message  Message to log
     * @return void
     */
    public static function info($message)
    {
        $log = self::_getLogger();
        is_null($log) || $log->log($message,Zend_Log::INFO);
    }

    /**
     * Wrapper for Streamwide_Log::log with the priority Zend_Log::NOTICE.
     *
     * @param string  $message  Message to log
     * @return void
     */
    public static function notice($message)
    {
        $log = self::_getLogger();
        is_null($log) || $log->log($message,Zend_Log::NOTICE);
    }

    /**
     * Wrapper for Streamwide_Log::log with the priority Zend_Log::WARN.
     *
     * @param string  $message  Message to log
     * @return void
     */
    public static function warn($message)
    {
        $log = self::_getLogger();
        is_null($log) || $log->log($message,Zend_Log::WARN);
    }

    /**
     * Wrapper for Streamwide_Log::log with the priority Zend_Log::ERR.
     *
     * @param string  $message  Message to log
     * @return void
     */
    public static function error($message)
    {
        $log = self::_getLogger();
        is_null($log) || $log->log($message,Zend_Log::ERR);
    }

    /**
     * Wrapper for Streamwide_Log::log with the priority Zend_Log::ALERT.
     *
     * @param string  $message  Message to log
     * @return void
     */
    public static function alert($message)
    {
        $log = self::_getLogger();
        is_null($log) || $log->log($message,Zend_Log::ALERT);
    }

    /**
     * Wrapper for Streamwide_Log::log with the priority Zend_Log::EMERG.
     *
     * @param string  $message  Message to log
     * @return void
     */
    public static function emergency($message)
    {
        $log = self::_getLogger();
        is_null($log) || $log->log($message,Zend_Log::EMERG);
    }
}

/* EOF */