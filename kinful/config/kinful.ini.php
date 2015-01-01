<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : kinful.ini.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-1-10
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
global $_system;// store global system variable
global $my_client_type;// request type
global $My_Kernel;
global $My_Sql;

defined('Kinful') or die("forbidden");

error_reporting(E_ALL);

$_system = array();    // store global system variable
$_siteConfigPath = MY_ROOT_PATH . 'config/kinful.com.config/';
$MY_SITES_LIST = array(
        'localhost'			=> MY_ROOT_PATH . 'config/kinful.com.config/',
        'jobfocus.cn'		=> MY_ROOT_PATH . 'config/kinful.com.config/',
        'jobfocus.com.cn'	=> MY_ROOT_PATH . 'config/kinful.com.config/',
        'teacup.com.cn'		=> MY_ROOT_PATH . 'config/kinful.com.config/',
        'kinful.com'		=> MY_ROOT_PATH . 'config/kinful.com.config/',
        'zhidianmijin.com'	=> MY_ROOT_PATH . 'config/kinful.com.config/',
        'zhidianmijin.cn'	=> MY_ROOT_PATH . 'config/kinful.com.config/'
    );
foreach($MY_SITES_LIST as $domain => $configPath) {
    if(false!==strpos(strtolower($_SERVER['SERVER_NAME']), $domain)) {
        $_siteConfigPath = $MY_SITES_LIST[$domain];
        break;
    }
}

require_once ($_siteConfigPath . 'my_constant.ini.php');
require_once ($_siteConfigPath . 'my_config.ini.php');
require_once ($_siteConfigPath . 'db.config.php');

$my_client_type = 'web';
//@set_magic_quotes_runtime(0);
/*
if (!ini_get('register_globals')) {
    while(list($key,$value)=each($_FILES)) {
        $GLOBALS[$key]=$value;
    }

    while(list($key,$value)=each($_ENV)) {
        $GLOBALS[$key]=$value;
    }

    while(list($key,$value)=each($_GET)) {
        $GLOBALS[$key]=$value;
    }

    while(list($key,$value)=each($_POST)) {
        $GLOBALS[$key]=$value;
    }

    while(list($key,$value)=each($_COOKIE)) {
        $GLOBALS[$key]=$value;
    }

    while(list($key,$value)=each($_SERVER)) {
        $GLOBALS[$key]=$value;
    }

    while(list($key,$value)=@each($_SESSION)) {
        $GLOBALS[$key]=$value;
    }
}
*/
?>
