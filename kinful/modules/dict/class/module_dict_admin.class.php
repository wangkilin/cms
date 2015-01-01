<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : module_dict_admin.class.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2010-7-23
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die("forbidden");

require_once(dirname(__FILE__) . '/My_Dict_Admin.class.php');
require_once(dirname(__FILE__) . '/module_dict_front.class.php');

class My_Dict_Module_Admin extends My_Dict_Module
{
    protected $_mediaWeights = array(0,1,2,3,4,5,6,7,8,9,10);

    protected function _loadModel($db)
    {
        $this->_mediaModel = new My_Dict_Admin($db);

    }

    public function  returnWeb ()
    {
        $adminType = isset($_REQUEST['admin']) ? $_REQUEST['admin'] : NULL;
        switch ($adminType) {
            case 'dict':// media content adminstration: create/update
                $ret = $this->webAdminDict();
                break;
            case 'category': // media category administration: create/update
            default:
                $ret = $this->webAdminCategory();
                break;
        }

        return $ret;
    }

    /**
     * Dict categories management for web
     * @return string The content to be displayed on the administration page
     */
    protected function webAdminCategory()
    {
        $action = isset($_REQUEST['form_action']) ? $_REQUEST['form_action'] : NULL;
        switch($action) {
            case 'add':// create media item or media category
            case 'new':
            case 'create':
                $ret = empty($_REQUEST['category_id']) ? $this->createCategory() : $this->createDict();
                break;

            case 'update':// update  media item or media category
            case 'edit':
            case 'save':
                $ret = empty($_REQUEST['dict_id']) ? $this->updateCategory() : $this->updateDict();
                break;

            case 'delete':// delete media item or media category
                $ret = empty($_REQUEST['dict_id']) ? $this->deleteCategory() : $this->deleteDict();
                break;

            case 'publish': // set media or category public state
                $ret = empty($_REQUEST['dict_id']) ? $this->updateCategoryPublish() : $this->updateDictPublish();
                break;

            case 'list':// list  media item or media category
            default:
                $ret = empty($_REQUEST['category_id']) ? $this->listCategories() : $this->listDictByCategoryId();
                break;
        }

        return $ret;
    }

    /**
     * Create media category
     */
    protected function createCategory()
    {
        global $My_Kernel;

        if (isset($_POST['form_action']) && 'create' == $_POST['form_action']) {
            $categoryInfo = array (
                'title'     => htmlspecialchars($_POST['dict_category_name']),
                'publish'   => $_POST['dict_category_publish']
                );
            $this->_mediaModel->createCategory($categoryInfo);

            $ret = array('content_type' => 'URL',
                         'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=category&form_action=list');
        } else {// show page creation form
            $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                              'file' => 'module_media.php'
                                        )
                             );
            $plugin = $My_Kernel->getPlugin('My_FormAction')
                                ->load( 'admin_main_content',
                                         array('action' => array('create', 'return', 'help'),
                                              'warning'   => array('return'=>'?yemodule=dict&admin=category',
                                                                   'help'  =>'?yemodule=dict&admin=category'
                                                             )
                                         )
                                      );

