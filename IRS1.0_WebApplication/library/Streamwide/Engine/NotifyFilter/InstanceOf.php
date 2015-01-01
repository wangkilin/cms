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

class Streamwide_Engine_NotifyFilter_InstanceOf extends Streamwide_Engine_NotifyFilter
{
    
    public function __construct( $class )
    {
        if ( !is_string( $class ) ) {
            throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a string' );
        }
        
        parent::__construct( $class );
    }
    
    public function isSatisfiedBy( $candidate )
    {
        return $candidate instanceof $this->_value;
    }
    
}
 
/* EOF */