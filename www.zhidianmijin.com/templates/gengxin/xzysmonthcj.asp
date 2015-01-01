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
 <tr bgcolor="3972B4"> 
      <td colspan="3" bgcolor="e7e7e7"> <div align="center"><strong><font color="#000000">星座运势采集</font></strong></div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      
      <td><input name="Submit" type="submit" <%if request("act")="cj" then%>disabled value="正在数据采集中....."<%else%>value="今日运势采集" onClick="(location='xzjryscj.asp?act=cj&type=day')"<%end if%> class="Submit" >
        <input name="Submit2" type="submit" <%if request("act")="cj" then%>disabled value="正在数据采集中....."<%else%>value="明日运势采集" onClick="(location='xzjryscj.asp?act=cj&type=nextday')"<%end if%> class="Submit" >
        <input name="Submit2" type="submit" <%if request("act")="cj" then%>disabled value="正在数据采集中....."<%else%>value="本周运势采集" onClick="(location='xzysweekcj.asp?act=cj&type=nextday')"<%end if%> class="Submit" >
        <input name="Submit2" type="submit" <%if request("act")="cj" then%>disabled value="正在数据采集中....."<%else%>value="本月运势采集" onClick="(location='xzysmonthcj.asp?act=cj&type=nextday')"<%end if%> class="Submit" >
        <input name="Submit2" type="submit" <%if request("act")="cj" then%>disabled value="正在数据采集中....."<%else%>value="今年运势采集" onClick="(location='xzysyearcj.asp?act=cj&type=nextday')"<%end if%> class="Submit" >
        <input name="Submit2" type="submit" <%if request("act")="cj" then%>disabled value="正在数据采集中....."<%else%>value="今年爱情运势采集" onClick="(location='xzysyearaqcj.asp?act=cj&type=nextday')"<%end if%> class="Submit" ></td>
    </tr>
</table><br>
<table width="98%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC">
    <tr bgcolor="3972B4">
      <td width="100%" colspan="3" bgcolor="e7e7e7"><%if request("act")="cj" then%>
	   <%
Dim Starid,Endid,Co,Msg,ID
Server.ScriptTimeOut=99999
Starid=Request("Starid")
cjtype=request("type")
Endid=11
If Starid="" or Not IsNumeric(Starid) Then Starid=0
ID=Starid
Co=Request("Co")

If Co="" or Not IsNumeric(Co) Then Co=0
If Starid="" or Not IsNumeric(Starid) Or Endid="" Or Not IsNumeric(Endid) Then
   Response.write "&nbsp;您输入的ID参数有错误<A HREF=# onclick=""Javascript:history.back(-1)""><FONT  COLOR=#FF0000>请点这里返回</FONT></A>"
   Response.End
End If


If Starid=11 Then
   Msg="本月运程数据采集完成!<br><br><A HREF=""xzysmonthcj.asp""><FONT  COLOR=#FF0000>返回</FONT></A><br><br>"
   MusicMake
Else
   Msg="正在采集中,请等待......<br><br>"
   MusicMake
   MakeNextPage
End IF

Sub MusicMake
Response.write "<b><font color=#FF0000>"&Starid&"</font>/<font color=#FF0000>"&Endid&"</font>&nbsp;&nbsp;"
Response.write Msg&"</b>"
Response.write "<IE:Download ID=""oDownload"" STYLE=""behavior:url(#default#download)"" />"

MakeIMG
End Sub

Sub MakeIMG
Dim k:k=0
Response.write "<table border=0 width=100% align=center><tr>"
Response.write  "<td width=100%  valign=top>"

set rs=server.CreateObject("ADODB.RecordSet")
set rs=server.CreateObject("ADODB.RecordSet")
sql="select * from cjxm where id=5"
rs.open sql,conn,1,3
url=rs("cjurl")
body=rs("cjbody")
cjxm1=rs("cjxm1")
cjxm2=rs("cjxm2")
cjxm3=rs("cjxm3")
cjxm4=rs("cjxm4")
cjxm5=rs("cjxm5")
cjxm6=rs("cjxm6")
cjxm7=rs("cjxm7")

rs.close

url=bqtf1(url)
body=bqtf1(body)
cjxm1=bqtf1(cjxm1)
cjxm2=bqtf1(cjxm2)
cjxm3=bqtf1(cjxm3)
cjxm4=bqtf1(cjxm4)
cjxm5=bqtf1(cjxm5)
cjxm6=bqtf1(cjxm6)
cjxm7=bqtf1(cjxm7)


