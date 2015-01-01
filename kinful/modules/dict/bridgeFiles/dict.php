<?php
set_time_limit(0);
$conn = mysql_connect('localhost', 'root', '');
mysql_select_db('dict', $conn);

$result = mysql_query('select * from cet_word');
$i=0;
while($row = mysql_fetch_array($result)) {
    $row['word_char'] = trim($row['word_char']);
    echo $row['word_char'] . "\n";
    $content = file_get_contents('http://www.dreye.com/dj/index.php?dw=' . $row['word_char']);
    if($content) {
        if(strpos($content, '&#23545;&#19981;&#36215;&#44;&#36825;&#20010;&#21333;&#35789;&#27809;&#25214;&#21040;!')) {
	    $content = file_get_contents('http://www.dreye.com/dj/index.php?dw=' . $row['word_char']);
	}
        file_put_contents('./dreye/' . $row['word_char'] . '.html', $content);
    }
    $content = file_get_contents('http://wap.dict.cn/search.php?q=' . $row['word_char']);
    if($content) {
        file_put_contents('./dict/'. $row['word_char'] . '.html' , $content);
    }
    sleep(3);
}
mysql_close($conn);

/* EOF */
