<?php
global $yearlast;
global $day60;
global $a;
$nlsc = array();
$sczy = array();
$scsy = array();
$jz = array();
$dayname = array();
$MonName = array();
global $rn;
global $mdn1;
//确定节气 yzn1 月支  起运基数 qyjsn1
$mdn1 = $bzm1 * 100 + $bzd1;
if($mdn1>=204 && $mdn1<= 305){
	$mzn1 = 3;
    $qyjsn1 = (($bzm1 - 2) * 30 + $bzd1 - 4) / 3;
}

if($mdn1>=306 && $mdn1<=404) {
    $mzn1 = 4;
    $qyjsn1 = (($bzm1 - 3) * 30 + $bzd1 - 6) / 3;
}

if($mdn1>=405 && $mdn1<= 504) {
    $mzn1 = 5;
    $qyjsn1 = (($bzm1 - 4) * 30 + $bzd1 - 5) / 3;
}

if($mdn1>=505 && $mdn1<=  605) {
    $mzn1 = 6;
    $qyjsn1 = (($bzm1 - 5) * 30 + $bzd1 - 5) / 3;
}

if($mdn1>=606 && $mdn1<= 706) {
$mdn1 = 7;
$qyjsn1 = (($bzm1 - 6) * 30 + $bzd1 - 6) / 3;
}

if($mdn1>=707 && $mdn1<= 807) {
$mdn1 = 8;
$qyjsn1 = (($bzm1 - 7) * 30 + $bzd1 - 7) / 3;
}

if($mdn1>=808 && $mdn1<=907) {
$mdn1 = 9;
$qyjsn1 = (($bzm1 - 8) * 30 + $bzd1 - 8) / 3;
}

if($mdn1>=908 && $mdn1<=1007) {
$mdn1 = 10;
$qyjsn1 = (($bzm1 - 9) * 30 + $bzd1 - 8) / 3;
}

if($mdn1>=1008 && $mdn1<= 1106) {
$mdn1 = 11;
$qyjsn1 = (($bzm1 - 10) * 30 + $bzd1 - 8) / 3;
}

if($mdn1>=1107 && $mdn1<=  1207) {
$mdn1 = 0;
$qyjsn1 = (($bzm1 - 11) * 30 + $bzd1 - 7) / 3;
}

if($mdn1>=1208 && $mdn1<=  1231) {
$mdn1 = 1;
$qyjsn1 = (bzd1 - 8) / 3;
}

if($mdn1>=101 && $mdn1<= 105) {
$mdn1 = 1;
$qyjsn1 = (30 + $bzd1 - 4) / 3;
}

if($mdn1>=106 && $mdn1<=  203) {
$mdn1 = 2;
$qyjsn1 = (($bzm1 - 1) * 30 + $bzd1 - 6) / 3;
}

//确定年干和年支 ygn1 年干 yzn1 年支
if($mdn1>=204 && $mdn1<=1231) {
    $ygn1 = ($bzy1 - 3) % 10;
    $yzn1 = ($bzy1 - 3) % 12;
}
if($mdn1>=101 && $mdn1<=203 ) {
    $ygn1 = ($bzy1 - 4) % 10;
    $yzn1 = ($bzy1 - 4) % 12;
}

//确定月干 mgn1 月干

if ($mzn1 > 2 && $mzn1 <= 11) {

    $mgn1 = ($ygn1 * 2 + $mzn1 + 8) % 10;
}else
    $mgn1 = ($ygn1 * 2 + $mzn1) % 10;
}

//从公元0年到目前年份的天数 yearlast

$yearlast = ($bzy1 - 1) * 5 + ($bzy1 - 1) / 4 - ($bzy1 - 1) / 100 + ($bzy1 - 1) / 400;
//计算某月某日与当年1月0日的时间差（以日为单位）yearday

$yearday = 0;
for($i=1; $i<$bzm1; $i++) {
    if(in_array($i, array(1, 3, 5, 7, 8, 10, 12))) {
		$yearday = $yearday + 31;
	} elseif (in_array($i, array(4, 6, 9, 11))) {
		$yearday = $yearday + 30;
	} else {
		if (($bzy1%4 == 0 && ($bzy1%100) <> 0) || $bzy1%400 == 0) {
			$yearday = $yearday + 29;
		} else {
			$yearday = $yearday + 28;
		}
	}
}

