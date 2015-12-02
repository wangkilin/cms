<?php
/**
* @version $Id: admin.menus.html.php,v 1.1 2004/10/04 15:06:18 dappa Exp $
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
class HTML_menusections {

	function showMenusections( $rows, $pageNav, $search, $levellist, $menutype, $option ) {
		global $my;
		global $mosConfig_live_site, $adminLanguage;
		?>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th class="menus">
			<?php echo $adminLanguage->A_MENU_MANAGER;?> / <?php echo $menutype;?>
			</th>
			<td nowrap="true">
			<?php echo $adminLanguage->A_COMP_MENUS_MAX_LVLS;?>
			</td>
			<td>
			<?php echo $levellist;?>
			</td>
			<td>
			<?php echo $adminLanguage->A_COMP_MESS_SEARCH;?>:
			</td>
			<td>
			<input type="text" name="search" value="<?php echo $search;?>" class="inputbox" />
			</td>
		</tr>
		</table>
	
		<table class="adminlist">
		<tr>
			<th width="20">
			#
			</th>
			<th width="20"> 
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" />
			</th>
			<th class="title" width="40%">
			<?php echo $adminLanguage->A_COMP_MENUS_MENU_ITEM;?>
			</th>
			<th width="5%">
			<?php echo $adminLanguage->A_COMP_PUBLISHED;?>
			</th>
			<th colspan="2" width="5%">
			<?php echo $adminLanguage->A_COMP_REORDER;?>
			</th>
			<th width="10%">
			<?php echo $adminLanguage->A_COMP_ACCESS;?>
			</th>
			<th width="20%" align="left">
			<?php echo $adminLanguage->A_COMP_TYPE;?>
			</th>
			<th width="10%">
			<?php echo $adminLanguage->A_COMP_CHECKED_OUT;?>
			</th>
		</tr>
	    <?php
		$k = 0;
		$i = 0;
		$n = count( $rows );
		foreach ($rows as $row) {
			$task = $row->published ? 'unpublish' : 'publish';
			$alt = $row->published ? 'Published' : 'Unpublished';
			if ( !$row->access ) {
				$color_access = 'style="color: green;"';
				$task_access = 'accessregistered';
			} else if ( $row->access == 1 ) {
				$color_access = 'style="color: red;"';
				$task_access = 'accessspecial';
			} else {
				$color_access = 'style="color: black;"';
				$task_access = 'accesspublic';
			}	
			$img = $row->published ? 'tick.png' : 'publish_x.png';
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $i + 1 + $pageNav->limitstart;?>
				</td>
				<td><?php echo mosHTML::idBox( $i, $row->id, ($row->checked_out && $row->checked_out != $my->id ) ); ?></td>
				<td nowrap="nowrap">
				<?php
				if ( $row->checked_out && ( $row->checked_out != $my->id ) ) {
					?>
<?php echo $row->treename; ?>
					&nbsp;[ <i><?php echo $adminLanguage->A_COMP_CHECKED_OUT;?></i> ]
					<?php
				} else {
					?>
					<a href="#edit" onclick="return listItemTask('cb<?php echo $i;?>','edit')">
					<?php echo $row->treename; ?>
					</a>
					<?php
				}
				?>
				</td>
				<td width="10%" align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
				<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
				</a>
				</td>
				<td><?php echo $pageNav->orderUpIcon( $i ); ?></td>
				<td><?php echo $pageNav->orderDownIcon( $i, $n ); ?></td>
				<td align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task_access;?>')" <?php echo $color_access; ?>>
				<?php echo $row->groupname;?>
				</a>
				</td>
				<td align="left">
				<?php echo $row->type;?> 
				</td>
				<td align="center">
				<?php echo $row->editor;?>&nbsp;
				</td>
		    </tr>
			<?php
			$k = 1 - $k;
			$i++;
		}
		?>
		</table>
		<?php echo $pageNav->getListFooter(); ?>
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="menutype" value="<?php echo $menutype; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		</form>
		<script language="Javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
		<?php
	}
	
	
	/**
	* Displays a selection list for menu item types
	*/
	function addMenuItem( &$cid, $lists, $menutype, $option ) {
		global $adminLanguage;
		
		$limit		= intval( mosGetParam( $_REQUEST, 'limit', 10 ) );
		$limitstart	= intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
		$levellimit	= intval( mosGetParam( $_REQUEST, 'levellimit', 0 ) );
		?>
		<script language="javascript">
		<!--
		function checkstep1( form ) {
			if (document.adminForm.type.selectedIndex < 0) {
				alert('<?php echo $adminLanguage->A_COMP_SELECT_MENU_TYPE;?>.');
			} else {
				document.adminForm.action = 'index2.php';
				document.adminForm.submit(form);
			}
		}
		//-->
		function submitbutton(pressbutton) {
			var form = document.adminForm;
	
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
	
			// do field validation
			if (form.type.value == ""){
				alert( "<?php echo $adminLanguage->A_COMP_SELECT_MENU_TYPE;?>" );
			} else {
				submitform( pressbutton );
			}
		}
		</script>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>
			<?php echo $adminLanguage->A_COMP_MENUS_ADD_ITEM;?>
			</th>
		</tr>
		</table>
	
		<table class="adminform">
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td width="20%" align="left" valign="top">
			<?php echo $adminLanguage->A_COMP_MENUS_SELECT_ADD;?>:
			</td>
			<td width="80%"> 
			<?php echo $lists['select'];?> 
		</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<input type="button" value="<?php echo $adminLanguage->A_COMP_MENUS_NEXT;?>" onClick="checkstep1(this.form);" class="button" />
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		</table>
	
		<input type="hidden" name="parent" value="<?php echo $cid[0]; ?>" />
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="menutype" value="<?php echo $menutype; ?>" />
		<input type="hidden" name="limit" value="<?php echo $limit;?>" />
		<input type="hidden" name="limitstart" value="<?php echo $limitstart;?>" />
		<input type="hidden" name="levellimit" value="<?php echo $levellimit;?>" />
		<input type="hidden" name="task" value="edit" />
		<input type="hidden" name="boxchecked" value="1" />
		</form>
		<?php 
	}
	
	
	/**
	* Form to select Menu to move menu item(s) to
	*/
	function moveMenu( $option, $cid, $MenuList, $items, $menutype  ) {
		global $adminLanguage;
		?>
		<form action="index2.php" method="post" name="adminForm">
		<br />
		<table class="adminheading">
		<tr>
			<th>
			<?php echo $adminLanguage->A_COMP_MENUS_MOVE_ITEMS;?>
			</th>
		</tr>
		</table>
		
		<br />
		<table class="adminform">
		<tr>
			<td width="3%"></td>
			<td align="left" valign="top" width="30%">
			<strong><?php echo $adminLanguage->A_COMP_MENUS_MOVE_MENU;?>:</strong>
			<br />
			<?php echo $MenuList ?>
			<br /><br />
			</td>
			<td align="left" valign="top">
			<strong>
			<?php echo $adminLanguage->A_COMP_MENUS_BEING_MOVED;?>:
			</strong>
			<br />
			<ol>
			<?php
			foreach ( $items as $item ) {
				?>
				<li>
				<?php echo $item->name; ?>
				</li>
				<?php
			}
			?>
			</ol>
			</td>
		</tr>
		</table>
		<br /><br />
		
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="sectionid" value="<?php echo $sectionid; ?>" />
		<input type="hidden" name="boxchecked" value="1" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="menutype" value="<?php echo $menutype; ?>" />
		<?php
		foreach ( $cid as $id ) {
			echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
		}
		?>
		</form>
		<?php
	}
	
	
	/**
	* Form to select Menu to copy menu item(s) to
	*/
	function copyMenu( $option, $cid, $MenuList, $items, $menutype  ) {
		global $adminLanguage;
		?>
		<form action="index2.php" method="post" name="adminForm">
		<br />
		<table class="adminheading">
		<tr>
			<th>
			<?php echo $adminLanguage->A_COMP_CONTENT_BAR_COPY;?> <?php echo $adminLanguage->A_COMP_TRASH_MENU_ITEMS;?>
			</th>
		</tr>
		</table>
		
		<br />
		<table class="adminform">
		<tr>
			<td width="3%"></td>
			<td align="left" valign="top" width="30%">
			<strong>
			<?php echo $adminLanguage->A_COMP_MENUS_COPY_MENU;?>:
			</strong>
			<br />
			<?php echo $MenuList ?>
			<br /><br />
			</td>
			<td align="left" valign="top">
			<strong>
			<?php echo $adminLanguage->A_COMP_MENUS_BEING_COPIED;?>:
			</strong>
			<br />
			<ol>
			<?php
			foreach ( $items as $item ) {
				?>
				<li>
				<?php echo $item->name; ?>
				</li>
				<?php
			}
			?>
			</ol>
			</td>
		</tr>
		</table>
		<br /><br />
		
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="sectionid" value="<?php echo $sectionid; ?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="menutype" value="<?php echo $menutype; ?>" />
		<?php
		foreach ( $cid as $id ) {
			echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
		}
		?>
		</form>
		<?php
	}


}
?>
