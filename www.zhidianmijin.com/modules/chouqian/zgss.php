<?php
$smarty->assign('includePage', 'chouqian/zgss.php');

if (isset($_REQUEST['name1'])) {
    $strname = $_REQUEST['name1'];
    $str1=substr($strname,0,2);
    $str2=substr($strname,2,2);
    $str3=substr($strname,4,2);
	$smarty->assign('str1', $str1);
	$smarty->assign('str2', $str2);
	$smarty->assign('str3', $str3);
    if ($str1<>"" and $str2<>"" and $str3<>"") {
        $bihua1=getnum($str1) % 10;
        if ($bihua1==0) {
            $bihua1=1;
        }
        $bihua2=getnum($str2) % 10;
        if ($bihua2==0) {
            $bihua2=1;
        }
        $bihua3=getnum($str3) % 10;
        if ($bihua3==0) {
            $bihua3=1;
        }
        
        $bihua=$bihua1 . $bihua2 . $bihua3;
        
        while ($bihua>=384) {
            $bihua=$bihua-384;
        }
        
        if ($bihua<=9) {
            $bihua="00" .$bihua;
        } elseif ($bihua<=99) {
            $bihua="0" . $bihua;
        }
        //'¼ÆËãÖî¸ğÉñÊı
        $sql="select * from zhuge where id=?";
        $db->query($sql, array($bihua));
        $rs = $db->fetchArray();
        $smarty->assign('zhugetitle', $rs['title']);
        $smarty->assign('zhugecontent', $rs['content']);
    }
}
?>
