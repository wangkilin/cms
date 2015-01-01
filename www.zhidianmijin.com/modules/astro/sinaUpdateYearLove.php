<?php
//$content = file_get_contents('http://astro.sina.com.cn/pc/west/frame4_11.html');
//$content = file_get_contents('frame4_11.html');
if (isset($update_xz) && ($content = getUrlContent('http://astro.sina.com.cn/pc/west/frame4_'.$update_xz.'.html'))) {
preg_match("/<li class=\"date\">有效日期:(.*)<\/li>/i", $content, $dates);
$yxqx = $dates[1];

$content = str_replace("\n", '', $content);
$content = str_replace("</div>", "</div>\n", $content);
preg_match("/<div class=\"lotconts\">(.*)<\/div>/i", $content, $zhpg);
$ztzk = $zhpg[1];
preg_match("/<div class=\"m_left\">(.*)<\/div>/i", $content, $zhpg);
$nv = $zhpg[1];
preg_match("/<div class=\"m_right\">(.*)<\/div>/i", $content, $zhpg);
$nan = $zhpg[1];

$db->query("update xzysaqyear set 
  yxqx  = ?, 
  ztzk = ?, 
  nv  = ?,
  nan  = ?
		, update_date=? 	where id = ?"
  , array($yxqx, $ztzk,$nv,$nan,$update_date, $update_xz+1));
}
?>