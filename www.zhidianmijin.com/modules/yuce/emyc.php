<?php
$smarty->assign('includePage', 'yuce/emyc.php');
if(isset($_REQUEST['fx'])) {
$fx=$_REQUEST['fx'];
$stime=$_REQUEST['stime'];
$sql="select * from msyuce where fx=? and stime=? and lb=?";
$db->query($sql, array($fx, $stime, '¶úÃù'));
if($rs = $db->fetchArray()) {
$smarty->assign('rs', $rs);
}
}
?>
