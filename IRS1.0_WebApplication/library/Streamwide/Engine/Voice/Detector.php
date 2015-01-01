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

class Streamwide_Engine_Voice_Detector extends Streamwide_Engine_Detector
{

    /// === Start option names declaration === ///
    
    /**
     * The amount of time (in seconds) before giving up if no voice activity
     * is detected. Closely related with determining if the VOICE_NOT_DETECTED event
     * should be dispatched. Defaults to -1 (which means that detection will last
     * indefinetely)
     *
     * @var float
     */
    const OPT_DETECTION_DURATION = 'detection_duration';
    
    /**
     * The minimum amount of time (in miliseconds) that the level of noise should be above
     * the threshold to allow the Engine to send the VOICE_DETECTED signal. Defaults to
     * 200 miliseconds
     *
     * @var integer
     */
    const OPT_MINIMUM_VOICE_ACTIVITY_DURATION = 'minimum_voice_activity_duration';
    
    /**
     * The level of noise (in decibels) that constitutes voice activity. Defaults to
     * 0.0 dB.
     *
     * @var float
     */
    const OPT_THRESHOLD = 'threshold';
    
    /// === End option names declaration === ///
    
    
    
    /// === Start options default values declaration === ///
    
    /**
     * The default value for detection duration option.
     *
     * @var integer
     */
    const DEFAULT_DETECTION_DURATION = -1;
    
    /**
     * The default value for minimum voice activity duration option.
     *
     * @var integer
     */
    const DEFAULT_MINIMUM_VOICE_ACTIVITY_DURATION = 200;
    
    /**
     * The default value for the threshold option.
     *
     * @var float
     */
    const DEFAULT_THRESHOLD = 0.0;
    
    /// === End options default values declaration === ///
    
    
    
    /// === Start error codes declaration === ///
    
    /**
     * Unable to send the SET signal to SW Engine
     *
     * @var string
     */
    const SET_SIGNAL_SEND_ERR_CODE = 'VOICEDETECTOR-100';
    
    /**
     * Call leg died in the middle of the detection process
     *
     * @var string
     */
    const CALL_LEG_DIED_ERR_CODE = 'VOICEDETECTOR-200';
    
    /**
     * An attempt was made to start the detection process, while the widget was already in the middle
     * of another detection proces
     *
     * @var string
     */
    const ALREADY_DETECTING_ERR_CODE = 'VOICEDETECTOR-300';
    
    /**
     * An attempt was made to stop the detection process, but the widget was not in the middle of
     * another detection process
     *
     * @var string
     */
    const NOT_DETECTING_ERR_CODE = 'VOICEDETECTOR-301';
    
    /**
     * An attempt was made to start or stop the detection process, but the media server call leg is dead
     *
     * @var string
     */
    const DEAD_CALL_LEG_ERR_CODE = 'VOICEDETECTOR-302';
    
