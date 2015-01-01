<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_user.class.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-1-24
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");

require_once(dirname(__FILE__) . '/My_Abstract.class.php');

class My_User extends My_Abstract
{
    /****************** START::property zone *************************/

    /**
     *@array    user information
     */
    private $_userInfo;

    /**
     *@string    groups separator
     */
    private $_groupSeparator = ',';

    /**
     *@object    group object handler
     */
    private $_groupObj;

    const WITH_GROUP_INFO = 1;
    const WITH_ROLE_INFO  = 2;
    const WITH_PERMISSION_INFO = 4;


    /****************** END::property zone *************************/

    /****************** START::method zone *************************/
    /**
     *@Decription : load specify type database class
     *
     *@Param : string    database type
     *
     *@return: constructor
     */
    public function MY_user($db)
    {
         global $_system;
         global $My_Kernel;
         My_Kernel::loadLang('class','user');//load class language
         $this->_db = $db;
         $this->_groupObj = $My_Kernel->getClass('group',$db);
         if(isset($_system['db_int_seperator']))
             $this->_groupSeparator = $_system['db_int_seperator'];
    }

    /**
     *@Description : split groups string got from DB
     *
     *@Param : string    groups string
     *
     *@Return: array
     */
    private function _splitGroupString($groupString)
    {
        $groups = explode($this->_groupSeparator,substr($groupString,1,strlen($groupString)-2));
        return $groups;
    }//END::function _splitGroupString

    /**
     *@Description : get user info by id
     *
     *@Param : INT    user id
     *
     *@return: array
     */
    public function getUserById($userId, $withMoreInfo=0)
    {
        global $My_Sql;

        if($this->_userInfo['user_id'] == $userId) {
            return $this->_userInfo;
        }

        $this->_db->query($My_Sql['getUserById'], array($userId));
        if($row = $this->_db->fetchArray()) {
            $this->_userInfo = $row;
            if($withMoreInfo) {
                $this->_loadUserMoreInfo();
            }

            return $this->_userInfo;
        }

        return false;
    }//END::function getUserById

    protected function _loadUserMoreInfo()
    {
        global $My_Sql;
        global $My_Kernel;

        if(!empty($this->_userInfo)) {
            if($this->_userInfo['group_ids']) {
                $this->_userInfo['group_ids'] = $this->_splitGroupString($this->_userInfo['group_ids']);
            }
            $this->_userInfo['group'] = $this->_groupObj->getGroupByIds($this->_userInfo['group_ids']);
            $this->_userInfo['role_ids'] = $this->_groupObj->getRolesByGroupIds($this->_userInfo['group_ids'], true);
            $this->_userInfo['permission'] = $My_Kernel->getClass('role', $this->_db)
                                                       ->getPermissionByRoleIds($this->_userInfo['role_ids']);

        }
    }

    /**
     *@Decription : get user info by name
     *
     *@Param : string    user name
     *
     *@return: array
     */
    public function getUserByName($userName, $withMoreInfo=false)
    {
        if($this->_userInfo['uid'] == $userName) {
            return $this->_userInfo;
        }
        $queryUser="select * from #._user where uid = '$userName'";
        $this->_db->query($queryUser);

        if($row = $this->_db->fetchArray()) {
            $this->_userInfo = $row;
            if($withMoreInfo) {
                $this->_loadUserMoreInfo();
            }

            return $this->_userInfo;
        }

        return false;
    }//END::function getUserByName

    /**
     * public function logout()
     *
     */
    public function logout()
    {
        return @session_unregister('my_user');
    }

    /**
     *@Decription : user login
     *
     *@Param : user name
     *@Param : password
     *
     *@return: int (0: success; 1:user not exists; 2:password wrong)
     */
    public function login($username, $password)
    {
        if(($userInfo=$this->getUserByName($username))===false)
            return 1;
        if($userInfo['pwd']!==My_Kernel::encryptString($password)) {
            return 2;
        }
        //load user information into session
        $this->_initUserSession($userInfo);

        return 0;
    }//END::function login

