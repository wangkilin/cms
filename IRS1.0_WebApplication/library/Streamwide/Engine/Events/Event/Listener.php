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
 * @subpackage Streamwide_Engine_Event
 * @version 1.0
 *
 */


/**
 * An entity that is interested in received certain events
 */
class Streamwide_Engine_Events_Event_Listener implements Streamwide_Event_Listener_Interface
{

    /**
     * Callback types
     */
    const CALLBACK_FUNC = 'FUNC';
    const CALLBACK_CLASS = 'CLASS';
    const CALLBACK_OBJECT = 'OBJECT';
    
    /**
     * Execution options names
     */
    const OPT_AUTO_REMOVE = 'autoRemove';
    const OPT_REMOVE_GROUP = 'removeGroup';
    const OPT_PRIORITY = 'priority';
    const OPT_NOTIFY_FILTER = 'notifyFilter';
    const OPT_FORCE_EXECUTION = 'forceExecution';
    
    /**
     * Parameter names
     */
    const PARAM_INSERT_OFFSET = 'insertOffset';
    const PARAM_GROUP = 'group';
    
    /**
     * Name of the listener (used for logging purposes). It is constructed internally
     * based on the callback type
     *
     * @var string
     */
    protected $_loggingName;
    
    /**
     * The php id in which this listener was attached to an event
     *
     * @var string
     */
    protected $_phpId;

    /**
     * The event type that will trigger the execution of this listener
     *
     * @var string
     */
    protected $_eventType;
    
    /**
     * Callback to execute when calling Streamwide_Engine_Events_Event_Listener::execute() method
     *
     * @var string|array
     */
    protected $_callback;

    /**
     * The callback type (one of FUNC, CLASS, OBJECT)
     *
     * @var string
     */
    protected $_callbackType;
    
    /**
     * Arguments for the callback
     *
     * @var array
     */
    protected $_args = array();

    /**
     * The event object that will be passed to the callback
     * if no event is provided when calling execute method
     *
     * @var Streamwide_Event_Interface
     */
    protected $_event;
    
    /**
     * Execution options for the listener
     *
     * @var array|null
     */
    protected $_options = array();
    
    /**
     * Event listener parameters
     *
     * @var array|null
     */
    protected $_params = array();

    /**
     * Constructor
     *
     * @param integer $phpId
     * @param array|string $callback
     * @param string|null $eventType
     * @param array|null $args
     * @param array|null $options
     * @param array|null $params
     */
    public function __construct( $phpId, $callback, $eventType = null, Array $args = null, Array $options = null, Array $params = null )
    {
        $this->setPhpId( $phpId );
        $this->setCallback( $callback );
        
        if ( null !== $eventType ) {
            $this->setEventType( $eventType );
        }
        if ( null !== $args ) {
            $this->setArgs( $args );
        }
        if ( null !== $options ) {
            $this->setOptions( $options );
        }
        if ( null !== $params ) {
            $this->setParams( $params );
        }
    }

    /**
     * Destructor
     *
     * @return void
     */
    public function __destruct()
    {
        if ( isset( $this->_callback ) ) {
            unset( $this->_callback );
        }
        
        if ( isset( $this->_event ) ) {
            unset( $this->_event );
        }
    }
    
    /**
     * Factory method. Returns an instance of this class
     *
     * @param array $config
     * @return Streamwide_Engine_Events_Event_Listener
     * @throws InvalidArgumentException
     */
    public static function factory( Array $config )
    {
        if ( !isset( $config['phpId'] ) ) {
            throw new InvalidArgumentException( 'Configuration array needed to construct an event listener must have a "phpId" key' );
        }
        $phpId = $config['phpId'];
                
        if ( !isset( $config['callback'] ) ) {
            throw new InvalidArgumentException( 'Configuration array needed to construct an event listener must have a "callback" key' );
        }
        $callback = $config['callback'];
        
        $eventType = isset( $config['eventType'] ) ? $config['eventType'] : null;
        
        $args = isset( $config['args'] ) ? $config['args'] : array();
        if ( !is_array( $args ) ) {
            $args = array( $args );
        }
        
        $options = isset( $config['options'] ) ? $config['options'] : array();
        if ( !is_array( $options ) ) {
            $options = array();
        }
        
        $params = isset( $config['params'] ) ? $config['params'] : array();
        if ( !is_array( $params ) ) {
            $params = array();
        }
        
        return new self( $phpId, $callback, $eventType, $args, $options, $params );
    }
    
