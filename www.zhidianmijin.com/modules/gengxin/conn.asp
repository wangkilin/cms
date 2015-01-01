<!--#include file="inc/function.asp"--><%
connstr="Provider=Microsoft.Jet.OLEDB.4.0;Data Source="&Server.MapPath("../#laisuanming.asp")
set conn=server.createobject("ADODB.CONNECTION")
conn.open connstr
If Err Then
response.Write "连接数据库出错!"
err.Clear
Set conn = Nothing
Response.End
End If
%>