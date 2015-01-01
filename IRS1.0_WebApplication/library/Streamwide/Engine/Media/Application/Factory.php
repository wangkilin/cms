<?php
/**
 *
 * $Rev: 2064 $
 * $LastChangedDate: 2009-10-22 19:19:50 +0800 (Thu, 22 Oct 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Media_Application
 * @version 1.0
 *
 */

/**
 * Base class for factories that create Streamwide_Engine_Media_Application_Abstract objects
 */
abstract class Streamwide_Engine_Media_Application_Factory
{

    /**
     * The factory method
     *
     * @param Streamwide_Engine_Controller $controller
     * @param Streamwide_Engine_Signal $signal|null The CREATE signal or null
     * @return Streamwide_Engine_Media_Application_Abstract
     */
    abstract public function factory( Streamwide_Engine_Controller $controller, Streamwide_Engine_Signal $signal = null );
    
}
 
/* EOF */