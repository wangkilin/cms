<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_block_admin.sql.php
 *@Author   : WangKilin
 *@Email    : wangkilin@126.com
 *@Date     : 2007-4-14
 *@Homepage : http://www.kinful.com
 *@Version  : 0.1
 */
defined('Kinful') or die("forbidden");

if (!isset($My_Sql) || !is_array($My_Sql)) {
    $My_Sql = array();
}

$My_Sql['getPublicBlocks'] = "select u.*,
                                           b.block_name,
                                           b.module_id,
                                           b.params
                                    from #._using_block  as u
                                    left join #._using_block_page as p
                                        on u.using_block_id = p.using_block_id
                                    left join #._block as b
                                        on u.block_id = b.block_id
                                    where (u.show_in_type = " . MY_ALL_PAGE . ' or
                                        (  p.page_id = ?
                                           and  u.show_in_type <> ' . MY_EXCLUDE_PAGE . '))
                                        and u.publish = 1
                                        and b.support_type & ! >0
                                        and b.is_admin = 1';

/* 获取前台显示块 */
$My_Sql['getAllFrontBlocks'] = "select * from #._block where is_admin = 0 ";

/* get common blocks which every page will use */
$My_Sql['getPageCommonBlocks'] = '
                            select u.*,
                                   p.position_name,
                                   m.module_name
                            from #._using_block as u
                            left join #._block as b
                                 on  u.block_id = b.block_id
                            left join #._module as m
                                 on  b.module_id = m.module_id
                            left join #._position as p
                                 on  u.position_id = p.position_id
                            where    u.show_in_type = ' . MY_ALL_PAGE . '
                            order by u.using_block_id desc';
/* EOF */
