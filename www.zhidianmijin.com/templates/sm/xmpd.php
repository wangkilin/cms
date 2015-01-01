<?if (!isset($smarty.post.act) || $smarty.post.act<>"ok")?>
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
</SCRIPT><table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">  
  <tbody>
  <form name="form1" method="post" onSubmit="return Check(this)"  action=""> <tr>
      <td class=new bgcolor="#FFFFFF">配对测试 <input name="fs" type="radio" onClick="javacript:document.getElementById('fs11').style.display='none';document.getElementById('fs21').style.display='none';" value="0" checked="" />不测试八字相合程度　<input type="radio" name="fs" value="1" onClick="javacript:document.getElementById('fs11').style.display='block';document.getElementById('fs21').style.display='block';" />同时测试八字相合程度

    </tr>  <tr>
      <td class=new bgcolor="#FFFFFF"><strong>请输入第一个姓名：</strong>
          <input name="name1" type="text" value="<?$xing1?><?$xing2?><?$ming1?><?$ming2?>" />
          &nbsp;
          <select size="1" name="xing1">
<option value="1" <?if (!$xing2) ?>selected="selected"<?/if?>>单姓</option>
<option value="2"<?if ($xing2<>"") ?>selected="selected"<?/if?>>复姓</option>
          </select>
          &nbsp;
          <select size="1" name="sex1">
<option value="男" <?if ($xingbie=="男") ?>selected="selected"<?/if?>>男性</option>
<option value="女" <?if ($xingbie=="女") ?>selected="selected"<?/if?>>女性</option>
          </select><br /><br /><div id="fs11" style="display:none">
<div class="divh2"></div>公历/阳历生日：<select size="1" name="y1"><?selectStepOptions start=1900 end=$_thisYear selected=$nian1 default=1980?></select>年<select name="m1" size="1"><?selectStepOptions start=1 end=12 selected=$yue1 default=$_thisMonth?></select>月<select name="d1" size="1"><?selectStepOptions start=1 end=31 selected=$ri1 default=$_thisDay?></select>日<select size="1" name="h1"> <?selectStepOptions start=0 end=23 selected=$hh1?> </select>点<select size="1" name="f1"><option value="0">未知</option>
		<?selectStepOptions start=0 end=59 selected=$mm1?>
		</select>分&nbsp;<a title="如果您只知道生日的农历日期，不要紧，请点这里去查询公历日期" style="CURSOR: hand" onClick="window.open('wannianli.htm','httpcnnongli','left=0,top=0,width=680,height=480,scrollbars=no,resizable=no,status=no')" href="#wnl1"><font color="#008000">只知道农历生日请点此查询公历</font></a>
<hr size="1">
</div><br /><strong>请输入第二个姓名：</strong>
          <input type="text" name="name2" />
          &nbsp;
          <select size="1" name="xing2">
<option value="1">单姓</option>
<option value="2">复姓</option>
</select>
          &nbsp;
          <select size="1" name="sex2">
<option value="男" <?if ($xingbie=="女") ?>selected="selected"<?/if?>>男性</option>
<option value="女" <?if ($xingbie=="男") ?>selected="selected"<?/if?>>女性</option>
</select><input type="hidden" name="act" value="ok" /><br /><br /><div id="fs21" style="display:none">
公历/阳历生日：<select size="1" name="y2"><?selectStepOptions start=1900 end=$_thisYear selected=1980?></select>年<select name="m2" size="1"><?selectStepOptions start=1 end=12 selected=$_thisMonth?></select>月<select name="d2" size="1"><?selectStepOptions start=1 end=31 selected=$_thisDay?></select>日<select size="1" name="h2"> <?selectStepOptions start=0 end=23?> </select>点<select size="1" name="f2"><option value="0">未知</option>
		<?selectStepOptions start=0 end=59 selected=$mm1?>
		</select>分
       &nbsp;<a title="如果您只知道生日的农历日期，不要紧，请点这里去查询公历日期" style="CURSOR: hand" onClick="window.open('wannianli.htm','httpcnnongli','left=0,top=0,width=680,height=480,scrollbars=no,resizable=no,status=no')" href="#wnl1"><font color="#008000">只知道农历生日请点此查询公历</font></a>
<hr size="1">
</div>
<input type="submit" value="开始测试" style="cursor:hand;" />
      </td>
    </tr> </form>
  </tbody>
