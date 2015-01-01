<?php
/**
* @version $Id: admin.menus.php,v 1.1 2004/10/04 15:38:46 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'admin_html' ) );

$type = mosGetParam( $_REQUEST, 'type', false );
$menutype = mosGetParam( $_REQUEST, 'menutype', 'mainmenu' );
$task = mosGetParam( $_REQUEST, 'task', "" );

$access = mosGetParam( $_POST, 'access', '' );
$utaccess	=mosGetParam( $_POST, 'utaccess', '' );
$ItemName	= mosGetParam( $_POST, 'ItemName', '' );

$cid = mosGetParam( $_POST, 'cid', array(0) );
if (!is_array( $cid )) {
	$cid = array(0);
}
$menu = mosGetParam( $_POST, 'menu', '' );

switch ($task) {

	case 'new':
		addMenuItem( $cid, $menutype, $option );
		break;

	case 'edit':
		$menu = new mosMenu( $database );
		if ($cid[0]) {
			$menu->load( $cid[0] );
		} else {
			$menu->type = $type;
		}

		if ($menu->type) {
			require( $mosConfig_absolute_path .'/administrator/components/com_menus/'. $menu->type .'/'. $menu->type .'.menu.php' );
		}
		break;

	case 'save':
		require( $mosConfig_absolute_path .'/administrator/components/com_menus/'. $type .'/'. $type .'.menu.php' );
		break;

	case 'publish':
	case 'unpublish':
		if ($msg = publishMenuSection( $cid, ($task == 'publish') )) {
			// proceed no further if the menu item can't be published
			mosRedirect( 'index2.php?option='. $option .'&menutype='. $menutype .'&mosmsg= '.$msg );
		} else {
			mosRedirect( 'index2.php?option='. $option .'&menutype='. $menutype );
		}
		break;

	case "remove":
		if ($msg = TrashMenusection( $cid )) {
			mosRedirect( 'index2.php?option='. $option .'&menutype='. $menutype .'&mosmsg= '.$msg );
		} else {
			mosRedirect( 'index2.php?option='. $option .'&menutype='. $menutype );
		}
		break;

	case 'cancel':
		cancelMenu( $option );
		break;

	case 'orderup':
		orderMenu( $cid[0], -1, $option );
		break;

	case 'orderdown':
		orderMenu( $cid[0], 1, $option );
		break;

	case 'accesspublic':
		accessMenu( $cid[0], 0, $option, $menutype );
		break;

	case 'accessregistered':
		accessMenu( $cid[0], 1, $option, $menutype );
		break;

	case 'accessspecial':
		accessMenu( $cid[0], 2, $option, $menutype );
		break;

	case 'movemenu':
		moveMenu( $option, $cid, $menutype );
		break;

	case 'movemenusave':
		moveMenuSave( $option, $cid, $menu, $menutype );
		break;

	case 'copymenu':
		copyMenu( $option, $cid, $menutype );
		break;

	case 'copymenusave':
		copyMenuSave( $option, $cid, $menu, $menutype );
		break;

	case 'cancelcopymenu':
	case 'cancelmovemenu':
		viewMenuItems( $menutype, $option );
	break;

	default:
		$type = trim( mosGetParam( $_REQUEST, 'type', null ) );
		if ($type) {
			// adding a new item - type selection form
			require( $mosConfig_absolute_path .'/administrator/components/com_menus/'. $type.php );
		} else {
			viewMenuItems( $menutype, $option );
		}
	break;
}

/**
* Shows a list of items for a menu
*/
function viewMenuItems( $menutype, $option ) {
	global $database, $mainframe, $mosConfig_list_limit;

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart$menutype", 'limitstart', 0 );
	$levellimit = $mainframe->getUserStateFromRequest( "view{$option}limit$menutype", 'levellimit', 10 );
	$search = $mainframe->getUserStateFromRequest( "search{$option}$menutype", 'search', '' );
	$search = $database->getEscaped( trim( strtolower( $search ) ) );

	// select the records
	// note, since this is a tree we have to do the limits code-side
	if ($search) {
		$query = "SELECT m.id"
		. "\n FROM #__menu AS m"
		//. "\nLEFT JOIN #__content AS c ON c.id = m.componentid AND type='content_typed'"
		. "\n WHERE menutype='$menutype'"
		. "\n AND LOWER(m.name) LIKE '%" . strtolower( $search ) . "%'"
		;
		$database->setQuery( $query );
		$search_rows = $database->loadResultArray();
	}

	$query = "SELECT m.*, u.name AS editor, g.name AS groupname, c.publish_up, c.publish_down, com.name AS com_name"
	. "\n FROM #__menu AS m"
	. "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
	. "\n LEFT JOIN #__groups AS g ON g.id = m.access"
	. "\n LEFT JOIN #__content AS c ON c.id = m.componentid AND m.type='content_typed'"
	. "\n LEFT JOIN #__components AS com ON com.id = m.componentid AND m.type='components'"
	//. "\n LEFT JOIN #__core_acl_aro_groups AS g ON g.group_id = m.access" <-- this is how it will be done
	. "\n WHERE m.menutype='$menutype'"
	. "\n AND m.published != -2"
	. "\n ORDER BY parent,ordering"
	;
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	// establish the hierarchy of the menu
	$children = array();
	// first pass - collect children
	foreach ($rows as $v ) {
		$pt = $v->parent;
		$list = @$children[$pt] ? $children[$pt] : array();
		array_push( $list, $v );
		$children[$pt] = $list;
	}
	// second pass - get an indent list of the items
	$list = mosTreeRecurse( 0, '', array(), $children, max( 0, $levellimit-1 ) );
	// eventually only pick out the searched items.
	if ($search) {
		$list1 = array();

		foreach ($search_rows as $sid ) {
			foreach ($list as $item) {
				if ($item->id == $sid) {
					$list1[] = $item;
				}
			}
		}
		// replace full list with found items
		$list = $list1;
	}

	$total = count( $list );

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	$levellist = mosHTML::integerSelectList( 1, 20, 1, 'levellimit', 'size="1" onchange="document.adminForm.submit();"', $levellimit );

	// slice out elements based on limits
	$list = array_slice( $list, $pageNav->limitstart, $pageNav->limit );

	$i = 0;
	foreach ( $list as $mitem ) {
		switch ( $mitem->type ) {
			case 'separator';
			case 'component_item_link';
				break;

			case 'content_item_link';
				$temp = split("&task=view&id=", $mitem->link);
				$mitem->link .= '&Itemid='. $mainframe->getItemid($temp[1]);
				break;

			case 'url':
				if ( eregi( 'index.php\?', $mitem->link ) ) {
					if ( !eregi( 'Itemid=', $mitem->link ) ) {
						$mitem->link .= '&Itemid='. $mitem->id;
					}
				}
				break;

			case 'content_typed';
			case 'content_item_link';
			default:
				$mitem->link .= '&Itemid='. $mitem->id;
				break;
		}
		$list[$i]->link = $mitem->link;
		$i++;
	}

	$i = 0;
	foreach ( $list as $row ) {
		$name = RenameMenu( $row->type, $row->com_name );
		$list[$i]->type = $name;
		$i++;
	}

	HTML_menusections::showMenusections( $list, $pageNav, $search, $levellist, $menutype, $option );
}

