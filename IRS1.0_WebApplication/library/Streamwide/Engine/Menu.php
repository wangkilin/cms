<?php
/**
 *
 * $Rev: 2189 $
 * $LastChangedDate: 2009-12-16 19:29:07 +0800 (Wed, 16 Dec 2009) $
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
 * Class that allows users to pick one option from a list of options
 */
class Streamwide_Engine_Menu extends Streamwide_Engine_Widget
{
    
    /**
     * Option names
     */
    const OPT_INVITE_PROMPT_PLAYLIST = 'invite_prompt_playlist';
    const OPT_MENU_KEYS_LIST = 'menu_keys_list';
    const OPT_STOP_PROMPTING_ON_DTMF = 'stop_prompting_on_dtmf';
    const OPT_WRONG_KEY_PROMPT_PLAYLIST = 'wrong_key_prompt_playlist';
    const OPT_NO_KEY_PROMPT_PLAYLIST = 'no_key_prompt_playlist';
    const OPT_TIMEOUT = 'timeout';
    const OPT_TRIES = 'tries';

    /**
     * Default values for some of the options
     */
    const STOP_PROMPTING_ON_DTMF_DEFAULT = true;
    const DEFAULT_TIMEOUT = 5.0;
    const DEFAULT_NUMBER_OF_TRIES = 3;

    const ALL_WRONG_KEYS_PROMPT_PLAYLIST = 'all_keys';
    
    /**
     * Prompt types
     */
    const PROMPT_INVITE = 'INVITE';
    const PROMPT_WRONG_KEY = 'WRONG_KEY';
    const PROMPT_NO_KEY = 'NO_KEY';

