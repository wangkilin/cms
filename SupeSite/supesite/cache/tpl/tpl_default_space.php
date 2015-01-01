<?php if(!defined('IN_SUPESITE')) exit('Access Denied'); ?>
<?php include template('header'); ?><?php $ads = getad('system', 'space', '1'); ; ?>
<?php if(!empty($ads['pageheadad']) ) { ?>
<div class="ad_header"><?=$ads['pageheadad']?></div>
<?php } ?>
</div><!--header end-->

<div id="nav">
<div class="main_nav">
<ul>
<?php if(empty($_SCONFIG['defaultchannel'])) { ?>
<li><a href="<?=S_URL?>/index.php">首页</a></li>
<?php } ?>
<?php if(is_array($channels['menus'])) { foreach($channels['menus'] as $key => $value) { ?>
<li><a href="<?=$value['url']?>"><?=$value['name']?></a></li>
<?php } } ?>
</ul>
</div>
</div><!--nav end-->

<div class="column" id="blog_detail">
<?php if(!empty($ads['pagecenterad'])) { ?>
<div class="ad_mainbody"><?=$ads['pagecenterad']?></div>
<?php } ?>
<div class="box_l">
<div class="global_module margin_bot10">
<div class="global_module2_caption"><h3>作者</h3></div>
<div class="blog_user">
<a href="<?=S_URL?>/space.php?uid=<?=$member['uid']?>"><img src="<?=UC_API?>/avatar.php?uid=<?=$member['uid']?>" alt="" /></a><br/>
<a href="<?=S_URL?>/space.php?uid=<?=$member['uid']?>"><?=$member['username']?></a><br />
<div class="user_group">
用户组：
<?php if($member['groupid']) { ?>
<?php echo $_SGLOBAL['grouparr'][$member['groupid']]['grouptitle']; ?>
<?php } else { ?>
-
<?php } ?>
<br />
开通时间：<?=$member['dateline']?><br />
更新时间：<?=$member['updatetime']?><br />
上次登录时间：<?=$member['lastlogin']?>
</div>
</div>
</div>
 
<?php if(!empty($ads['siderad'])) { ?>
<div class="global_module margin_bot10 bg_fff">
<div class="global_module2_caption"><h3>网络资源</h3></div>
<div class="ad_sidebar">
<?=$ads['siderad']?>
</div>

</div>
<?php } ?>
</div><!--box_l end-->

<div class="box_r bg_fff">
<div id="user_tab_caption">
<a
<?php if($_GET['op'] == 'news') { ?>
 class="current"
<?php } ?>
 href="<?php echo geturl("uid/$_GET[uid]/op/news"); ?>">资讯</a>
<?php if(uchome_exists() && !in_array('uchblog', $_SCONFIG['closechannels'])) { ?>
<a
<?php if($_GET['op'] == 'uchblog') { ?>
 class="current"
<?php } ?>
 href="<?php echo geturl("uid/$_GET[uid]/op/uchblog"); ?>">日志</a>
<?php } ?>
<?php if(uchome_exists() && !in_array('uchphoto', $_SCONFIG['closechannels'])) { ?>
<a
<?php if($_GET['op'] == 'uchphoto') { ?>
 class="current"
<?php } ?>
 href="<?php echo geturl("uid/$_GET[uid]/op/uchphoto"); ?>">相册</a>
<?php } ?>
<?php if(discuz_exists() && !in_array('bbs', $_SCONFIG['closechannels'])) { ?>
<a
<?php if($_GET['op'] == 'bbs') { ?>
 class="current"
<?php } ?>
 href="<?php echo geturl("uid/$_GET[uid]/op/bbs"); ?>">论坛</a>
<?php } ?>
</div>
<?php if($_GET['op'] == 'uchblog' && uchome_exists() && !in_array('uchblog', $_SCONFIG['closechannels'])) { ?>
<?php block("uchblog", "uid/$_GET[uid]/order/dateline DESC/perpage/20/cachetime/3600/showdetail/1/messagelen/200/messagedot/1/cachename/infobody"); ?>
<?php } elseif($_GET['op'] == 'uchphoto' && uchome_exists() && !in_array('uchphoto', $_SCONFIG['closechannels'])) { ?>
<?php block("uchphoto", "uid/$_GET[uid]/order/updatetime DESC/perpage/6/subjectlen/30/messagedot/0/cachetime/3600/cachename/infobody"); ?>
<?php } elseif($_GET['op'] == 'bbs' && discuz_exists() && !in_array('bbs', $_SCONFIG['closechannels'])) { ?>
<?php block("bbsthread", "authorid/$_GET[uid]/order/dateline DESC/perpage/20/cachetime/3600/showdetail/1/messagelen/200/messagedot/1/cachename/infobody"); ?>
<?php } else { ?>
<?php block("spacenews", "uid/$_GET[uid]/order/i.dateline DESC/perpage/20/cachetime/3600/showdetail/1/messagelen/200/messagedot/1/cachename/infobody"); ?>
<?php } ?>