/**
* Displays a selection list for menu item types
*/
function addMenuItem( &$cid, $menutype, $option ) {
	global $database, $mosConfig_absolute_path;

	$types = array();

	$dirs = mosReadDirectory( $mosConfig_absolute_path .'/administrator/components/com_menus' );
	foreach ( $dirs as $dir ) {
		$dir = $mosConfig_absolute_path .'/administrator/components/com_menus/'. $dir;
		if ( is_dir( $dir ) ) {
			$files = mosReadDirectory( $dir, ".\.menu\.php$" );
			foreach ($files as $file) {
				require_once( "$dir/$file" );
			}
		}
	}

	// renames menu names
	$i = 0;
	foreach ( $types as $type ) {
		$text = RenameMenu( $type->value );	
		$types[$i]->text = $text;
		$i++;
	}

	// sort array of objects
	SortArrayObjects( $types, 'text', 1 );

	$lists['select'] = mosHTML::selectList( $types, 'type', 'class="inputbox" size="20"', 'value', 'text' );

	HTML_menusections::addMenuItem( $cid, $lists, $menutype, $option );
}


/**
* Generic function to save the menu
*/
function saveMenu( $option ) {
	global $database;

	$params = mosGetParam( $_POST, 'params', '' );
	if (is_array( $params )) {
	    $txt = array();
	    foreach ($params as $k=>$v) {
	        $txt[] = "$k=$v";
		}
		$_POST['params'] = implode( "\n", $txt );
	}

	$row = new mosMenu( $database );

	if (!$row->bind( $_POST )) {
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
	$row->updateOrder( "menutype='$row->menutype' AND parent='$row->parent'" );

	mosRedirect( 'index2.php?option='. $option .'&menutype='. $row->menutype );
}

/**
* Publishes or Unpublishes one or more menu sections
* @param database A database connector object
* @param string The name of the category section
* @param array An array of id numbers
* @param integer 0 if unpublishing, 1 if publishing
*/
function publishMenuSection( $cid=null, $publish=1 ) {
	global $database, $mosConfig_absolute_path;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		return 'Select an item to ' . ($publish ? 'publish' : 'unpublish');
	}

	$menu = new mosMenu( $database );
	foreach ($cid as $id) {
		$menu->load( $id );
		$menu->published = $publish;

		if (!$menu->check()) {
			return $menu->getError();
		}
		if (!$menu->store()) {
			return $menu->getError();
		}

		if ($menu->type) {
			$database = &$database;
			$task = $publish ? 'publish' : 'unpublish';
			require( "$mosConfig_absolute_path/administrator/components/com_menus/$menu->type/$menu->type.menu.php" );
		}
	}
	return null;
}

