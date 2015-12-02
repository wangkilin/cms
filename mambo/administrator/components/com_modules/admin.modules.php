<?php
/**
* @version $Id: admin.modules.php,v 1.2 2004/10/02 17:12:52 mibi Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'modules', 'all' )
| $acl->acl_check( 'administration', 'install', 'users', $my->usertype, 'modules', 'all' ))) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'admin_html' ) );

$client = mosGetParam( $_REQUEST, 'client', '' );
$cid = mosGetParam( $_POST, 'cid', array(0) );
$moduleid = mosGetParam( $_REQUEST, 'moduleid', null );
if ($cid[0] == 0 && isset($moduleid) ) {
	$cid[0] = $moduleid;
}

switch ( $task ) {
	case 'copy':
		copyModule( $option, intval( $cid[0] ), $client );
		break;

	case 'new':
		editModule( $option, 0, $client );
		break;

	case 'edit':
		editModule( $option, $cid[0], $client );
		break;

	case 'save':
		mosCache::cleanCache( 'com_content' );
		saveModule( $option, $client );
		break;

	case "remove":
		removeModule( $cid, $option, $client );
		break;

	case 'cancel':
		cancelModule( $option, $client );
		break;

	case 'publish':
	case 'unpublish':
		mosCache::cleanCache( 'com_content' );
		publishModule( $cid, ($task == 'publish'), $option, $client );
		break;

	case 'orderup':
	case 'orderdown':
		orderModule( $cid[0], ($task == 'orderup' ? -1 : 1), $option, $client );
		break;

	case 'accesspublic':	
	case 'accessregistered':
	case 'accessspecial':
		accessMenu( $cid[0], $task, $option, $client );
		break;

	default:
		viewModules( $option, $client );
		break;
}

/**
* Compiles a list of installed or defined modules
*/
function viewModules( $option, $client ) {
	global $database, $my, $mainframe, $mosConfig_list_limit;

	if ($client == 'admin') {
		$where = "client_id='1'";
	} else {
		$where = "client_id='0'";
	}

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

	// get the total number of records
	$database->setQuery( "SELECT count(*) FROM #__modules WHERE $where" );
	$total = $database->loadResult();

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit );

	$database->setQuery( "SELECT m.*, u.name AS editor, g.name AS groupname, MIN(mm.menuid) AS pages"
	. "\nFROM #__modules AS m"
	. "\nLEFT JOIN #__users AS u ON u.id = m.checked_out"
	. "\nLEFT JOIN #__groups AS g ON g.id = m.access"
	. "\nLEFT JOIN #__modules_menu AS mm ON mm.moduleid=m.id"
	. "\nWHERE $where"
	. "\nGROUP BY m.id"
	. "\nORDER BY published DESC, position ASC, ordering ASC"
	. "\nLIMIT $pageNav->limitstart,$pageNav->limit"
	);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	HTML_modules::showModules( $rows, $my->id, $client, $pageNav, $option );
}

/**
* Compiles information to add or edit a module
* @param string The current GET/POST option
* @param integer The unique id of the record to edit
*/
function copyModule( $option, $uid, $client ) {
	global $database, $my, $adminLanguage;

	$row = new mosModule( $database );
	// load the row from the db table
	$row->load( $uid );
	$row->title = $adminLanguage->A_COMP_CATEG_COPY_OF ." ".$row->title;
	$row->id = 0;
	$row->iscore = 0;
	$row->published = 0;

	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();
	if ($client == 'admin') {
		$where = "client_id='1'";
	} else {
		$where = "client_id='0'";
	}
	$row->updateOrder( "position='$row->position' AND ($where)" );

	$database->setQuery( "SELECT menuid FROM #__modules_menu WHERE moduleid='$uid'" );
	$rows = $database->loadResultArray();

	foreach($rows as $menuid) {
		$database->setQuery( "INSERT INTO #__modules_menu"
		. "\nSET moduleid='$row->id', menuid='$menuid'"
		);
		$database->query();
	}
	mosRedirect( 'index2.php?option='. $option .'&client='. $client );
}

