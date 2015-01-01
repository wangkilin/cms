<?php
global $yearlast;
global $day60;
$a = array();
$nlsc = array();
$sczy = array();
$scsy = array();
$jz = array();
$dayname = array();
$MonName = array();
global $rn;


//十天干;
$a[21] = "甲";
$a[22] = "乙";
$a[23] = "丙";
$a[24] = "丁";
$a[25] = "戊";
$a[26] = "己";
$a[27] = "庚";
$a[28] = "辛";
$a[29] = "壬";
$a[20] = "癸";

//十二地支
$a[31] = "子";
$a[32] = "丑";
$a[33] = "寅";
$a[34] = "卯";
$a[35] = "辰";
$a[36] = "巳";
$a[37] = "午";
$a[38] = "未";
$a[39] = "申";
$a[40] = "酉";
$a[41] = "戌";
$a[30] = "亥";

//到此，完成了农历向阳历的转换
$bzyear=$nian1;
$bzmonth=$yue1;
$bzday=$ri1;
$bztime=$hh1;


//确定节气 yz 月支  起运基数 qyjs
$md=$bzmonth * 100 + $bzday;
if($md>=204 and $md<= 305){
$mz = 3;
$qyjs = (($bzmonth - 2) * 30 + $bzday - 4) /3;
}

if($md>=306 and $md<=404){
$mz = 4;
$qyjs = (($bzmonth - 3) * 30 + $bzday - 6) /3;
}

if($md>=405 and $md<= 504){
$mz = 5;
$qyjs = (($bzmonth - 4) * 30 + $bzday - 5) /3;
}

if($md>=505 and $md<=  605){
$mz = 6;
$qyjs = (($bzmonth - 5) * 30 + $bzday - 5) /3;
}

if($md>=606 and $md<= 706){
$mz = 7;
$qyjs = (($bzmonth - 6) * 30 + $bzday - 6) /3;
}

if($md>=707 and $md<= 807){
$mz = 8;
$qyjs = (($bzmonth - 7) * 30 + $bzday - 7) /3;
}

if($md>=808 and $md<=907){
$mz = 9;
$qyjs = (($bzmonth - 8) * 30 + $bzday - 8) /3;
}

if($md>=908 and $md<=1007){
$mz = 10;
$qyjs = (($bzmonth - 9) * 30 + $bzday - 8) /3;
}

if($md>=1008 and $md<= 1106){
$mz = 11;
$qyjs = (($bzmonth - 10) * 30 + $bzday - 8) /3;
}

if($md>=1107 and $md<=  1207){
$mz = 0;
$qyjs = (($bzmonth - 11) * 30 + $bzday - 7) /3;
}

if($md>=1208 and $md<=  1231){
$mz = 1;
$qyjs = ($bzday - 8) /3;
}

if($md>=101 and $md<= 105){
$mz = 1;
$qyjs = (30 + $bzday - 4) /3;
}

if($md>=106 and $md<=  203){
$mz = 2;
$qyjs = (($bzmonth - 1) * 30 + $bzday - 6) /3;
}

//确定年干和年支 yg 年干 yz 年支
if($md>=204 and $md<=1231){
$yg = ($bzyear - 3) % 10;
$yz = ($bzyear - 3) % 12;
}
if($md>=101 and $md<=203 ){
$yg = ($bzyear - 4) % 10;
$yz = ($bzyear - 4) % 12;
}

//确定月干 $mg 月干

If ($mz > 2 And $mz <= 11){

$mg = ($yg * 2 + $mz + 8) % 10;
} else {
$mg = ($yg * 2 + $mz) % 10;
}

//从公元0年到目前年份的天数 yearlast

