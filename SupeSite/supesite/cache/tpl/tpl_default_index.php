<?php if(!defined('IN_SUPESITE')) exit('Access Denied'); ?>
<?php include template('header'); ?><?php $ads = getad('system', 'indexad', '1'); ; ?>
<?php if(!empty($ads['pageheadad']) ) { ?>
<div class="ad_header"><?=$ads['pageheadad']?></div>
<?php } ?>
</div><!--header end-->

<div id="nav">
<div class="main_nav">
<ul>
<li class="current"><a href="<?=S_URL?>/index.php">首页</a></li>
<?php if(is_array($channels['menus'])) { foreach($channels['menus'] as $key => $value) { ?>
<li><a href="<?=$value['url']?>"><?=$value['name']?></a></li>
<?php } } ?>
</ul>
</div>

<div class="order_nav">
<?php if(is_array($channels['menus'])) { foreach($channels['menus'] as $key => $value) { ?>
<?php if($key == 'news') { ?>
<?php block("category", "type/news/isroot/1/order/c.displayorder/limit/0,12/cachetime/80800/cachename/category"); ?><ul><li>
<em><a href="<?=$value['url']?>"><?=$value['name']?></a>: </em><?php $dot = '|'; ?><?php $total = count($_SBLOCK['category']); ?><?php $i = 1;; ?>
<?php if(is_array($_SBLOCK['category'])) { foreach($_SBLOCK['category'] as $value) { ?>
<a href="<?=$value['url']?>"><?=$value['name']?></a>
<?php if($total != $i) { ?>
 <?=$dot?> 
<?php } ?>
<?php $i++;; ?>
<?php } } ?>
</li></ul>
<?php } elseif($key == 'bbs') { ?>
<?php if($forumarr) { ?>
<ul><li>
<em><a href="<?=$value['url']?>"><?=$value['name']?></a>: </em><?php $dot = '|'; ?><?php $total = count($forumarr); ?><?php $i = 1;; ?>
<?php if(is_array($forumarr)) { foreach($forumarr as $value) { ?>
<a href="<?=$value['url']?>"><?=$value['name']?></a>
<?php if($total != $i) { ?>
 <?=$dot?> 
<?php } ?>
<?php $i++;; ?>
<?php } } ?>
</li></ul>
<?php } ?>
<?php } elseif($value['type'] == 'model') { ?>
<?php @include S_ROOT.'./cache/model/model_'.$value['nameid'].'.cache.php';; ?>
<?php if(!empty($cacheinfo['categories'])) { ?>
<ul><li>
<em><a href="<?=$value['url']?>"><?=$value['name']?></a>: </em><?php $dot = '|'; ?><?php $total = count($cacheinfo['categories']); ?><?php $i = 1;; ?>
<?php if(is_array($cacheinfo['categories'])) { foreach($cacheinfo['categories'] as $key => $value) { ?>
 <a href="<?=$siteurl?>/m.php?name=<?=$cacheinfo['models']['modelname']?>&mo_catid=<?=$key?>" title="<?=$value?>"><?=$value?></a>
<?php if($total != $i) { ?>
 <?=$dot?> 
<?php } ?>
<?php $i++;; ?>
<?php } } ?>
</li></ul>
<?php } ?>
<?php } ?>
<?php } } ?>
</div>

</div><!--nav end-->

