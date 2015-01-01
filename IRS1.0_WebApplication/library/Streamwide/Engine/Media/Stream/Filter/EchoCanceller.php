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

class Streamwide_Engine_Media_Stream_Filter_EchoCanceller extends Streamwide_Engine_Media_Stream_Filter
{

    const PARAM_FILTER_LENGTH = 'filter_length';
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_name = self::FILTER_ECHO_CANCELLER;
    }

    /**
     * Also known as echo tail, this parameter defines how much (duration in milliseconds) echo the
     * filter will attempt to cancel. Default and recommended value is 1024 (about 1 second). The
     * higher the value, the more echo will be cancelled, but the time for echo cancellation to be fully
     * active will also increase. A too low value will lead to about no echo to be cancelled.

     * @param integer $filterLength
     * @return void
     */
    public function setFilterLength( $filterLength )
    {
        $this->_params[self::PARAM_FILTER_LENGTH] = (int)$filterLength;
    }
    
    /**
     * Get the filter length
     *
     * @return integer|null
     */
    public function getFilterLength()
    {
        if ( isset( $this->_params[self::PARAM_FILTER_LENGTH] ) ) {
            return $this->_params[self::PARAM_FILTER_LENGTH];
        }
    }
    
    /**
     * Setting of stream direction is not available for this filter
     *
     * @see Engine/Media/Stream/Streamwide_Engine_Media_Stream_Filter#setStreamDirection($streamDirection)
     */
    public function setStreamDirection( $streamDirection )
    {
        return null;
    }
    
    /**
     * @return string
     */
    protected function _getFilterFullName()
    {
        return $this->_name;
    }
    
}
 
/* EOF */