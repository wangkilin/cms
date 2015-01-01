<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_session.class.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-1-18
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");

class MY_session
{
    /****************** START::property zone *************************/
    /**
     *@object    database handler
     */
    private $_db;

    /**
     *@int        session valid time
     */
    private $_timeOut;

    /****************** END::property zone *************************/


    /****************** START::method zone *************************/
    /**
     *@Decription : load specify type database class
     *
     *@Param : string    database type
     *@Param : int        which Db will be connected to
     *
     *@return: constructor
     */
    public function MY_session($_db, $timeOut = 1800)
    {
        $this->_db = $_db;
        $this->_timeOut = $timeOut;

        session_set_save_handler(
                   array(& $this, 'sessOpen'),
                   array(& $this, 'sessClose'),
                   array(& $this, 'sessRead'),
                   array(& $this, 'sessWrite'),
                   array(& $this, 'sessDestroy'),
                   array(& $this, 'sessGc')
            );
    }// END::function MY_session

    /**
     *@Decription : open session
     *
     *@return: true
     */
    public function sessOpen($save_path, $session_name)
    {
        $timeOut = $this->_timeOut;
        $this->_db->query("delete from #._session where time_flg< (unix_timestamp()-$timeOut)");

        return true;
    }// END::function sessOpen

    /**
     *@Decription : write session
     *
     *@return: int
     */
    public function sessWrite($sid, $sessData)
    {
        $this->_db->query ("select * from #._session where sid = '$sid'");
        if(isset($_SESSION['user_info']))
        {
            $ip = $_SESSION['user_info']['ip'];
            $uid = $_SESSION['user_info']['uid'];
            $user_id = $_SESSION['user_info']['user_id'];
            $gid = $_SESSION['user_info']['gid'];
            $is_admin = $_SESSION['user_info']['is_admin'];
            $is_super = $_SESSION['user_info']['is_super'];
            $rank = $_SESSION['user_info']['rank'];
        }
        else
        {
            $ip = $_SERVER['REMOTE_ADDR'];
            $uid = '';
            $user_id = 0;
            $gid = 0;
            $is_admin = 0;
            $is_super = 0;
            $rank = 0;
        }

        $request_type = @$_SESSION['sess']['request_type'];
        $request_type_id = @$_SESSION['sess']['request_type_id'];


        if($this->_db->numRows())
            $this->_db->query("update #._session set sess_data = '$sessData', time_flg = unix_timestamp(), uid='$uid', user_id='$user_id', request_type_id='$request_type_id', request_type='$request_type', ip='$ip', gid='$gid' , rank='$rank' , is_admin='$is_admin' ,is_super='$is_super' where sid = '$sid'");
        else
            $this->_db->query ("insert into #._session (sid, sess_data, time_flg, uid , user_id, request_type, request_type_id, ip, gid , rank , is_admin ,is_super) values ( '$sid', '$sessData', unix_timestamp(), '$uid', '$user_id', '$request_type', '$request_type_id', '$ip', '$gid', '$rank', '$is_admin', '$is_super')");
        return true;
    }// END::function sessWrite

    /**
     *@Decription : read session
     *
     *@return: int
     */
    public function sessRead($sid)
    {
        $this->_db->query("select sess_data from #._session where sid = '$sid'");
        $sess_data = $this->_db->fetchRow();
        return $sess_data[0];
    }// END::function sessRead

    /**
     *@Decription : read session
     *
     *@return: int
     */
    public function sessClose()
    {
        return true;
    }// END::function sessClose

    /**
     *@Decription : read session
     *
     *@return: int
     */
    public function sessDestroy($sid)
    {
        $this->_db->query("delete from #._session where sid = '$sid'");
        return true;
    }// END::function sessDestroy

    /**
     *@Decription : read session
     *
     *@return: int
     */
    public function sessGc($timeOut = 180)
    {
        if($this->_timeOut)
            $timeOut = $this->_timeOut;
        $this->_db->query( "delete from #._session where time_flg< (unix_timestamp()-$timeOut)");
        return true;
    }// END::function sessGc

    /****************** END::method zone *************************/

}// END::class
?>