<div class="column">
<div class="col1">
<div class="col3"><?php block("spacenews", "haveattach/2/order/i.dateline DESC/limit/0,4/cachetime/83400/subjectlen/40/subjectdot/0/cachename/hotnewspic"); ?><div id="focus_turn">
<?php if(!empty($_SBLOCK['hotnewspic'])) { ?>
<ul id="focus_pic"><?php $j = 0; ?>
<?php if(is_array($_SBLOCK['hotnewspic'])) { foreach($_SBLOCK['hotnewspic'] as $pkey => $pvalue) { ?>
<?php $pcurrent = ($j == 0 ? 'current' : 'normal');; ?><li class="<?=$pcurrent?>"><a href="<?=$pvalue['url']?>"><img src="<?=$pvalue['a_filepath']?>" alt="" /></a></li><?php $j++; ?>
<?php } } ?>
</ul>
<ul id="focus_tx"><?php $i = 0; ?>
<?php if(is_array($_SBLOCK['hotnewspic'])) { foreach($_SBLOCK['hotnewspic'] as $key => $value) { ?>
<?php $current = ($i == 0 ? 'current' : 'normal');; ?><li class="<?=$current?>"><a href="<?=$value['url']?>" title="<?=$value['subjectall']?>"><?=$value['subject']?></a></li><?php $i++; ?>
<?php } } ?>
</ul>
<div id="focus_opacity"></div>
<?php } ?>
</div><!--focus_turn end--><?php block("spacenews", "order/i.viewnum DESC/limit/0,17/cachetime/86900/subjectlen/40/subjectdot/0/showdetail/1/messagelen/100/messagedot/1/cachename/hotnews"); ?>
<?php if(!empty($_SBLOCK['hotnews'])) { ?>
<?php $hotnews = @array_slice($_SBLOCK['hotnews'], 0, 5); ?>
<?php } ?>
<div id="new_news">
<h3>热点内容</h3>
<ul>
<?php if(is_array($hotnews)) { foreach($hotnews as $value) { ?>
<li><span class="box_r"><?php sdate('m-d',$value[dateline]); ?></span><a href="<?=$value['url']?>" title="<?=$value['subjectall']?>"><?=$value['subject']?></a></li>
<?php } } ?>
</ul>
</div>
</div><!--col3 end-->

