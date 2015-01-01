<?php

$smarty->assign('includePage', 'sm/sm.php');
if ($xing) {
	define( 'CURRENT_DIR', dirname(__FILE__);
	if ($_REQUEST['sm']==1) include('bz.php'); 
	elseif ($_REQUEST['sm']==2) include(CURRENT_DIR . 'bzcs.php');
	elseif ($_REQUEST['sm']==3) include(CURRENT_DIR . 'nm.php');
	elseif ($_REQUEST['sm']==4) include(CURRENT_DIR . 'cg.php');
	elseif ($_REQUEST['sm']==5) include(CURRENT_DIR . 'xm.php');
	elseif ($_REQUEST['sm']==6) include(CURRENT_DIR . 'xmpd.php');
	elseif ($_REQUEST['sm']==7) include(CURRENT_DIR . 'sbwr.php');
	elseif ($_REQUEST['sm']==8) include(CURRENT_DIR . 'x.php'); 
}
?>
