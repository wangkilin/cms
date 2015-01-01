<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName	: .php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 
 *@Homepage	: http://www.yeaheasy.com
 *@Version	: 0.1
 */

error_reporting(0);

if(!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(dirname(__FILE__)) . '/');
}

set_include_path(ROOT_PATH . PATH_SEPARATOR . get_include_path());

require_once(ROOT_PATH . 'inc/config.php');
require_once(ROOT_PATH . 'inc/smarty/Smarty.class.php');
require_once(ROOT_PATH . 'inc/YE_database.class.php');
require_once(ROOT_PATH . 'inc/db.config.php');
require_once(ROOT_PATH . 'inc/moduleInfo.php');
require_once(ROOT_PATH . 'inc/func.php');

/* EOF */
