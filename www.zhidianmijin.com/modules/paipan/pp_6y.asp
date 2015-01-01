<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<TITLE>纳甲六爻在线排卦（在线起卦）系统-算命网网</TITLE>
<!--#include file="top.asp"--><!--#include file="../inc/conn.asp"--><!--#include file="../inc/getuc.asp"--><!--#include file="luner.js" -->
<div id="right">
<!--#include file="right.asp"-->
</div>
<div id="left">
<div style="width:100%">
<%if request("act")="ok" then%><%
  Dim fangfa(5)
  fangfa(1)="电脑自动"
  fangfa(2)="手工指定"
  fangfa(3)="时间起卦"
  fangfa(4)="手动摇卦"
  fangfa(5)="报数起卦"

name=request.Form("name")
jg=request("jg")
reason=request("reason")
birthyear=request("birthyear")
sex=request("sex")
if sex="1" then sex="男" else sex="女"

  sely=request("sely")
  selmo=request("selmo")
  seld=request("seld")
  selh=request("selh")
  selm=request("selm")

  nongligan=request("nongligan")*1
  nongzhi=request("nongzhi")*1
  nongmonth=request("nongmonth")*1
  nongday=request("nongday")*1
  isLeap=request("isLeap")*1

  if selh=23 or selh=0 then
	guashi=1
  else
	guashi=int((selh+2)/2+0.5)
  end if
%>
<!--#include file="inc/xunkong.asp" -->
<!--#include file="ganzhidate.inc" -->
<!--#include file="guadata.inc" -->
<!--#include file="guadata2.inc" -->
<!--#include file="guadata3.inc" -->
<!--#include file="guadata4.inc" -->
<!--#include file="guadata5.inc" -->
<!--#include file="liuqing.inc" -->
<!--#include file="jieqi.inc" -->
<%
  Dim yao(6)
  yao(6)=request("Y6")
  yao(5)=request("Y5")
  yao(4)=request("Y4")
  yao(3)=request("Y3")
  yao(2)=request("Y2")
  yao(1)=request("Y1")

  auto=request("auto")*1
  if auto=3 then
	shangguashu=nongzhi+nongmonth+nongday
	shangguashu=int(((shangguashu/8)-int( shangguashu/8))*8+0.5)
	if shangguashu = 0 then
		shangguashu=8
	end if
	xiaguashu=nongzhi+nongmonth+nongday+guashi
	xiaguashu=int(((xiaguashu/8)-int(xiaguashu/8))*8+0.5)
	if xiaguashu = 0 then
		xiaguashu=8
	end if
	bianguashu=nongzhi+nongmonth+nongday+guashi
	bianguashu=int(((bianguashu/6)-int(bianguashu/6))*6+0.5)
	if bianguashu = 0 then
		bianguashu=6
	end if
            for i=1 to 8 
		if shangguashu=benbagua(i,4) then
			for j=1 to 3
				yao(j+3)=benbagua(i,j)
			next 
		end if
		if xiaguashu=benbagua(i,4) then
			for j=1 to 3
				yao(j)=benbagua(i,j)
			next 
		end if
         	next

	if yao(bianguashu)=1 then
		yao(bianguashu)=3
	else
		yao(bianguashu)=4
	end if
 end if 

 if auto=5 then
bianguashu=request("bsnums_up")*1+request("bsnums_down")*1
'response.write(request("addhour"))
	shangguashu=request("bsnums_up")*1
	shangguashu=int(((shangguashu/8)-int( shangguashu/8))*8+0.5)
	if shangguashu = 0 then
		shangguashu=8
	end if
	xiaguashu=request("bsnums_down")*1
	xiaguashu=int(((xiaguashu/8)-int(xiaguashu/8))*8+0.5)
	if xiaguashu = 0 then
		xiaguashu=8
	end if

	if request("addhour")="1" then
		bianguashu=bianguashu+guashi
	end if

	bianguashu=int(((bianguashu/6)-int(bianguashu/6))*6+0.5)
	if bianguashu = 0 then
		bianguashu=6
	end if
            for i=1 to 8 
		if shangguashu=benbagua(i,4) then
			for j=1 to 3
				yao(j+3)=benbagua(i,j)
			next 
		end if
		if xiaguashu=benbagua(i,4) then
			for j=1 to 3
				yao(j)=benbagua(i,j)
			next 
		end if
         	next

	if yao(bianguashu)=1 then
		yao(bianguashu)=3
	else
		yao(bianguashu)=4
	end if
 end if 

if auto=1 then
	Randomize()
	temprndyao=Rnd(1)*100
	yao(1)=int(((temprndyao/4)-int(temprndyao/4))*4+0.5)
	if yao(1)=0 then
		 yao(1)=4
	end if
	temprndyao=rnd(2)*100
	yao(2)=int(((temprndyao/4)-int(temprndyao/4))*4+0.5)
	if yao(2)=0 then
		 yao(2)=4
	end if
	temprndyao=rnd(3)*100
	yao(3)=int(((temprndyao/4)-int(temprndyao/4))*4+0.5)
	if yao(3)=0 then
		 yao(3)=4
	end if
	temprndyao=rnd(4)*100
	yao(4)=int(((temprndyao/4)-int(temprndyao/4))*4+0.5)
	if yao(4)=0 then
		 yao(4)=4
	end if
	temprndyao=rnd(5)*100
	yao(5)=int(((temprndyao/4)-int(temprndyao/4))*4+0.5)
	if yao(5)=0 then
		 yao(5)=4
	end if
	temprndyao=rnd(6)*100
	yao(6)=int(((temprndyao/4)-int(temprndyao/4))*4+0.5)
	if yao(6)=0 then
		 yao(6)=4
	end if
