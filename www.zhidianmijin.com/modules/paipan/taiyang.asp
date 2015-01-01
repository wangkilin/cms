<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<TITLE> 真太阳时间修正-算命网网
</TITLE>
<!--#include file="top.asp"--><!--#include file="../inc/conn.asp"-->
<SCRIPT src="comefrom.js"></SCRIPT><body topmargin=50 leftmargin=0 onload=init()><div id="right">
<!--#include file="right.asp"-->
</div>
<div id="left">
<div style="width:100%"><%
'其他数据

nx=trim(request("nx"))
xx=trim(request("xx"))
sex=trim(request("sex"))
riqi=trim(request("y"))&"-"&trim(request("m"))&"-"&trim(request("d"))

if len(riqi)<6 then riqi=trim(request("riqi"))
if riqi="" then
	riqi=year(now())&"-"&month(now())&"-"&day(now())
else
	riqi=FormatDateTime(riqi, 1) '转换成时间格式
end if

nian=year(riqi)
yue=month(riqi)
ri=day(riqi)

hh=trim(request("hh"))
fen=trim(request("fen"))

if nian="" then nian=year(now())
if yue="" then yue=month(now())
if ri="" then ri=day(now())
if hh="" then hh=hour(now())
if fen="" then fen=minute(now())

hh1=hh

province1=trim(request("province1"))
city1=trim(request("city1"))
jingdu=trim(request("jingdu"))

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
		shi=rs("shi")
		cxsjk="yes"
	end if
else
	shi=4*(jingdu-120)/60
end if

if cxsjk="" then
		province1=""
		city1=""
end if
if cxsjk="" and jingdu<>0 then
	set rs=server.createobject("ADODB.recordset")
	strsql="select * from jd where jingdu="&jingdu&" order by jingdu"
	rs.open strsql,conn1,1,1 
	if not rs.eof then
	do while not rs.eof
		id2=rs("id")
		sheng2=rs("sheng")
		xian2=rs("xian")
		jingdu2=rs("jingdu")
		dilimess=dilimess&"<b>"&sheng2&"</b>-<b>"&xian2&"</b> "
	rs.movenext
	loop
		dilimess="<hr size=1 color=>该经度所处的地点可能是在 "&dilimess
	else
	set rs=server.createobject("ADODB.recordset")
	strsql="select * from jd where jingdu>="&jingdu&" order by jingdu"
	rs.open strsql,conn1,1,1 
	if not rs.eof then
		id2=rs("id")
		sheng2=rs("sheng")
		xian2=rs("xian")
		jingdu2=rs("jingdu")
		dilimess="<hr size=1 color=>最靠近该经度的地点可能是在 <b>"&sheng2&"</b>-<b>"&xian2&"</b>(经度为"&jingdu2&") "
	end if
	set rs=server.createobject("ADODB.recordset")
	strsql="select * from jd where jingdu<="&jingdu&" order by jingdu desc"
	rs.open strsql,conn1,1,1 
	if not rs.eof then
		id2=rs("id")
		sheng2=rs("sheng")
		xian2=rs("xian")
		jingdu2=rs("jingdu")
		dilimess=dilimess&"和 <b>"&sheng2&"</b>-<b>"&xian2&"</b>(经度为"&jingdu2&") 。"
	end if
	end if
end if

miao=0
sj1=nian&"年"&yue&"月"&ri&"日 "&hh1&"："&fen&"："&miao&""
sj11=nian&"-"&yue&"-"&ri&" "&hh1&":"&fen&":"&miao&""

sj11=FormatDateTime(sj11, 0) '转换成时间格式
sj00=sj11

xialing=trim(request("xialing"))
if xialing="yes" then sj11=DateAdd("s", -3600, sj11)	'夏令时间处理

sj22=DateAdd("s", shi*3600, sj11)	'加上平太阳时间差值

set rs=server.createobject("ADODB.recordset")
strsql="select * from yr where yue="&yue&" and ri="&ri&""
rs.open strsql,conn1,1,1 
if not rs.eof then
	id=rs("id")
	shi=rs("shi")
end if
conn1.close
set conn1=nothing

sj33=DateAdd("s", shi*3600, sj22)	'加上平太阳时间差值
nian3=year(sj33)
yue3=month(sj33)
ri3=day(sj33)
hh3=hour(sj33)
fen3=minute(sj33)
miao3=second(sj33)
%>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" >
<tbody><form method="POST"  action="taiyang.asp" name=form1 onSubmit="return submitchecken();">
<input type="hidden" name="act" value="ok" /><tr>
  <td width="100%" class="ttop"> 真太阳时间修正</td>
    </tr>

  <tr>
<td class="new">出生日期：<select name="y" size="1" id="y" style="font-size: 9pt">
        <%for i=1950 to year(date())%>
        <option value="<%=i%>" <%if i=year(date()) then%> selected<%end if%>><%=i%></option>
        <%next%>
      </select>
