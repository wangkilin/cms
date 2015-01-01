<script language="JavaScript">
<!--
function checkbz()
{
var year=document.theform.y.value;
var month=document.theform.m.value;
var day=document.theform.d.value;
var hour=document.theform.hh.value;
var now=new Date();
var nowyear=now.getUTCFullYear ();
var nowmonth=now.getMonth();

if (year=='')
{
alert('请选择出生年份！');
document.theform.y.focus()
return false;
}
if (year>nowyear || year <=nowyear-100 || isNaN(year))
{
alert('请选择正确的出生年份！');
document.theform.y.focus()
return false;
}
if ( month=='')
{
alert('请选择出生月份！');
document.theform.m.focus()
return false;
}
if (day=='')
{
alert('请选择出生日期！');
document.theform.d.focus()
return false;
}
if ((month==2 && day>29) || ((month==1 || month==3 || month==5 || month==7 || month==8 || month==10|| month==12) && day>31) || ((month==4 || month==6 || month==9 || month==11 ) && day>30))
{
alert('请选择正确的出生日期！');
document.theform.d.focus()
return false;
}
if ( hour=='')
{
alert('请选择出生时间！');
document.theform.hh.focus()
return false;
}

var b=document.theform.b.value;
if (b=='')
{
alert('请选择您的性别！');
document.theform.b.focus()
return false;
}
var name=document.theform.name.value;
if (name=='')
{
alert('请输入您的姓名！');
document.theform.name.focus()
return false;
}
if (document.theform.name.value.length < 2 || document.theform.name.value.length>5)
{
alert("错误：姓名应在2-5个字之间！");
document.theform.name.focus();
return (false);
}
}
//-->
</script><table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
      <tr>
        <TD class=ttd style="PADDING-BOTTOM: 8px" vAlign=top>* 本测算来源于民间，仅供娱乐！ 
       </TD>
      </tr>
      <?if ($name) ?>
	        <tr>
        <TD class=new style="PADDING-BOTTOM: 8px" vAlign=top><p>亲爱的<?$name?>：</p>
          <p> 您出生于<?$y?>年<?$m?>月<?$d?>日，今年<?$yearsOld?>岁（以下资料仅供参考）：</p>
          <p> 测测你上辈子是什么人：根据您的公元出生年月日，经过电脑计算，结果为<?$sbnum3 ?>，表示你上辈子是<font color=#ff0000><?$intro?></font><br /><br /><a href="sm.php?sm=5"><font color=#0000ff>[重新测试]</font></a> </p></TD>
      </tr><?else?><?include file="$subIncludePage"?><?/if?>
    </TBODY>
  </TABLE>
