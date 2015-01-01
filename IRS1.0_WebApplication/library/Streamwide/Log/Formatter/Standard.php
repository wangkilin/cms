<?php
/**
 * Standard log formatter.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Log
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Vicentiu COSTACHE <vcostache@streamwide.ro>
 * @version    $Id: Standard.php 1962 2009-09-24 20:49:25Z rgasler $
 */

require_once 'Zend/Log/Formatter/Interface.php';

/**
 * Standard format for log:
 * %timestamp%.%microseconds%|%pid%|%memory%|%label%|%priorityName%|%message%
 */
class Streamwide_Log_Formatter_Standard implements Zend_Log_Formatter_Interface
{
    /**
     * @var string
     */
    protected $_format;

    /**
     * Class constructor
     *
     * @param string $header (optional) format specifier for log messages
     * @throws Zend_Log_Exception
     */
    public function __construct($header = null)
    {
        if ($header === null) {
            $header = '%timestamp%.%milliseconds%|%pid%|%memory%|%priorityName%|';
        }

        if (!is_string($header)) {
            throw new Streamwide_Log_Exception('Header format must be a string');
        }

        $this->_format = $header;

    }

    /**
     * Formats data into a single line to be written by the writer.
     *
     * @param array $event event data
     * @return string formatted line to write to the log
     */
    public function format($event)
    {
        //format the message
        $lines = explode(PHP_EOL, $event['message']);
        if (!is_array($lines))
        $lines = array (
            $lines
        );

        if (isset($event['priorityName'])) {
            $event['priorityName'] = str_pad($event['priorityName'], 7);
        }
        $output = "";
        foreach ($lines as $message) {
            if (trim($message) == '')
            continue;
            $header = $this->_format;
            foreach ($event as $name => $value) {
                $header = str_replace("%$name%", $value, $header);
            }
            $message = str_replace('|', '\\', $message);
            $output .= $header . $message . PHP_EOL;
        }
        return $output;
    }
}

/* EOF */