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

error_reporting(E_ALL);

define('ROOT_PATH', dirname(dirname(__FILE__)) . '/');

define('SMARTY_DIR', ROOT_PATH."inc/smarty/");
define('YE_TABLE_PREFIX', '');
require_once(ROOT_PATH . 'inc/inc.php');

$db = new YE_database();
$sql = "set names 'gbk'";
$db->query($sql);

?>
