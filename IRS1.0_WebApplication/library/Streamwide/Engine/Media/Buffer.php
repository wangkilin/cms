<?php
/**
 *
 * $Rev: 2338 $
 * $LastChangedDate: 2010-02-05 20:49:14 +0800 (Fri, 05 Feb 2010) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Media
 * @version 1.0
 *
 */

class Streamwide_Engine_Media_Buffer extends Streamwide_Engine_Media
{

    /**
     * Constructor
     *
     * @param string|null $name
     * @param string|null $channel
     * @param string|null $transition
     */
    public function __construct( $name = null, $channel = null, $transition = null )
    {
        if ( null !== $name && ( !is_string( $name ) || empty( $name ) ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a non-empty string' );
        }
        if ( null !== $channel && !in_array( $channel, $this->_allowedChannels ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 2 to be one of: "' . implode( '", "', $this->_allowedChannels ) . '" values' );
        }
        if ( null !== $transition && !in_array( $transition, $this->_allowedTransitions ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 3 to be one of: "' . implode( '", "', $this->_allowedTransitions ) . '" values' );
        }

        if ( null !== $name ) {
            $this->_name = $name;
        }
        else {
            $this->_name = sprintf( 'BUFFER-%s', uniqid() );
        }
        $this->_channel = ( null === $channel ? self::CHANNEL_AV : $channel );
        $this->_transition = $transition;
    }

    /**
     * Array representation of this object (to be used in conjunction with the PLAY signal)
     *
     * @return array
     */
    public function toArray()
    {
        $ret = array(
            self::ARR_FILENAME => sprintf( '%s:%s', self::FT_BUFFER, $this->_name ),
            self::ARR_TYPE => $this->_channel
        );
        if ( null !== $this->_transition ) {
            $ret[self::ARR_TRANS] = $this->_transition;
        }
        return $ret;
    }

}

/* EOF */
