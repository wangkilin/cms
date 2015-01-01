<?php
$smarty->assign('includePage', 'chouqian/mazu.php');

if(isset($_REQUEST['act']) && $_REQUEST['act']=="jq") {
	$thlqid=$_REQUEST['thlqid'];
	if ($thlqid<10) {
		$thlqid= '00' . $thlqid;
    } elseif ($thlqid>=10 and $thlqid<=60) {
		$thlqid= '0' . $thlqid;
    }
	$smarty->assign('thlqid', $thlqid);

} else {
	if(isset($_REQUEST['act']) && $_REQUEST['act'] == "ok") {
		if (!isset($_COOKIE['laisuanming']['mazu'])) {
			//'产生随机数
			$num=rand(1,60);
			setcookie('laisuanming[mazu]',$num, time()+3600, '/');
        } else {
			$num=$_COOKIE['laisuanming']['mazu'];
        }
		$smarty->assign('num', $num);

        $picnum=rand(1,3);
		$smarty->assign('picnum', $picnum);
        $mzclicknum=isset($_REQUEST['mzclicknum'])? (int)$_REQUEST['mzclicknum'] :1;
		$smarty->assign('mzclicknum', $mzclicknum);
        if ($mzclicknum=="") {
		} else {
			$gysmile=rand(1,4);
			$_COOKIE['laisuanming']['gysmile' . $mzclicknum]=$gysmile;
			$smarty->assign('gysmile', $gysmile);
        }
    } else {
		setcookie('laisuanming[mazu]','', time()-3600, '/');
    }
}
?>
