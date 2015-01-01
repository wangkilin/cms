<?php
$smarty->assign('includePage', 'sm/x.php');
    if (isset($_POST['act']) && $_POST["act"] =="ok") {
	  $sxing=$_POST["xing"];
	  $sxing1=$_POST["xing"];
	  $sxing2=$_POST["xing"];
	} else {
	  $sxing=$xing;
	  $sxing1=$xing;
	  $sxing2=$xing;
	}

	 $sql="select * from xing where xing=?";
	 $result = $db->query($sql, array($sxing2));
if ($rs = $db->fetchArray($result)) {
    $smarty->assign('intro', $rs["intro"]);
	}
$smarty->assign('sxing', $sxing);
$smarty->assign('sxing1', $sxing1);
$smarty->assign('sxing2', $sxing2);
?>
