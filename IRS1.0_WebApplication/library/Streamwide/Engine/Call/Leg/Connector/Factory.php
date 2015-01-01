<?php
/**
 *
 * $Rev: 2560 $
 * $LastChangedDate: 2010-04-23 15:49:53 +0800 (Fri, 23 Apr 2010) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Call_Leg_Connector
 * @version 1.0
 *
 */

/**
 * Factory class to retrieve and provided dependencies for Streamwide_Engine_Call_Leg_Connector class
 */
class Streamwide_Engine_Call_Leg_Connector_Factory
{

    /**
     * Connector types
     */
    const NO_SDP_IVR_CALL = 'NO_SDP_IVR_CALL';
    const SDP_IVR_CALL = 'SDP_IVR_CALL';
    const IVR_OUT_CALL = 'IVR_OUT_CALL';
    const MS_ALIVE_IVR_OUT_CALL = 'MS_ALIVE_IVR_OUT_CALL';
    const IVR_REINVITE = 'IVR_REINVITE';
    const IVR_RECONNECT = 'IVR_RECONNECT';
    const NO_SDP_DIRECT_CALL = 'NO_SDP_DIRECT_CALL';
    const SDP_DIRECT_CALL = 'SDP_DIRECT_CALL';
    const FORCED_FAX_NEGOTIATOR = 'FORCED_FAX_NEGOTIATOR';
    const SIP_RECONNECT = 'SIP_RECONNECT';
    const NO_SDP_DIRECT_REINVITE = 'NO_SDP_DIRECT_REINVITE';
    const SDP_DIRECT_REINVITE = 'SDP_DIRECT_REINVITE';
    
    /**
     * Parameters needed to instantiate the correct connector
     * and provide its dependencies
     *
     * @var array
     */
    protected $_params;
    
    /**
     * Constructor
     *
     * @param array $params
     * @return void
     */
    protected function __construct( Array $params )
    {
        $this->_params = $params;
    }
    
    /**
     * Factory method. Instantiate and prepares a connector for usage
     *
     * @param array $params
     * @return Streamwide_Engine_Call_Leg_Connector
     * @throws RuntimeException
     * @throws UnexpectedValueException
     */
    public static function factory( Array $params )
    {
        $self = new self( $params );
        $self->_checkRequiredParameters();
        $connector = $self->_getConnector();
        $self->_setConnectorDependencies( $connector );
        return $connector;
    }

    /**
     * Make sure that the required parameters have been provided
     *
     * @return void
     * @throws RuntimeException
     */
    protected function _checkRequiredParameters()
    {
        if ( !isset( $this->_params['type'] ) ) {
            throw new RuntimeException( 'The type of the connector has not be provided' );
        }
    }
    
    /**
     * Get the correct connector instance by type
     *
     * @return Streamwide_Engine_Call_Leg_Connector
     * @throws UnexpectedValueException
     */
    protected function _getConnector()
    {
        switch ( $this->_params['type'] ) {
            case self::NO_SDP_IVR_CALL:
                return new Streamwide_Engine_Call_Leg_Connector_NoSdpIvrCall();
            break;
            case self::SDP_IVR_CALL:
                return new Streamwide_Engine_Call_Leg_Connector_SdpIvrCall();
            break;
            case self::IVR_OUT_CALL:
                return new Streamwide_Engine_Call_Leg_Connector_IvrOutcall();
            break;
            case self::MS_ALIVE_IVR_OUT_CALL:
                return new Streamwide_Engine_Call_Leg_Connector_MsAliveIvrOutcall();
            break;
            case self::IVR_REINVITE:
                return new Streamwide_Engine_Call_Leg_Connector_IvrReinvite();
            break;
            case self::IVR_RECONNECT:
                return new Streamwide_Engine_Call_Leg_Connector_IvrReconnect();
            break;
            case self::FORCED_FAX_NEGOTIATOR:
                return new Streamwide_Engine_Call_Leg_Connector_ForcedFaxNegotiator();
            break;
            case self::NO_SDP_DIRECT_CALL:
                return new Streamwide_Engine_Call_Leg_Connector_NoSdpDirectCall();
            break;
            case self::SDP_DIRECT_CALL:
                return new Streamwide_Engine_Call_Leg_Connector_SdpDirectCall();
            break;
            case self::SIP_RECONNECT:
                return new Streamwide_Engine_Call_Leg_Connector_SipReconnect();
            break;
            case self::NO_SDP_DIRECT_REINVITE:
                return new Streamwide_Engine_Call_Leg_Connector_NoSdpDirectReinvite();
            break;
            case self::SDP_DIRECT_REINVITE:
                return new Streamwide_Engine_Call_Leg_Connector_SdpDirectReinvite();
            break;
            default:
                throw new UnexpectedValueException( 'Invalid connector type specified' );
            break;
        }
    }
    
    /**
     * Provide the connector with all needed dependencies to do its job
     *
     * @param Streamwide_Engine_Call_Leg_Connector $connector
     * @return void
     */
    protected function _setConnectorDependencies( Streamwide_Engine_Call_Leg_Connector $connector )
    {
        if ( isset( $this->_params['leftCallLeg'] ) ) {
            $connector->setLeftCallLeg( $this->_params['leftCallLeg'] );
        }
        if ( isset( $this->_params['rightCallLeg'] ) ) {
            $connector->setRightCallLeg( $this->_params['rightCallLeg'] );
        }
        if ( isset( $this->_params['connectionParams'] ) ) {
            $connector->setConnectionParams( $this->_params['connectionParams'] );
        }
        if ( isset( $this->_params['options'] ) ) {
            $connector->setOptions( $this->_params['options'] );
        }
    }
    
}

/* EOF */