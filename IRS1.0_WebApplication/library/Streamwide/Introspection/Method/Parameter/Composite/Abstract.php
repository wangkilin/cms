<?php
/**
 * Abstract composite method parameter.
 *
 * A composite method parameter can be a structure parameter
 * or an array parameter.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Introspection
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Abstract.php 1962 2009-09-24 20:49:25Z rgasler $
 */

/**
 * Represents a composite method parameter (a structure parameter or an array parameter)
 */
abstract class Streamwide_Introspection_Method_Parameter_Composite_Abstract extends Streamwide_Introspection_Method_Parameter_Abstract implements Streamwide_Introspection_Composite_Interface
{
    /**
     * The nesting separator character
     */
    const NESTING_SEPARATOR = '.';

    /**
     * Holds children references
     *
     * @var array
     */
    protected $_children = array();

    /**
     * Instances of the classes listed in this array are not allowed to be added as children
     *
     * @var array
     */
    protected static $_unallowedTypes = array(
        'Streamwide_Introspection_Method',
        'Streamwide_Introspection_Array',
        'Streamwide_Introspection_Method_Parameter_String_Error',
        'Streamwide_Introspection_Method_Parameter_String_Success',
        'Streamwide_Introspection_Method_Parameter_Structure_Error'
    );

    /**
     * Add a child
     *
     * @param Streamwide_Introspection_Leaf_Interface $child child element to add
     * @return void
     */
    public function addChild( Streamwide_Introspection_Leaf_Interface $child )
    {
        // do not allow instances of Streamwide_Introspection_Method or Streamwide_Introspection_Array to be added
        // as children because it doesn't make sense
        if ( false === $this->_isAllowedChild( $child ) ) {
            return null;
        }

        $this->_children[] = $child;
        $child->setParent( $this );
    }

    /**
     * Remove a child
     *
     * @param Streamwide_Introspection_Leaf_Interface $child child element to remove
     * @return boolean
     */
    public function removeChild( Streamwide_Introspection_Leaf_Interface $child )
    {
        if ( false === $this->_isAllowedChild( $child ) ) {
            return false;
        }

        $key = array_search( $child, $this->_children, true );
        if ( false !== $key ) {
            unset( $this->_children[$key] );
            return true;
        }
        return false;
    }

    /**
     * Returns the array of children
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->_children;
    }

    /**
     * Do we have any children attached?
     *
     * @return boolean
     */
    public function hasChildren()
    {
        return ( count( $this->_children ) > 0 );
    }

    /**
     * Get the number of children (used for testing)
     *
     * @return integer
     */
    public function getChildrenCount()
    {
        return count( $this->_children );
    }

    /**
     * Find a child by name. For child belonging to inner composite parameters use the nest separator.
     * Example: X.Y.Z will search for a child with the name Z that belongs to a composite parameter
     * with the name Y that in turn belongs to a composite parameter with the name X that belongs to this
     * composite parameter
     *
     * @param string $name child name
     * @return Streamwide_Introspection_Method_Parameter_Abstract|boolean The requested child or false if the child cannot be found
     */
    public function findChild( $name )
    {
        $levels = explode( self::NESTING_SEPARATOR, $name, 2 );
        $childName = array_shift( $levels );

        // search the first level of this structure
        $found = false;
        foreach ( $this->_children as $key => $child ) {
            if ( $child->getName() === $childName ) {
                $found = true;
                break;
            }
        }

        // check if we found a child in the first level
        if ( false === $found ) {
            return false;
        }

        // are there more levels to be searched? if not we are done
        if ( count( $levels ) == 0 ) {
            return $child;
        }

        // sanity check
        // Example: When searching for X.Y.Z, X and Y
        // must be instances of Streamwide_Introspection_Composite_Interface (because other types cannot have children)
        if ( !$child instanceof Streamwide_Introspection_Composite_Interface ) {
            return false;
        }

        return $child->findChild( $levels[0] );
    }

    /**
     * Getter method for the Streamwide_Introspection_Method_Parameter_Composite_Abstract::_unallowedTypes property
     *
     * @return array
     */
    public function getUnallowedTypes()
    {
        return self::$_unallowedTypes;
    }

    /**
     * Remove a inner child by its name
     * (please note that this method stops at the first found child,
     * if you have children with the same name go somewhere else :-))
     *
     * @param string $name the child name
     * @return boolean true if the child was removed, false otherwise
     */
    public function removeChildByName( $name )
    {
        if ( false === ( $child = $this->findChild( $name ) ) ) {
            return false;
        }
        return $child->removeMe();
    }

    /**
     * Set the isOptional property of a inner child
     * (please note that this method stops at the first found child,
     * if you have children with the same name go somewhere else :-))
     *
     * @param string  $name       the child name
     * @param boolean $isOptional whether the child is optional
     * @return boolean
     */
    public function setOptionalChildByName( $name, $isOptional )
    {
        if ( false === ( $child = $this->findChild( $name ) ) ) {
            return false;
        }
        $child->setOptional( $isOptional );
        return true;
    }

    /**
     * Check the class of a child
     *
     * @param Streamwide_Introspection_Leaf_Interface $child child element
     * @return boolean
     */
    protected function _isAllowedChild( Streamwide_Introspection_Leaf_Interface $child )
    {
        return ( !in_array( get_class( $child ), self::$_unallowedTypes ) );
    }


    /**
     * This function translates an array to internal structure
     *
     * @param array   $input                   input structure to translate
     * @param boolean $changeTypeOnTranslation (optional) whether to change also data type on translation
     * @return array The input array translated
     */
    abstract public function translateStructureToPhp ( $input, $changeTypeOnTranslation = true );

    /**
     * This function translates an array from internal structure
     *
     * @param array   $input                   input structure to translate
     * @param boolean $changeTypeOnTranslation (optional) whether to change also data type on translation
     * @return array The input array translated
     */
    abstract public function translateStructureFromPhp ( $input, $changeTypeOnTranslation = true );
}

/* EOF */
