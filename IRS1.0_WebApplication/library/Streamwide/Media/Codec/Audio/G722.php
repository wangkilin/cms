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
 * @version    $Id: G722.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Represents G722 audio codec.
 *
 * @package    Streamwide_Media
 */
class Streamwide_Media_Codec_Audio_G711U extends Streamwide_Media_Codec_Audio
{
    /**
     * Media codec name. A string to identify the media codec.
     *
     * @var string
     */
    protected $_name = 'g722';
    
    /**
     * Media codec description.
     *
     * @var string
     */
    protected $_description = '';
    
    /**
     * The sample rate.
     *
     * @var integer
     */
    protected $_sampleRate = 16000;
    
    /**
     * Allowed sample rates.
     *
     * @var array
     */
    protected $_allowedSampleRates = array(16000);
    
    /**
     * The bit rate.
     *
     * @var integer
     */
    protected $_bitRate = 64000;
    
    /**
     * Allowed bit rates.
     *
     * @var array
     */
    protected $_allowedBitRates = array(48000, 56000, 64000);
}

/* EOF */