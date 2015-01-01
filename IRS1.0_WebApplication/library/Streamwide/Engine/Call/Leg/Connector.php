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
 * @subpackage Streamwide_Engine_Call_Leg_Connector
 * @version 1.0
 *
 */

/**
 * "Connects" two call legs with one another by exchanging SDP info
 */
abstract class Streamwide_Engine_Call_Leg_Connector extends Streamwide_Engine_Widget
{
    
    /**
     * Connector types;
     */
    const CONNECTOR_SIPMS = 'SIPMS';
    const CONNECTOR_SIPSIP = 'SIPSIP';
    
    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::ERROR,
        Streamwide_Engine_Events_Event::CONNECTED
    );
    
    /**
     * Connector type (one of SIPMS, SIPSIP)
     *
     * @var string
     */
    protected $_type;
    
    /**
     * Left call leg
     *
     * @var Streamwide_Engine_Call_Leg_Abstract
     */
    protected $_leftCallLeg;
    
    /**
     * Right call leg
     *
     * @var Streamwide_Engine_Call_Leg_Abstract
     */
    protected $_rightCallLeg;
    
    /**
     * Connection parameters
     *
     * @var array
     */
    protected $_connectionParams = array();
    
    /**
     * Destructor
     */
    public function destroy()
    {
        if ( isset( $this->_leftCallLeg ) ) {
            unset( $this->_leftCallLeg );
        }
        
        if ( isset( $this->_rightCallLeg ) ) {
            unset( $this->_rightCallLeg );
        }
        
        parent::destroy();
    }
    
    /**
     * Perform the connection
     *
     * @return boolean
     */
    abstract public function connect();
    
    /**
     * Attempt to perform the connection again. This method should not
     * normally need to be used. It is here because is needed by the
     * MultiOutgoingIps decorator. Note that you may need to kill any
     * created call legs before calling this method.
     *
     * @param $options array|null
     * @return boolean
     */
    public function retryConnect( Array $options = null ) {
        // remove engine event listeners
        $this->_unsubscribeFromEngineEvents();
        
        // regenerate call leg names
        $this->_leftCallLeg->generateName();
        $this->_rightCallLeg->generateName();
        
        return $this->connect();
    }
    
    /**
     * Setter for the _leftCallLeg property
     *
     * @param Streamwide_Engine_Call_Leg_Abstract $leftCallLeg
     * @return void
     */
    public function setLeftCallLeg( Streamwide_Engine_Call_Leg_Abstract $leftCallLeg )
    {
        $this->_leftCallLeg = $leftCallLeg;
    }
    
    /**
     * Retrieve the left call leg
     *
     * @return Streamwide_Engine_Call_Leg_Abstract
     */
    public function getLeftCallLeg()
    {
        return $this->_leftCallLeg;
    }
    
    /**
     * Setter for the _rightCallLeg property
     *
     * @param Streamwide_Engine_Call_Leg_Abstract $rightCallLeg
     * @return void
     */
    public function setRightCallLeg( Streamwide_Engine_Call_Leg_Abstract $rightCallLeg )
    {
        $this->_rightCallLeg = $rightCallLeg;
    }
    
    /**
     * Retrieve the right call leg
     *
     * @return Streamwide_Engine_Call_Leg_Abstract
     */
    public function getRightCallLeg()
    {
        return $this->_rightCallLeg;
    }
    
    /**
     * Set the connection parameters
     *
     * @param array|Streamwide_Container $connectionParams
     * @return void
     * @throws InvalidArgumentException
     */
    public function setConnectionParams( $connectionParams )
    {
        if ( $connectionParams instanceof Streamwide_Container ) {
            $connectionParams = $connectionParams->toArray();
        }
        
        if ( !is_array( $connectionParams ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' requires parameter 1 to be an instance of Streamwide_Container or an array' );
        }
        
        $this->_validateConnectionParams( $connectionParams );
        $this->_connectionParams = $connectionParams;
    }
    
    /**
     * Retrieve the provided connection params
     *
     * @return array
     */
    public function getConnectionParams()
    {
        return $this->_connectionParams;
    }
    
    /**
     * Set a connection parameter
     *
     * @param string $name Parameter name
     * @param mixed $value Parameter value
     * @param boolean $overwrite Overwrite existing parameter?
     * @return void
     */
    public function setConnectionParam( $name, $value, $overwrite = true )
    {
        if ( array_key_exists( $name, $this->_connectionParams ) && false === $overwrite ) {
            return;
        }
        
        $this->_connectionParams[$name] = $value;
    }
    
    /**
     * Retrieve a connection paramter by name
     *
     * @param string $name
     * @return mixed
     */
    public function getConnectionParam( $name )
    {
        if ( array_key_exists( $name, $this->_connectionParams ) ) {
            return $this->_connectionParams[$name];
        }
    }
    
    /**
     * Retrieve the connector type
     *
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }
    
    /**
     * Did we received a moved during the connection process?
     *
     * @return boolean
     */
    public function hasReceivedMoved()
    {
        return false;
    }
    
    /**
     * Retrieve the MOVED signal that we received during the connection process
     *
     * @return Streamwide_Engine_Signal|null
     */
    public function getMovedSignal()
    {
        return null;
    }
    
    /**
     * Delegates work to internal methods when a signal is received from the SW Engine
     *
     * @param Streamwide_Engine_Events_Event $event
     * @return void
     */
    abstract public function onSignalReceived( Streamwide_Engine_Events_Event $event );
    
    /**
     * Validate connection parameters
     *
     * @param array $connectionParams
     * @return void
     */
    protected function _validateConnectionParams( Array $connectionParams )
    {
        return null;
    }
    
    /**
     * Handle a CHILD signal received in the middle of the connection process
     *
     * @param Streamwide_Engine_Signal $signal
     * @param string $errorCode
     * @return void
     */
    protected function _handleChildSignal( Streamwide_Engine_Signal $signal, $errorCode )
    {
        $this->_unsubscribeFromEngineEvents();
        $remoteName = $signal->getRemote();
        
        $defunctCallLeg = (
            $remoteName === $this->_leftCallLeg->getName()
            ? $this->_leftCallLeg
            : $this->_rightCallLeg
        );
        
        if ( $defunctCallLeg->isAlive() ) {
            $defunctCallLeg->setDead();
        }
        
        return $this->dispatchErrorEvent( $errorCode, array( 'callLeg' => $defunctCallLeg ) );
    }
    
}

/* EOF */
