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
 * @version    $Id: Cat.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Cat command implementation.
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
class Streamwide_Media_Command_Cat extends Streamwide_Media_Command
{
    /**
     * Application name.
     *
     * @var string
     */
    protected $_applicationName = 'cat';
    
    /**
     * A short description of the application.
     *
     * @var string
     */
    protected $_applicationDescription = 'concatenate files and print on the standard output';
    
    /**
     * Supported command versions.
     *
     * This implementation is generic, hence the *.
     *
     * @var string
     */
    protected $_supportedVersions = '*';
    
    /**
     * Executable command name.
     *
     * @var string
     */
    protected $_commandName = 'cat';
    
    /**
     * Executable command path.
     * Defaults to /bin.
     *
     * @var string
     */
    protected $_commandPath = '/bin';
    
    /**
     * The two input files.
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
     * Adds an input file.
     *
     * @param string $filename file name
     * @return Streamwide_Media_Command_Cat *Provides fluent interface*
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
        
        $parts[] = $this->_commandPath . '/' . $this->_commandName;
        
        // add input files
        foreach ($this->_inputFiles as $inputFile) {
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

/* EOF */