$yearlast = ($bzyear - 1) * 5 + ($bzyear - 1) / 4 - ($bzyear - 1) / 100 + ($bzyear - 1) / 400;
//计算某月某日与当年1月0日的时间差（以日为单位）yearday
$yearday = 0;
for ($i = 1; $i<$bzmonth; $i++) {
    if(in_array($i, array( 1, 3, 5, 7, 8, 10, 12))) {
		$yearday = $yearday + 31;
	} elseif (in_array($i, array(4, 6, 9, 11))) {
		$yearday = $yearday + 30;
	} else {
		if ($bzyear % 4 == 0 And (($bzyear % 100) <> 0) Or $bzyear % 400 == 0) {
			$yearday = $yearday + 29;
		} else {
			$yearday = $yearday + 28;
		}
	}
}
$yearday = $yearday + $bzday;

//计算日的六十甲子数 day60
$day60 = ($yearlast + $yearday + 6015) % 60;

//确定 日干 dg  日支  dz
$dg = $day60 % 10;
$dz = $day60 % 12;
//确定 时干 tg 时支 tz
$tz = ($bztime + 3) / 2 % 12;
//'tg = (dg * 2 + tz + 8) % 10
if ($tz == 0){
$tg = ($dg * 2 + $tz) % 10;
} else {
$tg = ($dg * 2 + $tz + 8) % 10;
}

//'把 年月日时 转换成为 生辰八字
switch($yz) {
Case 1:
$yzg = 0;
break;
Case 2:
case 8:
$yzg = 6;
break;
Case 3:
$yzg = 1;
break;
Case 4:
$yzg = 2;
break;
Case 5:
case 11:
$yzg = 5;
break;
Case 6:
$yzg = 3;
break;
Case 7:
$yzg = 4;
break;
Case 9:
$yzg = 7;
break;
Case 10:
$yzg = 8;
break;
Case 0:
$yzg = 9;
break;
}

//'月支纳干 $mzg
switch($mz){
Case 1:
$mzg = 0;
break;
Case 2:
case 8:
$mzg = 6;
break;
Case 3:
$mzg = 1;
break;
Case 4:
$mzg = 2;
break;
Case 5:
case 11:
$mzg = 5;
break;
Case 6:
$mzg = 3;
break;
Case 7:
$mzg = 4;
break;
Case 9:
$mzg = 7;
break;
Case 10:
$mzg = 8;
break;
Case 0:
$mzg = 9;
break;
}

//'日支纳干 dzg

switch($dz) {
case 1:
$dzg = 0;
break;
case 2:
case 8:
$dzg = 6;
break;
case 3:
$dzg = 1;
break;
case 4:
$dzg = 2;
break;
case 5:
case 11:
$dzg = 5;
break;
case 6:
$dzg = 3;
break;
case 7:
$dzg = 4;
break;
case 9:
$dzg = 7;
break;
case 10:
$dzg = 8;
break;
case 0:
$dzg = 9;
}

//'时支纳干 tzg
switch($tz) {
case 1:
$tzg = 0;
break;
case 2:
case 8:
$tzg = 6;
break;
case 3:
$tzg = 1;
break;
case 4:
$tzg = 2;
break;
case 5:
case 11:
$tzg = 5;
break;
case 6:
$tzg = 3;
break;
case 7:
$tzg = 4;
break;
case 9:
$tzg = 7;
break;
case 10:
$tzg = 8;
break;
case 0:
$tzg = 9;
}

//'到此，完成各地支所纳天干的确定任务
$yg1=$a[20 + $yg];
$yz1=$a[30 + $yz];
$mg1=$a[20 + $mg];
$mz1=$a[30 + $mz];
$dg1=$a[20 + $dg];
$dz1=$a[30 + $dz];
$tg1=$a[20 + $tg];
$tz1=$a[30 + $tz];
$ygz=$a[20 + $yg] . $a[30 + $yz];
$mgz=$a[20 + $mg] . $a[30 + $mz];
$dgz=$a[20 + $dg] . $a[30 + $dz];
$tgz=$a[20 + $tg] . $a[30 + $tz];

//'八字配对一
$bzy1=$nly1;
$bzm1=$nlm1;
$bzd1=$nld1;
$bzh1=$h1;

