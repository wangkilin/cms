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
 * Provides basic a basic listening of SW Engine events routine
 */
class Streamwide_Engine_Controller_Basic extends Streamwide_Engine_Controller
{

    /**
     * String representing the class name of the media applications that this
     * controller will instantiate or an instance of Streamwide_Engine_Media_Application_Factory
     * that will create the application(s) for us
     *
     * @var string|Streamwide_Engine_Media_Application_Factory
     */
    protected $_applicationClass;
    
    /**
     * Set the application class or application factory
     *
     * @param string|Streamwide_Engine_Media_Application_Factory $applicationClass
     * @return void
     */
    public function setApplicationClass( $applicationClass )
    {
        $this->_applicationClass = $applicationClass;
    }
    
    /**
     * Run the controller. Dequeues signals from the SW Engine's internal queue and
     * notifies the listeners that a signal from SW Engine has been received
     *
     * @return void
     */
    public function run()
    {
        $timeout = $this->_options[self::OPT_TIMEOUT];
        Streamwide_Engine_Logger::info( 'Going to main loop' );
        
        for ( ; ; ) {
            // Fetch a new signal from the SW Engine's queue
            $signal = Streamwide_Engine_Signal::dequeue( array( 'timeout' => $timeout ) );
            if ( false === $signal ) {
                continue;
            }
            
            // Update the loggers event items
            Streamwide_Engine_Logger::updateLogEventItems( array( $signal->getPhpId() => $signal->getParams() ) );
            // Log the received signal
            Streamwide_Engine_Logger::dump( $signal->toArray(), 'Received event from SW Engine:' );
            
            if ( $signal->getName() === Streamwide_Engine_Signal::CREATE ) {
                // We have received a CREATE (new call), we need to create a new application to handle
                // the call
                if ( false === ( $application = $this->_createNewApplication( $signal ) ) ) {
                    continue;
                }
                
                // Add the new application to the controller's running apps storage (will call
                // the application's start method)
                $this->addApp( $signal->getPhpId(), $application );
            } else {
                // We have received a signal from SW Engine, we need to notify the listeners
                $event = new Streamwide_Engine_Events_Event( $signal->getName() );
                $event->setParam( 'signal', $signal );
                $this->dispatchEvent( $event );
            }
        }
    }
    
    /**
     * Create a new application by using the string as a class name, or use the factory
     * to get a new application instance
     *
     * @param Streamwide_Engine_Signal $signal
     * @return Streamwide_Engine_Media_Application_Abstract|boolean
     */
    protected function _createNewApplication( Streamwide_Engine_Signal $signal = null )
    {
        if ( is_string( $this->_applicationClass ) ) {
            $application = new $this->_applicationClass( $this, $signal );
        } elseif ( $this->_applicationClass instanceof Streamwide_Engine_Media_Application_Factory ) {
            $application = $this->_applicationClass->factory( $this, $signal );
        }
        
        if ( !$application instanceof Streamwide_Engine_Media_Application_Abstract ) {
            trigger_notice( 'Media application must be an instance of Streamwide_Engine_Media_Application_Abstract', E_USER_NOTICE );
            return false;
        }
        
        return $application;
    }
    
}
 
/* EOF */