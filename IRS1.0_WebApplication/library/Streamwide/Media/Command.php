<?php
/**
 * StreamWIDE Framework
 *
 * $Rev: 2608 $
 * $LastChangedDate: 2010-05-18 10:01:35 +0800 (Tue, 18 May 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Command.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * A class to respresent an external application shell command.
 *
 * This class creates a transparency in use of command parameters
 * thus providinig a set of advantages:
 * - can support multiple versions of the command
 * - provides a layer of abstraction for the command parameters
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
abstract class Streamwide_Media_Command
{
    /**
     * Application name.
     *
     * @var string
     */
    protected $_applicationName;
    
    /**
     * A short description of the application.
     *
     * @var string
     */
    protected $_applicationDescription;
    
    /**
     * A string that represents supported command versions.
     * examples: 1.9.*, >= 1.8.10, <= 1.10.4
     *
     * @var string
     */
    protected $_supportedVersions;
    
    /**
     * Executable command name.
     *
     * @var string
     */
    protected $_commandName;
    
    /**
     * Executable command path.
     * Defaults to /usr/bin.
     *
     * @var string
     */
    protected $_commandPath = '/usr/bin';

    /**
     * Constructor.
     *
     * @param string $commandPath (optional) executable command path
     * @throws Streamwide_Media_Exception when the executable does not exist in given path
     */
    public function __construct($commandPath = null)
    {
        if (isset($commandPath)) {
            $this->setCommandPath($commandPath);
        }
    }
    
    /**
     * Returns the external application name.
     *
     * @return string
     */
    public function getApplicationName()
    {
        return $this->_applicationName;
    }
    
    /**
     * Returns the external application description.
     *
     * @return string
     */
    public function getApplicationDescription()
    {
        return $this->_applicationDescription;
    }
    
    /**
     * Returns the full command with parameters.
     *
     * @return string
     */
    public abstract function getCommand();
    
    /**
     * Set the executable path.
     *
     * @param string $path
     * @return Streamwide_Media_Command *Provides fluid interface*
     * @throws Streamwide_Media_Exception when the executable does not exist in given path
     */
    public function setCommandPath($path)
    {
        $this->_commandPath = $path;
        
        if (!$this->_commandExists($path)) {
            throw new Streamwide_Media_Exception("Command $this->_commandName does not exist in $path or is not executable.");
        }
    }
    
    /**
     * Returns the command path.
     *
     * @return string
     */
    public function getCommandPath()
    {
        return $this->_commandPath;
    }
    
    /**
     * Returns the command name.
     *
     * @return string
     */
    public function getCommandName()
    {
        return $this->_commandName;
    }
    
    /**
     * Runs the command.
     *
     * @param  integer &$returnValue set this reference if you want to catch the command return value
     * @return array   associative array with 'stdout' and 'stderr' keys
     */
    public function run(&$returnValue = null)
    {
        $command = $this->getCommand();

        $result = Streamwide_System_Command_Runner::runCommand($command, null, $return);

        return $result;
    }
    
    /**
     * Gets the version of the application.
     * Equivalent to --version command line option.
     *
     * @return string application version
     */
    public function getVersion()
    {
        return false;
    }
    
    /**
     * Checks if this object supports the given version of the application.
     *
     * @param string $version
     * @return boolean|string if version is given, else returns a string with supported versions
     */
    public function isSupportedVersion($version)
    {
        return false;
    }
    
    /**
     * Returns a string with supported versions of the application.
     *
     * @return string
     */
    public function getSupportedVersions()
    {
        return $this->_supportedVersions;
    }
    
    /**
     * Check if the executable command file exists in the given path.
     *
     * @return boolean
     */
    protected function _commandExists($path)
    {
       return is_executable($path . '/' . $this->_commandName);
    }
}

/* EOF */