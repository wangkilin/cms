<?php
/**
 *
 * $Rev: 2062 $
 * $LastChangedDate: 2009-10-22 19:00:57 +0800 (Thu, 22 Oct 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Signal_Specification_Decorator
 * @version 1.0
 *
 */

/**
 * Specification decorator to allow the specification candidate to be an instance of
 * Streamwide_Engine_Events_Event
 */
class Streamwide_Engine_Signal_Specification_Decorator extends Streamwide_Specification_Decorator
{
    
    /**
     * Constructor
     *
     * @param Streamwide_Specification_Abstract $spec
     * @return void
     */
    public function __construct( Streamwide_Engine_Signal_Specification $spec )
    {
        $this->_spec = $spec;
    }
    
    /**
     * Checks if $candidate has an instance of Streamwide_Engine_Signal assigned ot its "signal" key
     *
     * @return boolean
     */
    public function isSatisfiedBy( $candidate )
    {
        if ( $candidate instanceof Streamwide_Engine_Events_Event ) {
            $candidate = $candidate->getParam( 'signal' );
            if ( null !== $candidate ) {
                return $this->_spec->isSatisfiedBy( $candidate );
            }
            
            return false;
        }
        
        return false;
    }
    
}
 
/* EOF */