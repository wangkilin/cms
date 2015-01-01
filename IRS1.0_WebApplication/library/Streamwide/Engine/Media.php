<?php
/**
 *
 * $Rev: 2171 $
 * $LastChangedDate: 2009-12-07 17:47:29 +0800 (Mon, 07 Dec 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Media
 * @version 1.0
 *
 */


/**
 * A media to be used for playing and/or recording. Can be a audio file, video file, image file, buffer, fax tone
 */
abstract class Streamwide_Engine_Media
{

    /**
     * Allowed extensions for media files
     */
    const EXT_JPG = 'jpg';
    const EXT_BMP = 'bmp';
    const EXT_PNG = 'png';
    const EXT_XMP = 'xmp';
    const EXT_GIF = 'gif';
    const EXT_AL = 'al';
    const EXT_UL = 'ul';
    const EXT_3GP = '3gp';
    const EXT_STW = 'stw';

    /**
     * Allowed transitions for medias (files or buffers)
     */
    const TRANS_AUDIO = 'a';
    const TRANS_VIDEO = 'v';
    const TRANS_AV_FIRST = 'f';
    const TRANS_AV_LAST = 'l';

    /**
     * Allowed channels for playing medias (files or buffers)
     */
    const CHANNEL_AUDIO = 'a';
    const CHANNEL_VIDEO = 'v';
    const CHANNEL_AV = 'av';

    /**
     * Forced types for medias (used for overriding extensions and force a certain type of media to be played)
     */
    const FT_TONE = 'tone';
    const FT_BUFFER = 'buffer';
    const FT_ROOM = 'mcu';
    const FT_JPG = 'file-jpg';
    const FT_BMP = 'file-bmp';
    const FT_PNG = 'file-png';
    const FT_XMP = 'file-xmp';
    const FT_GIF = 'file-gif';
    const FT_AL = 'file-al';
    const FT_UL = 'file-ul';
    const FT_3GP = 'file-3gp';
    const FT_STW = 'file-stw';

    /**
     * Indexes used when converting this object to an array
     */
    const ARR_FILENAME = 'filename';
    const ARR_TYPE = 'type';
    const ARR_TRANS = 'transition';

    /**
     * The name of the media
     *
     * @var string
     */
    protected $_name;

    /**
     * The channel on which this media should be played (a=audio, v=video, av=audio/video).
     * Defaults to "av".
     *
     * @var string
     */
    protected $_channel;

    /**
     * Synchronization option used internally by the SW Engine to determine when the media should be played.
     * Allowed values are:
     * v=media will be played when video ends,
     * a=media will be played when audio ends,
     * f=media will be played when the first audio and video ends,
     * l=media will be played when the last audio and video ends
     *
     * @var string
     */
    protected $_transition;

    /**
     * Allowed channels for this media
     *
     * @var array
     */
    protected $_allowedChannels = array(
        self::CHANNEL_AUDIO,
        self::CHANNEL_VIDEO,
        self::CHANNEL_AV,
    );

    /**
     * Allowed transitions for this media
     *
     * @var array
     */
    protected $_allowedTransitions = array(
        self::TRANS_AUDIO,
        self::TRANS_VIDEO,
        self::TRANS_AV_FIRST,
        self::TRANS_AV_LAST
    );

    /**
     * Retrieves the name of the media
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Retrieves the channel on which the media should be played
     *
     * @return string
     */
    public function getChannel()
    {
    	return $this->_channel;
    }

    /**
     * Retrieves the synchronization option for this media
     *
     * @return string|null
     */
    public function getTransition()
    {
    	return $this->_transition;
    }

    /**
     * Retrieves the channels on which this file is allowed to play
     *
     * @return array
     */
    public function getAllowedChannels()
    {
        return $this->_allowedChannels;
    }

    /**
     * Retrieves the allowed transitions for this file
     *
     * @return array
     */
    public function getAllowedTransitions()
    {
        return $this->_allowedTransitions;
    }

    /**
     * Array representation of this object (to be used in conjunction with the PLAY signal)
     *
     * @return array
     */
    abstract public function toArray();
    
    /**
     * Returns an array with all defined channels
     *
     * @return array
     */
    public static function getAllChannels()
    {
        return array(
            self::CHANNEL_AUDIO,
            self::CHANNEL_VIDEO,
            self::CHANNEL_AV
        );
    }
    
    /**
     * Returns an array with all defined transitions
     *
     * @return array
     */
    public static function getAllTransitions()
    {
        return array(
            self::TRANS_AUDIO,
            self::TRANS_VIDEO,
            self::TRANS_AV_FIRST,
            self::TRANS_AV_LAST
        );
    }
    
    /**
     * Returns an array with all defined extensions
     *
     * @return array
     */
    public static function getAllExtensions()
    {
        return array(
            self::EXT_3GP,
            self::EXT_AL,
            self::EXT_BMP,
            self::EXT_GIF,
            self::EXT_JPG,
            self::EXT_PNG,
            self::EXT_UL,
            self::EXT_XMP,
            self::EXT_STW
        );
    }
    
    /**
     * Returns an array with all defined forced types
     *
     * @return array
     */
    public static function getAllForcedTypes()
    {
        return array(
            self::FT_3GP,
            self::FT_AL,
            self::FT_BMP,
            self::FT_BUFFER,
            self::FT_ROOM,
            self::FT_GIF,
            self::FT_JPG,
            self::FT_PNG,
            self::FT_TONE,
            self::FT_UL,
            self::FT_XMP,
            self::FT_STW
        );
    }

}

/* EOF */
