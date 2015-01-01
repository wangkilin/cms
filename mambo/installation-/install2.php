<?php
/**
* @version $Id: install2.php,v 1.26 2004/09/03 22:04:10 rcastley Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** Set flag that this is a parent file */
define( "_VALID_MOS", 1 );

/** Include common.php */
require_once( "common.php" );
require_once( "../includes/database.php" );

$DBhostname = trim( mosGetParam( $_POST, 'DBhostname', '' ) );
$DBuserName = trim( mosGetParam( $_POST, 'DBuserName', '' ) );
$DBpassword = trim( mosGetParam( $_POST, 'DBpassword', '' ) );
$DBname  	= trim( mosGetParam( $_POST, 'DBname', '' ) );
$DBPrefix  	= trim( mosGetParam( $_POST, 'DBPrefix', '' ) );
$DBDel  	= intval( trim( mosGetParam( $_POST, 'DBDel', 0 ) ) );
$DBBackup  	= intval( trim( mosGetParam( $_POST, 'DBBackup', 0 ) ) );
$DBSample  	= trim( mosGetParam( $_POST, 'DBSample', '' ) );
$DBcreated = trim( mosGetParam( $_POST, 'DBcreated', 0 ) );
$BUPrefix = 'old_';
$configArray['sitename'] = trim( mosGetParam( $_POST, 'sitename', '' ) );

$database = null;

$errors = array();
if ($DBcreated != 1){
	if (!$DBhostname || !$DBuserName || !$DBname) {
		db_err ("stepBack3","数据库设置错误!!请返回检查!");
	}

	if (!($mysql_link = @mysql_connect( $DBhostname, $DBuserName, $DBpassword ))) {
		db_err ("stepBack2","MySql用户名或密码错误!请返回检查!");
	}

	if($DBname == "") {
		db_err ("stepBack","数据库名称设置错误!请返回检查!");
	}

	// Does this code actually do anything???
	$configArray['DBhostname'] = $DBhostname;
	$configArray['DBuserName'] = $DBuserName;
	$configArray['DBpassword'] = $DBpassword;
	$configArray['DBname']     = $DBname;
	$configArray['DBPrefix']   = $DBPrefix;

	$sql = "CREATE DATABASE `$DBname`";
	$mysql_result = mysql_query( $sql );
	$test = mysql_errno();

	if ($test <> 0 && $test <> 1007) {
		db_err( "stepBack", "访问数据库出错: " . (mysql_error()) );
	}

	// db is now new or existing, create the db object connector to do the serious work
	$database = new database( $DBhostname, $DBuserName, $DBpassword, $DBname, $DBPrefix );

	$database->setQuery( "set names 'gb2312'" );// set charset
	$database->query();// kilin did it

	// delete existing mos table if requested
	if ($DBDel) {
		$database->setQuery( "SHOW TABLES FROM $DBname" );
		$errors = array();
		if ($tables = $database->loadResultArray()) {
			foreach ($tables as $table) {
				if (strpos( $table, $DBPrefix ) === 0) {
					if ($DBBackup) {
						$butable = str_replace( $DBPrefix, $BUPrefix, $table );
						$database->setQuery( "DROP TABLE IF EXISTS $butable" );
						$database->query();
						if ($database->getErrorNum()) {
							$errors[$database->getQuery()] = $database->getErrorMsg();
						}
						$database->setQuery( "RENAME TABLE $table TO $butable" );
						$database->query();
						if ($database->getErrorNum()) {
							$errors[$database->getQuery()] = $database->getErrorMsg();
						}
					}
					$database->setQuery( "DROP TABLE IF EXISTS $table" );
					$database->query();
					if ($database->getErrorNum()) {
						$errors[$database->getQuery()] = $database->getErrorMsg();
					}
				}
			}
		}
		/*
		if (count($errors)) {
		// abrupt failure...need to work on this
		echo '<pre>';print_r( $errors );echo '</pre>';
		die;
		}
		*/
	}

	populate_db($DBname,$DBPrefix,'mambo.sql');
	if ($DBSample == 1) {
		populate_db($DBname,$DBPrefix,'sample_data.sql');
	}
}

function db_err($step, $alert) {
	global $DBhostname,$DBuserName,$DBpassword,$DBDel,$DBname;
	echo "<form name=\"$step\" method=\"post\" action=\"install1.php\">
	<input type=\"hidden\" name=\"DBhostname\" value=\"$DBhostname\">
	<input type=\"hidden\" name=\"DBuserName\" value=\"$DBuserName\">
	<input type=\"hidden\" name=\"DBpassword\" value=\"$DBpassword\">
	<input type=\"hidden\" name=\"DBDel\" value=\"$DBDel\">
	<input type=\"hidden\" name=\"DBname\" value=\"$DBname\">
	</form>\n";
	//echo "<script>alert(\"$alert\"); document.$step.submit();</script>";
	echo "<script>alert(\"$alert\"); window.history.go(-1);</script>";  //this wasn't working
	exit();
}

