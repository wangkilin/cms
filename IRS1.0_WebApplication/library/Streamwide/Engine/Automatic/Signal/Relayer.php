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
 * @subpackage Streamwide_Engine_Widget
 * @version 1.0
 *
 */

/**
 * Automatically relays SW Engine signals between 2 call legs
 */
class Streamwide_Engine_Automatic_Signal_Relayer extends Streamwide_Engine_Widget
{
    
    /**
     * Events that trigger the starting of a relaying session
     *
     * @var array
     */
    const RS_PARAM_STARTER_EVENTS = 'relaySessionStarterEvents';
    
    /**
     * Events that trigger the stopping of a relaying session
     *
     * @var array
     */
    const RS_PARAM_ENDING_EVENTS = 'relaySessionEndingEvents';
    
    /**
     * The widget is ready to start relaying signals
     *
     * @var string
     */
    const STATE_READY = 'READY';
    
    /**
     * The widget has started relaying signals
     *
     * @var string
     */
    const STATE_RUNNING = 'RUNNING';
    
    /**
     * A signal relay that had the left call leg as the source
     * and the right call leg as the destination
     *
     * @var string
     */
    const LEFT_TO_RIGHT_RELAY = 'LTRR';
    
    /**
     * A signal relay that had the right call leg as the source
     * and the left call leg as the destination
     *
     * @var string
     */
    const RIGHT_TO_LEFT_RELAY = 'RTLR';
    
    /**
     * The signal is considered as viable for relaying no matter what its source is
     *
     * @var string
     */
    const SIG_SRC_BOTH = 'both';
    
    /**
     * The signal is considered as viable for relaying only if it has the left call
     * leg as its source
     *
     * @var string
     */
    const SIG_SRC_LEFT = 'left';
    
    /**
     * The signal is considered as viable for relaying only if it has the right call
     * leg as its source
     *
     * @var string
     */
    const SIG_SRC_RIGHT = 'right';
    
    /**
     * Global priority for the events in the events list. The explicit priority set
     * for the a particular event in the list takes precedence over this one
     *
     * @var integer
     */
    const OPT_PRIORITY = 'priority';
    
    /**
     * Whether or not to use the default events list
     *
     * @var boolean
     */
    const OPT_USE_DEFAULT_EVENTS_LIST = 'use_default_events_list';
    
    /**
     * Whether or not to enable relaying session support
     *
     * @var boolean
     */
    const OPT_ENABLE_RELAY_SESSIONS = 'enable_relay_sessions';

    /**
     * The default value for the priority option
     *
     * @var integer
     */
    const DEFAULT_PRIORITY = 0;
    
    /**
     * The default value for the "use default events list" option
     *
     * @var boolean
     */
    const USE_DEFAULT_EVENTS_LIST_DEFAULT = false;
    
    /**
     * The default value for the "enable relay sessions" option
     *
     * @var boolean
     */
    const ENABLE_RELAY_SESSIONS_DEFAULT = false;

    /**
     * An error has been encountered while attempting to relay a signal from one call leg
     * to the other
     *
     * @var string
     */
    const SIGNAL_RELAY_ERR_CODE = 'RELAYER-100';
    
    /**
     * One of the call legs died in the middle of the relaying process
     *
     * @var string
     */
    const CALL_LEG_DIED_ERR_CODE = 'RELAYER-200';
    
    /**
     * Attempt to start the relayer with an empty events list
     *
     * @var string
     */
    const EMPTY_EVENTS_LIST_ERR_CODE = 'RELAYER-201';
    
    /**
     * An attempt was made to stop the relaying process, but the widget was not running
     *
     * @var string
     */
    const NOT_RUNNING_ERR_CODE = 'RELAYER-300';
    
    /**
     * An attempt was made to start the relaying process, but the widget was already running
     *
     * @var string
     */
    const ALREADY_RUNNING_ERR_CODE = 'RELAYER-301';
    
