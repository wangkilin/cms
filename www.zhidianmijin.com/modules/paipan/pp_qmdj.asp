<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<TITLE>奇门遁甲在线排盘系统</TITLE>
<!--#include file="top.asp"--><!--#include file="../inc/conn.asp"--><!--#include file="../inc/getuc.asp"-->
<div id="right">
<!--#include file="right.asp"-->
</div>
<div id="left">
<div style="width:100%">
<%if request("act")="ok" then%><%
 name=request("name")
 sex=request("sex")
birthyear=request("birthyear")
zhanshi=request("zhanshi")
Pmethod=request("R1")
nian=request("year")
yue=request("month")
ri=request("date")
shi=request("hour")
fen=request("minute")
order=request("order")
zhuanf=trim(request.Form("r1"))
%>
<!--#include file="inc/sizhu.asp"-->
<!--#include file="inc/jieqi.asp"-->

<%

times=nian&"-"&yue&"-"&ri&" "&shi&":"&fen&":00"
NowTime=nian&"-"&yue&"-"&ri
if not isdate(NowTime) then
response.Write(NowTIME&"不是一个合法的日期,请重新选择日期") 
RESPONSE.END
END IF
call sizhu(nian,yue,ri,shi,fen,ygz,mgz,dgz,tgz)
call xunkong(dgz,rxunk,rxunshou)
call xunkong(tgz,txunk,txunshou)
call xunkong(ygz,yxunk,yxunshou)
call xunkong(mgz,mxunk,mxunshou)
'response.Write(ygz)
%>
<%set fo=server.CreateObject("scripting.filesystemobject")
path=server.MapPath("temp\cal.txt")
set cal=fo.opentextfile(path)
   tag=true 
   i=0
while (not cal.atendofstream) and tag
str=cal.readline
strarr=split(str,",")
    
	 'response.Write(strarr(1))
  
	'response.Write(time1&"<br>")
	'response.Write(time2&"<br>")
	
	  if trim(strarr(1))=trim(nian) then
	    time1=strarr(1)&"-"&strarr(2)&"-"&strarr(3)&" "&strarr(6)&":"&strarr(7)&":00"
	time2=strarr(1)&"-"&strarr(2)&"-"&strarr(8)&" "&strarr(10)&":"&strarr(9)&":00"
	
	 if datediff("s",time1,times)>=0 then
	    i=i+1
		'response.Write("ddddd")
		jiaoj=time1
	 else
	   
	    tag=false
	 end if
	 if datediff("s",time2,times)>=0 then
	   i=i+1
	  ' response.Write("aaaaa")
	  jiaoj=time2
	' response.Write(times&time2&"<br>")
	   end if
	   end if
wend

i=(i+21)mod 24
 jieqq=nian&"年"&yue&"月"&ri&"日"&jq(i)
 NjieQi=jq(i)
 jieqq1=jiaoj&jq(i)
select case njieqi
case "立春","雨水","惊蛰" tqindex=1
case "春分","清明","谷雨" tqindex=2
case "立夏","小满","芒种" tqindex=3
case "夏至","小暑","大暑"  tqindex=4
case "立秋","处暑","白露" tqindex=5
case  "秋分","寒露","霜降" tqindex=6
case "立冬","小雪","大雪" tqindex=7
case "冬至","小寒","大寒" tqindex=0
end select

%>
<%
tiangan1=left(dgz,1)
dizhi1=right(dgz,1)
for i=0 to 9 
if tg(i)=tiangan1 then
tgi=i
exit for
end if
next  '获得天干序号

for i=0 to 11 
if dz(i)=dizhi1 then
dzi=i
exit for
end if
next  '获得地支序号
%>

<% J=0
for i=0 to 59 
TgIndex=i mod 10
DzIndex=i mod 12
if tg(TgIndex)&dz(DzIndex)=dgz then
exit for
end if
j=j+1
next
j=j \ 5
select case j
case 0,3,6,9  yuan="上元"
case 1,4,7,10 yuan="中元"
case 2,5,8,11 yuan="下元"
end select
%>

