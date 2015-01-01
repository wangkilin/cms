<?php
$_REQUEST['sm'] = isset($_REQUEST['sm']) ? (int)$_REQUEST['sm'] : 0;
switch ($_REQUEST['sm']) {
	case 1:
		include(dirname(__FILE__ ). '/pd_astro.php');
		break;
	case 2:
		include(dirname(__FILE__ ). '/pd_name.php');
		break;
	case 3:
		include(dirname(__FILE__ ). '/pd_qq.php');
		break;
	case 4:
		include(dirname(__FILE__ ). '/pd_sxxx.php');
		break;
	case 5: 
		include(dirname(__FILE__ ). '/pd_xmwg.php');
		break;
	default:
		$smarty->assign('includePage', 'qinglv/index.php');
		break;
}



?>
