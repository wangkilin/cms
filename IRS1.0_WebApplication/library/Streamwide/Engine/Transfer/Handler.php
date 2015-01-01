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

/**
 * Widget for handling an incoming TRANSFER.
 */
class Streamwide_Engine_Transfer_Handler extends Streamwide_Engine_Widget
{
    
    const TRFINFO_SIGNAL_SEND_ERR_CODE = 'TRANSFERHANDLER-100';
    const OKTRANSFER_SIGNAL_SEND_ERR_CODE = 'TRANSFERHANDLER-101';
    const FAILTRANSFER_SIGNAL_SEND_ERR_CODE = 'TRANSFERHANDLER-102';
    const KILL_SIGNAL_SEND_ERR_CODE = 'TRANSFERHANDLER-103';
    const TRANSFER_FAILED_RECONNECT_SUCCESS_ERR_CODE = 'TRANSFERHANDLER-200';
    const TRANSFER_FAILED_RECONNECT_FAILURE_ERR_CODE = 'TRANSFERHANDLER-201';
    
    /**
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::TRANSFERRED,
        Streamwide_Engine_Events_Event::ERROR
    );
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::TRFINFO_SIGNAL_SEND_ERR_CODE => 'Unable to send TRFINFO signal to SW Engine',
        self::OKTRANSFER_SIGNAL_SEND_ERR_CODE => 'Unable to send OKTRANSFER signal to SW Engine',
        self::FAILTRANSFER_SIGNAL_SEND_ERR_CODE => 'Unable to send FAILTRANSFER signal to SW Engine',
        self::KILL_SIGNAL_SEND_ERR_CODE => 'Unable to send KILL signal to SW Engine',
        self::TRANSFER_FAILED_RECONNECT_SUCCESS_ERR_CODE => 'Transfer has failed but the previous state was restored',
        self::TRANSFER_FAILED_RECONNECT_FAILURE_ERR_CODE => 'Transfer has failed and the previous state could not be restored'
    );
    
    /**
     * The call leg that is expected to generate the TRANSFER signal
     *
     * @var Streamwide_Engine_Sip_Call_Leg
     */
    protected $_transferSource;
    
    /**
     * The call leg that is currently linked with the call leg that is expected to
     * generate the TRANSFER signal
     *
     * @var Streamwide_Engine_Call_Leg_Abstract|null
     */
    protected $_transferSourceLink;
    
    /**
     * The new call leg that is expected to take the place of the "expectedTransferSource"
     *
     * @var Streamwide_Engine_Sip_Call_Leg
     */
    protected $_transferDestination;

    /**
     * Parameters for the transfer
     *
     * @var array
     */
    protected $_transferParams = array();
    
    /**
     * The call leg connector responsible with creating the "expectedTransferDestination" call leg
     * and linking it with "expectedTransferSourceLink"
     *
     * @var Streamwide_Engine_Call_Leg_Connector
     */
    protected $_connector;
    
    /**
     * The call leg connector responsible with reconnecting "expectedTransferSource" with "expectedTransferSourceLink"
     *
     * @var Streamwide_Engine_Call_Leg_Connector
     */
    protected $_reconnector;

    /**
     * Destroy the widget
     *
     * @return void
     */
    public function destroy()
    {
        if ( isset( $this->_transferSource ) ) {
            $this->_transferSource = null;
            unset( $this->_transferSource );
        }
        
        if ( isset( $this->_transferSourceLink ) ) {
            $this->_transferSourceLink = null;
            unset( $this->_transferSourceLink );
        }
        
        if ( isset( $this->_transferDestination ) ) {
            $this->_transferDestination = null;
            unset( $this->_transferDestination );
        }
        
        if ( isset( $this->_connector ) ) {
            $this->_connector->destroy();
            $this->_connector = null;
            unset( $this->_connector );
        }
        
        if ( isset( $this->_reconnector ) ) {
            $this->_reconnector->destroy();
            $this->_reconnector = null;
            unset( $this->_reconnector );
        }
        
        parent::destroy();
    }
    
