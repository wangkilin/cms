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
 * Allows receiving of fax
 */
class Streamwide_Engine_Fax_Receiver extends Streamwide_Engine_Widget
{
    
    /**
     * Options for this widget
     */
    const OPT_DETECT_FAX_TONE = 'detect_fax_tone';
    
    /**
     * Default option values
     */
    const DETECT_FAX_TONE_DEFAULT = true;
    
    /**
     * States for this widget
     */
    const STATE_READY = 'READY';
    const STATE_RECEIVING = 'RECEIVING';
    
    /**
     * Error codes
     */
    const FAXRECEIVE_SIGNAL_SEND_ERR_CODE = 'FAXRECEIVER-100';
    const FAX_NOT_RECEIVED_ERR_CODE = 'FAXRECEIVER-200';
    const ALREADY_RECEIVING_ERR_CODE = 'FAXRECEIVER-300';
    
    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::FAX_RECEIVING_REQUESTED,
        Streamwide_Engine_Events_Event::FAX_RECEIVING_STARTED,
        Streamwide_Engine_Events_Event::FAX_TONE_NOT_DETECTED,
        Streamwide_Engine_Events_Event::FAX_PAGE_RECEIVED,
        Streamwide_Engine_Events_Event::FAX_RECEIVED,
        Streamwide_Engine_Events_Event::ERROR
    );
    
    /**
     * The media server call leg
     *
     * @var Streamwide_Engine_Media_Server_Call_Leg
     */
    protected $_msCallLeg;
    
    /**
     * The sip call leg
     *
     * @var Streamwide_Engine_Sip_Call_Leg
     */
    protected $_sipCallLeg;
    
    /**
     * Timeout timer object
     *
     * @var Streamwide_Engine_Timer_Timeout
     */
    protected $_timer;
    
    /**
     * Detector for fax tone
     *
     * @var Streamwide_Engine_Fax_Detector_Tone
     */
    protected $_faxToneDetector;
    
    /**
     * Connector to perform forced fax negotiation
     *
     * @var Streamwide_Engine_Call_Leg_Connector_ForcedFaxNegotiator
     */
    protected $_forcedFaxNegotiator;
    
    /**
     * Automatic signal relayer
     *
     * @var Streamwide_Engine_Automatic_Signal_Relayer
     */
    protected $_relayer;
    
    /**
     * Array of received pages
     *
     * @var array
     */
    protected $_faxPages = array();
    
    /**
     * The path to the directory where the fax pages will be saved
     *
     * @var string
     */
    protected $_savePath;
    
    /**
     * Has a fax tone been detected?
     *
     * @var boolean
     */
    protected $_faxToneDetected = false;
    
    /**
     * Did the audio reinvite timed out ? (available only in forced fax mode)
     *
     * @var boolean
     */
    protected $_audioReinviteTimedOut = false;
    
    /**
     * Whether to wait for update confirmation from the MS call leg
     *
     * @var boolean
     */
    protected $_waitUpdateConfirmation = false;
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::FAXRECEIVE_SIGNAL_SEND_ERR_CODE => 'Unable to send the FAXRECEIVE signal to SW Engine',
        self::FAX_NOT_RECEIVED_ERR_CODE => 'Fax receive unsuccessfull',
        self::ALREADY_RECEIVING_ERR_CODE => 'Fax receiver already receiving fax'
    );
    
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_stateManager = new Streamwide_Engine_Widget_State_Manager(
            array(
                self::STATE_READY,
                self::STATE_RECEIVING
            )
        );
        $this->_initDefaultOptions();
    }
    
    /**
     * Destructor
     */
    public function destroy()
    {
        if ( isset( $this->_msCallLeg ) ) {
            unset( $this->_msCallLeg );
        }
        
        if ( isset( $this->_sipCallLeg ) ) {
            unset( $this->_sipCallLeg );
        }
        
        if ( isset( $this->_timer ) ) {
            $this->_timer->destroy();
            unset( $this->_timer );
        }
        
        if ( isset( $this->_faxToneDetector ) ) {
            $this->_faxToneDetector->destroy();
            unset( $this->_faxToneDetector );
        }
        
        if ( isset( $this->_forcedFaxNegotiator ) ) {
            $this->_forcedFaxNegotiator->destroy();
            unset( $this->_forcedFaxNegotiator );
        }
        
        if ( isset( $this->_relayer ) ) {
            $this->_relayer->destroy();
            unset( $this->_relayer );
        }
        
        parent::destroy();
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#setOptions()
     */
    public function setOptions( Array $options )
    {
        $detectFaxTone = isset( $options[self::OPT_DETECT_FAX_TONE] ) ? $options[self::OPT_DETECT_FAX_TONE] : null;
        $this->_treatDetectFaxToneOption( $detectFaxTone );
    }
    
    /**
     * Set the media server call leg
     *
     * @param Streamwide_Engine_Media_Server_Call_Leg $msCallLeg
     * @return void
     */
    public function setMediaServerCallLeg( Streamwide_Engine_Media_Server_Call_Leg $msCallLeg )
    {
        $this->_msCallLeg = $msCallLeg;
    }
    
    /**
     * Retrieve the media server call leg
     *
     * @return Streamwide_Engine_Media_Server_Call_Leg|null
     */
    public function getMediaServerCallLeg()
    {
        return $this->_msCallLeg;
    }
    
    /**
     * Set the SIP call leg
     *
     * @param Streamwide_Engine_Sip_Call_Leg $sipCallLeg
     * @return void
     */
    public function setSipCallLeg( Streamwide_Engine_Sip_Call_Leg $sipCallLeg )
    {
        $this->_sipCallLeg = $sipCallLeg;
    }
    
    /**
     * Retrieve the sip call leg
     *
     * @return Streamwide_Engine_Sip_Call_Leg|null
     */
    public function getSipCallLeg()
    {
        return $this->_sipCallLeg;
    }
    
    /**
     * Set the timeout timer
     *
     * @param Streamwide_Engine_Timer_Timeout $timer
     * @return void
     */
    public function setTimer( Streamwide_Engine_Timer_Timeout $timer )
    {
        $this->_timer = $timer;
    }
    
    /**
     * Retrieve the timeout timer widget
     *
     * @return Streamwide_Engine_Timer_Timeout|null
     */
    public function getTimer()
    {
        return $this->_timer;
    }
    
    /**
     * Set the relayer widget
     *
     * @param Streamwide_Engine_Automatic_Signal_Relayer $relayer
     * @return void
     */
    public function setRelayer( Streamwide_Engine_Automatic_Signal_Relayer $relayer )
    {
        $this->_relayer = $relayer;
    }
    
    /**
     * Get the relayer
     *
     * @return Streamwide_Engine_Automatic_Signal_Relayer|null
     */
    public function getRelayer()
    {
        return $this->_relayer;
    }
    
    /**
     * Set the forced fax negotiator
     *
     * @param Streamwide_Engine_Call_Leg_Connector_ForcedFaxNegotiator $forcedFaxNegotiator
     * @return void
     */
    public function setForcedFaxNegotiator( Streamwide_Engine_Call_Leg_Connector_ForcedFaxNegotiator $forcedFaxNegotiator )
    {
        $this->_forcedFaxNegotiator = $forcedFaxNegotiator;
    }
    
    /**
     * Get the forced fax negotiator connector
     *
     * @return Streamwide_Engine_Call_Leg_Connector_ForcedFaxNegotiator|null
     */
    public function getForcedFaxNegotiator()
    {
        return $this->_forcedFaxNegotiator;
    }
    
    /**
     * Set fax tone detector
     *
     * @param Streamwide_Engine_Fax_Detector_Tone $faxToneDetector
     * @return void
     */
    public function setFaxToneDetector( Streamwide_Engine_Fax_Detector_Tone $faxToneDetector )
    {
        $this->_faxToneDetector = $faxToneDetector;
    }
    
    /**
     * Retrieve the fax tone detector
     *
     * @return Streamwide_Engine_Fax_Detector_Tone|null
     */
    public function getFaxToneDetector()
    {
        return $this->_faxToneDetector;
    }
    
    /**
     * Set the folder where the fax pages will be saved
     *
     * @param string $savePath
     * @return void
     */
    public function setSavePath( $savePath )
    {
        $this->_savePath = $savePath;
    }
    
    /**
     * Retrieve the folder where the fax pages will be saved
     *
     * @return string|null
     */
    public function getSavePath()
    {
        return $this->_savePath;
    }
    
    /**
     * Get the fax received pages
     *
     * @return array
     */
    public function getReceivedPages()
    {
        return $this->_pages;
    }
    
    /**
     * Is the widget ready to start receiving fax?
     *
     * @return boolean
     */
    public function isReady()
    {
        return ( $this->_stateManager->getState() === self::STATE_READY );
    }
    
    /**
     * Is the widget receiving fax?
     *
     * @return boolean
     */
    public function isReceiving()
    {
        return ( $this->_stateManager->getState() === self::STATE_RECEIVING );
    }
    
    /**
     * Receive the fax pages
     *
     * @return boolean
     */
    public function receive()
    {
        if ( $this->isReceiving() ) {
            $this->dispatchErrorEvent( self::ALREADY_RECEIVING_ERR_CODE );
            return false;
        }
        
        $this->_initFaxEnvDetection();
        if ( $this->_options[self::OPT_DETECT_FAX_TONE] ) {
            $this->_initFaxToneDetection();
        } else {
            $this->_waitAudioReinvite();
        }
        
        $this->_stateManager->setState( self::STATE_RECEIVING );
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::FAX_RECEIVING_REQUESTED ) );
        return true;
    }
    
    /**
     * Reset the widget to the initial state
     *
     * @return void
     */
    public function reset()
    {
        parent::reset();
        $this->_relayer->reset();
        $this->_forcedFaxNegotiator->reset();
        if ( isset( $this->_faxToneDetector ) ) {
            $this->_faxToneDetector->reset();
        }
        if ( isset( $this->_timer ) ) {
            $this->_timer->reset();
        }
        $this->_waitUpdateConfirmation = false;
        $this->_faxToneDetected = false;
        $this->_audioReinviteTimedOut = false;
        $this->_faxPages = array();
        $this->_stateManager->setState( self::STATE_READY );
    }
    
    /**
     * Audio reinvite waiting has finished
     *
     * @param Streamwide_Engine_Events_Events $event
     * @return void
     */
    public function onAudioReinviteTimeout( Streamwide_Engine_Events_Event $event )
    {
        $this->_audioReinviteTimedOut = true;
        if ( $this->_waitUpdateConfirmation ) {
            return null;
        }
        
        $this->_relayer->reset();
        return $this->_startForcedFaxNegotiation();
    }
    
    /**
     * Fax tone was detected, if a MOVED signal has not been received we start
     * the forced fax negotiation
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onFaxToneDetected( Streamwide_Engine_Events_Event $event )
    {
        $this->_faxToneDetected = true;
        if ( $this->_waitUpdateConfirmation ) {
            return null;
        }
        
        $this->_relayer->reset();
        return $this->_startForcedFaxNegotiation();
    }
    
    /**
     * Fax tone was not detected, if a MOVED signal has not been received we stop the fax environment
     * update detection
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onFaxToneNotDetected( Streamwide_Engine_Events_Event $event )
    {
        $this->_faxToneDetected = false;
        if ( $this->_waitUpdateConfirmation ) {
            return $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::FAX_TONE_NOT_DETECTED ) );
        }
        
        $this->_relayer->reset();
        return $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::FAX_TONE_NOT_DETECTED ) );
    }
    
    /**
     * A MOVED/OKMOVED/FAILMOVED signal has been relayed
     *
     * @param $event
     * @return unknown_type
     */
    public function onFaxEnvDetectionUpdate( Streamwide_Engine_Events_Event $event )
    {
        $signal = $event->getParam( 'signal' );
        $signalName = $signal->getName();
        
        switch ( $signalName ) {
            case Streamwide_Engine_Signal::MOVED:
                $this->_waitUpdateConfirmation = true;
            break;
            case Streamwide_Engine_Signal::FAILMOVED:
                $this->_waitUpdateConfirmation = false;
                if ( $this->_faxToneDetected || $this->_audioReinviteTimedOut ) {
                    $this->_relayer->reset();
                    return $this->_startForcedFaxNegotiation();
                }
            break;
            case Streamwide_Engine_Signal::OKMOVED:
                $this->_waitUpdateConfirmation = false;
                $specification = Streamwide_Engine_NotifyFilter_Factory::factory(
                    Streamwide_Engine_NotifyFilter_Factory::T_SIG_PARAM,
                    Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
                    array( 'policy', 'image' )
                );
                if ( $specification->isSatisfiedBy( $signal ) ) {
                    $this->_relayer->reset();
                    if ( isset( $this->_faxToneDetector ) ) {
                        $this->_faxToneDetector->reset();
                    }
                    if ( isset( $this->_timer ) ) {
                        $this->_timer->reset();
                    }
                    return $this->_faxReceive();
                }
                if ( $this->_faxToneDetected || $this->_audioReinviteTimedOut ) {
                    $this->_relayer->reset();
                    return $this->_startForcedFaxNegotiation();
                }
            break;
        }
    }
    
    /**
     * Forced fax negotiation complete, start receiving fax
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onForcedFaxNegotiationComplete( Streamwide_Engine_Events_Event $event )
    {
        return $this->_faxReceive();
    }
    
    /**
     * Forced fax negotation failed
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onForcedFaxNegotiationFailure( Streamwide_Engine_Events_Event $event )
    {
        return $this->dispatchErrorEvent( self::FAX_NOT_RECEIVED_ERR_CODE );
    }
    
    /**
     * We have received ENDOFFAX from SW Engine we need to check its "ok" parameter
     * to see if the fax has been received successfully
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onEndOfFax( Streamwide_Engine_Events_Event $event )
    {
        $signal = $event->getParam( 'signal' );
        $params = $signal->getParams();
        
        if ( !isset( $params['ok'] ) || $params['ok'] !== 'true' ) {
            return $this->dispatchErrorEvent( self::FAX_NOT_RECEIVED_ERR_CODE );
        }

        $this->_stateManager->setState( self::STATE_READY );
        return $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::FAX_RECEIVED ) );
    }
    
    /**
     * We have received a FAXPAGE from SW Engine we need to save the current fax page
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onFaxPage( Streamwide_Engine_Events_Event $event )
    {
        $signal = $event->getParam( 'signal' );
        $params = $signal->getParams();
        
        if ( isset( $params['filename'] ) ) {
            $this->_pages[] = $params['filename'];
        }
        
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::FAX_PAGE_RECEIVED );
        $event->setParam( 'filename', $params['filename'] );
        $event->setParam( 'receivedFaxPagesCount', count( $this->_pages ) );
        return $this->dispatchEvent( $event );
    }
    
    /**
     * Initialize the fax tone detection
     *
     * @return void
     */
    protected function _initFaxToneDetection()
    {
        $this->_faxToneDetector->addEventListener(
            Streamwide_Engine_Events_Event::FAX_TONE_DETECTED,
            array(
                'callback' => array( $this, 'onFaxToneDetected' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $this->_faxToneDetector->addEventListener(
            Streamwide_Engine_Events_Event::FAX_TONE_NOT_DETECTED,
            array(
                'callback' => array( $this, 'onFaxToneNotDetected' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $this->_faxToneDetector->startDetection();
    }
    
    /**
     * Initialize the fax environment detection
     *
     * @return void
     */
    protected function _initFaxEnvDetection()
    {
        $this->_relayer->reset();
        $this->_relayer->setOptions( array( Streamwide_Engine_Automatic_Signal_Relayer::OPT_PRIORITY => PHP_INT_MAX ) );
        $this->_relayer->setLeftCallLeg( $this->_sipCallLeg );
        $this->_relayer->setRightCallLeg( $this->_msCallLeg );
        $this->_relayer->setEventsList(
            array(
                Streamwide_Engine_Events_Event::MOVED,
                Streamwide_Engine_Events_Event::FAILMOVED,
                Streamwide_Engine_Events_Event::OKMOVED
            )
        );
        $this->_relayer->addEventListener(
            Streamwide_Engine_Events_Event::SIGNAL_RELAYED,
            array( 'callback' => array( $this, 'onFaxEnvDetectionUpdate' ) )
        );
        $this->_relayer->start();
    }
    
    /**
     * Start negotiating forced fax
     *
     * @return void
     */
    protected function _startForcedFaxNegotiation()
    {
        $this->_forcedFaxNegotiator->reset();
        $this->_forcedFaxNegotiator->setLeftCallLeg( $this->_sipCallLeg );
        $this->_forcedFaxNegotiator->setRightCallLeg( $this->_msCallLeg );
        $this->_forcedFaxNegotiator->addEventListener(
            Streamwide_Engine_Events_Event::CONNECTED,
            array(
                'callback' => array( $this, 'onForcedFaxNegotiationComplete' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $this->_forcedFaxNegotiator->addEventListener(
            Streamwide_Engine_Events_Event::ERROR,
            array(
                'callback' => array( $this, 'onForcedFaxNegotiationFailure' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $this->_forcedFaxNegotiator->connect();
    }

    /**
     * Wait for audio reinvite (CIRPACK softswitch hack)
     *
     * @return void
     */
    protected function _waitAudioReinvite()
    {
        $this->_timer->reset();
        $this->_timer->setOptions( array( Streamwide_Engine_Timer_Timeout::OPT_DELAY => 1 ) );
        $this->_timer->addEventListener(
            Streamwide_Engine_Events_Event::TIMEOUT,
            array(
                'callback' => array( $this, 'onAudioReinviteTimeout' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $this->_timer->arm();
    }
    
    /**
     * Start receiving the fax
     *
     * @return void
     */
    protected function _faxReceive()
    {
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::FAXRECEIVE,
            $this->_msCallLeg->getName(),
            array( 'filename' => $this->_savePath )
        );
        
        if ( false === $signal->send() ) {
            return $this->dispatchErrorEvent( self::FAXRECEIVE_SIGNAL_SEND_ERR_CODE );
        }
        
        $this->_subscribeToEngineEvents();
        return $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::FAX_RECEIVING_STARTED ) );
    }
    
    /**
     * Subscribe to the ENDOFFAX and FAXPAGE signals
     *
     * @return void
     */
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::ENDOFFAX,
            array(
                'callback' => array( $this, 'onEndOfFax' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::FAXPAGE,
            array( 'callback' => array( $this, 'onFaxPage' ) )
        );
    }
    
    /**
     * Unsubscribe from ENDOFFAX and FAXPAGE signals
     *
     * @return void
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $controller = $this->getController();
        $controller->removeEventListener(
            Streamwide_Engine_Events_Event::ENDOFFAX,
            array( 'callback' => array( $this, 'onEndOfFax' ) )
        );
        $controller->removeEventListener(
            Streamwide_Engine_Events_Event::FAXPAGE,
            array( 'callback' => array( $this, 'onFaxPage' ) )
        );
    }
    
    /**
     * Initialize options with default values
     *
     * @return void
     */
    protected function _initDefaultOptions()
    {
        $this->_options[self::OPT_DETECT_FAX_TONE] = self::DETECT_FAX_TONE_DEFAULT;
    }
    
    /**
     * Treat the "detect fax tone" option
     *
     * @param mixed $detectFaxTone
     * @return void
     */
    protected function _treatDetectFaxToneOption( $detectFaxTone = null )
    {
        if ( null === $detectFaxTone ) {
            return null;
        }
        
        if ( is_int( $detectFaxTone ) || is_string( $detectFaxTone ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to boolean', self::OPT_DETECT_FAX_TONE ) );
            $detectFaxTone = (bool)$detectFaxTone;
        }

        if ( is_bool( $detectFaxTone ) ) {
            $this->_options[self::OPT_DETECT_FAX_TONE] = $detectFaxTone;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_DETECT_FAX_TONE ) );
        }
    }
    
}


/* EOF */
