<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : menu.lang.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2007-4-22
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die("forbidden");

global $My_Lang;

if (!isset($My_Lang->class)) {
    $My_Lang->class = array('menu'=>array());
}
$My_Lang->class['menu']['left_menu']='左侧菜单';
$My_Lang->class['menu']['public_menu']='用户菜单';
$My_Lang->class['menu']['admin_menu']='后台管理';

$My_Lang->class['menu']['IT_news']	           =	'IT新闻';
$My_Lang->class['menu']['Inter_news']	           =	'内部新闻';
?>
