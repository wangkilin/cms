<%
function bqtf(s) 
if s<>"" then
s=replace(s,"'","''") 
end if
bqtf=s 
end function
 
function bqtf1(s)
if s<>"" then
s=replace(s,"''","'") 
end if
bqtf1=s 
end function 

function Checkin(s) 
s=trim(s) 
s=replace(s," ","&amp;nbsp;") 
s=replace(s,"'","&amp;#39;") 
s=replace(s,"""","&amp;quot;") 
s=replace(s,"&lt;","&amp;lt;") 
s=replace(s,"&gt;","&amp;gt;") 
Checkin=s 
end function 
'function CheckAdmin
'	if Session("IsAdmin")<>true then response.redirect "index.htm"
'end function
function CheckAdmin2
'	if Session("IsAdmin")<>true or (session("KEY")<>"check" and session("KEY")<>"super") then response.redirect "error.asp"
end function
function CheckAdmin3
'	if Session("IsAdmin")<>true or session("KEY")="super" then response.redirect "index.htm"
end function
sub error()
%>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META content=vv23com name=Author>
<LINK href="images/style.css" type=text/css rel=stylesheet>
<title>出错</title>
</head>
<body bgcolor="#E7EFF7" leftmargin="0" topmargin="111">
<div align="center">
  <center>
    <table width="60%" border="0" cellspacing="5" bgcolor="3972B4">
      <tr>
      <td width="100%">
        <div align="center">
            <table width="100%" border="0" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF">
              <tr>
                <td width="100%" bgcolor="#E7EFF7" height="80" align="center"> 
                  <b><font color="#FF0000">提示</font><font color="#FF0000">：</font><font color="#FF0000"><%=errmsg%>！ 
                  </font></b> 
                  <p><b><a href="javascript:history.go(-1)"><font color="#FF0000">返 
                    回</font></a></b> </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>
  </center>
</div>
</body>                    
</html>           
<%
end sub

%>
