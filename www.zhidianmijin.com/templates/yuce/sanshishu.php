<SCRIPT language=JavaScript>
<!--
function IsCn(Str)
{
    for(i=0;i<Str.length;i++) {
        if(41125<Str.charCodeAt(i) || Str.charCodeAt(i)<20224) {
            return false;
        }
    }
    return true;
}
function submitchecken() {
	if (document.cidu.youname1.value == "") {
		alert("请输入姓氏。");
		document.cidu.youname1.focus();
		return false;
		}
	if (IsCn(document.cidu.youname1.value)==false) {
		alert("输入出错,应该都为汉字。");
		document.cidu.youname1.focus();
		return false;
		}
	if (document.cidu.youname1.value.length > 2) {
		alert("姓氏输入出错,不能多于2字。");
		document.cidu.youname1.focus();
		return false;
		}

	if (document.cidu.youname2.value == "") {
		alert("请输入名。");
		document.cidu.youname2.focus();
		return false;
		}
	if (IsCn(document.cidu.youname2.value)==false) {
		alert("输入出错,应该都为汉字。");
		document.cidu.youname2.focus();
		return false;
		}
	if (document.cidu.youname2.value.length > 2) {
		alert("名字输入出错,不能多于2字。");
		document.cidu.youname2.focus();
		return false;
		}
	if (document.cidu.nn.value.length != 4) {
		alert("年的位数出错了,必须为4位。");
		document.cidu.nian.focus();
		return false;
		}
	
	re="请重新输入！";
 	y=document.cidu.nian.value;
 	m=document.cidu.yue.value;

 	h=document.cidu.hh.value;

	if (y==""||y<1901||y>2050) {
		alert("年应在1901和2050之间。"+re);
		document.cidu.nian.focus();
		return false;
		}
	if (m>12||m<1) {
		alert("月应在1与12之间。"+re);
		document.cidu.yue.focus();
		return false;
		}


	if (h>23||h<0) {
		alert("时应在0与23之间。"+re);
		document.cidu.hh.focus();
		return false;
		}
	return true;
	}
//-->
</SCRIPT>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="79%" class="ttd"><span class="red">&lt;&lt;三世书-财运篇&gt;&gt; 看看你的财运是属于哪种类型?</span>
    <br>
介绍:三世书是传说中一本可以看到你前世,今生和后世的书.里面所有人的一切都包括.这个财运篇是专门从里面精选而来,可以算到你的财运属于哪种类型的,据说很准的哦,试试吧~~</td>
    <td width="21%" class="ttd"><img src="<? $siteTheme ?>/images/sss.gif"></td>
</tr>
<form method="post" action="?m=6&sm=8" name=cidu  onsubmit="return submitchecken();">
  <tr>
    <td colspan="2" class="new"><div align=center>
  	姓：<input type=txt name=youname1 size=4 value=""  onKeypress="if ((event.keyCode != 13 && event.keyCode < 160)) event.returnValue = false;">
  	名：<input type=txt name=youname2 size=4 value=""  onKeypress="if ((event.keyCode != 13 && event.keyCode < 160)) event.returnValue = false;">
  	性别：<select name="sex" size="1" style="font-size: 9pt">
  	<option value="男" selected>男</option>
  	<option value="女" >女</option>
  	    </select>
  	请输入农历生辰!:<input name="nx" size="1" type=hidden value="公历"><select name="nn" size="1" id="nn" style="font-size: 9pt">            
        <?selectStepOptions start=1900 end=2158 selected=$_thisYear?>        
        
      </select>年
      <select size="1" name="yue" style="font-size: 9pt">           
        <?selectStepOptions start=1 end=12 selected=$_thisMonth?>            
      </select>月
   <select size="1" name="ri" style="font-size: 9pt">         
        <?selectStepOptions start=1 end=31 selected=$_thisDay?>          
    </select>日
      <select size="1" name="hh" style="font-size: 9pt">
      <?selectStepOptions start=0 end=23 ?>  
      </select>点
      <input type="submit" name="btnAdd" value="测算"></td>
    </tr><tr bgcolor="#EFF8FE">
  <td class="new" colspan="2" valign="middle"><div align="center"><A href='#' style='cursor:hand;' onclick="window.open('wannianli.htm','cidunongli','left=160,top=100,width=700,height=400,scrollbars=no,resizable=no,status=no')" title="如果您只知道生日的公历日期，不要紧，请点这里去查询农历日期">[<font color=red>查询农历生日</font>]</a></div></td>
</tr>
<? if ($smarty.request.nn) ?>

<tr bgcolor="#EFF8FE">
<td class="new" colspan="2" valign="middle">
<br><br>&nbsp;预测结果如下：<br><br>&nbsp;你的财运属<font size='6' color=red>『<? $content ?>』</font><br><br>&nbsp;&nbsp;&nbsp;&nbsp;<? $content1 ?>

</td>
</tr><? /if ?>
</tbody>
</table>
