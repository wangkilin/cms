<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : formAction.lang.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2007-4-15
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die("forbidden");
global $My_Lang;

if (!isset($My_Lang->plugin)) {
    $My_Lang->plugin = array('formAction'=>array());
}

$My_Lang->plugin['formAction']['new']	               =	'新建';
$My_Lang->plugin['formAction']['edit']	              =	'编辑';
$My_Lang->plugin['formAction']['save']	              =	'保存';
$My_Lang->plugin['formAction']['copy']	              =	'复制';
$My_Lang->plugin['formAction']['publish']           	=	'公开';
$My_Lang->plugin['formAction']['unpublish']		        =	'隐藏';
$My_Lang->plugin['formAction']['move']	              =	'移动';
$My_Lang->plugin['formAction']['delete']	            =	'删除';
$My_Lang->plugin['formAction']['next']	              =	'下一步';
$My_Lang->plugin['formAction']['help']	              =	'帮助';
$My_Lang->plugin['formAction']['return']	            =	'返回';

/* EOF */
