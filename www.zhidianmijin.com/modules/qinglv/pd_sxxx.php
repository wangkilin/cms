<?php
$smarty->assign('includePage', 'qinglv/pd_sxxx.php');

if (isset($_REQUEST['act']) && $_REQUEST['act']=="sxok") {

    $sqlstr="select * from shuxianglove where shengxiao1=? and shengxiao2=?";
    $db->query($sqlstr, array(trim($_REQUEST['p5']), trim($_REQUEST['p6'])));
    $rs = $db->fetchArray();
    $smarty->assign('title', $rs['title']);
    $smarty->assign('content1', rep($rs['content1']));
    $smarty->assign('content2', rep($rs['content2']));
}

if (isset($_REQUEST['act']) && $_REQUEST['act']=="xxok") {
    $sqlstr="select * from xuexinglove where xuexing1=? and xuexing2=?";
    $db->query($sqlstr, array(trim($_REQUEST['p3']), trim($_REQUEST['p4'])));
    $rs = $db->fetchArray();
    $smarty->assign('title1', $rs['title1']);
    $smarty->assign('title2', $rs['title2']);
    $smarty->assign('content', rep($rs['content']));
}
?>
