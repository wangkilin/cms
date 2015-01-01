<?php
$smarty->assign('includePage', 'yuce/hmjx.php');

//'ÊÖ»ú¼ªÐ×
if(isset($_REQUEST['word']) && strlen($word=trim($_REQUEST['word']))) {
$word=floatval($word)/80;
$temp=intval($word);
$word=$word-(float)$temp;
$word=intval($word*80);
$word=strval($word);
if ($word=="0") {
$word="81";
}
$sql="select * from shouji where num=?";
$db->query($sql, array($word));

if ($rs = $db->fetchArray()) {
$num=$rs['num'];
$title=$rs['title'];
$jx=$rs['jx'];
$jx="(" . $jx . ")";
$content=$rs['content'];
}
$smarty->assign('title', $title);
$smarty->assign('word', $_REQUEST['word']);
$smarty->assign('k', $_REQUEST['k']);
$smarty->assign('content', $content);
$smarty->assign('jx', $jx);
}
?>
