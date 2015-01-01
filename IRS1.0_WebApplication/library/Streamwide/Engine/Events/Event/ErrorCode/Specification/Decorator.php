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
 * that has a certain error code
 */
class Streamwide_Engine_Events_Event_ErrorCode_Specification_Decorator extends Streamwide_Engine_Events_Event_Candidate_Specification_Decorator
{

    public function isSatisfiedBy( $candidate )
    {
        if ( !parent::isSatisfiedBy( $candidate ) ) {
            return false;
        }
        
        return $this->_spec->isSatisfiedBy( $candidate->getErrorCode() );
    }
    
}
 
/* EOF */