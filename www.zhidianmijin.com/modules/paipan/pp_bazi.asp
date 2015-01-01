<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<TITLE>四柱八字在线排盘-算命网网</TITLE>

<!--#include file="top.asp"--><!--#include file="../inc/conn.asp"--><!--#include file="../inc/getuc.asp"-->
<div id="right">
<!--#include file="right.asp"-->
</div>
<div id="left">
<div style="width:100%">
<%if request("act")="ok" then%>
<!--#include file=inc/yzy.asp-->
<!--#include file=inc/sizhu.asp-->
<!--#include file=inc/yy.asp-->
<!--#include file=inc/pp_bz.asp-->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" id="paipanTable">
    <tbody>
      <tr>
        <td colspan="2" class="ttop">八字排盘结果</td>
      </tr>
      <tr>
        <td class="new"><strong>姓名：</strong></td>
        <td class="new"><%=name%>　<strong>出生地：</strong><%=area%>　　<strong>排盘方式：</strong>普通方式排盘</td>
      </tr> <tr>
        <td class="new">
          <strong>公历：</strong></td>
        <td class="new"><%=borntime%>　<%if taiyang="0" then%><%else%><strong>真太阳出生时间：</strong><%=truedate%>&nbsp;<%end if%>  <strong>农历：</strong><%call form_load(truedate,ntime,cyue,cri,cnian)
response.Write(ntime)%></td>
      </tr>
      <tr>
        <td colspan="2" class="new">&nbsp;</td>
      </tr>   <tr>
        <td class="new"><strong>胎元：</strong> </td>
        <td class="new"><% call taiy(tm,dm)%></td>
      </tr>   <tr>
        <td class="new"><strong>命宫：</strong></td>
        <td class="new"><%call mingg(dm,tdz,minggongx)%></td>
      </tr>   <tr>
        <td colspan="2" class="new">&nbsp;</td>
      </tr>   <tr>
        <td class="new"><%call xunkong(ygz,yxk,yxs)
	call xunkong(mgz,mxk,mxs)
	call xunkong(dgz,dxk,dxs)
	call xunkong(tgz,txk,txs)%><strong>旬空：</strong></td>
        <td class="new"><font color=blue><%=yxk%>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<%=mxk%>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<%=dxk%>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<%=txk%></font></td>
      </tr>
      <tr>
        <td class="new"><strong>起运：</strong></td>
        <td class="new">命主于出生后<%=qysj%>开始起运</td>
      </tr>
      <tr>
        <td class="new"><strong>交运：</strong>	</td>
        <td class="new">命主于公历<%=zysj%>交运</td>
      </tr>
      <tr>
        <td width="9%" valign="middle" class="new"><strong><%if sex=1 then
	response.write "乾造："
	else
	response.write "坤造："
	end if%> </strong> </td>
        <td width="91%" class="new"><font color=blue><% call sshen(ty,dtg)%>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <% call sshen(tm,dtg)%>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <%response.write "日元"%>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <% call sshen(ttg,dtg)%></font><br><font color=red><strong><%=ygz%></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><%=mgz%></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><%=dgz%></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><%=tgz%></strong>&nbsp;&nbsp;&nbsp;<strong>（<%=dxk%>空）</strong></font><br><%  
	  dim dc1(2),dc2(2),dc3(2),dc4(2)
  dc1(0)=left(dc(dy),1)
  dc2(0)=left(dc(dm),1)
  dc3(0)=left(dc(ddz),1)
  dc4(0)=left(dc(tdz),1)
  dc1(1)=mid(dc(dy),2,1)
  dc2(1)=mid(dc(dm),2,1)
  dc3(1)=mid(dc(ddz),2,1)
  dc4(1)=mid(dc(tdz),2,1)
  dc1(2)=mid(dc(dy),3,1)
  dc2(2)=mid(dc(dm),3,1)
  dc3(2)=mid(dc(ddz),3,1)
  dc4(2)=mid(dc(tdz),3,1)
