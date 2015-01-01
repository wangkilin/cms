<?php
/**
 *
 * $Rev: 2560 $
 * $LastChangedDate: 2010-04-23 15:49:53 +0800 (Fri, 23 Apr 2010) $
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
 * Reads a number inputed by a user from the dial pad
 */
class Streamwide_Engine_Number_Reader extends Streamwide_Engine_Widget
{

    /**
     * Option names
     */
    const OPT_INVITE_PROMPT_PLAYLIST = 'invite_prompt_playlist';
    const OPT_STOP_PROMPTING_ON_DTMF = 'stop_prompting_on_dtmf';
    const OPT_NO_INPUT_PROMPT_PLAYLIST = 'no_input_prompt_playlist';
    const OPT_FIRST_DIGIT_TIMEOUT = 'first_digit_timeout';
    const OPT_INTER_DIGIT_TIMEOUT = 'inter_digit_timeout';
    const OPT_END_READING_KEY = 'end_reading_key';
    const OPT_RETURN_ALL_INPUT = 'return_all_input';
    const OPT_TRIES = 'tries';

    /**
     * Default option values
     */
    const STOP_PROMPTING_ON_DTMF_DEFAULT = true;
    const RETURN_ALL_INPUT_DEFAULT = true;
    const DEFAULT_NUMBER_OF_TRIES = 3;

    /**
     * Error codes
     */
    const BAD_TRY_ERR_CODE = 'NUMBERREADER-200';
    const NO_TRIES_LEFT_ERR_CODE = 'NUMBERREADER-201';
    
    /**
     * Prompt types
     */
    const PROMPT_INVITE = 'INVITE';
    const PROMPT_NO_INPUT = 'NO_INPUT';
    
