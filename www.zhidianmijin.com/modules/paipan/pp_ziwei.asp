<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<TITLE>紫微斗数在线排盘系统-算命网网
</TITLE>
<!--#include file="top.asp"--><!--#include file="../inc/conn.asp"-->
<div id="right">
<!--#include file="right.asp"-->
</div>
<div id="left">
<div style="width:100%">
<%if request("act")="ok" then%>
<%on error resume next%>
<%
 server.ScriptTimeout=100
 name=request("name")
 sex=request("sex")
 DateType=request("DateType")
 y=request("year")
 m=request("month")
 d=request("date")
 h=request("hour")
 minutes=request("minute")


 Runyue=request("data_month_other")
 dlevel=request("data_level")
 starLevel=request("data_star_level")
 liunian=request.form("liunian")
%>

<!--#include file="inc/sizhu.asp"-->
<!--#include file="inc/jieqi.asp"-->
<!--#include file="inc/zwcom.asp"-->
<!--#include file="inc/yy.asp"-->
<%
 if DateType="0" then
  NongLI=y&"年"&m&"月"&d&"日"&dz(hindex)&"时"
 call setdate(y,m,d,Yy,Ym,Yd)
 call sizhu(yy,Ym,Yd,h,minutes,ygz,mgz,dgz,tgz)
 else
  call sizhu(y,m,d,h,minutes,ygz,mgz,dgz,tgz)
 call form_load(y&"-"&m&"-"&d&" "&h&":"&minutes&":00",ntime,cyue,cri,cyear)
 y=cyear
 m=cyue
 d=cri
  NongLI=ntime
 end if
%>
<%
if (sex=0 and (tgorder(ygz)mod 2)=1) or (sex=1 and (tgorder(ygz)mod 2)=0) then
ORDERS=1
ELSE
ORDERS=0
END IF   '阳男阴女顺俳，阴男阳女逆俳

%>
<%
hIndex=((h+1)/2)mod 12  '时辰的记法

%>
<%'给12宫配上天干和年上起月法相同
dim DpTg(11)
tm=int(((y mod 5)-2)*2-1)

if tm<0 then
tm=tm+10
end if

'response.Write(tm)
for i=0 to 11
dm=(i+11) mod 12
if dm=0 then
dm=12
end if
TgIndex=(tm+dm-2)mod 10 ' 求出地盘所对应的天干
DpTg(i)=Tg(TgIndex)
next
ytg=left(ygz,1)
%>

<%'命宫和身宫，
dim Minggong(11)
dim shenGong(11)
MingGIndex=(m-1-hIndex+12)mod 12
ShenGIndex=(m-1+HiNdex+12)mod 12
for i=0 to 11
shengong(i)="&nbsp&nbsp"
next
minggong(MinggIndex)="命宫"
shengong(shengIndex)="(身宫)"

'排12宫，以命工为基准，逆排
for i=1 to 11
MgIndex=(MinggIndex-i+12)mod 12
minggong(mgindex)=segong(i-1)
next
%>

<%'五行局和五行纳音
wxIndex=(minggindex+2)mod 12
wxgz=dptg(wxindex)&dz(wxindex)
wxNayin=nayins(wxgz)

select case right(trim(wxnayin),1)
     case "火"  WxJU="火六局"
	             Jindex=6
     case "土"  wxju="土五局"
	            Jindex=5
     case "水"  wxju="水二局"
	 	            Jindex=2
	 case "木"  wxju="木三局"
	 	            Jindex=3
	 case "金"  wxju="金四局"
	 	            Jindex=4
   end select
'call nayin("癸未")


%>

<%'安紫薇诸星
dim zwxing(11)
dim tfxing(11)
zwTemp=d mod jindex
zwInt=d\jindex

if zwTemp=0 then
zwindex=(zwint-1)mod 12

else if (zwTemp mod 2)=1 then
      zwindex=(zwint+1-jindex+zwtemp+12)mod 12
      else
	  zwindex=(zwint+1+jindex+zwtmp)mod 12
	  end if
end if   '分三种情况求出紫薇星的落宫
zwxing(zwindex)="紫薇"
select case ytg
case "乙"  zwxing(zwindex)="紫薇【科】"
case "壬"  zwxing(zwindex)="紫薇【权】"
end select
tianjiindex=(zwindex+11)mod 12
zwxing(tianjiindex)="天机"
select case ytg
   case "乙" zwxing(tianjiindex)="天机【禄】"
   case "丙" zwxing(tianjiindex)="天机【权】"
   case "丁" zwxing(tianjiindex)="天机【科】"
   case "戊" zwxing(tianjiindex)="天机【忌】"
   end select
taiyangindex=(zwindex+9)mod 12
zwxing(taiyangindex)="太阳"
select case ytg
case "甲" zwxing(taiyangindex)=zwxing(taiyangindex)&"【忌】"
case "庚" zwxing(taiyangindex)=zwxing(taiyangindex)&"【禄】"
case "辛" zwxing(taiyangindex)=zwxing(taiyangindex)&"【权】"
end select

