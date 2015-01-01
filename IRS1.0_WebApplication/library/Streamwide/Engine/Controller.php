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

if ( !defined( 'SW_ENGINE_CONTROLLER' ) ) {
	define( 'SW_ENGINE_CONTROLLER', 'controller' );
}

if ( !defined( 'SW_ENGINE_CURRENT_PHPID' ) ) {
	define( 'SW_ENGINE_CURRENT_PHPID', 'currentPhpId' );
}

if ( !defined( 'SW_ENGINE_PROXY' ) ) {
    define( 'SW_ENGINE_PROXY', 'swEngineProxy' );
}

if ( !defined( 'SW_ENGINE_LOG' ) ) {
	define( 'SW_ENGINE_LOG', 'log' );
}

/**
 * Listens for SW Engine signals and dispatches events to listeners.
 * Extend this class to implement your own controller (your own listening routine)
 */
abstract class Streamwide_Engine_Controller extends Streamwide_Engine_Widget
{

    /**
     * Options names
     */
    const OPT_TIMEOUT = 'timeout';

    /**
     * Default options values
     */
    const DEFAULT_TIMEOUT = -1;

    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::ERROR,
        Streamwide_Engine_Events_Event::CHILD,
        Streamwide_Engine_Events_Event::CREATE,
        Streamwide_Engine_Events_Event::DIAMETERMESSAGE,
        Streamwide_Engine_Events_Event::DTMF,
        Streamwide_Engine_Events_Event::END,
        Streamwide_Engine_Events_Event::ENDOFFAX,
        Streamwide_Engine_Events_Event::EOF,
        Streamwide_Engine_Events_Event::EVENT,
        Streamwide_Engine_Events_Event::FAIL,
        Streamwide_Engine_Events_Event::FAILMOVED,
        Streamwide_Engine_Events_Event::FAILREGISTER,
        Streamwide_Engine_Events_Event::FAILSDP,
        Streamwide_Engine_Events_Event::FAILTRANSFER,
        Streamwide_Engine_Events_Event::FAXPAGE,
        Streamwide_Engine_Events_Event::INFO,
        Streamwide_Engine_Events_Event::MOVED,
        Streamwide_Engine_Events_Event::OK,
        Streamwide_Engine_Events_Event::OKMOVED,
        Streamwide_Engine_Events_Event::OKSDP,
        Streamwide_Engine_Events_Event::OKTRANSFER,
        Streamwide_Engine_Events_Event::PROGRESS,
        Streamwide_Engine_Events_Event::PROK,
        Streamwide_Engine_Events_Event::PRSDP,
        Streamwide_Engine_Events_Event::REGISTER,
        Streamwide_Engine_Events_Event::RING,
        Streamwide_Engine_Events_Event::SDP,
        Streamwide_Engine_Events_Event::SIGNAL,
        Streamwide_Engine_Events_Event::SUBSCRIBE,
        Streamwide_Engine_Events_Event::TIMEOUT,
        Streamwide_Engine_Events_Event::TRANSFER,
        Streamwide_Engine_Events_Event::TRFINFO,
        Streamwide_Engine_Events_Event::WORD
    );
    
    /**
     * All running media applications are stored in here
     *
     * @var array
     */
    protected $_runningApps = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->_registry->set( SW_ENGINE_CONTROLLER, $this, false );
        $this->_initDefaultOptions();
    }

    /**
     * Run the controller
     *
     * @return void
     */
    abstract public function run();
    
    /**
     * Overriden from the abstract widget class
     *
     * @see Engine/Streamwide_Engine_Widget#getController()
     */
    public function getController()
    {
        return $this;
    }
    
    /**
     * Add an app to the running applications list
     *
     * @param integer $phpId
     * @param Streamwide_Engine_Media_Application_Abstract $app
     * @return void
     */
    public function addApp( $phpId, Streamwide_Engine_Media_Application_Abstract $app )
    {
    	$app->start();
        $this->_runningApps[$phpId] = $app;
    }

    /**
     * Removes a media application from the list of running applications
     *
     * @return void
     */
    public function removeApp( $phpId )
    {
    	if ( array_key_exists( $phpId, $this->_runningApps ) ) {
            unset( $this->_runningApps[$phpId] );
    	}
    }

    /**
     * Retrieves a instance of a running media application (if it exists)
     *
     * @param integer $phpId
     * @return Streamwide_Engine_Media_Application_Abstract|null
     */
    public function getApp( $phpId )
    {
        if ( array_key_exists( $phpId, $this->_runningApps ) ) {
            return $this->_runningApps[$phpId];
        }
    }
    
    /**
     * Provide default values for options
     *
     * @param array $options
     * @return void
     */
    public function setOptions( Array $options )
    {
        $timeout = isset( $options[self::OPT_TIMEOUT] ) ? $options[self::OPT_TIMEOUT] : null;
        $this->_treatTimeoutOption( $timeout );
    }
    
    /**
     * Treat the timeout option
     *
     * @param mixed $timeout
     * @return integer
     */
    protected function _treatTimeoutOption( $timeout = null )
    {
        if ( null === $timeout ) {
            // exit and use the default value
            return null;
        }

        if ( is_float( $timeout ) || ( is_string( $timeout ) && preg_match( '~^[1-9][0-9]*$~', $timeout ) === 1 ) ) {
            trigger_error( sprintf( 'Unexpected data type for option "%s". Value will be automatically converted to integer', self::OPT_TIMEOUT ) );
            $timeout = (int)$timeout;
        }

        if ( is_int( $timeout ) && ( $timeout > 0 || $timeout == -1 ) ) {
            $this->_options[self::OPT_TIMEOUT] = $timeout;
        } else {
        	trigger_error( sprintf( 'Option "%s" was provided with an invalid value. Using default value', self::OPT_TIMEOUT ) );
        }
    }

    /**
     * Initialize default options
     *
     * @return void
     */
    protected function _initDefaultOptions()
    {
        $this->_options[self::OPT_TIMEOUT] = self::DEFAULT_TIMEOUT;
    }

}

/* EOF */