    /**
     * Timeout types
     */
    const TIMEOUT_INTERDIGIT = 'INTERDIGIT';
    const TIMEOUT_FIRSTDIGIT = 'FIRSTDIGIT';

    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::ERROR,
        Streamwide_Engine_Events_Event::FINISHED
    );
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::NO_TRIES_LEFT_ERR_CODE => 'No tries left'
    );

    /**
     * Dtmf handler widget
     *
     * @var Streamwide_Engine_Dtmf_Handler
     */
    protected $_dtmfHandler;

    /**
     * Timeout timer widget
     *
     * @var Streamwide_Engine_Timer_Timeout
     */
    protected $_timer;

    /**
     * Media player widget
     *
     * @var Streamwide_Engine_Media_Player
     */
    protected $_mediaPlayer;

    /**
     * Counter widget
     *
     * @var Streamwide_Engine_Counter
     */
    protected $_counter;

    /**
     * The number read from user input
     *
     * @var string
     */
    protected $_number = '';

    /**
     * The numbers entered by the user between tries
     *
     * @var array
     */
    protected $_history = array();
    
    /**
     * Was the number reader initialized
     *
     * @var boolean
     */
    protected $_numberReaderInitialized = false;

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
     * Provide option defaults
     *
     * @param array $options
     * @return void
     */
    public function setOptions( Array $options )
    {
        $invitePromptPlaylist = isset( $options[self::OPT_INVITE_PROMPT_PLAYLIST] ) ? $options[self::OPT_INVITE_PROMPT_PLAYLIST] : null;
        $this->_treatInvitePromptPlaylistOption( $invitePromptPlaylist );

        $stopPromptingOnDtmf = isset( $options[self::OPT_STOP_PROMPTING_ON_DTMF] ) ? $options[self::OPT_STOP_PROMPTING_ON_DTMF] : null;
        $this->_treatStopPromptingOnDtmfOption( $stopPromptingOnDtmf );

        $noInputPromptPlaylist = isset( $options[self::OPT_NO_INPUT_PROMPT_PLAYLIST] ) ? $options[self::OPT_NO_INPUT_PROMPT_PLAYLIST] : null;
        $this->_treatNoInputPromptPlaylistOption( $noInputPromptPlaylist );

        $firstDigitTimeout = isset( $options[self::OPT_FIRST_DIGIT_TIMEOUT] ) ? $options[self::OPT_FIRST_DIGIT_TIMEOUT] : null;
        $this->_treatFirstDigitTimeoutOption( $firstDigitTimeout );

        $interDigitTimeout = isset( $options[self::OPT_INTER_DIGIT_TIMEOUT] ) ? $options[self::OPT_INTER_DIGIT_TIMEOUT] : null;
        $this->_treatInterDigitTimeoutOption( $interDigitTimeout );

        $endReadingKey = isset( $options[self::OPT_END_READING_KEY] ) ? $options[self::OPT_END_READING_KEY] : null;
        $this->_treatEndReadingKeyOption( $endReadingKey );

        $returnAllInput = isset( $options[self::OPT_RETURN_ALL_INPUT] ) ? $options[self::OPT_RETURN_ALL_INPUT] : null;
        $this->_treatReturnAllInputOption( $returnAllInput );

        $tries = isset( $options[self::OPT_TRIES] ) ? $options[self::OPT_TRIES] : null;
        $this->_treatTriesOption( $tries );
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
     * Retrieve the number read from user input
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->_number;
    }

    /**
     * Retrieve the list with the number(s) entered by the user between tries
     *
     * @return array
     */
    public function getHistory()
    {
        return $this->_history;
    }

    /**
     * Reset the widget
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
        $this->_number = '';
        $this->_history = array();
    }

    /**
     * Start the reading process
     *
     * @return boolean
     */
    public function startReading()
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
     * Deal with the user running out tries
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onNoTriesLeft( Streamwide_Engine_Events_Event $event )
    {
        $this->dispatchErrorEvent( self::NO_TRIES_LEFT_ERR_CODE );
    }
    
    /**
     * Deal with a key press from the user
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onKeyPressed( Streamwide_Engine_Events_Event $event )
    {
        $key = $event->getParam( 'receivedKey' );
        $promptType = $event->getContextParam( 'promptType' );
        if ( $this->_isEndKey( $key ) ) {
            $this->_timer->reset();
            $this->_mediaPlayer->reset();
            $this->_dtmfHandler->reset();
            $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::FINISHED );
            $event->setParam( 'number', $this->_number );
            $this->dispatchEvent( $event );
        } else {
            $this->_number .= $key;
            $this->_rearmTimer();
            if ( null !== $promptType ) {
                if ( self::PROMPT_INVITE === $promptType ) {
                    if ( $this->_shouldStopPromptingOnDtmf() ) {
                        $this->_mediaPlayer->stop();
                    }
                } else {
                    $this->_mediaPlayer->stop();
                }
            }
        }
    }
    
    /**
     * Deal with the finishing of the invite prompt
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onInvitePromptFinished( Streamwide_Engine_Events_Event $event )
    {
        $this->_armTimer();
        if ( !$this->_dtmfHandler->isListening() ) {
            $this->_listenForKeyPresses();
        }
    }
    
    /**
     * Deal with the finishing of the no input prompt
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onNoInputPromptFinished( Streamwide_Engine_Events_Event $event )
    {
        $this->_retry( false );
    }
    
    /**
     * Deal with the 2 possible timeout types
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onTimeout( Streamwide_Engine_Events_Event $event )
    {
        $timeoutType = $event->getContextParam( 'timeoutType' );
        if ( self::TIMEOUT_FIRSTDIGIT === $timeoutType ) {
            $shouldPromptOnNoInput = !empty( $this->_options[self::OPT_NO_INPUT_PROMPT_PLAYLIST] );
            if ( $shouldPromptOnNoInput ) {
                $this->_saveTry();
                $this->_counter->decrement();
                if ( $this->_counter->hasMoreTries() ) {
                    $this->_listenForKeyPresses( self::PROMPT_NO_INPUT );
                    $this->_playNoInputPrompt();
                } else {
                    $this->dispatchErrorEvent( self::NO_TRIES_LEFT_ERR_CODE );
                }
            } else {
                $this->_retry();
            }
        } elseif ( self::TIMEOUT_INTERDIGIT === $timeoutType ) {
            $this->_timer->reset();
            $this->_mediaPlayer->reset();
            $this->_dtmfHandler->reset();
            $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::FINISHED );
            $event->setParam( 'number', $this->_number );
            $this->dispatchEvent( $event );
        } else {
            throw new RuntimeException( 'Invalid context' );
        }
    }
    
    /**
     * Initialize the number reader widget (meaning initialize
     * the dependencies)
     *
     * @return void
     */
    protected function _init()
    {
        $this->_number = '';
        if ( !$this->_numberReaderInitialized ) {
            $this->_initCounter();
            $this->_initTimer();
            $this->_initDtmfHandler();
            $this->_initMediaPlayer();
            $this->_numberReaderInitialized = true;
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
        $timeout = $this->_options[self::OPT_FIRST_DIGIT_TIMEOUT];
        $this->_timer->setOptions( array( Streamwide_Engine_Timer_Timeout::OPT_DELAY => $timeout ) );
    }
    
    /**
     * Initialize the dtmf handler widget
     *
     * @return void
     */
    protected function _initDtmfHandler()
    {
        $this->_dtmfHandler->reset();
        $endReadingKey = $this->_options[self::OPT_END_READING_KEY];
        $currentHandlerOptions = $this->_dtmfHandler->getOptions();
        $options = array(
            // listen to all numeric key presses, as well as star and sharp keys (star key "*" is used
            // for decimal parts, and sharp key "#" is usually used to signal the ending of input)
            Streamwide_Engine_Dtmf_Handler::OPT_ALLOWED_DTMFS => array_values(
                array_diff(
                    Streamwide_Engine_Dtmf_Handler::getAllDtmfsList(),
                    array(
                        Streamwide_Engine_Dtmf_Handler::KEY_A,
                        Streamwide_Engine_Dtmf_Handler::KEY_B,
                        Streamwide_Engine_Dtmf_Handler::KEY_C,
                        Streamwide_Engine_Dtmf_Handler::KEY_D
                    )
                )
            ),
            // don't dispatch an event on wrong key
            Streamwide_Engine_Dtmf_Handler::OPT_SIGNAL_WRONG_KEY => false,
            // no limit for the received dtmfs
            Streamwide_Engine_Dtmf_Handler::OPT_RECEIVED_DTMFS_LIMIT => 0,
            // stop listening on a single key to indicate that the user has finished inputing
            // the number
            Streamwide_Engine_Dtmf_Handler::OPT_STOP_LISTENING_ON_KEY => array( $endReadingKey )
        );
        $options = array_merge( $currentHandlerOptions, $options );
        $this->_dtmfHandler->setOptions( $options );
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
     * Has the end key been received?
     *
     * @param string $key
     * @return boolean
     */
    protected function _isEndKey( $key )
    {
        $endReadingKey = $this->_options[self::OPT_END_READING_KEY];
        return ( 0 === strcmp( $key, $endReadingKey ) );
    }
    
    /**
     * Should we stop the invite prompt if a key has been pressed?
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
     * Give the user another chance
     *
     * @return boolean
     */
    protected function _retry( $decrement = true )
    {
        if ( true === $decrement ) {
            $this->_saveTry();
            $this->_counter->decrement();
        }
        if ( $this->_counter->hasMoreTries() ) {
            $this->_timer->reset();
            $this->_mediaPlayer->reset();
            $this->_dtmfHandler->reset();
            
            $this->dispatchErrorEvent( self::BAD_TRY_ERR_CODE );
            return $this->startReading();
        } else {
            $this->dispatchErrorEvent( self::NO_TRIES_LEFT_ERR_CODE );
            return false;
        }
    }
    
    /**
     * Save an attempt to input a number
     *
     * @return void
     */
    protected function _saveTry()
    {
        $this->_history[] = $this->_number;
    }
    
    /**
     * Start listening for key presses
     *
     * @param string|null $promptType
     * @return boolean
     */
    protected function _listenForKeyPresses( $promptType = null )
    {
        $this->_dtmfHandler->reset();
        $this->_dtmfHandler->setContextParams( array( 'promptType' => $promptType ) );
        $this->_dtmfHandler->addEventListener(
            Streamwide_Engine_Events_Event::KEY,
            array( 'callback' => array( $this, 'onKeyPressed' ) )
        );
        $listening = $this->_dtmfHandler->startListening();
        if ( !$listening ) {
            $this->_dtmfHandler->flushEventListeners();
        }
        
        return $listening;
    }
    
    /**
     * Play the invite prompt
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
     * Play the no input prompt
     *
     * @return boolean
     */
    protected function _playNoInputPrompt()
    {
        $noInputPromptPlaylist = $this->_options[self::OPT_NO_INPUT_PROMPT_PLAYLIST];
        $this->_mediaPlayer->reset();
        $this->_mediaPlayer->addEventListener(
            Streamwide_Engine_Events_Event::FINISHED,
            array(
                'callback' => array( $this, 'onNoInputPromptFinished' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $this->_mediaPlayer->setPlaylist( $noInputPromptPlaylist );
        $playing = $this->_mediaPlayer->play();
        if ( !$playing ) {
            $this->_mediaPlayer->flushEventListeners();
        }
        
        return $playing;
    }
    
    /**
     * Arm the timer
     *
     * @return boolean
     */
    protected function _armTimer()
    {
        $this->_timer->addEventListener(
            Streamwide_Engine_Events_Event::TIMEOUT,
            array(
                'callback' => array( $this, 'onTimeout' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        $this->_timer->setContextParams( array( 'timeoutType' => self::TIMEOUT_FIRSTDIGIT ) );
        $armed = $this->_timer->arm();
        if ( !$armed ) {
            $this->_timer->flushEventListeners();
        }
        
        return $armed;
    }
    
    /**
     * Rearm the timer
     *
     * @return boolean
     */
    protected function _rearmTimer()
    {
        $delay = $this->_options[self::OPT_INTER_DIGIT_TIMEOUT];
        $this->_timer->setContextParams( array( 'timeoutType' => self::TIMEOUT_INTERDIGIT ) );
		if ( $this->_timer->isArmed() ) {
            return $this->_timer->rearm( $delay );
		} else {
        	$this->_timer->setOptions( array( Streamwide_Engine_Timer_Timeout::OPT_DELAY => $delay ) );
			$this->_timer->addEventListener(
				Streamwide_Engine_Events_Event::TIMEOUT,
				array(
					'callback' => array( $this, 'onTimeout' ),
					'options' => array( 'autoRemove' => 'before' )
				)
			);
	       	return $this->_timer->arm();
		}
    }
    
    /**
     * Treat the "invite prompt playlist" option. The "invite prompt playlist" option represents the media that asks the user to enter
     * a number. This option must be provided (REQUIRED). This option must be provided as an array of objects of type
     * "Streamwide_Engine_Media" (or derived from "Streamwide_Engine_Media") (a wrong format will cause an Exception to
     * be thrown).
     *
     * @param mixed $promptPlaylist
     * @return array
     * @throws Exception
     */
    protected function _treatInvitePromptPlaylistOption( $invitePromptPlaylist = null )
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
     * Treat the "stop prompting on dtmf" option. This option tells us whether or not to stop prompting the media that
     * asks the user to enter a number when a dtmf is received while the media is playing. This option doesn't have to
     * be provided (OPTIONAL). If not provided it defaults to "true" (meaning that we will stop playing the media if
     * a key is received during playing). Must be provided as a boolean datatype. Integers and strings are also acceptable
     * and will be casted to the boolean datatype. If you provide a integer or string make sure you know what the casting to
     * the boolean datatype will give you (int(0) cast to boolean will result in the value boolean(false), any other integer
     * will result in the boolean(true) value. Empty string '' will result in the value boolean(false), any other string will
     * result in the boolean(true) value). Any other datatype (besides boolean, string or integer) will cause the default value
     * to be used.
     *
     * @param mixed $stopPromptingOnDtmf
     * @return boolean
     */
    protected function _treatStopPromptingOnDtmfOption( $stopPromptingOnDtmf = null )
    {
        if ( null === $stopPromptingOnDtmf ) {
            // exit and use the default value
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
     * Treat the "no input prompt playlist" option. This option represents the media to play to the user when he didn't
     * provide us with any input. This option must be provided only if the "prompt on no input" option is set to "true".
     * If it doesn't need to be provided and it's not provided it defaults to an empty array. Must be provided as an array
     * of objects of type "Streamwide_Engine_Media" (or derived from "Streamwide_Engine_Media"). Other datatypes (besides an
     * array) will cause an Exception to be thrown.
     *
     * @param mixed $noInputPromptPlaylist
     * @return array
     */
    protected function _treatNoInputPromptPlaylistOption( $noInputPromptPlaylist = null )
    {
        if ( null === $noInputPromptPlaylist ) {
            // exit and use the default value
            return null;
        }

        if ( is_array( $noInputPromptPlaylist ) ) {
            $this->_options[self::OPT_NO_INPUT_PROMPT_PLAYLIST] = $noInputPromptPlaylist;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_NO_INPUT_PROMPT_PLAYLIST ) );
        }
    }

    /**
     * Treat the "first digit timeout" option. This option tells us how much do we have to wait the user to press
     * the first key before we consider the current iteration a failed try. This option must be provided (REQUIRED).
     * Must be provided as integer greater than 0. Floats and numeric string are also acceptable and will be casted to integer.
     * If you provide a float or a numeric string make sure you know what value the integer cast will produce.
     * Any other datatype (besides integer, float, numeric string) or invalid values will cause an Exception to be thrown.
     *
     * @param mixed $firstDigitTimeout
     * @return float
     * @throws Exception
     */
    protected function _treatFirstDigitTimeoutOption( $firstDigitTimeout = null )
    {
        if ( null === $firstDigitTimeout ) {
            throw new Exception( sprintf( 'Required option "%s" not provided', self::OPT_FIRST_DIGIT_TIMEOUT ) );
        }

        if ( is_int( $firstDigitTimeout ) ) {
            $firstDigitTimeout = (float)$firstDigitTimeout;
        } elseif ( is_string( $firstDigitTimeout ) && preg_match( '~^(?:0|[1-9][0-9]*)(?:\.[0-9]+)?$~', $firstDigitTimeout ) === 1 ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to float', self::OPT_FIRST_DIGIT_TIMEOUT ) );
            $firstDigitTimeout = (float)$firstDigitTimeout;
        }

        if ( !is_float( $firstDigitTimeout ) ) {
            throw new Exception( sprintf( 'Option "%s" was provided with an invalid value', self::OPT_FIRST_DIGIT_TIMEOUT ) );
        }

        $this->_options[self::OPT_FIRST_DIGIT_TIMEOUT] = $firstDigitTimeout;
    }

    /**
     * Treat the "inter digit timeout" option. This option tells us how much do we have to wait the user to press
     * the next key before we consider the current iteration finished. This option must be provided (REQUIRED).
     * Must be provided as integer greater than 0. Floats and numeric string are also acceptable and will be casted to integer.
     * If you provide a float or a numeric string make sure you know what value the integer cast will produce.
     * Any other datatype (besides integer, float, numeric string) or invalid values will cause an Exception to be thrown.
     *
     * @param mixed $interDigitTimeout
     * @return float
     * @throws Exception
     */
    protected function _treatInterDigitTimeoutOption( $interDigitTimeout = null )
    {
        if ( null === $interDigitTimeout ) {
            throw new Exception( sprintf( 'Required option "%s" not provided', self::OPT_INTER_DIGIT_TIMEOUT ) );
        }
        
        if ( is_int( $interDigitTimeout ) ) {
            $interDigitTimeout = (float)$interDigitTimeout;
        } elseif ( is_string( $interDigitTimeout ) && preg_match( '~^(?:0|[1-9][0-9]*)(?:\.[0-9]+)?$~', $interDigitTimeout ) === 1 ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to float', self::OPT_INTER_DIGIT_TIMEOUT ) );
            $interDigitTimeout = (float)$interDigitTimeout;
        }

        if ( !is_float( $interDigitTimeout ) ) {
            throw new Exception( sprintf( 'Option "%s" was provided with an invalid value', self::OPT_INTER_DIGIT_TIMEOUT ) );
        }

        $this->_options[self::OPT_INTER_DIGIT_TIMEOUT] = $interDigitTimeout;
    }

    /**
     * Treat the "end reading key" option. This option represents the key that will stop the reading process.
     * This option doesn't have to be provided (OPTIONAL). If not provided it defaults to the "#" (pound) key.
     * Must be provided as a string of length equal to 1 and must be a valid key on the dial pad of a phone.
     * An invalid value or datatype will cause the default value to be used.
     *
     * @param mixed $endReadingKey
     * @return string
     */
    protected function _treatEndReadingKeyOption( $endReadingKey = null )
    {
        if ( null === $endReadingKey ) {
            // exit and use the default value
            return null;
        }

        $valid = (
            is_string( $endReadingKey )
            && strlen( $endReadingKey ) === 1
            && in_array( $endReadingKey, Streamwide_Engine_Dtmf_Handler::getAllDtmfsList() )
        );

        if ( $valid ) {
            $this->_options[self::OPT_END_READING_KEY] = $endReadingKey;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_END_READING_KEY ) );
        }
    }

    /**
     * Treat the "return all input" option. This options tells us whether or not to return all input
     * received from the user. This option doesn't have to be provided (OPTIONAL). If not provided it
     * defaults to true. When set to false it will return only the numeric input from the user.
     * Must be provided as a boolean datatype. Integers and strings are also acceptable and will be casted
     * to the boolean datatype. If you provide a integer or string make sure you know what the casting to
     * the boolean datatype will give you (int(0) cast to boolean will result in the value boolean(false),
     * any other integer will result in the boolean(true) value. Empty string '' will result in the value
     * boolean(false), any other string will result in the boolean(true) value). Any other datatype (besides
     * boolean, string or integer) will cause the default value to be used.
     *
     * @param mixed $returnAllInput
     * @return boolean
     */
    protected function _treatReturnAllInputOption( $returnAllInput = null )
    {
        if ( null === $returnAllInput ) {
            // exit and use the default value
            return null;
        }

        if ( is_int( $returnAllInput ) || is_string( $returnAllInput ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to boolean', self::OPT_RETURN_ALL_INPUT ) );
            $returnAllInput = (bool)$returnAllInput;
        }

        if ( is_bool( $returnAllInput ) ) {
            $this->_options[self::OPT_RETURN_ALL_INPUT] = $returnAllInput;
        } else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_RETURN_ALL_INPUT ) );
        }
    }

    /**
     * Treat the "tries" option
     *
     * @param mixed $tries
     * @return integer
     */
    protected function _treatTriesOption( $tries = null )
    {
        if ( null === $tries ) {
            // exit and use the default value
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
        $this->_options[self::OPT_NO_INPUT_PROMPT_PLAYLIST] = array();
        $this->_options[self::OPT_END_READING_KEY] = Streamwide_Engine_Dtmf_Handler::KEY_POUND;
        $this->_options[self::OPT_RETURN_ALL_INPUT] = self::RETURN_ALL_INPUT_DEFAULT;
        $this->_options[self::OPT_TRIES] = self::DEFAULT_NUMBER_OF_TRIES;
    }

}


/* EOF */