<%
select case NjieQi
  case "冬至","惊蛰"  YyJu="一七四"
  case "小寒"         YyJu="二八五"
  case "大寒","春分"  YyJu="三九六"
  case "雨水"         YyJu="九六三"
  case "清明","立夏"  YyJu="四一七"
  case "立春"         YyJu="八五二"
  case "谷雨","小满"  YyJu="五二八"
  case "芒种"         YyJu="六三九"
  case "夏至","白露"  YinJu="九三六"
  case "小暑"         YinJu="八二五" 
                     
  case "大暑","秋分"  YinJu="七一四"
  case "立秋"          YinJu="二五八"
  case "寒露","立冬"  YinJu="六九三"
  case "处暑"         YinJu="一四七"
  case "霜降","小雪"  YinJu="五八二"
  case "大雪"         YinJu="四七一"
end select
if YyJu<>"" then
select case yuan
case "中元" JuXu=mid(YyJu,2,1)
case "上元" JuXu=left(YyJu,1)
case "下元" JuXu=RIGHT(YyJu,1)
end select 
DunJu="阳遁"&JuXu&"局"
yinyang=true   '阳局
else
yinyang=false '阴局
select case yuan
case "中元" JuXu=mid(YinJu,2,1)
case "上元" JuXu=left(YinJu,1)
case "下元" JuXu=RIGHT(YinJu,1)
end select 
DunJu="阴遁"&JuXu&"局"
end if'获得阴阳遁局

if trim(request("jutag"))=1 then
ju=request("ju")
if ju>0 then
dunju="阳遁"&ju&"局"
else
dunju="阴遁"&abs(ju)&"局"
end if

end if
%>
<%dim sqly(8)
  DIM lIUyIA(8)
  dim bamens(7)
  dim bashens(7)
  dim jiuxings(7)
  dim tp(7)
  dim tpj(7)
  dim tianqin(7)
  'dim dpjs(8)
select case JuXu
case "一" JuX=1
case "二" JuX=2
case "三" JuX=3
case "四" JuX=4
case "五" JuX=5
case "六" JuX=6
case "七" JuX=7
case "八" JuX=8
case "九" JuX=9
end select

if trim(request("jutag"))=1 then
jux=abs(ju)
end if

%>

<%
if yinyang then
ijk=0
for i=jux-1 to jux+7
sqindex=i mod 9
sqly(sqindex)=left(liuyi(ijk),1)
LiuYiA(sqindex)=liuyi(ijk)
ijk=ijk+1
'dpjs(sqindex)
next
else
ijk=10

for i=jux-1 to jux+7
sqindex=i mod 9
ijk=(ijk+8) mod 9
sqly(sqindex)=left(liuyi(ijk),1)
LiuYiA(sqindex)=liuyi(ijk)

next
end if  '三奇六议
%>
<%zHuFu=0
FOR I=0 TO 8
IF INSTR(LiuYiA(I),tXunShou)>0 then
ZhuFu=i+1
exit for
end if
NEXT
select case zhufu
case 1 zfindex=1
case 8 zfindex=2
case 3 zfindex=3
case 4 zfindex=4
case 9 zfindex=5
case 2 zfindex=6
case 7 zfindex=7
case 6 zfindex=8
case 5 zfindex=6
end select '转盘排法
zhifu=jiuxing(zfindex-1)  '值符
if zfindex=9 then
zfindex1=tqindex+1
else
zfindex1=zfindex  '值使
end if'直符和直使  等于5怎么办
'response.write zfindex&zfindex1&zhufu
zhishi=bamen(zfindex1-1)

if zhuanf="fg" then  '飞宫排法
zhifu=Fjiuxing(zhufu-1)
zhishi=Fjiumen(zhufu-1)

end if
sg=left(tgz,1) '时干
if sg="甲" then
select case tgz
case "甲子" sg="戊"
case "甲戌" sg="己"
case "甲申" sg="庚"
case "甲午" sg="辛"
case "甲辰" sg="壬"
case "甲寅" sg="癸"
end select
end if
'response.write txunshou
 for ia=0 to 8
if sqly(ia)=sg then
sgIndex=ia+1
exit for
end if  '求出时干所在的宫sgindex
next
'response.write sg
'response.write sgindex&sg
select case sgindex
case 1 zfindexa=0
case 8 zfindexa=1
case 3 zfindexa=2
case 4 zfindexa=3
case 9 zfindexa=4
case 2 zfindexa=5
case 7 zfindexa=6
case 6 zfindexa=7
case 5 zfindexa=5
end select
'response.write zfindex
if sgindex=5 then
   trindex=6
   else
   trindex=zfindex
   end if
   
  ' response.Write zfindexa&trindex
  ' response.write jiuxing(trindex-1)
