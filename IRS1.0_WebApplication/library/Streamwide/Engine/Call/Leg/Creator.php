<?php
/**
 *
 * $Rev: 2560 $
 * $LastChangedDate: 2010-04-23 15:49:53 +0800 (Fri, 23 Apr 2010) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Package
 * @subpackage SubPackage
 * @version 1.0
 *
 */

abstract class Streamwide_Engine_Call_Leg_Creator extends Streamwide_Engine_Widget
{

    /**
     * The call leg that will be created
     *
     * @var Streamwide_Engine_Call_Leg_Abstract
     */
    protected $_callLeg;
    
    /**
     * Parameters for the CREATE signal
     *
     * @var array
     */
    protected $_creationParams = array();
    
    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::CALL_LEG_CREATED,
        Streamwide_Engine_Events_Event::ERROR
    );

    /**
     * Destructor
     *
     * @return void
     */
    public function destroy()
    {
        if ( isset( $this->_callLeg ) ) {
            unset( $this->_callLeg );
        }
        
        parent::destroy();
    }
    
    /**
     * @param Streamwide_Engine_Call_Leg_Abstract $callLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setCallLeg( Streamwide_Engine_Call_Leg_Abstract $callLeg )
    {
        if ( $callLeg->isAlive() ) {
            throw new InvalidArgumentException( get_class( $this ) . '::' . __FUNCTION__ . ' expects parameter 1 to be a dead call leg' );
        }
        
        $this->_callLeg = $callLeg;
    }
    
    /**
     * @return Streamwide_Engine_Call_Leg_Abstract
     */
    public function getCallLeg()
    {
        return $this->_callLeg;
    }
    
    /**
     * Set the creation parameters
     *
     * @param array $creationParams
     * @return void
     */
    public function setCreationParams( Array $creationParams )
    {
        if ( empty( $creationParams ) ) {
            return;
        }
        
        $r = new ReflectionObject( $this );
        $class = $r->getName();
        $constants = $r->getConstants();
        
        $parameterConstants = array_filter( array_keys( $constants ), array( $this, '_getParameterConstants' ) );
        
        $supportedParameters = array();
        for ( $i = 0, $n = count( $parameterConstants ); $i < $n; $i++ ) {
            $constant = $parameterConstants[$i];
            $supportedParameters[] = constant( $class . '::' . $constant );
        }
        
        if ( empty( $supportedParameters ) ) {
            return;
        }
        
        foreach ( $creationParams as $param => $value ) {
            if ( in_array( $param, $supportedParameters ) ) {
                $method = 'set' . ucfirst( $param );
                if ( method_exists( $this, $method ) ) {
                    $this->$method( $value );
                }
            }
        }
    }
    
    /**
     * Get the creation parameters
     *
     * @return array
     */
    public function getCreationParams()
    {
        return $this->_creationParams;
    }
    
    /**
     * Initialize the creation process
     *
     * @param string $errorCode
     * @return boolean
     */
    public function create( $errorCode )
    {
        $create = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::CREATE,
            $this->_callLeg->getName(),
            $this->_normalizeCreationParams()
        );
        
        if ( false === $create->send() ) {
            $this->dispatchErrorEvent( $errorCode );
            return false;
        }
        
        $this->_subscribeToEngineEvents();
        return true;
    }
    
    /**
     * Callback. Delegates to appropriate internal methods depending on the
     * received event
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onSignalReceived( Streamwide_Engine_Events_Event $event )
    {
        $eventType = $event->getEventType();
        $signal = $event->getParam( 'signal' );
        
        switch ( $eventType ) {
            case Streamwide_Engine_Events_Event::OK:
                return $this->_handleOkSignal( $signal );
            case Streamwide_Engine_Events_Event::FAIL:
                return $this->_handleFailSignal( $signal );
            case Streamwide_Engine_Events_Event::CHILD:
                return $this->_handleChildSignal( $signal );
        }
        
    }
    
    /**
     * Handle the OK signal. The call leg was created successfully. Mark the
     * call leg as alive and set its params. Dispatch a CALL_LEG_CREATED event
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleOkSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();
        
        $this->_callLeg->setAlive();
        $this->_callLeg->hasSentOrReceivedOk();
        $this->_callLeg->setParams( array_merge( $signal->getParams(), $this->_creationParams ) );
        
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::CALL_LEG_CREATED );
        $event->setParam( 'callLeg', $this->_callLeg );
        $this->dispatchEvent( $event );
    }
    
    /**
     * Handle FAIL signal. The call leg was not created. We need to dispatch an error
     * event.
     *
     * @param Streamwide_Engine_Signal $signal
     * @param string $errorCode
     * @return void
     */
    protected function _handleFailSignal( Streamwide_Engine_Signal $signal, $errorCode )
    {
        $this->_unsubscribeFromEngineEvents();
        
        $this->_callLeg->setDead();
        
        $params = $signal->getParams();
        $failureCode = isset( $params['code'] ) ? $params['code'] : null;
        
        $this->dispatchErrorEvent(
            $errorCode,
            array(
                'failureCode' => $failureCode,
                'signal' => $signal
            )
        );
    }
    
    /**
     * Handle CHILD signal. The call leg has died. We need to dispatch an error event
     *
     * @param Streamwide_Engine_Signal $signal
     * @param string $errorCode
     * @return void
     */
    protected function _handleChildSignal( Streamwide_Engine_Signal $signal, $errorCode )
    {
        $this->_unsubscribeFromEngineEvents();
        
        $this->_callLeg->setDead();
        
        return $this->dispatchErrorEvent(
            $errorCode,
            array( 'callLeg' => $this->_callLeg )
        );
    }
    
    /**
     * Method to filter out all class constants that do not start with "PARAM_"
     *
     * @param string $const
     * @return boolean
     */
    protected function _getParameterConstants( $const )
    {
        return ( strpos( $const, 'PARAM_' ) === 0 );
    }
    
    /**
     * Apply any normalizations, if needed, to the creation parameters
     *
     * @return array
     */
    protected function _normalizeCreationParams()
    {
        return $this->_creationParams;
    }
    
    /**
     * Determines if $param has been set in the parameters list
     *
     * @param string $param
     * @return boolean
     */
    protected function _isParameterSet( $param )
    {
        return isset( $this->_creationParams[(string)$param] );
    }
    
    /**
     * Subscribe to be notified on OK, FAIL and CHILD signals from SW Engine
     *
     * @return void
     */
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        
        // Start listen to OK signal
        $okNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_callLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::OK,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $okNotifyFilter
                )
            )
        );
        // End listen to OK signal
        
        // Start listen to FAIL signal
        $failNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_callLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::FAIL,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $failNotifyFilter
                )
            )
        );
        // End listen to FAIL signal
        
        // Start listen to CHILD signal
        $childNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_callLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::CHILD,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array( 'notifyFilter' => $childNotifyFilter )
            )
        );
        // Start listen to CHILD signal
    }
    
    /**
     * Unsubscribe from OK, FAIL and CHILD signals from SW Engine
     *
     * @return void
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $callback = array( 'callback' => array( $this, 'onSignalReceived' ) );
        
        $events = array(
            Streamwide_Engine_Events_Event::OK,
            Streamwide_Engine_Events_Event::FAIL,
            Streamwide_Engine_Events_Event::CHILD
        );
        
        $controller = $this->getController();
        foreach ( $events as $event ) {
            $controller->removeEventListener( $event, $callback );
        }
    }
    
}
 
/* EOF */