            $ret = $this->templater->setOptions($templateInfo)
                                   ->assignList( array('action'      => 'categoryCreate',
                                                       'form_action' => $plugin,
                                                       'lang'        => $this->lang,
                                                 )
                                               )
                                   ->render();
        }
        return $ret;
    }
    /**
     * Update media category
     */
    protected function updateCategory()
    {
        global $My_Kernel;

        $categoryId = intval($_REQUEST['category_id']);
        if (isset($_POST['form_action']) && 'save' == $_POST['form_action']) {
            $categoryInfo = array (
                'title'     => htmlspecialchars($_POST['dict_category_name']),
                'publish'   => $_POST['dict_category_publish']
                );
            $this->_mediaModel->updateCategory($categoryId, $categoryInfo);

            $ret = array('content_type' => 'URL',
                         'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=category&form_action=list');
        } else {// show media category update form
            $categoryInfo = $this->_mediaModel->getCategoryById($categoryId);
            $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                              'file' => 'module_media.php'
                                        )
                             );
            $plugin = $My_Kernel->getPlugin('My_FormAction')
                                ->load( 'admin_main_content',
                                         array('action' => array('save', 'return', 'help'),
                                              'warning'   => array('return'=>'?yemodule=dict&admin=category',
                                                                   'help'  =>'?yemodule=dict&admin=category'
                                                             )
                                         )
                                      );

            $ret = $this->templater->setOptions($templateInfo)
                                   ->assignList( array('action'      => 'categoryUpdate',
                                                       'form_action' => $plugin,
                                                       'lang'        => $this->lang,
                                                       'category'    => $categoryInfo
                                                 )
                                               )
                                   ->render();
        }
        return $ret;
    }
    /**
     * Delete media category
     */
    protected function deleteCategory()
    {
        global $My_Kernel;

        $categoryId = isset($_REQUEST['category_id']) ? (int)$_REQUEST['category_id'] : NULL;

        if (isset($_POST['form_delete_confirm']) && 'yes' == $_POST['form_delete_confirm']) {
            $this->_mediaModel->deleteCategoryById($categoryId);
            $ret = array('content_type' => 'URL',
                         'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=category&form_action=list');
        } else {
            $categoryInfo   = $this->_mediaModel->getCategoryById($categoryId);
            $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                              'file' => 'module_media.php'
                                        )
                             );
            $plugin = $My_Kernel->getPlugin('My_FormAction')
                                ->load( 'admin_main_content',
                                         array('action' => array('return'))
                                      );

            $ret = $this->templater->setOptions($templateInfo)
                                   ->assignList( array('action'      => 'deleteConfirm',
                                                       'form_action'        => $plugin,
                                                       'lang'        => $this->lang,
                                                       'hiddenItems' => array('category_id'=>$categoryId),
                                                       'descItems'   => array($this->lang['dict_category_title']=>$categoryInfo['title']
                                                       )
                                                 )
                                               )
                                   ->render();
        }

        return $ret;
    }

    /**
     * list all page categories
     * @param object $my_media Dict class object
     */
    public function listCategories ()
    {
        global $My_Kernel;

        $categories = $this->_mediaModel->getDictCategories();

        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                          'file' => 'module_media.php'
                                                    )
            );

        // prepare
        $plugin = $My_Kernel->getPlugin('My_FormAction')
                            ->load( 'admin_main_content',
                                     array('action' => array('new', 'edit', 'delete', 'help'),
                                          //'preAction' => array('new'=>'preNew', 'delete'=>'delAction'),
                                          'warinig'   => array('delete'=>'Please select one') ));
        $totalNumber = $this->_mediaModel->countCategory();
        $My_ListItemsInTpl = $My_Kernel->getPlugin('My_ListItemsInTpl');
        $pageList = $My_ListItemsInTpl->get('numberListPerPage');
        $numberPerPageIndex = isset($_GET['number_per_page'], $pageList[(int)$_GET['number_per_page']]) ? (int)$_GET['number_per_page'] : 0;
        $numberPerPage = $pageList[$numberPerPageIndex];
        $totalPage = ceil($totalNumber/$numberPerPage);
        $currentPage = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
        $currentPage = $currentPage > $totalPage ? $totalPage : $currentPage;

        $listKeys = array(array('key' => '<input type=radio name="category_id" value="%d">',
                                'value' => array('category_id')),
                         array('key' => '<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=category&form_action=update&category_id=%d" >%s</a>',
                                'value' => array('category_id', 'title')),
                    );
        $itemHeader = array($this->lang['item_order'],
                            '&nbsp;',
                            $this->lang['dict_category_name']);
        $itemMenu = array($this->lang['category_list_media_count']   =>array('html'=>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=dict&form_action=list&category_id=%d" class="item_count">%s</a>',
                                                        'id'=>'category_id',
                                                        'count'=>'item_count',
                                                        'class'=>'publish'
                                                          ),
                          $this->lang['publish'] =>array('html'=>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=category&form_action=delete&category_id=%d" class="action_publish_%d"></a>',
                                                        'id'=>'category_id',
                                                        'pub'      => 'publish',
                                                        'class'=>'publish'
                                                          ),
                          $this->lang['delete'] =>array('html'=>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=category&form_action=delete&category_id=%d" class="action_delete"></a>',
                                                        'id'=>'category_id',
                                                        'class'=>'delete'
                                                          ),
                         );
        $pageLink = '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=category&form_action=list';
        $items = $My_ListItemsInTpl
                           ->setOptions(array('itemHeader'=>$itemHeader,
                                        'listKeys'=>$listKeys,
                                        'pageLink'=>$pageLink,
                                        'itemMenu'=>$itemMenu,
                                        'totalItemNumber' =>$totalNumber,
                                        'currentPage' =>$currentPage,
                                        'numberPerPageIndex' =>$numberPerPageIndex
                                        )
                             )
                           ->listItemsInTpl ($categories)
            ;

        $ret = $this->templater->setOptions($templateInfo)
                               ->assignList( array('action'          => 'default',
                                                   'pages'           => $items,
                                                   'form_action'     => $plugin,
                                                   'page_admin_title' => $this->lang['dict_category_admin_title']
                                             )
                                           )
                               ->render();

        return $ret;
    }

    /**
     * admin(publish,delete, list) dict/category by list id.
     * @param object $my_media Dict class object
     * @param int $categoryId The page category id
     */
    protected function updateDictPublish ($my_media, $categoryId)
    {
        $subAction = isset($_GET['subAction']) ? $_GET['subAction'] : NULL;
        $dictId = isset($_GET['item']) ? (int)$_GET['item'] : 0;
        $redirect = true;

        switch ($subAction) {
            case 'publish_1':
                $my_media->updateDictPublish ($dictId, 0);
                break;

            case 'publish_0':
                $my_media->updateDictPublish ($dictId, 1);
                break;

            case 'delete':
                $this->webDeleteDict ($dictId);
                break;

            default:
                $redirect = false;
                break;
        }

        $ret = $redirect===false ? $this->webListDictByCategoryId($my_media, $categoryId) :
                  array('content_type' => 'URL',
                        'content' => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=dict&form_action=list&list=' . $categoryId);

        return $ret;
    }

    /**
     * List media by category id.
     * @param object $my_media Dict class object
     * @param int $categoryId The page category id
     */
    public function listDictByCategoryId()
    {
        global $My_Kernel;

        $categoryId = intval($_REQUEST['category_id']);
        $dict = & $this->_mediaModel->getDictByCategoryId ($categoryId);

        $totalNumber = $this->_mediaModel->countDictByCategoryId($categoryId);
        $My_ListItemsInTpl = $My_Kernel->getPlugin('My_ListItemsInTpl');
        $pageList = $My_ListItemsInTpl->get('numberListPerPage');
        $numberPerPageIndex = isset($_GET['number_per_page'], $pageList[(int)$_GET['number_per_page']]) ? (int)$_GET['number_per_page'] : 0;
        $numberPerPage = $pageList[$numberPerPageIndex];
        $totalPage = ceil($totalNumber/$numberPerPage);
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $currentPage = $currentPage>$totalPage ? $totalPage : $currentPage;

        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                          'file' => 'module_media.php'
                                                    )
            );
        $plugin = $My_Kernel->getPlugin('My_FormAction')
                            ->load( 'admin_main_content',
                                     array('action' => array('new', 'edit', 'delete', 'help'),
                                          //'preAction' => array('new'=>'preNew', 'delete'=>'delAction'),
                                          'warning'   => array('delete'=>'Please select one') ));
        $listKeys = array(array('key' => '<input type=radio name="dict_id" value="%d">',
                                'value' => array('dict_id')),
                         array('key' => '<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=dict&form_action=update&dict_id=%d" title="%s">%s</a>',
                                'value' => array('dict_id', 'title', 'title')),
                    );
        $itemHeader = array($this->lang['item_order'],
                            '&nbsp;',
                            $this->lang['page_name']);
        $itemMenu = array($this->lang['publish']   =>array('html'=>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=dict&form_action=list&list=%d&subAction=publish_%d&page=%d" class="action_publish_%d"></a>',
                                                        'category_id'  => $categoryId,
                                                        'pub'      => 'publish',
                                                        'id'       => 'dict_id',
                                                        'pub1'     => 'publish',
                                                        'class'    => 'publish'
                                                          ),
                          $this->lang['delete'] =>array(
                                                        'html'     =>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=dict&form_action=delete&list=%d&dict_id=%d" class="action_delete"></a>',
                                                        'list_id'  => $categoryId,
                                                        'id'       => 'dict_id',
                                                        'class'    =>'delete'
                                                          ),
                         );
        $pageLink = '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=dict&form_action=list&category_id=' . $categoryId;
        $items = $My_ListItemsInTpl
                           ->setOptions(array('itemHeader'=>$itemHeader,
                                        'listKeys'=>$listKeys,
                                        'pageLink'=>$pageLink,
                                        'itemMenu'=>$itemMenu,
                                        'totalItemNumber' =>$totalNumber,
                                        'currentPage' =>$currentPage,
                                        'numberPerPageIndex' =>$numberPerPageIndex
                                        )
                             )
                           ->listItemsInTpl ($dict)
            ;

        $ret = $this->templater->setOptions($templateInfo)
                               ->assignList( array('action' => 'listDict',
                                                   'dict'  => $items,
                                                   'form_action' => $plugin,
                                                   'page_admin_title' => $this->lang['page_admin_title']
                                             )
                                           )
                               ->render();

        return $ret;
    }

    /**
     * update page or page list
     */
    protected function updateDict ()
    {
        global $My_Kernel;

        $dictId = intval($_REQUEST['dict_id']);
        if (isset($_POST['form_action']) && 'save' == $_POST['form_action']) {
            $dictInfo = array (
                'title'     => $_POST['dict_title'],
                'publish'   => $_POST['dict_publish'],
                'onTop'     => $_POST['on_top'],
                'weight'    => $_POST['dict_weight'],
                'bold'      => $_POST['dict_bold'],
                'italic'    => $_POST['dict_italic'],
                'color'     => $_POST['title_color'],
                'titleDict'=> $_POST['dict_title_media'],
                'startTime' => $_POST['start_time'],
                'endTime'   => $_POST['end_time'],
                'refUrl'    => $_POST['reference_url'],
                'metaKey'   => $_POST['meta_key'],
                'metaDesc'  => $_POST['meta_desc'],
                'introText' => $_POST['intro_text'],
                'fullText'  => $_POST['full_text'],
                'categoryId'=> $_POST['category_id']
                );
            $this->_mediaModel->updateDict($dictId, $dictInfo);

            $ret = array('content_type' => 'URL',
                         'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=dict&form_action=list&category_id='.$_POST['category_id']);
        } else {// show media update form
            $dictInfo = $this->_mediaModel->getDictById($dictId);
            $categoryId = $dictInfo['category_id'];
            $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                              'file' => 'module_media.php'
                                        )
                             );
            $plugin = $My_Kernel->getPlugin('My_FormAction')
                                ->load( 'admin_main_content',
                                         array('action' => array('save', 'return', 'help'),
                                              'warning'   => array('return'=>'?yemodule=' . $this->_moduleInfo['moduleName'] . ' &admin=dict&category_id' . $categoryId,
                                                                   'help'  =>'?yemodule=' . $this->_moduleInfo['moduleName']
                                                             )
                                         )
                                      );

            $ret = $this->templater->setOptions($templateInfo)
                                   ->assignList( array('action'      => 'dictUpdate',
                                                       'form_action' => $plugin,
                                                       'lang'        => $this->lang,
                                                       'category_id' => $categoryId,
                                                       'dict_weights'=> $this->_mediaWeights,
                                                       'dictInfo'    => $dictInfo
                                                 )
                                               )
                                   ->render();
        }

        return $ret;
    }

    /**
     * create menu or menu list
     */
    protected function createDict ()
    {
        global $My_Kernel;

        $categoryId = intval($_REQUEST['category_id']);
        if (isset($_POST['form_action']) && 'create' == $_POST['form_action']) {
            $dictInfo = array (
                'title'     => $_POST['dict_title'],
                'publish'   => $_POST['dict_publish'],
                'onTop'     => $_POST['on_top'],
                'weight'    => $_POST['dict_weight'],
                'bold'      => $_POST['dict_bold'],
                'italic'    => $_POST['dict_italic'],
                'color'     => $_POST['title_color'],
                'titleDict'=> $_POST['dict_title_dict'],
                'startTime' => $_POST['start_time'],
                'endTime'   => $_POST['end_time'],
                'refUrl'    => $_POST['reference_url'],
                'metaKey'   => $_POST['meta_key'],
                'metaDesc'  => $_POST['meta_desc'],
                'introText' => $_POST['intro_text'],
                'fullText'  => $_POST['full_text'],
                'categoryId'=> $categoryId
                );
            $this->_dictModel->createDict($dictInfo);

            $ret = array('content_type' => 'URL',
                         'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=dict&form_action=list&category_id='.$categoryId);
        } else {// show page creation form
            $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                              'file' => 'module_dict.php'
                                        )
                             );
            $plugin = $My_Kernel->getPlugin('My_FormAction')
                                ->load( 'admin_main_content',
                                         array('action' => array('create', 'return', 'help'),
                                              'warning'   => array('return'=>'?yemodule=' . $this->_moduleInfo['moduleName'] . ' &admin=dict&category_id' . $categoryId,
                                                                   'help'  =>'?yemodule=' . $this->_moduleInfo['moduleName']
                                                             )
                                         )
                                      );

            $ret = $this->templater->setOptions($templateInfo)
                                   ->assignList( array('action'      => 'dictCreate',
                                                       'form_action' => $plugin,
                                                       'lang'        => $this->lang,
                                                       'category_id' => $categoryId,
                                                       'dict_weights'=> $this->_dictWeights
                                                 )
                                               )
                                   ->render();
        }
        return $ret;
    }

    protected function deleteDict ()
    {
        global $My_Kernel;

        $dictId = isset($_REQUEST['dict_id']) ? (int)$_REQUEST['dict_id'] : NULL;
        $categoryId = isset($_REQUEST['category_id']) ? (int)$_REQUEST['category_id'] : NULL;

        if (isset($_POST['form_delete_confirm']) && 'yes' == $_POST['form_delete_confirm']) {
            $this->_dictModel->deleteDictById($dictId);
            $ret = array('content_type' => 'URL',
                         'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=dict&form_action=list&category_id=' . $categoryId);
        } else {
            $dict   = $this->_dictModel->getDictById($dictId);
            $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                              'file' => 'module_dict.php'
                                        )
                             );
            $plugin = $My_Kernel->getPlugin('My_FormAction')
                                ->load( 'admin_main_content',
                                         array('action' => array('return'),
                                         )
                                      );

            $ret = $this->templater->setOptions($templateInfo)
                                   ->assignList( array('action'      => 'deleteConfirm',
                                                       'form_action'        => $plugin,
                                                       'lang'        => $this->lang,
                                                       'hiddenItems' => array('category_id'=>$dict['category_id'],
                                                              'dict_id' => $dictId),
                                                       'descItems'   => array($this->lang['dict_title']=>$dict['title']
                                                       )
                                                 )
                                               )
                                   ->render();
        }

        return $ret;
    }

    public function webAdminDict()
    {
        global $My_Kernel;

        $action = isset($_REQUEST['form_action']) ? $_REQUEST['form_action'] : NULL;

        switch (strtolower($action)) {
            case 'list': // list dict items by category id
                $ret = $this->listDictByCategoryId();
                break;

            case 'update': // update dict or dictList
            case 'save':
            case 'edit':
                $ret = $this->updateDict();
                break;

            case 'delete': // delete dict or dictList
                $ret = $this->deleteDict ();
                break;

            case 'new': // create new dict or dictList
            case 'create': // create new dict or dictList
                $ret = $this->createDict ();
                break;

            default:
                $ret = $this->listCategories ();
                break;

        }

        return $ret;
    }


	/****************** END::method zone *************************/

}// END::class

/* EOF */
