<?php
writecookies();
if ($xing) {
	require_once(ROOT_PATH . 'inc/bzi.php');
	$_REQUEST['sm'] = isset($_REQUEST['sm']) ? (int)$_REQUEST['sm'] : 0;
	switch ($_REQUEST['sm']) {
		case 2:
			include(dirname(__FILE__ ). '/bzcs.php');
		    break;
        case 3:
			include(dirname(__FILE__ ). '/nm.php');
		    break;
        case 4:
			include(dirname(__FILE__ ). '/cg.php');
		    break;
		case 5: 
			include(dirname(__FILE__ ). '/xm.php');
		    break;
        case 6: 
			include(dirname(__FILE__ ). '/xmpd.php');
		    break;
		case 7: 
			include(dirname(__FILE__ ). '/sbwr.php');
		    break;
		case 8: 
			include(dirname(__FILE__ ). '/x.php');
		    break;
		default:
			include(dirname(__FILE__ ). '/bz.php'); 
		    break;
	}
} else {
	$smarty->assign('includePage', 'sm/index.php');
}
?>
