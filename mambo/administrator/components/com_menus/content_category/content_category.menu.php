<?php
/**
* @version $Id: content_category.menu.php,v 1.8 2004/09/06 12:24:04 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

//$types[] = mosHTML::makeOption( 'new_item', 'Content Item' );
$types[] = mosHTML::makeOption( 'content_category', 'Category Table' );

$reqpath = "$mosConfig_absolute_path/administrator/components/com_menus/content_category";
require_once( "$reqpath/content_category.class.php" );
require_once( "$reqpath/content_category.menu.html.php" );

switch ($task) {
	case "content_category":
		// this is the new item, ie, the same name as the menu `type`
		content_category_menu::editCategory( 0, $menutype, $option );
		break;

	case "edit":
		content_category_menu::editCategory( $cid[0], $menutype, $option );
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
