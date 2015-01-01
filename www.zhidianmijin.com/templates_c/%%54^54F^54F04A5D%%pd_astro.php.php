<?php /* Smarty version 2.6.6, created on 2009-06-28 07:17:05
         compiled from qinglv/pd_astro.php */ ?>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="79%" class="ttd"><span class="red">星座对对配:</span><br>
    你相信<strong>星座配对</strong>吗？最佳的星座配能保证你的爱情浪漫永久吗？您认为星座是科学吗？星座真的有神奇力量吗？不管信或不信，测试一下看看先~~~~~<BR></td>
    <td width="21%" class="ttd"><img src="diary_book/images/pdxz.jpg" width="134" height="84"></td>
</tr>
<form name="form1"  method="post" action="">
<input type="hidden" name="act" value="ok" />
  <tr>
    <td colspan="2" class="new">
我的星座：
  <SELECT name="p1" class="style3">
  <OPTION value=白羊座>白羊座</OPTION>
  <OPTION value=金牛座>金牛座</OPTION>
  <OPTION value=双子座>双子座</OPTION>
  <OPTION value=巨蟹座>巨蟹座</OPTION>
  <OPTION value=狮子座>狮子座</OPTION>
  <OPTION value=处女座>处女座</OPTION>
  <OPTION value=天秤座>天秤座</OPTION>
  <OPTION value=天蝎座>天蝎座</OPTION>
  <OPTION value=射手座>射手座</OPTION>
  <OPTION value=摩羯座>摩羯座</OPTION>
  <OPTION value=水瓶座>水瓶座</OPTION>
  <OPTION value=双鱼座>双鱼座</OPTION>
  </SELECT>
  他/她的星座
  :
  <SELECT name="p2" class="style3">
  <OPTION value=白羊座 selected>白羊座</OPTION>
  <OPTION value=金牛座>金牛座</OPTION>
  <OPTION value=双子座>双子座</OPTION>
  <OPTION value=巨蟹座>巨蟹座</OPTION>
  <OPTION value=狮子座>狮子座</OPTION>
  <OPTION value=处女座>处女座</OPTION>
  <OPTION value=天秤座>天秤座</OPTION>
  <OPTION value=天蝎座>天蝎座</OPTION>
  <OPTION value=射手座>射手座</OPTION>
  <OPTION value=摩羯座>摩羯座</OPTION>
  <OPTION value=水瓶座>水瓶座</OPTION>
  <OPTION value=双鱼座>双鱼座</OPTION>
  </SELECT>
  <input type="submit" name="Submit1" value="开始配对" style="cursor:hand;">
    </form></td>
    </tr>
<?php if (( isset ( $_REQUEST['act'] ) && $_REQUEST['act'] == 'ok' )): ?>

<tr bgcolor="#EFF8FE">
<td class="new" colspan="2" valign="middle">
<br>双方星座：<font color=blue><?php echo $this->_tpl_vars['title']; ?>
 </font><br><br>
<font color=red><?php echo $this->_tpl_vars['content1']; ?>
</font><br><br>
<?php echo $this->_tpl_vars['content2']; ?>
 <br>
</td>
</tr><?php endif; ?>
</tbody>
</table>