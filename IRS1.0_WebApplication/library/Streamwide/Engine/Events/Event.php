<?php
/**
 *
 * $Rev: 2608 $
 * $LastChangedDate: 2010-05-18 10:01:35 +0800 (Tue, 18 May 2010) $
 * $LastChangedBy: kwu $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Event
 * @version 1.0
 *
 */

/**
 * An occurence (something that happened) in the system, and all (or at least some) of the details surrounding that occurence
 */
class Streamwide_Engine_Events_Event implements Streamwide_Event_Interface
{

    /**
     * Event types
     *
     * @var string
     */
    const ARMED = 'ARMED';
    const CALL_LEG_CREATED = 'CALL_LEG_CREATED';
    const CALL_LEG_ON_HOLD = 'CALL_LEG_ON_HOLD';
    const CHILD = 'CHILD';
    const CONNECTED = 'CONNECTED';
    const CREATE = 'CREATE';
    const DIAMETERMESSAGE = 'DIAMETERMESSAGE';
    const DISARMED = 'DISARMED';
    const DTMF = 'DTMF';
    const EARLY_MEDIA_AVAILABLE = 'EARLY_MEDIA_AVAILABLE';
    const EARLY_MEDIA_NEGOTIATED = 'EARLY_MEDIA_NEGOTIATED';
    const END = 'END';
    const ENDOFFAX = 'ENDOFFAX';
    const EOF = 'EOF';
    const ERROR = 'ERROR';
    const EVENT = 'EVENT';
    const FAIL = 'FAIL';
    const FAILMOVED = 'FAILMOVED';
    const FAILREGISTER = 'FAILREGISTER';
    const FAILSDP = 'FAILSDP';
    const FAILTRANSFER = 'FAILTRANSFER';
    const FAXPAGE = 'FAXPAGE';
    const FAX_PAGE_RECEIVED = 'FAX_PAGE_RECEIVED';
    const FAX_RECEIVED = 'FAX_RECEIVED';
    const FAX_RECEIVING_REQUESTED = 'FAX_RECEIVING_REQUESTED';
    const FAX_RECEIVING_STARTED = 'FAX_RECEIVING_STARTED';
    const FAX_SENDING_REQUESTED = 'FAX_SENDING_REQUESTED';
    const FAX_SENDING_STARTED = 'FAX_SENDING_STARTED';
    const FAX_SENT = 'FAX_SENT';
    const FAX_TONE_DETECTED = 'FAX_TONE_DETECTED';
    const FAX_TONE_DETECTION_STARTED = 'FAX_TONE_DETECTION_STARTED';
    const FAX_TONE_DETECTION_STOPPED = 'FAX_TONE_DETECTION_STOPPED';
    const FAX_TONE_NOT_DETECTED = 'FAX_TONE_NOT_DETECTED';
    const FINISHED = 'FINISHED';
    const INFO = 'INFO';
    const KEY = 'KEY';
    const LISTENING = 'LISTENING';
    const MOVED = 'MOVED';
    const NEW_DIRECTION = 'NEW_DIRECTION';
    const OK = 'OK';
    const OKMOVED = 'OKMOVED';
    const OKSDP = 'OKSDP';
    const OKTRANSFER = 'OKTRANSFER';
    const OPTION_CHOSEN = 'OPTION_CHOSEN';
    const PAUSED = 'PAUSED';
    const PLAYING = 'PLAYING';
    const PROGRESS = 'PROGRESS';
    const PROK = 'PROK';
    const PRSDP = 'PRSDP';
    const REARMED = 'REARMED';
    const RECORDING = 'RECORDING';
    const REGISTER = 'REGISTER';
    const RELAY_SESSION_STARTED = 'RELAY_SESSION_STARTED';
    const RELAY_SESSION_ENDED = 'RELAY_SESSION_ENDED';
    const RESUMED = 'RESUMED';
    const RING = 'RING';
    const RINGING = 'RINGING';
    const RUNNING = 'RUNNING';
    const SDP = 'SDP';
    const SIGNAL = 'SIGNAL';
    const SIGNAL_RELAYED = 'SIGNAL_RELAYED';
    const SILENCE_DETECTED = 'SILENCE_DETECTED';
    const SILENCE_DETECTION_STARTED = 'SILENCE_DETECTION_STARTED';
    const SILENCE_DETECTION_STOPPED = 'SILENCE_DETECTION_STOPPED';
    const SILENCE_NOT_DETECTED = 'SILENCE_NOT_DETECTED';
    const STEP = 'STEP';
    const STOPPED = 'STOPPED';
    const STOPPED_LISTENING = 'STOPPED_LISTENING';
    const SUBSCRIBE = 'SUBSCRIBE';
    const SUCCESS = 'SUCCESS';
    const TIMEOUT = 'TIMEOUT';
    const TRANSFER = 'TRANSFER';
    const TRANSFERRED = 'TRANSFERRED';
    const TRANSFER_FORWARDED = 'TRANSFER_FORWARDED';
    const TRANSFER_FORWARDING_STARTED = 'TRANSFER_FORWARDING_STARTED';
    const TRANSFER_FORWARDING_STOPPED = 'TRANSFER_FORWARDING_STOPPED';
    const TRANSFER_INFO = 'TRANSFER_INFO';
    const TRANSFER_LISTENING_TIMEOUT = 'TRANSFER_LISTENING_TIMEOUT';
    const TRFINFO = 'TRFINFO';
    const UNEXPECTED_KEY = 'UNEXPECTED_KEY';
    const VOICE_DETECTED = 'VOICE_DETECTED';
    const VOICE_DETECTION_STARTED = 'VOICE_DETECTION_STARTED';
    const VOICE_DETECTION_STOPPED = 'VOICE_DETECTION_STOPPED';
    const VOICE_NOT_DETECTED = 'VOICE_NOT_DETECTED';
    const WORD = 'WORD';
    const WORD_RECOGNIZED = 'WORD_RECOGNIZED';
    // answer to a http external message
    const EXTERNALANSWER = 'EXTERNALANSWER';
    
