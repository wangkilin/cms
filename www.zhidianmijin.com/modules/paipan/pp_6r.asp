<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<TITLE>六壬排盘-算命网网</TITLE>
<!--#include file="top.asp"--><!--#include file="../inc/getuc.asp"-->

<div id="right">
<!--#include file="right.asp"-->
</div>
<div id="left">
<div style="width:100%">
<%if request("act")="ok" then%>
<!--#include file="inc/sizhu.asp"-->
<!--#include file="inc/jieqi.asp"-->
<%
name=request.Form("name")
Response.Cookies("ciduppname")=name
zhanshi=request("zhanshi")
Response.Cookies("ciduppzhanshi")=zhanshi
jg=request("jg")
y=request("y")
m=request("m")
d=request("d")
mins=request("min")
h=request("h")
birthyear=request("birthyear")
Response.Cookies("ciduppyear")=birthyear
sex=request("sex")
Response.Cookies("ciduppsex")=sex
phn=request("pai")
gsarrage=request("guishen")
scpf=request("scpf")
df=request("df")
zhouye=request("zhouye")
Pf=request("pf")
Nyangli=y&"年"&m&"月"&d&"日"&h&"时"&mins&"分"
sex=request("sex")
if birthyear>y then
response.Write("输入有误，返回重新开始")
response.end
end if
%>

<%'年命
dys=(birthyear-1924)mod 12
dys=(dys+12) mod 12
tys=(birthyear-1924)mod 10
tys=(tys+10)mod 10
ygzs=tg(tys)&dz(dys)
call xunkong(ygzs,yxks,yxss)
'response.write yxss
suishu=y-birthyear+1
if sex then
hntg=(2+suishu-1) mod 10
hndz=(dzorder(yxss)+suishu)mod 12
else
hntg=(9+suishu-1) mod 10
hndz=(dzorder(yxss)-4+suishu)mod 12
end if

hangn=tg(hntg)&dz(hndz)
'response.write hangn&suishu
%>

<%dates=y&"-"&m&"-"&d
Ytime=dates&" "&h&"："&m&"：00"
if not isdate(dates) then
response.write dates&"不是一个合法的日期"
response.end
end if
'response.write ytime
call sizhu(y,m,d,h,mins,ygz,mgz,dgz,tgz)
call form_load(ytime,ntime,cyue,cri,cyear)
call makejq(ytime,prejq,nextjq)
call xunkong(ygz,yxk,yxs)
	call xunkong(mgz,mxk,mxs)
	call xunkong(dgz,dxk,dxs)
	call xunkong(hgz,hxk,hxs)
nJQ=RIGHT(NEXTjQ,2)
%>


<% '月将

select case njq
       case "雨水","惊蛰" yuej="亥"
       case "春分","清明" yuej="戌"
       case "谷雨","立夏" yuej="酉"
       case "小满","芒种" yuej="申"
       case "夏至","小暑" yuej="未"
       case "大暑","立秋" yuej="午"
       case "处暑","白露" yuej="巳"
       case "秋分","寒露" yuej="辰"
       case "霜降","立冬" yuej="卯"
       case "小雪","大雪" yuej="寅"
       case "冬至","小寒" yuej="丑"
       case "大寒","立春"   yuej="子" 
end select
'月将
%>
<%dim tianpan(11)
yjorder=Dzorder(yuej)
  szorder=Dzorder(tgz)
  xd=yjorder-szorder
  szindex=(1-szorder+12)mod 12
  szindex=(szindex+yjorder-1)mod 12
  for i=0 to 11 

      iindex =(szindex+12+i-1) mod 12
      tianpan(i)=dz(iindex)
  next
 shizhi=right(tgz,1)
%>

<%'四课
 select case left(dgz,1)
 case  "甲" Jk="寅"  
 case  "乙" Jk="辰" 
 case  "丙","戊" Jk="巳" 
 case  "丁","己" Jk="未"
 case  "庚"  Jk="申"    
 case  "辛" Jk="戌" 
 case  "壬"  Jk="亥" 
 case  "癸" Jk="丑" 
 end select
 
 jk1index=dzorder(jk) mod 12
 jk3index=dzorder(dgz) mod 12
 Jk1=tianpan(jk1index)
   jk2index=dzorder(jk1)mod 12
 jk2=tianpan(jk2index)
 jk3=tianpan(jk3index)
   jk4index=dzorder(jk3)mod 12
   jk4=tianpan(jk4index)
