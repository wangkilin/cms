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

class Streamwide_Engine_Rtp_Proxy_Call_Leg_Creator extends Streamwide_Engine_Call_Leg_Creator
{
    
    const PARAM_POLICY = 'policy';
    const PARAM_SDP = 'sdp';
    const PARAM_STRICT = 'strict';
    
    const CREATE_SIGNAL_SEND_ERR_CODE = 'RTPPROXYCREATOR-100';
    const CALL_LEG_NOT_CREATED_ERR_CODE = 'RTPPROXYCREATOR-200';
    const CALL_LEG_DIED_ERR_CODE = 'RTPPROXYCREATOR-201';
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::CREATE_SIGNAL_SEND_ERR_CODE => 'Unable to send CREATE signal to SW Engine',
        self::CALL_LEG_NOT_CREATED_ERR_CODE => 'The RTPProxy call leg could not be created',
        self::CALL_LEG_DIED_ERR_CODE => 'The RTPProxy call leg died'
    );
    
    /**
     * @param array $creationParams
     * @return void
     * @throws InvalidArgumentException
     */
    public function setCreationParams( Array $creationParams )
    {
        parent::setCreationParams( $creationParams );
        
        $policy = $this->getPolicy();
        if ( empty( $policy ) ) {
            throw new InvalidArgumentException( '"' . self::PARAM_POLICY . '" parameter is mandatory and it cannot be empty' );
        }
    }
    
    /**
     * @param Streamwide_Engine_Call_Leg_Abstract $callLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setCallLeg( Streamwide_Engine_Call_Leg_Abstract $callLeg )
    {
        if ( !$callLeg instanceof Streamwide_Engine_Rtp_Proxy_Call_Leg ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be an instance of Streamwide_Engine_Rtp_Proxy_Call_Leg' );
        }
        
        parent::setCallLeg( $callLeg );
    }
    
    /**
     * Set the "policy" parameter. Cannot be empty. Medias are separated
     * by a + sign.
     *
     * @param string $policy
     * @return void
     * @throws InvalidArgumentException
     */
    public function setPolicy( $policy )
    {
        if ( !is_string( $policy ) || strlen( $policy ) < 1 ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a non-empty string' );
        }
        
        $this->_creationParams[self::PARAM_POLICY] = $policy;
    }
    
    /**
     * Retrieve the value of the "policy" parameter
     *
     * @return string
     */
    public function getPolicy()
    {
        if ( $this->_isParameterSet( self::PARAM_POLICY ) ) {
            return $this->_creationParams[self::PARAM_POLICY];
        }
    }
    
    /**
     * Set the "sdp" parameter
     *
     * @param string $sdp
     * @return void
     */
    public function setSdp( $sdp )
    {
        $this->_creationParams[self::PARAM_SDP] = $sdp;
    }
    
    /**
     * Retrieve the value of the "sdp" parameter
     *
     * @return string|null
     */
    public function getSdp()
    {
        if ( $this->_isParameterSet( self::PARAM_SDP ) ) {
            return $this->_creationParams[self::PARAM_SDP];
        }
    }
    
    /**
     * Set the "strict" parameter
     *
     * @param string $strict
     * @return void
     */
    public function setStrict( $strict )
    {
        $this->_creationParams[self::PARAM_STRICT] = $strict;
    }
    
    /**
     * Retrieve the value of the "strict" parameter
     *
     * @return string|null
     */
    public function getStrict()
    {
        if ( $this->_isParameterSet( self::PARAM_STRICT ) ) {
            return $this->_creationParams[self::PARAM_STRICT];
        }
    }
    
    /**
     * Start the creation process
     *
     * @return boolean
     */
    public function create()
    {
        return parent::create( self::CREATE_SIGNAL_SEND_ERR_CODE );
    }
    
    /**
     * Handles FAIL signal. The RTPProxy call leg could not be created
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleFailSignal( Streamwide_Engine_Signal $signal )
    {
        parent::_handleFailSignal( $signal, self::CALL_LEG_NOT_CREATED_ERR_CODE );
    }
    
    /**
     * Handles CHILD signal. The RTPProxy call leg has died
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleChildSignal( Streamwide_Engine_Signal $signal )
    {
        parent::_handleChildSignal( $signal, self::CALL_LEG_DIED_ERR_CODE );
    }
    
    /**
     * Apply any normalization (if needed) to the creation params
     *
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Creator#_normalizeCreationParams()
     */
    protected function _normalizeCreationParams()
    {
        return array_merge(
            array(
                'proto' => 'RTPPROXY',
                'name' => $this->_callLeg->getName()
            ),
            $this->_creationParams
        );
    }
    
}
 
/* EOF */