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
 * @version    $Id: Mp3.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Represents an mp3 audio codec.
 *
 * This media codec has no constraints.
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
class Streamwide_Media_Codec_Audio_Mp3 extends Streamwide_Media_Codec_Audio
{
    /**
     * Media codec name. A string to identify the media codec.
     *
     * @var string
     */
    protected $_name = 'mp3';
    
    /**
     * Media codec description.
     *
     * @var string
     */
    protected $_description = 'MP3 (MPEG audio layer 3)';
}

/* EOF */