%>

<% '贵神
szorders=dzorder(tgz)
if zhouye=2 then 
if szorders>=4 and  szorders<10 then
 zhouye=1
 else
 zhouye=0
end if 
end if  '默认的昼夜选择
'response.Write(szorders)
dim guishens(11)
if gsarrage then
  select case left(dgz,1)
       case  "甲","戊","庚"  if zhouye then
	                         startGs="丑"
							 else
							 startGs="未"
							 end if
	   case  "乙","己"       if zhouye then
	                         startGs="子"
							 else
							 startGs="申"
							 end if'寅申乡
	   case  "丙","丁"      if zhouye then
	                         startGs="亥"
							 else
							 startGs="酉"
							 end if'"巳"酉
	   case  "壬","癸"      if zhouye then
	                         startGs="巳"
							 else
							 startGs="亥"
							 end if'巳亥
	   case  "辛"           if zhouye then
	                         startGs="午"
							 else
							 startGs="寅"
							 end if'午虎

 end select
else
 select case left(dgz,1)
       case  "甲"        if zhouye then
	                         startGs="未"
							 else
							 startGs="丑"
							 end if
	   case  "戊","庚"  if zhouye then
	                         startGs="丑"
							 else
							 startGs="未"
							 end if
	   case  "乙"       if zhouye then
	                         startGs="申"
							 else
							 startGs="子"
							 end if'寅申乡
	   case  "己"       if zhouye then
	                         startGs="子"
							 else
							 startGs="申"
							 end if'寅申乡
	   case  "丙"         if zhouye then
	                         startGs="酉"
							 else
							 startGs="亥"
							 end if'"巳"酉
	   case  "丁"      if zhouye then
	                         startGs="亥"
							 else
							 startGs="酉"
							 end if'"巳"酉
	   case  "壬"        if zhouye then
	                         startGs="卯"
							 else
							 startGs="巳"
							 end if'巳亥
	   case  "癸"      if zhouye then
	                         startGs="巳"
							 else
							 startGs="卯"
							 end if'巳亥
	   case  "辛"           if zhouye then
	                         startGs="寅"
							 else
							 startGs="午"
							 end if'午虎

 end select
 
 end if
for i=0 to 11  '找出在天盘的编号
if tianpan(i)=startGs then
exit for
end if
next
'response.Write(startGs&i)
'确定顺序
if i>=0 and i<=5  then
orders=1
else
orders=0
end if
if orders then
 for j=0 to 11 
 select case j
 case 0,4,9 guishens((i+j)mod 12)=left(guishen(j),1)
 case 1,2,3,5,6,7,8,10,11    guishens((i+j)mod 12)=right(guishen(j),1)  
 end select

 next 
 else
  for j=0 to 11
 select case j
 case 0,4,9                    guishens((i-j+12)mod 12)=left(guishen(j),1)
 case 1,2,3,5,6,7,8,10,11      guishens((i-j+12)mod 12)=right(guishen(j),1)  
 end select
 next
 end if
%>
<%'四课贵神
'response.write jk1index
gs1=guishens(jk1index)
gs2=guishens(jk2index)
gs3=guishens(jk3index)
gs4=guishens(jk4index)

%>
<%'三传
'response.write dgz
schang=(tgorder(dgz)-1)*6+round(dzorder(dgz)/2)
 'response.write (round(3/2))
 'response.write schang
 'response.end
 scorder=(szorder-yjorder+13)mod 12
 if scorder=0 then
 scorder=12
 end if
set fo=server.createobject("scripting.filesystemobject")
path=server.mappath("temp\sanchuan.txt")
set fn=fo.opentextfile(path)
for i=1 to schang-1
fn.skipline
next
str=fn.readline
'response.Write("dd"&scorder&"<br>"&schang&"<br>")
'response.Write(str)
ScStr=split(str,",")
sanchuan=trim(ScStr(scorder))
chuan1=mid(sanchuan,2,1)
chuan2=mid(sanchuan,3,1)
chuan3=mid(sanchuan,4,1)
'response.Write(sanchuan)
for i= 0 to 11
if tianpan(i)=chuan1 then
chuan1index=i
end if

