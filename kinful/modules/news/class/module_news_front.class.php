<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : modules/news/class/module_news_front.class.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2010-7-23
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die('forbidden');

require_once(dirname(__FILE__) . '/My_News.class.php');
require_once(MY_ROOT_PATH . 'modules/abstract.php');

class My_News_Module extends module
{
	/****************** START::property zone *************************/


    /*
     * @var object News class instance
     */
    protected $_newsModel;


	/****************** END::property zone *************************/


	/****************** START::method zone *************************/
    /**
     * constructor
     */
    public function __construct($moduleInfo)
    {
        global $My_Kernel, $My_Sql;

        parent::__construct($moduleInfo);
        //$this->_newsModel = $My_Kernel->getClass('news', $My_Kernel->getSystemDbHandler());
        $this->_loadModel($My_Kernel->getSystemDbHandler());
    }
    protected function _loadModel($db)
    {
        $this->_newsModel = new My_News($db);
    }

    public function  returnWeb ()
    {
        //var_dump($this->_params,$this->_isFinalPage);
        $ret = '';
        if (isset($this->_params['type'])) {// show block
            switch (strtolower($this->_params['type'])) {
                case 'news': // show specified news
                    $ret = $this->displayNews();
                    break;

                default: // show specified news categories
                    $ret = $this->displayCategory();
                    break;
            }

        } else if($this->_isFinalPage) {// show main content
            if(isset($_REQUEST['news_id'])) {
                $ret = $this->setParams('news_id=' . $_REQUEST['news_id'])
                            ->displayNews();
            } else {
                if(isset($_REQUEST['category_id'])) {
                    $this->setParams('category_id=' . $_REQUEST['category_id']);
                }
                $ret = $this->displayCategory();
            }
        }

        return $ret;
    }

