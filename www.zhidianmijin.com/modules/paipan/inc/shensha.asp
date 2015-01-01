<%function niangan(tgx,dza)
set fo=server.createobject("scripting.filesystemobject")
path=server.mappath("shensha")
path=path&"/niangan.txt"
shens=""
set fn=fo.opentextfile(path)
while not fn.atendofstream
  strss=fn.readline
  shensha=left(strss,5)
  ganzhi=right(strss,len(strss)-5)
  arr=split(ganzhi,",")
  for i=1 to ubound(arr)+1
     arr2=split(arr(i-1),":")
	' response.write arr(i-1)&"<br>"
	'response.write arr2(0)
	  if ubound(arr2)>0 then
	  if instr(arr2(0),tgx)>0 then
         if instr(arr2(1),dza)>0 then
	     'response.write shensha
		 shens=shens&"-"&shensha
		 exit for
		 else 
	     end if
	  end if
	  end if
  next
wend
niangan=shens
set fo=nothing
end function
'call niangan("甲","申","卯","申","亥")
'response.End()
'以年干为核心获得神煞的函数，输入参数为2个，分别是年干 ,支%>

<%Function nianzhi(nz,dza,nzx,shunxu)
set fo=server.createobject("scripting.filesystemobject")
path=server.mappath("shensha")
path=path&"/nianzhi.txt"
set fn=fo.opentextfile(path)
tags=0
shens=""
shun=shunxu
while not fn.atendofstream
tags=tags+1
   if tags=3 and shun=0 then 
   fn.skipline
   else
   if tags=4 and shun=1 then
   fn.skipline
   end if
   end if
  strss=fn.readline
  shensha=left(strss,5)
  ganzhi=right(strss,len(strss)-5)
  arr=split(ganzhi,",")
  for i=1 to ubound(arr)+1
     arr2=split(arr(i-1),":")
	' response.write arr(i-1)&"<br>"
	'response.write arr2(0)
	  if ubound(arr2)>0 then
	  if instr(arr2(0),nz)>0 then
         if instr(arr2(1),dza)>0 then
	     shens=shens&"-"&shensha
		 exit for
	     end if
	  end if
	  end if
  next
wend
Pmz=(nzx+10) mod 12
Dkz=(nzx+2) mod 12
Smz=(nzx+3) mod 12
if dz(Pmz)=dza then
shens=shens&"-披麻"
end if
if dz(dkz)=dza then
shens=shens& "-吊客"
end if
if dz(smz)=dza then
shens=shens&"-丧门"
end if
set fo=nothing
fn.close

nianzhi= shens
end function
'call nianzhi("子","1","1","巳",0)
'以年支为核心，查询神煞，输入参数为年，月，日，时支和阳男阴女标志位%>

<%

function yuezhi(yzx,tgx,dzy)
set fo=server.createobject("scripting.filesystemobject")
path=server.mappath("shensha")
path=path&"/yuezhi.txt"
shens=""
set fn=fo.opentextfile(path)
while not fn.atendofstream
  strss=fn.readline
  'response.write strss&"<br>"
  shensha=left(strss,5)
  ganzhi=right(strss,len(strss)-5)
  arr=split(ganzhi,",")
  for i=1 to ubound(arr)+1
     arr2=split(arr(i-1),":")
	' response.write arr(i-1)&"<br>"
	'response.write arr2(0)
	  if ubound(arr2)>0 then
	  if instr(arr2(0),yzx)>0 then
         if(instr(arr2(1),tgx)>0) or (instr(arr2(1),dzy)>0) then
	    shens=shens&"-"&shensha
		 exit for
	     end if
	  end if
	  end if
  next
wend
yuezhi= shens
set fo=nothing
fn.close
end function
'call yuezhi("寅","卯","丑")
'以月支为基准计算神煞
%>

<%function rigan(tgx,dza)
set fo=server.createobject("scripting.filesystemobject")
path=server.mappath("shensha")
path=path&"/rigan.txt"
shens=""
set fn=fo.opentextfile(path)
while not fn.atendofstream
  strss=fn.readline
  shensha=left(strss,5)
  ganzhi=right(strss,len(strss)-5)
  arr=split(ganzhi,",")
  for i=1 to ubound(arr)+1
     arr2=split(arr(i-1),":")
	' response.write arr(i-1)&"<br>"
	'response.write arr2(0)
	  if ubound(arr2)>0 then
	  if instr(arr2(0),tgx)>0 then
         if instr(arr2(1),dza)>0 then
	    shens=shens&"-"&shensha
		 exit for
	     end if
	  end if
	  end if
  next
wend
rigan= shens
set fo=nothing
end function
'call rigan("甲","子")
'以日干为基准计算神煞
%>

<%
function rizhi(tgx,dza,nzx)
set fo=server.createobject("scripting.filesystemobject")
path=server.mappath("shensha")
path=path&"/rizhi.txt"
shens=""
set fn=fo.opentextfile(path)
while not fn.atendofstream
  strss=fn.readline
  shensha=left(strss,5)
  ganzhi=right(strss,len(strss)-5)
  arr=split(ganzhi,",")
  for i=1 to ubound(arr)+1
     arr2=split(arr(i-1),":")
	' response.write arr(i-1)&"<br>"
	'response.write arr2(0)
	  if ubound(arr2)>0 then
	  if instr(arr2(0),tgx)>0 then
         if instr(arr2(1),dza)>0 then
	     shens=shens&"-"&shensha
		 exit for
	     end if
	  end if
	  end if
  next
