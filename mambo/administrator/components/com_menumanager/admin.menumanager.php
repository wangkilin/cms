<?php
/**
* @version $Id: admin.menumanager.php,v 1.2 2004/10/02 17:12:29 mibi Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if (!$acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_menumanager' )) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'admin_html' ) );
$task = mosGetParam( $_REQUEST, 'task', array(0) );
$cid = mosGetParam( $_POST, 'cid', array(0) );
if ( !is_array( $cid ) ) {
	$cid = array(0);
}
$menu_name = mosGetParam( $_POST, 'menu_name', 'New Menu' );
$type = mosGetParam( $_POST, 'type', '' );

switch ($task) {
	case "new":
	editMenu( $option, 0 );
	break;

	case "edit":
	editMenu( $option, $cid[0] );
	break;

	case "copyconfirm":
	copyConfirm( $option, $cid );
	break;

	case "savemenu":
	saveMenu( $option );
	break;

	case "deleteconfirm":
	deleteconfirm( $option, $cid );
	break;

	case "deletemenu":
	deleteMenu( $option, $cid, $type );
	break;

	case "copymenu":
	copyMenu( $option, $cid, $menu_name, $type );
	break;

	case "cancel":
	cancelMenu( $option );
	break;

	default:
	showMenu( $option );
	break;
}


/**
* Compiles a list of menumanager items
*/
function showMenu( $option ) {
	global $database, $mainframe, $mosConfig_list_limit;

	## Main Query
	$query = 	"SELECT a.title, a.params, a.id"
	. "\n FROM #__modules AS a"
	. "\n WHERE a.module = 'mod_mainmenu'"
	. "\n ORDER BY a.title"
	;
	$database->setQuery( $query );
	$menus = $database->loadObjectList();
	$total = count( $menus );

	## Query to get menu item count and menutype
	$query = 	"SELECT a.menutype, count( a.menutype ) as num"
	. "\n FROM #__menu AS a"
	. "\n WHERE a.published != -2"
	. "\n GROUP BY a.menutype"
	. "\n ORDER BY a.menutype"
	;
	$database->setQuery( $query );
	$menutype = $database->loadObjectList();

	for( $i = 0; $i < $total; $i++ ) {
		$params = mosParseParams( $menus[$i]->params );
		// adds menutype to array
		$menus[$i]->type = trim( @$params->menutype );
		foreach ( $menutype as $temp ) {
			if ( $menus[$i]->type == $temp->menutype ) {
				// adds item count to array
				$menus[$i]->num = $temp->num;
			}
		}
		if ( @!$menus[$i]->num ) {
			$menus[$i]->num = 0;
		}
	}

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{". $option ."}limitstart", 'limitstart', 0 );
	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	HTML_menumanager::show( $option, $menus, $pageNav );
}


/**
* Edits a mod_mainmenu module
*
* @param option	options for the edit mode
* @param cid	menu id
*/
function editMenu( $option, $menuID ) {
	global $database;
	
	$row = new mosModule( $database );
	if( $menuID > 0 ) {
		$row->load( $menuID );
		$params = explode('=', $row->params);
		$row->menutype = $params[1];
	} else {
		// setting default values
		$row->id = null;
		$row->iscore = 0;
		$row->published = 0;
		$row->position = "left";
		$row->module = "mod_mainmenu";
		$row->menutype = null;
	}

	HTML_menumanager::edit( $row, $option );
}

