<?php /* Smarty version 2.6.6, created on 2009-06-29 07:09:32
         compiled from yuce/zwsm.php */ ?>
<SCRIPT language="JavaScript">
<!--
function submitchecken() {
if (document.form1.zwdm.value == "") {
alert("请输入您的指纹代码！");
document.form1.zwdm.focus();
return false;
}
if (document.form1.zwdm.value.length != 5) {
alert("指纹代码输入出错，应该为5个X或O的字母！");
document.form1.zwdm.focus();
return false;
}
return true;
}
//-->
</SCRIPT>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="63%" class="ttd"><span class="red">指纹预测:</span>
    <br>
    据研究报告发现，人的性格是与生具来的。令人奇怪的是，人的指纹也是终生不变的。世界上绝对找不到两个指纹完全相同的人，所以“指纹”就被当作犯罪侦查上的重要线索之一。虽然我们的身体是由遗传所造成，且随着环境会发生变化，只有指纹始终不会发生变化。指纹，大致可分为“涡纹”（又叫斗或叫箩）和“流纹”（又叫簸箕）两种。随着形状的不同，其性格和命运也不相同。想不想得知其中之奥妙？ 
下面的测算程序可以通过指纹研究人的性格，辅助使您对自己或他人的性格有一定的了解，在生活中泰然处之。方法如下：<font color=red>男左手，女右手。</font><font color=blue>从拇指开始，斗（或叫箩）用O(OPQ的O，不是零0），簸箕用X（XYZ的X）代表。输入5个指纹代码，然后按《立刻测算》按钮，结果即出。</font></td>
    <td width="37%" class="ttd"><img src="diary_book/images/zw.gif" width="258" height="200"></td>
</tr>
<form name="form1" onSubmit="return submitchecken()" method="post" action="">
<input type="hidden" name="act" value="ok" />
  <tr>
    <td colspan="2" class="new">
请输入您的指纹代码：<input name="zwdm" type="text" id="zwdm" size="20" maxLength="5"> 
<input type="submit" name="Submit1" value="立刻测算" style="cursor:hand;"></form></td>
    </tr>
<?php if (( $this->_tpl_vars['rs'] )): ?>

<tr bgcolor="#EFF8FE">
<td class="new" colspan="2" valign="middle">
您的指纹代码为：<font color=blue><?php echo $this->_tpl_vars['rs']['zhiwen']; ?>
</font><br><br>
性格解析：<font color=ff1100><?php echo $this->_tpl_vars['rs']['jiexi']; ?>
</font>
</td>
</tr><?php endif; ?>
</tbody>
</table>