for ib=0 to 7
zf=(zfindexa+ib)mod 8
zfindexb=(zfindex-1+ib+8)mod 8
if zfindexb=5 then
   tianqindex=zf
   end if
jiuxings(zf)=left(jiuxing(zfindexb),2)'九星

next
'response.Write(jiuxings(0))
'response.write zfindexa&"<Br>"
'response.write zhufu&"<Br>"
for i=0 to 7
tianqin(i)="&nbsp;&nbsp;"
next
tianqingindex=(zfindexb+1) mod 9
'response.Write(zhufu)
tianqin(tianqindex)="<font color=red>禽</font>"
'if zhufu=5 then  '替宫的问题
' for i=0 to 7 
' if jiuxings(i)="天禽" then
' itag=i
' exit for
' end if
' next
' for j=0 to 7
' jiuxings((i+j)mod 8)=left(jiuxing((tqindex+j)mod 8),2)
' next
'tianqin(itag)=mid(jiuxings(itag),2,1) 
'jiuxings(itag)="天禽"
'
'else
'tianqin(tqindex)="禽"
'end if                  '天禽星
%>
<%for i=0 to 9
if tg(i)=left(tgz,1) then
Iindex=i
exit for
end if
next

'response.write left(tgz,1)&Iindex
select case Txunshou
case "甲子" sg1="戊"
case "甲戌" sg1="己"
case "甲申" sg1="庚"
case "甲午" sg1="辛"
case "甲辰" sg1="壬"
case "甲寅" sg1="癸"
end select
for i=0 to 7
if sqly(i)=sg1 then
xsindext=i+1
exit for
end if
next
'response.Write(sg1)
'response.write Txunshou
'response.write Txunshou&xindex&zfindex1
select case zhishi
case "休门" xsindex=1
case "死门" xsindex=2
case "伤门" xsindex=3
case "杜门" xsindex=4
case "开门" xsindex=6
case "惊门" xsindex=7
case "生门" xsindex=8
case "景门" xsindex=9
end select 
'response.Write(yinyang&xsindex&iindex)
'response.Write(xsindext&"dd"&iindex)
if yinyang then
bmindex=(xsindext+iindex) mod 9
'response.write iindex
'response.write zhufu
else
bmindex=(xsindext-iindex+9)mod 9
end if

'response.write "b="&Iindex&"<br>a="&xsindex&"<br>bm="&bmindex
if bmindex=0 then
bmindex=9
end if
'response.write bmindex
'response.write Txunshou&iindex&xsindex

select case bmindex
case 1 bmindexa=0
case 8 bmindexa=1
case 3 bmindexa=2
case 4 bmindexa=3
case 9 bmindexa=4
case 2 bmindexa=5
case 7 bmindexa=6
case 6 bmindexa=7
case 5 bmindexa=5
end select
'if yinyang then
'response.write bmindex
'response.write bmindexa&zfindex
'response.write BmIndex
for i=0 to 7
bamenindex=(bmindexa+i)mod 8
zfindexb=(zfindex1-1+i)mod 8
'response.Write(zfindexb)
bamens(bamenindex)=bamen(zfindexb)

select case bamens(bamenindex)
case "开门", "休门", "生门" bamens(bamenindex)="<font color=red>"&bamens(bamenindex)&"</font>"
end select 
next     
'response.write zfindex1'八门算法
%>
<%' 天盘天干
dim sqtag(8)
for i=0 to 7
select case jiuxings(i) 
case "天蓬"  tpi=0 
case "天任"  tpi=7 
case "天冲"  tpi=2
case "天辅"  tpi=3
case "天英"  tpi=8
case "天芮"  tpi=1
case "天柱"  tpi=6
case "天心"  tpi=5
case "天禽"  tpi=4
end select
tp(i)=sqly(tpi)

'response.write tpi&jiuxings(i) 
sqtag(tpi)=true
next

for i=0 to 8
if not sqtag(i) and zhufu<>5 then
tpj(tianqindex)=sqly(i) 
exit for
else if not sqtag(i) and zhufu=5 then
    
	tpj(tianqindex)=sqly(i)
	
     exit for
     end if
end if
next'天盘天干
for i=0 to 7 
if trim(tpj(i))="" then
tpj(i)="&nbsp;&nbsp;"

