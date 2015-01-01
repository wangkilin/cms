<?php
/**
* @version $Id: newsfeed_category_table.menu.php,v 1.1 2004/09/22 21:08:07 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

//$types[] = mosHTML::makeOption( 'new_item', 'Content Item' );
$types[] = mosHTML::makeOption( 'newsfeed_category_table', 'Table - <?php echo $adminLanguage->A_COMP_MENUS_NEWSFEED;?> Category' );

$reqpath = "$mosConfig_absolute_path/administrator/components/com_menus/newsfeed_category_table";
require_once( "$reqpath/newsfeed_category_table.class.php" );
require_once( "$reqpath/newsfeed_category_table.menu.html.php" );

switch ($task) {
	case "newsfeed_category_table":
		// this is the new item, ie, the same name as the menu `type`
		newsfeed_category_table_menu::editCategory( 0, $menutype, $option );
		break;

	case "edit":
		newsfeed_category_table_menu::editCategory( $cid[0], $menutype, $option );
		break;

	case "save":
		// no special handling
		saveMenu( $option );
		break;

	case "publish":
	case "unpublish":
		// no special action
		break;

	case "remove":
		// no special action
		break;
}
?>