if tianpan(i)=chuan2 then
chuan2index=i
end if

if tianpan(i)=chuan3 then
chuan3index=i
end if
next

scgs1=guishens(chuan1index)
scgs2=guishens(chuan2index)
scgs3=guishens(chuan3index)
%>

<%'三传天干，和起时辰法相同

C1tgIndex=dzorder(chuan1)-1
C2tgindex=dzorder(chuan2)-1
C3tgindex=dzorder(chuan3)-1
'response.Write(c1tgindex&c2tgindex)
riganorder=tgorder(dgz)-1
if riganorder>4 then
ryindex=(riganorder-4)*2-2
else
ryindex=(riganorder+1)*2-2
end if
if scpf then   '时旬遁干【排法
c1tgindexl=(c1tgindex+ryindex)mod 10
c2tgindexl=(c2tgindex+ryindex)mod 10
c3tgindexl=(c3tgindex+ryindex)mod 10
tg1=tg(c1tgindexl)
tg2=tg(c2tgindexl)
tg3=tg(c3tgindexl)
else
'日旬遁干
'response.write dxs
rtgindex=tgorder(dxs)-1
rdzindex=dzorder(dxs)-1
c1tgindex=(c1tgindex-rdzindex+12)mod 12
c2tgindex=(c2tgindex-rdzindex+12)mod 12
c3tgindex=(c3tgindex-rdzindex+12)mod 12

if c1tgindex<10 then
tg1=tg(c1tgindex)
else
tg1="&nbsp&nbsp"
end if
if c2tgindex<10 then
tg2=tg(c2tgindex)
else
tg2="&nbsp&nbsp"
end if
if c3tgindex<10 then
tg3=tg(c3tgindex)
else
tg3="&nbsp&nbsp"
end if


end if
%>

<%'六亲
rtgorder=tgorder(dgz)
rtg=round((rtgorder)/2+0.01)
'response.write round(rtg)
'response.write rtg&rtgorder
'response.write rtg
'response.write rtgorder
select case  chuan1
   case  "寅","卯"  b1=1 
   case  "巳","午"  b1=2 
   case  "辰","戌","丑","未"  b1=3  
   case  "申","酉"  b1=4 
   case  "亥","子"  b1=5
end select

select case  chuan2
    case "寅","卯" b2=1 
    case "巳","午" b2=2 
    case "辰","戌","丑","未" b2=3  
    case "申","酉" b2=4 
    case "亥","子" b2=5
end select

select case  chuan3
    case "寅","卯" b3=1 
    case "巳","午" b3=2 
    case "辰","戌","丑","未" b3=3  
    case "申","酉" b3=4 
    case "亥","子" b3=5
