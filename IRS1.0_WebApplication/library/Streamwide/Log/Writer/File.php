<?php
/**
 * File log writer.
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
 * @version    $Id: File.php 2457 2010-03-26 16:21:19Z rgasler $
 */

require_once 'Zend/Log/Writer/Abstract.php';
require_once 'Zend/Log/Formatter/Simple.php';

class Streamwide_Log_Writer_File extends Zend_Log_Writer_Abstract
{

    /**
     * Holds the PHP stream (file pointer resource) to log to.
     *
     * @var resource
     */
    protected $_stream = null;

    /**
     * Activate/desactivate lock on file log
     *
     * @var boolean
     */
    protected $_lock = false;

    /**
     * Class Constructor
     *
     * @param string $file file name
     * @param string $mode (optional) type of writing mode
     */
    public function __construct($file = '', $mode = 'a')
    {
        $this->_formatter = new Zend_Log_Formatter_Simple();

        if ($file) {
            $this->setFile($file, $mode);
        }
    }

    /**
     * Set the lock flag state: true or false.
     *
     * @param boolean $state state of the lock (true or false)
     * @return void
     */
    function setLock($state)
    {
        $this->_lock = $state;
    }

    /**
     * Set or change the file name for logging.
     *
     * @param string $file file name
     * @param string $mode (optional) type of writing mode
     * @return void
     */
    public function setFile($file, $mode = 'a')
    {
        // closes previous log file
        $this->shutdown();
        if (!$this->_stream = @ fopen($file, $mode)) {
            $msg = "File \"$file\" cannot be opened for writing using mode $mode";
            throw new Streamwide_Log_Exception($msg);
        }
    }

    /**
     * Close the stream resource.
     *
     * @return void
     */
    public function shutdown()
    {
        if (is_resource($this->_stream)) {
            fclose($this->_stream);
        }
    }

    /**
     * Write a message to the log.
     * Warning: locking doesn't work on NFS
     *
     * @param array $event event data
     * @return void
     * @throws Streamwide_Log_Exception when something goes wrong
     */
    protected function _write($event)
    {

        $line = $this->_formatter->format($event);
        if (!is_resource($this->_stream)) {
            throw new Streamwide_Log_Exception('Invalid file resource');
        }

        // if locking is active try to get an exclusive lock on the file
        if ($this->_lock && !@flock($this->_stream, LOCK_EX)) {
            //!NOTE: Locking doesn't work on NFS !!!
            throw new Streamwide_Log_Exception("The lock is active and it couldn't be set on the log file! (NFS file?)");
        }

        if (false === @fwrite($this->_stream, $line)) {
            throw new Streamwide_Log_Exception("Unable to write to stream");
        }

        // release the lock
        if ($this->_lock) {
            @flock($this->_stream, LOCK_UN);
        }
    }
    
    /**
     * Create a new instance of Zend_Log_Writer_File
     *
     * @param  array|Zend_Config $config
     * @return Zend_Log_Writer_File
     * @throws Zend_Log_Exception
     */
    static public function factory($config)
    {
        $config = self::_parseConfig($config);
        $config = array_merge(array(
            'file' => '',
            'mode' => 'a',
        ), $config);

        return new self(
            $config['file'],
            $config['mode']
        );
    }
}

/* EOF */