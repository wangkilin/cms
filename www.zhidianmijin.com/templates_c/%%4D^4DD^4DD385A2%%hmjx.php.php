<?php /* Smarty version 2.6.6, created on 2009-06-29 06:59:32
         compiled from yuce/hmjx.php */ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="78%" class="ttd"><span class="red">号码吉凶:</span>
    <br> <br>
    本数理分析系统可以分析手机号码、电话号码、QQ号码等号码的数理吉凶。有些人会问，号码为什么可能会影响一个人的运势？其实这就像姓名、风水会影响运势命运的意义是一样的。虽然这只是一个号码，但是它与您的生活息息相关，也是您与很多人沟通的桥梁！所以『吉』与『凶』关系非常大，的确不可轻忽！ </td>
    <td width="22%" class="ttd"><img src="../images/hm.gif" width="142" height="155"></td>
</tr>
<form name="theform" onSubmit="return checkjx();" method="post" action="">
<input type="hidden" name="act" value="ok" />
  <tr>
    <td colspan="2" class="ttd">
请输入要分析的号码：<input type="text" name="word" size="20" maxlength="20" onKeyUp="value=value.replace(/[^\d]/g,'') " onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" />
号码类型：<input id="qq" type=radio name=k value="QQ号码" checked>
          <label for="qq">QQ号</label> <input id="sj" type=radio name=k value="手机号码">
          <label for="sj">手机号</label> <input id="qt" type=radio name=k value="">
          <label for="qt">其它号码</label>
<input type="submit" name="Submit1" value="立刻分析" style="cursor:hand;"></form></td>
    </tr>
<?php if (( $this->_tpl_vars['word'] )): ?>
<tr bgcolor="#EFF8FE">
<td class="ttd" colspan="2" valign="middle">您分析的号码：<?php echo $this->_tpl_vars['k']; ?>
 <span class="red"><?php echo $this->_tpl_vars['word']; ?>
</span></td>
</tr><tr bgcolor="#EFF8FE">
<td class="ttd" colspan="2" valign="middle">号码吉凶分析：<font color=blue><strong><?php echo $this->_tpl_vars['title']; ?>
</strong></font> <span class="red"><?php echo $this->_tpl_vars['jx']; ?>
</span>
</td>
</tr><tr bgcolor="#EFF8FE">
<td class="new" colspan="2" valign="middle">主人个性分析：<?php echo $this->_tpl_vars['content']; ?>

</td>
</tr>
<?php endif; ?>
</tbody>
</table>