<?php
/**
 * Class that provides various transformations for video files:
 * conversion, mix, concatenate.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 * @subpackage Streamwide_Media_Video
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Cosmin STOICA <cstoica@streamwide.ro>
 * @version    $Id: Video.php 1962 2009-09-24 20:49:25Z rgasler $
 */

require_once 'Streamwide/Media/Abstract.php';

/**
 * class Streamwide_Media_Video
 *
 */
class Streamwide_Media_Video extends Streamwide_Media_Abstract
{
    /**
     * How many secconds from original file will be converted.
     * If null, entire media file will be converted.
     *
     * @var integer
     */
    protected $_duration = 0;

    /**
     * The frame rate of the file obtained after conversion.
     * Default value is 25
     *
     * @var integer
     */
    protected $_frameRate = 25;

    /**
     * The audio sample rate of the file obtained after conversion.
     *
     * @var integer
     */
    protected $_sampleRate = 44100;


    /**
     * The sample bit rate (in kbites) of the video stream obtained after conversion.
     * Default value for ffmpeg is 200
     *
     * @var integer
     */
    protected $_videoBitRate = '200k';

    /**
     * The sample bit rate (in kbites) of the audio stream obtained after conversion.
     * Default value for fffmpeg is 200
     *
     * @var integer
     */
    protected $_audioBitRate = '12.2k';

    /**
     * How many channels the audio file has: 1 - mono, 2 stereo.
     *
     * @var integer
     */
    protected $_channels = 2;

    /**
     * The size of video window.
     * Default value is 176x144 (qcif standard)
     *
     * @var integer
     */
    protected $_size = '176x144';

    /**
     * The video types for which the conversion is supported from one to another.
     *
     * @var array
     */
    protected $_supportedTypes = array('3gp', 'flv', 'wmv');


    /**
     * Class constructor
     *
     * @param string $source  (optional) The file which needs to be converted
     * @param array  $options (optional) An associative array of options
     */
    public function __construct($source = null, $options = null)
    {
        parent::__construct($source, $options);
    }

    /**
     * Sets how many seconds from the original file will be converted.
     *
     * @param integer $duration duration
     * @return bool true on success, false on error
     */
    public function setDuration($duration)
    {
        if (!is_int($duration) || $duration < 0) {
            return false;
        }

        $this->_duration = $duration;

        return true;
    }

    /**
     * Return the number of seconds set as duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->_duration;
    }

    /**
     * Sets the sample rate of the new file.
     *
     * @param integer $sampleRate sample rate
     * @return bool true on success, false on error
     */
    public function setSampleRate($sampleRate)
    {
        if (!is_int($sampleRate) || $sampleRate < 0) {
            return false;
        }

        $this->_sampleRate = $sampleRate;

        return true;
    }

    /**
     * Returns the sample rate.
     *
     * @return integer
     */
    public function getSampleRate()
    {
        return $this->_sampleRate;
    }

    /**
     * Sets the frame rate of the new file.
     *
     * @param integer $frameRate frame rate
     * @return bool true on success, false on error
     */
    public function setFrameRate($frameRate)
    {
        if (!is_int($frameRate) || $frameRate < 0) {
            return false;
        }

        $this->_frameRate = $frameRate;

        return true;
    }

    /**
     * Returns the frame rate.
     *
     * @return integer
     */
    public function getFrameRate()
    {
        return $this->_frameRate;
    }

    /**
     * Sets the video bit rate of the new file.
     *
     * @param integer $bitRate bit rate in kbites
     * @return bool true on success, false on error
     */
    public function setVideoBitRate($bitRate)
    {
        if (!is_int($bitRate) || $bitRate < 0) {
            return false;
        }

        $this->_videoBitRate = $bitRate . 'k';

        return true;
    }

    /**
     * Returns the video sample rate.
     *
     * @return integer
     */
    public function getVideoBitRate()
    {
        return $this->_videoBitRate;
    }

    /**
     * Sets the audio bit rate of the new file.
     *
     * @param integer $bitRate bit rate in kbites
     * @return bool true on success, false on error
     */
    public function setAudioBitRate($bitRate)
    {
        if (!is_int($bitRate) || $bitRate < 0) {
            return false;
        }

        $this->_audioBitRate = $bitRate . 'k';

        return true;
    }

