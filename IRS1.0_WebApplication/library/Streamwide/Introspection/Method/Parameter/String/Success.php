<?php
/**
 * Representation of a success string returned by a method.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Introspection
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Success.php 1962 2009-09-24 20:49:25Z rgasler $
 */

class Streamwide_Introspection_Method_Parameter_String_Success extends Streamwide_Introspection_Method_Parameter_String
{
    protected $_type = Streamwide_Introspection_Method_Parameter_Abstract::M_RETVAL;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct( 'SuccessString', 'The string "OK" if operation succeeds' );
    }

    /**
     * This class can be added as child only to Streamwide_Introspection_Method
     * which doesn't set itself as a parent of the child,
     * meaning that an instance of this class will never have a parent
     *
     * @param Streamwide_Introspection_Composite_Interface $parent parent element
     * @return void
     */
    public function setParent( Streamwide_Introspection_Composite_Interface $parent )
    {
        return null;
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