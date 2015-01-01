<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<TITLE> 地区经度查询-算命网网
</TITLE>
<!--#include file="top.asp"--><!--#include file="../inc/getuc.asp"-->
<SCRIPT src="comefrom.js"></SCRIPT><body topmargin=50 leftmargin=0 onload=init()><div id="right">
<!--#include file="right.asp"-->
</div>
<div id="left">
<div style="width:100%"><%
'其他数据

province1=trim(request("province1"))
city1=trim(request("city1"))

if not isnumeric(jingdu) then jingdu=0
on error resume next
	db1="laisuanmingjingdu.asp"
	Set conn1 = Server.CreateObject("ADODB.Connection")
	connstr1="Provider=Microsoft.Jet.OLEDB.4.0;Data Source=" & Server.MapPath(db1)
	conn1.Open connstr1

if province1<>"" and city1<>"" then
	set rs=server.createobject("ADODB.recordset")
	strsql="select * from jd where sheng='"&province1&"' and xian='"&city1&"'"
	rs.open strsql,conn1,1,1 
	if not rs.eof then
		id=rs("id")
		jingdu=rs("jingdu")
		jingdu=Split(jingdu,".")

	else
	jingdu="没有找到相关地区"
	end if
else
end if
conn1.close
set conn1=nothing

%>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" >
<tbody><form method="POST"  action="" name=form1 onSubmit="return submitchecken();">
<input type="hidden" name="act" value="ok" /><tr>
  <td width="100%" class="ttop"> 地区经度查询</td>
    </tr>  <tr>
<td class="new">省份名称：
  <SELECT name=province onchange=select()></SELECT> <INPUT name=province1 style="color:ff0000;" size=6 value="<%=province1%>" >
  县市名称：
  <SELECT name=city onchange=select()></SELECT> <INPUT name=city1 style="color:ff0000;" size=8 value="<%=city1%>" >&nbsp;</td>
</tr>     <%if request("act")="ok" then%>
 <tr>
        <td class="new"><p>&nbsp;<br>
所查地区：<font color="#FF0000"><%=province1%>-<%=city1%></font><p>
地区经度：<font color="#0000FF"><%=jingdu(0)%>度<%=jingdu(1)%>分</font><p>

　　  </td>
      </tr><%end if%>
<tr>
  <td class="new"><input type="submit" name="Submit3" value="查询地区经度" style='cursor:hand;'></td>
</tr>

</tr>
</form>
</table>




  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" >
    <tbody>
   
      <tr>
        <td width="100%" class="ttop">地区经度查询</td>
      </tr>
      <tr>
        <td class="new"><p>* 本系统目前不支持中国以外的地区经度查询，支持中国县级以上城市的经度查询，城市名称结尾请不要带“市”、“县”等字，尽量写短一些，本系统数据支持模糊方式查询。（县市名称可以为空） 
 </p>
          <p>&nbsp;</p></td>
      </tr>
  </table><table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
      <tr>
        <TD align="left" class=new style="PADDING-BOTTOM:5px"><script src="../images/urlcopy.js"></script></TD>
      </tr>
    </TBODY>
  </TABLE>
</div>
</div>
<!--#include file="../foot.asp"-->
</center>
</body></html>
