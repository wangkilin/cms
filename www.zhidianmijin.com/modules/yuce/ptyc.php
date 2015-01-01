<?php
$smarty->assign('includePage', 'yuce/myyc.php');
if(isset($_REQUEST['act']) && $_REQUEST['act']=='ok') {
$stime=$_REQUEST['stime'];
$sql="select * from msyuce where stime=? and lb=?";
$db->query($sql, array($stime, 'ÅçÌç'));
if($rs = $db->fetchArray()) {
$smarty->assign('rs', $rs);
}
}
?>
