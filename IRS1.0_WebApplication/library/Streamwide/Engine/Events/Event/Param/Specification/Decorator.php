<?php
/**
 *
 * $Rev: 2088 $
 * $LastChangedDate: 2009-10-30 20:56:54 +0800 (Fri, 30 Oct 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Package
 * @subpackage SubPackage
 * @version 1.0
 *
 */

/**
 * Allows a notification filter to be satisfied only if the tested candidate is an instance of Streamwide_Engine_Events_Event
 * that has a certain parameter with a certain value (provided by client code)
 */
class Streamwide_Engine_Events_Event_Param_Specification_Decorator extends Streamwide_Engine_Events_Event_Candidate_Specification_Decorator
{

    protected $_param;
    
    public function __construct( Streamwide_Specification_Abstract $spec, $param )
    {
        parent::__construct( $spec );
        $this->_param = $param;
    }
    
    public function isSatisfiedBy( $candidate )
    {
        if ( !parent::isSatisfiedBy( $candidate ) ) {
            return false;
        }
        
        $params = $candidate->getParams();
        
        if ( !is_array( $params ) ) {
            return false;
        }
        
        if ( empty( $params ) ) {
            return false;
        }
        
        if ( !array_key_exists( $this->_param, $params ) ) {
            return false;
        }
        
        return $this->_spec->isSatisfiedBy( $params[$this->_param] );
    }
    
}
 
/* EOF */