    /// === End error codes declaration === ///
    
    
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::SET_SIGNAL_SEND_ERR_CODE => 'Unable to send SET signal to SW Engine',
        self::CALL_LEG_DIED_ERR_CODE => 'The media server call leg died in the middle of the voice detection process',
        self::ALREADY_DETECTING_ERR_CODE => 'The voice detector is already running',
        self::NOT_DETECTING_ERR_CODE => 'The voice detector is not running',
        self::DEAD_CALL_LEG_ERR_CODE => 'Attempt to start/stop the detection process on a dead media server call leg',
    );
    
    /**
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::VOICE_DETECTION_STARTED,
        Streamwide_Engine_Events_Event::VOICE_DETECTION_STOPPED,
        Streamwide_Engine_Events_Event::VOICE_DETECTED,
        Streamwide_Engine_Events_Event::VOICE_NOT_DETECTED,
        Streamwide_Engine_Events_Event::ERROR
    );
    
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->_detectorName = self::T_VAD;
        $this->_detectionGoalAttainedEventName = Streamwide_Engine_Events_Event::VOICE_DETECTED;
        $this->_detectionGoalUnattainedEventName = Streamwide_Engine_Events_Event::VOICE_NOT_DETECTED;
        $this->_detectionStartedEventName = Streamwide_Engine_Events_Event::VOICE_DETECTION_STARTED;
        $this->_detectionStoppedEventName = Streamwide_Engine_Events_Event::VOICE_DETECTION_STOPPED;
        
        $this->_initDefaultOptions();
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#setOptions($options)
     */
    public function setOptions( Array $options )
    {
        $detectionDuration = isset( $options[self::OPT_DETECTION_DURATION] )
            ? $options[self::OPT_DETECTION_DURATION]
            : null;
        $this->_treatDetectionDurationOption( $detectionDuration );
        
        $minimumVoiceActivityDuration = isset( $options[self::OPT_MINIMUM_VOICE_ACTIVITY_DURATION] )
            ? $options[self::OPT_MINIMUM_VOICE_ACTIVITY_DURATION]
            : null;
        $this->_treatMinimumVoiceActivityDurationOption( $minimumVoiceActivityDuration );
        
        $threshold = isset( $options[self::OPT_THRESHOLD] )
            ? $options[self::OPT_THRESHOLD]
            : null;
        $this->_treatThresholdOption( $threshold );
    }
    
    /**
     * @see Engine/Streamwide_Engine_Detector#onCallLegDeath($event, $errorCode)
     */
    public function onCallLegDeath( Streamwide_Engine_Events_Event $event )
    {
        return parent::onCallLegDeath( $event, self::CALL_LEG_DIED_ERR_CODE );
    }
    
    /**
     * @see Engine/Streamwide_Engine_Detector#_ensureAliveMediaServerCallLeg($errorCode)
     */
    protected function _ensureAliveMediaServerCallLeg()
    {
        return parent::_ensureAliveMediaServerCallLeg( self::DEAD_CALL_LEG_ERR_CODE );
    }

    /**
     * @see Engine/Streamwide_Engine_Detector#_ensureStartDetectionCorrectState($errorCode)
     */
    protected function _ensureStartDetectionCorrectState()
    {
        return parent::_ensureStartDetectionCorrectState( self::ALREADY_DETECTING_ERR_CODE );
    }

    /**
     * @see Engine/Streamwide_Engine_Detector#_ensureStopDetectionCorrectState($errorCode)
     */
    protected function _ensureStopDetectionCorrectState()
    {
        return parent::_ensureStopDetectionCorrectState( self::NOT_DETECTING_ERR_CODE );
    }

    /**
     * @see Engine/Streamwide_Engine_Detector#_activateDetection($errorCode, $params)
     */
    protected function _activateDetection()
    {
        $errorCode = self::SET_SIGNAL_SEND_ERR_CODE;
        $minimumVoiceActivityDuration = $this->_options[self::OPT_MINIMUM_VOICE_ACTIVITY_DURATION];
        $threshold = $this->_options[self::OPT_THRESHOLD];
        
        $params = array(
            'type' => 'voice',
            'duration' => $minimumVoiceActivityDuration,
            'threshold' => $threshold
        );
        
        return parent::_activateDetection( $errorCode, $params );
    }
    
    /**
     * @see Engine/Streamwide_Engine_Detector#_deactivateDetection($params)
     */
    protected function _deactivateDetection()
    {
        return parent::_deactivateDetection( array( 'type' => 'voice' ) );
    }

    /**
     * @see Engine/Streamwide_Engine_Detector#_armDetectionDurationTimer($detectionDuration, $callback)
     */
    protected function _armDetectionDurationTimer()
    {
        $detectionDuration = $this->_options[self::OPT_DETECTION_DURATION];
        return parent::_armDetectionDurationTimer( $detectionDuration );
    }
    
    /**
     * @param mixed $detectionDuration
     * @return void
     */
    protected function _treatDetectionDurationOption( $detectionDuration = null )
    {
        if ( null === $detectionDuration ) {
            return;
        }
        
        if ( is_int( $detectionDuration ) ) {
            $detectionDuration = (float)$detectionDuration;
        } elseif ( is_string( $detectionDuration ) && preg_match( '~^(?:0|[1-9][0-9]*)(?:\.[0-9]+)?$~', $detectionDuration ) === 1 ) {
            trigger_error(
                sprintf(
                    'Unexpected data type for option "%s". Value will be automatically converted to float',
                    self::OPT_DETECTION_DURATION
                )
            );
            $detectionDuration = (float)$detectionDuration;
        }
        
        if ( is_float( $detectionDuration ) ) {
            $this->_options[self::OPT_DETECTION_DURATION] = $detectionDuration;
        }
        else {
            trigger_error(
                sprintf(
                    'Option "%s" was provided with an invalid value. Using default value',
                    self::OPT_DETECTION_DURATION
                )
            );
        }
    }
    
    /**
     * @param mixed $minimumVoiceActivityDuration
     * @return void
     */
    protected function _treatMinimumVoiceActivityDurationOption( $minimumVoiceActivityDuration = null )
    {
        if ( null === $minimumVoiceActivityDuration ) {
            return null;
        }

        if ( is_float( $minimumVoiceActivityDuration )
            || ( is_string( $minimumVoiceActivityDuration )
                && preg_match( '~^(?:0|[1-9][0-9]*)(?:\.[0-9]+)?$~', $minimumVoiceActivityDuration ) === 1 ) )
        {
            trigger_error(
                sprintf(
                    'Unexpected data type for option "%s". Value will be automatically converted to integer',
                    self::OPT_MINIMUM_VOICE_ACTIVITY_DURATION
                )
            );
            $minimumVoiceActivityDuration = (int)$minimumVoiceActivityDuration;
        }

        if ( is_int( $minimumVoiceActivityDuration ) && $minimumVoiceActivityDuration > 0 ) {
            $this->_options[self::OPT_MINIMUM_VOICE_ACTIVITY_DURATION] = $minimumVoiceActivityDuration;
        } else {
            trigger_error(
                sprintf(
                    'Option "%s" was provided with an invalid value. Using default value',
                    self::OPT_MINIMUM_VOICE_ACTIVITY_DURATION
                )
            );
        }
    }
    
    /**
     * @param mixed $threshold
     * @return void
     */
    protected function _treatThresholdOption( $threshold = null )
    {
        if ( null === $threshold ) {
            return;
        }
        
        if ( is_int( $threshold ) ) {
            $threshold = (float)$threshold;
        } elseif ( is_string( $threshold ) && preg_match( '~^(?:0|[1-9][0-9]*)(?:\.[0-9]+)?$~', $threshold ) === 1 ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to float', self::OPT_THRESHOLD ) );
            $threshold = (float)$threshold;
        }
        
        if ( is_float( $threshold ) ) {
            $this->_options[self::OPT_THRESHOLD] = $threshold;
        }
        else {
            trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_THRESHOLD ) );
        }
    }
    
    /**
     * Initialize the widget options to their default values
     *
     * @return void
     */
    protected function _initDefaultOptions()
    {
        $this->_options[self::OPT_DETECTION_DURATION] = self::DEFAULT_DETECTION_DURATION;
        $this->_options[self::OPT_MINIMUM_VOICE_ACTIVITY_DURATION] = self::DEFAULT_MINIMUM_VOICE_ACTIVITY_DURATION;
        $this->_options[self::OPT_THRESHOLD] = self::DEFAULT_THRESHOLD;
    }
    
}
 
/* EOF */