$yearday = $yearday + $bzd1;

//计算日的六十甲子数 day60
$day60 = ($yearlast + $yearday + 6015) % 60;

//确定 日干 dgn1  日支  dzn1
$dgn1 = $day60 % 10;
$dzn1 = day60 % 12;

//确定 时干 tgn1 时支 tzn1
$tzn1 = ($bzh1 + 3) / 2 % 12
//'tgn1 = (dgn1 * 2 + tzn1 + 8) Mod 10
if ($tzn1 = 0) {
    $tgn1 = ($dgn1 * 2 + $tzn1) % 10;
} else {
    $tgn1 = ($dgn1 * 2 + $tzn1 + 8) % 10;
}

//把 年月日时 转换成为 生辰八字
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
Case 4:
$yzgn1 = 2;
break;
Case 5:
case 11:
$yzgn1 = 5;
break;
Case 6:
$yzgn1 = 3;
break;
Case 7:
$yzgn1 = 4;
break;
Case 9:
$yzgn1 = 7;
break;
Case 10:
$yzgn1 = 8;
break;
Case 0:
$yzgn1 = 9;
break;
}


//月支纳干 mzgn1
switch($mzn1) {
Case 1:
$mzgn1 = 0;
break;
Case 2:
case 8:
$mzgn1 = 6;
break;
Case 3:
$mzgn1 = 1;
break;
Case 4:
$mzgn1 = 2;
break;
Case 5:
case 11:
$mzgn1 = 5;
break;
Case 6:
$mzgn1 = 3;
break;
Case 7:
$mzgn1 = 4;
break;
Case 9:
$mzgn1 = 7;
break;
Case 10:
$mzgn1 = 8;
break;
Case 0:
$mzgn1 = 9;
break;
}

//日支纳干 dzgn1
switch($dzn1) {
Case 1:
$dzgn1 = 0;
break;
Case 2:
case 8:
$dzgn1 = 6;
break;
Case 3:
$dzgn1 = 1;
break;
Case 4:
$dzgn1 = 2;
break;
Case 5:
case 11:
$dzgn1 = 5;
break;
Case 6:
$dzgn1 = 3;
break;
Case 7:
$dzgn1 = 4;
break;
Case 9:
$dzgn1 = 7;
break;
Case 10:
$dzgn1 = 8;
break;
Case 0:
$dzgn1 = 9;
break;
}

//时支纳干 tzgn1
switch($tzn1) {
Case 1:
$tzgn1 = 0;
break;
Case 2:
case 8:
$tzgn1 = 6;
break;
Case 3:
$tzgn1 = 1;
break;
Case 4:
$tzgn1 = 2;
break;
Case 5:
case 11:
$tzgn1 = 5;
break;
Case 6:
$tzgn1 = 3;
break;
Case 7:
$tzgn1 = 4;
break;
Case 9:
$tzgn1 = 7;
break;
Case 10:
$tzgn1 = 8;
break;
Case 0:
$tzgn1 = 9;
break;
}

//到此，完成各地支所纳天干的确定任务
$yg1n1=$a[20 + $ygn1];
$yz1n1 = $a[30 + $yzn1];
$mg1n1 = $a[20 + $mgn1]
$mz1n1 = $a[30 + $mzn1];
$dg1n1 = $a[20 + $dgn1];
$dz1n1 = $a[30 + $dzn1];
$tg1n1 = $a[20 + $tgn1];
$tz1n1 = $a[30 + $tzn1];
$ygzn1 = $a[20 + $ygn1] . $a[30 + $yzn1];
$mgzn1 = $a[20 + $mgn1] . $a[30 + $mzn1];
$dgzn1 = $a[20 + $dgn1) . $a[30 + $dzn1];
$tgzn1 = $a[20 + $tgn1) . $a[30 + $tzn1];

/* EOF */