//'确定节气 $yzn1 月支  起运基数 $qyjsn1
$mdn1=$bzm1 * 100 + $bzd1;
if($mdn1>=204 and $mdn1<= 305){
$mzn1 = 3;
$qyjsn1 = (($bzm1 - 2) * 30 + $bzd1 - 4) /3;
}

if($mdn1>=306 and $mdn1<=404){
$mzn1 = 4;
$qyjsn1 = (($bzm1 - 3) * 30 + $bzd1 - 6) /3;
}

if($mdn1>=405 and $mdn1<= 504){
$mzn1 = 5;
$qyjsn1 = (($bzm1 - 4) * 30 + $bzd1 - 5) /3;
}

if($mdn1>=505 and $mdn1<=  605){
$mzn1 = 6;
$qyjsn1 = (($bzm1 - 5) * 30 + $bzd1 - 5) /3;
}

if($mdn1>=606 and $mdn1<= 706){
$mzn1 = 7;
$qyjsn1 = (($bzm1 - 6) * 30 + $bzd1 - 6) /3;
}

if($mdn1>=707 and $mdn1<= 807){
$mzn1 = 8;
$qyjsn1 = (($bzm1 - 7) * 30 + $bzd1 - 7) /3;
}

if($mdn1>=808 and $mdn1<=907){
$mzn1 = 9;
$qyjsn1 = (($bzm1 - 8) * 30 + $bzd1 - 8) /3;
}

if($mdn1>=908 and $mdn1<=1007){
$mzn1 = 10;
$qyjsn1 = (($bzm1 - 9) * 30 + $bzd1 - 8) /3;
}

if($mdn1>=1008 and $mdn1<= 1106){
$mzn1 = 11;
$qyjsn1 = (($bzm1 - 10) * 30 + $bzd1 - 8) /3;
}

if($mdn1>=1107 and $mdn1<=  1207){
$mzn1 = 0;
$qyjsn1 = (($bzm1 - 11) * 30 + $bzd1 - 7) /3;
}

if($mdn1>=1208 and $mdn1<=  1231){
$mzn1 = 1;
$qyjsn1 = ($bzd1 - 8) /3;
}

if($mdn1>=101 and $mdn1<= 105){
$mzn1 = 1;
$qyjsn1 = (30 + $bzd1 - 4) /3;
}

if($mdn1>=106 and $mdn1<=  203){
$mzn1 = 2;
$qyjsn1 = (($bzm1 - 1) * 30 + $bzd1 - 6) /3;
}

//'确定年干和年支 $ygn1 年干 $yzn1 年支
if($mdn1>=204 and $mdn1<=1231){
$ygn1 = ($bzy1 - 3) % 10;
$yzn1 = ($bzy1 - 3) % 12;
}
if($mdn1>=101 and $mdn1<=203 ){
$ygn1 = ($bzy1 - 4) % 10;
$yzn1 = ($bzy1 - 4) % 12;
}

//'确定月干 $mgn1 月干

if ($mzn1 > 2 And $mzn1 <= 11){

$mgn1 = ($ygn1 * 2 + $mzn1 + 8) % 10;
} else{
$mgn1 = ($ygn1 * 2 + $mzn1) % 10;
}

//'从公元0年到目前年份的天数 $yearlast

$yearlast = intval(($bzy1 - 1) * 5 + ($bzy1 - 1) / 4 - ($bzy1 - 1) / 100 + ($bzy1 - 1) / 400);
//'计算某月某日与当年1月0日的时间差（以日为单位）$yearday

for( $i = 1; $i<$bzm1; $i++) {
    if(in_array($i, array(1, 3, 5, 7, 8, 10, 12))) {
		$yearday = $yearday + 31;
	} elseif (in_array($i, array(4, 6, 9, 11))) {
		$yearday = $yearday + 30;
	} else {
		if ($bzy1 % 4 == 0 And (($bzy1 % 100) <> 0) Or $bzy1 % 400 == 0) {
			$yearday = $yearday + 29;
		} else {
			$yearday = $yearday + 28;
		}
	}
}