end if
  
 benggua=""
 biangua=""
 isbiangua=0
 
for i=6 to 1 step -1
	if (yao(i)="1") or (yao(i)="3") then
		benggua=benggua&"1"
            end if
            if (yao(i)="2") or (yao(i)="4") then
		benggua=benggua&"0"
            end if
	if yao(i)="3" then
		biangua=biangua&"0"
                        isbiangua=1
            end if
            if yao(i)="4"  then
		biangua=biangua&"1"
		isbiangua=1
            end if
            if yao(i)="2" then
		biangua=biangua&"0"
            end if
            if yao(i)="1"  then
		biangua=biangua&"1"
            end if
Next

%>  



<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" id="paipanTable">
    <tbody>
      <tr>
        <td class="ttop"><strong>纳甲六爻在线排卦（在线起卦）系统</strong></td>
      </tr>
      <tr>
        <td class="new"><strong>姓名：</strong><%=request("name")%> <strong>出生年:</strong><%=request("birthyear")%><strong> 性别：</strong><%= Sex %><strong>&nbsp;占事：</strong><%= reason %></td>
        </tr>
      <tr>
        <td class="new"><strong>起卦方式：</strong><%= fangfa(auto) %></b>
<% if request("auto")="5" then %>
(<%=request("bsnums_up")%>,<%=request("bsnums_down")%>)
<% if request("addhour")=1 then %>
动爻加时辰
<% else %>
动爻不加时辰
<%end if %>
<%end if%></td>
      </tr>
      <tr>
        <td class="new"><b>公历时间：</B><font color="#ff0000"><%=sely %>年<%=selmo %>月<%=seld %>日<%=selh %>时<%=selm %>分</font>
      <% niangan=0%>
      <% 
'tempdate3=CDate("2004/4/15 3:21")
'date3=CDate(sely&"/"&selmo&"/"&seld&" "&selh&":"&selm)
tempdate3=CDate(sely&"/"&selmo&"/"&seld&" "&selh&":"&selm)
'2/4/2004 19:46

datenumberniangan=DateDiff("d","1900/12/26",tempdate3)
datenumberdizhi=DateDiff("d","1900/12/28",tempdate3)

temp=int(((datenumberniangan/10)-int( datenumberniangan/10))*10+0.5)
rigan=temp
if rigan= 0 then
	rigan=10
end if
rizhi=int(((datenumberdizhi/12)-int( datenumberdizhi/12))*12+0.5)
if rizhi= 0 then
	rizhi=12
end if
'response.write(rigan)
'response.write("<br>")
'response.write(rizhi)
'response.write("<br>")

for i=1 to 1331
date1=CDate(jieqi(i)) 
date2=CDate(jieqi(i+1))
date3=tempdate3
	if (date3>=date1) and(date3<date2) then
		monthnumberyuegan=DateDiff("m","1900/7/7",date1)
		monthnumberyuezhi=DateDiff("m","1900/11/8",date1)
		monthnumberdiff=DateDiff("m","1900/2/4",date1)
		i=5000
	end if
      	
next
yuezhi=int(((monthnumberyuezhi/12)-int(monthnumberyuezhi/12))*12+0.5)
if yuezhi= 0 then
	yuezhi=12
end if
yuegan=int(((monthnumberyuegan/10)-int(monthnumberyuegan/10))*10+0.5)
if yuegan= 0 then
	yuegan=10
end if

tempnianzhi=int(monthnumberdiff/12)
'response.write(monthnumberdiff)
'response.write("<br>")
'response.write(tempnianzhi)
'response.write("<br>")
nianzhi=int(((tempnianzhi/12)-int(tempnianzhi/12))*12+0.5)+1
if nianzhi= 12 then
	nianzhi=12
end if
tempniangan=int(monthnumberdiff/12)
niangan=int(((tempniangan/10)-int(tempniangan/10))*10+0.5)+7
if niangan> 10 then
	niangan=niangan-10
end if
      	
 %>
      <% 
 	if ((selh*1)>=0) and ((selh*1)<1) then 
		shizhi=1
	end if
	if ((selh*1)>=1) and ((selh*1)<3) then 
		shizhi=2
	end if
	if ((selh*1)>=3) and ((selh*1)<5) then 
		shizhi=3
	end if
	if ((selh*1)>=5) and ((selh*1)<7) then 
		shizhi=4
	end if
	if ((selh*1)>=7) and ((selh*1)<9) then 
		shizhi=5
	end if
	if ((selh*1)>=9) and ((selh*1)<11) then 
		shizhi=6
	end if
	if ((selh*1)>=11) and ((selh*1)<13) then 
		shizhi=7
	end if
	if ((selh*1)>=13) and ((selh*1)<15) then 
		shizhi=8
	end if
	if ((selh*1)>=15) and ((selh*1)<17) then 
		shizhi=9
	end if
	if ((selh*1)>=17) and ((selh*1)<19) then 
		shizhi=10
	end if
	if ((selh*1)>=19) and ((selh*1)<21) then 
		shizhi=11
	end if
	if ((selh*1)>=21) and ((selh*1)<23) then 
		shizhi=12
	end if
	if ((selh*1)=23) then 
		shizhi=1
		if rigan=10 then 
			rigan=1
		else
			rigan=rigan+1
		end if
		if rizhi=12 then
			rizhi=1
		else
			rizhi=rizhi+1
		end if
	end if
