<?php

$dirDict = opendir('./dict');
$i=0;
while(false!==($file = readdir($dirDict))) {
    if($file=='.' || $file=='..') {
        continue;
    }
    $i++;

    $fileInfo = basename($file, '.html');
    //echo $fileInfo;if($i++<5) continue; else exit;
    if(is_file('./dreye/' . $fileInfo . '.html')) {
        //echo './dreye/' . $fileInfo . '.html' . "\n";
        continue;
    } else {
        echo $file . "-------------\n";
    }
    $row = array('word_char'=> $fileInfo);
    $row['word_char'] = trim($row['word_char']);
    echo $file . $row['word_char'] . "\n";
    $content = file_get_contents('http://www.dreye.com/dj/index.php?dw=' . $row['word_char']);
    if($content) {
        if(strpos($content, '&#23545;&#19981;&#36215;&#44;&#36825;&#20010;&#21333;&#35789;&#27809;&#25214;&#21040;!')) {
            $content = file_get_contents('http://www.dreye.com/dj/index.php?dw=' . $row['word_char']);
        }
        file_put_contents('./dreye/' . $row['word_char'] . '.html', $content);
    }
    sleep(3);
}
closedir($dirDict);
echo $i . "===============\n";

$reTryDict = file('reTryDict.log');
foreach($reTryDict as $file) {
    $file = trim($file);
    $fileInfo = basename($file, '.html');
    $row = array('word_char'=> $fileInfo);
    $row['word_char'] = trim($row['word_char']);
    echo $file . "\n";
    $content = file_get_contents('http://wap.dict.cn/search.php?q=' . $row['word_char']);
    if($content) {
        file_put_contents('./dict/'. $row['word_char'] . '.html' , $content);
    }
}


/* EOF */
