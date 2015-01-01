<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : My_News_admin.class.php
 *@Author   : WangKilin
 *@Email    : wangkilin@126.com
 *@Date     : 2010-8-3
 *@Homepage : http://www.kinful.com
 *@Version  : 0.1
 */
defined('Kinful') or die("forbidden");
require_once(dirname(__FILE__) . '/My_News.class.php');
class My_News_Admin extends My_News
{
    /****************** START::property zone *************************/
    const DO_CREATE = 1; // flag for doing create item
    const DO_UPDATE = 2; // flag for doing update item


    /****************** END::property zone *************************/


    /****************** START::method zone *************************/

    /**
     * change category/news publish status by id
     *
     * @param string $type The operstaion target type, news or category
     * @param int $itemId The news category id
     * @param int $publishMode The publish mode. 0/1
     */
    public function updatePublish ($type, $itemId, $publishMode)
    {
        switch(strtolower($type)) {
            case 'news':
                $sql = $this->_SQL['updateNewsPublish'];
                break;

            case 'category':
                $sql = $this->_SQL['updateCategoryPublish'];
                break;

            default:
                break;
        }
        if(isset($sql)) {
            $this->_db->query($sql, array($publishMode, $itemId));
        }

        return;
    }

    /**
     * update page information by page id
     *
     * @param int $pageId The page id
     * @param array $newsInfo The page information
     */
    public function updateNews ($newsId, $newsInfo)
    {
        if(is_array($newsInfo)){
            $realNewsInfo =  $this->verifyNews($newsInfo, self::DO_UPDATE);
            if($realNewsInfo) {
                $params = array(
                    $realNewsInfo['title'],
                    $realNewsInfo['publish'],
                    $realNewsInfo['categoryId'],
                    $realNewsInfo['onTop'],
                    $realNewsInfo['titleStyle'],
                    $realNewsInfo['weight'],
                    $realNewsInfo['color'],
                    $realNewsInfo['startTime'],
                    $realNewsInfo['endTime'],
                    $realNewsInfo['refUrl'],
                    $realNewsInfo['metaKey'],
                    $realNewsInfo['metaDesc'],
                    $realNewsInfo['introText'],
                    $realNewsInfo['fullText'],
                    $realNewsInfo['modifiedTime'],
                    $realNewsInfo['modifiedById'],
                    $realNewsInfo['modifiedByName'],
                    intval($newsId)
                );
                $this->_db->query($this->_SQL['updateNews'], $params);

                return $this->_db->affectedRows();
            }
        }

        return null;
    }

    /**
     * create page
     *
     * @param array $newsInfo The page information
     */
    public function createNews ($newsInfo)
    {
        if(is_array($newsInfo)){
            $realNewsInfo =  $this->verifyNews($newsInfo, self::DO_CREATE);
            if($realNewsInfo) {
                $params = array(
                    $realNewsInfo['title'],
                    $realNewsInfo['publish'],
                    $realNewsInfo['categoryId'],
                    $realNewsInfo['onTop'],
                    $realNewsInfo['titleStyle'],
                    $realNewsInfo['weight'],
                    $realNewsInfo['color'],
                    $realNewsInfo['startTime'],
                    $realNewsInfo['endTime'],
                    $realNewsInfo['refUrl'],
                    $realNewsInfo['metaKey'],
                    $realNewsInfo['metaDesc'],
                    $realNewsInfo['introText'],
                    $realNewsInfo['fullText'],
                    $realNewsInfo['createTime'],
                    $realNewsInfo['createdById'],
                    $realNewsInfo['createByName'],
                );
                $this->_db->query($this->_SQL['createNews'], $params);
                $newsId = $this->_db->insertId();
                if($newsId) {
                    $this->_db->query($this->_SQL['increaseNewsItem'], array($realNewsInfo['categoryId']));
                }

                return $newsId;
            }
        }

        return null;
    }

    /**
     * delete a page by news id
     *
     * @param int $pageId The page id to be deleted
     */
    public function deleteNewsById ($newsId)
    {
        $newsInfo = $this->getNewsById($newsId);
        if(is_array($newsInfo)) {
            $this->_db->query($this->_SQL['deleteNewsById'], array($newsId));
            $deleteRow = $this->_db->affectedRows();
            if($deleteRow) {
                $this->_db->query($this->_SQL['decreaseNewsItem'], array($newsInfo['category_id']));
            }

            return $deleteRow;
        }

        return 0;
    }

    /**
     * update page list information by page list id
     *
     * @param int $newsCategoryId The page list id
     * @param array $newsCategoryInfo The page list information
     */
    public function updateCategory ($newsCategoryId, $newsCategoryInfo)
    {
        $affectedRows = 0;

        if (isset($newsCategoryInfo['title'], $newsCategoryInfo['publish'])) {

            $this->_db->query($this->_SQL['updateCategory'], array((string)$newsCategoryInfo['title'], intval($newsCategoryInfo['publish']), intval($newsCategoryId)));
            $ret = $this->_db->affectedRows();
        }

        return $affectedRows;
    }

