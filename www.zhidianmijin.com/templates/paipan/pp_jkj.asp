<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<TITLE>金口诀在线排盘系统-算命网网
</TITLE>
<!--#include file="top.asp"--><!--#include file="../inc/conn.asp"--><!--#include file="../inc/getuc.asp"-->
<div id="right">
<!--#include file="right.asp"-->
</div>
<div id="left">
<div style="width:100%">
<%if request("act")="ok" then%><!--#include file="inc/sizhu.asp"-->
<!--#include file="inc/jieqi.asp"-->
<%
function wuxing(x)
   select case x
          case "甲","乙","寅","卯"  wuxing="木金火"
          case "丙","丁","巳","午" wuxing="火水土"
		  case "戊","己","辰","戌","丑","未" wuxing="土木金"
		  case "庚","辛","申","酉" wuxing="金火水"
		  case "亥","子","壬","癸" wuxing="水土木"
   end select
end function
name=request("name")
jg=request("jg")
Response.Cookies("ciduppname")=name
zhanshi=request("zhanshi")
Response.Cookies("ciduppzhanshi")=zhanshi
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
df=request("df")
zhouye=trim(request("zhouye"))
Pf=request("pf")
Nyangli=y&"年"&m&"月"&d&"日"&h&"时"&mins&"分"
zhouye=request.Form("zhouye")
sex=request("sex")
Gsarrage=request("guishen")
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
if phn=1 then
if suishu<=0 then
response.write "你的输入有误"
response.end
end if
hangn=tg(hntg)&dz(hndz)
end if
'response.write hangn&suishu
%>

<%dates=y&"-"&m&"-"&d
Ytime=dates&" "&h&":"&m&":00"
if not isdate(dates) then
response.write dates&"不是一个合法的日期"
response.end
end if
'response.write ytime
call sizhu(y,m,d,h,mins,ygz,mgz,dgz,tgz)
call form_load(ytime,ntime,cyue,cri,cnian)
call makejq(ytime,prejq,nextjq)
nJQ=RIGHT(NEXTjQ,2)
%>
 <%call xunkong(ygz,yxk,yxs)
	call xunkong(mgz,mxk,mxs)
	call xunkong(dgz,dxk,dxs)
	call xunkong(tgz,hxk,hxs)
	'response.write yxk
	%>

<%'地分
select case request("dftag")
case 2 dzindex=request("nums")
       Df=dz((dzindex+11)mod 12)
case 1 df=dz(request("df"))
case 3 randomize
       df=dz(round(rnd*11) mod 12)
end select 
%>

<% '月将
select case pf
case 1 select case  nJQ
       case "立春","雨水" yuej="亥"
       case "惊蛰","春分" yuej="戌"
       case "清明","谷雨" yuej="酉"
        case "立夏","小满" yuej="申"
         case "芒种","夏至" yuej="未"
       case "小暑","大暑" yuej="午"
        case "立秋","处暑" yuej="巳"
         case "白露","秋分" yuej="辰"
      case "寒露","霜降" yuej="卯"
       case "立冬","小雪" yuej="寅"
        case "大雪","冬至" yuej="丑"
       case "小寒","大寒" yuej="子"

		END SELECT
case 2 select case njq
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
end select  '月将
%>


<%'将神
shizhi=right(tgz,1)
riganorder=Tgorder(dgz)-1
szorder=DzOrder(shizhi)
yjorder=dzorder(yuej)
dforder=dzorder(df)
jsorder=(yjorder+(dforder-szorder)+12) mod 12
if jsorder=0 then
jsorder=12
end if
jiangs=dz(jsorder-1)
js=jsname(jsorder-1)
%>

<% '贵神
if zhouye=2 then 
if szorder>=4 and  szorder<10 then
 zhouye=1
 else
 zhouye=0
