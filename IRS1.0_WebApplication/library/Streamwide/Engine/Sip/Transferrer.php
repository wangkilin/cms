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

class Streamwide_Engine_Sip_Transferrer extends Streamwide_Engine_Widget
{
    const STATE_READY = 'READY';
    const STATE_TRANSFERRING = 'TRANSFERRING';
    
    /**
     * Widget options
     */
    const OPT_TRANSFER_DESTINATION = 'transfer_destination';
    const OPT_TRANSFER_HEADERS = 'transfer_headers';

    /**
     * Error codes
     */
    const TRANSFER_SIGNAL_SEND_ERR_CODE = 'SIPTRANSFERRER-100';
    const TRANSFER_FAILED_ERR_CODE = 'SIPTRANSFERRER-200';
    const CALL_LEG_DIED_ERR_CODE = 'SIPTRANSFERRER-201';
    const ALREADY_TRANSFERRING_ERR_CODE = 'SIPTRANSFERRER-300';
    const NOT_TRANSFERRING_ERR_CODE = 'SIPTRANSFERRER-301';
    const DEAD_CALL_LEG_ERR_CODE = 'SIPTRANSFERRER-302';

    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::TRANSFER_SIGNAL_SEND_ERR_CODE => 'Unable to send signal the TRANSFER signal to SW Engine',
        self::TRANSFER_FAILED_ERR_CODE => 'Transfer failed',
        self::CALL_LEG_DIED_ERR_CODE => 'The SIP call leg died in the middle of the transfer process',
        self::ALREADY_TRANSFERRING_ERR_CODE => 'The SIP Transferrer is already runngin',
        self::NOT_TRANSFERRING_ERR_CODE => 'The SIP Transferrer is not runnging',
        self::DEAD_CALL_LEG_ERR_CODE => 'Cannot transfer a dead call leg'
    );
    
    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::TRANSFERRED,
        Streamwide_Engine_Events_Event::TRANSFER_INFO,
        Streamwide_Engine_Events_Event::ERROR
    );
    
    /**
     * The sip call leg we want to transfer
     *
     * @var Streamwide_Engine_Sip_Call_Leg
     */
    protected $_sipCallLeg;
    
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_stateManager = new Streamwide_Engine_Widget_State_Manager(
            array(
                self::STATE_READY,
                self::STATE_TRANSFERRING
            )
        );
        $this->_initDefaultOptions();
    }
    
    /**
     * Destructor
     *
     * @see Engine/Streamwide_Engine_Widget#destroy()
     */
    public function destroy()
    {
        if ( isset( $this->_sipCallLeg ) ) {
            unset( $this->_sipCallLeg );
        }
        
        parent::destroy();
    }
    
    /**
     * Set the call leg to be transferred
     *
     * @param Streamwide_Engine_Sip_Call_Leg $callLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setSipCallLeg( Streamwide_Engine_Sip_Call_Leg $callLeg )
    {
        if ( !$callLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive SIP call leg' );
        }
        if ( !$callLeg->hasSentOrReceivedOk() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive SIP call leg that has received the OK signal' );
        }
        $this->_sipCallLeg = $callLeg;
    }
    
    /**
     * Get the call leg to be transferred
     *
     * @return Streamwide_Engine_Sip_Call_Leg
     */
    public function getSipCallLeg()
    {
        return $this->_sipCallLeg;
    }
    
    /**
     * Perform the transfer
     *
     * @return boolean
     * @throws RuntimeException
     */
    public function transfer()
    {
        if ( !isset( $this->_options[self::OPT_TRANSFER_DESTINATION] ) ) {
            throw new RuntimeException( 'Transfer destination has not been provided' );
        }
        
        if ( !$this->_sipCallLeg->isAlive() ) {
            $this->dispatchErrorEvent( self::DEAD_CALL_LEG_ERR_CODE );
            return false;
        }
        
        if ( $this->isTransferring() ) {
            $this->dispatchErrorEvent( self::ALREADY_TRANSFERRING_ERR_CODE );
            return false;
        }
        
        $params = array( 'number' => $this->_options[self::OPT_TRANSFER_DESTINATION] );
        
        $headers = $this->_options[self::OPT_TRANSFER_HEADERS];
        if ( !empty( $headers ) ) {
            foreach ( $headers as $name => $value ) {
                $params[$name] = $value;
            }
        }
        
        $transferSignal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::TRANSFER,
            $this->_sipCallLeg->getName(),
            $params
        );
        
        if ( false === $transferSignal->send() ) {
            $this->dispatchErrorEvent( self::TRANSFER_SIGNAL_SEND_ERR_CODE );
            return false;
        }
        
        $this->_subscribeToEngineEvents();
        $this->_stateManager->setState( self::STATE_TRANSFERRING );
        return true;
    }
    
    /**
     * Is the widget ready to start the transfer process?
     *
     * @return boolean
     */
    public function isReady()
    {
        return ( $this->_stateManager->getState() === self::STATE_READY );
    }
    
    /**
     * Is the widget in the middle of the transfer process?
     *
     * @return boolean
     */
    public function isTransferring()
    {
        return ( $this->_stateManager->getState() === self::STATE_TRANSFERRING );
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#reset()
     */
    public function reset()
    {
        parent::reset();
        
        $this->_stateManager->setState( self::STATE_READY );
    }
    
    /**
     * We received a TRFINFO signal. We need to dispatch a TRANSFER_INFO event
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onTransferInfo( Streamwide_Engine_Events_Event $event )
    {
        $signal = $event->getParam( 'signal' );

        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::TRANSFER_INFO );
        $event->setParam( 'signal', $signal );
        
        $this->dispatchEvent( $event );
    }
    
    /**
     * The transfer has completed successfully. We need to dispath a TRANSFERRED event
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onTransferSuccess( Streamwide_Engine_Events_Event $event )
    {
        $this->_unsubscribeFromEngineEvents();
        $this->_stateManager->setState( self::STATE_READY );
        
        $this->_sipCallLeg->setDead();
        
        $signal = $event->getParam( 'signal' );
        
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::TRANSFERRED );
        $event->setParam( 'signal', $signal );
        $this->dispatchEvent( $event );
    }
    
    /**
     * The transfer has failed. We need to dispatch an ERROR event
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onTransferFailure( Streamwide_Engine_Events_Event $event )
    {
        $this->_unsubscribeFromEngineEvents();
        $this->_stateManager->setState( self::STATE_READY );
        
        $signal = $event->getParam( 'signal' );
        $params = $signal->getParams();
        
        $failureCode = isset( $params['code'] ) ? $params['code'] : null;
        
        $this->dispatchErrorEvent(
            self::TRANSFER_FAILED_ERR_CODE,
            array(
                'failureCode' => $failureCode,
                'signal' => $signal
            )
        );
    }
    
    /**
     * Handle the death of the call leg we want to transfer
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onCallLegDeath( Streamwide_Engine_Events_Event $event )
    {
        $this->_unsubscribeFromEngineEvents();
        $this->_stateManager->setState( self::STATE_READY );
        
        $this->_sipCallLeg->setDead();
        
        $this->dispatchErrorEvent( self::CALL_LEG_DIED_ERR_CODE );
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#setOptions($options)
     */
    public function setOptions( Array $options )
    {
        $transferDestination = isset( $options[self::OPT_TRANSFER_DESTINATION] ) ? $options[self::OPT_TRANSFER_DESTINATION] : null;
        $this->_treatTransferDestinationOption( $transferDestination );

        $transferHeaders = isset( $options[self::OPT_TRANSFER_HEADERS] ) ? $options[self::OPT_TRANSFER_HEADERS] : null;
        $this->_treatTransferHeadersOption( $transferHeaders );
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#_subscribeToEngineEvents()
     */
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        
        $okTransferNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_sipCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::OKTRANSFER,
            array(
                'callback' => array( $this, 'onTransferSuccess' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $okTransferNotifyFilter
                )
            )
        );
        
        $failTransferNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_sipCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::FAILTRANSFER,
            array(
                'callback' => array( $this, 'onTransferFailure' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $failTransferNotifyFilter
                )
            )
        );
        
        $trfInfoNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_sipCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::TRFINFO,
            array(
                'callback' => array( $this, 'onTransferInfo' ),
                'options' => array( 'notifyFilter' => $trfInfoNotifyFilter )
            )
        );
        
        $childNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_sipCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::CHILD,
            array(
                'callback' => array( $this, 'onCallLegDeath' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $childNotifyFilter
                )
            )
        );
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#_unsubscribeFromEngineEvents()
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $controller = $this->getController();
        $controller->removeEventListener(
            Streamwide_Engine_Events_Event::OKTRANSFER,
            array( 'callback' => array( $this, 'onTransferSuccess' ) )
        );
        
        $controller->removeEventListener(
            Streamwide_Engine_Events_Event::FAILTRANSFER,
            array( 'callback' => array( $this, 'onTransferFailure' ) )
        );
        
        $controller->removeEventListener(
            Streamwide_Engine_Events_Event::TRFINFO,
            array( 'callback' => array( $this, 'onTransferInfo' ) )
        );
        
        $controller->removeEventListener(
            Streamwide_Engine_Events_Event::CHILD,
            array( 'callback' => array( $this, 'onCallLegDeath' ) )
        );
    }
    
    /**
     * Treat the "transfer_destination" option. The value of this option can be
     * the phone number or complete "sip:" uri to forward to. This option is
     * mandatory
     *
     * @param mixed $transferDestination
     * @return void
     * @throws Exception
     */
    protected function _treatTransferDestinationOption( $transferDestination = null )
    {
        if ( null === $transferDestination ) {
            throw new Exception( sprintf( 'Required option "%s" not provided', self::OPT_TRANSFER_DESTINATION ) );
        }
        
        if ( !is_string( $transferDestination ) || strlen( $transferDestination ) < 1 ) {
            throw new Exception( sprintf( 'Invalid value provided for "%s" option', self::OPT_TRANSFER_DESTINATION ) );
        }
        
        $this->_options[self::OPT_TRANSFER_DESTINATION] = $transferDestination;
    }
    
    /**
     * Treat the "transfer_headers" options. The value for this option is an array of headers
     * with keys being the header names and values being the header values.
     *
     * @param mixed $transferHeaders
     * @return void
     */
    protected function _treatTransferHeadersOption( $transferHeaders = null )
    {
        if ( null === $transferHeaders ) {
            return null;
        }
        
        if ( is_array( $transferHeaders ) ) {
            $this->_options[self::OPT_TRANSFER_HEADERS] = $transferHeaders;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_TRANSFER_HEADERS ) );
        }
    }
    
    /**
     * Initialize options to their default values
     *
     * @return void
     */
    protected function _initDefaultOptions()
    {
        $this->_options[self::OPT_TRANSFER_HEADERS] = array();
    }
    
}
 
/* EOF */