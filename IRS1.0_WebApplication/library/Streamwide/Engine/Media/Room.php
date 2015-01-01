<?php
/**
 *
 * $Rev: 1953 $
 * $LastChangedDate: 2009-09-24 16:02:35 +0200 (Thu, 24 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Package
 * @subpackage SubPackage
 * @version 1.0
 *
 */

class Streamwide_Engine_Media_Room extends Streamwide_Engine_Media
{

    /**
     * @var array
     */
    protected $_roomOptions = array();

    /**
     * Constructor
     *
     * @param string|null $name
     * @param array $roomOptions
     * @param string|null $channel
     * @param string|null $transition
     */
    public function __construct( $name = null, Array $roomOptions = null, $channel = null, $transition = null )
    {
        if ( null !== $name && ( !is_string( $name ) || empty( $name ) ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a non-empty string' );
        }
        if ( null !== $channel && !in_array( $channel, $this->_allowedChannels ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 3 to be one of: "' . implode( '", "', $this->_allowedChannels ) . '" values' );
        }
        if ( null !== $transition && !in_array( $transition, $this->_allowedTransitions ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 4 to be one of: "' . implode( '", "', $this->_allowedTransitions ) . '" values' );
        }

        if ( null !== $name ) {
            $this->_name = $name;
        }
        else {
            $this->_name = sprintf( 'MCU-%s', uniqid() );
        }
        if ( is_array( $roomOptions ) ) {
            $this->_roomOptions = $roomOptions;
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
        $filename = self::FT_ROOM;
        if ( !empty( $this->_roomOptions ) ) {
            $filename .= '/';
            
            $it = new CachingIterator( new ArrayIterator( $this->_roomOptions ) );
            foreach ( $it as $name => $value ) {
                $filename .= $name . '=' . $value;
                if ( $it->hasNext() ) {
                    $filename .= ',';
                }
            }
        }
        $filename .= ':' . $this->_name;
        
        $ret = array(
            self::ARR_FILENAME => $filename,
            self::ARR_TYPE => $this->_channel
        );
        if ( null !== $this->_transition ) {
            $ret[self::ARR_TRANS] = $this->_transition;
        }
        return $ret;
    }

}

/* EOF */
