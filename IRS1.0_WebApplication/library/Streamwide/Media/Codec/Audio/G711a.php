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
 * @version    $Id: G711a.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Represents G711A codec audio media stream.
 *
 * @package    Streamwide_Media
 */
class Streamwide_Media_Codec_Audio_G711A extends Streamwide_Media_Codec_Audio
{
    /**
     * Media codec name. A string to identify the media codec.
     *
     * @var string
     */
    protected $_name = 'g771a';
    
    /**
     * Media codec description.
     *
     * @var string
     */
    protected $_description = 'PCM A-law';
    
    /**
     * The sample rate.
     *
     * @var integer
     */
    protected $_sampleRate = 8000;
    
    /**
     * Allowed sample rates.
     *
     * @var array
     */
    protected $_allowedSampleRates = array(8000);
    
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
    protected $_allowedBitRates = array(64000);
}

/* EOF */