<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<TITLE>玄空飞星在线排盘-算命网网</TITLE>
<!--#include file="top.asp"--><!--#include file="../inc/conn.asp"-->
<div id="right">
<!--#include file="right.asp"-->
</div>
<div id="left">
<div style="width:100%">
<%if request("act")="ok" then%><%
  Gm=trim(request("gm"))
  Dy=request("dy")
  
  Sx=trim(request("sx"))
  pljsx=request("pljsx")
  nian=request("nian")
Response.Cookies("ciduppyear")=nian
  sex=request("sex")
Response.Cookies("ciduppsex")=sex
  y=request("year")
  mont=request("month")
  SxId=left(Sx,(len(Sx)-4))
  SxName=right(Sx,4)
  shan=left(SxName,1)
  xiang=left(right(sxname,2),1)
  tixing=0
%>
<!--#include file="inc/xkfunc.asp"-->

<%
  select case shan
     case "丑","未","辰","戌","乙","辛","丁","癸","艮","坤","寅","申","子","午" tixing=1
  end select
  dim Jiu(7)
    dim sx1(23)
	  sx1(0)="壬"
      sx1(1)="子"
      sx1(2)="癸"
      sx1(3)="丑"
      sx1(4)="艮"
      sx1(5)="寅"
      sx1(6)="甲"
      sx1(7)="卯"
      sx1(8)="乙"
      sx1(9)="辰"
      sx1(10)="巽"
      sx1(11)="巳"
      sx1(12)="丙"
      sx1(13)="午"
      sx1(14)="丁"
      sx1(15)="未"
      sx1(16)="坤"
      sx1(17)="申"
      sx1(18)="庚"
      sx1(19)="酉"
      sx1(20)="辛"
      sx1(21)="戌"
      sx1(22)="乾"
      sx1(23)="亥"
  jiu(0)=1
  jiu(1)=8
  jiu(2)=3
  jiu(3)=4
  jiu(4)=9
  jiu(5)=2
  jiu(6)=7
  jiu(7)=6
  Bgid=(sxid\3)
  BgYu=sxid mod 3'获得所在元龙,如天元，地元，人元。
  bgidx=(jiu(bgid)+4)mod 9
  bgidy=9-bgidx
  %><%
  select case dy
       case 0 DaYun="一运"
       case 1 DaYun="二运"
       case 2 DaYun="三运"
	   case 3 DaYun="四运"
	   case 4 DaYun="五运"
	   case 5 DaYun="六运"
	   case 6 DaYun="七运"
       case 7 DaYun="八运"
	   case 8 DaYun="九运"
end select	
%>
<%Dim DaXie(8)
Dim SP(8)
Dim Xp(8)
Dim Yp(8)
Dim Yporder(8)
DaXie(0)="一"
DaXie(1)="二"
DaXie(2)="三"
DaXie(3)="四"
DaXie(4)="五"
DaXie(5)="六"
DaXie(6)="七"
DaXie(7)="八"
DaXie(8)="九"
for i=0 to 8
YpIndex=(i+dy)mod 9
Yp(i)=Daxie(YPindex)
yporder(i)=ypindex+1
next

'运盘
%>

 <%
 sp1=yporder(bgidx)
 xp1=yporder(bgidy)
 %>

 <%
 
   for i=0 to 7
   if jiu(i)=sp1 then
   kki=i
   exit for
   end if
   next  
   for i=0 to 7
   if jiu(i)=xp1 then
   kkj=i
   exit for
   end if
   next  
   if sp1=5 then
   kki=dy
   end if
   if xp1=5 then
   kkj=dy
   end if'
  ' response.write sp1&xp1&"<br>"
  'response.write kki&kkj&"<br>"
  ' response.write bgyu&"<bg>"
   %>

<%
if gm="挨星替卦" then
'response.write shan&xiang
 shangx=kki*3+bgyu
 xiangx=kkj*3+bgyu
 shan=sx1(shangx)
 xiang=sx1(xiangx)
' response.write xiangx
 'response.write shan&xiang
 if sp1<>5 then
