<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_group.class.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2007-3-18
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die("forbidden");

require_once(dirname(__FILE__) . '/My_Abstract.class.php');

class My_Group extends My_Abstract
{
	/****************** START::property zone *************************/

	/**
	 *@array	group information
	 */
	protected $_groupInfo;

	/**
	 *@string	integer separator
	 */
	protected $_intSeparator = ',';

    const WITH_ROLE_INFO  = 2;
    const WITH_PERMISSION_INFO = 4;

	/****************** END::property zone *************************/

	/****************** START::method zone *************************/
	/**
	 *@Decription : load specify type database class
	 *
	 *@Param : string	database type
	 *
	 *@return: constructor
	 */
	public function __construct(&$db)
	{
		 global $_system;
		 My_Kernel::loadLang('class','group');//load class language
		 $this->_db = $db;
		 if(isset($_system['db_int_seperator']))
		 {
			 $this->_intSeparator = $_system['db_int_seperator'];
		 }
	}

	/**
	 *@Decription : get group info by id
	 *
	 *@Param : INT	group id
	 *
	 *@return: array
	 */
	public function getGroupById($groupId)
	{
		if($this->_groupInfo['group_id'] == $groupId)
			return $this->_groupInfo;
		$querygroup="select * from #._group where group_id = $groupId";
		$this->_db->query($querygroup);
		if($row = $this->_db->fetchArray())
		{
			$this->_groupInfo = $row;
			return $row;
		}
		return false;

	}//END::function getGroupById

	/**
	 *@Decription : get groups info by ids
	 *
	 *@Param : array	groups id
	 *
	 *@return: array
	 */
	public function getGroupByIds($groupIdsArray, $withInfo=0)
	{
		if(!is_array($groupIdsArray))
			return false;
		$retGroups = array();
		$_groups = join(',', $groupIdsArray);
		$querygroup="select * from #._group where group_id in ($_groups)";
		$this->_db->query($querygroup);
		while($row = $this->_db->fetchArray())
		{
		    $row['group_perm'] = null;
			if($row['group_perm'])
				$row['group_perm'] = $this->_splitIntegers($row['group_perm']);// we just set group perm equal perm_id array, later we will get detail permission
			else
				$row['group_perm'] = array();
			$group_id = $row['group_id'];
			$retGroups[$group_id] = $row;
		}
		$tmp = count($retGroups);
		/**##################### this zone need to be thinked carefully. ###########################3**/
		if($tmp>0)
		{// $tmp>0 means that we got some groups info
			$_allPerms = array();
			foreach($retGroups as $group_id=>$row)
			{
				$_allPerms = array_merge($_allPerms, $row['group_perm']);
			}

			if(count($_allPerms))
			{// this means that we need to get detail permission
				$_allPerms = $this->_getDetailPermByIds(array_unique($_allPerms));// here we got all detail permission
				$_tmpRetGroups = $retGroups;
				foreach($_tmpRetGroups as $g_group_id=>$row)
				{
					if(count($row['group_perm']))
					{
						$_tmpPerm = array();
						foreach($row['group_perm'] as $permId)
						{
							$_tmpPerm["p$permId"]=$_allPerms["p$permId"];
							$_tmpCKey = $_allPerms["p$permId"][3];
							$_tmpMKey = $_allPerms["p$permId"][0];
							$_tmpPerm["c{$_tmpCKey}"]["m{$_tmpMKey}"]=$_allPerms["p$permId"];

						}
						$retGroups["$g_group_id"]['group_perm'] = $_tmpPerm;
					}//end if
				}//end foreach
			}//end if
		}//end if
		//var_dump($retGroups);
		if($tmp)
			return $retGroups;

		return false;

	}//END::function getGroupById

	/**
	 *@Decription : get group info by name
	 *
	 *@Param : string	group name
	 *
	 *@return: array
	 */
	public function getGroupByName($groupName)
	{
		if($this->_groupInfo['group_id'] == $groupName)
			return $this->_groupInfo;
		$querygroup="select * from #._group where group_name = '$groupName'";
		$this->_db->query($querygroup);
		if($row = $this->_db->fetchArray())
		{
			if($row['group_perm'])
			{
				$_permIds = $this->_splitIntegers($row['group_perm']);
				$row['group_perm'] = $this->_getDetailPermByIds($_permIds);
			}
			else
				$row['group_perm'] = array();
			$this->_groupInfo = $row;
			return $row;
		}
		return false;
	}//END::function getGroupByName