/**
* Trashes a menu record
*/
function TrashMenuSection( $cid=NULL ) {
	global $database, $adminLanguage;
	global $mosConfig_absolute_path;

	$state = "-2";
	//seperate contentids
	$cids = implode( ',', $cid );
	$query = 	"UPDATE #__menu SET published = '". $state ."', ordering = '0'"
	. "\n WHERE id IN ( ". $cids ." )"
	;
	$database->setQuery( $query );
	if ( !$database->query() ) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$total = count( $cid );
	$msg = $total ." ". $adminLanguage->A_COMP_TYPED_TRASHED;
	return $msg;
}

/**
* Cancels an edit operation
*/
function cancelMenu( $option ) {
	global $database;

	$menu = new mosMenu( $database );
	$menu->bind( $_POST );
	$menuid = mosGetParam( $_POST, 'menuid', 0 );
	if ( $menuid ) {
		$menu->id = $menuid;
	}
	$menu->checkin();

	if ( $menu->type == 'content_typed' ) {
		$contentid = mosGetParam( $_POST, 'id', 0 );
		$content = new mosContent( $database );		
		$content->load( $contentid );
		$content->checkin();
	}

	mosRedirect( 'index2.php?option='. $option .'&menutype='. $menu->menutype );
}

/**
* Moves the order of a record
* @param integer The increment to reorder by
*/
function orderMenu( $uid, $inc, $option ) {
	global $database;

	$row = new mosMenu( $database );
	$row->load( $uid );
	$row->move( $inc, 'menutype="'. $row->menutype .'" AND parent="'. $row->parent .'"' );

	mosRedirect( 'index2.php?option='. $option .'&menutype='. $row->menutype );
}


/**
* changes the access level of a record
* @param integer The increment to reorder by
*/
function accessMenu( $uid, $access, $option, $menutype ) {
	global $database;

	$menu = new mosMenu( $database );
	$menu->load( $uid );
	$menu->access = $access;

	if (!$menu->check()) {
		return $menu->getError();
	}
	if (!$menu->store()) {
		return $menu->getError();
	}

	mosRedirect( 'index2.php?option='. $option .'&menutype='. $menutype );
}