    /**
     * create page list
     *
     * @param string $newsCategoryInfo The page list information
     */
    public function createCategory ($newsCategoryInfo)
    {
        $ret = 0;
        if (isset($newsCategoryInfo['title'], $newsCategoryInfo['publish'])) {

            $this->_db->query($this->_SQL['createCategory'], array($newsCategoryInfo['title'], intval($newsCategoryInfo['publish'])));
            $ret = $this->_db->affectedRows();
        }

        return $ret;
    }

    /**
     * delete a page list by page list id, also delete the pages of such page list
     *
     * @param int $newsCategoryId The page list id to be deleted
     */
    public function deleteCategoryById ($newsCategoryId)
    {
        $this->_db->query($this->_SQL['deleteNewsCategoryById'], array($newsCategoryId));
        $this->_db->query($this->_SQL['deleteCategoryById'], array($newsCategoryId));
    }

    /**
     * verify news information
     */
    protected function verifyNews($newsInfo, $operation)
    {
        if(is_array($newsInfo) && isset($newsInfo['title'], $newsInfo['publish'], $newsInfo['categoryId'])) {
            $realNewsInfo = array();
            $realNewsInfo['title'] = htmlspecialchars($newsInfo['title']);
            $realNewsInfo['publish'] = intval($newsInfo['publish']);
            $realNewsInfo['categoryId'] = intval($newsInfo['categoryId']);

            $realNewsInfo['onTop'] = isset($newsInfo['onTop']) ? intval($newsInfo['onTop']) : 0;
            $realNewsInfo['titleStyle'] = 0;
            $realNewsInfo['weight'] = isset($newsInfo['weight']) ? intval($newsInfo['weight']) : 0;
            $realNewsInfo['titleStyle'] |= (isset($newsInfo['bold']) && $newsInfo['bold']==1) ? parent::NEWS_TITLE_BOLD : 0;
            $realNewsInfo['titleStyle'] |= (isset($newsInfo['italic']) && $newsInfo['italic']==1) ? parent::NEWS_TITLE_ITALIC : 0;
            if(!empty($newsInfo['titleMedia'])) {
                switch($newsInfo['titleMedia']) {
                    case parent::NEWS_TITLE_IMAGE:
                        $realNewsInfo['titleStyle'] |= parent::NEWS_TITLE_IMAGE;
                        break;

                    case parent::NEWS_TITLE_VIDEO:
                        $realNewsInfo['titleStyle'] |= parent::NEWS_TITLE_VIDEO;
                        break;

                    case parent::NEWS_TITLE_AUDIO:
                        $realNewsInfo['titleStyle'] |= parent::NEWS_TITLE_AUDIO;
                        break;

                    default:
                        break;
                }
            }
            $realNewsInfo['color'] = isset($newsInfo['color']) ? htmlspecialchars($newsInfo['color']) : '';
            $realNewsInfo['startTime'] = empty($newsInfo['startTime']) ? date('Y-m-d H:i:s') : $newsInfo['startTime'];
            $realNewsInfo['endTime'] = empty($newsInfo['endTime']) ? '2030-12-31 23:59:59' : $newsInfo['endTime'];
            $realNewsInfo['refUrl'] = isset($newsInfo['refUrl']) ? htmlspecialchars($newsInfo['refUrl']) : '';
            $realNewsInfo['metaKey'] = isset($newsInfo['metaKey']) ? htmlspecialchars($newsInfo['metaKey']) : '';
            $realNewsInfo['metaDesc'] = isset($newsInfo['metaDesc']) ? htmlspecialchars($newsInfo['metaDesc']) : '';
            $realNewsInfo['introText'] = isset($newsInfo['introText']) ? $newsInfo['introText'] : 0;
            $realNewsInfo['fullText'] = isset($newsInfo['fullText']) ? $newsInfo['fullText'] : '';
            if(self::DO_CREATE==$operation) {
                $realNewsInfo['createTime'] = isset($newsInfo['createTime']) ? $newsInfo['createTime'] : date('Y-m-d H:i:s');
                $realNewsInfo['createdById'] = isset($newsInfo['createdById']) ? intval($newsInfo['createdById']) : $_SESSION['my_user']['user_id'];
                $realNewsInfo['createByName'] = isset($newsInfo['createByName']) ? htmlspecialchars($newsInfo['createByName']) : $_SESSION['my_user']['uid'];
            } else if(self::DO_UPDATE==$operation) {
                $realNewsInfo['modifiedTime'] = isset($newsInfo['modifiedTime']) ? $newsInfo['modifiedTime'] : date('Y-m-d H:i:s');
                $realNewsInfo['modifiedById'] = isset($newsInfo['modifiedById']) ? intval($newsInfo['modifiedById']) : $_SESSION['my_user']['user_id'];
                $realNewsInfo['modifiedByName'] = isset($newsInfo['modifiedByName']) ? htmlspecialchars($newsInfo['modifiedByName']) : $_SESSION['my_user']['uid'];
            }

            return $realNewsInfo;
        } else {
            return NULL;
        }
    }

    /****************** END::method zone *************************/

}// END::class

/* EOF */
