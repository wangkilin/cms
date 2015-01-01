<?php
/**
 *
 * $Rev: 2066 $
 * $LastChangedDate: 2009-10-22 20:18:09 +0800 (Thu, 22 Oct 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Media
 * @version 1.0
 *
 */

/**
 * Fax tone
 */
class Streamwide_Engine_Media_Fax_Tone extends Streamwide_Engine_Media
{
    
    const OPT_DURATION = 'duration';
    
    /**
     * Playing options for this media
     *
     * @var array
     */
    protected $_playingOptions = array();
    
    /**
     * Constructor
     *
     * @param string|null $channel
     * @param string|null $transition
     * @param integer $duration
     */
    public function __construct( $channel = null, $transition = null, $duration = 20 )
    {
        if ( null !== $channel && !in_array( $channel, $this->_allowedChannels ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be one of: "' . implode( '", "', $this->_allowedChannels ) . '" values' );
        }
        if ( null !== $transition && !in_array( $transition, $this->_allowedTransitions ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 2 to be one of: "' . implode( '", "', $this->_allowedTransitions ) . '" values' );
        }
        
        $this->_name = 'CNG';
        $this->_channel = ( null === $channel ? self::CHANNEL_AV : $channel );
        $this->_transition = $transition;
        $this->setDuration( $duration );
    }
    
    /**
     * Sets the play duration for this file
     *
     * @param string $duration
     * @return void
     */
    public function setDuration( $duration )
    {
        $this->_playingOptions[self::OPT_DURATION] = $duration;
    }
    
    /**
     * Array
     * @return unknown_type
     */
    public function toArray()
    {
        $ret = array(
            self::ARR_FILENAME => sprintf( '%s/duration=%d:%s', self::FT_TONE, $this->_playingOptions[self::OPT_DURATION], $this->_name ),
            self::ARR_TYPE => $this->_channel
        );
        if ( null !== $this->_transition ) {
            $ret[self::ARR_TRANS] = $this->_transition;
        }
        return $ret;
    }
    
}


/* EOF */