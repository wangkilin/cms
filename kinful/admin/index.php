<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : index.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-1-10
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */

defined('Kinful')?'':define('Kinful', 1);

define('MY_ROOT_PATH', dirname(dirname(__FILE__)) . '/');	// kinful system root path
define('MY_ADMIN_ROOT_PATH', dirname(__FILE__) . '/');	// kinful system root path
define('MY_ROOT_URL', dirname($_SERVER['SCRIPT_NAME']) . '/');

function getMicroTime()
{
    $time = microtime();
    list($msec, $sec) = explode(" ", $time);
    return $sec.substr($msec, 2);
}

function getRunTime($start, $end)
{
    $spent = $end - $start;
    return sprintf("%.8f s",substr_replace(sprintf("%018s",$spent), '.', 10, 0));
}
$MY_START_TIME = getMicrotime();


require_once(MY_ROOT_PATH . 'config/kinful.ini.php');
require_once(MY_ROOT_PATH . 'admin/class/My_Kernel_Admin.class.php');

$My_Kernel = new My_Kernel_Admin;

$My_Kernel->printPage();
$MY_END_TIME = getMicrotime();

echo getRunTime($MY_START_TIME, $MY_END_TIME);
exit;
//$db = $my_kernel->getClass('database',array('mysql',0));

$my_kernel->initSystem($db);

$my_kernel->initFrontPage($db);
$my_kernel->display("theme_table.html");
var_dump($_SESSION['user']);
/*
//Load permission into session
if($_SESSION['global']['perm_time']> time())
{
    $query_permission="select * from #._permission";
    $db->query($query);
    while($row=$db->fetchArray())
    {
        list($perm_name, $perm_value, $module)
    }
}
*/
//Load modules into session
if(!isset($MY_module_info) || !is_array($MY_module_info))
{
    $query_module = "select * from #._module where public = 1";
    $db->query($query_module);
    while($row = $db->fetchArray())
    {
        list($module_id, $name,,$inter_file, $db_type, $dir_name) = $row;
        $_SESSION["$module_id"]='';
    }
}
/*
//Load menu
if(file_exists(MY_ROOT_PATH."my_menu.ini.php"))
    include_once(MY_ROOT_PATH."my_menu.ini.php");
else
{
    $query_menu = "select * from #._menu where publish = 1";
    $db->query($query_menu);
}


$html = my_kernel::loadClass('html');
/**/
$db->query("select * from #._config");
while($l=$db->fetchArray())
{
    echo $l[conf_desc];
    echo "<br>";
}

$db = $my_kernel->getClass('database',array('pgsql',0));
$db->debug = true;
//$db->MY_database(array("pgsql",0));
$db->query("select * from pg_ts_parser");
while($row=$db->fetchRow())
//$db->dbh['pgsql']->query("insert into admin(idt) values(33)");
echo $row[6];
echo "<br>";
//var_dump($db);
//echo $db->queryTimes();
$MY_END_TIME = getMicroTime();
/* check if site is closed by administrator */
if(defined('MY_close_site') && MY_close_site===true)
{
    if(empty($close_site_reason))
        $close_site_reason = "Sorry, we closed the site now. If you have any question, Please contact administator.";
    $my_tpl->assign('close_site_reason',$close_site_reason);
    $my_tpl->display();
    exit;
}

/* security check. if install/index.php exists, it is not secure */
if(is_dir(MY_ROOT_PATH."install") && file_exists(MY_ROOT_PATH."install/index.php"))
{
    if(empty($security_warning))
        $security_warning = "the install directory is still existing, it is dangerous to your site. Please delete or rename it.";
    $my_tpl->assign('security_waring',$security_warning);
    $my_tpl->display;
    exit;
}
/* EOF */