wuquindex=(zwindex+8)mod 12
if minggindex=3 or minggindex=5 then
zwxing(wuquindex)="武曲（命主）"
else
zwxing(wuquindex)="武曲"
end if
select case ytg
case "甲" zwxing(wuquindex)=zwxing(wuquindex)&"【科】"
case "己" zwxing(wuquindex)=zwxing(wuquindex)&"【禄】"
case "庚" zwxing(wuquindex)=zwxing(wuquindex)&"【权】"
case "壬" zwxing(wuquindex)=zwxing(wuquindex)&"【忌】"
end select
zwxing((zwindex+7)mod 12)="天同"
select case ytg
   case "丙" zwxing((zwindex+7)mod 12)="天同【禄】"
   case "丁" zwxing((zwindex+7)mod 12)="天同【权】"
   case "庚" zwxing((zwindex+7)mod 12)="天同【科】"
  end select
zwxing((zwindex+4)mod 12)="廉贞"
select case ytg
            case "甲" zwxing((zwindex+4)mod 12)="廉贞【禄】"
			case  "丙" zwxing((zwindex+4)mod 12)="廉贞【忌】"
			end select
'天府八星
TfIndex=(12-zwindex)mod 12
tfxing(tfindex)="天府"

taiyinindex=(tfindex+1)mod 12
tfxing(taiyinindex)="太阴"
select case ytg
  case "丁"  tfxing(taiyinindex)=tfxing(taiyinindex)&"【禄】"
  case "庚"  tfxing(taiyinindex)=tfxing(taiyinindex)&"【忌】"
  case  "癸" tfxing(taiyinindex)=tfxing(taiyinindex)&"【科】"
  case  "戊" tfxing(taiyinindex)=tfxing(taiyinindex)&"【权】"
 end select

tanlangindex=(tfindex+2)mod 12
if minggindex=10 then
tfxing(tanlangindex)="贪狼（命主）"
else
tfxing(tanlangindex)="贪狼"
end if
select case ytg
case "戊"  tfxing(tanlangindex)= tfxing(tanlangindex)&"【禄】"
case "己" tfxing(tanlangindex)= tfxing(tanlangindex)&"【权】"
case "癸" tfxing(tanlangindex)= tfxing(tanlangindex)&"【忌】"
end select
jumenindex=(tfindex+3)mod 12
if minggindex=11 or minggindex=9 then
tfxing(jumenindex)="巨门(命主)"
else
tfxing(jumenindex)="巨门"
end if

select case ytg
    case "丁" tfxing(jumenindex)=tfxing(jumenindex)&"【忌】"
	case "辛" tfxing(jumenindex)=tfxing(jumenindex)&"【禄】"
	case "癸" tfxing(jumenindex)=tfxing(jumenindex)&"【权】"
	end select
tfxing((tfindex+4)mod 12)="天相"

tianliangindex=(tfindex+5)mod 12
if ytg="乙" then
tfxing(tianliangindex)="天梁【权】"
else
tfxing(tianliangindex)="天梁"
end if
tfxing((tfindex+6)mod 12)="七杀"
if minggindex=4 then
tfxing((tfindex+10)mod 12)="破军(命主)"
else
tfxing((tfindex+10)mod 12)="破军"
end if

select case ytg
case "甲" tfxing((tfindex+10)mod 12)=tfxing((tfindex+10)mod 12)&"【权】"
case "癸" tfxing((tfindex+10)mod 12)=tfxing((tfindex+10)mod 12)&"【禄】"
end select
%>
<%'文昌文曲，文昌逆数到生时，文曲顺数到生时
dim wenchang(11)
wenchang((12-hindex+10)mod 12)="文昌"
select case ytg
       case "丙" wenchang((12-hindex+10)mod 12)="文昌【科】"
	   case "辛" wenchang((12-hindex+10)mod 12)="文昌【忌】"
	   end select
if minggindex=1 or minggindex=7 then
wenchang((hindex+4)mod 12)="文曲(命主)"
else
wenchang((hindex+4)mod 12)="文曲"
end if

select case ytg
 case "己"  wenchang((hindex+4)mod 12)=wenchang((hindex+4)mod 12)&"【忌】"
 case  "辛"  wenchang((hindex+4)mod 12)=wenchang((hindex+4)mod 12)&"【科】"
	  end select
engindex=(12-hindex+10+d-2)mod 12 '恩光序号文昌顺数到生日，退后一步是恩光，文曲顺数到生日，退后一步天贵扬
tianguiindex=(((hindex+4)mod 12)+d-2)mod 12'天贵序号
djindex=(11+hindex)mod 12
tkindex=(11-hindex+12)mod 12
apindex=(hindex+6)mod 12 '台铺
hxindex=(hindex+8)mod 12 '诰乡
if wenchang(apindex)<>"" then
wenchang(apindex) =wenchang(apindex)&"台铺"
else
wenchang(apindex) ="台铺"
end if

if wenchang(hxindex)<>"" then
wenchang(hxindex) =wenchang(hxindex)&"诰乡"
else
wenchang(hxindex) ="诰乡"
end if
if wenchang(djindex)<>"" then '安地劫
wenchang(djindex)=wenchang(djindex)&"地劫"
else
wenchang(djindex)="地劫"
end if

