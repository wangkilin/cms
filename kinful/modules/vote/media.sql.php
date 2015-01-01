<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_media_admin.sql.php
 *@Author   : WangKilin
 *@Email    : wangkilin@126.com
 *@Date     : 2010-8-5
 *@Homepage : http://www.kinful.com
 *@Version  : 0.1
 */
defined('Kinful') or die("forbidden");
global $My_Sql;
if (!isset($My_Sql) || !is_array($My_Sql)) {
    $My_Sql = array();
}
###### front #########
$My_Sql['getNewsByCategoryId'] = '
            select *
            from #._media
            where category_id = !
            order by on_top desc,
                 weight desc,
                 modified_time desc,
                 created_time desc
            limit !, !';
$My_Sql['getCategoryById']     = 'select * from #._category where category_id = !';
$My_Sql['deleteNewsHitsById']  = 'delete from #._hits where module_id = ! and hit_type = 1 and hit_id = ! ';
$My_Sql['getNewsById']         = 'select * from #._media where news_id = ! ';
$My_Sql['getNewsByKeywordAndCategory'] = "select * from #._media where category_id = ! and title like concat('%', ?, '%') limit !, !";
$My_Sql['getNewsByKeyword']    = "select * from #._media where title like concat('%', ?, '%') limit !, !";
$My_Sql['getAllNews']          = 'select * from #._media limit !, !';

$My_Sql['getNewsCategories']   = 'select * from #._category limit !, !';
$My_Sql['countNewsCategory']   = 'select count(*) as countAll from #._category';
$My_Sql['countNewsByCategoryId']  = 'select count(*) as countAll from #._media where category_id = ! ';

$My_Sql['getRandomNews']       = 'select * from #._media order by rand() limit ! ';
$My_Sql['getRandomNewsByCategoryId'] = 'select * from #._media where category_id = ! order by rand() limit ! ';
$My_Sql['getLatestNews']       = 'select * from #._media order by on_top desc, weight desc, modified_time desc, created_time desc limit ! ';

###### admin #########
$My_Sql['updateNewsPublish']   = 'update #._media set publish = ! where news_id = ! ';
$My_Sql['updateCategoryPublish'] = "update #._category set publish = ! where category_id = ! ";
$My_Sql['updateNews']    = 'update #._media
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

$My_Sql['createNews']          = 'insert into #._media
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
$My_Sql['deleteNewsById'] = 'delete from #._media where news_id = ! ';
$My_Sql['updateCategory'] = 'update #._category set  title = ?, publish = ! where category_id = ! ';
$My_Sql['createCategory'] = 'insert into #._category(title, publish) values (?, !) ';
$My_Sql['deleteNewsCategoryById'] = 'delete from #._media where category_id = ! ';
$My_Sql['deleteCategoryById'] = 'delete from #._category where category_id = ! ';
$My_Sql['increaseNewsItem'] = 'update #._category set item_count = item_count+1 where category_id = !';
$My_Sql['decreaseNewsItem'] = 'update #._category set item_count = item_count-1 where category_id = !';

/* EOF */
