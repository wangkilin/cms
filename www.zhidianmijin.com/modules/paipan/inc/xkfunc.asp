
<%
function plj(shanx)
sx=shanx
SxId=left(Sx,(len(Sx)-4))
SxName=right(Sx,4)
shan=left(SxName,1)
dim pojun(11)
pojun(0)="ÆÆ¾ü"
pojun(1)="<font color=red>ÓÒåö</font>"
pojun(2)="Á®Õê"
pojun(3)="ÆÆ¾ü"
pojun(4)="<font color=red>ÎäÇú</font>"
pojun(5)="<font color=red>Ì°ÀÇ</font>" 
pojun(6)="ÆÆ¾ü"
pojun(7)="<font color=red>×ó¸¨</font>"
pojun(8)="ÎÄÇú"
pojun(9)="ÆÆ¾ü"
pojun(10)="<font color=red>¾ÞÃÅ</font>"
pojun(11)="Â»´æ"
%>
<%dim sk(11)
if sxid mod 2=1 then
tag=true
else
tag=false
end if
sxid=cint(sxid)+1
          starts=round((sxid)/2)
		  
		  if starts=0 then
		  starts=1
		  end if
		 
          if tag then
          for i=0 to 11
          sk((starts+i-1)mod 12)=pojun(i)
          next
          else
        for i=0 to 11
          sk((starts-i+12-1)mod 12)=pojun(i)
          next
       end if
        

%>
<table width="600" align="center">
  <tr>
    <td align="center">Ë®¿ÚÔÚ£º<%=shan%></td>
  </tr>
  <tr>
    <td height="156" align="center" valign="top">©°©¤©¤©Ð©¤©¤©Ð©¤©¤©Ð©¤©¤©´<br>
      ©¦<%=sk(5)%>©¦<%=sk(6)%>©¦<%=sk(7)%>©¦<%=sk(8)%>©¦<br>
      ©¦ËÈ±û©¦Îç¶¡©¦Î´À¤©¦Éê¸ý©¦<br>
      ©À©¤©¤©à©¤©¤©à©¤©¤©à©¤©¤©È <br>
      ©¦<%=sk(4)%>©¦&nbsp;&nbsp;&nbsp;&nbsp;©¦&nbsp;&nbsp;&nbsp;&nbsp;©¦<%=sk(9)%>©¦<br>
      ©¦³½Ùã©¦ &nbsp;&nbsp; ©¦ &nbsp;&nbsp; ©¦ÓÏÐÁ©¦<br>
      ©À©¤©¤©à©¤©¤©à©¤©¤©à©¤©¤©È <br>
      ©¦<%=sk(3)%>©¦&nbsp;&nbsp;&nbsp;&nbsp;©¦&nbsp;&nbsp;&nbsp;&nbsp;©¦<%=sk(10)%>©¦<br>
      ©¦Ã®ÒÒ©¦ &nbsp;&nbsp; ©¦ &nbsp;&nbsp; ©¦ÐçÇ¬©¦<br>
      ©À©¤©¤©à©¤©¤©à©¤©¤©à©¤©¤©È <br>
      ©¦<%=sk(2)%>©¦<%=sk(1)%>©¦<%=sk(0)%>©¦<%=sk(11)%>©¦<br>
      ©¦Òú¼×©¦³óôÞ©¦×Ó¹ï©¦º¥ÈÉ©¦<br>
      ©¸©¤©¤©Ø©¤©¤©Ø©¤©¤©Ø©¤©¤©¼</td>
  </tr>
</table>
<%end function %>



<%function minggua(y,s,ys,ms)
nian=y
sex=s
lyp=9-((nian-110)mod 9)
if lyp=0 then
lyp=9
end if
if sex="male" then
ming=9-((nian-110)mod 9)
else
ming=(nian-104)mod 9
end if
if ming=0 then
ming=9
end if
if ming=5 then
if sex="male" then
ming=2
else
ming=8
end if
end if
'response.Write(ming)
%>
<%dim mg(8)
  dim ly(8)
ly(0)=lyp
mg(0)=ming
for i=1 to 8
mg(i)=(mg(0)+i)mod 9
ly(i)=(ly(0)+i)mod 9
if mg(i)=0 then
mg(i)=9
end if