if wenchang(tkindex)<>"" then '安天空劫
wenchang(tkindex)=wenchang(tkindex)&"天空劫"
else
wenchang(tkindex)="天空劫"
end if
%>
<%'火灵二星
dim huoling(11)
select case right(ygz,1)
       case "寅","午","戌" hxbg="丑卯"
	                       xiaoxian="辰"
	   case "申","子","辰"  hxbg="寅戌"
	                        xiaoxian="戌"
       case "亥","卯","未" hxbg="酉戌"
	                       xiaoxian="丑"
       case "巳","酉","丑" hxbg="卯戌"
	                      xiaoxian="未"
      ' case 再从始处来起子
      ' case 顺至生时是炎乡。
end select
hgindex=dzorder(left(hxbg,1)) '火星起宫
lgindex=dzorder(hxbg)    '灵星起宫	
hgindex=(hgindex+hindex-1)mod 12
lgindex=(lgindex+hindex-1)mod 12
huoling(hgindex)="火星"
huoling(lgindex)="铃星"

'起月系星星
zpindex=(4+m-1)mod 12  '左辅
youbiindex=(10-m+1+12)mod 12 '右弼
tianyindex=(m)mod 12
tianxindex=(9+m-1)mod 12
if huoling(zpindex)<>"" then
huoling(zpindex)=huoling(zpindex)&"左辅"
else
huoling(zpindex)="左辅"
end if
if ytg="壬" then
huoling(zpindex)=huoling(zpindex)&"【科】"
end if
if huoling(youbiindex)<>"" then
huoling(youbiindex)=huoling(youbiindex)&"右弼"
else
huoling(youbiindex)="右弼"
end if   '以上为作辅右臂
if ytg="戊" then
huoling(youbiindex)=huoling(youbiindex)&"【权】"
end if
if huoling(tianyindex)<>"" then
huoling(tianyindex)=huoling(tianyindex)&"天姚"
else
huoling(tianyindex)="天姚"
end if

if huoling(tianxindex)<>"" then
huoling(tianyindex)=huoling(tianxindex)&"天刑"
else
huoling(tianxindex)="天刑"
end if

select case m
       case 1,5,9  tianmindex=8
	               tianwindex=5
       case 7,11,3 tianmindex=2
	               tianwindex=2
       case 4,8,12 tianmindex=5
	               tianwindex=8
	   case 2,10,6 tianmindex=11
	                tianwindex=11
end select
if huoling(tianmindex)<>"" then
huoling(tianmindex)=huoling(tianmindex)&"天马"
else
huoling(tianmindex)="天马"
end if

if huoling(tianwindex)<>"" then
huoling(tianwindex)=huoling(tianwindex)&"天巫"
else
huoling(tianwindex)="天巫"
end if

select case m
        case 1,2 jieshenindex=8
        case 3,4 jieshenindex=10
		case 5,6 jieshenindex=0
		case 7,8 jieshenindex=2
		case 9,10 jieshenindex=4
		case 11,12 jieshenindex=6
end select

select case m
     case 1  tianyueindex=10
	          yinshaindex=2
	 case 2  tianyueindex=5
	          yinshaindex=0
	 case 3  tianyueindex=4
	          yinshaindex=10
	 case 4  tianyueindex=2
	          yinshaindex=8
	 case 5  tianyueindex=7
	          yinshaindex=6
	 case 6  tianyueindex=3
	          yinshaindex=4
	 case 7  tianyueindex=11
	          yinshaindex=2
	 case 8  tianyueindex=7
	          yinshaindex=0
	 case 9  tianyueindex=2
	          yinshaindex=10
	 case 10  tianyueindex=6
	          yinshaindex=8
	 case 11  tianyueindex=10
	          yinshaindex=6
	 case 12  tianyueindex=2
	          yinshaindex=4
end select 	

if huoling(jieshenindex)<>"" then
huoling(jieshenindex)=huoling(jieshenindex)&"解神"
else
huoling(jieshenindex)="解神"
end if

if huoling(tianyueindex)<>"" then
huoling(tianyueindex)=huoling(tianyueindex)&"天月"
else
huoling(tianyueindex)="天月"
end if
select case ytg
case "乙" huoling(tianyueindex)=huoling(tianyueindex)&"【忌】"
case "戊" huoling(tianyueindex)=huoling(tianyueindex)&"【权】"
end select
if huoling(yinshaindex)<>"" then
huoling(yinshaindex)=huoling(yinshaindex)&"阴煞"
else
huoling(yinshaindex)="阴煞"
end if

%>
<% '日系星星三台三台从左辅上起初一，顺行至本生日安之
 '八座从右弼上起初一，逆行至本生日安之
santindex=(zpindex+d-1)mod 12
bazuoindex=(youbiindex-((d-1) mod 12)+12)mod 12
if wenchang(santindex)<>"" then
wenchang(santindex)=wenchang(santindex)&"三台"
else
wenchang(santindex)="三台"
end if