for tagk=0 to 2
  	if tagk<>0 then
  		response.Write("<br>　　　 ")
  		if jg="1" then%>　<%end if
  	end if
  	%><%=dc1(tagk)%><%
  	if dc1(tagk)<>"" then
		call sshen(tgorder(dc1(tagk))-1,dtg) 
  	else
		response.Write("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;")
  	end if
	%>&nbsp;&nbsp;&nbsp;&nbsp;<%=dc2(tagk)%><%
	if dc2(tagk)<>"" then
		call sshen(tgorder(dc2(tagk))-1,dtg)
	else
		response.Write("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;")
	end if	
	%>&nbsp;&nbsp;&nbsp;&nbsp;<%=dc3(tagk)%><%
	if dc3(tagk)<>"" then
		call sshen(tgorder(dc3(tagk))-1,dtg)
	else
		response.Write("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;")
	end if
	%>&nbsp;&nbsp;&nbsp;&nbsp;<%=dc4(tagk)%><%
	if dc4(tagk)<>"" then
		call sshen(tgorder(dc4(tagk))-1,dtg)
	else
		response.Write("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;")
	end if	
	%>
<%next%></td>
      </tr>
      <tr>
        <td class="new"><strong>纳音：</strong></td>
        <td class="new"><font color=#408000>
          <% call nayin(ygz)%>
&nbsp;&nbsp;
      <% call nayin(mgz)%>
&nbsp;&nbsp;
      <% call nayin(dgz)%>
&nbsp;&nbsp;
      <% call nayin(tgz)%>
        </font></td>
      </tr><%if quanpai=1 then%>
      <tr>
        <td colspan="2" class="new">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="new"><strong>神煞：</strong></td>
      </tr>  <tr>
        <td colspan="2" class="new"><%
		  narr=niangan(tg(ty),dz(dy))&nianzhi(dz(dy),dz(dy),dy,sx)&yuezhi(dz(dm),tg(ty),dz(dy))&rigan(tg(dtg),dz(dy))&rizhi(dz(ddz),dz(dy),ddz)
		   
			 yarr=niangan(tg(ty),dz(dm))&nianzhi(dz(dy),dz(dm),dy,sx)&yuezhi(dz(dm),tg(tm),dz(dm))&rigan(tg(dtg),dz(dm))&rizhi(dz(ddz),dz(dm),ddz)
			rarr=niangan(tg(ty),dz(ddz))&nianzhi(dz(dy),dz(ddz),dy,sx)&yuezhi(dz(dm),tg(dtg),dz(ddz))&rigan(tg(dtg),dz(ddz))&rizhi(dz(ddz),dz(ddz),ddz)
			sarr=niangan(tg(ty),dz(tdz))&nianzhi(dz(dy),dz(tdz),dy,sx)&yuezhi(dz(dm),tg(ttg),dz(tdz))&rigan(tg(dtg),dz(tdz))&rizhi(dz(ddz),dz(tdz),ddz)
		    
			narr=narr&rizhu(tg(ty)&dz(dy),tg(dtg)&dz(ddz),0)&rizhus(tg(dtg)&dz(ddz),tg(ttg)&dz(tdz))
			
			yarr=yarr&rizhu(tg(tm)&dz(dm),tg(dtg)&dz(ddz),1)&rizhus(tg(dtg)&dz(ddz),tg(ttg)&dz(tdz))
			rarr=rarr&rizhu(tg(dtg)&dz(ddz),tg(dtg)&dz(ddz),0)&rizhus(tg(dtg)&dz(ddz),tg(ttg)&dz(tdz))
			sarr=sarr&rizhu(tg(ttg)&dz(tdz),tg(dtg)&dz(ddz),0)
			
			ssn=split(narr,"-")
			ssy=split(yarr,"-")
			ssr=split(rarr,"-")
			sss=split(sarr,"-")
			if ubound(ssn)>ubound(ssy) then
				longs=ubound(ssn)
			else
				longs=ubound(ssy)
			end if
			
			if ubound(ssr)>longs then
				longs=ubound(ssr)
			end if
			
			if ubound(sss)>longs then
				longs=ubound(sss)
			end if
			
			for iarr=1 to longs
			
			if iarr<=ubound(ssn) then
			  if len(trim(ssn(iarr)))=2 then
			     temps=ssn(iarr)&" &nbsp;&nbsp;&nbsp;&nbsp;"
			  else
			     temps=ssn(iarr)
			  end if
			else
			  temps="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
			end if
			if iarr=1 then
			  temps="<font color=blue>"&temps
			else
			  temps=""&temps
			end if
			
			if iarr<=ubound(ssy) then
			     if len(trim(ssy(iarr)))=2 then
			     	temps=temps&"&nbsp;"&ssy(iarr)&" &nbsp;&nbsp;&nbsp;&nbsp;"
			     else
			     	temps=temps&"&nbsp;"&ssy(iarr)
			     end if			
			else
					temps=temps&"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
			end if
			
			if iarr<=ubound(ssr) then
			
			 if len(trim(ssr(iarr)))=2 then
			     temps=temps&"&nbsp;"&ssr(iarr)&" &nbsp;&nbsp;&nbsp;&nbsp;"
			 else
			     temps=temps&"&nbsp;"&ssr(iarr)
			 end if			
			else
			temps=temps&"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
			end if
			
			if iarr<=ubound(sss) then
			 if len(trim(sss(iarr)))=2 then
			     temps=temps&"&nbsp;"&sss(iarr)&" &nbsp;&nbsp;&nbsp;&nbsp;"
			 else
			     temps=temps&"&nbsp;"&sss(iarr)
			 end if
			else
			temps=temps&"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
			end if
			response.Write(temps)
			if iarr<>longs then
				response.Write("<br>")
				if jg="1" then%>　<%end if
			end if
				'temps=""
			next