end select
'response.write rtg
LqIndex1=(rtg-b1+5)mod 5
LqIndex2=(rtg-b2+5)mod 5
LqIndex3=(rtg-b3+5)mod 5
LQ1=LIUQIN(LqIndex1)
LQ2=LIUQIN(LqIndex2)
LQ3=LIUQIN(LqIndex3)
%>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" id="paipanTable">
    <tbody>
      <tr>
        <td class="ttop">六壬排盘结果</td>
      </tr>
      <tr>
        <td class="new"><strong>姓名：</strong><%=request("name")%> <strong>出生年:</strong><%=request("birthyear")%><strong> 性别：</strong> 
          <% if request("sex")=1 then
	response.Write("男")
	else
	response.Write("女")
	end if
	%> <strong>占事：</strong><%=zhanshi%></td>
        </tr>
      <tr>
        <td class="new"><strong>公历：</strong><font color="#ff0000"><%=NYANGLI%></font> <strong>农历：</strong><font color="#ff0000"><%=ntime%></font></td>
      </tr>
      <tr>
        <td class="new"><strong>节气：</strong><font color="#0000ff"><%=nextjq%></font></td>
      </tr>
      <tr>
        <td class="new"><strong>干支：</strong><%=ygz%>&nbsp;&nbsp;<%=mgz%>&nbsp;&nbsp;<%=dgz%>&nbsp;&nbsp;<%=tgz%> <strong>月将：</strong><%=yuej%>将</td>
      </tr>
      <tr>
        <td class="new"><strong>旬空：</strong>
         <font color="#ff3300"> <%
	response.write yxk
	%>&nbsp;&nbsp;<%=mxk%>&nbsp;&nbsp;<%=dxk%>&nbsp;&nbsp;<%=hxk%></font></td>
      </tr> <%if phn=1 then%>
  <tr> 
   <td class="new"><strong>年命：</strong><%=ygzs%></td>
  </tr>
  <tr> 
     <td class="new"><strong>行年：</strong><%=hangn%></td>
  </tr>
  <%end if%>
      <tr>
        <td class="new"><table align="center">
          <tr align="center">
            <td class="new" width="20" align="right">&nbsp;</td>
            <td class="new" width="23"><%=guishens(6)%> </td>
            <td class="new" width="27"><%=guishens(7)%> </td>
            <td class="new" width="25"><%=guishens(8)%> </td>
            <td class="new" width="23"><%=guishens(9)%> </td>
            <td class="new" align="left">&nbsp;</td>
          </tr>
          <tr align="center">
            <td class="new" height="20" align="right">&nbsp;</td>
            <td class="new"><%=tianpan(6)%> </td>
            <td class="new"><%=tianpan(7)%> </td>
            <td class="new"><%=tianpan(8)%> </td>
            <td class="new"><%=tianpan(9)%> </td>
            <td class="new" align="left">&nbsp;</td>
          </tr>
          <tr align="center">
            <td class="new" height="20" align="right"><%=guishens(5)%></td>
            <td class="new"><%=tianpan(5)%> </td>
            <td class="new" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td class="new"><%=tianpan(10)%> </td>
            <td class="new" align="left"><%=guishens(10)%></td>
          </tr>
          <tr align="center">
            <td class="new" align="right"><%=guishens(4)%></td>
            <td class="new"><%=tianpan(4)%> </td>
            <td class="new" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td class="new"><%=tianpan(11)%> </td>
            <td class="new" align="left"><%=guishens(11)%></td>
          </tr>
          <tr align="center">
            <td class="new" align="right">&nbsp;</td>
            <td class="new"><%=tianpan(3)%> </td>
            <td class="new"><%=tianpan(2)%> </td>
            <td class="new"><%=tianpan(1)%> </td>
            <td class="new"><%=tianpan(0)%></td>
            <td class="new" align="left">&nbsp;</td>
          </tr>
          <tr align="center">
            <td class="new" align="right">&nbsp;</td>
            <td class="new"><%=guishens(3)%> </td>
            <td class="new"><%=guishens(2)%> </td>
            <td class="new"><%=guishens(1)%> </td>
            <td class="new"><%=guishens(0)%> </td>
            <td class="new" align="left">&nbsp;</td>
          </tr>
        </table>
          <table height="70" align="center">
            <tr>
              <td  class="new">&nbsp; <%=gs4%>&nbsp;&nbsp; <%=gs3%>&nbsp;&nbsp; <%=gs2%>&nbsp;&nbsp; <%=gs1%> <br>
                &nbsp; <%=jk4%>&nbsp;&nbsp; <%=jk3%>&nbsp;&nbsp; <%=jk2%>&nbsp;&nbsp; <%=jk1%> <br>
                &nbsp; <%=jk3%>&nbsp;&nbsp; <%=right(dgz,1)%>&nbsp;&nbsp; <%=jk1%>&nbsp;&nbsp; <%=left(dgz,1)%> </td>
            </tr>
          </table></td>
      </tr>   <tr> 
    <td align="center" class="new">
    	<%=lq1%>&nbsp;&nbsp;
    	<%=tg1%>&nbsp;&nbsp;
    	<%=chuan1%>&nbsp;&nbsp;
    	<%=scgs1%>
    	<br>
    	<%=lq2%>&nbsp;&nbsp;
    	<%=tg2%>&nbsp;&nbsp;
    	<%=chuan2%>&nbsp;&nbsp;
    	<%=scgs2%>
    	<br>
    	<%=lq3%>&nbsp;&nbsp;
    	<%=tg3%>&nbsp;&nbsp;
    	<%=chuan3%>&nbsp;&nbsp;
    	<%=scgs3%>
    </td>
  </tr>
    </table>