$yearday = $yearday + $bzd1;

//'计算日的六十甲子数 day60
$day60 = ($yearlast + $yearday + 6015) % 60;

//'确定 日干 dgn1  日支  dzn1
$dgn1 = $day60 % 10;
$dzn1 = $day60 % 12;
//'确定 时干 tgn1 时支 tzn1
$tzn1 = intval(($bzh1 + 3) / 2) % 12;

//'tgn1 = (dgn1 * 2 + tzn1 + 8) % 10
if ($tzn1 == 0){
$tgn1 = ($dgn1 * 2 + $tzn1) % 10;
} else {
$tgn1 = ($dgn1 * 2 + $tzn1 + 8) % 10;
}

//'把 年月日时 转换成为 生辰八字

switch($yzn1) {
case 1:
$yzgn1 = 0;
break;
case 2:
case 8:
$yzgn1 = 6;
break;
case 3:
$yzgn1 = 1;
break;
case 4:
$yzgn1 = 2;
break;
case 5:
case 11:
$yzgn1 = 5;
break;
case 6:
$yzgn1 = 3;
break;
case 7:
$yzgn1 = 4;
break;
case 9:
$yzgn1 = 7;
break;
case 10:
$yzgn1 = 8;
break;
case 0:
$yzgn1 = 9;
}


//'月支纳干 $mzgn1
switch($mzn1) {
case 1:
$mzgn1 = 0;
break;
case 2:
case 8:
$mzgn1 = 6;
break;
case 3:
$mzgn1 = 1;
break;
case 4:
$mzgn1 = 2;
break;
case 5:
case 11:
$mzgn1 = 5;
break;
case 6:
$mzgn1 = 3;
break;
case 7:
$mzgn1 = 4;
break;
case 9:
$mzgn1 = 7;
break;
case 10:
$mzgn1 = 8;
break;
case 0:
$mzgn1 = 9;
}

//'日支纳干 dzgn1

switch($dzn1) {
case 1:
$dzgn1 = 0;
break;
case 2:
case 8:
$dzgn1 = 6;
break;
case 3:
$dzgn1 = 1;
break;
case 4:
$dzgn1 = 2;
break;
case 5:
case 11:
$dzgn1 = 5;
break;
case 6:
$dzgn1 = 3;
break;
case 7:
$dzgn1 = 4;
break;
case 9:
$dzgn1 = 7;
break;
case 10:
$dzgn1 = 8;
break;
case 0:
$dzgn1 = 9;
}

//'时支纳干 $tzgn1
switch($tzn1) {
case 1:
$tzgn1 = 0;
break;
case 2:
case 8:
$tzgn1 = 6;
break;
case 3:
$tzgn1 = 1;
break;
case 4:
$tzgn1 = 2;
break;
case 5:
case 11:
$tzgn1 = 5;
break;
case 6:
$tzgn1 = 3;
break;
case 7:
$tzgn1 = 4;
break;
case 9:
$tzgn1 = 7;
break;
case 10:
$tzgn1 = 8;
break;
case 0:
$tzgn1 = 9;
}

//'到此，完成各地支所纳天干的确定任务
$yg1n1=$a[20 + $ygn1];
$yz1n1=$a[30 + $yzn1];
$mg1n1=$a[20 + $mgn1];
$mz1n1=$a[30 + $mzn1];
$dg1n1=$a[20 + $dgn1];
$dz1n1=$a[30 + $dzn1];
$tg1n1=$a[20 + $tgn1];
$tz1n1=$a[30 + $tzn1];
$ygzn1=$a[20 + $ygn1] . $a[30 + $yzn1];
$mgzn1=$a[20 + $mgn1] . $a[30 + $mzn1];
$dgzn1=$a[20 + $dgn1] . $a[30 + $dzn1];
$tgzn1=$a[20 + $tgn1] . $a[30 + $tzn1];

/* EOF */