%></td>
      </tr>
      <tr>
        <td class="new"><strong>纳音：</strong></td>
        <td class="new"><%dyy=qyday
		   
		  for i=0 to 9
		   if dyy=qyday then
			dayun="1-"&(dyy-1)
			else
			dayun=dyy-10
			end if
		   if sx=1 then
		   t=(tm+i) mod 10
		   d=(dm+i)mod 12
		   else
		   t=(tm-i+10) mod 10
		   d=(dm-i+12) mod 12
		   end if
		  '列出大运%>
              <font color=#408000>
                <%gz=tg(t)&dz(d)
		  call nayin(gz)%>
              </font>
              <%dyy=dyy+10
		  next%></td>
      </tr>
      <tr>
        <td class="new"><strong>十神： </strong></td>
        <td class="new"><%dyy=qyday
		  for i=0 to 9
		   if dyy=qyday then
			dayun="1-"&(dyy-1)
			else
			dayun=dyy-10
			end if
		   if sx=1 then
		   t=(tm+i) mod 10
		   d=(dm+i)mod 12
		   else
		   t=(tm-i+10) mod 10
		   d=(dm-i+12) mod 12
		   end if
		  '列出大运%>
              <font color=blue>
                <%call sshen(t,dtg)%>&nbsp;&nbsp;              </font>
              <%dyy=dyy+10
		  next%>      </td>
      </tr>
      <tr>
        <td class="new"><strong>大运：</strong></td>
        <td class="new"> <%dyy=qyday
		  for i=0 to 9
		   if dyy=qyday then
			dayun="1-"&(dyy-1)
			else
			dayun=dyy-10
			end if
		   if sx=1 then
		   t=(tm+i) mod 10
		   d=(dm+i)mod 12
		   else
		   t=(tm-i+10) mod 10
		   d=(dm-i+12) mod 12
		   end if
		  '列出大运%>
              <font color="#FF0000"><%=tg(t)&dz(d)%></font>&nbsp;&nbsp;
          <%dyy=dyy+10
		  next%></td>
      </tr>
      <tr>
        <td class="new"></td>
        <td class="new"><%dyy=qyday
		   
		  for i=0 to 9
		   if dyy=qyday then
			dayun="1-"&(dyy-1)
			else
			dayun=dyy-10
			end if
		   if sx=1 then
		   t=(tm+i) mod 10
		   d=(dm+i)mod 12
		   else
		   t=(tm-i+10) mod 10
		   d=(dm-i+12) mod 12
		   end if
		  '列出大运%>
              <font color=blue><%=dayun&"岁"%></font>&nbsp;&nbsp;
          <%dyy=dyy+10
		  next%></td>
      </tr>
      <tr>
        <td class="new"><strong>始于：</strong> </td>
        <td class="new"><%dayu=year(truedate)
		   
		   tag=true
		  for i=0 to 9 
		  if i<2 then
		  if i=0 then
		  dayunn=dayu
		  else
		  dayunn=dayu+qyday
		  end if
		  else
		 dayunn=dayunn+10
		  end if 
		  tag=false
		  %>              <font color="#FF0000"><%=dayunn%></font>&nbsp;&nbsp;<%  
		  next%></td>
      </tr>
      <tr>
        <td class="new"><strong>流年:</strong></td>
        <td class="new"><%
		t=(ty-1)mod 10
		 d=(dy-1)mod 12
	     t1=t
		d1=d
	    starx=year(truedate)
		stary=starx+qyday
        substar=qyday
		 for i=1 to 10
		
		 %>
            
                <%
		if not liutag then
		liutag=true