<%else%>
<SCRIPT language=JavaScript>
<!--
function submitchecken() {
	if (document.form1.name.value == "") {
		alert("请输入您的姓名。");
		document.form1.name.focus();
		return false;
		}
	if (document.form1.birthyear.value == "") {
		alert("请选择出生年份");
		document.form1.birthyear.focus();
		return false;
		}
	if (document.form1.sex.value == "") {
		alert("请选择您的性别");
		document.form1.sex.focus();
		return false;
		}
	if (document.form1.zhanshi.value == "") {
		alert("请输入你所需占事情。");
		document.form1.zhanshi.focus();
		return false;
		}
	re="请重新输入！";
 	y=document.form1.y.value;
 	m=document.form1.m.value;
 	d=document.form1.d.value;

	if ((m==4||m==6||m==9||m==11)&&d>30) {
		alert(m+"月只有30天。"+re);
		document.form1.d.focus();
		return false;
		}
	if (y%4!=0&&m==2&&d>28) {
		alert(y+"年是平年，2月只有28天。"+re);
		document.form1.d.focus();
		return false;
		}
	if (m==2&&d>29) {
		alert(y+"年是闰年，2月只有29天。"+re);
		document.form1.d.focus();
		return false;
		}
	showwait();
	return true;
	}
function showwait() {
waitting.style.display="";
waitting.style.visibility="visible";
	return true;
	}
//-->
</SCRIPT>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" >
<tbody><form name="form1"  onsubmit="return submitchecken();" method="post" action="">
<input type="hidden" name="act" value="ok" /><tr>
  <td width="100%" class="ttop">六壬在线排盘系统    </td>
    </tr>
  <tr>
    <td class="new">姓名：
      <input name="name" type="text" id="name" value="<%=xing&ming%>" size="12"> 
      出生时间： 
      <select name=birthyear>
              <%for i=1922 to year(date())%>
              <option value="<%=i%>"<%if i=nian1 then%> selected<%end if%>><%=i%></option>
              <%next%>
            </select> 
      性别: 
      <input name="sex" type="radio" value="1" checked>
      男
      <input type="radio" name="sex" value="0">
      女 <input type=hidden name=cm value=8> 
      占事： <input type="text" name="zhanshi" maxlength="12" size="12" value="<%=zhanshi%>"></td>
  </tr>
  <tr>
    <td class="new">公历时间： 
      
      <select name="y" size="1" id="y" style="font-size: 9pt">
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
<select name="h" size="1" id="h" style="font-size: 9pt">
  <%for i=0 to 23%>
  <option value="<%=i%>" <%if i=hour(now()) then%> selected<%end if%>><%=i%></option>
  <%next%>
</select>
点
<select name="min" size="1" id="min" style="font-size: 9pt">
  <option value="0">未知</option>
  <%for i=0 to 59%>
  <option value="<%=i%>"<%if i=minute(now()) then%> selected<%end if%>><%=i%></option>
  <%next%>
</select>
分&nbsp;&nbsp;<input name=pai type=checkbox value=1>
            排行年 </td>
  </tr>
<td  class="new">
<input id=gs1 name="GuiShen" type="radio" value="1" checked="" />
<label for="gs1"style="cursor:hand;" >甲戊庚牛羊</label>　　　　　
<input id=gs2 type="radio" name="GuiShen" value="0" >
<label for="gs2"style="cursor:hand;" >甲羊戊庚牛</label></td>
</tr>
<tr>
<td  class="new">贵人运行：<input 
      checked name=ZhouYe type=radio value=2>
            自动
            <input name=ZhouYe type=radio value=1>
            昼
            <input name=ZhouYe type=radio 
      value=0>
            夜
            <input name="scpf" type="radio" value="1">
            时旬遁干
            <input name="scpf" type="radio" value="0" checked>
            日旬遁干</td>