/**
* Form for moving item(s) to a specific menu
*/
function moveMenu( $option, $cid, $menutype ) {
	global $database, $adminLanguage;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('".$adminLanguage->A_COMP_CATEG_ITEM_MOVE."'); window.history.go(-1);</script>\n";
		exit;
	}

	## query to list selected menu items
	$cids = implode( ',', $cid );
	$query = "SELECT a.name FROM #__menu AS a WHERE a.id IN ( ". $cids ." )";
	$database->setQuery( $query );
	$items = $database->loadObjectList();
	
	## query to choose menu
	$query = "SELECT a.params FROM #__modules AS a WHERE a.module = 'mod_mainmenu' ORDER BY a.title";
	$database->setQuery( $query );
	$modules = $database->loadObjectList();
	
	foreach ( $modules as $module) {
		$params = mosParseParams( $module->params );
		// adds menutype to array
		$type = trim( @$params->menutype );
		$menu[] = mosHTML::makeOption( $type, $type );
	}
	// build the html select list
	$MenuList = mosHTML::selectList( $menu, 'menu', 'class="inputbox" size="10"', 'value', 'text', null );

	HTML_menusections::moveMenu( $option, $cid, $MenuList, $items, $menutype );
}

/**
* Save the item(s) to the menu selected
*/
function moveMenuSave( $option, $cid, $menu, $menutype ) {
	global $database, $my, $adminLanguage;

	$cids = implode( ',', $cid );
	$total = count( $cid );

	$query = 	"UPDATE #__menu"
	. "\n SET menutype = '". $menu ."', parent = '0', ordering = '9999'"
	. "\n WHERE id IN ( ". $cids ." )"
	;
	$database->setQuery( $query );
	if ( !$database->query() ) {
		echo "<script> alert('". $database->getErrorMsg() ."'); window.history.go(-1); </script>\n";
		exit();
	}

	// needed to reorder the menu items properly
	foreach( $cid as $id ) {
		$row = new mosMenu( $database );		
		$row->load( $id );
		$row->updateOrder( "menutype='". $row->menutype ."' AND parent='". $row->parent ."'" );
	}

	$msg = $total .$adminLanguage->A_COMP_MENUS_MOVED_TO. $menu;
	mosRedirect( 'index2.php?option='. $option .'&menutype='. $menutype .'&mosmsg='. $msg );
}

/**
* Form for copying item(s) to a specific menu
*/
function copyMenu( $option, $cid, $menutype ) {
	global $database, $adminLanguage;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('".$adminLanguage->A_COMP_CATEG_ITEM_MOVE."'); window.history.go(-1);</script>\n";
		exit;
	}

	## query to list selected menu items
	$cids = implode( ',', $cid );
	$query = "SELECT a.name FROM #__menu AS a WHERE a.id IN ( ". $cids ." )";
	$database->setQuery( $query );
	$items = $database->loadObjectList();
	
	## query to choose menu
	$query = "SELECT a.params  FROM #__modules AS a WHERE a.module = 'mod_mainmenu' ORDER BY a.title";
	$database->setQuery( $query );
	$modules = $database->loadObjectList();
	
	foreach ( $modules as $module) {
		$params = mosParseParams( $module->params );
		// adds menutype to array
		$type = trim( @$params->menutype );
		$menu[] = mosHTML::makeOption( $type, $type );
	}
	// build the html select list
	$MenuList = mosHTML::selectList( $menu, 'menu', 'class="inputbox" size="10"', 'value', 'text', null );

	HTML_menusections::copyMenu( $option, $cid, $MenuList, $items, $menutype );
}

