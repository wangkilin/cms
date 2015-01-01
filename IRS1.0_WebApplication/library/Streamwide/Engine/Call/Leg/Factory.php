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
 * @subpackage Streamwide_Engine_Call_Leg
 * @version 1.0
 *
 */

/**
 * Factory for creating and wiring call legs with their dependencies
 */
class Streamwide_Engine_Call_Leg_Factory
{

    /**
     * Factory options
     *
     * @var array
     */
    protected $_options;
    
    /**
     * Constructor
     *
     * @param array $options
     * @return void
     */
    public function __construct( Array $options )
    {
        $this->_checkRequiredOptions( $options );
        $this->_options = $options;
    }
    
    /**
     * Returns a instance of Streamwide_Engine_Call_Leg_Abstract based on the provided parameters
     *
     * @param array $options
     * @return Streamwide_Engine_Call_Leg_Abstract
     */
    public static function factory( Array $options )
    {
        $self = new self( $options );
        
        $name = null;
        $isAlive = false;
        $isRoot = false;
        if ( isset( $self->_options['name'] ) ) {
            $name = $self->_options['name'];
        }
        if ( isset( $self->_options['isAlive'] ) ) {
            $isAlive = $self->_options['isAlive'];
        }
        if ( isset( $self->_options['isRoot'] ) ) {
            $isRoot = $self->_options['isRoot'];
        }
        
        $type = $self->_options['type'];
        switch ( $type ) {
            case Streamwide_Engine_Call_Leg_Abstract::SIP_CL:
                $callLeg = new Streamwide_Engine_Sip_Call_Leg( $name, $isAlive );
            break;
            case Streamwide_Engine_Call_Leg_Abstract::PHP_CL:
                $callLeg = new Streamwide_Engine_Php_Call_Leg( $name, $isAlive );
            break;
            case Streamwide_Engine_Call_Leg_Abstract::MS_CL:
                $callLeg = new Streamwide_Engine_Media_Server_Call_Leg( $name, $isAlive );
            break;
            case Streamwide_Engine_Call_Leg_Abstract::ASR_CL:
                $callLeg = new Streamwide_Engine_Asr_Call_Leg( $name, $isAlive );
            break;
            case Streamwide_Engine_Call_Leg_Abstract::TTS_CL:
                $callLeg = new Streamwide_Engine_Tts_Call_Leg( $name, $isAlive );
            break;
            case Streamwide_Engine_Call_Leg_Abstract::DIAMETER_CL:
                $callLeg = new Streamwide_Engine_Diameter_Call_Leg( $name, $isAlive );
            break;
            case Streamwide_Engine_Call_Leg_Abstract::RTPPROXY_CL:
                $callLeg = new Streamwide_Engine_Rtp_Proxy_Call_Leg( $name, $isAlive );
            break;
            case Streamwide_Engine_Call_Leg_Abstract::RTSP_CL:
                $callLeg = new Streamwide_Engine_Rtsp_Call_Leg( $name, $isAlive );
            break;
        }
        
        if ( $isRoot ) {
            $callLeg->setRoot();
        }
        
        return $callLeg;
    }
    
    /**
     * Check the factory required options
     *
     * @param array $options
     * @return void
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    protected function _checkRequiredOptions( Array $options )
    {
        if ( !is_array( $options ) || empty( $options ) ) {
            throw new InvalidArgumentException( 'Factory options must be provided as a non empty array' );
        }
        
        if ( !isset( $options['type'] ) ) {
            throw new RuntimeException( 'Type of call leg to be created has not been provided' );
        }
    }
}

/* EOF */