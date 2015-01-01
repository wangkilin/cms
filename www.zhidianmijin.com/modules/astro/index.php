<?php
writecookies();
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "xzcx") {
    $myxz= Constellation($_REQUEST['y'] . '-' . $_REQUEST['m'] . '-' . $_REQUEST['d']);
	$_COOKIE['laisuanming']['myxz']= $myxz;
	setcookie ('laisuanming[myxz]', $myxz , time()+3600, '/');
} elseif ($xing<>"") {
    $myxz=Constellation($nian1 . '-' . $yue1 . '-' . $ri1);
} elseif(isset($_REQUEST['flag'])) {
	$_REQUEST['sm'] = 1;
} elseif (isset($_REQUEST['xz'])) {
	$_REQUEST['sm'] = 9;
} elseif (isset($_COOKIE['laisuanming']['myxz'])) {
	$myxz = $_COOKIE['laisuanming']['myxz'];
} else {
	$_REQUEST['sm'] = 0;
}

if (isset($myxz)) {
	$smarty->assign('currentAstro', $myxz);
}

$_REQUEST['sm'] = isset($_REQUEST['sm']) ? (int)$_REQUEST['sm'] : 0;
switch ((int)$_REQUEST['sm']) {
 case 1:
	 require_once(dirname(__FILE__ ). '/astro_show.php');
	 break;
 case 2://baojian
 case 3://eq
 case 4://iq
 case 5://mingren
 case 6://shibai
 case 7://shili
 case 8://wu
	 require_once(dirname(__FILE__ ). '/astro_common.php');
	 break;
 case 9://xzyc
	 require_once(dirname(__FILE__ ). '/xzyc.php');
	 break;
	   default:
        if ((int)date('Y', time()+30*24*60*60) > $thisYear) {
            $thisYear = date('Y', time()+30*24*60*60);
            $smarty->assign('_thisYear', $thisYear);
        }
			  $smarty->assign('includePage', 'astro/index.php');
		   break;
}

if ($xing<>"") {
    $smarty->assign('myxz', Constellation($nian1 . "-" . $yue1 . "-" . $ri1));
}
?>
