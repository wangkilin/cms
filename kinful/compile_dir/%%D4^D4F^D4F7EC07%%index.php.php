<?php /* Smarty version 2.6.6, created on 2010-10-10 12:57:50
         compiled from index.php */ ?>
<?php echo '<?php'; ?>

/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : index.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-1-10
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */

defined('Kinful')?'':define('Kinful', 1);

define('MY_ROOT_PATH', dirname(__FILE__) . '/');	// kinful system root path
define('MY_ROOT_URL', dirname($_SERVER['SCRIPT_NAME']) . '/');

function getMicroTime()
{
    $time = microtime();
    list($msec, $sec) = explode(" ", $time);
    return $sec.substr($msec, 2);
}

function getRunTime($start, $end)
{
    $spent = $end - $start;
    return sprintf("%.8f s",substr_replace(sprintf("%018s",$spent), '.', 10, 0));
}
$MY_START_TIME = getMicrotime();

require_once(MY_ROOT_PATH . 'config/kinful.ini.php');
require_once(MY_ROOT_PATH . 'class/My_Kernel.class.php');

$My_Kernel = new My_Kernel;
$My_Kernel->printPage();

/* EOF */