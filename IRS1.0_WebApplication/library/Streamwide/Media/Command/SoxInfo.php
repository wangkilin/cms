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
 * @subpackage Streamwide_Media_Command
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: SoxInfo.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * SoXI command implementation.
 *
 * Usage:
 * <code>
 * $result = $command->setInputFile($file)->run();
 * </code>
 *
 * @package    Streamwide_Media
 * @subpackage Streamwide_Media_Command
 */
class Streamwide_Media_Command_SoxInfo extends Streamwide_Media_Command
{
    /**
     * Application name.
     *
     * @var string
     */
    protected $_applicationName = 'SoXI';
    
    /**
     * A short description of the application.
     *
     * @var string
     */
    protected $_applicationDescription = 'Sound eXchange Information, display sound file metadata.';
    
    /**
     * Supported command versions.
     *
     * This implementation should support any version of this command,
     * hence the *.
     *
     * @var string
     */
    protected $_supportedVersions = '*';
    
    /**
     * Executable command name.
     *
     * @var string
     */
    protected $_commandName = 'soxi';
    
    /**
     * File to get metadata info.
     *
     * @var string
     */
    protected $_inputFile;
    
    /**
     * Set the input file.
     *
     * @param string $file
     * @return Streamwide_Media_Command_SoxInfo *Provides fluid interface*
     */
    public function setInputFile($file)
    {
        $this->_inputFile = $file;
        
        return $this;
    }
    
    /**
     * Returns the full command with parameters.
     *
     * @return string
     */
    public function getCommand()
    {
        $parts = array(
            $this->_commandPath . '/' . $this->_commandName,
            $this->_inputFileTag,
            $filename
        );
        
        $command = join(' ', $parts);

        return $command;
    }
}

/* EOF */