    /**
     *@Decription : initialize user session
     *
     *@Param : array    user information
     *
     *@return: void
     */
    private function _initUserSession($userInfo)
    {
        global $My_Kernel;

        if(is_array($userInfo)) {
            $_SESSION['my_user'] = $userInfo;
            $themeInfo = $userInfo['theme']?$My_Kernel->getClass('theme', $this->_db)->getThemeById($userInfo['theme']):null;
            if(is_array($themeInfo)) {
                $_SESSION['my_user']['front_theme'] = $themeInfo['theme_name'];
            } else {
                $_SESSION['my_user']['front_theme'] = 'kinful';
            }
            $themeInfo = $userInfo['admin_theme']?$My_Kernel->getClass('theme', $this->_db)->getThemeById($userInfo['admin_theme']):null;
            if(is_array($themeInfo)) {
                $_SESSION['my_user']['admin_theme'] = $themeInfo['theme_name'];
            } else {
                $_SESSION['my_user']['admin_theme'] = 'kinful';
            }
        }

    }//END::function _initUserSession

    /**
     *@Decription : encrypt string
     *
     *@Param :
     *
     *@return:
     */

    /**
     *@Decription : add new user
     *
     *@Param : array    user's information
     *
     *@return: boolean
     */
    public function addNewUser ($userInfo)
    {
        if(!is_array($userInfo))
            return false;
        if(!$this->_checkUserInfo($userInfo))
            return false;
        $fields = '';// fields name
        $values = '';// fields related values
        foreach($userInfo as $key => $value)
        {
            $fields .=$key.", ";
            $values .="'".$value."', ";
        }
        $fields = substr($fields, 0, strlen($fields)-2);
        $values = substr($values, 0, strlen($values)-2);
        $queryNew = "insert into #._user ($fields) values ($values)";
        $this->_db->query($queryNew);
        if($this->_db->affectedRows())
            return true;

        return false;
    }//END::function addNewUser

    /**
     *@Description : check if user information in  array is valid
     *
     *@Param : array    user's information
     *
     *@return: boolean
     */
    private function _check (& $userInfo)
    {
        $validKeys = array('uid' , 'pwd' , 'gender' , 'age' , 'email' , 'url' , 'photo' , 'reg_time' , 'reg_ip' , 'theme' , 'email_open' , 'email_ad' , 'last_login' , 'last_ip' , 'rank' , 'posts' , 'gid' , 'system_user' , 'super_admin');

        foreach($userInfo as $key => $value)
        {
            if(!in_array(strtolower($key),$validKeys))
                return false;
            $userInfo["$key"] = trim($userInfo["$key"]);
        }
        return true;
    }//END::function _check

    /**
     *@Decription : modify user information by user name
     *
     *@Param : string    user name
     *@Param : array    user's new information
     *
     *@return: boolean
     */
    public function modifyUserByName ($userName, $newInfo)
    {
        if($userName && is_array($newInfo))
        {
            if(!$this->_check($newInfo))
            {
                $this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['user']['validUserInfo'];
                return false;
            }

            $updateSql = '';
            foreach($newInfo as $key => $value)
            {
                $updateSql .= "$key = '$value',";
            }
            $updateSql = substr($updateSql, 0 ,strlen($updateSql));
            $updateStr = "update #._user set $updateSql where uid = '$userName'";
            $this->_db->query($updateStr);
            if(!$this->_db->affectedRows())
            {
                $this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['user']['modifyUserFail'];
                return false;
            }
            return true;
        }

        $this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['user']['wrongParameters'];
        return false;
    }//END::function modifyUserByName

