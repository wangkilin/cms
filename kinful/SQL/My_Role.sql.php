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

$My_Sql['getRoleById'] = 'select * from #._roles where role_id = ! ';

$My_Sql['getPermissionByRoleIds'] = '
    select p.*
    from #._role_permission as r
    left join #._permission as p
       on r.permission_id = p.perm_id
    where r.role_id in ( ? )';

/* EOF */
