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
 * @version    $Id: Mp3.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Represents a track for mp3 audio format.
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
class Streamwide_Media_Track_Audio_Mp3 extends Streamwide_Media_Track_Audio
{
    /**
     * Media stream default codec.
     *
     * @var Streamwide_Media_Codec_Audio
     */
    protected $_defaultCodec = 'Streamwide_Media_Codec_Audio_Mp3';
    
    /**
     * Allowed codecs.
     *
     * @var array
     */
    protected $_allowedCodecs = array(
        'Streamwide_Media_Codec_Audio_Auto',
    	'Streamwide_Media_Codec_Audio_Mp3'
    );
}

/* EOF */