<%
function bqtf(s) 
if s<>"" then
s=replace(s,"'","''") 
end if
bqtf=s 
end function
 
function bqtf1(s)
if s<>"" then
s=replace(s,"''","'") 
end if
bqtf1=s 
end function 


function bqtf2(fString)
if fString<>"" and not isnull(fstring) then
fString = replace(fString, "</strong>", "")
fString = replace(fString, "<td>","")
fString = replace(fString, "<tr>", "")
fString = replace(fString, "</td>","")
fString = replace(fString, "</tr>", "")
fString = replace(fString, "<strong>", "")
fString = replace(fString, "<br>", "")
fString = replace(fString, "<p>", "")
fString = replace(fString, "£ª", "")
fString = replace(fString, "<span>", "")
fString = replace(fString, "</span>", "")
fString = replace(fString, "ÐÕ", "")

bqtf2=fString
else
	bqtf2=""
end if
end function

function bqtf4(fString)
if fString<>"" and not isnull(fstring) then
fString = replace(fString, "</div>", "")
fString = replace(fString, "</script>","")
bqtf4=fString
else
	bqtf4=""
end if
end function

function bqtf3(s)
if s<>"" then
s=replace(s," ","") 
end if
bqtf3=s 
end function 

function htmlencode1(fString)
if fString<>"" and not isnull(fstring) then
	fString = replace(fString, "&gt;", ">")
	fString = replace(fString, "&lt;", "<")

	fString = Replace(fString, "&nbsp;", chr(32))
	fString = Replace(fString, "</P><P>", CHR(10) & CHR(10))
	fString = Replace(fString, "<BR>", CHR(10))
	fString = Replace(fString, "<br />", CHR(10))
	htmlencode1=fString
else
	htmlencode1=""
end if
end function

function htmlencode2(fString)
if fString<>"" and not isnull(fstring) then

	fString = replace(fString, ">", "&gt;")
	fString = replace(fString, "<", "&lt;")

	fString = Replace(fString, chr(32), "&nbsp;")
	fString = Replace(fString, CHR(10) & CHR(10), "</P><P>")
	fString = Replace(fString, CHR(10), "<BR>")
		fString = Replace(fString, CHR(10), "<br />")

	htmlencode2=fString
else
	htmlencode2=""
end if
end function
function htmlencode3(fString)
if fString<>"" and not isnull(fstring) then

	fString = replace(fString, "&gt;", ">")
	fString = replace(fString, "&lt;", "<")

'	fString = Replace(fString, "&nbsp;", chr(32))
'	fString = Replace(fString, "</P><P>", CHR(10) & CHR(10))
'	fString = Replace(fString, "<BR>", CHR(10))
    fString = Replace(fString, "<br />", CHR(10))
	htmlencode3=fString
else
	htmlencode3=""
end if
end function
function htmlencode4(fString)
if fString<>"" and not isnull(fstring) then
   fString = replace(fString, " ", "")
	fString = replace(fString, ">", "")
	fString = replace(fString, "<", "")
	fString = Replace(fString, chr(32), "")
	fString = Replace(fString, CHR(10) & CHR(10), "")
	fString = Replace(fString, CHR(10), "")
	htmlencode4=fString
else
	htmlencode4=""
end if
end function
function Jcode(str,Jtype)
E=array("¥´","¥¬","¥®","¥°","¥²","¥¶","¥¸","¥º","¥Å","¥Ç","¥É","¥Ý","¥Ù","¥×","¥Ó","¥Ñ","¥ô","¥Ü","¥Ú","¥Ö","¥Ô","¥Ð","¥Â","¥À","¥¾","¥¼")
F=array("chr(-23116)","chr(-23124)","chr(-23122)","chr(-23120)","chr(-23118)","chr(-23114)","chr(-23112)","chr(-23110)","chr(-23099)","chr(-23097)","chr(-23095)","chr(-23075)","chr(-23079)","chr(-23081)","chr(-23085)","chr(-23087)","chr(-23052)","chr(-23076)","chr(-23078)","chr(-23082)","chr(-23084)","chr(-23088)","chr(-23102)","chr(-23104)","chr(-23106)","chr(-23108)")
if Jtype then
	for i=0 to 25
		str=replace(str,E(i),F(i))
	next
else
	for i=0 to 25
		str=replace(str,F(i),E(i))
	next
end if
	Jcode=str
end function

function strlen(str)
dim p_len
p_len=0
strlen=0
if trim(str)<>"" then
p_len=len(trim(str))
for xx=1 to p_len
if asc(mid(str,xx,1))<0 then
strlen=int(strlen) + 2
else
strlen=int(strlen) + 1
end if
next
end if
end function

