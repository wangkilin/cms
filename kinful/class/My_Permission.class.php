<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : My_Permission.class.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2010-9-13
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die("forbidden");

require_once(dirname(__FILE__) . '/My_Abstract.class.php');

class My_Permission extends My_Abstract
{
    protected $_permissionInfo = array();

    public function __construct($db)
    {
        $this->_db = $db;
        parent::__construct('permission');
    }

    public function getPermissionById($permissionId)
    {
        global $My_Sql;

        if(@$this->_permissionInfo['permission_id']!=$permissionId) {
            return $this->_permissionInfo;
        }

        $this->_db->query($My_Sql['getPermissionById'], array($permissionId));
        if($row=$this->_db->fetchArray()) {
            $this->_permissionInfo = $row;
        }

        return $this->_permissionInfo;
    }
}
/* EOF */