    /**
     *@Decription : modify user information by user id
     *
     *@Param : int    user id
     *@Param : array    user's new information
     *
     *@return: boolean
     */
    public function modifyUserById ($userId, $newInfo)
    {
        if($userId && is_array($newInfo))
        {
            if(!$this->_check($newInfo))
            {
                $this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['user']['validUserInfo'];
                return false;
            }

            $updateSql = '';
            foreach($newInfo as $key => $value)
            {
                $updateSql .= "$key = '$value',";
            }
            $updateSql = substr($updateSql, 0 ,strlen($updateSql));
            $updateStr = "update #._user set $updateSql where user_id = '$userId'";
            $this->_db->query($updateStr);
            if(!$this->_db->affectedRows())
            {
                $this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['user']['modifyUserFail'];
                return false;
            }
            return true;
        }

        $this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['user']['wrongParameters'];
        return false;
    }//END::function modifyUserById

    /**
     *@Decription : delete user by user id
     *
     *@Param : int    user id
     *
     *@return: boolean
     */
    public function deleteUserById ($userId)
    {
        if(is_int($userId))
        {
            $deleteUser = "delete from #._user where user_id = $userId";
            $this->_db->query($deleteUser);
            if(!$this->_db->affectedRows())
            {
                $this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['user']['deleteUserIdFail'];
                return false;
            }
            return true;
        }

        $this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['user']['wrongParameters'];
        return false;
    }//END::function deleteUserById

    /**
     *@Decription : delete user by user name
     *
     *@Param : string    user name
     *
     *@return: boolean
     */
    public function deleteUserByName ($userName)
    {
        if(is_string($userName))
        {
            $deleteUser = "delete from #._user where uid = '$userName'";
            $this->_db->query($deleteUser);
            if(!$this->_db->affectedRows())
            {
                $this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['user']['deleteUserNameFail'];
                return false;
            }
            return true;
        }

        $this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['user']['wrongParameters'];
        return false;
    }//END::function deleteUserByName

    /**
     *@Decription : check if user is online
     *
     *@Param : int    user id
     *
     *@return: boolean
     */
    public function isUserIdOnline ($userId)
    {
        if(!is_int($userId))
            return false;
        $selectUser = "select * from #._session where user_id = $userId";
        $this->_db->query($selectUser);
        return $this->_db->numrows();
    }//END::function isUserIdOnline

    /**
     *@Decription : check if user is online
     *
     *@Param : int    user name
     *
     *@return: boolean
     */
    public function isUserNameOnline ($userName)
    {
        if(!is_string($userName))
            return false;
        $selectUser = "select * from #._session where uid = '$userName'";
        $this->_db->query($selectUser);
        return $this->_db->numRows();
    }//END::function isUserNameOnline

    /**
     *@Decription : get user's permission by user id
     *
     *@Param : int    user id
     *
     *@return: mixed(array/false)
     */
    public function getUserPermById ($userId)
    {
        $userPerm = array();
        if($this->_userInfo['user_id']!=$userId) {
            $this->getUserById($userId);
        }
        $groupIds = $this->_userInfo['group_ids'];
        if($groupIds) {
            $groups = $this->_groupObj->getGroupByIds($groupIds);
        }
        if($groups) {
            foreach($groups as $group_info) {
                $userPerm = array_merge_recursive($userPerm, $group_info['group_perm']);
            }
        }

        return $userPerm;
    }//END::function getUserPermById

    /**
     *@Decription : get user's permission by user name
     *
     *@Param : string    user name
     *
     *@return: mixed(array/false)
     */
    public function getUserPermByName ($userName)
    {
        global $My_Kernel;

        if($this->_userInfo['uid']!=$userName)
            $this->getUserById($userName);
        $groupIds = $this->_userInfo['gid'];
        if(!$groupIds)
            return false;
        $groups = explode($this->_groupSeparator, $groupIds);
        $group = $My_Kernel->getClass("group",$this->_db);
        $groupPerms = array();
        foreach ($groups as $groupId)
        {
            $groupPerms[] = $group->getGroupPermById($groupId);
        }
        $groupPerm = array();
        for($i=0; $i<count($groupPerms); $i++)
        {
            $groupPerm = array_merge($groupPerm, $groupPerms[$i]);
        }

        return $groupPerm;
    }//END::function getUserPermByName

    /****************** END::method zone *************************/
}//END::class
?>
