
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="78%" class="ttd"><span class="red">生男生女:</span>
    <br> <br>想预测一下，你们会生个男宝宝或是女宝宝吗？<br>
    测算数据来自《清宫珍藏的生男生女预测表》，仅供参考，请勿太信！ 
怀孕月份以农历为准。遇闰月，上半月以上个月份计算，下半月以下个月份计算。  </td>
    <td width="22%" class="ttd"><img src="<? $siteTheme ?>/images/snsn.jpg" width="140" height="80"></td>
</tr>
<? if (isset($smarty.request.act) && $smarty.request.act=="ok") ?>

  <tr>
    <td colspan="2" class="new"><font color="#0000FF"><? $mqname?></font>，您好<br>
    <? if ($smarty.request.cs==1) ?>
恭喜您，根据推算，你很可能会有一个&nbsp;<font color="#FF0000"><? $baby?></font>
<? else ?>
您如果想生个<font color="#FF0000"><? $baby?></font>，那么建议您在农历 <font color="#0000FF">今年 ：<? $yuef?>&nbsp;&nbsp;明年：<? $nyuef?></font> 怀孕的话机会比较大！<? /if ?><br><br>
      <a class="red" href="?m=6&sm=9">重新测试</a>  </td>
<? else  ?>
  <tr>
    <td colspan="2" class="ttd"><font color="#FF0000">*年龄为母亲虚岁年龄，月份指怀孕月份，以农历为准。遇闰月，上半月以上个月份计算，下半月以下个月份计算。</font>
   </td>
    </tr>  <tr>
    <td colspan="2" class="ttd"><font color="#0000ff">*我要预测宝宝性别：</font>
   </td>
    </tr><form name="theform" method="post" action="">
<input type="hidden" name="act" value="ok" />
<input type="hidden" name="cs" value="1" /><tr>
    <td colspan="2" class="ttd">我的芳名叫：<input name="mqname" type="text">&nbsp;,今年芳龄(虚岁)是:<select name="nn" size="1" style="font-size: 9pt">
      ><?selectStepOptions start=18 end=45 selected=22?>
     </select>&nbsp;,怀孕的月份(农历)是:<select name="yue" size="1" style="font-size: 9pt">
      ><?selectStepOptions start=1 end=12?>
     </select>月 &nbsp;<input name="sub" type="submit" value="开始推算">
   </td></form>
    </tr> <tr>
    <td colspan="2" class="ttd"><font color="#0000ff">*我要查询适合怀孕的月份：</font>
   </td>
    </tr><form name="theform" method="post" action="">
<input type="hidden" name="act" value="ok" />
<input type="hidden" name="cs" value="2" /><tr>
    <td colspan="2" class="new">我的芳名叫：<input name="mqname" type="text">&nbsp;,今年芳龄(虚岁)是:<select name="nn" size="1" style="font-size: 9pt">
      >
      <?selectStepOptions start=18 end=45 selected=22?>
     </select>&nbsp;,我计划生个:<select name="snsn" size="1" style="font-size: 9pt">
       <option value="男">小王子</option>
       <option value="女">小公主</option>

     </select>
     &nbsp;
     <input name="sub" type="submit" value="开始推算">
   </td></form>
    </tr><? /if ?>
</tbody>
</table>
 