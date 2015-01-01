<?php
/**
 * Representation of an error structure returned by a method.
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

class Streamwide_Introspection_Method_Parameter_Structure_Error extends Streamwide_Introspection_Method_Parameter_Structure
{
    protected $_type = Streamwide_Introspection_Method_Parameter_Abstract::M_ERROR;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct( 'ErrorStructure', 'Error' );
    }

    /**
     * Allow only instances of Streamwide_Introspection_Method_Parameter_String_Error to be added as children.
     * Also @see Streamwide_Introspection_Method_Parameter_Composite_Abstract::addChild method
     *
     * @param Streamwide_Introspection_Leaf_Interface $child the child leaf object
     * @return void
     */
    public function addChild( Streamwide_Introspection_Leaf_Interface $child )
    {
        if ( $child instanceof Streamwide_Introspection_Method_Parameter_String_Error ) {
            $this->_children[] = $child;
        }
    }

    /**
     * Do not allow removal of children.
     * Also @see Streamwide_Introspection_Method_Parameter_Composite_Abstract::removeChild method
     *
     * @param Streamwide_Introspection_Leaf_Interface $child the child leaf to remove
     * @return void
     */
    public function removeChild( Streamwide_Introspection_Leaf_Interface $child )
    {
    }

    /**
     * This structure cannot be added as a child to another structure or composite parameter
     * so setting a parent doesn't make sense
     *
     * @param Streamwide_Introspection_Composite_Interface $parent the parent object
     * @return void
     */
    public function setParent( Streamwide_Introspection_Composite_Interface $parent )
    {
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

    /**
     * Return an array representation of the current object
     *
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'type' => $this->getDataType(),
            'description' => $this->getDescription(),
            'optional' => (int)$this->isOptional()
        );

        if ( !empty( $this->_children ) ) {
            foreach ( $this->_children as $child ) {
                $array['errors'][$child->getName()] = $child->getDescription();
            }
        }

        return $array;
    }

}

/* EOF */