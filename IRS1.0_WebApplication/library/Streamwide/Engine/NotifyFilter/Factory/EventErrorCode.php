<?php
/**
 *
 * $Rev: 2560 $
 * $LastChangedDate: 2010-04-23 15:49:53 +0800 (Fri, 23 Apr 2010) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Package
 * @subpackage SubPackage
 * @version 1.0
 *
 */

class Streamwide_Engine_NotifyFilter_Factory_EventErrorCode extends Streamwide_Engine_NotifyFilter_Factory
{
    
    /**
     * @see Engine/NotifyFilter/Streamwide_Engine_NotifyFilter_Factory#equalToFilter($value, $strict)
     */
    public function equalToFilter( $value, $strict = false )
    {
        return $this->_createFilter( parent::equalToFilter( $value, $strict ) );
    }

    /**
     * @see Engine/NotifyFilter/Streamwide_Engine_NotifyFilter_Factory#inArrayFilter($value, $strict)
     */
    public function inArrayFilter( Array $list, $emptyListSatisfiesAll = false, $strict = false )
    {
        return $this->_createFilter( parent::inArrayFilter( $list, $emptyListSatisfiesAll, $strict ) );
    }

    /**
     * @see Engine/NotifyFilter/Streamwide_Engine_NotifyFilter_Factory#instanceOfFilter($class)
     */
    public function instanceOfFilter( $class )
    {
        return $this->_createFilter( parent::instanceOfFilter( $class ) );
    }
    
    /**
     * Decides what decorator will wrap the filter
     *
     * @param Streamwide_Specification_Abstract $filter
     * @return Streamwide_Specification_Abstract
     */
    protected function _createFilter( $filter )
    {
        return new Streamwide_Engine_Events_Event_ErrorCode_Specification_Decorator( $filter );
    }
    
}
 
/* EOF */