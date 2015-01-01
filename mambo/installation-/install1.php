<?php
/**
* @version $Id: install1.php,v 1.24 2004/09/03 22:04:10 rcastley Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** Include common.php */
include_once( "common.php" );

$DBhostname = trim( mosGetParam( $_POST, 'DBhostname', '' ) );
$DBuserName = trim( mosGetParam( $_POST, 'DBuserName', '' ) );
$DBpassword = trim( mosGetParam( $_POST, 'DBpassword', '' ) );
$DBname  	= trim( mosGetParam( $_POST, 'DBname', '' ) );
$DBPrefix  	= trim( mosGetParam( $_POST, 'DBPrefix', 'mos_' ) );
$DBDel  	= trim( mosGetParam( $_POST, 'DBDel', '' ) );
$DBBackup  	= trim( mosGetParam( $_POST, 'DBBackup', 1 ) );
$DBSample  	= trim( mosGetParam( $_POST, 'DBSample', '' ) );
$DBHelp 	= trim( mosGetParam( $_POST, 'DBHelp', '' ) );
$DBcreated = trim( mosGetParam( $_POST, 'DBcreated', 0 ) );
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
	var formValid=false;
	var f = document.form;
	if ( f.DBhostname.value == '' ) {
		alert('请输入主机名');
		f.DBhostname.focus();
		formValid=false;
	} else if ( f.DBuserName.value == '' ) {
		alert('请输入MySQL用户名');
		f.DBuserName.focus();
		formValid=false;
	} else if ( f.DBname.value == '' ) {
		alert('请输入MySql数据库名');
		f.DBname.focus();
		formValid=false;
	} else if ( confirm('请确定这些设置都是正确的？ \nMambo 现在开始进行数据库的设置!')) {
		formValid=true;
	}
	
	return formValid;
}
</script>
</head>
<body onload="document.form.DBhostname.focus();"/>
<div id="wrapper">
    <div id="header">
      
    <div id="mambo"><img src="header_install.png" alt="Mambo 安装" /></div>
    </div>
</div>
<div id="ctr" align="center">
	<form action="install2.php" method="post" name="form" id="form" onsubmit="return check();">
	<div class="install">
    <div id="stepbar">
      	<div class="step-off">安装前的检查</div>
      	<div class="step-off">许可协议</div>
      	<div class="step-on">第一步</div>
      	<div class="step-off">第二步</div>
      	<div class="step-off">第三步</div>
      	<div class="step-off">第四步</div>
      </div>
      <div id="right">
      <div class="far-right">
  	   <input class="button" type="submit" name="next" value="下一步 >>"/>
  		</div>
      <div id="step">第一步</div>
  		<div class="clr"></div>
  		<h1>MySQL 数据库设置:</h1>
      <div class="install-text">
  	   <p>在你的服务器上安装 Mambo 并运行它只需简单的四步...</p>
  	   <p>请输入Mambo在你的服务器上使用的数据库的主机名，通常为'localhost'。<br />
    		<br />
    		请输入Mambo在你的服务器上使用的 MySQL 用户名、密码以及数据库名。 
  		</div>
      <div class="install-form">
  	   <div class="form-block">
  	     <table class="content2">
  		  <tr>
  		    <td>主机名</td>
  		    <td align="left"><input class="inputbox" type="text" name="DBhostname" value="<?php echo "$DBhostname"; ?>" /></td>
  		    <td align="left" class="warning" colspan="2">(通常这里可以填写 'localhost')</td>
  		</tr>
  		  <tr>
  		    <td>MySQL 用户名</td>
  		    <td align="left"><input class="inputbox" type="text" name="DBuserName" value="<?php echo "$DBuserName"; ?>" /></td>
  		    <td colspan="2">&nbsp;</td>
  		</tr>
  		  <tr>
  		    <td>MySQL 密码</td>
  		    <td align="left"><input class="inputbox" type="text" name="DBpassword" value="<?php echo "$DBpassword"; ?>" /></td>
  		    <td align="left" class="warning" colspan="2">(密码当然<strong>必须</strong>输入正确啦)</td>
  		</tr>
  		  <tr>
  		    <td>MySQL 数据库名</td>
  		    <td align="left"><input class="inputbox" type="text" name="DBname" value="<?php echo "$DBname"; ?>" /></td>
  		</tr>
  		  <tr>
  		    <td>MySQL 表前缀</td>
  		    <td align="left"><input class="inputbox" type="text" name="DBPrefix" value="<?php echo "$DBPrefix"; ?>" /></td>
  		</tr>
  		  <tr>
  		    <td>删除已经存在的表？</td>
  		    <?php if ($DBDel==1) { ?>
  		    <td align="left"><input type="checkbox" name="DBDel" value="1" checked="checked" /></td>
  		    <?php }else{ ?>
  		    <td align="left"><input type="checkbox" name="DBDel" value="1" /></td>
  		    <?php } ?>
  		</tr>
  		  <tr>
  		    <td>备份数据表?</td>
  		    <?php if ($DBBackup==1) { ?>
  		    <td align="left"><input type="checkbox" name="DBBackup" value="1" checked="checked" /></td>
  		    <?php }else{ ?>
  		    <td align="left"><input type="checkbox" name="DBBackup" value="1" /></td>
  		    <?php } ?>
  		    <td>(已经存在的表将会被删除)</td>
  		</tr>
  		  <tr>
  		    <td>安装演示数据?</td>
  		    <?php if ($DBDel==1) { ?>
  		    <td align="left"><input type="checkbox" name="DBSample" value="1" checked="checked" /></td>
  		    <?php }else{ ?>
  		    <td align="left"><input type="checkbox" name="DBSample" value="1" /></td>
  		    <?php } ?>
  		</tr>
  	     </table>
  		</div>
		</div>
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