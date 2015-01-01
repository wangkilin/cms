<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : email.class.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2007-4-28
 *@Version	: 0.1
 */
 define('YE_ROOT_PATH', 'K:/yeaheasy/');	// yeaheasy system root path
 $startTime = time();
class email_smtp
{
	var $smtp_conn = '';	//resource of smtp connection

	var $CRLF = "\r\n";

	function email_smtp($host, $username, $password, $port = 25, $timeout=30)
	{
		if(is_resource($this->smtp_conn))
			return ;
		$this->smtp_conn = fsockopen($host, $port, $errno, $errstr, $timeout);
		if(is_resource($this->smtp_conn))
		{
			$reply = $this->getResponse();
                        
			//$this->smtp_conn = &$smtp_conn;
			fputs($this->smtp_conn,"HELO ".$_SERVER["REMOTE_ADDR"].$this->CRLF);
			$reply = $this->getResponse();
			$code = intval(substr($reply,0,3));
			if($code != 250)
			{
				error_log($this->_error = "Say hello to server failed.".$code.$reply);
				return ;
			}

			fputs($this->smtp_conn,"AUTH LOGIN" . $this->CRLF);
			$reply = $this->getResponse();
			$code = intval(substr($reply,0,3));
			if($code != 334)
			{
				error_log($this->_error = "AUTH not accepted from server.".$code.$reply);
				return ;
			}

			fputs($this->smtp_conn, base64_encode($username) . $this->CRLF);
			$reply = $this->getResponse();
			$code = intval(substr($reply,0,3));
			if($code != 334)
			{
				error_log($this->_error = "Username not accepted from server".$code.$reply);
				return ;
			}

			fputs($this->smtp_conn, base64_encode($password) . $this->CRLF);

			$reply = $this->getResponse();
			$code = intval(substr($reply,0,3));
			if($code != 235)
			{
				error_log($this->error = "Password not accepted from server".$code.$reply);
				return ;
			}

			return ;
		}

	}

	function send($emailHeaderInfo, $emailBody)
	{
		fputs($this->smtp_conn,"MAIL FROM:<".$emailHeaderInfo['from'].">" . $this->CRLF);

        $reply = $this->getResponse();
        $code = substr($reply,0,3);
		//error_log($reply);
		fputs($this->smtp_conn,"RCPT TO:<".$emailHeaderInfo['to'].">" . $this->CRLF);

        $reply = $this->getResponse();
		//error_log($reply);
        $code = substr($reply,0,3);

		$header = "MIME-Version: 1.0\n";

		$tz = date("Z");
        $tzs = ($tz < 0) ? "-" : "+";
        $tz = abs($tz);
        $tz = ($tz/3600)*100 + ($tz%3600)/60;
		$header .='Date: '.sprintf("%s %s%04d", date("D, j M Y H:i:s"), $tzs, $tz)."\n";

		$header .= "From: ".$emailHeaderInfo['from']."\n";
		$header .= "To: ".$emailHeaderInfo['to']."\n";
		$header .= "Replay-to: ".$emailHeaderInfo['reply']."\n";
		if($emailHeaderInfo['cc'])
			$header .="Cc: " . $emailHeaderInfo['cc'] ."\n";
		if($emailHeaderInfo['bcc'])
			$header .="Bcc: " . $emailHeaderInfo['bcc'] ."\n";
		$header .= "Subject: ".$emailHeaderInfo['subject']."\n";
		$header .= "X-Mailer: <!-- from contec -->contec"."\n";
		$header .= $emailHeaderInfo['contentType'];




		fputs($this->smtp_conn,"DATA" . $this->CRLF);
		$reply = $this->getResponse();
        $code = substr($reply,0,3);

        if($code != 354)
		{
            $this->_error = "DATA command not accepted from server".$code.$reply;
            return false;
        }
		fputs($this->smtp_conn,$header .$emailBody . $this->CRLF);
		fputs($this->smtp_conn, $this->CRLF . "." . $this->CRLF);
		//error_log($this->getResponse());

		return true;
	}

	function quit()
	{
		if(is_resource($this->smtp_conn))
			fclose($this->smtp_conn);
		return;
	}

	function getResponse()
	{
		$data = "";
        while($str = fgets($this->smtp_conn,512)) {
            $data .= $str;
            if(substr($str,3,1) == " ")
				break;
        }
        return $data;
	}
}

class socket
{
	public $_conn;

	public $_errno;

	public $_errstr;

	public $CRLF = "\r\n";

	public $debug = false;
	/**
	 *@Description : Constructor. create a connection with remote server
	 *
	 *@Param : string	remote host
	 *@Param : int		port remote host monitoring
	 *@Param : int		time out
	 *
	 *@return: void
	 */
	public function socket($host, $port, $timeout=30)
	{
		if(is_resource($this->_conn))
		{//already connecting with some remote server. close it
			$this->close($this->_conn);
			return ;
		}
		$this->_conn = fsockopen($host, $port, $this->_errno, $this_errstr, $timeout);
	}//END::function close
	
