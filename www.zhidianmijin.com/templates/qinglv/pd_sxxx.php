
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="81%" class="ttd"><span class="red">生肖配对:</span><br>
    属相有鼠、牛、虎、兔、龙、蛇、马、羊、猴、鸡、狗、猪十二种。属相又都是由五行来区分的，而五行则存在着相生相克的道理。相生的属相较能和睦相处，而相克的属相就不那么……了。您是否还对您的爱情犹豫不决啊，那就进来看看你们的生肖配不配吧！<BR></td>
    <td width="19%" class="ttd"><img src="<? $siteTheme ?>/images/sxpd.jpg" width="120" height="90"></td>
</tr>
<form name="form1"  method="post" action="">
<input type="hidden" name="act" value="sxok" />
  <tr>
    <td colspan="2" class="new">
我的生肖：
  <SELECT name="p5" class="style3">
<OPTION value=鼠>鼠</OPTION>
<OPTION value=牛>牛</OPTION>
<OPTION value=虎>虎</OPTION>
<OPTION value=兔>兔</OPTION>
<OPTION value=龙>龙</OPTION>
<OPTION value=蛇>蛇</OPTION>
<OPTION value=马>马</OPTION>
<OPTION value=羊>羊</OPTION>
<OPTION value=猴>猴</OPTION>
<OPTION value=鸡>鸡</OPTION>
<OPTION value=狗>狗</OPTION>
<OPTION value=猪>猪</OPTION>
</SELECT>
  他/她的生肖
  :
  <SELECT name="p6" class="style3">
<OPTION value=鼠 selected>鼠</OPTION>
<OPTION value=牛>牛</OPTION>
<OPTION value=虎>虎</OPTION>
<OPTION value=兔>兔</OPTION>
<OPTION value=龙>龙</OPTION>
<OPTION value=蛇>蛇</OPTION>
<OPTION value=马>马</OPTION>
<OPTION value=羊>羊</OPTION>
<OPTION value=猴>猴</OPTION>
<OPTION value=鸡>鸡</OPTION>
<OPTION value=狗>狗</OPTION>
<OPTION value=猪>猪</OPTION>
</SELECT>
  <input type="submit" name="Submit1" value="开始配对" style="cursor:hand;">
    </form></td>
    </tr>
<? if (isset($smarty.request.act) && $smarty.request.act=="sxok") ?>
<tr bgcolor="#EFF8FE">
<td class="new" colspan="2" valign="middle">
<br>配对生肖：<font color=blue><? $title ?></font><br><br>
<font color=red><? $content1 ?></font><br><br>
<? $content2 ?><br>

</td>
</tr><? /if ?>
</tbody>
</table>  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="79%" class="ttd"><span class="red">血型配对:</span><br>
    血型配对，根据血型测试您和恋人的缘分和婚姻！ <BR></td>
    <td width="21%" class="ttd"><img src="<? $siteTheme ?>/images/xxpd.jpg" width="140" height="94"></td>
</tr>
<form name="form1"  method="post" action="">
<input type="hidden" name="act" value="xxok" />
  <tr>
    <td colspan="2" class="new">
我的血型：
  <SELECT name="p3" class="style3">
<OPTION value=AB>AB型</OPTION>
<OPTION value=A>A型</OPTION>
<OPTION value=B>B型</OPTION>
<OPTION value=O>O型</OPTION>
</SELECT>
  他/她的血型
  :
  <SELECT name="p4" class="style3">
<OPTION value=AB>AB型</OPTION>
<OPTION value=A>A型</OPTION>
<OPTION value=B>B型</OPTION>
<OPTION value=O>O型</OPTION>
</SELECT>
  <input type="submit" name="Submit1" value="开始配对" style="cursor:hand;">
    </form></td>
    </tr>
<? if (isset($smarty.request.act) && $smarty.request.act=="xxok") ?>
<tr bgcolor="#EFF8FE">
<td class="new" colspan="2" valign="middle">
<br>配对生肖：<font color=blue><? $title1 ?></font><br><br>
<font color=red><? $title2 ?></font><br><br>
<? $content ?><br>

</td>
</tr><? /if ?>
</tbody>
</table>
