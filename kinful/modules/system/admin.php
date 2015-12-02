<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : system.module.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2007-2-6
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die("forbidden");

require_once (dirname(__FILE__) . '/class/module_system_admin.class.php');

function system_admin ($moduleInfo, $parameterExpressionString = null)
{
    global $my_client_type;

    $MyNewsModule = new My_System_Module_Admin ($moduleInfo);
    if ($parameterExpressionString) {
        $_set = MY_LOAD_MAIN_BLOCK_CONTENT === $parameterExpressionString ? 'setFinalPage' : 'setParams';

        $MyNewsModule->$_set($parameterExpressionString);
    }

    switch ($my_client_type) {
        case MY_CLIENT_IS_WAP:

            return $MyNewsModule->returnWap ();

            break;

        case MY_CLIENT_IS_RSS:

            return $MyNewsModule->returnRss ();

            break;

        default:

            return $MyNewsModule->returnWeb ();

            break;
    }
}

/* EOF */