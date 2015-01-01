<?php
$Sql="select * from #.hdrl where gn = ?";
$result = $db->query($Sql, array($nowDate));
$rs = $db->fetchArray($result);

$smarty->assign('nn', $rs["nn"]);
$smarty->assign('suici', $rs["suici"]);
$smarty->assign('cong', $rs["cong"]);
$smarty->assign('yi', $rs["yi"]);
$smarty->assign('ji', $rs["ji"]);
$smarty->assign('rs', $rs);
$smarty->assign('weeklyInfo', $weeklyInfo);

if($nian1 && $yue1 && $ri1) {
	$smarty->assign('xingzuo',  Constellation($nian1 . "-" . $yue1 . "-" . $ri1));
}

$smarty->assign('includePage', 'index.php');
?>
