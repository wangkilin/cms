<?php
/**
* @version $Id: menubar.html.php,v 1.2 2004/10/11 03:36:33 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/**
* Utility class for the button bar
* @package Mambo_4.5.1
*/
class mosMenuBar {

	/**
	* Writes the start of the button bar table
	*/
	function startTable() { 
		?>
		<script language="JavaScript" type="text/JavaScript">
		<!--
		function MM_swapImgRestore() { //v3.0
		var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
		}
		//-->
		</script>
		<table cellpadding="3" cellspacing="0" border="0">
		<tr>
		<?php
	}

	/**
	* Writes a custom option and task button for the button bar
	* @param string The task to perform (picked up by the switch($task) blocks
	* @param string The image to display
	* @param string The image to display when moused over
	* @param string The alt text for the icon image
	* @param boolean True if required to check that a standard list item is checked
	*/
	function custom( $task='', $icon='', $iconOver='', $alt='', $listSelect=true ) {
		if ($listSelect) {
			$href = "javascript:if (document.adminForm.boxchecked.value == 0){ alert('".$adminLanguage->A_ALERT_SELECT_TO." $alt');}else{submitbutton('$task')}";
		} else {
			$href = "javascript:submitbutton('$task')";
		}
		?>
		<td>
		<a class="toolbar" href="<?php echo $href;?>" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','images/<?php echo $iconOver;?>',1);">
		<img name="<?php echo $task;?>" src="images/<?php echo $icon;?>" alt="<?php echo $alt;?>" border="0" align="middle" />
		&nbsp;
		<?php echo $alt; ?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes the common 'new' icon for the button bar
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function addNew( $task='new', $alt='New' ) {
		global $adminLanguage;
		
		$image = mosAdminMenus::ImageCheckAdmin( 'new.png', '/administrator/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'new_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:submitbutton('<?php echo $task;?>');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_NEW;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'publish' button
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function publish( $task='publish', $alt='Publish' ) { 
		global $adminLanguage;
		
		$image = mosAdminMenus::ImageCheckAdmin( 'publish.png', '/administrator/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'publish_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:submitbutton('<?php echo $task;?>');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_PUBLISH;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'publish' button for a list of records
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function publishList( $task='publish', $alt='Publish' ) { 
		global $adminLanguage;
		
		$image = mosAdminMenus::ImageCheckAdmin( 'publish.png', '/administrator/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'publish_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
		?>
     	<td>
		<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('<?php echo $adminLanguage->A_ALERT_SELECT_PUB;?>'); } else {submitbutton('<?php echo $task;?>', '');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_PUBLISH;?>
		</a>
		</td>
     	<?php
	}

	/**
	* Writes a common 'default' button for a record
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function makeDefault( $task='default', $alt='Default' ) { 
		global $adminLanguage;
		
		$image = mosAdminMenus::ImageCheckAdmin( 'publish.png', '/administrator/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'publish_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('<?php echo $adminLanguage->A_ALERT_SELECT_PUB_LIST;?>'); } else {submitbutton('<?php echo $task;?>', '');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_DEFAULT;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'assign' button for a record
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function assign( $task='assign', $alt='Assign' ) { 
		global $adminLanguage;
		
		$image = mosAdminMenus::ImageCheckAdmin( 'publish.png', '/administrator/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'publish_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('<?php echo $adminLanguage->A_ALERT_ITEM_ASSIGN;?>'); } else {submitbutton('<?php echo $task;?>', '');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_ASSIGN;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'unpublish' button
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function unpublish( $task='unpublish', $alt='Unpublish' ) { 
		global $adminLanguage;
		
		$image = mosAdminMenus::ImageCheckAdmin( 'unpublish.png', '/administrator/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'unpublish_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:submitbutton('<?php echo $task;?>');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);" >
		<?php echo $image; ?>
<?php echo $adminLanguage->A_UNPUBLISH;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'unpublish' button for a list of records
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function unpublishList( $task='unpublish', $alt='Unpublish' ) {
		global $adminLanguage;
		 
		$image = mosAdminMenus::ImageCheckAdmin( 'unpublish.png', '/administrator/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'unpublish_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('<?php echo $adminLanguage->A_ALERT_SELECT_UNPUBLISH;?>'); } else {submitbutton('<?php echo $task;?>', '');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);" >
		<?php echo $image; ?>
<?php echo $adminLanguage->A_UNPUBLISH;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'archive' button for a list of records
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function archiveList( $task='archive', $alt='Archive' ) {
		global $adminLanguage;
		 
		$image = mosAdminMenus::ImageCheckAdmin( 'archive.png', '/administrator/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'archive_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('<?php echo $adminLanguage->A_ALERT_SELECT_ARCHIVE;?>'); } else {submitbutton('<?php echo $task;?>', '');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_MENU_ARCHIVE;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes an unarchive button for a list of records
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function unarchiveList( $task='unarchive', $alt='Unarchive' ) { 
		global $adminLanguage;
		
		$image = mosAdminMenus::ImageCheckAdmin( 'unarchive.png', '/administrator/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'unarchive_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('<?php echo $adminLanguage->A_ALERT_SELECT_UNARCHIVE;?>'); } else {submitbutton('<?php echo $task;?>', '');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_UNARCHIVE;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'edit' button for a list of records
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function editList( $task='edit', $alt='Edit' ) { 
		global $adminLanguage;
		
		$image = mosAdminMenus::ImageCheckAdmin( 'edit.png', '/administrator/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'edit_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('<?php echo $adminLanguage->A_ALERT_SELECT_EDIT;?>'); } else {submitbutton('<?php echo $task;?>', '');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_EDIT;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'edit' button for a template html
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function editHtml( $task='edit_source', $alt='Edit HTML' ) { 
		global $adminLanguage;
		
		$image = mosAdminMenus::ImageCheckAdmin( 'html.png', '/administrator/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'html_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('<?php echo $adminLanguage->A_ALERT_SELECT_EDIT;?>'); } else {submitbutton('<?php echo $task;?>', '');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_EDIT;?> HTML
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'edit' button for a template css
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function editCss( $task='edit_css', $alt='Edit CSS' ) { 
		global $adminLanguage;
		
		$image = mosAdminMenus::ImageCheckAdmin( 'css.png', '/administrator/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'css_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('<?php echo $adminLanguage->A_ALERT_SELECT_EDIT;?>'); } else {submitbutton('<?php echo $task;?>', '');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_EDIT;?> CSS
		</a>
		</td>
		<?php
	}

	/**
	* Writes a common 'delete' button for a list of records
	* @param string  Postscript for the 'are you sure' message
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function deleteList( $msg='', $task='remove', $alt='Delete' ) { 
		global $adminLanguage;
		
		$image = mosAdminMenus::ImageCheckAdmin( 'delete.png', '/administrator/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'delete_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('<?php echo $adminLanguage->A_ALERT_SELECT_DELETE;?>'); } else if (confirm('<?php echo $adminLanguage->A_ALERT_CONFIRM_DELETE;?>
<?php echo $msg;?>')){ submitbutton('<?php echo $task;?>');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_DELETE;?>
		</a>
		</td>
		<?php
	}

	/**
	* Write a trash button that will move items to Trash Manager
	*/
	function trash( $task='remove', $alt='Trash' ) { 
		global $adminLanguage;
		
		$image = mosAdminMenus::ImageCheckAdmin( 'delete.png', '/administrator/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'delete_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
		?>
		 <td>
		<a class="toolbar" href="javascript:submitbutton('<?php echo $task;?>');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_TRASH;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a preview button for a given option (opens a popup window)
	* @param string The name of the popup file (excluding the file extension)
	*/
	function preview( $popup='', $updateEditors=false ) {
		global $database, $adminLanguage;
		$image = mosAdminMenus::ImageCheckAdmin( 'preview.png', '/administrator/images/', NULL, NULL, 'Preview', 'preview' );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'preview_f2.png', '/administrator/images/', NULL, NULL, 'Preview', 'preview', 0 );

		$sql = "SELECT template FROM #__templates_menu WHERE client_id='0' AND menuid='0'";
		$database->setQuery( $sql );
		$cur_template = $database->loadResult();
		?>
		<td>
		<script language="javascript">
		function popup() {
			<?php
			if ($updateEditors) {
				getEditorContents( 'editor1', 'introtext' );
				getEditorContents( 'editor2', 'fulltext' );
			}
			?>
			window.open('popups/<?php echo $popup;?>.php?t=<?php echo $cur_template; ?>', 'win1', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');
		}
		</script>
	 	<a class="toolbar" href="#" onclick="popup();" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('preview','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_MENU_PREVIEW;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a preview button for a given option (opens a popup window)
	* @param string The name of the popup file (excluding the file extension)
	*/
	function help( $ref ) {
		global $mosConfig_live_site, $adminLanguage;
		$image = mosAdminMenus::ImageCheckAdmin( 'help.png', '/administrator/images/', NULL, NULL, 'Help', 'help' );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'help_f2.png', '/administrator/images/', NULL, NULL, 'Help', 'help', 0 );
		?>
		<td>
		<a class="toolbar" href="#" onclick="window.open('<?php echo "$mosConfig_live_site/help/$ref.xml";?>', 'mambo_help_win', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('help','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_HELP;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a save button for a given option
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function save( $task='save', $alt=_A_SAVE ) {
		$image = mosAdminMenus::ImageCheckAdmin( 'save.png', '/administrator/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'save_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:submitbutton('<?php echo $task;?>');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $alt;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a save button for a given option (NOTE this is being deprecated)
	*/
	function savenew() { 
		global $adminLanguage;
		
		$image = mosAdminMenus::ImageCheckAdmin( 'save.png', '/administrator/images/', NULL, NULL, 'save', 'save' );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'save_f2.png', '/administrator/images/', NULL, NULL, 'save', 'save', 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:submitbutton('savenew');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('save','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_SAVE;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a save button for a given option (NOTE this is being deprecated)
	*/
	function saveedit() { 
		global $adminLanguage;
		
		$image = mosAdminMenus::ImageCheckAdmin( 'save.png', '/administrator/images/', NULL, NULL, 'save', 'save' );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'save_f2.png', '/administrator/images/', NULL, NULL, 'save', 'save', 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:submitbutton('saveedit');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('save','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_SAVE;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a cancel button and invokes a cancel operation (eg a checkin)
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function cancel( $task='cancel', $alt=_A_CANCEL ) { 		
		$image = mosAdminMenus::ImageCheckAdmin( 'cancel.png', '/administrator/images/', NULL, NULL, $alt, $task );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'cancel_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:submitbutton('<?php echo $task;?>');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $alt;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a cancel button that will go back to the previous page without doing
	* any other operation
	*/
	function back() { 
		global $adminLanguage;
		
		$image = mosAdminMenus::ImageCheckAdmin( 'back.png', '/administrator/images/', NULL, NULL, 'back', 'cancel' );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'back_f2.png', '/administrator/images/', NULL, NULL, 'back', 'cancel', 0 );
		?>
		<td>
		<a class="toolbar" href="javascript:window.history.back();" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_BACK;?>
		</a>
		</td>
		<?php
	}

	/**
	* Write a divider between menu buttons
	*/
	function divider() { 
		$image = mosAdminMenus::ImageCheckAdmin( 'menu_divider.png', '/administrator/images/' );
		?>
		<td>
		<?php echo $image; ?>
		</td>
		<?php
	}

	/**
	* Writes a media_manager button
	* @param string The sub-drectory to upload the media to
	*/
	function media_manager( $directory = '' ) {
		global $database, $adminLanguage;
		$sql = "SELECT template FROM #__templates_menu WHERE client_id='1' AND menuid='0'";
		$database->setQuery( $sql );
		$cur_template = $database->loadResult();
		$image = mosAdminMenus::ImageCheckAdmin( 'upload.png', '/administrator/images/', NULL, NULL, 'Upload Image', 'uploadPic' );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'upload_f2.png', '/administrator/images/', NULL, NULL, 'Upload Image', 'uploadPic', 0 );
		?>
		<td>
		<a class="toolbar" href="#" onclick="popupWindow('popups/uploadimage.php?directory=<?php echo $directory; ?>&t=<?php echo $cur_template; ?>','win1',250,100,'no');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('uploadPic','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
<?php echo $adminLanguage->A_UPLOAD;?>
		</a>
		</td>
		<?php
	}

	/**
	* Writes a spacer cell
	* @param string The width for the cell
	*/
	function spacer( $width='' ) { 
		?>
		<td width="<?php echo $width;?>">&nbsp;</td>
		<?php
	}

	/**
	* Writes the end of the menu bar table
	*/
	function endTable() { 
		?>
		</tr>
		</table>
		<?php
	}
}
?>
