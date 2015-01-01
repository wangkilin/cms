<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_language.class.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2007-4-14
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die("forbidden");
define('MY_LANGUAGE_INC',1);
require_once(dirname(__FILE__) . '/My_Abstract.class.php');

class My_Language extends My_Abstract
{
	/****************** START::property zone *************************/

	/**
	 *@array	language information got by last query
	 */
	protected $_languageInfo = array();

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
		 My_Kernel::loadLang('class','language');//load class language
		 if(is_resource($db))
			 $this->_db = $db;
	}// END::constructor

	/**
	 *@Description : get language name by lang id
	 *
	 *@param : int	lang id
	 *
	 *@return: mixed(array/false)
	 */
	protected function _getLangInfoById($langId)
	{
		if($this->_langInfo["lang_id"] == $langId)
			return $this->_langInfo['lang_name'];

		$selectLang = "select * from #._language where lang_id = $langId";
		$this->_db->query($selectLang);
		if($row = $this->_db->fetchArray())
		{
			$this->_langInfo = $row;
			return $row;
		}

		$this->_errorStr = __CLASS__."->".__FUNCTION__."()".$My_Lang->class['lang']['getLangInfoFail'];
		return false;
	}//END::function _getLangInfoById

	/**
	 *@Description : get language name by lang id
	 *
	 *@param : int	lang id
	 *
	 *@return: string
	 */
	public function getLangNameById($langId)
	{
		if($this->_langInfo["lang_id"] != $langId && $this->_getLangInfoById($langId))
		{
			return MY_DEFAULT_LANGUAGE;
		}

		return $this->_langInfo["lang_name"];
	}//END::function _loadModuleById

	/**
	 *@Decription : get all languages system have
	 *
	 *@return: array
	 */
	public function getAllLanguages()
	{
		global $_system;
		$select_all_lang = "select * from #._language";
		$this->_db->query($select_all_lang);
		while(list($lang_id,$lang_name,$creatot_id,$install_date,$publish,$desc)=$this->_db->fatchArray())
		{
			$_system['lang'][]=$lang_name;
		}

	}//END::function getAllLanguages

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
		$this->debug = $debug;;
	}//END::function setDebug

	/****************** END::method zone *************************/

}// END::class
?>
