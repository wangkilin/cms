<?php
/**
 * Collection class.
 *
 * Used to handle a collection of objects of the same type.
 *
 * $Rev: 2026 $
 * $LastChangedDate: 2009-10-14 23:26:28 +0800 (Wed, 14 Oct 2009) $
 * $LastChangedBy: salexandru $
 *
 * @category   Streamwide
 * @package    Streamwide_Collection
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Collection.php 2026 2009-10-14 15:26:28Z salexandru $
 */

require_once 'Streamwide/Collection/Iterator.php';
require_once 'Streamwide/Collection/Exception.php';

class Streamwide_Collection implements Countable, IteratorAggregate
{

    /**
     * Items of the collection must be of type $_cType (cType stands for collection type)
     *
     * @var string
     */
    protected $_cType;

    /**
     * Internal array to hold the items
     *
     * @var array
     */
    protected $_collection = array();

    /**
     * Flag to indicate if the internal array has been loaded
     *
     * @var boolean
     */
    protected $_isLoaded = false;

    /**
     * Callback that handles the loading of the internal array
     *
     * @var string|array|null
     */
    protected $_loadCallback = null;

    /**
     * Arguments for the Collection::_loadCallback callback
     *
     * @var array
     */
    protected $_loadCallbackArgs = array();

    /**
     * Constructor.
     *
     * @param string $cType Collection type
     */
    public function __construct( $cType )
    {
        $this->_cType = $cType;
    }

    /**
     * Getter method for Collection::_cType property
     *
     * @return string Collection type
     */
    public function getCollectionType()
    {
        $this->_checkCallback();
        return $this->_cType;
    }

    /**
     * Getter method for Collection::_collection property
     *
     * @return array Collection
     */
    public function getCollection()
    {
        $this->_checkCallback();
        return $this->_collection;
    }

    /**
     * Setter method for Collection::_colection property.
     *
     * @param array $collection Collection
     * @return void
     */
    public function setCollection( array $collection )
    {
        // filter the provided $collection to contain only objects of type Collection::_class
        // array_filter does not reindex the array after removing the elements that do not satisfy the callback
        $this->_collection = array_values( array_filter( $collection, array( $this, '_checkUserProvidedItem' ) ) );
        $this->_isLoaded = true;
    }

    /**
     * Reset the internal array
     *
     * @return array The internal array as it was before reset
     */
    public function resetCollection()
    {
        $collection = $this->_collection;
        $this->_collection = array();
        $this->_isLoaded = false;
        return $collection;
    }

    /**
     * Callback function to be used in Collection::setCollection() method
     *
     * @param mixed $item An item from the user provided collection
     * @return boolean True if the item is an instance of Collection::_class, false otherwise
     */
    protected function _checkUserProvidedItem( $item )
    {
        return ( $item instanceof $this->_cType );
    }

    /**
     * Pops an element off the end of collection
     *
     * @return mixed An object of type Collection::_class
     *               or null if Collection::_collection is empty
     */
    public function pop()
    {
        $this->_checkCallback();
        return array_pop( $this->_collection );
    }

    /**
     * Pops an element off the begining of collection
     *
     * @return mixed An object of type Collection::_class
     *               or null if Collection::_collection is empty
     */
    public function shift()
    {
        $this->_checkCallback();
        return array_shift( $this->_collection );
    }

    /**
     * Prepends an item to the begining of collection
     *
     * @param mixed $item An object of type Collection::_cType
     * @return boolean True on success, false if the prepending fails
     * @throws Streamwide_Collection_Exception when the object type is not of collection type
     */
    public function unshift( $item )
    {
        if ( false === $this->_checkUserProvidedItem( $item ) ) {
            $message = '%s has been set to work with objects of type "%s"';
            throw new Streamwide_Collection_Exception( sprintf( $message, get_class( $this ), $this->_cType ) );
        }
        $this->_checkCallback();
        $before = $this->count();
        $after = array_unshift( $this->_collection, $item );
        return ( $after > $before && ( ( $after - $before ) == 1 ) );
    }

    /**
     * Adds an item at the end of collection.
     *
     * @param mixed $item An object of type Collection::_cType
     * @param Streamwide_Specification_Abstract $rule Rule to add items.
     * @return void
     * @throws Streamwide_Collection_Exception when the object type is not of collection type
     */
    public function addItem( $item, Streamwide_Specification_Abstract $rule = null )
    {
        if ( false === $this->_checkUserProvidedItem( $item ) ) {
            $message = '%s has been set to work with objects of type "%s"';
            throw new Streamwide_Collection_Exception( sprintf( $message, get_class( $this ), $this->_cType ) );
        }
        $this->_checkCallback();
        if ( null !== $rule && false === $rule->isSatisfiedBy( $item ) ) {
            return null;
        }
        $this->_collection[] = $item;
    }

