<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_media.class.php
 *@Author   : WangKilin
 *@Email    : wangkilin@126.com
 *@Date     : 2010-7-22
 *@Homepage : http://www.kinful.com
 *@Version  : 0.1
 */
defined('Kinful') or die("forbidden");

require_once(dirname(__FILE__) . '/../news.sql.php');
require_once(MY_ROOT_PATH . 'class/My_Abstract.class.php');

class My_News extends My_Abstract
{
    const NEWS_TITLE_BOLD = 0x01;
    const NEWS_TITLE_ITALIC = 0x02;
    const NEWS_TITLE_IMAGE = 0x04;
    const NEWS_TITLE_VIDEO = 0x08;
    const NEWS_TITLE_AUDIO = 0x10;
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

         require_once(dirname(__FILE__) . '/../news.sql.php');
         $this->_SQL = & $My_Sql;
         My_Kernel::loadLang('module','news');//load class language
         parent::General($db);
    }// END::constructor

    /**
     *@Decription : load media information by category id
     *
     *@Param int $categoryId
     *
     *@return: array
     */
    public function getNewsByCategoryId($categoryId)
    {
        return $this->getRebuildNews($this->_SQL['getNewsByCategoryId'], array($categoryId, $this->_limitOffset, $this->_limitRowCount));
    }//END::function

    /**
     *@Description : load media category information by id
     *
     *@Param int $categoryId
     *
     *@return: array
     */
    public function getCategoryById($categoryId)
    {
        $this->_db->query($this->_SQL['getCategoryById'], array($categoryId));
        $category = $this->_db->fetchArray();

        return $category;
    }//END::function

    /**
     *get media by id
     *
     *@param int $newsId The media id
     *
     *@return: mixed(array/NULL)
     */
    public function getNewsById($newsId)
    {
        if($this->_mediaInfo["news_id"] == $newsId) {
            return $this->_mediaInfo;
        }

        $this->_db->query($this->_SQL['getNewsById'], array($newsId));
        if($row = $this->_db->fetchArray()) {
            $this->_mediaInfo = $row;
            $this->rebuildNews($this->_mediaInfo);

            return $this->_mediaInfo;
        }

        $this->_errorStr = __CLASS__."->".__FUNCTION__."()".$My_Lang->class['module']['getNewsInfoFail'];

        return NULL;
    }//END::function getNewsById

    /**
     * Get random media items
     * @param int $limitItems The limitation of media items
     *
     * @return array
     */
    public function getRandomNews($limitItems, $categoryId=NULL)
    {
        $limitItems = intval($limitItems);
        $limitItems = $limitItems > 0 ? $limitItems : 1;

        if($categoryId) {
            $sql = $this->_SQL['getRandomNewsByCategoryId'];
            $params = array($categoryId, $limitItems);
        } else {
            $sql = $this->_SQL['getRandomNews'];
            $params = array($limitItems);
        }

        return $this->getRebuildNews($sql, $params);
    }

    public function getLatestNews($limitItems = null)
    {
        $limitItems = $limitItems ? intval($limitItems) : $this->_limitRowCount;

        return $this->getRebuildNews($this->_SQL['getLatestNews'], array($limitItems));
    }

    protected function getRebuildNews($sql, $params)
    {

        $newsList = array();
        $this->_db->query($sql, $params);
        while($row=$this->_db->fetchArray()) {
            $this->rebuildNews($row);
            $newsList[] = $row;
        }

        return $newsList;
    }

    protected function rebuildNews(& $newsInfo)
    {
            $newsInfo['title_style'] = intval($newsInfo['title_style']);
            $newsInfo['news_bold'] = $newsInfo['title_style'] & self::NEWS_TITLE_BOLD;
            $newsInfo['news_italic'] = $newsInfo['title_style'] & self::NEWS_TITLE_ITALIC;
            $newsInfo['news_title_media'] = $newsInfo['title_style'] & self::NEWS_TITLE_IMAGE;
            if(0===$newsInfo['news_title_media']) {
                $newsInfo['news_title_media'] = $newsInfo['title_style'] & self::NEWS_TITLE_AUDIO;
            }
            if(0===$newsInfo['news_title_media']) {
                $newsInfo['news_title_media'] = $newsInfo['title_style'] & self::NEWS_TITLE_VIDEO;
            }
    }


    /**
     * get media list by key word
     *
     *@param string $keyword The key word to search
     *@param int $categoryId The media category id
     *
     *@return: array
     */
    public function getNewsListByKeyWord($keyword='', $categoryId=null)
    {
        if($categoryId && $keyword!='') {
            $newsList = & $this->getListBySql($this->_SQL['getNewsByKeywordAndCategory'], array($categoryId, $keyword, $this->_limitOffset, $this->_limitRowCount));
        } else if($keyword!='') {
            $newsList = & $this->getListBySql($this->_SQL['getNewsByKeyword'], array($keyword, $this->_limitOffset, $this->_limitRowCount));
        } else if($categoryId) {
            $newsList = & $this->getNewsByCategoryId($categoryId);
        } else {
            $newsList = & $this->getAllNews();
        }

        return $newsList;
    }//END::function

    /**
     * get all news
     */
    public function & getAllNews()
    {
        return $this->getListBySql($this->_SQL['getAllNews']);
    }

    /**
     * get page catetories
     *
     * @return array Page category list
     */
    public function getNewsCategories()
    {
        return $this->getListBySql($this->_SQL['getNewsCategories'], array($this->_limitOffset, $this->_limitRowCount));
    }
    /**
     * get page lists total number
     *
     * @return int Total number of page lists
     */
    public function countCategory()
    {
        return $this->count($this->_SQL['countNewsCategory']);
    }

    /**
     * get total page number by page list id
     *
     * @param int $newsCategoryId The page list id
     *
     * @return int Total number
     */
    public function countNewsByCategoryId($newsCategoryId)
    {
        return $this->count($this->_SQL['countNewsByCategoryId'], array($newsCategoryId));
    }


    /****************** END::method zone *************************/

}// END::class

/* EOF */