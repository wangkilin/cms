<?php
//获取用户cookies信息
global $xing, $ming, $xingbie, $xuexing, $nian1, $yue1, $ri1, $hh1, $mm1, $nian2, $yue2, $ri2, $hh2, $mm2, $sx;

$xing=isset($_POST['xing'])? $_POST['xing'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['xing'])? $_COOKIE['laisuanming']['xing']:'');
$ming=isset($_POST['ming'])? $_POST['ming'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['ming'])? $_COOKIE['laisuanming']['ming']:'');
$xingbie=isset($_POST['xingbie'])? $_POST['xingbie'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['xingbie'])? $_COOKIE['laisuanming']['xingbie']:'');
$xuexing=isset($_POST['xuexing'])? $_POST['xuexing'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['xuexing'])? $_COOKIE['laisuanming']['xuexing']:'');
//公历
$nian1=isset($_POST['nian'])? $_POST['nian'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['nian1'])? $_COOKIE['laisuanming']['nian1']:'');
$yue1=isset($_POST['yue'])? $_POST['yue'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['yue1'])? $_COOKIE['laisuanming']['yue1']:'');
$ri1=isset($_POST['ri'])? $_POST['ri'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['ri1'])? $_COOKIE['laisuanming']['ri1']:'');
$hh1=isset($_POST['hh'])? $_POST['hh'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['hh1'])? $_COOKIE['laisuanming']['hh1']:'');
$mm1=isset($_POST['mm'])? $_POST['mm'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['mm1'])? $_COOKIE['laisuanming']['mm1']:'');
//农历
$nian2=isset($_POST['nian2'])? $_POST['nian2'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['nian2'])? $_COOKIE['laisuanming']['nian2']:'');
$yue2=isset($_POST['yue2'])? $_POST['yue2'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['yue2'])? $_COOKIE['laisuanming']['yue2']:'');
$ri2=isset($_POST['ri2'])? $_POST['ri2'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['ri2'])? $_COOKIE['laisuanming']['ri2']:'');
$hh2=isset($_POST['hh2'])? $_POST['hh2'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['hh2'])? $_COOKIE['laisuanming']['hh2']:'');
$mm2=isset($_POST['mm2'])? $_POST['mm2'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['mm2'])? $_COOKIE['laisuanming']['mm2']:'');
$sx=isset($_POST['sx'])? $_POST['sx'] : (isset($_COOKIE['laisuanming'], $_COOKIE['laisuanming']['sx'])? $_COOKIE['laisuanming']['sx']:'');

/* EOF */
