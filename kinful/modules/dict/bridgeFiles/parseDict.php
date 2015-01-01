<?php
set_time_limit(0);
$conn = mysql_connect('localhost', 'root', '');
mysql_select_db('dict', $conn);
mysql_query('set names \'utf8\'');

$dirDict = opendir('./dict');
while(false!==($file=readdir($dirDict))) {
    if($file=='.' || $file=='..') {
        continue;
    }
    $word = basename($file, '.html');
    $sql = 'select id from cet_word where word_char = \'' . $word . '\'';
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $wordId = $row['id'];
    $content = file_get_contents('./dict/' . $file);
    $content = explode('&#20363;&#21477;&#19982;&#29992;&#27861;:<br/>', $content);
    if(!isset($content[1])) {
        continue;
    }
    $content = explode('</p>', $content[1], 2);
    $content = explode('<br/>', $content[0]);
    for($i=0;$i<count($content);$i=$i+2) {
        if(!isset($content[$i+1])) {
            continue;
        }
        //echo $content[$i];
        //echo "::::::::::";
        //echo $content[++$i];
        //echo "\n";
        $sql = 'insert into cet_word_sentence values(\'' . $wordId . '\',\'' .addslashes(trim($content[$i])) . '\',\'' . addslashes(trim($content[$i+1])) . '\',\'dict\',\'\')';
        mysql_query($sql);
    }

}
/* EOF */
