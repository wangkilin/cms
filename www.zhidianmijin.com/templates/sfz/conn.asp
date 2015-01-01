

<%

  on error resume next
   connstr="Provider=Microsoft.Jet.OLEDB.4.0;Data Source=" & server.mappath("#sfz.asp")
     set conn=server.createobject("ADODB.CONNECTION")
     conn.open connstr 
%>
