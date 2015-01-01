<?php
$smarty->assign('includePage', 'chouqian/zgjm.php');

	$sql="SELECT * FROM jmlb";
	$result = $db->query($sql, array());
	$i = 0;
	$list = array();
	while($rs = $db->fetchArray($result)) {
		$list[$i] = array($rs['jmlb']);
		$sql2="SELECT * FROM zgjm where jmlb=" . $rs['id'];
		$result2 = mysql_query($sql2);
		$list[$i][1] = array();
		while($rs2 = mysql_fetch_array($result2)) {
			$list[$i][1][] = $rs2['title'];
		}
		$i++;
	}
	$smarty->assign('list', $list);
?>

