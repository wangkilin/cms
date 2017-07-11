<?php
/**
* @version $Id: content_archive_section.menu.php,v 1.7 2004/09/06 12:24:04 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

//$types[] = mosHTML::makeOption( 'new_item', 'Content Item' );
$types[] = mosHTML::makeOption( 'content_archive_section', 'Section Archive Blog' );

$reqpath = "$mosConfig_absolute_path/administrator/components/com_menus/content_archive_section";
require_once( "$reqpath/content_archive_section.class.php" );
require_once( "$reqpath/content_archive_section.menu.html.php" );

switch ($task) {
	case "content_archive_section":
		// this is the new item, ie, the same name as the menu `type`
		content_archive_section_menu::editSection( 0, $menutype, $option );
		break;

	case "edit":
		content_archive_section_menu::editSection( $cid[0], $menutype, $option );
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
