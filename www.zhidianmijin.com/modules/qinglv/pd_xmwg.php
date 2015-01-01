<?php
$smarty->assign('includePage', 'qinglv/pd_xmwg.php');

if (isset($_POST["act"]) && $_POST["act"]=="ok") {
    //'处理用户信息;
    $tiange=0;
    $dige=0;
    $renge1=0;
    $renge2=0;
    $renge=0;
    //'姓;
    $bihua1=0;
    $bihua2=0;
    $xing1=substr($xing,0,2);
    $xing11=substr($xing,0,2);
    $bihua1=getnum($xing1);
    $tiange=$bihua1+1;
    $tiangee=$bihua1+1;
    $renge1=$bihua1;
    if (substr($xing,2,2) <> "") {
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
    $dige = $bihua3+1;
    $digee = $bihua3+1;
    $renge2 = $bihua3;
    if (substr($ming,2,2) <> "") {
        $ming2=substr($ming,2,2);
        $ming22=substr($ming,2,2);
        $bihua4=getnum($ming2);
        $dige = $bihua3 + $bihua4;
        $digee = $bihua3 + $bihua4;
    }
    $zhongge = $bihua1 + $bihua2 + $bihua3 + $bihua4;
    $zhonggee = $bihua1 + $bihua2 + $bihua3 + $bihua4;
    //'计算三才;
    $renge = $renge1 + $renge2;
    $rengee = $renge1 + $renge2;
    $waige = $zhongge - $renge;
    $waigee = $zhonggee - $rengee;
    if (substr($xing,2,2) == "") {
        $waige = $waige +1;
        $waigee = $waigee+1;
    }
    if (substr($ming,2,2) == "") {
        $waige = $waige +1;
        $waigee = $waigee+1;
    }

    $name1=$_REQUEST['name1'];
    $name2=$_REQUEST['name2'];
    $xing1=$_REQUEST['xing1'];
    $xing2=$_REQUEST['xing2'];
    $sex1=$_REQUEST['sex1'];
    $sex2=$_REQUEST['sex2'];
    $tiange=0;
    $dige = 0;
    $renge1 = 0;
    $renge2 = 0;
    $renge = 0;
    $bihua1 = 0;
    $bihua2 = 0;
    $nxing1=substr($name1,0,2);
    $nxing11=substr($name1,0,2);
    $bihua1=getnum($nxing1);
    $tiange1=$bihua1+1;
    $tiangee1=$bihua1+1;
    $renge1=$bihua1;
    $rengee1=$bihua1;
    //'判断第一个名字 姓;
    if ($xing1 == "2") {
        $nxing2=substr($name1,2,2);
        $nxing22=substr($name1,2,2);
        $bihua2=getnum($nxing2);
        $tiange1=$bihua1+$bihua2;
        $tiangee1=$bihua1+$bihua2;
        $renge1=$bihua2;
        $rengee1=$bihua2;
        $bihua3 = 0;
        $bihua4 = 0;
        $nming1=substr($name1,4,2);
        $nming12=substr($name1,4, 2);
        $bihua3=getnum($nming1);
        $dige1=$bihua3+1;
        $digee1=$bihua3+1;
        $renge2=$bihua3;
        $rengee2=$bihua3;
        if (substr($name1,6,2) <> "") {
            $nming2=substr($name1,6,2);
            $nming22=substr($name1,6,2);
            $bihua4=getnum($nming2);
            $dige1=$bihua3+$bihua4;
            $digee1=$bihua3+$bihua4;
        }
    } else {
        $bihua3 = 0;;
        $bihua4 = 0;;
        $nming1=substr($name1,2,2);
        $nming12=substr($name1,2,2);
        $bihua3=getnum($nming1);
        $dige1=$bihua3+1;
        $digee1=$bihua3+1;
        $renge2=$bihua3;
        $rengee2=$bihua3;
        $waige1=$waige1+1;
        $waigee1=$waigee1+1;
        if (substr($name1,4,2) <> "") {
            $nming2=substr($name1,4,2);
            $nming22=substr($name1,4,2);
            $bihua4=getnum($nming2);
            $dige1=$bihua3+$bihua4;
            $digee1=$bihua3+$bihua4;
        }
    }
    $zhongge1=$bihua1+$bihua2+$bihua3+$bihua4;
    $zhonggee1=$bihua1+$bihua2+$bihua3+$bihua4;
    $renge1=$renge1+$renge2;
    $rengee1=$rengee1+$rengee2;
    $waige1=$zhongge1-$renge1;
    $waigee1=$zhonggee1-$rengee1;
    if ($nxing2 == "") {
        $waige1=$waige1+1;
        $waigee1=$waigee1+1;
    }
    if ($nming2 == "") {
        $waige1=$waige1+1;
        $waigee1=$waigee1+1;
    }

    $smarty->assign('name1',  $name1);
    $smarty->assign('sex1', $sex1);
    $smarty->assign('nxing1', $nxing1);
    $smarty->assign('nxing11', $nxing11);
    $smarty->assign('bihua1', $bihua1);
    if ($nxing2<>"") {
        $smarty->assign('nxing2', $nxing2);
        $smarty->assign('nxing22', $nxing22);
    }

    $smarty->assign('nming1', $nming1);
    $smarty->assign('nming12', $nming12);
    $smarty->assign('bihua3', $bihua3);

    if ($nming2<>"") {
        $smarty->assign('nming2', $nming2);
        $smarty->assign('nming22', $nming22);
        $smarty->assign('bihua4', $bihua4);
    }

    $smarty->assign('tiange1', $tiange1);

    $sql="select * from `81` where num=?";
    $db->query($sql, array($tiangee1));
    $rs = $db->fetchArray();
    $tgjx=$rs['jx'];

    $tgf1=getpf($tgjx);
    $smarty->assign('tgjx', $tgjx);
    $smarty->assign('renge1', $renge1);
    $sql="select * from `81` where num=?";
    $db->query($sql, array($rengee1));
    $rs = $db->fetchArray();
    $rgjx=$rs['jx'];

    $rgf1=getpf($rgjx);
    $smarty->assign('rgjx', $rgjx);
    $smarty->assign('dige1', $dige1);

    $sql="select * from `81` where num=?";
    $db->query($sql, array($digee1));
    $rs = $db->fetchArray();
    $dgjx=$rs['jx'];

    $dgf1=getpf($dgjx);
    $smarty->assign('dgjx', $dgjx);
    $smarty->assign('waige1', $waige1);

    $sql="select * from `81` where num=?";
    $db->query($sql, array($waigee1));
    $rs=$db->fetchArray();
    $wgjx=$rs['jx'];

    $wgf1=getpf($wgjx);
    $smarty->assign('wgjx', $wgjx);
    $smarty->assign('zhongge1', $zhongge1);

    $sql="select * from `81` where num=?";
    $db->query($sql, array($zhonggee1));
    $rs=$db->fetchArray();
    $zgjx=$rs['jx'];

    $zgf1=getpf($zgjx);
    $smarty->assign('zgjx', $zgjx);

    $sancai1=getsancai($tiangee1) . getsancai($rengee1) . getsancai($digee1);
    $sqlsancai="select * from sancai where title=?";
    $db->query($sqlsancai, array($sancai1));

    if ($rssancai=$db->fetchArray()) {
        $xg1=$rssancai['xg'];
    }


    $name2=$_REQUEST['name2'];
    $name2=$_REQUEST['name2'];
    $xing1=$_REQUEST['xing1'];
    $xing2=$_REQUEST['xing2'];
    $sex1=$_REQUEST['sex1'];
    $sex2=$_REQUEST['sex2'];
    $ntiange = 0;
    $ndige = 0;
    $nrenge1 = 0;
    $nrenge2 = 0;
    $nrenge = 0;
    $nbihua1 = 0;
    $nbihua2 = 0;
    $n2xing1=substr($name2,0,2);
    $n2xing11=substr($name2,0,2);
    $nbihua1=getnum($n2xing1);
    $ntiange1=$nbihua1+1;
    $ntiangee1=$nbihua1+1;
    $nrenge1=$nbihua1;
    $nrengee1=$nbihua1;
    //'判断第一个名字 姓
    if ($xing2 == "2") {
        $n2xing2=substr($name2,2,2);
        $n2xing22=substr($name2,2,2);
        $nbihua2=getnum($n2xing2);
        $ntiange1=$nbihua1+$nbihua2;
        $ntiangee1=$nbihua1+$nbihua2;
        $nrenge1=$nbihua2;
        $nrengee1=$nbihua2;
        $nbihua3 = 0;
        $nbihua4 = 0;
        $n2ming1=substr($name2,4,2);
        $n2ming12=substr($name2,4,2);
        $nbihua3=getnum($n2ming1);
        $ndige1=$nbihua3+1;
        $ndigee1=$nbihua3+1;
        $nrenge2=$nbihua3;
        $nrengee2=$nbihua3;
        if (substr($name2,6,2) <> "") {
            $n2ming2=substr($name2,6,2);
            $n2ming22=substr($name2,6,2);
            $nbihua4=getnum($n2ming2);
            $ndige1=$nbihua3+$nbihua4;
            $ndigee1=$nbihua3+$nbihua4;
        }
    } else {
        $nbihua3 = 0;
        $nbihua4 = 0;
        $n2ming1=substr($name2,2,2);
        $n2ming12=substr($name2,2,2);
        $nbihua3=getnum($n2ming1);
        $ndige1=$nbihua3+1;
        $ndigee1=$nbihua3+1;
        $nrenge2=$nbihua3;
        $nrengee2=$nbihua3;
        $nwaige1=$nwaige1+1;
        $nwaigee1=$nwaigee1+1;
        if (substr($name2,4,2) <> "") {
            $n2ming2=substr($name2,4,2);
            $n2ming22=substr($name2,4,2);
            $nbihua4=getnum($n2ming2);
            $ndige1=$nbihua3+$nbihua4;
            $ndigee1=$nbihua3+$nbihua4;
        }
    }
    $nzhongge1=$nbihua1+$nbihua2+$nbihua3+$nbihua4;
    $nzhonggee1=$nbihua1+$nbihua2+$nbihua3+$nbihua4;
    $nrenge1=$nrenge1+$nrenge2;
    $nrengee1=$nrengee1+$nrengee2;
    $nwaige1=$nzhongge1-$nrenge1;
    $nwaigee1=$nzhonggee1-$nrengee1;
    if (isset($n2xing2) && $n2xing2 == "") {
        $nwaige1=$nwaige1+1;
        $nwaigee1=$nwaigee1+1;
    }
    if (isset($n2ming2) && $n2ming2 == "") {
        $nwaige1=$nwaige1+1;
        $nwaigee1=$nwaigee1+1;
    }


    $smarty->assign('name2', $name2);
    $smarty->assign('sex2', $sex2);
    $smarty->assign('n2xing1', $n2xing1);
    $smarty->assign('n2xing11', $n2xing11);
    $smarty->assign('nbihua1', $nbihua1);

    if ($n2xing2<>"") {
        $smarty->assign('n2xing2', $n2xing2);

        $smarty->assign('n2xing22', $n2xing22);
        $smarty->assign('nbihua2', $nbihua2);

    }

    $smarty->assign('n2ming1', $n2ming1);

    $smarty->assign('n2ming12', $n2ming12);
    $smarty->assign('nbihua3', $nbihua3);
    if (isset($n2ming2) && $n2ming2<>"") {
        $smarty->assign('n2ming2', $n2ming2);
        $smarty->assign('n2ming22', $n2ming22);
        $smarty->assign('nbihua4', $nbihua4);

    }

    $smarty->assign('ntiange1', $ntiange1);


    $sql="select * from `81` where num=?";
    $db->query($sql, array($ntiangee1));
    $rs=$db->fetchArray();
    $tgjx=$rs['jx'];

    $tgf2=getpf($tgjx);
    $smarty->assign('tgjx', $tgjx);
    $smarty->assign('nrenge1', $nrenge1);

    $sql="select * from `81` where num=?";
    $db->query($sql, array($nrengee1));
    $rs=$db->fetchArray();
    $rgjx=$rs['jx'];

    $rgf2=getpf($rgjx);
    $smarty->assign('rgjx', $rgjx);
    $smarty->assign('ndige1', $ndige1);


    $sql="select * from `81` where num=?";
    $db->query($sql, array($ndigee1));
    $rs=$db->fetchArray();
    $dgjx=$rs['jx'];

    $dgf2=getpf($dgjx);
    $smarty->assign('dgjx', $dgjx);
    $smarty->assign('nwaige1', $nwaige1);

    $sql="select * from `81` where num=?";
    $db->query($sql, array($nwaigee1));
    $rs=$db->fetchArray();
    $wgjx=$rs['jx'];

    $wgf2=getpf($wgjx);
    $smarty->assign('wgjx', $wgjx);
    $smarty->assign('nzhongge1', $nzhongge1);

    $sql="select * from `81` where num=?";
    $db->query($sql, array($nzhonggee1));
    $rs=$db->fetchArray();
    $zgjx=$rs['jx'];

    $zgf2=getpf($zgjx);
    $smarty->assign('zgjx', $zgjx);

    $sancai1=getsancai($ntiangee1) . getsancai($nrengee1) . getsancai($ndigee1);
    $sqlsancai="select * from sancai where title=?";
    $db->query($sqlsancai, array($sancai1));
    if ($rssancai = $db->fetchArray()) {
        $xg1=$rssancai['xg'];
    }

    $smarty->assign('xg1', $xg1);


    $n1=abs($rgf1-$rgf2);
    $n2=abs($dgf1-$dgf2);
    $n3=abs($zgf1-$zgf2);
    $n4=abs($tgf1-$tgf2);
    $n5=abs($wgf1-$wgf2);
    $zf=($n1+$n2+$n3)+(($n4+$n5)/5);
    $zf=round(100-$zf);

    $smarty->assign('zf', $zf);
}
?>
