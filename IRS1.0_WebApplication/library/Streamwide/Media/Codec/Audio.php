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
 * @version    $Id: Audio.php 2608 2010-05-18 02:01:35Z kwu $
 */

require_once 'Streamwide/Media/Codec.php';

/**
 * Represents an audio media codec.
 *
 * @package    Streamwide_Media
 */
abstract class Streamwide_Media_Codec_Audio extends Streamwide_Media_Codec
{
    /**
     * The sample rate in Hz.
     *
     * @var integer
     */
    protected $_sampleRate;
    
    /**
     * The audio bit rate in kb/s.
     *
     * @var integer
     */
    protected $_bitRate;
    
    /**
     * Number of audio channels (1 or 2).
     *
     * @var integer
     */
    protected $_channels;
    
    /**
     * Allowed sample rates.
     *
     * @var array
     */
    protected $_allowedSampleRates = array();

    /**
     * Allowed bit rates.
     *
     * @var array
     */
    protected $_allowedBitRates = array();
    
	/**
     * Allowed channels.
     * Mono (1) or stereo (2).
     *
     * @var array
     */
    protected $_allowedChannels = array(1, 2);
    
    /**
     * Constructor.
     *
     * @param integer $sampleRate (optional) sample rate
     * @param integer $bitRate    (optional) bit rate
     * @param integer $channels   (optional) number of channels
     * @throws Streamwide_Media_Exception when parameters are not valid
     */
    public function __construct($sampleRate = null, $bitRate = null, $channels = null)
    {
        if (!is_null($sampleRate)) {
            $this->setSampleRate($sampleRate);
        }
        if (!is_null($bitRate)) {
            $this->setBitRate($bitRate);
        }
        if (!is_null($channels)) {
            $this->setChannels($channels);
        }
    }

    /**
     * Sets the sample rate of the new file.
     *
     * @param integer $sampleRate sample rate
     * @return Streamwide_Media_Stream_Audio *Provides a fluid interface*
     * @throws Streamwide_Media_Exception when parameter is not valid
     */
    public function setSampleRate($sampleRate)
    {
        if (!empty($this->_allowedSampleRates) && !in_array($sampleRate, $this->_allowedSampleRates)) {
            throw new Streamwide_Media_Exception('Sample rate not supported.');
        }
        
        $this->_validatePositiveInt('Sample rate', $sampleRate);

        $this->_sampleRate = $sampleRate;
        
        return $this;
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
     * Sets the audio bit rate of the new file.
     *
     * @param integer $bitRate bit rate in bit/second
     * @return Streamwide_Media_Stream_Audio *Provides a fluid interface*
     * @throws Streamwide_Media_Exception when parameter is not valid
     */
    public function setBitRate($bitRate)
    {
        if (!empty($this->_allowedBitRates) && !in_array($bitRate, $this->_allowedBitRates)) {
            throw new Streamwide_Media_Exception('Bit rate not supported.');
        }
        
        $this->_validatePositiveInt('Bit rate', $bitRate);

        $this->_bitRate = $bitRate;
        
        return $this;
    }

    /**
     * Returns the audio bit rate.
     *
     * @return integer
     */
    public function getBitRate()
    {
        return $this->_bitRate;
    }
    
    /**
     * Sets the audio channels number.
     *
     * @param integer $channels number of audio channels
     * @return Streamwide_Media_Stream_Audio *Provides a fluid interface*
     * @throws Streamwide_Media_Exception when parameter is not valid
     */
    public function setChannels($channels)
    {
        if (!empty($this->_allowedBitRates) && !in_array($sampleRate, $this->_allowedBitRates)) {
            throw new Streamwide_Media_Exception('Channels number not supported.');
        }
        
        $this->_validatePositiveInt('Channels', $channels);

        $this->_channels = $channels;
        
        return $this;
    }

    /**
     * Returns the number of audio channels.
     *
     * @return integer
     */
    public function getChannels()
    {
        return $this->_channels;
    }
}

/* EOF */