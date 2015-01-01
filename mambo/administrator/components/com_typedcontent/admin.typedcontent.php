<?php
/**
* @version $Id: admin.typedcontent.php,v 1.1 2004/10/03 02:39:55 mibi Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'admin_html' ) );

$id = mosGetParam( $_REQUEST, 'id', '' );
$cid = mosGetParam( $_POST, 'cid', array(0) );
if (!is_array( $cid )) {
	$cid = array(0);
}


switch ( $task ) {
	case "new":
		edit( 0, $option );
		break;

	case "edit":
		edit( $id, $option );
		break;

	case "editA":
		edit( $cid[0], $option );
		break;

	case "save":
		save( $option );
		break;

	case "remove":
		trash( $cid, $option );
		break;

	case "publish":
		changeState( $cid, 1, $option );
		break;

	case "unpublish":
		changeState( $cid, 0, $option );
		break;

	case "accesspublic":
		changeAccess( $cid[0], 0, $option );
		break;

	case "accessregistered":
		changeAccess( $cid[0], 1, $option );
		break;

	case "accessspecial":
		changeAccess( $cid[0], 2, $option );
		break;

	case "cancel":
		cancel( $option );
		break;

	case "resethits":
		resetHits( $option );
		break;

	case "menulink":
		menuLink( $option );
		break;

	default:
		view( $option );
		break;
}

/**
* Compiles a list of installed or defined modules
* @param database A database connector object
*/
function view( $option ) {
	global $database, $mainframe, $mosConfig_list_limit;

	$order = $mainframe->getUserStateFromRequest( "order", 'order', 'c.id DESC' );
	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
	//$limitstart = 0;
	$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
	$search = $database->getEscaped( trim( strtolower( $search ) ) );

	// used by filter
	if ( $search ) {
		$search_query = "\n AND ( LOWER( c.title ) LIKE '%$search%' OR LOWER( c.title_alias ) LIKE '%$search%' )";
	} else {
		$search_query = '';
	}

	// get the total number of records
	$query = "SELECT count(*)"
	. "\n FROM #__content AS c"
	. "\n WHERE c.sectionid = '0'"
	. "\n AND c.catid = '0'"
	. "\n AND c.state <> '-2'"
	;
	$database->setQuery( $query );
	$total = $database->loadResult();
	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit );

	$query = "SELECT c.*, g.name AS groupname, u.name AS editor, z.name AS creator"
	. "\n FROM #__content AS c"
	. "\n LEFT JOIN #__groups AS g ON g.id = c.access"
	. "\n LEFT JOIN #__users AS u ON u.id = c.checked_out"
	. "\n LEFT JOIN #__users AS z ON z.id = c.created_by"
	. "\n WHERE c.sectionid = '0'"
	. "\n AND c.catid = '0'"
	. "\n AND c.state <> '-2'"
	. $search_query
	. "\n ORDER BY ". $order
	. "\n LIMIT $pageNav->limitstart,$pageNav->limit"
	;
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	$count = count( $rows );
	for( $i = 0; $i < $count; $i++ ) {
		$query = "SELECT COUNT( id )"
		. "\n FROM #__menu"
		. "\n WHERE componentid = ". $rows[$i]->id
		. "\n AND type = 'content_typed'"
		;
		$database->setQuery( $query );
		$rows[$i]->links = $database->loadResult();
	}

	$ordering[] = mosHTML::makeOption( 'c.id ASC', 'ID asc' );		
	$ordering[] = mosHTML::makeOption( 'c.id DESC', 'ID desc' );		
	$ordering[] = mosHTML::makeOption( 'c.title ASC', 'Title asc' );		
	$ordering[] = mosHTML::makeOption( 'c.title DESC', 'Title desc' );		
	$ordering[] = mosHTML::makeOption( 'c.created ASC', 'Date asc' );		
	$ordering[] = mosHTML::makeOption( 'c.created DESC', 'Date desc' );		
	$ordering[] = mosHTML::makeOption( 'z.name ASC', 'Author asc' );		
	$ordering[] = mosHTML::makeOption( 'z.name DESC', 'Author desc' );		
	$ordering[] = mosHTML::makeOption( 'c.state ASC', 'Published asc' );		
	$ordering[] = mosHTML::makeOption( 'c.state DESC', 'Published desc' );		
	$ordering[] = mosHTML::makeOption( 'c.access ASC', 'Access asc' );		
	$ordering[] = mosHTML::makeOption( 'c.access DESC', 'Access desc' );		
	$javascript = 'onchange="document.adminForm.submit();"';
	$lists['order'] 		= mosHTML::selectList( $ordering, 'order', 'class="inputbox" size="1"'. $javascript, 'value', 'text', $order );

	HTML_typedcontent::showContent( $rows, $pageNav, $option, $search, $lists );
}

