<?php
$smarty->assign('includePage', 'yuce/hdjr.php');

if (isset($_REQUEST['act']) && $_REQUEST['act']=="crz") {
$yy=isset($_REQUEST['yy'])?$_REQUEST['yy']:'';
$mm=isset($_REQUEST['mm'])?$_REQUEST['mm']:'';
$dd=isset($_REQUEST['dd'])?$_REQUEST['dd']:'';
$word=isset($_REQUEST['word'])?$_REQUEST['word']:'';
$cxdate = '';
if ($yy<>"" and $mm<>"" and $dd<>"") {
$cxdate= $yy . "-" . $mm . "-" . $dd;
}
if ($cxdate=="") {
$cxdate=date('Y-m-d 00:00:00', time());
}

$smarty->assign('cxdate', $cxdate);

$sql="select * from hdrl where gn = ?";
$db->query($sql, array($cxdate));
$rs = $db->fetchArray();
$smarty->assign('rs', $rs);
$nlrz=substr($rs['suici'], -6, 4);
$sql="select * from zsfw1 where nlrz= ?";
$db->query($sql, array($nlrz));
$rs = $db->fetchArray();
$smarty->assign('zsfw', $rs);

} elseif (isset($_REQUEST['act']) && $_REQUEST['act']=="xrz") {
$upto=(int)$_REQUEST['upto'];
$tp=$_REQUEST['tp'];
$word=$_REQUEST['word'];
if ($tp==0) {
$cxbiao="yi";
} else {
$cxbiao="ji";
}

if (in_array($_REQUEST['weekday'], array('1','2','3','4','5','6','0'))) {
    $weekday = (int)$_REQUEST['weekday'];
} else {
    $weekday = '0,1,2,3,4,5,6';
}
$tdate=date('Y-n',time());

$sql="select * from hdrl where " . $cxbiao . " like ? and xq in ($weekday) and gn>? and datediff(gn,?)<".($upto+1);
$db->query($sql, array('%' .$word .'%', date('Y-m-d', $nowTime), date('Y-m-d', $nowTime)));
$allshu=$db->numRows();
if ($allshu) {

$i=0;

$list = array();
while($rs=$db->fetchArray()) {
    
if ($i++>=20) {
 break;
	  }
  $list[] = $rs; 

}

$smarty->assign('list', $list);
}
$smarty->assign('allshu', $allshu);
$smarty->assign('upto', $upto);
$smarty->assign('word', $word);

 }
 
$smarty->assign('astroInfo', $astroInfo);
$smarty->assign('weeklyInfo', $weeklyInfo);
 ?>
