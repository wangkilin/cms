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
 * Provides management (including notification and storage) of event listeners
 */
class Streamwide_Engine_Events_Event_Dispatcher implements Streamwide_Event_Dispatcher_Interface
{
    
    const T_FLUSH_PHPID = 'phpId';
    const T_FLUSH_EVENT_TYPE = 'eventType';
    const T_FLUSH_GROUP = 'group';
    
    /**
     * Holds a count with the number of instances of this class (used for logging)
     *
     * @var integer
     */
    protected static $_instances = 0;
    
    /**
     * The name of the class followed by the instance number (e.g Controller#2). Used for logging purposes
     *
     * @var string
     */
    protected $_class;
    
    /**
     * Event listeners list
     *
     * @var array
     */
    protected $_list = array();
    
    /**
     * Counter for the number of listeners attached to this dispatcher. Used mostly for logging purposes
     *
     * @var integer
     */
    protected $_count = 0;
    
    /**
     * Counter for the last index in the event listener list (optimization purposes)
     *
     * @var integer
     */
    protected $_nextAvailableListOffset = 0;
    
    /**
     * The internal registry
     *
     * @var Streamwide_Engine_Registry
     */
    protected $_registry;
    
    /**
     * A callback that will be executed when creating a new listener object. For now
     * this is used for testing purposes
     *
     * @var array|string
     */
    protected $_createListenerCallback;
    
    /**
     * Constructor
     *
     * @param string|null $class The class of the object that uses this event dispatcher (if any)
     */
    public function __construct( $class = null )
    {
        if ( null === $class )
        {
            $class = get_class( $this );
        }
        $this->_class = sprintf( '%s#%d', $class, ++self::$_instances );
        
        $this->setRegistry( Streamwide_Engine_Registry::getInstance() );
    }
    
    /**
     * @param Streamwide_Engine_Registry $registry
     * @return void
     */
    public function setRegistry( Streamwide_Engine_Registry $registry )
    {
        $this->_registry = $registry;
    }
    
    /**
     * @return Streamwide_Engine_Registry
     */
    public function getRegistry()
    {
        return $this->_registry;
    }

    /**
     * @param array|string $createListenerCallback
     * @return void
     */
    public function registerCreateListenerCallback( $createListenerCallback )
    {
        $this->_createListenerCallback = $createListenerCallback;
    }
    
    /**
     * @return void
     */
    public function unregisterCreateListenerCallback()
    {
        $this->_createListenerCallback = null;
    }
    
    /**
     * Dispatches an event. This means notifying all listeners and passing them the event object
     *
     * @param Streamwide_Event_Interface $event
     * @return void
     */
    public function dispatchEvent( Streamwide_Event_Interface $event )
    {
        $eventType = $event->getEventType();
        
        $phpId = $this->_registry->get( SW_ENGINE_CURRENT_PHPID );
        if ( null === $phpId ) {
            $logMessage = 'Event "%s" will not be dispatched from event dispatcher of class "%s" because the phpId is not set';
            Streamwide_Engine_Logger::debug( sprintf( $logMessage, $eventType, $this->_class ) );
            
            return;
        }
        
        $this->_dispatchEvent( $event, $phpId );
        
        return;
    }


