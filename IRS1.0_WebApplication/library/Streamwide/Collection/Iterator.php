<?php
/**
 * Collection iterator.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Collection
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Iterator.php 1962 2009-09-24 20:49:25Z rgasler $
 */

class Streamwide_Collection_Iterator implements Iterator
{
    /**
     * The collection object through which we iterate
     *
     * @var Collection
     */
    protected $_collection;

    /**
     * The current index
     *
     * @var integer
     */
    protected $_currentIndex = 0;

    /**
     * Constructor
     *
     * @param Streamwide_Collection $collection collection
     */
    public function __construct( Streamwide_Collection $collection )
    {
        $this->_collection = $collection;
    }

    /**
     * Returns the current element
     *
     * @return mixed|null
     */
    public function current()
    {
        return $this->_collection->getItemAt( $this->_currentIndex );
    }

    /**
     * Increment Streamwide_Collection_Iterator::_currentIndex;
     *
     * @return void;
     */
    public function next()
    {
        $this->_currentIndex++;
    }

    /**
     * Return the current key
     *
     * @return integer
     */
    public function key()
    {
        return $this->_currentIndex;
    }

    /**
     * Checks if the collection has more elements
     *
     * @return boolean
     */
    public function valid()
    {
        return $this->_currentIndex < $this->_collection->count();
    }

    /**
     * Reset Streamwide_Collection_Iterator::_currentIndex to 0
     *
     * @return void
     */
    public function rewind()
    {
        $this->_currentIndex = 0;
    }

    /**
     * Getter method for Streamwide_Collection_Iterator::_collection property
     *
     * @return Streamwide_Collection
     */
    public function getCollection()
    {
        return $this->_collection;
    }

}

/* EOF */