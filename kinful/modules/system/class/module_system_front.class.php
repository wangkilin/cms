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

class My_System_Module extends module
{
	/****************** START::property zone *************************/
    /*
     * @var array
     * module information.(module id and module name)
     */
    protected $_moduleInfo;

    /*
     * @var object
     * The templater system is using
     */
    protected $templater;

    /*
     * @var array
     * parameters list
     */
    protected $_params = array();
    
    /*
     * @var array
     * The parameters which has main block
     */
    protected $_mainBlockParams = array('login', 'theme');


	/****************** END::property zone *************************/


	/****************** START::method zone *************************/
    public function __construct ($moduleInfo)
    {
        global $My_Kernel;
        parent::__construct($moduleInfo);

        $this->_moduleInfo = $moduleInfo;

        $this->templater = $My_Kernel->getTemplater ();
        $this->templater->clearAssign()
                        ->assign('module_id', $this->_moduleInfo['moduleId'])
                        ->assign('module_name', $this->_moduleInfo['moduleName'])
                        ->assign('MY_ROOT_URL', MY_ROOT_URL)
                       ;
    }

    public function setParams ($parameterExpressionString)
    {
        if (is_string($parameterExpressionString)) {
            $parameterList = explode (MY_PARAM_SEPARATOR, $parameterExpressionString);
            reset($parameterList);
            while (list(, $param) = each($parameterList)) {
                $paramInfo = explode('=', $param, 2);
                if ($paramInfo) {
                    $this->_params[$paramInfo[0]] = trim($paramInfo[1]);
                }
            }
        }

        return $this;
    }

    public function  returnWeb ()
    {
        //var_dump($this->_params);
        if(true === $this->_isFinalPage && !isset($this->_params['type']) 
            && isset($_REQUEST['type']) && in_array($_REQUEST['type'], $this->_mainBlockParams)) {
        	$this->_params['type'] = $_REQUEST['type'];
        }
        if (isset($this->_params['type'])) {
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

                case 'theme':
                    $ret = $this->webTheme();
                    break;

                default:
                    $ret = $this->goHomepage();
                    break;
            }
        } else {
            $ret = $this->goHomepage();
        }
        
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

    public function  webMedia ()
    {
        global $My_Kernel;

        $ret = NULL;

        if (!isset($this->_params['media_type'])) {
            return $ret;
        }
        $renderType = strtolower($this->_params['media_type']);

        switch ($renderType) {
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

            case 'flash_mp3':
                $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                                  'file' => 'module_system.php'
                                                                 )
                                                           );
                break;

            default:
                break;
        }

        if ($templateInfo) {
            $ret = $this->templater
                        ->setOptions($templateInfo)
                        ->assign('RENDER_TYPE', $renderType)
                        ->render();
        }

        return $ret;

    }

    public function  webTheme ()
    {
        global $My_Kernel;
        global $My_Lang;

        $ret = NULL;
        if(isset($_REQUEST['action'])) {
        	$this->_params['action'] = $_REQUEST['action'];
        }
        $renderType = isset($this->_params['action']) ? strtolower($this->_params['action']) : 'list';

        $db = $My_Kernel->getSystemDbHandler();
        if ('change'==$renderType) { // change front theme
            $themeId = $_REQUEST['themeId'];
            $themeInfo = $My_Kernel->getClass('theme', $db)->getThemeById($themeId);
            if($themeInfo) {
                $_SESSION['my_user']['front_theme'] = $themeInfo['theme_name'];
                $_SESSION['my_user']['theme_id'] = $themeId;
            }
            
            $ret = $this->goHomepage();
            
        } else { // list theme block
            $themeList = $My_Kernel->getClass('theme', $db)->getThemeList();
            $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'module',
                                                              'file' => 'module_system.php'
                                                         )
                                                   );
            $ret = $this->templater
                        ->setOptions($templateInfo)
                        ->assign('RENDER_TYPE', 'themeListTheme')
                        ->assign('themeList', $themeList)
                        ->assignByRef('lang', $My_Lang->module['system'])
                        ->assign('defaultThemeId', @$_SESSION['my_user']['theme_id'])
                        ->render();
        }

        return $ret;

    }

	/****************** END::method zone *************************/

}// END::class

/* EOF */
