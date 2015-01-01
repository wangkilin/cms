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
 * @subpackage Streamwide_Engine_Signal
 * @version 1.0
 *
 */

/**
 * Representation of a SW Engine event (basically a wrapper on steroids over the
 * array returned by the as_next_event function)
 */
class Streamwide_Engine_Signal
{

    const SIG_NAME = 'name';
    const SIG_REMOTE = 'remote';
    const SIG_PHPID = 'phpid';
    const SIG_PARAMS = 'params';
    
    const ARM = 'ARM';
    const CHILD = 'CHILD';
    const CREATE = 'CREATE';
    const DIAMETERMESSAGE = 'DIAMETERMESSAGE';
    const DIAMETERSWITCHSERVER = 'DIAMETERSWITCHSERVER';
    const DISARM = 'DISARM';
    const DTMF = 'DTMF';
    const END = 'END';
    const ENDOFFAX = 'ENDOFFAX';
    const EOF = 'EOF';
    const EVENT = 'EVENT';
    const FAIL = 'FAIL';
    const FAILMOVED = 'FAILMOVED';
    const FAILREGISTER = 'FAILREGISTER';
    const FAILSDP = 'FAILSDP';
    const FAILSPEAK = 'FAILSPEAK';
    const FAILSUBSCRIBE = 'FAILSUBSCRIBE';
    const FAILTRANSFER = 'FAILTRANSFER';
    const FAXPAGE = 'FAXPAGE';
    const FAXRECEIVE = 'FAXRECEIVE';
    const FAXSEND = 'FAXSEND';
    const GOTO = 'GOTO';
    const INFO = 'INFO';
    const KILL = 'KILL';
    const LIMITCALL = 'LIMITCALL';
    const MCUSET = 'MCUSET';
    const MCUSTOP = 'MCUSTOP';
    const MCUPLAY = 'MCUPLAY';
    const MOVED = 'MOVED';
    const NOTIFY = 'NOTIFY';
    const OK = 'OK';
    const OKMOVED = 'OKMOVED';
    const OKREGISTER = 'OKREGISTER';
    const OKSDP = 'OKSDP';
    const OKSPEAK = 'OKSPEAK';
    const OKSUBSCRIBE = 'OKSUBSCRIBE';
    const OKTRANSFER = 'OKTRANSFER';
    const PAUSE = 'PAUSE';
    const PLAY = 'PLAY';
    const PROGRESS = 'PROGRESS';
    const REARM = 'REARM';
    const RECOGNIZE = 'RECOGNIZE';
    const RECORDSTART = 'RECORDSTART';
    const RECORDSTOP = 'RECORDSTOP';
    const REGISTER = 'REGISTER';
    const RESUME = 'RESUME';
    const RING = 'RING';
    const RTPPROXY = 'RTPPROXY';
    const SDP = 'SDP';
    const SET = 'SET';
    const SIGNAL = 'SIGNAL';
    const SPEAK = 'SPEAK';
    const STOP = 'STOP';
    const SUBSCRIBE = 'SUBSCRIBE';
    const SWAP = 'SWITCH';
    const TIMEOUT = 'TIMEOUT';
    const TRANSFER = 'TRANSFER';
    const TRFINFO = 'TRFINFO';
    const WORD = 'WORD';

    /**
     * The name of the signal
     *
     * @var string
     */
    protected $_name;

    /**
     * The destination of the signal
     *
     * @var string
     */
    protected $_remote;

    /**
     * The php process id
     *
     * @var integer
     */
    protected $_phpId;

    /**
     * The signal paramaters
     *
     * @var array
     */
    protected $_params = array();
    
    /**
     * A SW Engine proxy
     *
     * @var Streamwide_Engine_Proxy
     */
    protected $_engineProxy;
    
    /**
     * Has the signal been relayed?
     *
     * @var boolean
     */
    protected $_hasBeenRelayed = false;
    
    /**
     * Constructor
     *
     * @param Streamwide_Engine_Proxy $engineProxy
     * @return void
     */
    public function __construct( Streamwide_Engine_Proxy $engineProxy = null )
    {
        if ( null !== $engineProxy ) {
            $this->setEngineProxy( $engineProxy );
        }
    }
    
    public function __destruct()
    {
        if ( isset( $this->_engineProxy ) ) {
            unset( $this->_engineProxy );
        }
    }