else
		end if
		%>
		
		<%if substar>0 then
		t1=(t1+1)mod 10
		d1=(d1+1)mod 12
		substar=substar-1
		 %><font color="#0000ff"><%=tg(t1)&dz(d1)%>&nbsp;&nbsp;</font>
                <%else
            end if
			%>
              <%for j= 0 to 10
		    t2=(((stary+i+j*10-1925) mod 10)+10)mod 10
			d2=(((stary+i+j*10-1925) mod 12)+12) mod 12	
		   %><font color="#0000ff"><%=tg(t2)&dz(d2)%>&nbsp;&nbsp;</font>
              <%next
		  '流年%>
           <br><%if jg="1" then%>　<%end if%>
            <%next
		'流年排法%></td>
      </tr>
<%end if%>
    </table>
<%else%>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" >
<tbody><form name="theform" onSubmit="return checkjx();" method="post" action="">
<input type="hidden" name="act" value="ok" /><tr>
  <td width="100%" class="ttop">四柱八字在线排盘系统    </td>
    </tr>
  <tr>
    <td class="new">姓名：
      <input name="name" type="text" id="name" value="<%=xing&ming%>" size="12"> 
      出生地： 
      <input name="area" type="text" id="csd" size="25"> 
      性别: 
      <input name="sex" type="radio" value="1" checked>
      男
      <input type="radio" name="sex" value="0">
      女 </td>
  </tr>
  <tr>
    <td class="new">出生： 
      <select name="DateType" size="1" style="font-size: 9pt">
  	<option value="1"<%if DateType="1" then%> selected<%end if%>>阳历</option>
  	<option value="0"<%if DateType="0" then%> selected<%end if%>>阴历</option>
  	</select>
      <select name="year" size="1" id="year" style="font-size: 9pt">
        >
        <%for i=1950 to year(date())%>
        <option value="<%=i%>" <%if i=1981 then%> selected<%end if%>><%=i%></option>
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
  <option value="<%=i%>" ><%=DiZhi(i)%>&nbsp;<%=i%></option>
  <%next%>
</select>
点
<select name="minute" size="1" id="minute" style="font-size: 9pt">
  <option value="0">未知</option>
  <%for i=0 to 59%>
  <option value="<%=i%>"><%=i%></option>
  <%next%>
</select>
分 </td>
  </tr><!--
onkeyup="value=value.replace(/[^\d]/g,'')" 
-->
<tr id="fs1" style="display:none">
<td class="new">真太阳时排盘请输入所在地区经度： 
<input name=jd1 type="text" value="120" size="10" maxlength="4" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /> 
度 
<input name=jd2 type="text" value="0" size="10" maxlength="4" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /> 
分 （<a href="jingdu.asp" target="_blank"><font color="red">地区经度查询</font></a>） </td>
</tr>
<tr id="fs2"  style="display:block">
<td class="new">普通方式排盘无须输入地区经度值</td>
</tr>
<tr>
<td  class="new">
<input id=taiyang name="taiyang" type="radio" onClick="javacript:fs1.style.display='none';fs2.style.display='block';" value="0" checked="" />
<label for="taiyang"style="cursor:hand;" >按普通方式排</label>　　　　　
<input id=taiyang1 type="radio" name="taiyang" value="1" onClick="javacript:fs1.style.display='block';fs2.style.display='none';" />
<label for="taiyang1"style="cursor:hand;" >按真太阳时排盘</label></td>
</tr>
<tr>
<td  class="new"><input id=jp name="quanpai" type="radio" value="0" />
<label for="jp"style="cursor:hand;" >简排</label>　　　

