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

class Streamwide_Engine_NotifyFilter_EqualTo extends Streamwide_Engine_NotifyFilter
{

    protected $_strict = false;
    
    public function __construct( $value, $strict = false )
    {
        parent::__construct( $value );
        $this->_strict = (bool)$strict;
    }
    
    public function isSatisfiedBy( $candidate )
    {
        $value = $this->_value;
        
        if ( $value instanceof Streamwide_Engine_Call_Leg_Abstract ) {
            $value = $value->getName();
        }
        
        if ( $this->_strict ) {
            return ( $candidate === $value );
        }
        
        return ( $candidate == $value );
    }
    
}
 
/* EOF */