<?php
$smarty->assign('includePage', 'yuce/zwsm.php');

if(isset($_REQUEST['zwdm'])) {
//'¼ÆËãÖî¸ðÉñÊý
$zwdm=$_REQUEST['zwdm'];
$sql="select * from zhiwen where zhiwen=?";
$db->query($sql, array($zwdm));
if($rs = $db->fetchArray()) {
    $smarty->assign('rs', $rs);
}
}
?>
