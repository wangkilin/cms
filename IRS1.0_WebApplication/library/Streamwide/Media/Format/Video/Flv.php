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
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Flv.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Flv video file format.
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
class Streamwide_Media_Format_Audio_Flv extends Streamwide_Media_Format_Video
{
    /**
     * Default audio track class.
     *
     * @var string
     */
    protected $_defaultAudioTrack = 'Streamwide_Media_Track_Audio_Flv';

    /**
     * Array of audio track classes allowed.
     *
     * @var array of string
     */
    protected $_allowedAudioTracks = array('Streamwide_Media_Track_Audio_Flv');
    
    /**
     * Default video track class.
     *
     * @var string
     */
    protected $_defaultVideoTrack = 'Streamwide_Media_Track_Video_Flv';

    /**
     * Array of video track classes allowed.
     *
     * @var array of string
     */
    protected $_allowedVideoTracks = array('Streamwide_Media_Track_Video_Flv');
}

/* EOF */