url1=Split(url,"[id]")
body1=Split(body,"|")
cjxm1t=Split(cjxm1,"|")
cjxm2t=Split(cjxm2,"|")
cjxm3t=Split(cjxm3,"|")
cjxm4t=Split(cjxm4,"|")
cjxm5t=Split(cjxm5,"|")
cjxm6t=Split(cjxm6,"|")
cjxm7t=Split(cjxm7,"|")
url=url1(0)&id&url1(1)

zlp=GetHttp(url) 

'采集相关信息开始
body=GetStr(zlp,body1(0),body1(1))
cjxm1=GetStr(body,cjxm1t(0),cjxm1t(1))
cjxm1=bqtf2(cjxm1)
cjxm2=GetStr(body,cjxm2t(0),cjxm2t(1))
cjxm3=GetStr(body,cjxm3t(0),cjxm3t(1))
cjxm3a=GetStr(body,cjxm3t(0),cjxm3t(1))
cjxm3b=GetStr(body,cjxm3t(0),cjxm3t(1))
cjxm3a=Split(cjxm3a,"/>")
cjxm3s=ubound(cjxm3a) 
cjxm3b=Split(cjxm3b,"<p>")
cjxm4=GetStr(body,cjxm4t(0),cjxm4t(1))
cjxm4a=GetStr(body,cjxm4t(0),cjxm4t(1))
cjxm4b=GetStr(body,cjxm4t(0),cjxm4t(1))
cjxm4a=Split(cjxm4a,"/>")
cjxm4s=ubound(cjxm4a) 
cjxm4b=Split(cjxm4b,"<p>")
cjxm5=GetStr(body,cjxm5t(0),cjxm5t(1))
cjxm5a=GetStr(body,cjxm5t(0),cjxm5t(1))
cjxm5b=GetStr(body,cjxm5t(0),cjxm5t(1))

cjxm5a=Split(cjxm5a,"/>")
cjxm5s=ubound(cjxm5a) 
cjxm5b=Split(cjxm5b,"<p>")

cjxm6=GetStr(body,cjxm6t(0),cjxm6t(1))
cjxm6=bqtf2(cjxm6)
cjxm7=GetStr(body,cjxm7t(0),cjxm7t(1))
cjxm7=bqtf2(cjxm7)
'开始写入数据
cjxm1=replace(cjxm1,"白羊座","牡羊座")
set rs=server.CreateObject("ADODB.RecordSet")
Sql="select * from xzysmonth where xzmc = '"&cjxm1&"'"
Rs.Open Sql,Conn,1,3
if rs.eof then
Response.Write("<FONT COLOR=RED>星座不存在</FONT><BR><BR>")
else
if cjxm2=rs("yxqx") then
Response.Write("<FONT COLOR=RED>数据记录已更新</FONT><BR><BR>")
else
  rs("yxqx")=cjxm2
  rs("ztzs")=cjxm3s
  rs("ztys")=cjxm3b(1)
  rs("aqzs")=cjxm4s
  rs("aqys")=cjxm4b(1)
  rs("tzzs")=cjxm5s
  rs("tzys")=cjxm5b(1)
  rs("jyfs")=cjxm6
  Rs.Update
  end if
  end if
Rs.Close
Set Rs = Nothing
'===================================================
'RString=DeHttpdata(zlp,"'[^<>'']*','[^<>'']*','[^<>""]*'")

Response.Write "星座："&cjxm1&"<br>"
response.flush
Response.Write "有效期限："&cjxm2&"<br>"
response.flush
Response.Write "整体运势指数："&cjxm3s&"<br>"
response.flush
Response.Write "整体运势："&cjxm3b(1)&"<br>"
response.flush
Response.Write "爱情运势指数："&cjxm4s&"<br>"
response.flush
Response.Write "爱情运势："&cjxm4b(1)&"<br>"
response.flush
Response.Write "投资理财运："&cjxm5s&"<br>"
response.flush
Response.Write "投资理财运："&cjxm5b(1)&"<br>"
response.flush
Response.Write "解压方式："&cjxm6&"<br>"
response.flush


Response.write "<span id=last></span></td><td  valign=top><span id=showImport></span></td></tr></table>"

End Sub

Sub MakeNextPage
Response.write "<meta http-equiv=""refresh"" content=""0;url='xzysmonthcj.asp?act=cj&type="&cjtype&"&Starid="&Starid+1&"&Co="&Co+1&"'"">"
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



