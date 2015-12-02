<?php
/**
* @version $Id: content_typed.menu.php,v 1.9 2004/09/06 12:24:05 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

//$types[] = mosHTML::makeOption( 'new_item', 'Content Item' );
$types[] = mosHTML::makeOption( 'content_typed', 'Link - Static Content Item' );

$reqpath = "$mosConfig_absolute_path/administrator/components/com_menus/content_typed";
require_once( "$reqpath/content_typed.class.php" );
require_once( "$reqpath/content_typed.menu.html.php" );

$cid = mosGetParam( $_POST, 'cid', array(0) );
if (!is_array( $cid )) {
	$cid = array(0);
}

switch ($task) {
	case "content_typed":
		// this is the new item, ie, the same name as the menu `type`
		content_typed_menu::edit( 0, $menutype, $option );
		break;
	case "edit":
		content_typed_menu::edit( $cid[0], $menutype, $option );
		break;
	case 'save':
		saveMenu( $option );
		break;
}
?>
