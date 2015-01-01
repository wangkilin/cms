<?php
//$content = file_get_contents('frame1_11.html');
if (isset($update_xz) && ($content = getUrlContent('http://astro.sina.com.cn/pc/west/frame1_'.$update_xz.'.html'))) {
preg_match("/<!-- SUDA_CODE_END -->.*<!-- Start  Wrating  -->/si", $content, $match);
preg_match("/<li class=\"notes\">(.*)<\/li>/i", $content, $notes);
preg_match("/<li class=\"date\">有效日期:(.*)<\/li>/i", $content, $dates);
$title= $notes[1];
$yxqx= $dates[1];

$match[0] = str_replace("\n", '', $match[0]);
$match[0] = str_replace("</div>", "\n", $match[0]);
preg_match_all("/<h4>(.*)<\/h4>(.*)/i", $match[0], $match1);
foreach($match1[1] as $k=>$m) {
    switch(substr($m, 0, 8)) {
        case '整体运势':
            $ztzs = substr_count($m, '<img');
            $ztys = $match1[2][$k];
            break;
        case '健康运势':
            $jkzs   = substr_count($m, '<img');
            $jkys   = $match1[2][$k];
            break;
        case '工作学业':
            $gzzs   = substr_count($m, '<img');
            $gzys   = $match1[2][$k];
            break;
        case '性欲指数':
            $xyzs   = substr_count($m, '<img');
            $xyys   = $match1[2][$k];
            break;
        case '红心日':
            $hxri   = substr($match1[2][$k], 3, 4);
            $hxsm   = substr($match1[2][$k], 13);
            break;
        case '黑梅日':
            $hmri   = substr($match1[2][$k], 3, 4);
            $hmsm   = substr($match1[2][$k], 13);
            break;
        case '爱情运势':
            $infos = explode('</p><em>', $match1[2][$k]);
            $aqzs1  = substr_count($infos[0], '<img');
            $aqys1  = substr($infos[0], strrpos($infos[0], '<p>'));
            $aqzs2  = substr_count($infos[1], '<img');
            $aqys2  = substr($infos[1], strrpos($infos[1], '<p>'));
            break;

    }
}

$db->query( "update xzysweek set
yxqx   = ?, 
title  = ?, 
ztzs   = ?, 
ztys   = ?, 
aqzs1  = ?, 
aqys1  = ?, 
aqzs2  = ?, 
aqys2  = ?, 
jkzs   = ?, 
jkys   = ?, 
gzzs   = ?, 
gzys   = ?, 
xyzs   = ?, 
xyys   = ?, 
hxri   = ?, 
hxsm   = ?,
hmri   = ?, 
hmsm   = ?
		, update_date=? 	where id = ?"
  , array(
         $yxqx,  
         $title, 
         $ztzs,  
         $ztys,  
         $aqzs1, 
         $aqys1, 
         $aqzs2, 
         $aqys2, 
         $jkzs,  
         $jkys,  
         $gzzs,  
         $gzys,  
         $xyzs,  
         $xyys,  
         $hxri,  
         "<p>$hxsm",
         $hmri,  
         "<p>$hmsm"
        ,$update_date, $update_xz+1)); 
}
?>