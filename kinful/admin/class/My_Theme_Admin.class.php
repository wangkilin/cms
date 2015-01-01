<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : My_Theme_admin.class.php
 *@Author   : WangKilin
 *@Email    : wangkilin@126.com
 *@Date     : 2010-1-18
 *@Homepage : http://www.kinful.com
 *@Version  : 0.1
 */
defined('Kinful') or die("forbidden");

require_once(MY_ROOT_PATH . '/class/My_Theme.class.php');

class My_Theme_Admin extends My_Theme
{
    /**
     *@Description : get all front themes
     *
     *@return: array
     */
    public function getFrontThemes ()
    {
        global $My_Sql;

        $this->_db->query($My_Sql['getAllFrontThemes']);
        $themes = array();
        while ($row = $this->_db->fetchArray()) {
            $themes [] = $row;
        }

        return $themes;
    }

}// END::class
?>
