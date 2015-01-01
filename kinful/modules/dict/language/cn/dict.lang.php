<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : media.lang.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2010-8-8
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die("forbidden");
global $My_Lang, $My_Kernel;

$My_Kernel->loadLanguage('module', 'system');
if (!isset($My_Lang->module)) {
    $My_Lang->module = array('media'=>array());
} else if(isset($My_Lang->module['system'])) {
    $My_Lang->module['media'] = $My_Lang->module['system'];
} else {
    $My_Lang->module['media'] = array();
}

$My_Lang->module['media']['category_list_media_count'] = '新闻数';
$My_Lang->module['media']['media_category_admin_title'] = '新闻分类管理';
$My_Lang->module['media']['no_media_category_selected'] = '请选择要修改的新闻分类。';
$My_Lang->module['media']['media_on_top'] = '置 顶';
$My_Lang->module['media']['media_weight'] = '权 重';
$My_Lang->module['media']['media_title'] = '新闻标题';
$My_Lang->module['media']['media_bold'] = '粗 体';
$My_Lang->module['media']['media_italic'] = '斜 体';
$My_Lang->module['media']['media_title_color'] = '标题颜色';
$My_Lang->module['media']['media_start_time'] = '开始时间';
$My_Lang->module['media']['media_end_time'] = '结束时间';
$My_Lang->module['media']['media_reference_url'] = '参考网址';
$My_Lang->module['media']['media_publish'] = '是否发布';
$My_Lang->module['media']['media_meta_key'] = '关键字';
$My_Lang->module['media']['media_meta_desc'] = '关键字内容';
$My_Lang->module['media']['media_intro_text'] = '新闻介绍';
$My_Lang->module['media']['media_full_text'] = '新闻内容';
$My_Lang->module['media']['media_create_tab_title'] = '添加新闻';
$My_Lang->module['media']['media_admin_description'] = '新闻管理描述';
$My_Lang->module['media']['media_admin_title'] = '新闻管理';
$My_Lang->module['media']['media_title_media'] = '新闻类型';
$My_Lang->module['media']['media_title_no_media'] = '文本';
$My_Lang->module['media']['media_title_image'] = '图文';
$My_Lang->module['media']['media_title_video'] = '视频';
$My_Lang->module['media']['media_title_audio'] = '音频';
$My_Lang->module['media']['media_update_tab_title'] = '新闻更新';
$My_Lang->module['media']['media_category_title'] = '新闻分类';
$My_Lang->module['media']['media_category_name'] = '分类名称';
$My_Lang->module['media'][''] = '';
$My_Lang->module['media'][''] = '';
$My_Lang->module['media'][''] = '';
$My_Lang->module['media'][''] = '';
$My_Lang->module['media'][''] = '';
$My_Lang->module['media'][''] = '';
$My_Lang->module['media'][''] = '';
$My_Lang->module['media'][''] = '';
$My_Lang->module['media'][''] = '';
$My_Lang->module['media'][''] = '';
$My_Lang->module['media'][''] = '';
$My_Lang->module['media'][''] = '';
$My_Lang->module['media'][''] = '';
$My_Lang->module['media'][''] = '';
$My_Lang->module['media'][''] = '';
/* EOF */
