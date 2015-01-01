<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : system.module.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2010-7-23
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die("forbidden");

require_once(dirname(__FILE__) . '/My_News_Admin.class.php');
require_once(dirname(__FILE__) . '/module_news_front.class.php');

class My_News_Module_Admin extends My_News_Module
{
    protected $_newsWeights = array(0,1,2,3,4,5,6,7,8,9,10);

    protected function _loadModel($db)
    {
        $this->_newsModel = new My_News_Admin($db);

    }

    public function  returnWeb ()
    {
        $adminType = isset($_REQUEST['admin']) ? $_REQUEST['admin'] : NULL;
        switch ($adminType) {
            case 'news':// news content adminstration: create/update
                $ret = $this->webAdminNews();
                break;
            case 'category': // news category administration: create/update
            default:
                $ret = $this->webAdminCategory();
                break;
        }

        return $ret;
    }

    /**
     * News categories management for web
     * @return string The content to be displayed on the administration page
     */
    protected function webAdminCategory()
    {
        $action = isset($_REQUEST['form_action']) ? $_REQUEST['form_action'] : NULL;
        switch($action) {
            case 'add':// create news item or news category
            case 'new':
            case 'create':
                $ret = empty($_REQUEST['category_id']) ? $this->createCategory() : $this->createNews();
                break;

            case 'update':// update  news item or news category
            case 'edit':
            case 'save':
                $ret = empty($_REQUEST['news_id']) ? $this->updateCategory() : $this->updateNews();
                break;

            case 'delete':// delete news item or news category
                $ret = empty($_REQUEST['news_id']) ? $this->deleteCategory() : $this->deleteNews();
                break;

            case 'publish': // set news or category public state
                $ret = empty($_REQUEST['news_id']) ? $this->updateCategoryPublish() : $this->updateNewsPublish();
                break;

            case 'list':// list  news item or news category
            default:
                $ret = empty($_REQUEST['category_id']) ? $this->listCategories() : $this->listNewsByCategoryId();
                break;
        }

        return $ret;
    }

