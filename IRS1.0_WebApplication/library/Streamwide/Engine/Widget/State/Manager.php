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
 * @subpackage Streamwide_Engine_Widget
 * @version 1.0
 *
 */

/**
 * Manages internal widget states
 */
class Streamwide_Engine_Widget_State_Manager
{
    
    /**
     * Current state
     *
     * @var string
     */
    protected $_state;
    
    /**
     * Available states
     *
     * @var array
     */
    protected $_states = array();
    
    /**
     * Constructor
     *
     * @param array $states
     * @return void
     */
    public function __construct( Array $states = null )
    {
        if ( null !== $states ) {
            $this->init( $states );
        }
    }
    
    /**
     * Initialize the state manager
     *
     * @param array $states
     * @return void
     * @throws InvalidArgumentException
     */
    public function init( Array $states )
    {
        if ( !is_array( $states ) || empty( $states ) ) {
            throw new InvalidArgumentException( 'States must be provided as a non empty array' );
        }
        
        $states = array_values( $states );
        list( $state ) = $states;
        
        $this->_state = $state;
        $this->_states = $states;
    }
    
    /**
     * Set the current state
     *
     * @param $stringstate
     * @return unknown_type
     */
    public function setState( $state )
    {
        if ( !$this->_isValidState( $state ) ) {
            return null;
        }
        if ( $this->_state !== $state ) {
            $this->_state = $state;
        }
    }

    /**
     * Retrieve the current state
     *
     * @return string
     */
    public function getState()
    {
        return $this->_state;
    }
    
    /**
     * Validates a state
     *
     * @param string $state
     * @return boolean
     */
    protected function _isValidState( $state )
    {
        return in_array( $state, $this->_states );
    }
}


/* EOF */