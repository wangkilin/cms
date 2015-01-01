<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : My_Page_admin.class.php
 *@Author   : WangKilin
 *@Email    : wangkilin@126.com
 *@Date     : 2010-1-15
 *@Homepage : http://www.kinful.com
 *@Version  : 0.1
 */
defined('Kinful') or die("forbidden");

require_once(MY_ROOT_PATH . '/class/My_Page.class.php');

class My_Page_Admin extends My_Page
{
    /****************** START::property zone *************************/


    /****************** END::property zone *************************/


    /****************** START::method zone *************************/

    /**
     * get page catetories
     *
     * @return array Page category list
     */
    public function getPageCategory()
    {
        global $My_Sql;

        $this->_db->query($My_Sql['getPageList']);
        $pageList = array();
        while($row = $this->_db->fetchArray()) {
            $pageList[] = $row;
        }

        return $pageList;
    }
    /**
     * get page lists total number
     *
     * @return int Total number of page lists
     */
    public function getTotalPageList()
    {
        global $My_Sql;

        return $this->getTotal($My_Sql['countPageList']);
    }

    /**
     * get total page number by page list id
     *
     * @param int $pageListId The page list id
     *
     * @return int Total number
     */
    public function getTotalPageByListId($pageListId)
    {
        global $My_Sql;

        return $this->getTotal($My_Sql['countPageByListId'], array($pageListId));
    }

    /**
     * get total number from the input SQL and parameters
     *
     * @param string $sql The sql to be executed
     * @param array  $paramsList The parameters list
     *
     * @return int Total number
     */
    protected function getTotal ($sql, $paramsList=array())
    {
        $return = 0;

        if (count((array)$paramsList)) {
            $this->_db->query($sql, $paramsList);
        } else {
            $this->_db->query($sql);
        }

        if ($row = $this->_db->fetchArray()) {
            $return = (int)$row['count'];
        }

        return $return;
    }

    /**
     * change page publish status by page id
     *
     * @param int $pageId The page id
     * @param int $publishMode The publish mode. 0/1
     */
    public function updatePagePublish ($pageId, $publishMode)
    {
        global $My_Sql;

        $this->_db->query($My_Sql['updatePagePublish'], array($publishMode, $pageId));
    }

    /**
     * update page information by page id
     *
     * @param int $pageId The page id
     * @param array $pageInfo The page information
     */
    public function updatePage ($pageId, $pageInfo)
    {
        global $My_Sql;

        if (isset($pageInfo['page_name'], $pageInfo['has_main_block'],
            $pageInfo['theme_id'], $pageInfo['publish'], $pageInfo['support_type'], $pageInfo['page_category_id'])) {

            $this->_db->query($My_Sql['updatePage'], array($pageInfo['page_name'], $pageInfo['has_main_block'], $pageInfo['publish'], $pageInfo['theme_id'], $pageInfo['support_type'], $pageInfo['notes'], $pageId));
        }
    }

    /**
     * create page
     *
     * @param array $pageInfo The page information
     */
    public function createPage ($pageInfo)
    {
        global $My_Sql;

        if (isset($pageInfo['page_name'], $pageInfo['has_main_block'],
            $pageInfo['theme_id'], $pageInfo['publish'], $pageInfo['support_type'], $pageInfo['page_category_id'])) {

            $this->_db->query($My_Sql['createPage'], array((int)$pageInfo['page_category_id'], (string)$pageInfo['page_name'],
            (int)$pageInfo['has_main_block'], (int)$pageInfo['publish'],  (int)$pageInfo['theme_id'], (int)$page['support_type'], $pageInfo['notes']));
        }
    }

    /**
     * delete a page by page id
     *
     * @param int $pageId The page id to be deleted
     */
    public function deletePageById ($pageId)
    {
        global $My_Sql;

        $this->_db->query($My_Sql['deletePageById'], array($pageId));
    }

    /**
     * update page list information by page list id
     *
     * @param int $pageListId The page list id
     * @param array $pageListInfo The page list information
     */
    public function updatePageList ($pageListId, $pageListInfo)
    {
        global $My_Sql;

        if (isset($pageListInfo['page_category_name'])) {

            $this->_db->query($My_Sql['updatePageList'], array((string)$pageListInfo['page_category_name'], $pageListId));
        }
    }

    /**
     * create page list
     *
     * @param string $pageListInfo The page list information
     */
    public function createPageList ($pageListInfo)
    {
        global $My_Sql;

        if (isset($pageListInfo['page_category_name'])) {

            $this->_db->query($My_Sql['createPageList'], array((string)$pageListInfo['page_category_name']));
        }
    }

