<?php
/**
 * Introspection builder.
 *
 * Helps ease out the pain of creating an introspection array.
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

abstract class Streamwide_Introspection_Builder_Abstract
{
    /**
     * Introspection array
     *
     * @var Streamwide_Introspection_Array
     */
    protected $_introspection;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_introspection = new Streamwide_Introspection_Array();
    }

    /**
     * Builds the introspection array (creates the methods and adds them)
     *
     * @return void
     */
    abstract protected function _build();

    /**
     * Getter method for the Streamwide_Introspection_Builder_Abstract::_introspection property
     *
     * @return Streamwide_Introspection_Array
     */
    public function getIntrospection()
    {
        $this->_build();
        return $this->_introspection;
    }

    /**
     * Helper method. Adds a method to the introspection array
     *
     * @param Streamwide_Introspection_Method $method method object to add
     * @return void
     */
    protected function _addMethod( Streamwide_Introspection_Method $method )
    {
        $this->_introspection->addChild( $method );
    }

    /**
     * Helper method. Creates an empty new method.
     *
     * @param string $name    Method name.
     * @param string $purpose Method purpose.
     * @param string $author  (optional) Method author.
     * @param string $version (optional) Method version.
     * @return Streamwide_Introspection_Method
     */
    protected function _newMethod( $name, $purpose, $author = null, $version = null )
    {
        return new Streamwide_Introspection_Method( $name, $purpose, $author, $version );
    }

    /**
     * Helper method. Adds $param to $method
     *
     * @param Streamwide_Introspection_Method                    $method Method object.
     * @param Streamwide_Introspection_Method_Parameter_Abstract $param  Method parameter object.
     * @return void
     */
    protected function _setMethodParam( Streamwide_Introspection_Method $method, Streamwide_Introspection_Method_Parameter_Abstract $param )
    {
        if ( false === $param->isMethodParameter() ) {
            return null;
        }
        $method->addChild( $param );
    }

    /**
     * Helper method. Adds a return value to a method.
     *
     * @param Streamwide_Introspection_Method                    $method      Method object.
     * @param Streamwide_Introspection_Method_Parameter_Abstract $returnValue Return value object.
     * @return void
     */
    protected function _setMethodReturnValue( Streamwide_Introspection_Method $method, Streamwide_Introspection_Method_Parameter_Abstract $returnValue )
    {
        if ( false === $returnValue->isMethodReturnValue() ) {
            return null;
        }
        $method->addChild( $returnValue );
    }

    /**
     * Helper method. Adds an error structure to a method.
     *
     * @param Streamwide_Introspection_Method                           $method Method object.
     * @param Streamwide_Introspection_Method_Parameter_Structure_Error $struct Error structure object.
     * @return void
     */
    protected function _setMethodErrors( Streamwide_Introspection_Method $method, Streamwide_Introspection_Method_Parameter_Structure_Error $struct )
    {
        if ( false === $struct->isMethodError() ) {
            return null;
        }
        $method->addChild( $struct );
    }

    /**
     * Helper method. Removes inner children by name.
     *
     * @param Streamwide_Introspection_Method_Parameter_Composite_Abstract $param    Metod parameter object.
     * @param array                                                        $children A numerically indexed array with children names
     * @return void
     */
    protected function _removeParameterChildren( Streamwide_Introspection_Method_Parameter_Composite_Abstract $param, Array $children )
    {
        foreach ( $children as $childName ) {
            $param->removeChildByName( $childName );
        }
    }

    /**
     * Helper method. Sets inner children to be mandatory or optional and the children are specified by name
     *
     * @param Streamwide_Introspection_Method_Parameter_Composite_Abstract $param    Method parameter object.
     * @param array                                                        $children An associative array with key being the child name and value being the isOptional value
     * @return void
     */
    protected function _setParameterOptionalChildren( Streamwide_Introspection_Method_Parameter_Composite_Abstract $param, Array $children )
    {
        foreach ( $children as $childName => $isOptional ) {
            $param->setOptionalChildByName( $childName, $isOptional );
        }
    }
}

/* EOF */