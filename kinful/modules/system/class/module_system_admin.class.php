<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : system.module.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2007-2-6
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die("forbidden");

require_once(MY_ROOT_PATH . 'modules/abstract.php');

class My_System_Module_Admin extends module
{

    public function  returnWeb ()
    {
        $ret = NULL;
        //var_dump($this->_params,true === $this->_isFinalPage);
        if (true === $this->_isFinalPage && (isset($_REQUEST['admin']))) {
        // display main block content
            switch ($_REQUEST['admin']) {
                case 'menu':
                    $ret = $this->webAdminMenu();
                    break;

                case 'page':
                    $ret = $this->webAdminPage();
                    break;

                case 'module':
                    $ret = $this->webAdminModule();
                    break;

                case 'plugin':
                    $ret = $this->webAdminPlugin();
                    break;

                case 'login': // admin user logined, redirect url
                    $ret = $this->userLoginRedirect();
                    break;

                case 'logout':// admin user logout, redirect url
                    $ret = $this->userLogout();
                    break;

                default:
                    $ret = '';
                    break;
            }
            //$ret = array('basic' => $ret, 'param' => 'hello');
        } else if (isset($this->_params['type'])) {
        // load block content: system menu, banner and etc.
            switch (strtolower($this->_params['type'])) {
                case 'login':
                    $ret = $this->webLogin();
                    break;

                case 'media':
                    $ret = $this->webMedia();
                    break;

                case 'channel':
                    $ret = $this->webChannel();
                    break;

                case 'menu':
                    $ret = $this->webMenu();
                    break;

                case 'page':
                    $ret = $this->webPage();
                    break;

                default:
                    break;
            }
        }

        return $ret;
    }

    /**
     * Do login redirect to home page
     */
    protected function userLoginRedirect()
    {
        return $ret = array('content_type' => 'URL',
                            'content'      => MY_ROOT_URL);
    }