    /**
     * Dispatches an event. This means notifying all listeners and passing them the event object
     *
     * @param Streamwide_Event_Interface $event
     * @param scalar $phpId
     * @return void
     */
    protected function _dispatchEvent( Streamwide_Event_Interface $event, $phpId )
    {
        $eventType = $event->getEventType();
        
        $logMessage = 'Preparing to dispatch the "%s" event in phpId "%d" from event dispatcher of class "%s"';
        Streamwide_Engine_Logger::info( sprintf( $logMessage, $eventType, $phpId, $this->_class ) );
        
        $logMessage = 'The event listeners count for class "%s" is %d';
        Streamwide_Engine_Logger::debug( sprintf( $logMessage, $this->_class, $this->_count ) );
        
        // search the event listener list for info that matches the php id and event type
        if ( !isset( $this->_list[$phpId][$eventType] ) ) {
            $logMessage = 'Event "%s" will not be dispatched in phpId "%d" from event dispatcher of class "%s"';
            $logMessage .= ' because no event listeners subscribed to it';
            Streamwide_Engine_Logger::debug( sprintf( $logMessage, $eventType, $phpId, $this->_class ) );
            
            return;
        }
        
        // If the event does not have a source yet, set the source to be the instance of this class,
        // this is needed because event dispatching capabilities can be aquired through composition too,
        // not only through inheritance
        if ( null === $event->getEventSource() ) {
            $event->setEventSource( $this );
        }
        
        foreach ( new ArrayIterator( $this->_list[$phpId][$eventType] ) as $offset => $listener ) {
            if ( !$event->isDispatchable() ) {
                $logMessage = 'Breaking out of the event dispatching loop in phpId "%d" from event dispatcher of class "%s"';
                $logMessage .= ' because the event object has been marked as undispatchable';
                Streamwide_Engine_Logger::debug( sprintf( $logMessage, $phpId, $this->_class ) );
                
                break;
            }
            
            if ( !isset( $this->_list[$phpId][$eventType][$offset] ) ) {
                $forceExecution = $listener->getForceExecution();
                
                if ( $forceExecution ) {
                    $logMessage = 'Forcing execution of listener "%s" from "%s"';
                    Streamwide_Engine_Logger::debug( sprintf( $logMessage, $listener->getLoggingName(), $this->_class ) );
                } else {
                    $logMessage = 'Could not find offset "%d" in the event listener list in class "%s" while dispatching event "%s"';
                    Streamwide_Engine_Logger::debug( sprintf( $logMessage, $offset, $this->_class, $eventType ) );
                    
                    continue;
                }
            }
            
            $specification = $listener->getNotifyFilter();
            if ( !$specification->isSatisfiedBy( $event ) ) {
                $logMessage = 'Event "%s" will not be dispatched in phpId "%d" from event dispatcher of class "%s"';
                $logMessage .= ' because the event does not satisfy the listener\'s specifications';
                Streamwide_Engine_Logger::debug( sprintf( $logMessage, $eventType, $phpId, $this->_class ) );
                
                continue;
            }
            
            if ( $listener->isAutoRemovableBeforeExecution() ) {
                $removeGroup = $listener->getRemoveGroup();
                
                if ( $removeGroup && ( null !== ( $groupName = $listener->getGroup() ) ) ) {
                    $this->_flushByGroup( $groupName );
                }
                else {
                    unset( $this->_list[$phpId][$eventType][$offset] );
                    $this->_count--;
                    
                    $logMessage = 'Listener "%s" was automatically removed before execution from "%s"';
                    Streamwide_Engine_Logger::debug( sprintf( $logMessage, $listener->getLoggingName(), $this->_class ) );
                    
                    $logMessage = 'The event listeners count for class "%s" is %d';
                    Streamwide_Engine_Logger::debug( sprintf( $logMessage, $this->_class, $this->_count ) );
                }
            }
            
            // execute the listener
            $listener->execute( $event );

            if ( $listener->isAutoRemovableAfterExecution() ) {
                $removeGroup = $listener->getRemoveGroup();
                
                if ( $removeGroup && ( null !== ( $groupName = $listener->getGroup() ) ) ) {
                    $this->_flushByGroup( $groupName );
                }
                else {
                    unset( $this->_list[$phpId][$eventType][$offset] );
                    $this->_count--;
                    
                    $logMessage = 'Listener "%s" was automatically removed after execution from "%s"';
                    Streamwide_Engine_Logger::debug( sprintf( $logMessage, $listener->getLoggingName(), $this->_class ) );
                    
                    $logMessage = 'The event listeners count for class "%s" is %d';
                    Streamwide_Engine_Logger::debug( sprintf( $logMessage, $this->_class, $this->_count ) );
                }
            }
        }
        
        if ( isset( $this->_list[$phpId][$eventType] ) ) {
            $this->_performListMaintenance( $phpId, $eventType );
        }
    }

