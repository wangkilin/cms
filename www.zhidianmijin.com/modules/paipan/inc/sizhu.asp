<!--#include file=pfunc.asp-->
<!--#include file=shensha.asp-->
<%function sizhu(yea,mon,dat,hou,minut,ygz,mgz,dgz,tgz)
liutag=0
jd1=120
jd2=0
'nam=request.Form("name")
'area=request.Form("area")
'jd1=request.Form("jd1")
'jd2=request.Form("jd2")
'yea=request.Form("year")
'mon=request.Form("month")
'dat=trim(request.Form("date"))
'hou=request.Form("hour")
'minut=request.Form("minute")
'sex=request.Form("sex")
'borntime=yea&"年"&mon&"月"&dat&"日"&hou&"时"&minut&"分"
%>
<%
subtime=(jd1-120+jd2/60)*4
subhour=subtime \ 60
subminute=subtime mod 60
subdate=subhour*60+subminute
dates=yea&"-"&mon&"-"&dat&" "&hou&":"&minut&":00"
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


'//平太阳时得换算%>

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
'response.write yea&"<br>"
'response.write mon&"<br>"
'response.write dat&"<br>"
'response.write hou&"<br>"
'response.write minut&"<br>"
'response.end
'//真太阳时换算
%>
<%
path=server.MapPath(".")
path=path&"\jq.txt"
'response.End()

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
	   end if
       if strd=dat then
	   if strh<hou then
	   gzyear=yea
	   end if
	   if strh>hou then
	   gzyear=yea-1
	   end if
	   if strh=hou then
	   if strm<minut then
	   gzyear=yea
	   end if
	   if strm>=minut then
	   gzyear=yea-1
	   end if 
	   end if 
       end if
	   'else{
	  '     if strh<hou then
	  '     gzyear=yea
		'   else if strh>hou then
		'   gzyear=yea-1
		'   else{
		 '      if strm<minut then
		 '      gzyear=yea
		 '      else if strm>minut then
			'   gzyear=yea-1
		'	   else gzyear=yea
			'   end if
		'	   end if
		'   }
		'   end if
		 '  end if
	 '  }     
	  ' end if
	  ' end if
       
	else if mon=1 then
	     gzyear=yea-1
		 else
	gzyear=yea
	end if
	end if
ft.close
'response.write "年份"&gzyear
'//获得年份
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
'response.Write("dd"&gzmonth&"dd")
'response.write "月份"&gzmonth&"<br>"
'//获得月份%>

<%
ddate=yea&"-"&mon&"-"&dat
'ddate="1900-4-20"
gzdate=datediff("d","1900-2-20",ddate)
if hou=23 then
gzdate=gzdate+1
end if
'response.write "日分"&gzdate
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
'//获得干支纪年%>

<%
dm=(gzmonth)mod 12
tm=int(((gzyear mod 5)-2)*2-1)
'response.write tm
if tm<0 then
tm=tm+10
end if
minggongx=tm
'response.write tm
tm=(tm+gzmonth-3+10) mod 10
if dm=1 then
tm=(tm+2+10) mod 10
end if

'response.Write(tm&gzmonth)
'response.End()
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
t=hou+minut/60
'response.write t&"t<br>"
tdz=round(t/2) mod 12
'response.write tdz&"tdz<br>"
ttg=(ttg+tdz)mod 10
tgz=tg(ttg)&dz(tdz)
'response.Write(ygz&mgz&dgz&tgz)
end function
'获得干支纪时

%>
<%function xunkong(gz1,xunk,xunshou)
set fo=server.CreateObject("scripting.filesystemobject")
path=server.MapPath("temp")
path=path&"/xunkong.txt"
set fns=fo.opentextfile(path)
while not fns.atendofstream
str=fns.readline
if instr(str,gz1)>0 then
strarr=split(str,",")
xunk=strarr(10)
xunshou=strarr(0)
end if
wend
fns.close
set fo=nothing
end function

%>

<%function MakeJQ(InTime,PreJq,NJq)
times=IntIME
Nian=year(times)
set fo=server.CreateObject("scripting.filesystemobject")
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
'response.Write(i&"<br>")
i=(i+21)mod 24
 jieqq=nian&"年"&month(jiaoj)&"月"&day(jiaoj)&"日"&hour(jiaoj)&"时"&minute(jiaoj)&"分"&jq(i mod 24)
Njq=jieqq

end function%>

<%
function CbtoI(biangindex)
CbtoI=left(biangindex,1)*32+mid(biangindex,1,1)*16+mid(biangindex,2,1)*8+mid(biangindex,3,1)*4+mid(biangindex,4,1)*2++mid(biangindex,5,1)
END FUNCTION
%>

<%function Cfan(strs,str2)
str=strs
leng=len(str)
str2=""
for i=1 to leng
bit=left(str,1)
str=right(str,leng-i)
bit=bit xor "1"
str2=str2&bit
next
end function%>
