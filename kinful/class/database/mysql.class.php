<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : mysql.class.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-1-11
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");

class mysql
{
    /****************** START::property zone *************************/
    /**
     *@string    connection handle
     */
    public $conn;

    /**
     *@boolean    set true, class will debug
     */
    public $debug = false;

    /**
     *@array    error descption
     */
    private $_errorStr;

    /**
     *@mixed    the last query result
     */
    private $queryId;


    /****************** END::property zone *************************/


    /****************** START::method zone *************************/
    /**
     *@Decription : Constructor
     *
     *@Param : int        which Db will be connected to
     *
     *@return: void
     */
    public function mysql($dbSeq=0)
    {
         global $MY_db_config;
         global $MY_lang;
         include_once(MY_ROOT_PATH."language/".MY_kernel::getUserLang()."/class/mysql.lang.php");//load class language
         $this->connect($MY_db_config['mysql'][$dbSeq]);
    }// END::function mysql

    public function realEscapeString ($string)
    {
        if(is_string($string) && strlen($string)) {
            $string = mysql_real_escape_string($string, $this->conn);
        }

        return $string;
    }

    /**
     *@Decription : connect to database. private
     *
     *@Param : array    (hostname,username,password)
     *
     *@return: void
     */
    private function connect($connArray)
    {
        global $MY_lang;
        $this->free();
        $conn = @mysql_connect($connArray['hostname'].":".$connArray['port'],$connArray['username'],$connArray['password']);
        if(is_resource($conn))
        {
            $this->conn = & $conn;
            @mysql_select_db($connArray['database'],$conn);
            $this->query("set names 'utf8'");
        }
        else
            $this->_errorStr= __CLASS__."->".__FUNCTION__."()".$MY_lang->classModule['mysql']['failConnection']."::".mysql_error();
    }//END::function connect

    /**
     *@Decription : get the last error description. public
     *
     *@return: string    the last error description
     */
    public function getError()
    {
        return $this->_errorStr;
    }//END::function getError

    /**
     *@Decription : query action
     *
     *@Param : string    SQL sentence
     *
     *@return: boolean    query succeed?
     */
    public function query($query)
    {
        global $MY_lang;
        $query=trim($query);
        if($query=='')
            return NULL;

        if($this->debug)
            echo (__CLASS__."->".__FUNCTION__."() ".$MY_lang->classModule['mysql']['commandDone'].": $query<br> \n");
        if(!($this->queryId = @mysql_query($query)))
        {
            $this->_errorStr= __CLASS__."->".__FUNCTION__."()".$MY_lang->classModule['mysql']['failQuery'].$query."::".mysql_error();
            return false;
        }
        $this->_errorStr = NULL;

        return true;

    }//END:: function query

    /**
     *@Decription : get fetched data into an association array
     *
     *@return: array
     */
    public function fetchArray()
    {
        global $MY_lang;
        if($this->debug)
            echo (__CLASS__."->".__FUNCTION__."() ".$MY_lang->classModule['mysql']['commandDone']."<br> \n");
        if(!is_resource($this->queryId))
            return false;
        if(!($fetchArray = @mysql_fetch_assoc($this->queryId)))
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
        global $MY_lang;
        if($this->debug)
            echo (__CLASS__."->".__FUNCTION__."() ".$MY_lang->classModule['mysql']['commandDone']."<br> \n");
        if(!is_resource($this->queryId))
            return false;
        if(!($fetchRow = @mysql_fetch_row($this->queryId)))
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
        if(!is_resource($this->queryId))
            return 0;
        return @mysql_num_rows($this->queryId);
    }//END::function numRows

    /**
     *@Decription : get affected rows number after UPDATE, INSERT, DELETE
     *
     *@return: int
     */
    public function affectedRows()
    {
        global $MY_lang;
        if($this->debug)
            echo (__CLASS__."->".__FUNCTION__."() ".$MY_lang->classModule['mysql']['commandDone']."<br> \n");
        return @mysql_affected_rows($this->conn);
    }//END::function affectedRows

    public function insertId()
    {
        global $MY_lang;
        if($this->debug)
            echo (__CLASS__."->".__FUNCTION__."() ".$MY_lang->classModule['mysql']['commandDone']."<br> \n");
        return @mysql_insert_id();
    }//END::function insertId

    /**
     *@Decription : disconnect to database.
     *
     *@return: void
     */
    public function close()
    {
        global $MY_lang;
        $ret=@mysql_close();

        if($this->debug)
            echo (__CLASS__."->".__FUNCTION__."() ".$MY_lang->classModule['mysql']['commandDone']."<br> \n");

        if($ret)
        {
            $this->conn=NULL;
            return true;
        }
        else
            $this->_errorStr= __CLASS__."->".__FUNCTION__."()".$MY_lang->classModule['mysql']['failCloseDb'];

    }//END::function close

    /**
     *@Decription : free class handle
     *
     *@return: void
     */
    private function free()
    {
        global $MY_lang;
        $this->queryId = NULL;
        $this->conn = NULL;
        $this->_errorStr = NULL;
        if($this->debug)
            echo (__CLASS__."->".__FUNCTION__."() ".$MY_lang->classModule['mysql']['commandDone']."<br> \n");
    }

    /**
     *@Decription : set class if debug
     *
     *@Param : boolean    if true, will debug
     *
     *@return: void
     */
    public function debug($debug=false)
    {
        $this->debug = true;
    }// END::function debug

    /****************** END::method zone *************************/
}//END::class mysql
?>
