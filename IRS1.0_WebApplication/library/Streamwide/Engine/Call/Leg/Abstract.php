<?php
/**
 *
 * $Rev: 2066 $
 * $LastChangedDate: 2009-10-22 20:18:09 +0800 (Thu, 22 Oct 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Call_Leg
 * @version 1.0
 *
 */

/**
 * Base class for all call leg types in the system
 */
abstract class Streamwide_Engine_Call_Leg_Abstract
{
    
    /**
     * The PHP call leg type name
     */
    const PHP_CL = 'PHP';
    
    /**
     * SIP call leg type name
     */
    const SIP_CL = 'SIP';
    
    /**
     * Media server call leg type name
     */
    const MS_CL = 'MS';
    
    /**
     * RTSP call leg type name
     */
    const RTSP_CL = 'RTSP';
    
    /**
     * RTPPROXY call leg type name
     */
    const RTPPROXY_CL = 'RTPPROXY';
    
    /**
     * ASR call leg type name
     */
    const ASR_CL = 'ASR';
    
    /**
     * TTS call leg type name
     */
    const TTS_CL = 'TTS';
    
    /**
     * DIAMETER call leg type name
     */
    const DIAMETER_CL = 'DIAMETER';
    
    /**
     * The call leg type. One of: SIP, MS, RTSP, RTPPROXY, ASR, TTS, DIAMETER
     *
     * @var string
     */
    protected $_type;
    
    /**
     * The call leg name. All call legs inside a call must have unique names. The call
     * leg type along with a unique token are used to generate a unique name.
     *
     * @var string
     */
    protected $_name;
    
    /**
     * Is the call leg alive (created)?
     *
     * @var boolean
     */
    protected $_isAlive = false;
    
    /**
     * Is the call leg the root call leg (call legs have a tree-like structure)?
     *
     * @var boolean
     */
    protected $_isRoot = false;
    
    /**
     * Has an OK signal been received by this call leg?
     *
     * @var boolean
     */
    protected $_okSentOrReceived = false;
    
    /**
     * Call leg parameters (usually the parameters of the OK signal received from
     * SW Engine when creating a call leg)
     *
     * @var array
     */
    protected $_params;
    
    /**
     * Constructor
     *
     * @param string|null $name
     * @param boolean $alive
     * @throws InvalidArgumentException
     */
    public function __construct( $name = null, $alive = false )
    {
        if ( true === $alive && null === $name ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be non empty if parameter 2 is set to true' );
        }
        
        $this->_isAlive = $alive;
        $this->_isRoot = false;
        $this->_okSentOrReceived = false;
        
        $this->generateName( $name );
    }

    /**
     * Set the parameters for this call leg
     *
     * @param Streamwide_Container|array $params
     * @throws InvalidArgumentException
     * @return void
     */
    public function setParams( $params )
    {
        if ( $params instanceof Streamwide_Container ) {
            $params = $params->toArray();
        }
        if ( !is_array( $params ) ) {
            if ( is_object( $params ) ) {
                $type = get_class( $params );
            } else {
                $type = gettype( $params );
            }
            throw new InvalidArgumentException(
                sprintf( '%s expects parameter 1 to be an instance of class Streamwide_Container or an array, %s given', __METHOD__, $type )
            );
        }
        $this->_params = $params;
    }
    
    /**
     * Retrieve the call leg parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }
    
    /**
     * Retrieve a certain parameter by name
     *
     * @param string $name
     * @return mixed
     */
    public function getParam( $name )
    {
        if ( array_key_exists( $name, $this->_params ) ) {
            return $this->_params[$name];
        }
    }
    
    /**
     * Retrieve the name of the call leg
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }
    
    /**
     * Retrieve the type of the call leg
     *
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }
    
    /**
     * Set this call leg as the root call leg (call legs in a voice application have a tree-like structure).
     * This method has functionality only for SIP and PHP call legs.
     *
     * @return boolean
     */
    public function setRoot()
    {
        return false;
    }
    
    /**
     * Is this call leg the root call leg?
     *
     * @return boolean
     */
    public function isRoot()
    {
        return $this->_isRoot;
    }
    
    /**
     * Mark the call leg as alive
     *
     * @return void
     */
    public function setAlive()
    {
        $this->_isAlive = true;
    }
    
    /**
     * Mark the call leg as dead
     *
     * @return void
     */
    public function setDead()
    {
        $this->_isAlive = false;
        $this->_okSentOrReceived = false;
    }
    
    /**
     * Is the call leg alive?
     *
     * @return boolean
     */
    public function isAlive()
    {
        return $this->_isAlive;
    }
    
    /**
     * Mark the call leg as having received the OK signal
     *
     * @return void
     */
    public function okReceived()
    {
        $this->_okSentOrReceived = true;
    }
    
    /**
     * Mark the call leg as having sent the OK signal
     *
     * @return void
     */
    public function okSent()
    {
        $this->_okSentOrReceived = true;
    }
    
    /**
     * Has the OK signal been received?
     *
     * @return boolean
     */
    public function hasSentOrReceivedOk()
    {
        return $this->_okSentOrReceived;
    }
    
    /**
     * Retrieve an array representation of this call leg
     *
     * @return array
     */
    public function toArray()
    {
        $ret = array(
            'callLegName' => $this->_name,
            'callLegType' => $this->_type,
            'isAlive' => $this->_isAlive,
            'isRoot' => $this->_isRoot,
            'okSentOrReceived' => $this->_okSentOrReceived
        );
        if ( is_array( $this->_params ) ) {
            return array_merge( $ret, $this->_params );
        }
        return $ret;
    }
    
    /**
     * Generate a unique name for each call leg
     *
     * @return void
     */
    public function generateName( $name = null )
    {
        // prevent root call leg from name changes
        if ( $this->_isRoot && $this->_name !== null ) {
            return;
        }
        
        if ( null !== $name ) {
            $this->_name = $name;
        } else {
            $this->_name = md5( $this->_type . ':' . uniqid() );
        }
    }
    
}

/* EOF */