    /**
     * Removes an item at the provided $offset.
     *
     * @param integer $offset offset of the item in collection
     * @return mixed|null The removed item or null if the provided offset does not exists
     */
    public function removeItem( $offset )
    {
        $this->_checkCallback();
        if ( false === $this->_offsetExists( $offset ) ) {
            return null;
        }
        list( $item ) = array_splice( $this->_collection, $offset, 1 );
        return $item;
    }

    /**
     * Checks if $offset exists in collection.
     *
     * @param integer $offset offset of the item in collection
     * @return boolean true if offset exists, false otherwise
     */
    protected function _offsetExists( $offset )
    {
        $this->_checkCallback();
        return array_key_exists( $offset, $this->_collection );
    }

    /**
     * Returns the first element of the collection.
     * This is different than Collection::shift()
     * which alters the internal array.
     *
     * @return mixed|null The first item of the collection or null if the internal array is empty
     */
    public function getFirst()
    {
        $offset = 0;
        return $this->getItemAt( $offset );
    }

    /**
     * Returns the last element of the collection.
     * This is different than Collection::pop() which
     * alters the internal array.
     *
     * @return mixed|null The last item of the collection or null if the internal array is empty
     */
    public function getLast()
    {
        $offset = $this->count() - 1;
        return $this->getItemAt( $offset );
    }

    /**
     * Returns the item from the collection that is stored at index $offset.
     *
     * @param int $offset offset of the item in the collection
     * @return mixed|null The item of the collection at index $offset or null if $offset does not exist
     */
    public function getItemAt( $offset )
    {
        $this->_checkCallback();
        if ( false === $this->_offsetExists( $offset ) ) {
            return null;
        }
        return $this->_collection[$offset];
    }

    /**
     * Sort the collection items with an comparator object.
     *
     * @param Streamwide_Collection_Comparator $cmp comparator object
     * @return void
     */
    function sortCollection( Streamwide_Comparator_Interface $cmp )
    {
        $this->_checkCallback();
        usort( $this->_collection, array( $cmp, 'compare' ) );
    }

    /**
     * Returns the size of the collection.
     *
     * @return integer The size of the collection.
     */
    public function count()
    {
        $this->_checkCallback();
        return count( $this->_collection );
    }

    /**
     * Get a collection iterator.
     *
     * @return Streamwide_Collection_Iterator Collection iterator object.
     */
    public function getIterator()
    {
        $this->_checkCallback();
        return new Streamwide_Collection_Iterator( $this );
    }

    /**
     * Set a callback used for lazy loading the internal array
     *
     * <code>
     * class SomeClass
     * {
     *     public function __construct( DbConnection $dbConn )
     *     {
     *         $this->_dbConnection = $dbConn;
     *     }
     *
     *     public function load( Collection $collection )
     *     {
     *         $stmt = $dbConn->query( $sql );
     *         while ( $row = $stmt->fetch() ) {
     *             $item = new SomeOtherClass( $row['id'], $row['name'] );
     *             $collection->addItem( $item );
     *         }
     *     }
     *
     * }
     * $loader = new SomeClass( $registry->getDbConnection() );
     * $collection = new Collection( 'SomeOtherClass' );
     * $collection->setLoadCallback( array( $loader, 'load' ) );
     * </code>
     *
     * @param string|array $loadCallback A php callback to be used for populating the collection.
     * 									 Must have as its first argument a type
     * hint to Collection (see the code example above)
     * @param array $args (optional) Arguments that will be passed to $loadCallback
     * @return void
     * @throws Streamwide_Collection_Exception when the provided callback is not callable
     */
    public function setLoadCallback( $loadCallback, array $args = array() )
    {
        if ( ! is_callable( $loadCallback ) ) {
            throw new Streamwide_Collection_Exception( 'The provided callback is not callable' );
        }
        
        $this->_loadCallback = $loadCallback;
        $this->_loadCallbackArgs = $args;
        $this->_isLoaded = false;
    }

    /**
     * Checks if the load callback can be called and calls it.
     *
     * @return void
     */
    protected function _checkCallback()
    {
        if ( $this->_loadCallback !== null && false === $this->_isLoaded ) {
            $this->_isLoaded = true;
            $args = $this->_loadCallbackArgs;
            array_unshift( $args, $this );
            call_user_func_array( $this->_loadCallback, $args );
        }
    }

}

/* EOF */