	/**
	 *@Description : Close remote server connection
	 *
	 *@Return: void
	 */
	public function close()
	{
		@fclose($this-_conn);
	}//END::function close

	/**
	 *@Description : error recipient
	 *
	 *@Param : string	error description
	 *
	 *@Retrun: void
	 */
	public function mkError($reason)
	{
		$timeStamp = date("[Y-m-d H:i:s]", time());
		array_push($this->_errors, $timeStamp.$reason."\n");
	}//END::function mkError
}//END::class


class email_pop extends socket
{
	/************** start property zone ******************/
	/**
	 *@array	error recipient
	 */
	public $_errors = array();

	/**
	 *@boolean	set debug mode
	 */
	public $debug = true;
	/************** end property zone ********************/

	/************** start method zone ********************/
	/**
	 *@Description : get remote server responsed string
	 *
	 *@Return : string
	 */
	private function getResponse()
	{
		$data = "";
        while($str = fgets($this->_conn,512)) {
            if(trim(substr($str, 0, 2)) == ".")// if the last line is '.', that means responsing end
				break;
			$data .= $str;
        }
        return $data;
	}//END::function getResponse

	/**
	 *@Description : open pop server
	 *
	 *@Param : string	remote server. if security connection, please use 'ssl://remoteserver'.
	 *@Param : int		port remote server monitoring
	 *@Param : int		time out
	 *
	 *@Return: void
	 */
	public function email_pop($host, $port=110, $timeout=30)
	{
		$this->socket($host, $port, $timeout=30);
		$ret = fgets($this->_conn,512);
		if($this->debug)
			error_log( "email_pop() get $ret ");
	}//END::function email_pop

	/**
	 *@Description : login remote server
	 *
	 *@Param : string	user name
	 *@Param : string	password
	 *
	 *@Return: boolean
	 */
	public function login($name, $pass)
	{
		if(!is_resource($this->_conn))
		{
			$this->mkError(" login failed. have not connect to host");
			return false;
		}
		
		fputs($this->_conn, 'USER '.$name.$this->CRLF);
		$ret = fgets($this->_conn,512);
		if($this->debug)
			error_log( "login() get $ret ");
		if(strpos($ret, "OK")===false)
		{
			$this->mkError(" POP serser does not accept this user:$name");
			return false;
		}
		fputs($this->_conn, 'PASS '.$pass.$this->CRLF);
		$ret = fgets($this->_conn,512);
		if($this->debug)
			error_log( "login() get $ret ");
		if(strpos($ret, "OK")===false)
		{
			$this->mkError(" POP serser does not accept password:$name");
			return false;
		}
		return true;
	}//END:: login

	/**
	 *@Description : get email id list
	 *
	 *@Return: array
	 */
	public function getUidl()
	{
		if(!is_resource($this->_conn))
		{
			$this->mkError(" getUidl failed. have not connect to host");
			return false;
		}
		$data = array();
		fputs($this->_conn, "UIDL".$this->CRLF);// UIDL is pop command. it will get a list including email unique id
		while(trim(substr(($str = fgets($this->_conn,512)), 0, 2))!=".")// if one line only includes '.',that means end of response
		{
			list($emailSeq, $emailUid) = sscanf($str, "%d %s");
			if($emailSeq && $emailUid)
			{
				$data[$emailSeq] = $emailUid;
			}
		}
		if($this->debug)
			error_log( "getUidl() get $data ");
		return $data;
	}//END:: getUidl

	/**
	 *@Description : get email header(from,subject,date) by id
	 *
	 *@Param : int		email id. this id is sequence id. not email unique id.
	 *
	 *@Return: array
	 */
	public function getHeader($emailId)
	{
		$headerStr = '';
		if(!is_resource($this->_conn))
		{
			$this->mkError(" getHeader $emailId failed. have not connect to host");
			return false;
		}
		fputs($this->_conn, "TOP $emailId 0".$this->CRLF);// 'TOP' is pop command. it will show the email specific lines data. we only use 'TOP 1 0' to get header.

		while(substr($headerLine = fgets($this->_conn), 0, 1)!='.')
		{
			$headerStr .= $headerLine;
		}
		$header = $this->_parseEmailHeader($headerStr);
		return $header;
	}//END:: getHeader

	/**
	 *@Description : get email amount in mailbox
	 *
	 *@Return : int
	 */
	public function getEmailAmount()
	{
		if(!is_resource($this->_conn))
		{
			$this->mkError(" getEmailAmount failed. have not connect to host");
			return false;
		}
		fputs($this->_conn, "STAT".$this->CRLF);// 'STAT' is pop command, it will return email amount
		$ret = fgets($this->_conn,512);
		if(($_tmp = explode(" ", $ret)) && count($_tmp))
		{
			for($i=0;$i<count($_tmp);$i++)
			{
				if(is_numeric($_tmp[$i]))
					return $_tmp[$i];
			}
			$this->mkError(" getEmailAmount failed. return invalid string: $ret");
			return false;
		}

		$this->mkError(" getEmailAmount failed. return invalid string: $ret");
		return false;
	}//END:: getEmailAmount

