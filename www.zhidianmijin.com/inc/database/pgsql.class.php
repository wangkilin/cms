<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : pgsql.class.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2007-1-18
 *@Homepage	: http://www.yeaheasy.com
 *@Version	: 0.1
 */
defined('YeahEasy') or die("forbidden");

class pgsql
{
	/****************** START::property zone *************************/
	/**
	 *@string	connection handle
	 */
	private $conn;

	/**
	 *@boolean	set true, class will debug
	 */
	public $debug = false;

	/**
	 *@array	error descption
	 */
	private $_errorStr;

	/**
	 *@mixed	the last query result
	 */
	private $queryId;

	/**
	 *@string	last insert SQL
	 */
	private $_lastInsertStr = '' ;

	/****************** END::property zone *************************/


	/****************** START::method zone *************************/
	/**
	 *@Decription : Constructor
	 *
	 *@Param : int		which Db will be connected to
	 *
	 *@return: void
	 */	
	public function pgsql($dbSeq=0)
	{
		 global $YE_db_config;

		 include_once(YE_ROOT_PATH."language/class/".(isset($_system)?$_system['config']['default_language']:YE_DEFAULT_LANGUAGE)."/pgsql.lang.php");//load class language
		 $this->connect($YE_db_config['pgsql'][$dbSeq]);
	}// END::function pgsql

	/**
	 *@Decription : connect to database. private
	 *
	 *@Param : array	(hostname,username,password)
	 *
	 *@return: void
	 */
	private function connect($connArray)
	{
		$this->free();
		$connStr = '';
        $connStr = 'host=' . $connArray['hostname'];
        $connStr .= ' port=' . $connArray['port'];
		if ($connArray['database'])
            $connStr .= ' dbname=' . $connArray['database'];
		if($connArray['username'])
			$connStr .= ' user=' . $connArray['username'];
		if($connArray['password'])
			$connStr .= ' password=' . $connArray['password'];

		$conn = @pg_connect($connStr);
		if(is_resource($conn))
		{
			$this->conn = & $conn;
		}
		else
			$this->_errorStr= __CLASS__."->".__FUNCTION__."()".$YE_lang->classModule['pgsql']['failConnection'];
	}//END::function connect

	/**
	 *@Decription : get the last error description. public
	 *
	 *@return: string	the last error description
	 */
	public function getError()
	{
		return $this->_errorStr;
	}//END::function getError

	/**
	 *@Decription : query action
	 *
	 *@Param : string	SQL sentence
	 *
	 *@return: mixed	query result handle
	 */
	public function query($query)
	{
		$query=trim($query);
		if($query=='')
			return NULL;

		if(!($this->queryId = @pg_query($this->conn, $query)))
		{
			$this->_errorStr= __CLASS__."->".__FUNCTION__."()".$YE_lang->classModule['pgsql']['failQuery'].$query;
			return false;
		}

		if(preg_match("/^insert/i", $query))// check if is insert action
			$this->_lastInsertStr = $query;
		if($this->debug)
			echo (__CLASS__."->".__FUNCTION__."() ".$YE_lang->classModule['pgsql']['commandDone']."<br> \n");

		$this->_errorStr = NULL;;
		return true;
	}//END:: function query

	/**
	 *@Decription : get fetched data into an association array
	 *
	 *@return: array
	 */
	public function fetchArray()
	{
		if($this->debug)
			echo (__CLASS__."->".__FUNCTION__."() ".$YE_lang->classModule['pgsql']['commandDone']."<br> \n");
		if(!is_resource($this->queryId))
			return false;
		if(!($fetchArray = @pg_fetch_assoc($this->queryId)))
			return false;
		else
			return $fetchArray;
	}//END::function fetchArray

	/**
	 *@Decription : get fetched data into an array
	 *
	 *@return: array
	 */
	public function fetchRow()
	{
		if($this->debug)
			echo (__CLASS__."->".__FUNCTION__."() ".$YE_lang->classModule['pgsql']['commandDone']."<br> \n");
		if(!is_resource($this->queryId))
			return false;
		if(!($fetchRow = @pg_fetch_row($this->queryId)))
			return false;
		else
			return $fetchRow;
	}//END::function fetchRow
	