if wenchang(bazuoindex)<>"" then
wenchang(bazuoindex)=wenchang(bazuoindex)&"八座"
else
wenchang(bazuoindex)="八座"
end if

if wenchang(engindex)<>"" then
wenchang(engindex)=wenchang(engindex)&"恩光"
else
wenchang(engindex)="恩光"
end if

if wenchang(tianguiindex)<>"" then
wenchang(tianguiindex)=wenchang(tianguiindex)&"天贵"
else
wenchang(tianguiindex)="天贵"
end if
%>

<%'干系星星 甲寅乙卯丙禄巳，丁己午兮禄所至，庚禄居申辛禄酉，壬禄在亥癸禄子
select case left(ygz,1)
   case  "甲"  luncun="寅"
   case  "乙"  luncun="卯"
   case  "丙"  luncun="巳"
   case  "丁","己" luncun="午"
   case  "庚" luncun="申"
   case  "辛" luncun="酉"
   case  "壬" luncun="亥"
   case  "癸" luncun="子"
   case  "戊"  luncun="丑"
 end select
 lcindex=dzorder(luncun)-1
 lcindex=(lcindex+10)mod 12
 qingyindex=(lcindex+1)mod 12
 tuoluoindex=(lcindex+11)mod 12
 if minggindex=0 or minggindex=8 then
 mingzhu="禄存(命主)"
 else
 mingzhu="禄存"
 end if
 if zwxing(lcindex)<>"" then
zwxing(lcindex)=zwxing(lcindex)&""&mingzhu
else
zwxing(lcindex)=mingzhu
end if

 if zwxing(tuoluoindex)<>"" then
zwxing(tuoluoindex)=zwxing(tuoluoindex)&"陀罗"
else
zwxing(tuoluoindex)="陀罗"
end if

 if zwxing(qingyindex)<>"" then
zwxing(qingyindex)=zwxing(qingyindex)&"擎羊"
else
zwxing(qingyindex)="擎羊"
end if

select case left(ygz,1)
 case  "甲","戊","庚"       tiankui="丑"
							 tianji="未"
							
	   case  "乙","己"
	                         tiankui="子"
							
							 tianji="申"
							 '寅申乡
	   case  "丙","丁"
	                         tiankui="亥"
							
							 tianji="酉"
							'"巳"酉
	   case  "壬","癸"
	                         tiankui="卯"
							
							 tianji="巳"
							 '巳亥
	   case  "辛"
	                         tiankui="午"
							
							 tianji="寅"
							'午虎

 end select
 tiankuiindex=dzorder(tiankui)-1
 tianjiindex=dzorder(tianji)-1
 tiankuiindex=(tiankuiindex+10)mod 12
 tianjiindex=(tianjiindex+10)mod 12
 'response.Write(tiankui&tianji)
  if zwxing(tiankuiindex)<>"" then
zwxing(tiankuiindex)=zwxing(tiankuiindex)&"天魁"
else
zwxing(tiankuiindex)="天魁"
end if

  if zwxing(tianjiindex)<>"" then
zwxing(tianjiindex)=zwxing(tianjiindex)&"天钺"
else
zwxing(tianjiindex)="天钺"
end if

select case left(ygz,1)
 case "甲"  tianguan=7
            tianfu=9
 case "乙"  tianguan=4
            tianfu=8
 case "丙"  tianguan=5
            tianfu=0
 case "丁"  tianguan=2
            tianfu=11
 case "戊"  tianguan=3
            tianfu=3
 case "己"  tianguan=9
            tianfu=2
 case "庚"  tianguan=11
            tianfu=6
 case "辛" tianguan=7
            tianfu=5
 case "壬" tianguan=10
            tianfu=6
 case "癸" tianguan=6
            tianfu=5
end select
tianfuindex=(tianfu+10)mod 12
tianguanindex=(tianguan+10)mod 12

  if zwxing(tianfuindex)<>"" then
zwxing(tianfuindex)=zwxing(tianfuindex)&"天福"
else
zwxing(tianfuindex)="天福"
end if

 if zwxing(tianguanindex)<>"" then
zwxing(tianguanindex)=zwxing(tianguanindex)&"天官"
else
zwxing(tianguanindex)="天官"
end if


%>
<%dim boshis(11)  '12博士
'response.Write(orders)
if orders then
for i=0 to 11
boshis((lcindex+2+i)mod 12)=boshi(i)
next
else
for i=0 to 11
boshis((lcindex+14-i)mod 12)=boshi(i)
next
end if
ydzorder=dzorder(ygz)
tianxuindex=(6+ydzorder-1)mod 12
tiankuindex=(19-ydzorder)mod 12
longciindex=(4+ydzorder-1)mod 12
fenggeindex=(15-ydzindex)mod 12
hongluanindex=(16-ydzorder)mod 12
tianxiindex=(hongluanindex+6)mod 12
boshis(tianxuindex)=boshis(tianxuindex)&"天虚"
boshis(tiankuindex)=boshis(tiankuindex)&"天哭"
boshis(longciindex)=boshis(longciindex)&"龙池"
boshis(fenggeindex)=boshis(fenggeindex)&"凤阁"
boshis(hongluanindex)=boshis(hongluanindex)&"红鸾"
boshis(tianxiindex)=boshis(tianxiindex)&"天喜"