    /**
     * Reset the widget
     *
     * @return void
     */
    public function reset()
    {
        parent::reset();
        
        $this->_connector->reset();
        $this->_reconnector->reset();
    }
    
    /**
     * Set the call leg that is expected to generate the TRANSFER request
     *
     * @param Streamwide_Engine_Sip_Call_Leg $transferSource
     * @return void
     * @throws InvalidArgumentException
     */
    public function setTransferSource( Streamwide_Engine_Sip_Call_Leg $transferSource )
    {
        if ( !$transferSource->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be an alive SIP call leg' );
        }
        
        $this->_transferSource = $transferSource;
    }
    
    /**
     * Get the call leg that is expected to generate the TRANSFER request
     *
     * @return Streamwide_Engine_Sip_Call_Leg
     */
    public function getTransferSource()
    {
        return $this->_transferSource;
    }
    
    /**
     * Set the call leg that is currently linked with the call leg that is expected
     * to generate the TRANSFER request
     *
     * @param Streamwide_Engine_Call_Leg_Abstract $transferSourceLink
     * @return void
     * @throws InvalidArgumentException
     */
    public function setTransferSourceLink( Streamwide_Engine_Call_Leg_Abstract $transferSourceLink )
    {
        if ( !$transferSourceLink instanceof Streamwide_Engine_Sip_Call_Leg
            && !$transferSourceLink instanceof Streamwide_Engine_Media_Server_Call_Leg )
        {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a SIP or MS call leg' );
        }
        
        if ( !$transferSourceLink->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be an alive SIP or MS call leg' );
        }
        
        $this->_transferSourceLink = $transferSourceLink;
    }
    
    /**
     * Set the call leg that is currently linked with the call leg that is expected
     * to generate the TRANSFER request
     *
     * @return Streamwide_Engine_Call_Leg_Abstract $transferSourceLink
     */
    public function getTransferSourceLink()
    {
        return $this->_transferSourceLink;
    }
    
    /**
     * Set the call leg that will replace the call leg that is expected to generate the TRANSFER
     * request
     *
     * @param Streamwide_Engine_Sip_Call_Leg $transferDestination
     * @return void
     * @throws InvalidArgumentException
     */
    public function setTransferDestination( Streamwide_Engine_Sip_Call_Leg $transferDestination )
    {
        if ( $transferDestination->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a dead SIP call leg' );
        }
        
        $this->_transferDestination = $transferDestination;
    }
    
    /**
     * Get the call leg that will replace the call leg that is expected to generate the TRANSFER
     * request
     *
     * @return Streamwide_Engine_Sip_Call_Leg $transferDestination
     */
    public function getTransferDestination()
    {
        return $this->_transferDestination;
    }
    
    /**
     * Set the connector that will perform the transfer
     *
     * @param Streamwide_Engine_Call_Leg_Connector $connector
     * @return void
     * @throws InvalidArgumentException
     */
    public function setConnector( Streamwide_Engine_Call_Leg_Connector $connector )
    {
        if ( $this->_transferSourceLink instanceof Streamwide_Engine_Sip_Call_Leg )
        {
            $expectedConnectorType = Streamwide_Engine_Call_Leg_Connector::CONNECTOR_SIPSIP;
        } else {
            $expectedConnectorType = Streamwide_Engine_Call_Leg_Connector::CONNECTOR_SIPMS;
        }
        
        if ( $connector->getType() !== $expectedConnectorType ) {
            throw new InvalidArgumentException( sprintf( '%s expects parameter 1 to be a %s connector', __METHOD__, $expectedConnectorType ) );
        }
        
        $this->_connector = $connector;
    }
    
    /**
     * Get the connector that will perform the transfer
     *
     * @return Streamwide_Engine_Call_Leg_Connector
     */
    public function getConnector()
    {
        return $this->_connector;
    }
    
