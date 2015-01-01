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
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: FFmpeg.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Audio/Video converter using FFmpeg.
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
class Streamwide_Media_Converter_FFmpeg implements Streamwide_Media_Converter_Interface
{
    /**
     * FFmpeg command to use.
     *
     * @var Streamwide_Media_Command_FFmpeg_Abstract
     */
    protected $_ffmpegCommand;
    
    /**
     * Default ffmpeg command class.
     *
     * @var string
     */
    protected $_defaultFFmpegCommand = 'Streamwide_Media_Command_FFmpeg';
    
    /**
     * Constructor.
     *
     * @param Streamwide_Media_Command_FFmpeg $command
     */
    public function __construct(Streamwide_Media_Command_FFmpeg_Abstract $ffmpegCommand = null)
    {
        if (is_null($ffmpegCommand)) {
            $ffmpegCommand = new $this->_defaultFFmpegCommand;
        }
        
        $this->setFFmpegCommand($ffmpegCommand);
    }
    
    /**
     * Converts a file to the specified media type.
     *
     * @param string|array            $inputFiles   one or more source files
     * @param string                  $destination  destination file
     * @param Streamwide_Media_Format $outputFormat output format
     * @return string|boolean created file path or false if conversion has failed
     * @throws Streamwide_Media_Exception if output format is not supported
     */
    public function convert($inputFiles, $outputFile, $outputFormat)
    {
        if (!($outputFormat instanceof Streamwide_Media_Format_Audio || $outputFormat instanceof Streamwide_Media_Format_Video)) {
            throw new Streamwide_Media_Exception('Unsupported media format ' . get_class($outputFormat));
        }
        
        if (!is_array($inputFiles)) {
            $inputFiles = array($inputFiles);
        }
        
        // get the ffmpeg command
        $ffmpegCommand = $this->_ffmpegCommand;
        
        // add source
        foreach($inputFiles as $file) {
            $this->_addFileToFFmpegCommand($ffmpegCommand, $file);
        }
        
        // add destination
        $this->_addFileToFFmpegCommand($ffmpegCommand, $outputFile, false, $outputFormat);

        // execute the command
        $result = $this->_executeConversion($ffmpegCommand, $outputFile);

        // check if the conversion was made
        if (!$result) {
            return false;
        }

        return $outputFile;
    }

    
    /**
     * Set the ffmpeg command object.
     *
     * @param Streamwide_Media_Command_FFmpeg_Abstract $command
     * @return Streamwide_Media_Converter_FFmpeg *Provides a fluid interface*
     */
    public function setFFmpegCommand(Streamwide_Media_Command_FFmpeg $command)
    {
        $this->_ffmpegCommand = $command;
        
        return $this;
    }
    
    /**
     * Get the ffmpeg command object.
     *
     * @return Streamwide_Command_FFmpeg
     */
    public function getFFmpegCommand()
    {
        return new $this->_ffmpegCommand;
    }
    
    /**
     * Adds a file to a ffmpeg command.
     *
     * @param Streamwide_Media_Command_FFmpeg $ffmpegCommand
     * @param string                          $file
     * @param boolean                         $isInputFile
     * @param Streamwide_Media_Format         $format
     * @return void
     */
    private function _addFileToFFmpegCommand(Streamwide_Media_Command_FFmpeg $ffmpegCommand,
                                             $file,
                                             $isInputFile = true,
                                             Streamwide_Media_Format $format = null)
    {
        $options = array();
        
        $audioMapping = array(
            Streamwide_Media_Command_FFmpeg::AUDIO_BITRATE     => 'getBitRate',
            Streamwide_Media_Command_FFmpeg::AUDIO_CHANNELS    => 'getChannels',
            Streamwide_Media_Command_FFmpeg::AUDIO_CODEC       => 'getCodecName',
            Streamwide_Media_Command_FFmpeg::AUDIO_SAMPLE_RATE => 'getSampleRate'
        );

        $videoMapping = array();
        
        if (!is_null($format)) {
        
            // set duration
            $duration = 0;
            
            if (!is_null($format->getDuration())) {
                $duration = $format->getDuration();
            }
            
            if ($duration > 0) {
                $options[Streamwide_Media_Command_FFmpeg::DURATION] = $duration;
            }
            
            // set audio options
            $audioTrack = $format->getAudioTrack();
            
            if (!is_null($audioTrack)) {
                $codec = $audioTrack->getCodec();
                foreach($audioMapping as $option => $getMethod) {
                    $value = call_user_func(array($codec, $getMethod));
                    if (!is_null($value) && 'auto' != $value) {
                        $options[$option] = $value;
                    }
                }
            }
    
            $videoTrack = null;
            
            if ($format instanceof Streamwide_Media_Format_Video) {
                $videoTrack = $format->getVideoTrack();
            }
        }
        
        if ($isInputFile) {
            $ffmpegCommand->addInputFile($file, $options);
        } else {
            $ffmpegCommand->addOutputFile($file, $options);
        }
    }
    
    /**
     * Executes the conversion command.
     *
     * @param Streamwide_Media_Command_FFmpeg $command The command which will be executed
     * @return boolean true in case of success, false otherwise
     */
    protected function _executeConversion(Streamwide_Media_Command_FFmpeg $command, $destination)
    {
        $result = $command->run();
        var_dump($result);

        if (!file_exists($destination) || filesize($destination) == 0) {
            return false;
        }

        return true;
    }
}

/* EOF */