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
 * @subpackage Streamwide_Engine_Widget
 * @version 1.0
 *
 */

/**
 * Base widget class
 */
abstract class Streamwide_Engine_Widget implements Streamwide_Event_Dispatcher_Interface, Streamwide_Engine_Callback_Interface
{
    
    /**
     * The class for the default event dispatcher object
     *
     * @var string
     */
    protected static $_defaultEventDispatcherClass = 'Streamwide_Engine_Events_Event_Dispatcher';
    
    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array( Streamwide_Engine_Events_Event::ERROR );
    
    /**
     * Internal event dispatcher
     *
     * @var Streamwide_Event_Dispatcher_Interface
     */
    protected $_eventDispatcher;
    
    /**
     * Object to handle the state management of the widget (if the widget
     * needs state management)
     *
     * @var Streamwide_Engine_Widget_State_Manager
     */
    protected $_stateManager;
    
    /**
     * Global repository of common data
     *
     * @var Streamwide_Engine_Registry
     */
    protected $_registry;
    
    /**
     * Options for the widget
     *
     * @var array
     */
    protected $_options = array();

    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array();

    /**
     * If the methods of this widget are used as callbacks we need a unique id
     * to indentify that callback in order to perform a safe removal of that callback
     * when it's no longer needed
     *
     * @var string
     */
    protected $_callbackId;
    
    /**
     * A widget can be used in many contexts. This property helps setting some context
     * parameters that will be injected in the event objects dispatched by the widget.
     *
     * @var array|null
     */
    protected $_contextParams;
    
