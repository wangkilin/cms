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
 * @version    $Id: Pcm.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Represents PCM codec.
 *
 * @package    Streamwide_Media
 */
class Streamwide_Media_Codec_Audio_Pcm extends Streamwide_Media_Codec_Audio
{
    /**
     * Media codec name. A string to identify the media codec.
     *
     * @var string
     */
    protected $_name = 'pcm';
    
    /**
     * Media codec description.
     *
     * @var string
     */
    protected $_description = 'Pulse Code Modulation';
    
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
    protected $_allowedSampleRates = array(8000, 16000);
    
    /**
     * The bit rate.
     *
     * @var integer
     */
    protected $_bitRate = 12800;
    
    /**
     * Allowed bit rates.
     *
     * @var array
     */
    protected $_allowedBitRates = array(12800, 25600);
}

/* EOF */