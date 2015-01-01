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
 * @version    $Id: Track.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Represents an abstract media track.
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
abstract class Streamwide_Media_Track
{
    /**
     * Media stream codec.
     *
     * @var Streamwide_Media_Codec
     */
    protected $_codec;
    
    /**
     * Media stream default codec.
     *
     * @var Streamwide_Media_Codec
     */
    protected $_defaultCodec;
    
    /**
     * Allowed codecs.
     *
     * @var array
     */
    protected $_allowedCodecs = array();
    
    /**
     * Constructor.
     *
     * @param Streamwide_Media_Codec $codec (optional) stream codec, if not specified the default codec will be used
     * @param integer $duration             (optional) stream duration in miliseconds
     */
    public function __construct(Streamwide_Media_Codec $codec = null)
    {
        if (!is_null($codec)) {
            $this->_setCodec($codec);
        } else {
            $this->_setDefaultCodec();
        }
    }
    
    /**
     * Get the stream codec.
     *
     * @return string stream codec
     */
    public function getCodec()
    {
        return $this->_codec;
    }
    
    /**
     * Sets the codec.
     *
     * @param string $codec stream codec
     * @return Streamwide_Media_Track_Audio *Provides a fluid interface*
     * @throws Streamwide_Media_Exception when parameter is not valid
     */
    public function setCodec($codec)
    {
        if (!empty($this->_allowedCodecs)
            && !in_array(get_class($codec, $this->_allowedCodecs))) {
            throw new Streamwide_Media_Exception('Unsupported codec.');
        }
        
        $this->_codec = $codec;
        
        return $this;
    }
    
    /**
     * Gets the list of allowed codecs for this stream.
     *
     * @return array
     */
    public function getAllowedCodecs()
    {
        return $this->_allowedCodecs;
    }
    
    /**
     * Initializes the audio codec with a default instance.
     *
     * @return void
     * @throws Streamwide_Media_Exception when default codec has not been set
     */
    protected function _setDefaultCodec()
    {
        if (is_null($this->_defaultCodec)) {
            throw new Streamwide_Media_Exception('Default codec is not defined in ' . get_class($this));
        } else {
            $this->_codec = new $this->_defaultCodec;
        }
    }
}

/* EOF */