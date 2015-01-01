<?php
/**
* @version $Id: registration.html.php,v 1.18 2004/09/23 06:52:31 bzechmann Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// language detection
#if (file_exists($mosConfig_live_site . '/components/com_user_extended/detect_language.php')){
#  include($mosConfig_live_site . '/components/com_user_extended/detect_language.php');
#}
// get language files
if (file_exists('components/com_user_extended/language/' . $mosConfig_lang . '.php')){
  include_once('components/com_user_extended/language/' . $mosConfig_lang . '.php');
} else {
  include_once('components/com_user_extended/language/english.php');
}


/**
* @package Mambo_4.5.1
*/
class UserExtended_registration {

function lostPassForm($option) {
  ?>
  <div class="componentheading">
    <?php echo _PROMPT_PASSWORD; ?>
  </div>
  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
  <form action="index.php" method="post">
    <tr>
      <td colspan="2"><?php echo _NEW_PASS_DESC; ?></td>
    </tr>
    <tr>
      <td><?php echo _PROMPT_UNAME; ?></td>
      <td><input type="text" name="checkusername" class="inputbox" size="40" maxlength="25" /></td>
    </tr>
    <tr>
      <td><?php echo _PROMPT_EMAIL; ?></td>
      <td><input type="text" name="confirmEmail" class="inputbox" size="40" /></td>
    </tr>
    <tr>
      <td colspan="2"> <input type="hidden" name="option" value="<?php echo $option;?>" />
        <input type="hidden" name="task" value="sendNewPass" /> <input type="submit" class="button" value="<?php echo _BUTTON_SEND_PASS; ?>" /></td>
    </tr>
  </form>
  </table>
  <?php
  }


function registerForm($option, $useractivation) {
  ?>
  <script language="javascript" type="text/javascript">
    function submitbutton() {
      var form = document.mosForm;
      var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

      // do field validation
      if (form.name.value == "") {
        alert( "<?php echo html_entity_decode(_REGWARN_NAME);?>" );
      } else if (form.username.value == "") {
        alert( "<?php echo html_entity_decode(_REGWARN_UNAME);?>" );
      } else if (r.exec(form.username.value) || form.username.value.length < 3) {
        alert( "<?php printf( html_entity_decode(_VALID_AZ09), html_entity_decode(_PROMPT_UNAME), 2 );?>" );
      } else if (form.email.value == "") {
        alert( "<?php echo html_entity_decode(_REGWARN_MAIL);?>" );
      } else if (form.password.value.length < 6) {
        alert( "<?php echo html_entity_decode(_REGWARN_PASS);?>" );
      } else if (form.password2.value == "") {
        alert( "<?php echo html_entity_decode(_REGWARN_VPASS1);?>" );
      } else if ((form.password.value != "") && (form.password.value != form.password2.value)){
        alert( "<?php echo html_entity_decode(_REGWARN_VPASS2);?>" );
      } else if (r.exec(form.password.value)) {
        alert( "<?php printf( html_entity_decode(_VALID_AZ09), html_entity_decode(_REGISTER_PASS), 6 );?>" );

      <?php
      // form validation for required fields
      global $database, $mainframe;
      $sql="select * from #__user_extended_config WHERE id='1'";
      $database->SetQuery($sql);
      $rows22 = $database->LoadObjectList();
      $row11 = $rows22[0];
      // field validation
      if ($row11->user1_must && $row11->user1_show) {
      ?>
        } else if (form.user1.value == "") {
          alert( "<?php echo $row11->user1_name.' '._UEXT_ISREQUIRED; ?>." );
      <?php }
      if ($row11->user2_must && $row11->user2_show) {
      ?>
        } else if (form.user2.value == "") {
          alert( "<?php echo $row11->user2_name.' '._UEXT_ISREQUIRED; ?>." );
      <?php }
      if ($row11->user3_must && $row11->user3_show) {
      ?>
        } else if (form.user3.value == "") {
          alert( "<?php echo $row11->user3_name.' '._UEXT_ISREQUIRED; ?>." );
      <?php }
      if ($row11->user4_must && $row11->user4_show) {
      ?>
        } else if (form.user4.value == "") {
          alert( "<?php echo $row11->user4_name.' '._UEXT_ISREQUIRED; ?>." );
      <?php }
      if ($row11->user5_must && $row11->user5_show) {
      ?>
        } else if (form.user5.value == "") {
          alert( "<?php echo $row11->user5_name.' '._UEXT_ISREQUIRED; ?>." );
      <?php }
      if ($row11->user6_must && $row11->user6_show) {
      ?>
        } else if (form.user6.value == "") {
          alert( "<?php echo $row11->user6_name.' '._UEXT_ISREQUIRED; ?>." );
      <?php }
      if ($row11->user7_must && $row11->user7_show) {
      ?>
        } else if (form.user7.value == "") {
          alert( "<?php echo $row11->user7_name.' '._UEXT_ISREQUIRED; ?>." );
      <?php }
      if ($row11->user8_must && $row11->user8_show) {
      ?>
        } else if (form.user8.value == "") {
          alert( "<?php echo $row11->user8_name.' '._UEXT_ISREQUIRED; ?>." );
      <?php }
      if ($row11->user9_must && $row11->user9_show) {
      ?>
        } else if (form.user9.value == "") {
          alert( "<?php echo $row11->user9_name.' '._UEXT_ISREQUIRED; ?>." );
      <?php }
      if ($row11->user10_must && $row11->user10_show) {
      ?>
        } else if (form.user10.value == "") {
          alert( "<?php echo $row11->user10_name.' '._UEXT_ISREQUIRED; ?>." );
      <?php }
      if ($row11->user11_must && $row11->user11_show) {
      ?>
        } else if (form.user11.value == "") {
          alert( "<?php echo $row11->user11_name.' '._UEXT_ISREQUIRED; ?>." );
      <?php }
      if ($row11->user12_must && $row11->user12_show) {
      ?>
        } else if (form.user12.value == "") {
          alert( "<?php echo $row11->user12_name.' '._UEXT_ISREQUIRED; ?>." );
      <?php }
      if ($row11->user13_must && $row11->user13_show) {
      ?>
        } else if (form.user13.value == "") {
          alert( "<?php echo $row11->user13_name.' '._UEXT_ISREQUIRED; ?>." );
      <?php }
      if ($row11->user14_must && $row11->user14_show) {
      ?>
        } else if (form.user14.value == "") {
          alert( "<?php echo $row11->user14_name.' '._UEXT_ISREQUIRED; ?>." );
      <?php }
      if ($row11->user15_must && $row11->user15_show) {
      ?>
        } else if (form.user15.value == "") {
          alert( "<?php echo $row11->user15_name.' '._UEXT_ISREQUIRED; ?>." );
      <?php }
      // end custom form validation
      ?>

      } else {
        form.submit();
      }
    }
  </script>

  <div class="componentheading">
    <?php echo _REGISTER_TITLE; ?>
  </div>
  <form action="index.php" method="post" name="mosForm">
  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
    <tr>
      <td colspan="2"><?php echo _REGISTER_REQUIRED; ?></td>
    </tr>
    <tr>
      <td width="30%"><?php echo _REGISTER_NAME; ?> *</td>
      <td><input type="text" name="name" size="40" value="" class="inputbox" /></td>
    </tr>
    <tr>
      <td><?php echo _REGISTER_UNAME; ?> *</td>
      <td><input type="text" name="username" size="40" value="" class="inputbox" /></td>
    <tr>
      <td><?php echo _REGISTER_EMAIL; ?> *</td>
      <td><input type="text" name="email" size="40" value="" class="inputbox" /></td>
    </tr>
    <tr>
      <td><?php echo _REGISTER_PASS; ?> *</td>
      <td><input class="inputbox" type="password" name="password" size="40" value="" /></td>
    </tr>
    <tr>
      <td><?php echo _REGISTER_VPASS; ?> *</td>
      <td><input class="inputbox" type="password" name="password2" size="40" value="" /></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan=2>
      </td>
    </tr>

    <!-- user_extended -->
    <tr>
      <td colspan="2" class="componentheading"><?php echo _UEXT_DETAILS?></td>
    </tr>
    <?php
    //Extended User details form.
    global $database;
    include_once ("administrator/components/com_user_extended/user_extended.class.php");
    $rowExtended = new mosUser_Extended_Config ($database);
    $rowExtended->load('1');
    ?>
    <?php if ($rowExtended->user1_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user1_name; ?> </td>
       <td><input name="user1" type="text" class="inputbox" size="<?php echo $rowExtended->user1_size; ?>" maxlength="<?php echo $rowExtended->user1_size;?>" value="">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user1_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user2_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user2_name; ?></td>
       <td><input name="user2" type="text" class="inputbox" size="<?php echo $rowExtended->user2_size;?>" maxlength="<?php echo $rowExtended->user2_size;?>" value="">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user2_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user3_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user3_name; ?></td>
       <td><input name="user3" type="text" class="inputbox" size="<?php echo $rowExtended->user3_size;?>" maxlength="<?php echo $rowExtended->user3_size;?>" value="">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user3_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user4_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user4_name; ?> </td>
       <td><input name="user4" type="text" class="inputbox" size="<?php echo $rowExtended->user4_size;?>" maxlength="<?php echo $rowExtended->user4_size;?>" value="">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user4_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user5_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user5_name; ?> </td>
       <td><input name="user5" type="text" class="inputbox" size="<?php echo $rowExtended->user5_size;?>" maxlength="<?php echo $rowExtended->user5_size;?>" value="">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user5_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user6_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user6_name; ?> </td>
       <td><input name="user6" type="text" class="inputbox" size="<?php echo $rowExtended->user6_size;?>" maxlength="<?php echo $rowExtended->user6_size;?>" value="">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user6_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user7_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user7_name; ?> </td>
       <td><input name="user7" type="text" class="inputbox" size="<?php echo $rowExtended->user7_size;?>" maxlength="<?php echo $rowExtended->user7_size;?>" value="">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user7_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user8_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user8_name; ?> </td>
       <td><input name="user8" type="text" class="inputbox" size="<?php echo $rowExtended->user8_size;?>" maxlength="<?php echo $rowExtended->user8_size;?>" value="">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user8_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user9_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user9_name; ?> </td>
       <td><input name="user9" type="text" class="inputbox" size="<?php echo $rowExtended->user9_size;?>" maxlength="<?php echo $rowExtended->user9_size;?>" value="">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user9_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user10_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user10_name; ?> </td>
       <td><input name="user10" type="text" class="inputbox" size="<?php echo $rowExtended->user10_size;?>" maxlength="<?php echo $rowExtended->user10_size;?>" value="">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user10_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user11_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user11_name; ?> </td>
       <td><input name="user11" type="text" class="inputbox" size="<?php echo $rowExtended->user11_size;?>" maxlength="<?php echo $rowExtended->user11_size;?>" value="">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user11_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user12_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user12_name; ?> </td>
       <td><input name="user12" type="text" class="inputbox" size="<?php echo $rowExtended->user12_size;?>" maxlength="<?php echo $rowExtended->user12_size;?>" value="">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user12_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user13_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user13_name; ?> </td>
       <td><input name="user13" type="text" class="inputbox" size="<?php echo $rowExtended->user13_size;?>" maxlength="<?php echo $rowExtended->user13_size;?>" value="">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user13_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user14_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user14_name; ?> </td>
       <td><input name="user14" type="text" class="inputbox" size="<?php echo $rowExtended->user14_size;?>" maxlength="<?php echo $rowExtended->user14_size;?>" value="">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user14_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user15_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user15_name; ?> </td>
       <td><input name="user15" type="text" class="inputbox" size="<?php echo $rowExtended->user15_size;?>" maxlength="<?php echo $rowExtended->user15_size;?>" value="">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user15_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?>
    <!-- user_extended -->

  </table>
  <input type="hidden" name="id" value="0" />
  <input type="hidden" name="gid" value="0" />
  <input type="hidden" name="useractivation" value="<?php echo $useractivation;?>" />
  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="task" value="saveRegistration" />
  <input type="button" value="<?php echo _BUTTON_SEND_REG; ?>" class="button" onclick="submitbutton()" />
  </form>
  <?php
  }
}

############################################################################
############################################################################

class UserExtended_content {

function frontpage() {
  ?>
  <table cellpadding="5" cellspacing="0" border="0" width="100%">
  <!--
    <tr>
      <td class="contentheading"><?php echo _WELCOME; ?></td>
    </tr>
    <tr>
      <td><?php echo _WELCOME_DESC; ?></td>
    </tr>
  -->
  </table>
  <?php
  }


function userEdit($row, $option,$submitvalue) {
  ?>
  <script language="javascript" type="text/javascript">
  function submitbutton() {
    var form = document.EditUser;
    var r = new RegExp("[^0-9A-Za-z]", "i");

    if (form.name.value == "") {
      alert( "<?php echo _REGWARN_NAME;?>" );

    <?php
    // form validation for required fields
    global $database, $mainframe;
    $sql="select * from #__user_extended_config WHERE id='1'";
    $database->SetQuery($sql);
    $rows22 = $database->LoadObjectList();
    $row11 = $rows22[0];
    // field validation
    if ($row11->user1_must && $row11->user1_show) {
    ?>
      } else if (form.user1.value == "") {
        alert( "<?php echo $row11->user1_name.' '._UEXT_ISREQUIRED; ?>." );
    <?php }
    if ($row11->user2_must && $row11->user2_show) {
    ?>
      } else if (form.user2.value == "") {
        alert( "<?php echo $row11->user2_name.' '._UEXT_ISREQUIRED; ?>." );
    <?php }
    if ($row11->user3_must && $row11->user3_show) {
    ?>
      } else if (form.user3.value == "") {
        alert( "<?php echo $row11->user3_name.' '._UEXT_ISREQUIRED; ?>." );
    <?php }
    if ($row11->user4_must && $row11->user4_show) {
    ?>
      } else if (form.user4.value == "") {
        alert( "<?php echo $row11->user4_name.' '._UEXT_ISREQUIRED; ?>." );
    <?php }
    if ($row11->user5_must && $row11->user5_show) {
    ?>
      } else if (form.user5.value == "") {
        alert( "<?php echo $row11->user5_name.' '._UEXT_ISREQUIRED; ?>." );
    <?php }
    if ($row11->user6_must && $row11->user6_show) {
    ?>
      } else if (form.user6.value == "") {
        alert( "<?php echo $row11->user6_name.' '._UEXT_ISREQUIRED; ?>." );
    <?php }
    if ($row11->user7_must && $row11->user7_show) {
    ?>
      } else if (form.user7.value == "") {
        alert( "<?php echo $row11->user7_name.' '._UEXT_ISREQUIRED; ?>." );
    <?php }
    if ($row11->user8_must && $row11->user8_show) {
    ?>
      } else if (form.user8.value == "") {
        alert( "<?php echo $row11->user8_name.' '._UEXT_ISREQUIRED; ?>." );
    <?php }
    if ($row11->user9_must && $row11->user9_show) {
    ?>
      } else if (form.user9.value == "") {
        alert( "<?php echo $row11->user9_name.' '._UEXT_ISREQUIRED; ?>." );
    <?php }
    if ($row11->user10_must && $row11->user10_show) {
    ?>
      } else if (form.user10.value == "") {
        alert( "<?php echo $row11->user10_name.' '._UEXT_ISREQUIRED; ?>." );
    <?php }
    if ($row11->user11_must && $row11->user11_show) {
    ?>
      } else if (form.user11.value == "") {
        alert( "<?php echo $row11->user11_name.' '._UEXT_ISREQUIRED; ?>." );
    <?php }
    if ($row11->user12_must && $row11->user12_show) {
    ?>
      } else if (form.user12.value == "") {
        alert( "<?php echo $row11->user12_name.' '._UEXT_ISREQUIRED; ?>." );
    <?php }
    if ($row11->user13_must && $row11->user13_show) {
    ?>
      } else if (form.user13.value == "") {
        alert( "<?php echo $row11->user13_name.' '._UEXT_ISREQUIRED; ?>." );
    <?php }
    if ($row11->user14_must && $row11->user14_show) {
    ?>
      } else if (form.user14.value == "") {
        alert( "<?php echo $row11->user14_name.' '._UEXT_ISREQUIRED; ?>." );
    <?php }
    if ($row11->user15_must && $row11->user15_show) {
    ?>
      } else if (form.user15.value == "") {
        alert( "<?php echo $row11->user15_name.' '._UEXT_ISREQUIRED; ?>." );
    <?php }
    ?>
    } else {
      form.submit();
    }
  }
  </script>

  <form action="index.php" method="post" name="EditUser">
  <table cellpadding="5" cellspacing="0" border="0" width="100%">
    <tr>
      <td class="componentheading" colspan="5"><?php echo _EDIT_TITLE; ?></td>
    </tr>
    <tr>
      <td width=85><?php echo _YOUR_NAME; ?></td>
      <td><input class="inputbox" type="text" name="name" value="<?php echo $row->name;?>" /></td>
    </tr>
    <tr>
      <td><?php echo _EMAIL; ?></td>
      <td><input class="inputbox" type="text" name="email" value="<?php echo $row->email;?>" size="30" /></td>
    <tr>
      <td><?php echo _UNAME; ?></td>
      <td><input class="inputbox" type="text" name="username" value="<?php echo $row->username;?>" /></td>
    </tr>
    <tr>
      <td><?php echo _PASS; ?></td>
      <td><input class="inputbox" type="password" name="password" value="" /></td>
    </tr>
    <tr>
      <td><?php echo _VPASS; ?></td>
      <td><input class="inputbox" type="password" name="verifyPass" /></td>
    </tr>
    <tr>
      <td colspan="2" class="componentheading"><?php echo _UEXT_DETAILS?></td>
    </tr>

    <?php
    //Extended User details form.
    global $database;
    global $mosConfig_lang, $mosConfig_mbf_content; // neu mambelfish
    include_once ("administrator/components/com_user_extended/user_extended.class.php");
    $rowExtended = new mosUser_Extended_Config ($database);
    $rowExtended->load('1');

    $rowExUser = new mosUser_Extended($database);
    $rowExUser->load($row->id);

    ?>
    <?php if ($rowExtended->user1_show=="1") { ?>
    <tr>
       <td>
       <?php
       echo $rowExtended->user1_name; // original
       /*
       $rowExtended->user1_name;
       // $category->load( $id ); // muster
       $rowExtended = MambelFish::translate( $rowExtended, 'categories', $mosConfig_lang);
       echo $rowExtended.' testmic';
       */
       ?> </td>
       <td><input name="user1" type="text" class="inputbox" size="<?php echo $rowExtended->user1_size; ?>" maxlength="<?php echo $rowExtended->user1_size; ?>" value="<?php echo $rowExUser->user1;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user1_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user2_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user2_name; ?></td>
       <td><input name="user2" type="text" class="inputbox" size="<?php echo $rowExtended->user2_size; ?>" maxlength="<?php echo $rowExtended->user2_size; ?>" value="<?php echo $rowExUser->user2;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user2_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user3_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user3_name; ?></td>
       <td><input name="user3" type="text" class="inputbox" size="<?php echo $rowExtended->user3_size; ?>" maxlength="<?php echo $rowExtended->user3_size; ?>" value="<?php echo $rowExUser->user3;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user3_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user4_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user4_name; ?> </td>
       <td><input name="user4" type="text" class="inputbox" size="<?php echo $rowExtended->user4_size; ?>" maxlength="<?php echo $rowExtended->user4_size; ?>" value="<?php echo $rowExUser->user4;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user4_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user5_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user5_name; ?> </td>
       <td><input name="user5" type="text" class="inputbox" size="<?php echo $rowExtended->user5_size;?>" maxlength="<?php echo $rowExtended->user5_size;?>" value="<?php echo $rowExUser->user5;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user5_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user6_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user6_name; ?> </td>
       <td><input name="user6" type="text" class="inputbox" size="<?php echo $rowExtended->user6_size;?>" maxlength="<?php echo $rowExtended->user6_size;?>" value="<?php echo $rowExUser->user6;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user6_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user7_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user7_name; ?> </td>
       <td><input name="user7" type="text" class="inputbox" size="<?php echo $rowExtended->user7_size;?>" maxlength="<?php echo $rowExtended->user7_size;?>" value="<?php echo $rowExUser->user7;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user7_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user8_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user8_name; ?> </td>
       <td><input name="user8" type="text" class="inputbox" size="<?php echo $rowExtended->user8_size;?>" maxlength="<?php echo $rowExtended->user8_size;?>" value="<?php echo $rowExUser->user8;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user8_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user9_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user9_name; ?> </td>
       <td><input name="user9" type="text" class="inputbox" size="<?php echo $rowExtended->user9_size;?>" maxlength="<?php echo $rowExtended->user9_size;?>" value="<?php echo $rowExUser->user9;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user9_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user10_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user10_name; ?> </td>
       <td><input name="user10" type="text" class="inputbox" size="<?php echo $rowExtended->user10_size;?>" maxlength="<?php echo $rowExtended->user10_size;?>" value="<?php echo $rowExUser->user10;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user10_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?>

    <?php if ($rowExtended->user11_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user11_name; ?> </td>
       <td><input name="user11" type="text" class="inputbox" size="<?php echo $rowExtended->user11_size;?>" maxlength="<?php echo $rowExtended->user11_size;?>" value="<?php echo $rowExUser->user11;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user11_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user12_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user12_name; ?> </td>
       <td><input name="user12" type="text" class="inputbox" size="<?php echo $rowExtended->user12_size;?>" maxlength="<?php echo $rowExtended->user12_size;?>" value="<?php echo $rowExUser->user12;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user12_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user13_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user13_name; ?> </td>
       <td><input name="user13" type="text" class="inputbox" size="<?php echo $rowExtended->user13_size;?>" maxlength="<?php echo $rowExtended->user13_size;?>" value="<?php echo $rowExUser->user13;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user13_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user14_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user14_name; ?> </td>
       <td><input name="user14" type="text" class="inputbox" size="<?php echo $rowExtended->user14_size;?>" maxlength="<?php echo $rowExtended->user14_size;?>" value="<?php echo $rowExUser->user14;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user14_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user15_show=="1") { ?>
    <tr>
       <td><?php echo $rowExtended->user15_name; ?> </td>
       <td><input name="user15" type="text" class="inputbox" size="<?php echo $rowExtended->user15_size;?>" maxlength="<?php echo $rowExtended->user15_size;?>" value="<?php echo $rowExUser->user15;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($rowExtended->user15_must =="1") { echo _UEXT_REQUIRED; } ?></span></td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="2">
        <input class="button" type="button" value="<?php echo $submitvalue; ?>" onclick="submitbutton()"/>
      </td>
    </tr>
  </table>
  <input type="hidden" name="id" value="<?php echo $row->id;?>" />
  <input type="hidden" name="option" value="<?php echo $option;?>">
  <input type="hidden" name="task" value="saveUserEdit" />
  </form>
  <?php
  }


function confirmation() {
  ?>
  <table>
    <tr>
      <td class="componentheading"><?php echo _SUBMIT_SUCCESS; ?></td>
    </tr>
    <tr>
      <td><?php echo _SUBMIT_SUCCESS_DESC; ?></td>
    </tr>
  </table>
  <?php
  }


function UserView($option, $rowExUser, $u_name, $u_username, $u_email) {
  ?>
  <table cellpadding="5" cellspacing="0" border="0" width="100%">
    <tr>
      <td colspan="2" width="100%" class="componentheading"><?php echo _UEXT_DETAILSVIEW;?></td>
    </tr>
    <tr>
      <td width="30%" align="right"><?php echo _REGISTER_NAME; ?></td>
      <td width="70%"><?php echo $u_name; ?></td>
    </tr>
    <tr>
      <td align="right"><?php echo _REGISTER_UNAME; ?></td>
      <td><?php echo $u_username; ?></td>
    <tr>
      <td align="right"><?php echo _REGISTER_EMAIL; ?></td>
      <td><?php echo $u_email; ?> </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>

    <?php
     //Extended User details view
    global $database;
    include_once ("administrator/components/com_user_extended/user_extended.class.php");
    $rowExtended = new mosUser_Extended_Config ($database);
    $rowExtended->load(1);
    ?>
    <?php if ($rowExtended->user1_show=="1") { ?>
    <tr>
       <td width="20%" valign="top" align="right"><?php echo $rowExtended->user1_name; ?> </td>
       <td><?php echo $rowExUser->user1;?></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user2_show=="1") { ?>
    <tr>
       <td width="20%" valign="top" align="right"><?php echo $rowExtended->user2_name; ?></td>
       <td><?php echo $rowExUser->user2;?></td>
    </tr>
    <?php } ?><?php if ($rowExtended->user3_show=="1") { ?>
    <tr>
       <td width="20%" valign="top" align="right"><?php echo $rowExtended->user3_name; ?></td>
       <td><?php echo $rowExUser->user3;?></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user4_show=="1") { ?>
    <tr>
       <td width="20%" valign="top" align="right"><?php echo $rowExtended->user4_name; ?> </td>
       <td><?php echo $rowExUser->user4;?></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user5_show=="1") { ?>
    <tr>
       <td width="20%" valign="top" align="right"><?php echo $rowExtended->user5_name; ?> </td>
       <td><?php echo $rowExUser->user5;?></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user6_show=="1") { ?>
    <tr>
       <td width="20%" valign="top" align="right"><?php echo $rowExtended->user6_name; ?> </td>
       <td><?php echo $rowExUser->user6;?></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user7_show=="1") { ?>
    <tr>
       <td width="20%" valign="top" align="right"><?php echo $rowExtended->user7_name; ?> </td>
       <td><?php echo $rowExUser->user7;?></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user8_show=="1") { ?>
    <tr>
       <td width="20%" valign="top" align="right"><?php echo $rowExtended->user8_name; ?> </td>
       <td><?php echo $rowExUser->user8;?></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user9_show=="1") { ?>
    <tr>
       <td width="20%" valign="top" align="right"><?php echo $rowExtended->user9_name; ?> </td>
       <td><?php echo $rowExUser->user9;?></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user10_show=="1") { ?>
    <tr>
       <td width="20%" valign="top" align="right"><?php echo $rowExtended->user10_name; ?> </td>
       <td><?php echo $rowExUser->user10;?></td>
    </tr>
    <?php } ?>

    <?php if ($rowExtended->user11_show=="1") { ?>
    <tr>
       <td width="20%" valign="top" align="right"><?php echo $rowExtended->user11_name; ?> </td>
       <td><?php echo $rowExUser->user11;?></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user12_show=="1") { ?>
    <tr>
       <td width="20%" valign="top" align="right"><?php echo $rowExtended->user12_name; ?> </td>
       <td><?php echo $rowExUser->user12;?></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user13_show=="1") { ?>
    <tr>
       <td width="20%" valign="top" align="right"><?php echo $rowExtended->user13_name; ?> </td>
       <td><?php echo $rowExUser->user13;?></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user14_show=="1") { ?>
    <tr>
       <td width="20%" valign="top" align="right"><?php echo $rowExtended->user14_name; ?> </td>
       <td><?php echo $rowExUser->user14;?></td>
    </tr>
    <?php } ?>
    <?php if ($rowExtended->user15_show=="1") { ?>
    <tr>
       <td width="20%" valign="top" align="right"><?php echo $rowExtended->user15_name; ?> </td>
       <td><?php echo $rowExUser->user15;?></td>
    </tr>
    <?php } ?>
  </table>
  <input type="hidden" name="id" value="<?php echo $row->id;?>" />
  <input type="hidden" name="option" value="<?php echo $option;?>">
  <?php
  }
}

############################################################################
?>