    /**
     * Adds an event listener to the listeners list. On a successfull add the list is sorted by priority.
     * Listeners with the same priority will be executed in the order they were added to the list
     *
     * @param string $eventType
     * @param array $config
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function addEventListener( $eventType, Array $config )
    {
        if ( !is_string( $eventType ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a string ' . gettype( $eventType ) . ' given' );
        }
        
        $config['eventType'] = $eventType;
        $listener = $this->_newListener( $config );
        
        return $this->_addEventListener( $eventType, $listener );
    }

    /**
     * Removes an event listener from the listeners list
     *
     * @param string $eventType
     * @param array $config
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function removeEventListener( $eventType, Array $config )
    {
        if ( !is_string( $eventType ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a string ' . gettype( $eventType ) . ' given' );
        }
        
        $config['eventType'] = $eventType;
        $listener = $this->_newListener( $config );
        
        return $this->_removeEventListener( $eventType, $listener );
    }

    /**
     * Do we have any event listeners attached for the specified event type?
     *
     * @return boolean
     */
    public function hasEventListeners( $eventType = null )
    {
        if ( null === $eventType ) {
            return ( $this->_count > 0 );
        }

        $phpId = $this->_registry->get( SW_ENGINE_CURRENT_PHPID );
        if ( !isset( $this->_list[$phpId][$eventType] ) ) {
            return false;
        }
        
        return count( $this->_list[$phpId][$eventType] ) > 0;
    }

    /**
     * Searches for a certain event listener in the event listeners list
     *
     * @param string $eventType
     * @param array $config
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function hasEventListener( $eventType, Array $config )
    {
        if ( !is_string( $eventType ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a string ' . gettype( $eventType ) . ' given' );
        }
        
        $phpId = $this->_registry->get( SW_ENGINE_CURRENT_PHPID );
        if ( !isset( $this->_list[$phpId][$eventType] ) ) {
            return false;
        }
        
        $config['eventType'] = $eventType;
        $listener = $this->_newListener( $config );
        
        foreach ( new ArrayIterator( $this->_list[$phpId][$eventType] ) as $offset => $element ) {
            if ( $element->equals( $listener ) ) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Retrieves the internal event listeners list
     *
     * @return array
     */
    public function getEventListeners()
    {
        return $this->_list;
    }

    /**
     * Clears the event listeners list
     *
     * @param array $criteria
     * @return void
     */
    public function flushEventListeners( Array $criteria = null )
    {
        // if no criteria provided flush all event listeners
        if ( empty( $criteria )
            || (
                is_array( $criteria )
                && !( $phpIdCriteriaProvided = array_key_exists( self::T_FLUSH_PHPID, $criteria ) )
                && !( $eventTypeCriteriaProvided = array_key_exists( self::T_FLUSH_EVENT_TYPE, $criteria ) )
                && !( $groupCriteriaProvided = array_key_exists( self::T_FLUSH_GROUP, $criteria ) )
            )
        )
        {
            return $this->_flushAll();
        }
        
        if ( $phpIdCriteriaProvided ) {
            return $this->_flushByPhpId( $criteria[self::T_FLUSH_PHPID] );
        }
        
        if ( $eventTypeCriteriaProvided ) {
            return $this->_flushByEventType( $criteria[self::T_FLUSH_EVENT_TYPE] );
        }
        
        if ( $groupCriteriaProvided ) {
            return $this->_flushByGroup( $criteria[self::T_FLUSH_GROUP] );
        }
    }

    /**
     * Destructor.
     *
     * Remove any event listeners we have attached
     */
    public function __destruct()
    {
        $this->flushEventListeners();
    }

