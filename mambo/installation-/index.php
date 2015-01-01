<?php
/**
* @version $Id: index.php,v 1.35 2004/09/20 15:17:03 prazgod Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

if (file_exists( "../configuration.php" ) && filesize( "../configuration.php" ) > 10) {
	header( "Location: ../index.php" );
	exit();
}
require_once ("../includes/version.php");

/** Include common.php */
include_once( "common.php" );

function get_php_setting($val) {
	$r =  (ini_get($val) == '1' ? 1 : 0);
	return $r ? 'ON' : 'OFF';
}

function writableCell( $folder ) {
	echo '<tr>';
	echo '<td class="item">' . $folder . '/</td>';
	echo '<td align="left">';
	echo is_writable( "../$folder" ) ? '<b><font color="green">可写</font></b>' : '<b><font color="red">不可写</font></b>' . '</td>';
	echo '</tr>';
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
			alert("你必须阅读并同意此许可协议才能继续安装！")
			return false
		}
	}
}

</script>
</head>
<body>

<div id="wrapper">
<div id="header">

<div id="mambo"><img src="header_install.png" alt="Mambo 安装" /></div>
</div>
</div>

<div id="ctr" align="center">
<div class="install">
<div id="stepbar">
<div class="step-on">安装前的检查　</div>
<div class="step-off">许可协议</div>
<div class="step-off">第一步</div>
<div class="step-off">第二步</div>
<div class="step-off">第三步</div>
<div class="step-off">第四步</div>
</div>
<div id="right">

<div id="step">安装前的检查</div>

<div class="far-right">
<input name="Button2" type="submit" class="button" value="下一步 >>" onclick="window.location='install.php';" />
</div>
<div class="clr"></div>

<h1>Mambo <?php echo $version; ?> 自检:</h1>
<div class="install-text">
如何哪一项以红色提示，请修改该项以确保 Mambo <?php echo $version; ?>的正常安装!
<div class="ctr"></div>
</div>

<div class="install-form">
<div class="form-block">

<table class="content">
<tr>
	<td class="item">
	PHP 版本 >= 4.1.0
	</td>
	<td align="left">
	<?php echo phpversion() < '4.1' ? '<b><font color="red">版本太低</font></b>' : '<b><font color="green">可以安装</font></b>';?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - zlib 压缩支持
	</td>
	<td align="left">
	<?php echo extension_loaded('zlib') ? '<b><font color="green">可用</font></b>' : '<b><font color="red">不可用</font></b>';?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - XML 支持
	</td>
	<td align="left">
	<?php echo extension_loaded('xml') ? '<b><font color="green">可用</font></b>' : '<b><font color="red">不可用</font></b>';?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - MySQL 支持
	</td>
	<td align="left">
	<?php echo function_exists( 'mysql_connect' ) ? '<b><font color="green">可用</font></b>' : '<b><font color="red">不可用</font></b>';?>
	</td>
</tr>
<tr>
	<td valign="top" class="item">
	configuration.php
	</td>
	<td align="left">
	<?php
  if (@file_exists('../configuration.php') &&  @is_writable( '../configuration.php' )){
      echo '<b><font color="green">可写</font></b>';
    } else if (is_writable( '..' )) {
      echo '<b><font color="green">可写</font></b>';
    } else {
      echo '<b><font color="red">不可写</font></b><br /><span class="small">即使这样，你也可以继续完成安装的过程，但是在最后，你必须将提示的内容复制粘贴成configuration.php并上传到你的服务器!</span>';
    } ?>
	</td>
</tr>
<tr>
	<td class="item">
	Session 保存路径
	</td>
	<td align="left">
	<b><?php echo (($sp=ini_get('session.save_path'))?$sp:'没有设置'); ?></b>,
	<?php echo is_writable( $sp ) ? '<b><font color="green">可写</font></b>' : '<b><font color="red">不可写</font></b>';?>
	</td>
</tr>
</table>
</div>
</div>
<div class="clr"></div>

<h1>推荐设置:</h1>
<div class="install-text">
下面是运行 Mambo 的PHP环境推荐设置。
<br />
但是，即使你的某些设置与推荐设置不匹配，Mambo也可以继续进行安装和运行。
<div class="ctr"></div>
</div>

<div class="install-form">
<div class="form-block">

<table class="content">
<tr>
	<td class="toggle">
	PHP设置
	</td>
	<td class="toggle">
	推荐设置
	</td>
	<td class="toggle">
	当前设置
	</td>
</tr>
<tr>
	<td class="item">
	安全模式:
	</td>
	<td class="toggle">
	OFF
	</td>
	<td>
	<?php
	if ( get_php_setting('safe_mode') == 'OFF' ) {
		?>
		<font color="green"><b>
		<?php
	} else {
		?>
		<font color="red"><b>
		<?php
	}
	echo get_php_setting('safe_mode');	?>
	</b></font>
	<td>
