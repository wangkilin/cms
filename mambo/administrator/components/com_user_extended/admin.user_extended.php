<?php
// $Id: admin.user_extended.php,v 1.2 2004/09/27 21:43:13 bzechmann Exp $
/**
* @ Autor   : Bernhard Zechmann (MamboZ)
* @ Website : www.zechmann.com
* @ Download: www.mosforge.net/projects/userextended
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

if (!$acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_users' )) {
  mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );

$task = trim( mosGetParam( $_REQUEST, 'task', null ) );
$cid = mosGetParam( $_REQUEST, 'cid', array( 0 ) );
if (!is_array( $cid )) {
  $cid = array ( 0 );
}

switch ($act) {
    case "config":
    config( $database, $option );
    $task="null";
    break;
}

switch ($task) {

  case "null":
    // Do nothing
    break;
  case "new":
    editUser( 0, $option);
    break;

  case "edit":
    editUser( intval( $cid[0] ), $option );
    break;

  case "save":
    saveUser( $option );
    break;

  case "remove":
    removeUsers( $cid, $option );
    break;

  case "block":
    changeUserBlock( $cid, 1, $option );
    break;

  case "unblock":
    changeUserBlock( $cid, 0, $option );
    break;

  case "config":
    config( $database, $option );
    break;

  case "saveconfig":
    saveConfig($option, $database);
    break;

  case "about":
    showAbout();
    break;

  default:
    showUsers( $option );
    break;
}

//HTML_users::showCopyright();
UserExtended_users::showCopyright();

function showAbout() {
  # Show about screen to user
  //HTML_users::showAbout();
  UserExtended_users::showAbout();
}


function showUsers( $option ) {
  global $database, $mainframe, $my, $acl;

  $limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 );
  $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
  $search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
  $search = $database->getEscaped( trim( strtolower( $search ) ) );

  $where = array();
  if (isset( $search ) && $search!= "") {
    $where[] = "(username LIKE '%$search%' OR email LIKE '%$search%' OR a.name LIKE '%$search%')";
  }

  // exclude any child group id's for this user
  //$acl->_debug = true;
  $pgids = $acl->get_group_children( $my->gid, 'ARO', 'RECURSE' );

  if (is_array( $pgids ) && count( $pgids ) > 0) {
    $where[] = "(a.gid NOT IN (" . implode( ',', $pgids ) . "))";
  }

  $database->setQuery( "SELECT COUNT(*)"
    . "\nFROM #__users AS a"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
  );
  $total = $database->loadResult();
  echo $database->getErrorMsg();

  require_once("includes/pageNavigation.php");
  $pageNav = new mosPageNav( $total, $limitstart, $limit  );

  $database->setQuery( "SELECT a.*, g.name AS groupname"
    . "\nFROM #__users AS a"
    . "\nINNER JOIN #__core_acl_aro AS aro ON aro.value = a.id"  // map user to aro
    . "\nINNER JOIN #__core_acl_groups_aro_map AS gm ON gm.aro_id = aro.aro_id"  // map aro to group
    . "\nINNER JOIN #__core_acl_aro_groups AS g ON g.group_id = gm.group_id"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
    //. "\nGROUP BY usertype,username"
    //. "\nORDER BY usertype"
    . "\nLIMIT $pageNav->limitstart, $pageNav->limit"
  );

  $rows = $database->loadObjectList();
  if ($database->getErrorNum()) {
    echo $database->stderr();
    return false;
  }

  //HTML_users::showUsers( $rows, $pageNav, $search, $option );
  UserExtended_users::showUsers( $rows, $pageNav, $search, $option );
}

function editUser( $uid='0', $option='users' ) {
  global $database, $my, $acl;

  //$row = new mosUser( $database );
  //load the row from the db table
  //$row->load( $uid );

  if ($uid) {
  $sql="SELECT u.id as editid, u.*, c.* , e.* from #__users as u, #__user_extended_config as c";
  $sql .= " LEFT JOIN #__user_extended AS e ON u.id = e.id";
  $sql .= " WHERE u.id = '$uid'";
  $sql .= " AND c.id = '1'";
  } else {
  $sql="SELECT  c.* from #__user_extended_config as c WHERE c.id = '1'";
  }
  $database->SetQuery($sql);
  $rows = $database->LoadObjectList();
  if ($database->getErrorNum()) {
      echo $database->stderr();
      return false;
    }

  $row = $rows[0];


  $lists = array();

  $my_group = strtolower( $acl->get_group_name( $row->gid, 'ARO' ) );
  if ($my_group == 'super administrator') {
    $lists['gid'] = "<input type=\"hidden\" name=\"gid\" value=\"$my->gid\" /><strong>Super Administrator</strong>";
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

    $lists['gid'] = mosHTML::selectList( $gtree, 'gid', 'size="4"', 'value', 'text', $row->gid );
  }

// make the select list for yes/no fields
  $yesno[] = mosHTML::makeOption( '0', 'No' );
  $yesno[] = mosHTML::makeOption( '1', 'Yes' );

// build the html select list
  $lists['block'] = mosHTML::yesnoSelectList( 'block', 'class="inputbox" size="1"', $row->block );

// build the html select list
  $lists['sendEmail'] = mosHTML::yesnoSelectList( 'sendEmail', 'class="inputbox" size="1"', $row->sendEmail );

  //HTML_users::edituser( $row, $lists, $option, $uid );
  UserExtended_users::edituser( $row, $lists, $option, $uid );
}

function saveUser( $option ) {
  global $database, $my;
  global $mosConfig_live_site;

  $row = new mosUser( $database );
  if (!$row->bind( $_POST )) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }

  $isNew = !$row->id;
  $pwd = '';
  if ($isNew) {
    //extended user stuff
    $row->user_id = $row->id;
    // new user stuff
    if ($row->password == '') {
      $pwd = mosMakePassword();
      $row->password = md5( $pwd );
    } else {
      $pwd = $row->password;
      $row->password = md5( $row->password );
    }
  } else {
    // existing user stuff
    if ($row->password == '') {
      // password set to null if empty
      $row->password = null;
    } else {
      $row->password = md5( $row->password );
    }
  }
  $row->registerDate = date("Y-m-d H:i:s");
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
    $database->setQuery( "SELECT aro_id FROM #__core_acl_aro WHERE value='$row->id'" );
    $aro_id = $database->loadResult();

    $database->setQuery( "UPDATE #__core_acl_groups_aro_map"
      . "\nSET group_id = '$row->gid'"
      . "\nWHERE aro_id = '$aro_id'"
    );
    $database->query() or die( $database->stderr() );
  }

  $row->checkin();
  if ($isNew) {
    $database->setQuery( "SELECT email FROM #__users WHERE id=$my->id" );
    $adminEmail = $database->loadResult();

    $subject = "New User Details";
    $message = "Hello $row->name,\r \n \r \n";
    $message .= "You have been added as a user to $mosConfig_live_site by an Administrator.\r \n";
    $message .= "This email contains your username and password to log into the $mosConfig_live_site site:\r \n \r \n";
    $message .= "Username - $row->username\r \n";
    $message .= "Password - $pwd\r \n \r \n \r \n";
    $message .= "Please do not respond to this message as it is automatically generated and is for information purposes only\r \n";

    $headers .= "From: $adminEmail\r\n";
    $headers .= "Reply-To: $adminEmail\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-MSMail-Priority: Low\r\n";
    $headers .= "X-Mailer: Mambo Open Source 4.5\r\n";

    mail( $row->email, $subject, $message, $headers );
  }

  $limit = intval( mosGetParam( $_REQUEST, 'limit', 10 ) );
  $limitstart  = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );

  $row=null;



  $row = new mosUser_Extended( $database );

  if (!$row->bind( $_POST )) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }

  if (!$row->check()) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
    exit();
  }
  if (!$row->storeExtended(0)) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
    exit();
  }
 mosRedirect( "index2.php?option=$option" );
}

function removeUsers( $cid, $option ) {
  global $database, $acl;

  if (!is_array( $cid ) || count( $cid ) < 1) {
    echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
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
        $msg .= "You cannot delete a Super Administrator";
      } else {
        $obj->delete( $id );
        $msg .= $obj->getError();

        $obj2 = new mosUser_extended( $database );
        $obj2->delete( $id );
        $msg .= $obj2->getError();
      }
    }
  }

  $limit = intval( mosGetParam( $_REQUEST, 'limit', 10 ) );
  $limitstart  = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
  mosRedirect( "index2.php?option=$option", $msg );
}

/**
* Blocks or Unblocks one or more user records
* @param array An array of unique category id numbers
* @param integer 0 if unblock, 1 if blocking
* @param string The current url option
*/
function changeUserBlock( $cid=null, $block=1, $option ) {
  global $database, $my;

  if (count( $cid ) < 1) {
    $action = $block ? 'block' : 'unblock';
    echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
    exit;
  }

  $cids = implode( ',', $cid );

  $database->setQuery( "UPDATE #__users SET block='$block'"
  . "\nWHERE id IN ($cids)"
  );
  if (!$database->query()) {
    echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
    exit();
  }

  mosRedirect( "index2.php?option=$option" );
}

function is_email($email){
  $rBool=false;

  if(preg_match("/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/", $email)){
    $rBool=true;
  }
  return $rBool;
}

function config( $database, $option ) {

$row = new mosUser_Extended_Config($database);
$row->load('1');

//HTML_users_extended::Config($row,$option,$database);
UserExtended_users_extended::Config($row,$option,$database);
}

function saveConfig($option, $database) {
global $database, $my, $mainframe;

  $row = new mosUser_Extended_Config( $database );

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

  mosRedirect("index2.php?option=com_user_extended","Config Saved!");
}
?>