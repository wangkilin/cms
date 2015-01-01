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
 * @version    $Id: Abstract.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * FFmpeg generic command implementation.
 *
 * Specific FFmpeg implementation may have different
 * internal synopsis for option parameters.
 *
 * Usage:
 * <code>
 * $result = $command->addInputFile($inputFile)
 *                   ->addOutputFile($outputFile, $options)
 *                   ->run();
 * </code>
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
abstract class Streamwide_Media_Command_FFmpeg_Abstract extends Streamwide_Media_Command
{
    /**
     * Application name.
     *
     * @var string
     */
    protected $_applicationName = 'FFmpeg';
    
    /**
     * A short description of the application.
     *
     * @var string
     */
    protected $_applicationDescription = 'FFmpeg is a complete solution to record, convert and stream audio and video.';
    
    /**
     * Supported command versions.
     *
     * @var string
     */
    protected $_supportedVersions = '*';
    
    /**
     * Executable command name.
     *
     * @var string
     */
    protected $_commandName = 'ffmpeg';
    
    // FFmpeg specific members
    
    /**
     * Input files with options.
     *
     * @var array
     */
    protected $_inputFiles;
    
    /**
     * Output files with options.
     *
     * @var array
     */
    protected $_outputFiles;
    
    /*
     * Command options.
     */
    
    /**
     * General options.
     *
     * @var string
     */
    const DURATION          = 'duration';
    
    /**
     * Video options.
     *
     * @var string
     */
    const VIDEO_BITRATE      = 'video_bitrate';
    const VIDEO_FRAME_SIZE   = 'video_frame_size';
    const VIDEO_FRAME_RATE   = 'video_frame_rate';
    const VIDEO_ASPECT_RATIO = 'video_aspect_ratio';
    const VIDEO_CODEC        = 'video_codec';

    /**
     * Audio options.
     *
     * @var string
     */
    const AUDIO_BITRATE     = 'audio_bitrate';
    const AUDIO_SAMPLE_RATE = 'audio_sample_rate';
    const AUDIO_CHANNELS    = 'audio_channels';
    const AUDIO_CODEC       = 'audio_codec';
    
    /**
     * Predefined frame size formats.
     * Can be used with FRAME_SIZE option.
     *
     * @var array
     */
    protected $_frameSizeFormats = array();
    
    /**
     * Command tags for each option.
     *
     * @var array
     */
    protected $_optionTag = array();
    
    /**
     * Tags for input and output files.
     *
     * @var string
     */
    protected $_inputFileTag;
    protected $_outputFileTag;
    
    /**
     * Add an input file.
     *
     * Options
     *
     * General options:
     * DURATION           integer duration in ms
     *
     * Video options:
     * VIDEO_BITRATE      integer bitrate in bits
     * VIDEO_FRAME_SIZE   array   array(width, height)
     *                    string  a predefined frame size (@see self::_frameSizeFormats)
     * VIDEO_FRAME_RATE   integer frame rate in frames per second
     * VIDEO_ASPECT_RATIO float   eg: 1.3333
     *                    string  eg: 16:9
     * VIDEO_CODEC        string  video codec
     *
     * Audio options:
     * AUDIO_BITRATE      integer bitrate in bits
     * AUDIO_SAMPLE_RATE  integer audio sampling freq in Hz
     * AUDIO_CHANNELS     integer audio channels 1 or 2
     * AUDIO_CODEC        string  audio codec
     *
     * @param string $filename file name
     * @param string $options  (optional) associative array with options
     * @return void
     */
    public function addInputFile($filename, $options = null)
    {
        if (!is_null($options)) {
            $this->_validateOptions($options);
        } else {
            $options = array();
        }
        $this->_inputFiles[$filename] = $options;
    }
    
    /**
     * Add an output file.
     *
     * Options
     *
     * General options:
     * DURATION           integer duration in ms
     *
     * Video options:
     * VIDEO_BITRATE      integer bitrate in bits
     * VIDEO_FRAME_SIZE   array   array(width, height)
     *                    string  a predefined frame size (@see self::_frameSizeFormats)
     * VIDEO_FRAME_RATE   integer frame rate in frames per second
     * VIDEO_ASPECT_RATIO float   eg: 1.3333
     *                    string  eg: 16:9
     * VIDEO_CODEC        string  video codec
     *
     * Audio options:
     * AUDIO_BITRATE      integer bitrate in bits
     * AUDIO_SAMPLE_RATE  integer audio sampling freq in Hz
     * AUDIO_CHANNELS     integer audio channels 1 or 2
     * AUDIO_CODEC        string  audio codec
     *
     * @param string $filename file name
     * @param string $options  (optional) associative array with options
     * @return void
     */
    public function addOutputFile($filename, $options = null)
    {
        if (!is_null($options)) {
            $this->_validateOptions($options);
        } else {
            $options = array();
        }
        $this->_outputFiles[$filename] = $options;
    }
    
    /**
     * Gets the input files.
     *
     * @return array
     */
    public function getInputFiles()
    {
        return $this->_inputFiles;
    }
    
    /**
     * Gets the output files.
     *
     * @return array
     */
    public function getOutputFiles()
    {
        return $this->_outputFiles;
    }
    
    /**
     * Validates an array of options.
     *
     * @param array $options
     * @return void
     */
    protected function _validateOptions($options)
    {
        foreach ($options as $option => $value)
        {
            $this->_validateOptionValue($option, $value);
        }
    }
    
    /**
     * Gets a raw media file info output.
     * You must parse the output to use the returned data.
     *
     * @param string $filename file name
     * @return string
     */
    abstract public function getFileInfo($filename);
        
