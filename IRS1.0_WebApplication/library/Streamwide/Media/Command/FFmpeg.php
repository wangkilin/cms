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
 * @version    $Id: FFmpeg.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * FFmpeg command implementation.
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
class Streamwide_Media_Command_FFmpeg extends Streamwide_Media_Command_FFmpeg_Abstract
{
    /**
     * Supported command versions.
     *
     * @var string
     */
    protected $_supportedVersions = '0.5.*';
    
    /**
     * Predefined frame size formats.
     * Can be used with FRAME_SIZE option.
     *
     * @var array
     */
    protected $_frameSizeFormats = array(
        'sqcif' => '128x96',
        'qcif'  => '176x144',
        'cif'   => '352x288',
        '4cif'  => '704x576'
    );
    
    /**
     * Command tags for each option.
     *
     * @var array
     */
    protected $_optionTag = array(
        self::DURATION           => '-t',
        self::AUDIO_BITRATE      => '-ab',
        self::AUDIO_SAMPLE_RATE  => '-ar',
        self::AUDIO_CHANNELS     => '-ac',
        self::AUDIO_CODEC        => '-acodec',
        self::VIDEO_ASPECT_RATIO => '-aspect',
        self::VIDEO_BITRATE      => '-b',
        self::VIDEO_CODEC        => '-vcodec',
        self::VIDEO_FRAME_RATE   => '-r',
        self::VIDEO_FRAME_SIZE   => '-s',
    );
    
    /**
     * Tags for input and output files.
     *
     * @var string
     */
    protected $_inputFileTag  = '-i';
    protected $_outputFileTag = '';
    
    /**
     * Gets a raw media file info output.
     * You must parse the output to use the returned data.
     *
     * @param string $filename file name
     * @return array with stdout and stderr
     */
    public function getFileInfo($filename)
    {
        $parts = array(
            $this->_commandPath . '/' . $this->_commandName,
            $this->_inputFileTag,
            $filename
        );
        
        $command = join(' ', $parts);
        
        $result = Streamwide_System_Command_Runner::runCommand($command, null, $return, $stdout);

        return $result;
    }
    
    /**
     * Checks if this object supports the given version of the application.
     *
     * @param string $version
     * @return boolean
     */
    public function isSupportedVersion($version)
    {
        // supports version 0.5.*
        if (strpos('0.5', $version) == 0) {
            return true;
        }
        return false;
    }
}

/* EOF */