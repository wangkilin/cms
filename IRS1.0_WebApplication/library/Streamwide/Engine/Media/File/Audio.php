<?php
/**
 *
 * $Rev: 2066 $
 * $LastChangedDate: 2009-10-22 20:18:09 +0800 (Thu, 22 Oct 2009) $
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
 * An audio media file
 */
class Streamwide_Engine_Media_File_Audio extends Streamwide_Engine_Media_File_Abstract
{

    /**
     * Allowed channels for this media file (implement in subclasses)
     *
     * @var array
     */
    protected $_allowedChannels = array(
        self::CHANNEL_AUDIO,
        self::CHANNEL_AV
    );

    /**
     * Allowed extensions for this media file (implement in subclasses)
     *
     * @var array
     */
    protected $_allowedExtensions = array(
        self::EXT_AL,
        self::EXT_UL
    );

    /**
     * Allowed forced types for this media file (implement in subclasses)
     *
     * @var array
     */
    protected $_allowedForcedTypes = array(
        self::FT_AL,
        self::FT_UL
    );

}

/* EOF */