    /**
     * Execute the action that was attached to a certain event
     *
     * @param Streamwide_Event_Interface $event
     * @return mixed
     */
    public function execute( Streamwide_Event_Interface $event = null )
    {
        Streamwide_Engine_Logger::info( sprintf( 'Executing callback "%s"', $this->_loggingName ) );
        
        $args = $this->_args;
        $args[] = ( null === $event ? $this->_event : $event );
        return call_user_func_array( $this->_callback, $args );
    }

    /**
     * Determines if a listener instance is equal to another. A listener is equal to another if:
     *
     * 1: They were attached to an event in the same php id
     * 2: If their internal callbacks are equal
     *
     * @param Streamwide_Event_Listener_Interface $listener
     * @return boolean
     */
    public function equals( Streamwide_Event_Listener_Interface $listener )
    {
        // the 2 listeners must have the same phpId
        if ( $this->_phpId !== $listener->getPhpId() ) {
            return false;
        }

        // the 2 listeners must have the same callback type
        if ( $this->_callbackType !== $listener->getCallbackType() ) {
            return false;
        }
        
        // if the callback of the 2 listeners is a global function
        // compare the function name
        if ( self::CALLBACK_FUNC === $this->_callbackType ) {
            $callback = $listener->getCallback();
            return ( $this->_callback === $callback );
        }
        
        // if the callback of the 2 listeners is a static method
        // compare the method name and class name
        if ( self::CALLBACK_CLASS === $this->_callbackType ) {
            $callback = $listener->getCallback();
            if ( $this->_callback[1] !== $callback[1] ) {
                return false;
            }
            return ( $this->_callback[0] === $callback[0] );
        }
        
        // if the callback of the 2 listeners is a regular method
        // compare the method name, the classes of the objects
        // and their callbackId
        if ( self::CALLBACK_OBJECT === $this->_callbackType ) {
            $callback = $listener->getCallback();
            if ( $this->_callback[1] !== $callback[1] ) {
                return false;
            }
            return (
                get_class( $this->_callback[0] ) === get_class( $callback[0] ) &&
                0 === strcmp( $this->_callback[0]->getCallbackId(), $callback[0]->getCallbackId() )
            );
        }
    }

