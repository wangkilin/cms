<?php
/**
 * A representation of a long/i8 method parameter.
 *
 * $Rev: 1954 $
 * $LastChangedDate: 2009-09-24 23:27:45 +0800 (Thu, 24 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Introspection
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Long.php 1954 2009-09-24 15:27:45Z rgasler $
 */

class Streamwide_Introspection_Method_Parameter_Long extends Streamwide_Introspection_Method_Parameter_Abstract
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
        $this->_dataType = Streamwide_Introspection_Method_Parameter_Abstract::T_LONG;
    }

    /**
     * Translate from DB type into PHP type
     *
     * @param string $value the value to cast to long
     * @return float
     */
    public function castToPhp( $value )
    {
        if (!is_null($value)) {
            return floatval($value);
        }
        return $value;
    }
}

/* EOF */