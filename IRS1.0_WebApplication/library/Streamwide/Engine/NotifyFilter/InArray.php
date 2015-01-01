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

class Streamwide_Engine_NotifyFilter_InArray extends Streamwide_Engine_NotifyFilter
{
    
    protected $_strict = false;
    protected $_emptyListSatisfiesAll = false;
    
    public function __construct( Array $list, $emptyListSatisfiesAll = false, $strict = false )
    {
        parent::__construct( $list );
        $this->_emptyListSatisfiesAll = (bool)$emptyListSatisfiesAll;
        $this->_strict = (bool)$strict;
    }
    
    public function isSatisfiedBy( $candidate )
    {
        $list = $this->_value;
        
        if ( empty( $list ) ) {
            return $this->_emptyListSatisfiesAll;
        }
        
        return in_array( $candidate, array_map( array( $this, '_mapCallLegsToValues' ), $list ), $this->_strict );
    }
    
    protected function _mapCallLegsToValues( $elem )
    {
        if ( $elem instanceof Streamwide_Engine_Call_Leg_Abstract ) {
            return $elem->getName();
        }
        
        return $elem;
    }

}
 
/* EOF */