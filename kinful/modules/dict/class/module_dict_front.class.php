<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : module_media_front.class.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2010-7-23
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die('forbidden');

require_once(dirname(__FILE__) . '/My_Dict.class.php');
require_once(MY_ROOT_PATH . 'modules/abstract.php');

class My_Media_Module extends module
{
	/****************** START::property zone *************************/


    /*
     * @var object Dict class instance
     */
    protected $_dictModel;


	/****************** END::property zone *************************/


	/****************** START::method zone *************************/
    /**
     * constructor
     */
    public function __construct($moduleInfo)
    {
        global $My_Kernel, $My_Sql;

        parent::__construct($moduleInfo);
        //$this->_dictModel = $My_Kernel->getClass('dict', $My_Kernel->getSystemDbHandler());
        $this->_loadModel($My_Kernel->getSystemDbHandler());
    }
    protected function _loadModel($db)
    {
        $this->_dictModel = new My_Dict($db);
    }

    public function  returnWeb ()
    {
        //var_dump($this->_params,$this->_isFinalPage);
        $ret = '';
        if (isset($this->_params['type'])) {// show block
            switch (strtolower($this->_params['type'])) {
                case 'dict': // show specified dict
                    $ret = $this->displayDict();
                    break;

                default: // show specified dict categories
                    $ret = $this->displayCategory();
                    break;
            }

        } else if($this->_isFinalPage) {// show main content
            if(isset($_REQUEST['dict_id'])) {
                $ret = $this->setParams('dict_id=' . $_REQUEST['dict_id'])
                            ->displayDict();
            } else {
                if(isset($_REQUEST['category_id'])) {
                    $this->setParams('category_id=' . $_REQUEST['category_id']);
                }
                $ret = $this->displayCategory();
            }
        }

        return $ret;
    }

    public function displayDict($options = array())
    {
        global $My_Kernel;

        if(is_array($options)) {
            $this->_params = array_merge($this->_params, $options);
        }

        $options = array(
            'showTitle'   => true,
            'showCreateTime'   => true,
            'showCreateUser'   => true,
            'showReferenceUrl' => true,
            'showFullText'     => true
        );
        $dictList = NULL;
        $action = 'showDict';
        if(isset($this->_params['dict_id'])) {
            if($dict = $this->_dictModel->getDictById($this->_params['dict_id'])) {
                $dictList = array($dict);
            };
        } else if (isset($this->_params['dict_ids'])) {
            $dictList = $this->_dictModel->getDictByIds($this->_params['dict_ids']);
        } else if (isset($this->_params['dictType'])) {
            $options = array(
                    'showCreateTime'   => true,
                    'showCreateUser'   => false,
                    'showReferenceUrl' => false,
                    'showFullText'     => false
            );
            switch($this->_params['dictType']) {
                case 'latest':
                    $randomLimit = isset($this->_params['showItemsCount']) ? $this->_params['showItemsCount'] : 5;
                    $dictList = $this->_dictModel->getLatestDict($randomLimit);
                    break;

                case 'random':
                default:
                    $categoryId = isset($this->_params['category_id']) ? intval($this->_params['category_id']) : NULL;
                    $randomLimit = isset($this->_params['showItemsCount']) ? $this->_params['showItemsCount'] : 1;
                    $dictList = $this->_dictModel->getRandomDict($randomLimit, $categoryId);
                    $options['showCreateTime'] = false;
                    $options['showFullText'] = false;
                    $options['showTitle'] = true;
                    $options['showIntroText'] = true;

                    break;
            }
            $action = 'showDictList';
        } else if(! $this->_isFinalPage) {
            if(isset($_REQUEST['dict_id'])) {
                $dict = $this->_dictModel->getDictById($_REQUEST['dict_id']);
                $_categoryId = $dict['category_id'];
                $dictList = $this->_dictModel->getDictByCategoryId($_categoryId);
                $options = array(
                'showCreateTime'   => false,
                'showCreateUser'   => false,
                'showReferenceUrl' => false,
                'showFullText'     => false
                );
                $action = 'showDictList';
            } else if(!empty($_REQUEST['category_id'])) {
                $_categoryId = $_REQUEST['category_id'];
                $dictList = $this->_dictModel->getDictCategories();
                $action = 'showDictCategories';
            } else {
                $dictList = $this->_dictModel->getRandomDict(5);
                $options = array(
                'showCreateTime'   => false,
                'showCreateUser'   => false,
                'showReferenceUrl' => false,
                'showFullText'     => false
                );
                $action = 'showDictList';
            }
        }

        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                          'file' => 'module_dict.php'
                                                    )
            );
        if(is_array($dictList)) {
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
                                                   'dictList'        => $dictList,
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

        if(isset($_REQUEST['category_id'])) {
            $items = $this->_dictModel->getDictByCategoryId($_REQUEST['category_id']);
            $totalNumber = $this->_dictModel->countDictByCategoryId($_REQUEST['category_id']);
            $listKeys = array(array('key' => '<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&dict_id=%d" >%s</a>',
                                'value' => array('dict_id', 'title')),
                    );
        } else {
            $items = $this->_dictModel->getDictCategories();
            $totalNumber = $this->_dictModel->countCategory();
            $listKeys = array(array('key' => '<a href="?yemodule='.$this->_moduleInfo['moduleName'].'&category_id=%d" >%s</a>',
                                'value' => array('category_id', 'title')),
                    );
        }

        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                          'file' => 'module_dict.php'
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
        $pageLink = '?yemodule='.$this->_moduleInfo['moduleName'].'';
        $itemsHTML = $My_listItemsInTpl
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
                                                   'dict_categories' => $itemsHTML,
                                                   'page_admin_title' => $this->lang['dict_category_admin_title']
                                             )
                                           )
                               ->render();

        return $ret;
    }

	/****************** END::method zone *************************/

}// END::class

/* EOF */