</tr>
<tr>
	<td class="item">
	显示错误信息:
	</td>
	<td class="toggle">
	ON
	</td>
	<td>
	<?php
	if ( get_php_setting('display_errors') == 'ON' ) {
		?>
		<font color="green"><b>
		<?php
	} else {
		?>
		<font color="red" style="bold"><b>
		<?php
	}
	echo get_php_setting('display_errors');?>
	</b></font>
	</td>
</tr>
<tr>
	<td class="item">
	文件上传:
	</td>
	<td class="toggle">
	ON
	</td>
	<td>
	<?php
	if ( get_php_setting('file_uploads') == 'ON' ) {
		?>
		<font color="green"><b>
		<?php
	} else {
		?>
		<font color="red" style="bold"><b>
		<?php
	}
	echo get_php_setting('file_uploads');?>
	</b></font>
	</td>
</tr>
<tr>
	<td class="item">
	Magic Quotes GPC:
	</td>
	<td class="toggle">
	ON
	</td>
	<td>
	<?php
	if ( get_php_setting('magic_quotes_gpc') == 'ON' ) {
		?>
		<font color="green"><b>
		<?php
	} else {
		?>
		<font color="red" style="bold"><b>
		<?php
	}
	echo get_php_setting('magic_quotes_gpc');?>
	</b></font>
	</td>
</tr>
<tr>
        <td class="item">
        Magic Quotes Runtime:
        </td>
        <td class="toggle">
        OFF
        </td>
        <td>
        <?php
        if ( get_php_setting('magic_quotes_runtime') == 'OFF' ) {
                ?>
                <font color="green"><b>
                <?php
        } else {
                ?>
                <font color="red" style="bold"><b>
                <?php
        }
        echo get_php_setting('magic_quotes_runtime');?>
        </b></font>
        </td>
</tr>

<tr>
	<td class="item">
	Register Globals:
	</td>
	<td class="toggle">
	OFF
	</td>
	<td>
	<?php
	if ( get_php_setting('register_globals') == 'OFF' ) {
		?>
		<font color="green"><b>
		<?php
	} else {
		?>
		<font color="red" style="bold"><b>
		<?php
	}
	echo get_php_setting('register_globals');?>
	</b></font>
	</td>
</tr>
<tr>
	<td class="item">
	输出缓冲:
	</td>
	<td class="toggle">
	OFF
	</td>
	<td>
	<?php
	if ( get_php_setting('output_buffering') == 'OFF' ) {
		?>
		<font color="green"><b>
		<?php
	} else {
		?>
		<font color="red" style="bold"><b>
		<?php
	}
	echo get_php_setting('output_buffering');
	?>
	</b></font>
	</td>

</tr>
<tr>
	<td class="item">
	Session auto start:
	</td>
	<td class="toggle">
	OFF
	</td>
	<td>
	<?php
	if ( get_php_setting('session.auto_start') == 'OFF' ) {
		?>
		<font color="green"><b>
		<?php
	} else {
		?>
		<font color="red" style="bold"><b>
		<?php
	}
	echo get_php_setting('session.auto_start');?>
	</b></font>
	</td>
</tr>
</table>
</div>
</div>
<div class="clr"></div>

<h1>目录和文件的权限:</h1>
<div class="install-text">
为了正常的运行 Mambo ，有些文件和文件夹必须有可写的权限。如果你看到“不可写”，请在服务器上修改它的属性!
<div class="clr">&nbsp;&nbsp;</div>
<div class="ctr"></div>
</div>

<div class="install-form">
<div class="form-block">

<table class="content">
<?php
writableCell( 'administrator/backups' );
writableCell( 'administrator/components' );
writableCell( 'administrator/modules' );
writableCell( 'administrator/templates' );
writableCell( 'cache' );
writableCell( 'components' );
writableCell( 'images' );
writableCell( 'images/banners' );
writableCell( 'images/stories' );
writableCell( 'language' );
writableCell( 'mambots' );
writableCell( 'mambots/content' );
writableCell( 'mambots/search' );
writableCell( 'media' );
writableCell( 'modules' );
writableCell( 'templates' );
?>
</table>
</div>
<div class="clr"></div>
</div>
<div class="clr"></div>
</div>
<div class="clr"></div>
</div>

<div class="ctr">
Miro International Pty Ltd. &copy;2000 - 2004 All rights reserved.<br />
<a href="http://www.mamboserver.com" target="_blank">Mambo</a> is Free Software released under the GNU/GPL License.
<br>本安装程序由 <a href="http://www.mambochina.net" target="_blank">Mambo中国</a> 开发小组汉化
</div>

</body>
</html>
