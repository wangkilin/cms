<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : YE_database.class.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2007-1-10
 *@Homepage	: http://www.yeaheasy.com
 *@Version	: 0.1
 */
class YE_database 
{
	/****************** START::property zone *************************/
	/**
	 *@string	database type
	 */
	public $db_type;

	/**
	 *@object	db handle
	 */
	private $dbh;

	/**
	 *@int	the query action times
	 */
	private $queryTimes = 0;

	protected $countQuery=true;

	/****************** END::property zone *************************/


	/****************** START::method zone *************************/
	/**
	 *@Decription : load specify type database class
	 *
	 *@Param : int		which Db will be connected to
	 *
	 *@return: constractor
	 */	
	public function YE_database($dbConfigIndex=0)
	{
		global $YE_db_config;
		if(is_numeric($dbConfigIndex) && isset($YE_db_config[$dbConfigIndex])) {
      require_once(ROOT_PATH.'inc/database/' . $YE_db_config[$dbConfigIndex]['dbtype'] . '.class.php'); // load db type file
      $className = $YE_db_config[$dbConfigIndex]['dbtype'];
      $dbh = new $className($YE_db_config[$dbConfigIndex]);// initial class
      $this->dbh=$dbh;
  }
	}// END::function database
	
	/**
	 *@Decription : set class if debug
	 *
	 *@Param : boolean	if true, will debug
	 *
	 *@return: void
	 */
	public function setDebug($debug=false)
	{
		$this->dbh->debug = $debug;
	}// END::function debug

	/**
	 *@Decription : get query timers DB has done
	 *
	 *@return: int
	 */
	public function queryTimes()
	{
		if(!is_object($this->dbh))
			return 0;
		return $dbh->queryTimes();
	}// END::function queryTimes

	/**
	 *@Decription : get the last error description. public
	 *
	 *@return: string	the last error description
	 */
	public function getError()
	{
		return $this->dbh->getError();

	}//END::function getError

 /**
	 * parse the sql string that exists the parameters with the passed parameter
	 * follow the rule that  first passed para that stored in array will replace the first'?' signal
	 * that exists in sql string.
	 *
	 * @param string $strSql
	 * @param array  $valueArray
	 * @return boolean
	 */
	private function parseSql (& $strSql, $valueArray)
	{
	   $sqlVarNumber = substr_count($strSql, '?') + substr_count($strSql, '!');
	   $passedVarNumber = count($valueArray);
	   if ($sqlVarNumber != $passedVarNumber) {
			  return false;
	   }
	   preg_match_all('/\?|!/',$strSql, $matches, PREG_OFFSET_CAPTURE);

      for($j=count($matches[0])-1; $j>=0; $j--) {
          $tempValue = $valueArray[$j];
          if($matches[0][$j][0] == '?')
          {
              if(NULL !== $tempValue ){
                  $format = '\'%s\'';
                  //$realValue = sprintf($format,$tempValue );
                  $realValue = sprintf($format,mysql_real_escape_string($tempValue) );
              } else  {
                  $realValue = 'NULL';
              }
          }	elseif($matches[0][$j][0] == '!') {
              $format = ' %d';
              $realValue = sprintf($format,$tempValue);
          }
          $strSql = substr_replace($strSql, $realValue, $matches[0][$j][1], 1);
      }
      return true;
	}

	/**
	 *@Decription : query action
	 *
	 *@Param : string	SQL sentence
	 *
	 *@return: mixed	query result handle
	 */
	public function query($query, $param = array())
	{
		$query=trim($query);
		if($query=='')
			return NULL;
		$this->prefix($query);
        if (!$this->parseSql ($query, $param)) {
            return null;
        }
		if($this->countQuery===true)
			$this->queryTimes ++;
		$this->prefix($query);// to fix SQL sentence
		return $this->dbh->query($query);
	}//END:: function query

	/**
	 *@Decription : prefix SQL sentence
	 *
	 *@Param : string	SQL sentence
	 *
	 *@return: void
	 */
	private function prefix(&$query)
	{
		$query = str_replace("#.",YE_TABLE_PREFIX, $query);
	}//END::function prefix

	/**
	 *@Decription : get fetched data into an association array
	 *
	 *@return: array
	 */
	public function fetchArray()
	{
		return $this->dbh->fetchArray();
	}//END::function fetchArray

	/**
	 *@Decription : data seek
	 *
	 *@return: array
	 */
	public function dataSeek($rowNum)
	{
		return $this->dbh->dataSeek($rowNum);
	}//END::function fetchArray

	/**
	 *@Decription : get fetched data into an array
	 *
	 *@return: array
	 */
	public function fetchRow()
	{
		return $this->dbh->fetchRow();
	}//END::function fetchRow

	/**
	 *@Decription : get selected rows number
	 *
	 *@return: int
	 */
	public function numRows()
	{
		return $this->dbh->numRows();
	}//END::function numRows

	/**
	 *@Decription : get affected rows number after UPDATE, INSERT, DELETE
	 *
	 *@return: int
	 */
	public function affectedRows()
	{
		return $this->dbh->affectedRows();
	}//END::function affectedRows
	
	public function insertId()
	{
		return $this->dbh->insertId();
	}//END::function insertId

	/**
	 *@Decription : disconnect to database.
	 *
	 *@return: void
	 */
	public function close()
	{
		return $this->dbh->close();
	}//END::function close

	
	/****************** END::method zone *************************/
	
}// END::class
?>
