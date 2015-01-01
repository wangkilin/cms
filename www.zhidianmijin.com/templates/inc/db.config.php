<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : db.config.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2007-1-10
 *@Homepage	: http://www.yeaheasy.com
 *@Version	: 0.1
 */
global $YE_db_config;
$YE_db_config=array();
/****************** STRAT::mysql config zone *******************************/
$i=0;

$YE_db_config[$i]['dbtype']		=	'mysql';		// database type   
$YE_db_config[$i]['hostname']	=	'localhost';	// hostname
$YE_db_config[$i]['port']		=	'3308';			// port
$YE_db_config[$i]['username']	=	'root';			// username
$YE_db_config[$i]['password']	=	'4728999';		// user password
$YE_db_config[$i]['database']	=	'ming';		// database name
/****************** END::mysql config zone *******************************/

/****************** STRAT::pgsql config zone *******************************/
$i++;

$YE_db_config[$i]['dbtype']		=	'pgsql';		// database type  
$YE_db_config[$i]['hostname']	=	'localhost';	// hostname
$YE_db_config[$i]['port']		=	'5432';			// port
$YE_db_config[$i]['username']	=	'postgres';		// username
$YE_db_config[$i]['password']	=	'4728999';		// user password
$YE_db_config[$i]['database']	=	'yeaheasy';		// database name
/****************** END::pgsql config zone *******************************/

/****************** STRAT::mssql config zone *******************************/
$i++;

$YE_db_config[$i]['dbtype']		=	'mssql';		// database type  
$YE_db_config[$i]['hostname']	=	'localhost';	// hostname
$YE_db_config[$i]['port']		=	'';				// port
$YE_db_config[$i]['username']	=	'root';			// username
$YE_db_config[$i]['password']	=	'';				// user password
$YE_db_config[$i]['database']	=	'';				// database name
/****************** END::mssql config zone *******************************/

/****************** STRAT::oracle config zone *******************************/
$i++;

$YE_db_config[$i]['dbtype']		=	'oracle';		// database type  
$YE_db_config[$i]['hostname']	=	'localhost';	// hostname
$YE_db_config[$i]['port']		=	'';				// port
$YE_db_config[$i]['username']	=	'scott';			// username
$YE_db_config[$i]['password']	=	'scott4728999';				// user password
$YE_db_config[$i]['database']	=	'globals';				// database name
/****************** END::oracle config zone *******************************/

?>