    /**
     * Error codes
     */
    const BAD_TRY_ERR_CODE = 'MENU-200';
    const NO_TRIES_LEFT_ERR_CODE = 'MENU-201';

    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::ERROR,
        Streamwide_Engine_Events_Event::OPTION_CHOSEN
    );
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::BAD_TRY_ERR_CODE => 'Bad try',
        self::NO_TRIES_LEFT_ERR_CODE => 'No tries left'
    );
    
    /**
     * The counter widget
     *
     * @var Streamwide_Engine_Counter
     */
    protected $_counter;

    /**
     * The media player widget
     *
     * @var Streamwide_Engine_Media_Player
     */
    protected $_mediaPlayer;

    /**
     * The dtmf handler widget
     *
     * @var Streamwide_Engine_Dtmf_Handler
     */
    protected $_dtmfHandler;

    /**
     * The timeout timer widget
     *
     * @var Streamwide_Engine_Timer_Timeout
     */
    protected $_timer;
    
    /**
     * Has the menu been initialized?
     *
     * @var boolean
     */
    protected $_menuInitialized = false;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->_initDefaultOptions();
    }

    /**
     * Destructor
     */
    public function destroy()
    {
        if ( isset( $this->_counter ) ) {
            $this->_counter->destroy();
            unset( $this->_counter );
        }
        
        if ( isset( $this->_timer ) ) {
            $this->_timer->destroy();
            unset( $this->_timer );
        }
        
        if ( isset( $this->_dtmfHandler ) ) {
            $this->_dtmfHandler->destroy();
            unset( $this->_dtmfHandler );
        }
        
        if ( isset( $this->_mediaPlayer ) ) {
            $this->_mediaPlayer->destroy();
            unset( $this->_mediaPlayer );
        }
        
        parent::destroy();
    }

    /**
     * Set the timer widget to be used
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
     * @return Streamwide_Engine_Timer_Timeout
     */
    public function getTimer()
    {
        return $this->_timer;
    }
    
    /**
     * Set the media player widget to be used
     *
     * @param Streamwide_Engine_Media_Player $mediaPlayer
     * @return void
     */
    public function setMediaPlayer( Streamwide_Engine_Media_Player $mediaPlayer )
    {
        $this->_mediaPlayer = $mediaPlayer;
    }

    /**
     * Retrieve the media player widget
     *
     * @return Streamwide_Engine_Media_Player
     */
    public function getMediaPlayer()
    {
        return $this->_mediaPlayer;
    }
    
    /**
     * Set the counter widget to be used
     *
     * @param Streamwide_Engine_Counter $counter
     * @return void
     */
    public function setCounter( Streamwide_Engine_Counter $counter )
    {
        $this->_counter = $counter;
    }

    /**
     * Retrieve the counter widget
     *
     * @return Streamwide_Engine_Counter
     */
    public function getCounter()
    {
        return $this->_counter;
    }
    
    /**
     * Set the dtmf handler widget to be used
     *
     * @param Streamwide_Engine_Dtmf_Handler $dtmfHandler
     * @return void
     */
    public function setDtmfHandler( Streamwide_Engine_Dtmf_Handler $dtmfHandler )
    {
        $this->_dtmfHandler = $dtmfHandler;
    }
    
    /**
     * Retrieve the dtmf handler widget
     *
     * @return Streamwide_Engine_Dtmf_Handler
     */
    public function getDtmfHandler()
    {
        return $this->_dtmfHandler;
    }
    
    /**
     * Sets options values or provides default values for invalid or omitted required options
     *
     * @param mixed $options
     * @return void
     */
    public function setOptions( Array $options )
    {
        $invitePromptPlaylist = isset( $options[self::OPT_INVITE_PROMPT_PLAYLIST] ) ? $options[self::OPT_INVITE_PROMPT_PLAYLIST] : null;
        $this->_treatInvitePromptListOption( $invitePromptPlaylist );

        $menuKeysList = isset( $options[self::OPT_MENU_KEYS_LIST] ) ? $options[self::OPT_MENU_KEYS_LIST] : null;
        $this->_treatMenuKeysListOption( $menuKeysList );

        $stopPromptingOnDtmf = isset( $options[self::OPT_STOP_PROMPTING_ON_DTMF] ) ? $options[self::OPT_STOP_PROMPTING_ON_DTMF] : null;
        $this->_treatStopPromptingOnDtmfOption( $stopPromptingOnDtmf );

        $wrongKeyPromptPlaylist = isset( $options[self::OPT_WRONG_KEY_PROMPT_PLAYLIST] ) ? $options[self::OPT_WRONG_KEY_PROMPT_PLAYLIST] : null;
        $this->_treatWrongKeyPromptPlaylist( $wrongKeyPromptPlaylist );

        $noKeyPromptPlaylist = isset( $options[self::OPT_NO_KEY_PROMPT_PLAYLIST] ) ? $options[self::OPT_NO_KEY_PROMPT_PLAYLIST] : null;
        $this->_treatNoKeyPromptPlaylist( $noKeyPromptPlaylist );

        $timeout = isset( $options[self::OPT_TIMEOUT] ) ? $options[self::OPT_TIMEOUT] : null;
        $this->_treatTimeoutOption( $timeout );

        $tries = isset( $options[self::OPT_TRIES] ) ? $options[self::OPT_TRIES] : null;
        $this->_treatTriesOption( $tries );
    }
    
    /**
     * Resets the widget's properties to the initial state
     *
     * @return void
     */
    public function reset()
    {
        parent::reset();
        $this->_counter->reset();
        $this->_timer->reset();
        $this->_dtmfHandler->reset();
        $this->_mediaPlayer->reset();
        $this->_menuInitialized = false;
    }
    
    /**
     * Enter the menu
     *
     * @return boolean
     */
    public function enter()
    {
        $this->_init();
        
        if ( $this->_shouldStopPromptingOnDtmf() ) {
            if ( !$this->_listenForKeyPresses( self::PROMPT_INVITE ) ) {
                return false;
            }
        }
        
        return $this->_playInvitePrompt();
    }
    
    /**
     * Handles a key press (delegates to internal methods)
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onKeyPressed( Streamwide_Engine_Events_Event $event )
    {
        $eventType = $event->getEventType();
        $key = $event->getParam( 'receivedKey' );
        $promptType = $event->getContextParam( 'promptType' );
        switch ( $eventType ) {
            case Streamwide_Engine_Events_Event::KEY:
                $this->_handleValidKey( $key, $promptType );
            break;
            case Streamwide_Engine_Events_Event::UNEXPECTED_KEY:
                $this->_handleInvalidKey( $key, $promptType );
            break;
        }
    }
    
    /**
     * Arms the menu timer and listens for user key presses
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onInvitePromptFinished( Streamwide_Engine_Events_Event $event )
    {
        $this->_armTimer();
        $this->_listenForKeyPresses();
    }
    
    /**
     * Handle the menu timeout
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onMenuTimeout( Streamwide_Engine_Events_Event $event )
    {
        if ( $this->_timer->isArmed() ) {
            $this->_timer->disarm();
        }
        $shouldPromptOnNoKey = !empty( $this->_options[self::OPT_NO_KEY_PROMPT_PLAYLIST] );
        if ( $shouldPromptOnNoKey ) {
            $this->_counter->decrement();
            if ( $this->_counter->hasMoreTries() ) {
                $this->_listenForKeyPresses( self::PROMPT_NO_KEY );
                $this->_playNoKeyPrompt();
            } else {
                $this->dispatchErrorEvent( self::NO_TRIES_LEFT_ERR_CODE );
            }
        } else {
            $this->_retry();
        }
    }
    
    /**
     * Try again after the "no key" prompt has finished playing
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onNoKeyPromptFinished( Streamwide_Engine_Events_Event $event )
    {
        // do not decrement, counter was already decremented
        $this->_retry( false );
    }
    
    /**
     * Try again after the wrong key prompt has finished playing
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onWrongKeyPromptFinished( Streamwide_Engine_Events_Event $event )
    {
        // do not decrement counter was already decremented
        $this->_retry( false );
    }
    
    /**
     * Initialize the menu
     *
     * @return void
     */
    protected function _init()
    {
        if ( !$this->_menuInitialized ) {
            $this->_initCounter();
            $this->_initTimer();
            $this->_initDtmfHandler();
            $this->_initMediaPlayer();
            $this->_menuInitialized = true;
        }
    }
    
    /**
     * Initialize the counter widget
     *
     * @return void
     */
    protected function _initCounter()
    {
        $this->_counter->reset();
        $tries = $this->_options[self::OPT_TRIES];
        $this->_counter->setOptions( array( Streamwide_Engine_Counter::OPT_TRIES => $tries ) );
    }
    
    /**
     * Initialize the timer widget
     *
     * @return void
     */
    protected function _initTimer()
    {
        $this->_timer->reset();
        $timeout = $this->_options[self::OPT_TIMEOUT];
        $this->_timer->setOptions( array( Streamwide_Engine_Timer_Timeout::OPT_DELAY => $timeout ) );
    }
    
    /**
     * Initialize the media player widget
     *
     * @return void
     */
    protected function _initMediaPlayer()
    {
        $this->_mediaPlayer->reset();
    }
    
    /**
     * Initialize the dtmf handler widget
     *
     * @return void
     */
    protected function _initDtmfHandler()
    {
        $this->_dtmfHandler->reset();
        $currentOptions = $this->_dtmfHandler->getOptions();
        $options = array(
            Streamwide_Engine_Dtmf_Handler::OPT_ALLOWED_DTMFS => $this->_options[self::OPT_MENU_KEYS_LIST],
            Streamwide_Engine_Dtmf_Handler::OPT_SIGNAL_WRONG_KEY => true
        );
        if ( is_array( $currentOptions ) ) {
            $options = array_merge( $currentOptions, $options );
        }
        $this->_dtmfHandler->setOptions( $options );
    }
    
    /**
     * Should we stop the prompts of the menu if the user presses any keys
     * while these prompts are playing?
     *
     * @return boolean
     */
    protected function _shouldStopPromptingOnDtmf()
    {
        $shouldStopPromptingOnDtmf = $this->_options[self::OPT_STOP_PROMPTING_ON_DTMF];
        if ( false === $shouldStopPromptingOnDtmf ) {
            // prompts are uninterruptable only once
            $this->_options[self::OPT_STOP_PROMPTING_ON_DTMF] = true;
        }
        return $shouldStopPromptingOnDtmf;
    }
    
    /**
     * Sets up the dtmf handler widget to listen for key presses
     *
     * @param string $promptType
     * @return boolean
     */
    protected function _listenForKeyPresses( $promptType = null )
    {
        $this->_dtmfHandler->reset();
        $this->_dtmfHandler->setContextParams( array( 'promptType' => $promptType ) );
        $this->_dtmfHandler->addEventListener(
            Streamwide_Engine_Events_Event::KEY,
            array(
                'callback' => array( $this, 'onKeyPressed' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $this->_dtmfHandler->addEventListener(
            Streamwide_Engine_Events_Event::UNEXPECTED_KEY,
            array(
                'callback' => array( $this, 'onKeyPressed' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        
        $listening = $this->_dtmfHandler->startListening();
        if ( !$listening ) {
            $this->_dtmfHandler->flushEventListeners();
        }
        
        return $listening;
    }
    
    /**
     * Handles a key press
     *
     * @param string|null $promptType
     * @return void
     */
    protected function _handleKeyPress( $promptType = null )
    {
        if ( null === $promptType ) {
            if ( $this->_timer->isArmed() ) {
                $this->_timer->disarm();
            }
        } else {
            switch ( $promptType ) {
                case self::PROMPT_NO_KEY:
                case self::PROMPT_WRONG_KEY:
                    $this->_mediaPlayer->stop();
                break;
                case self::PROMPT_INVITE:
                    if ( $this->_shouldStopPromptingOnDtmf() ) {
                        $this->_mediaPlayer->stop();
                    }
                break;
            }
        }
    }
    
    /**
     * Handles a valid key
     *
     * @param string $key
     * @param string $promptType
     * @return void
     */
    protected function _handleValidKey( $key, $promptType = null )
    {
        $this->_handleKeyPress( $promptType );
        
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::OPTION_CHOSEN );
        $event->setParam( 'menuOption', $key );
        $this->dispatchEvent( $event );
    }
    
    /**
     * Handles a invalid key
     *
     * @param string $key
     * @param string $promptType
     * @return void
     */
    protected function _handleInvalidKey( $key, $promptType = null )
    {
        // do nothing if we received an invalid key while playing the invite prompt
        if ( null !== $promptType && $promptType === self::PROMPT_INVITE ) {
            return null;
        }
        
        $this->_handleKeyPress( $promptType );
        $shouldPromptOnWrongKey = !empty( $this->_options[self::OPT_WRONG_KEY_PROMPT_PLAYLIST] );
        if ( $shouldPromptOnWrongKey ) {
            $this->_counter->decrement();
            if ( $this->_counter->hasMoreTries() ) {
                $this->_listenForKeyPresses( self::PROMPT_WRONG_KEY );
                $this->_playWrongKeyPrompt( $key );
            } else {
                $this->dispatchErrorEvent( self::NO_TRIES_LEFT_ERR_CODE );
            }
        } else {
            $this->_retry();
        }
    }
    
    /**
     * Plays the invite prompt
     *
     * @return boolean
     */
    protected function _playInvitePrompt()
    {
        $invitePromptPlaylist = $this->_options[self::OPT_INVITE_PROMPT_PLAYLIST];
        $this->_mediaPlayer->reset();
        $this->_mediaPlayer->addEventListener(
            Streamwide_Engine_Events_Event::FINISHED,
            array(
                'callback' => array( $this, 'onInvitePromptFinished' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $this->_mediaPlayer->setPlaylist( $invitePromptPlaylist );
        
        $playing = $this->_mediaPlayer->play();
        if ( !$playing ) {
            $this->_mediaPlayer->flushEventListeners();
        }
        
        return $playing;
    }
    
    /**
     * Arms the menu timer
     *
     * @return boolean
     */
    protected function _armTimer()
    {
        $this->_timer->addEventListener(
            Streamwide_Engine_Events_Event::TIMEOUT,
            array(
                'callback' => array( $this, 'onMenuTimeout' ),
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
     * Play the "wrong key" prompt
     *
     * @param string $key
     * @return boolean
     */
    protected function _playWrongKeyPrompt( $key )
    {
        $wrongKeyPromptPlaylist = $this->_options[self::OPT_WRONG_KEY_PROMPT_PLAYLIST];
        if ( array_key_exists( self::ALL_WRONG_KEYS_PROMPT_PLAYLIST, $wrongKeyPromptPlaylist ) ) {
            $wrongKeyPromptPlaylist = $wrongKeyPromptPlaylist[self::ALL_WRONG_KEYS_PROMPT_PLAYLIST];
        } elseif ( array_key_exists( $key, $wrongKeyPromptPlaylist ) ) {
            $wrongKeyPromptPlaylist = $wrongKeyPromptPlaylist[$key];
        } else {
            // couldn't find a valid prompt playlist
            return $this->_retry( false );
        }
        
        $this->_mediaPlayer->reset();
        $this->_mediaPlayer->addEventListener(
            Streamwide_Engine_Events_Event::FINISHED,
            array(
                'callback' => array( $this, 'onWrongKeyPromptFinished' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $this->_mediaPlayer->setPlaylist( $wrongKeyPromptPlaylist );
        $playing = $this->_mediaPlayer->play();
        
        if ( !$playing ) {
            $this->_mediaPlayer->flushEventListeners();
        }
        
        return $playing;
    }
    
    /**
     * Play the "no key" prompt
     *
     * @return boolean
     */
    protected function _playNoKeyPrompt()
    {
        $noKeyPromptPlaylist = $this->_options[self::OPT_NO_KEY_PROMPT_PLAYLIST];
        $this->_mediaPlayer->reset();
        $this->_mediaPlayer->addEventListener(
            Streamwide_Engine_Events_Event::FINISHED,
            array(
                'callback' => array( $this, 'onNoKeyPromptFinished' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $this->_mediaPlayer->setPlaylist( $noKeyPromptPlaylist );
        $playing = $this->_mediaPlayer->play();
        
        if ( !$playing ) {
            $this->_mediaPlayer->flushEventListeners();
        }
        
        return $playing;
    }
    
    /**
     * Decrement the counter and give the user another try
     *
     * @param boolean $decrement
     * @return boolean
     */
    protected function _retry( $decrement = true )
    {
        if ( true === $decrement ) {
            $this->_counter->decrement();
        }
        if ( $this->_counter->hasMoreTries() ) {
            $this->_timer->reset();
            $this->_dtmfHandler->reset();
            $this->_mediaPlayer->reset();
            
            $this->dispatchErrorEvent( self::BAD_TRY_ERR_CODE );
            return $this->enter();
        } else {
            $this->dispatchErrorEvent( self::NO_TRIES_LEFT_ERR_CODE );
            return false;
        }
    }
    
    /**
     * Treat the "invite prompt playlist" option.
     *
     * @param mixed $invitePromptPlaylist
     * @return void
     * @throws Exception
     */
    protected function _treatInvitePromptListOption( $invitePromptPlaylist = null )
    {
        if ( null === $invitePromptPlaylist ) {
            throw new Exception( sprintf( 'Required option "%s" not provided', self::OPT_INVITE_PROMPT_PLAYLIST ) );
        }

        if ( !is_array( $invitePromptPlaylist ) ) {
            throw new Exception( sprintf( 'Invalid value provided for "%s" option', self::OPT_INVITE_PROMPT_PLAYLIST ) );
        }

        if ( empty( $invitePromptPlaylist ) ) {
            throw new Exception( sprintf( 'Empty playlist provided for "%s" option', self::OPT_INVITE_PROMPT_PLAYLIST ) );
        }

        $this->_options[self::OPT_INVITE_PROMPT_PLAYLIST] = $invitePromptPlaylist;
    }

    /**
     * Treat the "menu keys list" option.
     *
     * @param mixed $menuKeysList
     * @return void
     * @throws Exception
     */
    protected function _treatMenuKeysListOption( $menuKeysList = null )
    {
        if ( null === $menuKeysList ) {
            throw new Exception( sprintf( 'Required option "%s" not provided', self::OPT_MENU_KEYS_LIST ) );
        }

        if ( !is_array( $menuKeysList ) ) {
            throw new Exception( sprintf( 'Invalid value provided for "%s" option', self::OPT_MENU_KEYS_LIST ) );
        }

        $menuKeysList = array_map( 'strval', $menuKeysList );
        $intersection = array_intersect( $menuKeysList, Streamwide_Engine_Dtmf_Handler::getAllDtmfsList() );
        if ( count( $intersection ) !== count( $menuKeysList ) ) {
            throw new Exception( sprintf( 'Invalid keys provided in the keys list for "%s" option', self::OPT_MENU_KEYS_LIST ) );
        }

        $this->_options[self::OPT_MENU_KEYS_LIST] = $menuKeysList;
    }

    /**
     * Treat the "stop prompting on dtmf" option.
     *
     * @param mixed $stopPromptingOnDtmf
     * @return void
     */
    protected function _treatStopPromptingOnDtmfOption( $stopPromptingOnDtmf = null )
    {
        if ( null === $stopPromptingOnDtmf ) {
            return null;
        }
        
        if ( is_int( $stopPromptingOnDtmf ) || is_string( $stopPromptingOnDtmf ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to boolean', self::OPT_STOP_PROMPTING_ON_DTMF ) );
            $stopPromptingOnDtmf = (bool)$stopPromptingOnDtmf;
        }
        
        if ( is_bool( $stopPromptingOnDtmf ) ) {
            $this->_options[self::OPT_STOP_PROMPTING_ON_DTMF] = $stopPromptingOnDtmf;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_STOP_PROMPTING_ON_DTMF ) );
        }
    }

    /**
     * Treat the "wrong key prompt playlist".
     *
     * @param mixed $wrongKeyPromptPlaylist
     * @return void
     * @throws Exception
     */
    protected function _treatWrongKeyPromptPlaylist( $wrongKeyPromptPlaylist = null )
    {
        if ( null === $wrongKeyPromptPlaylist ) {
            return null;
        }

        if ( is_array( $wrongKeyPromptPlaylist ) ) {
            $this->_options[self::OPT_WRONG_KEY_PROMPT_PLAYLIST] = $wrongKeyPromptPlaylist;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_WRONG_KEY_PROMPT_PLAYLIST ) );
        }
    }

    /**
     * Treat the "no key prompt playlist" option.
     *
     * @param mixed $noKeyPromptPlaylist
     * @return void
     * @throws Exception
     */
    protected function _treatNoKeyPromptPlaylist( $noKeyPromptPlaylist = null )
    {
        if ( null === $noKeyPromptPlaylist ) {
            return null;
        }

        if ( is_array( $noKeyPromptPlaylist ) ) {
            $this->_options[self::OPT_NO_KEY_PROMPT_PLAYLIST] = $noKeyPromptPlaylist;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_NO_KEY_PROMPT_PLAYLIST ) );
        }
    }

    /**
     * Treat the "timeout" option.
     *
     * @param mixed $timeout
     * @return void
     */
    protected function _treatTimeoutOption( $timeout = null )
    {
        if ( null === $timeout ) {
            return null;
        }

        if ( is_int( $timeout ) ) {
            $timeout = (float)$timeout;
        } elseif ( is_string( $timeout ) && preg_match( '~^(?:0|[1-9][0-9]*)(?:\.[0-9]+)?$~', $timeout ) === 1 ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to float', self::OPT_TIMEOUT ) );
            $timeout = (float)$timeout;
        }

        if ( is_float( $timeout ) ) {
            $this->_options[self::OPT_TIMEOUT] = $timeout;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_TIMEOUT ) );
        }
    }

    /**
     * Treat the "tries" option
     *
     * @param mixed $tries
     * @return void
     */
    protected function _treatTriesOption( $tries = null )
    {
        if ( null === $tries ) {
            return null;
        }

        if ( is_float( $tries ) || ( is_string( $tries ) && preg_match( '~^(?:0|[1-9][0-9]*)(?:\.[0-9]+)?$~', $tries ) === 1 ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to integer', self::OPT_TRIES ) );
            $tries = (int)$tries;
        }

        if ( is_int( $tries ) && $tries > 0 ) {
            $this->_options[self::OPT_TRIES] = $tries;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_TRIES ) );
        }
    }

    /**
     * Initialize the default options
     *
     * @return void
     */
    protected function _initDefaultOptions()
    {
        $this->_options[self::OPT_STOP_PROMPTING_ON_DTMF] = self::STOP_PROMPTING_ON_DTMF_DEFAULT;
        $this->_options[self::OPT_WRONG_KEY_PROMPT_PLAYLIST] = array();
        $this->_options[self::OPT_NO_KEY_PROMPT_PLAYLIST] = array();
        $this->_options[self::OPT_TIMEOUT] = self::DEFAULT_TIMEOUT;
        $this->_options[self::OPT_TRIES] = self::DEFAULT_NUMBER_OF_TRIES;
    }
}


/* EOF */
