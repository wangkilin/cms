<?php /* Smarty version 2.6.6, created on 2010-07-26 10:04:44
         compiled from index.htm */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['siteCharset']; ?>
" />
<?php unset($this->_sections['siteMeta']);
$this->_sections['siteMeta']['name'] = 'siteMeta';
$this->_sections['siteMeta']['loop'] = is_array($_loop=$this->_tpl_vars['siteMetas']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['siteMeta']['show'] = true;
$this->_sections['siteMeta']['max'] = $this->_sections['siteMeta']['loop'];
$this->_sections['siteMeta']['step'] = 1;
$this->_sections['siteMeta']['start'] = $this->_sections['siteMeta']['step'] > 0 ? 0 : $this->_sections['siteMeta']['loop']-1;
if ($this->_sections['siteMeta']['show']) {
    $this->_sections['siteMeta']['total'] = $this->_sections['siteMeta']['loop'];
    if ($this->_sections['siteMeta']['total'] == 0)
        $this->_sections['siteMeta']['show'] = false;
} else
    $this->_sections['siteMeta']['total'] = 0;
if ($this->_sections['siteMeta']['show']):

            for ($this->_sections['siteMeta']['index'] = $this->_sections['siteMeta']['start'], $this->_sections['siteMeta']['iteration'] = 1;
                 $this->_sections['siteMeta']['iteration'] <= $this->_sections['siteMeta']['total'];
                 $this->_sections['siteMeta']['index'] += $this->_sections['siteMeta']['step'], $this->_sections['siteMeta']['iteration']++):
$this->_sections['siteMeta']['rownum'] = $this->_sections['siteMeta']['iteration'];
$this->_sections['siteMeta']['index_prev'] = $this->_sections['siteMeta']['index'] - $this->_sections['siteMeta']['step'];
$this->_sections['siteMeta']['index_next'] = $this->_sections['siteMeta']['index'] + $this->_sections['siteMeta']['step'];
$this->_sections['siteMeta']['first']      = ($this->_sections['siteMeta']['iteration'] == 1);
$this->_sections['siteMeta']['last']       = ($this->_sections['siteMeta']['iteration'] == $this->_sections['siteMeta']['total']);
?>
   <meta <?php if (count($_from = (array)$this->_tpl_vars['siteMetas'][$this->_sections['siteMeta']['index']])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?> <?php echo $this->_tpl_vars['key']; ?>
="<?php echo $this->_tpl_vars['item']; ?>
"<?php endforeach; unset($_from); endif; ?> />
<?php endfor; endif; ?>
<title><?php echo $this->_tpl_vars['siteName']; ?>
</title>
<SCRIPT LANGUAGE="JavaScript" src="<?php echo $this->_tpl_vars['siteTheme']; ?>
/js/diary_book.js"></SCRIPT>
<link href="<?php echo $this->_tpl_vars['siteTheme']; ?>
/css/diary_book.css" type=text/css rel=stylesheet>
<link rel="shortcut icon" href="http://www.zhidianmijin.com/favicon.ico" />
</head>

<body>
<div id="Layer1"><img src="<?php echo $this->_tpl_vars['siteTheme']; ?>
/images/logo.gif" alt="Logo" width="85" height="85" id="logo"/></div>
<div id="Layer2">
<div id="Menu">
<ul>
<?php if (isset($this->_foreach['rootMenu'])) unset($this->_foreach['rootMenu']);
$this->_foreach['rootMenu']['total'] = count($_from = (array)$this->_tpl_vars['siteMenu']);
$this->_foreach['rootMenu']['show'] = $this->_foreach['rootMenu']['total'] > 0;
if ($this->_foreach['rootMenu']['show']):
$this->_foreach['rootMenu']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['subMenu']):
        $this->_foreach['rootMenu']['iteration']++;
        $this->_foreach['rootMenu']['first'] = ($this->_foreach['rootMenu']['iteration'] == 1);
        $this->_foreach['rootMenu']['last']  = ($this->_foreach['rootMenu']['iteration'] == $this->_foreach['rootMenu']['total']);
?>
<li class='rootMenu'><a href=?m=<?php echo $this->_tpl_vars['key']; ?>
><?php echo $this->_tpl_vars['subMenu']['menuName']; ?>
</a>
<?php if (( count ( $this->_tpl_vars['subMenu']['subModules'] ) )): ?>
<ul>
<?php if (isset($this->_foreach['subMenu'])) unset($this->_foreach['subMenu']);
$this->_foreach['subMenu']['total'] = count($_from = (array)$this->_tpl_vars['subMenu']['subModules']);
$this->_foreach['subMenu']['show'] = $this->_foreach['subMenu']['total'] > 0;
if ($this->_foreach['subMenu']['show']):
$this->_foreach['subMenu']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['subKey'] => $this->_tpl_vars['subMenuName']):
        $this->_foreach['subMenu']['iteration']++;
        $this->_foreach['subMenu']['first'] = ($this->_foreach['subMenu']['iteration'] == 1);
        $this->_foreach['subMenu']['last']  = ($this->_foreach['subMenu']['iteration'] == $this->_foreach['subMenu']['total']);
?>
 <?php if (( $this->_tpl_vars['subMenuName'] )): ?>
<li class='subMenu'><a href=?m=<?php echo $this->_tpl_vars['key']; ?>
&sm=<?php echo $this->_tpl_vars['subKey']+1; ?>
><?php echo $this->_tpl_vars['subMenuName']; ?>
</a></li>
<?php endif; ?>
<?php endforeach; unset($_from); endif; ?>
</ul>
<?php endif; ?>
</li>
<?php endforeach; unset($_from); endif; ?>
</ul></div>
<div id="Layer3" background="<?php echo $this->_tpl_vars['siteTheme']; ?>
/images/image55_r2_c1.gif"></div>
<div id="Layer4" background="<?php echo $this->_tpl_vars['siteTheme']; ?>
/images/bookBodyBg.gif">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['includePage']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<div id="Layer5" background="<?php echo $this->_tpl_vars['siteTheme']; ?>
/images/image55_r2_c3.gif"></div>

</div>

<div id="Layer6">
<div style="font-size:12px">
<font color=red><b>免责声明</b></font>：<br> 1.本站算命系统来源于中国民俗学的一些测算方法，并非科学研究成果，仅供休闲娱乐，请勿迷信，按此操作一切后果自负！<br>2.任何人均不得将本算命系统用于任何非法用途，且必须自行承担因使用本系统带来的任何后果和责任。 
<br>祝您在本站玩的愉快，且每日吉星高照！希望您把本站推荐给朋友，或者链接到您的网页和博客上，谢谢！
<br><br>&nbsp;   &nbsp; 联系站长  &nbsp; Email:zhidianmijin@126.com   &nbsp; QQ:994640800   &nbsp; MSN:zhidianmijin@hotmail.com
<br><center>京ICP备09076694号</center>
</div>
</div>
<div id="left_top_ad">
东方时尚驾校代约车
<br>QQ:994640800
</div>

<!-- text add. 3 row X 3 column 
<div id="bottom_ad">
</div>-->
<!-- <SCRIPT LANGUAGE="JavaScript" src="medias/<?php echo $this->_tpl_vars['siteTheme']; ?>
/js/ad_sender.php"></SCRIPT> -->
</body>
</html>