select case shan
case "子","癸","甲","申" dyys=1
case "坤","壬","乙","卯","未" dyys=2
case "戌","乾","亥","辰","巽","巳" dyys=6
case "艮","丙","辛","酉","丑"  dyys=7
case  "寅","午","庚","丁" dyys=9
end select
end if
if xp1<>5 then
'response.write dyys
select case xiang
case "子","癸","甲","申" dyyx=1
case "坤","壬","乙","卯","未" dyyx=2
case "戌","乾","亥","辰","巽","巳" dyyx=6
case "艮","丙","辛","酉","丑"  dyyx=7
case  "寅","午","庚","丁" dyyx=9
end select
end if
else
dyy=dy
end if
if gm="挨星替卦" then
 sp(0)=dyys
 xp(0)=dyyx
 
 else
 sp(0)=yporder(bgidx)
 xp(0)=yporder(bgidy)
   
 end if'获得中宫山向盘
 if sp1=5 then
sp(0)=5
end if
 if xp1=5 then
xp(0)=5
end if
%>

   <%
   SxIds=kki*3+bgyu
   SxIdx=kkj*3+bgyu'山向得到序号
  %>
  <%

  If (((SxIds-1)\3)mod 2)=1 then
    Orderx=true
	else
	Orderx=false
	end if    '确定阴阳
   If sXIDs=0 then
   Orderx=true
   end if  
    If (((SxIdx-1)\3)mod 2)=1 then
    Ordery=true
	else
	Ordery=false
	end if    '确定阴阳
   If sXIDx=0 then
   Ordery=true
   end if    '壬为阳
	'response.write order
  %>
<%

if Orderx then
for i=1 to 8
Sp(i)=(Sp(0)+i)mod 9
if sp(i)=0 then
sp(i)=9
end if
next
else
for i=1 to 8
Sp(i)=(Sp(0)-i+9)mod 9
if sp(i)=0 then
sp(i)=9
end if
next
end if
%>
<%

if Ordery then
for i=1 to 8
Xp(i)=(Xp(0)+i)mod 9
if xp(i)=0 then
xp(i)=9
end if
next
else
for i=1 to 8
Xp(i)=(Xp(0)-i+9)mod 9
if xp(i)=0 then
xp(i)=9
end if
next
end if
%>





<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" id="paipanTable">
    <tbody>
      <tr>
        <td class="ttop">玄空飞星在线排盘</td>
      </tr>
      <tr>
        <td align="center" class="new"><strong><font color="#0000FF"><%=dayun%> <%=sxName%>
<br>
<%=gm%></font></strong>
<br>　　　　<a href=pp target=_blank><font color=aaaaaa></font></a>
<br>┌──┬──┬──┐
<br>│&nbsp;<%=sP(8)%> <%=xP(8)%> │ <%=sP(4)%> <%=xP(4)%> │<%=sP(6)%>  <%=xP(6)%> &nbsp;│
<br>│ <%=yP(8)%> │ <%=yP(4)%> │ <%=yP(6)%>   │
<br>├──┼──┼──┤
<br>│&nbsp;<%=sP(7)%> <%=xP(7)%> │ <%=sP(0)%> <%=xP(0)%> │<%=sP(2)%>  <%=xP(2)%> &nbsp;│
<br>│ <%=yP(7)%> │ <%=yP(0)%> │ <%=yP(2)%>    │
<br>├──┼──┼──┤
<br>│&nbsp;<%=sP(3)%> <%=xP(3)%> │ <%=sP(5)%> <%=xP(5)%>  │<%=sP(1)%>  <%=xP(1)%> &nbsp;│
<br>│ <%=yP(3)%> │ <%=yP(5)%> │ <%=yP(1)%> │
<br>└──┴──┴──┘
<br>　　<%response.Write(shan&"山:")
  if tixing=1 then
 
  %>
      <font color="#0000CC">宜出煞，楼门或大门宜开畅。而不宜收敛。开门宜大，或门旁边有较多玻璃窗，于室内于门处不宜有所阻拦，如设屏风等。且门外地势宜略低。</font> 
      <%else%>
      <font color="#0000CC">宜收山，住宅形势须保守，而不宜开畅，于开门不宜过大，且于门处宜设屏风以遮掩，用以藏气。屋门外形势不宜过低，低则收山不尽 
      </font>
    <%end if%>   