function strvalue(str,lennum)
dim p_num
dim i
if strlen(str)<=lennum then
strvalue=str
else
p_num=0
x=0
do while not p_num > lennum-2
x=x+1
if asc(mid(str,x,1))<0 then
p_num=int(p_num) + 2
else
p_num=int(p_num) + 1
end if
strvalue=left(trim(str),x)&""
loop
end if
end function

function getpychar(char)
Dim tmp,C
        C=asc(char)
        if c<0 Then C=C+65536
		If c>255 Then
           tmp=65536+asc(char) 
           if(tmp>=45217 and tmp<=45252) then getpychar= "A" 
           if(tmp>=45253 and tmp<=45760) then getpychar= "B" 
           if(tmp>=45761 and tmp<=46317) then getpychar= "C" 
           if(tmp>=46318 and tmp<=46825) then getpychar= "D" 
           if(tmp>=46826 and tmp<=47009) then getpychar= "E" 
           if(tmp>=47010 and tmp<=47296) then getpychar= "F" 
           if(tmp>=47297 and tmp<=47613) then getpychar= "G" 
           if(tmp>=47614 and tmp<=48118) then getpychar= "H" 
           if(tmp>=48119 and tmp<=49061) then getpychar= "J" 
           if(tmp>=49062 and tmp<=49323) then getpychar= "K" 
           if(tmp>=49324 and tmp<=49895) then getpychar= "L" 
           if(tmp>=49896 and tmp<=50370) then getpychar= "M" 
           if(tmp>=50371 and tmp<=50613) then getpychar= "N" 
           if(tmp>=50614 and tmp<=50621) then getpychar= "O" 
           if(tmp>=50622 and tmp<=50905) then getpychar= "P" 
           if(tmp>=50906 and tmp<=51386) then getpychar= "Q" 
           if(tmp>=51387 and tmp<=51445) then getpychar= "R" 
           if(tmp>=51446 and tmp<=52217) then getpychar= "S" 
           if(tmp>=52218 and tmp<=52697) then getpychar= "T" 
           if(tmp>=52698 and tmp<=52979) then getpychar= "W" 
           if(tmp>=52980 and tmp<=53688) then getpychar= "X" 
           if(tmp>=53689 and tmp<=54480) then getpychar= "Y" 
           if(tmp>=54481 and tmp<=56289) then getpychar= "Z" 
        Else
		   getpychar=Char
	    End If
end function 

function getpychar2(char)
Dim tmp,C
        C=asc(char)
        if c<0 Then C=C+65536
		If c>255 Then
           tmp=65536+asc(char) 
           if(tmp>=45217 and tmp<=45252) then getpychar2= "a" 
           if(tmp>=45253 and tmp<=45760) then getpychar2= "b" 
           if(tmp>=45761 and tmp<=46317) then getpychar2= "c" 
           if(tmp>=46318 and tmp<=46825) then getpychar2= "d" 
           if(tmp>=46826 and tmp<=47009) then getpychar2= "e" 
           if(tmp>=47010 and tmp<=47296) then getpychar2= "f" 
           if(tmp>=47297 and tmp<=47613) then getpychar2= "g" 
           if(tmp>=47614 and tmp<=48118) then getpychar2= "h" 
           if(tmp>=48119 and tmp<=49061) then getpychar2= "j" 
           if(tmp>=49062 and tmp<=49323) then getpychar2= "k" 
           if(tmp>=49324 and tmp<=49895) then getpychar2= "l" 
           if(tmp>=49896 and tmp<=50370) then getpychar2= "m" 
           if(tmp>=50371 and tmp<=50613) then getpychar2= "n" 
           if(tmp>=50614 and tmp<=50621) then getpychar2= "o" 
           if(tmp>=50622 and tmp<=50905) then getpychar2= "p" 
           if(tmp>=50906 and tmp<=51386) then getpychar2= "q" 
           if(tmp>=51387 and tmp<=51445) then getpychar2= "r" 
           if(tmp>=51446 and tmp<=52217) then getpychar2= "s" 
           if(tmp>=52218 and tmp<=52697) then getpychar2= "t" 
           if(tmp>=52698 and tmp<=52979) then getpychar2= "w" 
           if(tmp>=52980 and tmp<=53688) then getpychar2= "x" 
           if(tmp>=53689 and tmp<=54480) then getpychar2= "y" 
           if(tmp>=54481 and tmp<=56289) then getpychar2= "z" 
        Else
		   getpychar2=Char
	    End If
end function 
%>