if ly(i)=0 then
ly(i)=9
end if
next

if sex="male" then
sex="ÄÐ"
else
sex="Å®"
end if
%>
<%
nian=ys
yue=ms
%>
<%dim dz(11)
dim liuy(8)
dz(0)="×Ó"
dz(1)="³ó"
dz(2)="Òú"
dz(3)="Ã®"
dz(4)="³½"
dz(5)="ËÈ"
dz(6)="Îç"
dz(7)="Î´"
dz(8)="Éê"
dz(9)="ÓÏ"
dz(10)="Ðç"
dz(11)="º¥"
dy=(nian-724)mod 12
dizhi=dz(dy)
select case dizhi
case "×Ó","Îç","Ã®","ÓÏ"  lyz=8
case "³½","Ðç","³ó","Î´"  lyz=5
case "Òú","Éê","ËÈ","º¥"  lyz=2
end select
lyz=(lyz-yue+1+9)mod 9
if lyz=0 then
lyz=9
end if
liuy(0)=lyz
%>
<%for i=1 to 8
 liuy(i)=(liuy(0)+i)mod 9
 if liuy(i)=0 then
 liuy(i)=9
 end if
next
for i=0 to 8
select case mg(i)
   case 1 mg(i)="<font color=red>Ò»</font>"
   case 2 mg(i)="<font color=red>¶þ</font>" 
   case 3 mg(i)="<font color=red>Èý</font>" 
   case 4 mg(i)="<font color=red>ËÄ</font>" 
   case 5 mg(i)="<font color=red>Îå</font>" 
   case 6 mg(i)="<font color=red>Áù</font>" 
   case 7 mg(i)="<font color=red>Æß</font>" 
   case 8 mg(i)="<font color=red>°Ë</font>" 
   case 9 mg(i)="<font color=red>¾Å</font>" 
end select
next
for i=0 to 8
ly(i)="<font color=green>"&ly(i)&"</font>"
liuy(i)="<font color=blue>"&liuy(i)&"</font>"
next
%>
<table width="194" height="200" align="center">
  <tr> 
    <td height="22" align="center" valign="top"><p><%=nian%><strong>Äê</strong><%=dz((yue+1)mod 12)%><strong>ÔÂ</strong></p>
     
      <p><strong>ÉúÄê£º</strong><%=nian%><strong> ÐÔ±ð:</strong><%=sex%></p></td>
  </tr>
  <tr> 
    <td height="141" align="center" valign="top">©°©¤©¤©Ð©¤©¤©Ð©¤©¤©´<br>
      ©¦<%=ly(8)%>&nbsp;<%=liuy(8)%>&nbsp;©¦<%=ly(4)%>&nbsp;<%=liuy(4)%>&nbsp;©¦<%=ly(6)%>&nbsp;<%=liuy(6)%>&nbsp;©¦<br>
      ©¦&nbsp;<%=mg(8)%> ©¦ <%=mg(4)%> ©¦ <%=mg(6)%> ©¦<br>
      ©À©¤©¤©à©¤©¤©à©¤©¤©È<br>
      ©¦<%=ly(7)%>&nbsp;<%=liuy(7)%> ©¦<%=ly(0)%>&nbsp;<%=liuy(0)%>&nbsp;©¦<%=ly(2)%>&nbsp;<%=liuy(2)%>&nbsp;©¦<br>
      ©¦&nbsp;<%=mg(7)%> ©¦ <%=mg(0)%> ©¦ <%=mg(2)%> ©¦<br>
      ©À©¤©¤©à©¤©¤©à©¤©¤©È<br>
      ©¦<%=ly(3)%>&nbsp;<%=liuy(3)%> ©¦<%=ly(5)%>&nbsp;<%=liuy(5)%>&nbsp;©¦<%=ly(1)%>&nbsp;<%=liuy(1)%>&nbsp;©¦<br>
      ©¦ <%=mg(3)%> ©¦ <%=mg(5)%> ©¦ <%=mg(1)%> ©¦<br>
      ©¸©¤©¤©Ø©¤©¤©Ø©¤©¤©¼</td>
  </tr>
</table>
<%end function%>