<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : block.lang.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2007-4-15
 *@Homepage	: http://www.yeaheasy.com
 *@Version	: 0.1
 */
defined('YeahEasy') or die("forbidden");
global $YE_lang;

if (!isset($YE_lang->module)) {
    $YE_lang->module = array('system'=>array());
}

$YE_lang->module['system']['public']	=	'Public';
$YE_lang->module['system']['show_page_desc']	=	array('All page', 'Home Page', 'Specified pages', 'Non-specified pages');
$YE_lang->module['system']['show_page']	=	'Display setting';
$YE_lang->module['system']['block_id']	=	'Block ID';
$YE_lang->module['system']['block_name']	=	'Block Name';
$YE_lang->module['system']['params']		=	'Parameters Setting';
$YE_lang->module['system']['block_link']	=	'Hyperlink On Block';
$YE_lang->module['system']['show_link']	=	'Show Link';
$YE_lang->module['system']['show_type']	=	'Show Title';
$YE_lang->module['system']['publish']		=	'Publish';
$YE_lang->module['system']['show_level']	=	'Access Control';
$YE_lang->module['system']['show_link_no']	= 'No';
$YE_lang->module['system']['show_link_yes']	= 'Yes';
$YE_lang->module['system']['show_title_no']	= 'No';
$YE_lang->module['system']['show_title_yes']	= 'Yes';
$YE_lang->module['system']['publish_yes']		= 'Yes';
$YE_lang->module['system']['publish_no']		= 'No';
?>
