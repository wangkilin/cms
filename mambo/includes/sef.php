<?php
/**
* @version $Id: sef.php,v 1.12 2004/09/08 13:24:43 saka Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

if ($mosConfig_sef) {
	$url_array = explode("/", $_SERVER['REQUEST_URI']);
	/**
	* Content
	* http://www.domain.com/$option/$task/$sectionid/$id/$Itemid/$limit/$limitstart
	*/
	if (in_array("content", $url_array)) {

		$uri = explode("content/", $_SERVER['REQUEST_URI']);
		$option = "com_content";
		$_GET['option'] = $option;
		$_REQUEST['option'] = $option;
		$pos = array_search ("content", $url_array);

		// $option/$task/$sectionid/$id/$Itemid/$limit/$limitstart
		if (isset($url_array[$pos+6]) && $url_array[$pos+6]!="") {
			$task = $url_array[$pos+1];
			$sectionid = $url_array[$pos+2];
			$id = $url_array[$pos+3];
			$Itemid = $url_array[$pos+4];
			$limit = $url_array[$pos+5];
			$limitstart = $url_array[$pos+6];
			$_GET['task'] = $task;
			$_REQUEST['task'] = $task;
			$_GET['sectionid'] = $sectionid;
			$_REQUEST['sectionid'] = $sectionid;
			$_GET['id'] = $id;
			$_REQUEST['id'] = $id;
			$_GET['Itemid'] = $Itemid;
			$_REQUEST['Itemid'] = $Itemid;
			$_GET['limit'] = $limit;
			$_REQUEST['limit'] = $limit;
			$_GET['limitstart'] = $limitstart;
			$_REQUEST['limitstart'] = $limitstart;
			$QUERY_STRING = "option=com_content&task=$task&sectionid=$sectionid&id=$id&Itemid=$Itemid&limit=$limit&limitstart=$limitstart";
			// $option/$task/$id/$Itemid/$limit/$limitstart
		} else if (isset($url_array[$pos+5]) && $url_array[$pos+5]!="") {
			$task = $url_array[$pos+1];
			$id = $url_array[$pos+2];
			$Itemid = $url_array[$pos+3];
			$limit = $url_array[$pos+4];
			$limitstart = $url_array[$pos+5];
			$_GET['task'] = $task;
			$_REQUEST['task'] = $task;
			$_GET['id'] = $id;
			$_REQUEST['id'] = $id;
			$_GET['Itemid'] = $Itemid;
			$_REQUEST['Itemid'] = $Itemid;
			$_GET['limit'] = $limit;
			$_REQUEST['limit'] = $limit;
			$_GET['limitstart'] = $limitstart;
			$_REQUEST['limitstart'] = $limitstart;
			$QUERY_STRING = "option=com_content&task=$task&id=$id&Itemid=$Itemid&limit=$limit&limitstart=$limitstart";
			// $option/$task/$sectionid/$id/$Itemid
		} else if (!(isset($url_array[$pos+5]) && $url_array[$pos+5]!="") && isset($url_array[$pos+4]) && $url_array[$pos+4]!="") {
			$task = $url_array[$pos+1];
			$sectionid = $url_array[$pos+2];
			$id = $url_array[$pos+3];
			$Itemid = $url_array[$pos+4];
			$_GET['task'] = $task;
			$_REQUEST['task'] = $task;
			$_GET['sectionid'] = $sectionid;
			$_REQUEST['sectionid'] = $sectionid;
			$_GET['id'] = $id;
			$_REQUEST['id'] = $id;
			$_GET['Itemid'] = $Itemid;
			$_REQUEST['Itemid'] = $Itemid;
			$QUERY_STRING = "option=com_content&task=$task&sectionid=$sectionid&id=$id&Itemid=$Itemid";
			// $option/$task/$id/$Itemid
		} else if (!(isset($url_array[$pos+4]) && $url_array[$pos+4]!="") && (isset($url_array[$pos+3]) && $url_array[$pos+3]!="")) {
			$task = $url_array[$pos+1];
			$id = $url_array[$pos+2];
			$Itemid = $url_array[$pos+3];
			$_GET['task'] = $task;
			$_REQUEST['task'] = $task;
			$_GET['id'] = $id;
			$_REQUEST['id'] = $id;
			$_GET['Itemid'] = $Itemid;
			$_REQUEST['Itemid'] = $Itemid;
			$QUERY_STRING = "option=com_content&task=$task&id=$id&Itemid=$Itemid";
			// $option/$task/$id
		} else if (!(isset($url_array[$pos+3]) && $url_array[$pos+3]!="") && (isset($url_array[$pos+2]) && $url_array[$pos+2]!="")) {
			$task = $url_array[$pos+1];
			$id = $url_array[$pos+2];
			$_GET['task'] = $task;
			$_REQUEST['task'] = $task;
			$_GET['id'] = $id;
			$_REQUEST['id'] = $id;
			$QUERY_STRING = "option=com_content&task=$task&id=$id";
			// $option/$task
		} else if (!(isset($url_array[$pos+2]) && $url_array[$pos+2]!="") && (isset($url_array[$pos+1]) && $url_array[$pos+1]!="")) {
			$task = $url_array[$pos+1];
			$_GET['task'] = $task;
			$_REQUEST['task'] = $task;
			$QUERY_STRING = "option=com_content&task=$task";
		}
		$_SERVER['QUERY_STRING'] = $QUERY_STRING;
		$REQUEST_URI = $uri[0]."index.php?".$QUERY_STRING;
		$_SERVER['REQUEST_URI'] = $REQUEST_URI;
	}

	/*
	Components
	http://www.domain.com/component/$name,$value
	*/
	if (in_array("component", $url_array)) {

		$uri = explode("component/", $_SERVER['REQUEST_URI']);
		$uri_array = explode("/", $uri[1]);
		$QUERY_STRING = "";

		foreach($uri_array as $value) {
			$temp = explode(",", $value);
			if (isset($temp[0]) && $temp[0]!="" && isset($temp[1]) && $temp[1]!="") {
				$_GET[$temp[0]] = $temp[1];
				$_REQUEST[$temp[0]] = $temp[1];
				$QUERY_STRING .= $temp[0]=="option" ? "$temp[0]=$temp[1]" : "&$temp[0]=$temp[1]";
			}
		}

		$_SERVER['QUERY_STRING'] = $QUERY_STRING;
		$REQUEST_URI = $uri[0]."index.php?".$QUERY_STRING;
		$_SERVER['REQUEST_URI'] = $REQUEST_URI;
	}
	// Extract to globals
	while(list($key,$value)=each($_GET)) $GLOBALS[$key]=$value;
	// Don't allow config vars to be passed as global
	include( "configuration.php" );
}

