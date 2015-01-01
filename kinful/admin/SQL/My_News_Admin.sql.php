<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_news_admin.sql.php
 *@Author   : WangKilin
 *@Email    : wangkilin@126.com
 *@Date     : 2010-8-5
 *@Homepage : http://www.kinful.com
 *@Version  : 0.1
 */
defined('Kinful') or die("forbidden");

if (!isset($My_Sql) || !is_array($My_Sql)) {
    $My_Sql = array();
}
$My_Sql['updateNewsPublish']   = 'update #._news set publish = ! where news_id = ! ';
$My_Sql['updateCategoryPublish'] = "update #._category set publish = ! where category_id = ! ";
$My_Sql['updateNews']    = 'update #._news
                               set
                                 title = ?,
                                 publish = !,
                                 category_id = !,
                                 on_top = !,
                                  title_style = !,
                                  weight = !,
                                  title_color = ?,
                                  start_time = ?,
                                  end_time = ?,
                                  reference_url = ?,
                                  meta_key = ?,
                                  meta_desc = ?,
                                  intro_text = ?,
                                  full_text = ?,
                                  modified_time = ?,
                                  modified_by_id = !,
                                  modified_by_name = ?
                               where
                                  news_id = !';

$My_Sql['createNews']          = 'insert into #._news
                                 (title, publish, category_id, on_top,
                                  title_style, weight, title_color, start_time,
                                  end_time, reference_url, meta_key, meta_desc,
                                  intro_text, full_text, created_time, created_by_id,
                                  created_by_name)
                               values
                                 (?, !, !, !,
                                  !, !, ?, ?,
                                  ?, ?, ?, ?,
                                  ?, ?, ?, !,
                                  ?)';
$My_Sql['deleteNewsById'] = 'delete from #._news where news_id = ! ';
$My_Sql['updateCategory'] = 'update #._category set  title = ?, publish = ! where category_id = ! ';
$My_Sql['createCategory'] = 'insert into #._category(title, publish) values (?, !) ';
$My_Sql['deleteNewsCategoryById'] = 'delete from #._news where category_id = ! ';
$My_Sql['deleteCategoryById'] = 'delete from #._category where category_id = ! ';
$My_Sql['increaseNewsItem'] = 'update #._category set item_count = item_count+1 where category_id = !';
$My_Sql['decreaseNewsItem'] = 'update #._category set item_count = item_count-1 where category_id = !';

/* EOF */