end if 
end if  '默认的昼夜选择
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
							 startGs="卯"
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
StartGsOrder=DzOrder(startgs)
if StartGsOrder>=6 and StartGsOrder<=11 then
dir=0
else
dir=1
end if '确定鬼神顺逆
'response.Write(zhouye)
if dir then
gsorder=(12+dforder-startgsorder) mod 12
else
gsorder=(12+startgsorder-dforder) mod 12
end if
gsdz=uisdz(gsorder)
guiren=guishen(gsorder)
%>

<%'人元 将神，贵神天干
if riganorder>4 then
ryindex=(riganorder-4)*2-2
else
ryindex=(riganorder+1)*2-2
end if
jstgindex=(ryindex+jsorder-1)mod 10
'response.write riganorder&ryindex&gsorder
gstgindex=(ryindex+dzorder(gsdz)-1)mod 10
ryindex=(ryindex+dforder-1)mod 10

'response.write jsorder
gstg=tg(gstgindex)
jstg=tg(jstgindex)
renyuan=tg(ryindex)
%>

<%'定用爻
yyy=tgorder(renyuan)
myy=dzorder(gsdz)
dyy=dzorder(jiangs)
hyy=dzorder(df)
if (yyy mod 2)=1 then
yyy=1
else
yyy=-1
end if

if (myy mod 2)=1 then
myy=1
else
myy=-1
end if

if (dyy mod 2)=1 then
dyy=1
else
dyy=-1
end if

if (hyy mod 2)=1 then
hyy=1
else
hyy=-1
end if
yytag=yyy+myy+dyy+hyy
'response.write yytag
if yytag=2 then
 if myy=-1 then
   gsyy="【用爻】"
   end if
    if dyy=-1 then
   jsyy="【用爻】"
   end if  
   
   end if
if yytag=-2 then
 if myy=1 then
  gsyy="【用爻】"
   end if
    if dyy=1 then
   jsyy="【用爻】"
   end if
end if

if yytag=0 or yytag=-4 then
jsyy="【用爻】"
end if

if  yytag=4 then
gsyy="【用爻】"
end if
%>
<%'四大空亡
if dxs="甲子" or  dxs="甲午" then
kongmang="水"
end if

if dxs="甲寅" or  dxs="甲申" then
kongmang="金"
end if
%>
<%'14旺衰
dim ws(3)
tag=0
wxry=wuxing(renyuan)
wxgs=wuxing(gsdz)
wxjs=wuxing(jiangs)
wxdf=wuxing(df)
wxstr=left(wxry,1)&left(wxgs,1)&left(wxjs,1)&left(wxdf,1)
'response.write wxstr
if instr(wxstr,mid(wxry,2,1))=0 then
ws(0)="旺"
tag=tag+1
else
ke=left(wxry,1)
end if
if instr(wxstr,mid(wxgs,2,1))=0 then
ws(1)="旺"
tag=tag+1
else
ke=left(wxgs,1)
end if
if instr(wxstr,mid(wxjs,2,1))=0 then
ws(2)="旺"
tag=tag+1
else
ke=left(wxjs,1)
end if
if instr(wxstr,mid(wxdf,2,1))=0 then
ws(3)="旺"
tag=tag+1
else
ke=left(wxdf,1)
end if
if tag=2 then
    if right(wxry,1)=ke then
	ws(0)=""
	end if

     if right(wxgs,1)=ke then
	ws(1)=""
	end if

     if right(wxjs,1)=ke then
	ws(2)=""
	end if

     if right(wxdf,1)=ke then
	ws(3)=""
	end if
end if
%>






<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" id="paipanTable">
    <tbody>
      <tr>
        <td class="ttop">金口诀在线排盘系统
</td>
      </tr>
      <tr>
        <td class="new">　　
  <strong>姓名</strong>：<%=name%>　　
  <strong>生年</strong>：<%=birthyear%>　　<strong>性别</strong>：
  <%if sex=1 then
	response.Write("男")
	else
	response.Write("女")
