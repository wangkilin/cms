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
 * Allows repeated execution of a task
 */
class Streamwide_Engine_Timer_Interval extends Streamwide_Engine_Widget
{

    /**
     * States for this widget
     */
    const STATE_READY = 'READY';
    const STATE_RUNNING = 'RUNNING';

    /**
     * Option names
     */
    const OPT_INTERVAL = 'interval';
    const OPT_COUNT = 'count';

    /**
     * Default values for options
     */
    const DEFAULT_COUNT = 0;

    /**
     * Error codes
     */
    const ALREADY_RUNNING_ERR_CODE = 'INTERVALTIMER-200';
    const ALREADY_STOPPED_ERR_CODE = 'INTERVALTIMER-201';

    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::ERROR,
        Streamwide_Engine_Events_Event::RUNNING,
        Streamwide_Engine_Events_Event::STOPPED,
        Streamwide_Engine_Events_Event::FINISHED,
        Streamwide_Engine_Events_Event::STEP
    );
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::ALREADY_RUNNING_ERR_CODE => 'Interval timer already running',
        self::ALREADY_STOPPED_ERR_CODE => 'Interval timer already stopped'
    );

    /**
     * Timer widget
     *
     * @var Streamwide_Engine_Timer_Timeout
     */
    protected $_timeoutTimer;

    /**
     * Holds the current count
     *
     * @var integer
     */
    protected $_currentCount;

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
        if ( isset( $this->_timeoutTimer ) ) {
            $this->_timeoutTimer->destroy();
            unset( $this->_timeoutTimer );
        }
        
        parent::destroy();
    }

    /**
     * Provide options default values
     *
     * @param mixed $options
     * @return void
     */
    public function setOptions( Array $options )
    {
        $interval = isset( $options[self::OPT_INTERVAL] ) ? $options[self::OPT_INTERVAL] : null;
        $this->_treatIntervalOption( $interval );

        $count = isset( $options[self::OPT_COUNT] ) ? $options[self::OPT_COUNT] : null;
        $this->_treatCountOption( $count );
    }

    /**
     * Set the timer used by this widget
     *
     * @param Streamwide_Engine_Timer_Timeout $timer
     * @return void
     */
    public function setTimeoutTimer( Streamwide_Engine_Timer_Timeout $timeoutTimer )
    {
        $this->_timeoutTimer = $timeoutTimer;
        $this->_timeoutTimer->reset();
    }
    
    /**
     * Retrieve the timeout timer widget
     *
     * @return Streamwide_Engine_Timer_Timeout|null
     */
    public function getTimeoutTimer()
    {
        return $this->_timeoutTimer;
    }

    /**
     * Start the interval timer
     *
     * @return boolean
     */
    public function start()
    {
        if ( $this->isRunning() ) {
            $this->dispatchErrorEvent( self::ALREADY_RUNNING_ERR_CODE );
            return false;
        }

        $interval = $this->_options[self::OPT_INTERVAL];
        $this->_timeoutTimer->setOptions( array( Streamwide_Engine_Timer_Timeout::OPT_DELAY => $interval ) );
        $this->_timeoutTimer->addEventListener(
            Streamwide_Engine_Events_Event::TIMEOUT,
            array( 'callback' => array( $this, 'onTimeout' ) )
        );
        $armed = $this->_timeoutTimer->arm();
        
        if ( !$armed ) {
            $this->_timeoutTimer->flushEventListeners();
            return false;
        }

        // mark the widget as running
        $this->_stateManager->setState( self::STATE_RUNNING );

        // dispatch a INTERVAL_TIMER_RUNNING event
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::RUNNING ) );

        return true;
    }

    /**
     * Handle the TIMER_TIMEOUT event
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onTimeout( Streamwide_Engine_Events_Event $event )
    {
        $count = $this->_options[self::OPT_COUNT];
        if ( null === $this->_currentCount ) {
        	$this->_currentCount = $count;
        }
        if ( 0 === $count || --$this->_currentCount > 0 ) {
            $this->_timeoutTimer->arm();
            $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::STEP ) );
        } else {
            $this->stop();
        }
    }

    /**
     * Stop the interval timer
     *
     * @return boolean
     */
    public function stop()
    {
        if ( !$this->isRunning() ) {
            $this->dispatchErrorEvent( self::ALREADY_STOPPED_ERR_CODE );
            return false;
        }

        // reset the timer
        $this->_timeoutTimer->reset();

        // mark the widget as READY
        $this->_stateManager->setState( self::STATE_READY );

        // dispatch a INTERVAL_TIMER_STOPPED
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::STOPPED ) );

        return true;
    }

    /**
     * Reset the widget
     *
     * @return void
     */
    public function reset()
    {
        parent::reset();
        
        $this->_currentCount = null;
        if ( $this->isRunning() ) {
            $this->stop();
        }
    }

    /**
     * Is the interval timer ready?
     *
     * @return boolean
     */
    public function isReady()
    {
        return ( $this->_stateManager->getState() === self::STATE_READY );
    }

    /**
     * Is the interval timer running?
     *
     * @return boolean
     */
    public function isRunning()
    {
        return ( $this->_stateManager->getState() === self::STATE_RUNNING );
    }

    /**
     * Treat the "interval" option
     *
     * @param mixed $interval
     * @return void
     */
    protected function _treatIntervalOption( $interval = null )
    {
        if ( null === $interval ) {
            throw new Exception( sprintf( 'Required option "%s" was not provided', self::OPT_INTERVAL ) );
        }

        if ( is_int( $interval ) ) {
            $interval = (float)$interval;
        } elseif (  is_string( $interval ) && preg_match( '~^(?:0|[1-9][0-9]*)(?:\.[0-9]+)?$~', $interval ) === 1 ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to float', self::OPT_INTERVAL ) );
            $interval = (float)$interval;
        }

        if ( !is_float( $interval ) ) {
            throw new Exception( sprintf( 'Invalid value provided for "%s" option', self::OPT_INTERVAL ) );
        } else {
            $this->_options[self::OPT_INTERVAL] = round( $interval, 3 );
        }
    }

    /**
     * Treat the "count" option
     *
     * @param mixed $count
     * @return void
     */
    protected function _treatCountOption( $count = null )
    {
        if ( null === $count ) {
            return null;
        }

        if ( is_float( $count ) || ( is_string( $count ) && preg_match( '~^[1-9][0-9]*$~', $count ) === 1 ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to integer', self::OPT_COUNT ) );
            $count = (int)$count;
        }

        if ( is_int( $count ) && $count > 0 ) {
            $this->_options[self::OPT_COUNT] = $count;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_COUNT ) );
        }
    }

    /**
     * Initialize default options
     *
     * @return void
     */
    protected function _initDefaultOptions()
    {
        $this->_options[self::OPT_COUNT] = self::DEFAULT_COUNT;
    }

}

/* EOF */