	/**
	 *@Decription : add new group
	 *
	 *@Param : array	group's information
	 *
	 *@return: boolean
	 */
	public function addNewGroup ($groupInfo)
	{
		if(!is_array($groupInfo))
			return false;
		if(!$this->_checkGroupInfo($groupInfo))
			return false;
		$fields = '';// fields name
		$values = '';// fields related values
		foreach($groupInfo as $key => $value)
		{
			$fields .=$key.", ";
			$values .="'".$value."', ";
		}
		$fields = substr($fields, 0, strlen($fields)-2);
		$values = substr($values, 0, strlen($values)-2);
		$queryNew = "insert into #._group ($fields) values ($values)";
		if($this->_db->query($queryNew))
			return true;
		else
		{
			$this->_errorStr = $My_Lang->class['group']['failAddGroup'].$this->_db->getError();
			return false;
		}
	}//END::function addNewGroup

	/**
	 *@Description : check if group information in  array is valid
	 *
	 *@Param : array	group's information
	 *
	 *@return: boolean
	 */
	private function _check (& $groupInfo)
	{
		global $_system;
		$groupInfo = array_change_key_case($groupInfo, CASE_LOWER);
		if(isset($groupInfo['group_perm']))
			$groupInfo['group_perm'] = $_system['config']['db_int_seperator'].join($_system['config']['db_int_seperator'], $groupInfo['group_perm']).$_system['config']['db_int_seperator'];
		if(isset($groupInfo['admin_ids']))
			$groupInfo['admin_ids'] = $_system['config']['db_int_seperator'].join($_system['config']['db_int_seperator'], $groupInfo['admin_ids']).$_system['config']['db_int_seperator'];
		if(isset($groupInfo['user_ids']))
			$groupInfo['user_ids'] = $_system['config']['db_int_seperator'].join($_system['config']['db_int_seperator'], $groupInfo['user_ids']).$_system['config']['db_int_seperator'];
		$validKeys = array('group_name' , 'parent_gid' , 'admin_ids' , 'group_desc' , 'group_perm' , 'user_ids' , 'creator_id');
		foreach($groupInfo as $key => $value)
		{
			if(!in_array($key,$validKeys))
			{
				$this->_errorStr = $My_Lang->class['group']['invalidGroupInfo'];
				return false;
			}
			$groupInfo["$key"] = trim($groupInfo["$key"]);
		}
		return true;
	}//END::function _check

	/**
	 *@Decription : modify group information by group name
	 *
	 *@Param : string	group name
	 *@Param : array	group's new information
	 *
	 *@return: boolean
	 */
	public function modifyGroupByName ($groupName, $newInfo)
	{
		if($groupName && is_array($newInfo))
		{
			if(!$this->_check($newInfo))
			{
				return false;
			}

			$updateSql = '';
			foreach($newInfo as $key => $value)
			{
				$updateSql .= "$key = '$value',";
			}
			$updateSql = substr($updateSql, 0 ,strlen($updateSql)-1);
			$updateStr = "update #._group set $updateSql where group_name = '$groupName'";
			if(!$this->_db->query($updateStr))
			{
				$this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['group']['modifyGroupFail'];
				return false;
			}
			return true;
		}

		$this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['group']['wrongParameters'];
		return false;
	}//END::function modifyGroupByName

	/**
	 *@Decription : modify group information by group id
	 *
	 *@Param : int	group id
	 *@Param : array	group's new information
	 *
	 *@return: boolean
	 */
	public function modifyGroupById ($groupId, $newInfo)
	{
		if($groupId && is_array($newInfo))
		{
			if(!$this->_check($newInfo))
			{
				return false;
			}

			$updateSql = '';
			foreach($newInfo as $key => $value)
			{
				$updateSql .= "$key = '$value',";
			}
			$updateSql = substr($updateSql, 0 ,strlen($updateSql));
			$updateStr = "update #._group set $updateSql where group_id = '$groupId'";
			if(!$this->_db->query($updateStr))
			{
				$this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['group']['modifygroupFail'];
				return false;
			}
			return true;
		}

		$this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['group']['wrongParameters'];
		return false;
	}//END::function modifyGroupById

