<?php
/**
* @version $Id: wrapper.menu.php,v 1.1 2004/09/06 17:16:11 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$types[] = mosHTML::makeOption( 'wrapper', 'Wrapper' );

$reqpath = $mosConfig_absolute_path .'/administrator/components/com_menus/wrapper';
require_once( $reqpath. '/wrapper.class.php' );
require_once( $reqpath. '/wrapper.menu.html.php' );

switch ( $task ) {
	case 'wrapper':
		// this is the new item, ie, the same name as the menu `type`
		wrapper_menu::edit( 0, $menutype, $option );
		break;
	case 'edit':
		wrapper_menu::edit( $cid[0], $menutype, $option );
		break;
	case 'save':
		wrapper_menu::saveMenu( $option );
		break;
}
?>
