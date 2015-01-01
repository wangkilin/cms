<?php
$smarty->assign('includePage', 'qinglv/pd_astro.php');

if(isset($_REQUEST['act']) && $_REQUEST['act']=="ok") {

    $sql="select * from xingzuolove where xingzuo1= ? and xingzuo2= ? ";
    $db->query($sql, array(trim($_REQUEST['p1']), trim($_REQUEST['p2'])));
    $rs = $db->fetchArray();

    $smarty->assign('title', $rs['title']);
    $smarty->assign('content1', rep($rs['content1']));
    $smarty->assign('content2', rep($rs['content2']));
}
?>
