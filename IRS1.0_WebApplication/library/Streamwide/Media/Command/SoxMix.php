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
 * @version    $Id: SoxMix.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * SoX mix command implementation.
 *
 * Usage:
 *
 * <code>
 * $result = $command->addInputFile($file1)
 *                   ->addInputFile($file2)
 *                   ->setOutputFile($output)
 *                   ->run();
 * </code>
 *
 * @package    Streamwide_Media
 * @subpackage Streamwide_Media_Command
 */
class Streamwide_Media_Command_SoxMix extends Streamwide_Media_Command_Sox_Abstract
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
     * Command mix option.
     *
     * @var string
     */
    protected $_mixParameter  = '-m';
    
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
     * Prepares and returns the command.
     *
     * @return string the full command
     */
    public function getCommand()
    {
        $this->_checkAllPartsAreSet();
        
        $parts = array();

        $parts[] = $this->_commandPath . '/' . $this->_commandName;
        $parts[] = $this->_mixParameter;
        
        // add input files
        foreach ($this->_inputFiles as $inputFile) {
            
            // for alaw files put additional options for the mix
            if ('al' == pathinfo($inputFile, PATHINFO_EXTENSION)) {
                $parts[] = '-c 1 -r 8000';
            }
            
            $parts[] = $inputFile;
        }
        // add output file
        foreach ($this->_outputFiles as $outputFile => $options) {
            $parts[] = $outputFile;
        }
        
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