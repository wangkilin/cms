<?php
/**
 *
 * $Rev: 2560 $
 * $LastChangedDate: 2010-04-23 15:49:53 +0800 (Fri, 23 Apr 2010) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Package
 * @subpackage SubPackage
 * @version 1.0
 *
 */

class Streamwide_Engine_Media_Stream_Filter_NoiseReduction extends Streamwide_Engine_Media_Stream_Filter
{

    const PARAM_DENOISE_THRESHOLD = 'denoise_threshold';
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_name = self::FILTER_NOISE_REDUCTION;
        $this->_streamDirection = self::STREAM_INCOMING;
    }
    
    /**
     * This parameter defines how much (in dB) stationnary noise the filter will attempt to
     * remove. Default value -45 dB. The higher the value, the more noise will be removed, but at the
     * risk of damaging the worthwile rest of the audio signal, for instance the voice of the caller.
     *
     * @param integer $denoiseThreshold
     */
    public function setDenoiseThreshold( $denoiseThreshold )
    {
        $this->_params[self::PARAM_DENOISE_THRESHOLD] = (int)$denoiseThreshold;
    }
    
    /**
     * Get the denoise threshold
     *
     * @return integer|null
     */
    public function getDenoiseThreshold()
    {
        if ( isset( $this->_params[self::PARAM_DENOISE_THRESHOLD] ) ) {
            return $this->_params[self::PARAM_DENOISE_THRESHOLD];
        }
    }
    
}
 
/* EOF */