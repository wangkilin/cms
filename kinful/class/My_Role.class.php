<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : My_Role.class.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2010-9-13
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die("forbidden");

require_once(dirname(__FILE__) . '/My_Abstract.class.php');

class My_Role extends My_Abstract
{
    protected $_roleInfo = array();

    const WITH_PERMISSION_INFO = 4;

    public function __construct($db)
    {
        $this->_db = $db;
        parent::__construct('role');
    }

    public function getRoleById($roleId)
    {
        global $My_Sql;

        if(@$this->_roleInfo['role_id']!=$roleId) {
            return $this->_roleInfo;
        }

        $this->_db->query($My_Sql['getRoleById'], array($roleId));
        if($row=$this->_db->fetchArray()) {
            $this->_roleInfo = $row;
        }

        return $this->_roleInfo;
    }

    public function getRoleByIds($roleIds)
    {
        global $My_Sql;
    }

    public function getPermissionByRoleId($roleId)
    {
        global $My_Sql;

        $permissions = $this->getPermissionByRoleIds(array($roleId));
        $permission = isset($permissions[0]) ? $permissions[0] : array();

        return $permission;
    }

    public function getPermissionByRoleIds($roleIdsList)
    {
        global $My_Sql;

        settype($roleIdsList, 'array');
        foreach($roleIdsList as $key=>$roleId) {
            $roleIdsList[$key] = intval($roleId);
        }

        return $this->getListBySql($My_Sql['getPermissionByRoleIds'], array(join(',', $roleIdsList)));
    }

}
/* EOF */