    public function displayNews($options = array())
    {
        global $My_Kernel;

        if(is_array($options)) {
            $this->_params = array_merge($this->_params, $options);
        }

        $categoryInfo = NULL;

        $options = array(
            'showTitle'   => true,
            'showCreateTime'   => true,
            'showCreateUser'   => true,
            'showReferenceUrl' => true,
            'showFullText'     => true
        );
        $newsList = NULL;
        $action = 'showNews';
        if(isset($this->_params['news_id'])) {
            if($news = $this->_newsModel->getNewsById($this->_params['news_id'])) {
                $newsList = array($news);
                $categoryInfo = $this->_isFinalPage ? null : $this->_newsModel->getCategoryById($news['category_id']);
            };
        } else if (isset($this->_params['news_ids'])) {
            $newsList = $this->_newsModel->getNewsByIds($this->_params['news_ids']);
        } else if (isset($this->_params['newsType'])) {
            $options = array(
                    'showCreateTime'   => true,
                    'showCreateUser'   => false,
                    'showReferenceUrl' => false,
                    'showFullText'     => false
            );
            switch($this->_params['newsType']) {
                case 'latest':
                    $randomLimit = isset($this->_params['showItemsCount']) ? $this->_params['showItemsCount'] : 5;
                    $newsList = $this->_newsModel->getLatestNews($randomLimit);
                    break;

                case 'random':
                default:
                    $categoryId = isset($this->_params['category_id']) ? intval($this->_params['category_id']) : NULL;
                    $randomLimit = isset($this->_params['showItemsCount']) ? $this->_params['showItemsCount'] : 1;
                    $newsList = $this->_newsModel->getRandomNews($randomLimit, $categoryId);
                    $options['showCreateTime'] = false;
                    $options['showFullText'] = false;
                    $options['showTitle'] = true;
                    $options['showIntroText'] = true;

                    break;
            }
            $action = 'showNewsList';
        } else if(! $this->_isFinalPage) {
            if(isset($_REQUEST['news_id'])) {
                $news = $this->_newsModel->getNewsById($_REQUEST['news_id']);
                $_categoryId = $news['category_id'];
                $categoryInfo = $this->_newsModel->getCategoryById($_categoryId);
                $newsList = $this->_newsModel->getNewsByCategoryId($_categoryId);
                $options = array(
                'showCreateTime'   => false,
                'showCreateUser'   => false,
                'showReferenceUrl' => false,
                'showFullText'     => false
                );
                $action = 'showNewsList';
            } else if(!empty($_REQUEST['category_id'])) {
                $_categoryId = $_REQUEST['category_id'];
                $categoryInfo = $this->_newsModel->getCategoryById($_categoryId);
                $newsList = $this->_newsModel->getNewsCategories();
                $action = 'showNewsCategories';
            } else {
                $newsList = $this->_newsModel->getRandomNews(5);
                $options = array(
                'showCreateTime'   => false,
                'showCreateUser'   => false,
                'showReferenceUrl' => false,
                'showFullText'     => false
                );
                $action = 'showNewsList';
            }
        }
        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                          'module' => $this->_moduleInfo['moduleName'],
                                                          'file' => 'news.tpl.php'
                                                    )
            );
        if(is_array($newsList)) {
            if(isset($this->_params['length'])) {
                $options['length'] = intval($this->_params['length']);
            }
            if(isset($this->_params['showCreateTime'])) {
                $options['showCreateTime'] = settype($this->_params['showCreateTime'], 'bool');
            }
            if(isset($this->_params['showCreateUser'])) {
                $options['showCreateUser'] = settype($this->_params['showCreateUser'], 'bool');
            }
            if(isset($this->_params['showModifyTime'])) {
                $options['showModifyTime'] = settype($this->_params['showModifyTime'], 'bool');
            }
            if(isset($this->_params['showModifyUser'])) {
                $options['showModifyUser'] = settype($this->_params['showModifyUser'], 'bool');
            }
            if(isset($this->_params['showReferenceUrl'])) {
                $options['showReferenceUrl'] = settype($this->_params['showReferenceUrl'], 'bool');
            }
            if(isset($this->_params['showIntroText'])) {
                $options['showIntroText'] = settype($this->_params['showIntroText'], 'bool');
            }
            if(isset($this->_params['showFullText'])) {
                $options['showFullText'] = settype($this->_params['showFullText'], 'bool');
            }
        }

        $ret = $this->templater->setOptions($templateInfo)
                               ->assignList( array('action'          => $action,
                                                   'newsList'        => $newsList,
                                                   'category_info'   => $categoryInfo,
                                                   'options'         => $options,
                                                   'lang'            => $this->lang
                                             )
                                           )
                               ->render();

        return $ret;
    }

    public function displayCategory($options=array())
    {
        global $My_Kernel;

        if(is_array($options)) {
            $this->_params = array_merge($this->_params, $options);
        }

        $categoryInfo = NULL;

        if(isset($_REQUEST['category_id'])) {
            $categoryInfo = $this->_isFinalPage ? null : $this->_newsModel->getCategoryById($_REQUEST['category_id']);
            $items = $this->_newsModel->getNewsByCategoryId($_REQUEST['category_id']);
            $totalNumber = $this->_newsModel->countNewsByCategoryId($_REQUEST['category_id']);
            $listKeys = array(array('key' => '<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&news_id=%d" >%s</a>',
                                'value' => array('news_id', 'title')),
                    );
        } else {
            $items = $this->_newsModel->getNewsCategories();
            $totalNumber = $this->_newsModel->countCategory();
            $listKeys = array(array('key' => '<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&category_id=%d" >%s</a>',
                                'value' => array('category_id', 'title')),
                    );
        }

        $templateInfo = $My_Kernel->getTemplateInfo(array('type'   => 'module',
                                                          'module' => $this->_moduleInfo['moduleName'],
                                                          'file'   => 'news.tpl.php'
                                                    )
            );

        // prepare
        $My_listItemsInTpl = $My_Kernel->getPlugin('My_ListItemsInTpl');
        $pageList = $My_listItemsInTpl->get('numberListPerPage');
        $numberPerPageIndex = isset($_GET['number_per_page'], $pageList[(int)$_GET['number_per_page']]) ? (int)$_GET['number_per_page'] : 0;
        $numberPerPage = $pageList[$numberPerPageIndex];
        $totalPage = ceil($totalNumber/$numberPerPage);
        $currentPage = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
        $currentPage = $currentPage > $totalPage ? $totalPage : $currentPage;

        $itemHeader = $itemMenu = array();
        $pageLink   = '?yemodule='.$this->_moduleInfo['moduleName'].'';
        $itemsHTML  = $My_listItemsInTpl
                           ->setOptions(array('itemHeader'=>$itemHeader,
                                        'listKeys'=>$listKeys,
                                        'pageLink'=>$pageLink,
                                        'itemMenu'=>$itemMenu,
                                        'totalItemNumber' =>$totalNumber,
                                        'currentPage' =>$currentPage,
                                        'numberPerPageIndex' =>$numberPerPageIndex
                                        )
                             )
                           ->listItemsInTpl ($items)
            ;

        $ret = $this->templater->setOptions($templateInfo)
                               ->assignList( array('action'          => 'listCategory',
                                                   'category_info'   => $categoryInfo,
                                                   'news_categories' => $itemsHTML,
                                                   'page_admin_title'=> $this->lang['news_category_admin_title']
                                             )
                                           )
                               ->render();

        return $ret;
    }

	/****************** END::method zone *************************/

}// END::class

/* EOF */
