<?php
/**
* @version $Id: admin.users.php,v 1.1 2004/10/03 03:19:24 mibi Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

if (!$acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_users' )) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'admin_html' ) );

$task = trim( mosGetParam( $_REQUEST, 'task', null ) );
$cid = mosGetParam( $_REQUEST, 'cid', array( 0 ) );
if (!is_array( $cid )) {
	$cid = array ( 0 );
}

switch ($task) {
	case 'new':
		editUser( 0, $option);
		break;

	case 'edit':
		editUser( intval( $cid[0] ), $option );
		break;

	case 'save':
		saveUser( $option );
		break;

	case 'remove':
		removeUsers( $cid, $option );
		break;

	case 'block':
		changeUserBlock( $cid, 1, $option );
		break;

	case 'unblock':
		changeUserBlock( $cid, 0, $option );
		break;

	case 'logout':
		logoutUser( $cid, $option );
		break;

	case 'cancel':
		cancelUser( $option );
		break;

	default:
		showUsers( $option );
		break;
}

function showUsers( $option ) {
	global $database, $mainframe, $my, $acl, $mosConfig_list_limit;

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
	$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
	$search = $database->getEscaped( trim( strtolower( $search ) ) );

	$where = array();
	if (isset( $search ) && $search!= "") {
		$where[] = "(a.username LIKE '%$search%' OR a.email LIKE '%$search%' OR a.name LIKE '%$search%')";
	}

	// exclude any child group id's for this user
	//$acl->_debug = true;
	$pgids = $acl->get_group_children( $my->gid, 'ARO', 'RECURSE' );

	if (is_array( $pgids ) && count( $pgids ) > 0) {
		$where[] = "(a.gid NOT IN (" . implode( ',', $pgids ) . "))";
	}

	$query = "SELECT COUNT(*)"
	. "\n FROM #__users AS a"
	. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	;
	$database->setQuery( $query );
	$total = $database->loadResult();

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	$query = "SELECT a.*, g.name AS groupname, s.userid AS loggedin"
	. "\n FROM #__users AS a"
	. "\n INNER JOIN #__core_acl_aro AS aro ON aro.value = a.id"	// map user to aro
	. "\n INNER JOIN #__core_acl_groups_aro_map AS gm ON gm.aro_id = aro.aro_id"	// map aro to group
	. "\n INNER JOIN #__core_acl_aro_groups AS g ON g.group_id = gm.group_id"
	. "\n LEFT JOIN #__session AS s ON s.userid = a.id"
	. (count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
	. "\n GROUP BY a.id"
	//. "\nORDER BY usertype"
	. "\n LIMIT $pageNav->limitstart, $pageNav->limit"
	;
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	HTML_users::showUsers( $rows, $pageNav, $search, $option );
}

function editUser( $uid='0', $option='users' ) {
	global $database, $my, $acl, $adminLanguage;

	$row = new mosUser( $database );
	// load the row from the db table
	$row->load( $uid );

	if ( $uid ) {
		$query = "SELECT * FROM #__contact_details WHERE user_id='". $row->id ."'";
		$database->setQuery( $query );
		$contact = $database->loadObjectList();
	} else {
		$contact = NULL;
	}

	$my_group = strtolower( $acl->get_group_name( $row->gid, 'ARO' ) );
	if ($my_group == 'super administrator') {
		$lists['gid'] = '<input type="hidden" name="gid" value="'. $my->gid .'" /><strong>'. $adminLanguage->A_COMP_USERS_SUPER_ADMIN .'</strong>';
	} else {
		// ensure user can't add group higher than themselves
		$my_groups = $acl->get_object_groups( 'users', $my->id, 'ARO' );
		if (is_array( $my_groups ) && count( $my_groups ) > 0) {
			$ex_groups = $acl->get_group_children( $my_groups[0], 'ARO', 'RECURSE' );
		} else {
			$ex_groups = array();
		}

		$gtree = $acl->get_group_children_tree( null, 'USERS', false );

		// remove users 'above' me
		$i = 0;
		while ($i < count( $gtree )) {
			if (in_array( $gtree[$i]->value, $ex_groups )) {
				array_splice( $gtree, $i, 1 );
			} else {
				$i++;
			}
		}

		$lists['gid'] 		= mosHTML::selectList( $gtree, 'gid', 'size="4"', 'value', 'text', $row->gid );
	}

	// build the html select list
	$lists['block'] 		= mosHTML::yesnoRadioList( 'block', 'class="inputbox" size="1"', $row->block );

	// build the html select list
	$lists['sendEmail'] 	= mosHTML::yesnoRadioList( 'sendEmail', 'class="inputbox" size="1"', $row->sendEmail );

	HTML_users::edituser( $row, $contact, $lists, $option, $uid );
}

function saveUser( $option ) {
	global $database, $my;
	global $mosConfig_live_site, $mosConfig_mailfrom, $mosConfig_fromname, $mosConfig_sitename;

	$row = new mosUser( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$isNew = !$row->id;
	$pwd = '';
	if ($isNew) {
		// new user stuff
		if ($row->password == '') {
			$pwd = mosMakePassword();
			$row->password = md5( $pwd );
		} else {
			$pwd = $row->password;
			$row->password = md5( $row->password );
		}
		$row->registerDate = date( 'Y-m-d H:i:s' );
	} else {
		// existing user stuff
		if ($row->password == '') {
			// password set to null if empty
			$row->password = null;
		} else {
			$row->password = md5( $row->password );
		}
	}

	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}
// update the ACL

	if ($isNew) {
	} else {
		$query = "SELECT aro_id FROM #__core_acl_aro WHERE value='$row->id'";
		$database->setQuery( $query );
		$aro_id = $database->loadResult();

		$query = "UPDATE #__core_acl_groups_aro_map"
		. "\n SET group_id = '$row->gid'"
		. "\n WHERE aro_id = '$aro_id'"
		;
		$database->setQuery( $query );
		$database->query() or die( $database->stderr() );
	}

	$row->checkin();
	if ($isNew) {
		$query = "SELECT email FROM #__users WHERE id=$my->id";
		$database->setQuery( $query );
		$adminEmail = $database->loadResult();

		$subject = _NEW_USER_MESSAGE_SUBJECT;
		$message = sprintf ( _NEW_USER_MESSAGE, $row->name, $mosConfig_sitename, $mosConfig_live_site, $row->username, $pwd );

		if ($mosConfig_mailfrom != "" && $mosConfig_fromname != "") {
			$adminName = $mosConfig_fromname;
			$adminEmail = $mosConfig_mailfrom;
		} else {
			$query = "SELECT name, email FROM #__users WHERE usertype='superadministrator'";
			$database->setQuery( $query );
			$rows = $database->loadObjectList();
			$row = $rows[0];
			$adminName = $row->name;
			$adminEmail = $row->email;
		}
		mosMail( $adminEmail, $adminName, $row->email, $subject, $message );
	}

	$limit = intval( mosGetParam( $_REQUEST, 'limit', 10 ) );
	$limitstart	= intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
	mosRedirect( 'index2.php?option='. $option );
}

/**
* Cancels an edit operation
* @param option component option to call
*/
function cancelUser( $option ) {
	mosRedirect( 'index2.php?option='. $option .'&task=view' );
}