wend
Pmz=(nzx+10) mod 12
Dkz=(nzx+2) mod 12
Smz=(nzx+3) mod 12
if dz(Pmz)=dza then
shens=shens&"-披麻"
end if
if dz(dkz)=dza then
shens=shens&"-吊客"
end if
if dz(smz)=dza then
shens=shens&"-丧门"
end if
rizhi= shens
set fo=nothing
end function
'call rizhi("丑","丑",1)
'以日支为基准计算神煞
'a="d,ddd,d"
'b=split(a,",")
'response.write ubound(b)
%>
<%function rizhu(zhu,rizh,yuetag)
set fo=server.createobject("scripting.filesystemobject")
path=server.mappath("shensha")
path=path&"/rizhu.txt"
set fn=fo.opentextfile(path)
yzhi=right(zhu,1)
itag=0    '计数器
while not fn.atendofstream
itag=itag+1
  strss=fn.readline
  shensha=left(strss,5)
  ganzhi=right(strss,len(strss)-5)
  arr=split(ganzhi,",")
  if itag<=5 then
  for i=1 to ubound(arr)+1
     arr2=split(arr(i-1),":")
	' response.write arr(i-1)&"<br>"
	'response.write arr2(0)
	  if ubound(arr2)>0 then
	  if instr(arr2(0),zhu)>0 then
         if(instr(arr2(1),rizh)>0 or trim(arr2(1))="") then
	     shens=shens&"-"&shensha
		 exit for
	     end if
	  end if
	  end if
  next
  else if yuetag=1 then
        yzhi=right(trim(zhu),1)
        for i=1 to ubound(arr)+1
     arr2=split(arr(i-1),":")
	' response.write arr(i-1)&"<br>"
	'response.write arr2(0)
	  if ubound(arr2)>0 then
	  if instr(arr2(0),yzhi)>0 then
         if(instr(arr2(1),rizh)>0) then
	     shens=shens&"-"&shensha
		 exit for
	     end if
	  end if
	  end if
  next
        
        end if    

  end if
wend
rizhu=shens
set fo=nothing
end function '以日主为主
'call rizhu("戊寅","庚申",1)
%>
<%
function rizhus(x,y)
set fo=server.createobject("scripting.filesystemobject")
path=server.mappath("shensha")
path=path&"/rizhus.txt"
set fn=fo.opentextfile(path)
while not fn.atendofstream
  strss=fn.readline
  shensha=left(strss,5)
  ganzhi=right(strss,len(strss)-5)
  arr=split(ganzhi,",")
  for i=1 to ubound(arr)+1
     arr2=split(arr(i-1),":")
	' response.write arr(i-1)&"<br>"
	'response.write arr2(0)
	  if ubound(arr2)>0 then
	  if instr(arr2(0),x)>0 or trim(arr2(0))="" then
         if instr(arr2(1),y)>0 then
	     shens=shens&"-"&shensha
		 exit for
	     end if
	  end if
	  end if
  next
wend
rizhus= shens
set fo=nothing
end function
'call rizhus("癸亥","癸丑")
'以日主和时柱排神煞
%>

<%
function sqgr(x,y,z,w)
gss="乙巳,丁巳,辛亥,戊申,壬寅,戊午,壬子,丙午"
sq1="卯巳午"
sq2="乙丙丁"
two=0
three=0
three1=0
if instr(gss,x)>0 then
two=two+1
gss=replace(gss,x,"")
end if
if instr(gss,y)>0 then
two=two+1
gss=replace(gss,y,"")
end if
if instr(gss,z)>0 then
two=two+1
gss=replace(gss,z,"")
end if
if instr(gss,w)>0 then
two=two+1
gss=replace(gss,w,"")
end if
if two>1 then 
response.write "孤鸾煞"
end if
if instr(sq1,right(x,1)) then
three=three+1
sq1=replace(sq1,right(x,1),"")
end if 
if instr(sq1,right(y,1)) then
three=three+1
sq1=replace(sq1,right(y,1),"")
end if
if instr(sq1,right(z,1)) then
three=three+1
sq1=replace(sq1,right(z,1),"")
end if
if instr(sq1,right(w,1)) then
three=three+1
sq1=replace(sq1,right(w,1),"")
end if

if instr(sq2,left(x,1))>0 then
three1=three1+1
sq2=replace(sq2,left(x,1),"")

end if 
if instr(sq2,left(y,1))>0 then
three1=three1+1
sq2=replace(sq2,left(y,1),"")
end if 
if instr(sq2,left(z,1))>0 then
three1=three1+1
sq2=replace(sq2,left(z,1),"")
end if 
if instr(sq2,left(w,1))>0 then
three1=three1+1
sq2=replace(sq2,left(w,1),"")
end if 
if three>2 or three1>2 then
response.write "三奇贵人"
end if
end function
'call sqgr("丁巳","丁巳","dd","丁巳")
'以日主和时柱排神煞
'w=1
'q=1

'response.write w and q 
%>