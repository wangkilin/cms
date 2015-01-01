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
 * Video file format.
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
abstract class Streamwide_Media_Format_Video extends Streamwide_Media_Format_Video
{
    /**
     * Video track.
     *
     * @var Streamwide_Media_Track_Video
     */
    protected $_videoTrack;
    
    /**
     * Default Video track for this format.
     * Video track is a class that inherits Streamwide_Media_Track_Video.
     *
     * @var string
     */
    protected $_defaultVideoTrack;
    
    /**
     * Array of Video tracks allowed for this format.
     * Video tracks are classes that inherit Streamwide_Media_Track_Video.
     *
     * @var array of string
     */
    protected $_allowedVideoTracks = array();
    
    /**
     * Constructor.
     *
     * @param Streamwide_Media_Track_Video $audioTrack (optional) audio track
     * @param Streamwide_Media_Track_Video $videoTrack (optional) video track
     */
    public function __construct(Streamwide_Media_Track_Audio $audioTrack = null, Streamwide_Media_Track_Video $videoTrack = null)
    {
        parent::construct($audioTrack);
        
        if (!is_null($videoTrack)) {
            $this->_setVideoTrack($videoTrack);
        } else {
            $this->_initVideoTrack();
        }
    }
    
    /**
     * Sets the Video track.
     *
     * @param Streamwide_Media_Track_Video $VideoTrack
	 * @return Streamwide_Media_Type_Video *Provides a fluid interface*
     */
    public function setVideoTrack(Streamwide_Media_Track_Video $videoTrack)
    {
        if (!empty($this->_allowedVideoSteams) && !in_array($VideoTrack, $this->_allowedVideoTracks)) {
            throw new Streamwide_Media_Exception('Video track not supported.');
        }

        $this->_VideoTrack = $VideoTrack;
        
        return $this;
    }
    
    /**
     * Gets the video track.
     *
     * @return Streamwide_Media_Track_Video
     */
    public function getVideoTrack()
    {
        return $this->_videoTrack;
    }
    
    /**
     * Initializes the Video track with the default instance
     * that is the first in the list of allowed tracks.
     *
     * @return void
     * @throws Streamwide_Media_Exception when Video track is not set
     */
    private function _initVideoTrack()
    {
        if (is_null($this->_defaultVideoTrack)) {
            throw new Streamwide_Media_Exception('Default video track is not defined in ' . get_class($this));
        } else {
           $this->_VideoTrack = new $this->_defaultVideoTrack;
        }
    }
}

/* EOF */

/* EOF */