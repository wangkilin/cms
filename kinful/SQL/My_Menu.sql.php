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

$My_Sql['getMenusByMenuListId'] = 'select m.*,
                       l.menu_list_name
                from #._menu as m
                left join #._menu_list as l
                    on m.menu_list_id = l.menu_list_id
                where m.publish = 1
                    and l.publish  = 1
                    and m.menu_list_id = ? ';
$My_Sql['getMenuById'] = 'select * from #._menu where menu_id = ?';
/* EOF */
