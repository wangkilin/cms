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
 * @subpackage Streamwide_Media_Decoder
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: FFmpeg.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Media decoder using FFmpeg command.
 *
 * @package    Streamwide_Media
 * @subpackage Streamwide_Media_Decoder
 */
class Streamwide_Media_Decoder_FFmpeg implements Streamwide_Media_Decoder_Interface
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
     * Format mapper. (maps file extensions to media formats)
     */
    protected $_formatMapper;
    
    /**
     * Default format mapper.
     *
     * @var Streamwide_Media_Format_Mapper_Interface
     */
    protected $_defaultFormatMapper = 'Streamwide_Media_Format_Mapper';
    
    /**
     * Constructor.
     *
     * @param Streamwide_Media_Command_FFmpeg_Abstract $command
     * @param Streamwide_Media_Format_Mapper_Interface $mapper
     */
    public function __construct(
        Streamwide_Media_Command_FFmpeg_Abstract $command = null,
        Streamwide_Media_Format_Mapper_Interface $mapper = null
    )
    {
        if (is_null($command)) {
            $command = new $this->_defaultFFmpegCommand;
        }
        if (is_null($mapper)) {
            $mapper = new $this->_defaultFormatMapper;
        }
        
        $this->_ffmpegCommand = $command;
        $this->_formatMapper = $mapper;
    }
    
    /**
     * Decodes a media file format and transforms it
     * into a Streamwide_Media_Format object
     *
     * @param string $file media file to decode
     * @return Streamwide_Media_Format
     */
    public function decodeFormat($file)
    {
        $output = $this->_ffmpegCommand->getFileInfo($file);

        $arrayFormat = $this->_parse($output['stderr']);
        
        if (!$arrayFormat) {
            throw new Streamwide_Media_Exception('Failed decoding the file format: ' . $file);
        }
        
        // set the media type
        $arrayFormat['type'] = pathinfo($file, PATHINFO_EXTENSION);
        
        return $this->_newFormatFromArray($arrayFormat);
    }
    
    /**
     * Parses raw text command output and returns
     * an array representation of a media format.
     *
     * @return array|boolean returns false when input text cannot be parsed
     */
    protected function _parse($text)
    {
        /* The parser expects the following format:
          Input #0 .*:
            Duration: %duration(hh:mm:ss.ss), .*'
              Stream #0.%track: %type(Video/Audio): %data'
 
          The %data can be:
              Video: %codec, %frameSize (WxH), %bitRate kb/s, %frameRate tbr
              Audio: %codec, %sampleRate Hz, %channels (mono|stereo), %bitRate kb/s
         */
        
        /* Parse algorithm:
           seek in all text Input #0
           go to next line
           seek Duration: %duration (hh:mm:ss.ss)
           for each following line
              get the stream type with a regexp (Audio/Video)
              get the other data with a regexp (based on stream type)
         */
        
        $start = strpos($text, 'Input #0');

        $format = array();

        if ($start) {
            $content = substr($text, $start);

            $lines = explode("\n", $content);

            // get duration
            $durationLine = $lines[1];

            preg_match('/Duration: (\d\d):(\d\d):(\d\d).(\d\d)/', $durationLine, $matches);

            if (5 == count($matches)) {
                list($all, $hours, $minutes, $seconds, $miliseconds) = $matches;
                
                $format['duration'] = (float) ($hours * 3600 + $minutes * 60 + $seconds + $miliseconds / 100);

                $format['streams'] = array();

                // parse streams
                for ($i = 2; $i; $i++) {
                    if (preg_match('/Stream #0.\d: (Audio|Video):/', $lines[$i], $matches)) {
                        if ('Audio' == $matches[0]) {
                            // Audio track
                            preg_match('//', $lines[$i], $matches);
                        } else {
                            // Video track
                            preg_match('//', $lines[$i], $matches);
                        }
                    } else {
                        break;
                    }
                }
                
                return $format;
            }
        }
        
        return false;
    }
    
    /**
     * Creates a new Streamwide_Media_Format from
     * an array representation of the format.
     *
     * @param array $arrayFormat
     * @return Streamwide_Media_Format_Audio|Streamwide_Media_Format_Video
     */
    protected function _newFormatFromArray(Array $arrayFormat)
    {
        $formatClass = $this->_formatMapper->getFormat($arrayFormat['type']);
        
        $format = new $formatClass;
        
        $format->setDuration($arrayFormat['duration']);
        
        // TODO: add tracks
        
        return $format;
    }
    
    /**
     * Set the ffmpeg command object.
     *
     * @param Streamwide_Command_FFmpeg $command
     * @return Streamwide_Media_Converter_FFmpeg *Provides a fluid interface*
     */
    public function setFFmpegCommand(Streamwide_Command_FFmpeg $command)
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
}

/* EOF */