end if%>　　
  <strong>占事</strong>：<%=zhanshi%>
  <br>　　
  <B>公历</B>： <%=NYANGLI%>　　<B>农历</B>：<%=ntime%>
  <br>　　
  <B>节气</B>：<%=nextjq%> 
  <br>　　
  <strong>干支</strong>：<font color="#FF0000"> <%=ygz%>&nbsp;&nbsp;<%=mgz%>&nbsp;&nbsp;<%=dgz%>&nbsp;&nbsp;<%=tgz%></font>　　<strong>月将</strong>：<%=yuej%>将
  <br>　　
  <strong>旬空：</strong> <%=yxk%>&nbsp&nbsp<%=mxk%>&nbsp&nbsp<%=dxk%>&nbsp&nbsp<%=hxk%>　　
  <%if kongmang<>"" then%>
  <B>四大空亡： <%=kongmang%>
  <%else%>
          www.114xk.cn
  <%end if%>
          
          <%if phn=1 then%>
    <br>　　
          <B>年命</B>： <%=ygzs%>
          <%end if%>
          <%if phn=1 then%>
    <br>　　
          <B>行年</B>： <%=hangn%>
          <%end if%>
    <br>
  &nbsp;
  <br>　　
  <B>人元</B>： <%=renyuan%>
  <%'=ws(0)%> 
  <br>　　
  <B>贵神</B>： <%=gstg%><%=gsdz%>(<%=guiren%>)
  <font color="#0000FF"><%=gsyy%><%'=ws(1)%></font>
 
  <br>　　
  <B>将神</B>： <%=jstg%><%=jiangs%>(<%=js%>)<font color="#0000FF"><%=jsyy%> </font>
  <%'=ws(2)%>
  <br>　　
  <B>地分</B>： <%=df%>
  <%'=ws(3)%></td>

      </tr>

    </table>
<%else%><%
dz(0)="子"
dz(1)="丑"
dz(2)="寅"
dz(3)="卯"
dz(4)="辰"
dz(5)="巳"
dz(6)="午"
dz(7)="未"
dz(8)="申"
dz(9)="酉"
dz(10)="戌"
dz(11)="亥"

%>
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
  <td width="100%" class="ttop">金口诀在线排盘系统</td>
    </tr>
  <tr>
    <td class="new">姓名：
      <input name="name" type="text" id="name" value="<%=xing&ming%>" size="12"> 
      出生时间： 
      <select name=birthyear>
              <%for i=1922 to year(date())%>
              <option value="<%=i%>"<%if i=1981 then%> selected<%end if%>><%=i%></option>
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
        >
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

<tr>
<td  class="new"><INPUT name=dftag type=radio value=1>
            地分　：
            <SELECT name=df>
            <OPTION selected value=0>子</OPTION>
            <OPTION value=1>丑</OPTION>
            <OPTION value=2>寅</OPTION>
            <OPTION value=3>卯</OPTION>
            <OPTION value=4>辰</OPTION>
            <OPTION value=5>巳</OPTION>
            <OPTION value=6>午</OPTION>
            <OPTION value=7>未</OPTION>
            <OPTION value=8>申</OPTION>
            <OPTION value=9>酉</OPTION>
            <OPTION value=10>戌</OPTION>
            <OPTION value=11>亥</OPTION>
          </SELECT>
          <INPUT name=dftag type=radio value=2>
            报数
            <input name="nums" type="text" id="nums" size="6">
            
            <INPUT name=dftag type=radio value=3 checked>
            随机地分</td>
</tr><tr>
<td  class="new">贵人运行：<input 
      checked name=ZhouYe type=radio value=2>
            自动
            <input name=ZhouYe type=radio value=1>
            昼
            <input name=ZhouYe type=radio 
      value=0>
            夜</td>
</tr><tr>
<td  class="new"><input id=gs1 name="GuiShen" type="radio" value="1" checked="" />
<label for="gs1"style="cursor:hand;" >甲戊庚牛羊</label>　
<input id=gs2 type="radio" name="GuiShen" value="0" >
<label for="gs2"style="cursor:hand;" >甲羊戊庚牛</label>
              <input type="radio" id=pf1 name="Pf" value="1" checked><label for="pf1"style="cursor:hand;" >交节换将</label>
       
            <input type="radio" id=pf2 name="Pf" value="0"><label for="pf2"style="cursor:hand;" >中气换将</label></td>
