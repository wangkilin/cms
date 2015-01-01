<?php
/**
 *
 * $Rev: 2154 $
 * $LastChangedDate: 2009-11-24 22:30:11 +0800 (Tue, 24 Nov 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Call_Leg_Connector_Decorator
 * @version 1.0
 *
 */

class Streamwide_Engine_Call_Leg_Connector_MultiOutgoingIps_Decorator extends Streamwide_Engine_Widget_Decorator
{

    /**
     * Cache the FAIL event in this property. If every IP in the
     * list fails, this event will be sent to decorated widget
     *
     * @var Streamwide_Engine_Events_Event
     */
    protected $_failEvent;
    
    /**
     * The remote SIP call leg
     *
     * @var Streamwide_Engine_Sip_Call_Leg
     */
    protected $_remoteSipCallLeg;
    
    /**
     * Failure codes that determine the retrying of the next IP in the list.
     * If the code of the FAIL signal is not in this list then the next IP is tried.
     *
     * @var array
     */
    protected $_outgoingStopCodes = array(
        'plain' => array( '486' ),
        'regex' => array()
    );
    
    /**
     * A list with provisional responses to listen for
     *
     * @var array
     */
    protected $_provisionalResponses = array(
        Streamwide_Engine_Events_Event::RING,
        Streamwide_Engine_Events_Event::PROGRESS,
        Streamwide_Engine_Events_Event::SDP,
        Streamwide_Engine_Events_Event::PRSDP
    );
    
    /**
     * The list of IPs to try
     *
     * @var array
     */
    protected $_ipsList = array();
    
    /**
     * An iterator object to iterate over the IPs list
     *
     * @var ArrayIterator
     */
    protected $_iterator;
    
    /**
     * An associative array with the connection parameters for each IP in the list
     *
     * @var array
     */
    protected $_ipsParams = array();
    
    /**
     * The default IPs parameters
     *
     * @var array
     */
    protected $_defaultIpsParams = array();
    
    /**
     * Destructor
     */
    public function destroy()
    {
        if ( isset( $this->_failEvent ) ) {
            unset( $this->_failEvent );
        }
        
        if ( isset( $this->_remoteSipCallLeg ) ) {
            unset( $this->_remoteSipCallLeg );
        }
        
        if ( isset( $this->_iterator ) ) {
            unset( $this->_iterator );
        }
        
        parent::destroy();
    }
    
