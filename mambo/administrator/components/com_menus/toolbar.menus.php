<?php
/**
* @version $Id: toolbar.menus.php,v 1.7 2004/08/26 05:20:43 rcastley Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );
require_once( $mainframe->getPath( 'toolbar_default' ) );

$cid = mosGetParam($_POST,'cid');
switch ($task) {

	case "new":
		TOOLBAR_menus::_NEW();
		break;

	case "movemenu":
		TOOLBAR_menus::_MOVEMENU();
		break;

	case "copymenu":
		TOOLBAR_menus::_COPYMENU();
		break;

	case "edit":
		if ($cid[0]) {
			$database->setQuery( "SELECT type FROM #__menu WHERE id=$cid[0]" );

			if ($type = $database->loadResult()) {
				if (file_exists( "$mosConfig_absolute_path/administrator/components/com_menus/$type/$type.menubar.php" )) {
					require_once( "$mosConfig_absolute_path/administrator/components/com_menus/$type/$type.menubar.php" );
				} else {
					TOOLBAR_menus::_EDIT();
				}
				//require ("menubar/$type.php");
			} else {
				echo $database->stderr();
			}
		} else {
			if ($type = mosGetParam( $_REQUEST, 'type', null )) {
				if (file_exists( "$mosConfig_absolute_path/administrator/components/com_menus/$type/$type.menubar.php" )) {
					require_once( "$mosConfig_absolute_path/administrator/components/com_menus/$type/$type.menubar.php" );
				} else {
					TOOLBAR_menus::_EDIT();
				}
				//require ("menubar/$type.php");
			} else {
				TOOLBAR_menus::_EDIT();
			}
		}
		//menuMenusections::EDIT_MENU( $comcid, $type, $published );
		break;

	case "cancel":
		// no menu bar as page in immediately refreshed
		break;

	default:
		$type = trim( mosGetParam( $_REQUEST, 'type', null ) );
		if ($type) {
			if (file_exists( "$mosConfig_absolute_path/administrator/components/com_menus/$type/$type.menubar.php" )) {
				require_once( "$mosConfig_absolute_path/administrator/components/com_menus/$type/$type.menubar.php" );
			} else {
				TOOLBAR_menus::_DEFAULT();
			}
		} else {
			TOOLBAR_menus::_DEFAULT();
		}
		break;
}
?>