%>
      <%	 
	Dim tempshigan(12)
	if rigan=1 or rigan=6 then
		tempshigan(1)=1
		tempshigan(2)=2
		tempshigan(3)=3
		tempshigan(4)=4
		tempshigan(5)=5
		tempshigan(6)=6
		tempshigan(7)=7
		tempshigan(8)=8
		tempshigan(9)=9
		tempshigan(10)=10
		tempshigan(11)=1
		tempshigan(12)=2
	end if
	if rigan=2 or rigan=7 then
		tempshigan(1)=3
		tempshigan(2)=4
		tempshigan(3)=5
		tempshigan(4)=6
		tempshigan(5)=7
		tempshigan(6)=8
		tempshigan(7)=9
		tempshigan(8)=10
		tempshigan(9)=1
		tempshigan(10)=2
		tempshigan(11)=3
		tempshigan(12)=4
	end if
	if rigan=3 or rigan=8 then
		tempshigan(1)=5
		tempshigan(2)=6
		tempshigan(3)=7
		tempshigan(4)=8
		tempshigan(5)=9
		tempshigan(6)=10
		tempshigan(7)=1
		tempshigan(8)=2
		tempshigan(9)=3
		tempshigan(10)=4
		tempshigan(11)=5
		tempshigan(12)=6
	end if
	if rigan=4 or rigan=9 then
		tempshigan(1)=7
		tempshigan(2)=8
		tempshigan(3)=9
		tempshigan(4)=10
		tempshigan(5)=1
		tempshigan(6)=2
		tempshigan(7)=3
		tempshigan(8)=4
		tempshigan(9)=5
		tempshigan(10)=6
		tempshigan(11)=7
		tempshigan(12)=8
	end if

	if rigan=5 or rigan=10 then
		tempshigan(1)=9
		tempshigan(2)=10
		tempshigan(3)=1
		tempshigan(4)=2
		tempshigan(5)=3
		tempshigan(6)=4
		tempshigan(7)=5
		tempshigan(8)=6
		tempshigan(9)=7
		tempshigan(10)=8
		tempshigan(11)=9
		tempshigan(12)=10
	end if
%>
      <% 
	if (rizhi-rigan)=0 then 
		kongzhi=12
	else
		if rizhi>rigan then
			kongzhi=rizhi-rigan
		else
			kongzhi=rizhi+12-rigan
		end if
	end if
%>
      <% 
	if rizhi= 3 or rizhi=7 or rizhi=11 then
		maxing=9
		taohua=4
	end if
	if rizhi= 1 or rizhi=5 or rizhi=9 then
		maxing=3
		taohua=10
	end if
	if rizhi= 4 or rizhi=8 or rizhi=12 then
		maxing=6
		taohua=1
	end if
	if rizhi= 2 or rizhi=6 or rizhi=10 then
		maxing=12
		taohua=7
	end if
	
	if rigan=1 then
		lu=3
	end if
	if rigan=2 then
		lu=4
	end if
	if rigan=3 or rigan=5 then
		lu=6
	end if
	if rigan=4 or rigan=6 then
		lu=7
	end if
	if rigan=7 then
		lu=9
	end if
	if rigan=8 then
		lu=10
	end if
	if rigan=9 then
		lu=12
	end if
	if rigan=10 then
		lu=1
	end if
	if rigan=1 or rigan=5 or rigan=7 then
		guiren1=2
		guiren2=8
	end if
	if rigan=2 or rigan=6 then
		guiren1=1
		guiren2=9
	end if
	if rigan=3 or rigan=4 then
		guiren1=10
		guiren2=12
	end if
	if rigan=9 or rigan=10 then
		guiren1=6
		guiren2=4
	end if
	if rigan=8 then
		guiren1=3
		guiren2=7
	end if
%>
      &nbsp;&nbsp;&nbsp;<b>农历时间：</B><font color="#0000ff"><%= tiangan(nongligan)&dizhi(nongzhi) %>年
      <% if isLeap=1 then %>
      闰
      <% end if %>
      <%=nongliyu(nongmonth)%>月<%=nongliri(nongday) %>日<%=dizhi(shizhi)%>时</font>
      <BR>
      <b>干　　支：</B><%= tiangan(niangan)&dizhi(nianzhi)%>年 <%= tiangan(yuegan)&dizhi(yuezhi)%>月 <%= tiangan(rigan)&dizhi(rizhi)%>日 <%=tiangan(tempshigan(shizhi))&dizhi(shizhi)%>时　<br>
      <%call xunkong(tiangan(niangan)&dizhi(nianzhi),yxk,yxs)
call xunkong(tiangan(yuegan)&dizhi(yuezhi),mxk,mxs)
call xunkong(tiangan(rigan)&dizhi(rizhi),dxk,dxs)
call xunkong(tiangan(tempshigan(shizhi))&dizhi(shizhi),txk,txs)

