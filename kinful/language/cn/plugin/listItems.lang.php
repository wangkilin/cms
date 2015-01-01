<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : block.lang.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2007-4-15
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die("forbidden");
global $My_Lang;

if (!isset($My_Lang->plugin)) {
    $My_Lang->plugin = array('listItems'=>array());
}

$My_Lang->plugin['listItems']['first_page']	     =	'第一页';
$My_Lang->plugin['listItems']['pre_page']	       =	'上一页';
$My_Lang->plugin['listItems']['next_page']	      =	'下一页';
$My_Lang->plugin['listItems']['last_page']	      =	'最后一页';
$My_Lang->plugin['listItems']['number_per_page']	=	'每页显示';
$My_Lang->plugin['listItems']['jump_to']		       =	'跳转到';
$My_Lang->plugin['listItems']['page']	           =	'页';
$My_Lang->plugin['listItems']['total_number']	   =	'共';
$My_Lang->plugin['listItems']['item']	           =	'条';
/*EOF */