function populate_db($DBname, $DBPrefix, $sqlfile='mambo.sql') {
	global $errors;

	mysql_select_db($DBname);
	$mqr = @get_magic_quotes_runtime();
	@set_magic_quotes_runtime(0);
	$query = fread(fopen("sql/".$sqlfile, "r"), filesize("sql/".$sqlfile));
	@set_magic_quotes_runtime($mqr);
	$pieces  = split_sql($query);

	for ($i=0; $i<count($pieces); $i++) {
		$pieces[$i] = trim($pieces[$i]);
		if(!empty($pieces[$i]) && $pieces[$i] != "#") {
			$pieces[$i] = str_replace( "#__", $DBPrefix, $pieces[$i]);
			if (!$result = mysql_query ($pieces[$i])) {
				$errors[] = array ( mysql_error(), $pieces[$i] );
			}
		}
	}
}

function split_sql($sql) {
	$sql = trim($sql);
	$sql = ereg_replace("\n#[^\n]*\n", "\n", $sql);

	$buffer = array();
	$ret = array();
	$in_string = false;

	for($i=0; $i<strlen($sql)-1; $i++) {
		if($sql[$i] == ";" && !$in_string) {
			$ret[] = substr($sql, 0, $i);
			$sql = substr($sql, $i + 1);
			$i = 0;
		}

		if($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\") {
			$in_string = false;
		}
		elseif(!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset($buffer[0]) || $buffer[0] != "\\")) {
			$in_string = $sql[$i];
		}
		if(isset($buffer[1])) {
			$buffer[0] = $buffer[1];
		}
		$buffer[1] = $sql[$i];
	}

	if(!empty($sql)) {
		$ret[] = $sql;
	}
	return($ret);
}

$isErr = intval( count( $errors ) );
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
	if ( f.sitename.value == '' ) {
		alert('请输入名称');
		f.sitename.focus();
		formValid = false
	}
	return formValid;
}
</script>
</head>
<body onload="document.form.sitename.focus();"/>
<div id="wrapper">
    <div id="header">
      <div id="mambo"><img src="header_install.png" alt="Mambo 安装" /></div>
    </div>
</div>

<div id="ctr" align="center">
	<form action="install3.php" method="post" name="form" id="form" onsubmit="return check();">
	<input type="hidden" name="DBhostname" value="<?php echo "$DBhostname"; ?>" />
	<input type="hidden" name="DBuserName" value="<?php echo "$DBuserName"; ?>" />
	<input type="hidden" name="DBpassword" value="<?php echo "$DBpassword"; ?>" />
	<input type="hidden" name="DBname" value="<?php echo "$DBname"; ?>" />
	<input type="hidden" name="DBPrefix" value="<?php echo "$DBPrefix"; ?>" />
	<div class="install">
    <div id="stepbar">
      	<div class="step-off">安装前的检查</div>
      	<div class="step-off">许可协议</div>
      	<div class="step-off">第一步</div>
      	<div class="step-on">第二步</div>
      	<div class="step-off">第三步</div>
      	<div class="step-off">第四步</div>
      </div>
      <div id="right">
  		<div class="far-right">
<?php if (!$isErr) { ?>
  		  <input class="button" type="submit" name="next" value="下一步 >>"/>
<?php } ?>
  		</div>
  		<div id="step">第二步</div>
  		<div class="clr"></div>
  		
  		<h1>请输入你的Mambo站点名称:</h1>
  		<div class="install-text">
<?php if ($isErr) { ?>
			数据库内容更新出错!<br />
  				安装程序无法继续运行!!!
<?php } else { ?>
			成功!
			<br />
			<br />
  			请输入你的Mambo站点名称。
<?php } ?>
  		</div>
  		<div class="install-form">
  			<div class="form-block">
  				<table class="content2">
  <?php
  if ($isErr) {
  	echo "<tr><td colspan=\"2\">";
  	echo "<b></b>";
  	echo "<br /><br />错误记录:<br />\n";
  	// abrupt failure
  	echo '<textarea rows="10" cols="50">';
  	foreach($errors as $error) {
  		echo "SQL=$error[0]:\n- - - - - - - - - -\n$error[1]\n= = = = = = = = = =\n\n";
  	}
  	echo '</textarea>';
  	echo "</td></tr>\n";
  } else {
	?>
  		          <tr>
  		            <td width="100">站点名称</td>
  		            <td align="center"><input class="inputbox" type="text" name="sitename" size="50" value="<?php echo "{$configArray['sitename']}"; ?>" /></td>
  		          </tr>
  		          <tr>
  		            <td width="100">&nbsp;</td>
  		            <td align="center" class="small">例如：我的Mambo</td>
  		          </tr>
  		          <tr>
  				</table>
	<?php
  }
  ?>		
  			</div>
  		</div>		
  		<div class="clr"></div>
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
