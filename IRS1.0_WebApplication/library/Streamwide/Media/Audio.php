<?php
/**
 * Class that provides various transformations for audio files:
 * conversion, mix, concatenate.
 *
 * $Rev: 2457 $
 * $LastChangedDate: 2010-03-27 00:21:19 +0800 (Sat, 27 Mar 2010) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 * @subpackage Streamwide_Media_Audio
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Cosmin STOICA <cstoica@streamwide.ro>
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Audio.php 2457 2010-03-26 16:21:19Z rgasler $
 */

require_once 'Streamwide/Media/Abstract.php';

/**
 * class Streamwide_Media_Audio
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
class Streamwide_Media_Audio extends Streamwide_Media_Abstract
{
    const MONO = 1;
    const STEREO = 2;

    /**
     * How many secconds from original file will be converted. If null, entire media file will be converted.
     * @var integer
     */
    protected $_duration = 0;

    /**
     * How many channels the audio file has: 1 - mono, 2 stereo.
     * @var integer
     */
    protected $_channels = self::MONO;

    /**
     * The sample rate of the file obtained after conversion.
     * @var integer
     */
    protected $_sampleRate = 8000;

    /**
     * The audio bit rate of the file obtained after conversion.
     * @var integer
     */
    protected $_bitRate = 8;

    /**
     * The audio types for which the conversion is supported from one to another.
     * @var array
     */
    protected $_supportedTypes = array('wav', 'al', 'mp3', 'wma', 'amr');

    /**
     * The join and mix of the audio files are done using SOX, but there are
     * file types unsupported by SOX.
     * @var array
     */
    protected $_unsupportedSoxTypes = array('wma');

    /**
     * Class constructor
     *
     * @param string $source  The file which need to be converted
     * @param array  $options Associative array of options
     */
    public function __construct($source = null, $options = null)
    {
        parent::__construct($source, $options);
    }

    /**
     * Sets how many seconds from the original file will be converted.
     *
     * @param integer $duration duration
     * @return boolean true on success, false on error
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
     * Sets the number of channels.
     *
     * @param integer $channels number of channels
     * @return bool true on success, false on error
     */
    public function setChannels($channels)
    {
        if ($channels !== self::MONO && $channels !== self::STEREO) {
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
     * Sets the sample rate of the new file.
     *
     * @param integer $sampleRate sample rate
     * @return boolean true on success, false on error
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
     * Sets the bit rate of the new file.
     *
     * @param integer $bitRate bit rate
     * @return boolean true on success, false on error
     */
    public function setBitRate($bitRate)
    {
        if (!is_int($bitRate) || $bitRate < 0) {
            return false;
        }

        $this->_bitRate = $bitRate;

        return true;
    }

    /**
     * Returns the sample rate.
     *
     * @return integer
     */
    public function getBitRate()
    {
        return $this->_bitRate;
    }

    /**
     * Converts a file to the specified type and stores it in the given destination.
     *
     * @param string $type        File type
     * @param string $destination The destination file/folder
     * @return string|boolean The name of the file obtained after conversion, in case of success;
     *                        false if the conversion has failed.
     * @throws Streamwide_Media_Exception When source file has not yet been specified.
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

            case 'al':
                $result = $this->_convertToAl();
                break;
                
            case 'amr':
                $result = $this->_convertToAmr();
                break;

            case 'mp3':
                $result = $this->_convertToMp3();
                break;
                
            case 'wav':
                $result = $this->_convertToWav();
                break;

            case 'wma':
                $result = $this->_convertToWma();
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
     * @return string|boolean The name of the file obtained after the concatenation or
     * 						  false if the concatenation failed.
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

        // check wether sox supports provided file types
        if ($this->_isUnsupportedSoxType($this->_type) || $this->_isUnsupportedSoxType($type)) {
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

        // get the path to the Sox application
        $soxPath = $this->_getSoxPath();

        /* if the destination file is one of the files used in the join process then
         * the file obtained after joining these files will be stored in a temporary
         * location then it will be moved to its final destination - this way we avoid conflicts
         * generated when trying to overwrite a file which is in use
         */
        if ($this->_source == $this->_destination || $file == $this->_destination) {
            $destinationFile = basename($this->_destination);
            $tmpDestination = $this->_prepareDirectory($this->_options['tmpDirectory']) . $destinationFile;
            $command = $soxPath . 'sox --combine concatenate ' . $this->_source . ' ' . $file . ' ' . $tmpDestination . ';';
            $command .= 'mv ' . $tmpDestination . ' ' . $this->_destination;
        } else {
            $command = $soxPath . 'sox --combine concatenate ' . $this->_source . ' ' . $file . ' ' . $this->_destination;
        }

        // execute the command
        $result = $this->_execute($command);

        // check if the files were joined and the destination file exists
        if (!file_exists($this->_destination) || filesize($this->_destination) == 0) {
            return false;
        }

        return $this->_destination;
    }

    /**
     * This method mixes the given file over the current one.
     *
     * @param string  $mixFile       File to mix
     * @param string  $destination   The destination file/folder
     * @param boolean $repeatMixFile Whether to reapeat the mix file while the source file is played
     * @return string The destination Where the resulted file was stored.
     */
    public function mix($mixFile, $destination = null, $repeatMixFile = false)
    {
        // check if a source file was set
        if (is_null($this->_source)) {
            throw new Streamwide_Media_Exception('A source file must be specified first.');
        }

        $this->_checkFile($mixFile);

        // try detecting the type of the file which will be mixed with the current one
        $mixFileType = $this->_detectFileType($mixFile);

        // check wether sox supports provided file types
        if ($this->_isUnsupportedSoxType($this->_type) || $this->_isUnsupportedSoxType($mixFileType)) {
            throw new Streamwide_Media_Exception('Provided file format is not supported.');
        }

        // the type of the files which will be mixed should be the same
        if ($mixFileType != $this->_type) {
            throw new Streamwide_Media_Exception('Files having different types can not be mixed.');
        }

        // set the destination for the file obtained at the end of the mix process
        $this->_setDestination($mixFileType, $destination);

        // check if the destination can be overwritten in case it exists
        $this->_checkOverwriteState();

        // get the path to the Sox application
        $soxPath = $this->_getSoxPath();

        // get the volume of the source media file - it will be used for adjusting the volume
        // of the resulted file
        $sourceFileVolume = $this->_getFileVolume($this->_source);

        // if the mixFile don't has to be repeated while the source file is played
        // we just mix the two files together; otherwise we have to see for how many
        // times the mix file can be repeated.
        if ($repeatMixFile) {
            // get the length of the two files
            $sourceFileLength = $this->getFileLength($this->_source);
            $mixFileLength = $this->getFileLength($mixFile);

            // we have to build a temporary mix file having the same length as the source
            // we will concatenate the mixFile with itself until the length of this temporary
            // file became greater than the source length then we will cut the temporary file
            // for exactly matching with the source length
            $tempMixFile = $this->_generateTmpFileName($mixFileType);
            $tempFile = $this->_generateTmpFileName($mixFileType);

            $createTempMixFileCommands = 'cp ' . $mixFile . ' ' . $tempMixFile . ';';
            $createTempMixFileCommands .= 'cp ' . $mixFile . ' ' . $tempFile . ';';

            // find out many times the mix file should be repeated to cover the source length
            $repetitionsNumber = ceil($sourceFileLength/$mixFileLength);

            // concatenate the mixFile to the tempMixFile as many times as needed
            for ($i = 1; $i < $repetitionsNumber; $i++) {
                $createTempMixFileCommands .= ' ' . $soxPath . 'sox --combine concatenate ' . $tempMixFile . ' ' . $mixFile . ' ' . $tempFile . ';';
                $createTempMixFileCommands .= 'mv ' . $tempFile . ' ' . $tempMixFile . ';';
            }

            // cut the tempMixFile to the same length as the source
            $createTempMixFileCommands .= $soxPath . 'sox ' . $tempMixFile . ' ' . $tempFile . ' trim 0 ' . $sourceFileLength . ';';
            $createTempMixFileCommands .= 'mv ' . $tempFile . ' ' . $tempMixFile . ';';

            $this->_execute($createTempMixFileCommands);

            // check if the mixFile was created
            if (!file_exists($tempMixFile)) {
                return false;
            }

            $mixFile = $tempMixFile;
        }
        
        // if we mix al files add additional parameters
        $mixOptions = ('al' == $this->_type) ? ' -c 1 -r 8000 ' : '';

        // add the tempMixFile over the source file
        if ($this->_source == $this->_destination || $mixFile == $this->_destination) {
            $destinationFile = basename($this->_destination);
            $tmpDestination = $this->_prepareDirectory($this->_options['tmpDirectory']) . $destinationFile;
            
            $mixCommands = $soxPath . 'sox -m ' . $mixOptions . $this->_source . ' ' . $mixOptions . $mixFile . ' ' . $tmpDestination . ' vol ' . $sourceFileVolume . ';';
            $mixCommands .= 'mv ' . $tmpDestination . ' ' . $this->_destination;
        } else {
            $mixCommands = $soxPath . 'sox -m ' . $mixOptions . $this->_source . ' ' . $mixOptions . $mixFile . ' ' . $this->_destination . ' vol ' . $sourceFileVolume;
        }

        $this->_execute($mixCommands);

        // check if temporary files were needed and delete them
        if (isset($tempMixFile)) {
            @unlink($tempMixFile);
        }

        // check if the mix was made
        if (!file_exists($this->_destination)) {
            return false;
        }

        return $this->_destination;
    }

    /**
     * Converts the source file to wav.
     *
     * @return string|bool The name of the file obtained after conversion or false if the conversion has failed.
     */
    private function _convertToWav()
    {
        $duration = ($this->_duration > 0) ? '-t ' . $this->_duration : '';

        switch ($this->_type) {
            case 'al':
                // when converting from al sample rate must be set for input file
                $command = $this->_getFfmpegPath() . 'ffmpeg -ar 8000 -i ' . $this->_source . ' ';
                $command .= $duration . ' -ab ' . $this->_bitRate . 'k -ar ' . $this->_sampleRate . ' ';
                $command .= '-ac ' . $this->_channels . ' ' . $this->_destination;
                break;

            case 'amr':
            case 'mp3':
            case 'wav':
            case 'wma':
                $command = $this->_getFfmpegPath() . 'ffmpeg -i ' . $this->_source . ' ';
                $command .= $duration . ' -ab ' . $this->_bitRate . 'k -ar ' . $this->_sampleRate . ' ';
                $command .= '-ac ' . $this->_channels . ' ' . $this->_destination;
                break;

            default :
                // do nothing
                break;
        }

        // execute the command
        return $this->_executeConversion($command);
    }

    /**
     * Converts the source file to al.
     *
     * @return string|bool The name of the file obtained after conversion or false if the conversion has failed.
     */
    private function _convertToAl()
    {
        $duration = ($this->_duration > 0) ? '-t ' . $this->_duration . ' ' : '';

        switch ($this->_type) {
            case 'al':
                // when converting from al sample rate must be set for input file
                $command = $this->_getFfmpegPath() . 'ffmpeg -ar 8000 -i ' . $this->_source . ' ';
                $command .= $duration . ' -ab ' . $this->_bitRate . 'k -ar 8000 ';
                $command .= '-ac 1 -acodec pcm_alaw ' . $this->_destination;
                break;

            case 'amr':
            case 'mp3':
            case 'wav':
            case 'wma':
                $command = $this->_getFfmpegPath() . 'ffmpeg -i ' . $this->_source . ' ';
                $command .= $duration . ' -ab ' . $this->_bitRate . 'k -ar 8000 ';
                $command .= '-ac 1 -acodec pcm_alaw ' . $this->_destination;
                break;

            default :
                // do nothing
                break;
        }

        // execute the command
        return $this->_executeConversion($command);
    }

    /**
     * Converts the source file to amr.
     *
     * @return string|bool The name of the file obtained after conversion or false if the conversion has failed.
     */
    private function _convertToAmr()
    {
        $duration = ($this->_duration > 0) ? '-t ' . $this->_duration . ' ' : '';

        switch ($this->_type) {
            case 'al':
                // when converting from al sample rate must be set for input file
                // amr supports only 8000 Hz sample rate, mono channel and max 12.2k bitrate,
                $command = $this->_getFfmpegPath() . 'ffmpeg -ar 8000 -i ' . $this->_source;
                $command .= ' -ar 8000 -ac 1 -ab 12.2k ';
                $command .= $duration .  $this->_destination;
                break;
                
            case 'amr':
            case 'mp3':
            case 'wav':
            case 'wma':
                // amr supports only 8000 Hz sample rate, mono channel and max 12.2k bitrate,
                $command = $this->_getFfmpegPath() . 'ffmpeg -i ' . $this->_source;
                $command .= ' -ar 8000 -ac 1 -ab 12.2k ';
                $command .= $duration .  $this->_destination;
                break;

            default :
                // do nothing
                break;
        }

        // execute the command
        return $this->_executeConversion($command);
    }
    
    /**
     * Converts the source file to mp3.
     *
     * @return string|bool The name of the file obtained after conversion or false if the conversion has failed.
     */
    private function _convertToMp3()
    {
        $duration = ($this->_duration > 0) ? '-t ' . $this->_duration . ' ' : '';

        switch ($this->_type) {
            case 'al':
                // when converting from al sample rate must be set for input file
                $command = $this->_getFfmpegPath() . 'ffmpeg -ar 8000 -i ' . $this->_source . ' ';
                $command .= $duration . $this->_destination;
                break;

            case 'amr':
            case 'mp3':
            case 'wav':
            case 'wma':
                $command = $this->_getFfmpegPath() . 'ffmpeg -i ' . $this->_source . ' ';
                $command .= $duration .  $this->_destination;
                break;

            default :
                // do nothing
                break;
        }

        // execute the command
        return $this->_executeConversion($command);
    }

    /**
     * Converts the source file to wma.
     *
     * @return string|bool The name of the file obtained after conversion or false if the conversion has failed.
     */
    private function _convertToWma()
    {
         $duration = ($this->_duration > 0) ? '-t ' . $this->_duration . ' ' : '';

        switch ($this->_type) {
            case 'al':
                // when converting from al sample rate must be set for input file
                $command = $this->_getFfmpegPath() . 'ffmpeg -ar 8000 -i ' . $this->_source . ' ';
                $command .= $duration . ' -ab ' . $this->_bitRate . 'k -ar ' . $this->_sampleRate . ' ';
                $command .= '-ac ' . $this->_channels . ' ' . $this->_destination;
                break;

            case 'amr':
            case 'mp3':
            case 'wav':
            case 'wma':
                $command = $this->_getFfmpegPath() . 'ffmpeg -i ' . $this->_source . ' ';
                $command .= $duration . ' -ab ' . $this->_bitRate . 'k -ar ' . $this->_sampleRate . ' ';
                $command .= '-ac ' . $this->_channels . ' ' . $this->_destination;
                break;

            default :
                // do nothing
                break;
        }

        // execute the command
        return $this->_executeConversion($command);
    }

    /**
     * Checks if the provided file type is unsupported by SOX.
     *
     * @param string $type file type
     * @return boolean true in case of success or false otherwise
     */
    protected function _isUnsupportedSoxType($type)
    {
        if (in_array($type, $this->_unsupportedSoxTypes)) {
            return true;
        }

        return false;
    }

    /**
     * Returns the volume of a media file
     *
     * @param string $file The media file whose volume we want to determine
     * @return float The file volume in decibels
     */
    protected function _getFileVolume($file)
    {
        $command = $this->_getSoxPath() . 'sox ' . $file . ' 2>&1 -n stat | grep Volume | cut -d : -f 2 | cut -f 1';

        return (float)$this->_execute($command);
    }
}

/* EOF */
