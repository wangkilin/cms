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
    <td width="21%" class="ttd"><img src="<? $siteTheme ?>/images/pd_name.jpg" width="139" height="104"></td>
</tr>
<form name="form1" onSubmit="return Check(this)" method="post" action="">
<input type="hidden" name="act" value="ok" />
  <tr>
    <td colspan="2" class="new">
请输入您的姓名：
  <input name="name1" type="text" id="name1" size="20" onKeyUp="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" maxLength="4"> 
  请输入您爱人的名字:
  <input name="name2" type="text" id="name2" size="20" onKeyUp="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" maxLength="4"> 
  <input type="submit" name="Submit1" value="开始测试" style="cursor:hand;"></form></td>
    </tr>
<? if (isset($smarty.request.act) && $smarty.request.act=="ok") ?>
<tr bgcolor="#EFF8FE">
<td class="new" colspan="2" valign="middle">
<br>双方姓名：<font color=blue><? $strname1 ?>&nbsp;<? $strname2 ?> </font><br><br>
<font color=cc6600>关系揭密：</font><? $intro ?><font color=red>(仅供娱乐)</font><br><br>
</td>
</tr><? /if ?>
</tbody>
</table>
