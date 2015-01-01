<?php
/**
 * Apc backend for Zend_Cache with dumb caching.
 *
 * Useful for testing and disabling cache in a transparent way.
 *
 * $Rev: 2608 $
 * $LastChangedDate: 2010-05-18 10:01:35 +0800 (Tue, 18 May 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Cache
 * @subpackage Streamwide_Cache_Backend
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: NoCache.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * @see Zend_Cache_Backend_Interface
 */
require_once 'Zend/Cache/Backend/ExtendedInterface.php';

/**
 * @see Zend_Cache_Backend
 */
require_once 'Zend/Cache/Backend.php';

/**
 * Class that implements a dumb cache - no caching is done.
 * This is useful for testing and for disabling cache.
 *
 * @package Streamwide_Cache
 * @subpackage Streamwide_Cache_Backend
 * @deprecated Deprecated against Zend_Cache_Backend_BlackHole
 */
class Streamwide_Cache_Backend_NoCache extends Zend_Cache_Backend implements Zend_Cache_Backend_ExtendedInterface
{
    /**
     * Constructor
     *
     * @param array $options associative array of options
     * @throws Zend_Cache_Exception
     * @return void
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);
    }

    /**
     * Test if a cache is available for the given id and (if yes) return it (false else)
     *
     * @param string  $id                     cache id
     * @param boolean $doNotTestCacheValidity if set to true, the cache validity won't be tested
     * @return boolean false
     */
    public function load($id, $doNotTestCacheValidity = false)
    {
        return false;
    }

    /**
     * Test if a cache is available or not (for the given id)
     *
     * @param string $id cache id
     * @return boolean false (the cache is not available)
     */
    public function test($id)
    {
        return false;
    }

    /**
     * Save some string datas into a cache record
     *
     * Note: $data is always "string" (serialization is done by the
     * core not by the backend)
     *
     * @param string  $data             datas to cache
     * @param string  $id               cache id
     * @param array   $tags             (optional) array of tags, the cache record will be tagged by each string entry
     * @param integer $specificLifetime (optional) if not false, set a specific lifetime
     *                                             for this cache record (null => infinite lifetime)
     * @return boolean true if no problem
     */
    public function save($data, $id, $tags = array(), $specificLifetime = false)
    {
        return true;
    }

    /**
     * Remove a cache record
     *
     * @param string $id cache id
     * @return boolean true if no problem
     */
    public function remove($id)
    {
        return true;
    }

    /**
     * Clean some cache records
     *
     * Available modes are :
     * 'all' (default)  => remove all cache entries ($tags is not used)
     * 'old'            => unsupported
     * 'matchingTag'    => unsupported
     * 'notMatchingTag' => unsupported
     * 'matchingAnyTag' => unsupported
     *
     * @param string $mode clean mode
     * @param array  $tags array of tags
     * @throws Zend_Cache_Exception
     * @return boolean true if no problem
     */
    public function clean($mode = Zend_Cache::CLEANING_MODE_ALL, $tags = array())
    {
        return true;
    }

    /**
     * Return the filling percentage of the backend storage
     *
     * @throws Zend_Cache_Exception
     * @return int integer 0
     */
    public function getFillingPercentage()
    {
        return ((int) 0);
    }

    /**
     * Return an array of stored tags
     *
     * @return array array of stored tags (string)
     */
    public function getTags()
    {
        return array();
    }

    /**
     * Return an array of stored cache ids which match given tags
     *
     * In case of multiple tags, a logical AND is made between tags
     *
     * @param array $tags array of tags
     * @return array array of matching cache ids (string) empty
     */
    public function getIdsMatchingTags($tags = array())
    {
        return array();
    }

    /**
     * Return an array of stored cache ids which don't match given tags
     *
     * In case of multiple tags, a logical OR is made between tags
     *
     * @param array $tags array of tags
     * @return array array of not matching cache ids (string) empty
     */
    public function getIdsNotMatchingTags($tags = array())
    {
        return array();
    }

    /**
     * Return an array of stored cache ids which match any given tags
     *
     * In case of multiple tags, a logical AND is made between tags
     *
     * @param array $tags array of tags
     * @return array array of any matching cache ids (string) empty
     */
    public function getIdsMatchingAnyTags($tags = array())
    {
        return array();
    }

    /**
     * Return an array of stored cache ids
     *
     * @return array array of stored cache ids (string) empty
     */
    public function getIds()
    {
        $res = array();
        return $res;
    }

    /**
     * Return an array of metadatas for the given cache id
     *
     * The array must include these keys :
     * - expire : the expire timestamp
     * - tags : a string array of tags
     * - mtime : timestamp of last modification time
     *
     * @param string $id cache id
     * @return boolean false (the cache is not found)
     */
    public function getMetadatas($id)
    {
        return false;
    }

    /**
     * Give (if possible) an extra lifetime to the given cache id
     *
     * @param string  $id            cache id
     * @param integer $extraLifetime extra lifetime
     * @return boolean true if ok
     */
    public function touch($id, $extraLifetime)
    {
        return true;
    }

    /**
     * Return an associative array of capabilities (booleans) of the backend
     *
     * The array must include these keys :
     * - automatic_cleaning (is automating cleaning necessary)
     * - tags (are tags supported)
     * - expired_read (is it possible to read expired cache records
     *                 (for doNotTestCacheValidity option for example))
     * - priority does the backend deal with priority when saving
     * - infinite_lifetime (is infinite lifetime can work with this backend)
     * - get_list (is it possible to get the list of cache ids and the complete list of tags)
     *
     * @return array associative array of capabilities
     */
    public function getCapabilities()
    {
        return array(
            'automatic_cleaning' => false,
            'tags' => false,
            'expired_read' => false,
            'priority' => false,
            'infinite_lifetime' => false,
            'get_list' => true
        );
    }
}

/* EOF */