%>
      <B>旬　　空：</B><%= yxk%>&nbsp;&nbsp; <%= mxk%>&nbsp;&nbsp; <%= dxk%>&nbsp;&nbsp; <%=txk%>&nbsp;&nbsp;　<br>
     <B>神　　煞：</B>驿马─<%=dizhi(maxing) %>　桃花─<%=dizhi(taohua) %>　日禄─<%=dizhi(lu) %>　贵人─<%=dizhi(guiren1) %>，<%=dizhi(guiren2) %><BR>
      <% if rigan=1 or rigan=2 then
	liushen(1)=liushentemp(1)
	liushen(2)=liushentemp(2)
	liushen(3)=liushentemp(3)
	liushen(4)=liushentemp(4)
	liushen(5)=liushentemp(5)
	liushen(6)=liushentemp(6)
   end if
   if rigan=3 or rigan=4 then
   	liushen(1)=liushentemp(6)
   	liushen(2)=liushentemp(1)
   	liushen(3)=liushentemp(2)
   	liushen(4)=liushentemp(3)
   	liushen(5)=liushentemp(4)
   	liushen(6)=liushentemp(5)
   end if
   if rigan=5 then
      	liushen(1)=liushentemp(5)
      	liushen(2)=liushentemp(6)
      	liushen(3)=liushentemp(1)
      	liushen(4)=liushentemp(2)
      	liushen(5)=liushentemp(3)
      	liushen(6)=liushentemp(4)
   end if
   if rigan=6 then
        liushen(1)=liushentemp(4)
        liushen(2)=liushentemp(5)
        liushen(3)=liushentemp(6)
        liushen(4)=liushentemp(1)
        liushen(5)=liushentemp(2)
        liushen(6)=liushentemp(3)
   end if
   if rigan=7 or rigan=8 then
      	liushen(1)=liushentemp(3)
      	liushen(2)=liushentemp(4)
      	liushen(3)=liushentemp(5)
      	liushen(4)=liushentemp(6)
      	liushen(5)=liushentemp(1)
      	liushen(6)=liushentemp(2)
   end if
   if rigan=9 or rigan=10 then
      liushen(1)=liushentemp(2)
      liushen(2)=liushentemp(3)
      liushen(3)=liushentemp(4)
      liushen(4)=liushentemp(5)
      liushen(5)=liushentemp(6)
      liushen(6)=liushentemp(1)
   end if
%>
   
      <% 
'response.write(benggua)
for i=1 to 64
	if bagua(i,12)=benggua then
		j=i
	end if
  	if bagua(i,12)=biangua then
		k=i
	end if
next 
 fu1=bagua(j,8)*1
 fu2=bagua(j,10)*1
%>
<br>&nbsp;
      <% if  isbiangua=0 then %>
      <% if bagua(j,8)="0" then %>
<br>　　　
    <%= "&nbsp;&nbsp; "&bagua(j,1) %>
    <br>　
    <%= "<B>六神 【本　　卦】" %></B>
      <br>　
      <% for l=1 to 6  %>
      <%= liushen(l)&"　"&bagua(j,l+1) %>
      <br>　
      <% next %>
      <br>
      <% else %>
<br>
      <% fu1=bagua(j,8)*1 
		       fu2=bagua(j,10)*1 %>
      <%= "　　　　　　　　　"&bagua(j,1) %><br>
      <B><%= "六神 　伏　　神　【本　　卦】" %></B><br>
      <% for l=1 to 6 %>
      <% if fu1<>(7-l) and fu2<>(7-l) then %>
      <%= liushen(l)&"　　　　　　　"&bagua(j,l+1) %><br>
      <% end if %>
      <% if fu1=(7-l) then %>
      <%= liushen(l)&"　"&bagua(j,9)&bagua(j,l+1) %><br>
      <% end if %>
      <% if fu2=(7-l) then %>
      <%= liushen(l)&"　"&bagua(j,11)&bagua(j,l+1) %><br>
      <% end if %>
      <% next %>
      <% end if %>
      <% else %>
      <% if bagua(j,8)="0" then %>
      <% tempguaming= "　　　"&bagua(j,1)
  
	while Len(tempguaming)<19
		tempguaming=tempguaming+"　"
	Wend
%>
<br>
      <%= tempguaming&bagua(k,1)%>
      <%'= "　　　"&bagua(j,1) &"　　　　　　　"&bagua(k,1)%>
      <br>
      <B><%= "六神 【本　　卦】　　　　　　　　　【变　　卦】" %></B><br>
      <% for l=1 to 6  %>
      <% if yao(7-l)<>3 and yao(7-l)<>4 then %>
      <%= liushen(l)&"　"&bagua(j,l+1) &"　　　"&baguabian(k,l+1)&liuqing(liunum(baguabian(j,1),baguaganzhi(k,l+1)))&baguabiangz(k,l+1)%><br>
      <% end if %>
      <% if yao(7-l)=3  then %>
      <%= liushen(l)&"　"&bagua(j,l+1) &"O-> "&"　"&baguabian(k,l+1)&liuqing(liunum(baguabian(j,1),baguaganzhi(k,l+1)))&baguabiangz(k,l+1)%><br>
      <% end if %>
      <% if yao(7-l)=4 then %>
      <%= liushen(l)&"　"&bagua(j,l+1) &"X-> "&"　"&baguabian(k,l+1)&liuqing(liunum(baguabian(j,1),baguaganzhi(k,l+1)))&baguabiangz(k,l+1)%><br>
      <% end if %>
      <% next %>
      <% else %>
      <% fu1=bagua(j,8)*1 
		       fu2=bagua(j,10)*1 %>
      <% tempguaming= "　　　　　　　　　"&bagua(j,1)  
	while Len(tempguaming)<25
		tempguaming=tempguaming+"　"
	Wend