    /**
     * Relays a signal to $callLegName
     *
     * @param string $callLegName The call leg name to relay the signal to
     * @param array $options Relaying options
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function relay( $callLegName, Array $options = null )
    {
        if ( $this->_hasBeenRelayed ) {
            return false;
        }
        
        if ( 0 == strcmp( $this->_remote, $callLegName ) ) {
        	throw new InvalidArgumentException( 'Cannot relay to the same call leg name' );
        }

        $retries = 0;
        $excludeParams = false;

        if ( is_array( $options ) ) {
        	if ( isset( $options['retries'] ) ) {
        		$retries = (int)$options['retries'];
        	}
            if ( isset( $options['excludeParams'] ) ) {
            	$excludeParams = (bool)$options['excludeParams'];
            }
        }

        $clone = clone $this;
        $clone->setRemote( $callLegName );
        if ( true === $excludeParams ) {
            $clone->setParams( array() );
        } else {
            $clone->setParams( $this->_params );
            $clone->cleanSipHeaders();
        }
        
        $sent = $clone->send( $retries );
        if ( $sent ) {
            $this->markRelayed();
        }
        return $sent;
    }

    /**
     * Sends a signal to SW Engine
     *
     * @param integer $retries If as_send_event returns false, we can retry to send the signal
     * @return boolean
     */
    public function send( $retries = 0 )
    {
        if ( !is_int( $retries ) ) {
        	$retries = (int)$retries;
        }

        $array = $this->toArray();
        do {
            Streamwide_Engine_Logger::dump( $array, 'Sending to SW Engine:' );
            $sent = $this->_engineProxy->sendEvent( $array );
            Streamwide_Engine_Logger::info( sprintf( 'Signal "%s" %s sent to SW Engine', $array[self::SIG_NAME], ( $sent === true ? 'successfully' : 'unsuccessfully' ) ) );
            $retries--;
        }
        while ( false === $sent && $retries > 0 );

        return $sent;
    }
    
    /**
     * Has the signal been relayed?
     *
     * @return boolean
     */
    public function hasBeenRelayed()
    {
        return $this->_hasBeenRelayed;
    }
    
    /**
     * Mark the signal as being relayed
     *
     * @return unknown_type
     */
    public function markRelayed()
    {
        $this->_hasBeenRelayed = true;
    }
    
    /**
     * Set the engine proxy to be used
     *
     * @param Streamwide_Engine_Proxy $engineProxy
     * @return void
     */
    public function setEngineProxy( Streamwide_Engine_Proxy $engineProxy )
    {
        $registry = Streamwide_Engine_Registry::getInstance();
        $registry->set( SW_ENGINE_PROXY, $engineProxy );
        $this->_engineProxy = $engineProxy;
    }
    