function sefRelToAbs( $string ) {
	GLOBAL $mosConfig_live_site, $mosConfig_sef;

	if ($mosConfig_sef && !eregi("^(([^:/?#]+):)",$string) && !strcasecmp(substr($string,0,9),"index.php")) {

		// Replace all & with &amp;
		$string = str_replace( '&amp;', '&', $string );
		$string = str_replace( '&', '&amp;', $string );

		/*
		Home
		index.php
		*/
		if ($string=="index.php") {
			$string="";
		}

		$sefstring = "";
		if ( (eregi("option=com_content",$string) || eregi("option=content",$string) ) && !eregi("task=new",$string) && !eregi("task=edit",$string) ) {
			/*
			Content
			index.php?option=com_content&task=$task&sectionid=$sectionid&id=$id&Itemid=$Itemid&limit=$limit&limitstart=$limitstart
			*/
			$sefstring .= "content/";
			if (eregi("&amp;task=",$string)) {
				$temp = split("&amp;task=", $string);
				$temp = split("&", $temp[1]);
				$sefstring .= $temp[0]."/";
			}
			if (eregi("&amp;sectionid=",$string)) {
				$temp = split("&amp;sectionid=", $string);
				$temp = split("&", $temp[1]);
				$sefstring .= $temp[0]."/";
			}
			if (eregi("&amp;id=",$string)) {
				$temp = split("&amp;id=", $string);
				$temp = split("&", $temp[1]);
				$sefstring .= $temp[0]."/";
			}
			if (eregi("&amp;Itemid=",$string)) {
				$temp = split("&amp;Itemid=", $string);
				$temp = split("&", $temp[1]);
				$sefstring .= $temp[0]."/";
			}
			if (eregi("&amp;limit=",$string)) {
				$temp = split("&amp;limit=", $string);
				$temp = split("&", $temp[1]);
				$sefstring .= $temp[0]."/";
			}
			if (eregi("&amp;limitstart=",$string)) {
				$temp = split("&amp;limitstart=", $string);
				$temp = split("&", $temp[1]);
				$sefstring .= $temp[0]."/";
			}
			$string = $sefstring;
		} else if (eregi("option=com_",$string) && !eregi("option=com_registration",$string) && !eregi("task=new",$string) && !eregi("task=edit",$string)) {
			/*
			Components
			index.php?option=com_xxxx&...
			*/
			$sefstring = "component/";
			$temp = split("\?", $string);
			$temp = split("&amp;", $temp[1]);
			foreach($temp as $key => $value) {
				$sefstring .= $value."/";
			}
			$string = str_replace( '=', ',', $sefstring );
		}
		//echo $mosConfig_live_site."/".$string;
		return $mosConfig_live_site."/".$string;
	} else {
		return $string;
	}

}
?>
