<?php
$smarty->assign('includePage', 'chouqian/guandi.php');
if(isset($_REQUEST['act']) && $_REQUEST['act'] == "jq") {
    $smarty->assign('gdlqid', $_REQUEST['gdlqid']);
} elseif(isset($_REQUEST['act']) && $_REQUEST['act'] == "ok") {
    if (!isset($_COOKIE['laisuanming']['guandi'])) {
        //'产生随机数
        $_COOKIE['laisuanming']['guandi'] = $num=rand(1,100);
        setcookie('laisuanming[guandi]',$num, time()+3600, '/');

    }else {
        $num=$_COOKIE['laisuanming']['guandi'];
    }
    $smarty->assign('num', $num);
    $picnum=rand(1,3);
    $gdclicknum=isset($_REQUEST['gdclicknum']) ? (int)$_REQUEST['gdclicknum']:1;
    $smarty->assign('gdclicknum', $gdclicknum);
	$smarty->assign('picnum', $picnum);

    if (!$gdclicknum) {

    } else {
        $gysmile=rand(1,4);
        $smarty->assign('gysmile', $gysmile);
        $_COOKIE['laisuanming']['gysmile' . $gdclicknum]=$gysmile;
    }
}
?>