'response.write boshis(hongluanindex)&hongluanindex
select case right(ygz,1)
       case  "寅","卯","辰"  guchen="巳"
	                         guaxiu="丑"
	   case  "巳","午","未" guchen="申"
	                          guaxiu="辰"
       case  "申","酉","戌"  guaxiu="亥"
	                         guchen="未"
	   case  "亥","子","丑"  guchen="寅"
	                         guaxiu="戌"


end select	
guchenindex=dzorder(guchen)-1
guaxiuindex=dzorder(guaxiu)-1
boshis(guchenindex)=boshis(guchenindex)&"孤辰"
boshis(guaxiuindex)=boshis(guaxiuindex)&"寡宿"
ygzorders=dzorder(ygz)
'select case  (ygzorder-1)mod 3
  ' case 0   beilianindex=(21-ygzorder)mod 12
  ' case 1    beilianindex=(23-ygzorder)mod 12
   'case 2   beilianindex=(25-ygzorder)mod 12
'end select
beilianindex=(ygzorders+8)mod 12
select case right(ygz,1)
case  "子","午","卯","酉" poshui="巳"
case  "寅","申","巳","亥" poshui="酉"
case  "辰","戌","丑","未" poshui="丑"
end select
poshuiindex=dzorder(poshui)-1
boshis(poshuiindex)=boshis(poshuiindex)&"破碎"
boshis(beilianindex)=boshis(beilianindex)&"蜚廉"
tiancaiindex=(((minggindex+2)mod 12)+ydzorder-1)mod 12
tianshouindex=(((shengindex+2)mod 12)+ydzorder-1)mod 12
boshis(tiancaiindex)=boshis(tiancaiindex)&"天才"
boshis(tianshouindex)=boshis(tianshouindex)&"天寿"

%>

 <%select case wxju
    case "水二局" changsh="申"
	case "木三局" changsh="亥"
	case "金四局" changsh="巳"
    case   "土五局" changsh="申"
	case "火六局" changsh="寅"
 end select
changshindex=dzorder(changsh)-1
if orders then
for i=0 to 11
dptg((i+changshindex)mod 12)=changsheng(i)&""&dptg((i+changshindex)mod 12)
next
else
for i=0 to 11
dptg((changshindex-i+12)mod 12)=changsheng(i)&""&dptg((changshindex-i+12)mod 12)
next
end if
%>

<%select case left(ygz,1)

  case "甲","己" jiekong="申酉"
  case "乙","庚" jiekong="午未"
  case "丙","辛" jiekong="辰巳"
  case "丁","壬" jiekong="寅卯"
  case "戊","癸" jiekong="子丑"
  end select
jieluindex=dzorder(left(jiekong,1))-1
kongmangindex=dzorder(jiekong)-1
if wenchang(jieluindex)<>"" then
wenchang(jieluindex)=wenchang(jieluindex)&"截路空亡"
else
wenchang(jieluindex)="截路"
end if

if wenchang(kongmangindex)<>"" then
wenchang(kongmangindex)=wenchang(kongmangindex)&"空亡"
else
wenchang(kongmangindex)="空亡"
end if
%>
<%call xunkong(ygz,xk,xunshou)
select case xunshou
      case "甲子"  xunzhong="戌亥"
	  case "甲戌"  xunzhong="申酉"
	  case "甲申"  xunzhong="午未"
      case "甲午"  xunzhong="辰巳"
	  case "甲辰"  xunzhong="寅卯"
	  case "甲寅"  xunzhong="子丑"
end select	

xunzhongindex=dzorder(left(xunzhong,1))-1
kongwangindex=dzorder(xunzhong)-1

if wenchang(xunzhongindex)<>"" then
wenchang(xunzhongindex)=wenchang(xunzhongindex)&"旬中"
else
wenchang(xunzhongindex)="旬中"
end if

if wenchang(kongwangindex)<>"" then
wenchang(kongwangindex)=wenchang(kongwangindex)&"空亡"
else
wenchang(kongwangindex)="空亡"
end if
%>

<%'起大限
xushuig=(minggindex+2)mod 12
xushui=jindex-1
if orders then
for i=0 to 11
xushui=xushui+1
dptg((i+xushuig)mod 12)=xushui&"－"&(xushui+9)&""&dptg((i+xushuig)mod 12)
xushui=xushui+9
next
else
for i=0 to 11
xushui=xushui+1
dptg((xushuig-i+12)mod 12)=xushui&"－"&(xushui+9)&""&dptg((xushuig-i+12)mod 12)
xushui=xushui+9
next
end if
%>

<%


%>

<%'流年星
dim lyxing(11)
select case right(ygz,1)
      case "寅","午","戌" liunian="午"
	  case "申","子","辰" liunian="子"
	  case "巳","酉","丑" liunian="酉"
	  case "亥","卯","未" liunian="卯"
end select
startly=dzorder(liunian)-1
for i=0 to 11
lyxing((startly+i)mod 12)=liunianxing2(i)
next
%>

