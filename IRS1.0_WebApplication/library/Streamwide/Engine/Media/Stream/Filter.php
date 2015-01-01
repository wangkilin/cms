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

abstract class Streamwide_Engine_Media_Stream_Filter implements Streamwide_Engine_Callback_Interface
{
    
    const FILTER_GAIN = 'GAIN';
    const FILTER_OVERLAY = 'OVERLAY';
    const FILTER_ECHO_CANCELLER = 'ECHO_CANCELLER';
    const FILTER_NOISE_REDUCTION = 'NOISE_REDUCTION';
    
    const STREAM_INCOMING = 'IN';
    const STREAM_OUTGOING = 'OUT';
    
    /**
     * Callback id to uniquely identify instances of this class
     *
     * @var string
     */
    protected $_callbackId;
    
    /**
     * The name of the filter
     *
     * @var string
     */
    protected $_name;
    
    /**
     * Wether the filter is active or not
     *
     * @var boolean
     */
    protected $_active = false;
    
    /**
     * The direction of the stream upon which the filter acts
     *
     * @var string
     */
    protected $_streamDirection;
    
    /**
     * @var Streamwide_Engine_Media_Server_Call_Leg
     */
    protected $_mediaServerCallLeg;
    
    /**
     * Filter parameters
     *
     * @var array
     */
    protected $_params = array();
    
    /**
     * Retrieve one of the child classes
     *
     * @return Streamwide_Engine_Media_Stream_Filter
     * @throws InvalidArgumentException
     */
    public static function factory( $type )
    {
        $filter = null;
        
        switch ( $type ) {
            case self::FILTER_GAIN:
                $filter = new Streamwide_Engine_Media_Stream_Filter_Gain();
            break;
            case self::FILTER_OVERLAY:
                $filter = new Streamwide_Engine_Media_Stream_Filter_Overlay();
            break;
            case self::FILTER_NOISE_REDUCTION:
                $filter = new Streamwide_Engine_Media_Stream_Filter_NoiseReduction();
            break;
            case self::FILTER_ECHO_CANCELLER:
                $filter = new Streamwide_Engine_Media_Stream_Filter_EchoCanceller();
            break;
        }
        
        if ( null === $filter ) {
            throw new InvalidArgumentException( 'Invalid filter type provided' );
        }
        
        return $filter;
    }
    
    /**
     * Set the direction of the stream upon which the filter acts on
     *
     * @param string $streamDirection
     * @return string
     */
    public function setStreamDirection( $streamDirection )
    {
        if ( $streamDirection !== self::STREAM_INCOMING && $streamDirection !== self::STREAM_OUTGOING ) {
            return;
        }
        
        $this->_streamDirection = $streamDirection;
    }
    
    /**
     * Get the direction of the stream
     *
     * @return string
     */
    public function getStreamDirection()
    {
        return $this->_streamDirection;
    }
    
    /**
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
     * @return Streamwide_Engine_Media_Server_Call_Leg
     */
    public function getMediaServerCallLeg()
    {
        return $this->_mediaServerCallLeg;
    }
    
    /**
     * @param $params
     * @return void
     */
    public function setParams( Array $params )
    {
        foreach ( $params as $name => $value ) {
            $method = 'set' . $this->_camelizeParamName( $name );
            if ( method_exists( $this, $method ) ) {
                $this->$method( $value );
            }
        }
    }
    
    /**
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }
    
    /**
     * Set the id that will uniquely identify each instance of this class
     *
     * @return void
     */
    public function setCallbackId()
    {
        if ( null === $this->_callbackId ) {
            $this->_callbackId = md5( uniqid( rand(), true ) );
        }
    }
    
    /**
     * Get the id that uniquely identify each instance of this class
     *
     * @return string
     */
    public function getCallbackId()
    {
        return $this->_callbackId;
    }
    
    /**
     * Get the name of the filter
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }
    
    /**
     * Activate the filter
     *
     * @return boolean
     */
    public function activate()
    {
        if ( $this->isActive() ) {
            return false;
        }
        
        $ret = $this->_applyFilterSettings( true );
        if ( $ret ) {
            $this->_active = true;
        }
        
        return $ret;
    }
    
    /**
     * Update filter's settings
     *
     * @return boolean
     */
    public function update() {
        if ( !$this->isActive() ) {
            return false;
        }
        
        return $this->_applyFilterSettings( true );
    }
    
    /**
     * Deactivate the filter
     *
     * @return boolean
     */
    public function deactivate() {
        if ( !$this->isActive() ) {
            return false;
        }
        
        $ret = $this->_applyFilterSettings( false );
        if ( $ret ) {
            $this->_active = false;
        }
        
        return $ret;
    }
    
    /**
     * Is the filter active?
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->_active;
    }
    
    /**
     * Get the name of filter as it required by the SW Engine. For example in the case of
     * the GAIN filter, engine requires either GAIN_IN or GAIN_OUT.
     *
     * @return string
     */
    protected function _getFilterFullName() {
        return sprintf( '%s_%s', $this->_name, $this->_streamDirection );
    }
    
    /**
     * Send the filter settings to the engine for activation, deactivation or update
     *
     * @param boolean $activate
     */
    protected function _applyFilterSettings( $activate = true )
    {
        $name = Streamwide_Engine_Signal::SET;
        $remote = $this->_mediaServerCallLeg->getName();
        $params = array();
        
        $params['name'] = $this->_getFilterFullName();
        $params['activate'] = 'false';
        
        if ( true === $activate ) {
            $params['activate'] = 'true';
            $params = array_merge( $params, $this->_params );
        }
    
        $set = Streamwide_Engine_Signal::factory( $name, $remote, $params );
        return $set->send();
    }
    
    /**
     * Transforms a string like "filter_length" to "FilterLength"
     *
     * @param string $name
     * @return string
     */
    protected function _camelizeParamName( $name )
    {
        return str_replace( ' ', '', ucwords( preg_replace( '/[^A-Z^a-z^0-9]+/', ' ' , $name ) ) );
    }

}
 
/* EOF */