    /**
     * Set the connector that will reconnect the call legs in case the transfer fails
     *
     * @param Streamwide_Engine_Call_Leg_Connector $connector
     * @return void
     */
    public function setReconnector( Streamwide_Engine_Call_Leg_Connector $reconnector )
    {
        if ( $this->_transferSourceLink instanceof Streamwide_Engine_Sip_Call_Leg )
        {
            $expectedConnectorType = Streamwide_Engine_Call_Leg_Connector::CONNECTOR_SIPSIP;
        } else {
            $expectedConnectorType = Streamwide_Engine_Call_Leg_Connector::CONNECTOR_SIPMS;
        }
        
        if ( $reconnector->getType() !== $expectedConnectorType ) {
            throw new InvalidArgumentException( sprintf( '%s expects parameter 1 to be a %s connector', __METHOD__, $expectedConnectorType ) );
        }
        
        $this->_reconnector = $reconnector;
    }
    
    /**
     * Get the connector that will reconnect the call legs in case the transfer fails
     *
     * @return Streamwide_Engine_Call_Leg_Connector
     */
    public function getReconnector()
    {
        return $this->_reconnector;
    }
    
    /**
     * Set the parameters for the transfer
     *
     * @param array $transferParams
     * @return void
     */
    public function setTransferParams( Array $transferParams )
    {
        $this->_transferParams = $transferParams;
    }
    
    /**
     * Get the transfer parameters
     *
     * @return array
     */
    public function getTransferParams()
    {
        return $this->_transferParams;
    }
    
    /**
     * Start listening for a TRANSFER request
     *
     * @return boolean
     */
    public function start()
    {
        $this->_subscribeToEngineEvents();
        return true;
    }
    
    /**
     * Callback. Called when a TRANSFER is requested. Will notify the
     * call leg that emitted the TRANSFER request that REFER is accepted
     * and will start the transfer process
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onTransferRequested( Streamwide_Engine_Events_Event $event )
    {
        if ( !isset( $this->_transferParams['destinationNumber'] ) ) {
            $signal = $event->getParam( 'signal' );
            $params = $signal->getParams();
            
            if ( isset( $params['number'] ) ) {
                $this->_transferParams['destinationNumber'] = $params['number'];
            }
        }
        
        $trfInfo = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::TRFINFO,
            $this->_transferSource->getName(),
            array( 'code' => 1 )
        );
        
        if ( false === $trfInfo->send() ) {
            $this->dispatchErrorEvent( self::TRFINFO_SIGNAL_SEND_ERR_CODE );
            return;
        }
        
        $this->_startTransfer();
    }
    
    /**
     * Callback. Called whenever a RINGING or PROGRESS signal is received from
     * the call leg that will take the place of the call leg that emitted the
     * TRANSFER request
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onTransferProgress( Streamwide_Engine_Events_Event $event )
    {
        $trfInfo = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::TRFINFO,
            $this->_transferSource->getName()
        );
        
        if ( false === $trfInfo->send() ) {
            $this->dispatchErrorEvent( self::TRFINFO_SIGNAL_SEND_ERR_CODE );
            return;
        }
    }
    
    /**
     * Callback. Called when the transfer is successful. Will notify the call leg
     * that emitted the TRANSFER request, attempt to kill it and dispatch
     * a TRANSFERRED event
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onTransferSuccess( Streamwide_Engine_Events_Event $event )
    {
        $this->_connector->reset();
        
        $okTransfer = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::OKTRANSFER,
            $this->_transferSource->getName()
        );
        if ( false === $okTransfer->send() ) {
            $this->dispatchErrorEvent( self::OKTRANSFER_SIGNAL_SEND_ERR_CODE );
            return;
        }
        
        $kill = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::KILL,
            $this->_transferSource->getName()
        );
        if ( false === $kill->send() ) {
            $this->dispatchErrorEvent( self::KILL_SIGNAL_SEND_ERR_CODE );
            return;
        }
        
        $signal = $event->getParam( 'signal' );
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::TRANSFERRED );
        $event->setParam( 'signal', $signal );
        
        $this->dispatchEvent( $event );
    }
    
    /**
     * Callback. Called when the transfer has failed. Will notify the call leg that
     * emitted the TRANSFER and will attempt to reconnect the call legs.
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onTransferFailure( Streamwide_Engine_Events_Event $event )
    {
        $this->_connector->reset();
        
        $failTransfer = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::FAILTRANSFER,
            $this->_transferSource->getName()
        );
        if ( false === $failTransfer->send() ) {
            $this->dispatchErrorEvent( self::FAILTRANSFER_SIGNAL_SEND_ERR_CODE );
            return;
        }
        
        $this->_revertTransfer();
    }
    
    /**
     * Callback. Called when the call leg have been successfully reconnected.
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onReconnectSuccess( Streamwide_Engine_Events_Event $event )
    {
        $this->_reconnector->reset();
        $this->dispatchErrorEvent( self::TRANSFER_FAILED_RECONNECT_SUCCESS_ERR_CODE );
    }
    
    /**
     * Callback. Called when the attempt to reconnect the call legs has failed.
     *
     * @param Streamwide_Engine_Events_Event $event
     */
    public function onReconnectFailure( Streamwide_Engine_Events_Event $event )
    {
        $this->_reconnector->reset();
        $this->dispatchErrorEvent( self::TRANSFER_FAILED_RECONNECT_FAILURE_ERR_CODE );
    }
    
