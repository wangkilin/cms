<!--#include file="../inc/conn.asp"-->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>周公解梦：梦见<%=request("word")%></title>

<STYLE TYPE="text/css">
BODY{margin:0px}
div {font-size: 14px;color: #000000;line-height: 26px;}
td {font-size: 14px;color: #000000;line-height: 26px;}
a {color: #000000;text-decoration: underline;}
a:hover {color: #FF0000;text-decoration: underline;}
.a14black {color: #000000;}
.a14black:hover {color: #FF0000;}
.tablebgcolor{background-color:#BBAC85;width:760px;}
.tablebgcolor1{width:760px;}
.tablebgcolor2{background-color:#BBAC85;width:760px;}
.tablebgcolor3{background-color:#0066cc;width:760px;}
.tablebgcolor4{background-color:#d2d0d0;width:98%;}
.tdbgcolor{background-color:#FDFBF2;padding-left:5px;}
.tdbgcolor1{background-color:#F9F4DA;padding-left:5px;}
.tdbgcolor2{background-color:#ffffff;padding:5px;}
.fontcolor1 {color:#0000ff;}
.fontcolor2 {color:green;}
.fontcolor3 {color:#ff0000;}
.div1 {font-size: 14px;color: #000000;width:760px;float:left;}
.input1 {cursor:hand;font-size:18px;}
.sy {display:inline;font-size:1px;float:right;overflow:hidden;width:1px;color:#f6f6f6;height:1px;}
.divh{height:8px;line-height:8px;}
.divh1{height:4px;line-height:4px;}
.divh2{height:12px;line-height:12px;}
.12black{font-size:12px;color:#000000;line-height:22px;}
.12blue{font-size:12px;color:#0000ff;line-height:22px;}
.12red{font-size:12px;color:#ff0000;line-height:22px;}
.12blue1{font-size:12px;color:#0044DD;line-height:22px;}
.14black{font-size:14px;color:#000000;line-height:26px;}
.14blue{font-size:14px;color:#0000ff;line-height:26px;}
.14red{font-size:14px;color:#ff0000;line-height:26px;}
.14blue1{font-size:14px;color:#0044DD;line-height:26px;}
</STYLE>
</head>

<body>

<div class="divh"></div>

<div align="center">
<table cellspacing="1" cellpadding="0" border="0" class="tablebgcolor4">
<TBODY>
<%
     MaxPerPage=3
   if not isempty(request("page")) then 
      currentPage=cint(request("page")) 
   else 
      currentPage=1 
   end if 
   set rs=server.createobject("adodb.recordset")
if request("act")=1 then
cxgjz="title"
elseif request("act")=2 then
cxgjz="content"
end if
sql="select * from zgjm where "&cxgjz&" like '%"& request("word") &"%'"
rs.open sql,conn,1,1
if rs.eof then
response.write("<script>alert('没有找到相关解梦内容');window.close()</script>")
response.end
else
allshu=rs.recordcount
rs.pagesize=MaxPerPage 
mpage=rs.pagecount     
rs.move  (currentPage-1)*MaxPerPage
%>
<TR class="tdbgcolor"><TD height="25" align="right" width="100%">共找到<FONT COLOR="#FF0000"><%=allshu%></FONT>个解梦结果，分为<font color="#FF0000"><%=mpage%></font>页，目前是第<font color="#FF0000"><%=currentPage%></font>页</TD></TR>
<TR class="tdbgcolor2"><TD>

<div align="center">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tbody><%i=0
do while not rs.eof
  i=i+1 
jmlb=rs("jmlb")
		 set rs2=server.createobject("adodb.recordset")
sql2="select * from jmlb where id="&jmlb
rs2.open sql2,conn,1,3%>
<tr><td style="line-height:200%">
<font color="green">［<%=i%>.<%=rs2("jmlb")%>］</font> <font color="red">（<%=rs("title")%>）</font><br />
<%word=request("word")
content=rs("content")
%>
<%=replace(content,word,"<font color=red>"&word&"</font>")%>
</td></tr>  <%
 
if i>=MaxPerPage then exit do
 rs.movenext
 loop 
   end if
%>
</tbody></table>
</div>
<hr size="1" color="#d2d0d0" />

<!--分页开始-->
<div align="center">
<script>
PageCount=<%=mpage%> //总页数
topage=<%=currentPage%>   //当前停留页
if (topage>1){document.write("<a href='?Act=<%=request("act")%>&word=<%=request("word")%>=0' title='上一页'>上一页</a>");}
for (var i=1; i <= PageCount; i++) {
if (i <= topage+6 && i >= topage-6 || i==1 || i==PageCount){
if (i > topage+7 || i < topage-5 && i!=1 && i!=2 ){document.write(" ... ");}
if (topage==i){document.write("<font color=#d2d0d0> "+ i +" </font>");}
else{
document.write(" <a href='?Act=<%=request("act")%>&word=<%=request("word")%>="+i+"'>["+ i +"]</a> ");
}
}
}
if (PageCount-topage>=1){document.write("<a href='?Act=<%=request("act")%>&word=<%=request("word")%>=2' title='下一页'>下一页</a>");}
  </script>
</div>
<!--分页结束-->
</TD></TR>
</TBODY></table>
<br />
<a href="javascript:window.close()">[关闭页面]</a>
</div>

</body>
</html>
<div style="display:none">
<script language="JavaScript" type="text/javascript" src="http://c6.50bang.com/click.js?user_id=426799&l=205" charset="gb2312"></script>
<script language='javascript' src='http://utk.baidu.com/usv/uc.sv?pe=SNpZ67xMUB7UcVcuCo0fx3vuV~w=&sn=160&an=69714&rn=625'></script>
</div>