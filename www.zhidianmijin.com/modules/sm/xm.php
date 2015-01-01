<?php
$smarty->assign('includePage', 'sm/xm.php');
//'处理用户信息;
$tiange=0;
$dige=0;
$renge1=0;
$renge2=0;
$renge=0;
//$'姓;
$bihua1=0;
$bihua2=0;
$xing1=substr($xing,0,2);
$xing11=substr($xing,0,2);
$bihua1=getnum($xing1);
$tiange=$bihua1+1;
$tiangee=$bihua1+1;
$renge1=$bihua1;
$xing2=$xing22=$ming2=$ming22='';
if(substr($xing,2,2) <> "") {
$xing2=substr($xing,2,2);
$xing22=substr($xing,2,2);
$bihua2=getnum($xing2);
$tiange=$bihua1+$bihua2;
$tiangee=$bihua1+$bihua2;
$renge1=$bihua2 ;
}
//'名;
$bihua3=0;
$bihua4=0;
$ming1=substr($ming,0,2);
$ming11=substr($ming,0,2);
$bihua3=getnum($ming1);
$dige=$bihua3+1;
$digee=$bihua3+1;
$renge2=$bihua3;
if (substr($ming,2,2) <> "") {
$ming2=substr($ming,2,2);
$ming22=substr($ming,2,2);
$bihua4=getnum($ming2);
$dige=$bihua3+$bihua4;
$digee=$bihua3+$bihua4;
}
$zhongge=$bihua1+$bihua2+$bihua3+$bihua4;
$zhonggee=$bihua1+$bihua2+$bihua3+$bihua4;
//'计算三才;
$renge=$renge1+$renge2;
$rengee=$renge1+$renge2;
$waige=$zhongge-$renge;
$waigee=$zhonggee-$rengee;
if (substr($xing,2,2) == "") {
$waige=$waige+1;
$waigee=$waigee+1;
}
if (substr($ming,2,2) == ''){
$waige=$waige+1;
$waigee=$waigee+1;
}

$sql="select * from `81` where num=?";
$result = $db->query($sql, array($tiangee));
$rs = $db->fetchArray($result);
$tgyy=$rs["yy"];
$tgjx=$rs["jx"];
$tgas=$rs["as"];
$tgxx=$rs["content"];

$sql="select * from `81` where num=?";
$result = $db->query($sql, array($rengee));
$rs = $db->fetchArray($result);
$rgyy=$rs["yy"];
$rgjx=$rs["jx"];
$rgas=$rs["as"];
$rgxx=$rs["content"];

$sql="select * from `81` where num=?";
$result = $db->query($sql, array($digee));
$rs = $db->fetchArray($result);
$dgyy=$rs["yy"];
$dgjx=$rs["jx"];
$dgas=$rs["as"];
$dgxx=$rs["content"];

$sql="select * from `81` where num=?";
$result = $db->query($sql, array($zhonggee));
$rs = $db->fetchArray($result);
$zgyy=$rs["yy"];
$zgjx=$rs["jx"];
$zgas=$rs["as"];
$zgxx=$rs["content"];

$sql="select * from `81` where num=?";
$result = $db->query($sql, array($waigee));
$rs = $db->fetchArray($result);
$wgyy=$rs["yy"];
$wgjx=$rs["jx"];
$wgas=$rs["as"];
$wgxx=$rs["content"];

$sancai=getsancai($tiange) . getsancai($renge) . getsancai($dige);

//'三才吉凶
$sql="select * from sancai where title=?";
$result = $db->query($sql, array($sancai));
if($rs = $db->fetchArray($result)) {
    $sancaicontent=$rs['content'];
    $scyy=$rs['yy'];
    $scjx=$rs['jx'];
    $jcy=$rs['jcy'];
    $jcyjx=$rs['jx1'];
    $cgy=$rs['cgy'];
    $cgyjx=$rs['jx2'];
    $rjgx=$rs['rjgx'];
    $rjgxjx=$rs['jx3'];
    $xg=$rs['xg'];
}

	  $xmdf=intval(getpf($tgjx)/10) + intval(getpf($rgjx)) + intval(getpf($dgjx)) + intval(getpf($zgjx)) + intval(getpf($wgjx)/10) + intval(getpf($scjx)/4) + intval(getpf(substr($jcyjx, 0, 2))/4) + intval(getpf($cgyjx)/4) + intval(getpf($rjgxjx)/4);
	  if ($zhonggee>60) {
	  $xmdf=$xmdf-5;
	  }
	  $xmdf=50+$xmdf ;

$smarty->assign('xing1', $xing1);
$smarty->assign('xing11', $xing11);
$smarty->assign('bihua1', $bihua1);
$smarty->assign('xing2', $xing2);
$smarty->assign('xing22', $xing22);
$smarty->assign('bihua2', $bihua2);
$smarty->assign('ming1', $ming1);
$smarty->assign('ming11', $ming11);
$smarty->assign('bihua3', $bihua3);
$smarty->assign('ming2', $ming2);
$smarty->assign('ming22', $ming22);
$smarty->assign('bihua4', $bihua4);
$smarty->assign('tiange', $tiange);
$smarty->assign('tiangee', $tiangee);
$smarty->assign('dige', $dige);
$smarty->assign('digee', $digee);
$smarty->assign('tgjx', $tgjx);
$smarty->assign('tgyy', $tgyy);
$smarty->assign('tgxx', $tgxx);
$smarty->assign('renge', $renge);
$smarty->assign('rengee', $rengee);
$smarty->assign('rgjx', $rgjx);
$smarty->assign('rgyy', $rgyy);
$smarty->assign('rgxx', $rgxx);
$smarty->assign('dgjx', $dgjx);
$smarty->assign('dgyy', $dgyy);
$smarty->assign('dgxx', $dgxx);
$smarty->assign('waige', $waige);
$smarty->assign('waigee', $waigee);
$smarty->assign('wgjx', $wgjx);
$smarty->assign('wgxx', $wgxx);
$smarty->assign('wgyy', $wgyy);
$smarty->assign('zhongge', $zhongge);
$smarty->assign('zhonggee', $zhonggee);
$smarty->assign('zgjx', $zgjx);
$smarty->assign('zgxx', $zgxx);
$smarty->assign('zgyy', $zgyy);
$smarty->assign('xg', $xg);
$smarty->assign('scyy', $scyy);
$smarty->assign('scjx', $scjx);
$smarty->assign('sancai', $sancai);
$smarty->assign('sancaicontent', $sancaicontent);
$smarty->assign('jcy', $jcy);
$smarty->assign('jcyjx', $jcyjx);
$smarty->assign('cgy', $cgy);
$smarty->assign('cgyjx', $cgyjx);
$smarty->assign('rjgx', $rjgx);
$smarty->assign('rjgxjx', $rjgxjx);
$smarty->assign('rgas', $rgas);
$smarty->assign('dgas', $dgas);
$smarty->assign('zgas', $zgas);
$smarty->assign('wgas', $wgas);
$smarty->assign('xmdf', $xmdf);
?>
