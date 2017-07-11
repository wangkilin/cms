<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_Dict.class.php
 *@Author   : WangKilin
 *@Email    : wangkilin@126.com
 *@Date     : 2010-7-22
 *@Homepage : http://www.kinful.com
 *@Version  : 0.1
 */
defined('Kinful') or die("forbidden");

require_once(dirname(__FILE__) . '/../dict.sql.php');
require_once(MY_ROOT_PATH . 'class/My_Module_Abstract.class.php');

class My_Dict extends My_Module_Abstract
{
    /****************** START::property zone *************************/

    /**
     *@array    page information got by last query
     */
    protected $_moduleInfo = array();

    /*
     * @var array The last returned media information
     */
    protected $_mediaInfo = NULL;

    /*
     * @var array The sql statements
     */
    protected $_SQL = array();
    /****************** END::property zone *************************/


    /****************** START::method zone *************************/
    /**
     *@Description : constructor
     *
     *@return: constractor
     */
    public function __construct($db)
    {
         global $My_Lang;
         global $My_Sql;

         require_once(dirname(__FILE__) . '/../dict.sql.php');
         $this->_SQL = & $My_Sql;
         My_Kernel::loadLang('module','dict');//load class language
         parent::General($db);
    }// END::constructor

    /**
     *get media by id
     *
     *@param int $dictId The media id
     *
     *@return: mixed(array/NULL)
     */
    public function getDictById($dictId)
    {
        if($this->_mediaInfo["dict_id"] == $dictId) {
            return $this->_mediaInfo;
        }

        $this->_db->query($this->_SQL['getDictById'], array($dictId));
        if($row = $this->_db->fetchArray()) {
            $this->_mediaInfo = $row;
            $this->rebuildDict($this->_mediaInfo);

            return $this->_mediaInfo;
        }

        $this->_errorStr = __CLASS__."->".__FUNCTION__."()".$My_Lang->class['module']['getDictInfoFail'];

        return NULL;
    }//END::function getDictById

    /**
     * Get random media items
     * @param int $limitItems The limitation of media items
     *
     * @return array
     */
    public function getRandomDict($limitItems, $categoryId=NULL)
    {
        $limitItems = intval($limitItems);
        $limitItems = $limitItems > 0 ? $limitItems : 1;

        if($categoryId) {
            $sql = $this->_SQL['getRandomDictByCategoryId'];
            $params = array($categoryId, $limitItems);
        } else {
            $sql = $this->_SQL['getRandomDict'];
            $params = array($limitItems);
        }

        return $this->getRebuildDict($sql, $params);
    }

    /**
     * get media list by key word
     *
     *@param string $keyword The key word to search
     *@param int $categoryId The media category id
     *
     *@return: array
     */
    public function getDictByKeyWord($keyword='', $categoryId=null)
    {
        if($categoryId && $keyword!='') {
            $dictList = & $this->getListBySql($this->_SQL['getDictByKeywordAndCategory'], array($categoryId, $keyword, $this->_limitOffset, $this->_limitRowCount));
        } else if($keyword!='') {
            $dictList = & $this->getListBySql($this->_SQL['getDictByKeyword'], array($keyword, $this->_limitOffset, $this->_limitRowCount));
        } else if($categoryId) {
            $dictList = & $this->getDictByCategoryId($categoryId);
        } else {
            $dictList = & $this->getAllDict();
        }

        return $dictList;
    }//END::function
    
    /****************** END::method zone *************************/

}// END::class

/* EOF */