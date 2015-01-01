<?php
/**
* @version $Id: registration.php,v 1.19 2004/09/22 00:12:41 prazgod Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$task = mosGetParam( $_REQUEST, 'task', "" );
require_once( $mainframe->getPath( 'front_html' ) );

//print "<script> alert($mosConfig_live_site . '/components/com_user_extended/user_extended_content.html.php');</script>\n";
//include($mosConfig_live_site . '/components/com_user_extended/user_extended_content.html.php');


switch( $task ) {
  case "saveUpload":
  saveUpload( $mosConfig_dbprefix, $uid, $option, $userfile, $userfile_name, $type, $existingImage);
  break;

  case "UserDetails":
  userEdit( $option, $my->id, _UPDATE );
  break;

  case "saveUserEdit":
  userSave( $option, $my->id );
  break;

  case "UserView":
  UserView( $option, $my->id );
  break;

  case "CheckIn":
  CheckIn( $my->id, $access, $option );
  break;

  // standard options 4.5.1
  case "lostPassword":
  lostPassForm( $option );
  break;

  case "sendNewPass":
  sendNewPass( $option );
  break;

  case "register":
  registerForm( $option, $mosConfig_useractivation );
  break;

  case "saveRegistration":
  saveRegistration( $option );
  break;

  case "activate":
  activate( $option );
  break;
}


function lostPassForm( $option ) {
  global $mainframe;
  $mainframe->SetPageTitle(_PROMPT_PASSWORD);
  UserExtended_registration::lostPassForm($option);
}

function sendNewPass( $option ) {
  global $database, $Itemid;
  global $mosConfig_live_site, $mosConfig_sitename;

  $_live_site = $mosConfig_live_site;
  $_sitename = $mosConfig_sitename;

  // ensure no malicous sql gets past
  $checkusername = trim( mosGetParam( $_POST, 'checkusername', '') );
  $checkusername = $database->getEscaped( $checkusername );
  $confirmEmail = trim( mosGetParam( $_POST, 'confirmEmail', '') );
  $confirmEmail = $database->getEscaped( $confirmEmail );

  $database->setQuery( "SELECT id FROM #__users"
  . "\nWHERE username='$checkusername' AND email='$confirmEmail'"
  );

  if (!($user_id = $database->loadResult()) || !$checkusername || !$confirmEmail) {
    mosRedirect( "index.php?option=$option&task=lostPassword&mosmsg="._ERROR_PASS );
  }

  $database->setQuery( "SELECT name, email FROM #__users"
  . "\n WHERE usertype='superadministrator'" );
  $rows = $database->loadObjectList();
  foreach ($rows AS $row) {
    $adminName = $row->name;
    $adminEmail = $row->email;
  }

  $newpass = mosMakePassword();
  $message = _NEWPASS_MSG;
  eval ("\$message = \"$message\";");
  $subject = _NEWPASS_SUB;
  eval ("\$subject = \"$subject\";");

  mosMail($mosConfig_mailfrom, $mosConfig_fromname, $confirmEmail, $subject, $message);

  $newpass = md5( $newpass );
  $sql = "UPDATE #__users SET password='$newpass' WHERE id='$user_id'";
  $database->setQuery( $sql );
  if (!$database->query()) {
    die("SQL error" . $database->stderr(true));
  }

  mosRedirect( "index.php?Itemid=$Itemid&mosmsg="._NEWPASS_SENT );
}

function registerForm( $option, $useractivation ) {
  global $mainframe, $database, $my, $acl;

  if (!$mainframe->getCfg( 'allowUserRegistration' )) {
    mosNotAuth();
    return;
  }


  $mainframe->SetPageTitle(_REGISTER_TITLE);
  UserExtended_registration::registerForm($option, $useractivation);
}

function saveRegistration( $option ) {
  global $database, $my, $acl;
  global $mosConfig_sitename, $mosConfig_live_site, $mosConfig_useractivation, $mosConfig_allowUserRegistration;
  global $mosConfig_mailfrom, $mosConfig_fromname, $mosConfig_mailfrom, $mosConfig_fromname;

  if ($mosConfig_allowUserRegistration=="0") {
    mosNotAuth();
    return;
  }

  $row = new mosUser( $database );

  if (!$row->bind( $_POST, "usertype" )) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }

  mosMakeHtmlSafe($row);

  $row->id = 0;
  $row->usertype = '';
  $row->gid = $acl->get_group_id('Registered','ARO');

  if ($mosConfig_useractivation=="1") {
    $row->activation = md5( mosMakePassword() );
    $row->block = "1";
  }

  if (!$row->check()) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }

  $pwd = $row->password;
  $row->password = md5( $row->password );
  $row->registerDate = date("Y-m-d H:i:s");

  if (!$row->store()) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }

//// Begin UserExtended
  include ("administrator/components/com_user_extended/user_extended.class.php");
  $rowExtended = new mosUser_Extended($database);
  if (!$rowExtended->bind( $_POST )) {
    echo "<script> alert('".$rowExtended->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }
  if (!$rowExtended->check()) {
    echo "<script> alert('".$rowExtended->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }
  if (!$rowExtended->storeExtended($row->id)) {
    echo "<script> alert('".$rowExtended->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }
//// End UserExtended

  $row->checkin();

  $name = $row->name;
  $email = $row->email;
  $username = $row->username;

  $subject = sprintf (_SEND_SUB, $name, $mosConfig_sitename);
  $subject = html_entity_decode($subject, ENT_QUOTES);
  if ($mosConfig_useractivation=="1"){
    $message = sprintf (_USEND_MSG_ACTIVATE, $name, $mosConfig_sitename, $mosConfig_live_site."/index.php?option=com_registration&task=activate&activation=".$row->activation, $mosConfig_live_site, $username, $pwd);
  } else {
    $message = sprintf (_USEND_MSG, $name, $mosConfig_sitename, $mosConfig_live_site);
  }

  $message = html_entity_decode($message, ENT_QUOTES);
  // Send email to user
  if ($mosConfig_mailfrom != "" && $mosConfig_fromname != "") {
    $adminName2 = $mosConfig_fromname;
    $adminEmail2 = $mosConfig_mailfrom;
  } else {
    $database->setQuery( "SELECT name, email FROM #__users"
    ."\n WHERE usertype='superadministrator'" );
    $rows = $database->loadObjectList();
    $row2 = $rows[0];
    $adminName2 = $row2->name;
    $adminEmail2 = $row2->email;
  }

  mosMail($adminEmail2, $adminName2, $email, $subject, $message);

  // Send notification to all administrators
  $subject2 = sprintf (_SEND_SUB, $name, $mosConfig_sitename);
  $message2 = sprintf (_ASEND_MSG, $adminName2, $mosConfig_sitename, $row->name, $email, $username);
  $subject2 = html_entity_decode($subject2, ENT_QUOTES);
  $message2 = html_entity_decode($message2, ENT_QUOTES);

  // get superadministrators id
  $admins = $acl->get_group_objects( 25, 'ARO' );

  foreach ( $admins['users'] AS $id ) {
    $database->setQuery( "SELECT email, sendEmail FROM #__users"
      ."\n WHERE id='$id'" );
    $rows = $database->loadObjectList();

    $row = $rows[0];

    if ($row->sendEmail) {
      mosMail($adminEmail2, $adminName2, $row->email, $subject2, $message2);
    }
  }

  if ( $mosConfig_useractivation == "1" ){
    echo _REG_COMPLETE_ACTIVATE;
  } else {
    echo _REG_COMPLETE;
  }

}

function activate( $option ) {
  global $database;

  $activation = trim( mosGetParam( $_REQUEST, 'activation', '') );

  $database->setQuery( "SELECT id FROM #__users"
  ."\n WHERE activation='$activation' AND block='1'" );
  $result = $database->loadResult();

  if ($result) {
    $database->setQuery( "UPDATE #__users SET block='0', activation='' WHERE activation='$activation' AND block='1'" );
    if (!$database->query()) {
      echo "SQL error" . $database->stderr(true);
    }
    echo _REG_ACTIVATE_COMPLETE;
  } else {
    echo _REG_ACTIVATE_NOT_FOUND;
  }
}

function is_email($email){
  $rBool=false;

  if(preg_match("/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/", $email)){
    $rBool=true;
  }
  return $rBool;
}

############################################################################

function saveUpload($database, $_dbprefix, $uid, $option, $userfile, $userfile_name, $type, $existingImage) {
  global $database;

  if ($uid == 0) {
    mosNotAuth();
    return;
  }

  $base_Dir = "images/stories/";
  $checksize=filesize($userfile);
  if ($checksize > 50000) {
    echo "<script> alert(\""._UP_SIZE."\"); window.history.go(-1); </script>\n";
  } else {
    if (file_exists($base_Dir.$userfile_name)) {
      $message=_UP_EXISTS;
      eval ("\$message = \"$message\";");
      print "<script> alert('$message'); window.history.go(-1);</script>\n";
    } else {
      if ((!strcasecmp(substr($userfile_name,-4),".gif")) || (!strcasecmp(substr($userfile_name,-4),".jpg"))) {
        if (!move_uploaded_file($userfile, $base_Dir.$userfile_name))
        {
          echo _UP_COPY_FAIL." $userfile_name";
        } else {
          echo "<script>window.opener.focus;</script>";
          if ($type=="news") {
            $op="UserNews";
          } elseif ($type=="articles") {
            $op="UserArticle";
          }

          if ($existingImage!="") {
            if (file_exists($base_Dir.$existingImage)) {
              //delete the exisiting file
              unlink($base_Dir.$existingImage);
            }
          }
          echo "<script>window.opener.document.adminForm.ImageName.value='$userfile_name';</script>";
          echo "<script>window.opener.document.adminForm.ImageName2.value='$userfile_name';</script>";
          echo "<script>window.opener.document.adminForm.imagelib.src=null;</script>";
          echo "<script>window.opener.document.adminForm.imagelib.src='images/stories/$userfile_name';</script>";
          echo "<script>window.close(); </script>";
        }
      } else {
        echo "<script> alert(\""._UP_TYPE_WARN."\"); window.history.go(-1); </script>\n";
      }
    }
  }
}


function userEdit( $option, $uid, $submitvalue) {
  global $database;
  if ($uid == 0) {
    mosNotAuth();
    return;
  }
  $row = new mosUser( $database );
  $row->load( $uid );
  $row->orig_password = $row->password;
  //HTML_user::userEdit( $row, $option, $submitvalue );
  UserExtended_content::userEdit( $row, $option, $submitvalue );
}


function userSave( $option, $uid) {
  global $database;

  $user_id = intval( mosGetParam( $_POST, 'id', 0 ));

  // do some security checks
  if ($uid == 0 || $user_id == 0 || $user_id <> $uid) {
    mosNotAuth();
    return;
  }
  $row = new mosUser( $database );
  $row->load( $user_id );
  $row->orig_password = $row->password;

  if (!$row->bind( $_POST )) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }

  if(isset($_POST["password"]) && $_POST["password"] != "") {
    if(isset($_POST["verifyPass"]) && ($_POST["verifyPass"] == $_POST["password"])) {
      $row->password = md5($_POST["password"]);
    } else {
      echo "<script> alert(\""._PASS_MATCH."\"); window.history.go(-1); </script>\n";
      exit();
    }
  } else {
    // Restore 'original password'
    $row->password = $row->orig_password;
  }
  if (!$row->check()) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }

  unset($row->orig_password); // prevent DB error!!

  if (!$row->store()) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }

  //extended stuff....
  // save extended details
  include ("administrator/components/com_user_extended/user_extended.class.php");

  $rowExtended = new mosUser_Extended($database);

  if (!$rowExtended->bind( $_POST )) {
    echo "<script> alert('".$rowExtended->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }
  if (!$rowExtended->check()) {
    echo "<script> alert('".$rowExtended->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }

  if (!$rowExtended->storeExtended($user_id)) {
    echo "<script> alert('".$rowExtended->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }

  mosRedirect ("index.php?option=$option", _USER_DETAILS_SAVE);
}


function CheckIn( $userid, $access, $option ){
  global $database;
  global $mosConfig_db;

  if (!($access->canEdit || $access->canEditOwn || $userid > 0)) {
    mosNotAuth();
    return;
  }

  $lt = mysql_list_tables($mosConfig_db);
  $k = 0;
  while (list($tn) = mysql_fetch_array($lt)) {
    // only check in the mos_* tables
    if (strpos( $tn, $database->_table_prefix ) !== 0) {
      continue;
    }
    $lf = mysql_list_fields($mosConfig_db, "$tn");
    $nf = mysql_num_fields($lf);

    $checked_out = false;
    $editor = false;

    for ($i = 0; $i < $nf; $i++) {
      $fname = mysql_field_name($lf, $i);
      if ( $fname == "checked_out") {
        $checked_out = true;
      } else if ( $fname == "editor") {
        $editor = true;
      }
    }

    if ($checked_out) {
      if ($editor) {
        $database->setQuery( "SELECT checked_out, editor FROM $tn WHERE checked_out > 0 AND checked_out=$userid" );
      } else {
        $database->setQuery( "SELECT checked_out FROM $tn WHERE checked_out > 0 AND checked_out=$userid" );
      }
      $res = $database->query();
      $num = $database->getNumRows( $res );

      if ($editor) {
        $database->setQuery( "UPDATE $tn SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE checked_out > 0" );
      } else {
        $database->setQuery( "UPDATE $tn SET checked_out=0, checked_out_time='0000-00-00 00:00:00' WHERE checked_out > 0" );
      }
      $res = $database->query();

      if ($res == 1) {
        echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
        if ($num > 0) {
          echo "\n<tr class=\"row$k\">";
          echo "\n  <td width=\"250\">";
          echo _CHECK_TABLE;
          echo " - $tn</td>";
          echo "\n  <td>";
          echo _CHECKED_IN;
          echo "<b>$num</b>";
          echo _CHECKED_IN_ITEMS;
          echo "</td>";
          echo "\n</tr>";
        }
        $k = 1 - $k;
      }
    }
  }
  ?>
  <tr>
    <td colspan="2"><b><?php echo _CONF_CHECKED_IN; ?></b></td>
  </tr>
</table>
<?php
}


function UserView( $option, $uid ) {
  global $database;
  if ($uid == 0) {
    mosNotAuth();
    return;
  }
  $user_id = intval( mosGetParam( $_REQUEST, 'userid', 0 ));
  if ($user_id == 0) {
    $user_id = $uid;
  }
//  echo "<script>alert('$user_id');</script>";
  include_once ("administrator/components/com_user_extended/user_extended.class.php");
  $row = new mosUser_Extended($database);
  $row->load($user_id);

  $urow = new mosUser( $database );
  $urow->load($user_id);
  $u_name = $urow->name;
  $u_username = $urow->username;
  $u_email = $urow->email;

  UserExtended_content::UserView($option, $row, $u_name, $u_username, $u_email);
}

############################################################################
?>
