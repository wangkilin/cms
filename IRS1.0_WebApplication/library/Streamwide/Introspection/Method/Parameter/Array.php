<?php
/**
 * A representation of an array method parameter.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Introspection
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Array.php 1962 2009-09-24 20:49:25Z rgasler $
 */

class Streamwide_Introspection_Method_Parameter_Array extends Streamwide_Introspection_Method_Parameter_Composite_Abstract
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
        $this->_dataType = Streamwide_Introspection_Method_Parameter_Abstract::T_ARRAY;
    }

    /**
     * Add a child. Note that only one child is allowed. This is because the introspection will check every element
     * of an array method parameter to correspond with the definition of this child
     *
     * @param Streamwide_Introspection_Composite_Interface $child child parameter
     * @return void
     */
    public function addChild( Streamwide_Introspection_Leaf_Interface $child )
    {
        if ( count( $this->_children ) == 0 ) {
            $this->_children[] = $child;
            $child->setParent( $this );
        }
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
            $tmp = array_merge( $tmp, array( $child->toArray() ) );
            $array['member'] = $tmp;
        }
        return $array;
    }

    /**
     * This function translates an internal structure to a php array
     *
     * @param array   $input                   input array to translate
     * @param boolean $changeTypeOnTranslation (optional) whether to change also the data types on translation
     * @return array The input array translated
     */
    public function translateStructureToPhp ( $input, $changeTypeOnTranslation = true )
    {
        if (is_array($input)
            && $this->_children[0] instanceof Streamwide_Introspection_Method_Parameter_Composite_Abstract) {
            foreach ($input as &$value) {
                $value = $this->_children[0]->translateStructureToPhp($value, $changeTypeOnTranslation);
            }
        }
        return $input;
    }

    /**
     * This function translates a php array to an internal format
     *
     * @param array   $input                   array to translate
     * @param boolean $changeTypeOnTranslation (optional) whether to change also the data types on translation
     * @return array  The input array translated
     */
    public function translateStructureFromPhp ( $input, $changeTypeOnTranslation = true )
    {
        if (is_array($input)
            && $this->_children[0] instanceof Streamwide_Introspection_Method_Parameter_Composite_Abstract) {
            foreach ($input as &$value) {
                $value = $this->_children[0]->translateStructureFromPhp($value, $changeTypeOnTranslation);
            }
        }
        return $input;
    }
}

/* EOF */