<!--最新资讯--><?php block("spacenews", "order/i.dateline DESC/limit/0,5/cachetime/85400/subjectlen/46/subjectdot/0/showdetail/1/messagelen/150/messagedot/1/cachename/newnews1"); ?><div class="col4" id="hot_news">
<h3>最新资讯</h3>
<?php if(is_array($_SBLOCK['newnews1'])) { foreach($_SBLOCK['newnews1'] as $value) { ?>
<div class="hot_news_list">
<h4><a href="<?=$value['url']?>" title="<?=$value['subjectall']?>"><?=$value['subject']?></a></h4>
<p><?=$value['message']?></p>
</div>
<?php } } ?>
</div><!--col4 end-->
</div><!--col1 end-->
<div class="col2">
<div id="user_login">
<script src="<?=S_URL?>/batch.panel.php?rand=<?php echo rand(1, 999999); ?>" type="text/javascript" language="javascript"></script>
</div><!--user_login end--><?php block("poll", "order/dateline DESC/limit/0,3/cachetime/80000/subjectlen/36/cachename/poll"); ?><div class="super_notice">
<h3>调查:</h3>
<ul>
<?php if(empty($_SBLOCK['poll'])) { ?>
<li>暂时没有调查</li>
<?php } else { ?>
<?php if(is_array($_SBLOCK['poll'])) { foreach($_SBLOCK['poll'] as $value) { ?>
<li><a href="<?=$value['url']?>" title="<?=$value['subjectall']?>"><?=$value['subject']?></a></li>
<?php } } ?>
<?php } ?>
</ul>
</div><!--调查end--><?php block("announcement", "order/displayorder DESC,starttime DESC/limit/0,3/cachetime/96400/subjectlen/34/subjectdot/0/cachename/announce"); ?><div class="super_notice">
<h3>公告:</h3>
<ul>
<?php if(empty($_SBLOCK['announce'])) { ?>
<li>暂时没有公告</li>
<?php } else { ?>
<?php if(is_array($_SBLOCK['announce'])) { foreach($_SBLOCK['announce'] as $value) { ?>
<li><a href="<?=$value['url']?>" title="<?=$value['subjectall']?>"><?=$value['subject']?></a></li>
<?php } } ?>
<?php } ?>
</ul>
</div><!--公告end-->
<div class="search_bar margin_bot0">
<h3>站内搜索</h3>
<div class="search_content">
<form action="<?=S_URL?>/batch.search.php" method="post">
<input type="text" class="input_tx" size="23" name="searchkey" value="<?=$searchkey?>" /> <input type="submit" class="input_search" name="authorsearchbtn" value="搜索" />
<div class="search_catalog">
<?php if(empty($searchname)) { ?>
<?php $searchname = 'subject'; ?>
<?php } ?>
<input id="title" name="searchname" type="radio" value="subject" 
<?php if($searchname == 'subject') { ?>
checked="checked" 
<?php } ?>
/><label for="title">标题</label>
<input id="content" name="searchname" type="radio" value="message" 
<?php if($searchname == 'message') { ?>
checked="checked" 
<?php } ?>
/><label for="content">内容</label>
<input id="author" name="searchname" type="radio" value="author" 
<?php if($searchname == 'author') { ?>
checked="checked" 
<?php } ?>
/><label for="author">作者</label>
<?php if(!empty($channels['menus']['bbs'])) { ?>
<a class="search_bbs" title="搜索论坛" href="<?=$bbsurl?>/search.php" target="_blank">搜索论坛</a>
<?php } ?>
<input type="hidden" value="news" name="type">
<input type="hidden" name="formhash" value="<?php echo formhash();; ?>" />
</div>
</form>
</div>
</div><!--站内搜索-->
</div><!--col2 end-->
</div><!--column end-->
<?php if(!empty($ads['pagecenterad'])) { ?>
<div class="ad_pagebody"><?=$ads['pagecenterad']?></div>
<?php } ?>
<div class="column">
<div class="col1">
<div class="global_module">
<div class="global_module1_caption"><h3>资讯</h3><a class="more" href="<?php echo geturl("action/news"); ?>">更多&gt;&gt;</a></div>
<ul class="global_tx_list1">
<?php if(!empty($_SBLOCK['hotnews'])) { ?>
<?php $hotnews2 = @array_slice($_SBLOCK['hotnews'], 5, 17); ?>
<?php } ?>
<?php if(is_array($hotnews2)) { foreach($hotnews2 as $value) { ?>
<li><span class="box_r"><?php sdate('m-d',$value[dateline]); ?></span><a href="<?=$value['url']?>" title="<?=$value['subjectall']?>"><?=$value['subject']?></a></li>
<?php } } ?>
</ul>
</div>
</div><!--col1 end--><?php block("spacenews", "digest/1,2,3/order/i.viewnum DESC,i.dateline DESC/limit/0,6/cachetime/89877/subjectlen/34/subjectdot/0/cachename/hotnews2"); ?><div class="col2">
<div class="global_module bg_fff">
<div class="global_module2_caption"><h3>本月精华</h3></div>
<ul class="global_tx_list2">
<?php if(is_array($_SBLOCK['hotnews2'])) { foreach($_SBLOCK['hotnews2'] as $value) { ?>
<li><a href="<?=$value['url']?>" title="<?=$value['subjectall']?>"><?=$value['subject']?></a></li>
<?php } } ?>
</ul>
</div>
</div><!--col2 end-->
</div><!--column end-->
<?php if(!empty($channels['menus']['uchimage'])) { ?>
<div class="column"><?php block("uchphoto", "updatetime/604800/order/updatetime DESC/limit/0,6/cachetime/86585/subjectlen/12/cachename/uchphoto"); ?><div class="col1">
<div class="global_module">
<div class="global_module1_caption"><h3>相册</h3><a class="more" href="<?php echo geturl("action/uchimage"); ?>">更多&gt;&gt;</a></div>
<ul class="global_piclist">
<?php if(is_array($_SBLOCK['uchphoto'])) { foreach($_SBLOCK['uchphoto'] as $key => $value) { ?>
<li><div><a href="<?=$value['url']?>"><img alt="" src="<?=$value['pic']?>"/></a></div><span><a href="<?=$value['url']?>"><?=$value['albumname']?></a></span></li>
<?php } } ?>
</ul>
</div>
</div><!--col1 end--><?php block("uchphoto", "dateline/604800/order/picnum DESC,updatetime DESC/limit/0,2/cachetime/89477/subjectlen/14/subjectdot/0/cachename/uchphototop"); ?><div class="col2">
<div class="global_module bg_fff">
<div class="global_module2_caption"><h3>精彩推荐</h3></div>
<ul class="global_piclist">
<?php if(is_array($_SBLOCK['uchphototop'])) { foreach($_SBLOCK['uchphototop'] as $key => $value) { ?>
<li><div><a href="<?=$value['url']?>"><img alt="" src="<?=$value['pic']?>"/></a></div><span><a href="<?=$value['url']?>"><?=$value['albumname']?></a></span></li>
<?php } } ?>
</ul>
</div>
</div><!--col2 end-->
</div><!--column end-->
<?php } ?>

