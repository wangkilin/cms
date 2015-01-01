<?php
/**
 *
 * $Rev: 2135 $
 * $LastChangedDate: 2009-11-23 17:53:15 +0800 (Mon, 23 Nov 2009) $
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
 * Provides notification to listeners when a key is pressed on the dial pad
 */
class Streamwide_Engine_Dtmf_Handler extends Streamwide_Engine_Widget
{

    /**
     * States for this object
     */
    const STATE_READY = 'READY';
    const STATE_LISTENING = 'LISTENING';

    /**
     * Option names
     */
    const OPT_ALLOWED_DTMFS = 'allowed_dtmfs';
    const OPT_ALLOWED_DTMF_SOURCES = 'allowed_dtmf_sources';
    const OPT_SIGNAL_WRONG_KEY = 'signal_wrong_key';
    const OPT_RECEIVED_DTMFS_LIMIT = 'received_dtmfs_limit';
    const OPT_STOP_LISTENING_ON_KEY = 'stop_listening_on_key';
    const OPT_STOP_LISTENING_ON_WRONG_KEY = 'stop_listening_on_wrong_key';
    
    /**
     * Default option values
     */
    const SIGNAL_WRONG_KEY_DEFAULT = false;
    const DEFAULT_RECEIVED_DTMFS_LIMIT = 0;
    const STOP_LISTENING_ON_KEY_DEFAULT = false;
    const STOP_LISTENING_ON_WRONG_KEY_DEFAULT = false;

    /**
     * Possible keys on the dial pad of a phone
     */
    const KEY_0 = '0';
    const KEY_1 = '1';
    const KEY_2 = '2';
    const KEY_3 = '3';
    const KEY_4 = '4';
    const KEY_5 = '5';
    const KEY_6 = '6';
    const KEY_7 = '7';
    const KEY_8 = '8';
    const KEY_9 = '9';
    const KEY_A = 'A';
    const KEY_B = 'B';
    const KEY_C = 'C';
    const KEY_D = 'D';
    const KEY_POUND = '#';
    const KEY_STAR = '*';

