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

class Streamwide_Engine_Media_Stream_Filter_Gain extends Streamwide_Engine_Media_Stream_Filter
{
    
    const PARAM_TYPE = 'type';
    const PARAM_AMT = 'amt';
    const PARAM_TARGET_LEVEL = 'target_level';
    const PARAM_THRESHOLD = 'threshold';
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_name = self::FILTER_GAIN;
        $this->_streamDirection = self::STREAM_INCOMING;
    }
    
    /**
     * Set the mode of gain to be used. Can be "amt" for fixed gain or "agc" for
     * adaptive gain
     *
     * @param string $type
     * @return void
     */
    public function setType( $type )
    {
        $type = strtolower( $type );
        
        if ( $type !== 'amt' && $type !== 'agc' ) {
            return;
        }
        
        $this->_params[self::PARAM_TYPE] = $type;
    }

    /**
     * Get the mode of gain
     *
     * @return string|null
     */
    public function getType() {
        if ( isset( $this->_params[self::PARAM_TYPE] ) ) {
            return $this->_params[self::PARAM_TYPE];
        }
    }
    
    /**
     * Set the amount of gain in decibels (-96 to 96). Can only used in "amt" mode.
     *
     * @param integer $amt
     * @return void
     */
    public function setAmt( $amt )
    {
        $amt = (int)$amt;
        
        if ( $amt < -96 ) {
            $amt = -96;
        }
        
        if ( $amt > 96 ) {
            $amt = 96;
        }
        
        $this->_params[self::PARAM_AMT] = $amt;
    }
    
    /**
     * Get the amount of gain
     *
     * @return integer|null
     */
    public function getAmt()
    {
        if ( isset( $this->_params[self::PARAM_AMT] ) ) {
            return $this->_params[self::PARAM_AMT];
        }
    }
    
    /**
     * Target level used in adaptive gain mode, in Dbm0 (-40 to 0)
     *
     * @param integer $targetLevel
     * @return void
     */
    public function setTargetLevel( $targetLevel )
    {
        $targetLevel = (int)$targetLevel;
        
        if ( $targetLevel < -40 ) {
            $targetLevel = -40;
        }
        
        if ( $targetLevel > 0 ) {
            $targetLevel = 0;
        }
        
        $this->_params[self::PARAM_TARGET_LEVEL] = $targetLevel;
    }
    
    /**
     * Get the target level
     *
     * @return integer|null
     */
    public function getTargetLevel()
    {
        if ( isset( $this->_params[self::PARAM_TARGET_LEVEL] ) ) {
            return $this->_params[self::PARAM_TARGET_LEVEL];
        }
    }

    /**
     * Sound level threshold used to prevent amplifying background noise, in Dbm0.
     *
     * @param integer $threshold
     */
    public function setThreshold( $threshold )
    {
        $this->_params[self::PARAM_THRESHOLD] = (int)$threshold;
    }
    
    /**
     * Get the sound level threshold
     *
     * @return integer|null
     */
    public function getThreshold()
    {
        if ( isset( $this->_params[self::PARAM_THRESHOLD] ) ) {
            return $this->_params[self::PARAM_THRESHOLD];
        }
    }
    
}
 
/* EOF */