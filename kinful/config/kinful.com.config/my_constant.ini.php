<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_constant.ini.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-4-14
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");

define('MY_CLIENT_IS_WEB', 'web');  // client is requesting WEB content
define('MY_CLIENT_IS_WAP', 'wap');  // client is requesting WAP content
define('MY_CLIENT_IS_RSS', 'rss');  // client is requesting RSS content

define('MY_MODULE_REQUEST_DESC', 'module');    // access module page flag. use the module theme and print the page content
define('MY_PAGE_REQUEST_DESC',   'page');      // access customize page flag. use the page theme and print the page content
define('MY_HOME_REQUEST_DESC',   '.');         // access home page flag. use the home theme and print the page content


define('MY_MODULE_REQUEST',    0x04);
define('MY_PAGE_REQUEST',    0x02);
define('MY_HOME_PAGE',     0x01);
define('MY_INCLUDE_PAGE',  0x02);    // access customize page flag. use the page theme and print the page content
define('MY_EXCLUDE_PAGE',  0x04);    // access module page flag. use the module theme and print the page content
define('MY_HOME_REQUEST',    0x01);    // access home page flag. use the home theme and print the page content
define('MY_ALL_PAGE',        0xff);
define('MY_COMMON_PAGE_ID', -1);   // 公用的page id。 首页是0， 其他是系统数据库分配

define('MY_SUPPORT_NONE', 0x00);
define('MY_SUPPORT_WEB', 0x01);
define('MY_SUPPORT_WAP', 0x02);
define('MY_SUPPORT_RSS', 0x04);
define('MY_SUPPORT_ALL', 0xff);



define('MY_SESSION_IN_FILE', 2);
define('MY_SESSION_IN_DB',   1);
define('MY_SESSION_METHOD', MY_SESSION_IN_DB);// storing session method.


define('MY_TABLE_PREFIX', 'my');	// data table will start with it

define('MY_DEFAULT_LANGUAGE', 'cn');		// default language

define('MY_SITE_NAME', 'Yeah,easy!');		// site name will be shown in the title

define('MY_CONFIG_IN_FILE', 0);				// if load configuration from config file

define('MY_MODULE_IN_FILE', 1);				// if 1, load modules information from config file,else load from DB
define('MY_PAGE_IN_FILE', 1);				// if 1, load pages information from config file,else load from DB

define('MY_LOAD_MAIN_BLOCK_CONTENT', 1);

define('MY_PARAM_SEPARATOR', "\n");  // separator module used for joining the parameters that to be store into DB.
define('MY_INT_SEPARATOR', ','); // separator used for joinng the integar characters

/* EOF */
