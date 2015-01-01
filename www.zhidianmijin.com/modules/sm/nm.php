<?php 
$xing1 = substr($xing,0,2);
$ming1 = substr($ming, 0, 2);
$smarty->assign('xing1', $xing1);
if (substr($xing, 2 , 2) <> "") {
  $smarty->assign('xing2', substr($xing, 2, 2));
}
$smarty->assign('ming1', $ming1);
if (substr($ming, 2, 2) <> "")
    $smarty->assign('ming2', substr($ming, 2, 2));

$bzwh = tgdzwh($yg1) . tgdzwh($yz1) . tgdzwh($mg1) . tgdzwh($mz1) . tgdzwh($dg1) . tgdzwh($dz1) . tgdzwh($tg1) .  tgdzwh($tz1);
$mainw = '';
$mainq = '';
$wnum1 =substr_count($bzwh, '金');
if ($wnum1>=3)
    $mainw=$mainw . "<strong>金</strong>旺";
elseif ($wnum1==0)
    $mainq=$mainq . "缺<strong>金</strong>";

$wnum2 =substr_count($bzwh, '木');
if ($wnum2>=3)
    $mainw=$mainw . "<strong>木</strong>旺";
elseif ($wnum2==0)
    $mainq=$mainq . "缺<strong>木</strong>";

$wnum3 =substr_count($bzwh, '水');
if ($wnum3>=3)
    $mainw=$mainw . "<strong>水</strong>旺";
elseif ($wnum3==0)
    $mainq=$mainq . "缺<strong>水</strong>";

$wnum4 =substr_count($bzwh, '火');
if ($wnum4>=3)
    $mainw=$mainw . "<strong>火</strong>旺";
elseif ($wnum4==0)
    $mainq=$mainq . "缺<strong>火</strong>";

$wnum5 =substr_count($bzwh, '土');
if ($wnum5>=3)
    $mainw=$mainw . "<strong>土</strong>旺";
elseif ($wnum5==0)
    $mainq=$mainq . "缺<strong>土</strong>";

$sql="select * from wh where wh=?";
$result = $db->query($sql, array(tgdzwh($dg1)));
if ($rs = $db->fetchArray()) {
	$smarty->assign('tnwh', $rs['tnwh']);
	$smarty->assign('ynwh', $rs['ynwh']);
	$smarty->assign('skzhyj', $rs['skzhyj']);
	$smarty->assign('whzx', $rs['whzx']);
	$smarty->assign('szwh', $rs['szwh']);
	$smarty->assign('hyhw', $rs['hyhw']);
}

$sql="select * from sjrs where wh='" . tgdzwh($dg1) ."' and sj='" . siji($yue1) ."'";
$result = $db->query($sql);
if ($rs = $db->fetchArray()) {
    $smarty->assign('sjrs', $rs["sjrs"]);
}

$sql="select * from sxgx where sx='" . $sx . "'";
$result = $db->query($sql);
if ($rs = $db->fetchArray()) {
    $smarty->assign('sxgx', $rs["sxgx"]);
}

$sql="select * from rgnm where rgz='" . $dgz . "'";
$result = $db->query($sql);
if ($rs = $db->fetchArray()) {
    $smarty->assign('xgfx', $rs["xgfx"]);
    $smarty->assign('aqfx', $rs["aqfx"]);
    $smarty->assign('syfx', $rs["syfx"]);
    $smarty->assign('cyfx', $rs["cyfx"]);
    $smarty->assign('jkfx', $rs["jkfx"]);
}

$smarty->assign('sx', $sx);
$smarty->assign('ygz', $ygz);
$smarty->assign('mainw', $mainw);
$smarty->assign('mainq', $mainq);
$smarty->assign('dg1', $dg1);
$smarty->assign('yue1', $yue1);
$smarty->assign('wnum1', $wnum1);
$smarty->assign('wnum2', $wnum2);
$smarty->assign('wnum3', $wnum3);
$smarty->assign('wnum4', $wnum4);
$smarty->assign('wnum5', $wnum5);
$smarty->assign('mgz', $mgz);
$smarty->assign('dgz', $dgz);
$smarty->assign('tgz', $tgz);

$smarty->register_modifier("layin","layin");
$smarty->register_modifier("siji","siji");
$smarty->register_modifier("tgdzwh","tgdzwh");
$smarty->register_modifier("DiZhi","DiZhi");

$smarty->assign('yg1', $yg1);
$smarty->assign('yz1', $yz1);
$smarty->assign('mg1', $mg1);
$smarty->assign('mz1', $mz1);
$smarty->assign('dg1', $dg1);
$smarty->assign('dz1', $dz1);
$smarty->assign('tg1', $tg1);
$smarty->assign('tz1', $tz1);

$smarty->assign('includePage', 'sm/nm.php');
?>
