<%
'算命网sql数据库备用
   set conn=server.CreateObject("ADODB.CONNECTION")
   connstr="DRIVER=SQL Server;SERVER=(local);User Id=sa;PASSWORD=sa;DATABASE=laisuanming"
   conn.open connstr 

%>
