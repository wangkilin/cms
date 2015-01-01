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

$My_Sql['getPublicChannels'] = "select *
                                    from #._channel
                                    where publish = 1
                                        and support_type & !  = !";

$My_Sql['geChannelByName'] = "select * from #._channel where channel_name = ?";

$My_Sql['geChannelById'] = "select * from #._channel where channel_id = ?";

/* EOF */
