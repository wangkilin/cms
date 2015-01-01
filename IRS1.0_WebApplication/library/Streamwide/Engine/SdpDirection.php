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
 * Widget that allows to wait for a new SDP direction if the current SDP direction
 * is not appropriate
 */
class Streamwide_Engine_SdpDirection extends Streamwide_Engine_Widget
{
    
    /**
     * SDP direction types
     */
    const DIRECTION_INACTIVE = 'inactive';
    const DIRECTION_SENDRECV = 'sendrecv';
    const DIRECTION_SENDONLY = 'sendonly';
    const DIRECTION_RECVONLY = 'recvonly';

    /**
     * Error codes
     */
    const NEW_DIRECTION_TIMEOUT_ERR_CODE = 'SDPDIRECTION-200';
    
    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::NEW_DIRECTION,
        Streamwide_Engine_Events_Event::ERROR
    );
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::NEW_DIRECTION_TIMEOUT_ERR_CODE => 'No new SDP direction received'
    );
    
    /**
     * A timer to be used for measuring the amount of time to wait for a new SDP direction
     *
     * @var Streamwide_Engine_Timer_Timeout
     */
    protected $_timer;
    
    /**
     * A (started) relayer object
     *
     * @var Streamwide_Engine_Automatic_Signal_Relayer
     */
    protected $_relayer;
    
    /**
     * List of directions that will be considered as "new"
     *
     *
     * @var array
     */
    protected $_allowedNewDirections = array(
        self::DIRECTION_SENDONLY,
        self::DIRECTION_SENDRECV
    );
    
    /**
     * Destructor
     */
    public function destroy()
    {
        if ( isset( $this->_timer ) ) {
            $this->_timer->destroy();
            unset( $this->_timer );
        }
        
        if ( isset( $this->_relayer ) ) {
            $this->_relayer->destroy();
            unset( $this->_relayer );
        }
        
        parent::destroy();
    }
    
    /**
     * Set the timer to use for measuring the amount of time to wait for a new SDP direction
     *
     * @param Streamwide_Engine_Timer_Timeout $timer
     * @return void
     */
    public function setTimer( Streamwide_Engine_Timer_Timeout $timer )
    {
        $this->_timer = $timer;
    }
    
    /**
     * Retrieve the timer widget
     *
     * @return Streamwide_Engine_Timer_Timeout|null
     */
    public function getTimer()
    {
        return $this->_timer;
    }
    
    /**
     * Set the relayer to listen to for a new SDP direction
     *
     * @param Streamwide_Engine_Automatic_Signal_Relayer $relayer
     * @return void
     */
    public function setRelayer( Streamwide_Engine_Automatic_Signal_Relayer $relayer )
    {
        $this->_relayer = $relayer;
    }
    
    /**
     * Retrieve the relayer widget
     *
     * @return Streamwide_Engine_Automatic_Signal_Relayer|null
     */
    public function getRelayer()
    {
        return $this->_relayer;
    }
    
    /**
     * Set the allowed new directions
     *
     * @param string|array $allowedNewDirections
     * @return void
     */
    public function setAllowedNewDirections( $allowedNewDirections )
    {
        if ( !is_array( $allowedNewDirections ) ) {
            $allowedNewDirections = array( $allowedNewDirections );
        }
        
        $this->_allowedNewDirections = $allowedNewDirections;
    }
    
    /**
     * Wait for a new direction
     *
     * @param float|integer $time
     * @return boolean
     */
    public function waitNewDirection( $time )
    {
        if ( false === $this->_startRelayer() ) {
            return false;
        }
        
        return $this->_armTimer( $time );
    }
    
    /**
     * Deal with the timeout (dispatch an error event)
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onTimeout( Streamwide_Engine_Events_Event $event )
    {
        $this->_relayer->removeEventListener(
            Streamwide_Engine_Events_Event::SIGNAL_RELAYED,
            array( 'callback' => array( $this, 'onSignalRelayed' ) )
        );
        
        return $this->dispatchErrorEvent( self::NEW_DIRECTION_TIMEOUT_ERR_CODE );
    }
    
    /**
     * Check if the relayed signal is the signal that interests us (OKMOVED).
     * If so, check its direction parameter and dispatch an event if we found
     * what we are looking for
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onSignalRelayed( Streamwide_Engine_Events_Event $event )
    {
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::NEW_DIRECTION );
        return $this->dispatchEvent( $event );
    }
    
    /**
     * Arm the timer
     *
     * @param float|integer $delay
     * @return boolean
     */
    protected function _armTimer( $delay )
    {
        $this->_timer->reset();
        $this->_timer->setOptions( array( Streamwide_Engine_Timer_Timeout::OPT_DELAY => $delay ) );
        $this->_timer->addEventListener(
            Streamwide_Engine_Events_Event::TIMEOUT,
            array(
                'callback' => array( $this, 'onTimeout' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        
        $armed = $this->_timer->arm();
        if ( !$armed ) {
            $this->_timer->flushEventListeners();
        }
        
        return $armed;
    }
    
    /**
     * Starts the relayer if it is not started
     *
     * @return boolean
     */
    protected function _startRelayer()
    {
        // Notify filter that is satisfied by an event object that has an OKMOVED signal
        // and that has a "from" parameter that is an instance of Streamwide_Engine_Media_Server_Call_Leg.
        // The OKMOVED signal has to have a "direction" parameter with a value that is present in the
        // _allowedNewDirections property
        $notifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_NAME,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            Streamwide_Engine_Signal::OKMOVED
        )->logicalAnd(
            Streamwide_Engine_NotifyFilter_Factory::factory(
                Streamwide_Engine_NotifyFilter_Factory::T_EVT_PARAM,
                Streamwide_Engine_NotifyFilter_Factory::FILTER_INSTANCE_OF,
                array( 'from', 'Streamwide_Engine_Media_Server_Call_Leg' )
            )
        )->logicalAnd(
            Streamwide_Engine_NotifyFilter_Factory::factory(
                Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_PARAM,
                Streamwide_Engine_NotifyFilter_Factory::FILTER_IN_ARRAY,
                array( 'direction', $this->_allowedNewDirections )
            )
        );
        
        $this->_relayer->addEventListener(
            Streamwide_Engine_Events_Event::SIGNAL_RELAYED,
            array(
                'callback' => array( $this, 'onSignalRelayed' ),
                'options' => array(
                    'notifyFilter' => $notifyFilter,
                    'autoRemove' => 'before'
                )
            )
        );
        
        if ( !$this->_relayer->isRunning() ) {
            $started = $this->_relayer->start();
            if ( !$started ) {
                $this->_relayer->removeEventListener(
                    Streamwide_Engine_Events_Event::SIGNAL_RELAYED,
                    array( 'callback' => array( $this, 'onSignalRelayed' ) )
                );
                return false;
            }
        }

        return true;
    }
    
}
 
/* EOF */