/**
* Saves the module after an edit form submit
*/
function saveModule( $option, $client ) {
	global $database;

	$params = mosGetParam( $_POST, 'params', '' );
	if (is_array( $params )) {
		$txt = array();
		foreach ($params as $k=>$v) {
			$txt[] = "$k=$v";
		}
		$_POST['params'] = implode( "\n", $txt );
	}

	$row = new mosModule( $database );
	if (!$row->bind( $_POST, 'selections' )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();
	if ($client == 'admin') {
		$where = "client_id='1'";
	} else {
		$where = "client_id='0'";
	}
	$row->updateOrder( "position='$row->position' AND ($where)" );

	$menus = mosGetParam( $_POST, 'selections', array() );

	$database->setQuery( "DELETE FROM #__modules_menu WHERE moduleid='$row->id'" );
	$database->query();

	foreach ($menus as $menuid){
		// this check for the blank spaces in the select box that have been added for cosmetic reasons
		if ( $menuid <> "-999" ) {
			$database->setQuery( "INSERT INTO #__modules_menu"
			. "\nSET moduleid='$row->id', menuid='$menuid'"
			);
			$database->query();
		}
	}

	mosRedirect( 'index2.php?option='. $option .'&client='. $client );
}

/**
* Compiles information to add or edit a module
* @param string The current GET/POST option
* @param integer The unique id of the record to edit
*/
function editModule( $option, $uid, $client ) {
	global $database, $my, $mainframe, $adminLanguage;
	global $mosConfig_absolute_path;

	$lists = array();
	$row = new mosModule( $database );
	// load the row from the db table
	$row->load( $uid );
	// fail if checked out not by 'me'
	if ( $row->checked_out && $row->checked_out <> $my->id ) {
		echo "<script>alert(\"". $adminLanguage->A_COMP_CONTENT_MODULE ." ". $row->title ." ". $adminLanguage->A_COMP_CONTENT_ANOTHER ."\"); document.location.href='index2.php?option=$option'</script>\n";
		exit(0);
	}

	$row->content = htmlspecialchars( str_replace( '&amp;', '&', $row->content ) );

	if ( $uid ) {
		$row->checkout( $my->id );
	}
	// if a new record we must still prime the mosModule object with a default
	// position and the order; also add an extra item to the order list to
	// place the 'new' record in last position if desired
	if ($uid == 0) {
		$row->position = 'left';
		$row->showtitle = true;
		//$row->ordering = $l;
		$row->published = 1;
	}


	if ( $client == 'admin' ) {
		$where = "client_id='1'";
		$lists['client_id'] = 1;
	} else {
		$where = "client_id='0'";
		$lists['client_id'] = 0;
	}
	$query = "SELECT position, ordering, showtitle, title"
	. "\n FROM #__modules"
	. "\n WHERE ". $where
	. "\n ORDER BY ordering"
	;
	$database->setQuery( $query );
	if ( !($orders = $database->loadObjectList()) ) {
		echo $database->stderr();
		return false;
	}

	$query = "SELECT position, description"
	. "\n FROM #__template_positions"
	. "\n WHERE position <> ''"
	;
	$database->setQuery( $query );
	// hard code options for now
	$positions = $database->loadObjectList();

	$orders2 = array();
	$pos = array();
	foreach ($positions as $position) {
		$orders2[$position->position] = array();
		$pos[] = mosHTML::makeOption( $position->position, $position->description );
	}

	$l = 0;
	$r = 0;
	for ($i=0, $n=count( $orders ); $i < $n; $i++) {
		$ord = 0;
		if (array_key_exists( $orders[$i]->position, $orders2 )) {
			$ord =count( array_keys( $orders2[$orders[$i]->position] ) ) + 1;
		}

		$orders2[$orders[$i]->position][] = mosHTML::makeOption( $ord, $ord.'::'.addslashes( $orders[$i]->title ) );
	}

	// build the html select list
	$pos_select = 'onchange="changeDynaList(\'ordering\',orders,document.adminForm.position.options[document.adminForm.position.selectedIndex].value, originalPos, originalOrder)"';
	$active = ( $row->position ? $row->position : 'left' );
	$lists['position'] = mosHTML::selectList( $pos, 'position', 'class="inputbox" size="1" '. $pos_select, 'value', 'text', $active );

	// get selected pages for $lists['selections']
	if ( $uid ) {
		$query = 'SELECT menuid AS value FROM #__modules_menu WHERE moduleid='. $row->id;
		$database->setQuery( $query );
		$lookup = $database->loadObjectList();
	} else {
		$lookup = array( mosHTML::makeOption( 0, 'All' ) );
	}

	if ( $row->access == 99 || $row->client_id == 1 || $lists['client_id'] ) {
		$lists['access'] 			= 'Administrator<input type="hidden" name="access" value="99" />';
		$lists['showtitle'] 		= 'N/A <input type="hidden" name="showtitle" value="1" />';
		$lists['selections'] 		= 'N/A';
	} else {
		if ( $client == 'admin' ) {
			$lists['access'] 		= 'N/A';
			$lists['selections'] 	= 'N/A';
		} else {
			$lists['access'] 		= mosAdminMenus::Access( $row );
			$lists['selections'] 	= mosAdminMenus::MenuLinks( $lookup, 1, 1 );
		}
		$lists['showtitle'] = mosHTML::yesnoRadioList( 'showtitle', 'class="inputbox"', $row->showtitle );
	}

	// build the html select list for published
	$lists['published'] 			= mosAdminMenus::Published( $row );

	// get params definitions
	$params =& new mosParameters( $row->params, $mainframe->getPath( 'mod0_xml', $row->module ), 'module' );

	HTML_modules::editModule( $row, $orders2, $lists, $params, $option );
}

/**
* Deletes one or more modules
*
* Also deletes associated entries in the #__module_menu table.
* @param array An array of unique category id numbers
*/
function removeModule( &$cid, $option, $client ) {
	global $database, $my, $adminLanguage;

	if (count( $cid ) < 1) {
		echo "<script> alert(\"". $adminLanguage->A_COMP_MAMB_DEL ."\"); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "SELECT id, module, title, iscore FROM #__modules WHERE id IN ($cids)" );
	if (!($rows = $database->loadObjectList())) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
	}

	$err = array();
	$cid = array();
	foreach ($rows as $row) {
		if ($row->module == '' || $row->iscore == 0) {
			$cid[] = $row->id;
		} else {
			$err[] = $row->title;
		}
	}

	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$database->setQuery( "DELETE FROM #__modules WHERE id IN ($cids)" );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit;
		}
		$database->setQuery( "DELETE from #__modules_menu WHERE moduleid IN ($cids)" );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."');</script>\n";
			exit;
		}
		$mod = new mosModule( $database );
		$mod->ordering = 0;
		$mod->updateOrder( "position='left'" );
		$mod->updateOrder( "position='right'" );
	}

	if (count( $err )) {
		$cids = addslashes( implode( "', '", $err ) );
		echo "<script>alert(\"". $adminLanguage->A_COMP_MOD_MODULES .": '". $cids ."' ". $adminLanguage->A_COMP_MOD_CANNOT ."\");</script>\n";
	}

	mosRedirect( 'index2.php?option='. $option .'&client='. $client );
}

