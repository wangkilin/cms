<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : My_Menu.class.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-4-20
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");

require_once(MY_ROOT_PATH . '/class/My_Menu.class.php');

class My_Menu_Admin extends My_Menu
{
    /****************** START::property zone *************************/


    /****************** END::property zone *************************/


    /****************** START::method zone *************************/

    /**
     * get all menu lists
     */
    public function getAllModuleMenus ()
    {
        global $my_client_type;
        global $My_Sql;

        switch ($my_client_type) {
            case MY_CLIENT_IS_WAP:
                $clientType = MY_SUPPORT_WAP;
                break;

            case MY_CLIENT_IS_RSS:
                $clientType = MY_SUPPORT_RSS;
                break;

            default:
                $clientType = MY_SUPPORT_WEB;
                break;
        }

        $menus = array();
        $this->_db->query($My_Sql['getAllModuleMenus']);

        while ($row = $this->_db->fetchArray()) {
            $menus [] = $row;
        }

        //var_dump($menus);
        return $menus;
    }

    /**
     * get menu lists total number
     *
     * @return int Total number of menu lists
     */
    public function getTotalMenuList()
    {
        global $My_Sql;

        return $this->getTotal($My_Sql['countMenuList']);
    }

    /**
     * get total menu number by menu list id
     *
     * @param int $menuListId The menu list id
     *
     * @return int Total number
     */
    public function getTotalMenuByListId($menuListId)
    {
        global $My_Sql;

        return $this->getTotal($My_Sql['countMenuByListId'], array($menuListId));
    }

    /**
     * get total number from the input SQL and parameters
     *
     * @param string $sql The sql to be executed
     * @param array  $paramsList The parameters list
     *
     * @return int Total number
     */
    protected function getTotal ($sql, $paramsList=array())
    {
        $return = 0;

        if (count((array)$paramsList)) {
            $this->_db->query($sql, $paramsList);
        } else {
            $this->_db->query($sql);
        }

        if ($row = $this->_db->fetchArray()) {
            $return = (int)$row['count'];
        }

        return $return;
    }

    /**
     * change menu publish status by menu id
     *
     * @param int $menuId The menu id
     * @param int $publishMode The publish mode. 0/1
     */
    public function updateMenuPublish ($menuId, $publishMode)
    {
        global $My_Sql;

        $this->_db->query($My_Sql['updateMenuPublish'], array($publishMode, $menuId));
    }

    /**
     * update menu information by menu id
     *
     * @param int $menuId The menu id
     * @param array $menuInfo The menu information
     */
    public function updateMenu ($menuId, $menuInfo)
    {
        global $My_Sql;

        if (isset($menuInfo['parent_id'], $menuInfo['menu_name'], $menuInfo['menu_link'],
            $menuInfo['open_mode'], $menuInfo['publish'])) {

            $this->_db->query($My_Sql['updateMenu'], array((int)$menuInfo['parent_id'], (string)$menuInfo['menu_name'], (string)$menuInfo['menu_link'],
            (int)$menuInfo['open_mode'], (int)$menuInfo['publish'], $menuId));
        }
    }

    /**
     * create menu
     *
     * @param array $menuInfo The menu information
     */
    public function createMenu ($menuInfo)
    {
        global $My_Sql;

        if (isset($menuInfo['parent_id'], $menuInfo['menu_name'], $menuInfo['menu_link'],
            $menuInfo['open_mode'], $menuInfo['publish'], $menuInfo['menu_list_id'])) {

            $this->_db->query($My_Sql['createMenu'], array((int)$menuInfo['parent_id'], (string)$menuInfo['menu_name'], (string)$menuInfo['menu_link'],
            (int)$menuInfo['open_mode'], (int)$menuInfo['publish'], (int)$menuInfo['menu_list_id']));
        }
    }

    /**
     * delete a menu by menu id
     *
     * @param int $menuId The menu id to be deleted
     */
    public function deleteMenuById ($menuId)
    {
        global $My_Sql;

        $this->_db->query($My_Sql['deleteMenuById'], array($menuId));
    }

    /**
     * change menu list publish status by menu list id
     *
     * @param int $menuListId The menu list id
     * @param int $publishMode The publish mode. 0/1
     */
    public function updateListPublish ($menuListId, $publishMode)
    {
        global $My_Sql;

        $this->_db->query($My_Sql['updateListPublish'], array($publishMode, $menuListId));
    }

    /**
     * update menu list information by menu list id
     *
     * @param int $menuListId The menu list id
     * @param array $menuListInfo The menu list information
     */
    public function updateMenuList ($menuListId, $menuListInfo)
    {
        global $My_Sql;

        if (isset($menuListInfo['menu_list_name'], $menuListInfo['publish'])) {

            $this->_db->query($My_Sql['updateMenuList'], array((string)$menuListInfo['menu_list_name'], (int)$menuListInfo['publish'], $menuListId));
        }
    }

    /**
     * create menu list
     *
     * @param array $menuListInfo The menu list information
     */
    public function createMenuList ($menuListInfo)
    {
        global $My_Sql;

        if (isset($menuListInfo['menu_list_name'], $menuListInfo['publish'])) {

            $this->_db->query($My_Sql['createMenuList'], array((string)$menuListInfo['menu_list_name'], (int)$menuListInfo['publish']));
        }
    }

    /**
     * delete a menu list by menu list id, also delete the menus of such menu list
     *
     * @param int $menuListId The menu list id to be deleted
     */
    public function deleteListById ($menuListId)
    {
        global $My_Sql;

        $this->_db->query($My_Sql['deleteListById'], array($menuListId));
        $this->_db->query($My_Sql['deleteMenusByListId'], array($menuListId));
    }

    /**
     * update menus' order
     *
     * @param int $menuListId The menu list id of which menu belong to
     * @param int $menuId The menu id
     * @param int $direction Up or down? 1/-1
     */
    public function updateMenuOrder ($menuListId, $menuId, $direction)
    {
        global $My_Sql;

        $this->_db->query($My_Sql['getOnlyMenusByListId'], array($menuListId));

        if (1 == $direction) {
            while ($row = $this->_db->fetchArray()) {
                if ($row['menu_id'] == $menuId && isset($tmpRow)) {
                    $fromOrder = $row['menu_order'];
                    $fromId    = $menuId;
                    $toOrder   = $tmpRow['menu_order'];
                    $toId      = $tmpRow['menu_id'];
                    break;
                }

                $tmpRow = $row;
            }
        } else if (-1 == $direction) {
            while ($row = $this->_db->fetchArray()) {
                if ($row['menu_id'] == $menuId && isset($tmpRow)) {
                    $fromOrder = $row['menu_order'];
                    $fromId    = $menuId;
                    if ($row = $this->_db->fetchArray()) {
                        $toOrder   = $row['menu_order'];
                        $toId      = $row['menu_id'];
                    }
                    break;
                }

                $tmpRow = $row;
            }
        }

        if (isset($fromOrder, $fromId, $toOrder, $toId)) {
            $this->_db->query($My_Sql['updateMenuOrder'], array($fromOrder, $toId));
            $this->_db->query($My_Sql['updateMenuOrder'], array($toOrder, $fromId));
        }
    }

    /****************** END::method zone *************************/

}// END::class

/* EOF */
