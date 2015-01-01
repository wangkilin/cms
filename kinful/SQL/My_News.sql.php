<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_news.sql.php
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

$My_Sql['getNewsByCategoryId'] = '
            select *
            from #._news
            where category_id = !
            order by on_top desc,
                 weight desc,
                 modified_time desc,
                 created_time desc
            limit !, !';
$My_Sql['getCategoryById']     = 'select * from #._category where category_id = !';
$My_Sql['deleteNewsHitsById']  = 'delete from #._hits where module_id = ! and hit_type = 1 and hit_id = ! ';
$My_Sql['getNewsById']         = 'select * from #._news where news_id = ! ';
$My_Sql['getNewsByKeywordAndCategory'] = "select * from #._news where category_id = ! and title like concat('%', ?, '%') limit !, !";
$My_Sql['getNewsByKeyword']    = "select * from #._news where title like concat('%', ?, '%') limit !, !";
$My_Sql['getAllNews']          = 'select * from #._news limit !, !';

$My_Sql['getNewsCategories']   = 'select * from #._category limit !, !';
$My_Sql['countNewsCategory']   = 'select count(*) as countAll from #._category';
$My_Sql['countNewsByCategoryId']  = 'select count(*) as countAll from #._news where category_id = ! ';

$My_Sql['getRandomNews']       = 'select * from #._news order by rand() limit ! ';
$My_Sql['getRandomNewsByCategoryId'] = 'select * from #._news where category_id = ! order by rand() limit ! ';
$My_Sql['getLatestNews']       = 'select * from #._news order by on_top desc, weight desc, modified_time desc, created_time desc limit ! ';
/* EOF */
