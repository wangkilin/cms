<?php
/**
 *
 * $Rev: 2560 $
 * $LastChangedDate: 2010-04-23 15:49:53 +0800 (Fri, 23 Apr 2010) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Widget_Decorator
 * @version 1.0
 *
 */

/**
 * Base class to allow unobtrusive adding of behaviour for widgets, without abusing
 * inheritance
 */
abstract class Streamwide_Engine_Widget_Decorator extends Streamwide_Engine_Widget_Wrapper
{
    
    /**
     * Retrieves the decorated widget (the end of the chain)
     *
     * @return Streamwide_Engine_Widget
     */
    public function getDecoratedWidget()
    {
        if ( $this->_widget instanceof self ) {
            return $this->_widget->getDecoratedWidget();
        }
        return $this->_widget;
    }
    
    

}

/* EOF */