    /**
     * Returns the audio sample rate.
     *
     * @return integer
     */
    public function getAudioBitRate()
    {
        return $this->_audioBitRate;
    }

    /**
     * Sets the size of video window.
     *
     * @param integer $width  window width
     * @param integer $height window height
     * @return bool true on success, false on error
     */
    public function setSize($width, $height)
    {
        if (
            !is_int($width) || $width < 0
            && !is_int($height) || $height < 0
        ) {
            return false;
        }

        // we store the size in a special format
        $this->_size = $width . 'x' . $height;

        return true;
    }

    /**
     * Returns the video window size size.
     *
     * @return array|null array with 2 elements: width, height or null if ize is invalid
     */
    public function getSize()
    {
        $sizeItems = explode('x', $this->_size);

        $result = (count($sizeItems) == 2) ? $sizeItems : null;

        return $result;
    }

    /**
     * Sets the number of channels.
     *
     * @param integer $channels number of channels
     * @return bool true on success, false on error
     */
    public function setChannels($channels)
    {
        if ($channels !== 1 && $channels !== 2) {
            return false;
        }

        $this->_channels = $channels;

        return true;
    }

    /**
     * Returns the number of channels.
     *
     * @return integer
     */
    public function getChannels()
    {
        return $this->_channels;
    }

    /**
     * Converts a file to the specified type and stores it in the given destination.
     *
     * @param string $type        file type
     * @param string $destination destination file
     * @return string|boolean The name of the file obtained after conversion, in case of success;
     * 						  false if the conversion has failed.
     * @throws Streamwide_Media_Exception
     */
    public function convert($type, $destination = null)
    {
        // check if a source file was set
        if (is_null($this->_source)) {
            throw new Streamwide_Media_Exception('A source file must be specified first.');
        }

        $type = strtolower($type);

        // check if provided type is supported
        if (!$this->_isSupportedType($type)) {
            throw new Streamwide_Media_Exception('Conversion from ' . $this->_type . ' to ' . $type . ' is not supported.');
        }

        // set the destination for the file obtained after conversion
        $this->_setDestination($type, $destination);

        // check if the destination can be overwritten in case it exists
        $this->_checkOverwriteState();

        switch ($type) {
            case '3gp':
                $result = $this->_convertTo3Gp();
                break;

            case 'flv':
                $result = $this->_convertToFlv();
                break;

            case 'wmv':
                $result = $this->_convertToWmv();
                break;

            default :
                // do nothing
                break;
        }

        // check if the conversion was made
        if (!$result) {
            return false;
        }

        return $this->_destination;
    }

    /**
     * Concatenate a file to the end of the current one.
     *
     * @param string $file        The file which will be concatenated.
     * @param string $destination The destination file.
     * @return string|boolean The name of the file obtained after the concatenation
     *                        or false if the concatenation failed.
     * @throws Streamwide_Media_Exception
     */
    public function join($file, $destination = null)
    {
        // check if a source file was set
        if (is_null($this->_source)) {
            throw new Streamwide_Media_Exception('A source file must be specified first.');
        }

        $this->_checkFile($file);

        // try detecting the type of the file which will be concatenaded to the current one
        $type = $this->_detectFileType($file);

        // check wether ffmpeg supports provided file types
        if ($this->_isSupportedType($this->_type) || $this->_isSupportedType($type)) {
            throw new Streamwide_Media_Exception('Provided file format is not supported.');
        }

        // the type of the files which will be concatenated should be the same
        if ($type != $this->_type) {
            throw new Streamwide_Media_Exception('Files having different types can not be concatenated.');
        }

        // set the destination for the file obtained after conversion
        $this->_setDestination($type, $destination);

        // check if the destination can be overwritten in case it exists
        $this->_checkOverwriteState();

        $command = "cat $this->_source $file > $this->_destination";

        // execute the command
        $result = ($this->_executeConversion($command)) ? $this->_destination : false;

        return $result;
    }

