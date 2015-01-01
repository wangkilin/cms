<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : My_Dict_admin.class.php
 *@Author   : WangKilin
 *@Email    : wangkilin@126.com
 *@Date     : 2010-8-3
 *@Homepage : http://www.kinful.com
 *@Version  : 0.1
 */
defined('Kinful') or die("forbidden");
require_once(dirname(__FILE__) . '/My_Dict.class.php');
class My_Dict_Admin extends My_Dict
{
    /****************** START::property zone *************************/
    const DO_CREATE = 1; // flag for doing create item
    const DO_UPDATE = 2; // flag for doing update item


    /****************** END::property zone *************************/


    /****************** START::method zone *************************/

    /**
     * change category/dict publish status by id
     *
     * @param string $type The operstaion target type, media or category
     * @param int $itemId The media category id
     * @param int $publishMode The publish mode. 0/1
     */
    public function updatePublish ($type, $itemId, $publishMode)
    {
        switch(strtolower($type)) {
            case 'dict':
                $sql = $this->_SQL['updateDictPublish'];
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
     * @param array $dictInfo The page information
     */
    public function updateDict ($dictId, $dictInfo)
    {
        if(is_array($dictInfo)){
            $realDictInfo =  $this->verifyDict($dictInfo, self::DO_UPDATE);
            if($realDictInfo) {
                $params = array(
                    $realDictInfo['title'],
                    $realDictInfo['publish'],
                    $realDictInfo['categoryId'],
                    $realDictInfo['onTop'],
                    $realDictInfo['titleStyle'],
                    $realDictInfo['weight'],
                    $realDictInfo['color'],
                    $realDictInfo['startTime'],
                    $realDictInfo['endTime'],
                    $realDictInfo['refUrl'],
                    $realDictInfo['metaKey'],
                    $realDictInfo['metaDesc'],
                    $realDictInfo['introText'],
                    $realDictInfo['fullText'],
                    $realDictInfo['modifiedTime'],
                    $realDictInfo['modifiedById'],
                    $realDictInfo['modifiedByName'],
                    intval($dictId)
                );
                $this->_db->query($this->_SQL['updateDict'], $params);

                return $this->_db->affectedRows();
            }
        }

        return null;
    }

    /**
     * create page
     *
     * @param array $dictInfo The page information
     */
    public function createDict ($dictInfo)
    {
        if(is_array($dictInfo)){
            $realDictInfo =  $this->verifyDict($dictInfo, self::DO_CREATE);
            if($realDictInfo) {
                $params = array(
                    $realDictInfo['title'],
                    $realDictInfo['publish'],
                    $realDictInfo['categoryId'],
                    $realDictInfo['onTop'],
                    $realDictInfo['titleStyle'],
                    $realDictInfo['weight'],
                    $realDictInfo['color'],
                    $realDictInfo['startTime'],
                    $realDictInfo['endTime'],
                    $realDictInfo['refUrl'],
                    $realDictInfo['metaKey'],
                    $realDictInfo['metaDesc'],
                    $realDictInfo['introText'],
                    $realDictInfo['fullText'],
                    $realDictInfo['createTime'],
                    $realDictInfo['createdById'],
                    $realDictInfo['createByName'],
                );
                $this->_db->query($this->_SQL['createDict'], $params);
                $dictId = $this->_db->insertId();
                if($dictId) {
                    $this->_db->query($this->_SQL['increaseDictItem'], array($realDictInfo['categoryId']));
                }

                return $dictId;
            }
        }

        return null;
    }

    /**
     * delete a page by media id
     *
     * @param int $pageId The page id to be deleted
     */
    public function deleteDictById ($dictId)
    {
        $dictInfo = $this->getDictById($dictId);
        if(is_array($dictInfo)) {
            $this->_db->query($this->_SQL['deleteDictById'], array($dictId));
            $deleteRow = $this->_db->affectedRows();
            if($deleteRow) {
                $this->_db->query($this->_SQL['decreaseDictItem'], array($dictInfo['category_id']));
            }

            return $deleteRow;
        }

        return 0;
    }

    /**
     * update page list information by page list id
     *
     * @param int $dictCategoryId The page list id
     * @param array $dictCategoryInfo The page list information
     */
    public function updateCategory ($dictCategoryId, $dictCategoryInfo)
    {
        $affectedRows = 0;

        if (isset($dictCategoryInfo['title'], $dictCategoryInfo['publish'])) {

            $this->_db->query($this->_SQL['updateCategory'], array((string)$dictCategoryInfo['title'], intval($dictCategoryInfo['publish']), intval($dictCategoryId)));
            $ret = $this->_db->affectedRows();
        }

        return $affectedRows;
    }

    /**
     * create page list
     *
     * @param string $dictCategoryInfo The page list information
     */
    public function createCategory ($dictCategoryInfo)
    {
        $ret = 0;
        if (isset($dictCategoryInfo['title'], $dictCategoryInfo['publish'])) {

            $this->_db->query($this->_SQL['createCategory'], array($dictCategoryInfo['title'], intval($dictCategoryInfo['publish'])));
            $ret = $this->_db->affectedRows();
        }

        return $ret;
    }

    /**
     * delete a page list by page list id, also delete the pages of such page list
     *
     * @param int $dictCategoryId The page list id to be deleted
     */
    public function deleteCategoryById ($dictCategoryId)
    {
        $this->_db->query($this->_SQL['deleteDictCategoryById'], array($dictCategoryId));
        $this->_db->query($this->_SQL['deleteCategoryById'], array($dictCategoryId));
    }

    /**
     * verify media information
     */
    protected function verifyDict($dictInfo, $operation)
    {
        if(is_array($dictInfo) && isset($dictInfo['title'], $dictInfo['publish'], $dictInfo['categoryId'])) {
            $realDictInfo = array();
            $realDictInfo['title'] = htmlspecialchars($dictInfo['title']);
            $realDictInfo['publish'] = intval($dictInfo['publish']);
            $realDictInfo['categoryId'] = intval($dictInfo['categoryId']);

            $realDictInfo['onTop'] = isset($dictInfo['onTop']) ? intval($dictInfo['onTop']) : 0;
            $realDictInfo['titleStyle'] = 0;
            $realDictInfo['weight'] = isset($dictInfo['weight']) ? intval($dictInfo['weight']) : 0;
            $realDictInfo['titleStyle'] |= (isset($dictInfo['bold']) && $dictInfo['bold']==1) ? parent::NEWS_TITLE_BOLD : 0;
            $realDictInfo['titleStyle'] |= (isset($dictInfo['italic']) && $dictInfo['italic']==1) ? parent::NEWS_TITLE_ITALIC : 0;
            if(!empty($dictInfo['titleMedia'])) {
                switch($dictInfo['titleMedia']) {
                    case parent::NEWS_TITLE_IMAGE:
                        $realDictInfo['titleStyle'] |= parent::NEWS_TITLE_IMAGE;
                        break;

                    case parent::NEWS_TITLE_VIDEO:
                        $realDictInfo['titleStyle'] |= parent::NEWS_TITLE_VIDEO;
                        break;

                    case parent::NEWS_TITLE_AUDIO:
                        $realDictInfo['titleStyle'] |= parent::NEWS_TITLE_AUDIO;
                        break;

                    default:
                        break;
                }
            }
            $realDictInfo['color'] = isset($dictInfo['color']) ? htmlspecialchars($dictInfo['color']) : '';
            $realDictInfo['startTime'] = empty($dictInfo['startTime']) ? date('Y-m-d H:i:s') : $dictInfo['startTime'];
            $realDictInfo['endTime'] = empty($dictInfo['endTime']) ? '2030-12-31 23:59:59' : $dictInfo['endTime'];
            $realDictInfo['refUrl'] = isset($dictInfo['refUrl']) ? htmlspecialchars($dictInfo['refUrl']) : '';
            $realDictInfo['metaKey'] = isset($dictInfo['metaKey']) ? htmlspecialchars($dictInfo['metaKey']) : '';
            $realDictInfo['metaDesc'] = isset($dictInfo['metaDesc']) ? htmlspecialchars($dictInfo['metaDesc']) : '';
            $realDictInfo['introText'] = isset($dictInfo['introText']) ? $dictInfo['introText'] : 0;
            $realDictInfo['fullText'] = isset($dictInfo['fullText']) ? $dictInfo['fullText'] : '';
            if(self::DO_CREATE==$operation) {
                $realDictInfo['createTime'] = isset($dictInfo['createTime']) ? $dictInfo['createTime'] : date('Y-m-d H:i:s');
                $realDictInfo['createdById'] = isset($dictInfo['createdById']) ? intval($dictInfo['createdById']) : $_SESSION['my_user']['user_id'];
                $realDictInfo['createByName'] = isset($dictInfo['createByName']) ? htmlspecialchars($dictInfo['createByName']) : $_SESSION['my_user']['uid'];
            } else if(self::DO_UPDATE==$operation) {
                $realDictInfo['modifiedTime'] = isset($dictInfo['modifiedTime']) ? $dictInfo['modifiedTime'] : date('Y-m-d H:i:s');
                $realDictInfo['modifiedById'] = isset($dictInfo['modifiedById']) ? intval($dictInfo['modifiedById']) : $_SESSION['my_user']['user_id'];
                $realDictInfo['modifiedByName'] = isset($dictInfo['modifiedByName']) ? htmlspecialchars($dictInfo['modifiedByName']) : $_SESSION['my_user']['uid'];
            }

            return $realDictInfo;
        } else {
            return NULL;
        }
    }

    /****************** END::method zone *************************/

}// END::class

/* EOF */