<?php if(!empty($channels['menus']['bbs'])) { ?>
<div class="column">
<div class="col1"><?php block("bbsthread", "order/t.dateline DESC/subjectlen/36/subjectdot/0/limit/0,12/cachetime/5630/cachename/newthread"); ?><div class="global_module">
<div class="global_module1_caption"><h3>论坛</h3><a class="more" href="<?php echo geturl("action/bbs"); ?>">更多&gt;&gt;</a></div>
<ul class="global_tx_list1">
<?php if(is_array($_SBLOCK['newthread'])) { foreach($_SBLOCK['newthread'] as $value) { ?>
<li><span class="box_r"><a href="<?=S_URL?>/space.php?uid=<?=$value['authorid']?>"><?=$value['author']?></a></span><a href="<?=$value['url']?>" title="<?=$value['subjectall']?>"><?=$value['subject']?></a></li>
<?php } } ?>
</ul>
</div>
</div><!--col1 end--><?php block("bbsforum", "type/forum/allowblog/1/order/posts DESC/limit/0,6/cachetime/14672/cachename/hotforums"); ?><div class="col2">
<div class="global_module bg_fff">
<div class="global_module2_caption"><h3>版块帖子数排行</h3></div>
<ul class="global_tx_list2">
<?php if(is_array($_SBLOCK['hotforums'])) { foreach($_SBLOCK['hotforums'] as $value) { ?>
<li><span class="box_r"><?=$value['posts']?></span><a href="<?=$value['url']?>"><?=$value['name']?></a></li>
<?php } } ?>
</ul>
</div>
</div><!--col2 end-->
</div><!--column end-->
<?php } ?>

<?php if(!empty($channels['menus']['uchblog'])) { ?>
<?php block("uchblog", "order/dateline DESC/subjectlen/36/subjectdot/0/limit/0,12/cachetime/18400/cachename/hotblog"); ?><div class="column">
<div class="col1">
<div class="global_module">
<div class="global_module1_caption"><h3>日志</h3><a class="more" href="<?php echo geturl("action/uchblog"); ?>">更多&gt;&gt;</a></div>
<ul class="global_tx_list1">
<?php if(is_array($_SBLOCK['hotblog'])) { foreach($_SBLOCK['hotblog'] as $value) { ?>
<li><span class="box_r"><a href="<?=S_URL?>/space.php?uid=<?=$value['uid']?>"><?=$value['username']?></a></span><a href="<?=$value['url']?>" title="<?=$value['subjectall']?>"><?=$value['subject']?></a></li>
<?php } } ?>
</ul>
</div>
</div><!--col1 end--><?php block("uchspace", "order/updatetime DESC/limit/0,8/cachetime/86430/cachename/uchspace"); ?><div class="col2">
<div class="global_module bg_fff">
<div class="global_module2_caption"><h3>最近更新</h3></div>
<ul class="global_avatar_list new_avatar">
<?php if(is_array($_SBLOCK['uchspace'])) { foreach($_SBLOCK['uchspace'] as $value) { ?>
<li><a href="<?=S_URL?>/space.php?uid=<?=$value['uid']?>"><img src="<?=UC_API?>/avatar.php?uid=<?=$value['uid']?>&size=small" alt="<?=$value['username']?>" /></a><span><a href="<?=S_URL?>/space.php?uid=<?=$value['uid']?>"><?=$value['username']?></a></span></li>
<?php } } ?>
</ul>
</div>
</div><!--col2 end-->
</div><!--column end-->
<?php } ?>

<?php if(!empty($ads['pagefootad'])) { ?>
<div class="ad_pagebody"><?=$ads['pagefootad']?></div>
<?php } ?>

<?php if(!empty($_SCONFIG['showindex'])) { ?>
<?php block("friendlink", "order/displayorder/limit/0,$_SCONFIG[showindex]/cachetime/11600/namelen/32/cachename/friendlink/tpl/data"); ?><div id="links">
<h3>友情链接</h3><?php $imglink=$txtlink="";; ?>
<?php if(is_array($_SBLOCK['friendlink'])) { foreach($_SBLOCK['friendlink'] as $value) { ?>
<?php if($value['logo']) { ?>
<?php $imglink .= "<a href=\"".$value['url']."\" target=\"_blank\"><img src=\"".$value['logo']."\" alt=\"".$value['description']."\"  border=\"0\" /></a>\n";; ?>
<?php } else { ?>
<?php $txtlink .= "<li><a href=\"".$value['url']."\" title=\"".$value['description']."\" target=\"_blank\">".$value['name']."</a></li>\n";; ?>
<?php } ?>
<?php } } ?>
<?php if(!empty($imglink)) { ?>
<div class="links_img">
<?=$imglink?>
</div>
<?php } ?>

<?php if(!empty($txtlink)) { ?>
<div class="links_tx">
<ul class="s_clear">
<?=$txtlink?>
</ul>
</div>
<?php } ?>
</div>
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