<br>
<%if request("pailong")=1 then%>
<br>　<strong>排龙诀</strong><p></p>
<%'response.Write(pljsx)
'response.end

call plj(pljsx)

end if
%>
<br>
<%
if request("mingua")=1 then
%>
<br>　<strong><font color=red>命卦</font>、<font color=green>流年</font>、<font color=blue>流月</font></strong><p></p>
<%'response.Write(pljsx)
'response.end
call minggua(nian,sex,y,mont)
%>
<%
end if%>
</td>

      </tr>

    </table>
<%else%><%
dim dz(11)
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
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" >
<tbody><form name="form1"  method="post" action="">
<input type="hidden" name="act" value="ok" /><tr>
  <td width="100%" class="ttop">玄空飞星在线排盘</td>
    </tr>
  <tr>
    <td class="new">选择 
        <input name="feixing" type="checkbox" id="feixing" value="checkbox" checked>
        飞星盘&nbsp;&nbsp;卦名： 
            <select id = select5 name=gm style="WIDTH: 80px">
              <option value = "挨星下卦" selected >挨星下卦</option>
              <option value = "挨星替卦" >挨星替卦</option>
            </select>
大运：
<select id = select6 name=dy style="WIDTH: 55px">
  <option value = 0 >一运</option>
  <option value = 1 >二运</option>
  <option value = 2 >三运</option>
  <option value = 3 >四运</option>
  <option value = 4 >五运</option>
  <option value = 5 >六运</option>
  <option value = 6 selected >七运</option>
  <option value = 7 >八运</option>
  <option value = 8 >九运</option>
</select>
山向：
<select id=select7 name=sx style="WIDTH: 80px">
  <option value = 0壬山丙向 selected>壬山丙向</option>
  <option value = 1子山午向 >子山午向</option>
  <option value = 2癸山丁向 >癸山丁向</option>
  <option value = 3丑山未向 >丑山未向</option>
  <option value = 4艮山坤向 >艮山坤向</option>
  <option value = 5寅山申向 >寅山申向</option>
  <option value = 6甲山庚向 >甲山庚向</option>
  <option value = 7卯山酉向 >卯山酉向</option>
  <option value = 8乙山辛向 >乙山辛向</option>
  <option value = 9辰山戌向 >辰山戌向</option>
  <option value = 10巽山乾向 >巽山乾向</option>
  <option value = 11已山亥向 >已山亥向</option>
  <option value = 12丙山壬向 >丙山壬向</option>
  <option value = 13午山子向 >午山子向</option>
  <option value = 14丁山癸向 >丁山癸向</option>
  <option value = 15未山丑向 >未山丑向</option>
  <option value = 16坤山艮向 >坤山艮向</option>
  <option value = 17申山寅向 >申山寅向</option>
  <option value = 18庚山甲向 >庚山甲向</option>
  <option value = 19酉山卯向 >酉山卯向</option>
  <option value = 20辛山乙向 >辛山乙向</option>
  <option value = 21戌山辰向 >戌山辰山</option>
  <option value = 22乾山巽向 >乾山巽向</option>
  <option value = 23亥山已向 >亥山已向</option>
</select></td>
  </tr>

