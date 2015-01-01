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
 * Allows receiving of a notification after a certain amount of time
 * has elapsed
 */
class Streamwide_Engine_Timer_Timeout extends Streamwide_Engine_Widget
{

    /**
     * States for this object
     */
    const STATE_READY = 'READY';
    const STATE_ARMED = 'ARMED';

    /**
     * Option names
     */
    const OPT_DELAY = 'delay';

    /**
     * Remote param name for sending ARM, DISARM, REARM signals
     */
    const REMOTE_NAME = 'root';

    /**
     * Error codes constants
     *
     * TIMEOUTTIMER-1xx refer to errors in sending signals to the SW engine
     * TIMEOUTTIMER-2xx refer to internal timer errors
     * TIMEOUTTIMER-3xx refer to timer state errors
     */
    const ARM_SIGNAL_SEND_FAILURE_ERR_CODE = 'TIMEOUTTIMER-100';
    const REARM_SIGNAL_SEND_FAILURE_ERR_CODE = 'TIMEOUTTIMER-101';
    const DISARM_SIGNAL_SEND_FAILURE_ERR_CODE = 'TIMEOUTTIMER-102';
    const NOT_ARMED_ERR_CODE = 'TIMEOUTTIMER-300';
    const ALREADY_ARMED_ERR_CODE = 'TIMEOUTTIMER-301';

    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::ERROR,
        Streamwide_Engine_Events_Event::ARMED,
        Streamwide_Engine_Events_Event::DISARMED,
        Streamwide_Engine_Events_Event::REARMED,
        Streamwide_Engine_Events_Event::TIMEOUT
    );
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::ARM_SIGNAL_SEND_FAILURE_ERR_CODE => 'Sending of signal ARM failed',
        self::REARM_SIGNAL_SEND_FAILURE_ERR_CODE => 'Sending of signal REARM failed',
        self::DISARM_SIGNAL_SEND_FAILURE_ERR_CODE => 'Sending of signal DISARM failed',
        self::NOT_ARMED_ERR_CODE => 'Timeout timer not armed',
        self::ALREADY_ARMED_ERR_CODE => 'Timeout timer already armed'
    );

    /**
     * The name of the timer
     *
     * @var string
     */
    protected $_name;
    
    /**
     * Flag to indicate if the name of the timer has already been regenerated
     *
     * @var boolean
     */
    protected $_nameGenerated = false;

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
                    self::STATE_ARMED
                )
            )
        );
        $this->_generateName();
    }

    /**
     * Provide options default values
     *
     * @param mixed $options
     * @return void
     */
    public function setOptions( Array $options )
    {
        $delay = isset( $options[self::OPT_DELAY] ) ? $options[self::OPT_DELAY] : null;
        $options[self::OPT_DELAY] = $this->_treatDelayOption( $delay );
    }

    /**
     * Retrieves the name of the timer
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Is the timer armed?
     *
     * @return boolean
     */
    public function isArmed()
    {
        return ( $this->_stateManager->getState() === self::STATE_ARMED );
    }

    /**
     * Is the timer ready?
     *
     * @return boolean
     */
    public function isReady()
    {
        return ( $this->_stateManager->getState() === self::STATE_READY );
    }

    /**
     * Arm the timer
     *
     * @return boolean
     */
    public function arm()
    {
        if ( $this->isArmed() ) {
            $this->dispatchErrorEvent( self::ALREADY_ARMED_ERR_CODE );
            return false;
        }

        // get the provided delay
        $delay = $this->_options[self::OPT_DELAY];
        // regenerate the timer name
        $this->_generateName();

        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::ARM,
            self::REMOTE_NAME,
            array(
                'time' => $delay,
                'reference' => $this->_name
            )
        );
        
        // send the ARM signal
        $ret = $signal->send();

        // dispatch an ERROR event if the signal could not be sent
        if ( false === $ret ) {
            $this->dispatchErrorEvent( self::ARM_SIGNAL_SEND_FAILURE_ERR_CODE );
            return $ret;
        }

        // subscribe to the TIMEOUT event
        $this->_subscribeToEngineEvents();

        // mark the timer as being armed
        $this->_stateManager->setState( self::STATE_ARMED );
        // dispatch a TIMEOUT_TIMER_ARMED event
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::ARMED ) );
        return $ret;
    }

    /**
     * Rearm the timer
     *
     * @param integer|null $newDelay
     * @return boolean
     */
    public function rearm( $newDelay = null )
    {
        if ( !$this->isArmed() ) {
            $this->dispatchErrorEvent( self::NOT_ARMED_ERR_CODE );
            return false;
        }

        if ( is_int( $newDelay ) || ( is_string( $newDelay ) && preg_match( '~^(?:0|[1-9][0-9]*)(?:\.[0-9]+)?$~', $newDelay ) === 1 ) ) {
            $newDelay = (float)$newDelay;
        }

        if ( is_float( $newDelay ) ) {
            $this->_options[self::OPT_DELAY] = round( $newDelay, 3 );
        }

        // retrieve the provided delay (this will be either a new value if provided and valid
        // or the old delay value)
        $delay = $this->_options[self::OPT_DELAY];

        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::REARM,
            self::REMOTE_NAME,
            array(
                'time' => $delay,
                'reference' => $this->_name
            )
        );
        
        // send the REARM signal
        $ret = $signal->send();

        // dispatch an ERROR event and exit if the signal could not be sent
        if ( false === $ret ) {
            $this->dispatchErrorEvent( self::REARM_SIGNAL_SEND_FAILURE_ERR_CODE );
            return $ret;
        }

        // if all OK dispatch an TIMEOUT_TIMER_REARMED event
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::REARMED ) );
        return $ret;
    }

    /**
     * Disarm the timer
     *
     * @return boolean
     */
    public function disarm()
    {
        if ( !$this->isArmed() ) {
            $this->dispatchErrorEvent( self::NOT_ARMED_ERR_CODE );
            return false;
        }

        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::DISARM,
            self::REMOTE_NAME,
            array( 'reference' => $this->_name )
        );
        
        // send the DISARM signal
        $ret = $signal->send();

        // dispatch an ERROR event and exit if the signal could not be sent
        if ( false === $ret ) {
            $this->dispatchErrorEvent( self::DISARM_SIGNAL_SEND_FAILURE_ERR_CODE );
            return $ret;
        }

        // unsubscribe from the SIGNAL_IN_TIMEOUT event
        $this->_unsubscribeFromEngineEvents();

        // mark the timer as READY
        $this->_stateManager->setState( self::STATE_READY );
        // lower the flag so, that the next call to arm() will
        // generate a new name
        $this->_nameGenerated = false;

        // dispatch an TIMEOUT_TIMER_DISARMED event
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::DISARMED ) );
        return $ret;
    }

    /**
     * Callback to respond to the TIMEOUT SW Engine signal
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onTimeout( Streamwide_Engine_Events_Event $event )
    {
        if ( !$this->isArmed() ) {
            return $this->dispatchErrorEvent( self::ALREADY_ARMED_ERR_CODE );
        }

        // mark the timer as READY
        $this->_stateManager->setState( self::STATE_READY );
        // lower the flag so, that the next call to arm() will
        // generate a new name
        $this->_nameGenerated = false;

        // dispatch a TIMEOUT_TIMER_TIMEOUT event
        $signal = $event->getParam( 'signal' );
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::TIMEOUT );
        $event->setParam( 'signal', $signal );
        $this->dispatchEvent( $event );
    }

    /**
     * Resets the timer to the initial state
     *
     * @return void
     */
    public function reset()
    {
        parent::reset();
        
        if ( $this->isArmed() ) {
            $this->disarm();
        }
    }

    /**
     * Generate the timer's name
     *
     * @return void
     */
    protected function _generateName()
    {
        if ( false === $this->_nameGenerated ) {
            $this->_name = md5( sprintf( 'TIMEOUTTIMER:%s', uniqid() ) );
            $this->_nameGenerated = true;
        }
    }
    
    /**
     * Subscribe to TIMEOUT signal from SW Engine
     *
     * @see Engine/Streamwide_Engine_Widget#_subscribeToEngineEvents()
     * @return void
     */
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        
        $timeoutNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_PARAM,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            array( 'reference', $this->_name )
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::TIMEOUT,
            array(
                'callback' => array( $this, 'onTimeout' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $timeoutNotifyFilter
                )
            )
        );
    }
    
    /**
     * Unsubscribe from the TIMEOUT signal from SW Engine
     *
     * @see Engine/Streamwide_Engine_Widget#_unsubscribeFromEngineEvents()
     * @return void
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $controller = $this->getController();
        $controller->removeEventListener(
            Streamwide_Engine_Events_Event::TIMEOUT,
            array( 'callback' => array( $this, 'onTimeout' ) )
        );
    }

    /**
     * Treats the delay option
     *
     * @param mixed $delay
     * @return void
     * @throws Exception
     */
    protected function _treatDelayOption( $delay = null )
    {
        if ( null === $delay ) {
            throw new Exception( sprintf( 'Required option "%s" was not provided', self::OPT_DELAY ) );
        }

        if ( is_int( $delay ) ) {
            $delay = (float)$delay;
        } elseif ( is_string( $delay ) && preg_match( '~^(?:0|[1-9][0-9]*)(?:\.[0-9]+)?$~', $delay ) === 1 ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to float', self::OPT_DELAY ) );
            $delay = (float)$delay;
        }

        if ( !is_float( $delay ) ) {
            throw new Exception( sprintf( 'Invalid value provided for "%s" option', self::OPT_DELAY ) );
        } else {
            $this->_options[self::OPT_DELAY] = round( $delay, 3 );
        }
    }

}

/* EOF */