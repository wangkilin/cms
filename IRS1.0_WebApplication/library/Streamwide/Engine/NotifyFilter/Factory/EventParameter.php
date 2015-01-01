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

class Streamwide_Engine_NotifyFilter_Factory_EventParameter extends Streamwide_Engine_NotifyFilter_Factory
{
    
    /**
     * @see Engine/NotifyFilter/Streamwide_Engine_NotifyFilter_Factory#equalToFilter($value, $strict)
     */
    public function equalToFilter( $param, $value, $strict = false )
    {
        return $this->_createFilter(
            $param,
            parent::equalToFilter( $value, $strict )
        );
    }

    /**
     * @see Engine/NotifyFilter/Streamwide_Engine_NotifyFilter_Factory#inArrayFilter($value, $strict)
     */
    public function inArrayFilter( $param, Array $list, $emptyListSatisfiesAll = false, $strict = false )
    {
        return $this->_createFilter(
            $param,
            parent::inArrayFilter( $list, $emptyListSatisfiesAll, $strict )
        );
    }

    /**
     * @see Engine/NotifyFilter/Streamwide_Engine_NotifyFilter_Factory#instanceOfFilter($class)
     */
    public function instanceOfFilter( $param, $class )
    {
        return $this->_createFilter(
            $param,
            parent::instanceOfFilter( $class )
        );
    }
    
    /**
     * Decides what decorator will wrap the filter
     *
     * @param string $param
     * @param Streamwide_Specification_Abstract $filter
     * @return Streamwide_Specification_Abstract
     */
    protected function _createFilter( $param, $filter )
    {
        if ( 'signal' === $param ) {
            return new Streamwide_Engine_Events_Event_Param_Signal_Specification_Decorator( $filter );
        }
        
        return new Streamwide_Engine_Events_Event_Param_Specification_Decorator( $filter, $param );
    }
    
}
 
/* EOF */