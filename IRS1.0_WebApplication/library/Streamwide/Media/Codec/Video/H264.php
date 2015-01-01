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
 * @version    $Id: H264.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Represents H.264 video codec.
 *
 * @package    Streamwide_Media
 */
class Streamwide_Media_Codec_Video_H264 extends Streamwide_Media_Codec_Video
{
    /**
     * Media codec name. A string to identify the media codec.
     *
     * @var string
     */
    protected $_name = 'h264';
    
    /**
     * Media codec description.
     *
     * @var string
     */
    protected $_description = '';
    
    
    /**
     * The frame size.
     * Default value: qcif
     *
     * @var array
     */
    protected $_frameSize = array(176, 144);
}

/* EOF */