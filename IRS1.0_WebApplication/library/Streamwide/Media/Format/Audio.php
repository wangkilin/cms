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

/**
 * Audio file format.
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
abstract class Streamwide_Media_Format_Audio extends Streamwide_Media_Format
{
    /**
     * Audio track.
     *
     * @var Streamwide_Media_Track_Audio
     */
    protected $_audioTrack;
    
    /**
     * Default audio track for this format.
     * Audio track is a class that inherits Streamwide_Media_Track_Audio.
     *
     * @var string
     */
    protected $_defaultAudioTrack;
    
    /**
     * Array of audio tracks allowed for this format.
     * Audio tracks are classes that inherit Streamwide_Media_Track_Audio.
     *
     * @var array of string
     */
    protected $_allowedAudioTracks = array();
    
    /**
     * Constructor.
     *
     * @param Streamwide_Media_Track_Audio $audioTrack (optional) audio track
     */
    public function __construct(Streamwide_Media_Track_Audio $audioTrack = null)
    {
        if (!is_null($audioTrack)) {
            $this->_setAudioTrack($audioTrack);
        } else {
            $this->_initAudioTrack();
        }
    }
    
    /**
     * Sets the audio track.
     *
     * @param Streamwide_Media_Track_Audio $audioTrack
	 * @return Streamwide_Media_Type_Audio *Provides a fluid interface*
     */
    public function setAudioTrack(Streamwide_Media_Track_Audio $audioTrack)
    {
        if (!empty($this->_allowedAudioSteams) && !in_array($audioTrack, $this->_allowedAudioTracks)) {
            throw new Streamwide_Media_Exception('Audio track not supported.');
        }

        $this->_audioTrack = $audioTrack;
        
        return $this;
    }
    
    /**
     * Gets the audio track.
     *
     * @return Streamwide_Media_Track_Audio
     */
    public function getAudioTrack()
    {
        return $this->_audioTrack;
    }
    
    /**
     * Initializes the audio track with the default instance
     * that is the first in the list of allowed tracks.
     *
     * @return void
     * @throws Streamwide_Media_Exception when audio track is not set
     */
    private function _initAudioTrack()
    {
        if (is_null($this->_defaultAudioTrack)) {
            throw new Streamwide_Media_Exception('Default audio track is not defined in ' . get_class($this));
        } else {
           $this->_audioTrack = new $this->_defaultAudioTrack;
        }
    }
}

/* EOF */