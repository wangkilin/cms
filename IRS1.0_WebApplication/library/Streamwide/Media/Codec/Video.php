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
 * @version    $Id: Video.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Represents an audio media codec.
 *
 * @package    Streamwide_Media
 */
abstract class Streamwide_Media_Codec_Video extends Streamwide_Media_Codec
{
    /**
     * Video bit rate in kb/s.
     *
     * @var integer
     */
    protected $_bitRate;
    
    /**
     * The frame rate in fps.
     *
     * @var integer
     */
    protected $_frameRate;
    
    /**
     * The frame size.
     * Array of (W,H).
     *
     * @var array
     */
    protected $_frameSize;
    
    /**
     * Array of size abbreviations.
     *
     * @var array
     */
    protected $_frameSizeAbbreviation = array(
        'sqcif' => array(128, 96),
        'qcif'  => array(176, 144),
        'cif'   => array(352, 288),
        '4cif'  => array(704, 576),
        '16cif' => array(1408, 1152)
    );
    
    /**
     * Allowed bit rates.
     *
     * @var array
     */
    protected $_allowedBitRates = array();
    
    /**
     * Allowed frame rates.
     *
     * @var array
     */
    protected $_allowedFrameRates = array();
    
    
    /**
     * Allowed frame sizes.
     *
     * @var array
     */
    protected $_allowedFrameSizes = array();
    
    /**
     * Constructor.
     *
     * @param int          $bitRate     (optional) bit rate in bit/second
     * @param int          $frameRate   (optional) frame rate in Hz
     * @param array|string $frameSize   (optional) frame size array(w,h) or abbreviation
     * @throws Streamwide_Media_Exception when parameters are not valid
     */
    public function __construct($bitRate = null, $frameRate = null, $frameSize = null)
    {
        if (!is_null($bitRate)) {
            $this->setBitRate($bitRate);
        }
        if (!is_null($frameRate)) {
            $this->setFrameRate($frameRate);
        }
        if (!is_null($frameSize)) {
            $this->setFrameSize($frameSize);
        }
        if (!is_null($aspectRatio)) {
            $this->setAspectRatio($aspectRatio);
        }
    }

    /**
     * Sets the audio bit rate of the new file.
     *
     * @param integer $bitRate bit rate in bytes
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
     * Sets the audio frame rate.
     *
     * @param integer $frameRate frame rate in Hz
     * @return Streamwide_Media_Stream_Audio *Provides a fluid interface*
     * @throws Streamwide_Media_Exception when parameter is not valid
     */
    public function setFrameRate($frameRate)
    {
        if (!empty($this->_allowedFrameRates) && !in_array($frameRate, $this->_allowedFrameRates)) {
            throw new Streamwide_Media_Exception('Frame rate not supported.');
        }
        
        $this->_validatePositiveInt('Frame rate', $frameRate);

        $this->_frameRate = $frameRate;
        
        return $this;
    }

    /**
     * Returns the audio frame rate.
     *
     * @return integer
     */
    public function getFrameRate()
    {
        return $this->_frameRate;
    }
    
    /**
     * Sets the audio frame size of the new file.
     *
     * @param array|string $frameSize frame size
     * @return Streamwide_Media_Stream_Audio *Provides a fluid interface*
     * @throws Streamwide_Media_Exception when parameter is not valid
     */
    public function setFrameSize($frameSize)
    {
        // check if frame size is abbreviation
        if (is_string($frameSize)) {
            if (isset($this->_frameSizeAbbreviation[$frameSize])) {
                $frameSize = $this->_frameSizeAbbreviation[$frameSize];
            } else {
                throw new Streamwide_Media_Exception('Unknown frame size abbrviation: ' . $frameSize);
            }
        }
        
        // check if frame size is allowed
        if (is_array($frameSize) &&
            !empty($this->_allowedFrameSizes) &&
            !in_array($frameSize, $this->_allowedFrameSizes)) {
            throw new Streamwide_Media_Exception('Frame size not supported.');
        } else {
            throw new Streamwide_Media_Exception('Frame size must be an array.');
        }

        $this->_frameSize = $frameSize;
        
        return $this;
    }

    /**
     * Returns the audio frame size.
     *
     * @return array
     */
    public function getFrameSize()
    {
        return $this->_frameSize;
    }
}

/* EOF */