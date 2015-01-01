<?php /* Smarty version 2.6.6, created on 2009-06-28 07:36:44
         compiled from qinglv/index.php */ ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="79%" class="ttd"><span class="red">星    座对对配:</span><br>
    你相信<strong>星座配对</strong>吗？最佳的星座配能保证你的爱情浪漫永久吗？您认为星座是科学吗？星座真的有神奇力量吗？不管信或不信，测试一下看看先~~~~~<BR></td>
    <td width="21%" class="ttd"><img src="diary_book/images/pdxz.jpg" width="134" height="84"></td>
</tr>
<form name="form1"  method="post" action="?m=5&sm=1">
<input type="hidden" name="act" value="ok" />
  <tr>
    <td colspan="2" class="new">
我的星座：
  <SELECT name="p1" class="style3">
  <OPTION value=白羊座>白羊座</OPTION>
  <OPTION value=金牛座>金牛座</OPTION>
  <OPTION value=双子座>双子座</OPTION>
  <OPTION value=巨蟹座>巨蟹座</OPTION>
  <OPTION value=狮子座>狮子座</OPTION>
  <OPTION value=处女座>处女座</OPTION>
  <OPTION value=天秤座>天秤座</OPTION>
  <OPTION value=天蝎座>天蝎座</OPTION>
  <OPTION value=射手座>射手座</OPTION>
  <OPTION value=摩羯座>摩羯座</OPTION>
  <OPTION value=水瓶座>水瓶座</OPTION>
  <OPTION value=双鱼座>双鱼座</OPTION>
  </SELECT>
  他/她的星座
  :
  <SELECT name="p2" class="style3">
  <OPTION value=白羊座 selected>白羊座</OPTION>
  <OPTION value=金牛座>金牛座</OPTION>
  <OPTION value=双子座>双子座</OPTION>
  <OPTION value=巨蟹座>巨蟹座</OPTION>
  <OPTION value=狮子座>狮子座</OPTION>
  <OPTION value=处女座>处女座</OPTION>
  <OPTION value=天秤座>天秤座</OPTION>
  <OPTION value=天蝎座>天蝎座</OPTION>
  <OPTION value=射手座>射手座</OPTION>
  <OPTION value=摩羯座>摩羯座</OPTION>
  <OPTION value=水瓶座>水瓶座</OPTION>
  <OPTION value=双鱼座>双鱼座</OPTION>
  </SELECT>
  <input type="submit" name="Submit1" value="开始配对" style="cursor:hand;">
    </form></td>
    </tr>
</tbody>
</table>
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
  <td width="79%" class="ttd"><span class="red">姓名配对关系提示:</span><br>
    姓名当中究竟隐藏了多少奥秘，可能至今也没有人能完全说破，这里有个趣味游戏，通过姓名笔划数看看你和爱人的关系究竟怎样——</td>
    <td width="21%" class="ttd"><img src="diary_book/images/pd_name.jpg" width="139" height="104"></td>
</tr>
<form name="form1" onSubmit="return Check(this)" method="post" action="?m=5&sm=2">
<input type="hidden" name="act" value="ok" />
  <tr>
    <td colspan="2" class="new">
请输入您的姓名：
  <input name="name1" type="text" id="name1" size="20" onKeyUp="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" maxLength="4"> 
  请输入您爱人的名字:
  <input name="name2" type="text" id="name2" size="20" onKeyUp="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" maxLength="4"> 
  <input type="submit" name="Submit1" value="开始测试" style="cursor:hand;"></form></td>
    </tr>
</tbody>
</table>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="81%" class="ttd"><span class="red">姓名五格配对评分:</span><br>
    根据《易经》的"象"、"数"理论，依据姓名的笔画数和一定规则建立起来天格、地格、人格、总格、外格等五格数理关系，并运用阴阳五行相生相克理论，来推算的各方面运势。 </td>
    <td width="19%" class="ttd"><img src="diary_book/images/xmpd.jpg" width="105" height="140"></td>
</tr>
<form name="form1" onSubmit="return Check(this)" method="post" action="?m=5&sm=5">
<input type="hidden" name="act" value="ok" />
  <tr>
    <td colspan="2" class="new">
请输入您的姓名：<input name="name1" type="text" id="name1" size="20" onKeyUp="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" maxLength="4">&nbsp;<select size="1" name="xing1">
<option value="1" selected="selected">单姓</option>
<option value="2">复姓</option>
          </select>&nbsp;<select size="1" name="sex1">
<option value="男" >男性</option>
<option value="女" >女性</option>
          </select>
  <tr>
    <td colspan="2" class="new">输入另一个姓名:  <input name="name2" type="text" id="name2" size="20" onKeyUp="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" maxLength="4">&nbsp;<select size="1" name="xing2">
<option value="1">单姓</option>
<option value="2">复姓</option>
</select>&nbsp;<select size="1" name="sex2">
<option value="男" >男性</option>
<option value="女" selected >女性</option>
</select>
<input type="submit" name="Submit1" value="开始测试" style="cursor:hand;">
  </form>
    </tr></tbody>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="81%" class="ttd"><span class="red">生肖配对:</span><br>
    属相有鼠、牛、虎、兔、龙、蛇、马、羊、猴、鸡、狗、猪十二种。属相又都是由五行来区分的，而五行则存在着相生相克的道理。相生的属相较能和睦相处，而相克的属相就不那么……了。您是否还对您的爱情犹豫不决啊，那就进来看看你们的生肖配不配吧！<BR></td>
    <td width="19%" class="ttd"><img src="diary_book/images/sxpd.jpg" width="120" height="90"></td>
</tr>
<form name="form1"  method="post" action="?m=5&sm=4">
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
</tbody>
</table>  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="79%" class="ttd"><span class="red">血型配对:</span><br>
    血型配对，根据血型测试您和恋人的缘分和婚姻！ <BR></td>
    <td width="21%" class="ttd"><img src="diary_book/images/xxpd.jpg" width="140" height="94"></td>
</tr>
<form name="form1"  method="post" action="?m=5&sm=4">
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
</tbody>
</table> <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="79%" class="ttd"><span class="red">QQ号码关系提示:</span><br>
    想知道QQ好友跟我的关系吗？马上进行这个趣味小测试吧~~~ ^_^</td>
    <td width="21%" class="ttd"><img src="diary_book/images/qqpd.jpg" width="120" height="90"></td>
</tr><SCRIPT language=javascript>
<!--
function Check2(theForm2)
{
var qq1 = theForm2.qq1.value;
if (qq1 == "") 
{
alert("请输入QQ！");
theForm2.qq1.value="";
theForm2.qq1.focus();
return false;
}
var qq2 = theForm2.qq2.value;
if (qq2 == "") 
{
alert("请输入对方QQ！");
theForm2.qq2.value="";
theForm2.qq2.focus();
return false;
}
}

//-->
</SCRIPT>  
<form name="form1" onSubmit="return Check2(this)" method="post" action="?m=5&sm=3">
<input type="hidden" name="act" value="ok" />
  <tr>
    <td colspan="2" class="new">
我的QQ：
  <input name="qq1" type="text" id="qq1" size="20"  onKeyUp="value=value.replace(/[^\d]/g,'') " onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" />
  对方QQ:
  <input name="qq2" type="text" id="qq2" size="20"  onKeyUp="value=value.replace(/[^\d]/g,'') " onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" />
  <input type="submit" name="Submit1" value="开始测试" style="cursor:hand;"></form></td>
    </tr>
</tbody>
</table>