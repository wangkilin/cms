<?php
$smarty->assign('includePage', 'chouqian/guanyin.php');

if(isset($_REQUEST['act']) && $_REQUEST['act']=="jq") {
    $gyqid=$_REQUEST['gyqid'];
    $smarty->assign('gyqid', $gyqid);
    $sql="select * from guanyin where id=?";
    $db->query($sql, array($gyqid));
    $rs = $db->fetchArray();
    $jieqian = $rs['jieqian'];
    $smarty->assign('jieqian', $jieqian);
} else {

    if(isset($_REQUEST['act']) && $_REQUEST['act'] == "ok") {
        if (!isset($_COOKIE['laisuanming']['guanyin'])) {
        //'产生随机数
        $_COOKIE['laisuanming']['guanyin'] = $num=rand(1,100);
        setcookie('laisuanming[guanyin]',$num, time()+3600, '/');
        }else {
        $num=$_COOKIE['laisuanming']['guanyin'];
        }
        $smarty->assign('num', $num);

        $picnum=rand(1,3);
        $smarty->assign('picnum', $picnum);
        $gyclicknum=isset($_REQUEST['gyclicknum']) ? (int)$_REQUEST['gyclicknum']:1;
        $smarty->assign('gyclicknum', $gyclicknum);

        if (!$gyclicknum) {
        }else {
            $gysmile=rand(1,4);
            $smarty->assign('gysmile', $gysmile);
            $_COOKIE['laisuanming']['gysmile' . $gyclicknum]=$gysmile;
        }
    }else {
        setcookie('laisuanming[guanyin]','', time()-3600, '/');
    } 
}
?>
