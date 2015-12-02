<?php
/**
* @version $Id: admin.messages.html.php,v 1.2 2004/10/11 03:36:33 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo_4.5.1
*/
class HTML_messages {
	function showMessages( &$rows, $pageNav, $search, $option ) {
       global $adminLanguage;
?>
<form action="index2.php" method="post" name="adminForm">
  <table class="adminheading">
    <tr>
      <th class="inbox"><?php echo $adminLanguage->A_COMP_MESS_PRIVATE;?></th>
      <td><?php echo $adminLanguage->A_COMP_MESS_SEARCH;?>:</td>
      <td> <input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
      </td>
    </tr>
  </table>
  <table class="adminlist">
    <tr>
      <th width="20">#</th>
      <th width="5%" class="title"> <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
      </th>
      <th width="60%" class="title"><?php echo $adminLanguage->A_COMP_MASS_SUB;?></th>
      <th width="15%" class="title"><?php echo $adminLanguage->A_COMP_MESS_FROM;?></th>
      <!-- <th width="20%" class="title">UserType</th> -->
      <th width="15%" class="title"><?php echo $adminLanguage->A_COMP_DATE;?></th>
      <th width="5%" class="title"><?php echo $adminLanguage->A_COMP_MESS_READ;?></th>
    </tr>
<?php
$k = 0;
for ($i=0, $n=count( $rows ); $i < $n; $i++) {
	$row =& $rows[$i];
?>
    <tr class="<?php echo "row$k"; ?>">
      <td width="20"><?php echo $i+1+$pageNav->limitstart;?></td>
      <td width="5%"><?php echo mosHTML::idBox( $i, $row->message_id ); ?></td>
      <td width="60%"> <a href="#edit" onClick="return listItemTask('cb<?php echo $i;?>','view')">
        <?php echo $row->subject; ?> </a> </td>
      <td width="15%"><?php echo $row->user_from; ?></td>
      <td width="15%"><?php echo $row->date_time; ?></td>
      <td width="15%"><?php 
      if (intval( $row->state ) == "1") {
      	echo $adminLanguage->A_COMP_MESS_READ;
      } else {
      	echo $adminLanguage->A_COMP_MESS_UNREAD;
	  } ?></td>
    </tr>
    <?php $k = 1 - $k;
			} ?>
	</table>
	<?php echo $pageNav->getListFooter(); ?>
  <input type="hidden" name="option" value="<?php echo $option;?>" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="boxchecked" value="0" />
</form>
<?php }

function editConfig( &$vars, $option) {
    global $adminLanguage;
	$tabs = new mosTabs(0);
?>
<table class="adminheading">
  <tr>
    <th class="msgconfig"><?php echo $adminLanguage->A_COMP_MESS_CONF;?></th>
  </tr>
</table>
<?php
$tabs->startPane("messages");
$tabs->startTab($adminLanguage->A_COMP_MESS_GENERAL, "general-page" );
?>
<form action="index2.php" method="post" name="adminForm">
<script language="javascript" type="text/javascript">
function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'saveconfig') {
		if (confirm ("<?php echo $adminLanguage->A_COMP_MESS_SURE;?>")) {
			submitform( pressbutton );
		}
	} else {
		document.location.href = 'index2.php?option=<?php echo $option;?>';
	}
}
</script>

  
    <table class="adminform">
      <tr>
        <td width="20%"><?php echo $adminLanguage->A_COMP_MESS_INBOX;?>:</td>
        <td> <?php echo $vars['lock']; ?> </td>
      </tr>
      <tr>
        <td width="20%"><?php echo $adminLanguage->A_COMP_MESS_MAILME;?>:</td>
        <td> <?php echo $vars['mail_on_new']; ?> </td>
      </tr>
    </table>


<?php
$tabs->endTab();
$tabs->endPane();
?>  <input type="hidden" name="option" value="<?php echo $option; ?>">
  <input type="hidden" name="task" value="">
</form>
<?php }

function viewMessage( &$row, $option ) {
    global $adminLanguage;
?>
	<table class="adminheading">
		<tr>
			<th class="inbox"><?php echo $adminLanguage->A_COMP_MESS_VIEW;?></th>
		</tr>
	</table>

	<form action="index2.php" method="post" name="adminForm">
	<table class="adminform">
		<tr>
			<td width="100"><?php echo $adminLanguage->A_COMP_MESS_FROM;?>:</td>
			<td width="85%" bgcolor="#ffffff"><?php echo $row->user_from;?></td>
		</tr>
		<tr>
			<td><?php echo $adminLanguage->A_COMP_MESS_POSTED;?>:</td>
			<td bgcolor="#ffffff"><?php echo $row->date_time;?></td>
		</tr>
		<tr>
			<td><?php echo $adminLanguage->A_COMP_MASS_SUB;?>:</td>
			<td bgcolor="#ffffff"><?php echo $row->subject;?></td>
		</tr>
		<tr>
			<td><?php echo $adminLanguage->A_COMP_MASS_MESS;?>:</td>
			<td width="100%" bgcolor="#ffffff"><?php echo htmlspecialchars( $row->message );?></td>
		</tr>
	</table>
	</form>
<?php }

function newMessage($option, $recipientslist ) {
	global $adminLanguage;
    global $my;
?>
	<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}

		// do field validation
		if (form.subject.value == "") {
			alert( "<?php echo $adminLanguage->A_COMP_MESS_PROVIDE_SUB;?>" );
		} else if (form.message.value == "") {
			alert( "<?php echo $adminLanguage->A_COMP_MESS_PROVIDE_MESS;?>" );
		} else if (getSelectedValue('adminForm','user_id_to') < 1) {
			alert( "<?php echo $adminLanguage->A_COMP_MESS_PROVIDE_REC;?>" );
		} else {
			submitform( pressbutton );
		}
	}
	</script>

	<table class="adminheading">
		<tr>
			<th class="inbox"><?php echo $adminLanguage->A_COMP_MESS_NEW;?></th>
		</tr>
	</table>

	<form action="index2.php" method="post" name="adminForm">
	<table class="adminform">
		<tr>
			<td width="100"><?php echo $adminLanguage->A_COMP_MESS_TO;?>:</td>
			<td width="85%" bgcolor="#ffffff"><?php echo $recipientslist; ?></td>
		</tr>
		<tr>
			<td><?php echo $adminLanguage->A_COMP_MASS_SUB;?>:</td>
			<td bgcolor="#ffffff"> <input type="text" name="subject" size="50" maxlength="100" class="inputbox" /></td>
		</tr>
		<tr>
			<td><?php echo $adminLanguage->A_COMP_MASS_MESS;?>:</td>
			<td width="100%" bgcolor="#ffffff"> <input type="text" name="message" size="50" maxlength="100" class="inputbox" /></td>
		</tr>
	</table>
	<input type="hidden" name="user_id_from" value="<?php echo $my->id; ?>">
	<input type="hidden" name="option" value="<?php echo $option; ?>">
	<input type="hidden" name="task" value="">
	</form>
<?php }

}?>
