<?php
/**
 *
 * $Rev: 2135 $
 * $LastChangedDate: 2009-11-23 17:53:15 +0800 (Mon, 23 Nov 2009) $
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
 * Keeps track of the number of tries allowed to execute a certain action
 */
class Streamwide_Engine_Counter extends Streamwide_Engine_Widget
{
    
    /**
     * Options names
     */
    const OPT_TRIES = 'tries';

    /**
     * Options defaults
     */
    const DEFAULT_NUMBER_OF_TRIES = 1;

    /**
     * Error code constants
     */
    const NO_TRIES_LEFT_ERR_CODE = 'COUNTER-200';

    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::ERROR,
        Streamwide_Engine_Events_Event::OK
    );
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::NO_TRIES_LEFT_ERR_CODE => 'No tries left'
    );
    
    protected $_triesLeft;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->_initDefaultOptions();
    }

    /**
     * Retrieves the current number of tries
     *
     * @return integer
     */
    public function getTriesLeft()
    {
        return $this->_triesLeft;
    }

    /**
     * Do we have more tries left?
     *
     * @return boolean
     */
    public function hasMoreTries()
    {
        return ( $this->_triesLeft > 0 );
    }
    
    /**
     * Decrement the counter
     *
     * @param integer $step
     * @return boolean
     */
    public function decrement( $step = 1 )
    {
        $this->_triesLeft -= $step;
        if ( $this->_triesLeft < 0 ) {
            $this->_triesLeft = 0;
        }

        if ( 0 === $this->_triesLeft ) {
            $this->dispatchErrorEvent( self::NO_TRIES_LEFT_ERR_CODE );
            return false;
        }
         
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::OK );
        $event->setParam( 'triesLeft', $this->_triesLeft );
        $this->dispatchEvent( $event );
        return true;
    }
    
    /**
     * Sets options values or provides default values for invalid or omitted required options
     *
     * @param mixed $options
     * @return void
     */
    public function setOptions( Array $options )
    {
        $tries = isset( $options[self::OPT_TRIES] ) ? $options[self::OPT_TRIES] : null;
        $this->_treatTriesOption( $tries );
        $this->_triesLeft = $this->_options[self::OPT_TRIES];
    }

    /**
     * Treat the tries options
     *
     * @param mixed $tries
     * @return void
     */
    protected function _treatTriesOption( $tries = null )
    {
        if ( null === $tries ) {
            // exit and use the default value
            return null;
        }

        if ( is_float( $tries ) || ( is_string( $tries ) && preg_match( '~^[1-9][0-9]*$~', $tries ) === 1 ) ) {
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
     * Initialize default options
     *
     * @return void
     */
    protected function _initDefaultOptions()
    {
    	$this->_options[self::OPT_TRIES] = self::DEFAULT_NUMBER_OF_TRIES;
    	$this->_triesLeft = self::DEFAULT_NUMBER_OF_TRIES;
    }

}

/* EOF */