%>
<br>
      <%= tempguaming&bagua(k,1) %>
      <%'= "　　　　　　　　　"&bagua(j,1)&"　　　　　　　"&bagua(k,1) %>
      <br>
      <B><%= "六神 　伏　　神&nbsp;【本　　卦】　　　　　　　　　【变　　卦】" %></B><br>
      <% for l=1 to 6 %>
      <% if fu1<>(7-l) and fu2<>(7-l) then %>
      <% if yao(7-l)<>3 and yao(7-l)<>4 then %>
      <%=  liushen(l)&"　　　　　　　"&bagua(j,l+1) &"　　　"&baguabian(k,l+1)&liuqing(liunum(baguabian(j,1),baguaganzhi(k,l+1)))&baguabiangz(k,l+1)%><br>
      <% end if %>
      <% if yao(7-l)=3  then %>
      <%=  liushen(l)&"　　　　　　　"&bagua(j,l+1) &"O-> "&"　"&baguabian(k,l+1)&liuqing(liunum(baguabian(j,1),baguaganzhi(k,l+1)))&baguabiangz(k,l+1)%><br>
      <% end if %>
      <% if yao(7-l)=4 then %>
      <%= liushen(l)&"　　　　　　　"&bagua(j,l+1) &"X-> "&"　"&baguabian(k,l+1)&liuqing(liunum(baguabian(j,1),baguaganzhi(k,l+1)))&baguabiangz(k,l+1)%><br>
      <% end if %>
      <% end if %>
      <% if fu1=(7-l) then %>
      <% if yao(7-l)<>3 and yao(7-l)<>4 then %>
      <%= liushen(l)&"　"&bagua(j,9)&bagua(j,l+1) &"　　　"&baguabian(k,l+1)&liuqing(liunum(baguabian(j,1),baguaganzhi(k,l+1)))&baguabiangz(k,l+1)%><br>
      <% end if %>
      <% if yao(7-l)=3  then %>
      <%= liushen(l)&"　"&bagua(j,9)&bagua(j,l+1) &"O-> "&"　"&baguabian(k,l+1)&liuqing(liunum(baguabian(j,1),baguaganzhi(k,l+1)))&baguabiangz(k,l+1)%><br>
      <% end if %>
      <% if yao(7-l)=4 then %>
      <%= liushen(l)&"　"&bagua(j,9)&bagua(j,l+1) &"X-> "&"　"&baguabian(k,l+1)&liuqing(liunum(baguabian(j,1),baguaganzhi(k,l+1)))&baguabiangz(k,l+1)%><br>
      <% end if %>
      <% end if %>
      <% if fu2=(7-l) then %>
      <% if yao(7-l)<>3 and yao(7-l)<>4 then %>
      <%= liushen(l)&"　"&bagua(j,11)&bagua(j,l+1) &"　　　"&baguabian(k,l+1)&liuqing(liunum(baguabian(j,1),baguaganzhi(k,l+1)))&baguabiangz(k,l+1)%><br>
      <% end if %>
      <% if yao(7-l)=3  then %>
      <%= liushen(l)&"　"&bagua(j,11)&bagua(j,l+1) &"O-> "&"　"&baguabian(k,l+1)&liuqing(liunum(baguabian(j,1),baguaganzhi(k,l+1)))&baguabiangz(k,l+1)%><br>
      <% end if %>
      <% if yao(7-l)=4 then %>
      <%= liushen(l)&"　"&bagua(j,11)&bagua(j,l+1) &"X-> "&"　"&baguabian(k,l+1)&liuqing(liunum(baguabian(j,1),baguaganzhi(k,l+1)))&baguabiangz(k,l+1)%><br>
      <% end if %>
      <% end if %>
      <% next %>
      <% end if %>
    <% end if %>
<br>
      <%bengua=mid(bagua(j,1),4,3)
 'response.write tempguaming
 set fo=server.createobject("scripting.filesystemobject")
  path=server.mappath("temp")
  path=path&"/guaci.txt"
  set fn=fo.opentextfile(path)
  tag=true
  tag1=true
  tag2=true
  while not fn.atendofstream and tag
  str=fn.readline
  if instr(str,bengua)>0 then
  tag=false
  title=str
  end if
  wend

  while not fn.atendofstream and tag1
  str=fn.readline
  if trim(str)<>"********************" then
  guaci=guaci&str
  else
  tag1=false
  end if
  wend
  while not fn.atendofstream and tag2
  str=fn.readline
  if  instr(str,"《易经》")>0 then
  tag2=false
  else
   guayao=guayao&"<br>"&str
  end if

  wend 
  'response.write bengua
  %>
<br><font color="#FF0000"><strong><%=title%></strong></font>
<br><%=guaci%></font>
<br><%=guayao%></font>
<br>    

</td>
      </tr>
      <tr>
        <td class="new">&nbsp;</td>
      </tr>
      
       <%if phn=1 then%>
  
  <%end if%>
    </table>
