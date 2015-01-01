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
 * @subpackage Streamwide_Engine_Log
 * @version 1.0
 *
 */

/**
 * Global utility class to make logging easier. Delegates the task of
 * logging to an object in the @see Streamwide_Engine_Registry (usually a
 * @see Streamwide_Engine_Log instance)
 */
final class Streamwide_Engine_Logger
{

    /**
     * Log object (performs the actual logging)
     *
     * @var Streamwide_Log
     */
    private $_log;

    /**
     * Sole instance of this class
     *
     * @var Streamwide_Engine_Logger
     */
    private static $_instance;

    /**
     * Constructor (made private to prevent instantiation)
     */
    private function __construct()
    {
        if ( defined( 'SW_ENGINE_LOG' ) ) {
            $registry = Streamwide_Engine_Registry::getInstance();
            $this->_log = $registry->get( SW_ENGINE_LOG );
        }
    }

    /**
     * Can we log?
     *
     * @return boolean
     */
    private function _canLog()
    {
    	return ( null !== $this->_log && $this->_log instanceof Streamwide_Log );
    }

    /**
     * Retrieve the sole instance of this class
     *
     * @return Streamwide_Engine_Logger
     */
    private static function _getInstance()
    {
    	if ( null === self::$_instance ) {
    		self::$_instance = new self();
    	}
        return self::$_instance;
    }

    /**
     * Logs an emergency (system is unusable)
     *
     * @param string $message
     * @return void
     */
    public static function emerg( $message )
    {
        $self = self::_getInstance();
        if ( $self->_canLog() ) {
        	$self->_log->emerg( $message );
        }
    }

    /**
     * Logs an alert (action must be taken immediately)
     *
     * @param string $message
     * @return void
     */
    public static function alert( $message )
    {
        $self = self::_getInstance();
        if ( $self->_canLog() ) {
            $self->_log->alert( $message );
        }
    }

    /**
     * Logs a critical situation (critical conditions)
     *
     * @param string $message
     * @return void
     */
    public static function crit( $message )
    {
        $self = self::_getInstance();
        if ( $self->_canLog() ) {
            $self->_log->crit( $message );
        }
    }

    /**
     * Logs an error (error conditions)
     *
     * @param string $message
     * @return void
     */
    public static function err( $message )
    {
        $self = self::_getInstance();
        if ( $self->_canLog() ) {
            $self->_log->err( $message );
        }
    }

    /**
     * Logs a warning (warning conditions)
     *
     * @param string $message
     * @return void
     */
    public static function warn( $message )
    {
        $self = self::_getInstance();
        if ( $self->_canLog() ) {
            $self->_log->warn( $message );
        }
    }

    /**
     * Logs a notice (normal but significant condition)
     *
     * @param string $message
     * @return void
     */
    public static function notice( $message )
    {
        $self = self::_getInstance();
        if ( $self->_canLog() ) {
            $self->_log->notice( $message );
        }
    }

    /**
     * Logs informational messages
     *
     * @param string $message
     * @return void
     */
    public static function info( $message )
    {
        $self = self::_getInstance();
        if ( $self->_canLog() ) {
            $self->_log->info( $message );
        }
    }

    /**
     * Logs debug messages
     *
     * @param string $message
     * @return void
     */
    public static function debug( $message )
    {
        $self = self::_getInstance();
        if ( $self->_canLog() ) {
            $self->_log->debug( $message );
        }
    }

    /**
     * Debug helper function. This is a wrapper for var_dump().
     *
     * @param mixed $var
     * @param string|null $label
     * @return void
     */
    public static function dump( $var, $label = null )
    {
        $self = self::_getInstance();
        if ( $self->_canLog() ) {
            $self->_log->dump( $var, $label );
        }
    }
    
    /**
     * Set a logger to be used by this class
     *
     * @param Streamwide_Log $log
     * @param boolean $overwrite
     * @return void
     */
    public static function setLog( Streamwide_Log $log, $overwrite = true )
    {
        $self = self::_getInstance();
        if ( null !== $self->_log && false === $overwrite ) {
            return null;
        }
        
        if ( defined( 'SW_ENGINE_LOG' ) ) {
            $registry = Streamwide_Engine_Registry::getInstance();
            $registry->set( SW_ENGINE_LOG, $log );
        }
        
        $self->_log = $log;
    }
    
    /**
     * Update the internal log object's event items
     *
     * @param array $data
     * @return void
     */
    public static function updateLogEventItems( Array $data )
    {
        $self = self::_getInstance();
        if ( $self->_log instanceof Streamwide_Engine_Log ) {
            $self->_log->updateEventItems( $data );
        }
    }

}

/* EOF */