<tr> 
<td class="new">选择 
        <input name="pailong" type="checkbox" id="pailong" value="1">
         排龙诀&nbsp;&nbsp;水口在： 
            <select id=pljsx name=pljsx style="WIDTH:40px">
              <option value = 0壬山丙向 selected>壬</option>
              <option value = 1子山午向 >子</option>
              <option value = 2癸山丁向 >癸</option>
              <option value = 3丑山未向 >丑</option>
              <option value = 4艮山坤向 >艮</option>
              <option value = 5寅山申向 >寅</option>
              <option value = 6甲山庚向 >甲</option>
              <option value = 7卯山酉向 >卯</option>
              <option value = 8乙山辛向 >乙</option>
              <option value = 9辰山戌向 >辰</option>
              <option value = 10巽山乾向 >巽</option>
              <option value = 11已山亥向 >已</option>
              <option value = 12丙山壬向 >丙</option>
              <option value = 13午山子向 >午</option>
              <option value = 14丁山癸向 >丁</option>
              <option value = 15未山丑向 >未</option>
              <option value = 16坤山艮向 >坤</option>
              <option value = 17申山寅向 >申</option>
              <option value = 18庚山甲向 >庚</option>
              <option value = 19酉山卯向 >酉</option>
              <option value = 20辛山乙向 >辛</option>
              <option value = 21戌山辰向 >戌</option>
              <option value = 22乾山巽向 >乾</option>
              <option value = 23亥山已向 >亥</option>
            </select></td>
</tr>

<tr> 
<td class="new">选择 
        <input name="mingua" type="checkbox" id="mingua" value="1">
        流年、流月、命卦&nbsp;&nbsp;流年 
            <select name="year" id="year">
              <%yea=year(now)
		  for i=0 to 100%>
              <option value=<%=yea-i%>><%=yea-i%></option>
              <%next%>
            </select>
        流月： 
        <select name="month" id="month">
          <option value=<%=mon%>><%=dz((mon+1)mod 12)%>月</option>
          <%
		  for i=1 to 12
		  j=(i+1)mod 12
		  %>
          <option value=<%=i%>><%=dz(j)%>月</option>
          <%next%>
        </select></td>
</tr>
<tr> 
<td class="new">出生时间： 
      <select name=birthyear>
              <%for i=1922 to year(date())%>
              <option value="<%=i%>"<%if i=1981 then%> selected<%end if%>><%=i%></option>
              <%next%>
            </select> 
      性别: 
      <input name="sex" type="radio" value="1" checked>
      男
      <input type="radio" name="sex" value="0">
      女 <input type=hidden name=cm value=8> </td>
</tr>
 <tr align="center"> 
<td class="new">注：排龙诀及收山出煞诀采用王亭之先生"中州派玄空学"内容，谨此致谢！</td>
</tr><tr align="center"> 
<td class="new">
 <input type="submit" value="开始排盘" id=submit1 name=submit1>          　 
          <input type="reset" value="重新设定" id=submit1 name=reset>
  </td>
</tr>
</tbody>
</form>
</table>
  <%end if%>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" >
    <tbody>
   
      <tr>
        <td width="100%" class="ttop">玄空飞星在线排盘</td>
      </tr>
      <tr>
        <td class="new"><p>玄就是时间，空就是空间，玄空学就是一门研究时间和空间为人造福的学问。<BR>
          　　
          玄空学由三大体系构成：河图，洛书，八卦。<BR>
          　　
          河图必须要记忆的是：一六为水，二七为火，三八为木，四九为金，五十为土。河图为先天。<BR>
          　　
          洛书必须要记忆的是：戴九履一，左三右七，二四为肩，六八为足。洛书为后天。<BR>
          　　
          八卦有先天八卦，有后天八卦，先天配河图，后天配洛书。先后天八卦的方位一定要记牢。<BR>
          　　
          关于河图洛书八卦的内容很多书籍都有了，我就不多说了，但大家要记住的是，这些是最重要的基础，一定要充分了解，否则后面的东西就很难掌握了。<BR>
          　　
          在玄空风水中要用到的是：坎水为一居正北，坤土为二居西南，震木为三居正东，巽木为四居东南，五为土居正中，乾金为六居西北，艮土为八居东北，离火为九居正南。<BR>
          　　
          玄空风水学在实践运用中的四的步骤是：一，排龙；二，安星；三，析局；四，调整。<BR>
          　　
          玄空风水的最大关键是：形理兼察。重理气也重峦头（在平洋主要是水法）。<BR>
          　　
          往后我们就直接进入玄空之门，易学基础不够的学友，马上把河图、洛书、八卦的基本知识掌握，因为到后面就是这些东西的运用了。 </p>
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
