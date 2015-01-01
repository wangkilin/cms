<?php
/**
 * Representation of an error string returned by a method.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Introspection
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Error.php 1962 2009-09-24 20:49:25Z rgasler $
 */

class Streamwide_Introspection_Method_Parameter_String_Error extends Streamwide_Introspection_Method_Parameter_String
{
    protected $_type = Streamwide_Introspection_Method_Parameter_Abstract::M_OTHER;

    /**
     * Set the parent
     *
     * @param Streamwide_Introspection_Composite_Interface $parent parent element
     * @return void
     */
    public function setParent( Streamwide_Introspection_Composite_Interface $parent )
    {
        $this->_parent = $parent;
    }

    /**
     * An instance of this class cannot be a method parameter, return value or error
     *
     * @param integer $type parameter type
     * @return void
     */
    public function setType( $type )
    {
    }
}

/* EOF */