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
 * @version    $Id: Sox.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * SoX concatenate command implementation.
 *
 * Usage:
 *
 * <code>
 * $result = $soxCommand->setJoin(true)
 *                      ->addInputFile($file1)
 *                      ->addInputFile($file2)
 *                      ->addInputFile($file3)
 *                      ->setOutputFile($output)
 *                      ->run();
 * </code>
 *
 * @package    Streamwide_Media
 * @subpackage Streamwide_Media_Command
 */
class Streamwide_Media_Command_Sox extends Streamwide_Media_Command
{
    /**
     * Application name.
     *
     * @var string
     */
    protected $_applicationName = 'SoX';
    
    /**
     * A short description of the application.
     *
     * @var string
     */
    protected $_applicationDescription = 'SoX is a cross-platform command line utility that can convert various formats of computer audio files in to other format.';
    
    /**
     * Supported command versions.
     *
     * @var string
     */
    protected $_supportedVersions = '14.3.*';
    
    /**
     * Executable command name.
     *
     * @var string
     */
    protected $_commandName = 'sox';

    /**
     * Join files.
     *
     * @var boolean
     */
    protected $_join = true;
    
    /**
     * Command mix option.
     *
     * @var string
     */
    protected $_joinParameter  = '--combine concatenate';
    
    /**
     * The input files.
     *
     * @var array
     */
    protected $_inputFiles;
    
    /**
     * The output file.
     *
     * @var string
     */
    protected $_outputFile;
    
    /**
     * Adds an input file to mix.
     *
     * @param string $filename file name
     * @return Streamwide_Media_Command_SoxMix *Provides fluent interface*
     */
    public function addInputFile($filename)
    {
        $this->_inputFiles[] = $filename;
        
        return $this;
    }
    
    /**
     * Get the input files.
     *
     * @return array
     */
    public function getInputFiles()
    {
        return $this->_inputFiles;
    }
    
    /**
     * Set the output file.
     *
     * @param string $filename output file name
     * @return Streamwide_Media_Command_SoxMix *Provides fluent interface*
     */
    public function setOutputFile($filename)
    {
        $this->_outputFile = $filename;
        
        return $this;
    }
    
    /**
     * Get the output file.
     *
     * @return string
     */
    public function getOutputFile()
    {
        return $this->_outputFile;
    }
    
    
    /**
     * Activate or deactivate the join bahavior.
     *
     * @param boolean $join whether
     * @return unknown_type
     */
    public function setJoin($join)
    {
        if (!is_boolean($join)) {
            throw new Streamwide_Media_Exception('Join parameter must be boolean.');
        }
        
        $this->_join = $join;
    }
    
    /**
     * Query the object if it will join files.
     *
     * @return boolean
     */
    public function willJoin()
    {
        return $this->_join;
    }
    
    /**
     * Prepares and returns the command.
     *
     * @return string the full command
     */
    public function getCommand()
    {
        $this->_checkAllPartsAreSet();
        
        $parts = array();

        $parts[] = $this->_commandPath . '/' . $this->_commandName;
        $parts[] = $this->_joinParameter;
        
        // add input files
        foreach ($this->_inputFiles as $inputFile) {
            $parts[] = $inputFile;
        }
        $parts[] = $outputFile;
        
        $command = join(' ', $parts);
        
        return $command;
    }
    
    protected function _checkAllPartsAreSet()
    {
        if (empty($this->_inputFiles)) {
            throw new Streamwide_Media_Exception('Input files have not been set.');
        }
        if (empty($this->_outputFile)) {
            throw new Streamwide_Media_Exception('Output file has not been set.');
        }
    }
}

/* EOF */