<?php
//写入cookies---writecookies()
function writecookies()
{
	if (count($_POST)) {
		$xing=newtrim($_REQUEST['xing']);
		$ming=newtrim($_REQUEST['ming']);
		$xingbie=newtrim($_REQUEST['xingbie']);
		$xuexing=newtrim($_REQUEST['xuexing']);
		//公历
		$nian1=newtrim($_REQUEST['nian']);
		$yue1=newtrim($_REQUEST['yue']);
		$ri1=newtrim($_REQUEST['ri']);
		$hh1=newtrim($_REQUEST['hh']);
		$mm1=newtrim($_REQUEST['mm']);
		//农历
		$glstr= $nian1 . "-" . $yue1 . "-" . $ri1;
		$nlstr=hhcal($glstr);
		$nlarray=explode('|' , $nlstr);
		$nlnian=$nlarray[0];
		$nlyue=$nlarray[1];
		$nlri=$nlarray[2];
		$sx=$nlarray[3];

		$cookieExpire = time()+3600;
		setcookie ('laisuanming[xing]', $xing , $cookieExpire, '/');
		setcookie ('laisuanming[ming]', $ming , $cookieExpire, '/');
		setcookie ('laisuanming[xingbie]', $xingbie , $cookieExpire, '/');
		setcookie ('laisuanming[xuexing]', $xuexing , $cookieExpire, '/');
		//公历
		setcookie ('laisuanming[nian1]', $nian1 , $cookieExpire, '/');
		setcookie ('laisuanming[yue1]', $yue1 , $cookieExpire, '/');
		setcookie ('laisuanming[ri1]', $ri1 , $cookieExpire, '/');
		setcookie ('laisuanming[hh1]', $hh1 , $cookieExpire, '/');
		setcookie ('laisuanming[mm1]', $mm1 , $cookieExpire, '/');
		//农历
		setcookie ('laisuanming[nian2]', $nlnian , $cookieExpire, '/');
		setcookie ('laisuanming[yue2]', $nlyue , $cookieExpire, '/');
		setcookie ('laisuanming[ri2]', $nlri , $cookieExpire, '/');
		setcookie ('laisuanming[hh2]', $hh1 , $cookieExpire, '/');
		setcookie ('laisuanming[mm2]', $mm1 , $cookieExpire, '/');
		setcookie ('laisuanming[sx]', $sx , $cookieExpire, '/');

  $_COOKIE['laisuanming']['xing'] = $xing;
		$_COOKIE['laisuanming']['ming'] = $ming;
		$_COOKIE['laisuanming']['xingbie'] = $xingbie;
		$_COOKIE['laisuanming']['xuexing'] = $xuexing;
		//公历
		$_COOKIE['laisuanming']['nian1'] = $nian1;
		$_COOKIE['laisuanming']['yue1'] = $yue1;
		$_COOKIE['laisuanming']['ri1'] = $ri1;
		$_COOKIE['laisuanming']['hh1'] = $hh1;
		$_COOKIE['laisuanming']['mm1'] = $mm1;
		//农历
		$_COOKIE['laisuanming']['nian2'] = $nlnian;
		$_COOKIE['laisuanming']['yue2'] = $nlyue;
		$_COOKIE['laisuanming']['ri2'] = $nlri;
		$_COOKIE['laisuanming']['hh2'] = $hh1;
		$_COOKIE['laisuanming']['mm2'] = $mm1;
		$_COOKIE['laisuanming']['sx'] = $sx;
	}
}


//清除cookies---clearcookies()
function clearcookies()
{
	 $cookieExpire = time()-3600;
		setcookie ('laisuanming[xing]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[ming]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[xingbie]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[xuexing]', '' , $cookieExpire, '/');
		//公历
		setcookie ('laisuanming[nian1]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[yue1]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[ri1]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[hh1]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[mm1]', '' , $cookieExpire, '/');
		//农历
		setcookie ('laisuanming[nian2]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[yue2]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[ri2]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[hh2]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[mm2]', '' , $cookieExpire, '/');
		setcookie ('laisuanming[sx]', '' , $cookieExpire, '/');
  setcookie ('laisuanming', '' , $cookieExpire, '/');
}

/* EOF */