    /**
     * Does the actual work of adding an event listener to the list
     *
     * @param string $eventType
     * @param Streamwide_Engine_Events_Event_Listener $listener
     * @return boolean
     */
    protected function _addEventListener( $eventType, $listener )
    {
        $listener->setInsertOffset( $this->_nextAvailableListOffset );
        
        $phpId = $listener->getPhpId();
        $this->_list[$phpId][$eventType][$this->_nextAvailableListOffset] = $listener;
        
        if ( count( $this->_list[$phpId][$eventType] ) > 1
            && false === usort( $this->_list[$phpId][$eventType], array( $this, '_compareElements' ) ) )
        {
            $logMessage = 'Unable to sort event listener list by priority. Removing listener';
            Streamwide_Engine_Logger::notice( $logMessage );
            
            unset( $this->_list[$phpId][$eventType][$this->_nextAvailableListOffset] );
            $this->_performListMaintenance( $phpId, $eventType );
            
            return false;
        }
        
        $this->_nextAvailableListOffset++;
        $this->_count++;
        
        $logMessage = 'Added listener "%s" to "%s" event in class "%s"';
        Streamwide_Engine_Logger::debug( sprintf( $logMessage, $listener->getLoggingName(), $eventType, $this->_class ) );
        
        $logMessage = 'The event listeners count for class "%s" is %d';
        Streamwide_Engine_Logger::debug( sprintf( $logMessage, $this->_class, $this->_count ) );
        
        return true;
    }
    
    /**
     * Does the actual work of removing an event listener from the list
     *
     * @param string $eventType
     * @param Streamwide_Engine_Events_Event_Listener $listener
     * @return boolean
     */
    protected function _removeEventListener( $eventType, $listener )
    {
        if ( $this->_count < 1 ) {
            return false;
        }
        
        $phpId = $listener->getPhpId();
        if ( !isset( $this->_list[$phpId][$eventType] ) ) {
            return false;
        }
        
        $found = false;
        foreach ( new ArrayIterator( $this->_list[$phpId][$eventType] ) as $offset => $element ) {
            if ( $element->equals( $listener ) ) {
                unset( $this->_list[$phpId][$eventType][$offset] );
                $this->_count--;
                
                $found = true;
                break;
            }
        }
        
        if ( $found ) {
            $this->_performListMaintenance( $phpId, $eventType );
            
            $logMessage = 'Removed listener "%s" from "%s" event in class "%s"';
            Streamwide_Engine_Logger::debug( sprintf( $logMessage, $listener->getLoggingName(), $eventType, $this->_class ) );
            
            $logMessage = 'The event listeners count for class "%s" is %d';
            Streamwide_Engine_Logger::debug( sprintf( $logMessage, $this->_class, $this->_count ) );
        }
        
        return $found;
    }
    
    /**
     * Comparison function for sorting the event listeners list
     *
     * @param Streamwide_Engine_Events_Event_Listener $a
     * @param Streamwide_Engine_Events_Event_Listener $b
     * @return integer
     */
    protected function _compareElements( Streamwide_Engine_Events_Event_Listener $a, Streamwide_Engine_Events_Event_Listener $b )
    {
        $aPriority = $a->getPriority();
        $bPriority = $b->getPriority();
        
        // Elements with higher priority come first
        $diff = $bPriority - $aPriority;
        
        if ( $diff === 0 ) {
            // if the two elements have the same priority then the order in which they were
            // added to the list takes precedence
            $aInsertOffset = $a->getInsertOffset();
            $bInsertOffset = $b->getInsertOffset();
            
            $diff = $aInsertOffset - $bInsertOffset;
        }
        
        return $diff;
    }
    
    /**
     * Retrieve a instance of a event listener
     *
     * @param array $config
     * @return Streamwide_Engine_Events_Event_Listener
     */
    protected function _newListener( Array $config )
    {
        $config['phpId'] = $this->_registry->get( SW_ENGINE_CURRENT_PHPID );
        
        if ( null !== $this->_createListenerCallback ) {
            return call_user_func( $this->_createListenerCallback, $config );
        }
        
        return Streamwide_Engine_Events_Event_Listener::factory( $config );
    }
    
    /**
     * Flush all event listeners
     *
     * @return void
     */
    protected function _flushAll()
    {
        $this->_list = array();
        $this->_count = 0;
        $this->_nextAvailableListOffset = 0;
        
        $logMessage = 'Flushed ALL event listeners for class "%s"';
        Streamwide_Engine_Logger::debug( sprintf( $logMessage, $this->_class ) );
        
        $logMessage = 'The event listeners count for class "%s" is %d';
        Streamwide_Engine_Logger::debug( sprintf( $logMessage, $this->_class, $this->_count ) );
    }
    
