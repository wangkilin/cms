<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_channel.class.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-4-14
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");
define('MY_theme_CLASS_INC',1);
require_once(dirname(__FILE__) . '/My_Abstract.class.php');

class My_Theme extends My_Abstract
{
    /****************** START::property zone *************************/

    /**
     *@array    theme information got by last query
     */
    protected $_themeInfo = array();

    /****************** END::property zone *************************/


    /****************** START::method zone *************************/
    /**
     *@Description : constructor
     *
     *@return: constractor
     */
    public function __construct($db)
    {
         global $My_Lang;
         My_Kernel::loadLanguage('class','theme');//load class language
         if(is_object($db))
             $this->_db = $db;
    }// END::constructor

    /**
     *@Description : set class debug mode
     *
     *@param : boolean
     *
     *@return: void
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
    }//END::function setDebug

    /**
     *@Description : get theme information by channel id
     *
     *@param : int    theme id
     *
     *@return: mixed(array/false)
     */
    public function getThemeById($themeId)
    {
        global $My_Sql;

        if(@$this->_themeInfo["theme_id"] == $themeId)
            return $this->_themeInfo;

        $this->_db->query($My_Sql['getThemeById'], array($themeId));
        if($row = $this->_db->fetchArray()) {
            $this->_themeInfo = $row;

            return $row;
        }

        return false;
    }//END::function getThemeById

    public function getThemeList()
    {
        global $My_Sql;

        $sql = defined('MY_ADMIN_ROOT_PATH') ? $My_Sql['getAdminThemeList'] : $My_Sql['getFrontThemeList'];
        $themeList = $this->getListBySql($sql, array());
        $defaultThumbnail = MY_ROOT_URL . 'themes/kinful/images/noThumbnail.jpg';
        foreach($themeList as $key => $theme) {
            $_thumbnailPath = MY_ROOT_PATH . 'themes/' . $theme['theme_path'] . '/images/thumbnail.jpg' ;
            $_thumbnail = MY_ROOT_URL . 'themes/' . $theme['theme_path'] . '/images/thumbnail.jpg' ;
            $themeList[$key]['thumbnail'] = file_exists($_thumbnailPath) ? $_thumbnail : $defaultThumbnail;

        }

        return $themeList;
    }
    /****************** END::method zone *************************/

}// END::class
?>