    /**
     * Create news category
     */
    protected function createCategory()
    {
        global $My_Kernel;

        if (isset($_POST['form_action']) && 'create' == $_POST['form_action']) {
            $categoryInfo = array (
                'title'     => htmlspecialchars($_POST['news_category_name']),
                'publish'   => $_POST['news_category_publish']
                );
            $this->_newsModel->createCategory($categoryInfo);

            $ret = array('content_type' => 'URL',
                         'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=category&form_action=list');
        } else {// show page creation form
            $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                              'module' => $this->_moduleInfo['moduleName'],
                                              'file'   => 'newsAdmin.tpl.php'
                                        )
                             );
            $plugin = $My_Kernel->getPlugin('My_FormAction')
                                ->load( 'admin_main_content',
                                         array('action' => array('create', 'return', 'help'),
                                              'warning'   => array('return'=>'?yemodule=news&admin=category',
                                                                   'help'  =>'?yemodule=news&admin=category'
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
     * Update news category
     */
    protected function updateCategory()
    {
        global $My_Kernel;

        $categoryId = intval($_REQUEST['category_id']);
        if (isset($_POST['form_action']) && 'save' == $_POST['form_action']) {
            $categoryInfo = array (
                'title'     => htmlspecialchars($_POST['news_category_name']),
                'publish'   => $_POST['news_category_publish']
                );
            $this->_newsModel->updateCategory($categoryId, $categoryInfo);

            $ret = array('content_type' => 'URL',
                         'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=category&form_action=list');
        } else {// show news category update form
            $categoryInfo = $this->_newsModel->getCategoryById($categoryId);
            $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                              'module' => $this->_moduleInfo['moduleName'],
                                              'file'   => 'newsAdmin.tpl.php'
                                        )
                             );
            $plugin = $My_Kernel->getPlugin('My_FormAction')
                                ->load( 'admin_main_content',
                                         array('action' => array('save', 'return', 'help'),
                                              'warning'   => array('return'=>'?yemodule=news&admin=category',
                                                                   'help'  =>'?yemodule=news&admin=category'
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
     * Delete news category
     */
    protected function deleteCategory()
    {
        global $My_Kernel;

        $categoryId = isset($_REQUEST['category_id']) ? (int)$_REQUEST['category_id'] : NULL;

        if (isset($_POST['form_delete_confirm']) && 'yes' == $_POST['form_delete_confirm']) {
            $this->_newsModel->deleteCategoryById($categoryId);
            $ret = array('content_type' => 'URL',
                         'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=category&form_action=list');
        } else {
            $categoryInfo   = $this->_newsModel->getCategoryById($categoryId);
            $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                              'module' => $this->_moduleInfo['moduleName'],
                                              'file'   => 'newsAdmin.tpl.php'
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
                                                       'descItems'   => array($this->lang['news_category_title']=>$categoryInfo['title']
                                                       )
                                                 )
                                               )
                                   ->render();
        }

        return $ret;
    }

    /**
     * list all page categories
     * @param object $my_news News class object
     */
    public function listCategories ()
    {
        global $My_Kernel;

        $categories = $this->_newsModel->getNewsCategories();

        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                              'module' => $this->_moduleInfo['moduleName'],
                                              'file'   => 'newsAdmin.tpl.php'
                                                    )
            );

        // prepare
        $plugin = $My_Kernel->getPlugin('My_FormAction')
                            ->load( 'admin_main_content',
                                     array('action' => array('new', 'edit', 'delete', 'help'),
                                          //'preAction' => array('new'=>'preNew', 'delete'=>'delAction'),
                                          'warinig'   => array('delete'=>'Please select one') ));
        $totalNumber = $this->_newsModel->countCategory();
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
                            $this->lang['news_category_name']);
        $itemMenu = array($this->lang['category_list_news_count']   =>array('html'=>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=news&form_action=list&category_id=%d" class="item_count">%s</a>',
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
                                                   'page_admin_title' => $this->lang['news_category_admin_title']
                                             )
                                           )
                               ->render();

        return $ret;
    }

    /**
     * admin(publish,delete, list) news/category by list id.
     * @param object $my_news News class object
     * @param int $categoryId The page category id
     */
    protected function updateNewsPublish ($my_news, $categoryId)
    {
        $subAction = isset($_GET['subAction']) ? $_GET['subAction'] : NULL;
        $newsId = isset($_GET['item']) ? (int)$_GET['item'] : 0;
        $redirect = true;

        switch ($subAction) {
            case 'publish_1':
                $my_news->updateNewsPublish ($newsId, 0);
                break;

            case 'publish_0':
                $my_news->updateNewsPublish ($newsId, 1);
                break;

            case 'delete':
                $this->webDeleteNews ($newsId);
                break;

            default:
                $redirect = false;
                break;
        }

        $ret = $redirect===false ? $this->webListNewsByCategoryId($my_news, $categoryId) :
                  array('content_type' => 'URL',
                        'content' => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=news&form_action=list&list=' . $categoryId);

        return $ret;
    }

    /**
     * List news by category id.
     * @param object $my_news News class object
     * @param int $categoryId The page category id
     */
    public function listNewsByCategoryId()
    {
        global $My_Kernel;

        $categoryId = intval($_REQUEST['category_id']);
        $news = & $this->_newsModel->getNewsByCategoryId ($categoryId);

        $totalNumber = $this->_newsModel->countNewsByCategoryId($categoryId);
        $My_ListItemsInTpl = $My_Kernel->getPlugin('My_ListItemsInTpl');
        $pageList = $My_ListItemsInTpl->get('numberListPerPage');
        $numberPerPageIndex = isset($_GET['number_per_page'], $pageList[(int)$_GET['number_per_page']]) ? (int)$_GET['number_per_page'] : 0;
        $numberPerPage = $pageList[$numberPerPageIndex];
        $totalPage = ceil($totalNumber/$numberPerPage);
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $currentPage = $currentPage>$totalPage ? $totalPage : $currentPage;

        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                              'module' => $this->_moduleInfo['moduleName'],
                                              'file'   => 'newsAdmin.tpl.php'
                                                    )
            );
        $plugin = $My_Kernel->getPlugin('My_FormAction')
                            ->load( 'admin_main_content',
                                     array('action' => array('new', 'edit', 'delete', 'help'),
                                          //'preAction' => array('new'=>'preNew', 'delete'=>'delAction'),
                                          'warning'   => array('delete'=>'Please select one') ));
        $listKeys = array(array('key' => '<input type=radio name="news_id" value="%d">',
                                'value' => array('news_id')),
                         array('key' => '<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=news&form_action=update&news_id=%d" title="%s">%s</a>',
                                'value' => array('news_id', 'title', 'title')),
                    );
        $itemHeader = array($this->lang['item_order'],
                            '&nbsp;',
                            $this->lang['page_name']);
        $itemMenu = array($this->lang['publish']   =>array('html'=>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=news&form_action=list&list=%d&subAction=publish_%d&page=%d" class="action_publish_%d"></a>',
                                                        'category_id'  => $categoryId,
                                                        'pub'      => 'publish',
                                                        'id'       => 'news_id',
                                                        'pub1'     => 'publish',
                                                        'class'    => 'publish'
                                                          ),
                          $this->lang['delete'] =>array(
                                                        'html'     =>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=news&form_action=delete&list=%d&news_id=%d" class="action_delete"></a>',
                                                        'list_id'  => $categoryId,
                                                        'id'       => 'news_id',
                                                        'class'    =>'delete'
                                                          ),
                         );
        $pageLink = '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=news&form_action=list&category_id=' . $categoryId;
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
                           ->listItemsInTpl ($news)
            ;

        $ret = $this->templater->setOptions($templateInfo)
                               ->assignList( array('action' => 'listNews',
                                                   'news'  => $items,
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
    protected function updateNews ()
    {
        global $My_Kernel;

        $newsId = intval($_REQUEST['news_id']);
        if (isset($_POST['form_action']) && 'save' == $_POST['form_action']) {
            $newsInfo = array (
                'title'     => $_POST['news_title'],
                'publish'   => $_POST['news_publish'],
                'onTop'     => $_POST['on_top'],
                'weight'    => $_POST['news_weight'],
                'bold'      => $_POST['news_bold'],
                'italic'    => $_POST['news_italic'],
                'color'     => $_POST['title_color'],
                'titleMedia'=> $_POST['news_title_media'],
                'startTime' => $_POST['start_time'],
                'endTime'   => $_POST['end_time'],
                'refUrl'    => $_POST['reference_url'],
                'metaKey'   => $_POST['meta_key'],
                'metaDesc'  => $_POST['meta_desc'],
                'introText' => $_POST['intro_text'],
                'fullText'  => $_POST['full_text'],
                'categoryId'=> $_POST['category_id']
                );
            $this->_newsModel->updateNews($newsId, $newsInfo);

            $ret = array('content_type' => 'URL',
                         'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=news&form_action=list&category_id='.$_POST['category_id']);
        } else {// show news update form
            $newsInfo = $this->_newsModel->getNewsById($newsId);
            $categoryId = $newsInfo['category_id'];
            $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                              'module' => $this->_moduleInfo['moduleName'],
                                              'file'   => 'newsAdmin.tpl.php'
                                        )
                             );
            $plugin = $My_Kernel->getPlugin('My_FormAction')
                                ->load( 'admin_main_content',
                                         array('action' => array('save', 'return', 'help'),
                                              'warning'   => array('return'=>'?yemodule=' . $this->_moduleInfo['moduleName'] . ' &admin=news&category_id' . $categoryId,
                                                                   'help'  =>'?yemodule=' . $this->_moduleInfo['moduleName']
                                                             )
                                         )
                                      );

            $ret = $this->templater->setOptions($templateInfo)
                                   ->assignList( array('action'      => 'newsUpdate',
                                                       'form_action' => $plugin,
                                                       'lang'        => $this->lang,
                                                       'category_id' => $categoryId,
                                                       'news_weights'=> $this->_newsWeights,
                                                       'newsInfo'    => $newsInfo
                                                 )
                                               )
                                   ->render();
        }

        return $ret;
    }

    /**
     * create menu or menu list
     */
    protected function createNews ()
    {
        global $My_Kernel;

        $categoryId = intval($_REQUEST['category_id']);
        if (isset($_POST['form_action']) && 'create' == $_POST['form_action']) {
            $newsInfo = array (
                'title'     => $_POST['news_title'],
                'publish'   => $_POST['news_publish'],
                'onTop'     => $_POST['on_top'],
                'weight'    => $_POST['news_weight'],
                'bold'      => $_POST['news_bold'],
                'italic'    => $_POST['news_italic'],
                'color'     => $_POST['title_color'],
                'titleMedia'=> $_POST['news_title_media'],
                'startTime' => $_POST['start_time'],
                'endTime'   => $_POST['end_time'],
                'refUrl'    => $_POST['reference_url'],
                'metaKey'   => $_POST['meta_key'],
                'metaDesc'  => $_POST['meta_desc'],
                'introText' => $_POST['intro_text'],
                'fullText'  => $_POST['full_text'],
                'categoryId'=> $categoryId
                );
            $this->_newsModel->createNews($newsInfo);

            $ret = array('content_type' => 'URL',
                         'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=news&form_action=list&category_id='.$categoryId);
        } else {// show page creation form
            $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                              'module' => $this->_moduleInfo['moduleName'],
                                              'file'   => 'newsAdmin.tpl.php'
                                        )
                             );
            $plugin = $My_Kernel->getPlugin('My_FormAction')
                                ->load( 'admin_main_content',
                                         array('action' => array('create', 'return', 'help'),
                                              'warning'   => array('return'=>'?yemodule=' . $this->_moduleInfo['moduleName'] . ' &admin=news&category_id' . $categoryId,
                                                                   'help'  =>'?yemodule=' . $this->_moduleInfo['moduleName']
                                                             )
                                         )
                                      );

            $ret = $this->templater->setOptions($templateInfo)
                                   ->assignList( array('action'      => 'newsCreate',
                                                       'form_action' => $plugin,
                                                       'lang'        => $this->lang,
                                                       'category_id' => $categoryId,
                                                       'news_weights'=> $this->_newsWeights
                                                 )
                                               )
                                   ->render();
        }
        return $ret;
    }

    protected function deleteNews ()
    {
        global $My_Kernel;

        $newsId = isset($_REQUEST['news_id']) ? (int)$_REQUEST['news_id'] : NULL;
        $categoryId = isset($_REQUEST['category_id']) ? (int)$_REQUEST['category_id'] : NULL;

        if (isset($_POST['form_delete_confirm']) && 'yes' == $_POST['form_delete_confirm']) {
            $this->_newsModel->deleteNewsById($newsId);
            $ret = array('content_type' => 'URL',
                         'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=news&form_action=list&category_id=' . $categoryId);
        } else {
            $news   = $this->_newsModel->getNewsById($newsId);
            $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                              'module' => $this->_moduleInfo['moduleName'],
                                              'file'   => 'newsAdmin.tpl.php'
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
                                                       'hiddenItems' => array('category_id'=>$news['category_id'],
                                                              'news_id' => $newsId),
                                                       'descItems'   => array($this->lang['news_title']=>$news['title']
                                                       )
                                                 )
                                               )
                                   ->render();
        }

        return $ret;
    }

    public function webAdminNews()
    {
        global $My_Kernel;

        $action = isset($_REQUEST['form_action']) ? $_REQUEST['form_action'] : NULL;

        switch (strtolower($action)) {
            case 'list': // list news items by category id
                $ret = $this->listNewsByCategoryId();
                break;

            case 'update': // update news or newsList
            case 'save':
            case 'edit':
                $ret = $this->updateNews();
                break;

            case 'delete': // delete news or newsList
                $ret = $this->deleteNews ();
                break;

            case 'new': // create new news or newsList
            case 'create': // create new news or newsList
                $ret = $this->createNews ();
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
