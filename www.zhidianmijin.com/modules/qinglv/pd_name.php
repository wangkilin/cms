<?php
$smarty->assign('includePage', 'qinglv/pd_name.php');

if (isset($_REQUEST['act']) && $_REQUEST['act']=="ok") {
    $strname1=$_REQUEST['name1'];
    $str1=substr($strname1,0,2);
    $str2=substr($strname1,2,2);
    $str3=substr($strname1,4,2);
    $str4=substr($strname1,6,2);
    $bihua1=getnum($str1);
    $bihua2=getnum($str2);
    $bihua3=getnum($str3);
    $bihua4=getnum($str4);
    $bihuaname1=$bihua1 + $bihua2 + $bihua3 + $bihua4;


    $strname2=$_REQUEST['name2'];
    $sstr1=substr($strname2,0,2);
    $sstr2=substr($strname2,2,2);
    $sstr3=substr($strname2,4,2);
    $sstr4=substr($strname2,6,2);
    $sbihua1=getnum($sstr1);
    $sbihua2=getnum($sstr2);
    $sbihua3=getnum($sstr3);
    $sbihua4=getnum($sstr4);
    $bihuaname2=$sbihua1 + $sbihua2 + $sbihua3 + $sbihua4;
    $bihuac=$bihuaname1 + $bihuaname2;
    $bihuac= $bihuac % 100;

    //'¼ÆËã
    $sql="select * from qlpdbh where bihua like ?";
    $db->query($sql, array('%' . $bihuac . '%'));
    if($rs = $db->fetchArray()) {
        $intro=$rs['intro'];
    }

    $smarty->assign('strname1', $strname1);
    $smarty->assign('strname2', $strname2);
    $smarty->assign('intro', $intro);
}
?>