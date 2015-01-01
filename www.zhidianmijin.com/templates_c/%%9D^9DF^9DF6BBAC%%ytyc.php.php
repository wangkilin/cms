<?php /* Smarty version 2.6.6, created on 2009-06-28 14:15:11
         compiled from yuce/ytyc.php */ ?>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="79%" class="ttd"><span class="red">眼跳预测:</span>
    <br>
    眼皮跳跳，是祸是福？是灾是喜？想知道是情人想你，呃，还是老妈在念叨？又或者是老板要找你“谈话”？！别急别急，有关于眼跳吉凶、眼跳释意、眼跳征兆等的一切，眼跳释义都会告诉你哦。</td>
    <td width="21%" class="ttd"><img src="diary_book/images/yt.jpg" width="140" height="140"></td>
</tr>
<form name="form1" onSubmit="return submitchecken()" method="post" action="">
<input type="hidden" name="act" value="ok" />
  <tr>
    <td colspan="2" class="new">选择眼睛：
       
<input id="fx" type="radio" CHECKED="" value="左" name="fx" />
左&nbsp;<input id="fx" type="radio" value="右" name="fx" />
右&nbsp;&nbsp;眼跳时间：<select id="stime" style="WIDTH: 100px" name="stime" size="1">
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