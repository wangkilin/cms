<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_.sql.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-4-14
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");

if (!isset($My_Sql) || !is_array($My_Sql)) {
    $My_Sql = array();
}

$My_Sql['getModuleById'] = 'select * from #._module where module_id = ?';
$My_Sql['getModuleByName'] = 'select * from #._module where module_name = ? and publish = 1';

/* get all public modules */
$My_Sql['getAllPublicModules'] = 'select * from #._module where publish = 1';

/* EOF */
