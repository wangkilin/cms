<?php

	$_REQUEST['sm'] = isset($_REQUEST['sm']) ? (int)$_REQUEST['sm'] : 0;
	switch ($_REQUEST['sm']) {
		case 1:
			include(dirname(__FILE__ ). '/emyc.php');
		    break;
		case 2: 
			include(dirname(__FILE__ ). '/myyc.php');
		    break;
        case 3: 
			include(dirname(__FILE__ ). '/ptyc.php');
		    break;
		case 4: 
			include(dirname(__FILE__ ). '/ytyc.php');
		    break;
		case 5: 
			include(dirname(__FILE__ ). '/xjyc.php');
		    break;
        case 6:
			include(dirname(__FILE__ ). '/hdjr.php');
		    break;
        case 7:
			include(dirname(__FILE__ ). '/hmjx.php');
		    break;
		case 8: 
			include(dirname(__FILE__ ). '/sanshishu.php');
		    break;
		case 9: 
			include(dirname(__FILE__ ). '/snsn.php');
		    break;
		case 10: 
			include(dirname(__FILE__ ). '/zwsm.php');
		    break;
		default:
  $smarty->assign('includePage', 'yuce/index.php');
		    break;
	}
?>
