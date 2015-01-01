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
 * @version    $Id: ThirdGP.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Represents an audio track for 3GP format.
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
class Streamwide_Media_Track_Audio_ThirdGP extends Streamwide_Media_Track_Audio
{
    /**
     * Media stream default codec.
     *
     * @var Streamwide_Media_Codec_Audio
     */
    protected $_defaultCodec = 'Streamwide_Media_Codec_Audio_Auto';
    
    /**
     * Allowed codecs.
     *
     * @var array
     */
    protected $_allowedCodecs = array(
        'Streamwide_Media_Codec_Audio_Auto',
    	'Streamwide_Media_Codec_Audio_Amr'
    );
}

/* EOF */