    /**
     * list all page categories
     * @param object $my_page Page class object
     */
    public function webListPageList ($my_page)
    {
        global $My_Kernel;

        $pages = $my_page->getPageCategory();

        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                          'file' => 'module_system_page.php'
                                                    )
            );

        $plugin = $My_Kernel->getPlugin('My_FormAction')
                            ->load( 'admin_main_content',
                                     array('action' => array('new', 'edit', 'delete', 'help'),
                                          //'preAction' => array('new'=>'preNew', 'delete'=>'delAction'),
                                          'warinig'   => array('delete'=>'Please select one') ));
        $totalNumber = $my_page->getTotalPageList();
        $My_ListItemsInTpl = $My_Kernel->getPlugin('My_ListItemsInTpl');
        $pageList = $My_ListItemsInTpl->get('numberListPerPage');
        $numberPerPageIndex = isset($_GET['number_per_page'], $pageList[(int)$_GET['number_per_page']]) ? (int)$_GET['number_per_page'] : 0;
        $numberPerPage = $pageList[$numberPerPageIndex];
        $totalPage = ceil($totalNumber/$numberPerPage);
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $currentPage = $currentPage>$totalPage ? $totalPage : $currentPage;

        $listKeys = array(array('key' => '<input type=radio name="page_list_id" value="%d">',
                                'value' => array('page_category_id')),
                         array('key' => '<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=page&form_action=update&list=%d" >%s</a>',
                                'value' => array('page_category_id', 'page_category_name')),
                    );
        $itemHeader = array($this->lang['item_order'],
                            '&nbsp;',
                            $this->lang['page_category_name']);
        $itemMenu = array($this->lang['page_list_page_count']   =>array('html'=>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=page&form_action=list&list=%d" class="item_count">%s</a>',
                                                        'id'=>'page_category_id',
                                                        'count'=>'page_list_page_count',
                                                        'class'=>'publish'
                                                          ),
                          $this->lang['delete'] =>array('html'=>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=page&form_action=delete&list=%d" class="action_delete"></a>',
                                                        'id'=>'page_category_id',
                                                        'class'=>'delete'
                                                          ),
                         );
        $pageLink = '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=page&form_action=list';
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
                           ->listItemsInTpl ($pages)
            ;

        $ret = $this->templater->setOptions($templateInfo)
                               ->assignList( array('action'          => 'default',
                                                   'pages'           => $items,
                                                   'form_action'     => $plugin,
                                                   'page_admin_title' => $this->lang['page_list_admin_title']
                                             )
                                           )
                               ->render();

        return $ret;
    }

    /**
     * admin(publish,delete, list) page/pageList by list id.
     * @param object $my_page Page class object
     * @param int $pageListId The page category id
     */
    protected function webAdminPageByListId ($my_page, $pageListId)
    {
        $subAction = isset($_GET['subAction']) ? $_GET['subAction'] : NULL;
        $pageId = isset($_GET['page']) ? (int)$_GET['page'] : 0;
        $redirect = true;

        switch ($subAction) {
            case 'publish_1':
                $my_page->updatePagePublish ($pageId, 0);
                break;

            case 'publish_0':
                $my_page->updatePagePublish ($pageId, 1);
                break;

            case 'delete':
                $this->webDeletePage ($pageId);
                break;

            default:
                $redirect = false;
                break;
        }

        $ret = $redirect===false ? $this->webListPageByListId($my_page, $pageListId) :
                  array('content_type' => 'URL',
                        'content' => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=page&form_action=list&list=' . $pageListId);

        return $ret;
    }

    /**
     * List pages by list id.
     * @param object $my_page Page class object
     * @param int $pageListId The page category id
     */
    public function webListPageByListId($my_page, $pageListId)
    {
        global $My_Kernel;

        $pages = & $my_page->getPagesByPageListId ($pageListId);

        $totalNumber = $my_page->getTotalPageByListId($pageListId);
        $My_ListItemsInTpl = $My_Kernel->getPlugin('My_ListItemsInTpl');
        $pageList = $My_ListItemsInTpl->get('numberListPerPage');
        $numberPerPageIndex = isset($_GET['number_per_page'], $pageList[(int)$_GET['number_per_page']]) ? (int)$_GET['number_per_page'] : 0;
        $numberPerPage = $pageList[$numberPerPageIndex];
        $totalPage = ceil($totalNumber/$numberPerPage);
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $currentPage = $currentPage>$totalPage ? $totalPage : $currentPage;

        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                          'file' => 'module_system_page.php'
                                                    )
            );
        $plugin = $My_Kernel->getPlugin('My_FormAction')
                            ->load( 'admin_main_content',
                                     array('action' => array('new', 'edit', 'delete', 'help'),
                                          //'preAction' => array('new'=>'preNew', 'delete'=>'delAction'),
                                          'warning'   => array('delete'=>'Please select one') ));
        $listKeys = array(array('key' => '<input type=radio name="page_id" value="%d">',
                                'value' => array('page_id')),
                         array('key' => '<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=page&form_action=update&page=%d" title="%s">%s</a>',
                                'value' => array('page_id', 'notes', 'page_name')),
                    );
        $itemHeader = array($this->lang['item_order'],
                            '&nbsp;',
                            $this->lang['page_name']);
        $itemMenu = array($this->lang['publish']   =>array('html'=>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=page&form_action=list&list=%d&subAction=publish_%d&page=%d" class="action_publish_%d"></a>',
                                                        'list_id'  => $pageListId,
                                                        'pub'      => 'publish',
                                                        'id'       => 'page_id',
                                                        'pub1'     => 'publish',
                                                        'class'    => 'publish'
                                                          ),
                          $this->lang['delete'] =>array(
                                                        'html'     =>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=page&form_action=delete&list=%d&page=%d" class="action_delete"></a>',
                                                        'list_id'  => $pageListId,
                                                        'id'       => 'page_id',
                                                        'class'    =>'delete'
                                                          ),
                         );
        $pageLink = '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=page&form_action=list&list=' . $pageListId;
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
                           ->listItemsInTpl ($pages)
            ;

        $ret = $this->templater->setOptions($templateInfo)
                               ->assignList( array('action' => 'list_page',
                                                   'pages'  => $items,
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
    protected function webUpdatePage ($my_page)
    {
        global $My_Kernel;
        global $_system;

        $pageId = isset($_POST['page_id']) ? (int)$_POST['page_id'] : (isset($_GET['page']) ? (int)$_GET['page'] : NULL);
        $pageListId = isset($_POST['page_list_id']) ? (int)$_POST['page_list_id'] : (isset($_GET['list']) ? (int)$_GET['list'] : NULL);

        if (isset($pageId)) {
            if (isset($_POST['form_action']) && 'save' == $_POST['form_action']) {
                $supportType = MY_SUPPORT_NONE;
                foreach ((array)$_POST['page_support_type'] as $_supportType) {
                    $supportType |= $_supportType;
                }
                $pageInfo = array (
                    'page_name'       => $_POST['page_name'],
                    'support_type'    => $supportType,
                    'publish'         => $_POST['page_publish'],
                    'page_category_id'=> $pageListId,
                    'has_main_block'  => $_POST['has_main_block'],
                    'notes'           => $_POST['page_admin_note'],
                    'theme_id'        => $_POST['use_style'],
                    );
                $pageBlockInfo = array ();
                if (isset($_POST['newBlockId'], $_POST['newBlockName'], $_POST['newPositionId'])) {
                    $pageBlockInfo['block']      = $_POST['newBlockId'];
                    $pageBlockInfo['name']       = $_POST['newBlockName'];
                    $pageBlockInfo['position']   = $_POST['newPositionId'];
                }
                if (isset($_POST['toRemoveBlock'])) {
                    $pageBlockInfo['remove']     = $_POST['toRemoveBlock'];
                    $pageBlockInfo['removePage'] = $_POST['toRemovePage'];
                }
                if($pageId>0) {
                    $my_page->updatePage($pageId, $pageInfo);
                }
                $my_page->setPageBlock($pageId, $pageBlockInfo);

                //$ret = array('content_type' => 'URL',
                //             'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=page&form_action=list&list=' . $_POST['page_list_id']);
            } else {
                $page = $my_page->getPageById($pageId);
                $db = $My_Kernel->getSystemDbHandler();
                $my_theme = $My_Kernel->getClass('theme', $db);
                $my_block = $My_Kernel->getClass('block', $db);
                $my_module= $My_Kernel->getClass('module', $db);
                $blocks   = $my_block->sortBlockByModuleId($my_block->getAllFrontBlocks());
                $commonBlocks = $my_block->getPageBlocks($pageId);
                $modules  = $my_module->loadAllModules();
                $themes = $my_theme->getFrontThemes();

                $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                  'file' => 'module_system_page.php'
                                            )
                                 );
                $plugin = $My_Kernel->getPlugin('My_FormAction')
                                    ->load( 'admin_main_content',
                                             array('action' => array('save', 'return', 'help'),
                                                  'warning'   => array('return'=>'?yemodule=system&admin=page',
                                                                       'help'  =>'?yemodule=system&admin=page'
                                                                 )
                                             )
                                          );

                $ret = $this->templater->setOptions($templateInfo)
                                       ->assignList( array('action'      => 'page',
                                                           'page'        => $page,
                                                           'form_action' => $plugin,
                                                           'lang'        => $this->lang,
                                                           'themes'      => $themes,
                                                           'blocks'      => $blocks,
                                                           'modules'     => $modules,
                                                           'common_blocks'=> $commonBlocks,
                                                           'positions'   => $_system['positions']
                                                     )
                                                   )
                                       ->render();
            }
        } else if (isset($pageListId)) {
            if (isset($_POST['form_action']) && 'save' == $_POST['form_action']) {
                $pageListInfo = array (
                    'page_category_name' => $_POST['page_list_name']
                    );

                $my_page->updatePageList($pageListId, $pageListInfo);
                $ret = array('content_type' => 'URL',
                             'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=page');
            } else {
                $pageList   = $my_page->getPageListById($pageListId);
                $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                  'file' => 'module_system_page.php'
                                            )
                                 );
                $plugin = $My_Kernel->getPlugin('My_FormAction')
                                    ->load( 'admin_main_content',
                                             array('action' => array('save', 'return', 'help'),
                                                  'warning'   => array('return'=>'?yemodule=system&admin=page',
                                                                       'help'  =>'?yemodule=system&admin=page'
                                                                 )
                                             )
                                          );

                $ret = $this->templater->setOptions($templateInfo)
                                       ->assignList( array('action'      => 'list',
                                                           'page_list'   => $pageList,
                                                           'form_action' => $plugin,
                                                           'lang'        => $this->lang
                                                     )
                                                   )
                                       ->render();
            }
        }

        return $ret;
    }

    /**
     * create menu or menu list
     */
    protected function webCreatePage ($my_page)
    {
        global $My_Kernel;
        global $_system;

        $pageListId = isset($_POST['page_list_id']) ? (int)$_POST['page_list_id'] : (isset($_GET['list']) ? (int)$_GET['list'] : NULL);

        if (isset($pageListId)) { // create page
            if (isset($_POST['form_action']) && 'create' == $_POST['form_action']) {
                $supportType = MY_SUPPORT_NONE;
                foreach ($_POST['page_support_type'] as $_supportType) {
                    $supportType |= $_supportType;
                }
                $pageInfo = array (
                    'page_name'       => $_POST['page_name'],
                    'support_type'    => $supportType,
                    'publish'         => $_POST['page_publish'],
                    'page_category_id'=> $pageListId,
                    'has_main_block'  => $_POST['has_main_block'],
                    'notes'           => $_POST['page_admin_note'],
                    'theme_id'        => $_POST['use_style'],
                    );
                $my_page->createPage($pageInfo);

                $ret = array('content_type' => 'URL',
                             'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=page&form_action=list&list=' . $pageListId);
            } else {// show page creation form
                $db = $My_Kernel->getSystemDbHandler();
                $themes = $My_Kernel->getClass('theme', $db)->getFrontThemes();
                $my_block = $My_Kernel->getClass('block', $db);
                $blocks   = $my_block->sortBlockByModuleId($my_block->getAllFrontBlocks());
                $commonBlocks = $my_block->getPageCommonBlocks();
                $modules  = $My_Kernel->getClass('module', $db)->loadAllModules();
                $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                  'file' => 'module_system_page.php'
                                            )
                                 );
                $plugin = $My_Kernel->getPlugin('My_FormAction')
                                    ->load( 'admin_main_content',
                                             array('action' => array('create', 'return', 'help'),
                                                  'warning'   => array('return'=>'?yemodule=system&admin=page',
                                                                       'help'  =>'?yemodule=system&admin=page'
                                                                 )
                                             )
                                          );

                $ret = $this->templater->setOptions($templateInfo)
                                       ->assignList( array('action'      => 'pageCreate',
                                                           'page_list_id'=> $pageListId,
                                                           'form_action' => $plugin,
                                                           'lang'        => $this->lang,
                                                           'themes'      => $themes,
                                                           'modules'     => $modules,
                                                           'blocks'      => $blocks,
                                                           'common_blocks'=> $commonBlocks,
                                                           'positions'   => $_system['positions']
                                                     )
                                                   )
                                       ->render();
            }
        } else { // create page list
            if (isset($_POST['form_action']) && 'create' == $_POST['form_action']) {
                $pageListInfo = array (
                    'page_category_name' => $_POST['page_list_name']
                    );

                $my_page->createPageList($pageListInfo);
                $ret = array('content_type' => 'URL',
                             'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=page');
            } else {
                $pageList   = $my_page->getPageListById($pageListId);
                $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                  'file' => 'module_system_page.php'
                                            )
                                 );
                $plugin = $My_Kernel->getPlugin('My_FormAction')
                                    ->load( 'admin_main_content',
                                             array('action' => array('create', 'return', 'help'),
                                                  'warning'   => array('return'=>'?yemodule=system&admin=page',
                                                                       'help'  =>'?yemodule=system&admin=page'
                                                                 )
                                             )
                                          );

                $ret = $this->templater->setOptions($templateInfo)
                                       ->assignList( array('action'      => 'listCreate',
                                                           'page_list'   => $pageList,
                                                           'form_action' => $plugin,
                                                           'lang'        => $this->lang
                                                     )
                                                   )
                                       ->render();
            }
        }

        return $ret;
    }

    protected function webDeletePage ($my_page)
    {
        global $My_Kernel;

        $pageId = isset($_POST['page_id']) ? (int)$_POST['page_id'] : (isset($_GET['page']) ? (int)$_GET['page'] : NULL);
        $pageListId = isset($_POST['page_list_id']) ? (int)$_POST['page_list_id'] : (isset($_GET['list']) ? (int)$_GET['list'] : NULL);

        if (isset($pageId)) {

            if (isset($_POST['form_delete_confirm']) && 'yes' == $_POST['form_delete_confirm']) {
                $my_page->deletePageById($pageId);
                $ret = array('content_type' => 'URL',
                             'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=page&form_action=list&list=' . $_POST['page_list_id']);
            } else {
                $page   = $my_page->getPageById($pageId);
                $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                  'file' => 'module_system_delete_confirm.php'
                                            )
                                 );
                $plugin = $My_Kernel->getPlugin('My_FormAction')
                                    ->load( 'admin_main_content',
                                             array('action' => array('delete'),
                                             )
                                          );

                $ret = $this->templater->setOptions($templateInfo)
                                       ->assignList( array('action'      => 'page',
                                                           'lang'        => $this->lang,
                                                           'hiddenItems' => array('page_list_id'=>$page['page_category_id'],
                                                                  'page_id' => $page['page_id']),
                                                           'descItems'   => array($this->lang['page_name']=>$page['page_name']
                                                           )
                                                     )
                                                   )
                                       ->render();
            }

        } else if (isset($pageListId)) {
            if (isset($_POST['form_delete_confirm']) && 'yes' == $_POST['form_delete_confirm']) {
                $my_page->deleteListById($pageListId);
                $ret = array('content_type' => 'URL',
                             'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=page');
            } else {
                $pageList   = $my_page->getPageListById($pageListId);
                $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                  'file' => 'module_system_delete_confirm.php'
                                            )
                                 );
                $plugin = $My_Kernel->getPlugin('My_FormAction')
                                    ->load( 'admin_main_content',
                                             array('action' => array('return'),
                                             )
                                          );

                $ret = $this->templater->setOptions($templateInfo)
                                       ->assignList( array(
                                                           'lang'        => $this->lang,
                                                           'form_action' => $plugin,
                                                           'hiddenItems' => array('page_list_id'=>$pageListId),
                                                           'descItems'   => array($this->lang['page_list_name']=>$pageList['page_category_name']
                                                           , $this->lang['addtion_note']  =>$this->lang['delete_page_category_will_also_delete']
                                                                            )
                                                     )
                                                   )
                                       ->render();
            }
        }

        return $ret;
    }

    public function webAdminPage()
    {
        global $My_Kernel;

        $action = isset($_POST['form_action']) ? $_POST['form_action'] : (isset($_GET['form_action']) ? $_GET['form_action'] : NULL);
        $db = $My_Kernel->getSystemDbHandler();
        $requestInfo = $My_Kernel->getRequestTypeAndId();
        $my_page = $My_Kernel->getClass('page', $db);

        switch (strtolower($action)) {
            case 'list':
                $pageListId = (int) $_GET['list'];
                $ret = $this->webAdminPageByListId($my_page, $pageListId);
                break;

            case 'update': // update page or pageList
            case 'save':
            case 'edit':
                $ret = $this->webUpdatePage($my_page);
                break;

            case 'delete': // delete page or pageList
                $ret = $this->webDeletePage ($my_page);
                break;

            case 'new': // create new page or pageList
            case 'create': // create new page or pageList
                $ret = $this->webCreatePage ($my_page);
                break;

            default:

                $ret = $this->webListPageList ($my_page);
                break;

        }

        //var_dump($ret);
        return $ret;
    }

    /**
     * sort menu by menu id . The keys of new array are the menus id;
     *
     * @param array $menus The menus list
     * @param boolean $linkRef If new array links to menus address reference
     *
     * @return array
     */
    static public function sortMenusById($menus, $linkRef = true)
    {
        $_menus = array();

        foreach((array) $menus as $key => $menu) {
            if ($linkRef===true) {
                $_menus [$menu['menu_id']] = &$menus[$key] ;
            } else {
                $_menus [$menu['menu_id']] = $menu;
            }
        }

        return $_menus;
    }

    public function sortMenusByParentId($menus, $linkRef=true)
    {
        $_menus = array();

        foreach ((array)$menus as $key => $menu) {
            if (! isset($_menus[$menu['parent_id']])) {
                $_menus[$menu['parent_id']] = array();
            }

            if (true===$linkRef) {
                $_menus[$menu['parent_id']][$menu['menu_id']] = & $menus[$key];
            } else {
                $_menus[$menu['parent_id']][$menu['menu_id']] = $menu;
            }
        }

        return $_menus;
    }

    public function renameMenuNameWithParentName($menus)
    {
        $_menus = $this->sortMenusById($menus);

        foreach ($menus as $menuId => $menu) {
            $menus[$menuId]['id_tree'] = '|' . $menu['menu_id'] . '|';
            $parentId = $menu['parent_id'];
            while (0!=$parentId) {
                if (isset($_menus[$parentId])) {
                    $menus[$menuId]['menu_name'] = $_menus[$parentId]['menu_name'] . ' / ' . $menus[$menuId]['menu_name'];
                    $menus[$menuId]['id_tree'] = '|' . $parentId . '|' . $menus[$menuId]['id_tree'];
                    $parentId = $_menus[$parentId]['parent_id'];
                } else {
                    break;
                }
            }
            //$menus[$menuId]['id_tree'] = '|0|' . $menus[$menuId]['id_tree'];
        }

        return $menus;
    }

    public function levelSortMenus(& $menus, $entryKey=0)
    {
        $_menus = array();

        foreach ((array)$menus[$entryKey] as $menuId => $menu) {
            $_menus[] = & $menus[$entryKey][$menuId];
            if (isset($menus[$menuId])) {
                $tmpMenus = $this->levelSortMenus($menus, $menuId);
                $_menus = array_merge($_menus, $tmpMenus);
            }
        }

        return $_menus;
    }

    public function webListMenuByListId($my_menu, $menuListId)
    {
        global $My_Kernel;

        $menus = & $my_menu->getMenusByMenuListId ($menuListId);
        $menus = $this->renameMenuNameWithParentName($menus);
        $menus = $this->sortMenusByParentId($menus);
        $menus = $this->levelSortMenus($menus);

        $totalNumber = $my_menu->getTotalMenuByListId($menuListId);
        $My_ListItemsInTpl = $My_Kernel->getPlugin('My_ListItemsInTpl');
        $pageList = $My_ListItemsInTpl->get('numberListPerPage');
        $numberPerPageIndex = isset($_GET['number_per_page'], $pageList[(int)$_GET['number_per_page']]) ? (int)$_GET['number_per_page'] : 0;
        $numberPerPage = $pageList[$numberPerPageIndex];
        $totalPage = ceil($totalNumber/$numberPerPage);
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $currentPage = $currentPage>$totalPage ? $totalPage : $currentPage;

        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                          'file' => 'module_system_menu_admin.php'
                                                    )
            );
        $plugin = $My_Kernel->getPlugin('My_FormAction')
                            ->load( 'admin_main_content',
                                     array('action' => array('new', 'edit', 'delete', 'help'),
                                          //'preAction' => array('new'=>'preNew', 'delete'=>'delAction'),
                                          'warning'   => array('delete'=>'Please select one') ));
        $listKeys = array(array('key' => '<input type=radio name="menu_id" value="%d">',
                                'value' => array('menu_id')),
                         array('key' => '<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu&form_action=update&menu=%d" >%s</a>',
                                'value' => array('menu_id', 'menu_name')),
                    );
        $itemHeader = array($this->lang['item_order'],
                            '&nbsp;',
                            $this->lang['menu_name']);
        $itemMenu = array($this->lang['publish']   =>array('html'=>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu&form_action=list&list=%d&subAction=publish_%d&menu=%d" class="action_publish_%d"></a>',
                                                        'list_id'  => $menuListId,
                                                        'pub'      => 'publish',
                                                        'id'       => 'menu_id',
                                                        'pub1'     => 'publish',
                                                        'class'    => 'publish'
                                                          ),
                          $this->lang['order'] =>array(
                                                        'html'=>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu&form_action=list&list=%d&subAction=order_down&menu=%d" class="action_order_down"></a>
                                                                <a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu&form_action=list&list=%d&subAction=order_up&menu=%d" class="action_order_up"></a>',
                                                        'list_id'  => $menuListId,
                                                        'id'       => 'menu_id',
                                                        'list_id1' => $menuListId,
                                                        'id1'      => 'menu_id',
                                                        'class'    => 'order'
                                                          ),
                          $this->lang['delete'] =>array(
                                                        'html'     =>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu&form_action=list&list=%d&subAction=delete&menu=%d" class="action_delete" onclick=\'javascript: return(confirm("'.$this->lang['deleteConfirm'].':%s?"))\'></a>',
                                                        'list_id'  => $menuListId,
                                                        'id'       => 'menu_id',
                                                        'menuName' => 'menu_name',
                                                        'class'    =>'delete'
                                                          ),
                         );
        $pageLink = '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu&form_action=list&list=' . $menuListId;
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
                           ->listItemsInTpl ($menus)
            ;

        $ret = $this->templater->setOptions($templateInfo)
                               ->assignList( array('action'      => 'list_menu',
                                                   'menus'       => $items,
                                                   'form_action' => $plugin,
                                                   'lang'        => $this->lang
                                             )
                                           )
                               ->render();

        return $ret;
    }

    public function webListMenuList ($my_menu)
    {
        global $My_Kernel;

        $requestInfo = $My_Kernel->getRequestTypeAndId();

        $menus = & $my_menu->getAllModuleMenus ($requestInfo['type'], $requestInfo['id']);

        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                          'file' => 'module_system_menu_admin.php'
                                                    )
            );

        $plugin = $My_Kernel->getPlugin('My_FormAction')
                            ->load( 'admin_main_content',
                                     array('action' => array('new', 'edit', 'delete', 'help'),
                                          //'preAction' => array('new'=>'preNew', 'delete'=>'delAction'),
                                          'warinig'   => array('delete'=>'Please select one') ));
        $totalNumber = $my_menu->getTotalMenuList();
        $My_ListItemsInTpl = $My_Kernel->getPlugin('My_ListItemsInTpl');
        $pageList = $My_ListItemsInTpl->get('numberListPerPage');
        $numberPerPageIndex = isset($_GET['number_per_page'], $pageList[(int)$_GET['number_per_page']]) ? (int)$_GET['number_per_page'] : 0;
        $numberPerPage = $pageList[$numberPerPageIndex];
        $totalPage = ceil($totalNumber/$numberPerPage);
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $currentPage = $currentPage>$totalPage ? $totalPage : $currentPage;

        $listKeys = array(array('key' => '<input type=radio name="menu_list_id" value="%d">',
                                'value' => array('menu_list_id')),
                         array('key' => '<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu&form_action=update&list=%d" >%s</a>',
                                'value' => array('menu_list_id', 'menu_list_name')),
                    );
        $itemHeader = array($this->lang['item_order'],
                            '&nbsp;',
                            $this->lang['menu_list_name']);
        $itemMenu = array($this->lang['menu_list_menu_count']   =>array('html'=>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu&form_action=list&list=%d" class="menu_count">%s</a>',
                                                        'id'=>'menu_list_id',
                                                        'count'=>'menu_list_menu_count',
                                                        'class'=>'publish'
                                                          ),
                          $this->lang['publish']   =>array('html'=>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu&form_action=listUpdate&subAction=publish_%d&list=%d" class="action_publish_%d"></a>',
                                                        'pub'=>'publish',
                                                        'id'=>'menu_list_id',
                                                        'pub1'=>'publish',
                                                        'class'=>'publish'
                                                          ),
                          $this->lang['delete'] =>array('html'=>'<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu&form_action=listUpdate&subAction=delete&list=%d" class="action_delete"></a>',
                                                        'id'=>'menu_list_id',
                                                        'class'=>'delete'
                                                          ),
                         );
        $pageLink = '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu&form_action=list';
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
                           ->listItemsInTpl ($menus)
            ;

        $ret = $this->templater->setOptions($templateInfo)
                               ->assignList( array('action'      => 'default',
                                                   'menus'       => $items,
                                                   'form_action' => $plugin,
                                                   'lang'        => $this->lang
                                             )
                                           )
                               ->render();

        return $ret;
    }

    protected function webAdminMenuByListId ($my_menu, $menuListId)
    {
        $subAction = isset($_GET['subAction']) ? $_GET['subAction'] : NULL;
        $menuId = isset($_GET['menu']) ? (int)$_GET['menu'] : 0;
        $redirect = true;

        switch ($subAction) {
            case 'publish_1':
                $my_menu->updateMenuPublish ($menuId, 0);
                break;

            case 'publish_0':
                $my_menu->updateMenuPublish ($menuId, 1);
                break;

            case 'delete':
                $my_menu->deleteMenuById ($menuId);
                break;

            case 'order_up':
                $my_menu->updateMenuOrder ($menuListId, $menuId, 1);
                break;

            case 'order_down':
                $my_menu->updateMenuOrder ($menuListId, $menuId, -1);
                break;

            default:
                $redirect = false;
                break;
        }

        $ret = $redirect===false ? $this->webListMenuByListId($my_menu, $menuListId) :
                  array('content_type' => 'URL',
                        'content' => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu&form_action=list&list=' . $menuListId);

        return $ret;
    }

    protected function webAdminListById ($my_menu, $menuListId)
    {
        $subAction = isset($_GET['subAction']) ? $_GET['subAction'] : NULL;
        $redirect = true;

        switch ($subAction) {
            case 'publish_1':
                $my_menu->updateListPublish ($menuListId, 0);
                break;

            case 'publish_0':
                $my_menu->updateListPublish ($menuListId, 1);
                break;

            case 'delete':
                return $this->webDeleteMenu ($my_menu);
                //return $my_menu->deleteListById ($menuListId);
                break;

            default:
                $redirect = false;
                break;
        }

        $ret = $redirect===false ? $this->webListMenuList($my_menu) :
                  array('content_type' => 'URL',
                        'content' => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu');

        return $ret;
    }

    /**
     * update menu or menu list
     */
    protected function webUpdateMenu ($my_menu)
    {
        global $My_Kernel;

        $menuId = isset($_POST['menu_id']) ? (int)$_POST['menu_id'] : (isset($_GET['menu']) ? (int)$_GET['menu'] : NULL);
        $menuListId = isset($_POST['menu_list_id']) ? (int)$_POST['menu_list_id'] : (isset($_GET['list']) ? (int)$_GET['list'] : NULL);

        if (isset($menuId)) {
            if (isset($_POST['form_action']) && 'save' == $_POST['form_action']) {
                $menuInfo = array (
                    'parent_id' => $_POST['parent_menu'],
                    'menu_name' => $_POST['menu_name'],
                    'menu_link' => $_POST['menu_link'],
                    'open_mode' => $_POST['open_mode'],
                    'publish'   => $_POST['menu_publish']
                    );
                $my_menu->updateMenu($menuId, $menuInfo);
                $ret = array('content_type' => 'URL',
                             'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu&form_action=list&list=' . $_POST['menu_list_id']);
            } else {
                $menu = $my_menu->getMenuById($menuId);
                $menus = $my_menu->getMenusByMenuListId($menu['menu_list_id']);
                $menus = $this->renameMenuNameWithParentName($menus);
                $menus = $this->sortMenusByParentId($menus);
                $menus = $this->levelSortMenus($menus);
                $sortedMenus = $this->sortMenusById($menus);
                $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                  'file' => 'module_system_menu_webUpdateMenu.php'
                                            )
                                 );
                $plugin = $My_Kernel->getPlugin('My_FormAction')
                                    ->load( 'admin_main_content',
                                             array('action' => array('save', 'return', 'help'),
                                                  'warning'   => array('return'=>'?yemodule=system&admin=menu',
                                                                       'help'  =>'?yemodule=system&admin=menu'
                                                                 )
                                             )
                                          );

                $ret = $this->templater->setOptions($templateInfo)
                                       ->assignList( array('action'      => 'menu',
                                                           'menu'        => $menu,
                                                           'menus'       => $menus,
                                                           'sortedMenus' => $sortedMenus,
                                                           'form_action' => $plugin,
                                                           'lang'        => $this->lang
                                                     )
                                                   )
                                       ->render();
            }
        } else if (isset($menuListId)) {
            if (isset($_POST['form_action']) && 'save' == $_POST['form_action']) {
                $menuListInfo = array (
                    'menu_list_name' => $_POST['menu_list_name'],
                    'publish'        => $_POST['publish']
                    );

                $my_menu->updateMenuList($menuListId, $menuListInfo);
                $ret = array('content_type' => 'URL',
                             'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu');
            } else {
                $menuList   = $my_menu->getMenuListById($menuListId);
                $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                  'file' => 'module_system_menu_webUpdateMenu.php'
                                            )
                                 );
                $plugin = $My_Kernel->getPlugin('My_FormAction')
                                    ->load( 'admin_main_content',
                                             array('action' => array('save', 'return', 'help'),
                                                  'warning'   => array('return'=>'?yemodule=system&admin=menu',
                                                                       'help'  =>'?yemodule=system&admin=menu'
                                                                 )
                                             )
                                          );

                $ret = $this->templater->setOptions($templateInfo)
                                       ->assignList( array('action'      => 'list',
                                                           'menu_list'   => $menuList,
                                                           'form_action' => $plugin,
                                                           'lang'        => $this->lang
                                                     )
                                                   )
                                       ->render();
            }
        }

        return $ret;
    }

    /**
     * create menu or menu list
     */
    protected function webCreateMenu ($my_menu)
    {
        global $My_Kernel;

        $menuListId = isset($_POST['menu_list_id']) ? (int)$_POST['menu_list_id'] : (isset($_GET['list']) ? (int)$_GET['list'] : NULL);

        if (isset($menuListId)) {
            if (isset($_POST['form_action']) && 'create' == $_POST['form_action']) {
                $menuInfo = array (
                    'parent_id' => $_POST['parent_menu'],
                    'menu_name' => $_POST['menu_name'],
                    'menu_link' => $_POST['menu_link'],
                    'open_mode' => $_POST['open_mode'],
                    'publish'   => $_POST['menu_publish'],
                    'menu_list_id'=>$menuListId
                    );
                $my_menu->createMenu($menuInfo);

                $ret = array('content_type' => 'URL',
                             'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu&form_action=list&list=' . $menuListId);
            } else {
                $menus = $my_menu->getMenusByMenuListId($menuListId);
                $menus = $this->renameMenuNameWithParentName($menus);
                $menus = $this->sortMenusByParentId($menus);
                $menus = $this->levelSortMenus($menus);
                $sortedMenus = $this->sortMenusById($menus);
                $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                  'file' => 'module_system_menu_webUpdateMenu.php'
                                            )
                                 );
                $plugin = $My_Kernel->getPlugin('My_FormAction')
                                    ->load( 'admin_main_content',
                                             array('action' => array('create', 'return', 'help'),
                                                  'warning'   => array('return'=>'?yemodule=system&admin=menu',
                                                                       'help'  =>'?yemodule=system&admin=menu'
                                                                 )
                                             )
                                          );

                $ret = $this->templater->setOptions($templateInfo)
                                       ->assignList( array('action'      => 'menuCreate',
                                                           'menu_list_id'=> $menuListId,
                                                           'menus'       => $menus,
                                                           'sortedMenus' => $sortedMenus,
                                                           'form_action' => $plugin,
                                                           'lang'        => $this->lang
                                                     )
                                                   )
                                       ->render();
            }
        } else {
            if (isset($_POST['form_action']) && 'create' == $_POST['form_action']) {
                $menuListInfo = array (
                    'menu_list_name' => $_POST['menu_list_name'],
                    'publish'        => $_POST['publish']
                    );

                $my_menu->createMenuList($menuListInfo);
                $ret = array('content_type' => 'URL',
                             'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu');
            } else {
                $menuList   = $my_menu->getMenuListById($menuListId);
                $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                  'file' => 'module_system_menu_webUpdateMenu.php'
                                            )
                                 );
                $plugin = $My_Kernel->getPlugin('My_FormAction')
                                    ->load( 'admin_main_content',
                                             array('action' => array('create', 'return', 'help'),
                                                  'warning'   => array('return'=>'?yemodule=system&admin=menu',
                                                                       'help'  =>'?yemodule=system&admin=menu'
                                                                 )
                                             )
                                          );

                $ret = $this->templater->setOptions($templateInfo)
                                       ->assignList( array('action'      => 'listCreate',
                                                           'menu_list'   => $menuList,
                                                           'form_action' => $plugin,
                                                           'lang'        => $this->lang
                                                     )
                                                   )
                                       ->render();
            }
        }

        return $ret;
    }

    protected function webDeleteMenu ($my_menu)
    {
        global $My_Kernel;

        $menuId = isset($_POST['menu_id']) ? (int)$_POST['menu_id'] : (isset($_GET['menu']) ? (int)$_GET['menu'] : NULL);
        $menuListId = isset($_POST['menu_list_id']) ? (int)$_POST['menu_list_id'] : (isset($_GET['list']) ? (int)$_GET['list'] : NULL);

        if (isset($menuId)) {

            if (isset($_POST['form_delete_confirm']) && 'yes' == $_POST['form_delete_confirm']) {
                $my_menu->deleteMenuById($menuId);
                $ret = array('content_type' => 'URL',
                             'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu&form_action=list&list=' . $_POST['menu_list_id']);
            } else {
                $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                  'file' => 'module_system_delete_confirm.php'
                                            )
                                 );
                $plugin = $My_Kernel->getPlugin('My_FormAction')
                                    ->load( 'admin_main_content',
                                             array('action' => array('delete'),
                                             )
                                          );

                $ret = $this->templater->setOptions($templateInfo)
                                       ->assignList( array('action'      => 'menu',
                                                           'lang'        => $this->lang
                                                     )
                                                   )
                                       ->render();
            }

        } else if (isset($menuListId)) {
            if (isset($_POST['form_delete_confirm']) && 'yes' == $_POST['form_delete_confirm']) {
                $my_menu->deleteListById($menuListId);
                $ret = array('content_type' => 'URL',
                             'content'      => '?yemodule='.$this->_moduleInfo['moduleName'].'&admin=menu');
            } else {
                $menuList   = $my_menu->getMenuListById($menuListId);
                $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                  'file' => 'module_system_delete_confirm.php'
                                            )
                                 );
                $plugin = $My_Kernel->getPlugin('My_FormAction')
                                    ->load( 'admin_main_content',
                                             array('action' => array('return'),
                                             )
                                          );

                $ret = $this->templater->setOptions($templateInfo)
                                       ->assignList( array(
                                                           'lang'        => $this->lang,
                                                           'form_action' => $plugin,
                                                           'hiddenItems' => array('menu_list_id'=>$menuListId),
                                                           'descItems'   => array($this->lang['menu_list_name']=>$menuList['menu_list_name']
                                                                                , $this->lang['addtion_note']  =>$this->lang['delete_list_will_also_delete']
                                                                            )
                                                     )
                                                   )
                                       ->render();
            }
        }

        return $ret;
    }

    public function webAdminMenu()
    {
        global $My_Kernel;

        $action = isset($_POST['form_action']) ? $_POST['form_action'] : (isset($_GET['form_action']) ? $_GET['form_action'] : NULL);
        $db = $My_Kernel->getSystemDbHandler();
        $requestInfo = $My_Kernel->getRequestTypeAndId();
        $my_menu = $My_Kernel->getClass('menu', $db);

        switch (strtolower($action)) {
            case 'list':
                $menuListId = (int) $_GET['list'];
                $ret = $this->webAdminMenuByListId($my_menu, $menuListId);
                break;

            case 'listupdate':
                $menuListId = (int) $_GET['list'];
                $ret = $this->webAdminListById ($my_menu, $menuListId);
                break;

            case 'addmenu':
                $menuListId = (int) $_GET['list'];
                $menus = $my_menu->getMenusByListId ();

            case 'update': // update menu or menuList
            case 'save':
            case 'edit':
                $ret = $this->webUpdateMenu($my_menu);
                break;

            case 'delete': // delete menu or menuList
                $ret = $this->webDeleteMenu ($my_menu);
                break;

            case 'new': // create new menu or menuList
            case 'create': // create new menu or menuList
                $ret = $this->webCreateMenu ($my_menu);
                break;

            default:

                $ret = $this->webListMenuList ($my_menu);
                break;

        }

        //var_dump($ret);
        return $ret;
    }

    public function webChannel()
    {
        global $My_Kernel;

        $db = $My_Kernel->getSystemDbHandler();
        $requestInfo = $My_Kernel->getRequestTypeAndId();

        $my_channel = $My_Kernel->getClass('channel', $db);
        $channels = & $my_channel->getPublicChannels ($requestInfo['type'], $requestInfo['id']);

        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                          'file' => 'module_system_channel.php'
                                                    )
            );

        $ret = $this->templater->setOptions($templateInfo)
                               ->assign('channels', $channels)
                               ->render();
        //var_dump($ret);

        return $ret;
    }

    public function webMenu()
    {
        global $My_Kernel;

        if (empty($this->_params['menu_list_id'])) {
            return $ret;
        }

        $db = $My_Kernel->getSystemDbHandler();
        //$requerstInfo = $My_Kernel->getRequestTypeAndId();

        $my_menu = $My_Kernel->getClass('menu', $db);
        $menus = $my_menu->getMenusbyMenuListId((int)$this->_params['menu_list_id']);

        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                          'file' => 'module_system_menu.php'
                                                          )
              );

        $ret = $this->templater->setOptions($templateInfo)
                               ->assign('menus', $menus)
                               ->render();
        //var_dump($ret);

        return $ret;
    }

    public function webMenuAdmin ()
    {
        global $My_Kernel;

        $db = $My_Kernel->getSystemDbHandler();
        //$requerstInfo = $My_Kernel->getRequestTypeAndId();

        $my_menu = $My_Kernel->getClass('menu', $db);
        $menus = $my_menu->getMenusbyMenuListId((int)$this->_params['menu_list_id']);

        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                          'file' => 'module_system_menu.php'
                                                          )
              );

        $ret = $this->templater->setOptions($templateInfo)
                               ->addign('menuAdmin', $menuItems)
                               ->render();
    }

    public function  webLogin ()
    {
        global $My_Kernel;

        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                          'file' => 'module_system_login.php'
                                                    )
            );

        if (!count($_POST) && isset($_SERVER['HTTP_REFERER'])) {
            $backPage = $_SERVER['HTTP_REFERER'];
            $goBackDesc = '';
        } else {
            $backPage = MY_ROOT_URL;
            $goBackDesc = '';
        }

        $this->templater->assign('back_page', $backPage)
                        ->assign('go_back_desc', $goBackDesc);

        $ret = $this->templater->setOptions($templateInfo)->render();
        //var_dump($ret);

        return $ret;
    }

    public function userLogout ()
    {
        global $My_Kernel;

        $db = $My_Kernel->getSystemDbHandler();
        $My_Kernel->getClass('user', $db)->logout();

        return $ret = array('content_type' => 'URL',
                             'content'      => MY_ROOT_URL);
    }

    public function  webMedia ()
    {
        global $My_Kernel;

        $ret = NULL;

        if (!isset($this->_params['media_type'])) {
            return $ret;
        }

        switch (strtolower($this->_params['media_type'])) {
            case 'logo':
                $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                                  'file' => 'module_system_logo.php'
                                                                 )
                                                           );
                break;

            case 'banner':
                $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                                  'file' => 'module_system_banner.php'
                                                                 )
                                                           );
                break;

            default:
                break;
        }

        if ($templateInfo) {
            $ret = $this->templater->setOptions($templateInfo)->render();
        }

        return $ret;

    }

	/****************** END::method zone *************************/

}// END::class

/* EOF */