年
<select name="m" size="1" id="m" style="font-size: 9pt">
  <%for i=1 to 12%>
  <option value="<%=i%>"<%if i=month(date()) then%> selected<%end if%>><%=i%></option>
  <%next%>
</select>
月
<select name="d" size="1" id="d" style="font-size: 9pt">
  <%for i=1 to 31%>
  <option value="<%=i%>" <%if i=day(date()) then%> selected<%end if%>><%=i%></option>
  <%next%>
</select>
日
<font color=red>(＊北京标准时间) </font></td>
  </tr>

<tr>
<td class="new">出生时间：<select size="1" name="hh" style="font-size: 9pt"> <option value="0" <%if hh=0 then%>selected<%end if%>>子 0</option> <option value="1" <%if hh-1=0 then%>selected<%end if%>>丑 1</option> <option value="2" <%if hh-2=0 then%>selected<%end if%>>丑 2</option> <option value="3" <%if hh-3=0 then%>selected<%end if%>>寅 3</option> <option value="4" <%if hh-4=0 then%>selected<%end if%>>寅 4</option> <option value="5" <%if hh-5=0 then%>selected<%end if%>>卯 5</option> <option value="6" <%if hh-6=0 then%>selected<%end if%>>卯 6</option> <option value="7" <%if hh-7=0 then%>selected<%end if%>>辰 7</option> <option value="8" <%if hh-8=0 then%>selected<%end if%>>辰 8</option> <option value="9" <%if hh-9=0 then%>selected<%end if%>>巳 9</option> <option value="10" <%if hh-10=0 then%>selected<%end if%>>巳 10</option> <option value="11" <%if hh-11=0 then%>selected<%end if%>>午 11</option> <option value="12" <%if hh-12=0 then%>selected<%end if%>>午 12</option> <option value="13" <%if hh-13=0 then%>selected<%end if%>>未 13</option> <option value="14" <%if hh-14=0 then%>selected<%end if%>>未 14</option> <option value="15" <%if hh-15=0 then%>selected<%end if%>>申 15</option> <option value="16" <%if hh-16=0 then%>selected<%end if%>>申 16</option> <option value="17" <%if hh-17=0 then%>selected<%end if%>>酉 17</option> <option value="18" <%if hh-18=0 then%>selected<%end if%>>酉 18</option> <option value="19" <%if hh-19=0 then%>selected<%end if%>>戌 19</option> <option value="20" <%if hh-20=0 then%>selected<%end if%>>戌 20</option> <option value="21" <%if hh-21=0 then%>selected<%end if%>>亥 21</option> <option value="22" <%if hh-22=0 then%>selected<%end if%>>亥 22</option> <option value="23" <%if hh-23=0 then%>selected<%end if%>>子 23</option> </select>点<select size="1" name="fen" style="font-size: 9pt"><% for y=0 to 59%><option value="<%=y%>" <%if fen-y=0 then%>selected<%end if%>><%=y%></option><%next%></select>分<font color=red>(＊24小时制,00:00~23:59。) </font><input type=checkbox name=xialing value=yes <%if xialing="yes" then%>checked<%end if%>>
  夏令时间</td>
</tr>  <tr>
<td class="new">出生地点：<SELECT name=province onchange=select()></SELECT> <INPUT name=province1 style="color:ff0000;" size=6 value="<%=province1%>" ><SELECT name=city onchange=select()></SELECT> <INPUT name=city1 style="color:ff0000;" size=8 value="<%=city1%>" >&nbsp;若不在上面的选择中，请填写出生地经度：<input type=txt name=jingdu size=8 value="<%=jingdu%>">度<%=dilimess%></td>
</tr>
<tr>
  <td class="new"><input type="submit" name="Submit3" value="立刻修正" style='cursor:hand;'></td>
</tr>

</tr>
</form>
</table>
<%if request("act")="ok" then%>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" id="paipanTable">
    <tbody>
      <tr>
        <td class="ttop"> 真太阳时间显示</td>
      </tr>
      <tr>
        <td class="new"><p>&nbsp;<br>
　　原始时间：<%=sj00%><p>
北京标准时间：<%=sj11%><p>
　平太阳时间：<%=sj22%><p>
　真太阳时间：<font color=red><%=sj33%></font><p>
<p>
　　  </td>
      </tr>
    </table>
<%end if%>


  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" >
    <tbody>
   
      <tr>
        <td width="100%" class="ttop">周易预测中的时辰怎样确定？</td>
      </tr>
      <tr>
        <td class="new"><p>时辰究竟应该按照什么标准确定呢？是按北京时间确定？还是按当地时间确定？其实唯一的标准就是太阳相对于地球的视角，即天文学上所谓的真太阳时。即：真太阳时＝平太阳时+真平太阳时差。凡定生时，必须按照其出生地点，推算出当地的平太阳时，再根据平太阳时推算出真太阳时为准，不能简单地沿用北京时间，下面列出中国各主要城市之平太阳时与北京时间对照表，供定时辰之参考。 </p>
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
