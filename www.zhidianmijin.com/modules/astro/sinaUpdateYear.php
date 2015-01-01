<?php
//$content = file_get_contents('http://astro.sina.com.cn/pc/west/frame1_11.html');
//$content = file_get_contents('frame3_11.html');
if (isset($update_xz) && ($content = getUrlContent('http://astro.sina.com.cn/pc/west/frame3_'.$update_xz.'.html'))) {
preg_match("/<!-- SUDA_CODE_END -->.*<!-- Start  Wrating  -->/si", $content, $match);
preg_match("/<li class=\"notes\">(.*)<\/li>/i", $content, $notes);
preg_match("/<li class=\"date\">有效日期:(.*)<\/li>/i", $content, $dates);
$title= $notes[1];
//print_r($match);
$yxqx = $dates[1];

$match[0] = str_replace("\n", '', $match[0]);
//preg_match("/<div class=\"lotconts\">(.*)<\/div>/i", $match[0], $zhpg);
//$zhpg = $zhpg[1];
$match[0] = str_replace("</div>", "\n", $match[0]);
preg_match_all("/<h4>(.*)<\/h4>(.*)/i", $match[0], $match1);
//print_r($match1);
foreach($match1[1] as $k=>$m) {
    switch(substr($m, 0, 8)) {
        case '整体概况':
            $ztzs = substr_count($match1[1][$k], '<img');
		    $ztzk = $match1[2][$k];
            break;
        case '功课学业':
            $gkzs = substr_count($match1[1][$k], '<img');
		    $gkxy = $match1[2][$k];
            break;
        case '工作职场':
            $gzzs = substr_count($match1[1][$k], '<img');
		    $gzzc = $match1[2][$k];
            break;
        case '金钱理财':
            $jqzs   = substr_count($match1[1][$k], '<img');
		    $zqlc = $match1[2][$k];
            break;
        case '恋爱婚姻':
            $lazs  = substr_count($match1[1][$k], '<img');
		    $lzfy = $match1[2][$k];
            break;

    }
}

$db->query("update xzysyear set 
  yxqx  = ?, 
  title = ?, 
  ztzs  = ?,
  ztzk  = ?,
  gkzs  = ?,
  gkxy  = ?,
  gzzs  = ?,
  gzzc  = ?,
  jqzs  = ?,
  zqlc  = ?,
  lazs  = ?,
  lzfy  = ?
		, update_date=? 	where id = ?"
  , array($yxqx, $title,$ztzs,$ztzk,$gkzs,$gkxy,$gzzs,$gzzc,$jqzs,$zqlc,$lazs,$lzfy,$update_date, $update_xz+1)); 
}
?>