end if
next
%>
<%'八神
if yinyang then

for i=0 to 7
ij=(zfindexa+i)mod 8
bashens(ij)=bashen(i)
select case bashens(i)
case "直符","六合", "九地" ,"九天" bashens(i)="<font color=red>"&bashens(i)&"</font>"
end select
next
else

for i=0 to 7
ij=(zfindexa+i)mod 8
ik=(8-i)mod 8
bashens(ij)=bashen(ik)
select case bashens(i)
case "直符","六合", "九地" ,"九天" bashens(i)="<font color=red>"&bashens(i)&"</font>"
end select
next
end if
'response.write "zhufu"&zhufu
%>



<% '飞宫排法

DIM fgJx(8)
Dim FgBm(8)
dim fGtp(8)
dim fgtpJS(8)
dim FgDpJs(8)
if zhuanf="fg" then  '飞宫排法
for ia=0 to 8
if sqly(ia)=sg then
Fgsg=ia
exit for
end if
next
'response.write fgsg&"<br>"&zhufu&"<br>"
if bmindex=0 then
bmindex=9
end if
if yinyang then  '九门九星顺排
  for i=0 TO 8
  FgJx((i+FgSg)mod 9)=FJIUXing((i+zhufu-1)mod 9)
  NEXT
  
  for i=0 to 8
  FgBm((I+bmIndex-1)mod 9)=FjiuMen((zhufu+i-1)mod 9)
  next
  
    for i=0 to 8 '天盘九神
  FgtpjS((i+FgSg)mod 9)=Fjiushen(i)
  next
   for i=0 to 8 '地盘九神
  FgdpjS((i+zhufu-1)mod 9)=Fjiushen(i)
  next
else  '九门九星逆排
for i=0 TO 8
  FgJx((i+FgSg)mod 9)=FJIUXing((zhufu-i+8)mod 9)
  'response.Write((zhufu-i+8)mod 9)
  NEXT
  
   for i=0 to 8'九门
  FgBm((I+bmIndex-1)mod 9)=FjiuMen((zhufu-i+8)mod 9)
  
  next

  for i=0 to 8 '九神
  FgtpjS((i+FgSg)mod 9)=Fyjiushen((9-i)mod 9)
  next
   for i=0 to 8 '地盘九神
  FgdpjS((i+zhufu-1)mod 9)=Fyjiushen((9-i)mod 9)
  next
end if '九门九星结尾
'if yinyang then 
'response.write Fjiumen(zhufu-1)
'天盘天干的
 for i=0 to 8
select case FgJx(i)
case "蓬" FgTpIndex=0
case "芮" FgTpIndex=1
case "冲" FgTpIndex=2
case "辅" FgTpIndex=3
case "禽" FgTpIndex=4
case "心" FgTpIndex=5
case "柱" FgTpIndex=6
case "任" FgTpIndex=7
case "英" FgTpIndex=8
end select
FgTp(i)=sqly(FgTpIndex)
next '天盘天干

end if '飞宫结尾
'response.Write(txunshou&)

for i= 0 to 8
select case sqly(i)
case "乙","丙","丁"  sqly(i)="<font color=red>"&sqly(i)&"</font>"
end select
next 

for i= 0 to 7
select case tpj(i)
case "乙","丙","丁" tpj(i)="<font color=red>"&tpj(i)&"</font>"
end select
select case tp(i)
case "乙","丙","丁" tp(i)="<font color=red>"&tp(i)&"</font>"
end select


select case jiuxings(i)
case "天辅", "天心", "天任", "天禽" jiuxings(i)="<font color=red>"&jiuxings(i)&"</font>"
                                     
end select 
next
%>
 



<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" id="paipanTable">
    <tbody>
      <tr>
        <td class="ttop"><strong>奇门遁甲在线排盘系统</strong></td>
      </tr>
      <tr>
        <td class="new"><strong>姓名：</strong><%=request("name")%> <strong>出生年:</strong><%=request("birthyear")%><strong> 性别：</strong>
          <% if sex=1 then
	response.Write("男")
	else
	response.Write("女")
	end if
	%>          <strong>&nbsp;占事：</strong><%=zhanshi%></td>
        </tr>
      <tr>
        <td class="new"><strong>公历时间</strong>：<%=times%>　　<strong>农历时间：</strong><% call form_load(times,ntime,cyue,cri,cnian)
	response.Write(ntime)
	%>
