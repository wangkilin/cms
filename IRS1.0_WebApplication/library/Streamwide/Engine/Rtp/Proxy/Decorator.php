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

class Streamwide_Engine_Rtp_Proxy_Decorator extends Streamwide_Engine_Widget_Decorator
{
    
    /**
     * @var Streamwide_Engine_Rtp_Proxy_Call_Leg
     */
    protected $_rtpProxyCallLeg;
    
    /**
     * A list of events triggered when receiving signals that contain an "sdp" parameter
     *
     * @var array
     */
    protected $_sdpCarrierEvents = array();
    
    /**
     * @var string
     */
    protected $_rightIpAddress;
    
    /**
     * @var string
     */
    protected $_leftIpAddress;
    
    /**
     * Constructor
     *
     * @param Streamwide_Engine_Widget
     * @throws InvalidArgumentException
     */
    public function __construct( Streamwide_Engine_Widget $widget )
    {
        $this->_ensureValidWidget( $widget );
        parent::__construct( $widget );
    }
    
    /**
     * @param string $method
     * @param array $args
     * @throws RuntimeException
     */
    public function __call( $method, $args )
    {
        $widget = $this->getDecoratedWidget();
        
        $shouldInit = false;
        if ( $widget instanceof Streamwide_Engine_Call_Leg_Connector
            && strtolower( $method ) === 'connect' ) {
            $shouldInit = true;
        } elseif ( $widget instanceof Streamwide_Engine_Automatic_Signal_Relayer
            && strtolower( $method ) === 'start' ) {
            $shouldInit = true;
        }
        
        if ( $shouldInit ) {
            $this->_subscribeToEngineEvents();
        }
        
        return parent::__call( $method, $args );
    }
    
    /**
     * @param Streamwide_Engine_Rtp_Proxy_Call_Leg $rtpProxyCallLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setRtpProxyCallLeg( Streamwide_Engine_Rtp_Proxy_Call_Leg $rtpProxyCallLeg )
    {
        if ( !$rtpProxyCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be an alive RTPPROXY call leg' );
        }
        
        $this->_rtpProxyCallLeg = $rtpProxyCallLeg;
    }
    
    /**
     * @return Streamwide_Engine_Rtp_Proxy_Call_Leg
     */
    public function getRtpProxyCallLeg()
    {
        return $this->_rtpProxyCallLeg;
    }
    
    /**
     * Register the events we need to pay attention to
     *
     * @param array $sdpCarrierEvents
     * @return void
     */
    public function registerSdpCarrierEvents( Array $sdpCarrierEvents )
    {
        $this->_sdpCarrierEvents = $sdpCarrierEvents;
    }
    
    /**
     * @return array
     */
    public function getRegisteredSdpCarrierEvents()
    {
        return $this->_sdpCarrierEvents;
    }
    
    /**
     * @param string $leftIpAddress
     * @return void
     */
    public function setLeftIpAddress( $leftIpAddress )
    {
        $this->_leftIpAddress = $leftIpAddress;
    }
    
    /**
     * @return string
     */
    public function getLeftIpAddress()
    {
        return $this->_leftIpAddress;
    }
    
    /**
     * @param string $rightIpAddress
     * @return void
     */
    public function setRightIpAddress( $rightIpAddress )
    {
        $this->_rightIpAddress = $rightIpAddress;
    }
    
    /**
     * @return string
     */
    public function getRightIpAddress()
    {
        return $this->_rightIpAddress;
    }
    
    /**
     * Handles an event triggered by the receiving of a signal
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onSignalReceived( Streamwide_Engine_Events_Event $event )
    {
        $signal = $event->getParam( 'signal' );
        $remote = $signal->getRemote();
        $params = $signal->getParams();
        
        if ( !is_array( $params ) || empty( $params ) || !array_key_exists( 'sdp', $params ) ) {
            $message = 'No "sdp" parameter found in the "%s" signal. Signal will be skipped';
            trigger_error( sprintf( $message, $signal->getName() ), E_USER_NOTICE );
            return;
        }
        
        if ( $remote === $this->getLeftCallLeg()->getName() ) {
            $source = 'left';
        } elseif ( $remote === $this->getRightCallLeg()->getName() ) {
            $source = 'right';
        } else {
            $message = 'Unexpected source for "%s" signal. Signal will be skipped';
            trigger_error( sprintf( $message, $signal->getName() ), E_USER_NOTICE );
            return;
        }
        
        $this->_updateRtpProxyCallLeg( $params['sdp'], $source );
        $modifiedSdp = $this->_modifySdp( $params['sdp'], $source );
        
        $params['sdp'] = $modifiedSdp;
        $signal->setParams( $params );
        $event->setParam( 'signal', $signal );
    }
    
    /**
     * Update the RTPROXY call leg with the new sdp
     *
     * @param string $sdp
     * @param string $source The source of the sdp (one of the two values: left or right)
     * @return void
     */
    protected function _updateRtpProxyCallLeg( $sdp, $source )
    {
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::RTPPROXY,
            $this->_rtpProxyCallLeg->getName(),
            array( $source . 'sdp' => $sdp ) // the array key translates to "leftsdp" or "rightsdp"
        );
        
