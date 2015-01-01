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

$My_Sql['getMenusByMenuListId']      = 'select m.*,
                                               l.menu_list_name
                                        from #._menu as m
                                        left join #._menu_list as l
                                            on m.menu_list_id = l.menu_list_id
                                        where m.menu_list_id = ?
                                        order by m.parent_id, m.menu_order, m.menu_id';

$My_Sql['getOnlyMenusByListId']      = 'select * from #._menu where menu_list_id = ? order by menu_order, menu_id';

$My_Sql['getAvailableModuleMenus']   = 'select * from #._menu_list where publish = 1';

$My_Sql['getAllModuleMenus']         = ' select l. * , count(m.menu_name) as menu_list_menu_count
                                         from `my_menu_list` as l
                                         left join my_menu as m
                                              on m.menu_list_id = l.menu_list_id
                                         group by l.menu_list_id';

$My_Sql['countMenuList']             = 'select count(*) as count from #._menu_list';
$My_Sql['countMenuByListId']             = 'select count(*) as count from #._menu where menu_list_id = ?';

$My_Sql['updateMenuPublish']         = 'update #._menu set publish = ? where menu_id= ?';
$My_Sql['deleteMenuById']            = 'delete from #._menu where menu_id= ?';


$My_Sql['updateListPublish']         = 'update #._menu_list set publish = ? where menu_list_id= ?';
$My_Sql['deleteListById']            = 'delete from #._menu_list where menu_list_id= ?';
$My_Sql['deleteMenusByListId']       = 'delete from #._menu where menu_list_id= ?';

$My_Sql['updateMenuOrder']           = 'update #._menu set menu_order = ? where menu_id = ?';

$My_Sql['getMenuListById']           = 'select * from #._menu_list where menu_list_id = ? ';

$My_Sql['updateMenu']                = 'update #._menu set parent_id = ?,
                                                           menu_name = ?,
                                                           menu_link = ?,
                                                           open_mode = ?,
                                                           publish   = ?
                                        where menu_id = ?';
$My_Sql['createMenu']                = 'insert into #._menu (parent_id ,
                                                           menu_name,
                                                           menu_link,
                                                           open_mode,
                                                           publish,
                                                           menu_list_id)
                                        values(?, ?, ?, ?, ?, ?)';

$My_Sql['updateMenuList']            = 'update #._menu_list set menu_list_name = ?,
                                                                publish        = ?
                                        where menu_list_id = ?';

$My_Sql['createMenuList']            = 'insert into #._menu_list (menu_list_name, publish) values (?, ?)';

/* EOF */