<br><strong>节气</strong>：<%=jieqq1&yuan%>&</a>
<br><strong>干支：</strong><%=ygz&"  "&mgz&"  "&dgz&"  "&tgz%>
<br><strong>当日旬空</strong>：<strong><%=yxunk%></strong>(年)&nbsp;<strong><%=mxunk%></strong>(月)&nbsp;<strong><%=rxunk%></strong>(日)&nbsp;<strong><%=txunk%></strong>(时)
<br>&nbsp;
<br>此局为<strong><%=DunJu%></strong>&nbsp;&nbsp;直符<strong>:<%=zhifu%></strong>&nbsp;&nbsp;直使<strong>:<%=zhishi%></strong>
</td>      </tr>
      <tr>
        <td align="center" class="new"><br>
  <%
  if zhuanf="zp" then%>
<br>　　　　　┌──────┬──────┬──────┐
<br>　　　　　│　　<%=bashens(3)%>　　│　　<%=bashens(4)%>　　│　　<%=bashens(5)%>　　│
<br>　　　　　│<%=tianqin(3)%>　<%=jiuxings(3)%>　<%=tp(3)%>│<%=tianqin(4)%>　<%=jiuxings(4)%>　<%=tp(4)%>│<%=tianqin(5)%>　<%=jiuxings(5)%>　<%=tp(5)%>│
<br>　　　　　│<%=tpj(3)%>　<%=bamens(3)%>　<%=sqly(3)%>│<%=tpj(4)%>　<%=bamens(4)%>　<%=sqly(8)%>│<%=tpj(5)%>　<%=bamens(5)%>　<%=sqly(1)%>│
<br>　　　　　├──────┼──────┼──────┤
<br>　　　　　│　　<%=bashens(2)%>　　│　　　　　　│　　<%=bashens(6)%>　　│
<br>　　　　　│<%=tianqin(2)%>　<%=jiuxings(2)%>　<%=tp(2)%>│　　　　　　│<%=tianqin(6)%>　<%=jiuxings(6)%>　<%=tp(6)%>│
<br>　　　　　│<%=tpj(2)%>　<%=bamens(2)%>　<%=sqly(2)%>│　　　　　<%=sqly(4)%>│<%=tpj(6)%>　<%=bamens(6)%>　<%=sqly(6)%>│
<br>　　　　　├──────┼──────┼──────┤
<br>　　　　　│　　<%=bashens(1)%>　　│　　<%=bashens(0)%>　　│　　<%=bashens(7)%>　　│
<br>　　　　　│<%=tianqin(1)%>　<%=jiuxings(1)%>　<%=tp(1)%>│<%=tianqin(0)%>&nbsp;&nbsp;<%=jiuxings(0)%>　<%=tp(0)%>│<%=tianqin(7)%>　<%=jiuxings(7)%>　<%=tp(7)%>│
<br>　　　　　│<%=tpj(1)%>　<%=bamens(1)%>　<%=sqly(7)%>│<%=tpj(0)%>　<%=bamens(0)%>　<%=sqly(0)%>│<%=tpj(7)%>　<%=bamens(7)%>　<%=sqly(5)%>│
<br>　　　　　└──────┴──────┴──────┘<br>
<br>
  
  <%else%>
