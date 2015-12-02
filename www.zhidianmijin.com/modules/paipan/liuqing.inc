<%  
  Dim liuqing(5)
  liuqing(1)="¡¡¸¸Ä¸"
  liuqing(2)="¡¡ÐÖµÜ"
  liuqing(3)="¡¡¹Ù¹í"
  liuqing(4)="¡¡ÆÞ²Æ"
  liuqing(5)="¡¡×ÓËï"

 function liunum(tempgong,tempyaozhi)

gong=tempgong*1
yaozhi=tempyaozhi*1

Select Case gong

case 1
	if yaozhi=1 then		
		liunum=2
	end if
	if yaozhi=2 then
		liunum=4
	end if
	if yaozhi=3 then
		liunum=5
	end if
	if yaozhi=4 then
		liunum=1
	end if
	if yaozhi=5 then
		liunum=3
	end if
case 2
	if yaozhi=1 then		
		liunum=3
	end if
	if yaozhi=2 then
		liunum=2
	end if
	if yaozhi=3 then
		liunum=1
	end if
	if yaozhi=4 then
		liunum=4
	end if
	if yaozhi=5 then
		liunum=5
	end if
case 3
	if yaozhi=1 then		
		liunum=1
	end if
	if yaozhi=2 then
		liunum=5
	end if
	if yaozhi=3 then
		liunum=2
	end if
	if yaozhi=4 then
		liunum=3
	end if
	if yaozhi=5 then
		liunum=4
	end if
case 4
	if yaozhi=1 then		
		liunum=5
	end if
	if yaozhi=2 then
		liunum=3
	end if
	if yaozhi=3 then
		liunum=4
	end if
	if yaozhi=4 then
		liunum=2
	end if
	if yaozhi=5 then
		liunum=1
	end if
case 5
	if yaozhi=1 then		
		liunum=4
	end if
	if yaozhi=2 then
		liunum=1
	end if
	if yaozhi=3 then
		liunum=3
	end if
	if yaozhi=4 then
		liunum=5
	end if
	if yaozhi=5 then
		liunum=2
	end if

end select
end function

'response.write(liunum("2","3"))
%>
