<?php
set_time_limit(0);
$conn = mysql_connect('localhost', 'root', '');
mysql_select_db('dict', $conn);
mysql_query('set names \'utf8\'');

$unicodeMap = file('./unicodeMap.txt');

for($i=0; $i<count($unicodeMap); $i=$i+2) {
    $charList = explode("\t", $unicodeMap[$i]);
    $unicodeList = explode("\t", $unicodeMap[$i+1]);
    foreach($charList as $key=>$char) {
        $unicode = '&#' . hexdec($unicodeList[$key]) . ';';
        $sql = 'update cet_word_sentence set chinese_sentence = replace(chinese_sentence, \'' . $unicode . '\', \'' . $char . '\')';
        mysql_query($sql);
    }
}