    /**
     * delete a page list by page list id, also delete the pages of such page list
     *
     * @param int $pageListId The page list id to be deleted
     */
    public function deleteListById ($pageListId)
    {
        global $My_Sql;

        $this->_db->query($My_Sql['deletePageListById'], array($pageListId));
        $this->_db->query($My_Sql['deletePagesByListId'], array($pageListId));
    }

    /**
     * set page blocks
     * To add new blocks, or to remove blocks
     *
     * @param int $pageId The page id
     * @param array $blockInfo The blocks information
     *
     * @return object this
     */
    public function setPageBlock($pageId, $blockInfo)
    {
        global $My_Sql;
        global $My_Kernel;
      //  var_dump(__LINE__, $pageId, $blockInfo);

        $My_Block = $My_Kernel->getClass('block', $this->_db);
        // add new blocks into page
        if(isset($blockInfo['block'], $blockInfo['position'])) {
            /*
             * First, check if the block with the position is already existing in this page.
             * if exists, and page is excluded to show by this block, remove data from excluding pages;
             * if the block only excludes this page, reset block show type in every page.
             */
            $blocks = $My_Block->getPageBlocks($pageId);
          //  var_dump(__LINE__, $blocks);
            foreach($blocks as $block) {
                $positionKey = array_search($block['position_id'], $blockInfo['position']);
                $blockKey = array_search($block['block_id'], $blockInfo['block']);
                $isExcludePage = MY_EXCLUDE_PAGE==$block['show_in_type'];
                if($blockKey===$positionKey && false!==$blockKey && $isExcludePage) {
                    $pages = $My_Block->getExcludePageByBlockId($block['block_id']);
                  //  var_dump(__LINE__, $pages);
                    $pagesCount = count($pages);
                    foreach($pages as $page) {
                        if($page['page_id']==$pageId) {
                            $My_Block->removeBlockPage($page['using_page_id']);
                            $pagesCount--;
                        }
                    }
                    /* the existing block only excludes this page,
                     * reset the block is shown in every page
                     */
                    if($pagesCount==0){
                        $My_Block->setUsingBlock($block['using_block_id'], array('showInType'=> MY_ALL_PAGE));
                        unset($blockInfo['block'][$blockKey]);
                        unset($blockInfo['position'][$blockKey]);
                    }
                }
            }
            /*
             * add new using block
             */
          //  var_dump(__LINE__, $blockInfo['block']);
            foreach($blockInfo['block'] as $key=>$blockId) {
                if(!isset($blockInfo['position'][$key])) {
                    continue;
                }
                $blockName = isset($blockInfo['name'][$key]) ? $blockInfo['name'][$key] : '';
                $visibleBlock = array('position_id' => $blockInfo['position'][$key],
                                      'block_id'    => $blockId,
                                      'page_id'     => $pageId,
                                      'block_name'  => $blockName,
                                      'show_in_type'=> MY_INCLUDE_PAGE
                                );
                              //  var_dump(__LINE__, $visibleBlock);
                $usingBlockId = $My_Block->addVisibleBlock($visibleBlock);;
              //  var_dump(__LINE__, $usingBlockId);
            }
        }

        if (isset($blockInfo['remove'])) {
            $blocks = $My_Block->getUsingBlockByIds($blockInfo['remove']);
          //  var_dump(__LINE__, $blocks);
            $_tmpBlocks = array();
            foreach($blocks as $block) {
                $_tmpBlocks[$block['using_block_id']] = $block;
            }
          //  var_dump(__LINE__, $blockInfo['remove']);
            foreach($blockInfo['remove'] as $key=>$usingBlockId) {
                if(isset($_tmpBlocks[$usingBlockId])) {
                    switch($_tmpBlocks[$usingBlockId]['show_in_type']) {
                        case MY_ALL_PAGE:
                            $My_Block->setUsingBlock($block['using_block_id'], array('showInType', MY_EXCLUDE_PAGE));
                        case MY_EXCLUDE_PAGE:// add this page into exclude page list
                            $My_Block->addBlockPage($usingBlockId, $pageId);
                            break;

                        case MY_INCLUDE_PAGE: // check if page id in the include page list, if yes, remove it
                            if(!empty($blockInfo['removePage'][$key])) {
                                $My_Block->removeBlockPage($blockInfo['removePage'][$key]);
                            }
                            if(count($My_Block->getIncludePageByUsingBlockId($usingBlockId))==0){
                                $My_Block->removeUsingBlock($usingBlockId);
                            }
                            break;

                        default:
                            break;
                    }
                }
            }
        }
    }

    /****************** END::method zone *************************/

}// END::class

/* EOF */
