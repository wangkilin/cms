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

class Streamwide_Engine_Asr_SpeechRecognizer extends Streamwide_Engine_Widget
{
    
    const OPT_GRAMMAR = 'grammar';
    const OPT_GRAMMAR_TYPE = 'grammar_type';
    
    const RECOGNIZE_SIGNAL_SEND_FAILURE_ERR_CODE = 'ASRRECOGNIZER-100';
    const STOP_SIGNAL_SEND_FAILURE_ERR_CODE = 'ASRRECOGNIZER-101';
    const ASR_CALL_LEG_NOT_ALIVE_ERR_CODE = 'ASRRECOGNIZER-200';
    const ASR_RECOGNITION_FAILURE_ERR_CODE = 'ASRRECOGNIZER-202';
    const MEDIA_RECORDER_RECORDING_FAILURE_ERR_CODE = 'ASRRECOGNIZER-203';
    const MEDIA_RECORDER_ALREADY_RECORDING_ERR_CODE = 'ASRRECOGNIZER-204';
    
    /**
     * @var Streamwide_Engine_Asr_Call_Leg
     */
    protected $_asrCallLeg;
    
    /**
     * @var Streamwide_Engine_Media_Recorder
     */
    protected $_mediaRecorder;
    
    /**
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::WORD_RECOGNIZED,
        Streamwide_Engine_Events_Event::ERROR
    );
    
    /**
     * Mapping of error codes to error message
     *
     * @var array
     */
    protected $_errors = array(
        self::RECOGNIZE_SIGNAL_SEND_FAILURE_ERR_CODE => 'Unable to send RECOGNIZE signal to SW Engine',
        self::STOP_SIGNAL_SEND_FAILURE_ERR_CODE => 'Unable to send STOP signal to SW Engine',
        self::ASR_CALL_LEG_NOT_ALIVE_ERR_CODE => 'Attempt to start an ASR session with a dead ASR call leg',
        self::ASR_RECOGNITION_FAILURE_ERR_CODE => 'Recognition error (timeout or recognition failure)',
        self::MEDIA_RECORDER_RECORDING_FAILURE_ERR_CODE => 'Unable to start the media recorder',
        self::MEDIA_RECORDER_ALREADY_RECORDING_ERR_CODE => 'Attempt to start an ASR session with an already started media recorder'
    );
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->_initDefaultOptions();
    }
    
    /**
     * @param Streamwide_Engine_Asr_Call_Leg $asrCallLeg
     * @return void
     */
    public function setAsrCallLeg( Streamwide_Engine_Asr_Call_Leg $asrCallLeg )
    {
        if ( !$asrCallLeg->isAlive() ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be an alive ASR call leg' );
        }
        
        $this->_asrCallLeg = $asrCallLeg;
    }
    
    /**
     * @return Streamwide_Engine_Asr_Call_Leg
     */
    public function getAsrCallLeg()
    {
        return $this->_asrCallLeg;
    }
    
    /**
     * @param Streamwide_Engine_Media_Recorder $mediaRecorder
     * @return void
     */
    public function setMediaRecorder( Streamwide_Engine_Media_Recorder $mediaRecorder )
    {
        $this->_mediaRecorder = $mediaRecorder;
    }
    
    /**
     * @return Streamwide_Engine_Media_Recorder
     */
    public function getMediaRecorder()
    {
        return $this->_mediaRecorder;
    }
    
    /**
     * Set widget options
     *
     * @param array $options
     * @return void
     */
    public function setOptions( Array $options )
    {
        $grammarType = isset( $options[self::OPT_GRAMMAR_TYPE] ) ? $options[self::OPT_GRAMMAR_TYPE] : null;
        $this->_treatGrammarTypeOption( $grammarType );
        
        $grammar = isset( $options[self::OPT_GRAMMAR] ) ? $options[self::OPT_GRAMMAR] : null;
        $this->_treatGrammarOption( $grammar );
    }

    public function startAsrSession()
    {
        if ( !$this->_asrCallLeg->isAlive() ) {
            $this->dispatchErrorEvent( self::ASR_CALL_LEG_NOT_ALIVE_ERR_CODE );
            return false;
        }
        
        if ( !$this->_mediaRecorder->isRecording() ) {
            $callLegParams = $this->_asrCallLeg->getParams();
            if ( !is_array( $callLegParams ) || empty( $callLegParams ) ) {
                $message = 'No ASR call leg parameters found. Unable to determine the name of the buffer';
                trigger_error( $message, E_USER_NOTICE );
                return false;
            }
            
            if ( !isset( $callLegParams['buffer'] ) ) {
                $message = 'Buffer name not present in the call leg parameters';
                trigger_error( $message, E_USER_NOTICE );
                return false;
            }
        
            $this->_mediaRecorder->setStorage( new Streamwide_Engine_Media_Buffer( $callLegParams['buffer'] ) );
            $isRecording = $this->_mediaRecorder->start();
            
            if ( !$isRecording ) {
                $this->dispatchErrorEvent( self::MEDIA_RECORDER_RECORDING_FAILURE_ERR_CODE );
            }
            
            return $isRecording;
        }
        
        $this->dispatchErrorEvent( self::MEDIA_RECORDER_ALREADY_RECORDING_ERR_CODE );
        return false;
    }
    
    public function stopAsrSession()
    {
        if ( $this->_mediaRecorder->isRecording() ) {
            $this->_mediaRecorder->reset();
        }
        
        if ( $this->_asrCallLeg->isAlive() ) {
            $kill = Streamwide_Engine_Signal::factory(
                Streamwide_Engine_Signal::KILL,
                $this->_asrCallLeg->getName()
            );
            $kill->send();
            
            $this->_asrCallLeg->setDead();
        }
        
        $this->_unsubscribeFromEngineEvents();
        return true;
    }
    
    public function startRecognition()
    {
        $grammar = $this->getOption( self::OPT_GRAMMAR );
        
        $params = array( 'grammar' => $grammar );
        if ( null !== $this->_options[self::OPT_GRAMMAR_TYPE] ) {
            $params['grammartype'] = $this->_options[self::OPT_GRAMMAR_TYPE];
        }
        
        $recognize = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::RECOGNIZE,
            $this->_asrCallLeg->getName(),
            $params
        );
        if ( false === $recognize->send() ) {
            $this->dispatchErrorEvent( self::RECOGNIZE_SIGNAL_SEND_FAILURE_ERR_CODE );
            return false;
        }
        
        $this->_subscribeToEngineEvents();
        return true;
    }

    public function stopRecognition()
    {
        $stop = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::STOP,
            $this->_asrCallLeg->getName()
        );
        if ( false === $stop->send() ) {
            $this->dispatchErrorEvent( self::STOP_SIGNAL_SEND_FAILURE_ERR_CODE );
            return false;
        }
        
        $this->_unsubscribeFromEngineEvents();
        return true;
    }
    
    public function onWordRecognized( Streamwide_Engine_Events_Event $event )
    {
        $signal = $event->getParam( 'signal' );
        $params = $signal->getParams();
        
        if ( $params['word'] === '@' ) {
            $this->dispatchErrorEvent( self::ASR_RECOGNITION_FAILURE_ERR_CODE );
            return;
        }
        
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::WORD_RECOGNIZED );
        $event->setParam( 'signal', $signal );
        $this->dispatchEvent( $event );
    }
    
    public function reset()
    {
        parent::reset();
        
        $this->stopAsrSession();
    }
    
    public function destroy()
    {
        if ( isset( $this->_asrCallLeg ) ) {
            unset( $this->_asrCallLeg );
        }
        
        if ( isset( $this->_mediaRecorder ) ) {
            $this->_mediaRecorder->destroy();
            unset( $this->_mediaRecorder );
        }

        parent::destroy();
    }
    
    protected function _subscribeToEngineEvents()
    {
        $controller = $this->getController();
        
        $notifyFilter = Streamwide_Engine_NotifyFilter_Factory::factory(
            Streamwide_Engine_NotifyFilter_Factory::T_EVT_SIG_PARAM_REMOTE,
            Streamwide_Engine_NotifyFilter_Factory::FILTER_EQUAL_TO,
            $this->_asrCallLeg->getName()
        );
        $config = array(
            'callback' => array( $this, 'onWordRecognized' ),
            'options' => array( 'notifyFilter' => $notifyFilter )
        );
        
        $controller->addEventListener( Streamwide_Engine_Events_Event::WORD, $config );
    }
    
    protected function _unsubscribeFromEngineEvents()
    {
        $controller = $this->getController();
        
        $config = array( 'callback' => array( $this, 'onWordRecognized' ) );
        $controller->removeEventListener( Streamwide_Engine_Events_Event::WORD, $config );
    }
    
    protected function _treatGrammarTypeOption( $grammarType = null )
    {
        if ( null === $grammarType ) {
            return;
        }
        
        if ( !is_string( $grammarType ) ) {
            $message = 'Unexpected data type for option "%s". Value will be automatically converted to string';
            trigger_error( sprintf( $message, self::OPT_GRAMMAR_TYPE ), E_USER_NOTICE );
            $grammarType = (string)$grammarType;
        }
        
        $grammarType = strtoupper( $grammarType );
        
        if ( $grammarType !== 'XML' && !empty( $grammarType ) ) {
            $message = '"%s" can only be empty or have "xml" as its value. Value will be automatically set to null';
            trigger_error( sprintf( $message, self::OPT_GRAMMAR_TYPE ), E_USER_NOTICE );
            $grammarType = null;
        }

        $this->_options[self::OPT_GRAMMAR_TYPE] = $grammarType;
    }
    
    protected function _treatGrammarOption( $grammar = null )
    {
        if ( null === $grammar ) {
            throw new Exception( sprintf( 'Required option "%s" not provided', self::OPT_GRAMMAR ) );
        }
        
        if ( !is_string( $grammar ) ) {
            $message = 'Unexpected data type for option "%s". Value will be automatically converted to string';
            trigger_error( sprintf( $message, self::OPT_GRAMMAR ), E_USER_NOTICE );
            $grammar = (string)$grammar;
        }
        
        if ( trim( $grammar ) === '' ) {
            throw new Exception( sprintf( '"%s" option cannot be empty', self::OPT_GRAMMAR ) );
        }
        
        $this->_options[self::OPT_GRAMMAR] = $grammar;
    }
    
    protected function _initDefaultOptions()
    {
        $this->_options[self::OPT_GRAMMAR_TYPE] = null;
    }
    
}
 
/* EOF */