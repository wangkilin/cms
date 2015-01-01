<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_page.class.php
 *@Author   : WangKilin
 *@Email    : wangkilin@126.com
 *@Date     : 2010-1-12
 *@Homepage : http://www.kinful.com
 *@Version  : 0.1
 */
defined('Kinful') or die("forbidden");
define('MY_page_CLASS_INC',1);

require_once(dirname(__FILE__) . '/My_Abstract.class.php');

class My_Page extends My_Abstract
{
    /****************** START::property zone *************************/

    /**
     *@array    page information got by last query
     */
    protected $_pageInfo = array();

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
         My_Kernel::loadLang('class','page');//load class language
         if(is_object($db)) {
             $this->_db = $db;
         }
    }// END::constructor

    /**
     *@Decription : load pages information by page category id
     *
     *@Param int $pageListId
     *
     *@return: void
     */
    public function getPagesByPageListId($pageListId)
    {
        global $My_Sql;

        $pages = array();
        $this->_db->query($My_Sql['getPagesByPageListId'], array($pageListId));

        while ($row = $this->_db->fetchArray()) {
            $pages [] = $row;
        }

        return $pages;
    }//END::function

    /**
     *@Description : load page category information by id
     *
     *@Param int $pageListId
     *
     *@return: array
     */
    public function getPageListById($pageListId)
    {
        global $My_Sql;

        $this->_db->query($My_Sql['getPageListById'], array($pageListId));

        $page = $this->_db->fetchArray();

        return $page;
    }//END::function

    /**
     *@Decription : delete page by id
     *
     *@Param : int    page id
     *
     *@return: boolean
     */
    public function deletePageById($pageId)
    {
        $delete_comp = "delete from #._page where page_id = $pageId";
        $this->_db->query($delete_comp);
        if($this->_db->affectedRows())
            return true;
        else
            return false;
    }//END::function deletepageById

    /**
     *@Description : get class error
     *
     *@return: string
     */
    public function getError()
    {
        return $this->_errorStr;
    }//END::function getError

    /**
     *@Description : set class debug mode
     *
     *@param : boolean
     *
     *@return: void
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
    }//END::function setDebug

    /**
     *@Description : get page information by page id
     *
     *@param : int    page id
     *
     *@return: mixed(array/false)
     */
    public function getPageById($pageId)
    {
        global $My_Sql;

        if($pageId && $this->_pageInfo["page_id"] == $pageId) {
            return $this->_pageInfo;
        }

        if($pageId===0) {
            $pageInfo = array(
                'page_id' => 0,
            );
            return $pageInfo;
        }

        $this->_db->query($My_Sql['getPageById'], array($pageId));
        if($row = $this->_db->fetchArray()) {
            $this->_pageInfo = $row;

            return $row;
        }

        $this->_errorStr = __CLASS__."->".__FUNCTION__."()".$My_Lang->class['module']['getPageInfoFail'];

        return false;
    }//END::function getPageById

    /**
     *@Description : get page information by page name
     *
     *@param : int    page name
     *
     *@return: mixed(array/false)
     */
    public function getPageByName($pageName)
    {
        global $My_Sql;

        if(isset($this->_pageInfo["page_name"]) &&
            $this->_pageInfo["page_name"] == $pageName) {

            return $this->_pageInfo;
        }

        $this->_db->query($My_Sql['getPageByName'], array($pageName));
        if($row = $this->_db->fetchArray()) {
            $this->_pageInfo = $row;

            return $row;
        } else {
            $this->_errorStr = __CLASS__."->".__FUNCTION__."()".$My_Lang->class['module']['getPageInfoFail'];

            return false;
        }
    }//END::function getpageByName

    public function pageIdExists ($pageId)
    {
        return $this->isValidPageId ($pageId);
    }

    public function pageAccessable ($pageName, $rank)
    {
        $pageInfo = $this->getPageByName ($pageName);

        return $pageInfo['show_level']<=$rank;
    }

    /****************** END::method zone *************************/

}// END::class
?>