	/**
	 *@Decription : update user/s group information
	 *
	 *@Param : int		group id
	 *@Param : array	user/s id that belong to group id
	 *
	 *@return: boolean
	 */
	private function _updateUserGroupId($gourpId, $usersId)
	{
		$updateUser = "update *._user set group_ids = concat()";
	}

	/**
	 *@Decription : delete group by group id
	 *
	 *@Param : int	group id
	 *
	 *@return: boolean
	 */
	public function deleteGroupById ($groupId)
	{
		if(is_int($groupId))
		{
			$deletegroup = "delete from #._group where group_id = $groupId";
			if(!$this->_db->query($deletegroup))
			{
				$this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['group']['deleteGroupFail'];
				return false;
			}
			return true;
		}

		$this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['group']['wrongParameters'];
		return false;
	}//END::function deleteGroupById

	/**
	 *@Decription : delete group by group name
	 *
	 *@Param : string	group name
	 *
	 *@return: boolean
	 */
	public function deleteGroupByName ($groupName)
	{
		if(is_string($groupName))
		{
			$deletegroup = "delete from #._group where group_name = '$groupName'";
			$this->_db->query($deletegroup);
			if(!$this->_db->affectedRows())
			{
				$this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['group']['deleteGroupFail'];
				return false;
			}
			return true;
		}

		$this->_errorStr = __CLASS__."->".__FUNCTION__."() : ".$My_Lang->class['group']['wrongParameters'];
		return false;
	}//END::function deleteGroupByName

	/**
	 *@Decription : get group's role by group id
	 *
	 *@Param : int	group id
	 *
	 *@return: mixed(array/false)
	 */
	public function getRolesByGroupId ($groupId)
	{
		return $this->getRolesByGroupIds(array($groupId));
	}//END::function getRolesByGroupId

	/**
	 * get roles information by group ids list
	 * @param array $groupIds The group ids list
	 * @param bool $onlyRoleIds If only return role ids
	 */
	public function getRolesByGroupIds($groupIds, $onlyRoleIds=false)
	{
	    global $My_Sql;

	    settype($groupIds, 'array');
	    foreach($groupIds as $key => $groupId) {
	        $groupIds[$key] = intval($groupId);
	    }
	    $roles = array();
	    $this->_db->query($My_Sql['getRolesByGroupIds'], array(join(',', $groupIds)));
	    while($row=$this->_db->fetchArray()) {
	        if (true===$onlyRoleIds) {
	            $roleIds = explode(MY_INT_SEPARATOR, trim($row['group_roles'], MY_INT_SEPARATOR));
	            $roles = array_merge($roles, $roleIds);
	        } else {
	            $roles[] = $row;
	        }
	    }
	    $roles = array_unique($roles);

	    return $roles;
	}

	/**
	 *@Decription : get group's permission by group name
	 *
	 *@Param : string	group name
	 *
	 *@return: mixed(array/false)
	 */
	public function getRolesByGroupName ($groupName)
	{
		if($this->_groupInfo['group_name']!=$groupName) {
			if(!($row = $this->getGroupByName($group_name)))
				return false;
		}

		return $this->getRolesByGroupIds(array($this->_groupInfo['group_id']));
	}//END::function

	/**
	 *@Decription : split integers string joined by $this->_intSeparator into array
	 *
	 *@Param : string	integers string joined by $this->_intSeparator
	 *
	 *@return: array
	 */
	private function _splitIntegers(&$intStr)
	{
		$intStr = substr($intStr,1,strlen($intStr)-2);// integers string like (,1,2,34,)
		$intArray = explode($this->_intSeparator, $intStr);
		return $intArray;
	}//END::function _splitIntegers

	/**
	 *@Decription : get detail information by permission ID/s
	 *
	 *@Param : array	permission ids
	 *
	 *@return: array
	 */
	private function _getDetailPermByIds($permIds)
	{
		$permIds = join(',', $permIds);
		$selectPerms = "select * from #._permission where perm_id in ($permIds)";
		$this->_db->query($selectPerms);
		$retPerms = array();
		while($row = $this->_db->fetchArray())
		{
			$retPerms["p{$row['perm_id']}"]=array($row['module_id'],$row['perm_name'],$row['perm_value'],$row['comp_id']);// Since this array will be merged, so we have to use string as its key. integer will make mistakes
		}

		return $retPerms;
	}//END::function _getDetailPerm

	/****************** END::method zone *************************/
}//END::class
?>
