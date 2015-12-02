<?php
/**
* @version $Id: url.menu.php,v 1.6 2004/09/06 12:24:05 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$types[] = mosHTML::makeOption( 'url', 'Link - URL' );

$reqpath = "$mosConfig_absolute_path/administrator/components/com_menus/url";
require_once( "$reqpath/url.class.php" );
require_once( "$reqpath/url.menu.html.php" );

switch ($task) {
	case "url":
		// this is the new item, ie, the same name as the menu `type`
		url_menu::edit( 0, $menutype, $option );
		break;

	case "edit":
		url_menu::edit( $cid[0], $menutype, $option );
		break;

	case "save":
		// no special handling
		saveMenu( $option );
		break;

	// no special action for other tasks
}
?>
