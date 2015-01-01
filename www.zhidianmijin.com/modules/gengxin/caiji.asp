<!--#include file="conn.asp"--><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>内容管理</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK href="images/style.css" 
type=text/css rel=stylesheet>
<META content="MSHTML 6.00.3790.0" name=GENERATOR>
<style type="text/css">
<!--
.STYLE1 {color: #FFFFFF}
-->
</style>

</HEAD>
<BODY style="FONT-SIZE: 12px; v-text-align: center" leftMargin=0 topMargin=3
align="center" marginheight="0" marginwidth="0"><script language="javascript">
function del(id)
	{
		if (confirm('\n真的要删除该所所选线路吗?'))
		  if (confirm('\n再次确认!!!\n\n\n真的要删除所选线路吗!?'))
			location="xl_admin.asp?id=<%=request("id")%>&act=删除"
        }
function MakeHTML(id)
{window.open("make_html_bus.asp?type=page&id="+id,"","width=150,height=15,resizable=no,scrollbars=no,status=no,toolbar=no,menubar=no,location=no");}
function CheckAll(form)
{
	for (var i=0;i<form.elements.length;i++)
	{
		var e = form.elements[i];
//		if (e.name != 'chkall')
			e.checked = true// form.chkall.checked;
	}
}
function CheckOthers(form)
{
	for (var i=0;i<form.elements.length;i++)
	{
		var e = form.elements[i];
//		if (e.name != 'chkall')
			if (e.checked==false)
			{
				e.checked = true;// form.chkall.checked;
			}
			else
			{
				e.checked = false;
			}
	}
}

</script>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
  
<tr> 
    <td width="11%" height="26" bgcolor="e7e7e7"> <div align="center"><font color="#000000">ID</font></div></td>
    <td width="72%" bgcolor="e7e7e7"> <div align="center"><font color="#000000">姓氏</font></div></td>
    <td width="17%" bgcolor="e7e7e7"><div align="center" class="STYLE1"><font color="#000000">操作</font></div></td>
  </tr>
  <%
     MaxPerPage=30
   if not isempty(request("page")) then 
      currentPage=cint(request("page")) 
   else 
      currentPage=1 
   end if 
if request("id")<>"" then
	if search="" then
		search = search & " WHERE "
	else
		search = search & " AND "
	end if
	search = search & " id = '" & request("id") & "' "
end if
if request("title")<>"" then
	if search="" then
		search = search & " WHERE "
	else
		search = search & " AND "
	end if
	search = search & " cjxm like '%"& request("title") &"%'"
end if
set rs=server.createobject("adodb.recordset")
sql="select * from cjxm " & search &""
rs.open sql,conn,1,1
if rs.eof then%>
    <tr bgcolor=#ffffff onMouseOut=mOut(this,'#FFFFFF') onMouseOver=mOvr(this,'#C4FFB5')>
      <TD height="40" colspan="10"><div align="center"><strong><font color="#FF0000">
      没有任何内容</font></strong></div></TD>
    </TR>
    <%
else
allshu=rs.recordcount
rs.pagesize=MaxPerPage 
mpage=rs.pagecount     
rs.move  (currentPage-1)*MaxPerPage
i=0
do while not rs.eof
%>
  <tr bgcolor="#FFFFFF"> 
    <td> <div align="center">  [<%=rs("id")%>] </div></td>
    <td><%=rs("xmmc")%> </td>
    <td bgcolor="#FFFFFF"><div align="center"><a href="cjxm_add.asp?act=edit&id=<%=rs("id")%>">修改</a>&nbsp; <a href="x_admin.asp?id=<%=rs("id")%>&act=删除" onClick="{if(confirm('确定删除此内容吗，此操作不可恢复!?')){return true;}return false;}"> 删除</a></div></td>
  </tr>
  <%
  i=i+1  
if i>=MaxPerPage then exit do
 rs.movenext
 loop 
   end if
%>
</table>
<table width="98%" height="26" border="0" align="center" cellpadding="0" cellspacing="0">
  <form action="?" method=get name="form"><tr> 
    <td width="55%" nowrap>页次：<font color="ff0000"> <%=currentPage%></font>/<%=mpage%> &nbsp;每页&nbsp;<b><font color="ff0000"> <%=MaxPerPage%> 
    </font></b> 内容数&nbsp;<b><font color="ff0000"> <%=allshu%> 搜索
    <input name="title" type="text" id="title" size="10">
    <input type="submit" name="Submit" value="提交">
    <a href="cjxm_add.asp">增加</a></font></b></td>
    <td width="45%" nowrap><p align="center"> 
        <%pageno=currentPage  
		if cint(pageno)>1 then%>
        <a href=?page=1&classid=<%=request("classid")%> title="最前页"><%end if%>首页</a> 
        <% if cint(pageno)>1 then%>
        <a href=?page=<%=currentPage-1%>&classid=<%=request("classid")%> title="上一页"><%end if%>上页</a> 
        <%pp=cint(pageno)-2            
  if pp<1 then            
  pp=1            
  end if            
p=0
for pno=pp to mpage
p=p+1
if pno*1=cint(pageno)*1 then%>
        <font color="#FF0000">[
        <%=pno%>
        ]</font> 
        <%else%>
        <a href=?page=<%=pno%>&classid=<%=request("classid")%> title="第<%=pno%>页">[
        <%=pno%>
        ]</a
>
        <%end if%>
        <%if p>=5 then exit for            
next%>
        <% if cint(pageno)< mpage then%>
        &nbsp;<a href=?page=<%=currentPage+1%>&classid=<%=request("classid")%> title="下一页"><%end if%>下页</a>&nbsp;
        <% if cint(pageno)< mpage then%>
      <a href=?page=<%=mpage%>&classid=<%=request("classid")%> title="最后页"><%end if%>末页</a></p></td>
  </tr></form>
</table>

</BODY></HTML>