<%'起小限
xiaoxianindex=dzorder(xiaoxian)-1
if sex then
for i=0 to 11
lyxing((xiaoxianindex+i)mod 12)=lyxing((xiaoxianindex+i)mod 12)&"【"&(i+1)&string(2-len(i+1)," ")&"】"
next
else
for i=0 to 11
lyxing((xiaoxianindex+i)mod 12)=lyxing((xiaoxianindex+i)mod 12)&"【"&(i+1)&string(2-len(i+1)," ")&"】"
next

end if
%>

<%'太岁一年一替换，岁前首先是晦气，

'丧门贯索及官符，小耗大耗龙德继，

'白虎天德连吊客，病符居后须当记
for i=0 to 11
lyxing((ydzorder-1+i)mod 12)=lyxing((ydzorder-1+i)mod 12)&liunianxing(i)
next
'斗君】
ydzorder=dzorder(ygz)-1
'response.Write(m&"<Br>")
''response.Write(hindex&"<Br>")
'response.Write(ydzorder&"<Br>")
doujunindex=(((ydzorder-m+12)mod 12)+hindex)mod 12
'doujungong=dz(doujunindex)
'response.write doujunindex&"<Br>"
%>

<%set fo=server.CreateObject("scripting.filesystemobject")
path=server.MapPath("temp")
path=path&"/mpx.txt"
ii=ydzorder+1
for i=0 to 11
set fn=fo.opentextfile(path)
while not fn.atendofstream
str=fn.readline
strarr=split(str,",")
'response.Write(replace("dd巨门",strarr(1),strarr(1)&strarr(ii)))
tfxing(i)=replace(tfxing(i),strarr(1),strarr(1)&strarr(ii))
zwxing(i)=replace(zwxing(i),strarr(1),strarr(1)&strarr(ii))
wenchang(i)=replace(wenchang(i),strarr(1),strarr(1)&strarr(ii))
huoling(i)=replace(huoling(i),strarr(1),strarr(1)&strarr(ii))
boshis(i)=replace(boshis(i),strarr(1),strarr(1)&strarr(ii))
minggong(i)=replace(minggong(i),strarr(1),strarr(1)&strarr(ii))
wend
fn.close
next%>
<%

