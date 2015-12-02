<?php
/**
* @version $Id: component_item_link.menu.html.php,v 1.1 2004/10/04 16:20:57 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Display Component item link
* @package Mambo_4.5.1
*/
class component_item_link_menu_html {


function edit( &$menu, &$lists, &$params, $option ) {
	global $mosConfig_live_site, $adminLanguage;
	$tabs = new mosTabs(0);
	?>
	<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
	<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if ( pressbutton == 'cancel' ) {
			submitform( pressbutton );
			return;
		}
	
		// do field validation
		if ( trim(form.name.value) == "" ){
			alert( "<?php echo $adminLanguage->A_COMP_MENUS_CIL_LINK_NAME;?>" );
		} else if ( trim( form.link.value ) == "" ){
			alert( "<?php echo $adminLanguage->A_COMP_MENUS_CIL_SELECT_COMP;?>" );
		} else {
			submitform( pressbutton );
		}
	}
	</script>
	
	<form action="index2.php" method="post" name="adminForm">
	<table class="adminheading">
	<tr> 
		<th>
		<?php echo $menu->id ? $adminLanguage->A_EDIT : $adminLanguage->A_COMP_ADD;?> <?php echo $adminLanguage->A_COMP_MENUS_MENU_ITEM;?> :: <?php echo $adminLanguage->A_COMP_MENUS_LINK.$adminLanguage->A_COMP_MENUS_COMP_ITEM;?>
		</th>
	</tr>
	</table>
	
	<?php
	$tabs->startPane("module");
	$tabs->startTab($adminLanguage->A_DETAILS,"Details-page");
	?>
	<table class="adminform">
	<tr>
		<td width="10%" align="right">
		<?php echo $adminLanguage->A_COMP_NAME;?>:
		</td>
		<td width="80%">
		<input class="inputbox" type="text" name="name" size="50" maxlength="100" value="<?php echo $menu->name; ?>" />
		</td>
	</tr>
	<tr>
		<td width="10%" align="right" valign="top">
		<?php echo $adminLanguage->A_COMP_MENUS_CIL_LINK_COMP;?>:
		</td>
		<td width="80%">
		<?php echo $lists['components']; ?>
		</td>
	</tr>
	<tr>
		<td width="10%" align="right"><?php echo $adminLanguage->A_COMP_MENUS_URL;?>:</td>
		<td width="80%">
		<?php echo $lists['link']; ?>
		</td>
	</tr>
	<tr>
		<td width="10%" align="right" valign="top">
		<?php echo $adminLanguage->A_COMP_MENUS_CIL_ON_CLICK;?>:
		</td>
		<td width="80%">
		<?php echo $lists['target']; ?>
		</td>
	</tr>
	<tr>
		<td align="right">
		<?php echo $adminLanguage->A_COMP_MENUS_CIL_PARENT;?>:
		</td>
		<td>
		<?php echo $lists['parent']; ?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
		<?php echo $adminLanguage->A_COMP_ORDERING;?>:
		</td>
		<td>
		<?php echo $lists['ordering']; ?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
		<?php echo $adminLanguage->A_COMP_ACCESS_LEVEL;?>:
		</td>
		<td>
		<?php echo $lists['access']; ?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right"><?php echo $adminLanguage->A_COMP_PUBLISHED;?>:</td>
		<td>
		<?php echo $lists['published']; ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
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
	<input type="hidden" name="task" value="" />
	</form>
	<script language="Javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
	<?php
}

}
?>