<%else%>
<script language=javascript>
var fangfa;
function DateDemo(){
   var d, s = "Today's date is: ";
   d = new Date();
   var c = ":";
 
   s += (d.getMonth() + 1) + "/";
   s += d.getDate() + "/";
   s += d.getYear() + "  ";

   s += d.getHours() + c;
   s += d.getMinutes() + c;
   s += d.getSeconds() + c;
   s += d.getMilliseconds();



   var tyear=d.getYear();
   for (i=0;i<=document.form1.sely.length-1;i++)
   {
	if ((document.all.sely.options[i].text*1)==(tyear*1))
		document.all.sely.selectedIndex=i;
   }

   var tmo=d.getMonth()+1;
   for (i=0;i<=document.form1.selmo.length-1;i++)
   {
	if ((document.all.selmo.options[i].text*1)==(tmo*1))
		document.all.selmo.selectedIndex=i;
   }

   var tdate=d.getDate();
   for (i=0;i<=document.form1.seld.length-1;i++)
   {
	if ((document.all.seld.options[i].text*1)==(tdate*1))
		document.all.seld.selectedIndex=i;
   }

   var th=d.getHours();
   for (i=0;i<=document.form1.selh.length-1;i++)
   {
	if ((document.all.selh.options[i].text*1)==(th*1))
		document.all.selh.selectedIndex=i;
   }

   var tm=d.getMinutes();
   for (i=0;i<=document.form1.selm.length-1;i++)
   {
	if ((document.all.selm.options[i].text*1)==(tm*1))
		document.all.selm.selectedIndex=i;
   }

   //alert(s);
   //return(s);
}
function getDate()
{

var temph=document.all.selh.options[document.all.selh.selectedIndex].text*1;
var tempy=document.all.sely.options[document.all.sely.selectedIndex].text*1;
var tempmo=document.all.selmo.options[document.all.selmo.selectedIndex].text*1;
var tempd=document.all.seld.options[document.all.seld.selectedIndex].text*1;
var ischanged=0;


if(form1.name.value=="")
{alert("请输入您的姓名。");
document.form1.name.focus();
return false;
}
if(form1.birthyear.value=="")
{alert("请选择您的出生时间");
document.form1.birthyear.focus();
return false;
}
if(form1.sex.value=="")
{alert("请选择您的性别");
document.form1.sex.focus();
return false;
}
if(form1.reason.value=="")
{alert("请输入你所需占事情");
document.form1.reason.focus();
return true;
}


if (((tempmo==4)||(tempmo==6)||(tempmo==9)||(tempmo==11))&&(tempd>30))
{
	alert("您输入的日期无效，请输入有效的日期！")	;
	return;
}

if (tempmo==2)	
{
	if ((tempy%4)==0)
	{
		if  (tempd>29)
		{
			alert("您输入的日期无效，请输入有效的日期！")	;
			return;
		}		
	}
	else
	{
		if  (tempd>28)
		{
			alert("您输入的日期无效，请输入有效的日期！")	;
			return;
		}
	}
}

if (fangfa==5)
{
	var tempnumber=document.form1.bsnums_up.value;
	if (tempnumber.length==0)
	{
		alert("请输入有效的整数");
		document.form1.bsnums_up.focus();
		return;
	}
	else
	{
		for (i=0;i<tempnumber.length;i++)
		{
			if ((tempnumber.charAt(i)!="1")&&(tempnumber.charAt(i)!="2")&&(tempnumber.charAt(i)!="3")&&(tempnumber.charAt(i)!="4")&&(tempnumber.charAt(i)!="5")&&(tempnumber.charAt(i)!="6")&&(tempnumber.charAt(i)!="7")&&(tempnumber.charAt(i)!="8")&&(tempnumber.charAt(i)!="9")&&(tempnumber.charAt(i)!="0"))
			{
				alert("请输入有效的整数");
				document.form1.bsnums_up.focus();
				return;
			}
		}
	}

	var tempnumber=document.form1.bsnums_down.value;
	if (tempnumber.length==0)
	{
		alert("请输入有效的整数");
		document.form1.bsnums_down.focus();
		return;
	}
	else
	{
		for (i=0;i<tempnumber.length;i++)
		{
			if ((tempnumber.charAt(i)!="1")&&(tempnumber.charAt(i)!="2")&&(tempnumber.charAt(i)!="3")&&(tempnumber.charAt(i)!="4")&&(tempnumber.charAt(i)!="5")&&(tempnumber.charAt(i)!="6")&&(tempnumber.charAt(i)!="7")&&(tempnumber.charAt(i)!="8")&&(tempnumber.charAt(i)!="9")&&(tempnumber.charAt(i)!="0"))
			{
				alert("请输入有效的整数");
				document.form1.bsnums_down.focus();
				return;
			}
		}
	}
}

if ( temph==23)
{
	 
	if ((tempmo==1)||(tempmo==3)||(tempmo==5)||(tempmo==7)||(tempmo==8)||(tempmo==10))
	{
			if  (tempd==31)
			{

				tempmo=tempmo+1;
				tempd=1;
			}		
			else
				tempd=tempd+1;
			 ischanged=1
	}	
          	
	if (( ischanged==0)&&((tempmo==4)||(tempmo==6)||(tempmo==9)||(tempmo==11)))
	{
			if  (tempd==30)
			{
				tempmo=tempmo+1;
				tempd=1;
			}		
			else
				tempd=tempd+1;
	}
	if (( ischanged==0)&&(tempmo==12))
	{
		if  (tempd==31)
		{
			tempmo=1;
			tempd=1;
			tempy=tempy+1;
		}		
		else
			tempd=tempd+1;
	}
	if (( ischanged==0)&&(tempmo==2))	
	{
		if ((tempy%4)==0)
		{
			if  (tempd==29)
			{
				tempmo=tempmo+1;
				tempd=1;
			}		
			else
				tempd=tempd+1;
		}
		else
		{
			if  (tempd==28)
			{
				tempmo=tempmo+1;
				tempd=1;
			}		
			else
				tempd=tempd+1;
		}
		
	}

}

	var tempdate=tempy+"/"+tempmo+ "/"+ tempd;
	//objDate=new Date(tempdate);
	Lunar(tempdate);
	document.all.form1.submit();
}

</script>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" >
<tbody><form name="form1" method="post" action=""onsubmit="return submitchecken();">
<input type="hidden" name="act" value="ok" /><tr>
  <td width="100%" class="ttop"><strong>纳甲六爻在线排卦（在线起卦）系统</strong></td>
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
      女  
      占事： 
      <input name="reason" type="text" id="reason" value="<%=zhanshi%>" size="12" maxlength="12"></td>
  </tr>
  <tr>
    <td class="new">公历时间： 
      
      <select name="sely" size="1" id="sely" style="font-size: 9pt">
        >
        <%for i=1950 to year(date())%>
        <option value="<%=i%>" <%if i=year(date()) then%> selected<%end if%>><%=i%></option>
        <%next%>
      </select>