/**
* Save the item(s) to the menu selected
*/
function copyMenuSave( $option, $cid, $menu, $menutype ) {
	global $database, $my;

	$total = count( $cid );
	
	$copy = new mosMenu( $database );
	$original = new mosMenu( $database );
	foreach( $cid as $id ) {
		$original->load( $id );
		$copy = $original;
		$copy->id = NULL;
		$copy->ordering = '9999';
		$copy->menutype = $menu;
		if ( !$copy->store() ) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$copy->updateOrder( "menutype='". $copy->menutype ."' AND parent='". $copy->parent ."'" );
	}

	$msg = $total .$adminLanguage->A_COMP_MENUS_COPIED_TO. $menu;
	mosRedirect( 'index2.php?option='. $option .'&menutype='. $menutype .'&mosmsg='. $msg );
}

function RenameMenu( &$type, $component=-1 ) {
	global $adminLanguage;
	
	switch ( $type ) {
		case 'wrapper';
			$name = $adminLanguage->A_COMP_MENUS_WRAPPER;
			break;

		case 'separator';
			$name = $adminLanguage->A_COMP_MENUS_SEPERATOR;
			break;

		case 'content_typed';
			$name = $adminLanguage->A_COMP_MENUS_LINK.$adminLanguage->A_COMP_MENUS_STATIC;
			break;

		case 'url';
			$name = $adminLanguage->A_COMP_MENUS_LINK.$adminLanguage->A_COMP_MENUS_URL;
			break;

		case 'content_item_link';
			$name = $adminLanguage->A_COMP_MENUS_LINK.$adminLanguage->A_COMP_MENUS_CONTENT_ITEM;
			break;

		case 'component_item_link';
			$name = $adminLanguage->A_COMP_MENUS_LINK.$adminLanguage->A_COMP_MENUS_COMP_ITEM;
			break;

		case 'contact_item_link';
			$name = $adminLanguage->A_COMP_MENUS_LINK.$adminLanguage->A_COMP_MENUS_CONT_ITEM;
			break;

		case 'newsfeed_link';
			$name = $adminLanguage->A_COMP_MENUS_LINK.$adminLanguage->A_COMP_MENUS_NEWSFEED;
			break;

		case 'components';
			if ( $component == -1 ) {
				$name = $adminLanguage->A_COMP_MENUS_COMP;
			} else {
				$name = $adminLanguage->A_COMP_MENUS_COMP .' - '. $component;
			}
			break;

		case 'content_section';
			$name = $adminLanguage->A_COMP_MENUS_LIST.$adminLanguage->A_COMP_MENUS_CONT_SEC;
			break;

		case 'content_category';
			$name = $adminLanguage->A_COMP_MENUS_TABLE.$adminLanguage->A_COMP_MENUS_CONT_CAT;
			break;

		case 'content_blog_section';
			$name = $adminLanguage->A_COMP_MENUS_BLOG.$adminLanguage->A_COMP_MENUS_CONT_SEC;
			break;

		case 'content_blog_category';
			$name = $adminLanguage->A_COMP_MENUS_BLOG.$adminLanguage->A_COMP_MENUS_CONT_CAT;
			break;

		case 'content_blog_category_multi';
			$name = $adminLanguage->A_COMP_MENUS_BLOG.$adminLanguage->A_COMP_MENUS_CONT_CAT_MULTI;
			break;

		case 'content_archive_section';
			$name = $adminLanguage->A_COMP_MENUS_BLOG.$adminLanguage->A_COMP_MENUS_CONT_SEC_ARCH;
			break;

		case 'content_archive_category';
			$name = $adminLanguage->A_COMP_MENUS_BLOG.$adminLanguage->A_COMP_MENUS_CONT_CAT_ARCH;
			break;

		case 'contact_category_table';
			$name = $adminLanguage->A_COMP_MENUS_TABLE.$adminLanguage->A_COMP_MENUS_CONTACT_CAT;
			break;

		case 'weblink_category_table';
			$name = $adminLanguage->A_COMP_MENUS_TABLE.$adminLanguage->A_COMP_MENUS_WEBLINK_CAT;
			break;

		case 'newsfeed_category_table';
			$name = $adminLanguage->A_COMP_MENUS_TABLE.$adminLanguage->A_COMP_MENUS_NEWS_CAT;
			break;

		default:
			$name = $type;
			break;
	}
	
	return $name;
}

?>