/**
* Compiles information to add or edit content
* @param database A database connector object
* @param string The name of the category section
* @param integer The unique id of the category to edit (0 if new)
*/
function edit( $uid, $option ) {
	global $database, $my, $acl, $mainframe, $adminLanguage;
	global $mosConfig_absolute_path, $mosConfig_live_site;

	$row = new mosContent( $database );

	// fail if checked out not by 'me'
	if ($row->checked_out && $row->checked_out <> $my->id) {
		echo "<script>alert(\"". $adminLanguage->A_COMP_CONTENT_MODULE ." ". $row->title ." ". $adminLanguage->A_COMP_ANOTHER_ADMIN ."\"); document.location.href='index2.php?option=$option'</script>\n";
		exit(0);
	}

	$lists = array();

	if ($uid) {
		// load the row from the db table
		$row->load( $uid );
		$row->checkout( $my->id );
		if (trim( $row->images )) {
			$row->images = explode( "\n", $row->images );
		} else {
			$row->images = array();
		}
		if (trim( $row->publish_down ) == "0000-00-00 00:00:00") {
			$row->publish_down = "Never";
		}

		$query = "SELECT name from #__users"
		. "\n WHERE id=$row->created_by"
		;
		$database->setQuery( $query );
		$row->creator = $database->loadResult();

		$query = "SELECT name from #__users"
		. "\n WHERE id=$row->modified_by"
		;
		$database->setQuery( $query );
		$row->modifier = $database->loadResult();

		// get list of links to this item
		$and = "\n AND componentid = ". $row->id;
		$menus = mosAdminMenus::Links2Menu( 'content_typed', $and );
	} else {
		// initialise values for a new item
		$row->version = 0;
		$row->state = 1;
		$row->images = array();
		$row->publish_up = date( "Y-m-d", time() );
		$row->publish_down = "Never";
		$row->sectionid = 0;
		$row->catid = 0;
		$row->creator = '';
		$row->modifier = '';
		$row->ordering = 0;
		$menus = array();
	}

	// calls function to read image from directory
	$pathA = $mosConfig_absolute_path .'/images/stories';
	$pathL = $mosConfig_live_site .'/images/stories';
	$images = array();
	$folders = array();
	$folders[] = mosHTML::makeOption( '/' );
	mosAdminMenus::ReadImages( $pathA, '/', $folders, $images );
	// list of folders in images/stories/
	$lists['folders'] 			= mosAdminMenus::GetImageFolders( $folders, $pathL );
	// list of images in specfic folder in images/stories/
	$lists['imagefiles']		= mosAdminMenus::GetImages( $images, $pathL );
	// list of saved images
	$lists['imagelist'] 		= mosAdminMenus::GetSavedImages( $row, $pathL );

	// build list of users
	$active = ( intval( $row->created_by ) ? intval( $row->created_by ) : $my->id );
	$lists['created_by'] 		= mosAdminMenus::UserSelect( 'created_by', $active );
	// build the select list for the image positions
	$lists['_align'] 			= mosAdminMenus::Positions( '_align' );
	// build the html select list for the group access
	$lists['access'] 			= mosAdminMenus::Access( $row );
	// build the html select list for menu selection
	$lists['menuselect']		= mosAdminMenus::MenuSelect( );

	// get params definitions
	$params =& new mosParameters( $row->attribs, $mainframe->getPath( 'com_xml', 'com_typedcontent' ), 'component' );

	HTML_typedcontent::edit( $row, $images, $lists, $my->id, $params, $option, $menus );
}