年
<select name="selmo" size="1" id="selmo" style="font-size: 9pt">
  <%for i=1 to 12%>
  <option value="<%=i%>"<%if i=month(date()) then%> selected<%end if%>><%=i%></option>
  <%next%>
</select>
月
<select name="seld" size="1" id="seld" style="font-size: 9pt">
  <%for i=1 to 31%>
  <option value="<%=i%>" <%if i=day(date()) then%> selected<%end if%>><%=i%></option>
  <%next%>
</select>
日
<select name="selh" size="1" id="h" style="font-size: 9pt">
  <%for i=0 to 23%>
  <option value="<%=i%>" <%if i=hour(now()) then%> selected<%end if%>><%=i%></option>
  <%next%>
</select>
点
<select name="selm" size="1" id="selm" style="font-size: 9pt">
  <option value="0">未知</option>
  <%for i=0 to 59%>
  <option value="<%=i%>"<%if i=minute(now()) then%> selected<%end if%>><%=i%></option>
  <%next%>
</select>
分&nbsp;&nbsp;</td>
  </tr>
<tr>
<td  class="new">起卦方式：
  <INPUT 
      onclick="javacript:yg1.style.display='block';yg2.style.display='block';yg3.style.display='none';yg4.style.display='none';yg5.style.display='block';fangfa=4;" 
      type=radio value=4 name=auto checked>
            手动摇卦
            <INPUT 
      onclick="javacript:yg1.style.display='none';yg2.style.display='none';yg3.style.display='none';yg4.style.display='block';yg5.style.display='block';fangfa=2;" 
      type=radio value=2 name=auto>
            手工指定 
            <INPUT 
      onclick="javacript:yg1.style.display='none';yg2.style.display='none';yg3.style.display='block';yg4.style.display='none';yg5.style.display='none';fangfa=5" 
      type=radio value=5 name=auto>
            报数起卦
            <INPUT 
      onclick="javacript:yg1.style.display='none';yg2.style.display='none';yg3.style.display='none';yg4.style.display='none';yg5.style.display='none';fangfa=3;" 
      type=radio value=3 name=auto>
            时间起卦
            <INPUT 
      onclick="javacript:yg1.style.display='none';yg2.style.display='none';yg3.style.display='none';yg4.style.display='none';yg5.style.display='none';fangfa=1;" 
      type=radio  value=1 name=auto>
            电脑自动&nbsp;</font></P></TD></TR>
  <SCRIPT language=javascript>     
<!--     
var times=0;    
var yao=0;    
function yaogua(ok)
         
