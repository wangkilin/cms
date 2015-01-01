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
 * Allows sending of fax
 */
class Streamwide_Engine_Fax_Sender extends Streamwide_Engine_Widget
{
    
    /**
     * Fax tone playing duration in seconds. The purpose of the high
     * value is to avoid dealing with a EOF which will add to the complexity
     * of this class.
     */
    const FAX_TONE_DURATION = 3600;
    
    /**
     * How long (in seconds) we will play the fax tone
     * @todo Should we make this configurable
     */
    const FAX_TONE_PLAY_TIMEOUT = 10;
    
    /**
     * States for this widget
     */
    const STATE_READY = 'READY';
    const STATE_SENDING = 'SENDING';
    
    /**
     * Widget options. These are global options (applied to all fax pages) and can be overridden
     * by providing fax page options
     */
    const OPT_PAGE_ENCODING = 'page_encoding';
    const OPT_PAGE_LENGTH = 'page_length';
    const OPT_PAGE_WIDTH = 'page_width';
    const OPT_PAGE_RESOLUTION = 'page_resolution';

    /**
     * Default values for options
     */
    const DEFAULT_PAGE_ENCODING = 'T4_1D_MH';
    const DEFAULT_PAGE_LENGTH = 'A4';
    const DEFAULT_PAGE_WIDTH = 'A4';
    const DEFAULT_PAGE_RESOLUTION = '200x100';
    
