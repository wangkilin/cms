<?php
/**
 * A representation of a string method parameter.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Introspection
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: String.php 1962 2009-09-24 20:49:25Z rgasler $
 */

/**
 * A representation of a string method parameter
 */
class Streamwide_Introspection_Method_Parameter_String extends Streamwide_Introspection_Method_Parameter_Abstract
{
    /**
     * Class constructor.
     *
     * @param string  $name        parameter name
     * @param string  $description parameter description
     * @param boolean $isOptional  (optional) if the parameter is optional, false by default
     * @param string  $alias       (optional) parameter alias
     */
    public function __construct( $name, $description, $isOptional = false, $alias = null )
    {
        parent::__construct( $name, $description, $isOptional, $alias );
        $this->_dataType = Streamwide_Introspection_Method_Parameter_Abstract::T_STRING;
    }

    /**
     * Translate from DB type into PHP type
     *
     * @param int $value the value to cast to string
     * @return boolean
     */
    public function castToPhp( $value )
    {
        if (!is_null($value)) {
            return strval($value);
        }
        return $value;
    }
}

/* EOF */