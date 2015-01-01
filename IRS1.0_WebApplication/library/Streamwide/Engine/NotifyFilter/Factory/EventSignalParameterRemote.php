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
 * Factory class that creates notification filters who filter out a Streamwide_Engine_Events_Event instance
 * that has a Streamwide_Engine_Signal parameter that, in turn, has a certain remote (source of emision)
 */
class Streamwide_Engine_NotifyFilter_Factory_EventSignalParameterRemote extends Streamwide_Engine_NotifyFilter_Factory
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
     *
     * This filter doesn't make sense (a signal's remote property will never be an instance of any class,
     * unless PHP will introduce a String class) but its here to conform with the filter factory API
     */
    public function instanceOfFilter( $class )
    {
        return $this->_createFilter( parent::instanceOfFilter( $class ) );
    }
    
    /**
     * Wraps the filter in the needed decorators and returns it
     *
     * @param Streamwide_Specification_Abstract $filter
     * @return Streamwide_Specification_Abstract
     */
    protected function _createFilter( $filter )
    {
        return new Streamwide_Engine_Events_Event_Param_Signal_Specification_Decorator(
            new Streamwide_Engine_Signal_Remote_Specification_Decorator(
                $filter
            )
        );
    }
    
}
 
/* EOF */