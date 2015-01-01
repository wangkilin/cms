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

class Streamwide_Engine_Transfer_Forwarder extends Streamwide_Engine_Widget
{
    
    /**
     * The widget is ready to be started
     *
     * @var string
     */
    const STATE_READY = 'READY';
    
    /**
     * The widget is listening to a TRANSFER event
     *
     * @var string
     */
    const STATE_LISTENING = 'LISTENING';
    
    /**
     * The widget is forwarding the transfer to the right call leg
     *
     * @var string
     */
    const STATE_FORWARDING = 'FORWARDING';
    
    /**
     * Whether or not to KILL the left call leg on OKTRANSFER
     *
     * @var boolean
     */
    const OPT_KILL_LEFT_CALL_LEG = 'kill_left_call_leg';
    
    /**
     * How long to wait (in seconds) for the TRANSFER signal
     *
     * @var float
     */
    const OPT_LISTENING_DELAY = 'listening_delay';
    
    /**
     * Default value for the "kill_left_call_leg" option
     *
     * @var boolean
     */
    const KILL_LEFT_CALL_LEG_DEFAULT = true;
    
    /**
     * Default value for the "listening_delay" option
     *
     * @var integer
     */
    const DEFAULT_LISTENING_DELAY = -1;
    
    /**
     * The timer could not be armed
     *
     * @var string
     */
    const TIMER_ARM_ERR_CODE = 'TRANSFERFORWARDER-200';
    
    /**
     * The relayer could not be started
     *
     * @var string
     */
    const RELAYER_START_ERR_CODE = 'TRANSFERFORWARDER-201';
    
    /**
     * The time allocated to widget for listening to a TRANSFER event has elapsed
     *
     * @var string
     */
    const LISTENING_TIMER_EXPIRED_ERR_CODE = 'TRANSFERFORWARDER-202';
    
    /**
     * The attempt to forward the TRANSFER to the right SIP call leg has failed
     *
     * @var string
     */
    const TRANSFER_FORWARDING_ERR_CODE = 'TRANSFERFORWARDER-203';
    
    /**
     * An attempt was made to start the widget, but the widget was already started
     *
     * @var string
     */
    const ALREADY_STARTED_ERR_CODE = 'TRANSFERFORWARDER-300';
    
    /**
     * An attempt was made to stop the widget, but the widget was already stopped
     *
     * @var string
     */
    const ALREADY_STOPPED_ERR_CODE = 'TRANSFERFORWARDER-301';
    
    /**
     * An attempt was made to stop the widget, but the widget was in the middle of the forwarding process
     *
     * @var string
     */
    const FORWARDING_ERR_CODE = 'TRANSFERFORWARDER-302';
    
    /**
     * An attempt was made to start the widget, but one of the sip call legs is dead
     *
     * @var string
     */
    const DEAD_CALL_LEG_ERR_CODE = 'TRANSFERFORWARDER-303';
    
    /**
     * The left SIP call leg. The TRANSFER signal received from this call leg is
     * forwarded to the right SIP call leg
     *
     * @var Streamwide_Engine_Sip_Call_Leg
     */
    protected $_leftCallLeg;
    
    /**
     * The right SIP call leg. The TRANSFER signal received from the left SIP call leg
     * is forwarded to this call leg
     *
     * @var Streamwide_Engine_Sip_Call_Leg
     */
    protected $_rightCallLeg;
    
    /**
     * Relayer to handle signalization of TRFINFO, OKTRANSFER, FAILTRANSFER between
     * the two SIP call legs
     *
     * @var Streamwide_Engine_Automatic_Signal_Relayer
     */
    protected $_relayer;
    
