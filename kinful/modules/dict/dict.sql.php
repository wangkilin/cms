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
$My_Sql['getDictByCategoryId'] = '
            select *
            from #._media
            where category_id = !
            order by on_top desc,
                 weight desc,
                 modified_time desc,
                 created_time desc
            limit !, !';
$My_Sql['getCategoryById']     = 'select * from #._category where category_id = !';
$My_Sql['deleteDictHitsById']  = 'delete from #._hits where module_id = ! and hit_type = 1 and hit_id = ! ';
$My_Sql['getDictById']         = 'select * from #._media where dict_id = ! ';
$My_Sql['getDictByKeywordAndCategory'] = "select * from #._media where category_id = ! and title like concat('%', ?, '%') limit !, !";
$My_Sql['getDictByKeyword']    = "select * from #._media where title like concat('%', ?, '%') limit !, !";
$My_Sql['getAllDict']          = 'select * from #._media limit !, !';

$My_Sql['getDictCategories']   = 'select * from #._category limit !, !';
$My_Sql['countDictCategory']   = 'select count(*) as countAll from #._category';
$My_Sql['countDictByCategoryId']  = 'select count(*) as countAll from #._media where category_id = ! ';

$My_Sql['getRandomDict']       = 'select * from #._media order by rand() limit ! ';
$My_Sql['getRandomDictByCategoryId'] = 'select * from #._media where category_id = ! order by rand() limit ! ';
$My_Sql['getLatestDict']       = 'select * from #._media order by on_top desc, weight desc, modified_time desc, created_time desc limit ! ';

###### admin #########
$My_Sql['updateDictPublish']   = 'update #._media set publish = ! where dict_id = ! ';
$My_Sql['updateCategoryPublish'] = "update #._category set publish = ! where category_id = ! ";
$My_Sql['updateDict']    = 'update #._media
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
                                  dict_id = !';

$My_Sql['createDict']          = 'insert into #._media
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
$My_Sql['deleteDictById'] = 'delete from #._media where dict_id = ! ';
$My_Sql['updateCategory'] = 'update #._category set  title = ?, publish = ! where category_id = ! ';
$My_Sql['createCategory'] = 'insert into #._category(title, publish) values (?, !) ';
$My_Sql['deleteDictCategoryById'] = 'delete from #._media where category_id = ! ';
$My_Sql['deleteCategoryById'] = 'delete from #._category where category_id = ! ';
$My_Sql['increaseDictItem'] = 'update #._category set item_count = item_count+1 where category_id = !';
$My_Sql['decreaseDictItem'] = 'update #._category set item_count = item_count-1 where category_id = !';

/* EOF */
