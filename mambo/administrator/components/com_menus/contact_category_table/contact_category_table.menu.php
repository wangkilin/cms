<?php
/**
* @version $Id: contact_category_table.menu.php,v 1.1 2004/09/21 18:28:41 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

//$types[] = mosHTML::makeOption( 'new_item', 'Content Item' );
$types[] = mosHTML::makeOption( 'contact_category_table', 'Category Table' );

$reqpath = "$mosConfig_absolute_path/administrator/components/com_menus/contact_category_table";
require_once( "$reqpath/contact_category_table.class.php" );
require_once( "$reqpath/contact_category_table.menu.html.php" );

switch ($task) {
	case "contact_category_table":
		// this is the new item, ie, the same name as the menu `type`
		contact_category_table_menu::editCategory( 0, $menutype, $option );
		break;

	case "edit":
		contact_category_table_menu::editCategory( $cid[0], $menutype, $option );
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