/**
* Publishes or Unpublishes one or more modules
* @param array An array of unique record id numbers
* @param integer 0 if unpublishing, 1 if publishing
*/
function publishModule( $cid=null, $publish=1, $option, $client ) {
	global $database, $my, $adminLanguage;

	if (count( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert(\"". $adminLanguage->A_COMP_MOD_SELECT_TO ." ". $action ."\"); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$query = "UPDATE #__modules SET published='$publish'"
	. "\n WHERE id IN ($cids)"
	. "\n AND (checked_out=0 OR (checked_out='$my->id'))"
	;
	$database->setQuery( $query );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (count( $cid ) == 1) {
		$row = new mosModule( $database );
		$row->checkin( $cid[0] );
	}

	mosRedirect( 'index2.php?option='. $option .'&client='. $client );
}

/**
* Cancels an edit operation
*/
function cancelModule( $option, $client ) {
	global $database;

	$row = new mosModule( $database );
	// ignore array elements
	$row->bind( $_POST, 'selections params' );
	$row->checkin();

	mosRedirect( 'index2.php?option='. $option .'&client='. $client );
}

/**
* Moves the order of a record
* @param integer The unique id of record
* @param integer The increment to reorder by
*/
function orderModule( $uid, $inc, $option ) {
	global $database;

	$client = mosGetParam( $_POST, 'client', '' );

	$row = new mosModule( $database );
	$row->load( $uid );
	if ($client == 'admin') {
		$where = "client_id='1'";
	} else {
		$where = "client_id='0'";
	}

	$row->move( $inc, "position='$row->position' AND ($where)"  );
	if ( $client ) {
		$client = '&client=admin' ;
	} else {
		$client = '';
	}

	mosRedirect( 'index2.php?option='. $option .'&client='. $client );
}

/**
* changes the access level of a record
* @param integer The increment to reorder by
*/
function accessMenu( $uid, $access, $option, $client ) {
	global $database;

	switch ( $access ) {
		case 'accesspublic':	
			$access = 0;
			break;

		case 'accessregistered':
			$access = 1;
			break;

		case 'accessspecial':
			$access = 2;
			break;
	} 

	$row = new mosModule( $database );
	$row->load( $uid );
	$row->access = $access;

	if ( !$row->check() ) {
		return $row->getError();
	}
	if ( !$row->store() ) {
		return $row->getError();
	}

	mosRedirect( 'index2.php?option='. $option .'&client='. $client );
}

?>
