<?php
set_time_limit(0);
$conn = mysql_connect('localhost', 'root', '');
mysql_select_db('dict', $conn);
mysql_query('set names \'utf8\'');

$dirDreye = opendir('./dreye');
while(false!==($file=readdir($dirDreye))) {
    if($file=='.' || $file=='..') {
        continue;
    }
    $word = basename($file, '.html');
    $sql = 'select id from cet_word where word_char = \'' . $word . '\'';
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $wordId = $row['id'];
    $content = file_get_contents('./dreye/' . $file);
    $content = explode('<br><br>', $content, 2);
    $content = explode('<div>', trim($content[1]), 2);
    $content = explode('<br><br>', trim(trim($content[0]), '<br>'));
    for($i=0;$i<count($content);$i++) {
        $items = explode('<br>', strip_tags($content[$i],'<br>' ));
        if(!isset($items[1])) continue;
        //echo trim($items[0]);
        //echo "::::::::::";
        //echo trim(trim($items[1]), '&nbsp;');
        //echo "\n";
        $sql = 'insert into cet_word_sentence values( \'' . $wordId . '\',\'' .addslashes(trim($items[0])) . '\',\'' . addslashes(trim(trim($items[1]), '&nbsp;')) . '\',\'dreye\', \'\')';
        mysql_query($sql);
    }

}
/* EOF */
