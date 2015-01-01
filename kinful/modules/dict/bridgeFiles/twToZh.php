<?php
set_time_limit(0);
$conn = mysql_connect('localhost', 'root', '');
mysql_select_db('dict', $conn);
mysql_query('set names \'utf8\'');

$zhToTwMap = file('./zhTwMap.txt');
foreach($zhToTwMap as $zhToTw) {
    $zhToTw = explode('=', $zhToTw);
    $sql = 'update cet_word_sentence set chinese_sentence = replace(chinese_sentence, \'' . trim($zhToTw[1]) . '\', \'' . trim($zhToTw[0]) . '\')';
    mysql_query($sql);
}
/* EOF */
