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
                                        and b.is_admin = 0';

/* get blocks by page type and page id */
$My_Sql['getPageBlocks'] = 'select u.*,
                                   pos.position_name,
                                   m.module_name,
                                   p.using_page_id
                            from #._using_block as u
                            left join #._block as b
                                 on u.block_id = b.block_id
                            left join #._using_block_page as p
                                 on  u.using_block_id = p.using_block_id
                            left join #._module as m
                                 on b.module_id = m.module_id
                            left join #._position pos
                                 on u.position_id = pos.position_id
                            where    b.is_admin = 0
                                 and (u.show_in_type = ' . MY_ALL_PAGE . '
                                 or  (p.page_id = ?
                                     and  u.show_in_type <> ' . MY_EXCLUDE_PAGE . '))
                            order by u.using_block_id desc';

/* get using blocks by ids list */
$My_Sql['getUsingBlockByIds'] = 'select * from #._using_block where using_block_id in ( ? )';

/* get excluding page by block id */
$My_Sql['getExcludePageByBlockId'] = '
    select p.*
    from #._using_block_page as p
    left join #._using_block as b
        on  p.using_block_id = b.using_block_id
    where u.show_in_type = ' . MY_EXCLUDE_PAGE . '
        and u.block_id = ? ';

/* get including page by using block id */
$My_Sql['getIncludePageByUsingBlockId'] = '
    select p.*
    from #._using_block_page as p
    left join #._using_block as b
        on  p.using_block_id = b.using_block_id
    where u.show_in_type = ' . MY_INCLUDE_PAGE . '
        and p.using_block_id = ? ';

/* remove using block */
$My_Sql['removeUsingBlock'] = 'delete from #._using_block where using_block_id = ? ';

/* remove block page by using page id */
$My_Sql['removeBlockPage'] = 'delete from #._using_block_page where using_page_id = ?';

/* set using block property */
$My_Sql['setUsingBlockShowInType'] = 'update #._using_block set show_in_type = ? where using_block_id = ? ';

/* add block page */
$My_Sql['addBlockPage'] = 'insert into #._using_block_page (using_block_id, page_id) values (? , ?) ';

/* add using block */
$My_Sql['addVisibleBlock'] = '
    insert into #._using_block (block_id, block_show_name, position_id, show_in_type)
                      values    (?, ?, ?, ?)';
/* EOF */
