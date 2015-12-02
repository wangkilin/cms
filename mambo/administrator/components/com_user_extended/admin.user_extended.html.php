<?php
// $Id: admin.user_extended.html.php,v 1.2 2004/09/27 21:43:13 bzechmann Exp $
/**
* @ Autor   : Bernhard Zechmann (MamboZ)
* @ Website : www.zechmann.com
* @ Download: www.mosforge.net/projects/userextended
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/


//class HTML_users {
class UserExtended_users {

  function showUsers( &$rows, $pageNav, $search, $option ) {
?>

<form action="index2.php" method="post" name="adminForm">
  <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname"><img src="components/com_user_extended/images/logo.png" valign="top">&nbsp;User Extended Manager</td>
      <td nowrap="nowrap">Display #</td>
      <td> <?php echo $pageNav->writeLimitBox(); ?> </td>
      <td>Search:</td>
      <td> <input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
      </td>
    </tr>
  </table>
  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
    <tr>
      <th width="2%" class="title">#</td>
      <th width="3%" class="title"> <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
      </th>
      <th width="20%" class="title">Name</th>
      <th width="10%" class="title">UserID</th>
      <th width="15%" class="title">Group</th>
      <th width="15%" class="title">E-Mail</th>
      <th width="15%" class="title">Last Visit</th>
      <th width="10%" class="title">Enabled</th>
    </tr>
<?php
    $k = 0;
    for ($i=0, $n=count( $rows ); $i < $n; $i++) {
      $row =& $rows[$i];
      $img = $row->block ? 'publish_x.png' : 'tick.png';
      $task = $row->block ? 'unblock' : 'block';
?>
    <tr class="<?php echo "row$k"; ?>">
      <td><?php echo $i+1+$pageNav->limitstart;?></td>
      <td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onClick="isChecked(this.checked);" /></td>
      <td> <a href="#edit" onClick="return listItemTask('cb<?php echo $i;?>','edit')">
        <?php echo $row->name; ?> </a> </td>
      <td><?php echo $row->username; ?></td>
      <td><?php echo $row->groupname; ?></td>
      <td><a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></a></td>
      <td><?php echo $row->lastvisitDate; ?></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task;?>')"><img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="" /></a></td>
    </tr>
    <?php $k = 1 - $k; } ?>
    <tr>
      <th align="center" colspan="9"> <?php echo $pageNav->writePagesLinks(); ?></th>
    </tr>
    <tr>
      <td align="center" colspan="9"> <?php echo $pageNav->writePagesCounter(); ?></td>
    </tr>
  </table>
  <input type="hidden" name="option" value="com_user_extended" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="boxchecked" value="0" />
</form>
<?php }


  function edituser( &$row, &$lists, $option, $uid ) {
    global $my, $acl;
    $canBlockUser = $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'user properties', 'block_user' );
    $canEmailEvents = $acl->acl_check( 'workflow', 'email_events', 'user', $acl->get_group_name( $row->gid, 'ARO' ) );
?>
  <script language="javascript" type="text/javascript">
    function submitbutton(pressbutton) {
      var form = document.adminForm;
      if (pressbutton == 'cancel') {
        submitform( pressbutton );
        return;
      }
      var r = new RegExp("[^0-9A-Za-z]", "i");

      // do field validation
      if (trim(form.name.value) == "") {
        alert( "You must provide a name." );
      } else if (form.username.value == "") {
        alert( "You must provide a user login name." );
      } else if (r.exec(form.username.value)) {
        alert( "You can only have characters and number in your login name." );
      } else if (trim(form.email.value) == "") {
        alert( "You must provide an email address." );
      } else if (form.gid.value == "") {
        alert( "You must assign user to a group." );
      } else if (trim(form.password.value) != "" && form.password.value != form.password2.value){
        alert( "Password do not match." );

      <?php
      // form validation for required fields
      global $database, $mainframe;
      $sql="select * from #__user_extended_config WHERE id='1'";
      $database->SetQuery($sql);
      $rows22 = $database->LoadObjectList();
      $row11 = $rows22[0];

      // next field
      if ($row11->user1_must && $row11->user1_show) {
      ?>
        } else if (form.user1.value == "") {
          alert( "<?php echo $row11->user1_name; ?> is required!." );
      <?php
      }

      // next field
      if ($row11->user2_must && $row11->user2_show) {
      ?>
        } else if (form.user2.value == "") {
          alert( "<?php echo $row11->user2_name; ?> is required!." );
      <?php
      }

      // next field
      if ($row11->user3_must && $row11->user3_show) {
      ?>
        } else if (form.user3.value == "") {
          alert( "<?php echo $row11->user3_name; ?> is required!." );
      <?php
      }

      // next field
      if ($row11->user4_must && $row11->user4_show) {
      ?>
        } else if (form.user4.value == "") {
          alert( "<?php echo $row11->user4_name; ?> is required!." );
      <?php
      }

      // next field
      if ($row11->user5_must && $row11->user5_show) {
      ?>
        } else if (form.user5.value == "") {
          alert( "<?php echo $row11->user5_name; ?> is required!." );
      <?php
      }

      // next field
      if ($row11->user6_must && $row11->user6_show) {
      ?>
        } else if (form.user6.value == "") {
          alert( "<?php echo $row11->user6_name; ?> is required!." );
      <?php
      }

      // next field
      if ($row11->user7_must && $row11->user7_show) {
      ?>
        } else if (form.user7.value == "") {
          alert( "<?php echo $row11->user7_name; ?> is required!." );
      <?php
      }

      // next field
      if ($row11->user8_must && $row11->user8_show) {
      ?>
        } else if (form.user8.value == "") {
          alert( "<?php echo $row11->user8_name; ?> is required!." );
      <?php
      }

      // next field
      if ($row11->user9_must && $row11->user9_show) {
      ?>
        } else if (form.user9.value == "") {
          alert( "<?php echo $row11->user9_name; ?> is required!." );
      <?php
      }

      // next field
      if ($row11->user10_must && $row11->user10_show) {
      ?>
        } else if (form.user10.value == "") {
          alert( "<?php echo $row11->user10_name; ?> is required!." );
      <?php
      }

      // next field
      if ($row11->user11_must && $row11->user11_show) {
      ?>
        } else if (form.user11.value == "") {
          alert( "<?php echo $row11->user11_name; ?> is required!." );
      <?php
      }

      // next field
      if ($row11->user12_must && $row11->user12_show) {
      ?>
        } else if (form.user12.value == "") {
          alert( "<?php echo $row11->user12_name; ?> is required!." );
      <?php
      }
      // next field
      if ($row11->user13_must && $row11->user13_show) {
      ?>
        } else if (form.user13.value == "") {
          alert( "<?php echo $row11->user13_name; ?> is required!." );
      <?php
      }
      // next field
      if ($row11->user14_must && $row11->user14_show) {
      ?>
        } else if (form.user14.value == "") {
          alert( "<?php echo $row11->user14_name; ?> is required!." );
      <?php
      }
      // next field
      if ($row11->user15_must && $row11->user15_show) {
      ?>
        } else if (form.user15.value == "") {
          alert( "<?php echo $row11->user15_name; ?> is required!." );
      <?php
      }


      // end custom form validation
      ?>


      } else {
        submitform( pressbutton );
      }
    }
  </script>
<script language="javascript" src="js/dhtml.js"></script>
  <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td class="sectionname"><img src="components/com_user_extended/images/logo.png" valign="top"><?php echo $row->id ? 'Edit' : 'Add';?> User Extended </td>
    </tr>
  </table>
<table cellspacing="0" cellpadding="4" border="0" width="100%">
  <tr>
    <td width="" class="tabpadding">&nbsp;</td>
    <td id="tab1" class="offtab" onClick="dhtml.cycleTab(this.id)">Mambo Core</td>
    <td id="tab2" class="offtab" onClick="dhtml.cycleTab(this.id)">Extended</td>
    <td width="90%" class="tabpadding">&nbsp;</td>
  </tr>
</table>
  <form action="index2.php" method="POST" name="adminForm">
    <div id="page1" class="pagetext">
  <table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
    <tr>
      <td width="100">Name:</td>
      <td width="85%"><input type="text" name="name" class="inputbox" size="40" value="<?php echo $row->name; ?>" /></td>
    </tr>
    <tr>
      <td>Username:</td>
      <td><input type="text" name="username" class="inputbox" size="40" value="<?php echo $row->username; ?>" /></td>
    <tr>
      <td>Email:</td>
      <td><input class="inputbox" type="text" name="email" size="40" value="<?php echo $row->email; ?>" /></td>
    </tr>
    <tr>
      <td>New Password:</td>
      <td><input class="inputbox" type="password" name="password" size="40" value="" /></td>
    </tr>
    <tr>
      <td>Verify Password:</td>
      <td><input class="inputbox" type="password" name="password2" size="40" value="" /></td>
    </tr>
    <tr>
      <td valign="top">Group:</td>
      <td><?php echo $lists['gid']; ?></td>
    </tr>
<?php  if ($canBlockUser) { ?>
    <tr>
      <td>Block User</td>
      <td><?php echo $lists['block']; ?></td>
    </tr>
<?php  }
    if ($canEmailEvents) { ?>
    <tr>
      <td>Receive Submission Emails</td>
      <td><?php echo $lists['sendEmail']; ?></td>
    </tr>
<?php  } ?>
<?php if( $uid ) { ?>
    <tr>
       <td>Register Date</td>
       <td><?php echo $row->registerDate;?></td>
    </tr>
    <tr>
       <td>Last Visit Date</td>
       <td><?php echo $row->lastvisitDate;?></td>
    </tr>
<?php } ?>
</table></div>
 <div id="page2" class="pagetext">
  <table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
    <tr>
      <th colspan="2">Extended Details</th>
    </tr>
    <?php if ($row->user1_show=="1") { ?>
    <tr>
       <td><?php echo $row->user1_name; ?> </td>
       <td><input name="user1" type="text" class="inputbox" value="<?php echo $row->user1;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($row->user1_must =="1") { echo "Required"; } ?></span></td>
    </tr>
    <?php } ?><?php if ($row->user2_show=="1") { ?>
    <tr>
       <td><?php echo $row->user2_name; ?></td>
       <td><input name="user2" type="text" class="inputbox" value="<?php echo $row->user2;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($row->user2_must =="1") { echo "Required"; } ?></span></td>
    </tr>
    <?php } ?><?php if ($row->user3_show=="1") { ?>
    <tr>
       <td><?php echo $row->user3_name; ?></td>
       <td><input name="user3" type="text" class="inputbox" value="<?php echo $row->user3;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($row->user3_must =="1") { echo "Required"; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($row->user4_show=="1") { ?>
    <tr>
       <td><?php echo $row->user4_name; ?> </td>
       <td><input name="user4" type="text" class="inputbox" value="<?php echo $row->user4;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($row->user4_must =="1") { echo "Required"; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($row->user5_show=="1") { ?>
    <tr>
       <td><?php echo $row->user5_name; ?> </td>
       <td><input name="user5" type="text" class="inputbox" value="<?php echo $row->user5;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($row->user5_must =="1") { echo "Required"; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($row->user6_show=="1") { ?>
    <tr>
       <td><?php echo $row->user6_name; ?> </td>
       <td><input name="user6" type="text" class="inputbox" value="<?php echo $row->user6;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($row->user6_must =="1") { echo "Required"; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($row->user7_show=="1") { ?>
    <tr>
       <td><?php echo $row->user7_name; ?> </td>
       <td><input name="user7" type="text" class="inputbox" value="<?php echo $row->user7;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($row->user7_must =="1") { echo "Required"; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($row->user8_show=="1") { ?>
    <tr>
       <td><?php echo $row->user8_name; ?> </td>
       <td><input name="user8" type="text" class="inputbox" value="<?php echo $row->user8;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($row->user8_must =="1") { echo "Required"; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($row->user9_show=="1") { ?>
    <tr>
       <td><?php echo $row->user9_name; ?> </td>
       <td><input name="user9" type="text" class="inputbox" value="<?php echo $row->user9;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($row->user9_must =="1") { echo "Required"; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($row->user10_show=="1") { ?>
    <tr>
       <td><?php echo $row->user10_name; ?> </td>
       <td><input name="user10" type="text" class="inputbox" value="<?php echo $row->user10;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($row->user10_must =="1") { echo "Required"; } ?></span></td>
    </tr>
    <?php } ?>

    <?php if ($row->user11_show=="1") { ?>
    <tr>
       <td><?php echo $row->user11_name; ?> </td>
       <td><input name="user11" type="text" class="inputbox" value="<?php echo $row->user11;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($row->user11_must =="1") { echo "Required"; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($row->user12_show=="1") { ?>
    <tr>
       <td><?php echo $row->user12_name; ?> </td>
       <td><input name="user12" type="text" class="inputbox" value="<?php echo $row->user12;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($row->user12_must =="1") { echo "Required"; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($row->user13_show=="1") { ?>
    <tr>
       <td><?php echo $row->user13_name; ?> </td>
       <td><input name="user13" type="text" class="inputbox" value="<?php echo $row->user13;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($row->user13_must =="1") { echo "Required"; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($row->user14_show=="1") { ?>
    <tr>
       <td><?php echo $row->user14_name; ?> </td>
       <td><input name="user14" type="text" class="inputbox" value="<?php echo $row->user14;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($row->user14_must =="1") { echo "Required"; } ?></span></td>
    </tr>
    <?php } ?>
    <?php if ($row->user15_show=="1") { ?>
    <tr>
       <td><?php echo $row->user15_name; ?> </td>
       <td><input name="user15" type="text" class="inputbox" value="<?php echo $row->user15;?>">
       &nbsp;&nbsp;<span class="error"><?php if ($row->user15_must =="1") { echo "Required"; } ?></span></td>
    </tr>
    <?php } ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table></div>
  <input type="hidden" name="id" value="<?php echo $row->editid; ?>" />
   <input type="hidden" name="user_id" value="<?php echo $row->editid; ?>" />
<?php  if (!$canEmailEvents) { ?>
  <input type="hidden" name="sendEmail" value="0" />
<?php } ?>
  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="task" value="" />

</form>
<script language="javascript" type="text/javascript">
    dhtml.cycleTab('tab1');
    </script>
<?php }


function showAbout() {
?>
  <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td class="sectionname"><img src="components/com_user_extended/images/logo.png" valign="top"> About</td>
    </tr>
    <tr>
      <td>
        <pre><?php include ("components/com_user_extended/README.txt"); ?></pre>
       </td>
    </tr>
  </table>
<?php
  }


  function showCopyright() {
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">Copyright &copy; 2004, Bernhard Zechmann (MamboZ) <a href="http://www.zechmann.com" target="_blank">http://www.zechmann.com</a></td>
  </tr>
</table>
<?php
  }

}
?>


<?php

//class HTML_users_extended {
class UserExtended_users_extended {

  function Config($row,$option,$database){
  ?>
  <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td class="sectionname"><img src="components/com_user_extended/images/logo.png" valign="top"> Extended User Configuration </td>
    </tr>
  </table>
  <form action="index2.php" method="POST" name="adminForm">
  <table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
    <tr>
      <th width="100">Title/Name:</th>
      <th width="25%"><div align="center">Shown</div></th>
      <th width="25%"><div align="center">Required</div></th>
      <th width="25%"><div align="center">Size</div></th>
    </tr>

  <!-- ROW -->
   <tr>
       <td><input name="user1_name" type="text" id="user1_name" class="inputbox" value="<?php echo $row->user1_name ?>"></td>
       <td>  <div align="center">
         <label>
            <input name="user1_show" type="radio" value="1" <?php if ($row->user1_show == "1") { echo "checked"; } ?>>
    Yes</label>

          <label>
            <input type="radio" name="user1_show" value="0"<?php if ($row->user1_show == "0") { echo "checked"; } ?>>
    No</label>
           </div></td>
       <td>
             <div align="center">
               <label>
               <input name="user1_must" type="radio" value="1" <?php if ($row->user1_must == "1") { echo "checked"; } ?>>
    Yes</label>
               <label>
               <input type="radio" name="user1_must" value="0"<?php if ($row->user1_must == "0") { echo "checked"; } ?>>
    No</label>
             </div></td>
             <td><input name="user1_size" type="text" id="user1_size" class="inputbox" value="<?php echo $row->user1_size ?>"></td>
    </tr>
    <!-- end row --><!-- ROW -->
   <tr>
       <td><input name="user2_name" type="text" id="user2_name" class="inputbox" value="<?php echo $row->user2_name ?>"></td>
       <td>  <div align="center">
         <label>
            <input name="user2_show" type="radio" value="1" <?php if ($row->user2_show == "1") { echo "checked"; } ?>>
    Yes</label>

          <label>
            <input type="radio" name="user2_show" value="0"<?php if ($row->user2_show == "0") { echo "checked"; } ?>>
    No</label>
           </div></td>
       <td>
             <div align="center">
               <label>
               <input name="user2_must" type="radio" value="1" <?php if ($row->user2_must == "1") { echo "checked"; } ?>>
    Yes</label>
               <label>
               <input type="radio" name="user2_must" value="0"<?php if ($row->user2_must == "0") { echo "checked"; } ?>>
    No</label>
             </div></td>
             <td><input name="user2_size" type="text" id="user2_size" class="inputbox" value="<?php echo $row->user2_size ?>"></td>
    </tr>
    <!-- end row --><!-- ROW -->
   <tr>
       <td><input name="user3_name" type="text" id="user3_name" class="inputbox" value="<?php echo $row->user3_name ?>"></td>
       <td>  <div align="center">
         <label>
            <input name="user3_show" type="radio" value="1" <?php if ($row->user3_show == "1") { echo "checked"; } ?>>
    Yes</label>

          <label>
            <input type="radio" name="user3_show" value="0"<?php if ($row->user3_show == "0") { echo "checked"; } ?>>
    No</label>
           </div></td>
       <td>
             <div align="center">
               <label>
               <input name="user3_must" type="radio" value="1" <?php if ($row->user3_must == "1") { echo "checked"; } ?>>
    Yes</label>
               <label>
               <input type="radio" name="user3_must" value="0"<?php if ($row->user3_must == "0") { echo "checked"; } ?>>
    No</label>
             </div></td>
             <td><input name="user3_size" type="text" id="user3_size" class="inputbox" value="<?php echo $row->user3_size ?>"></td>
    </tr>
    <!-- end row --><!-- ROW -->
   <tr>
       <td><input name="user4_name" type="text" id="user4_name" class="inputbox" value="<?php echo $row->user4_name ?>"></td>
       <td>  <div align="center">
         <label>
            <input name="user4_show" type="radio" value="1" <?php if ($row->user4_show == "1") { echo "checked"; } ?>>
    Yes</label>

          <label>
            <input type="radio" name="user4_show" value="0"<?php if ($row->user4_show == "0") { echo "checked"; } ?>>
    No</label>
           </div></td>
       <td>
             <div align="center">
               <label>
               <input name="user4_must" type="radio" value="1" <?php if ($row->user4_must == "1") { echo "checked"; } ?>>
    Yes</label>
               <label>
               <input type="radio" name="user4_must" value="0"<?php if ($row->user4_must == "0") { echo "checked"; } ?>>
    No</label>
             </div></td>
             <td><input name="user4_size" type="text" id="user4_size" class="inputbox" value="<?php echo $row->user4_size ?>"></td>
    </tr>
    <!-- end row --><!-- ROW -->
   <tr>
       <td><input name="user5_name" type="text" id="user5_name" class="inputbox" value="<?php echo $row->user5_name ?>"></td>
       <td>  <div align="center">
         <label>
            <input name="user5_show" type="radio" value="1" <?php if ($row->user5_show == "1") { echo "checked"; } ?>>
    Yes</label>

          <label>
            <input type="radio" name="user5_show" value="0"<?php if ($row->user5_show == "0") { echo "checked"; } ?>>
    No</label>
           </div></td>
       <td>
             <div align="center">
               <label>
               <input name="user5_must" type="radio" value="1" <?php if ($row->user5_must == "1") { echo "checked"; } ?>>
    Yes</label>
               <label>
               <input type="radio" name="user5_must" value="0"<?php if ($row->user5_must == "0") { echo "checked"; } ?>>
    No</label>
             </div></td>
             <td><input name="user5_size" type="text" id="user5_size" class="inputbox" value="<?php echo $row->user5_size ?>"></td>
    </tr>
    <!-- end row --><!-- ROW -->
   <tr>
       <td><input name="user6_name" type="text" id="user6_name" class="inputbox" value="<?php echo $row->user6_name ?>"></td>
       <td>  <div align="center">
         <label>
            <input name="user6_show" type="radio" value="1" <?php if ($row->user6_show == "1") { echo "checked"; } ?>>
    Yes</label>

          <label>
            <input type="radio" name="user6_show" value="0"<?php if ($row->user6_show == "0") { echo "checked"; } ?>>
    No</label>
           </div></td>
       <td>
             <div align="center">
               <label>
               <input name="user6_must" type="radio" value="1" <?php if ($row->user6_must == "1") { echo "checked"; } ?>>
    Yes</label>
               <label>
               <input type="radio" name="user6_must" value="0"<?php if ($row->user6_must == "0") { echo "checked"; } ?>>
    No</label>
             </div></td>
             <td><input name="user6_size" type="text" id="user6_size" class="inputbox" value="<?php echo $row->user6_size ?>"></td>
    </tr>
    <!-- end row --><!-- ROW -->
   <tr>
       <td><input name="user7_name" type="text" id="user7_name" class="inputbox" value="<?php echo $row->user7_name ?>"></td>
       <td>  <div align="center">
         <label>
            <input name="user7_show" type="radio" value="1" <?php if ($row->user7_show == "1") { echo "checked"; } ?>>
    Yes</label>

          <label>
            <input type="radio" name="user7_show" value="0"<?php if ($row->user7_show == "0") { echo "checked"; } ?>>
    No</label>
           </div></td>
       <td>
             <div align="center">
               <label>
               <input name="user7_must" type="radio" value="1" <?php if ($row->user7_must == "1") { echo "checked"; } ?>>
    Yes</label>
               <label>
               <input type="radio" name="user7_must" value="0"<?php if ($row->user7_must == "0") { echo "checked"; } ?>>
    No</label>
             </div></td>
             <td><input name="user7_size" type="text" id="user7_size" class="inputbox" value="<?php echo $row->user7_size ?>"></td>
    </tr>
    <!-- end row --><!-- ROW -->
   <tr>
       <td><input name="user8_name" type="text" id="user8_name" class="inputbox" value="<?php echo $row->user8_name ?>"></td>
       <td>  <div align="center">
         <label>
            <input name="user8_show" type="radio" value="1" <?php if ($row->user8_show == "1") { echo "checked"; } ?>>
    Yes</label>

          <label>
            <input type="radio" name="user8_show" value="0"<?php if ($row->user8_show == "0") { echo "checked"; } ?>>
    No</label>
           </div></td>
       <td>
             <div align="center">
               <label>
               <input name="user8_must" type="radio" value="1" <?php if ($row->user8_must == "1") { echo "checked"; } ?>>
    Yes</label>
               <label>
               <input type="radio" name="user8_must" value="0"<?php if ($row->user8_must == "0") { echo "checked"; } ?>>
    No</label>
             </div></td>
             <td><input name="user8_size" type="text" id="user8_size" class="inputbox" value="<?php echo $row->user8_size ?>"></td>
    </tr>
    <!-- end row --><!-- ROW -->
   <tr>
       <td><input name="user9_name" type="text" id="user9_name" class="inputbox" value="<?php echo $row->user9_name ?>"></td>
       <td>  <div align="center">
         <label>
            <input name="user9_show" type="radio" value="1" <?php if ($row->user9_show == "1") { echo "checked"; } ?>>
    Yes</label>

          <label>
            <input type="radio" name="user9_show" value="0"<?php if ($row->user9_show == "0") { echo "checked"; } ?>>
    No</label>
           </div></td>
       <td>
             <div align="center">
               <label>
               <input name="user9_must" type="radio" value="1" <?php if ($row->user9_must == "1") { echo "checked"; } ?>>
    Yes</label>
               <label>
               <input type="radio" name="user9_must" value="0"<?php if ($row->user9_must == "0") { echo "checked"; } ?>>
    No</label>
             </div></td>
             <td><input name="user9_size" type="text" id="user9_size" class="inputbox" value="<?php echo $row->user9_size ?>"></td>
    </tr>
    <!-- end row --><!-- ROW -->
   <tr>
       <td><input name="user10_name" type="text" id="user10_name" class="inputbox" value="<?php echo $row->user10_name ?>"></td>
       <td>  <div align="center">
         <label>
            <input name="user10_show" type="radio" value="1" <?php if ($row->user10_show == "1") { echo "checked"; } ?>>
    Yes</label>

          <label>
            <input type="radio" name="user10_show" value="0"<?php if ($row->user10_show == "0") { echo "checked"; } ?>>
    No</label>
           </div></td>
       <td>
             <div align="center">
               <label>
               <input name="user10_must" type="radio" value="1" <?php if ($row->user10_must == "1") { echo "checked"; } ?>>
    Yes</label>
               <label>
               <input type="radio" name="user10_must" value="0"<?php if ($row->user10_must == "0") { echo "checked"; } ?>>
    No</label>
             </div></td>
             <td><input name="user10_size" type="text" id="user10_size" class="inputbox" value="<?php echo $row->user10_size ?>"></td>
    </tr>
    <!-- end row --><!-- ROW -->
   <tr>
       <td><input name="user11_name" type="text" id="user11_name" class="inputbox" value="<?php echo $row->user11_name ?>"></td>
       <td>  <div align="center">
         <label>
            <input name="user11_show" type="radio" value="1" <?php if ($row->user11_show == "1") { echo "checked"; } ?>>
    Yes</label>

          <label>
            <input type="radio" name="user11_show" value="0"<?php if ($row->user11_show == "0") { echo "checked"; } ?>>
    No</label>
           </div></td>
       <td>
             <div align="center">
               <label>
               <input name="user11_must" type="radio" value="1" <?php if ($row->user11_must == "1") { echo "checked"; } ?>>
    Yes</label>
               <label>
               <input type="radio" name="user11_must" value="0"<?php if ($row->user11_must == "0") { echo "checked"; } ?>>
    No</label>
             </div></td>
             <td><input name="user11_size" type="text" id="user11_size" class="inputbox" value="<?php echo $row->user11_size ?>"></td>
    </tr>
    <!-- end row --><!-- ROW -->
   <tr>
       <td><input name="user12_name" type="text" id="user12_name" class="inputbox" value="<?php echo $row->user12_name ?>"></td>
       <td>  <div align="center">
         <label>
            <input name="user12_show" type="radio" value="1" <?php if ($row->user12_show == "1") { echo "checked"; } ?>>
    Yes</label>

          <label>
            <input type="radio" name="user12_show" value="0"<?php if ($row->user12_show == "0") { echo "checked"; } ?>>
    No</label>
           </div></td>
       <td>
             <div align="center">
               <label>
               <input name="user12_must" type="radio" value="1" <?php if ($row->user12_must == "1") { echo "checked"; } ?>>
    Yes</label>
               <label>
               <input type="radio" name="user12_must" value="0"<?php if ($row->user12_must == "0") { echo "checked"; } ?>>
    No</label>
             </div></td>
             <td><input name="user12_size" type="text" id="user12_size" class="inputbox" value="<?php echo $row->user12_size ?>"></td>
    </tr>
    <!-- end row --><!-- ROW -->
   <tr>
       <td><input name="user13_name" type="text" id="user13_name" class="inputbox" value="<?php echo $row->user13_name ?>"></td>
       <td>  <div align="center">
         <label>
            <input name="user13_show" type="radio" value="1" <?php if ($row->user13_show == "1") { echo "checked"; } ?>>
    Yes</label>

          <label>
            <input type="radio" name="user13_show" value="0"<?php if ($row->user13_show == "0") { echo "checked"; } ?>>
    No</label>
           </div></td>
       <td>
             <div align="center">
               <label>
               <input name="user13_must" type="radio" value="1" <?php if ($row->user13_must == "1") { echo "checked"; } ?>>
    Yes</label>
               <label>
               <input type="radio" name="user13_must" value="0"<?php if ($row->user13_must == "0") { echo "checked"; } ?>>
    No</label>
             </div></td>
             <td><input name="user13_size" type="text" id="user13_size" class="inputbox" value="<?php echo $row->user13_size ?>"></td>
    </tr>
    <!-- end row --><!-- ROW -->
   <tr>
       <td><input name="user14_name" type="text" id="user14_name" class="inputbox" value="<?php echo $row->user14_name ?>"></td>
       <td>  <div align="center">
         <label>
            <input name="user14_show" type="radio" value="1" <?php if ($row->user14_show == "1") { echo "checked"; } ?>>
    Yes</label>

          <label>
            <input type="radio" name="user14_show" value="0"<?php if ($row->user14_show == "0") { echo "checked"; } ?>>
    No</label>
           </div></td>
       <td>
             <div align="center">
               <label>
               <input name="user14_must" type="radio" value="1" <?php if ($row->user14_must == "1") { echo "checked"; } ?>>
    Yes</label>
               <label>
               <input type="radio" name="user14_must" value="0"<?php if ($row->user14_must == "0") { echo "checked"; } ?>>
    No</label>
             </div></td>
             <td><input name="user14_size" type="text" id="user14_size" class="inputbox" value="<?php echo $row->user14_size ?>"></td>
    </tr>
    <!-- end row --><!-- ROW -->
   <tr>
       <td><input name="user15_name" type="text" id="user15_name" class="inputbox" value="<?php echo $row->user15_name ?>"></td>
       <td>  <div align="center">
         <label>
            <input name="user15_show" type="radio" value="1" <?php if ($row->user15_show == "1") { echo "checked"; } ?>>
    Yes</label>

          <label>
            <input type="radio" name="user15_show" value="0"<?php if ($row->user15_show == "0") { echo "checked"; } ?>>
    No</label>
           </div></td>
       <td>
             <div align="center">
               <label>
               <input name="user15_must" type="radio" value="1" <?php if ($row->user15_must == "1") { echo "checked"; } ?>>
    Yes</label>
               <label>
               <input type="radio" name="user15_must" value="0"<?php if ($row->user15_must == "0") { echo "checked"; } ?>>
    No</label>
             </div></td>
             <td><input name="user15_size" type="text" id="user15_size" class="inputbox" value="<?php echo $row->user15_size ?>"></td>
    </tr>
    <!-- end row -->

    <tr>
      <th>&nbsp;</th>
      <th><div align="center">The following fields are needed for Mambo Core </div></th>
      <th><div align="center"></div></th>
      <th><div align="center"></div></th>
    </tr>
    <tr>
      <td> Name<br>
        </td>
      <td> <div align="center">Yes</div></td>
      <td><div align="center">Yes</div></td>
      <td><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
      <td>Username</td>
      <td> <div align="center">Yes</div></td>
      <td><div align="center">Yes</div></td>
      <td><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
      <td>Password</td>
      <td> <div align="center">Yes</div></td>
      <td><div align="center">Yes</div></td>
      <td><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
      <td>Group</td>
      <td> <div align="center">Yes</div></td>
      <td><div align="center">Yes</div></td>
      <td><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
      <td>Block User </td>
      <td> <div align="center">Yes</div></td>
      <td><div align="center">Yes</div></td>
      <td><div align="center">&nbsp;</div></td>
    </tr>

  </table>
  <input type="hidden" name="id" value="1" />
  <input type="hidden" name="option" value="com_user_extended" />
  <input type="hidden" name="task" value="saveconfig" />
   <input type="hidden" name="act" value="saveconfig" />
</form>
  <?php
  }

}
?>