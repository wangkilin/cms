<%
'on error resume next
name=request.Form("name")
Response.Cookies("ciduppname")=name
area=request.Form("area")
Response.Cookies("ciduppaddr")=area
if area="" then area="未输入"
jd1=request.Form("jd1")
jd2=request.Form("jd2")
yea=request.Form("year")
mon=request.Form("month")
dat=trim(request.Form("date"))
hou=request.Form("hour")
minut=request.Form("minute")
sex=request.Form("sex")
quanpai=request.form("quanpai")
datetype=trim(request.Form("datetype"))
if datetype=0 then
		yangli=yzhy(yea&"-"&mon&"-"&dat)
		'res ponse.Write("dd")
		yea=year(yangli)
		mon=month(yangli)
		dat=day(yangli)
end if
borntime=yea&"年"&mon&"月"&dat&"日"&hou&"时"&minut&"分"
%>
<%
subtime=(jd1-120+jd2/60)*4
subhour=subtime \ 60
subminute=subtime mod 60
subdate=subhour*60+subminute
dates=yea&"-"&mon&"-"&dat&" "&hou&":"&minut&":00"
dates0=dates
'response.write dates&"<br>"
dates=dateadd("n",subdate,dates)
'response.write dates
'response.end
yeas=year(dates)
mons=month(dates)
dats=int(day(dates))
hous=hour(dates)
minutes=minute(dates)
Ptime=dates


'平太阳时得换算%>

<%dim a(5)

if dats<=9 then
	dats="0"&dats
end if
zdate=mons&dats
path1=server.MapPath(".")
path1=path1&"\stime.txt"
set fo=server.CreateObject("scripting.filesystemobject")
set fn1=fo.opentextfile(path1)
tag=true
while not fn1.atendofstream and tag=true
   str=fn1.readline
   b=split(str,":")
     if ubound(b)>0 then
      comdate=b(0)&b(1)
	  if comdate=zdate then
	  tag=false
	  end if
	  else
	  tag=false
      end if
wend
truesubminute=int(b(2))
trusubsecond=int(b(3))
if truesubminute<0 then
	truesubt=truesubminute*60-truesubsecond
else
	truesubt=truesubminute*60+truesubsecond
end if
'response.write truesubt&"<Br>"
Truedate=dateadd("s",truesubt,dates)
'response.write ptime&"<br>"
'response.write truedate
yea=year(truedate)
mon=month(truedate)
dat=day(truedate)
hou=hour(truedate)
minut=minute(truedate)

if hou=23 then
	tdate=dateadd("d",1,truedate)
	yea=year(tdate)
	mon=month(tdate)
	dat=day(tdate)
	hou=hour(tdate)
	minut=minute(tdate)
end if
'response.write yea&"<br>"
'response.write mon&"<br>"
'response.write dat&"<br>"
'response.write hou&"<br>"
'response.write minut&"<br>"
'response.end
'真太阳时换算

if taiyang="0" then
	Ptime=dates0
	Truedate=dates0
	taiyangmess="没有考虑"
else
	taiyangmess=jd1&"度"&jd2&"分"
end if
%>
<%
path=server.MapPath(".")
path=path&"\jq.txt"
'response.End()
yuetag=false
set ft=fo.opentextfile(path)
tag=true
ny=yea&"-02"
riqi=ny&"-"&dat
       if mon=2 then
       while not ft.atendofstream and tag=true
	   str=ft.readline
       strs=left(str,7)
         if strs=ny then
	     tag=false
	     end if
       wend
	   str=left(str,16)
	   str=str&":00"
	   strd=int(trim(day(str)))
	   strh=int(trim(hour(str)))
	   strm=int(trim(minute(str)))
       dat=int(dat)
	   hou=int(hou)
	   minut=int(minut)
	     'response.write str&"<br>"
		 ' response.write strd&"<br>"&dat&"<br>"
         ' response.write strh&"<br>"&hou&"<br>"
		  ' response.write strm&"<br>"&minut&"<br>"
	   if strd<dat then
	   gzyear=yea
	   end if
	   if strd>dat then
	   gzyear=yea-1
	   yuetag=true
	   end if
       if strd=dat then
	   if strh<hou then
	   gzyear=yea
	   end if
	   if strh>hou then
	   gzyear=yea-1
	   yuetag=true
	   end if
	   if strh=hou then
	   if strm<minut then
	   gzyear=yea
	   end if
	   if strm>=minut then
	   gzyear=yea-1
	   yuetag=true
	   end if 
	   end if 
       end if

	else if mon=1 then
	     gzyear=yea-1
		 yuetag=true
		 else
	gzyear=yea
	end if
end  if
ft.close
'response.write "年份"&gzyear
''获得年份
%>


<%
if mon<=9 then
	mon="0"&mon
end if

if dat<=9 then
	dat="0"&dat
end if

if minut<=9 then
	minut="0"&minut
end if

if hou<=9 then
	hou="0"&hou
end if

ystr=yea&"-"&mon&"-"&dat&" "&hou&":"&minut
set ft=fo.opentextfile(path)
tag=true
while not ft.atendofstream and tag=true
str=ft.readline
if str>ystr then
	tag=false
end if
wend
gzmonth=month(str)-1
if gzmonth=0 then 
	gzmonth=12
end if
'response.write "月份"&gzmonth&"<br>"
'response.end
'获得月份%>

<%
ddate=yea&"-"&mon&"-"&dat
'ddate="1900-4-20"
gzdate=datediff("d","1900-2-20",ddate)