    /**
     * Start the transfer
     *
     * @return void
     */
    protected function _startTransfer()
    {
        $this->_connector->reset();
        $this->_connector->setConnectionParams( $this->_transferParams );
        if ( $this->_transferSourceLink instanceof Streamwide_Engine_Media_Server_Call_Leg ) {
            $this->_connector->setLeftCallLeg( $this->_transferDestination );
            $this->_connector->setRightCallLeg( $this->_transferSourceLink );
        } else {
            $this->_connector->setLeftCallLeg( $this->_transferSourceLink );
            $this->_connector->setRightCallLeg( $this->_transferDestination );
        }
        
        $this->_connector->addEventListener(
            Streamwide_Engine_Events_Event::CONNECTED,
            array(
                'callback' => array( $this, 'onTransferSuccess' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $this->_connector->addEventListener(
            Streamwide_Engine_Events_Event::ERROR,
            array(
                'callback' => array( $this, 'onTransferFailure' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $this->_connector->addEventListener(
            Streamwide_Engine_Events_Event::RINGING,
            array( 'callback' => array( $this, 'onTransferProgress' ) )
        );
        $this->_connector->addEventListener(
            Streamwide_Engine_Events_Event::PROGRESS,
            array( 'callback' => array( $this, 'onTransferProgress' ) )
        );
        
        $this->_connector->connect();
    }
    
    /**
     * Revert the transfer (reconnect the call legs)
     *
     * @return void
     */
    protected function _revertTransfer()
    {
        $this->_reconnector->reset();
        $this->_reconnector->setLeftCallLeg( $this->_transferSource );
        $this->_reconnector->setRightCallLeg( $this->_transferSourceLink );
        
        $this->_reconnector->addEventListener(
            Streamwide_Engine_Events_Event::CONNECTED,
            array(
                'callback' => array( $this, 'onReconnectSuccess' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $this->_reconnector->addEventListener(
            Streamwide_Engine_Events_Event::ERROR,
            array(
                'callback' => array( $this, 'onReconnectFailure' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        
        $this->_reconnector->connect();
    }
    
    /**
     * Listen for a TRANSFER request
     *
     * @return void
     */
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        
        // Start listen to TRANSFER signal
        $transferNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_transferSource->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::TRANSFER,
            array(
                'callback' => array( $this, 'onTransferRequested' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $transferNotifyFilter
                )
            )
        );
        // End listen to TRANSFER signal
    }
    
    /**
     * Stop listening for a TRANSFER request
     *
     * @return void
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $controller = $this->getController();
        
        $controller->removeEventListener(
            Streamwide_Engine_Events_Event::TRANSFER,
            array( 'callback' => array( $this, 'onTransferRequested' ) )
        );
    }
    
}
 
/* EOF */