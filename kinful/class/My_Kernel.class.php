<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : My_Kernel.class.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-1-10
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");

class My_Kernel
{
    /**
     *@array :    store class handler
     */
    protected $_classHandler = array();

    /**
     *@object :    template class handler
     */
    protected $_templater;

    /**
     *@array : store parametes with which to to find component and module
     */
    protected $_guideParams = array();

    /*
     * @var string Templater name
     */
    protected $_templaterName = 'smarty';

    /*
     * @var string what's tpye of client is using ( WAP, WEB, RSS) ?
     */
    protected $_clientType = MY_CLIENT_IS_WEB;

    protected $_systemDb;

    protected $_allowedClientType = array ('web', 'rss', 'wap');

    protected $_requestType = null;
    protected $_requestTypeId = 0;
    protected $_requestTypeValue = 0;

    /*
     * @var int
     * The final page id to be rendered
     */
    protected $_displayPageId = -1;


    /* @var array
     * the properties list, which is allowed to be set/get
     */
    protected $_allowToSee = array('requestType',
                                   'requestTypeId',
                                   'requestTypeValue',
                                   'templaterName');

    /*
     * @var string
     * The default theme name
     */
    protected $_defaultTheme = '';

    /**
     *@Description:    initialize system
     *
     *@return: void
     */
    public function __construct()
    {
        $this->_systemDb = & $this->getClass('database','default');

        $this->setClientType();// set wap or web browser. then we can output wml or html
        $this->_initConfig();// initialize global config
        $this->_initSession();// here we set where session will be stored at

    }//END::function initSystem

    /**
     * Set class property value.
     * If property exists, assign the value to it
     *
     * @param string $propertyName The property name existing in class
     * @param mixed  $value        New property value
     *
     * @return My_Kernel
     */
    public function set($propertyName, $value)
    {
        if (in_array("_$propertyName", $this->_allowToSee)) {
            $this->$propertyName = $value;
        }

        return $this;
    }

    /**
     * Get property
     * @param string The property label
     */
    public function get($propertyName)
    {
        $propertyName = "_$propertyName";
        if(in_array($propertyName, $this->_allowToSee)) {
            return $this->$propertyName;
        }

        return NULL;
    }


    /**
     * get system db handler
     *
     * @return object Db handler
     */
    public function getSystemDbHandler()
    {
        return $this->_systemDb;
    }

    /**
     * get request type and request type id
     *
     * @return array Request assiation: type and id
     */
    public function getRequestTypeAndId()
    {
        return array('type' => $this->_requestType,
                     'id'   => $this->_requestTypeId
                    );
    }

    /**
     *@Decription : initialize front page
     *
     *@Param : object    database handler
     *
     *@return: void
     */
    public function printPage()
    {
        global $_system;

        $this->_initUserSession();
        $positions = $this->getPositions();
        $this->_checkRequestType();
        //var_dump($this->_requestType, $this->_requestTypeId, $this->_requestTypeValue);

        if (MY_MODULE_REQUEST === $this->_requestType) {
            $yeMainBlock = $this->loadMainBlockContent($positions);
        } else {
            $yeMainBlock = '';
        }

        if (is_array($yeMainBlock) && isset($yeMainBlock['content_type'])) {
            switch ($yeMainBlock['content_type']) {
                case 'URL':
                    $this->redirect($yeMainBlock['content']);
                    return;
                    break;

                default:
                    break;
            }
        }

        /*
         * according to displayPageId, load theme info first,
         * then get page blocks
         */
        $themeInfo = $this->getTemplateInfo();

        $blocks = & $this->loadBlocks();
        $templater = $this->getTemplater($themeInfo);
        $templater->assign('MY_THEME_PATH', MY_ROOT_URL . 'themes/' . $this->_defaultTheme . '/');
        if (MY_MODULE_REQUEST === $this->_requestType) {
            $templater->assign('MY_MODULE_NAME', $this->_requestTypeValue);
        }
        $templater->assign('MY_REQUEST_TYPE', $this->_requestType);
        $templater->assign('site_config', $_system['config']);
        $templater->display($positions, $blocks, $yeMainBlock);
        //var_dump($this->_requestType, $this->_requestTypeId, $this->_requestTypeValue);
    }//END::function initFrontPage