function removeUsers( $cid, $option ) {
	global $database, $acl, $adminLanguage;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert(\"". $adminLanguage->A_COMP_CONTENT_SEL_DEL ."\"); window.history.go(-1);</script>\n";
		exit;
	}
	$msg = '';
	if (count( $cid )) {
		$obj = new mosUser( $database );
		foreach ($cid as $id) {
			// check for a super admin ... can't delete them
			$groups = $acl->get_object_groups( 'users', $id, 'ARO' );
			$this_group = strtolower( $acl->get_group_name( $groups[0], 'ARO' ) );
			if ($this_group == 'super administrator') {
				$msg .= $adminLanguage->A_COMP_USERS_CANNOT;
			} else {
				$obj->delete( $id );
				$msg .= $obj->getError();
			}
		}
	}

	$limit = intval( mosGetParam( $_REQUEST, 'limit', 10 ) );
	$limitstart	= intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
	mosRedirect( 'index2.php?option='. $option, $msg );
}

/**
* Blocks or Unblocks one or more user records
* @param array An array of unique category id numbers
* @param integer 0 if unblock, 1 if blocking
* @param string The current url option
*/
function changeUserBlock( $cid=null, $block=1, $option ) {
	global $database, $my, $adminLanguage;

	if (count( $cid ) < 1) {
		$action = $block ? 'block' : 'unblock';
		echo "<script> alert(\"". $adminLanguage->A_COMP_SEL_ITEM ." ". $action ."\"); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$query = "UPDATE #__users SET block='$block' WHERE id IN ($cids)";
	$database->setQuery( $query );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	mosRedirect( 'index2.php?option='. $option );
}

/**
* @param array An array of unique user id numbers
* @param string The current url option
*/
function logoutUser( $cid=null, $option ) {
	global $database, $my;

	if (count( $cid ) < 1) {
		mosRedirect( 'index2.php?option='. $option, 'Please select a user' );
	}

	$cids = implode( ',', $cid );

	$query = "DELETE FROM #__session WHERE userid IN ($cids)";
	$database->setQuery( $query );
	$database->query();

	mosRedirect( 'index2.php?option='. $option, $database->getErrorMsg() );
}

function is_email($email){
	$rBool=false;

	if(preg_match("/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/", $email)){
		$rBool=true;
	}
	return $rBool;
}
?>
