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
 * @subpackage Streamwide_Engine_Call_Leg_Connector
 * @version 1.0
 *
 */

class Streamwide_Engine_Call_Leg_Connector_ForcedFaxNegotiator extends Streamwide_Engine_Call_Leg_Connector
{

    /**
     * Error codes
     */
    const MOVED_SIGNAL_SEND_ERR_CODE = 'FORCEDFAXNEGOTIATOR-100';
    const FAILMOVED_SIGNAL_SEND_ERR_CODE = 'FORCEDFAXNEGOTIATOR-101';
    const OKSDP_SIGNAL_SEND_ERR_CODE = 'FORCEDFAXNEGOTIATOR-102';
    const FAILSDP_SIGNAL_SEND_ERR_CODE = 'FORCEDFAXNEGOTIATOR-103';
    const OKSDP_SIGNAL_RELAY_ERR_CODE = 'FORCEDFAXNEGOTIATOR-104';
    const OKMOVED_SIGNAL_RELAY_ERR_CODE = 'FORCEDFAXNEGOTIATOR-105';
    const FAX_ENV_NOT_CREATED_ERR_CODE = 'FORCEDFAXNEGOTIATOR-200';
    const CALL_LEG_DIED_ERR_CODE = 'FORCEDFAXNEGOTIATOR-201';
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::MOVED_SIGNAL_SEND_ERR_CODE => 'Unable to send MOVED signal to SW Engine',
        self::FAILMOVED_SIGNAL_SEND_ERR_CODE => 'Unable to send FAILMOVED signal to SW Engine',
        self::OKSDP_SIGNAL_SEND_ERR_CODE => 'Unable to send OKSDP signal to SW Engine',
        self::FAILSDP_SIGNAL_SEND_ERR_CODE => 'Unable to send FAILSDP signal to SW Engine',
        self::OKSDP_SIGNAL_RELAY_ERR_CODE => 'Unable to relay the OKSDP signal to the SIP call leg',
        self::OKMOVED_SIGNAL_RELAY_ERR_CODE => 'Unable to relay the OKMOVED signal to the SIP call leg',
        self::FAX_ENV_NOT_CREATED_ERR_CODE => 'Fax environment could not be created',
        self::CALL_LEG_DIED_ERR_CODE => 'One of the call legs involved in the connection process has died (CHILD signal received)',
    );
    
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_type = self::CONNECTOR_SIPMS;
    }
    
    /**
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Connexant#connect()
     */
    public function connect()
    {
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::MOVED,
            $this->_rightCallLeg->getName(),
            array( 'policy' => 'image' )
        );
        
        if ( false === $signal->send() ) {
            $this->dispatchErrorEvent( self::MOVED_SIGNAL_SEND_ERR_CODE );
            return false;
        }
        
        $this->_subscribeToEngineEvents();
        return true;
    }

    /**
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Connexant#onSignalReceived()
     */
    public function onSignalReceived( Streamwide_Engine_Events_Event $event )
    {
        $eventType = $event->getEventType();
        $signal = $event->getParam( 'signal' );
        
        switch ( $eventType ) {
            case Streamwide_Engine_Events_Event::MOVED:
                return $this->_handleMovedSignal( $signal );
            case Streamwide_Engine_Events_Event::SDP:
                return $this->_handleSdpSignal( $signal );
            case Streamwide_Engine_Events_Event::OKMOVED:
                return $this->_handleOkMovedSignal( $signal );
            case Streamwide_Engine_Events_Event::FAILMOVED:
                return $this->_handleFailMovedSignal( $signal );
            case Streamwide_Engine_Events_Event::CHILD:
                return $this->_handleChildSignal( $signal );
        }
        
        return null;
    }

    /**
     * Setter for the _leftCallLeg property
     *
     * @param Streamwide_Engine_Call_Leg_Abstract $leftCallLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setLeftCallLeg( Streamwide_Engine_Call_Leg_Abstract $leftCallLeg )
    {
        if ( !$leftCallLeg instanceof Streamwide_Engine_Sip_Call_Leg ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an instance of Streamwide_Engine_Sip_Call_Leg' );
        }
        if ( !$leftCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive SIP call leg' );
        }
        parent::setLeftCallLeg( $leftCallLeg );
    }
    
    /**
     * Setter for the _rightCallLeg property
     *
     * @param Streamwide_Engine_Call_Leg_Abstract $rightCallLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setRightCallLeg( Streamwide_Engine_Call_Leg_Abstract $rightCallLeg )
    {
        if ( !$rightCallLeg instanceof Streamwide_Engine_Media_Server_Call_Leg ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an instance of Streamwide_Engine_Media_Server_Call_Leg' );
        }
        if ( !$rightCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive MS call leg' );
        }
        parent::setRightCallLeg( $rightCallLeg );
    }
    
    /**
     * We have send a MOVED with policy image to the MS call leg, but we can receive a
     * MOVED signal from the SIP call leg in which case we need to reply with FAILMOVED
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $failMovedSignal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::FAILMOVED,
            $this->_leftCallLeg->getName(),
            array( 'code' => '488' )
        );
        if ( false === $failMovedSignal->send() ) {
            return $this->dispatchErrorEvent( self::FAILMOVED_SIGNAL_SEND_ERR_CODE );
        }
    }
    
    /**
     * We have received SDP signal from the MS call leg, we need to send a MOVED
     * signal to the SIP call leg
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleSdpSignal( Streamwide_Engine_Signal $signal )
    {
        $movedSignal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::MOVED,
            $this->_leftCallLeg->getName(),
            $signal->getParams()
        );
        
        if ( false === $movedSignal->send() ) {
            $this->_unsubscribeFromEngineEvents();
            return $this->dispatchErrorEvent( self::MOVED_SIGNAL_SEND_ERR_CODE );
        }
    }
    
    /**
     * We have received OKMOVED, we need see who its from. If it came from
     * the SIP call leg we need to send an OKSDP signal to MS call leg, if it
     * came from MS call leg we need to relay it to the SIP call leg and
     * dispatch the FAX_ENV_CREATED event
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleOkMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $remote = $signal->getRemote();
        
        if ( $remote === $this->_leftCallLeg->getName() ) {
            $this->_leftCallLeg->getParams( $signal->getParams() );
            
            $oksdpSignal = Streamwide_Engine_Signal::factory(
                Streamwide_Engine_Signal::OKSDP,
                $this->_rightCallLeg->getName(),
                $signal->getParams()
            );
            
            if ( false === $oksdpSignal->send() ) {
                $this->_unsubscribeFromEngineEvents();
                return $this->dispatchErrorEvent( self::OKSDP_SIGNAL_SEND_ERR_CODE );
            }
            
            return null;
        }
        
        if ( $remote === $this->_rightCallLeg->getName() ) {
            $this->_rightCallLeg->setParams( $signal->getParams() );
            
            if ( false === $signal->relay( $this->_leftCallLeg->getName() ) ) {
                $this->_unsubscribeFromEngineEvents();
                return $this->dispatchErrorEvent( self::OKMOVED_SIGNAL_RELAY_ERR_CODE );
            }
            
            $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::CONNECTED );
            $event->setParam( 'signal', $signal );
            return $this->dispatchEvent( $event );
        }
    }
    
    /**
     * We have received FAILMOVED. If it came from SIP call leg we need to send a
     * FAILSDP to the MS call leg and dispatch an error event. If it came from MS call
     * leg the fax environment could not be created
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleFailMovedSignal( Streamwide_Engine_Signal $signal )
    {
        $this->_unsubscribeFromEngineEvents();
        
        $remote = $signal->getRemote();
        
        if ( $remote === $this->_leftCallLeg->getName() ) {
            $failSdpSignal = Streamwide_Engine_Signal::factory(
                Streamwide_Engine_Signal::FAILSDP,
                $this->_rightCallLeg->getName(),
                $signal->getParams()
            );
            if ( false === $failSdpSignal->send() ) {
                $this->dispatchErrorEvent( self::FAILSDP_SIGNAL_SEND_ERR_CODE );
            }
            return null;
        }
        
        if ( $remote === $this->_rightCallLeg->getName() ) {
            return $this->dispatchErrorEvent( self::FAX_ENV_NOT_CREATED_ERR_CODE );
        }
    }
    
    /**
     * We have received a CHILD. We need to dispatch an ERROR event
     *
     * @param Streamwide_Engine_Signal $signal
     * @return unknown_type
     */
    protected function _handleChildSignal( Streamwide_Engine_Signal $signal )
    {
        return parent::_handleChildSignal( $signal, self::CALL_LEG_DIED_ERR_CODE );
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#_subscribeToEngineEvents()
     */
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        
        // Start listen to MOVED signal
        $movedNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_leftCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::MOVED,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $movedNotifyFilter
                )
            )
        );
        // End listen to MOVED signal
        
        // Start listen to SDP signal
        $sdpNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_rightCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::SDP,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $sdpNotifyFilter
                )
            )
        );
        // End listen to SDP signal
        
        // Start listen to OKMOVED signal
        $okMovedNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_IN_ARRAY,
            array( array( $this->_leftCallLeg->getName(), $this->_rightCallLeg->getName() ) )
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::OKMOVED,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array( 'notifyFilter' => $okMovedNotifyFilter )
            )
        );
        // End listen to OKMOVED signal
        
        // Start listen to FAILMOVED signal
        $failMovedNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_IN_ARRAY,
            array( array( $this->_leftCallLeg->getName(), $this->_rightCallLeg->getName() ) )
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::FAILMOVED,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $failMovedNotifyFilter
                )
            )
        );
        // End listen to FAILMOVED signal
        
        // Start listen to CHILD signal
        $childNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_IN_ARRAY,
            array( array( $this->_leftCallLeg->getName(), $this->_rightCallLeg->getName() ) )
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::CHILD,
            array(
                'callback' => array( $this, 'onSignalReceived' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $childNotifyFilter
                )
            )
        );
        // Start listen to CHILD signal
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#_unsubscribeFromEngineEvents()
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $callback = array( 'callback' => array( $this, 'onSignalReceived' ) );
        
        $events = array(
            Streamwide_Engine_Events_Event::MOVED,
            Streamwide_Engine_Events_Event::SDP,
            Streamwide_Engine_Events_Event::OKMOVED,
            Streamwide_Engine_Events_Event::FAILMOVED,
            Streamwide_Engine_Events_Event::CHILD
        );
        
        $controller = $this->getController();
        foreach ( $events as $event ) {
            $controller->removeEventListener( $event, $callback );
        }
    }
    
}

/* EOF */