<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName    : index.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-5-7
 *@Homepage    : http://www.yeaheasy.com
 *@Version    : 0.1
 */
defined('YeahEasy')?'':define('YeahEasy', 1);

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
$YE_START_TIME = getMicrotime();
global $ye_kernel, $db;
include("../yeaheasy.ini.php");
$ye_kernel = new ye_kernel;
//$db = $ye_kernel->getClass('database',array('mysql',0));
$db = $ye_kernel->getClass('database','default');

/** check logon **/
if(!empty($_POST['YE_username']) && isset($_POST['YE_password']))
{
}

$ye_kernel->initAdminPage(&$db);
$menuString = '<table border="0" cellspacing="0" cellpadding="0"><tr>';
$menuString .= "<td style='text-indent: 8px;cursor:hand'cursor:hand'><a href='/admin/'>Home</a></td><td width='12'></td>";
/*
foreach($_system['admin_menu'] as $menuType=>$menuInfo)
{
    $menuString .= "[null,'$menuType','index.php',null,''";
    if(count($menuInfo))
    {
        $menuString .= ',';
        foreach($menuInfo as $level2Menu)
        {
            $menuString .= "[null,'".$level2Menu[0]."','index.php',null,''],\n";
        }
        $menuString = substr($menuString,0, strlen($menuString)-1);
    }
    $menuString .="],\n_cmSplit,\n";
};
*/
foreach($_system['admin_menu'] as $menuType=>$menuInfo)
{
    $menuString .= "<td valign='top'><table border='0' cellspacing='0' cellpadding='0' onmouseover=\"YE_show_submenu('YE_sub_$menuType',true)\" onmouseout=\"YE_show_submenu('YE_sub_$menuType',false)\"><tr><td style='cursor:hand' >$menuType</td></tr>\n";
    if(count($menuInfo))
    {
        $menuString .= "<tr><td><div style='display: none; Z-INDEX: 1; position: absolute;text-indent: 4px;' id='YE_sub_$menuType'><table width='100' cellpadding='2' border='0' cellspacing='0' style='text-indent: 4px;'>";
        foreach($menuInfo as $level2Menu)
        {
            $menuString .= "<tr><td style='cursor:hand'  bgcolor='#E4DECD' onmouseover=\"javascript:this.style.backgroundColor='#f5efde'\" onmouseout=\"javascript:this.style.backgroundColor='#E4DECD'\">";
            $menuString .= "<a href='".$level2Menu[1]."'>" . $level2Menu[0] . "</a>\n";
            $menuString .= "</td></tr>\n";
        }
        $menuString .= "</table></div></td></tr>\n";
    }
    $menuString .="</table></td><td width='12'></td>\n";
}
$menuString .= "<td width='300'></td></tr></table>";
$ye_kernel->smartyAssign('menuString',$menuString);
//echo $menuString;
$ye_kernel->displayAdmin("theme_table.html");
exit;


$db = $ye_kernel->getClass('database',array('pgsql',0));
$db->debug = true;
//$db->YE_database(array("pgsql",0));
$db->query("select * from pg_ts_parser");
while($row=$db->fetchRow())
//$db->dbh['pgsql']->query("insert into admin(idt) values(33)");
echo $row[6];
echo "<br>";
//var_dump($db);
//echo $db->queryTimes();
$YE_END_TIME = getMicroTime();
 ?>