    public function redirect($location)
    {
        if (!headers_sent()) {
            header('Location: ' . $location);
        } else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . $location . '";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
            echo '</noscript>';
        }
    }

    /**
     * get blocks for display page
     */
    public function & loadBlocks ()
    {
        $my_block = $this->getClass('block', $this->_systemDb);
        $blocks = $my_block->getPublicBlocks ($this->_displayPageId);
        //var_dump($blocks);

        $my_module = $this->getClass('module', $this->_systemDb);
        $my_module->loadBlocksContentIntoPosition ($blocks);

        return $blocks;
    }

    /**
     * get module main block
     */
    public function & loadMainBlockContent($positions)
    {
        $content = $this->getClass('module', $this->_systemDb)
                        ->getMainBlockContent ($this->_requestTypeId, $positions);
                        
        return $content;
    }

    public function getTemplater ($themeInfo=NULL)
    {
        $templater = $this->getClass('templater', $this->_templaterName, $themeInfo);

        return $templater;
    }

    public function getPlugin ()
    {
        $plugin = null;

        $argNum = func_num_args()-1;
        if ($argNum<0) {
            return $plugin;
        }
        $args = func_get_args();
        $pluginName = trim((string)array_shift($args));

        if(trim($pluginName)=='') {
            return $plugin;
        }
        $pluginFile = MY_ROOT_PATH . 'plugins/' . $pluginName . '/' . $pluginName . '.class.php';
        if (is_file($pluginFile)) {
            require_once($pluginFile);
            if (class_exists($pluginName)) {

                $params = '';
                for ($i=0; $i<$argNum; $i++) {
                    $params .= '$args[' . $i . '],';
                }
                $params =rtrim($params, ',');

                if (is_callable(array($pluginName, 'getInstance'))) {
                    $classCall = "$pluginName::getInstance";
                } else {
                    $classCall = "new $pluginName";
                }

                if (''===$params) {
                    $plugin = eval("return $classCall();");
                } else {
                    $plugin = eval("return $classCall($params);");
                }
            }
        }

        return $plugin;
    }

    public function getDedaultThemeName()
    {
        global $_system;

        if($this->_defaultTheme=='') {
            $this->_defaultTheme = isset($_SESSION['my_user'], $_SESSION['my_user']['theme'])
                     ? $_SESSION['my_user']['theme'] : $_system['config']['default_theme'];
        }

        return $this->_defaultTheme;
    }

    public function getTemplateInfo ($templateOptions=array())
    {
        global $_system;

        $templateFile = isset($templateOptions['file']) ? $templateOptions['file'] : 'index.php';

        $themeName = isset($_SESSION['my_user'], $_SESSION['my_user']['theme'])
                     ? $_SESSION['my_user']['theme'] : $_system['config']['default_theme'];

        if(''==$this->_defaultTheme) {
            $this->_defaultTheme = $themeName;
        }

        if(defined('MY_ADMIN_ROOT_PATH')) {
            $compileDir = MY_ADMIN_ROOT_PATH . 'compile_dir/' . $themeName;
            $templateDir = MY_ADMIN_ROOT_PATH . 'themes/' . $themeName;
        } else {
            $compileDir = MY_ROOT_PATH . 'compile_dir/' . $themeName;
            $templateDir = MY_ROOT_PATH . 'themes/' . $themeName;
        }
        $fileList = array($templateFile,
                              '../' . $_system['config']['default_theme'] . '/'. $templateFile,
                              '../kinful/' . $templateFile,
                              'index.php',
                              '../kinful/index.php'
        );

        if(isset($templateOptions['type'], $templateOptions['module']) && 'module'==$templateOptions['type']) {
        // module has its own template
            $templateDir = array(MY_ROOT_PATH . 'modules/' . $templateOptions['module'] .'/', $templateDir);
        }

        if(!is_array($templateDir)) {
            $templateDir = array($templateDir);
        }

        $findTemplate = false;
        while(list(, $templateFile)=each($fileList)) {
            reset($templateDir);
            while(list(, $_dir) = each($templateDir)) {
                $templateFilePath = $_dir . '/' . $templateFile;
                if(is_file($templateFilePath)) {
                    $findTemplate = true;
                    break;
                }
            }
            if($findTemplate) {
                break;
            } else {
                continue;
            }
        }


        return array('template'=>$templateFilePath, 'compile_dir'=>$compileDir);
    }

    /**
     * Reset request parameter
     */
    protected function _setRequest($requestOptions = array())
    {
        if(isset($requestOptions['page'])) {
            $_REQUEST['yepage'] = $requestOptions['page'];
        }

        if(isset($requestOptions['module'])) {
            $_REQUEST['yemodule'] = $requestOptions['module'];
        }

        return $this;
    }

    /**
     *@Decription : initialize parameters with which to find component and module
     *
     *@return: void
     */
    protected function _checkRequestType()
    {
        global $_system;

        $_page = isset($_REQUEST['yepage']) ? $_REQUEST['yepage'] : NULL;
        $_module = isset($_REQUEST['yemodule']) ? $_REQUEST['yemodule'] : NULL;
        $isRequestSet = false;

        if ($_module) {
            $my_module = & $this->getClass('module', $this->_systemDb);
            $moduleInfo = $my_module->getModuleByName ($_module);
            if (is_array($moduleInfo) && $moduleInfo['access_level'] <= $_SESSION['my_user']['rank']) {
                $this->_requestTypeValue = $_module;
                $this->_requestTypeId = $moduleInfo['module_id'];
                $this->_requestType = MY_MODULE_REQUEST;
                $this->_displayPageId = $moduleInfo['page_id'];

                $isRequestSet=true;
            }
        }

        if ($isRequestSet===false && $_page) {
            $my_page = & $this->getClass('page', $this->_systemDb);
            $pageInfo = $my_page->getPageByName ($_page);
            /* able to access, and the page shall not support main block,
             * only this situation, we think user is try to access channel page
             * or, we go to home page
             */
            if (is_array($pageInfo) && $pageInfo['show_level'] <= $_SESSION['my_user']['rank'] ) {
                $this->_requestTypeValue = $_page;
                $this->_displayPageId = $this->_requestTypeId = $pageInfo['page_id'];
                $this->_requestType = MY_PAGE_REQUEST;

                $isRequestSet=true;
            }
        }

        if ($isRequestSet===false) {
            $this->_requestType = MY_HOME_REQUEST;
            $this->_requestTypeId = 0;
            $this->_requestTypeValue = 0;
            $this->_displayPageId = 0;
        }
        $_SESSION['sess'] = array('request_type'=>$this->_requestType, 'request_type_id'=>$this->_requestTypeId);

        return;
    }//END::function _checkRequestType

    /**
     *@Decription : get position information
     *
     *@Param : DB handler
     *
     *@return:
     */
    public function & getPositions()
    {
        global $_system;

        $positionClass = & $this->getClass('position', $this->_systemDb);
        $_system['positions'] = $positionClass->getPositions();

        return $_system['positions'];
    }//END::function _loadPosition

    /**
     *@Decription : get user language specified
     *
     *@return: book
     */
    public function getUserLang()
    {
        global $_system;
        $_langCode = isset($_SESSION['my_user']['language'])?$_SESSION['my_user']['language']:((isset($_system)&&isset($_system['config']['default_language']))?$_system['config']['default_language']:MY_DEFAULT_LANGUAGE);

        return $_langCode;

    }//END::function getUserLang

    /**
     *@Decription : load language file
     *
     *@Param : string    {class; page}
     *
     *@return: void
     */
    public function loadLanguage($type, $fileName)
    {
        global $_system;
        global $My_Lang;
        switch(strtolower($type)) {
            case 'module': // module has its own language file
                $refPath = MY_ROOT_PATH . 'modules/' . $fileName . '/language/';
                $type = '.';
                break;

            default:
                $refPath = MY_ROOT_PATH . 'language/';

                break;
        }
        if(isset($_SESSION['my_user']['language']) && file_exists(($langFile=$refPath . $_SESSION['my_user']['language'] . "/$type/$fileName.lang.php"))) {
            include_once($langFile);
            $langFile .= 'session';
        } elseif(isset($_system)&&isset($_system['config']['default_language']) && file_exists(($langFile=$refPath . "{$_system['config']['default_language']}/$type/$fileName.lang.php"))) {
            include_once($langFile);
            $langFile .= 'module';
        } elseif (is_file(($langFile = $refPath . MY_DEFAULT_LANGUAGE. "/$type/$fileName.lang.php"))) {
            include_once($langFile);
            $langFile .= 'defualt';
        } else {
            //$langFile = '----------------' . $type . $fileName;
        }
        //echo $langFile . '<br>';
    }//END::function loadLanguage

    public function loadLang ($type, $fileName)
    {
        self::loadLanguage ($type, $fileName);
    }

    /**
     *@Description: set client type(WAP, WEB, RSS) that user is using. then set global variable $my_client_type
     *
     *@return: void
     */
    protected function setClientType ()
    {
        global $my_client_type;

        $clientType = 'web';

        if (in_array($clientType, $this->_allowedClientType)) {
            $this->_clientType = $clientType;
        }
        $my_client_type = & $this->_clientType;

        return $this;

    }//END::function _checkWapAgent

    /**
     *@Description:    initialize config
     *
     *@return: void
     */
    protected function _initConfig()
    {//load config setting
        global $My_Kernel;

        if ( MY_CONFIG_IN_FILE && file_exists(MY_ROOT_PATH . 'config/my_config.ini.php') ) {
        // configure in file OR first access OR configure just changed
            include_once(MY_ROOT_PATH . 'config/my_config.ini.php');
        } elseif(isset($_system['config'])) {
            unset($_system['config']);
        }

        if(! isset($_system['config']) || ! MY_CONFIG_IN_FILE) {
        //config has not pick out from database
            $query_config="select conf_name, conf_value from #._config";
            $this->_systemDb->query($query_config);

            while($row=$this->_systemDb->fetchRow()) {
                list($conf_name, $conf_value) = $row;
                $_system['config']["$conf_name"] = $conf_value;
            }

            if(MY_CONFIG_IN_FILE) {
                $sess_conf_str = "";
                foreach($_system['config'] as $conf_key => $conf_value) {
                    $sess_conf_str .= sprintf("%-50s",'$_system["config"]["'.$conf_key.'"]')."=\t \"$conf_value\";\n";
                }
                $this->_createConfigFile("my_config.ini.php", $sess_conf_str);
                //echo $my_file->getError();
            }
        }

        $GLOBALS['_system'] = &$_system;
    }//END::function _initConfig

    /**
     *@Description:    initialize session
     *
     *@return: void
     */
    protected function _initSession()
    {//Load SESSION
        if(MY_SESSION_METHOD == MY_SESSION_IN_DB) {
        //session stored in database
            $this->getClass('session',$this->_systemDb, intval($GLOBALS['_system']['config']['session_cache_expire']));
        }

        session_start();

    }//END::function _initSession

    /**
     *@Description:    initialize user session
     *
     *@return: void
     */
    protected function _initUserSession($userInfo = array())
    {
        if(!isset($_SESSION['my_user'])) {
            $userClass = $this->getClass('user', $this->_systemDb);
            $userInfo = $userClass->getUserByName('guest', true);
            if($userInfo['theme']) {
                $themeInfo = $this->getClass('theme', $this->_systemDb)
                                       ->getThemeById($userInfo['theme']);
                $userInfo['front_theme'] = $themeInfo['theme_name'];
            } else {
                $userInfo['front_theme'] = $GLOBALS['_system']['config']['default_theme'];
            }
        }
        //$_SESSION['my_user']['theme'] = 'cloth_purple';

        if(is_array($userInfo) && count($userInfo)>8) {
            $_SESSION['my_user'] = $userInfo;
        }
        $_SESSION['my_user']['theme'] = $_SESSION['my_user']['front_theme'];
    }//END::function _initUser

    /**
     *@Decription : initialize menus
     *
     *@Param : $object    db handler
     *
     *@return: void
     */
    protected function _initMenu($db)
    {
        $menuClass = $this->getClass('menu',$db);
        $menuClass->loadAllMenus();
        global $_system;
        if($_system['config']['menu_in_file'])
        {//we need to write menu information into file
            $_from_db = true;
            $menu_file = '';//store content

            while((list($position_id,$_positionInfo) = each ($_system['menu'])) && $_from_db===true)
            {
                while((list($parent_id,$_parentInfo) = each($_positionInfo)) && $_from_db===true)
                {
                    while((list($order_id,$menuInfo) = each($_parentInfo)) && $_from_db===true)
                    {
                        if($menuInfo['from_db'] === true)
                            $menu_file .=  sprintf("%-45s",'$_system["menu"]['.$position_id.']['.$parent_id.']['.$order_id."]")."=\t array('menu_id'=>".$menuInfo['menu_id'].",
                                                'menu_name'=>'".$menuInfo['menu_name']."',
                                                'menu_link'=>".$menuInfo['menu_link'].",
                                                'show_link'=>".$menuInfo['show_link'].",
                                                'show_page'=>".$menuInfo['show_page'].",
                                                'show_in_com'=>array(".join(',', $menuInfo['show_in_com'])."),
                                                'show_in_mod'=>array(".join(',', $menuInfo['show_in_mod'])."),
                                                'show_level'=>".$menuInfo['show_level'].",
                                                'from_db'=>false);\n";
                        else
                            $_from_db = false;
                    }
                }
            }
            if($_from_db ===true)
            {
                $this->_createConfigFile("my_menu.ini.php", $menu_file);
            }
        }
    }//END::function _initMenu

    /**
     *@Decription : load blocks for the request
     *
     *@param string $requestType request type
     *@param int    $requestTypeId The request type id
     *
     *@return: void
     /
    public function loadBlocks ($requestType, $requestTypeId)
    {
        global $_system, $MY_LAYOUT;

        if(count($_system['block']))
        {
            foreach($_system['block'] as $positionId=>$positionBlock)
            {
                $tmpMenuArray = array();//to store menus
                while(list(,$blockInfo) = each($positionBlock))
                {
                    if($_mid ===0 && $_cid===0 && $blockInfo['show_page']>1)//this is home page, we show the home page blocks and those blocks can be show everywhere.
                    {
                        continue;
                    }
                    if(($_mid>0 || $_cid>0) && $blockInfo['show_page']==0)//these blocks only show on home page
                    {
                        continue;
                    }

                    My_Kernel::loadLanguage(1, $_system["component"] ["{$_system['module'] ["{$blockInfo['module_id']}"] ['comp_id']}"] ['comp_name']);
                    if(($_mid>0 || $_cid>0) && $blockInfo['show_page']>1 && !in_array($_mid,$blockInfo['show_in_mod']) && !in_array($_cid,$blockInfo['show_in_com']))// these blocks only show on specified pages
                        continue;

                    $_tmp_mid = $blockInfo['module_id'];
                    $_tmp_cid = $_system['module']["$_tmp_mid"]['comp_id'];
                    $_c_class = $_system['component']["$_tmp_cid"]['comp_name'];

                    if(file_exists(MY_ROOT_PATH."components/".$_system['module']["$_tmp_mid"]['dir_name']."/".$_system['module']["$_tmp_mid"]['inter_file']))// interface file exists
                    {
                        include_once(MY_ROOT_PATH."components/".$_system['module']["$_tmp_mid"]['dir_name']."/".$_system['module']["$_tmp_mid"]['inter_file']);
                        if($_system['module']["$_tmp_mid"]['inter_function']!='' && method_exists($_c_class,$_system['module']["$_tmp_mid"]['inter_function']))
                        {
                            $_params = explode('&',$blockInfo['params']);
                            if(count($_params))
                            {
                                $param = array();
                                foreach($_params as $_param)
                                {
                                    $_param = explode('=',$_param);
                                    $param[$_param[0]] = $_param[1];
                                }
                            }

                            $_inter_function = $_system['module']["$_tmp_mid"]['inter_function'];
                            //load database handler component need
                            $db_type =     $_system['component']["$_tmp_cid"]['db_type'];
                            $db_num =     $_system['component']["$_tmp_cid"]['db_num'];
                            $db_api = $this->getComponentDbApi($db_type, $db_num);
                            eval("\$_return = $_c_class::$_inter_function(\$db_api, \$_tmp_cid, \$_tmp_mid, \$param);");

                            $_positionName = $_system["position"]["{$blockInfo['position_id']}"]["position_name"];
                            $MY_LAYOUT[$_positionName][$blockInfo['order']] = array($_return, $blockInfo['show_link'], $blockInfo['block_name'], 1);
                            //echo "$_c_class::$_inter_function()";
                        }//if
                    }//if
                }//while
            }
        }
    }//END::function _setBlocksByModuleId*/

    /**
     *@Description: initialize Blocks
     *
     *@Param : object    database handler
     *
     *@return: boolean
     */
    protected function _initBlock(&$db)
    {
        global $My_Kernel;
        global $_params;
        $blockClass = $this->getClass('block',$db);
        $blockClass->loadAllBlocks();
        global $_system;
        if(isset($_system['component']) && isset($_system['module']) && isset($_system['block']))
        {
            if(!empty($_system['config']['component_in_file']) && (list($compId,$compInfo) = each($_system['component'])) && $compInfo['from_db'] === true)
            {//we need write component information into config file
                $_tmpCompFile = '';
                foreach($_system['component'] as $compId=>$compInfo)
                {
                    $_tmpCompFile .= sprintf("%-35s",'$_system["component"]["'.$compId.'"]')."=\t array(
                                        'comp_name'=>'".$compInfo['comp_name']."',
                                        'inter_file'=>'".$compInfo['inter_file']."',
                                        'inter_function'=>'".$compInfo['inter_function']."',
                                        'db_type'=>".$compInfo['db_type'].",
                                        'dir_name'=>'".$compInfo['dir_name']."',
                                        'access_level'=>".$compInfo['access_level'].",
                                        'from_db'=>false
                                    );\t// ".$compInfo['desc']."\n";
                }
                $this->_createConfigFile("my_component.ini.php", $_tmpCompFile);
            }

            if(!empty($_system['config']['module_in_file']) && (list($moduleId,$moduleInfo) = each($_system['module'])) && $moduleInfo['from_db'] === true)
            {//we need write module information into config file
                $_tmpModuleFile = '';
                foreach($_system['module'] as $moduleId=>$moduleInfo)
                {
                    /***** start module zone *****/
                    $inter_file = $moduleInfo['inter_file']?$moduleInfo['inter_file']:$_system['component']["{$moduleInfo['comp_id']}"]['inter_file'];
                    $_tmpModuleFile .= sprintf("%-30s",'$_system["module"]["'.$moduleId.'"]')."=\t array(
                                        'module_name'=>'".$moduleInfo['module_name']."',
                                        'db_type'=>".$moduleInfo['db_type'].",
                                        'dir_name'=>'".$moduleInfo['dir_name']."',
                                        'inter_file'=>'".$moduleInfo['inter_file']."',
                                        'inter_function'=>'".$moduleInfo['inter_function']."',
                                        'access_level'=>".$moduleInfo['access_level'].",
                                        'comp_id'=>".$moduleInfo['comp_id'].",
                                        'from_db'=>false
                                    );\t//".$moduleInfo['desc']."\n";
                    /***** end module zone *****/
                }
                $this->_createConfigFile("my_module.ini.php", $_tmpModuleFile);
            }
            if(!empty($_system['config']['block_in_file']) && (list(,$_positionInfo)=each($_system['block'])) && (list(,$blockInfo)=$_positionInfo) )
            {//we need write block information into config file
                $_tmpBlockFile = '';
                foreach($_system['block'] as $positionId=>$positionBlock)
                {
                    while(list(,$blockInfo) = each($positionBlock))
                    {
                        $_tmpBlockFile .= sprintf("%-30s","\$_system['block'][\"$positionId\"][]"). "=    array(
                                        'block_id'=>".$blockInfo['block_id'].",
                                        'parent_id'=>".$blockInfo['parent_id'].",
                                        'position_id'=>".$blockInfo['position_id'].",
                                        'block_name'=>\"".$blockInfo['block_name']."\",
                                        'module_id'=>".$blockInfo['module_id'].",
                                        'order'=>".$blockInfo['order'].",
                                        'params'=>\"".$blockInfo['params']."\",
                                        'block_link'=>\"".$blockInfo['block_link']."\",
                                        'show_link'=>".$blockInfo['show_link'].",
                                        'type'=>".$blockInfo['type'].",
                                        'show_page'=>".$blockInfo['show_page'].",
                                        'show_in_com'=>array(".join(',',$blockInfo['show_in_com'])."),
                                        'show_in_mod'=>array(".join(',',$blockInfo['show_in_mod'])."),
                                        'show_level'=>".$blockInfo['show_level'].",
                                        'from_db'=>false
                                    );\n";
                    }//End while
                }//End foreach
                $this->_createConfigFile("my_block.ini.php", $_tmpBlockFile);
            }
            return true;
        }
        else
            return false;
    }//END::function _initBlock

    /**
     *@getClassHandle will get the specify class handle
     *
     *@Param : string    class name
     *@Param : any        will be contractor parameter/s
     *
     *@return: class handle or false
     */
    public function getClass()
    {
        global $My_Sql;

        $argNum = func_num_args();
        if (--$argNum<1) {
            return NULL;
        }
        $args = func_get_args();
        $className = trim(array_shift($args));
        if(trim($className)=='') {
            return NULL;
        }

        $className = 'My_' . ucfirst(strtolower($className));

        if(is_file(MY_ROOT_PATH . "SQL/$className.sql.php")) {
            require_once(MY_ROOT_PATH . "SQL/$className.sql.php");
        }
        $classFile = MY_ROOT_PATH . "class/$className.class.php";
        if(!is_file($classFile)) {
        // class file not exists
            return NULL;
        }

        include_once($classFile);
        if (!class_exists($className)) {
        // class not exists in class file
            return NULL;
        }

        $params = '';
        for ($i=0; $i<$argNum; $i++) {
            $params .= '$args[' . $i . '],';
        }
        $params =rtrim($params, ',');

        if (is_callable(array($className, 'getInstance'))) {
            $classCall = "$className::getInstance";
        } else {
            $classCall = "new $className";
        }

        if (''===$params) {
            return eval("return $classCall();");
        } else {
            return eval("return $classCall($params);");
        }
    }// END::function getClass

    /**
     *@Decription : get theme path
     *
     *@Param : int    theme id
     *
     *@return: string
     */
    public function getThemePath($themeId)
    {
        $select_theme = "select * from #._theme where theme_id = $themeId";
        $this->_systemDb->query($select_theme);
        if($row = $db->fetchArray())
        {
            if($row['theme_path'])
                return $row['theme_path'];
            else
                return $row['theme_name'];
        }
        return '';
    }//END::function _getThemePath

    /**
     *@recall class constructor
     *
     *@Param : string    class name
     *
     *@return: constructor name
     */
    protected function _getConstructor($className)
    {
            return "MY_$className";
    }// END::function loadClass

    /**
     *@Description : generate class method error
     *
     *@return : string
     */
    public function createClassError($errorDescription='')
    {
        return __CLASS__."->".__FUNCTION__."() :: $errorDescription ! ";
    }//END::function createClassError

    /**
     *@Decription : encrypt string
     *
     *@Param : string    the string content will be encrypt
     *@Param : string    the function name with which encrpyts string
     *
     *@return: string
     */
    public function encryptString($string, $encryptMethod='md5')
    {
        if(function_exists($encryptMethod))
        {
            $retString = $encryptMethod($string);
            return $retString;
        }
        return $string;
    }//END::function encryptString

    /**
     *@Decription : create query string from GET parameters and user assigned
     *
     *@Param : array    parameters user assigned
     *
     *@return: string
     */
    public function getQueryString($params)
    {
        $ret = 'yepage='.$this->_guideParams['yepage']."&yemodule=".$this->_guideParams['yemodule'];

        foreach($params as $key=>$value)
        {
            $ret .= "&$key=$value";
        }
        return $ret;

    }//END::function getQueryString

}// END::class My_Kernel

class My_Lang
{//store language item
}//END::class MY_lang
global $My_Lang;
$My_Lang=new My_Lang;
?>