    /**
     * @var Streamwide_Engine_Timer_Timeout
     */
    protected $_timer;
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::TIMER_ARM_ERR_CODE => 'Timer widget could not be armed',
        self::RELAYER_START_ERR_CODE => 'Relayer widget could not be started',
        self::LISTENING_TIMER_EXPIRED_ERR_CODE => 'The time allocated for listening to a TRANSFER event has elapsed',
        self::TRANSFER_FORWARDING_ERR_CODE => 'The attempt to forward the TRANSFER to the right SIP call leg has failed',
        self::ALREADY_STARTED_ERR_CODE => 'Cannot start, the widget is already started',
        self::ALREADY_STOPPED_ERR_CODE => 'Cannot stop, the widget is already stopped',
        self::FORWARDING_ERR_CODE => 'Cannot stop, the widget is in the middle of the forwarding process',
        self::DEAD_CALL_LEG_ERR_CODE => 'Cannot listen for TRANSFER or forward a TRANSFER because one of the SIP call legs is dead'
    );
    
    /**
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::TRANSFER_FORWARDED,
        Streamwide_Engine_Events_Event::TRANSFER_FORWARDING_STARTED,
        Streamwide_Engine_Events_Event::TRANSFER_FORWARDING_STOPPED,
        Streamwide_Engine_Events_Event::TRANSFER_LISTENING_TIMEOUT,
        Streamwide_Engine_Events_Event::ERROR
    );
    
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
                self::STATE_LISTENING,
                self::STATE_FORWARDING
            )
        );
        $this->_initDefaultOptions();
    }
    
    /**
     * Destructor
     *
     * @return void
     */
    public function destroy()
    {
        if ( isset( $this->_leftCallLeg ) ) {
            unset( $this->_leftCallLeg );
        }
        
        if ( isset( $this->_rightCallLeg ) ) {
            unset( $this->_rightCallLeg );
        }
        
        if ( isset( $this->_relayer ) ) {
            $this->_relayer->destroy();
            unset( $this->_relayer );
        }
        
        if ( isset( $this->_timer ) ) {
            $this->_timer->destroy();
            unset( $this->_timer );
        }
        
        parent::destroy();
    }
    
    /**
     * @param Streamwide_Engine_Sip_Call_Leg $leftCallLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setLeftCallLeg( Streamwide_Engine_Sip_Call_Leg $leftCallLeg )
    {
        if ( !$leftCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be an alive SIP call leg' );
        }
        
        $this->_leftCallLeg = $leftCallLeg;
    }
    
    /**
     * @return Streamwide_Engine_Sip_Call_Leg
     */
    public function getLeftCallLeg()
    {
        return $this->_leftCallLeg;
    }
    
    /**
     * @param Streamwide_Engine_Sip_Call_Leg $rightCallLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setRightCallLeg( Streamwide_Engine_Sip_Call_Leg $rightCallLeg )
    {
        if ( !$rightCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be an alive SIP call leg' );
        }
        
        if ( !$rightCallLeg->hasSentOrReceivedOk() ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be an alive SIP that has sent or received the OK signal' );
        }
        
        $this->_rightCallLeg = $rightCallLeg;
    }
    
    /**
     * @return Streamwide_Engine_Sip_Call_Leg
     */
    public function getRightCallLeg()
    {
        return $this->_rightCallLeg;
    }
    
    /**
     * @param Streamwide_Engine_Automatic_Signal_Relayer $relayer
     * @return void
     */
    public function setRelayer( Streamwide_Engine_Automatic_Signal_Relayer $relayer )
    {
        $this->_relayer = $relayer;
    }
    
    /**
     * @return Streamwide_Engine_Automatic_Signal_Relayer
     */
    public function getRelayer()
    {
        return $this->_relayer;
    }
    
    /**
     * @param Streamwide_Engine_Timer_Timeout $timer
     * @return void
     */
    public function setTimer( Streamwide_Engine_Timer_Timeout $timer )
    {
        $this->_timer = $timer;
    }
    
    /**
     * @return Streamwide_Engine_Timer_Timeout
     */
    public function getTimer()
    {
        return $this->_timer;
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#setOptions($options)
     */
    public function setOptions( Array $options )
    {
        $killLeftCallLeg = isset( $options[self::OPT_KILL_LEFT_CALL_LEG] )
            ? $options[self::OPT_KILL_LEFT_CALL_LEG]
            : null;
        $this->_treatKillLeftCallLegOption( $killLeftCallLeg );
        
        $listeningDelay = isset( $options[self::OPT_LISTENING_DELAY] )
            ? $options[self::OPT_LISTENING_DELAY]
            : null;
        $this->_treatListeningDelayOption( $listeningDelay );
    }
    
    /**
     * Start listening for TRANSFER
     *
     * @return boolean
     */
    public function start()
    {
        if ( !$this->_ensureAliveCallLegs() ) {
            return false;
        }
        
        if ( !$this->isReady() ) {
            $this->dispatchErrorEvent( self::ALREADY_STARTED_ERR_CODE );
            return false;
        }
        
        if ( !$this->_startRelayer() ) {
            return false;
        }
        
        if ( !$this->_armTimer() ) {
            $this->_relayer->reset();
            return false;
        }
        
        $this->_stateManager->setState( self::STATE_LISTENING );
        
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::TRANSFER_FORWARDING_STARTED ) );
        return true;
    }
    
    /**
     * Stop listening for TRANSFER or stop the forwarding process
     *
     * @return boolean
     */
    public function stop()
    {
        if ( $this->isReady() ) {
            $this->dispatchErrorEvent( self::ALREADY_STOPPED_ERR_CODE );
            return false;
        }
        
        if ( $this->isForwarding() ) {
            $this->dispatchErrorEvent( self::FORWARDING_ERR_CODE );
            return false;
        }

        $this->_resetInternalWidgets();
        
        $this->_stateManager->setState( self::STATE_READY );
        
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::TRANSFER_FORWARDING_STOPPED ) );
        return true;
    }
    
    /**
     * Is the widget ready?
     *
     * @return boolean
     */
    public function isReady()
    {
        return ( $this->_stateManager->getState() === self::STATE_READY );
    }
    
    /**
     * Is the widget listening for a TRANSFER event?
     *
     * @return boolean
     */
    public function isListening()
    {
        return ( $this->_stateManager->getState() === self::STATE_LISTENING );
    }
    
    /**
     * Is the widget forwarding a TRANSFER?
     *
     * @return boolean
     */
    public function isForwarding()
    {
        return ( $this->_stateManager->getState() === self::STATE_FORWARDING );
    }
    
    /**
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onSignalRelayed( Streamwide_Engine_Events_Event $event )
    {
        $signal = $event->getParam( 'signal' );
        
        switch ( $signal->getName() ) {
            case Streamwide_Engine_Signal::TRANSFER:
                $this->_handleTransferSignal( $signal );
            break;
            case Streamwide_Engine_Signal::OKTRANSFER:
                $this->_handleOkTransferSignal( $signal );
            break;
            case Streamwide_Engine_Signal::FAILTRANSFER:
                $this->_handleFailTransferSignal( $signal );
            break;
        }
    }
    
    /**
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onListeningTimeout( Streamwide_Engine_Events_Event $event )
    {
        $this->_relayer->reset();
        $this->_stateManager->setState( self::STATE_READY );
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::TRANSFER_LISTENING_TIMEOUT ) );
    }
    
    /**
     * Callback. Deals with relayer errors
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onRelayerError( Streamwide_Engine_Events_Event $event )
    {
        $this->_handleTransferForwardingFailure();
    }
    
    /**
     * The relayer relayed a TRANSFER signal. We change the widget state
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleTransferSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_stateManager->setState( self::STATE_FORWARDING );
    }
    
    /**
     * The relayer relayed an OKTRANSFER signal. The TRANSFER forwarding was
     * successfull.
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleOkTransferSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_resetInternalWidgets();
        $this->_killLeftCallLeg();
        $this->_stateManager->setState( self::STATE_READY );
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::TRANSFER_FORWARDED ) );
    }
    
    /**
     * The relayer relayed a FAILTRANSFER signal. The TRANSFER forwarding has
     * failed
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleFailTransferSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_handleTransferForwardingFailure();
    }
    
    /**
     * @return void
     */
    protected function _handleTransferForwardingFailure()
    {
        $this->_resetInternalWidgets();
        $this->_stateManager->setState( self::STATE_READY );
        $this->dispatchErrorEvent( self::TRANSFER_FORWARDING_ERR_CODE );
    }
    
    /**
     * @return boolean
     */
    protected function _startRelayer()
    {
        $eventsList = array(
            array(
                'name' => Streamwide_Engine_Events_Event::TRANSFER,
                'source' => Streamwide_Engine_Automatic_Signal_Relayer::SIG_SRC_LEFT
            ),
            array(
                'name' => Streamwide_Engine_Events_Event::TRFINFO,
                'source' => Streamwide_Engine_Automatic_Signal_Relayer::SIG_SRC_RIGHT
            ),
            array(
                'name' => Streamwide_Engine_Events_Event::OKTRANSFER,
                'source' => Streamwide_Engine_Automatic_Signal_Relayer::SIG_SRC_RIGHT
            ),
            array(
                'name' => Streamwide_Engine_Events_Event::FAILTRANSFER,
                'source' => Streamwide_Engine_Automatic_Signal_Relayer::SIG_SRC_RIGHT
            )
        );

        $this->_relayer->reset();
        $this->_relayer->setLeftCallLeg( $this->_leftCallLeg );
        $this->_relayer->setRightCallLeg( $this->_rightCallLeg );
        $this->_relayer->setEventsList( $eventsList );
        
        $this->_relayer->addEventListener(
            Streamwide_Engine_Events_Event::SIGNAL_RELAYED,
            array( 'callback' => array( $this, 'onSignalRelayed' ) )
        );
        
        $this->_relayer->addEventListener(
            Streamwide_Engine_Events_Event::ERROR,
            array(
                'callback' => array( $this, 'onRelayerError' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        
        if ( !$this->_relayer->start() ) {
            $this->_relayer->reset();
            $this->dispatchErrorEvent( self::RELAYER_START_ERR_CODE );
            return false;
        }
        
        return true;
    }
    
    /**
     * @return boolean
     */
    protected function _armTimer()
    {
        $listeningDelay = $this->_options[self::OPT_LISTENING_DELAY];
        
        if ( isset( $this->_timer ) && $listeningDelay > 0 ) {
            $this->_timer->reset();
            $this->_timer->setOptions( array( Streamwide_Engine_Timer_Timeout::OPT_DELAY => $listeningDelay ) );
            $this->_timer->addEventListener(
                Streamwide_Engine_Events_Event::TIMEOUT,
                array(
                    'callback' => array( $this, 'onListeningTimeout' ),
                    'options' => array( 'autoRemove' => 'before' )
                )
            );
            
            if ( !$this->_timer->arm() ) {
                $this->_timer->reset();
                $this->dispatchErrorEvent( self::TIMER_ARM_ERR_CODE );
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * @return void
     */
    protected function _resetInternalWidgets()
    {
        $this->_relayer->reset();
        
        if ( isset( $this->_timer ) ) {
            $this->_timer->reset();
        }
    }
    
    /**
     * @return void
     */
    protected function _killLeftCallLeg()
    {
        $shouldKillLeftCallLeg = $this->_options[self::OPT_KILL_LEFT_CALL_LEG];
        
        if ( $shouldKillLeftCallLeg ) {
            $killSignal = Streamwide_Engine_Signal::factory(
                Streamwide_Engine_Signal::KILL,
                $this->_leftCallLeg->getName()
            );
            
            if ( $killSignal->send() ) {
                $this->_leftCallLeg->setDead();
            }
        }
    }
    
    /**
     * Make sure that both the SIP call legs are alive
     *
     * @return boolean
     */
    protected function _ensureAliveCallLegs()
    {
        if ( $this->_leftCallLeg->isAlive() && $this->_rightCallLeg->isAlive() ) {
            return true;
        }
        
        $this->dispatchErrorEvent( self::DEAD_CALL_LEG_ERR_CODE );
        return false;
    }
    
    /**
     * @param mixed $killLeftCallLeg
     * @return void
     */
    protected function _treatKillLeftCallLegOption( $killLeftCallLeg = null )
    {
        if ( null === $killLeftCallLeg ) {
            return null;
        }
        
        if ( is_int( $killLeftCallLeg ) || is_string( $killLeftCallLeg ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to boolean', self::OPT_KILL_LEFT_CALL_LEG ) );
            $killLeftCallLeg = (bool)$killLeftCallLeg;
        }
        
        if ( is_bool( $killLeftCallLeg ) ) {
            $this->_options[self::OPT_KILL_LEFT_CALL_LEG] = $killLeftCallLeg;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_KILL_LEFT_CALL_LEG ) );
        }
    }
    
    /**
     * @param mixed $listeningDelay
     * @return void
     */
    protected function _treatListeningDelayOption( $listeningDelay = null )
    {
        if ( null === $listeningDelay ) {
            return;
        }
        
        if ( is_int( $listeningDelay ) ) {
            $listeningDelay = (float)$listeningDelay;
        } elseif (
            is_string( $listeningDelay )
            && preg_match( '~^(?:0|[1-9][0-9]*)(?:\.[0-9]+)?$~', $listeningDelay ) === 1 )
        {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to float', self::OPT_LISTENING_DELAY ) );
            $listeningDelay = (float)$listeningDelay;
        }

        if ( !is_float( $listeningDelay ) ) {
            trigger_error( sprintf( 'Invalid value provided for "%s" option. Using default value', self::OPT_LISTENING_DELAY ) );
        } else {
            $this->_options[self::OPT_LISTENING_DELAY] = round( $listeningDelay, 3 );
        }
    }
    
    /**
     * Init options to their default values
     *
     * @return void
     */
    protected function _initDefaultOptions()
    {
        $this->_options[self::OPT_KILL_LEFT_CALL_LEG] = self::KILL_LEFT_CALL_LEG_DEFAULT;
        $this->_options[self::OPT_LISTENING_DELAY] = self::DEFAULT_LISTENING_DELAY;
    }

}
 
/* EOF */