    /**
     * Flush all event listeners from $phpId
     *
     * @param integer $phpId
     * @return void
     */
    protected function _flushByPhpId( $phpId )
    {
        if ( !isset( $this->_list[$phpId] ) ) {
            return;
        }

        $count = 0;
        foreach ( new ArrayIterator( $this->_list[$phpId] ) as $list ) {
            $count += count( $list );
        }
        
        unset( $this->_list[$phpId] );
        $this->_count -= $count;
        
        $logMessage = 'Flushed ALL event listeners for phpId "%d" in class "%s"';
        Streamwide_Engine_Logger::debug( sprintf( $logMessage, $phpId, $this->_class ) );
        
        $logMessage = 'The event listeners count for class "%s" is %d';
        Streamwide_Engine_Logger::debug( sprintf( $logMessage, $this->_class, $this->_count ) );
    }
    
    /**
     * Flush all event listeners attached to $eventType in the current php id
     *
     * @param string $eventType
     * @return void
     */
    protected function _flushByEventType( $eventType )
    {
        $phpId = $this->_registry->get( SW_ENGINE_CURRENT_PHPID );
        if ( null === $phpId ) {
            return;
        }
        
        if ( !isset( $this->_list[$phpId][$eventType] ) ) {
            return;
        }
        
        $count = count( $this->_list[$phpId][$eventType] );
        
        unset( $this->_list[$phpId][$eventType] );
        if ( count( $this->_list[$phpId] ) === 0 ) {
            unset( $this->_list[$phpId] );
        }
        
        $this->_count -= $count;
        
        $logMessage = 'Flushed ALL event listeners for event "%s" in the current phpId ("%d") in class "%s"';
        Streamwide_Engine_Logger::debug( sprintf( $logMessage, $eventType, $phpId, $this->_class ) );
        
        $logMessage = 'The event listeners count for class "%s" is %d';
        Streamwide_Engine_Logger::debug( sprintf( $logMessage, $this->_class, $this->_count ) );
    }
    
    /**
     * Flush the listeners belonging to $groupName in the current php id
     *
     * @param string $groupName
     * @return void
     */
    protected function _flushByGroup( $groupName )
    {
        $phpId = $this->_registry->get( SW_ENGINE_CURRENT_PHPID );
        if ( null === $phpId ) {
            return;
        }

        if ( !isset( $this->_list[$phpId] ) ) {
            return;
        }
        
        foreach ( $this->_list[$phpId] as $eventType => $listeners ) {
            foreach ( $listeners as $offset => $listener ) {
                if ( $listener->getGroup() === $groupName ) {
                    if ( isset( $currentEventType ) && $currentEventType !== $eventType ) {
                        if ( count( $this->_list[$phpId][$currentEventType] ) === 0 ) {
                            unset( $this->_list[$phpId][$currentEventType] );
                        }
                    }
                    
                    unset( $this->_list[$phpId][$eventType][$offset] );
                    $this->_count--;
                    
                    $currentEventType = $eventType;
                }
            }
        }
        
        if ( isset( $currentEventType ) ) {
            $this->_performListMaintenance( $phpId, $currentEventType );
        }
        
        $logMessage = 'Flushed ALL event listeners belonging to group "%s" in the current phpId ("%d") in class "%s"';
        Streamwide_Engine_Logger::debug( sprintf( $logMessage, $groupName, $phpId, $this->_class ) );
        
        $logMessage = 'The event listeners count for class "%s" is %d';
        Streamwide_Engine_Logger::debug( sprintf( $logMessage, $this->_class, $this->_count ) );
    }
    
    /**
     * Remove any empty arrays from the list
     *
     * @param integer $phpId
     * @param string $eventType
     */
    protected function _performListMaintenance( $phpId, $eventType ) {
        if ( count( $this->_list[$phpId][$eventType] ) === 0 ) {
            unset( $this->_list[$phpId][$eventType] );
            if ( count( $this->_list[$phpId] ) === 0 ) {
                unset( $this->_list[$phpId] );
            }
        }
    }
    
}

/* EOF */