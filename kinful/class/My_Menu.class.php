<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_menu.class.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-4-20
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");
define('MY_MENU_CLASS_INC', 1);

require_once(dirname(__FILE__) . '/My_Abstract.class.php');

class My_Menu extends My_Abstract
{
    /****************** START::property zone *************************/

    /**
     *@array    menu information got by last query
     */
    protected $_menuInfo = array();

    protected $_lang = null;

    /****************** END::property zone *************************/


    /****************** START::method zone *************************/
    /**
     *@Description : constructor
     *
     *@return: constractor
     */
    public function __construct(&$db)
    {
         global $My_Lang;
         My_Kernel::loadLang('class','menu');//load class language

         $this->_lang = & $My_Lang->class['menu'];

         if(is_object($db))
             $this->_db = $db;
    }// END::constructor

    /**
     *@Decription : load menus information of some menu list
     *
     *@Param int $menuListId
     *
     *@return: void
     */
    public function getMenusByMenuListId($menuListId)
    {
        global $My_Sql;

        $menus = array();
        $this->_db->query($My_Sql['getMenusByMenuListId'], array($menuListId));

        while ($row = $this->_db->fetchArray()) {
            $menus [] = $row;
        }

        //var_dump($menus);
        return $menus;
    }//END::function

    /**
     *@Decription : load menu list information by id
     *
     *@Param int $menuListId
     *
     *@return: array
     */
    public function getMenuListById($menuListId)
    {
        global $My_Sql;

        $this->_db->query($My_Sql['getMenuListById'], array($menuListId));

        $menu = $this->_db->fetchArray();

        return $menu;
    }//END::function

    public function getMenuById ($menuId)
    {
        global $My_Sql;

        $this->_db->query($My_Sql['getMenuById'], array($menuId));

        $menu = $this->_db->fetchArray();

        return $menu;
    }

    /**
     *@Description : get class error
     *
     *@return: string
     */
    public function getError()
    {
        return $this->_errorStr;
    }//END::function getError

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

    public function get ($property)
    {
        return isset($this->$property) ? $this->$property : null;
    }

    /****************** END::method zone *************************/

}// END::class
?>