/**
* Saves the typed content item
*/
function save( $option ) {
	global $database, $my, $adminLanguage;

	$row = new mosContent( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$isNew = false;
	if ($row->id) {
		$row->modified = date( 'Y-m-d H:i:s' );
		$row->modified_by = $my->id;
	} else {
		$isNew = true;
		$row->created = date( 'Y-m-d H:i:s' );
		$row->created_by = $my->id;
	}
	if (trim( $row->publish_down ) == 'Never') {
		$row->publish_down = '0000-00-00 00:00:00';
	}

	// Save Parameters
	$params = mosGetParam( $_POST, 'params', '' );
	if (is_array( $params )) {
		$txt = array();
		foreach ( $params as $k=>$v) {
			$txt[] = "$k=$v";
		}
		$row->attribs = implode( "\n", $txt );
	}

	// code cleaner for xhtml transitional compliance
	$row->introtext = str_replace( '<br>', '<br />', $row->introtext );

	$row->state = mosGetParam( $_REQUEST, 'published', 0 );

	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();

	$msg = $adminLanguage->A_COMP_TYPED_SAVED;
	mosRedirect( 'index2.php?option='. $option .'&msg='. $msg );
}

/**
* Trashes the typed content item
*/
function trash( &$cid, $option ) {
	global $database, $mainframe, $adminLanguage;

	$total = count( $cid );
	if ( $total < 1) {
		echo "<script> alert(\"". $adminLanguage->A_COMP_CONTENT_SEL_DEL ."\"); window.history.go(-1);</script>\n";
		exit;
	}

	$state = '-2';
	$ordering = '0';
	//seperate contentids
	$cids = implode( ',', $cid );
	$query = 	"UPDATE #__content SET state = '". $state ."', ordering = '". $ordering ."'"
	. "\n WHERE id IN ( ". $cids ." )"
	;
	$database->setQuery( $query );
	if ( !$database->query() ) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$msg = $total ." ". $adminLanguage->A_COMP_TYPED_TRASHED;
	mosRedirect( 'index2.php?option='. $option, $msg );
}

/**
* Changes the state of one or more content pages
* @param string The name of the category section
* @param integer A unique category id (passed from an edit form)
* @param array An array of unique category id numbers
* @param integer 0 if unpublishing, 1 if publishing
* @param string The name of the current user
*/
function changeState( $cid=null, $state=0, $option ) {
	global $database, $my, $adminLanguage;

	if (count( $cid ) < 1) {
		$action = $publish == 1 ? $adminLanguage->A_PUBLISH : ($publish == -1 ? $adminLanguage->A_COMP_CONTENT_ARCHIVE : $adminLanguage->A_COMP_UNPUBLISHED );
		echo "<script> alert(\"". $adminLanguage->A_COMP_SEL_ITEM ." ". $action ."\"); window.history.go(-1);</script>\n";
		exit;
	}

	$total = count ( $cid );
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

	if ( $state == "1" ) {
		$msg = $total ." ". $adminLanguage->A_COMP_CONTENT_PUBLISHED;
	} else if ( $state == "0" ) {
		$msg = $total ." ". $adminLanguage->A_COMP_CONTENT_UNPUBLISHED;
	}
	mosRedirect( 'index2.php?option='. $option .'&msg='. $msg );
}

/**
* changes the access level of a record
* @param integer The increment to reorder by
*/
function changeAccess( $id, $access, $option  ) {
	global $database, $adminLanguage;

	$row = new mosContent( $database );
	$row->load( $id );
	$row->access = $access;

	if ( !$row->check() ) {
		return $row->getError();
	}
	if ( !$row->store() ) {
		return $row->getError();
	}

	mosRedirect( 'index2.php?option='. $option );
}


/**
* Function to reset Hit count of a content item
*/
function resethits( $option ) {
	global $database, $adminLanguage;
	$id = mosGetParam( $_REQUEST, 'id', NULL );

	$row = new mosContent($database);
	$row->Load($id);
	$row->hits = "0";
	$row->store();
	$row->checkin();

	$redirect = mosGetParam( $_POST, 'redirect', $sectionid );
	$msg = $adminLanguage->A_COMP_CONTENT_RESET_HIT_COUNT .": ". $row->title;

	mosRedirect( 'index2.php?option='. $option .'&msg='. $msg );
}

/**
* Cancels an edit operation
* @param database A database connector object
*/
function cancel( $option ) {
	global $database;

	$row = new mosContent( $database );
	$row->bind( $_POST );
	$row->checkin();
	mosRedirect( 'index2.php?option='. $option );
}

function menuLink( $option ) {
	global $database, $adminLanguage;

	$content = new mosContent( $database );
	$content->bind( $_POST );
	$content->checkin();

	$menu = mosGetParam( $_POST, 'menuselect', '' );
	$link = mosGetParam( $_POST, 'link_name', '' );
	$id = mosGetParam( $_POST, 'id', '' );

	$row 				= new mosMenu( $database );
	$row->menutype 		= $menu;
	$row->name 			= $link;
	$row->type 			= 'content_typed';
	$row->published		= 1;
	$row->componentid		= $id;
	$row->link			= 'index.php?option=com_content&task=view&id='. $id;
	$row->ordering			= 9999;

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

	$msg = $link ." ". $adminLanguage->A_COMP_CONTENT_IN_MENU  .": ". $menu ." ". $adminLanguage->A_COMP_CONTENT_SUCCESS;
	mosRedirect( 'index2.php?option='. $option,  $msg );

}

?>
