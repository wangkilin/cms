<!-- #include file="conn.asp" --><!-- #include file="cjf.asp" --><!--#include file="inc/CHAR.INC"-->

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK href="images/style.css" 
type=text/css rel=stylesheet>
<META content="MSHTML 6.00.3790.0" name=GENERATOR></HEAD>
<BODY style="FONT-SIZE: 12px; v-text-align: center" leftMargin=0 topMargin=3 
align="center" marginheight="0" marginwidth="0">
<table width="98%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC">
   <form name="form1" method="get" action="astrocj.asp">
 <tr bgcolor="3972B4"> 
      <td colspan="3" bgcolor="e7e7e7"> <div align="center"><strong><font color="#000000">采集</font></strong></div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="17%">&nbsp;</td>
      <td width="83%">
      从<input name="id1" type="text" id="id1" size="10">
      到
      
      <input name="id2" type="text" id="id2" size="10">
      <input name="Submit" type="submit" <%if request("act")="cj" then%>disabled value="正在数据采集中....."<%else%>value="开始采集"<%end if%> class="Submit" >
     <input name="act" type="hidden" value="cj"></td>
    </tr>
    </form>
</table><br>
<table width="98%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC">
    <tr bgcolor="3972B4">
      <td width="100%" colspan="3" bgcolor="e7e7e7"><%if request("act")="cj" then%>
	   <%
Dim id1,id2,Co,Msg,ID
Server.ScriptTimeOut=99999
id1=Request("id1")
id2=Request("id2")
If id1="" or Not IsNumeric(id1) Then id1=1
ID=id1
Co=Request("Co")

If Co="" or Not IsNumeric(Co) Then Co=1
If id1="" or Not IsNumeric(id1) Or id2="" Or Not IsNumeric(id2) Then
   Response.write "&nbsp;您输入的ID参数有错误<A HREF=# onclick=""Javascript:history.back(-1)""><FONT  COLOR=#FF0000>请点这里返回</FONT></A>"
   Response.End
End If


If id1=id2 Then
   Msg="数据采集完成! <br><br><FONT  COLOR=#FF0000>返回</FONT></A><br><br>"
   MusicMake
Else
   Msg="正在采集中,请等待......<br><br>"
   MusicMake
   MakeNextPage
End IF

Sub MusicMake
Response.write "<b><font color=#FF0000>"&id1&"</font>/<font color=#FF0000>"&id2&"</font>&nbsp;&nbsp;"
Response.write Msg&"</b>"
Response.write "<IE:Download ID=""oDownload"" STYLE=""behavior:url(#default#download)"" />"

MakeIMG
End Sub

Sub MakeIMG
Dim k:k=0
Response.write "<table border=0 width=100% align=center><tr>"
Response.write  "<td width=100%  valign=top>"

set rs=server.CreateObject("ADODB.RecordSet")
sql="select * from cjxm where id=8"
rs.open sql,conn,1,3
url=rs("cjurl")
body=rs("cjbody")
cjxm1=rs("cjxm1")
cjxm2=rs("cjxm2")

rs.close

url=bqtf1(url)
body=bqtf1(body)
cjxm1=bqtf1(cjxm1)
cjxm2=bqtf1(cjxm2)



url1=Split(url,"[id]")
body1=Split(body,"|")
cjxm1t=Split(cjxm1,"|")
cjxm2t=Split(cjxm2,"|")

url=url1(0)&id&url1(1)
On Error Resume Next 

zlp=GetHttp(url) 

'采集相关信息开始
body=GetStr(zlp,body1(0),body1(1))
cjxm1=GetStr(body,cjxm1t(0),cjxm1t(1))
cjxm1=bqtf2(cjxm1)
cjxm1=DSConvert(cjxm1,0)
cjxm2=GetStr(body,cjxm2t(0),cjxm2t(1))
cjxm2=bqtf2(cjxm2)

'开始写入数据
if cjxm1="<font class=f1491>|</font>" then
Response.Write("目标地址不存在")
else
set rs=server.CreateObject("ADODB.RecordSet")
Sql="select * from astro where title = '"&cjxm1&"'"
Rs.Open Sql,Conn,1,3
if not rs.eof then
Response.Write("<FONT COLOR=RED>数据记录已存在</FONT><BR><BR>")
else
Rs.AddNew
  rs("title")=cjxm1
  rs("content")=cjxm2
  Rs.Update
  end if
Rs.Close
Set Rs = Nothing
'===================================================
'RString=DeHttpdata(zlp,"'[^<>'']*','[^<>'']*','[^<>""]*'")
Response.Write "ID："&id1&"<br>"
response.flush
Response.Write "标题："&cjxm1&"<br>"
response.flush
Response.Write "内容："&cjxm2&"<br>"
Response.write "<span id=last></span></td><td  valign=top><span id=showImport></span></td></tr></table>"
end if

End Sub

Sub MakeNextPage
Response.write "<meta http-equiv=""refresh"" content=""0;url='astrocj.asp?act=cj&id1="&id1+1&"&id2="&id2&"&Co="&Co+1&"'"">"
End Sub
%>
<%end if%></td>
    </tr>
</table>
</BODY></HTML>

<script language="JavaScript" type="text/JavaScript">
function SwitchNewsType(NewsType)
{
	switch (NewsType)
	{
	case "PicNews":
		document.getElementById('PicNews').style.display='';
	break;

	}
}

</script>



