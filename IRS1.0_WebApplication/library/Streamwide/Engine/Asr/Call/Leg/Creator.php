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

class Streamwide_Engine_Asr_Call_Leg_Creator extends Streamwide_Engine_Call_Leg_Creator
{
    
    const PARAM_LANGUAGE = 'language';
    const PARAM_MSID = 'msid';
    const PARAM_CONFIDENCE = 'confidence';
    
    const CREATE_SIGNAL_SEND_ERR_CODE = 'ASRCREATOR-100';
    const CALL_LEG_NOT_CREATED_ERR_CODE = 'ASRCREATOR-200';
    const CALL_LEG_DIED_ERR_CODE = 'ASRCREATOR-201';
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::CREATE_SIGNAL_SEND_ERR_CODE => 'Unable to send CREATE signal to SW Engine',
        self::CALL_LEG_NOT_CREATED_ERR_CODE => 'The ASR call leg could not be created',
        self::CALL_LEG_DIED_ERR_CODE => 'The ASR call leg died'
    );
    
    /**
     * @param array $creationParams
     * @return void
     * @throws InvalidArgumentException
     */
    public function setCreationParams( Array $creationParams )
    {
        parent::setCreationParams( $creationParams );
        
        $language = $this->getLanguage();
        if ( empty( $language ) ) {
            throw new InvalidArgumentException( '"' . self::PARAM_LANGUAGE . '" parameter is mandatory and it cannot be empty' );
        }
    }
    
    /**
     * @param Streamwide_Engine_Call_Leg_Abstract $callLeg
     * @return void
     * @throws InvalidArgumentException
     */
    public function setCallLeg( Streamwide_Engine_Call_Leg_Abstract $callLeg )
    {
        if ( !$callLeg instanceof Streamwide_Engine_Asr_Call_Leg ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be an instance of Streamwide_Engine_Asr_Call_Leg' );
        }
        
        parent::setCallLeg( $callLeg );
    }
    
    /**
     * Set the language used for recognition. Example: "fr-FR" for french or "en-GB" for english
     *
     * @param string $language
     * @return void
     * @throws InvalidArgumentException
     */
    public function setLanguage( $language )
    {
        if ( !is_string( $language ) || strlen( $language ) < 1 ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a non-empty string' );
        }
        
        $this->_creationParams[self::PARAM_LANGUAGE] = $language;
    }
    
    /**
     * Retrieve the language used for recognition
     *
     * @return string|null
     */
    public function getLanguage()
    {
        if ( $this->_isParameterSet( self::PARAM_LANGUAGE ) ) {
            return $this->_creationParams[self::PARAM_LANGUAGE];
        }
    }
    
    /**
     * MSID of the associated MS call leg, given by the MS module in the OK response
     *
     * @param string $msid
     * @return void
     */
    public function setMsid( $msid )
    {
        $this->_creationParams[self::PARAM_MSID] = $msid;
    }
    
    /**
     * Retrieve the MSID of the associated MS call leg
     *
     * @return string|null
     */
    public function getMsid()
    {
        if ( $this->_isParameterSet( self::PARAM_MSID ) ) {
            return $this->_creationParams[self::PARAM_MSID];
        }
    }
    
    /**
     * Confidence level for the recognition. If not present the server's confidence
     * level is used.
     *
     * @param integer $confidence
     * @return void
     */
    public function setConfidence( $confidence )
    {
        $this->_creationParams[self::PARAM_CONFIDENCE] = $confidence;
    }
    
    /**
     * Retrieve the confidence level
     *
     * @return integer|null
     */
    public function getConfidence()
    {
        if ( $this->_isParameterSet( self::PARAM_CONFIDENCE ) ) {
            return $this->_creationParams[self::PARAM_CONFIDENCE];
        }
    }
    
    /**
     * Start the creation process
     *
     * @return boolean
     */
    public function create()
    {
        return parent::create( self::CREATE_SIGNAL_SEND_ERR_CODE );
    }
    
    /**
     * Handles FAIL signal. The ASR call leg could not be created
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleFailSignal( Streamwide_Engine_Signal $signal )
    {
        parent::_handleFailSignal( $signal, self::CALL_LEG_NOT_CREATED_ERR_CODE );
    }
    
    /**
     * Handles CHILD signal. The ASR call leg has died
     *
     * @param Streamwide_Engine_Signal $signal
     * @return void
     */
    protected function _handleChildSignal( Streamwide_Engine_Signal $signal )
    {
        parent::_handleChildSignal( $signal, self::CALL_LEG_DIED_ERR_CODE );
    }
    
    /**
     * Apply any normalization (if needed) to the creation params
     *
     * @see Engine/Call/Leg/Streamwide_Engine_Call_Leg_Creator#_normalizeCreationParams()
     */
    protected function _normalizeCreationParams()
    {
        return array_merge(
            array(
                'proto' => 'ASR',
                'name' => $this->_callLeg->getName()
            ),
            $this->_creationParams
        );
    }

}
 
/* EOF */