<input name="quanpai" type="radio" id=wq value="1" checked />
<label for="wq" style="cursor:hand;" >
全排</label></td>
</tr> 
<td align="center" class="new"><input type="submit" value="在线八字排盘" name="submit" style="cursor:hand;" /> </td>
</tr>
</form>
</table><%end if%>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" >
    <tbody>
   
      <tr>
        <td width="100%" class="ttop">四柱八字常用术语简释</td>
      </tr>
      <tr>
        <td class="new"><P><BR><FONT color=#0000ff><STRONG>比劫帮身：<BR></STRONG></FONT>比肩劫财与日干属同类之物，均可助日干之力，如甲见甲（比）、乙（劫）、寅（禄）、卯（刃）之类，正如一个人打不过人家，有兄弟帮忙或壮胆，就能打过人家。日干弱，不能胜任财官伤食之消耗，柱见比劫则为喜，如柱中财多身弱，喜比劫帮身克财；柱中官杀旺而身弱，喜比劫帮身敌官杀；柱中伤食旺而身弱，喜比劫帮身泄气也，行运亦如之。人命逢之，兄弟有情，朋友得助，社会关系良好，发达亦是必靠兄弟朋友之助。日干本强，又见比劫来帮身，则为祸也。</P>
<P><STRONG><FONT color=#0000ff>比劫夺财：</FONT></STRONG><BR>又叫“比劫争财”。日干强，柱又有多比劫，则比劫之帮身却为凶兆，盖旺上加旺，物极必反，柱中财星本为日干所享，却被比劫争夺去，行运亦如。比劫过旺，须官杀制伏比劫方为福。人命逢比劫夺财，一生财物每多虚耗，经济观念不强，浪费成性，且一生又多遇小人夺财，兄弟无情义，行运遇此，多主遭人算计而破败。柱中日干强，比劫多而成为忌神，须柱有官杀制之，行运亦宜官杀旺乡。 </P>
<P><BR><STRONG><FONT color=#0000ff>财多身弱：</FONT></STRONG><BR>又叫“财旺身衰”。柱中日干弱而偏正财之力强，日主不能胜任之，其财反不能享，如三岁小儿要挑一百斤东西。凡财多身弱者，而柱中又有官杀，则财生官杀来克日主，其祸不可胜言。或柱中又有食伤，泄尽日干元气生在财上，其祸亦重。财多身弱，宜见柱有比劫帮身为福，行运遇比劫则发，或柱有印星亦吉，唯须比劫制财以护印。 </P>
<P><BR><STRONG><FONT color=#0000ff>贪财坏印：</FONT></STRONG><BR>又叫“财星破印”。日干弱，喜印星生扶日干，则不喜财星，因财可克印也。若柱中以印为用神，而逢柱中有财星冲、克印星，则为不吉之兆，人命逢此，一者背井离乡，二者职业不定，三者学业难就，四者因财致祸，五者早克母亲，六者体弱病多，七者经常搬迁，八者为人虚浮了无实学，九者婆媳不睦，以上诸等，必犯一二，又看此财印居于何柱而详言之。行运遇之，多主有灾，或丢掉公职（也许是下海），或因财丧命。凡财星破印，须有比劫制财方佳，行运亦同。</P>
<P><STRONG><FONT color=#0000ff>印绶护身：</FONT></STRONG><BR>日干弱，当赖正偏印生身而旺。凡印星护身，忌财星克印，喜官杀生印。若柱中日干本强，又有印星来生，或遇过多之印生日，反不为吉，则又喜财星克去有余之印。流年大运同。</P>
<P><STRONG><FONT color=#0000ff>官印相生 或“杀印相生”：</FONT></STRONG><BR>柱中官杀克日，须印星泄官杀之力而生身，或身强印弱，喜官杀生印。有云：官生印，印生身，富贵双全。杀不离印，印不离杀，杀印相生，功名显达。</P>
<P><STRONG><FONT color=#0000ff>财旺生官：</FONT></STRONG><BR>身旺，财旺，官弱，喜财生起官星为用也。</P>
<P><STRONG><FONT color=#0000ff>官星卫财：</FONT></STRONG><BR>柱中财神，被比劫夺去，犹喜官杀克去比劫，使财为日干所享，此官星卫财也。</P>
<P><STRONG><FONT color=#0000ff>官杀混杂：</FONT></STRONG><BR>柱中既有官星，又有七杀，且官杀成党，克伐日干，则凶不可测。日干旺，比劫多，喜官杀相混，日干旺，印星多，不忌官杀。身衰而官杀混杂，必然贫贱，身强而官杀混杂，宜去官留杀，或去杀留官，具体而定。凡官杀混杂，喜印星化官杀而生日，喜比劫代替日干而受官杀之克。若日干不弱，又喜食伤制去官杀之力，若身弱则喜印星化官杀生身，不宜食伤也，当知，身弱又逢克泄交集，下命无疑。</P>
<P><STRONG><FONT color=#0000ff>官变为鬼：</FONT></STRONG><BR>又叫“身衰遇鬼”。日干衰，有重重官星来克日干，此非官也，实乃克身之鬼也，官多无官，与七杀无异，祸不可测，唯喜印星化之。大忌柱中有财及运逢财地，必遭大祸。</P>
<P><STRONG><FONT color=#0000ff>伤食泄秀：</FONT></STRONG><BR>日干强，比劫多，无官杀，须伤官或食神泄日干之力，以趋中和，此为泄秀，而尤喜柱有财星，则比劫生伤食，伤食生财星，财为我享也。日干衰弱，再不宜逢伤食盗泄日干之气，则弱上加弱也，又宜取比劫代身泄气，或印星制去伤食。岁君大运同。</P>
<P><STRONG><FONT color=#0000ff>偏印夺食：</FONT></STRONG><BR>又叫“食神逢枭”。日干强，无官杀，宜食神泄气以成中和，而生财星为福，却柱有偏印，克去食神，又使日干更旺，此为凶也。此非独食神、偏印也，伤官、正印亦如之。凡伤食泄秀而用，不宜见印星也，若遇之，又宜财星克去正偏印为福。</P>
<P><STRONG><FONT color=#0000ff>伤官见官：</FONT></STRONG><BR>柱以伤官为用，或柱伤官气盛，则不喜官星，缘伤官与官星相战，其祸不可胜言，行运同此。凡伤官见官之格，最难分辨，今后再详述。 </P>
<P><STRONG><FONT color=#0000ff>食神制杀：</FONT></STRONG><BR>日干衰，有食神，又有七杀克身，杀虽不宜见之，妙在有食神制去七杀也。或日干旺，七杀亦强，无印星，唯以食神制伏七杀，化为权星也。古诗云：偏官有制化为权，唾手登云发少年。此不单食神可制杀，伤官亦可制杀，其理同。唯日干强，七杀弱，不可制也，反宜行财杀旺乡助起七杀也。日干强，七杀强，可制，但不可制过头，如叠叠伤食，七杀被制过份，又为凶兆，不能发达。日干衰，七杀过强，不可制也，反宜印绶化杀生身为上。</P>
<P><STRONG><FONT color=#0000ff>羊刃驾杀：</FONT></STRONG><BR>日干强，柱又有羊刃，喜见七杀，此七杀不可制，名羊刃驾杀，兵权贵显。如七杀过重，又宜略略制之，或有印化之，制者宜行制伏运，不宜印运，化则宜行印运，不宜行财运克印。凡命中羊刃驾杀者，以制杀为佳，以印化杀并不一定很好。</P>
<P><STRONG><FONT color=#0000ff>官星带刃：</FONT></STRONG><BR>日干强，柱有羊刃，喜见正官，尤喜正官通根透干，制伏羊刃，名官星带刃，掌万将之威权。柱中羊刃重而官弱，而又宜财生官，或杀混官，行运亦如。唯羊刃不喜正官在地支来冲也，反为大凶之兆，名羊刃倒戈，必作无头之鬼。如甲以卯为刃，不喜酉来冲，丙以午为刃，不喜子来冲，流年大运同。</P>
<P><BR><BR></SPAN></P></td>
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