</tr> <tr>
<td align="center" class="new"><input type="submit" value="六壬在线排盘" name="submit" style="cursor:hand;" /> </td>
</tr>
</form>
</table><%end if%>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" >
    <tbody>
   
      <tr>
        <td width="100%" class="ttop">说明</td>
      </tr>
      <tr>
        <td class="new">六壬是用阴阳五行占卜吉凶的一种术数。六壬与遁甲、太乙合称三式。五行以水为首，十天干中，壬、癸分别为阳水、阴水。舍阴取阳，六十甲子中壬有六个（壬申、壬午、壬辰、壬寅、壬子、壬戌），称为六壬。六壬有六十四课，以刻有干支的天盘、地盘相叠，转动天盘后得出所值的干支及时辰，判明吉凶。<BR>
          <BR>
          六壬术起源很早，汉代《吴越春秋》、《越绝书》已有记载，《隋书·经籍志》载有《六壬式经杂古》《六壬释兆》。唐《王建诗·贫居》云：“近来身不健，时就六壬古。”说明在唐代时已经很流行六壬术。<BR>
          <BR>
          《四库未收书提要》载录了宋代祝泌的《六壬大古》，并介绍云：“是编《宋志》不著录，郑樵《通志略》所列六壬，多至八十二家。焦宏《经籍志》凡八十九家，钱遵王《述古堂书目》凡一十八家，皆无是册，盖佚已久矣。此从宋刻本依样影抄，卷首有泌边书序及六壬起例。案泌云六壬立名，古今不宣其旨，惟《周礼·哲蔟氏》掌覆夭鸟之巢以方书十日、十二辰、十二月、十二岁、二十八星之号，即壬盘之体，三代之壬书，惟此一证，与术家以五行始于水，水生于一，成于六之说异。”<BR>
          <BR>
          明代无名氏撰《六壬大全》，此书总汇六壬术诸家遗文，颇为详细，在社会上很有影响。<BR>
          <BR>
          六壬术是易之支派，用于卜占，程序复杂，荒诞无稽，已经被历史所淘汰。<BR>
          六壬是我国古典数术之一，与奇门、太乙并称为三式，因土为万物之母，水为万物之源，五行以水为一，且六十花甲子中六个壬故称为六壬。<BR>
          <BR>
          　　
          其法以月将加时辰，立四课，排三传，观阴阳，辩生克，以决吉凶成败。<BR>
          <BR>
          　　
          六壬以占卜人事著称，其法由来已久，具体年代，已无法确定，到了东汉已经盛行，由此已知定是始于汉代以前。<BR>
          <BR>
          　　
          到了北宋，宋仁宗还亲为杨维德编撰的《景偌六壬神定经》作序。说明宋代时已经得到了社会各阶层的喜爱。这时的相关六壬书籍有徐次宾的《口鉴》，宋元改朝换代之际祝泌所著的《六壬大占》和《壬易会元》等书。<BR>
          <BR>
          　　
          明代是中国数术蓬勃发展的时期，六壬类书籍更是层出不穷，其中以袁祥著，郭御青校刊的《六壬大全》、陈公献的《大六壬指南》、尹希吉的《六壬捷录》较为有名。<BR>
          <BR>
          　　
          清代六壬专著更多，主要有徐端华的《六壬直指》等.<BR>
          <BR>
          　　
          民国是文人研究数术成为时髦，这时的六壬类著作主要有韦千里的《千里秘笈》、袁树珊所著《大六壬探源》和徐养浩所著《大六壬金铰剪》等。<BR>
          <BR>
          　　
          建国后由于历史原因，传统数术的研究一度中断。<BR>
          <BR>
          　　
          改革开放以来，易学的春天再度来临，六壬作为一门传统学术，由于起点高，学习难度大，所以对六壬有较高造诣的的学者和能为之一读的六壬类专著却鲜为一见。<BR>
          <BR>
          　　
          近代著作虽然有冯化成的《移神换将》、《六爻神探》，赵向阳的《推盘布局》，皆不如仙鹤居士的《实用六壬预测学》通俗易学，徐伟刚所著《袖里乾坤》阐微发隐，李峰注解的《御定六壬直指》可为一读。<BR></td>
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
