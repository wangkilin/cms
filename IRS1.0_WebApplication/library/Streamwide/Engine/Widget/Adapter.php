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

abstract class Streamwide_Engine_Widget_Adapter extends Streamwide_Engine_Widget_Wrapper
{

    /**
     * Retrieves the adaptee widget
     *
     * @return Streamwide_Engine_Widget
     */
    public function getAdaptee()
    {
        return $this->_widget;
    }
    
    
}
 
/* EOF */