<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : db.config.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2007-1-10
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die("forbidden");
global $MY_db_config;
$MY_db_config=array();
/****************** STRAT::mysql config zone *******************************/
$i=0;

$MY_db_config['mysql'][$i]['hostname']	=	'localhost';	// hostname
$MY_db_config['mysql'][$i]['port']		=	'3306';			// port
$MY_db_config['mysql'][$i]['username']	=	'root';			// username
$MY_db_config['mysql'][$i]['password']	=	'4728999';		// user password
$MY_db_config['mysql'][$i]['database']	=	'kinful';		// database name
/****************** END::mysql config zone *******************************/

/****************** STRAT::pgsql config zone *******************************/
$i=0;

$MY_db_config['pgsql'][$i]['hostname']	=	'localhost';	// hostname
$MY_db_config['pgsql'][$i]['port']		=	'5432';			// port
$MY_db_config['pgsql'][$i]['username']	=	'postgres';		// username
$MY_db_config['pgsql'][$i]['password']	=	'4728999';		// user password
$MY_db_config['pgsql'][$i]['database']	=	'kinful';		// database name
/****************** END::pgsql config zone *******************************/

/****************** STRAT::mssql config zone *******************************/
$i=0;

$MY_db_config['mssql'][$i]['hostname']	=	'localhost';	// hostname
$MY_db_config['mssql'][$i]['port']		=	'';				// port
$MY_db_config['mssql'][$i]['username']	=	'root';			// username
$MY_db_config['mssql'][$i]['password']	=	'';				// user password
$MY_db_config['mssql'][$i]['database']	=	'';				// database name
/****************** END::mssql config zone *******************************/

/****************** STRAT::oracle config zone *******************************/
$i=0;

$MY_db_config['oracle'][$i]['hostname']	=	'localhost';	// hostname
$MY_db_config['oracle'][$i]['port']		=	'';				// port
$MY_db_config['oracle'][$i]['username']	=	'scott';			// username
$MY_db_config['oracle'][$i]['password']	=	'scott4728999';				// user password
$MY_db_config['oracle'][$i]['database']	=	'globals';				// database name
/****************** END::oracle config zone *******************************/

$MY_db_config['default'] = array('mysql',0);				// system default database type and setting
?>