for i=0 to 11
zwxing(i)=zwxing(i)&string(20-lenb(zwxing(i)),"-")
tfxing(i)=tfxing(i)&string(20-lenb(tfxing(i)),"-")
wenchang(i)=wenchang(i)&string(abs(20-lenb(wenchang(i))),"-")
boshis(i)=boshis(i)&string(20-lenb(boshis(i)),"-")
minggong(i)=minggong(i)&string(20-lenb(minggong(i)),"-")
huoling(i)=huoling(i)&string(20-lenb(huoling(i)),"-")
lyxing(i)=lyxing(i)&string(22-lenb(lyxing(i)),"-")
'response.write len(wenchang(i))&"<br>"
next
%><table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" id="paipanTable">
    <tbody>
      <tr>
        <td class="ttop">紫微斗数在线排盘系统</td>
      </tr>
      <tr>
        <td class="new">
　　
  <table width="90%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor=#0EA7F1>
    <tr>
      <td width="25%" bgcolor="#FFFFFF"><%=zwxing(3)%></font>　</td>
      <td width="25%" bgcolor="#FFFFFF"><%=zwxing(4)%></font>　</td>
      <td width="25%" bgcolor="#FFFFFF"><%=zwxing(5)%></font>　</td>
      <td width="25%" bgcolor="#FFFFFF"><%=zwxing(6)%></font>　</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><%=tfxing(3)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=tfxing(4)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=tfxing(5)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=tfxing(6)%></font>　</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><%=wenchang(5)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=wenchang(6)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=wenchang(7)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=wenchang(8)%></font>　</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><%=huoling(5)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=huoling(6)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=huoling(7)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=huoling(8)%></font>　</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><%=minggong(3)&shengong(3)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=minggong(4)&shengong(4)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=minggong(5)&shengong(5)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=minggong(6)&shengong(6)%></font>　</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><%=boshis(5)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=boshis(6)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=boshis(7)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=boshis(8)%></font>　</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><%=DpTg(5)%>巳</font></td>
      <td bgcolor="#FFFFFF"><%=DpTg(6)%>午</font></td>
      <td bgcolor="#FFFFFF"><%=DpTg(7)%>未</font></td>
      <td bgcolor="#FFFFFF"><%=DpTg(8)%>申</font></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><%=lyxing(5)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=lyxing(6)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=lyxing(7)%></font>　</td>
      <td bgcolor="#FFFFFF"><%=lyxing(8)%></font>　</td>
    </tr>
  </table>  </td>
      </tr>
      <tr>
        <td class="new"><table width="90%" align="center" cellpadding="5" cellspacing="1" bgcolor=#C98B30>
          <tr>
            <td width="25%" bgcolor="#FFFFFF"><%=zwxing(2)%></font>　</td>
            <td bgcolor="#FFFFFF">................</font>........................</font></td>
            <td width="25%" bgcolor="#FFFFFF"><%=zwxing(7)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=tfxing(2)%></font>　</td>
            <td bgcolor="#FFFFFF">....<a target="_blank" href="pp"><font color=aaaaaa></font></a>.......</td>
            <td bgcolor="#FFFFFF"><%=tfxing(7)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=wenchang(4)%></font>　</td>
            <td bgcolor="#FFFFFF"> <strong>性别</strong>：
              <%if sex=1 then
	response.Write("男")
	else
	response.Write("女")
	end if%></td>
            <td bgcolor="#FFFFFF"><%=wenchang(9)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=huoling(4)%></font>　</td>
            <td bgcolor="#FFFFFF"><strong>阴历：</strong><%=NongLi%></font> <font color="#FF0000"><%=wxju%></font></font></td>
            <td bgcolor="#FFFFFF"><%=huoling(9)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=minggong(2)&shengong(2)%></font>　</td>
            <td bgcolor="#FFFFFF"><strong><font color="#000000"><%=YGZ%>--<%=MGZ%>--<%=DGZ%>--<%=TGZ%></font></strong></font><font color="#000000"><strong></font></font></td>
            <td bgcolor="#FFFFFF"><%=minggong(7)&shengong(7)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=boshis(4)%></font>　</td>
            <td bgcolor="#FFFFFF"><strong>子年斗君：</strong><%=dz(doujunindex)%>..........................</font></td>
            <td bgcolor="#FFFFFF"><%=boshis(9)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=DpTg(4)%>辰</font></td>
            <td bgcolor="#FFFFFF">&nbsp;</font>................</font>........................</font></td>
            <td bgcolor="#FFFFFF"><%=DpTg(9)%>酉</font></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=lyxing(4)%></font>　</td>
            <td bgcolor="#FFFFFF">................</font>........................</font></td>
            <td bgcolor="#FFFFFF"><%=lyxing(9)%></font>　</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="new"><table width="90%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor=#C20385>
          <tr>
            <td width="25%" bgcolor="#FFFFFF"><%=zwxing(1)%></font>　</td>
            <td bgcolor="#FFFFFF">&nbsp;</font>................</font>........................</font></td>
            <td width="25%" bgcolor="#FFFFFF"><%=zwxing(8)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=tfxing(1)%></font>　</td>
            <td bgcolor="#FFFFFF">&nbsp;</font>................</font>........................</font></td>
            <td bgcolor="#FFFFFF"><%=tfxing(8)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=wenchang(3)%></font>　</td>
            <td bgcolor="#FFFFFF">&nbsp;</font>................</font>........................</font></td>
            <td bgcolor="#FFFFFF"><%=wenchang(10)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=huoling(3)%></font>　</td>
            <td bgcolor="#FFFFFF">....<a target="_blank" href="pp"><font color=aaaaaa></font></a>.......</td>
            <td bgcolor="#FFFFFF"><%=huoling(10)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=minggong(1)&shengong(1)%></font>　</td>
            <td bgcolor="#FFFFFF">&nbsp;</font>................</font>........................</font></td>
            <td bgcolor="#FFFFFF"><%=minggong(8)&shengong(8)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=boshis(3)%></font>　</td>
            <td bgcolor="#FFFFFF">&nbsp;</font>................</font>........................</font></td>
            <td bgcolor="#FFFFFF"><%=boshis(10)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=DpTg(3)%>卯</font></td>
            <td bgcolor="#FFFFFF">&nbsp;</font>................</font>........................</font></td>
            <td bgcolor="#FFFFFF"><%=DpTg(10)%>戌</font></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=lyxing(3)%></font>　</td>
            <td bgcolor="#FFFFFF">................</font>........................</font></td>
            <td bgcolor="#FFFFFF"><%=lyxing(10)%></font>　</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="new"><table width="90%" height="30" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor=#7B5851>
          <tr>
            <td width="25%" bgcolor="#FFFFFF"><%=zwxing(0)%></font>　</td>
            <td width="25%" bgcolor="#FFFFFF"><%=zwxing(11)%></font>　</td>
            <td width="25%" bgcolor="#FFFFFF"><%=zwxing(10)%></font>　</td>
            <td width="25%" bgcolor="#FFFFFF"><%=zwxing(9)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=tfxing(0)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=tfxing(11)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=tfxing(10)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=tfxing(9)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=wenchang(2)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=wenchang(1)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=wenchang(0)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=wenchang(11)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=huoling(2)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=huoling(1)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=huoling(0)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=huoling(11)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=minggong(0)&shengong(0)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=minggong(11)&shengong(11)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=minggong(10)&shengong(10)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=minggong(9)&shengong(9)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=boshis(2)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=boshis(1)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=boshis(0)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=boshis(11)%></font>　</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=DpTg(2)%>寅</font></td>
            <td bgcolor="#FFFFFF"><%=DpTg(1)%>丑</font></td>
            <td bgcolor="#FFFFFF"><%=DpTg(0)%>子</font></td>
            <td bgcolor="#FFFFFF"><%=DpTg(11)%>亥</font></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><%=lyxing(2)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=lyxing(1)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=lyxing(0)%></font>　</td>
            <td bgcolor="#FFFFFF"><%=lyxing(11)%></font>　</td>
          </tr>
        </table></td>
      </tr>
    </table>
