<?php
/**
* @version $Id: content_blog_category.menu.html.php,v 1.25 2004/09/23 23:57:38 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Writes the edit form for new and existing content item
*
* A new record is defined when <var>$row</var> is passed with the <var>id</var>
* property set to 0.
* @package Mambo_4.5.1
* @param mosContent The category object
*/

class content_blog_category_html { 


function edit( &$menu, &$lists, &$params, $option ) {
	/* in the HTML below, references to "section" were changed to "category" */
	global $mosConfig_live_site, $adminLanguage;
	$tabs = new mosTabs(0);
	?>
	<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
	<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		var form = document.adminForm;
		<?php 
		if ( !$menu->id ) {
			?>
			if ( form.name.value == '' ) {
				alert( 'This Menu item must have a title' );
				return;
			} else {
				submitform( pressbutton );
			}
			<?php
		} else {
			?>
			if ( form.name.value == '' ) {
				alert( 'This Menu item must have a title' );
			} else {
				submitform( pressbutton );
			}
			<?php
		}
		?>
	}
	</script>
	
	<form action="index2.php" method="post" name="adminForm">

	<table class="adminheading">
	<tr>
		<th>
		<?php echo $menu->id ? $adminLanguage->A_EDIT : $adminLanguage->A_COMP_ADD;?> <?php echo $adminLanguage->A_COMP_MENUS_MENU_ITEM;?> :: <?php echo $adminLanguage->A_COMP_MENUS_BLOG;?> - <?php echo $adminLanguage->A_COMP_MENUS_CONT_CAT_MULTI;?>
		</th>
	</tr>
	</table>

	<?php
	$tabs->startPane("module");
	$tabs->startTab($adminLanguage->A_DETAILS,"Details-page");
	?>
	<table class="adminform">
	<tr>
		<td width="10%" align="right"><?php echo $adminLanguage->A_COMP_NAME;?>:</td>
		<td width="200px">
		<input class="inputbox" type="text" name="name" size="30" maxlength="100" value="<?php echo $menu->name; ?>" />
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right"><?php echo $adminLanguage->A_COMP_CATEG;?>:</td>
		<td colspan="2">
		<?php echo $lists['categoryid']; ?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo $adminLanguage->A_COMP_ADMIN_URL;?>:</td>
		<td colspan="2">
		<?php echo $lists['link']; ?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo $adminLanguage->A_COMP_MENUS_CIL_PARENT;?>:</td>
		<td colspan="2">
		<?php echo $lists['parent'];?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right"><?php echo $adminLanguage->A_COMP_ORDERING;?>:</td>
		<td colspan="2">
		<?php echo $lists['ordering']; ?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right"><?php echo $adminLanguage->A_COMP_ACCESS_LEVEL;?>:</td>
		<td colspan="2">
		<?php echo $lists['access']; ?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right"><?php echo $adminLanguage->A_COMP_PUBLISHED;?>:</td>
		<td colspan="2">
		<?php echo $lists['published']; ?>
		</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	</table>
	<?php
	$tabs->endTab();
	$tabs->startTab($adminLanguage->A_COMP_CONT_PARAMETERS,"params-page");
	?>
	<table class="adminform">
	<tr>
		<td>
			<?php echo $params->render();?>
		</td>
	</tr>
	</table>
	<?php
	$tabs->endTab();
	$tabs->endPane();
	?>
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="id" value="<?php echo $menu->id; ?>" />
	<input type="hidden" name="menutype" value="<?php echo $menu->menutype; ?>" />
	<input type="hidden" name="type" value="<?php echo $menu->type; ?>" />
	<input type="hidden" name="link" value="index.php?option=com_content&task=blogcategory&id=0" />
	<input type="hidden" name="componentid" value="0" />
	<input type="hidden" name="task" value="" />
	</form>
	<script language="Javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
	<?php
}

}
?>