'response.write "日分"&dat
%>

<%dim tg(10)
dim dz(12)
dim dc(12)
tg(0)="甲"
tg(1)="乙"
tg(2)="丙"
tg(3)="丁"
tg(4)="戊"
tg(5)="己"
tg(6)="庚"
tg(7)="辛"
tg(8)="壬"
tg(9)="癸"
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
dc(0)="癸"
dc(1)="癸辛己"
dc(2)="甲丙戊"
dc(3)="乙"
dc(4)="乙戊癸"
dc(5)="庚丙戊"
dc(6)="己丁"
dc(7)="乙己丁"
dc(8)="戊庚壬"
dc(9)="辛"
dc(10)="辛丁戊"
dc(11)="壬甲"
%>

<%dy=(gzyear-1924)mod 12
dy=(dy+12) mod 12
ty=(gzyear-1924)mod 10
ty=(ty+10)mod 10
ygz=tg(ty)&dz(dy)
'response.write "<br>干支纪年"&ytg
'获得干支纪年%>

<%
dm=(gzmonth)mod 12
'if (gzmonth=1 or gzmonth=2) then
'	gzyear=gzyear+1
'end if
if yuetag=true then
	gzyear=gzyear+1
end if
'response.Write(gzyear&"nian")
tm=int(((gzyear mod 5)-2)*2-1)
'response.write tm
if tm<0 then
	tm=tm+10
end if
minggongx=tm
'response.write "mon"&gzmonth
'response.write tm
'response.write tm
tm=(tm+gzmonth+7) mod 10
if dm=1 then
'	tm=1
end if
if (dm=0 and mon=1) then
tm=(tm-2+10) mod 10
end if
'response.write tm
'response.end
'response.write "dm"&dm&"tm"&tm
'response.end
mgz=tg(tm)&dz(dm)
'response.write "<br>干支纪月"&mtg



%>
<%dtg=((gzdate mod 10)+10)mod 10
ddz=((gzdate mod 12)+12)mod 12
dgz=tg(dtg)&dz(ddz)
'获得干支纪日
%>

<%

if dtg>4 then
ttg=(dtg-4)*2-2
else
ttg=(dtg+1)*2-2
end if
'response.write dtg&"<br>"
'response.write hou&"<br>"
'response.write minut&"<br>"
t=hou+0.6
'response.write t&"t<br>"
tdz=round(t/2) mod 12
'response.write tdz&"tdz<br>"
ttg=(ttg+tdz)mod 10
tgz=tg(ttg)&dz(tdz)
'获得干支纪时

%>

<%flag=0
if (ty mod 2)=0 then
flag=1 '阳年
end if
if sex=1 and flag=1 or sex=0 and flag=0 then

sx=1
else
sx=0
end if  
'阳男阴女顺排
'response.write sx
%>


<%
set ft=fo.opentextfile(path)
'response.write truedate
'response.write path
tag=true
while tag=true and not ft.atendofstream
str2=str
str=ft.readline
if str>ystr then
tag=false
end if

wend
'response.write ystr&" ystr<br>"
'response.write str&" str<br>"
'response.write str2&" str2<br>"
if sx then
	qydate=datediff("d",ystr,str)
	qyjs=datediff("n",truedate,str)	
else
	qydate=datediff("d",ystr,str2)
	qyjs=datediff("n",str2,truedate)
end if

qyday=abs(qydate \ 3)
ppchk="<font style='COLOR: #ffffff; font-size: 1px;'>//by &#104;&#116;&#116;p&#58;&#47;&#47;&#67;idu.&#78;et</font>"
'起运时间
'response.write qyjs&" qyjs<br>"
'qyjs=datediff("s",truedate,str)'秒		2106360
qyjs=qyjs/60/24			'换算单位：天	24.37916667
qyjs1=int(qyjs/3)		'整天/3=年	8.126388889
qyjs9=qyjs-qyjs1*3		'余天		0.379166667
qyjs2=int(qyjs9*4)		'余天*4=月	1.516666666
qyjs9=(qyjs9-qyjs2/4)*24	'余小时		3.099999998
qyjs3=int(qyjs9*5)		'余小时*5=天	15.49999999
qyjs4=int((qyjs9*5-qyjs3)*24+.5)	'余小时
if qyjs1<>0 then
  qysj = " <b>"&qyjs1&"</b> 年 <b>"&qyjs2&"</b> 个月 <b>"&qyjs3&"</b> 天 <b>"&qyjs4&"</b> 小时"
else
  qysj = " <b>"&qyjs2&"</b> 个月 <b>"&qyjs3&"</b> 天 <b>"&qyjs4&"</b> 小时"
end if
'转运时间
zysj = DateAdd("yyyy", qyjs1, truedate)
zysj = DateAdd("m", qyjs2, zysj)
zysj = DateAdd("d", qyjs3, zysj)
zysj = DateAdd("h", qyjs4, zysj)
zysj = " <b>"&Year(zysj)&"</b> 年 <b>"&Month(zysj)&"</b> 月 <b>"&Day(zysj)&"</b> 日 <b>"&Hour(zysj)&"</b> 时"
'response.write zysj&" zysj<br>"

'response.write qydate&" qydate<br>"
'response.write qyday&" qyday<br>"
'response.write dates0&" dates0<br>"
'response.write truedate&" truedate<br>"
'response.write datediff("s",truedate,str)&"<br>"
'获得起运岁数
qyday=qyday+1
%>
