<?php
/**
* @version $Id: admin.menumanager.html.php,v 1.3 2004/10/11 03:36:33 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* HTML class for all menumanager component output
* @package Mambo_4.5.1
*/
class HTML_menumanager {
	/**
	* Writes a list of the menumanager items
	*/
	function show ( $option, $menus, $pageNav ) {
		global $adminLanguage;
        ?>
		<script language="javascript" type="text/javascript">
		function menu_listItemTask( id, task, option ) {
			var f = document.adminForm;
			cb = eval( 'f.' + id );
			if (cb) {
				cb.checked = true;
				submitbutton(task);
			}
			return false;
		}
		</script>
	
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th class="menus">
			<?php echo $adminLanguage->A_MENU_MANAGER;?>
			</th>
		</tr>
		</table>
	
		<table class="adminlist">
		<tr>
			<th width="20"><?php echo $adminLanguage->A_COMP_NB;?></th>
			<th width="20">&nbsp;</th>
			<th width="20px">&nbsp;</th>
			<th width="20%"  nowrap="true" align="<?php echo ($adminLanguage->RTLsupport ? 'right' : 'left'); ?>"> <!-- rtl change -->
			<?php echo $adminLanguage->A_COMP_MENU_NAME;?>
			</th>
			<th class="title" width="20%" nowrap="true">
			<?php echo $adminLanguage->A_COMP_MENU_TYPE;?>
			</th>
			<th width="5%" nowrap="true">
			<?php echo $adminLanguage->A_COMP_MENU_ID;?>
			</th>
			<th width="5%">
			<?php echo $adminLanguage->A_MENU_ITEMS;?>
			</th>
			<th width="50%">&nbsp;</th>
		</tr>
		<?php
		$k = 0;
		$i = 0;
		$n = count( $menus );
		foreach ( $menus as $menu ) {
			?>
			<tr class="<?php echo "row". $k; ?>">
				<td align="center" width="30px">
				<?php echo $i + 1 + $pageNav->limitstart;?>
				</td>
				<td width="30px" align="center">
				<input type="radio" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $menu->id; ?>" onclick="isChecked(this.checked); " />
				</td>
				<td width="20px"></td>
				<td align="<?php echo ($adminLanguage->RTLsupport ? 'right' : 'left'); ?>"> <!-- rtl change -->
				<?php
				if ( @!$menu->title ) {
					?>
					<small><?php echo $adminLanguage->A_COMP_MENU_ASSIGN;?></small>
					<?php
				} else {
					?>
					<a href="#edit" onClick="return listItemTask('cb<?php echo $i;?>','edit')">
					<?php
					echo $menu->title;
					?>
					</a>
					<?php
				}
				?>
				</td>
				<td>
					<a href="index2.php?option=com_menus&menutype=<?php echo $menu->type; ?>">
					<?php
				echo $menu->type;
					?>
					</a>
				</td>
				<td align="center">
				<?php
					?>
					<a href="index2.php?option=com_modules&task=edit&moduleid=<?php echo $menu->id;?>">
					<?php
				echo $menu->id;
					?>
					</a>
					<?php
				?>
				</td>
				<td align="center">
				<?php
				echo $menu->num;
				?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<?php
			$k = 1 - $k;
			$i++;
		}
		?>
		</table>
		<?php echo $pageNav->getListFooter(); ?>
	
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		</form>
		<?php
	}


	/**
	* writes a form to take the name of the menu you would like created
	* @param option	display options for the form
	*/
	function edit ( &$row, $option ) {
		global $adminLanguage;
        ?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			if (pressbutton == 'savemenu') {
				if ( document.adminForm.title.value == '' ) {
					alert("<?php echo $adminLanguage->A_COMP_MENU_ENTER;?>");
					document.adminForm.title.focus();
				}
				else if ( document.adminForm.params.value == '' ) {
					alert("<?php echo $adminLanguage->A_COMP_MENU_ENTER_TYPE;?>");
					document.adminForm.params.focus();
				} else {
					submitform( 'savemenu' );
				}
			} else {
				submitform( pressbutton );
			}
		}
		</script>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th class="menus">
			<?php echo $adminLanguage->A_COMP_MENU_DETAILS;?>
			</th>
		</tr>
		</table>
	
