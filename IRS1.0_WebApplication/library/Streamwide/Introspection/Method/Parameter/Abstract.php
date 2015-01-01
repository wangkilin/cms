<?php
/**
 * Abstract method parameter.
 *
 * Method parameters can be structures, arrays, booleans,
 * datetimes, strings, doubles or integers.
 *
 * $Rev: 1967 $
 * $LastChangedDate: 2009-09-25 19:50:42 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Introspection
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Abstract.php 1967 2009-09-25 11:50:42Z rgasler $
 */

abstract class Streamwide_Introspection_Method_Parameter_Abstract implements Streamwide_Introspection_Leaf_Interface
{
    /**
     * Method parameter data types
     */
    const T_STRUCTURE = 'struct';
    const T_ARRAY = 'array';
    const T_BOOLEAN = 'boolean';
    const T_DATETIME = 'string';
    const T_STRING = 'string';
    const T_DOUBLE = 'double';
    const T_INTEGER = 'int';
    const T_LONG = 'string';
    const T_BASE64 = 'string';

    /**
     * Parameter types relative to a method (a method parameter, a method return value or a method error)
     */
    const M_PARAM = 1;
    const M_RETVAL = 2;
    const M_ERROR = 3;
    const M_OTHER = -1;

    /**
     * The name of the parameter (used only when the parameter is a child of a structure or an array parameter)
     *
     * @var string
     */
    protected $_name;

    /**
     * Type of the parameter (see the above const definitions)
     *
     * @var string
     */
    protected $_dataType;

    /**
     * The type of the parameter relative to a method
     * (meaning this object can be used either as a method parameter or a method return value).
     * Defaults to method parameter.
     *
     * @var integer
     */
    protected $_type = self::M_PARAM;

    /**
     * The parameter description
     *
     * @var string
     */
    protected $_description;

    /**
     * Is the parameter optional?
     *
     * @var boolean
     */
    protected $_isOptional = false;

    /**
     * Parent of this parameter (used only when the parameter is a child of a structure or an array parameter)
     * Can only be of type Streamwide_Introspection_Composite_Interface
     *
     * @var Streamwide_Introspection_Composite_Interface
     */
    protected $_parent = null;

    /**
     * Alias name used in translation
     * @var string
     */
    protected $_alias;

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
        $this->setName( $name );
        $this->setDescription( $description );
        $this->setOptional( $isOptional );
        $this->setAlias( $alias );
    }

    /**
     * Setter method for the Streamwide_Introspection_Method_Parameter_Abstract::_name property
     *
     * @param string $name the parameter name
     * @return void
     */
    public function setName( $name )
    {
        $this->_name = (string)$name;
    }

    /**
     * Setter method for the Streamwide_Introspection_Method_Parameter_Abstract::_type property
     *
     * @param int $type the type of the parameter
     * @return void
     */
    public function setType( $type )
    {
        $type = (int)$type;
        switch ( $type ) {
            case self::M_PARAM:
            case self::M_RETVAL:
                $this->_type = $type;
                break;
        }
    }

    /**
     * Setter method for the Streamwide_Introspection_Method_Parameter_Abstract::_description property
     *
     * @param string $description the parameter description
     * @return void
     */
    public function setDescription( $description )
    {
        $this->_description = (string)$description;
    }

    /**
     * Setter method for the Streamwide_Introspection_Method_Parameter_Abstract::_isOptional property
     *
     * @param boolean $isOptional whether this parameter is optional
     * @return void
     */
    public function setOptional( $isOptional )
    {
        $this->_isOptional = (bool)$isOptional;
    }

    /**
     * Setter method for the Streamwide_Introspection_Method_Parameter_Abstract::_parent property
     *
     * @param Streamwide_Introspection_Composite_Interface $parent parent
     * @return void
     */
    public function setParent( Streamwide_Introspection_Composite_Interface $parent )
    {
        $this->_parent = $parent;
    }

    /**
     * Setter for alias
     *
     * @param string $alias parameter alias
     * @return void
     */
    public function setAlias( $alias )
    {
        $this->_alias = $alias;
    }

    /**
     * Getter method for the Streamwide_Introspection_Method_Parameter_Abstract::_name property
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Getter method for the Streamwide_Introspection_Method_Parameter_Abstract::_type property
     *
     * @return integer
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Getter method for the Streamwide_Introspection_Method_Parameter_Abstract::_dataType property
     *
     * @return integer
     */
    public function getDataType()
    {
        return $this->_dataType;
    }


    /**
     * Getter method for the Streamwide_Introspection_Method_Parameter_Abstract::_description property
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Getter method for the Streamwide_Introspection_Method_Parameter_Abstract::_isOptional property
     *
     * @return boolean
     */
    public function isOptional()
    {
        return $this->_isOptional;
    }

    /**
     * Getter for parameter alias.
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->_alias;
    }

    /**
     * Is this object a method parameter?
     *
     * @return boolean
     */
    public function isMethodParameter()
    {
        return $this->_type === self::M_PARAM;
    }

    /**
     * Is this object a method return value?
     *
     * @return boolean
     */
    public function isMethodReturnValue()
    {
        return $this->_type === self::M_RETVAL;
    }

    /**
     * Is this object a method error?
     *
     * @return boolean
     */
    public function isMethodError()
    {
        return $this->_type === self::M_ERROR;
    }

    /**
     * Getter method for the Streamwide_Introspection_Method_Parameter_Abstract::_parent property
     *
     * @return Streamwide_Introspection_Composite_Interface
     */
    public function getParent()
    {
        return $this->_parent;
    }

    /**
     * Requests to be removed as a child
     *
     * @return boolean
     */
    public function removeMe()
    {
        if ( null !== $this->_parent && true === $this->_parent->removeChild( $this ) ) {
            $this->_parent = null;
            return true;
        }
        return false;
    }

    /**
     * Return an array representation of the current object
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'type' => $this->_dataType,
            'description' => $this->_description,
            'optional' => (int)$this->_isOptional
        );
    }

    /**
     * Translate from PHP type into DB type
     * eg: php type TRUE goes into 1 or 0 for db type
     *
     * @param mixed $value value to cast from php type
     * @return mixed
     */
    public function castFromPhp( $value )
    {
        return $value;
    }

    /**
     * Translate from DB type into PHP type
     * boolean db 1/0 goes into php type TRUE/FALSE
     * string float/int goes into (int) $val or floatval($val)
     *
     * @param mixed $value value to cast to php type
     * @return mixed
     */
    public function castToPhp( $value )
    {
        return $value;
    }
}

/* EOF */