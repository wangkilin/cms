<?php
$smarty->assign('includePage', 'chouqian/huangdaxian.php');

if(isset($_REQUEST['act']) && $_REQUEST['act'] == "jq") {
    $gyqid=$_REQUEST['gyqid'];
    $sql="select * from huangdaxian where id=?";
    $db->query($sql, array($gyqid));
    $rs = $db->fetchArray();
    $smarty->assign('qianshu', $rs['qianshu']);
    $smarty->assign('hdxname', $rs['name']);
    $smarty->assign('title', $rs['title']);
    $smarty->assign('shi', rep($rs['shi']));
    $smarty->assign('content', $rs['content']);

} elseif(isset($_REQUEST['act']) && $_REQUEST['act'] == "ok") {
    if (!isset($_COOKIE['laisuanming']['guanyin'])) {
    //'产生随机数
        $num=rand(1,100);
        setcookie('laisuanming[guanyin]',$num, time()+3600, '/');
    }else {
        $num=$_COOKIE['laisuanming']['guanyin'];
    }
    $smarty->assign('num', $num);

    $picnum=rand(1,3);
    $gyclicknum=isset($_REQUEST['gyclicknum']) ? (int)$_REQUEST['gyclicknum']:1;
    $smarty->assign('picnum', $picnum);
    $smarty->assign('gyclicknum', $gyclicknum);

    if (!$gyclicknum) {
    }else {
        $gysmile=rand(1,4);
        $smarty->assign('gysmile', $gysmile);
        $_COOKIE['laisuanming']['gysmile' . $gyclicknum]=$gysmile;
    }
}
?>
