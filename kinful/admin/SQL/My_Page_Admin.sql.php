<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_page_admin.sql.php
 *@Author   : WangKilin
 *@Email    : wangkilin@126.com
 *@Date     : 2010-1-12
 *@Homepage : http://www.kinful.com
 *@Version  : 0.1
 */
defined('Kinful') or die("forbidden");

if (!isset($My_Sql) || !is_array($My_Sql)) {
    $My_Sql = array();
}


$My_Sql['countPageByListId']             = 'select count(*) as count from #._page where page_category_id = ?';
$My_Sql['countPageList']             = 'select count(*) as count from #._page_category';
$My_Sql['updatePagePublish']         = 'update #._page set publish = ? where page_id= ?';
$My_Sql['deletePageById']            = 'delete from #._page where page_id= ?';
$My_Sql['createPage']                = 'insert into #._page (
                                                           page_category_id,
                                                           page_name,
                                                           has_main_block,
                                                           publish,
                                                           template_id,
                                                           support_type,
                                                           notes)
                                        values(?, ?, ?, ?, ?, ?, ?)';
$My_Sql['createPageList']            = 'insert into #._page_category (page_category_name) values (?)';
$My_Sql['getPageListById']           = 'select * from #._page_category where page_category_id = ? ';
$My_Sql['updatePageList']            = 'update #._page_category set page_category_name = ?
                                        where page_category_id = ?';
$My_Sql['updatePage']                = 'update #._page set
                                                           page_name      = ?,
                                                           has_main_block = ?,
                                                           publish        = ?,
                                                           template_id    = ?,
                                                           support_type   = ?,
                                                           notes          = ?
                                        where page_id = ?';



$My_Sql['getPageList']               = 'select c.*, count(p.page_id) as page_list_page_count
                                          from #._page_category as c
                                          left join #._page as p
                                              on c.page_category_id = p.page_category_id
                                          group by c.page_category_id';

$My_Sql['getOnlyPagesByListId']      = 'select * from #._page where page_list_id = ? order by page_order, page_id';

$My_Sql['getAvailablePages']   = 'select * from #._page_list where publish = 1';

$My_Sql['getAllPages']         = ' select l.* , count(m.page_name) as page_list_page_count
                                         from `my_page_list` as l
                                         left join my_page as m
                                              on m.page_list_id = l.page_list_id
                                         group by l.page_list_id';
$My_Sql['deletePageListById']            = 'delete from #._page_category where page_category_id= ?';
$My_Sql['deletePagesByListId']       = 'delete from #._page where page_category_id= ?';




/* EOF */