    /**
     * Mix a file with the current one.
     * The result will have duration of the longest one, if no duration is set
     *
     * @param string $mixFile     The file which will be concatenated.
     * @param string $destination (optional) The destination file.
     * @return string|boolean The name of the file obtained after the concatenation
     * 						  or false if the concatenation failed.
     * @throws Streamwide_Media_Exception
     */
    public function mix($mixFile, $destination = null)
    {
        // check if a source file was set
        if (is_null($this->_source)) {
            throw new Streamwide_Media_Exception('A source file must be specified first.');
        }

        $this->_checkFile($file);

        // try detecting the type of the file which will be concatenaded to the current one
        $type = $this->_detectFileType($file);

        // check wether ffmpeg supports provided file types
        if ($this->_isSupportedType($this->_type) || $this->_isSupportedType($type)) {
            throw new Streamwide_Media_Exception('Provided file format is not supported.');
        }

        // the type of the files which will be concatenated should be the same
        if ($type != $this->_type) {
            throw new Streamwide_Media_Exception('Files having different types can not be concatenated.');
        }

        // set the destination for the file obtained after conversion
        $this->_setDestination($type, $destination);

        // check if the destination can be overwritten in case it exists
        $this->_checkOverwriteState();

        $command = $this->_getFfmpegPath() . $this->_buildCommand(array($this->_source, $file), $this->_destination);

        // execute the command
        $result = ($this->_executeConversion($command)) ? $this->_destination : false;

        return $result;
    }

    /**
     * Converts the source file to 3gp.
     *
     * @return string|bool The name of the file obtained after conversion or false if the conversion has failed.
     */
    private function _convertTo3Gp()
    {
        // the 3gp conversion requires some fixed parameters
        $this->_size = 'qcif';
        $this->_sampleRate = 8000;
        $this->_channels = 1;

        // build command
        $command = $this->_buildCommand($this->_source, $this->_destination, true);

        // customize command by forcing output format
        $command = sprintf($command, '-f 3gp');

        // execute the command
        return $this->_executeConversion($command);
    }

    /**
     * Converts the source file to flv.
     *
     * @return string|bool The name of the file obtained after conversion or false if the conversion has failed.
     */
    private function _convertToFlv()
    {
        // build command
        $command = $this->_buildCommand($this->_source, $this->_destination);

        // execute the command
        return $this->_executeConversion($command);
    }

    /**
     * Converts the source file to wmv.
     *
     * @return string|bool The name of the file obtained after conversion or false if the conversion has failed.
     */
    private function _convertToWmv()
    {
        // build command
        $command = $this->_buildCommand($this->_source, $this->_destination, true);

        // customize command by forcing video codec
        $command = sprintf($command, '-vcodec wmv2');
        
        // execute the command
        return $this->_executeConversion($command);
    }

    /**
     * Bulid the ffmpeg command based on given params and the class properties such
     * as size, bitrate.
     *
     * @param array   $source      source files
     * @param string  $destination destination file
     * @param boolean $changeable  if is set to true then the comand will contain
     * 							   a string place holder(%s) for using sprintf function
     * @return string ffmpeg command
     */
    private function _buildCommand($source, $destination, $changeable = false)
    {
        $cmd = $this->_getFfmpegPath() . 'ffmpeg ';

        // build source(s)
        $cmd .= (is_array($source)) ? implode( '-i ', $source) : '-i ' . $source;

        // set the cmd options
        $cmd .= ($this->_duration > 0) ? ' -t ' . $this->_duration : '';
        $cmd .= ($this->_sampleRate > 0) ? ' -ar ' . $this->_sampleRate : '';
        $cmd .= ($this->_frameRate > 0) ? ' -r ' . $this->_frameRate : '';
        $cmd .= ($this->_videoBitRate > 0) ? ' -b ' . $this->_videoBitRate : '';
        $cmd .= ($this->_audioBitRate > 0) ? ' -ab ' . $this->_audioBitRate : '';
        $cmd .= ($this->_size != '') ? ' -s ' . $this->_size : '';
        $cmd .= ($this->_channels > 0) ? ' -ac ' . $this->_channels : '';
        $cmd .= ' -sameq '; // keep the same quality as sources have

        $cmd .= (true == $this->_options['overwriteDestination']) ? ' -y ' : ''; // overwrite destination

        // add the possibility to inject extra options using spritf
        $cmd .= ($changeable) ? ' %s ' : '';

        // set the output file(destination)
        $cmd .= ' ' . $destination;

        return $cmd;
    }
}

/* EOF */