	/**
	 *@Description : get email content data
	 *
	 *@Return : string
	 */
	public function getEmailContent($emailId)
	{
		$body = '';
		if(!is_resource($this->_conn))
		{
			$this->mkError(" getEmailContent failed. have not connect to host");
			return false;
		}
		fputs($this->_conn, "RETR $emailId".$this->CRLF);// 'RETR' is pop command, it will return the whole email content.
		$ret = $this->getResponse();
		return $ret;
	}//END:: getEmailContent

	/**
	 *@Descirption : parse email header
	 *
	 *@Return : array
	 */
	private function _parseEmailHeader($headerContent)
	{
		preg_match_all("/From:([^\n]+)/s", $headerContent, $_from);
		preg_match_all("/Subject:([^\n]*)/s", $headerContent, $_subject);
		preg_match_all("/Date:([^\n]+)/s", $headerContent, $_date);

		return array(str_replace(array("\r","\n","'"),array('','','"'),$_from[1][0]), str_replace(array("\r","\n","'"),array('','','"'),$_subject[1][0]), strtotime($_date[1][0])+3600*8);
	}//END:: _parseEmailHeader

	/**
	 *@Description : set debug mode
	 *
	 *@return : void
	 */
	public function debug($debug)
	{
		$this->debug = $debug;
	}//END::function debug

}//END::class

/* login */
$pop = new email_pop('pop.126.com', 110);
$pop->login('wangkilin', 'mingxiazhou4585999');


//var_dump($pop->_errors);
$emailNum = $pop->getEmailAmount();
$uidl = $pop->getUidl();// get email unique ids list. this command is very fast
//echo count($uidl);
$emailTimeCache = array();// will store email recieved time info
$totalEmailCache = array();// will store email header info(sender, time, title, id)
$uidlCache = array();// email unique ids.  unique id not equal email id. email id is sequence,and it would change if we delete an email from box. but unique id will not change.

/* check if the cache file exists */
if(file_exists('email_info.php'))
	include_once('email_info.php');
if(count($uidlCache) && count($totalEmailCache) && count($emailTimeCache))
{// cache file exists, and it has content
	foreach($uidlCache as $key=>$value)
	{$j++;
		if(array_search($value, $uidl)===false)
		{
			unset($uidlCache[$key]);
			unset($totalEmailCache[$value]);
			if(($_tmpKey = array_search($value,$emailTimeCache))!==false)
				unset($emailTimeCache[$_tmpKey]);
		}
	}
}
else
{// no cache info.
	$emailTimeCache = array();
	$totalEmailCache = array();
	$uidlCache = array();
}
foreach($uidl as $key=>$value)
{
	if((time()-$startTime)>5)
		break;
	$i++;
	if(isset($totalEmailCache[$value]))
	{
		$totalEmailCache[$value][3] = $key;
		$totalEmailCache[$value][4] = array_search($value,$emailTimeCache);
	}
	else
	{
		$emailHeader = $pop->getHeader($key);
		$totalEmailCache[$uidl[$key]] =$emailHeader;
		$timeKey = "t".sprintf('%0-15s', $emailHeader[2].$key);
		$emailTimeCache[$timeKey] = $uidl[$key];
		$totalEmailCache[$uidl[$key]][4] = $timeKey;
		$totalEmailCache[$uidl[$key]][3] = $key;
	}
	//echo $uidl[$key]."<br>";
	//echo $timeKey."<hr>";
}

$uidlStr = '$uidlCache = array("'.join('","',array_keys($totalEmailCache))."\");\n";
foreach($totalEmailCache as $key=>$value)
{
	$totalEmailStr .= "\$totalEmailCache['$key'] = array('$value[0]','$value[1]', $value[2], $value[3]);\n";
	$timeKey = $value[4];
	$emailTimeStr .= "\$emailTimeCache['$timeKey'] = '".$key."';\n";

}

krsort($emailTimeCache);
$i=1;
echo "<table border=1>";
while(list($key,$value)=each($emailTimeCache))
{
	echo "<tr><td>".$i++."</td><td>".date("Y-m-d H:i:s",$totalEmailCache[$value][2])."</td><td>".$totalEmailCache[$value][0]."</td><td>".$totalEmailCache[$value][1]."</td><td>".$totalEmailCache[$value][3]."</td></tr>";
}
echo "</table>";

file_put_contents("email_info.php","<?php\n".$uidlStr.$totalEmailStr.$emailTimeStr."\n?>");


 ?>
