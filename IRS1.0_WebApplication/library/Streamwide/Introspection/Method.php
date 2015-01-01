<?php
/**
 * Implementation of Streamwide_Introspection_Method class.
 *
 * A representation of a introspection method.
 * The method can have parameters, one return value and can be parametrized
 * with an array of errors.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Introspection
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Method.php 1962 2009-09-24 20:49:25Z rgasler $
 */

class Streamwide_Introspection_Method implements Streamwide_Introspection_Composite_Interface
{
    /**
     * The name of the method
     *
     * @var string
     */
    protected $_name;

    /**
     * The author of the method
     *
     * @var string
     */
    protected $_author;

    /**
     * The method version
     *
     * @var string
     */
    protected $_version;

    /**
     * The purpose of the method
     *
     * @var string
     */
    protected $_purpose;

    /**
     * Holds the parameters for this method
     *
     * @var array
     */
    protected $_params = array();

    /**
     * Holds the return value of the method
     *
     * @var array
     */
    protected $_returns = array();

    /**
     * Holds error structure for this method
     *
     * @var array
     */
    protected $_errors = array();

    /**
     * Constructor
     *
     * @param string $name    method name
     * @param string $purpose method purpose
     * @param array  $errors  array of errors returned by this method
     * @param string $author  (optional) author
     * @param string $version (optional) version
     */
    public function __construct( $name, $purpose, $author = null, $version = null )
    {
    	$this->_name = $name;
        $this->_purpose = $purpose;
        $this->_author = $author;
        $this->_version = $version;
    }

    /**
     * Add a child. When $type is set to 'parameter' the child is added to the Streamwide_Introspection_Method::_params array. Otherwise the child
     * is set to be the return value of the method. If a return value has already been set returns false
     *
     * @param Streamwide_Introspection_Leaf_Interface $child child to add
     * @return boolean
     */
    public function addChild( Streamwide_Introspection_Leaf_Interface $child )
    {
        // do not allow other Streamwide_Introspection_Method objects or Streamwide_Introspection_Array objects
        // to be added as children because it doesn't make sense
        $unallowedTypes = array( __CLASS__, 'Streamwide_Introspection_Array' );
        foreach ( $unallowedTypes as $unallowedType ) {
        	if ( $child instanceof $unallowedType ) {
        		return false;
        	}
        }

        // Check to see if the child is the error structure for the method
        if ( $child->isMethodError() ) {
        	if ( 0 === count( $this->_errors ) ) {
        		$this->_errors[] = $child;
                return false;
        	}
        }

        // if the child is a method return value check to see if we don't already have set a return value
        // for this method
        if ( $child->isMethodReturnValue() ) {
            if ( 0 === count( $this->_returns ) ) {
                $this->_returns[] = $child;
                return false;
            }
        }

        // if we got here we are certain that the child is a method parameter
        $this->_params[] = $child;
        
        return true;
    }

    /**
     * Prevent removal of children (we don't need such a functionality but it is defined in the API of Introspection_Composite_Interface
     * so we must implement it)
     *
     * @param Streamwide_Introspection_Leaf_Interface $child
     * @return void
     */
    public function removeChild( Streamwide_Introspection_Leaf_Interface $child )
    {
    	// do not allow removal of children
    }

    /**
     * Do we have children? We don't this functionality but it is defined in the API of Streamwide_Introspection_Composite_Interface
     * so we must implement it. Note that the children count is represented by the sum of the parameters and the return value
     *
     * @return boolean
     */
    public function hasChildren()
    {
    	return count( $this->_params ) > 0
            || count( $this->_errors ) > 0
            || count( $this->_returns ) > 0;
    }

    /**
     * Return an array representation of the current object
     *
     * @return array
     */
    public function toArray()
    {
        // check to see if the method has a return value set
        if ( 0 === count( $this->_returns ) ) {
        	throw new Exception( 'The method needs a return value' );
        }

        // check to see if the method has the errors set, if not create an empty error structure
        if ( 0 === count( $this->_errors ) ) {
        	$this->_errors[] = new Streamwide_Introspection_Method_Parameter_Structure_Error( null, null );
        }

        // build the template for the return array
    	$array = array(
            'name' => $this->_name,
            'author' => $this->_author,
            'purpose' => $this->_purpose,
            'version' => $this->_version,
            'signatures' => array()
        );

        $signature = array(
            'params' => array(),
            'returns' => array()
        );

        foreach ( $this->_params as $param ) {
            $signature['params'][] = $param->toArray();
        }

        list( $returnValue ) = $this->_returns;
        $signature['returns'][] = $returnValue->toArray();

        list( $errorStructure ) = $this->_errors;
        $signature['returns'][] = $errorStructure->toArray();

        $array['signatures'][] = $signature;

        return $array;
    }
}

/* EOF */