    /**
     * @param integer $phpId
     * @return void
     * @throws InvalidArgumentException
     */
    public function setPhpId( $phpId )
    {
        if ( !is_scalar( $phpId ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be an positive integer' );
        }
        
        if ( !is_int( $phpId ) ) {
            $phpId = (int)$phpId;
        }
        
        if ( $phpId < 0 ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be an positive integer' );
        }
        
        $this->_phpId = $phpId;
    }
    
    /**
     * @return integer
     */
    public function getPhpId()
    {
        return $this->_phpId;
    }
    
    /**
     * @param string $eventType
     * @return void
     */
    public function setEventType( $eventType )
    {
        if ( !is_string( $eventType ) || strlen( $eventType ) < 1 ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a non-empty string' );
        }
        
        $this->_eventType = $eventType;
    }
    
    /**
     * @return string
     */
    public function getEventType()
    {
        return $this->_eventType;
    }
    
    /**
     * @param string|array $callback
     * @throws InvalidArgumentException
     */
    public function setCallback( $callback )
    {
        if ( !is_callable( $callback ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a valid callback' );
        }

        $this->_determineCallbackType( $callback );
        
        if ( self::CALLBACK_OBJECT === $this->_callbackType ) {
            $object = $callback[0];
            if ( !$object instanceof Streamwide_Engine_Callback_Interface ) {
                throw new InvalidArgumentException( __METHOD__ . ' expects that the first element of the callback array to implement the Streamwide_Engine_Callback_Interface' );
            }
            $object->setCallbackId();
        }
        
        $this->_callback = $callback;
    }
    
    /**
     * Retrieve the internal callback function
     *
     * @return string|array
     */
    public function getCallback()
    {
        return $this->_callback;
    }
    
    /**
     * Arguments for the callback
     *
     * @param array|null $args
     */
    public function setArgs( Array $args = null )
    {
        $this->_args = $args;
    }
    
    /**
     * Retrieve the arguments array for the internal callback function
     *
     * @return array
     */
    public function getArgs()
    {
        return $this->_args;
    }
    
    /**
     * Set the event that will be passed to the callback if no event object
     * is provided when calling execute method
     *
     * @param Streamwide_Event_Interface $event
     * @return void
     */
    public function setEvent( Streamwide_Event_Interface $event )
    {
        $this->_event = $event;
    }
    
    /**
     * Get the event that will be passed to the callback if no event object is provided
     * when calling the execute method
     */
    public function getEvent()
    {
        return $this->_event;
    }
    
    /**
     * Set the execution options for the listener from an associative
     * array
     *
     * @param array $options
     * @return void
     */
    public function setOptions( Array $options )
    {
        if ( empty( $options ) ) {
            return;
        }
        
        $optionsNames = array(
            self::OPT_AUTO_REMOVE,
            self::OPT_REMOVE_GROUP,
            self::OPT_PRIORITY,
            self::OPT_NOTIFY_FILTER,
            self::OPT_FORCE_EXECUTION
        );
        
        for ( $i = 0, $n = count( $optionsNames ); $i < $n; $i++ ) {
            $optionName = $optionsNames[$i];
            
            if ( array_key_exists( $optionName, $options ) ) {
                $method = 'set' . ucfirst( $optionName );
                if ( method_exists( $this, $method ) ) {
                    $this->$method( $options[$optionName] );
                }
            }
        }
    }
    
    /**
     * Retrieve the execution options set for this listener
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }
    
    /**
     * Set the listener priority
     *
     * @param integer $priority
     * @return void
     */
    public function setPriority( $priority )
    {
        $this->_options[self::OPT_PRIORITY] = (int)$priority;
    }
    
    /**
     * Retrieve the execution priority for the current instance
     *
     * @return integer
     */
    public function getPriority()
    {
        if ( isset( $this->_options[self::OPT_PRIORITY] ) ) {
            return $this->_options[self::OPT_PRIORITY];
        }
        
        // default
        return 0;
    }

    /**
     * Set the specification that contain the logic to tell us
     * if the event listener can be executed when a certain event occurs
     *
     * @param Streamwide_Specification_Abstract $spec
     * @return void
     */
    public function setNotifyFilter( Streamwide_Specification_Abstract $spec )
    {
        $this->_options[self::OPT_NOTIFY_FILTER] = $spec;
    }
    
    /**
     * Retrieve the specifications that contain the logic to tell us
     * if the event listener can be executed when a certain event occurs
     *
     * @return Streamwide_Specification_Abstract
     */
    public function getNotifyFilter()
    {
        if ( isset( $this->_options[self::OPT_NOTIFY_FILTER] ) ) {
            return $this->_options[self::OPT_NOTIFY_FILTER];
        }
        
        // default
        return new Streamwide_Engine_NotifyFilter_AlwaysTrue();
    }
    
    /**
     * @param string $autoRemove
     * @return void
     */
    public function setAutoRemove( $autoRemove )
    {
        $autoRemove = strtolower( $autoRemove );
        
        switch ( $autoRemove ) {
            case 'before':
            case 'after':
                $this->_options[self::OPT_AUTO_REMOVE] = $autoRemove;
            break;
        }
    }
    
    /**
     * @return string|null
     */
    public function getAutoRemove()
    {
        if ( isset( $this->_options[self::OPT_AUTO_REMOVE] ) ) {
            return $this->_options[self::OPT_AUTO_REMOVE];
        }
        
        // default
        return null;
    }
    
    /**
     * @param boolean $removeGroup
     * @return void
     */
    public function setRemoveGroup( $removeGroup )
    {
        $this->_options[self::OPT_REMOVE_GROUP] = (bool)$removeGroup;
    }
    
    /**
     * @return boolean
     */
    public function getRemoveGroup()
    {
        if ( isset( $this->_options[self::OPT_REMOVE_GROUP] ) ) {
            return $this->_options[self::OPT_REMOVE_GROUP];
        }
        
        // default
        return false;
    }
    
    /**
     * @param boolean $forceExecution
     * @return void
     */
    public function setForceExecution( $forceExecution )
    {
        $this->_options[self::OPT_FORCE_EXECUTION] = (bool)$forceExecution;
    }
    
    /**
     * @return boolean
     */
    public function getForceExecution()
    {
        if ( isset( $this->_options[self::OPT_FORCE_EXECUTION] ) ) {
            return $this->_options[self::OPT_FORCE_EXECUTION];
        }
        
        // default
        return false;
    }
    
    /**
     * Is the listener marked to be automatically removed before execution?
     *
     * @return boolean
     */
    public function isAutoRemovableBeforeExecution()
    {
        return (
            isset( $this->_options[self::OPT_AUTO_REMOVE] )
            && strtolower( $this->_options[self::OPT_AUTO_REMOVE] ) === 'before'
        );
    }
    
    /**
     * Is the listener marked to be automatically removed after execution?
     *
     * @return boolean
     */
    public function isAutoRemovableAfterExecution()
    {
        return (
            isset( $this->_options[self::OPT_AUTO_REMOVE] )
            && strtolower( $this->_options[self::OPT_AUTO_REMOVE] ) === 'after'
        );
    }
    
    /**
     * Whether or not to remove the listener from the listeners list automatically
     *
     * @return integer Will be removed BEFORE executing the internal callback (-1),
     *                 will be removed AFTER executing the internal callback (1)
     *                 or no auto remove (0).
     * @deprecated since v1.1
     */
    public function autoRemove()
    {
        if ( !isset( $this->_options['autoRemove'] ) ) {
            return 0;
        }
        $autoRemove = (string)$this->_options['autoRemove'];
        switch ( $autoRemove ) {
            case 'before': return -1;
            case 'after': return 1;
        }
        return 0;
    }

    /**
     * Retrieve the internal callback type (can be one of: FUNC, CLASS or OBJECT)
     *
     * @return string
     */
    public function getCallbackType()
    {
        return $this->_callbackType;
    }
    
    /**
     * Set the insert offset of the listener
     *
     * @param integer $offset
     * @return void
     * @throws InvalidArgumentException
     */
    public function setInsertOffset( $offset )
    {
        if ( !is_int( $offset ) || $offset < 0 ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be an integer greater than or equal to 0' );
        }
        
        $this->setParam( self::PARAM_INSERT_OFFSET, $offset );
    }
    
    /**
     * Retrieve the insert offset of the listener
     *
     * @return integer|null
     */
    public function getInsertOffset()
    {
        return $this->getParam( self::PARAM_INSERT_OFFSET );
    }
    
    /**
     * Set the listener group
     *
     * @param string $group
     * @return void
     * @throws InvalidArgumentException
     */
    public function setGroup( $group )
    {
        if ( !is_string( $group ) || strlen( $group ) < 1 ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a non-empty string' );
        }
        
        $this->setParam( self::PARAM_GROUP, $group );
    }
    
    /**
     * Retrieve the listener's group
     *
     * @return string|null
     */
    public function getGroup()
    {
        return $this->getParam( self::PARAM_GROUP );
    }
    
    /**
     * Set a parameter
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setParam( $key, $value )
    {
        $this->_params[$key] = $value;
    }
    
    /**
     * Return the value of a parameter
     *
     * @param string $key
     * @return mixed
     */
    public function getParam( $key )
    {
        if ( array_key_exists( $key, $this->_params ) )
        {
            return $this->_params[$key];
        }
    }
    
    /**
     * Set ALL the parameters
     *
     * @param array $params
     * @return void
     */
    public function setParams( Array $params )
    {
        if ( empty( $params ) ) {
            return;
        }

        $numberOfRemainingParams = $numberOfProvidedParams = count( $params );
        
        $paramsNames = array(
            self::PARAM_INSERT_OFFSET,
            self::PARAM_GROUP
        );
        
        for ( $i = 0, $n = count( $paramsNames ); $i < $n; $i++ ) {
            $paramName = $paramsNames[$i];
            
            if ( array_key_exists( $paramName, $params ) ) {
                $method = 'set' . ucfirst( $paramName );
                if ( method_exists( $this, $method ) ) {
                    $this->$method( $params[$paramName] );
                    unset( $params[$paramName] );
                    $numberOfRemainingParams--;
                }
            }
        }
        
        if ( $numberOfRemainingParams > 0 ) {
            if ( $numberOfRemainingParams < $numberOfProvidedParams ) {
                $params = array_merge( $this->_params, $params );
            }
                
            $this->_params = $params;
        }
    }
    
    /**
     * Retrieve ALL the parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }
    
    /**
     * Is the internal callback a global function?
     *
     * @return boolean
     */
    public function hasFunctionCallback()
    {
        return ( $this->_callbackType === self::CALLBACK_FUNC );
    }
    
    /**
     * Is the internal callback a static method?
     *
     * @return boolean
     */
    public function hasClassCallback()
    {
        return ( $this->_callbackType === self::CALLBACK_CLASS );
    }
    
    /**
     * Is the internal callback a regular method?
     *
     * @return boolean
     */
    public function hasObjectCallback()
    {
        return ( $this->_callbackType === self::CALLBACK_OBJECT );
    }

    /**
     * @return string
     */
    public function getLoggingName()
    {
        if ( !isset( $this->_loggingName ) ) {
            $this->_setLoggingName();
        }
        
        return $this->_loggingName;
    }
    
    /**
     * Determine the callback type (can be one of FUNC, OBJECT, CLASS)
     *
     * @param array|string $callback
     * @return void
     */
    protected function _determineCallbackType( $callback )
    {
        if ( is_array( $callback ) ) {
            if ( is_object( $callback[0] ) ) {
                $this->_callbackType = self::CALLBACK_OBJECT;
            } else {
                $this->_callbackType = self::CALLBACK_CLASS;
            }
        } else {
            $this->_callbackType = self::CALLBACK_FUNC;
        }
    }
    
    /**
     * Set the listener's logging name
     *
     * @return void
     */
    protected function _setLoggingName()
    {
        switch ( $this->_callbackType ) {
            case self::CALLBACK_OBJECT:
                $this->_loggingName = sprintf(
                    '%s->%s() (callback id: %s)',
                    get_class( $this->_callback[0] ),
                    $this->_callback[1],
                    $this->_callback[0]->getCallbackId()
                );
            break;
            case self::CALLBACK_CLASS:
                $this->_loggingName = vsprintf( '%s::%s()', $this->_callback );
            break;
            case self::CALLBACK_FUNC:
                $this->_loggingName = sprintf( '%s()', $this->_callback );
            break;
        }
    }
    
}

/* EOF */