</tr>  <tr>
<td align="center" class="new"><input type="submit" value="在线八字排盘" name="submit" style="cursor:hand;" /> </td>
</tr>
</form>
</table>
  <%end if%>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" >
    <tbody>
   
      <tr>
        <td width="100%" class="ttop">金口诀的源流</td>
      </tr>
      <tr>
        <td class="new"><br />
　 提到金口诀就不可以不说大六壬，因为金口诀的全称就是&quot;大六壬神课金口诀&quot;。因此，可知金口诀是源于大六壬脱胎形成的新的一种预测科学。<br />
&nbsp; &nbsp;大六壬据传说源于上古九天玄女，但这毕竟只是传说。有史料记载的就是东汉赵晔《吴越春秋》，袁康《越绝书》均已有大六壬之文字，故由此可知大六壬应早于东汉时期出现。<br />
&nbsp; &nbsp;大六壬发展到战国时期，由阿鄄之间出生的伟大的军事家、玄学家孙膑简化而形成一门崭新的预测体系--&quot;大六壬神课金口诀&quot;，又有&quot;孙膑神课&quot;、&quot;小六壬&quot;、&quot;六壬时课&quot;等诸多别名。<br />
　　金口诀自孙膑创立后，在其传人后代中口口相传，不留文字，一直不为外人所知。我们现在可以看到的有关金口诀的著作最早的就是明朝时期的《大六壬神课金口诀》。这也是金口诀唯一的古版专著，但内容参差不齐，留下了几个时代的痕迹，并且篇张之间的距离感很强，由我推测应该不是一个人所著，此书应该是几个朝代的金口诀先师智慧的结晶。<br />
　　金口诀在孙膑之后的传承者们远离了政治舞台。以行卜为生，由于时代的久远，在传承上出现了一些不同的小支派，有的重口诀神煞，有的重旺相休囚，有的重年月日时对课内的影响等等，不一而同。这给金口诀的爱好者带来了许多的麻烦事，以致于到今天为止能全力研究金口诀的易学爱好者寥寥无几，更谈不上精通了。<br />
金口诀断课的几种层次<br />
　　一种易术的好坏高低，无非是准确率的问题。&quot;金口诀&quot;既然有这样一个名字，也肯定有着它必然的道理。前文提到金口诀的传承中出现了分化分支的问题，导致了每个流派在断课中使用的方法不同，从而使准确率成为评价一种流派最佳的裁判。<br />
　　金口诀断课分为以下几种层次：<br />
　　第一种层次就是用口诀生搬硬套，简单的三动五动、大量的神煞，以及用月令日辰分出旺衰，这种断课方法是当前在金口诀界最多的断课技能，流传得最广，也是最简单的方法，应验率一般。<br />
　　第二层次，就是可以不用口诀、神煞，不用月令日辰的旺衰，可以灵活应用三动五动，准确地判断课内旺衰，大量地使用旺相休囚死配合用爻来判断事体，达到这种层次的人已经不多了，用这种方法断课准确率可迅速提升至令人惊汉的境界。<br />
　　第三层次，就是已经进入化境，对各种金口诀的理论精髓全部融会贯通，达到可以不用三动五动，不用旺相休囚死，只凭五行之间的生克来断事，这种层次已经是超越了金口诀的界限，可以灵活应用各种易术来给金口诀服务，说到底的一句话就是干支关系烂熟于心。<br />
　　以上三个层次就是当今金口诀界的现状，想提升层次又须要聚备扎实的基本功和敏于上进的心态和明师不断的循循善诱。具备了以上几点，学好用好金口诀就不是一件难事了。<br />
　　金口诀美好的明天靠我们一起来创造！ <br></td>
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
