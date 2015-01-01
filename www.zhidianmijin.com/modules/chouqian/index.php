<?php
$_REQUEST['sm'] = isset($_REQUEST['sm']) ? (int)$_REQUEST['sm'] : 0;
switch ((int)$_REQUEST['sm']) {
    case 1:
        require_once(dirname(__FILE__ ). '/guandi.php');
        break;
    case 2:
       require_once(dirname(__FILE__ ). '/guanyin.php');
       break;
    case 3:
       require_once(dirname(__FILE__ ). '/huangdaxian.php');
       break;
    case 8:
       require_once(dirname(__FILE__ ). '/jm.php');
       break;
    case 4:
       require_once(dirname(__FILE__ ). '/lvzu.php');
       break;
    case 5:
       require_once(dirname(__FILE__ ). '/mazu.php');
       break;
    case 7:
       require_once(dirname(__FILE__ ). '/zgjm.php');
       break;
    case 6:
       require_once(dirname(__FILE__ ). '/zgss.php');
       break;
    default:
       $smarty->assign('includePage', 'chouqian/index.php');
       break;
}
?>