    /**
     * Set the list with failure codes that will trigger a retry.
     * In an attempt to optimize things this method will separate the provided
     * $outgoingStopCodes list into plain codes (for example 300, 458, 486 etc)
     * and regex codes (for example 5**, **5, *8* etc). That way we'll be able to first
     * search into the plain codes list before bringing up the regexp engine
     *
     * @param array|string $outgoingStopCodes
     * @return void
     * @throws InvalidArgumentException
     */
    public function setOutgoingStopCodes( $outgoingStopCodes )
    {
        if ( is_string( $outgoingStopCodes ) ) {
            $outgoingStopCodes = preg_split( '!\s*,\s*!', $outgoingStopCodes, -1, PREG_SPLIT_NO_EMPTY );
        }
        
        if ( !is_array( $outgoingStopCodes ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a string or array' );
        }
        
        if ( empty( $outgoingStopCodes ) ) {
            return;
        }
        
        // Extract plain codes
        $plainCodes = array_filter(
            $outgoingStopCodes,
            create_function( '$code', 'return ( false === strpos( $code, "*" ) );' )
        );
        if ( !in_array( '486', $plainCodes ) ) {
            $plainCodes[] = '486';
        }
        
        // Turn each code that contains a star ("*") into a regular expression
        // Example: 5** will be turned into "!^5[0-9][0-9]$!"
        $regexCodes = array_map(
            create_function( '$code', 'return sprintf( \'!^%s$!\', str_replace( "*", "[0-9]", $code ) );' ),
            array_diff( $outgoingStopCodes, $plainCodes )
        );
        
        $this->_outgoingStopCodes['plain'] = array_values( $plainCodes );
        $this->_outgoingStopCodes['regex'] = array_values( $regexCodes );
    }
    
    /**
     * Retrieve the list with failure codes
     *
     * @param string|null $which Which list to retrieve ("regex" for the list of outgoing stop codes regexes
     *                           or "plain" for the list of plain outgoing stop codes)
     * @return array
     */
    public function getOutgoingStopCodes( $which = null )
    {
        if ( null === $which || !array_key_exists( $which, $this->_outgoingStopCodes ) ) {
            return $this->_outgoingStopCodes;
        }
        
        return $this->_outgoingStopCodes[$which];
    }
    
    /**
     * Set the list of IPs to be tried if remote SIP call leg sends us a FAIL
     *
     * @param array|string $ipsList
     * @return void
     * @throws InvalidArgumentException
     */
    public function setIpsList( $ipsList )
    {
        if ( is_string( $ipsList ) ) {
            $ipsList = preg_split( '!\s*,\s*!', $ipsList, -1, PREG_SPLIT_NO_EMPTY );
        }
        
        if ( !is_array( $ipsList ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be string or array' );
        }
        
        $this->_ipsList = $ipsList;
    }
    
    /**
     * Retrieve the list of retryable IPs
     *
     * @return array
     */
    public function getIpsList()
    {
        return $this->_ipsList;
    }
    
    /**
     * Provide a list of connection parameters for some or all the IPs in the IPs list
     *
     * @param array $ipsParams
     * @return void
     */
    public function setIpsParams( Array $ipsParams )
    {
        $this->_ipsParams = $ipsParams;
    }
    
    /**
     * Retrieve the connection parameters lists for the IPs in the IPs list
     *
     * @return array
     */
    public function getIpsParams()
    {
        return $this->_ipsParams;
    }

    /**
     * Set the provisional responses list
     *
     * @param array $provisionalResponses
     * @return void
     */
    public function setProvisionalResponses( Array $provisionalResponses )
    {
        $this->_provisionalResponses = $provisionalResponses;
    }
    
    /**
     * Retrieve the provisional responses list
     *
     * @return array
     */
    public function getProvisionalResponses()
    {
        return $this->_provisionalResponses;
    }
    
    /**
     * Set the connection parameters. The provided data will become the default ips data.
     *
     * @param array|Streamwide_Container $connectionParams
     * @return void
     * @throws InvalidArgumentException
     */
    public function setConnectionParams( $connectionParams )
    {
        if ( $connectionParams instanceof Streamwide_Container ) {
            $connectionParams = $connectionParams->toArray();
        }
        
        if ( !is_array( $connectionParams ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an instance of Streamwide_Container or an array' );
        }
        
        $this->_defaultIpsParams = $connectionParams;
    }

    /**
     * Retrieve the default ips data
     *
     * @return array
     */
    public function getConnectionParams()
    {
        return $this->_defaultIpsParams;
    }
    
    /**
     * Initialize and performs the connection
     *
     * @return boolean
     */
    public function connect()
    {
        $this->_initConnect();
        $this->_connect( true );
        return true;
    }
    
    /**
     * Determine if a FAIL code is an outgoing stop code
     *
     * @param string $code
     * @return boolean
     */
    public function isOutgoingStopCode( $code )
    {
        // try the plain codes list first
        if ( in_array( $code, $this->_outgoingStopCodes['plain'] ) ) {
            return true;
        }
        
        // if the regexes list is empty exit
        if ( empty( $this->_outgoingStopCodes['regex'] ) ) {
            return false;
        }
        
        // try the regex codes list
        $found = false;
        for ( $i = 0, $n = count( $this->_outgoingStopCodes['regex'] ); $i < $n; $i++ ) {
            $regex = $this->_outgoingStopCodes['regex'][$i];
            if ( 1 === preg_match( $regex, $code ) ) {
                $found = true;
                break;
            }
        }
            
        return $found;
    }
    
    /**
     * Handles FAIL, PRSDP/SDP/RING/PROGRESS events
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onSignalReceived( Streamwide_Engine_Events_Event $event )
    {
        $eventType = $event->getEventType();
        
        if ( $eventType === Streamwide_Engine_Events_Event::FAIL ) {
            return $this->_handleFailEvent( $event );
        }
        
        if ( in_array( $eventType, $this->_provisionalResponses ) ) {
            return $this->_handleProvisionalResponse( $event );
        }
    }
    
    /**
     * Handles an error that occured in the decorated widget
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onError( Streamwide_Engine_Events_Event $event )
    {
        $this->_unsubscribeFromEngineEvents();
        $this->_widget->triggerErrorEventOnRemoteSipFailure( true );
    }
    
    /**
     * Initialize the connection
     *
     * @return void
     */
    protected function _initConnect()
    {
        // usually the remote SIP call leg is the right call leg
        // but in the case of the IVR Outcall connector the remote
        // SIP call leg is the left call leg
        $callLeg = $this->_widget->getRightCallLeg();
        $this->_remoteSipCallLeg = (
            !$callLeg instanceof Streamwide_Engine_Sip_Call_Leg
            ? $this->_widget->getLeftCallLeg()
            : $callLeg
        );
        
        // prevent decorated widget from triggering an ERROR event on
        // FAIL received from the remote SIP call leg
        $this->_widget->triggerErrorEventOnRemoteSipFailure( false );
        
        // Listen to ERROR events dispatched by the decorated widget
        $this->_widget->addEventListener(
            Streamwide_Engine_Events_Event::ERROR,
            array(
                'callback' => array( $this, 'onError' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        
        // create the iterator
        $this->_iterator = new ArrayIterator( $this->_ipsList );
        
        // init default IP params
        if ( empty( $this->_defaultIpsParams ) ) {
            $this->_defaultIpsParams = $this->_widget->getConnectionParams();
        }
    }
    
    /**
     * Performs the connection
     *
     * @param boolean $isFirstTime Whether or not this is the first time when we attempt to connect
     * @return void
     */
    protected function _connect( $isFirstTime = false )
    {
        if ( !$this->_iterator->valid() ) {
            $this->_unsubscribeFromEngineEvents();
            $this->_widget->removeEventListener(
                Streamwide_Engine_Events_Event::ERROR,
                array( 'callback' => array( $this, 'onError' ) )
            );
            $this->_widget->triggerErrorEventOnRemoteSipFailure( true );
            return $this->_widget->onSignalReceived( $this->_failEvent );
        }
        
        $ip = $this->_iterator->current();
        $this->_iterator->next();
        
        $connectionParams = array( 'ip' => $ip );
        $sourceNumber = $this->_getIpParam( $ip, 'sourceNumber' );
        if ( null !== $sourceNumber ) {
            $connectionParams['sourceNumber'] = $sourceNumber;
        }
        $destinationNumber = $this->_getIpParam( $ip, 'destinationNumber' );
        if ( null !== $destinationNumber ) {
            $connectionParams['destinationNumber'] = $destinationNumber;
        }
        $uri = $this->_getIpParam( $ip, 'uri' );
        if ( null !== $uri ) {
            $connectionParams['uri'] = $uri;
        }
        $sipExtraParams = $this->_getIpParam( $ip, 'sipExtraParams' );
        if ( null !== $sipExtraParams ) {
            $connectionParams['sipExtraParams'] = $sipExtraParams;
        }
        
        $connectionParams = $this->_buildConnectionParams( $this->_defaultIpsParams, $connectionParams );
        
        $this->_widget->setConnectionParams( $connectionParams );
        
        if ( $isFirstTime ) {
            $this->_widget->connect();
        } else {
            $this->_widget->retryConnect();
        }
        
        return $this->_subscribeToEngineEvents();
    }
    
    /**
     * Merge recursively the connection params for a certain IP with the default IPs parameters
     *
     * @param array $initial
     * @param array $new
     * @return array
     */
    protected function _buildConnectionParams( Array $initial, Array $new )
    {
        foreach ( $new as $key => $value ) {
            $goRecursively = (
                array_key_exists( $key, $initial )
                && is_array( $initial[$key] )
                && is_array( $value )
            );
            if ( $goRecursively ) {
                $initial[$key] = $this->_buildConnectionParams( $initial[$key], $value );
            } else {
                $initial[$key] = $value;
            }
        }
        return $initial;
    }
    
    /**
     * Retrieve a connection parameter for a certain IP. If the parameter has not been
     * provided for the $ip it will be retrieved from the default IPs list
     *
     * @param string $ip
     * @param string $param
     * @return string|null
     */
    protected function _getIpParam( $ip, $param )
    {
        // check to see if a specific params list has been provided
        $params = array();
        if ( array_key_exists( $ip, $this->_ipsParams ) ) {
            $params = $this->_ipsParams[$ip];
        }
        
        // check to see if the parameter has been provided in the specific ip params list
        if ( array_key_exists( $param, $params ) ) {
            return $params[$param];
        }
        
        // retrieve it from the default params list
        if ( array_key_exists( $param, $this->_defaultIpsParams ) ) {
            return $this->_defaultIpsParams[$param];
        }
        
        return null;
    }
    
    /**
     * Handles the FAIL event
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    protected function _handleFailEvent( Streamwide_Engine_Events_Event $event )
    {
        // Make sure to unsubscribe the event listeners as early as possible.
        // In case of retry the call legs names will be regenerated so the
        // event listeners MUST be recreated. In case of letting the decorated
        // widget handle the FAIL signal we also need to remove the event listeners
        $this->_unsubscribeFromEngineEvents();
        
        $signal = $event->getParam( 'signal' );
        $params = $signal->getParams();
        
        $code = null;
        if ( array_key_exists( 'code', $params ) ) {
            $code = $params['code'];
        }
        
        if ( null !== $code && !$this->isOutgoingStopCode( $code ) ) {
            $this->_failEvent = $event;
            return $this->_connect();
        }
        
        $this->_widget->removeEventListener(
            Streamwide_Engine_Events_Event::ERROR,
            array( 'callback' => array( $this, 'onError' ) )
        );
        $this->_widget->triggerErrorEventOnRemoteSipFailure( true );
        return $this->_widget->onSignalReceived( $event );
    }
    
    /**
     * Handles a provisional response
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    protected function _handleProvisionalResponse( Streamwide_Engine_Events_Event $event )
    {
        $this->_unsubscribeFromEngineEvents();
        $this->_widget->removeEventListener(
            Streamwide_Engine_Events_Event::ERROR,
            array( 'callback' => array( $this, 'onError' ) )
        );
        $this->_widget->triggerErrorEventOnRemoteSipFailure( true );
    }
    
    /**
     * Subscribe to FAIL, PRSDP/SDP/RING/PROGRESS events
     *
     * @return void
     */
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::FAIL,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'priority' => '1',
                    'notifyFilter' => Streamwide_Engine_NotifyFilter_Factory::factory(
                        Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
                        Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
                        $this->_remoteSipCallLeg->getName()
                    )
                )
            )
        );
        
        for ( $i = 0, $n = count( $this->_provisionalResponses ); $i < $n; $i++ ) {
            $event = $this->_provisionalResponses[$i];
            $controller->addEventListener(
                $event,
                array(
                    'callback' => array( $this, 'onSignalReceived' ),
                    'options' => array(
                        'autoRemove' => 'before',
                        'priority' => '1',
                        'notifyFilter' => Streamwide_Engine_NotifyFilter_Factory::factory(
                            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
                            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
                            $this->_remoteSipCallLeg->getName()
                        )
                    )
                )
            );
        }
    }
    
    /**
     * Unsubscribe from FAIL, PRSDP/SDP/RING/PROGRESS events
     *
     * @return void
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $callback = array( 'callback' => array( $this, 'onSignalReceived' ) );
        
        $events = $this->_provisionalResponses;
        $events[] = Streamwide_Engine_Events_Event::FAIL;
        
        $controller = $this->getController();
        foreach ( $events as $event ) {
            $controller->removeEventListener( $event, $callback );
        }
    }
    
}
 
/* EOF */
