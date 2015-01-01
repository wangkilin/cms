<?php
/**
 *
 * $Rev: 2171 $
 * $LastChangedDate: 2009-12-07 17:47:29 +0800 (Mon, 07 Dec 2009) $
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
 * Allows playing of media
 */
class Streamwide_Engine_Media_Player extends Streamwide_Engine_Widget
{
    
    /**
     * States for this object
     */
    const STATE_READY = 'READY';
    const STATE_PLAYING = 'PLAYING';
    const STATE_STOPPED = 'STOPPED';
    const STATE_PAUSED = 'PAUSED';

    /**
     * Option names
     */
    const OPT_CLEAR_PLAYLIST_ON_STOP = 'clear_playlist_on_stop';

    /**
     * Default option values
     */
    const CLEAR_PLAYLIST_ON_STOP_DEFAULT = true;

    /**
     * Error codes
     *
     * MEDIAPLAYER-1xx errors refer to failures in sending a certain signal to the SW Engine
     * MEDIAPLAYER-2xx errors refer to internal errors
     * MEDIAPLAYER-3xx errors refer to state errors
     */
    const PLAY_SIGNAL_SEND_FAILURE_ERR_CODE = 'MEDIAPLAYER-100';
    const STOP_SIGNAL_SEND_FAILURE_ERR_CODE = 'MEDIAPLAYER-101';
    const PAUSE_SIGNAL_SEND_FAILURE_ERR_CODE = 'MEDIAPLAYER-102';
    const RESUME_SIGNAL_SEND_FAILURE_ERR_CODE = 'MEDIAPLAYER-103';
    const GOTO_SIGNAL_SEND_FAILURE_ERR_CODE = 'MEDIAPLAYER-104';
    const PLAYLIST_EMPTY_ERR_CODE = 'MEDIAPLAYER-200';
    const NOT_PLAYING_ERR_CODE = 'MEDIAPLAYER-300';
    const NOT_PAUSED_ERR_CODE = 'MEDIAPLAYER-301';
    const NOT_PLAYING_OR_PAUSED_ERR_CODE = 'MEDIAPLAYER-302';
    const ALREADY_PLAYING_ERR_CODE = 'MEDIAPLAYER-303';

    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::ERROR,
        Streamwide_Engine_Events_Event::PLAYING,
        Streamwide_Engine_Events_Event::FINISHED,
        Streamwide_Engine_Events_Event::STOPPED,
        Streamwide_Engine_Events_Event::PAUSED,
        Streamwide_Engine_Events_Event::RESUMED
    );
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::STOP_SIGNAL_SEND_FAILURE_ERR_CODE => 'Sending of signal STOP failed',
        self::PAUSE_SIGNAL_SEND_FAILURE_ERR_CODE => 'Sending of signal PAUSE failed',
        self::RESUME_SIGNAL_SEND_FAILURE_ERR_CODE => 'Sending of signal RESUME failed',
        self::PLAY_SIGNAL_SEND_FAILURE_ERR_CODE => 'Sending of signal PLAY failed',
        self::GOTO_SIGNAL_SEND_FAILURE_ERR_CODE => 'Sending of signal GOTO failed',
        self::PLAYLIST_EMPTY_ERR_CODE => 'Cannot PLAY, playlist empty',
        self::NOT_PLAYING_ERR_CODE => 'Media player not playing',
        self::NOT_PAUSED_ERR_CODE => 'Media player not paused',
        self::NOT_PLAYING_OR_PAUSED_ERR_CODE => 'Media player not paused or playing',
        self::ALREADY_PLAYING_ERR_CODE => 'Media player already playing'
    );

    /**
     * A created (alive) media server call leg
     *
     * @var string
     */
    protected $_mediaServerCallLeg;

    /**
     * The playlist to play
     *
     * @var array
     */
    protected $_playList = array();

    /**
     * Has the player received an EOF signal?
     *
     * @var boolean
     */
    protected $_eofReceived = false;

    /**
     * Constructor
     *
     * @param Streamwide_Engine_Media_Server_Call_Leg|null $mediaServerCallLeg
     */
    public function __construct( Streamwide_Engine_Media_Server_Call_Leg $mediaServerCallLeg = null )
    {
        parent::__construct();
        if ( null !== $mediaServerCallLeg ) {
            $this->setMediaServerCallLeg( $mediaServerCallLeg );
        }
        $this->setStateManager(
            new Streamwide_Engine_Widget_State_Manager(
                array(
                    self::STATE_READY,
                    self::STATE_PLAYING,
                    self::STATE_STOPPED,
                    self::STATE_PAUSED
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
        if ( isset( $this->_mediaServerCallLeg ) ) {
            unset( $this->_mediaServerCallLeg );
        }
        
        $this->_playList = array();
        
        parent::destroy();
    }
    
    /**
     * Provides default values for options supported by the player
     *
     * @param mixed $options
     * @return void
     */
    public function setOptions( Array $options )
    {
        $clearPlayListOnStop = isset( $options[self::OPT_CLEAR_PLAYLIST_ON_STOP] ) ? $options[self::OPT_CLEAR_PLAYLIST_ON_STOP] : null;
        $this->_treatClearPlaylistOnStopOption( $clearPlayListOnStop );
    }

    /**
     * Set the media server call leg used by this media player
     *
     * @param Streamwide_Engine_Media_Server_Call_Leg $mediaServerCallLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setMediaServerCallLeg( Streamwide_Engine_Media_Server_Call_Leg $mediaServerCallLeg )
    {
        if ( !$mediaServerCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an alive media server call leg' );
        }
        $this->_mediaServerCallLeg = $mediaServerCallLeg;
    }
    
    /**
     * Retrieve the media server call leg
     *
     * @return Streamwide_Engine_Media_Server_Call_Leg|null
     */
    public function getMediaServerCallLeg()
    {
        return $this->_mediaServerCallLeg;
    }
    
    /**
     * Play some media
     *
     * @return boolean
     * @throws RuntimeException
     */
    public function play()
    {
        if ( $this->isPlaying() ) {
            $this->dispatchErrorEvent( self::ALREADY_PLAYING_ERR_CODE );
            return false;
        }

        if ( $this->isPaused() ) {
        	return $this->resume();
        }

        // if no playlist has been provided dispatch an ERROR event
        if ( empty( $this->_playList ) ) {
            $this->dispatchErrorEvent( self::PLAYLIST_EMPTY_ERR_CODE );
            return false;
        }

        if ( null === $this->_mediaServerCallLeg ) {
            throw new RuntimeException( 'Media server call leg has not been set' );
        }
        
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::PLAY,
            $this->_mediaServerCallLeg->getName()
        );

        // send a PLAY signal for each item in the playlist
        $ret = false;
        foreach ( new ArrayIterator( $this->_playList ) as $file ) {
            $signal->setParams( $file->toArray() );
            // @TODO Determine the return value of the method based on the success of sending the signal to the SW Engine
            // For now, we return true if at least one signal is sent successfully
            if ( $signal->send() ) {
                $ret = true;
            }
        }

        // if the PLAY signal(s) could not be sent, dispatch an ERROR event and exit
        if ( false === $ret ) {
            $this->dispatchErrorEvent( self::PLAY_SIGNAL_SEND_FAILURE_ERR_CODE );
            return $ret;
        }

        $this->_eofReceived = false;

        // subscribe to the EOF signal
        $this->_subscribeToEngineEvents();

        // mark the widget as PLAYING
        $this->_stateManager->setState( self::STATE_PLAYING );

        // dispatch a PLAYER_PLAYING event
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::PLAYING ) );

        return true;
    }
    
    /**
     * Stop playing the currently played media
     *
     * @return boolean
     * @throws RuntimeException
     */
    public function stop()
    {
        if ( !$this->isPlaying() && !$this->isPaused() ) {
            $this->dispatchErrorEvent( self::NOT_PLAYING_OR_PAUSED_ERR_CODE );
            return false;
        }

        if ( null === $this->_mediaServerCallLeg ) {
            throw new RuntimeException( 'Media server call leg has not been set' );
        }
        
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::STOP,
            $this->_mediaServerCallLeg->getName()
        );
        
        // send the STOP signal
        // if the sending of the signal failed dispatch an ERROR event
        if ( false === $signal->send() ) {
            $this->dispatchErrorEvent( self::STOP_SIGNAL_SEND_FAILURE_ERR_CODE );
            return false;
        }

        // unsubscribe from the SIGNAL_IN_EOF event
        $this->_unsubscribeFromEngineEvents();

        // clear the playlist
        $this->clearPlaylist();

        // mark the widget as STOPPED
        $this->_stateManager->setState( self::STATE_STOPPED );

        // dispatch a PLAYER_STOPPED event
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::STOPPED ) );

        return true;
    }

    /**
     * Pause playing the currently played media
     *
     * @param array|null $options
     * @return boolean
     * @throws RuntimeException
     */
    public function pause()
    {
        if ( !$this->isPlaying() ) {
            $this->dispatchErrorEvent( self::NOT_PLAYING_ERR_CODE );
            return false;
        }

        if ( null === $this->_mediaServerCallLeg ) {
            throw new RuntimeException( 'Media server call leg has not been set' );
        }
        
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::PAUSE,
            $this->_mediaServerCallLeg->getName()
        );
        
        // send the PAUSE signal
        // if the sending of the signal failed dispatch an ERROR event
        if ( false === $signal->send() ) {
            $this->dispatchErrorEvent( self::PAUSE_SIGNAL_SEND_FAILURE_ERR_CODE );
            return false;
        }

        // mark the widget as paused
        $this->_stateManager->setState( self::STATE_PAUSED );

        // dispatch a PLAYER_PAUSED event
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::PAUSED ) );

        return true;
    }

    /**
     * Resume playing the currently paused media
     *
     * @return boolean
     * @throws RuntimeException
     */
    public function resume()
    {
        if ( !$this->isPaused() ) {
            $this->dispatchErrorEvent( self::NOT_PAUSED_ERR_CODE );
        	return false;
        }

        if ( null === $this->_mediaServerCallLeg ) {
            throw new RuntimeException( 'Media server call leg has not been set' );
        }
        
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::RESUME,
            $this->_mediaServerCallLeg->getName()
        );
        
        // send the RESUME signal
        // if the sending of the signal failed dispatch an ERROR event
        if ( false === $signal->send() ) {
            $this->dispatchErrorEvent( self::RESUME_SIGNAL_SEND_FAILURE_ERR_CODE );
            return false;
        }

        // mark the widget as PLAYING
        $this->_stateManager->setState( self::STATE_PLAYING );

        // dispatch an PLAYER_RESUMED event
        $this->dispatchEvent( new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::RESUMED ) );

        return true;
    }

    /**
     * Go forward or backward in the play of the currently played media
     *
     * @param integer $amount
     * @param integer $direction Defaults to 1 (go forward)
     * @return boolean
     * @throws RuntimeException
     */
    public function goto( $amount, $direction = 1 )
    {
        if ( !$this->isPlaying() && !$this->isPaused() ) {
        	$this->dispatchErrorEvent( self::NOT_PLAYING_OR_PAUSED_ERR_CODE );
            return false;
        }

        if ( is_float( $amount ) || ( is_string( $amount ) && preg_match( '~^[1-9][0-9]*$~', $amount ) === 1 ) ) {
            $amount = (int)$amount;
        }

        if ( !is_int( $amount ) || $amount < 1 ) {
            return false;
        }

        if ( !is_int( $direction ) ) {
            $direction = 1;
        }

        if ( $direction > 0 ) {
            $gotoAmount = sprintf( '+%d', $amount );
        } elseif ( $direction < 0 ) {
        	$gotoAmount = sprintf( '-%d', $amount );
        } else {
        	$gotoAmount = sprintf( '%d', $amount );
        }

        if ( null === $this->_mediaServerCallLeg ) {
            throw new RuntimeException( 'Media server call leg has not been set' );
        }
        
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::GOTO,
            $this->_mediaServerCallLeg->getName(),
            array( 'time' => $gotoAmount )
        );
        
        // send the GOTO signal
        // if the sending of the signal failed dispatch an ERROR event
        if ( false === $signal->send() ) {
            $this->dispatchErrorEvent( Streamwide_Engine_Media_Player::GOTO_SIGNAL_SEND_FAILURE_ERR_CODE );
            return false;
        }

        return true;
    }

    /**
     * Handle the EOF signal from SW Engine
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    public function onEof( Streamwide_Engine_Events_Event $event )
    {
        // raise the eofReceived flag
        $this->_eofReceived = true;

        // clear the playlist (if this option is activated)
        $this->clearPlaylist();

        // mark the widget as READY
        $this->_stateManager->setState( self::STATE_READY );

        // dispatch a PLAYER_FINISHED event
        $signal = $event->getParam( 'signal' );
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::FINISHED );
        $event->setParam( 'signal', $signal );
        $this->dispatchEvent( $event );
    }

    /**
     * Gives the media player a playlist to play
     *
     * @param array $playlist
     */
    public function setPlaylist( Array $playlist )
    {
    	$this->_playList = $playlist;
    }

    /**
     * Appends a media object to playlist
     *
     * @param Streamwide_Engine_Media $file
     * @return void
     */
    public function appendToPlaylist( Streamwide_Engine_Media $file )
    {
    	$this->_playList[] = $file;
    }

    /**
     * Get the last set playlist
     *
     * @return array
     */
    public function getPlaylist()
    {
    	return $this->_playList;
    }

    /**
     * Is the media player playing?
     *
     * @return boolean
     */
    public function isPlaying()
    {
        return ( $this->_stateManager->getState() === self::STATE_PLAYING );
    }

    /**
     * Is the media player paused?
     *
     * @return boolean
     */
    public function isPaused()
    {
        return ( $this->_stateManager->getState() === self::STATE_PAUSED );
    }

    /**
     * Is the media player stopped?
     *
     * @return boolean
     */
    public function isStopped()
    {
        return ( $this->_stateManager->getState() === self::STATE_STOPPED );
    }

    /**
     * Is the media player ready?
     *
     * @return boolean
     */
    public function isReady()
    {
    	return ( $this->_stateManager->getState() === self::STATE_READY );
    }

    /**
     * Empty the playlist
     *
     * @param boolean $force Forces the clearing of the playlist
     * @return void
     */
    public function clearPlaylist( $force = false )
    {
        if ( true === $force ) {
        	$this->_playList = array();
        } else {
            $clearPlayListOnStop = $this->_options[self::OPT_CLEAR_PLAYLIST_ON_STOP];
            if ( true === $clearPlayListOnStop ) {
                $this->_playList = array();
            }
        }
    }

    /**
     * Has an EOF signal been received?
     *
     * @return boolean
     */
    public function hasReceivedEof()
    {
    	return $this->_eofReceived;
    }

    /**
     * Reset the player
     *
     * @return void
     */
    public function reset()
    {
        parent::reset();
        
        if ( $this->isPlaying() || $this->isPaused() ) {
        	$this->stop();
        }
        
        if ( !$this->isReady() ) {
            $this->_stateManager->setState( self::STATE_READY );
        }
        
        $this->_playList = array();
        $this->_eofReceived = false;
    }

    /**
     * Subscribe to the EOF signal from SW Engine
     *
     * @return void
     */
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        
        $eofNotifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_mediaServerCallLeg->getName()
        );
        $controller->addEventListener(
            Streamwide_Engine_Events_Event::EOF,
            array(
                'callback' => array( $this, 'onEof' ),
                'options' => array(
                    'autoRemove' => 'before',
                    'notifyFilter' => $eofNotifyFilter
                )
            )
        );
    }
    
    /**
     * Unsubscribe from the EOF signal from SW Engine
     *
     * @return void
     */
    protected function _unsubscribeFromEngineEvents()
    {
        $controller = $this->getController();
        $controller->removeEventListener(
            Streamwide_Engine_Events_Event::EOF,
            array( 'callback' => array( $this, 'onEof' ) )
        );
    }

    /**
     * Treat the clearPlaylistOnStop option
     *
     * @param mixed $clearPlaylistOnStop
     * @return boolean
     */
    protected function _treatClearPlaylistOnStopOption( $clearPlayListOnStop = null )
    {
    	if ( null === $clearPlayListOnStop ) {
            // exit and use the default value
            return null;
    	}

        if ( is_int( $clearPlayListOnStop ) || is_string( $clearPlayListOnStop ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to boolean', self::OPT_CLEAR_PLAYLIST_ON_STOP ) );
            $clearPlayListOnStop = (bool)$clearPlayListOnStop;
        }

        if ( is_bool( $clearPlayListOnStop ) ) {
            $this->_options[self::OPT_CLEAR_PLAYLIST_ON_STOP] = $clearPlayListOnStop;
        } else {
        	trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_CLEAR_PLAYLIST_ON_STOP ) );
        }
    }

    /**
     * Initialize the default options
     *
     * @return void
     */
    protected function _initDefaultOptions()
    {
        $this->_options[self::OPT_CLEAR_PLAYLIST_ON_STOP] = self::CLEAR_PLAYLIST_ON_STOP_DEFAULT;
    }

}

/* EOF */