    /**
     * The event type
     *
     * @var string
     */
    protected $_eventType;

    /**
     * The source of the event
     *
     * @var mixed
     */
    protected $_eventSource;

    /**
     * Flag to indicate if this event object is dispatchable
     *
     * @var boolean
     */
    protected $_dispatchable = true;
    
    /**
     * An error message for error events
     *
     * @var string
     */
    protected $_errorMessage;

    /**
     * An error code for error events
     *
     * @var string
     */
    protected $_errorCode;

    /**
     * Additional params
     *
     * @var array
     */
    protected $_params = array();

    /**
     * Constructor
     *
     * @param string $eventType
     */
    public function __construct( $eventType )
    {
        if ( !is_string( $eventType ) ) {
        	throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be string, ' . gettype( $eventType ) . ' given' );
        }
    	$this->_eventType = $eventType;
    }
    
    /**
     * Destructor
     */
    public function __destruct()
    {
        if ( isset( $this->_eventSource ) ) {
            unset( $this->_eventSource );
        }
        
        $this->_params = array();
    }

    /**
     * Retrieves the event type for the current instance
     *
     * @return string
     */
    public function getEventType()
    {
        return $this->_eventType;
    }

    /**
     * Saves the context (source) where the event occured
     *
     * @param mixed $source
     * @return Streamwide_Engine_Events_Event
     */
    public function setEventSource( $source )
    {
        $this->_eventSource = $source;
        return $this;
    }

    /**
     * Retrieves the context (source) where the event occured
     *
     * @return mixed
     */
    public function getEventSource()
    {
        return $this->_eventSource;
    }

    /**
     * Mark the event object as dispatchable
     *
     * @return void
     */
    public function markDispatchable()
    {
        $this->_dispatchable = true;
    }
    
    /**
     * Mark the event object as undispatchable
     *
     * @return void
     */
    public function markUndispatchable()
    {
        $this->_dispatchable = false;
    }
    
    /**
     * Is the event object dispatchable
     *
     * @return boolean
     */
    public function isDispatchable()
    {
        return $this->_dispatchable;
    }
    
    /**
     * Save an error message
     *
     * @param string $errorMessage
     * @return Streamwide_Engine_Events_Event
     */
    public function setErrorMessage( $errorMessage )
    {
    	$this->_errorMessage = $errorMessage;
        return $this;
    }

    /**
     * Get the error message for this event
     *
     * @return string
     */
    public function getErrorMessage()
    {
    	return $this->_errorMessage;
    }

    /**
     * Set the error code for this event
     *
     * @param string $errorCode
     * @return Streamwide_Engine_Events_Event
     */
    public function setErrorCode( $errorCode )
    {
        $this->_errorCode = $errorCode;
        return $this;
    }

    /**
     * Get the error code for this event
     *
     * @return string
     */
    public function getErrorCode()
    {
    	return $this->_errorCode;
    }

    /**
     * Set an event parameter
     *
     * @param string $key
     * @param mixed $value
     * @return Streamwide_Engine_Events_Event
     */
    public function setParam( $key, $value )
    {
        $this->_params[$key] = $value;
        return $this;
    }

    /**
     * Retrieve an event parameter
     *
     * @param string $key
     * @return mixed
     */
    public function getParam( $key )
    {
    	if ( array_key_exists( $key, $this->_params ) ) {
    		return $this->_params[$key];
    	}
    }
    
    /**
     * Set event parameters
     *
     * @param array $params
     * @param boolean $merge
     * @return void
     */
    public function setParams( Array $params, $merge = false )
    {
        if ( true === $merge ) {
            $params = array_merge( $this->_params, $params );
        }
        $this->_params = $params;
        return $this;
    }
    
    /**
     * Retrieve the event parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }
    
    /**
     * Retrieve a context parameter
     *
     * @param string $key
     * @return mixed
     */
    public function getContextParam( $key )
    {
        $key = sprintf( '__%s__', $key );
        return $this->getParam( $key );
    }

}

/* EOF */