<br>　　　　　┌─────┬─────┬─────┐
<br>　　　　　│<%=fgtpjs(3)%><%=fgjX(3)%> &nbsp;<%=fgtp(3)%>│<%=fgtpjs(8)%><%=fgjX(8)%> &nbsp;<%=fgtp(8)%>│<%=fgtpjs(1)%> <%=fgjX(1)%>&nbsp; <%=fgtp(1)%>│
<br>　　　　　│ &nbsp;&nbsp;&nbsp;<%=fgBm(3)%> &nbsp;&nbsp;&nbsp;│ &nbsp;&nbsp;&nbsp;<%=fgBm(8)%> &nbsp;&nbsp;&nbsp;│ &nbsp;&nbsp;&nbsp;<%=fgBm(1)%> &nbsp;&nbsp;&nbsp;│
<br>　　　　　│<%=fgdpjs(3)%>巽 &nbsp;<%=sqly(3)%>│<%=fgdpjs(8)%>离&nbsp; <%=sqly(8)%>│<%=fgdpjs(1)%>坤 
&nbsp;<%=sqly(1)%>│
<br>　　　　　├─────┼─────┼─────┤
<br>　　　　　
│<%=fgtpjs(2)%><%=fgjX(2)%> &nbsp;<%=fgtp(2)%>│<%=fgtpjs(4)%><%=fgjX(4)%> &nbsp;<%=fgtp(4)%>│<%=fgtpjs(6)%><%=fgjX(6)%> &nbsp;<%=fgtp(6)%>│
<br>　　　　　│ &nbsp;&nbsp;&nbsp;<%=fgBm(2)%> &nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;&nbsp; <%=fgBm(4)%> &nbsp;&nbsp;&nbsp;│ &nbsp;&nbsp;&nbsp;<%=fgBm(6)%> &nbsp;&nbsp; │
<br>　　　　　│<%=fgdpjs(2)%>震 &nbsp;<%=sqly(2)%>│<%=fgdpjs(4)%>中 &nbsp;<%=sqly(4)%>│<%=fgdpjs(6)%>兑 &nbsp;<%=sqly(6)%>│
<br>　　　　　├─────┼─────┼─────┤
<br>　　　　　│<%=fgtpjs(7)%><%=fgjX(7)%> &nbsp;<%=fgtp(7)%>│<%=fgtpjs(0)%><%=fgjX(0)%>&nbsp; <%=fgtp(0)%>│<%=fgtpjs(5)%><%=fgjX(5)%>&nbsp;&nbsp;<%=fgtp(5)%>│
<br>　　　　　│ &nbsp;&nbsp;&nbsp;<%=fgBm(7)%> &nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;&nbsp; <%=fgBm(0)%> &nbsp;&nbsp;&nbsp;│ &nbsp;&nbsp;&nbsp;<%=fgBm(5)%> &nbsp;&nbsp; │
<br>　　　　　│<%=fgdpjs(7)%>艮&nbsp; <%=sqly(7)%>│<%=fgdpjs(0)%>坎 &nbsp;<%=sqly(0)%>│<%=fgdpjs(5)%>乾&nbsp; <%=sqly(5)%>│
<br>　　　　　└─────┴─────┴─────┘<br> <br>
    
  <%end if%></td>

      </tr>
      
      
       <%if phn=1 then%>
  
  <%end if%>
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
<tbody><form name="form1"   onsubmit="return submitchecken();" method="post" action="">
<input type="hidden" name="act" value="ok" /><tr>
  <td width="100%" class="ttop"><strong>奇门遁甲在线排盘系统</strong></td>
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
      占事： <input name="zhanshi" type="text" id="zhanshi" value="<%=zhanshi%>" size="12" maxlength="12"></td>
  </tr>
<tr id="fs1" style="display:block"> 

    <td class="new">公历时间： 
      
      <select name="year" size="1" id="year" style="font-size: 9pt">
        >
        <%for i=1950 to year(date())%>
        <option value="<%=i%>" <%if i=year(date()) then%> selected<%end if%>><%=i%></option>
        <%next%>
      </select>
年
<select name="month" size="1" id="month" style="font-size: 9pt">
  <%for i=1 to 12%>
  <option value="<%=i%>"<%if i=month(date()) then%> selected<%end if%>><%=i%></option>
  <%next%>
</select>
月
<select name="date" size="1" id="date" style="font-size: 9pt">
  <%for i=1 to 31%>
  <option value="<%=i%>" <%if i=day(date()) then%> selected<%end if%>><%=i%></option>
  <%next%>
</select>
日
<select name="hour" size="1" id="hour" style="font-size: 9pt">
  <%for i=0 to 23%>
  <option value="<%=i%>" <%if i=hour(now()) then%> selected<%end if%>><%=i%></option>
  <%next%>
</select>
点
<select name="minute" size="1" id="minute" style="font-size: 9pt">
  <option value="0">未知</option>
  <%for i=0 to 59%>
  <option value="<%=i%>"<%if i=minute(now()) then%> selected<%end if%>><%=i%></option>
  <%next%>
</select>
分&nbsp;&nbsp;</td>
  </tr>
