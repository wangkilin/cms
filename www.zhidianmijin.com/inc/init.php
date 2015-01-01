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

if (!defined('YE_ALLOW_ACCESS')) {
	header ('Location: ../index.php');
	exit;
}

@set_magic_quotes_runtime(0);

global $db, $smarty, $nowTime, $thisYear, $thisMonth, $thisDay, $nowDate, $astroInfo, $weeklyInfo;

$astroInfo = array('牡羊座', '金牛座', '双子座', '巨蟹座'
                 , '狮子座', '处女座', '天秤座', '天蝎座'
                 , '射手座', '魔羯座', '水瓶座', '双鱼座');
$weeklyInfo = array('星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六');

define('ROOT_PATH', dirname(dirname(__FILE__)) . '/');

define('SMARTY_DIR', ROOT_PATH."inc/smarty/");
define('YE_TABLE_PREFIX', '');
require_once(ROOT_PATH . 'inc/inc.php');

writecookies();

$db = new YE_database();
$sql = "set names 'gbk'";
$db->query($sql);

$smarty = new Smarty;

$smarty->register_function('selectStepOptions', 'selectStepOptions');

$smarty->template_dir = ROOT_PATH . 'templates/';
$smarty->compile_dir = ROOT_PATH . 'templates_c/';
$smarty->left_delimiter = '<?';
$smarty->right_delimiter = '?>';

$nowTime = time() + (800-(int)(date('O')))*36;
$thisYear = date("Y", $nowTime);
$thisMonth = date("n", $nowTime);
$thisDay = date("j", $nowTime);
$nowDate = date('Y-n-j', $nowTime);
$smarty->assign('_thisYear', $thisYear);
$smarty->assign('_thisMonth', $thisMonth);
$smarty->assign('_thisDay', $thisDay);
$smarty->assign('_nowDate', $nowDate);

//获取用户cookies信息
global $xing, $ming, $xingbie, $xuexing, $nian1, $yue1, $ri1, $hh1, $mm1, $nian2, $yue2, $ri2, $hh2, $mm2, $sx;

$xing=isset($_POST['xing'])? $_POST['xing'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['xing'])? $_COOKIE['laisuanming']['xing']:'');
$ming=isset($_POST['ming'])? $_POST['ming'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['ming'])? $_COOKIE['laisuanming']['ming']:'');
$xingbie=isset($_POST['xingbie'])? $_POST['xingbie'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['xingbie'])? $_COOKIE['laisuanming']['xingbie']:'');
$xuexing=isset($_POST['xuexing'])? $_POST['xuexing'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['xuexing'])? $_COOKIE['laisuanming']['xuexing']:'');
//公历
$nian1=isset($_POST['nian'])? $_POST['nian'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['nian1'])? $_COOKIE['laisuanming']['nian1']:'');
$yue1=isset($_POST['yue'])? $_POST['yue'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['yue1'])? $_COOKIE['laisuanming']['yue1']:'');
$ri1=isset($_POST['ri'])? $_POST['ri'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['ri1'])? $_COOKIE['laisuanming']['ri1']:'');
$hh1=isset($_POST['hh'])? $_POST['hh'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['hh1'])? $_COOKIE['laisuanming']['hh1']:'');
$mm1=isset($_POST['mm'])? $_POST['mm'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['mm1'])? $_COOKIE['laisuanming']['mm1']:'');
//农历
$nian2=isset($_POST['nian2'])? $_POST['nian2'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['nian2'])? $_COOKIE['laisuanming']['nian2']:'');
$yue2=isset($_POST['yue2'])? $_POST['yue2'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['yue2'])? $_COOKIE['laisuanming']['yue2']:'');
$ri2=isset($_POST['ri2'])? $_POST['ri2'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['ri2'])? $_COOKIE['laisuanming']['ri2']:'');
$hh2=isset($_POST['hh2'])? $_POST['hh2'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['hh2'])? $_COOKIE['laisuanming']['hh2']:'');
$mm2=isset($_POST['mm2'])? $_POST['mm2'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['mm2'])? $_COOKIE['laisuanming']['mm2']:'');
$sx=isset($_POST['sx'])? $_POST['sx'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['sx'])? $_COOKIE['laisuanming']['sx']:'');

?>
