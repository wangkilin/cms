<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_page.sql.php
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


$My_Sql['getPagesByPageListId']      = 'select p.*,
                                               c.page_category_name
                                        from #._page as p
                                        left join #._page_category as c
                                            on p.page_category_id = c.page_category_id
                                        where p.page_category_id = ?
                                        order by p.page_id';
$My_Sql['getPublicPages'] = "select *
                                    from #._page
                                    where publish = 1
                                        and support_type & !  = !";

$My_Sql['getPageByName'] = "select * from #._page where page_name = ?";

$My_Sql['getPageById'] = "select * from #._page where page_id = ?";

/* EOF */