    /**
     * An attempt was made to start the relaying process, but one of the call legs is dead
     *
     * @var string
     */
    const DEAD_CALL_LEG_ERR_CODE = 'RELAYER-302';
    
    /**
     * Left call leg
     *
     * @var Streamwide_Engine_Call_Leg_Abstract
     */
    protected $_leftCallLeg;
    
    /**
     * Right call leg
     *
     * @var Streamwide_Engine_Call_Leg_Abstract
     */
    protected $_rightCallLeg;

    /**
     * A list with events to listen for (these are events that describe the receiving
     * of a SW Engine signal in Controller)
     *
     * @var array
     */
    protected $_eventsList = array();
    
    /**
     * If an events list is not provided before calling the start() method and the
     * "use default events list" option is set to true the relayer will use this
     * events list (but only if it's not empty)
     *
     * @var array
     */
    static protected $_defaultEventsList = array(
        array(
            'name' => Streamwide_Engine_Events_Event::MOVED,
            'source' => self::SIG_SRC_BOTH,
            'priority' => self::DEFAULT_PRIORITY,
            'callback' => null
        ),
        array(
            'name' => Streamwide_Engine_Events_Event::OKMOVED,
            'source' => self::SIG_SRC_BOTH,
            'priority' => self::DEFAULT_PRIORITY,
            'callback' => null
        ),
        array(
            'name' => Streamwide_Engine_Events_Event::FAILMOVED,
            'source' => self::SIG_SRC_BOTH,
            'priority' => self::DEFAULT_PRIORITY,
            'callback' => null
        ),
        array(
            'name' => Streamwide_Engine_Events_Event::SDP,
            'source' => self::SIG_SRC_BOTH,
            'priority' => self::DEFAULT_PRIORITY,
            'callback' => null
        ),
        array(
            'name' => Streamwide_Engine_Events_Event::OKSDP,
            'source' => self::SIG_SRC_BOTH,
            'priority' => self::DEFAULT_PRIORITY,
            'callback' => null
        ),
        array(
            'name' => Streamwide_Engine_Events_Event::FAILSDP,
            'source' => self::SIG_SRC_BOTH,
            'priority' => self::DEFAULT_PRIORITY,
            'callback' => null
        )
    );
    
    /**
     * The relay session parameters. Contains the signal(s) that denote the start of a relay
     * session and the signal(s) that denote the end of a relay session
     *
     * @var array
     */
    protected $_relaySessionParams = array();
    
    /**
     * Flag to tell us if the relayer has a relay session started
     *
     * @var boolean
     */
    protected $_isRelaySessionStarted = false;
    
    /**
     * The flow of the previous signal relay (left to right, or right to left)
     *
     * @var string
     */
    protected $_relayFlow;
    
    /**
     * Flag to indicate that a CHILD signal has been received and one of
     * the call legs involved in the relaying process has died
     *
     * @var boolean
     */
    protected $_isCallLegDead = false;
    
