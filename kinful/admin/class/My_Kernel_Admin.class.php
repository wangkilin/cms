<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_kernel_admin.class.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-1-10
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");

require_once (MY_ROOT_PATH . 'class/My_Kernel.class.php');

class My_Kernel_Admin extends My_Kernel
{

    /**
     *@Description:    initialize user session
     *
     *@return: void
     */
    protected function _initUserSession($userInfo = array())
    {
        if(isset($_POST['user_name'], $_POST['user_password'], $_REQUEST['admin'], $_REQUEST['yemodule'])
          && 'login'==$_REQUEST['admin'] && 'system'==$_REQUEST['yemodule']) {
            $my_user = $this->getClass('user', $this->_systemDb);
            $checkLogin = $my_user->login($_POST['user_name'], $_POST['user_password']);
            //var_dump($_SESSION);
            //exit;
        }

        if(!isset($checkLogin) || $checkLogin>0) {
            parent::_initUserSession();
        }
        $_SESSION['my_user']['theme'] = isset($_SESSION['my_user']['admin_theme']) ?
                                            $_SESSION['my_user']['admin_theme'] : 'kinful';
        if(intval($_SESSION['my_user']['system_user'])<1 && intval($_SESSION['my_user']['super_admin'])<1) {
            //$this->_setRequest(array('page'=>'login', 'module'=>''));
            //session_destroy();
            $this->redirect(MY_ROOT_URL . 'login.html');
            exit;
        }

        return $this;
    }//END::function _initUser


    /**
     *@Description:    initialize config
     *
     *@return: void
     */
    protected function _initConfig()
    {//load config setting
        global $My_Kernel;

        if ( MY_CONFIG_IN_FILE && file_exists(MY_ROOT_PATH."config/my_config.ini.php") ) {
        // configure in file OR first access OR configure just changed
            include_once(MY_ROOT_PATH."config/my_config.ini.php");
        }
        elseif(isset($_system['config'])) {
            unset($_system['config']);
        }

        if(!isset($_system['config']) || !MY_CONFIG_IN_FILE) {
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

        $_className = 'My_' . ucfirst(strtolower($className)) . '_Admin';
        $classFile = MY_ADMIN_ROOT_PATH . "class/$_className.class.php";
        $sqlAdminFile = MY_ADMIN_ROOT_PATH . 'SQL/' . $_className . '.sql.php';
        $sqlFile = MY_ROOT_PATH . 'SQL/My_' . ucfirst(strtolower($className)) . '.sql.php';

        if(is_file($sqlFile)) {
            include($sqlFile);
        }

        if(is_file($sqlAdminFile)) {
            include($sqlAdminFile);
        }

        if(!is_file($classFile)) {
        // class file not exists
            $_className = 'My_' . ucfirst(strtolower($className));
            $classFile = MY_ROOT_PATH . "class/$_className.class.php";

            if (! is_file($classFile)) {
                return NULL;
            }
        }

        include_once($classFile);
        if (!class_exists($_className)) {
        // class not exists in class file
            return NULL;
        }

        $params = '';
        for ($i=0; $i<$argNum; $i++) {
            $params .= '$args[' . $i . '],';
        }
        $params =rtrim($params, ',');

        if (is_callable(array($_className, 'getInstance'))) {
            $classCall = "$_className::getInstance";
        } else {
            $classCall = "new $_className";
        }

        if (''===$params) {
            return eval("return $classCall();");
        } else {
            return eval("return $classCall($params);");
        }
    }// END::function getClass

}// END::class My_Kernel

/* EOF */