<?php if($_GET['op'] == 'uchphoto') { ?>
<div class="global_module user_photolist">
<div class="clearfix">
<?php if(is_array($_SBLOCK['infobody'])) { foreach($_SBLOCK['infobody'] as $key => $value) { ?>
<dl>
<dt><div><a href="<?=$value['url']?>"><img src="<?=$value['pic']?>" alt="" /></a></div></dt>
<dd>
<h5><a href="<?=$value['url']?>"><?=$value['albumname']?></a></h5>
<p><a href="<?=S_URL?>/space.php?uid=<?=$value['uid']?>"><?=$value['username']?></a> <?=$value['picnum']?>张照片</p>
<p>
创建：
<?php if(($_SGLOBAL['timestamp'] - $value['dateline']) > 86400) { ?>
 <?php sdate("Y-m-d", $value[dateline]); ?>
<?php } else { ?>
<?php echo intval(($_SGLOBAL['timestamp'] - $value['dateline']) / 3600 + 1);; ?>小时之前
<?php } ?>
</p>
<p>更新：
<?php if(($_SGLOBAL['timestamp'] - $value['dateline']) > 86400) { ?>
 <?php sdate("Y-m-d", $value[updatetime]); ?>
<?php } else { ?>
<?php echo intval(($_SGLOBAL['timestamp'] - $value['dateline']) / 3600 + 1);; ?>小时之前
<?php } ?>
</p>
</dd>
</dl>
<?php } } ?>
</div>
<?php if(!empty($_SBLOCK['infobody_multipage'])) { ?>
<?=$_SBLOCK['infobody_multipage']?>
<?php } ?>

<?php if(empty($_SBLOCK['infobody'])) { ?>
<div class="user_no_body">此用户尚未发表信息</div>
<?php } ?>
</div>
<?php } else { ?>
<div class="global_module user_blog">
<?php if(is_array($_SBLOCK['infobody'])) { foreach($_SBLOCK['infobody'] as $key => $value) { ?>
<?php if($_GET['op'] == 'bbs') { ?>
<?php $value['replynum'] = $value['replies'];; ?>
<?php } ?>
<div class="user_blog_list">
<h5><a href="<?=$value['url']?>"><?=$value['subject']?></a></h5>
<p><?=$value['message']?></p>
<p class="user_blog_op"><a class="more" href="<?=$value['url']?>">点击此处查看原文</a> 
<span>
<?php if(($_SGLOBAL['timestamp'] - $value['dateline']) > 86400) { ?>
 <?php sdate("Y-m-d", $value[dateline]); ?>
<?php } else { ?>
<?php echo intval(($_SGLOBAL['timestamp'] - $value['dateline']) / 3600 + 1);; ?>小时之前
<?php } ?>
 | 
<?php if($_GET['op'] == 'bbs') { ?>
评论(<?=$value['replies']?>) | 阅读(<?=$value['views']?>)
<?php } else { ?>
评论(<?=$value['replynum']?>) | 阅读(<?=$value['viewnum']?>)
<?php } ?>
</span></p>
</div>
<?php } } ?>
<?php if(!empty($_SBLOCK['infobody_multipage'])) { ?>
<?=$_SBLOCK['infobody_multipage']?>
<?php } ?>

<?php if(empty($_SBLOCK['infobody'])) { ?>
<div class="user_no_body">此用户尚未发表信息</div>
<?php } ?>
</div>
<?php } ?>
</div>
</div><!--column end-->
<?php if(!empty($ads['pagefootad'])) { ?>
<div class="ad_pagebody"><?=$ads['pagefootad']?></div>
<?php } ?>

<?php if(!empty($ads['pagemovead']) || !empty($ads['pageoutad'])) { ?>
<?php if(!empty($ads['pagemovead'])) { ?>
<div id="coupleBannerAdv" style="z-index: 10; position: absolute; width:100px;left:10px;top:10px;display:none">
<div style="position: absolute; left: 6px; top: 6px;">
<?=$ads['pagemovead']?>
<br />
<img src="<?=S_URL?>/images/base/advclose.gif" onMouseOver="this.style.cursor='hand'" onClick="closeBanner('coupleBannerAdv');">
</div>
<div style="position: absolute; right: 6px; top: 6px;">
<?=$ads['pagemovead']?>
<br />
<img src="<?=S_URL?>/images/base/advclose.gif" onMouseOver="this.style.cursor='hand'" onClick="closeBanner('coupleBannerAdv');">
</div>
</div>
<?php } ?>

<?php if(!empty($ads['pageoutad'])) { ?>
<div id="floatAdv" style="z-index: 10; position: absolute; width:100px;left:10px;top:10px;display:none">
<div id="floatFloor" style="position: absolute; right: 6px; bottom:-700px">
<?=$ads['pageoutad']?>
</div>
</div>
<?php } ?>
<script type="text/javascript" src="<?=S_URL?>/include/js/floatadv.js"></script>
<script type="text/javascript">
<?php if(!empty($ads['pageoutad'])) { ?>
var lengthobj = getWindowSize();
lsfloatdiv('floatAdv', 0, 0, 'floatFloor' , -lengthobj.winHeight).floatIt();
<?php } ?>

<?php if(!empty($ads['pagemovead'])) { ?>
lsfloatdiv('coupleBannerAdv', 0, 0, '', 0).floatIt();
<?php } ?>
</script>
<?php } ?>
<?php if(!empty($ads['pageoutindex'])) { ?>
<?=$ads['pageoutindex']?>
<?php } ?>
<?php include template('footer'); ?>