    /**
     * Prepares and returns the command.
     *
     * @return string the full command
     */
    public function getCommand()
    {
        $parts = array();

        $parts[] = $this->_commandPath . '/' . $this->_commandName;
        
        // add input files
        foreach ($this->_inputFiles as $inputFile => $options) {
            $this->_addFileParts($parts, $inputFile, true, $options);
        }
        // add output files
        foreach ($this->_outputFiles as $outputFile => $options) {
            $this->_addFileParts($parts, $outputFile, false, $options);
        }
        
        $command = join(' ', $parts);
        
        return $command;
    }
    
    /**
     * Adds a file parts to the end of an array of command parts.
     *
     * @param array   &$parts      array of parts
     * @param string  $file        file name
     * @param boolean $isInputFile whether the file is an input file or not
     * @param array   $options     file options
     * @return void
     */
    private function _addFileParts(&$parts, $file, $isInputFile, $options)
    {
        // add options
        foreach($options as $option => $value) {
            $parts[] = $this->_optionTag[$option];
            $parts[] = $this->_prepareOptionValue($option, $value);
        }
        
        // add input or output file tag
        $tag = $isInputFile ? $this->_inputFileTag : $this->_outputFileTag;
        if (!empty($tag)) {
            $parts[] = $tag;
        }
        // add file name
        $parts[] = $file;
    }
    
    /**
     * Validates an option value.
     *
     * @param string $aspectRatio
     * @return boolean true if the parameter is valid
     * @throws Streamwide_Media_Exception when option is not valid
     */
    protected function _validateOptionValue($option, $value)
    {
         switch($option) {
             case self::AUDIO_BITRATE:
                 if (is_int($value) && $value > 0) {
                     return true;
                 }
                 throw new Streamwide_Media_Exception(self::AUDIO_BITRATE . ' must be a positive integer');
                 break;
                 
             case self::AUDIO_CHANNELS:
                 if ($value === 1 || $value === 2) {
                     return true;
                 }
                 throw new Streamwide_Media_Exception(self::AUDIO_CHANNELS . ' must be 1 or 2');
                 break;
                 
             case self::AUDIO_CODEC:
                 if (is_string($value)) {
                     return true;
                 }
                 throw new Streamwide_Media_Exception(self::AUDIO_CODEC . ' must be a string');
                 break;
                 
             case self::AUDIO_SAMPLE_RATE:
                 if (is_int($value) && $value > 0) {
                     return true;
                 }
                 throw new Streamwide_Media_Exception(self::AUDIO_SAMPLE_RATE . ' must be a positive integer');
                 break;
                 
             case self::DURATION:
                 if (is_int($value) && $value > 0) {
                     return true;
                 }
                 throw new Streamwide_Media_Exception(self::DURATION . ' must be a positive integer');
                 break;
                 
             case self::VIDEO_ASPECT_RATIO:
                 if (is_float($value)) {
                     return true;
                 }
                 if (is_string($value) && preg_match('/^\d+:\d+$/', $value)) {
                     return true;
                 }
                 throw new Streamwide_Media_Exception(self::VIDEO_ASPECT_RATIO . ' must be a \'w:h\' string or an int');
                 break;
                 
             case self::VIDEO_BITRATE:
                 if (is_int($value) && $value > 0) {
                     return true;
                 }
                 throw new Streamwide_Media_Exception(self::VIDEO_BITRATE . ' must be a positive integer');
                 break;
                 
             case self::VIDEO_CODEC:
                 if (is_string($value)) {
                     return true;
                 }
                 throw new Streamwide_Media_Exception(self::VIDEO_CODEC . ' must be a string');
                 break;
                 
             case self::VIDEO_FRAME_RATE:
                 if (is_int($value) && $value > 0) {
                     return true;
                 }
                 throw new Streamwide_Media_Exception(self::VIDEO_FRAME_RATE . ' must be a positive integer');
                 break;
                                  
             case self::VIDEO_FRAME_SIZE:
                 if (is_string($value)) {
                     if(in_array($value, array_keys($this->_frameSizeFormats))) {
                         return true;
                     }
                 }
                 if (is_array($value) && 2 == count($value) && is_int($value[0]) && is_int($value[1])) {
                     return true;
                 }
                 throw new Streamwide_Media_Exception(self::VIDEO_FRAME_SIZE . ' must be an array of the format (width, height) or a predefined frame size');
                 break;
                 
             default:
                 throw new Streamwide_Media_Exception('Unknown FFmpeg option: ' . $option);
                 break;
         }
    }
    
    /**
     * Transforms an option value to the syntax
     * required for running the command.
     *
     * @param string $option option name
     * @param mixed  $value  value
     * @return mixed transformed value
     */
    protected function _prepareOptionValue($option, $value)
    {
        switch($option) {
            
            case self::DURATION:
            case self::AUDIO_BITRATE:
            case self::VIDEO_BITRATE:
                 $newvalue = $value / 1000;
                 break;
                  
             case self::VIDEO_FRAME_SIZE:
                 if (is_string($value)) {
                     $newvalue = $this->_frameSizeFormats[$value];
                 } else {
                     $newvalue = $value[0] . 'x' . $value[1];
                 }
                 break;
                 
             default:
                 $newvalue = $value;
                 break;
        }
        
        return $newvalue;
    }
    
    /**
     * Gets the frame size predefined formats.
     *
     * @return string
     */
    public function getPredefinedFrameSizeFormats()
    {
        return $this->_frameSizeFormats;
    }
}

/* EOF */