{  if(form1.b1.value=='停 止')
   ok=0;
   if(times==0)
   form1.b1.value="第一次";
   if(ok!=0)
    form1.b1.value='停 止';
	if(times==6)
	{form1.b1.value='第一次';
	}
	if (ok==1)				//开始摇     
	{     
		times++;     
		document.q1.src="../images/qltb2.gif"     
		document.q2.src="../images/qltb2.gif"     
		document.q3.src="../images/qltb2.gif"	     
	}	     
	else					//停止     
	{     
		document.q1.src="../images/qltb.gif"     
		document.q2.src="../images/qltb.gif"     
		document.q3.src="../images/qltb.gif"     
		yao1 = Math.round(Math.random());   
		yao2 = Math.round(Math.random());   
		yao3 = Math.round(Math.random());		   
		if (yao1+yao2+yao3==0)   
			yao=3;   
		else if (yao1+yao2+yao3==1)   
			yao=0;   
		else if (yao1+yao2+yao3==2)   
			yao=1;   
		else if (yao1+yao2+yao3==3)   
			yao=2;				   
		switch(times)     
		{     
			case 1:     
				document.form1.Y1.options[yao].selected=true;    
				document.form1.b1.value="第二次"    
				break;     
			case 2:     
				document.form1.Y2.options[yao].selected=true;     
				document.form1.b1.value="第三次"				   
				break;     
			case 3:     
				document.form1.Y3.options[yao].selected=true;     
				document.form1.b1.value="第四次"				   
				break;     
			case 4:     
				document.form1.Y4.options[yao].selected=true;     
				document.form1.b1.value="第五次"				   
				break;     
			case 5:     
				document.form1.Y5.options[yao].selected=true;     
				document.form1.b1.value="第六次"   
				break;     
			case 6:     
				document.form1.Y6.options[yao].selected=true;     
				yg2.style.display='none';    
				break;			     
		}    
		if (times>=6) times=0;     
	}	     
	return true;     
}     
-->     
</SCRIPT></td>
</tr>  <TR id=yg3 style="DISPLAY: none">
        <TD class=new align=center>上卦数： 
          <INPUT maxLength=8 size=10 
      name=bsnums_up>
          　下卦数： 
          <INPUT maxLength=8 size=10 name=bsnums_down>
          <INPUT 
      type=checkbox CHECKED value=1 name=addhour>
          动爻加时辰</TD>
      </TR>
  <TR id=yg1 style="DISPLAY: block">
    <TD  class=new align=center><IMG height=87 src="../images/qltb.gif" width=83 border=0 
      name=q1>　　 <IMG height=87 src="../images/qltb.gif" width=83 border=0 
      name=q2>　　 <IMG height=87 src="../images/qltb.gif" width=83 border=0 
      name=q3>
 </TD></TR>
  <TR id=yg2 style="DISPLAY: block">
    <TD  class=new align=center ><INPUT onclick=yaogua(1) type=button value=第一次 name=b1> 
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <INPUT onclick=yaogua(0) type=button value="确 定" name=b2 style="display:none"> </TD></TR>
  <TR id=yg4 style="DISPLAY: none">
    <TD class=new align=center>
     <FONT color=#0000ff>请在下面任意选择每个爻的阴阳属性 
  </FONT></TD></TR>
  <TR id=yg5 style="DISPLAY: block" bgcolor=ffffff>
    <TD  class=new align=center>
      <TABLE width="87%" border=0 
      align=center cellPadding=3 cellSpacing=1 borderColorLight=#000000 borderColorDark=#ffffff bgcolor="#CCCCCC">
        <TBODY>
        <TR bgcolor="#F5F5F5">
          <TD width="34%" height="30" align=center>
            <P>第六爻</P></TD>
          <TD width="66%" height="30" align=middle><SELECT size=1 name=Y6> <OPTION 
              value=1 selected>少阳 ───</OPTION> <OPTION value=2>少阴 ─　─</OPTION> 
              <OPTION value=3>老阳─── ○</OPTION> <OPTION value=4>老阴─　─ 
            Ｘ</OPTION></SELECT> </TD></TR>
        <TR bgcolor="eeeeee">
          <TD width="34%" height="30" align=center>第五爻</TD>
          <TD width="66%" height="30" align=middle bgcolor="eeeeee" ><SELECT size=1 name=Y5> 
              <OPTION value=1 selected>少阳 ───</OPTION> <OPTION value=2>少阴 
              ─　─</OPTION> <OPTION value=3>老阳─── ○</OPTION> <OPTION 
              value=4>老阴─　─ Ｘ</OPTION></SELECT> </TD></TR>
        <TR bgcolor="#F5F5F5">
          <TD width="34%" height="30" align=center>第四爻</TD>
          <TD width="66%" height="30" align=middle><SELECT size=1 name=Y4> <OPTION 
              value=1 selected>少阳 ───</OPTION> <OPTION value=2>少阴 ─　─</OPTION> 
              <OPTION value=3>老阳─── ○</OPTION> <OPTION value=4>老阴─　─ 
            Ｘ</OPTION></SELECT> </TD></TR>
        <TR bgcolor="eeeeee">
          <TD width="34%" height="30" align=center>第三爻</TD>
          <TD width="66%" height="30" align=middle bgcolor="eeeeee"><SELECT size=1 name=Y3> 
              <OPTION value=1 selected>少阳 ───</OPTION> <OPTION value=2>少阴 
              ─　─</OPTION> <OPTION value=3>老阳─── ○</OPTION> <OPTION 
              value=4>老阴─　─ Ｘ</OPTION></SELECT> </TD></TR>
        <TR bgcolor="#F5F5F5">
          <TD width="34%" height="30" align=center>第二爻</TD>
          <TD width="66%" height="30" align=middle><SELECT size=1 name=Y2> <OPTION 
              value=1 selected>少阳 ───</OPTION> <OPTION value=2>少阴 ─　─</OPTION> 
              <OPTION value=3>老阳─── ○</OPTION> <OPTION value=4>老阴─　─ 
            Ｘ</OPTION></SELECT> </TD></TR>
        <TR bgcolor="eeeeee">
          <TD width="34%" height="30" align=center>第一爻</TD>
          <TD width="66%" height="30" align=middle bgcolor="eeeeee"><SELECT size=1 name=Y1> <OPTION 
              value=1 selected>少阳 ───</OPTION> <OPTION value=2>少阴 ─　─</OPTION> 
              <OPTION value=3>老阳─── ○</OPTION> <OPTION value=4>老阴─　─ 
            Ｘ</OPTION></SELECT><INPUT TYPE="hidden" name="nongligan">
<INPUT TYPE="hidden" name="nongzhi">
<INPUT TYPE="hidden" name="nongmonth">
<INPUT TYPE="hidden" name="nongday">
<INPUT TYPE="hidden" name="isLeap"> </TD></TR></TBODY></TABLE></TD></TR><tr>
<td align="center" class="new"><INPUT type=button value=确定排卦 name=ok onClick="javascript:getDate()" style="cursor:hand;" />&nbsp;&nbsp;&nbsp;&nbsp; <INPUT type=reset value=重新开始 name=re >  </td>
</tr>
</form>
</table><%end if%>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" >
    <tbody>
   
      <tr>
        <td width="100%" class="ttop">六爻</td>
      </tr>
      <tr>
        <td class="new">一，六爻是我国传统预测方法的一种，往往和八字等同论。叫六爻基本是民间普及的叫法，它的别名还有“火珠林预测”“纳甲预测”“周易预测”等，书本上多称之为周易预测。 <BR>
          <BR>
          二，六爻所以叫六爻基本上是从形上叫来的。卦成后，它有六个爻位，由于动静不同的原因，变化也就很多了。易有六十四卦，一卦有六爻。卦因为爻动又分主和变等，所以六爻的演化的繁复是不逊于八字的。 <BR>
          <BR>
          三，六爻成卦的方法也交多，在高手处更是随意而为。如：金钱起卦，以蓍草起卦，声音起卦，名字起卦，方位起卦等等，凡成有数，尽皆可为。起了卦能做什么？我们依照成卦的显示，从象理数占上入手，依爻与爻间的生克制化就能推算天地人间任何事物了（信否在您）。 </td>
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
