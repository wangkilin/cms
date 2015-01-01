<SCRIPT language=javascript>
<!--
function Check(theForm)
{
var name1 = theForm.name1.value;
if (name1 == "") 
{
alert("请输入您的姓名！");
theForm.name1.value="";
theForm.name1.focus();
return false;
}
if (theForm.name1.value.length < 2 || theForm.name1.value.length>4)
{
alert("错误：名字应在2-4个字之间！");
theForm.name1.focus();
return (false);
}
if (name1.search(/[`1234567890-=\~!@#$%^&*()_+|<>;':",.?/ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz]/) != -1) 
{
alert("请务必输入简体汉字！");
theForm.name1.value = "";
theForm.name1.focus();
return false;
}
var name2 = theForm.name2.value;
if (name2 == "") 
{
alert("请输入您爱人的名字！");
theForm.name2.value="";
theForm.name2.focus();
return false;
}
if (theForm.name2.value.length < 2 || theForm.name2.value.length>4)
{
alert("错误：名字应在2-4个字之间！");
theForm.name2.focus();
return (false);
}
if (name2.search(/[`1234567890-=\~!@#$%^&*()_+|<>;':",.?/ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz]/) != -1) 
{
alert("请务必输入简体汉字！");
theForm.name2.value = "";
theForm.name2.focus();
return false;
}

}

//-->
</SCRIPT> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="81%" class="ttd"><span class="red">姓名五格配对评分:</span><br>
    根据《易经》的"象"、"数"理论，依据姓名的笔画数和一定规则建立起来天格、地格、人格、总格、外格等五格数理关系，并运用阴阳五行相生相克理论，来推算的各方面运势。 </td>
    <td width="19%" class="ttd"><img src="<? $siteTheme ?>/images/xmpd.jpg" width="105" height="140"></td>
</tr>
<form name="form1" onSubmit="return Check(this)" method="post" action="">
<input type="hidden" name="act" value="ok" />
  <tr>
    <td colspan="2" class="new">
请输入您的姓名：<input name="name1" type="text" id="name1" size="20" onKeyUp="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" maxLength="4">&nbsp;<select size="1" name="xing1">
<option value="1" <? if ($xing2=="" ) ?>selected="selected"<? /if ?>>单姓</option>
<option value="2"<? if ($xing2<>"" ) ?>selected="selected"<? /if ?>>复姓</option>
          </select>&nbsp;<select size="1" name="sex1">
<option value="男" <? if ($xingbie=="男" ) ?>selected="selected"<? /if ?>>男性</option>
<option value="女" <? if ($xingbie=="女" ) ?>selected="selected"<? /if ?>>女性</option>
          </select>
  <tr>
    <td colspan="2" class="new">输入另一个姓名:  <input name="name2" type="text" id="name2" size="20" onKeyUp="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" maxLength="4">&nbsp;<select size="1" name="xing2">
<option value="1">单姓</option>
<option value="2">复姓</option>
</select>&nbsp;<select size="1" name="sex2">
<option value="男" <? if ($xingbie=="女" ) ?>selected="selected"<? /if ?>>男性</option>
<option value="女" <? if ($xingbie=="男" ) ?>selected="selected"<? /if ?>>女性</option>
</select>
<input type="submit" name="Submit1" value="开始测试" style="cursor:hand;">
  </form>
    </tr></tbody>
</table>
<?if (isset($smarty.post.act) && $smarty.post.act=="ok") ?>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#5391EE"  style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">  
  <tbody>    <tr>
      <td colspan="3" class=new bgcolor="#FFFFFF">姓名：<?  $name1 ?>  性别：<?  $sex1 ?>  </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="2" cellspacing="1"  style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">
        <tbody>
          <tr>
            <td bgcolor="#FFFFFF"></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">繁体</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">拼音</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">笔划</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">五行</font></td>
            </tr>
          <tr>
            <td  align="center" bgcolor="#FFFFFF" class="new2"><?  $nxing1 ?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?  $nxing1|GbToBig ?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?  $nxing11|truncate:2|c ?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $bihua1 ?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $nxing11|getzywh ?></td>
          </tr>
          <tr>
         <? if ($nxing2<>"") ?>   <td align="center" bgcolor="#FFFFFF" class="new2"><?  $nxing2 ?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?  $nxing2|GbToBig ?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?  $nxing22|c ?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $bihua2 ?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $nxing22|getzywh ?></td>
          </tr><? /if ?>
          <tr>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $nming1 ?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?  $nming1|GbToBig ?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?  $nming12|c ?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $bihua3 ?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $nming12|getzywh ?></td>
          </tr>
          <? if ($nming2<>"") ?><tr>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $nming2 ?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?  $nming2|GbToBig ?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?  $nming22|c ?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $bihua4 ?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $nming22|getzywh ?></td>
          </tr><? /if ?>
        </tbody>
      </table></td>
      <td width="25%" colspan="-3" align="center" bgcolor="#FFFFFF"  class="new2">天格-&gt; <?  $tiange1 ?> (<?  $tiange1|getsancai ?>) 
 ->(<font color=red><?  $tgjx ?></font>)<br />
      <p>人格-&gt; <?  $renge1 ?> (<?  $renge1|getsancai ?>)
 ->(<font color=red><?  $rgjx ?></font>)</p>        <p>地格-&gt; <?  $dige1 ?> (<?  $dige1|getsancai ?>)
 ->(<font color=red><?  $dgjx ?></font>)</p></td>
      <td width="25%"  class="new2" align="center" bgcolor="#FFFFFF">外格-&gt; <?  $waige1 ?> (<?  $waige1|getsancai ?>)
 ->(<font color=red><?  $wgjx ?></font>)<br />
      <p>　</p>        <p>总格-&gt; <?  $zhongge1 ?> (<?  $zhongge1|getsancai ?>)
 ->(<font color=red><?  $zgjx ?></font>)</p></td>
    </tr>
    <tr>
      <td colspan="3" class=new bgcolor="#FFFFFF">姓名蕴含的个性分析：<?  $xg1 ?><? $tiangee1 ?>=<? $rengee1 ?>=<? $digee1 ?></td>
    </tr>
  </tbody>
</table>

<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#5391EE"  style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">  
  <tbody> <tr>
      <td colspan="3" class=new bgcolor="#FFFFFF">姓名：<?  $name2 ?>  性别：<?  $sex2 ?>  </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="2" cellspacing="1"  style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">
        <tbody>
          <tr>
            <td bgcolor="#FFFFFF"></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">繁体</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">拼音</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">笔划</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">五行</font></td>
            </tr>
          <tr>
            <td  align="center" bgcolor="#FFFFFF" class="new2"><?  $n2xing1 ?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?  $n2xing1|GbToBig ?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?  $n2xing11|truncate:2|c ?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $nbihua1 ?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $n2xing11|getzywh ?></td>
          </tr>
          <tr>
         <? if ($n2xing2<>"") ?>   <td align="center" bgcolor="#FFFFFF" class="new2"><?  $n2xing2 ?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?  $n2xing2|GbToBig ?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?  $n2xing22|c ?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $nbihua2 ?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $n2xing22|getzywh ?></td>
          </tr><? /if ?>
          <tr>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $n2ming1 ?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?  $n2ming1|GbToBig ?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?  $n2ming12|c ?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $nbihua3 ?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $n2ming12|getzywh ?></td>
          </tr>
          <? if ($n2ming2<>"") ?><tr>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $n2ming2 ?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?  $n2ming2|GbToBig ?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?  $n2ming22|c ?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $nbihua4 ?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?  $n2ming22|getzywh ?></td>
          </tr><? /if ?>
        </tbody>
      </table></td>
      <td width="25%" colspan="-3" align="center" bgcolor="#FFFFFF"  class="new2">天格-&gt; <?  $ntiange1 ?> (<?  $ntiange1|getsancai ?>) 
 ->(<font color=red><?  $tgjx ?></font>)<br />
      <p>人格-&gt; <?  $nrenge1 ?> (<?  $nrenge1|getsancai ?>)
 ->(<font color=red><?  $rgjx ?></font>)</p>        <p>地格-&gt; <?  $ndige1 ?> (<?  $ndige1|getsancai ?>)
 ->(<font color=red><?  $dgjx ?></font>)</p></td>
      <td width="25%"  class="new2" align="center" bgcolor="#FFFFFF">外格-&gt; <?  $nwaige1 ?> (<?  $nwaige1|getsancai ?>)
 ->(<font color=red><?  $wgjx ?></font>)<br />
      <p>　</p>        <p>总格-&gt; <?  $nzhongge1 ?> (<?  $nzhongge1|getsancai ?>)
 ->(<font color=red><?  $zgjx ?></font>)</p></td>
    </tr>
    <tr>
      <td colspan="3" class=new bgcolor="#FFFFFF">姓名蕴含的个性分析：<?  $xg1 ?></td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
      <tr>
        <TD class=ttd>经过分析，[<?  $name1 ?>]和[<?  $name2 ?>]的姓名配对评分如下：</TD>
      </tr>      <tr>
        <TD class=new>姓名缘份指数：<span class="pf"><?  $zf  ?></span></TD>
        </tr>  <tr>
        <TD class=new><? if ($sex1==$sex2) ?><font color=red>本站是按中国民俗学的一些测算方法来计算的，暂时不支持同性缘份的测试</font><?  else ?><font color=green>
		 <? if ($zf<60) ?>你们的姓名五格可能不是太合，不过八字配合所起的作用更大，另外彼此的努力也会让你们改善关系，记住：事在人为！
		<? elseif ($zf<70 and $zf>=60) ?>
		你们的姓名五格相合程度马马虎虎，不过八字配合所起的作用更大，继续努力改善关系，会对你们的关系有帮助的！ 
		<?  elseif ( $zf<80 and $zf>=70) ?>你们的姓名五格相合一般！ 
		<?  elseif ( $zf<80 and $zf>=70) ?>你们的姓名五格相合程度还不错哟！ 
		<?  elseif ($zf<90 and $zf>=80) ?>
		你们的姓名五格相合程度相当棒！ 
		<?  elseif ( $zf>=90) ?>
		你们的姓名五格相合程度太棒了！！恭喜！</font><? if ($name1==$name2) ?><br /><font color=#0000ff>^_^ 你们俩同名同姓嘛，真巧哟！</font> <? /if ?><? /if ?>
		<? /if ?></TD>
        </tr>
    </TBODY>
</TABLE>
<? /if ?>

