<?php
$smarty->assign('includePage', 'chouqian/jm.php');

$MaxPerPage=3;
if (!empty($_REQUEST["page"]))  
    $currentPage=intval($_REQUEST["page"]);
else 
    $currentPage=1;

if (!in_array((int)$_REQUEST["act"], array(1,2)) || !isset($_REQUEST["word"])) {
    header('Location: index.php');
}
if ($_REQUEST["act"]==1) {
    $cxgjz="title";
} elseif ($_REQUEST["act"]==2) {
    $cxgjz="content";
}

$sql="select * from zgjm where $cxgjz like ?";

$db->query($sql, array('%'. $_REQUEST["word"] .'%'));
if (!($allshu= $db->numRows())) {

} else{

    $pagesize = $MaxPerPage ;
    $mpage=ceil($allshu/$pagesize);
    if($currentPage>$mpage) {
	    $currentPage = 1;
    }
    $db->dataSeek(($currentPage-1)*$pagesize);
    $smarty->assign('allshu', $allshu);
	$smarty->assign('mpage', $mpage);
	$smarty->assign('currentPage', $currentPage);

	$i=0;
	$list = array();
	while($rs=$db->fetchArray()) {
        $i++; 
		$jmlb=$rs['jmlb'];

        $sql2="select * from jmlb where id=" . $jmlb;
		$result2 = mysql_query($sql2);
		$rs2 = mysql_fetch_array($result2);
		$list[] = array('title'=>$rs['title'], 'jmlb'=>$rs2['jmlb'], 'content'=>$rs['content']);

        if ($i>=$MaxPerPage) { 
	        break;
        }
    }
	$smarty->assign('list', $list);
}
?>