		<table class="adminform">
		<tr height="45px;">
			<td width="100px" align="left">
			<strong><?php echo $adminLanguage->A_COMP_MENU_NAME;?>:</strong>
			</td>
			<td>
			<input class="inputbox" type="text" name="title" size="30" value="<?php echo $row->title ? $row->title : "";?>" />
			</td>
		<tr>
		<tr height="45px;">
			<td width="100px" align="left">
			<strong><?php echo $adminLanguage->A_COMP_MENU_TYPE;?>:</strong>
			</td>
			<td>
			<input class="inputbox" type="text" name="params" size="30" value="<?php echo isset($row->menutype) ? $row->menutype : ""; ?>" />
			</td>
		<tr>
		<tr>
			<td colspan="2">
			</td>
		<tr>
		</tr>
			<td colspan="2">
			<?php echo $adminLanguage->A_COMP_MENU_MAINMENU;?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			</td>
		<tr>
		</table>
		<br /><br />
	
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="iscore" value="<?php echo $row->iscore; ?>" />
		<input type="hidden" name="published" value="<?php echo $row->published; ?>" />
		<input type="hidden" name="position" value="<?php echo $row->position; ?>" />
		<input type="hidden" name="module" value="<?php echo $row->module; ?>" />

		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="savemenu" />
		<input type="hidden" name="boxchecked" value="0" />
		</form>
		<?php
		}
	
	
		/**
		* A delete confirmation page
		* Writes list of the items that have been selected for deletion
		*/
		function showDelete( $option, $cid, $type, $items, $module ) {
		    global $adminLanguage;
        ?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>
			<?php echo $adminLanguage->A_COMP_MENU_DEL;?>: <?php echo $module[0]->title;?>
			</th>
		</tr>
		</table>
	
		<br />
		<table class="adminform">
		<tr>
			<td width="3%"></td>
			<td align="left" valign="top" width="20%">
			<strong><?php echo $adminLanguage->A_COMP_MENU_MODULE_DEL;?>:</strong>
			<br />
			<font color="#000066"><strong><?php echo $module[0]->title; ?></strong></font>
			<br /><br />
			</td>
			<td align="left" valign="top" width="25%">
			<strong><?php echo $adminLanguage->A_COMP_MENU_ITEMS_DEL;?>:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $items as $item ) {
				echo "<li>". $item->name ."</li>";
			}
			echo "</ol>";
			?>
			</td>
			<td>
			<?php echo $adminLanguage->A_COMP_MENU_WILL;?> <strong><font color="#FF0000">
            <?php echo $adminLanguage->A_COMP_MEDIA_DEL;?></font></strong>
            <?php echo $adminLanguage->A_COMP_MENU_WILL2;?>
			<br /><br /><br />
			<div style="border: 1px dotted gray; width: 70px; padding: 10px; margin-left: 100px;">
			<a class="toolbar" href="javascript:if (confirm('<?php echo $adminLanguage->A_COMP_MENU_YOU_SURE;?>')){ submitbutton('deletemenu');}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('remove','','images/delete_f2.png',1);">
			<img name="remove" src="images/delete.png" alt="<?php echo $adminLanguage->A_COMP_MEDIA_DEL;?>" border="0" align="middle" />
			&nbsp;<?php echo $adminLanguage->A_COMP_MEDIA_DEL;?>
			</a>
			</div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		</table>
		<br /><br />
	
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="sectionid" value="<?php echo $sectionid; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="type" value="<?php echo $type; ?>" />
		<?php
		foreach ($cid as $id) {
			echo "\n<input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
		}
		?>
		<input type="hidden" name="boxchecked" value="1" />
		</form>
		<?php
	}


	/**
	* A copy confirmation page
	* Writes list of the items that have been selected for copy
	*/
	function showCopy( $option, $cid, $type, $items ) {
		global $adminLanguage;
        ?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			if (pressbutton == 'copymenu') {
				if ( document.adminForm.menu_name.value == '' ) {
					alert("<?php echo $adminLanguage->A_COMP_MENU_NAME_MENU;?>");
				} else {
					submitform( 'copymenu' );
				}
			} else {
				submitform( pressbutton );
			}
		}
		</script>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>
			<?php echo $adminLanguage->A_COMP_MENU_COPY;?>
			</th>
		</tr>
		</table>
	
		<br />
		<table class="adminform">
		<tr>
			<td width="3%"></td>
			<td align="left" valign="top" width="30%">
			<strong><?php echo $adminLanguage->A_COMP_MENU_NEW;?>:</strong>
			<br />
			<input class="inputbox" type="text" name="menu_name" size="30" value="" />
			<br /><br />
			<strong><?php echo $adminLanguage->A_COMP_MENU_COPIED;?>:</strong>
			<br />
			<font color="#000066"><strong><?php echo $type; ?></strong></font>
			<br /><br />
			</td>
			<td align="left" valign="top" width="25%">
			<strong><?php echo $adminLanguage->A_COMP_MENU_ITEMS_COPIED;?>:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $items as $item ) {
				echo "<li>". $item->name ." - ". $item->id ."</li>";
				echo "\n <input type=\"hidden\" name=\"mids[]\" value=\"$item->id\" />";
			}
			echo "</ol>";
			?>
			</td>
			<td valign="top">
            <?php echo $adminLanguage->A_COMP_MENU_MOD_MENU;?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		</table>
		<br /><br />
	
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="type" value="<?php echo $type; ?>" />
		<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
		</form>
		<?php
	}



}
?>
