<?php
/**
* @version $Id: install.php,v 1.8 2004/09/19 15:17:46 saka Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

if (file_exists( "../configuration.php" ) && filesize( "../configuration.php" ) > 10) {
	header( "Location: ../index.php" );
	exit();
}
/** Include common.php */
include_once( "common.php" );
function writableCell( $folder ) {
	echo "<tr>";
	echo "<td class=\"item\">" . $folder . "/</td>";
	echo "<td align=\"left\">";
	echo is_writable( "../$folder" ) ? '<b><font color="green">可写</font></b>' : '<b><font color="red">不可写</font></b>' . "</td>";
	echo "</tr>";
}
?>
<?php echo "<?xml version=\"1.0\" encoding=\"gbk\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Mambo - 安装程序</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link rel="shortcut icon" href="../../images/favicon.ico" />
<link rel="stylesheet" href="install.css" type="text/css" />
<script>
var checkobj

function agreesubmit(el){
	checkobj=el
	if (document.all||document.getElementById){
		for (i=0;i<checkobj.form.length;i++){  //hunt down submit button
		var tempobj=checkobj.form.elements[i]
		if(tempobj.type.toLowerCase()=="submit")
		tempobj.disabled=!checkobj.checked
		}
	}
}

function defaultagree(el){
	if (!document.all&&!document.getElementById){
		if (window.checkobj&&checkobj.checked)
		return true
		else{
			alert("请仔细阅读并同意此协议以继续Mambo的安装")
			return false
		}
	}
}
</script>
</head>
<body onload="document.adminForm.next.disabled=true;">
<div id="wrapper">
  <div id="header">
    <div id="mambo"><img src="header_install.png" alt="Mambo 安装" /></div>
  </div>
</div>
<div id="ctr" align="center">
    <form action="install1.php" method="post" name="adminForm" id="adminForm" onSubmit="return defaultagree(this)">
    <div class="install">
    <div id="stepbar">
      	<div class="step-off">安装前的检查</div>
      	<div class="step-on">许可协议</div>
      	<div class="step-off">第一步</div>
      	<div class="step-off">第二步</div>
      	<div class="step-off">第三步</div>
      	<div class="step-off">第四步</div>
      </div>
      <div id="right">
        <div id="step">许可协议</div>
        <div class="far-right">
          <input class="button" type="submit" name="next" value="下一步 >>" DISABLED/>
        </div>
        <div class="clr"></div>
          <h1>GNU/GPL 协议:</h1>
          <div class="licensetext">
    			 <a href="http://www.mamboserver.com">Mambo </a> is Free Software released under the GNU/GPL License.
    			 <div class="error">*** 要继续进行Mambo的安装，你必须同意此协议 ***</div>

          </div>
          <div class="clr"></div>
          <div class="license-form">
            <div class="form-block" style="padding: 0px;">
    		      <iframe src="gpl.html" class="license" frameborder="0" scrolling="auto"></iframe>
            </div>
          </div>
          <div class="clr"></div>
          <div class="ctr">
    			   <input type="checkbox" name="agreecheck"  class="inputbox" onClick="agreesubmit(this)" />
    		     我同意此 GPL 许可协议
    			 </div>
          <div class="clr"></div>
        </div>
        <div id="break"></div>
      <div class="clr"></div>
    <div class="clr"></div>
    </form>

</div>
  <div class="ctr">
	   Miro International Pty Ltd. &copy;2000 - 2004 All rights reserved. <br />
	     <a href="http://www.mamboserver.com" target="_blank">Mambo</a> is Free Software released under the GNU/GPL License.
<br>本安装程序由 <a href="http://www.mambochina.net" target="_blank">Mambo中国</a> 开发小组汉化
	 </div>
</body>
</html>
