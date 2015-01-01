<?php
$smarty->assign('includePage', 'astro/xzyc.php');
$yctype=strtolower(isset($_REQUEST['type'])?$_REQUEST['type']:'today');
$xz= isset($_REQUEST['xz'])?$_REQUEST['xz']:'';
if ($xing<>"") {
$myxz=Constellation($nian1 . '-' . $yue1 . '-' . $ri1);
  } else{
      $myxz="ÄµÑò×ù";
}
switch (strtolower($yctype)) {
    case "nextday":
        $table = '#.xzysnextday';
        $update_date = date('Y-m-d 00:00:00', $nowTime);
        $inc_file = 'sinaUpdateTomorrow.php';
        break;
    case "week":
        $table = '#.xzysweek';
        $update_date = date('Y-m-d 00:00:W', $nowTime);
        $inc_file = 'sinaUpdateWeek.php';
        break;
    case "month":
        $table = '#.xzysmonth';
        $update_date = date('Y-m-01 00:00:00', $nowTime);
        $inc_file = 'sinaUpdateMonth.php';
        break;
    case "year":
        $table = '#.xzysyear';
        $update_date = date('Y-01-01 00:00:00', $nowTime);
        $inc_file = 'sinaUpdateYear.php';
        break;
    case "yearlove":
        $table = '#.xzysaqyear';
        $update_date = date('Y-01-01 00:00:00', $nowTime);
        $inc_file = 'sinaUpdateYearLove.php';
        break;
    default:
        $table = '#.xzysday';
        $update_date = date('Y-m-d 00:00:00', $nowTime);
        $inc_file = 'sinaUpdateToday.php';
        break;
}

$loop=2;
while($loop-->0) {
  if ($xz<>"") {
  $sql="select * from $table where id=?";
  $db->query($sql, array($xz));
} else {
$sql="select * from $table where xzmc=?";
    $db->query($sql, array($myxz));
}
$rs = $db->fetchArray();
    $goToUpdate = true;
    if(!$rs || $rs['update_date']!=$update_date && $goToUpdate) {
		$goToUpdate = false;
        global $xz, $myxz, $update_date, $update_xz;
        if ($xz<>"" && isset($astroInfo[$xz-1])) {
            $update_xz = $xz-1;
        } elseif (false===($update_xz =array_search($myxz, $astroInfo))) {
            unset($update_xz);
        }

        include_once(dirname(__FILE__) . '/' . $inc_file);
    } else {
        break;
    }
}


$smarty->assign('yctype', $yctype);
$smarty->assign('xz', $xz);

$smarty->assign('rs', $rs);
?>
