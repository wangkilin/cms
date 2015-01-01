<?php
/**
 * StreamWIDE Framework
 *
 * $Rev: 2608 $
 * $LastChangedDate: 2010-05-18 10:01:35 +0800 (Tue, 18 May 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Package
 * @subpackage Subpackage
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: SoxMix.php 2608 2010-05-18 02:01:35Z kwu $
 */

class Streamwide_Media_Mixer_SoxMix implements Streamwide_Media_Mixer_Interface
{
    /**
     * SoxMix command to use.
     *
     * @var Streamwide_Media_Command_SoxMix
     */
    protected $_soxMixCommand;
    
    /**
     * Default ffmpeg command class.
     *
     * @var string
     */
    protected $_defaultSoxMixCommand = 'Streamwide_Media_Command_SoxMix';
    
    /**
     * Constructor.
     *
     * @param Streamwide_Media_Command_SoxMix $command
     */
    public function __construct(Streamwide_Media_Command_SoxMix $soxMixCommand = null)
    {
        if (is_null($soxMixCommand)) {
            $soxMixCommand = new $this->_defaultSoxMixCommand;
        }
        
        $this->setSoxMixCommand($soxMixCommand);
    }
    
    
    /**
     * This method mixes the given files.
     *
     * @param array   $inputFiles  Source files
     * @param string  $outputFile  The destination file
     * @return string|boolean      resulted file path or false if the mix failed
     */
    public function mix(Array $inputFiles, $outputFile)
    {
        // get the soxmix command
        $command = $this->_soxMixCommand;
        
        foreach ($inputFiles as $file) {
            $command->addInputFile($file);
        }
        $command->setOutputFile($outputFile);
        
        $result = $command->run();
        
        if (!file_exists($destination) || filesize($destination) == 0) {
            return false;
        }
        
        return $destination;

    }
        
    /**
     * Set the soxmix command object.
     *
     * @param Streamwide_Command_SoxMix $command
     * @return Streamwide_Media_Converter_SoxMix *Provides a fluid interface*
     */
    public function setSoxMixCommand(Streamwide_Command_SoxMix $command)
    {
        $this->_ffmpegCommand = $command;
        
        return $this;
    }
    
    /**
     * Get the soxmix command object.
     *
     * @return Streamwide_Command_SoxMix
     */
    public function getSoxMixCommand()
    {
        return new $this->_soxMixCommand;
    }
}

/* EOF */