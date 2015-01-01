<?php
/**
* @version $Id: admin.frontpage.php,v 1.1 2004/10/01 17:07:56 mibi Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' )
		| $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_frontpage' ))) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

// call
require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );

$act = mosGetParam( $_REQUEST, 'act', null );
$task = mosGetParam( $_REQUEST, 'task', array(0) );
$cid = mosGetParam( $_POST, 'cid', array(0) );
if (!is_array( $cid )) {
	$cid = array(0);
}

switch($act) {

	default:
		switch ($task) {
			case "publish":
				changeFrontPage( $cid, 1, $option );
				break;

			case "unpublish":
				changeFrontPage( $cid, 0, $option );
				break;

			case "archive":
				changeFrontPage( $cid, -1, $option );
				break;

			case "remove":
				removeFrontPage( $cid, $option );
				break;

			case "orderup":
				orderFrontPage( $cid[0], -1, $option );
				break;

			case "orderdown":
				orderFrontPage( $cid[0], 1, $option );
				break;

			default:
				viewFrontPage( $option );
				break;
		}
		break;
}

/**
* Compiles a list of frontpage items
*/
function viewFrontPage( $option ) {
	global $database, $mainframe, $mosConfig_list_limit;

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
	$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
	$search = $database->getEscaped( trim( strtolower( $search ) ) );

	$where = array(
	"c.state >= 0"
	);

	if ($search) {
		$where[] = "LOWER(c.title) LIKE '%$search%'";
	}

	// get the total number of records
	$database->setQuery( "SELECT count(*)"
		. "\nFROM #__content AS c"
		. "\nINNER JOIN #__categories AS cc ON cc.id = c.catid"
		. "\nINNER JOIN #__sections AS s ON s.id = cc.section AND s.scope='content'"
		. "\nINNER JOIN #__content_frontpage AS f ON f.content_id = c.id"
		. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	);
	$total = $database->loadResult();

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit );

	$database->setQuery( "SELECT c.*, g.name AS groupname, cc.name, u.name AS editor, f.ordering AS fpordering"
	. "\nFROM #__content AS c"
	. "\nINNER JOIN #__categories AS cc ON cc.id = c.catid"
	. "\nINNER JOIN #__sections AS s ON s.id = cc.section AND s.scope='content'"
	. "\nINNER JOIN #__content_frontpage AS f ON f.content_id = c.id"
	. "\nINNER JOIN #__groups AS g ON g.id = c.access"
	. "\nLEFT JOIN #__users AS u ON u.id = c.checked_out"
	. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	. "\nORDER BY f.ordering"
	. "\nLIMIT $pageNav->limitstart,$pageNav->limit"
	);

	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	HTML_content::showList( $rows, $search, $pageNav, $option );
}

/**
* Changes the state of one or more content pages
* @param array An array of unique category id numbers
* @param integer 0 if unpublishing, 1 if publishing
*/
function changeFrontPage( $cid=null, $state=0, $option ) {
	global $database, $my, $adminLanguage;

	if (count( $cid ) < 1) {
		$action = $publish == 1 ? 'publish' : ($publish == -1 ? 'archive' : 'unpublish');
		echo "<script> alert(\"". $adminLanguage->A_COMP_SEL_ITEM ." ". $action ."\"); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__content SET state='$state'"
	. "\nWHERE id IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))"
	);
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (count( $cid ) == 1) {
		$row = new mosContent( $database );
		$row->checkin( $cid[0] );
	}

	mosRedirect( "index2.php?option=$option" );
}

function removeFrontPage( &$cid, $option ) {
	global $database, $adminLanguage;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert(\"". $adminLanguage->A_COMP_CONTENT_SEL_DEL ."\"); window.history.go(-1);</script>\n";
		exit;
	}
	$fp = new mosFrontPage( $database );
	foreach ($cid as $id) {
		if (!$fp->delete( $id )) {
			echo "<script> alert('".$fp->getError()."'); </script>\n";
			exit();
		}
		$obj = new mosContent( $database );
		$obj->load( $id );
		$obj->mask = 0;
		if (!$obj->store()) {
			echo "<script> alert('".$fp->getError()."'); </script>\n";
			exit();
		}
	}
	$fp->updateOrder();

	mosRedirect( "index2.php?option=$option" );
}

/**
* Moves the order of a record
* @param integer The increment to reorder by
*/
function orderFrontPage( $uid, $inc, $option ) {
	global $database;

	$fp = new mosFrontPage( $database );
	$fp->load( $uid );
	$fp->move( $inc );

	mosRedirect( "index2.php?option=$option" );
}

/**
* Displays front page settings option
*/
function viewSettings( $option, $act ) {
	global $database;

	$database->setQuery( "SELECT col_main FROM #__templates WHERE id=0" );
	$col = $database->loadResult();

	$params = array();
	$database->setQuery( "SELECT params FROM #__menu WHERE link='index.php?option=com_frontpage'" );
	$param = mosParseParams( $database->loadResult() );
	$params['count'] = isset( $param->count ) ? $param->count : 6;
	$params['intro'] = isset( $param->intro ) ? $param->intro : 3;
	$params['image'] = @$param->image ? 1 : 0;
	$params['header'] = @$param->header;
	$params['empty'] = @$param->empty;
	$params['orderby'] = @$param->orderby;
	$params['image'] = mosHTML::yesnoSelectList( 'image', 'class="inputbox" size="1"', $params['image'] );
	$orderby[] = mosHTML::makeOption( 'ordering', 'Ordering' );
	$orderby[] = mosHTML::makeOption( 'date', 'Date asc' );
	$orderby[] = mosHTML::makeOption( 'rdate', 'Date desc' );
	$params['orderby'] = mosHTML::selectList( $orderby, 'orderby', 'class="inputbox" size="1"', 'value', 'text', $params['orderby'] );

	HTML_content::showSettings( $col, $option, $params, $act );
}

/**
* Saves front page settings options
*/
function saveSettings( $option, $act ) {
	GLOBAL $database, $adminLanguage;
	$col_main = mosGetParam( $_POST, 'col_main', 1 );
	$count = mosGetParam( $_POST, 'count', 6 );
	if ($count!="" && !is_numeric($count)) {
		echo "<script> alert(\"". $adminLanguage->A_COMP_FRONT_COUNT_NUM ."\"); window.history.go(-1); </script>\n";
		die;
	}
	$intro = mosGetParam( $_POST, 'intro', 3 );
	if ($intro!="" && !is_numeric($intro)) {
		echo "<script> alert(\"". $adminLanguage->A_COMP_FRONT_INTRO_NUM ."\"); window.history.go(-1); </script>\n";
		die;
	}
	$image = mosGetParam( $_POST, 'image', 1 );
	$header = mosGetParam( $_POST, 'header', $adminLanguage->A_COMP_FRONT_WELCOME );
	$empty = mosGetParam( $_POST, 'empty', $adminLanguage->A_COMP_FRONT_IDONOT );
	$orderby = mosGetParam( $_POST, 'orderby', 'ordering' );

	$database->setQuery( "UPDATE #__templates SET col_main=$col_main WHERE id=0" );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		die;
	}

	$params = "count=$count\nintro=$intro\nimage=$image\nheader=$header\nempty=$empty\norderby=$orderby";

	$database->setQuery( "UPDATE #__menu SET params='$params' WHERE link='index.php?option=com_frontpage'" );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		die;
	}
	mosRedirect( "index2.php?mosmsg=The%20frontpage%20settings%20have%20been%20updated!" );
}
?>