    /**
     * Error codes
     */
    const FAXSEND_SIGNAL_SEND_ERR_CODE = 'FAXSENDER-100';
    const FAX_NOT_SENT_ERR_CODE = 'FAXSENDER-200';
    const FAX_PAGES_NOT_PROVIDED_ERR_CODE = 'FAXSENDER-201';
    const ALREADY_SENDING_ERR_CODE = 'FAXSENDER-300';
    
    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::FAX_SENDING_REQUESTED,
        Streamwide_Engine_Events_Event::FAX_SENDING_STARTED,
        Streamwide_Engine_Events_Event::FAX_SENT,
        Streamwide_Engine_Events_Event::ERROR
    );
    
    /**
     * Fax pages to send
     *
     * @var array
     */
    protected $_faxPages = array();
    
    /**
     * Whether to wait for update confirmation from the MS call leg
     *
     * @var boolean
     */
    protected $_waitUpdateConfirmation = false;
    
    /**
     * The media server call leg
     *
     * @var Streamwide_Engine_Media_Server_Call_Leg
     */
    protected $_msCallLeg;
    
    /**
     * The SIP call leg
     *
     * @var Streamwide_Engine_Sip_Call_Leg
     */
    protected $_sipCallLeg;
    
    /**
     * A timeout timer used to allow the playing of the fax tone only for a certain period of time
     *
     * @var Streamwide_Engine_Timer_Timeout
     */
    protected $_timer;
    
    /**
     * A media player to play the fax tone
     *
     * @var Streamwide_Engine_Media_Player
     */
    protected $_mediaPlayer;
    
    /**
     * A relayer to relay possible signals that are received when the fax tone is played
     *
     * @var Streamwide_Engine_Automatic_Signal_Relayer
     */
    protected $_relayer;
    
    /**
     * SIP-MS connector to perform forced fax if we don't receive the MOVED signal when playing
     * the fax tone
     *
     * @var Streamwide_Engine_Call_Leg_Connector_ForcedFaxNegotiator
     */
    protected $_forcedFaxNegotiator;
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::FAXSEND_SIGNAL_SEND_ERR_CODE => 'Unable to send FAXSEND signal to SW Engine',
        self::FAX_NOT_SENT_ERR_CODE => 'Fax sending unsuccessfull',
        self::FAX_PAGES_NOT_PROVIDED_ERR_CODE => 'Fax pages not provided',
        self::ALREADY_SENDING_ERR_CODE => 'Fax sender already sending fax'
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
                self::STATE_SENDING
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
        
        if ( isset( $this->_mediaPlayer ) ) {
            $this->_mediaPlayer->destroy();
            unset( $this->_mediaPlayer );
        }
        
        if ( isset( $this->_relayer ) ) {
            $this->_relayer->destroy();
            unset( $this->_relayer );
        }
        
        if ( isset( $this->_forcedFaxNegotiator ) ) {
            $this->_forcedFaxNegotiator->destroy();
            unset( $this->_forcedFaxNegotiator );
        }
        
        parent::destroy();
    }
    
    /**
     * Set the widget's options
     *
     * @see Engine/Streamwide_Engine_Widget#setOptions()
     */
    public function setOptions( Array $options )
    {
        $pageEncoding = isset( $options[self::OPT_PAGE_ENCODING] ) ? $options[self::OPT_PAGE_ENCODING] : null;
        $this->_treatPageEncodingOption( $pageEncoding );
        
        $pageLength = isset( $options[self::OPT_PAGE_LENGTH] ) ? $options[self::OPT_PAGE_LENGTH] : null;
        $this->_treatPageLengthOption( $pageLength );
        
        $pageWidth = isset( $options[self::OPT_PAGE_WIDTH] ) ? $options[self::OPT_PAGE_WIDTH] : null;
        $this->_treatPageWidthOption( $pageWidth );
        
        $pageResolution = isset( $options[self::OPT_PAGE_RESOLUTION] ) ? $options[self::OPT_PAGE_RESOLUTION] : null;
        $this->_treatPageResolutionOption( $pageResolution );
    }
    
    /**
     * Set the fax pages to send
     *
     * @param array $faxPages
     * @return void
     */
    public function setFaxPages( Array $faxPages )
    {
        $this->_faxPages = $faxPages;
    }
    
    /**
     * Retrieve the fax pages set to be sent
     *
     * @return array
     */
    public function getFaxPages()
    {
        return $this->_faxPages;
    }
    
    /**
     * Set the media server call leg to be used by this widget
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
     * Set the sip call leg to be used by this widget
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
     * Set the timeout timer to be used by this widget
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
     * Set the media player to be used by this widget
     *
     * @param Streamwide_Engine_Media_Player $mediaPlayer
     * @return void
     */
    public function setMediaPlayer( Streamwide_Engine_Media_Player $mediaPlayer )
    {
        $this->_mediaPlayer = $mediaPlayer;
    }
    
    /**
     * Get the media player
     *
     * @return Streamwide_Engine_Media_Player|null
     */
    public function getMediaPlayer()
    {
        return $this->_mediaPlayer;
    }
    
    /**
     * Set the relayer used by this widget
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
     * Set the connector that will perform the forced creation of fax environment
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
     * Start the fax sending procedure
     *
     * @return boolean
     */
    public function send()
    {
        if ( $this->isSending() ) {
            $this->dispatchErrorEvent( self::ALREADY_SENDING_ERR_CODE );
            return false;
        }
        
        $this->_initFaxEnvDetection();
        $this->_playFaxTone();
        $this->_timeFaxTonePlaying();
        
        $this->_stateManager->setState( self::STATE_SENDING );
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::FAX_SENDING_REQUESTED ) );
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
        $this->_timer->reset();
        $this->_mediaPlayer->reset();
        $this->_forcedFaxNegotiator->reset();
        $this->_waitUpdateConfirmation = false;
        $this->_stateManager->setState( self::STATE_READY );
    }
    
    /**
     * Is the widget ready for sending fax?
     *
     * @return boolean
     */
    public function isReady()
    {
        return ( $this->_stateManager->getState() === self::STATE_READY );
    }
    
    /**
     * Is the widget running?
     *
     * @return boolean
     */
    public function isSending()
    {
        return ( $this->_stateManager->getState() === self::STATE_SENDING );
    }
    
    /**
     * We have received a TIMEOUT, if we are still waiting for an OKMOVED/FAILMOVED do
     * nothing, otherwise reset the relayer and create the fax environment manually
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onFaxPlayingTimeout( Streamwide_Engine_Events_Event $event )
    {
        $this->_mediaPlayer->reset();
        if ( $this->_waitUpdateConfirmation ) {
            return null;
        }
        
        $this->_relayer->reset();
        $this->_createFaxEnv();
    }
    
    /**
     * A MOVED/OKMOVED/FAILMOVED signal has been relayed.
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
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
                if ( !$this->_mediaPlayer->isPlaying() ) {
                    $this->_relayer->reset();
                    return $this->_createFaxEnv();
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
                    $this->_mediaPlayer->reset();
                    $this->_timer->reset();
                    $this->_relayer->reset();
                    return $this->_faxSend();
                }
                if ( !$this->_mediaPlayer->isPlaying() ) {
                    $this->_relayer->reset();
                    return $this->_createFaxEnv();
                }
            break;
        }
    }
    
    /**
     * Forced fax negotiation was successfull, send the FAXSEND signal
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onForcedFaxNegotiationComplete( Streamwide_Engine_Events_Event $event )
    {
        return $this->_faxSend();
    }
    
    /**
     * Forced fax negotiation failed, dispatch an error event
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onForcedFaxNegotiationFailure( Streamwide_Engine_Events_Event $event )
    {
        return $this->dispatchErrorEvent( self::FAX_NOT_SENT_ERR_CODE );
    }
    
    /**
     * We have received ENDOFFAX, we need to check it's "ok" parameter to see if
     * everything went fine
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onEndOfFax( Streamwide_Engine_Events_Event $event )
    {
        $signal = $event->getParam( 'signal' );
        $params = $signal->getParams();
        
        $this->_forcedFaxNegotiator->reset();
        $this->_unsubscribeFromEngineEvents();
        
        if ( array_key_exists( 'ok', $params ) && $params['ok'] === 'true' ) {
            return $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::FAX_SENT ) );
        }
        return $this->dispatchErrorEvent( self::FAX_NOT_SENT_ERR_CODE );
    }
    
    /**
     * Prepare the parameters of the FAXSEND signal
     *
     * @return array
     */
    protected function _preparePages()
    {
        $ret = array();
        for ( $i = 0, $j = 1, $n = count( $this->_faxPages ); $i < $n; $i++ ) {
            $prefix = sprintf( 'page%d', $j++ );
            
            $filename = sprintf( '%s_filename', $prefix );
            $encoding = sprintf( '%s_encoding', $prefix );
            $pageWidth = sprintf( '%s_width', $prefix );
            $pageLength = sprintf( '%s_length', $prefix );
            $pageResolution = sprintf( '%s_resolution', $prefix );
            
            $page = array(
                $filename => $this->_faxPages[$i]['filename'],
                $encoding => isset( $this->_faxPages[$i]['encoding'] ) ? $this->_faxPages[$i]['encoding'] : $this->_options[self::OPT_PAGE_ENCODING],
                $pageWidth => isset( $this->_faxPages[$i]['width'] ) ? $this->_faxPages[$i]['width'] : $this->_options[self::OPT_PAGE_WIDTH],
                $pageLength => isset( $this->_faxPages[$i]['length'] ) ? $this->_faxPages[$i]['length'] : $this->_options[self::OPT_PAGE_LENGTH],
                $pageResolution => isset( $this->_faxPages[$i]['resolution'] ) ? $this->_faxPages[$i]['resolution'] : $this->_options[self::OPT_PAGE_RESOLUTION]
            );
            
            $ret = array_merge( $ret, $page );
        }
        
        return $ret;
    }
    
    /**
     * Play the fax tone for an hour
     *
     * @return void
     */
    protected function _playFaxTone()
    {
        $playlist = array( new Streamwide_Engine_Media_Fax_Tone( null, null, self::FAX_TONE_DURATION ) );
        $this->_mediaPlayer->reset();
        $this->_mediaPlayer->setMediaServerCallLeg( $this->_msCallLeg );
        $this->_mediaPlayer->setPlaylist( $playlist );
        $this->_mediaPlayer->play();
    }
    
    /**
     * Time the playing of the fax tone. When this timer expires we need to create the
     * fax environment manually (if it has not been created automatically for us)
     *
     * @return void
     */
    protected function _timeFaxTonePlaying()
    {
        $this->_timer->reset();
        $this->_timer->setOptions( array( Streamwide_Engine_Timer_Timeout::OPT_DELAY => self::FAX_TONE_PLAY_TIMEOUT ) );
        $this->_timer->addEventListener(
            Streamwide_Engine_Events_Event::TIMEOUT,
            array(
                'callback' => array( $this, 'onFaxPlayingTimeout' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $this->_timer->arm();
    }
    
    /**
     * Create the fax environment manually
     *
     * @return void
     */
    protected function _createFaxEnv()
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
     * Send the FAXSEND signal
     *
     * @return void
     */
    protected function _faxSend()
    {
        $params = $this->_preparePages();
        if ( empty( $params ) ) {
            return $this->dispatchErrorEvent( self::FAX_PAGES_NOT_PROVIDED_ERR_CODE );
        }
        
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::FAXSEND,
            $this->_msCallLeg->getName(),
            $params
        );
        if ( false === $signal->send() ) {
            return $this->dispatchErrorEvent( self::FAXSEND_SIGNAL_SEND_ERR_CODE );
        }
        
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::FAX_SENDING_STARTED ) );
        $this->_subscribeToEngineEvents();
    }
    
    /**
     * Initialize the automatic fax detection
     *
     * @return void
     */
    protected function _initFaxEnvDetection()
    {
        $this->_relayer->reset();
        $this->_relayer->setLeftCallLeg( $this->_sipCallLeg );
        $this->_relayer->setRightCallLeg( $this->_msCallLeg );
        $this->_relayer->setOptions( array( Streamwide_Engine_Automatic_Signal_Relayer::OPT_PRIORITY => PHP_INT_MAX ) );
        $this->_relayer->setEventsList(
            array(
                Streamwide_Engine_Events_Event::MOVED,
                Streamwide_Engine_Events_Event::OKMOVED,
                Streamwide_Engine_Events_Event::FAILMOVED
            )
        );
        $this->_relayer->addEventListener(
            Streamwide_Engine_Events_Event::SIGNAL_RELAYED,
            array( 'callback' => array( $this, 'onFaxEnvDetectionUpdate' ) )
        );
        $this->_relayer->start();
    }
    
    /**
     * Subscribe to the ENDOFFAX signal
     *
     * @see Engine/Streamwide_Engine_Widget#_subscribeToEngineEvents()
     */
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        
        $endOfFaxNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_msCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::ENDOFFAX,
            array(
                'callback' => array( $this, 'onEndOfFax' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $endOfFaxNotifyFilter
                )
            )
        );
    }
    
    /**
     * Unsubscribe from ENDOFFAX signal
     *
     * @see Engine/Streamwide_Engine_Widget#_unsubscribeFromEngineEvents()
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $controller = $this->getController();
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::ENDOFFAX,
            array( 'callback' => array( $this, 'onEndOfFax' ) )
        );
    }
    
    /**
     * Initialize widget options with default values
     *
     * @return void
     */
    protected function _initDefaultOptions()
    {
        $this->_options[self::OPT_PAGE_ENCODING] = self::DEFAULT_PAGE_ENCODING;
        $this->_options[self::OPT_PAGE_LENGTH] = self::DEFAULT_PAGE_LENGTH;
        $this->_options[self::OPT_PAGE_WIDTH] = self::DEFAULT_PAGE_WIDTH;
        $this->_options[self::OPT_PAGE_RESOLUTION] = self::DEFAULT_PAGE_RESOLUTION;
    }
    
    /**
     * Treat the "page encoding" option
     *
     * @param mixed $pageEncoding
     * @return void
     */
    protected function _treatPageEncodingOption( $pageEncoding = null )
    {
        if ( null === $pageEncoding ) {
            return null;
        }
        
        if ( !is_string( $pageEncoding ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to string', self::OPT_PAGE_ENCODING ) );
            $pageEncoding = (string)$pageEncoding;
        }
        
        if ( !in_array( $pageEncoding, array( 'T4_1D_MH', 'T4_2D_MR' ), true ) ) {
            trigger_error( sprintf( 'Invalid value provided for "%s" option. Using default value', self::OPT_PAGE_ENCODING ) );
        } else {
            $this->_options[self::OPT_PAGE_ENCODING] = $pageEncoding;
        }
    }
    
    /**
     * Treat the "page length" option
     *
     * @param mixed $pageLength
     * @return void
     */
    protected function _treatPageLengthOption( $pageLength = null )
    {
        if ( null === $pageLength ) {
            return null;
        }
        
        if ( !is_string( $pageLength ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to string', self::OPT_PAGE_LENGTH ) );
            $pageLength = (string)$pageLength;
        }
        
        if ( !in_array( $pageLength, array( 'A4', 'B4', 'UNLIMITED' ), true ) ) {
            trigger_error( sprintf( 'Invalid value provided for "%s" option. Using default value', self::OPT_PAGE_LENGTH ) );
        } else {
            $this->_options[self::OPT_PAGE_LENGTH] = $pageLength;
        }
    }
    
    /**
     * Treat the "page width" option
     *
     * @param mixed $pageWidth
     * @return void
     */
    protected function _treatPageWidthOption( $pageWidth = null )
    {
        if ( null === $pageWidth ) {
            return null;
        }
        
        if ( !is_string( $pageWidth ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to string', self::OPT_PAGE_WIDTH ) );
            $pageWidth = (string)$pageWidth;
        }
        
        if ( !in_array( $pageWidth, array( 'A4', 'B4', 'B3' ), true ) ) {
            trigger_error( sprintf( 'Invalid value provided for "%s" option. Using default value', self::OPT_PAGE_WIDTH ) );
        } else {
            $this->_options[self::OPT_PAGE_WIDTH] = $pageWidth;
        }
    }
    
    /**
     * Treat the "page resolution" option
     *
     * @param mixed $pageResolution
     * @return void
     */
    protected function _treatPageResolutionOption( $pageResolution = null )
    {
        if ( null === $pageResolution ) {
            return null;
        }
        
        if ( !is_string( $pageResolution ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to string', self::OPT_PAGE_RESOLUTION ) );
            $pageResolution = (string)$pageResolution;
        }
        
        $allowedPageResolutions = array(
            '200x100', '200x200',
            '300x300', '400x400',
            '600x600', '1200x1200',
            '200x400', '300x600',
            '400x800', '600x1200'
        );
        if ( !in_array( $pageResolution, $allowedPageResolutions, true ) ) {
            trigger_error( sprintf( 'Invalid value provided for "%s" option. Using default value', self::OPT_PAGE_RESOLUTION ) );
        } else {
            $this->_options[self::OPT_PAGE_RESOLUTION] = $pageResolution;
        }
    }
    
}

/* EOF */