<%else%>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" >
<tbody><form name="form1"  onsubmit="return submitchecken();" method="post" action="">
<input type="hidden" name="act" value="ok" /><tr>
  <td width="100%" class="ttop">紫微斗数在线排盘系统</td>
    </tr>

  <tr>
<td align="center" class="new">公历生日： 
      <input name="DateType" type="hidden" value="1"> <input name="data_month_other" type="hidden" value="0">
	  <input type="hidden" name="liunian" value="2007">
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

<tr>
<td align="center" class="new">性别:
  <input name="sex" type="radio" value="1" checked>
男
<input type="radio" name="sex" value="0">
女 盘类：<input type="radio" value="1" name="mode" checked="" />天盘
<input type="radio" value="2" name="mode" disabled="" />人盘
<input type="radio" value="3" name="mode" disabled="" />地盘
<input type="radio" value="4" name="mode" />
限流盘</td>
</tr>  <tr>
<td align="center" class="new"><input type="submit" value="紫微斗数在线排盘" name="submit" style="cursor:hand;" /> </td>
</tr>
</form>
</table>
  <%end if%>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" >
    <tbody>
   
      <tr>
        <td width="100%" class="ttop">紫微斗数在线排盘系统
</td>
      </tr>
      <tr>
        <td class="new"><p>紫微斗数，是中国传统命理学的最重要的支派之一。她是以人出生的年、月、日、时确定十二宫的位置，构成命盘，结合各宫的星群组合，牵系周易卦爻，来预测一个人的名员流程、吉凶祸福的。<BR>
            <BR>
            相对于四柱推命而言，其渊源较早，而又是同源而分流,故并称为中国传统命理学的两大派别；而且紫微斗数推命术既具有道家宇宙观的神秘色彩，又具有注重社会环境、人际关系的近代意蕴，在中国神秘文化中卓立特出，名列“五大神数”之首，号称“天下第一神数”。<BR>
            <BR>
            紫微斗数推命的出发点依然时天人合一的观念和阴阳五<A href="/view/148051.htm" target="_blank">行</A>的学说，但她在一般推命术的推算程序的基础上，以处于北天中央正宫的紫微垣中诸吉、凶、化星的尊卑位置特点及地球面对他们向背运动的规律，赋予不同的命理意义，以推知人的命运，因而具有自己的方法和特点。<BR>
            <BR>
            紫微斗数推命术的基本方法时以一个人的出生年、月、日、时定出其命宫所在，依此推断其终生的地位、人格、贫富、休咎，然后依次列出兄弟宫、夫妻宫、子女宫、财帛宫、疾厄宫、迁移宫、交友宫、事业宫、田宅宫、福德宫、父母宫，作出生图；从而观察各宫位的星群组合，推知其斗数命理；最后再通过<strong>四化星</strong>（化科、化禄、化权、化忌）的牵引，注意各种变化的轨迹。<BR>
            <BR>
            紫微斗数的明显特点是：<BR>
            <BR>
            １、可将人的命运凶吉、贵贱休咎作出具体的说明，而非抽象的把握。<BR>
            <BR>
            ２、紫微斗数通过命盘十二宫，系统而全面的预测一个人一生的错综复杂的社会关系和个人遭遇，逻辑体系严密，既相对容易、程式化，又变化演绎，又较高的数理性和深刻性。<BR>
            <BR>
            正因为如此，这种预测方法并非江湖上目不识丁的卜者或盲者可以掐指推算、信口开河的，在民间不如<strong>四柱</strong>流行，反过来讲，也正因为如此，紫微斗数才少了点庸俗性、玄虚性、迷信性，伴随着世界性的“易经热”、“命理热”、“信息预测热”的不断形成高潮，在现代文明程度较高的台、港、东南亚等地蔚然成风。<BR>
            <BR>
            源流： <BR>
            <BR>
            紫微斗数据传说大约是在北宋时期，由道家的一位重要人物陈抟（陈希夷）所发明。紫微斗数的前身是“十八飞星”，斗数略晚于五星术产生，大约与子平术（八字、四柱）同时，曾受到印度占星术的影响。历代研究斗数的著作相比大大少于八字，因此斗数源流和传承的情况，由于资料的缺乏而不太清晰。 <BR>
            <BR>
            典籍： <BR>
            <BR>
            由于斗数不如八字公开，研究斗数的人相对较少，留下的著作就更少。目前较为流行的斗数典籍是大约200年前的《斗数全书》与《斗数全集》，还有一些著名的赋文，如《太微赋》、《骨髓赋》等等。在一些港台现代人的斗数著作中，比较系统和规范的是民国时期陆斌兆的《紫微斗数讲义》、张开卷的《紫微斗数》和上个世纪90年代王亭之的《中州派紫微斗数》。紫微斗数在大陆一段时间以内由于各种原因曾经有过研究断层，随着改革开放的进行，一些港台术数家的斗数著作流入了大陆，极大的促进了大陆的紫微斗数研究的发展。 <BR>
        </p>
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
