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
 * @version    $Id: AmrNb.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Represents AMR-NB codec.
 *
 * @package    Streamwide_Media
 */
class Streamwide_Media_Codec_Audio_AmrNb extends Streamwide_Media_Codec_Audio
{
    /**
     * Media codec name. A string to identify the media codec.
     *
     * @var string
     */
    protected $_name = 'amrnb';
    
    /**
     * Media codec description.
     *
     * @var string
     */
    protected $_description = 'Adaptive Multi-Rate Narrowband';
    
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
    protected $_bitRate = 12200;
    
    /**
     * Allowed bit rates.
     *
     * @var array
     */
    protected $_allowedBitRates = array(4750, 5150, 5900, 6700, 7400, 7950, 10200, 12200);
}

/* EOF */