    /**
     * Getter method for the Streamwide_Engine_Signal::_name property
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Setter method for the Streamwide_Engine_Signal::_name property
     *
     * @param string $name
     * @return void
     */
    public function setName( $name )
    {
        if ( !is_scalar( $name ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a scalar, ' . gettype( $name ) . ' given' );
        }

        if ( !is_string( $name ) ) {
            $name = (string)$name;
        }

        $this->_name = $name;
    }

    /**
     * Getter method for the Streamwide_Engine_Signal::_remote property
     *
     * @return string
     */
    public function getRemote()
    {
        return $this->_remote;
    }

    /**
     * Setter method for the Streamwide_Engine_Signal::_remote property
     *
     * @param string $remote
     * @return void
     * @throws InvalidArgumentException
     */
    public function setRemote( $remote )
    {
        if ( !is_scalar( $remote ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a scalar, ' . gettype( $remote ) . ' given' );
        }

        if ( !is_string( $remote ) ) {
            $remote = (string)$remote;
        }

        $this->_remote = $remote;
    }

    /**
     * Getter method for the Streamwide_Engine_Signal::_phpId property
     *
     * @return integer
     */
    public function getPhpId()
    {
        return $this->_phpId;
    }

    /**
     * Setter method for the Streamwide_Engine_Signal::_phpId property
     *
     * @param integer $phpId
     * @return void
     * @throws InvalidArgumentException
     */
    public function setPhpId( $phpId )
    {
        if ( !is_scalar( $phpId ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a scalar, ' . gettype( $phpId ) . ' given' );
        }

        if ( !is_int( $phpId ) ) {
            $phpId = (int)$phpId;
        }

        if ( $phpId < 0 ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a positive integer' );
        }
        
        $this->_phpId = $phpId;
    }

    /**
     * Getter method for the Streamwide_Engine_Signal::_params property
     *
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * Setter method for the Streamwide_Engine_Signal::_params property
     *
     * @param array $params
     * @return void
     */
    public function setParams( Array $params )
    {
        if ( is_array( $params ) ) {
            $this->_params = $params;
        }
    }
    
    /**
     * Clean sip headers from parameters
     *
     * @return void
     */
    public function cleanSipHeaders()
    {
        if ( !empty( $this->_params ) ) {
            foreach ( $this->_params as $parameterName => $parameterValue ) {
                if ( 0 === strpos( $parameterName, 'sip_' ) ) {
                    unset( $this->_params[$parameterName] );
                }
            }
        }
    }
    
    /**
     * Returns the array representation of the current signal
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            self::SIG_NAME => $this->_name,
            self::SIG_REMOTE => $this->_remote,
            self::SIG_PHPID => $this->_phpId,
            self::SIG_PARAMS => $this->_params
        );
    }

    /**
     * Returns a string representation of the current signal when object is used in string context
     *
     * @return string
     */
    public function __toString()
    {
        $string = self::SIG_NAME . ': ' . $this->_name . PHP_EOL;
        $string .= self::SIG_REMOTE . ': ' . $this->_remote . PHP_EOL;
        $string .= self::SIG_PHPID . ': '. $this->_phpId . PHP_EOL;
        $string .= self::SIG_PARAMS . ': ' . PHP_EOL;
        foreach ( new RecursiveIteratorIterator( new RecursiveArrayIterator( $this->_params ) ) as $key => $value ) {
            $string .= "\t" . $key . ': ' . $value . PHP_EOL;
        }
        return $string;
    }
    
    /**
     * Create a signal object
     *
     * @param string $name
     * @param string|null $remote
     * @param array|null $params
     * @return Streamwide_Engine_Signal
     * @throws Exception
     */
    public static function factory( $name, $remote = null, Array $params = null )
    {
        $registry = Streamwide_Engine_Registry::getInstance();
        $phpId = $registry->get( SW_ENGINE_CURRENT_PHPID );
        
        $engineProxy = $registry->get( SW_ENGINE_PROXY );
        if ( null === $engineProxy ) {
            $engineProxy = new Streamwide_Engine_Proxy();
            $registry->set( SW_ENGINE_PROXY, $engineProxy );
        }
        
        if ( !$engineProxy instanceof Streamwide_Engine_Proxy ) {
            throw new Exception( 'The engine proxy object must be an instance of Streamwide_Engine_Proxy' );
        }
        
        $signal = new self( $engineProxy );
        $signal->setName( $name );
        $signal->setPhpId( $phpId );
        if ( null !== $remote && is_string( $remote ) ) {
            $signal->setRemote( $remote );
        }
        if ( null !== $params && is_array( $params ) ) {
            $signal->setParams( $params );
        }
        return $signal;
    }
    
    /**
     * Retrieve the next signal from the SW Engine's event queue
     *
     * @param array $options
     * @return Streamwide_Engine_Signal|boolean
     */
    public static function dequeue( Array $options = null )
    {
        $registry = Streamwide_Engine_Registry::getInstance();
        
        // initialize options to their default values
        if ( null === ( $engineProxy = $registry->get( SW_ENGINE_PROXY ) ) ) {
            $engineProxy = new Streamwide_Engine_Proxy();
            $registry->set( SW_ENGINE_PROXY, $engineProxy );
        }
        $timeout = -1;
        $savePhpId = true;
        
        if ( is_array( $options ) ) {
            if ( isset( $options['timeout'] ) ) {
                $timeout = (int)$options['timeout'];
            }
            
            if ( isset( $options['engineProxy'] ) && $options['engineProxy'] instanceof Streamwide_Engine_Proxy ) {
                $engineProxy = $options['engineProxy'];
                $registry->set( SW_ENGINE_PROXY, $engineProxy );
            }
            
            if ( isset( $options['savePhpId'] ) ) {
                $savePhpId = (bool)$options['savePhpId'];
            }
        }
        
        if ( false === ( $array = $engineProxy->nextEvent( $timeout ) ) ) {
            return false;
        }
        
        $name = $array[self::SIG_NAME];
        $phpId = $array[self::SIG_PHPID];
        $remote = $array[self::SIG_REMOTE];
        $params = $array[self::SIG_PARAMS];
        
        if ( $savePhpId ) {
            $registry->set( SW_ENGINE_CURRENT_PHPID, $phpId );
        }
        
        $signal = new self( $engineProxy );
        $signal->setName( $name );
        $signal->setPhpId( $phpId );
        $signal->setRemote( $remote );
        $signal->setParams( $params );
        return $signal;
    }

}

/* EOF */
