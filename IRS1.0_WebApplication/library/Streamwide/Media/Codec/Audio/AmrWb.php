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
 * @version    $Id: AmrWb.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Represents AMR-WB codec.
 *
 * @package    Streamwide_Media
 */
class Streamwide_Media_Codec_Audio_AmrWb extends Streamwide_Media_Codec_Audio
{
    /**
     * Media codec name. A string to identify the media codec.
     *
     * @var string
     */
    protected $_name = 'amrwb';
    
    /**
     * Media codec description.
     *
     * @var string
     */
    protected $_description = 'Adaptive Multi-Rate Wideband';
    
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
    protected $_bitRate = 23850;
    
    /**
     * Allowed bit rates.
     *
     * @var array
     */
    protected $_allowedBitRates = array(6600, 8850, 12650, 14250, 15850, 18250, 19850, 23050, 23850);
}

/* EOF */