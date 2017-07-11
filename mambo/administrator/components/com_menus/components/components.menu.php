<?php
/**
* @version $Id: components.menu.php,v 1.2 2004/10/13 08:43:04 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

//$types[] = mosHTML::makeOption( 'new_item', 'Content Item' );
$types[] = mosHTML::makeOption( 'components', $adminLanguage->A_COMP_MENUS_COMP );
$task = trim( mosGetParam( $_REQUEST, 'task', "" ) );
$menutype = trim( mosGetParam( $_REQUEST, 'menutype', "" ) );

$reqpath = "$mosConfig_absolute_path/administrator/components/com_menus/components";
require_once( "$reqpath/components.class.php" );
require_once( "$reqpath/components.menu.html.php" );

switch ($task) {
	case "components":
		// this is the new item, ie, the same name as the menu `type`
		components_menu::edit( 0, $menutype, $option );
		break;

	case "edit":
		components_menu::edit( $cid[0], $menutype, $option );
		break;

	case "save":
		// no special handling
		saveMenu( $option );
		break;

	// no special action for other tasks
}
?>
