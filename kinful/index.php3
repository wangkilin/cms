<?php
include_once($_SERVER[DOCUMENT_ROOT]."/../inc/config/dbConfig.cfg.php");

$insert="insert into count_table(referer,time,ip) values ('$_SERVER[HTTP_REFERER]','".time()."',$_SERVER[REMOTE_ADDR]')";
mysql_query($insert);
?>
<HTML>
<HEAD>
<TITLE> Yeah,Easy!! </TITLE>
</HEAD>
<BODY>
<table width="400" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="41" height="77" bgcolor="7ABA32">&nbsp;</td>
    <td width="55" height="77" background="http://www.intermyth.com/imgs/domainparking/card2_r1_c2.jpg">&nbsp;</td>
    <td width="13" height="77" bgcolor="7ABA32"><strong></strong></td>
    <td width="291" bgcolor="7ABA32"><strong><font color=#FFFFFF style='font-size:13pt;font-family:Trebuchet MS'>Welcome to www.yeaheasy.com</font></strong></td>
  </tr>
  <tr> 
    <td colspan="4"><img src="http://www.intermyth.com/imgs/domainparking/card2_r2_c1.jpg" width="400" height="2"></td>
  </tr>
  <tr > 
    <td height="115" colspan="4" background="http://www.intermyth.com/imgs/domainparking/card2_r3_c1.jpg">&nbsp;</td>
  </tr>
  <tr align="center" bgcolor="58A20F"> 
    <td height="91" colspan="4"><strong><font color=#FFFFFF face='Trebuchet MS'><font style='font-size:10pt'>2006-04-04 16:59</font></font></strong></td>
  </tr>
</table>
</BODY>
</HTML>
