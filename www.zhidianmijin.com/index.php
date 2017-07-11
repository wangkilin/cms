<?php
define('YE_ALLOW_ACCESS', 1);
define('BASE_URL',
                   'http' . (empty($_SERVER['HTTPS'])?'s':'') . '://' .
				   $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] );



require_once('./inc/init.php');
error_reporting(E_ALL);
require_once('./inc/chineseConvert.php');

$moduleId = isset($_GET['m'])?(int)$_GET['m']:0;
$moduleId = isset($moduleInfo[$moduleId])?$moduleId:0;
$subModuleId = isset($_GET['sm'])?(int)$_GET['sm']:0;


$sql = 'insert into #.stat (`from_ip`, `module_id`, `sub_module_id`, `access_date`) values (?, ?, ?, ?)';
$db->query($sql, array($_SERVER['REMOTE_ADDR'], $moduleId, $subModuleId, date('Y-m-d H:00:00')));

if(isset($_REQUEST['clearCookie'])) {
    clearcookies();
    header('Location: ' . $_SERVER['PHP_SELF']);
}

require_once(ROOT_PATH . $moduleInfo[$moduleId]['php']);


$smarty->assign('siteMenu', $moduleInfo);

$smarty->assign('xing', $xing);
$smarty->assign('ming', $ming);
$smarty->assign('xingbie', $xingbie);
$smarty->assign('xuexing', $xuexing);
$smarty->assign('nian1', $nian1);
$smarty->assign('yue1', $yue1);
$smarty->assign('ri1', $ri1);
$smarty->assign('hh1', $hh1);
$smarty->assign('mm1', $mm1);
$smarty->assign('nian2', $nian2);
$smarty->assign('yue2', $yue2);
$smarty->assign('ri2', $ri2);
$smarty->assign('hh2', $hh2);
$smarty->assign('mm2', $mm2);
$smarty->assign('sx', $sx);

$smarty->assign('siteTheme', $systemConfig['yeSiteTheme']);
$smarty->assign('siteName', $systemConfig['yeSiteName']);
$smarty->assign('siteCharset', $systemConfig['yeSiteCharset']);
$smarty->assign_by_ref('siteMetas', $systemConfig['yeMetaInfo']);

$webContent = $smarty->fetch('index.htm');
//foreach ($chineseZhCn as $key=>$value) {
    //echo $value, $chineseZhTw[$key];
    //$webContent = mb_ereg_replace($value, $chineseZhTw[$key], $webContent);
//}
echo $webContent;
?>
