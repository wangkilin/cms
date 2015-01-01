<?php
/**
* @version $Id: install3.php,v 1.23 2004/09/10 23:20:39 rcastley Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** Include common.php */
include_once("common.php");

$DBhostname = trim( mosGetParam( $_POST, 'DBhostname', '' ) );
$DBuserName = trim( mosGetParam( $_POST, 'DBuserName', '' ) );
$DBpassword = trim( mosGetParam( $_POST, 'DBpassword', '' ) );
$DBname  	= trim( mosGetParam( $_POST, 'DBname', '' ) );
$DBPrefix  	= trim( mosGetParam( $_POST, 'DBPrefix', '' ) );
$sitename  	= trim( mosGetParam( $_POST, 'sitename', '' ) );
$adminEmail = trim( mosGetParam( $_POST, 'adminEmail', '') );
$configArray['siteUrl'] = trim( mosGetParam( $_POST, 'siteUrl', '' ) );
$configArray['absolutePath'] = trim( mosGetParam( $_POST, 'absolutePath', '' ) );
if (get_magic_quotes_gpc()) {
	$configArray['absolutePath'] = stripslashes(stripslashes($configArray['absolutePath']));
	$sitename = stripslashes(stripslashes($sitename));
}

if ($sitename == '') {
	echo "<form name=\"stepBack\" method=\"post\" action=\"install2.php\">
			<input type=\"hidden\" name=\"DBhostname\" value=\"$DBhostname\">
			<input type=\"hidden\" name=\"DBuserName\" value=\"$DBuserName\">
			<input type=\"hidden\" name=\"DBpassword\" value=\"$DBpassword\">
			<input type=\"hidden\" name=\"DBname\" value=\"$DBname\">
			<input type=\"hidden\" name=\"DBPrefix\" value=\"$DBPrefix\">
			<input type=\"hidden\" name=\"DBcreated\" value=1>
		</form>";

	echo "<script>alert('站点名不合法!'); document.stepBack.submit();</script>";
	return;
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
<script language="javascript" type="text/javascript">
function check() {
	<!-- form validation check -->
	var formValid = true;
	var f = document.form;
	if ( f.siteUrl.value == '' ) {
		alert('请输入站点访问地址');
		f.siteUrl.focus();
		formValid = false;
	} else if ( f.absolutePath.value == '' ) {
		alert('请输入你的站点在服务器上的绝对路径');
		f.absolutePath.focus();
		formValid = false;
	} else if ( f.adminEmail.value == '' ) {
		alert('请输入你的站点管理员的联络Email');
		f.adminEmail.focus();
		formValid = false;
	} else if ( f.adminPassword.value == '' ) {
		alert('请输入你的管理员密码');
		f.adminPassword.focus();
		formValid = false;
	}

	return formValid;
}
</script>
</head>
<body onload="document.form.siteUrl.focus();"/>
<div id="wrapper">
    <div id="header">
    <div id="mambo"><img src="header_install.png" alt="Mambo 安装" /></div>
    </div>
</div>
<div id="ctr" align="center">
		<form action="install4.php" method="post" name="form" id="form" onsubmit="return check();">
		 <input type="hidden" name="DBhostname" value="<?php echo "$DBhostname"; ?>" />
		 <input type="hidden" name="DBuserName" value="<?php echo "$DBuserName"; ?>" />
		 <input type="hidden" name="DBpassword" value="<?php echo "$DBpassword"; ?>" />
		 <input type="hidden" name="DBname" value="<?php echo "$DBname"; ?>" />
		 <input type="hidden" name="DBPrefix" value="<?php echo "$DBPrefix"; ?>" />
		 <input type="hidden" name="sitename" value="<?php echo "$sitename"; ?>" />
	<div class="install">
    <div id="stepbar">
      	<div class="step-off">安装前的检查</div>
      	<div class="step-off">许可协议</div>
      	<div class="step-off">第一步</div>
      	<div class="step-off">第二步</div>
      	<div class="step-on">第三步</div>
      	<div class="step-off">第四步</div>
      </div>
      <div id="right">
    		<div id="step">第三步</div>
    		<div class="far-right">
    			<input class="button" type="submit" name="next" value="下一步 >>"/>
    		</div>
    		<div class="clr"></div>
    		
    		<h1>设置站点的 URL, 绝对路径和管理员 e-mail</h1>
    		<div class="install-text">
    			  <p>如果你发现提示的 URL 和路径不正确，请修改它!
    	          如果你不能确定，请联络你的供应商或者管理员。通常，这些已经都为你设置好了。<br />
    	          <br />
    	          请输入你的 e-mail。<br />
    		</div>
    		<div class="install-form">
    			<div class="form-block">
    				<table class="content2">
    		          <tr>
    		            <td width="100">URL</td>
    		            <td align="center"><input class="inputbox" type="text" name="siteUrl" value="<?php if($configArray['siteUrl']) { echo $configArray['siteUrl'];
    		            } else {
    		            	$url = $_SERVER['SERVER_NAME'];
    		            	$root = $url.$_SERVER['PHP_SELF'];
    		            	$root = str_replace("installation/","",$root);
    		            	$root = str_replace("/install3.php","",$root);
    		            	echo "http://$root";
    		            }
    								?>" size="50" /> </td>
    		          </tr>
    		          <tr>
    		            <td>路径</td>
    		            <td align="center"><input class="inputbox" type="text" name="absolutePath" value="<?php
    		            if($configArray['absolutePath'])
    		            {
    		            	echo $configArray['absolutePath'];
    		            }
    		            else
    		            {
    		            	$path = getcwd();
    		            	if (preg_match("/\/installation/i", "$path")) {
    		            		$abspath = str_replace('/installation',"",$path);
    		            	} else {
    		            		$abspath = str_replace('\installation',"",$path);
    		            	}
    		            	echo $abspath;
    		            }
    								?>" size="50" /> </td>
    		          </tr>
    		          <tr>
    		            <td>你的 E-mail</td>
    		            <td align="center"><input class="inputbox" type="text" name="adminEmail" value="<?php echo "$adminEmail"; ?>" size="50" /></td>
    		          </tr>
    		          <tr>
    		            <td>管理员密码</td>
    		            <td align="center"><input class="inputbox" type="text" name="adminPassword" value="<?php
    		            echo mosMakePassword(8);
    								?>" size="50" /></td>
    		          </tr>				
    				</table>
    			</div>
    		</div>		
    		<div id="break"></div>
      </div>
		<div class="clr"></div>
		</form>
	</div>
	<div class="clr"></div>
</div>
	 <div class="ctr">
	   Miro International Pty Ltd. &copy;2000 - 2004 All rights reserved. <br />
	     <a href="http://www.mamboserver.com" target="_blank">Mambo</a> is Free Software released under the GNU/GPL License.
<br>本安装程序由 <a href="http://www.mambochina.net" target="_blank">Mambo中国</a> 开发小组汉化
	 </div>
</body>
</html>