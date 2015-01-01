<?php
/**
 * A representation of a structure method parameter.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Introspection
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Structure.php 1962 2009-09-24 20:49:25Z rgasler $
 */

/**
 * A representation of a structure method parameter
 */
class Streamwide_Introspection_Method_Parameter_Structure extends Streamwide_Introspection_Method_Parameter_Composite_Abstract
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
        $this->_dataType = Streamwide_Introspection_Method_Parameter_Abstract::T_STRUCTURE;
    }

    /**
     * Return an array representation of the current object
     *
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();
        $tmp = array();
        foreach ( $this->_children as $child ) {
            $tmp = array_merge( $tmp, array( $child->getName() => $child->toArray() ) );
            $array['member'] = $tmp;
        }
        return $array;
    }

    /**
     * This function translates an array to internal structure
     *
     * @param array   $input                   input structure to translate
     * @param boolean $changeTypeOnTranslation (optional) whether to change also data type on translation
     * @return array The input array translated
     */
    public function translateStructureToPhp ( $input, $changeTypeOnTranslation = true )
    {
        foreach ($this->_children as $child) {
            if (is_array($input) && array_key_exists($child->getAlias(), $input)) {
                $input[$child->getName()] = $input[$child->getAlias()];
                unset($input[$child->getAlias()]);
                if ($changeTypeOnTranslation) {
                    $input[$child->getName()] = $child->castToPhp($input[$child->getName()]);
                }

                if ($child instanceof Streamwide_Introspection_Method_Parameter_Composite_Abstract) {
                    $input[$child->getName()] = $child->translateStructureToPhp($input[$child->getName()], $changeTypeOnTranslation);
                }
            }
        }
        return $input;
    }

    /**
     * This function translates an array from internal structure
     *
     * @param array   $input                   input structure to translate
     * @param boolean $changeTypeOnTranslation (optional) whether to change also data type on translation
     * @return array The input array translated
     */
    public function translateStructureFromPhp ( $input, $changeTypeOnTranslation = true )
    {
        foreach ($this->_children as $child) {
            if (is_array($input) && array_key_exists($child->getName(), $input)) {
                $input[$child->getAlias()] = $input[$child->getName()];
                unset($input[$child->getName()]);
                if ($changeTypeOnTranslation) {
                    $input[$child->getAlias()] = $child->castFromPhp($input[$child->getAlias()]);
                }

                if ($child instanceof Streamwide_Introspection_Method_Parameter_Composite_Abstract) {
                    $input[$child->getAlias()] = $child->translateStructureFromPhp($input[$child->getAlias()], $changeTypeOnTranslation);
                }
            }
        }
        
        return $input;
    }
}

/* EOF */