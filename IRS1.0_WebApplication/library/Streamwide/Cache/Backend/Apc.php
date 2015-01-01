<?php
/**
 * Apc backend for Zend_Cache with tags support.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Cache
 * @subpackage Streamwide_Cache_Backend
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Adrian SIMINICEANU <asiminiceanu@streamwide.ro>
 * @version    $Id: Apc.php 1962 2009-09-24 20:49:25Z rgasler $
 */

/**
 * @see Zend_Cache_Backend_Apc
 */
require_once 'Zend/Cache/Backend/Apc.php';

/**
 * Class that extends the functionality of Zend_Cache_Backend_Apc to be able to support tags.
 *
 * <code>
 * $frontendOptions = array(
 *     'lifetime' => 3600, // cache lifetime of 1 hour
 *     'automatic_serialization' => true
 * );
 * $backendClass = 'Streamwide_Cache_Backend_Apc';
 * $cache = Zend_Cache::factory('Core', $backendClass, $frontendOptions, array(), false, true);
 * $cache->save('value', 'uniqueId', array('tagA', 'tagB'));
 * $cache->load('uniqueId');
 * $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('tagA','tagB'));
 * </code>
 */
class Streamwide_Cache_Backend_Apc extends Zend_Cache_Backend_Apc
{
    /**
     * internal APC prefix
     */
    const TAGS_PREFIX = "internal_APCtag_";
    
    /**
     * Save some string datas into a cache record
     *
     * Note : $data is always "string" (serialization is done by the core not by the backend)
     *
     * @param string  $data             datas to cache
     * @param string  $id               cache id
     * @param array   $tags             (optional) array of strings, the cache record will be tagged
     *                                  by each string entry
     * @param integer $specificLifetime (optional) if != false, set a specific lifetime
     *                                  for this cache record (null => infinite lifetime)
     * @return boolean true if no problem
     */
    public function save($data, $id, $tags = array(), $specificLifetime = false)
    {
        $lifetime = $this->getLifetime($specificLifetime);
        $resultOfStore = apc_store($id, array($data, time()), $lifetime);
        $resultOfTags  = (count($tags) == 0);

        foreach ($tags as $tag) {
            $tagid = self::TAGS_PREFIX.$tag;
            $oldTags = array();
            $tmp = apc_fetch($tagid);
            if (is_array($tmp)) {
                $oldTags = $tmp[0];
            }
            $oldTags[$id] = $id;
            apc_delete($tagid);
            $resultOfTags = apc_store($tagid, array($oldTags, time()), $lifetime);
        }

        return $resultOfStore && $resultOfTags;
    }

    /**
     * Clean some cache records
     *
     * Available modes are :
     * 'all' (default)  => remove all cache entries ($tags is not used)
     * 'old'            => remove too old cache entries ($tags is not used)
     * 'matchingTag'    => remove cache entries matching all given tags
     *                     ($tags can be an array of strings or a single string)
     * 'notMatchingTag' => remove cache entries not matching one of the given tags
     *                     ($tags can be an array of strings or a single string)
     *
     * @param string $mode clean mode
     * @param array  $tags array of tags
     * @return boolean true if no problem
     */
    public function clean($mode = Zend_Cache::CLEANING_MODE_ALL, $tags = array())
    {
        if ($mode==Zend_Cache::CLEANING_MODE_ALL) {
            return apc_clear_cache('user');
        }
        if ($mode==Zend_Cache::CLEANING_MODE_MATCHING_TAG) {
            $idList = null;
            foreach ($tags as $tag) {
                $nextIdList = array();
                $tmp = apc_fetch(self::TAGS_PREFIX.$tag);
                if (is_array($tmp)) {
                    $nextIdList = $tmp[0];
                }
                if ($idList) {
                    $idList = array_intersect_assoc($idList, $nextIdList);
                } else {
                    $idList = $nextIdList;
                }
                if (count($idList) == 0) {
                    // if ID list is already empty - we may skip checking other IDs
                    $idList = null;
                    break;
                }
            }

            if ($idList) {
                foreach ($idList as $id) {
                    apc_delete($id);
                }
            }
            foreach ($tags as $tag) {
                apc_delete(self::TAGS_PREFIX.$tag);
            }
            return true;
        }
        if ($mode==Zend_Cache::CLEANING_MODE_OLD) {
            $this->_log("Streamwide_Cache_Backend_Apc::clean() : CLEANING_MODE_OLD is unsupported by the Apc backend");
        }
        if ($mode==Zend_Cache::CLEANING_MODE_NOT_MATCHING_TAG) {
            $this->_log("Streamwide_Cache_Backend_Apc::clean() : tags are unsupported by the Apc backend");
        }
    }
}

/* EOF */