    /**
     * Error codes constants
     *
     * DTMFHANDLER-3xx error codes refer to state errors
     */
    const ALREADY_LISTENING_ERR_CODE = 'DTMFHANDLER-300';
    const NOT_LISTENING_ERR_CODE = 'DTMFHANDLER-301';

    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::ERROR,
        Streamwide_Engine_Events_Event::KEY,
        Streamwide_Engine_Events_Event::UNEXPECTED_KEY,
        Streamwide_Engine_Events_Event::LISTENING,
        Streamwide_Engine_Events_Event::STOPPED_LISTENING
    );
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::ALREADY_LISTENING_ERR_CODE => 'Already listening',
        self::NOT_LISTENING_ERR_CODE => 'Not listening'
    );

    /**
     * A list with all keys on a dial pad of a phone
     *
     * @var array
     */
    protected static $_allDtmfs = array(
        self::KEY_0, self::KEY_1,
        self::KEY_2, self::KEY_3,
        self::KEY_4, self::KEY_5,
        self::KEY_6, self::KEY_7,
        self::KEY_8, self::KEY_9,
        self::KEY_A, self::KEY_B,
        self::KEY_C, self::KEY_D,
        self::KEY_POUND, self::KEY_STAR
    );

    /**
     * Keeps a list with all received dtmfs
     *
     * @var array
     */
    protected $_receivedDtmfs = array();

    /**
     * Keeps a list with handled dtmfs
     *
     * @var array
     */
    protected $_handledDtmfs = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setStateManager(
            new Streamwide_Engine_Widget_State_Manager(
                array(
                    self::STATE_READY,
                    self::STATE_LISTENING
                )
            )
        );
        $this->_initDefaultOptions();
    }

    /**
     * Provides default values for all options supported by this widget (helps avoid spreading of
     * complex logic throughout the class)
     *
     * @param array $options
     * @return void
     */
    public function setOptions( Array $options )
    {
        $allowedDtmfs = isset( $options[self::OPT_ALLOWED_DTMFS] ) ? $options[self::OPT_ALLOWED_DTMFS] : null;
        $this->_treatAllowedDtmfsOption( $allowedDtmfs );

        $allowedDtmfSources = isset( $options[self::OPT_ALLOWED_DTMF_SOURCES] ) ? $options[self::OPT_ALLOWED_DTMF_SOURCES] : null;
        $this->_treatAllowedDtmfSourcesOption( $allowedDtmfSources );

        $signalWrongKey = isset( $options[self::OPT_SIGNAL_WRONG_KEY] ) ? $options[self::OPT_SIGNAL_WRONG_KEY] : null;
        $this->_treatSignalWrongKeyOption( $signalWrongKey );

        $receivedDtmfsLimit = isset( $options[self::OPT_RECEIVED_DTMFS_LIMIT] ) ? $options[self::OPT_RECEIVED_DTMFS_LIMIT] : null;
        $this->_treatReceivedDtmfsLimitOption( $receivedDtmfsLimit );

        $stopListeningOnKey = isset( $options[self::OPT_STOP_LISTENING_ON_KEY] ) ? $options[self::OPT_STOP_LISTENING_ON_KEY] : null;
        $this->_treatStopListeningOnKeyOption( $stopListeningOnKey );
        
        $stopListeningOnWrongKey = isset( $options[self::OPT_STOP_LISTENING_ON_WRONG_KEY] ) ? $options[self::OPT_STOP_LISTENING_ON_WRONG_KEY] : null;
        $this->_treatStopListeningOnWrongKeyOption( $stopListeningOnWrongKey );
    }

    /**
     * Retrieve the list with all dtmfs on the dial pad of a phone
     *
     * @return array
     */
    public function getAllDtmfs()
    {
        return self::getAllDtmfsList();
    }

    /**
     * Retrieve the list with all dtmfs on the dial pad of a phone (static)
     *
     * @return array
     */
    public static function getAllDtmfsList()
    {
        return self::$_allDtmfs;
    }

    /**
     * Return a count of received dtmfs
     *
     * @return integer
     */
    public function getReceivedDtmfsCount()
    {
        return count( $this->_receivedDtmfs );
    }

    /**
     * Retrieve a count of handled dtmfs
     *
     * @return integer
     */
    public function getHandledDtmfsCount()
    {
        return ( count( $this->_handledDtmfs ) );
    }

    /**
     * Retrieve a list with received dtmfs
     *
     * @return array
     */
    public function getReceivedDtmfs()
    {
        return $this->_receivedDtmfs;
    }

    /**
     * Retrieve a list with handled dtmfs
     *
     * @return array
     */
    public function getHandledDtmfs()
    {
        return $this->_handledDtmfs;
    }

    /**
     * Retrieves the list with received keys that were "unexpected" or "wrong"
     *
     * @return array
     */
    public function getReceivedWrongKeys()
    {
        return array_diff( $this->_receivedDtmfs, $this->_handledDtmfs );
    }

    /**
     * Get the last received dtmf
     *
     * @return string|null
     */
    public function getLastReceivedDtmf()
    {
        $index = $this->getReceivedDtmfsCount();
        if ( $index <= 0 ) {
            return null;
        }
        return $this->_receivedDtmfs[--$index];
    }

    /**
     * Retrieve the last handled DTMF value
     *
     * @return string|null
     */
    public function getLastHandledDtmf()
    {
        $index = $this->getHandledDtmfsCount();
        if ( $index <= 0 ) {
            return null;
        }
        return $this->_handledDtmfs[--$index];

    }

    /**
     * Is the handler ready?
     *
     * @return boolean
     */
    public function isReady()
    {
        return ( $this->_stateManager->getState() === self::STATE_READY );
    }
    
    /**
     * Is the handler listening?
     *
     * @return boolean
     */
    public function isListening()
    {
        return ( $this->_stateManager->getState() === self::STATE_LISTENING );
    }

    /**
     * Starts listening for SIGNAL_IN_DTMF events
     *
     * @param array|null $options
     * @return boolean
     */
    public function startListening()
    {
        // dispatch an ERROR event if the widget is already listening
        if ( $this->isListening() ) {
            $this->dispatchErrorEvent( self::ALREADY_LISTENING_ERR_CODE );
            return false;
        }

        // subscribe to the SIGNAL_IN_DTMF event
        $this->_subscribeToEngineEvents();

        // mark the widget as LISTENING
        $this->_stateManager->setState( self::STATE_LISTENING );
        // dispatch a DTMF_HANDLER_LISTENING event
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::LISTENING ) );
        return true;
    }

    /**
     * Interrupts the listening process
     *
     * @return boolean
     */
    public function stopListening()
    {
        // dispatch an ERROR event if the widget is not listening
        if ( !$this->isListening() ) {
            $this->dispatchErrorEvent( self::NOT_LISTENING_ERR_CODE );
            return false;
        }

        // unsubscribe from the SIGNAL_IN_DTMF event
        $this->_unsubscribeFromEngineEvents();

        // mark the handler as READY
        $this->_stateManager->setState( self::STATE_READY );

        // dispatch an DTMF_HANDLER_STOPPED event
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::STOPPED_LISTENING ) );
        return true;
    }

    /**
     * Resets the handler
     *
     * @return void
     */
    public function reset()
    {
        parent::reset();
        
        if ( $this->isListening() ) {
            $this->stopListening();
        }
        
        $this->_receivedDtmfs = array();
        $this->_handledDtmfs = array();
    }

    /**
     * Handle a DTMF signal
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onDtmf( Streamwide_Engine_Events_Event $event )
    {
        // if the handler is not in the listening state we should not treat the event
        if ( !$this->isListening() ) {
            return null;
        }
        
        // extract the source of the DTMF signal
        $signal = $event->getParam( 'signal' );
        $remote = $signal->getRemote();
        
        // check to see if we have an allowed source
        if ( !$this->_isAllowedDtmfSource( $remote ) ) {
            return null;
        }
        
        // extract the DTMF value
        $params = $signal->getParams();
        $dtmf = $params['dtmf'];
        
        // add the received dtmf to the received dtmfs list
        $this->_receivedDtmfs[] = $dtmf;
        // check if the limit is reached
        if ( $this->_isLimitReached() ) {
            $this->stopListening();
        }
        
        // if the dtmf is "treatable" add it to the handled dtmfs list and dispatch
        // a KEY event
        if ( $this->_isAllowedDtmf( $dtmf ) ) {
            $this->_handledDtmfs[] = $dtmf;
            if ( $this->_canDtmfStopListeningProcess( $dtmf ) ) {
                $this->stopListening();
            }
            $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::KEY );
            $event->setParam( 'receivedKey', $dtmf );
            $event->setParam( 'source', $remote );
            $event->setParam( 'signal', $signal );
            $this->dispatchEvent( $event );
        } else {
            if ( $this->_canDtmfStopListeningProcess( $dtmf, false ) ) {
                $this->stopListening();
            }
            if ( $this->_shouldSignalWrongKey() ) {
                // if the handler is set to signal unexpected keys, dispatch an DTMF_HANDLER_UNEXPECTED_KEY event
                $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::UNEXPECTED_KEY );
                $event->setParam( 'receivedKey', $dtmf );
                $event->setParam( 'source', $remote );
                $event->setParam( 'signal', $signal );
                $this->dispatchEvent( $event );
            }
        }
    }

    /**
     * Is the received dtmfs limit reached?
     *
     * @return boolean
     */
    protected function _isLimitReached()
    {
        $receivedDtmfsLimit = $this->_options[self::OPT_RECEIVED_DTMFS_LIMIT];
        return ( $receivedDtmfsLimit > 0 && $receivedDtmfsLimit === $this->getReceivedDtmfsCount() );
    }

    /**
     * Is the dtmf in the allowed dtmfs list?
     *
     * @param string $dtmf
     * @return boolean
     */
    protected function _isAllowedDtmf( $dtmf )
    {
        $allowedDtmfs = $this->_options[self::OPT_ALLOWED_DTMFS];
        return in_array( $dtmf, $allowedDtmfs, true );
    }

    /**
     * Is the dtmf source in the allowed dtmf sources list?
     *
     * @param string $source
     * @return boolean
     */
    protected function _isAllowedDtmfSource( $source )
    {
        $allowedDtmfSources = $this->_options[self::OPT_ALLOWED_DTMF_SOURCES];
        if ( empty( $allowedDtmfSources ) ) {
            return true;
        }
        
        return in_array( $source, $allowedDtmfSources, true );
    }
    
    /**
     * Should we signal that we received an unexpected key?
     *
     * @return boolean
     */
    protected function _shouldSignalWrongKey()
    {
        return $this->_options[self::OPT_SIGNAL_WRONG_KEY];
    }

    /**
     * Can the received dtmf stop the listening process?
     *
     * @param string $dtmf
     * @param boolean $isValid
     * @return boolean
     */
    protected function _canDtmfStopListeningProcess( $dtmf, $isValid = true )
    {
        $opt = $this->_options[self::OPT_STOP_LISTENING_ON_KEY];
        if ( !$isValid ) {
            $opt = $this->_options[self::OPT_STOP_LISTENING_ON_WRONG_KEY];
        }
        
        if ( is_array( $opt ) ) {
            return in_array( $dtmf, $opt );
        }
        // if $opt is not an array it should be a boolean
        return $opt;
    }

    /**
     * Subscribe to DTMF signal from SW Engine
     *
     * @see Engine/Streamwide_Engine_Widget#_subscribeToEngineEvents()
     */
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        
        $dtmfNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_IN_ARRAY,
            array( $this->_options[self::OPT_ALLOWED_DTMF_SOURCES], true )
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::DTMF,
            array(
                'callback' => array( $this, 'onDtmf' ),
                'options' => array( 'notifyFilter' => $dtmfNotifyFilter )
            )
        );
    }
    
    /**
     * Unsubscribe from DTMF signal from SW Engine
     *
     * @see Engine/Streamwide_Engine_Widget#_unsubscribeFromEngineEvents()
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $controller = $this->getController();
        $controller->removeEventListener(
            Streamwide_Engine_Events_Event::DTMF,
            array( 'callback' => array( $this, 'onDtmf' ) )
        );
    }
    
    /**
     * Treats the "allowed dtmfs" option
     *
     * @param mixed $allowedDtmfs
     * @return void
     */
    protected function _treatAllowedDtmfsOption( $allowedDtmfs = null )
    {
        if ( null === $allowedDtmfs ) {
            // exit and use the default value
            return null;
        }

        if ( is_string( $allowedDtmfs ) && strlen( $allowedDtmfs ) === 1 ) {
            $allowedDtmfs = array( $allowedDtmfs );
        }
        
        if ( is_int( $allowedDtmfs ) && $allowedDtmfs >= 0 && $allowedDtmfs <= 9 ) {
            $allowedDtmfs = array( (string)$allowedDtmfs );
        }

        if ( !is_array( $allowedDtmfs ) ) {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_ALLOWED_DTMFS ) );
        } else {
            if ( empty( $allowedDtmfs ) ) {
                // leave the option of listening to nothing
            	$this->_options[self::OPT_ALLOWED_DTMFS] = array();
                return null;
            }
            // keep only valid values
            $allowedDtmfs = array_map( 'strval', $allowedDtmfs );
            $allowedDtmfs = array_intersect( $allowedDtmfs, self::$_allDtmfs );
            if ( !empty( $allowedDtmfs ) ) {
                $this->_options[self::OPT_ALLOWED_DTMFS] = $allowedDtmfs;
            } else {
                trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_ALLOWED_DTMFS ) );
            }
        }
    }

    /**
     * Treats the "allowed dtmf sources" option
     *
     * @param mixed $allowedDtmfSources
     * @return void
     */
    protected function _treatAllowedDtmfSourcesOption( $allowedDtmfSources = null )
    {
        if ( null === $allowedDtmfSources ) {
            // exit and use the default value
            return null;
        }

        if ( is_string( $allowedDtmfSources ) && strlen( trim( $allowedDtmfSources ) ) > 0 ) {
            $allowedDtmfSources = array( $allowedDtmfSources );
        }

        if ( is_array( $allowedDtmfSources ) ) {
            $this->_options[self::OPT_ALLOWED_DTMF_SOURCES] = $allowedDtmfSources;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_ALLOWED_DTMF_SOURCES ) );
        }
    }

    /**
     * Treats the "signal wrong key" option
     *
     * @param mixed $signalWrongKey
     * @return void
     */
    protected function _treatSignalWrongKeyOption( $signalWrongKey = null )
    {
        if ( null === $signalWrongKey ) {
            // exit and use the default value
            return null;
        }

        if ( is_int( $signalWrongKey ) || is_string( $signalWrongKey ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to boolean', self::OPT_SIGNAL_WRONG_KEY ) );
            $signalWrongKey = (bool)$signalWrongKey;
        }

        if ( is_bool( $signalWrongKey ) ) {
            $this->_options[self::OPT_SIGNAL_WRONG_KEY] = $signalWrongKey;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_SIGNAL_WRONG_KEY ) );
        }
    }

    /**
     * Treats the "received dtmfs limit" option
     *
     * @param mixed $dtmfsLimit
     * @return void
     */
    protected function _treatReceivedDtmfsLimitOption( $dtmfsLimit = null )
    {
        if ( null === $dtmfsLimit ) {
            return null;
        }

        if ( is_float( $dtmfsLimit ) || ( is_string( $dtmfsLimit ) && preg_match( '~^[1-9][0-9]*$~', $dtmfsLimit ) === 1 ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to integer', self::OPT_RECEIVED_DTMFS_LIMIT ) );
            $dtmfsLimit = (int)$dtmfsLimit;
        }

        if ( is_int( $dtmfsLimit ) && $dtmfsLimit >= 0 ) {
            $this->_options[self::OPT_RECEIVED_DTMFS_LIMIT] = $dtmfsLimit;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_RECEIVED_DTMFS_LIMIT ) );
        }
    }

    /**
     * Treats the "stop listening on key" option
     *
     * @param mixed $stopListeningOnKeyOption
     * @return void
     */
    protected function _treatStopListeningOnKeyOption( $stopListeningOnKey = null )
    {
        if ( null === $stopListeningOnKey ) {
            // exit and use the default value
            return null;
        }

        if ( is_array( $stopListeningOnKey ) ) {
            // no point in going further if the client code is messing with us
            if ( empty( $stopListeningOnKey ) ) {
                trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_STOP_LISTENING_ON_KEY ) );
                return null;
            }
            // take into account the possibility that the client of the dtmf handler
            // wants to listen to "nothing" in which case this option makes no sense
            // and will use the default value
            if ( empty( $this->_options[self::OPT_ALLOWED_DTMFS] ) ) {
                return null;
            }
            // must be a subset of "allowed dtmfs"
            $stopListeningOnKey = array_map( 'strval', $stopListeningOnKey );
            $stopListeningOnKey = array_intersect( $this->_options[self::OPT_ALLOWED_DTMFS], $stopListeningOnKey );
            if ( empty( $stopListeningOnKey ) ) {
                trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_STOP_LISTENING_ON_KEY ) );
                return null;
            }
            // set the option if we have at least one valid key inside the array
            $this->_options[self::OPT_STOP_LISTENING_ON_KEY] = array_values( $stopListeningOnKey );
            return null;
        }
        
        if ( is_int( $stopListeningOnKey ) || is_string( $stopListeningOnKey ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to boolean', self::OPT_STOP_LISTENING_ON_KEY ) );
            $stopListeningOnKey = (bool)$stopListeningOnKey;
        }
        
        if ( is_bool( $stopListeningOnKey ) ) {
            $this->_options[self::OPT_STOP_LISTENING_ON_KEY] = $stopListeningOnKey;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_STOP_LISTENING_ON_KEY ) );
        }
    }
    
    /**
     * Treats the "stop listening on wrong key" option
     *
     * @param mixed $stopListeningOnWrongKey
     * @return void
     */
    protected function _treatStopListeningOnWrongKeyOption( $stopListeningOnWrongKey = null )
    {
        if ( null === $stopListeningOnWrongKey ) {
            // exit and use the default value
            return null;
        }
        
        if ( is_array( $stopListeningOnWrongKey ) ) {
            // no point in going further if client code is messing with us
            if ( empty( $stopListeningOnWrongKey ) ) {
                trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_STOP_LISTENING_ON_WRONG_KEY ) );
                return null;
            }
            // take the unexpected keys list
            $unexpectedKeysList = array_diff( self::$_allDtmfs, $this->_options[self::OPT_ALLOWED_DTMFS] );
            // if we have no unexpected keys then default value of the option is fine
            if ( empty( $unexpectedKeysList ) ) {
                return null;
            }
            // must be a valid subset of the "unexpected keys" set
            $stopListeningOnWrongKey = array_intersect( $unexpectedKeysList, $stopListeningOnWrongKey );
            if ( empty( $stopListeningOnWrongKey ) ) {
                trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_STOP_LISTENING_ON_WRONG_KEY ) );
                return null;
            }
            // set the option if we have at least one valid value
            $this->_options[self::OPT_STOP_LISTENING_ON_WRONG_KEY] = $stopListeningOnWrongKey;
            return null;
        }
        
        if ( is_int( $stopListeningOnWrongKey ) || is_string( $stopListeningOnWrongKey ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to boolean', self::OPT_STOP_LISTENING_ON_WRONG_KEY ) );
            $stopListeningOnWrongKey = (bool)$stopListeningOnWrongKey;
        }
        
        if ( is_bool( $stopListeningOnWrongKey ) ) {
            $this->_options[self::OPT_STOP_LISTENING_ON_WRONG_KEY] = $stopListeningOnWrongKey;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_STOP_LISTENING_ON_WRONG_KEY ) );
        }
    }

    /**
     * Initialize the default options
     *
     * @return void
     */
    protected function _initDefaultOptions()
    {
        $this->_options[self::OPT_ALLOWED_DTMFS] = self::$_allDtmfs;
        $this->_options[self::OPT_ALLOWED_DTMF_SOURCES] = array();
        $this->_options[self::OPT_SIGNAL_WRONG_KEY] = self::SIGNAL_WRONG_KEY_DEFAULT;
        $this->_options[self::OPT_RECEIVED_DTMFS_LIMIT] = self::DEFAULT_RECEIVED_DTMFS_LIMIT;
        $this->_options[self::OPT_STOP_LISTENING_ON_KEY] = self::STOP_LISTENING_ON_KEY_DEFAULT;
        $this->_options[self::OPT_STOP_LISTENING_ON_WRONG_KEY] = self::STOP_LISTENING_ON_WRONG_KEY_DEFAULT;
    }

}

/* EOF */