    /**
     * Flag to indicate that a OKMOVED signal has been received and one
     * of the call legs involved in the relaying process has updated his
     * parameters
     *
     * @var boolean
     */
    protected $_isCallLegUpdated = false;
    
    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::SIGNAL_RELAYED,
        Streamwide_Engine_Events_Event::RELAY_SESSION_STARTED,
        Streamwide_Engine_Events_Event::RELAY_SESSION_ENDED,
        Streamwide_Engine_Events_Event::ERROR
    );
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::SIGNAL_RELAY_ERR_CODE => 'Unable to relay signal %s to %s',
        self::CALL_LEG_DIED_ERR_CODE => 'The call leg has died',
        self::EMPTY_EVENTS_LIST_ERR_CODE => 'Attempt to start the relayer with an empty events list',
        self::NOT_RUNNING_ERR_CODE => 'The relayer is not running',
        self::ALREADY_RUNNING_ERR_CODE => 'The relayer is already running',
        self::DEAD_CALL_LEG_ERR_CODE => 'Attempt to start the relaying process when one of the call legs is dead'
    );
    
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setStateManager(
            new Streamwide_Engine_Widget_State_Manager(
                array(
                    self::STATE_READY,
                    self::STATE_RUNNING
                )
            )
        );
        $this->_initDefaultOptions();
    }
    
    /**
     * Destructor
     */
    public function destroy()
    {
        if ( isset( $this->_leftCallLeg ) ) {
            unset( $this->_leftCallLeg );
        }
        
        if ( isset( $this->_rightCallLeg ) ) {
            unset( $this->_rightCallLeg );
        }
        
        unset( $this->_eventsList );
        
        parent::destroy();
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#reset()
     */
    public function reset()
    {
        parent::reset();
        $this->_eventsList = array();
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#setOptions($options)
     */
    public function setOptions( Array $options )
    {
        $priority = isset( $options[self::OPT_PRIORITY] ) ? $options[self::OPT_PRIORITY] : null;
        $this->_treatPriorityOption( $priority );
        
        $useDefaultEventsList = isset( $options[self::OPT_USE_DEFAULT_EVENTS_LIST] ) ? $options[self::OPT_USE_DEFAULT_EVENTS_LIST] : null;
        $this->_treatUseDefaultEventsListOption( $useDefaultEventsList );
        
        $enableRelaySessions = isset( $options[self::OPT_ENABLE_RELAY_SESSIONS] ) ? $options[self::OPT_ENABLE_RELAY_SESSIONS] : null;
        $this->_treatEnableRelaySessions( $enableRelaySessions );
    }
    
    /**
     * Start relaying
     *
     * @return boolean
     */
    public function start()
    {
        if ( !$this->_ensureAliveCallLegs() ) {
            return false;
        }
        
        if ( !$this->_ensureCorrectState( self::STATE_READY ) ) {
            return false;
        }
        
        if ( !$this->_ensureValidEventsList() ) {
            return false;
        }
        
        $this->_subscribeToEngineEvents();
        $this->_stateManager->setState( self::STATE_RUNNING );
        
        return true;
    }
    
    /**
     * Stop relaying
     *
     * @return boolean
     */
    public function stop()
    {
        if ( !$this->_ensureCorrectState( self::STATE_RUNNING ) ) {
            return false;
        }
        
        $this->_unsubscribeFromEngineEvents();
        $this->_stateManager->setState( self::STATE_READY );
        
        return true;
    }
    
    /**
     * Is the relayer running?
     *
     * @return boolean
     */
    public function isRunning()
    {
        return ( $this->_stateManager->getState() === self::STATE_RUNNING );
    }
    
    /**
     * Is the relayer ready to be run?
     *
     * @return boolean
     */
    public function isReady()
    {
        return ( $this->_stateManager->getState() === self::STATE_READY );
    }
    
    /**
     * Does the relayer has a relay session started
     *
     * @return boolean
     */
    public function isRelaySessionStarted()
    {
        if ( $this->_options[self::OPT_ENABLE_RELAY_SESSIONS] === false ) {
            return false;
        }
        
        return $this->_isRelaySessionStarted;
    }
    
    /**
     * Retrieve the default events list
     *
     * @return array
     */
    public function getDefaultEventsList()
    {
        return self::$_defaultEventsList;
    }
    
    /**
     * Set the events list
     *
     * @param array $eventsList
     * @return void
     */
    public function setEventsList( Array $eventsList )
    {
        $this->_eventsList = $this->_normalizeEventsList( $eventsList );
    }
    
    /**
     * Retrieve the events list
     *
     * @return array
     */
    public function getEventsList()
    {
        return $this->_eventsList;
    }
    
    /**
     * Set the left call leg
     *
     * @param Streamwide_Engine_Call_Leg_Abstract $leftCallLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setLeftCallLeg( Streamwide_Engine_Call_Leg_Abstract $leftCallLeg )
    {
        if ( !$leftCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be an alive call leg' );
        }
        
        $this->_leftCallLeg = $leftCallLeg;
    }
    
    /**
     * Retrieve the left call leg
     *
     * @return Streamwide_Engine_Call_Leg_Abstract|null
     */
    public function getLeftCallLeg()
    {
        return $this->_leftCallLeg;
    }
    
    /**
     * Set the right call leg
     *
     * @param Streamwide_Engine_Call_Leg_Abstract $rightCallLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setRightCallLeg( Streamwide_Engine_Call_Leg_Abstract $rightCallLeg )
    {
        if ( !$rightCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be an alive call leg' );
        }
        
        $this->_rightCallLeg = $rightCallLeg;
    }
    
    /**
     * Retrieve the right call leg
     *
     * @return Streamwide_Engine_Call_Leg_Abstract|null
     */
    public function getRightCallLeg()
    {
        return $this->_rightCallLeg;
    }
    
    /**
     * Set the parameters for the relay session
     *
     * @param array $relaySessionParams
     * @return void
     */
    public function setRelaySessionParams( Array $relaySessionParams )
    {
        $this->_relaySessionParams = $relaySessionParams;
    }
    
    /**
     * Retrieve the relay session parameters
     *
     * @return array
     */
    public function getRelaySessionParams()
    {
        return $this->_relaySessionParams;
    }
    
    /**
     * @return void
     */
    public function toggleRelaySessionSupport()
    {
        $this->_options[self::OPT_ENABLE_RELAY_SESSIONS] = !$this->_options[self::OPT_ENABLE_RELAY_SESSIONS];
    }
    
    /**
     * Are the relay sessions enabled?
     *
     * @return boolean
     */
    public function isRelaySessionsSupportEnabled()
    {
        return $this->_options[self::OPT_ENABLE_RELAY_SESSIONS];
    }
    
    /**
     * Treat an event by relaying the received signal
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     * @throws RuntimeException
     */
    public function onSignalReceived( Streamwide_Engine_Events_Event $event )
    {
        $signal = $event->getParam( 'signal' );
        if ( null === $signal ) {
            return null;
        }
        
        // update call leg flags
        $this->_updateCallLegFlags( $signal->getName() );
        
        // check to see if any of the call legs involved
        // in the relaying process has died
        if ( $this->_isCallLegDead ) {
            return $this->_handleCallLegDeath( $signal->getRemote() );
        }
        
        // relay the signal
        if ( false === $this->_relaySignal( $signal ) ) {
            return null;
        }

        // update the call leg parameters
        $this->_updateCallLegParams( $signal->getRemote(), $signal->getParams() );
        
        // deal with relay session
        $this->_startOrEndRelaySession( $event );
        
        // dispatch the SIGNAL_RELAYED event
        $signalRelayedEvt = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::SIGNAL_RELAYED );
        $params = array(
            'signal' => $signal,
            'from' => $this->_relayFlow === self::LEFT_TO_RIGHT_RELAY
                ? $this->_leftCallLeg
                : $this->_rightCallLeg,
            'to' => $this->_relayFlow === self::RIGHT_TO_LEFT_RELAY
                ? $this->_leftCallLeg
                : $this->_rightCallLeg
        );
        $signalRelayedEvt->setParams( $params );
        
        return $this->dispatchEvent( $signalRelayedEvt );
    }
    
    /**
     * Relay a signal from one call leg to another
     *
     * @param Streamwide_Engine_Signal $signal
     * @return boolean
     * @throws RuntimeException
     */
    protected function _relaySignal( Streamwide_Engine_Signal $signal )
    {
        $remote = $signal->getRemote();
        
        if ( $signal->hasBeenRelayed() ) {
            $errorMessageTpl = $this->_errors[self::SIGNAL_RELAY_ERR_CODE];
            $callLegName = ( $remote === $this->_leftCallLeg->getName()
                ? $this->_rightCallLeg->getName()
                : $this->_leftCallLeg->getName()
            );
            
            $this->_errors[self::SIGNAL_RELAY_ERR_CODE] = sprintf( $errorMessageTpl, $signal->getName(), $callLegName );
            
            $this->dispatchErrorEvent( self::SIGNAL_RELAY_ERR_CODE );
            
            return false;
        }
        
        $callLegName = null;
        if ( $remote === $this->_leftCallLeg->getName() ) {
            $this->_relayFlow = self::LEFT_TO_RIGHT_RELAY;
            $callLegName = $this->_rightCallLeg->getName();
        } elseif ( $remote === $this->_rightCallLeg->getName() ) {
            $this->_relayFlow = self::RIGHT_TO_LEFT_RELAY;
            $callLegName = $this->_leftCallLeg->getName();
        }
        // this should not happen (but it doesn't hurt to check)
        if ( null === $callLegName ) {
            throw new RuntimeException( sprintf( 'Invalid remote name found in %s signal', $signal->getName() ) );
        }
        
        $preRelayCallback = $this->_retrievePreRelayCallback( $signal );
        if ( null !== $preRelayCallback ) {
            $signal = call_user_func_array( $preRelayCallback, array( $signal ) );
        }
        
        if ( false === $signal->relay( $callLegName ) ) {
            $errorMessageTpl = $this->_errors[self::SIGNAL_RELAY_ERR_CODE];
            $this->_errors[self::SIGNAL_RELAY_ERR_CODE] = sprintf( $errorMessageTpl, $signal->getName(), $callLegName );
            
            $this->dispatchErrorEvent( self::SIGNAL_RELAY_ERR_CODE );
            
            return false;
        }
        
        return true;
    }
    
    /**
     * Retrieves the prerelay callback for a signal
     *
     * @param Streamwide_Engine_Signal $signal
     * @return string|array|void
     */
    protected function _retrievePreRelayCallback( Streamwide_Engine_Signal $signal )
    {
        for ( $i = 0, $n = count( $this->_eventsList ); $i < $n; $i++ ) {
            $event = $this->_eventsList[$i];
            
            if ( $event['name'] === $signal->getName() ) {
                return $event['callback'];
            }
        }
    }
    
    /**
     * Decides whether or not to start or end a relay session
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    protected function _startOrEndRelaySession( Streamwide_Engine_Events_Event $event )
    {
        if ( !$this->isRelaySessionsSupportEnabled() ) {
            return null;
        }
        
        if ( false === $this->_isRelaySessionStarted ) {
            $this->_startRelaySession( $event );
        } else {
            $this->_endRelaySession( $event );
        }
    }
    
    /**
     * Checks to see if a relay session can be started by searching the received
     * signal name in the _relaySessionParams['sessionStarterSignals'] array.
     * If found a relay session is started, if not nothing happens.
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    protected function _startRelaySession( Streamwide_Engine_Events_Event $event )
    {
        if ( $this->_isRelaySessionStarterEvent( $event->getEventType() ) ) {
            $this->_isRelaySessionStarted = true;
            
            $relaySessionStartedEvt = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::RELAY_SESSION_STARTED );
            $relaySessionStartedEvt->setParam( 'signal', $event->getParam( 'signal' ) );
            return $this->dispatchEvent( $relaySessionStartedEvt );
        }
    }
    
    /**
     * Checks to see if a relay session can be ended by searching the received
     * event type in the relay session parameters array.
     * If found the relay session is ended, if not nothing happens.
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    protected function _endRelaySession( Streamwide_Engine_Events_Event $event )
    {
        if ( $this->_isRelaySessionEndingEvent( $event->getEventType() ) ) {
            $this->_isRelaySessionStarted = false;
            
            $relaySessionEndedEvt = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::RELAY_SESSION_ENDED );
            $relaySessionEndedEvt->setParam( 'signal', $event->getParam( 'signal' ) );
            
            return $this->dispatchEvent( $relaySessionEndedEvt );
        }
    }
    
    /**
     * Determine if the event should start a relay session
     *
     * @param string $eventType
     * @return boolean
     */
    protected function _isRelaySessionStarterEvent( $eventType )
    {
        if ( !isset( $this->_relaySessionParams[self::RS_PARAM_STARTER_EVENTS] ) ) {
            return false;
        }
        
        $relaySessionStarterEvents = $this->_relaySessionParams[self::RS_PARAM_STARTER_EVENTS];
        if ( !is_array( $relaySessionStarterEvents ) ) {
            $relaySessionStarterEvents = array( $relaySessionStarterEvents );
        }
        
        return in_array( $eventType, $relaySessionStarterEvents );
    }
    
    /**
     * Determine if the event should stop a relay session
     *
     * @param string $eventType
     * @return boolean
     */
    protected function _isRelaySessionEndingEvent( $eventType )
    {
        if ( !isset( $this->_relaySessionParams[self::RS_PARAM_ENDING_EVENTS] ) ) {
            return false;
        }
        
        $relaySessionEndingEvents = $this->_relaySessionParams[self::RS_PARAM_ENDING_EVENTS];
        if ( !is_array( $relaySessionEndingEvents ) ) {
            $relaySessionEndingEvents = array( $relaySessionEndingEvents );
        }
        
        return in_array( $eventType, $relaySessionEndingEvents );
    }
    
    /**
     * Handle the death of a call leg (receiving CHILD)
     *
     * @param string $callLegName The name of the call leg who died
     * @return void
     */
    protected function _handleCallLegDeath( $callLegName )
    {
        $this->_unsubscribeFromEngineEvents();
        $callLeg = ( $callLegName === $this->_leftCallLeg ? $this->_leftCallLeg : $this->_rightCallLeg );
        $callLeg->setDead();
        
        return $this->dispatchErrorEvent(
            self::CALL_LEG_DIED_ERR_CODE,
            array( 'callLeg' => $callLeg )
        );
    }
    
    /**
     * Update the call leg flags
     *
     * @param string $signalName
     * @return void
     */
    protected function _updateCallLegFlags( $signalName )
    {
        switch ( $signalName ) {
            case Streamwide_Engine_Signal::OKMOVED:
                $this->_isCallLegUpdated = true;
            break;
            case Streamwide_Engine_Signal::CHILD:
                $this->_isCallLegDead = true;
            break;
        }
    }
    
    /**
     * If an OKMOVED has been received we need to update the call leg's parameters
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _updateCallLegParams( $callLegName, $newParams )
    {
        if ( false === $this->_isCallLegUpdated ) {
            return null;
        }
        
        $callLeg = ( $callLegName === $this->_leftCallLeg
            ? $this->_leftCallLeg
            : $this->_rightCallLeg
        );
        $callLeg->setParams( $newParams );
        // reset the updated flag
        $this->_isCallLegUpdated = false;
    }
    
    /**
     * Convert events to the accepted internal format
     *
     * @param array $eventsList
     * @return array
     */
    protected function _normalizeEventsList( Array $eventsList )
    {
        if ( empty( $eventsList ) ) {
            return $eventsList;
        }
        
        $childEventHandled = false;
        
        for ( $i = 0, $n = count( $eventsList ); $i < $n; $i++ ) {
            $event = $eventsList[$i];
            
            if ( is_array( $event ) ) {
                // check for the presence of the "name" key
                if ( !array_key_exists( 'name', $event ) ) {
                    trigger_error( 'Name of the event not provided. Removing from list' );
                    unset( $eventsList[$i] );
                    continue;
                }
                
                // check for "source" key and set it to the default value
                // if it doesn't exist
                if ( !array_key_exists( 'source', $event ) ) {
                    $event['source'] = self::SIG_SRC_BOTH;
                }
                
                // check for the "priority" key and set it to the default value
                // if it doesn't exist
                if ( !array_key_exists( 'priority', $event ) ) {
                    $event['priority'] = $this->_options[self::OPT_PRIORITY];
                }
                
                // check for the "callback" key and set it to the default value
                // if it doesn't exist
                if ( !array_key_exists( 'callback', $event ) ) {
                    $event['callback'] = null;
                }
            }
            else {
                $event = array(
                    'name' => $event,
                    'source' => self::SIG_SRC_BOTH,
                    'priority' => $this->_options[self::OPT_PRIORITY],
                    'callback' => null
                );
            }
            
            // check if CHILD event is already handled
            if ( $event['name'] === Streamwide_Engine_Events_Event::CHILD ) {
                $childEventHandled = true;
            }
            
            $eventsList[$i] = $event;
        }
        
        if ( !$childEventHandled && !empty( $eventsList ) ) {
            $eventsList[] = array(
                'name' => Streamwide_Engine_Events_Event::CHILD,
                'source' => self::SIG_SRC_BOTH,
                'priority' => $this->_options[self::OPT_PRIORITY],
                'callback' => null
            );
        }
        
        return array_values( $eventsList );
    }
    
    /**
     * Create the list of engine event listeners
     *
     * @param array $eventsList
     * @return array
     */
    protected function _createEngineEventListenersList( Array $eventsList ) {
        $list = array();
        
        for ( $i = 0, $n = count( $eventsList ); $i < $n; $i++ ) {
            $event = $eventsList[$i];
            
            $eventName = $event['name'];
            $allowedSignalSource = $event['source'];
            $listenerPriority = $event['priority'];
            
            $notifyFilterFactoryName = Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE;
            switch ( $allowedSignalSource ) {
                case self::SIG_SRC_LEFT:
                    $notifyFilterType = Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO;
                    $notifyFilterParams = $this->_leftCallLeg->getName();
                break;
                case self::SIG_SRC_RIGHT:
                    $notifyFilterType = Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO;
                    $notifyFilterParams = $this->_rightCallLeg->getName();
                break;
                default:
                    $notifyFilterType = Streamwide_Engine_NotifyFilter_Factory::FILTER_IN_ARRAY;
                    $notifyFilterParams = array(
                        array( $this->_leftCallLeg->getName(), $this->_rightCallLeg->getName() )
                    );
                break;
            }

            $notifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
                $notifyFilterFactoryName,
                $notifyFilterType,
                $notifyFilterParams
            );
            
            $list[$eventName] = array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'notifyFilter' => $notifyFilter,
                    'priority' => $listenerPriority
                )
            );
        }
        
        return $list;
    }
    
    /**
     * Make sure that both of the call legs involved in the relaying process
     * are alive
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
     * Make sure that the widget is in a correct state
     *
     * @param string $state
     * @return boolean
     */
    protected function _ensureCorrectState( $state )
    {
        $isCorrectState = false;
        $errorCode = null;
        
        switch ( $state ) {
            case self::STATE_READY:
                $isCorrectState = $this->isReady();
                $errorCode = self::ALREADY_RUNNING_ERR_CODE;
            break;
            case self::STATE_RUNNING:
                $isCorrectState = $this->isRunning();
                $errorCode = self::NOT_RUNNING_ERR_CODE;
            break;
        }
        
        if ( !$isCorrectState ) {
            $this->dispatchErrorEvent( $errorCode );
        }
        
        return $isCorrectState;
    }
    
    /**
     * Make sure we have a valid events list
     *
     * @return boolean
     */
    protected function _ensureValidEventsList()
    {
        if ( empty( $this->_eventsList ) ) {
            $useDefaultEventsList = $this->_options[self::OPT_USE_DEFAULT_EVENTS_LIST];
            if ( !$useDefaultEventsList ) {
                $this->dispatchErrorEvent( self::EMPTY_EVENTS_LIST_ERR_CODE );
                return false;
            }
            
            $this->_eventsList = self::$_defaultEventsList;
        }
        
        return true;
    }
    
    /**
     * Initialize options default values
     *
     * @return void
     */
    protected function _initDefaultOptions()
    {
        $this->_options[self::OPT_PRIORITY] = self::DEFAULT_PRIORITY;
        $this->_options[self::OPT_USE_DEFAULT_EVENTS_LIST] = self::USE_DEFAULT_EVENTS_LIST_DEFAULT;
        $this->_options[self::OPT_ENABLE_RELAY_SESSIONS] = self::ENABLE_RELAY_SESSIONS_DEFAULT;
    }
    
    /**
     * Subscribe to all the events in the provided list
     *
     * @return void
     */
    protected function _subscribeToEngineEvents()
    {
        $engineListeners = $this->_createEngineEventListenersList( $this->_eventsList );
        
        $controller = $this->getController();
        foreach ( $engineListeners as $eventName => $listener ) {
            $controller->addEventListener( $eventName, $listener );
        }
    }
    
    /**
     * Unsubscribe from all the events in the provided list
     *
     * @return void
     */
    protected function _unsubscribeFromEngineEvents()
    {
        if ( empty( $this->_eventsList ) ) {
            return null;
        }
        
        $callback = array( 'callback' => array( $this, 'onSignalReceived' ) );
        
        $controller = $this->getController();
        foreach ( $this->_eventsList as $event ) {
            $controller->removeEventListener( $event['name'], $callback );
        }
    }
    
    /**
     * Treat the "priority" option
     *
     * @param mixed $priority
     * @return void
     */
    protected function _treatPriorityOption( $priority = null )
    {
        if ( null === $priority ) {
            return null;
        }
            
        if ( is_float( $priority ) || ( is_string( $priority ) && preg_match( '~^[1-9][0-9]*$~', $priority ) === 1 ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to integer', self::OPT_PRIORITY ) );
            $priority = (int)$priority;
        }

        if ( is_int( $priority ) ) {
            $this->_options[self::OPT_PRIORITY] = $priority;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_PRIORITY ) );
        }
    }
    
    /**
     * Treat the "use default events list" option
     *
     * @param mixed $useDefaultEventsList
     * @return void
     */
    protected function _treatUseDefaultEventsListOption( $useDefaultEventsList = null )
    {
        if ( null === $useDefaultEventsList ) {
            return null;
        }
        
        if ( is_int( $useDefaultEventsList ) || is_string( $useDefaultEventsList ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to boolean', self::OPT_USE_DEFAULT_EVENTS_LIST ) );
            $useDefaultEventsList = (bool)$useDefaultEventsList;
        }
        
        if ( is_bool( $useDefaultEventsList ) ) {
            $this->_options[self::OPT_USE_DEFAULT_EVENTS_LIST] = $useDefaultEventsList;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_USE_DEFAULT_EVENTS_LIST ) );
        }
    }
    
    /**
     * Treat the "enable relay sessions" option
     *
     * @param mixed $enableRelaySessions
     * @return unknown_type
     */
    protected function _treatEnableRelaySessions( $enableRelaySessions = null )
    {
        if ( null === $enableRelaySessions ) {
            return null;
        }
        
        if ( is_int( $enableRelaySessions ) || is_string( $enableRelaySessions ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to boolean', self::OPT_ENABLE_RELAY_SESSIONS ) );
            $enableRelaySessions = (bool)$enableRelaySessions;
        }
        
        if ( is_bool( $enableRelaySessions ) ) {
            $this->_options[self::OPT_ENABLE_RELAY_SESSIONS] = $enableRelaySessions;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_ENABLE_RELAY_SESSIONS ) );
        }
    }
    
}


/* EOF */
