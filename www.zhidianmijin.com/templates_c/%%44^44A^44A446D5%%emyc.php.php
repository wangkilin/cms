<?php /* Smarty version 2.6.6, created on 2009-06-27 02:26:06
         compiled from yuce/emyc.php */ ?>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="79%" class="ttd"><span class="red">耳鸣预测:</span>
    <br>
    耳朵里好象有“小蜜蜂”在“嗡嗡嗡”，或者时刻像在听“摇滚乐”？你这是耳鸣现象啦！为什么会耳鸣呢？当然有科学的解释，也有一些是科学所不能告诉你的部分哦^_^   通过耳鸣占卜，看看这种耳鸣预测出你将来会发生什么事情哦。</td>
    <td width="21%" class="ttd"><img src="diary_book/images/em.jpg" width="140" height="107"></td>
</tr>
<form name="form1" onSubmit="return submitchecken()" method="post" action="">
<input type="hidden" name="act" value="ok" />
  <tr>
    <td colspan="2" class="new">选择耳朵：
       
<input id="fx" type="radio" CHECKED="" value="左" name="fx" />
左&nbsp;<input id="fx" type="radio" value="右" name="fx" />
右&nbsp;&nbsp;耳鸣时间：<select id="stime" style="WIDTH: 100px" name="stime" size="1">
<option value="1" selected="">23-01[子时]</option>
<option value="2">01-03[丑时]</option>
<option value="3">03-05[寅时]</option>
<option value="4">05-07[卯时]</option>
<option value="5">07-09[辰时]</option>
<option value="6">09-11[巳时]</option>
<option value="7">11-13[午时]</option>
<option value="8">13-15[未时]</option>
<option value="9">15-17[申时]</option>
<option value="10">17-19[酉时]</option>
<option value="11">19-21[戌时]</option>
<option value="12">21-23[亥时]</option>
</select> <input type="submit" value="开始分析" style="cursor:hand;" /></form></td>
    </tr>
<?php if (( $this->_tpl_vars['rs'] )): ?>

<tr bgcolor="#EFF8FE">
<td class="new" colspan="2" valign="middle">
<br><br>&nbsp;预测结果如下：<br><br>&nbsp;<font color=blue><?php echo $this->_tpl_vars['rs']['content']; ?>
</font><br><br>
</td>
</tr><?php endif; ?>
</tbody>
</table>