<?php
if ($myxz) {
    $smarty->assign('myxz', $myxz);
    switch ((int)$_REQUEST['sm']) {
     case 2://baojian
         $sql="select * from baojian where title=?";
         $infoTitle = '身体保健';
         break;
     case 3://eq
         $sql="select * from ndeq where title=?";
         $infoTitle = 'EQ曲线';
         break;
     case 4://iq
         $sql="select * from xlcz where title=?";
         $infoTitle = 'IQ测试';
         break;
     case 5://mingren
         $sql="select * from mingren where title=?";
         $infoTitle = '星座名人';
         break;
     case 6://shibai
         $sql="select * from shiye where title=?";
         $infoTitle = '失败剖析';
         break;
     case 7://shili
         $sql="select * from aiqing where title=?";
         $infoTitle = '个人实力';
         break;
     case 8://wu
         $sql="select * from qingxv where title=?";
         $infoTitle = '五大建议';
         break;
    }

    $db->query($sql, array($myxz));
    $rs = $db->fetchArray();
    $smarty->assign('content', $rs['content']);
    $smarty->assign('infoTitle', $infoTitle);
}
$smarty->assign('includePage', 'astro/astro_common.php');
?>