/**
* Creates a new mod_mainmenu module, which makes the menu visible
* this is a workaround until a new dedicated table for menu management can be created
*/
function saveMenu( $option ) {
	global $database;
    global $adminLanguage;
	## create the new module
	$row = new mosModule( $database );
	$row->bind( $_POST );
	
	// change display
	$row->params = "menutype=". $row->params;

	$newMenu = false;
	if( !isset($row->id) || $row->id == '') {
		$newMenu = true;
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
	$row->updateOrder( "position='". $row->position ."'" );

	if ($newMenu) {
		## module assigned to show on All pages by default
		## ToDO: Changed to become a mambo db-object
		$query =	"INSERT INTO #__modules_menu VALUES"
		. "\n ( ". $row->id .", 0 )"
		;
		$database->setQuery( $query );
		if ( !$database->query() ) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$msg = $adminLanguage->A_COMP_MENU_CREATED ." (id=$row->id)";
	}
	else {
		$msg = $adminLanguage->A_COMP_MENU_UPDATED;
	}
	
	mosRedirect( "index2.php?option=com_menumanager&mosmsg=". $msg ."" );
}

/**
* Compiles a list of the items you have selected to permanently delte
*/
function deleteConfirm( $option, $cid ) {
	global $database;

	$cids = implode( ',', $cid );
	$query = "SELECT a.id, a.module, a.title, a.params FROM #__modules AS a WHERE a.id IN ( ". $cids ." )";
	$database->setQuery( $query );
	$module = $database->loadObjectList();

	$params = mosParseParams( $module[0]->params );
	// adds menutype to array
	$type = trim( @$params->menutype );

	// Content Items query
	$query = 	"SELECT a.name"
	. "\n FROM #__menu AS a"
	. "\n WHERE ( a.menutype IN ( '". $type ."' ) )"
	. "\n ORDER BY a.name"
	;
	$database->setQuery( $query );
	$items = $database->loadObjectList();

	HTML_menumanager::showDelete( $option, $cid, $type, $items, $module );
}

/**
* Deletes menu items(s) you have selected
*/
function deleteMenu( $option, $cid, $type ) {
	global $database, $adminLanguage;

	// delete menu
	$query = 	"DELETE FROM #__menu"
	. "\n WHERE ( menutype IN ( '". $type ."' ) )"
	;
	$database->setQuery( $query );
	if ( !$database->query() ) {
		echo "<script> alert('". $database->getErrorMsg() ."');</script>\n";
		exit;
	}

	// delete module
	$cids = implode( ',', $cid );

	$database->setQuery( "SELECT id, module, title, iscore FROM #__modules WHERE id IN (". $cids .")" );
	if (!($rows = $database->loadObjectList())) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
	}

	$err = array();
	$cid = array();
	foreach ($rows as $row) {

		if ($row->module == 'mod_mainmenu') {
			$cid[] = $row->id;
		} else {
			$err[] = $row->title;
		}
	}

	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$database->setQuery( "DELETE FROM #__modules WHERE id IN ( ". $cids ." )" );
		if ( !$database->query() ) {
			echo "<script> alert('". $database->getErrorMsg() ."'); window.history.go(-1); </script>\n";
			exit;
		}
		$database->setQuery( "DELETE FROM #__modules_menu WHERE moduleid IN ( ". $cids ." )" );
		if ( !$database->query() ) {
			echo "<script> alert('". $database->getErrorMsg() ."');</script>\n";
			exit;
		}
		$mod = new mosModule( $database );
		$mod->ordering = 0;
		$mod->updateOrder( "position='left'" );
		$mod->updateOrder( "position='right'" );
	}

	$msg = $adminLanguage->A_COMP_MENU_DETECTED;
	mosRedirect( "index2.php?option=com_menumanager&mosmsg=". $msg ."" );
}


/**
* Compiles a list of the items you have selected to Copy
*/
function copyConfirm( $option, $cid ) {
	global $database;

	$cids = implode( ',', $cid );
	$query = "SELECT a.id, a.module, a.title, a.params FROM #__modules AS a WHERE a.id IN ( ". $cids ." )";
	$database->setQuery( $query );
	$module = $database->loadObjectList();

	$params = mosParseParams( $module[0]->params );
	// adds menutype to array
	$type = trim( @$params->menutype );

	// Content Items query
	$query = 	"SELECT a.name, a.id"
	. "\n FROM #__menu AS a"
	. "\n WHERE ( a.menutype IN ( '". $type ."' ) )"
	. "\n ORDER BY a.name"
	;
	$database->setQuery( $query );
	$items = $database->loadObjectList();

	HTML_menumanager::showCopy( $option, $cid, $type, $items );
}


/**
* Copies a complete menu, all its items and creates a new module, using the name speified
*/
function copyMenu( $option, $cid, $menu_name, $type ) {
	global $database, $adminLanguage;

	$mids = mosGetParam( $_POST, 'mids', '' );
	// create the module copy
	foreach( $cid as $id ) {
		$row = new mosModule( $database );
		$row->load( $id );
		$row->title = $menu_name;
		$row->iscore = 0;
		$row->published = 0;
		$row->position = "left";
		$row->module = "mod_mainmenu";
		$row->params = "menutype=". $menu_name ."";

		if (!$row->check()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$row->checkin();
		$row->updateOrder( "position='". $row->position ."'" );
	}

	$total = count( $mids );
	$copy = new mosMenu( $database );
	$original = new mosMenu( $database );
	foreach( $mids as $mid ) {
		$original->load( $mid );
		$copy = $original;
		$copy->id = NULL;
		$copy->menutype = $menu_name;
		if ( !$copy->check() ) {
			echo "<script> alert('".$copy->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		if ( !$copy->store() ) {
			echo "<script> alert('".$copy->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
	}

	$msg = $adminLanguage->A_COMP_MENU_COPY_OF ." `". $type ."` ". $adminLanguage->A_COMP_MENU_CONSIST ." ". $total ." ". $adminLanguage->A_COMP_ITEMS;
	mosRedirect( "index2.php?option=com_menumanager&mosmsg=". $msg ."" );
}

/**
* Cancels an edit operation
* @param option	options for the operation
*/
function cancelMenu( $option ) {
	mosRedirect( 'index2.php?option=com_menumanager&task=view' );
}


?>