<tr id="fs2" style="display:none"> 
<td class="new"><span class="style4">四柱：</span> <span class="style4">&nbsp;&nbsp;
<select name="Nian" size="1">
<Option value=0>甲子</option><Option value=1>乙丑</option><Option value=2>丙寅</option><Option value=3>丁卯</option><Option value=4>戊辰</option><Option value=5>己巳</option><Option value=6>庚午</option><Option value=7>辛未</option><Option value=8>壬申</option><Option value=9>癸酉</option><Option value=10>甲戌</option><Option value=11>乙亥</option><Option value=12>丙子</option><Option value=13>丁丑</option><Option value=14>戊寅</option><Option value=15>己卯</option><Option value=16>庚辰</option><Option value=17>辛巳</option><Option value=18>壬午</option><Option value=19>癸未</option><Option value=20>甲申</option><Option value=21>乙酉</option><Option value=22>丙戌</option><Option value=23>丁亥</option><Option value=24>戊子</option><Option value=25>己丑</option><Option value=26>庚寅</option><Option value=27>辛卯</option><Option value=28>壬辰</option><Option value=29>癸巳</option><Option value=30>甲午</option><Option value=31>乙未</option><Option value=32>丙申</option><Option value=33>丁酉</option><Option value=34>戊戌</option><Option value=35>己亥</option><Option value=36>庚子</option><Option value=37>辛丑</option><Option value=38>壬寅</option><Option value=39>癸卯</option><Option value=40>甲辰</option><Option value=41>乙巳</option><Option value=42>丙午</option><Option value=43>丁未</option><Option value=44>戊申</option><Option value=45>己酉</option><Option value=46>庚戌</option><Option value=47>辛亥</option><Option value=48>壬子</option><Option value=49>癸丑</option><Option value=50>甲寅</option><Option value=51>乙卯</option><Option value=52>丙辰</option><Option value=53>丁巳</option><Option value=54>戊午</option><Option value=55>己未</option><Option value=56>庚申</option><Option value=57>辛酉</option><Option value=58>壬戌</option><Option value=59>癸亥</option> 
</select>
年 
<select name="Yue" size="1">
<Option value=1>寅月</option><Option value=2>卯月</option><Option value=3>辰月</option><Option value=4>巳月</option><Option value=5>午月</option><Option value=6>未月</option><Option value=7>申月</option><Option value=8>酉月</option><Option value=9>戌月</option><Option value=10>亥月</option> 
<Option value="11">子月</Option>
<Option value="12">丑月</Option>
</select>
月 
<select name="Ri" size="1">
<Option value=0>甲子</option><Option value=1>乙丑</option><Option value=2>丙寅</option><Option value=3>丁卯</option><Option value=4>戊辰</option><Option value=5>己巳</option><Option value=6>庚午</option><Option value=7>辛未</option><Option value=8>壬申</option><Option value=9>癸酉</option><Option value=10>甲戌</option><Option value=11>乙亥</option><Option value=12>丙子</option><Option value=13>丁丑</option><Option value=14>戊寅</option><Option value=15>己卯</option><Option value=16>庚辰</option><Option value=17>辛巳</option><Option value=18>壬午</option><Option value=19>癸未</option><Option value=20>甲申</option><Option value=21>乙酉</option><Option value=22>丙戌</option><Option value=23>丁亥</option><Option value=24>戊子</option><Option value=25>己丑</option><Option value=26>庚寅</option><Option value=27>辛卯</option><Option value=28>壬辰</option><Option value=29>癸巳</option><Option value=30>甲午</option><Option value=31>乙未</option><Option value=32>丙申</option><Option value=33>丁酉</option><Option value=34>戊戌</option><Option value=35>己亥</option><Option value=36>庚子</option><Option value=37>辛丑</option><Option value=38>壬寅</option><Option value=39>癸卯</option><Option value=40>甲辰</option><Option value=41>乙巳</option><Option value=42>丙午</option><Option value=43>丁未</option><Option value=44>戊申</option><Option value=45>己酉</option><Option value=46>庚戌</option><Option value=47>辛亥</option><Option value=48>壬子</option><Option value=49>癸丑</option><Option value=50>甲寅</option><Option value=51>乙卯</option><Option value=52>丙辰</option><Option value=53>丁巳</option><Option value=54>戊午</option><Option value=55>己未</option><Option value=56>庚申</option><Option value=57>辛酉</option><Option value=58>壬戌</option><Option value=59>癸亥</option> 
</select>
日 
<select name="Shi" size="1">
<Option value=0>子时</option><Option value=1>丑时</option><Option value=2>寅时</option><Option value=3>卯时</option><Option value=4>辰时</option><Option value=5>巳时</option><Option value=6>午时</option><Option value=7>未时</option><Option value=8>申时</option><Option value=9>酉时</option><Option value=10>戌时</option><Option value=11>亥时</option> 
</select>
时 
<select name="ju" id="ju">
<option value="1" selected="">阳一局</option>
<option value="2">阳二局</option>
<option value="3">阳三局</option>
<option value="4">阳四局</option>
<option value="5">阳五局</option>
<option value="6">阳六局</option>
<option value="7">阳七局</option>
<option value="8">阳八局</option>
<option value="9">阳九局</option>
<option value="-1">阴一局</option>
<option value="-2">阴二局</option>
<option value="-3">阴三局</option>
<option value="-4">阴四局</option>
<option value="-5">阴五局</option>
<option value="-6">阴六局</option>
<option value="-7">阴七局</option>
<option value="-8">阴八局</option>
<option value="-9">阴九局</option>
</select>
局</span></td>
</tr>
<tr> 
<td class="new"> <input id=gl type="radio" name="jutag" value="0" checked="" onClick="javacript:fs1.style.display='block';fs2.style.display='none';fs3.style.display='block';" />
<label for="gl"style="cursor:hand;" >按公历起局</label>　　　
  <input id=sz type="radio" name="jutag" value="1" onClick="javacript:fs1.style.display='none';fs2.style.display='block';fs3.style.display='none';" />
  <label for="sz"style="cursor:hand;" >按四柱起局</label></td>