	/**
	 *@Decription : get selected rows number
	 *
	 *@return: int
	 */
	public function numRows()
	{
		if($this->debug)
			echo (__CLASS__."->".__FUNCTION__."() ".$YE_lang->classModule['pgsql']['commandDone']."<br> \n");

		if(!is_resource($this->queryId))
			return false;
		return @pg_num_rows($this->queryId);
	}//END::function numRows

	/**
	 *@Decription : get affected rows number after UPDATE, INSERT, DELETE
	 *
	 *@return: int
	 */
	public function affectedRows()
	{
		if($this->debug)
			echo (__CLASS__."->".__FUNCTION__."() ".$YE_lang->classModule['pgsql']['commandDone']."<br> \n");
		return @pg_affected_rows();
	}//END::function affectedRows
	
	public function insertId()
	{
		if($this->debug)
			echo (__CLASS__."->".__FUNCTION__."() ".$YE_lang->classModule['pgsql']['commandDone']."<br> \n");
		if($this->_lastInsertStr && preg_match("/nextval(\(.+\))/i",str_replace(array(" ","\r","\n","\t"), "", $this->_lastInsertStr), $seqStr))
		{
			$_query="select currval".$seqStr[1];
			$this->query($_query);
			$_row = $this->fetchArray();
			return $_row[0];
		}
		elseif($this->_lastInsertStr)
		{
			$joinInsert = str_replace(array(" ","\r","\n","\t"), "", $this->_lastInsertStr);
			$tableName=substr($joinInsert,10,strpos($joinInsert,"(")-10);
			$query="select  adef.adsrc from pg_catalog.pg_attribute a left join pg_catalog.pg_attrdef adef on a.attrelid=adef.adrelid and a.attnum=adef.adnum left join pg_catalog.pg_type t on a.atttypid=t.oid where a.attrelid = (select oid from pg_catalog.pg_class where relname='$tableName') and a.attnum > 0 and not a.attisdropped  and lower(substr(adef.adsrc,0,8))='nextval' order by a.attnum";
			$this->query($query);
			if($row=$this->fetchRow())
			{
				$this->query(substr_replace($row[0],"currval",0,7));
				if($row = $this->fetchRow())
					return $row[0];
			}

		}
		
		return 0;
	}//END::function insertId

	/**
	 *@Decription : disconnect to database.
	 *
	 *@return: void
	 */
	public function close()
	{
		$ret=@pg_close();
		if($ret)
			$this->conn=NULL;
		elseif($this->cacheError)
			$this->_errorStr= __CLASS__."->".__FUNCTION__."()".$YE_lang->classModule['pgsql']['failCloseDb'];
		if($this->debug)
			echo (__CLASS__."->".__FUNCTION__."() ".$YE_lang->classModule['pgsql']['commandDone']."<br> \n");
	}//END::function close

	/**
	 *@Decription : get query times
	 *
	 *@return: int
	 */
	public function queryTimes()
	{
		if($this->debug)
			echo (__CLASS__."->".__FUNCTION__."() ".$YE_lang->classModule['pgsql']['commandDone']."<br> \n");
		return $this->queryTimes();
	}

	/**
	 *@Decription : free class handle
	 *
	 *@return: void
	 */
	private function free()
	{
		$this->queryId = NULL;
		$this->conn = NULL;
		$this->_allErrors = array();
		if($this->debug)
			echo (__CLASS__."->".__FUNCTION__."() ".$YE_lang->classModule['pgsql']['commandDone']."<br> \n");
	}

	/**
	 *@Decription : set class if debug
	 *
	 *@Param : boolean	if true, will debug
	 *
	 *@return: void
	 */
	public function debug($debug=false)
	{
		$this->debug = true;
	}// END::function debug
	
	/****************** END::method zone *************************/
}//END::class pgsql
?>
