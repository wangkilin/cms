<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : .php
 *@Author   : WangKilin
 *@Email    : wangkilin@126.com
 *@Date     : 
 *@Homepage : http://www.yeaheasy.com
 *@Version  : 0.1
 */
class test
{
    function getInstance($cc)
    {
        echo "hello";
    }
}

if (function_exists('test::getInstance')) {
    test::getInstance();
}

if (is_callable(array('test', 'getInstance'))) {
    test::getInstance('cc'); echo  'dddd';
}
 ?>