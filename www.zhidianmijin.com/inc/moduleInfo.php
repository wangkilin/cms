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

/*
if (!defined('YE_ALLOW_ACCESS')) {
	header ('Location: ../index.php');
	exit;
}
*/
global $moduleInfo;

$moduleInfo = array();

$i = 0;
$moduleInfo[$i] = array();
$moduleInfo[$i]['php'] = 'modules/index.php';
$moduleInfo[$i]['menuName'] = '首页';

$i++;
$moduleInfo[$i] = array();
$moduleInfo[$i]['php'] = 'modules/sm/index.php';
$moduleInfo[$i]['menuName'] = '传统算命';
$moduleInfo[$i]['subModules'] = array('生辰八字', '八字测算', '日干论命', '称骨论命', '姓名测试', '姓命配对', '上辈为人', '姓氏起源');

$i++;
$moduleInfo[$i] = array();
$moduleInfo[$i]['php'] = 'modules/astro/index.php';
$moduleInfo[$i]['menuName'] = '生肖/星座/血型';
$moduleInfo[$i]['subModules'] = array('', '星座保健', '星座EQ', '星座IQ', '星座名人', '星座失败教训', '星座实力', '星座5大建议', '星座运程');

$i++;
$moduleInfo[$i] = array();
$moduleInfo[$i]['php'] = 'modules/chouqian/index.php';
$moduleInfo[$i]['menuName'] = '抽签/测字/解梦';
$moduleInfo[$i]['subModules'] = array('关帝神签', '观音灵签', '黄大仙灵签', '吕祖灵签', '天后灵签', '诸葛神算', '周公解梦' );

$i++;
$moduleInfo[$i] = array();
$moduleInfo[$i]['php'] = 'modules/hunpei/index.php';
$moduleInfo[$i]['menuName'] = '婚姻系数';
$moduleInfo[$i]['subModules'] = array();


$i++;
$moduleInfo[$i] = array();
$moduleInfo[$i]['php'] = 'modules/qinglv/index.php';
$moduleInfo[$i]['menuName'] = '恋爱指南';
$moduleInfo[$i]['subModules'] = array('星座组合', '姓名配对', 'QQ缘分', '生肖血型', '姓名五格' );

$i++;
$moduleInfo[$i] = array();
$moduleInfo[$i]['php'] = 'modules/yuce/index.php';
$moduleInfo[$i]['menuName'] = '民俗预测';
$moduleInfo[$i]['subModules'] = array('耳鸣', '面热', '喷嚏', '眼跳', '心惊', '黄道吉日', 'QQ/手机号码吉凶', '三世财运', '生男生女', '指纹');

$i++;
$moduleInfo[$i] = array();
$moduleInfo[$i]['php'] = 'modules/donation/index.php';
$moduleInfo[$i]['menuName'] = '<br><b>捐赠本站<b>';
$moduleInfo[$i]['subModules'] = array();

?>