</table>
<?else?>
<table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">  
  <tbody>    <tr>
      <td colspan="3" class=new bgcolor="#FFFFFF">姓名：<?$name1?>  性别：<?$sex1?>&nbsp;<?if ($fs==1)?>生日:<?$y1?>年<?$m1?>月<?$d1?>日<?$h1?>时<?$f1?>分<?/if?></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0"  style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">
        <tbody>
          <tr>
            <td bgcolor="#FFFFFF"></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">繁体</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">拼音</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">笔划</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">五行</font></td>
            </tr>
          <tr>
            <td  align="center" bgcolor="#FFFFFF" class="new2"><?$nxing1?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?$nxing1|GbToBig?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?$nxing11|truncate:2|c?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$bihua1?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$nxing11|getzywh?></td>
          </tr>
          <tr>
         <?if ($nxing2<>'' ) ?>   <td align="center" bgcolor="#FFFFFF" class="new2"><?$nxing2?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?$nxing2|GbToBig?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?$nxing22|c?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$bihua2?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$nxing22|getzywh?></td>
          </tr><?/if?>
          <tr>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$nming1?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?$nming1|GbToBig?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?$nming12|c?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$bihua3?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$nming12|getzywh?></td>
          </tr>
          <?if ($nming2<>'' )?><tr>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$nming2?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?$nming2|GbToBig?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?$nming22|c?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$bihua4?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$nming22|getzywh?></td>
          </tr><?/if?>
        </tbody>
      </table></td>
      <td width="25%" colspan="-3" align="center" bgcolor="#FFFFFF"  class="new2">天格-&gt; <?$tiange1?> (<?$tiange1|getsancai?>)  ->(<font color=red><?$tgjx?></font>)<br />
      <p>人格-&gt; <?$renge1?> (<?$renge1|getsancai?>) ->(<font color=red><?$rgjx?></font>)</p>        <p>地格-&gt; <?$dige1?> (<?$dige1|getsancai?>) ->(<font color=red><?$dgjx?></font>)</p></td>
      <td width="25%"  class="new2" align="center" bgcolor="#FFFFFF">外格-&gt; <?$waige1?> (<?$waige1|getsancai?>) ->(<font color=red><?$wgjx?></font>)<br />
      <p>　</p>        <p>总格-&gt; <?$zhongge1?> (<?$zhongge1|getsancai?>) ->(<font color=red><?$zgjx?></font>)</p></td>
    </tr>
    <tr>
      <td colspan="3" class=new bgcolor="#FFFFFF">姓名蕴含的个性分析：<?$xg1?></td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">  
  <tbody> <tr>
      <td colspan="3" class=new bgcolor="#FFFFFF">姓名：<?$name2?>  性别：<?$sex2?> &nbsp;<?if ($fs==1)?>生日:<?$y2?>年<?$m2?>月<?$d2?>日<?$h2?>时<?$f2?>分<?/if?></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0"  style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">
        <tbody>
          <tr>
            <td bgcolor="#FFFFFF"></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">繁体</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">拼音</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">笔划</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">五行</font></td>
            </tr>
          <tr>
            <td  align="center" bgcolor="#FFFFFF" class="new2"><?$n2xing1?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?$n2xing1|GbToBig?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?$n2xing11|truncate:2|c?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$nbihua1?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$n2xing11|getzywh?></td>
          </tr>
          <tr>
         <?if ($n2xing2<>'' ) ?>   <td align="center" bgcolor="#FFFFFF" class="new2"><?$n2xing2?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?$n2xing2|GbToBig?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?$n2xing22|c?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$nbihua2?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$n2xing22|getzywh?></td>
          </tr><?/if?>
          <tr>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$n2ming1?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?$n2ming1|GbToBig?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?$n2ming12|c?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$nbihua3?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$n2ming12|getzywh?></td>
          </tr>
          <?if ($n2ming2<>'' )?><tr>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$n2ming2?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?$n2ming2|GbToBig?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?$n2ming22|c?></font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$nbihua4?></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?$n2ming22|getzywh?></td>
          </tr><?/if?>
        </tbody>
      </table></td>
      <td width="25%" colspan="-3" align="center" bgcolor="#FFFFFF"  class="new2">天格-&gt; <?$ntiange1?> (<?$ntiange1|getsancai?>) 
 ->(<font color=red><?$ntgjx?></font>)<br />
      <p>人格-&gt; <?$nrenge1?> (<?$nrenge1|getsancai?>)
       ->(<font color=red><?$nrgjx?></font>)</p>        <p>地格-&gt; <?$ndige1?> (<?$ndige1|getsancai?>)
 ->(<font color=red><?$ndgjx?></font>)</p></td>
      <td width="25%"  class="new2" align="center" bgcolor="#FFFFFF">外格-&gt; <?$nwaige1?> (<?$nwaige1|getsancai?>)
       ->(<font color=red><?$nwgjx?></font>)<br />
      <p>　</p>        <p>总格-&gt; <?$nzhongge1?> (<?$nzhongge1|getsancai?>)
       ->(<font color=red><?$nzgjx?></font>)</p></td>
    </tr>
    <tr>
      <td colspan="3" class=new bgcolor="#FFFFFF">姓名蕴含的个性分析：<?$xg2?></td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
      <tr>
        <TD class=ttd>经过分析，[<?$name1?>]和[<?$name2?>]的姓名配对评分如下：</TD>
      </tr>      <tr>
        <TD class=new><span class="red">姓名缘份指数：<?$zf?></span></TD>
        </tr>  <tr>
        <TD class=new><?if ($sex1==$sex2)?><font color=red>本站是按中国民俗学的一些测算方法来计算的，暂时不支持同性缘份的测试</font><?else?><font color=green>
		 <?if ($zf<60)?>你们的姓名五格可能不是太合，不过八字配合所起的作用更大，另外彼此的努力也会让你们改善关系，记住：事在人为！
		<?elseif ($zf<70 and zf>=60) ?>
		你们的姓名五格相合程度马马虎虎，不过八字配合所起的作用更大，继续努力改善关系，会对你们的关系有帮助的！ 
		<?elseif ($zf<80 and $zf>=70)?>你们的姓名五格相合一般！ 
		<?elseif ($zf<80 and $zf>=70)?>你们的姓名五格相合程度还不错哟！ 
		<?elseif ($zf<90 and $zf>=80)?>
		你们的姓名五格相合程度相当棒！ 
		<?elseif ($zf>=90)?>
		你们的姓名五格相合程度太棒了！！恭喜！</font><?if ($name1==$name2)?><br /><font color=#0000ff>^_^ 你们俩同名同姓嘛，真巧哟！</font> <?/if?><?/if?>
		<?/if?></TD>
        </tr>
    </TBODY>
</TABLE>
<?/if?>