        $signal->send();
    }
    
    /**
     * Modify the sdp before sending it
     *
     * @param string $sdp
     * @param string $source The source of the sdp (one of the two values: left or right)
     * @return string
     */
    protected function _modifySdp( $sdp, $source )
    {
        $callLegParams = $this->_rtpProxyCallLeg->getParams();
        if ( !is_array( $callLegParams ) || empty( $callLegParams ) ) {
            $message = 'No RTPPROXY call leg parameters found. The sdp will not be modified. This may lead to unexpected results';
            trigger_error( $message, E_USER_NOTICE );
            
            return $sdp;
        }
        
        if ( !isset( $callLegParams['policy'] ) ) {
            $message = 'No "policy" parameter found in the RTPPROXY call leg. The sdp will not be modified. This may lead to unexpected results';
            trigger_error( $message, E_USER_NOTICE );
            
            return $sdp;
        }
        
        // Explode the policy. Policy values are in the form: audio+video
        $policyParts = explode( '+', $callLegParams['policy'] );
        
        $ret = "";
        foreach ( preg_split( "!\r?\n!", $sdp, -1, PREG_SPLIT_NO_EMPTY ) as $line ) {
            $line = trim( $line );
            
            // if the line is a connection information line, replace the IP address
            if ( strpos( $line, 'c=' ) === 0 ) {
                $ipAddress = $source === 'left' ? $this->_leftIpAddress : $this->_rightIpAddress;
                $ret .= "c=IN IP4 " . $ipAddress . "\r\n";
                
                continue;
            }
            
            // if the line is a media info line, replace the port with the correspondent
            // value stored in the call leg parameters
            if ( strpos( $line, 'm=' ) === 0 ) {
                $parts = explode( '=', $line, 2 );
                $mediaInfo = explode( ' ', $parts[1] );
                $media = $mediaInfo[0];
                
                if ( in_array( $media, $policyParts ) ) {
                    // this will result in something like "audioleftport", "videorightport" etc
                    $key = strtolower( $media . $source . 'port' );
                    
                    if ( isset( $callLegParams[$key] ) ) {
                        $mediaInfo[1] = $callLegParams[$key];
                        $ret .= "m=" . implode( ' ', $mediaInfo ) . "\r\n";
                        
                        continue;
                    }
                }
            }
                
            if ( $line !== '' ) {
                $ret .= $line . "\r\n";
            }
        }
        
        return $ret;
    }
    
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        $leftCallLeg = $this->getLeftCallLeg();
        $rightCallLeg = $this->getRightCallLeg();
        
        foreach ( $this->_sdpCarrierEvents as $event ) {
            $notifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
                Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
                Streamwide_Engine_NotifyFilter_Factory::FILTER_IN_ARRAY,
                array( array( $leftCallLeg->getName(), $rightCallLeg->getName() ) )
            );
            $config = array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array( 'notifyFilter' => $notifyFilter )
            );
            
            $controller->addEventListener( $event, $config );
        }
    }
    
    protected function _unsubscribeFromEngineEvents()
    {
        $controller = $this->getController();
        $config = array( 'callback' => array( $this, 'onSignalReceived' ) );
        
        foreach ( $this->_sdpCarrierEvents as $event ) {
            $controller->removeEventListener( $event, $config );
        }
    }
    
    /**
     * Make sure we are wrapping a valid widget
     *
     * @param Streamwide_Engine_Widget $widget
     * @return void
     * @throws InvalidArgumentException
     */
    protected function _ensureValidWidget( Streamwide_Engine_Widget $widget ) {
        if ( $widget instanceof Streamwide_Engine_Widget_Decorator ) {
            $widget = $widget->getDecoratedWidget();
        }
        
        $valid = false;
        if ( $widget instanceof Streamwide_Engine_Call_Leg_Connector
            && $widget->getType() === Streamwide_Engine_Call_Leg_Connector::CONNECTOR_SIPSIP ) {
            $valid = true;
        } elseif ( $widget instanceof Streamwide_Engine_Automatic_Signal_Relayer ) {
            $valid = true;
        }
        
        if ( !$valid ) {
            throw new InvalidArgumentException( __CLASS__ . ' can only decorate SIPSIP connector and relayer widgets' );
        }
    }
    
}
 
/* EOF */