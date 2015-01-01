<?php
/**
 * Implementation of Streamwide_Introspection_Array class.
 *
 * A representation of an introspection array.
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

/**
 * A representation of an introspection array.
 */
class Streamwide_Introspection_Array implements Streamwide_Introspection_Composite_Interface
{
    /**
     * @var array
     */
    protected $_children = array();

    /**
     * Add a child. Note that only Streamwide_Introspection_Method objects are allowed as children
     *
     * @param Streamwide_Introspection_Leaf_Interface $child the child leaf object
     * @return void
     */
    public function addChild( Streamwide_Introspection_Leaf_Interface $child )
    {
        if ( $child instanceof Streamwide_Introspection_Method ) {
            $this->_children[] = $child;
        }
    }

    /**
     * Remove a child. This functionality is not needed nor encouraged for this kind of object so we just return null
     *
     * @param Streamwide_Introspection_Leaf_Interface $child the child leaf object
     * @return void
     */
    public function removeChild( Streamwide_Introspection_Leaf_Interface $child )
    {
        return null;
    }

    /**
     * Do we have children attached?
     *
     * @return boolean
     */
    public function hasChildren()
    {
        return count( $this->_children ) > 0;
    }

    /**
     * Returns an array representation of this object and its children
     *
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'methodList' => array()
        );
        foreach ( $this->_children as $child ) {
            $array['methodList'][] = $child->toArray();
        }
        return $array;
    }
}

/* EOF */