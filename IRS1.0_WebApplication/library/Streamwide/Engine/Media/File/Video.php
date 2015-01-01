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
 * A video media file
 */
class Streamwide_Engine_Media_File_Video extends Streamwide_Engine_Media_File_Abstract
{

    /**
     * Allowed extensions for this media file
     *
     * @var array
     */
    protected $_allowedExtensions = array(
        self::EXT_3GP,
        self::EXT_STW
    );

    /**
     * Allowed forced types for this media file
     *
     * @var array
     */
    protected $_allowedForcedTypes = array(
        self::FT_3GP,
        self::FT_STW
    );

}

/* EOF */