</tr>
<tr> 
<td class="new"><input id=zp type="radio" name="R1" value="zp" checked="" onClick="javacript:fs4.style.display='none';" //>
<label for="zp"style="cursor:hand;" >转盘奇门</label>　　　　
  <input id=fg type="radio" name="R1" value="fg" onClick="javacript:fs4.style.display='block';" />
  <label for="fg"style="cursor:hand;" >飞盘奇门</label></td>
</tr>
<tr id="fs4" style="display:none"> 
<td class="new"><input name="order" id=yx type="radio" value="1" checked="" />
 <label for="yx"style="cursor:hand;" > 阳顺阴逆</label>　　　　
    <input type="radio" id=qbx name="order" value="0" />
<label for="qbx"style="cursor:hand;" >全部顺排</label></td>
</tr>
<tr align="center"> 
<td class="new"> 
<input name="Submit" type="submit" value="奇门遁甲起局" style="cursor:hand;" /></td>
</tr>
</tbody>
</form>
</table>
  <%end if%>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" >
    <tbody>
   
      <tr>
        <td width="100%" class="ttop"><strong>奇门遁甲</strong>排盘说明</td>
      </tr>
      <tr>
        <td class="new"><p>奇门遁甲，原来是中国古老的一本书，但它往往被认为是一本占卜用的书，但有的说法是说《奇门遁甲》是我国古代人民在同大自然作斗争中，经过长期观察、反复验证，总结出来的一门传统珍贵文化遗产。还有的说“奇门遁甲”是修真的功法。
          
          </p>
          <p>“奇门遁甲”的含义是什么呢？就是由“奇”，“门”，“遁甲”三个概组成。“奇”就是乙，丙，丁三奇；“门”就是休，生，伤，杜，景，死，惊，开八门；“遁”是隐藏的意思，“甲”指六甲，即甲子，甲戌，甲申，甲午，甲辰，甲寅，“遁甲”是在十干中最为尊贵，它藏而不现，隐遁于六仪之下。“六仪”就是戊，己，庚，辛，壬，癸。隐遁原则是甲子同六戊，甲戌同六己，甲申同六庚，甲午同六辛，甲辰同六壬，甲寅同六癸。另外还配合蓬，任，冲，辅，英，芮，柱，心，禽九星。奇门遁的占测主要分为天，门，地三盘，象征三才。天盘的九宫有九星，中盘的八宫（中宫寄二宫）布八门，地盘的八宫代表八个方位，静止不动，同时天盘地盘上，每宫都分配着特定的奇（乙，丙，丁）仪（戊，己，庚，辛，壬，癸六仪）。这样，根据具体时日，以六仪，三奇，八门，九星排局，以占测事物关系，性状，动向，选择吉时吉方，就构成了中国神秘文化中一个特有的门类----奇门遁甲。 </p></td>
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