    /**
     * Options for injecting the context parameters into the event object
     *
     * @var array|null
     */
    protected $_contextParamsOptions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setEventDispatcher( new self::$_defaultEventDispatcherClass( get_class( $this ) ) );
        $this->setRegistry( Streamwide_Engine_Registry::getInstance() );
    }
    
    /**
     * Destructor
     */
    public function destroy()
    {
        $this->_unsubscribeFromEngineEvents();
        
        if ( isset( $this->_eventDispatcher ) ) {
            unset( $this->_eventDispatcher );
        }

        if ( isset( $this->_registry ) ) {
            unset( $this->_registry );
        }
        
        if ( isset( $this->_stateManager ) ) {
            unset( $this->_stateManager );
        }
    }
    
    /**
     * Set the event dispatcher
     *
     * @param Streamwide_Event_Dispatcher_Interface $eventDispatcher
     * @return void
     */
    public function setEventDispatcher( Streamwide_Event_Dispatcher_Interface $eventDispatcher )
    {
        $this->_eventDispatcher = $eventDispatcher;
    }
    
    /**
     * Return the event dispatcher for this widget
     *
     * @return Streamwide_Event_Dispatcher_Interface
     */
    public function getEventDispatcher()
    {
        return $this->_eventDispatcher;
    }
    
    /**
     * Set the state manager
     *
     * @param Streamwide_Engine_Widget_State_Manager $stateManager
     * @return void
     */
    public function setStateManager( Streamwide_Engine_Widget_State_Manager $stateManager )
    {
        $this->_stateManager = $stateManager;
    }
    
    /**
     * Retrieve the state manager for this widget (if any)
     * @return Streamwide_Engine_Widget_State_Manager|null
     */
    public function getStateManager()
    {
        return $this->_stateManager;
    }
    
    /**
     * Set the registry
     *
     * @param Streamwide_Engine_Registry $registry
     * @return void
     */
    public function setRegistry( Streamwide_Engine_Registry $registry )
    {
        $this->_registry = $registry;
    }
    
    /**
     * Retrieve the internal registry
     *
     * @return Streamwide_Engine_Registry
     */
    public function getRegistry()
    {
        return $this->_registry;
    }
    
    /**
     * Retrieve the controller reference from the registry
     *
     * @return Streamwide_Engine_Controller
     * @throws Exception
     */
    public function getController()
    {
        $controller = $this->_registry->get( SW_ENGINE_CONTROLLER );
        if ( null === $controller ) {
            throw new Exception( 'Controller object not set in the registry' );
        }
        return $controller;
    }
    
    /**
     * Sets the context parameters
     *
     * @param array $contextParams
     * @param array|null $options
     * @return void
     */
    public function setContextParams( Array $contextParams, Array $options = null )
    {
        if ( is_array( $options ) ) {
            $merge = false;
            if ( array_key_exists( 'merge', $options ) ) {
                $merge = (bool)$options['merge'];
                unset( $options['merge'] );
            }
            if ( true === $merge && null !== $this->_contextParams ) {
                $contextParams = array_merge( $this->_contextParams, $contextParams );
            }
        }
        $this->_contextParams = $contextParams;
        $this->_contextParamsOptions = $options;
    }
    
    /**
     * Retrieve the context parameters
     *
     * @return array|null
     */
    public function getContextParams()
    {
        return $this->_contextParams;
    }
    
    /**
     * Retrieve the context parameters options
     *
     * @return array|null
     */
    public function getContextParamsOptions()
    {
        return $this->_contextParamsOptions;
    }
    
    /**
     * Sets options values or provides default values for invalid or omitted required options
     *
     * @param mixed $options
     * @return void
     */
    public function setOptions( Array $options )
    {
        $this->_options = $options;
    }

    /**
     * Retrieve the options list of the widget
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * Retrieve a option value from the options list
     *
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function getOption( $optionName )
    {
        if ( !array_key_exists( $optionName, $this->_options ) ) {
            throw new InvalidArgumentException( sprintf( 'Option "%s" is not defined in %s\'s options list or it was not set', $optionName, get_class( $this ) ) );
        }
        return $this->_options[$optionName];
    }

    /**
     * Set a unique id for this callback
     *
     * @return void
     */
    public function setCallbackId()
    {
        if ( null === $this->_callbackId ) {
            $this->_callbackId = md5( uniqid( rand(), true ) );
        }
    }

    /**
     * Retrieve the unique id that was set with setCallbackId()
     *
     * @return string
     */
    public function getCallbackId()
    {
    	return $this->_callbackId;
    }

    /**
     * Retrieve the error messages list for this widget
     *
     * @return array
     */
    public function getErrors()
    {
    	return $this->_errors;
    }

    /**
     * Clears the context parameters
     *
     * @param array|null $contextParams Use this parameter if you want to clear only certain context params
     * @return void
     */
    public function clearContextParams( Array $contextParams = null )
    {
        if ( is_array( $contextParams ) && !empty( $contextParams ) ) {
            foreach ( new ArrayIterator( $contextParams ) as $contextParamName ) {
                if ( array_key_exists( $contextParamName, $this->_contextParams ) ) {
                    unset( $this->_contextParams[$contextParamName] );
                }
            }
            // if the context parameters list is empty set it to null
            if ( empty( $this->_contextParams ) ) {
                $this->_contextParams = null;
            }
        } else {
            $this->_contextParams = null;
        }
    }
    
    /**
     * Resets the widget's properties to the initial state
     *
     * @return void
     */
    public function reset()
    {
    	$this->_unsubscribeFromEngineEvents();
        $this->flushEventListeners();
    	$this->_contextParams = null;
    	$this->_contextParamsOptions = null;
    }
    
    /**
     * Is the provided event type in the allowed event types list?
     *
     * @param string $eventType
     * @return boolean
     */
    public function isAllowedEventType( $eventType )
    {
        return in_array( $eventType, $this->_allowedEventTypes );
    }

    /**
     * Set the default event dispatcher class
     *
     * @param string $defaultEventDispatcherClass
     * @return void
     */
    public static function setDefaultEventDispatcherClass( $defaultEventDispatcherClass )
    {
        if ( !is_string( $defaultEventDispatcherClass ) )
        {
            return;
        }
        
        try
        {
            $r = new ReflectionClass( $defaultEventDispatcherClass );
            if ( $r->isSubclassOf( 'Streamwide_Event_Dispatcher_Interface' ) && $r->isInstantiable() )
            {
                self::$_defaultEventDispatcherClass = $defaultEventDispatcherClass;
            }
        }
        catch ( Exception $e )
        {}
    }
    
    /**
     * @see Engine/Events/Event/Streamwide_Engine_Events_Event_Dispatcher#dispatchEvent()
     */
    public function dispatchEvent( Streamwide_Event_Interface $event )
    {
        $eventType = $event->getEventType();
        if ( !$this->isAllowedEventType( $eventType ) ) {
            return null;
        }
        
        // check to see if we have any context parameters set
        if ( null !== $this->_contextParams ) {
            $areContextParamsOptionsSet = (
                is_array( $this->_contextParamsOptions ) &&
                !empty( $this->_contextParamsOptions )
            );
            foreach ( new ArrayIterator( $this->_contextParams ) as $key => $value ) {
                $clashSafeName = sprintf( '__%s__', $key );
                // do we have options for the current context parameter?
                $hasOptions = (
                    // context parameters must be set
                    $areContextParamsOptionsSet
                    // the parameter name must exist as a key in the array
                    && array_key_exists( $key, $this->_contextParamsOptions )
                     // and must have an array value
                    && is_array( $this->_contextParamsOptions[$key] )
                    // which must be non empty
                    && !empty( $this->_contextParamsOptions[$key] )
                );
                if ( $hasOptions ) {
                    $options = $this->_contextParamsOptions[$key];
                    if ( array_key_exists( 'forEvent', $options ) ) {
                        if ( !is_array( $options['forEvent'] ) ) {
                            $options['forEvent'] = array( $options['forEvent'] );
                        }
                        if ( !in_array( $eventType, $options['forEvent'] ) ) {
                            // if the current context parameter is not allowed to be injected in
                            // the current event object skip to the next context parameter
                            continue;
                        }
                    }
                }
                // empty options or no options set default
                // to injecting the context parameter into all
                // events dispatched by the widget
                $event->setParam( $clashSafeName, $value );
            }
        }
        
        $event->setEventSource( $this );
        return $this->_eventDispatcher->dispatchEvent( $event );
    }
    
    /**
     * Dispatch an error event
     *
     * @param string $code
     * @param array|null $eventParams
     * @return void
     */
    public function dispatchErrorEvent( $code, Array $eventParams = null )
    {
        $errorEvent = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::ERROR );
        $errorEvent->setErrorCode( $code );
        if ( array_key_exists( $code, $this->_errors ) ) {
        	$errorEvent->setErrorMessage( $this->_errors[$code] );
        }
        if ( is_array( $eventParams ) && !empty( $eventParams ) ) {
        	foreach ( new ArrayIterator( $eventParams ) as $key => $param ) {
        		$errorEvent->setParam( $key, $param );
        	}
        }
        $this->dispatchEvent( $errorEvent );
    }
    
    /**
     * @see Engine/Events/Event/Streamwide_Engine_Events_Event_Dispatcher#addEventListener()
     */
    public function addEventListener( $eventType, Array $callback )
    {
        if ( !$this->isAllowedEventType( $eventType ) ) {
            return false;
        }
        return $this->_eventDispatcher->addEventListener( $eventType, $callback );
    }

    /**
     * @see Engine/Events/Event/Streamwide_Engine_Events_Event_Dispatcher#removeEventListener()
     */
    public function removeEventListener( $eventType, Array $callback )
    {
        if ( !$this->isAllowedEventType( $eventType ) ) {
            return false;
        }
        return $this->_eventDispatcher->removeEventListener( $eventType, $callback );
    }

    /**
     * @see Engine/Events/Event/Streamwide_Engine_Events_Event_Dispatcher#hasEventListener()
     */
    public function hasEventListener( $eventType, Array $callback )
    {
        if ( !$this->isAllowedEventType( $eventType ) ) {
            return false;
        }
        return $this->_eventDispatcher->hasEventListener( $eventType, $callback );
    }

    /**
     * @see Engine/Events/Event/Streamwide_Engine_Events_Event_Dispatcher#hasEventListeners()
     */
    public function hasEventListeners( $eventType = null )
    {
        if ( null !== $eventType && !$this->isAllowedEventType( $eventType ) ) {
            return false;
        }
        return $this->_eventDispatcher->hasEventListeners( $eventType );
    }

    /**
     * @see Engine/Events/Event/Streamwide_Engine_Events_Event_Dispatcher#getEventListeners()
     */
    public function getEventListeners()
    {
        return $this->_eventDispatcher->getEventListeners();
    }

    /**
     * @see Engine/Events/Event/Streamwide_Engine_Events_Event_Dispatcher#flushEventListeners()
     */
    public function flushEventListeners( Array $criteria = null )
    {
        $hasEventTypeCriteria = (
            is_array( $criteria ) &&
            !empty( $criteria ) &&
            array_key_exists( 'eventType', $criteria )
        );
        if ( $hasEventTypeCriteria && !$this->isAllowedEventType( $criteria['eventType'] ) ) {
            trigger_notice(
                sprintf(
                	'Unallowed event type "%s" provided in the criteria array. This can lead to unexpected results.',
                    $criteria['eventType']
                ),
                E_USER_NOTICE
            );
            unset( $criteria['eventType'] );
        }
        
        return $this->_eventDispatcher->flushEventListeners( $criteria );
    }
    
    /**
     * Subscribe to needed events from SW Engine
     *
     * @return void
     */
    protected function _subscribeToEngineEvents()
    {}
    
    /**
     * Unsubscribe from events from SW Engine
     *
     * @return void
     */
    protected function _unsubscribeFromEngineEvents()
    {}
    
    /**
     * Merges a custom allowed event types list with the one inherited from the base widget class
     *
     * @param string|array $allowedEventTypes
     * @return void
     */
    protected function _addAllowedEventTypes( $allowedEventTypes )
    {
        if ( !is_array( $allowedEventTypes ) ) {
            $allowedEventTypes = array( $allowedEventTypes );
        }
        
        if ( !is_array( $this->_allowedEventTypes ) ) {
            return null;
        }
        
        $allowedEventTypes = array_diff( $allowedEventTypes, $this->_allowedEventTypes );
        $this->_allowedEventTypes = array_merge( $this->_allowedEventTypes, $allowedEventTypes );
    }

}

/* EOF */
