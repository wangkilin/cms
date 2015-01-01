<?php
/**
 * A representation of a boolean method parameter.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Introspection
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Boolean.php 1962 2009-09-24 20:49:25Z rgasler $
 */

class Streamwide_Introspection_Method_Parameter_Boolean extends Streamwide_Introspection_Method_Parameter_Abstract
{

    /**
     * Class constructor.
     *
     * @param string  $name        parameter name
     * @param string  $description parameter description
     * @param boolean $isOptional  (optional) if the parameter is optional, false by default
     * @param string  $alias       (optional) parameter alias
     */
    function __construct( $name, $description, $isOptional = false, $alias = null )
    {
        parent::__construct( $name, $description, $isOptional, $alias );
        $this->_dataType = Streamwide_Introspection_Method_Parameter_Abstract::T_BOOLEAN;
    }

    /**
     * Translate from DB type into PHP type
     *
     * @param int $value value to translate
     * @return boolean
     */
    public function castToPhp( $value )
    {
        if (!is_null($value)) {
            return (bool) $value;
        }
        return $value;
    }

    /**
     * Translate from PHP type into DB type
     *
     * @param boolean $value value to translate
     * @return int
     */
    public function castFromPhp( $value )
    {
        if (!is_null($value)) {
            return ($value == true) ? 1 : 0;
        }
        return $value;
    }

}

/* EOF */
