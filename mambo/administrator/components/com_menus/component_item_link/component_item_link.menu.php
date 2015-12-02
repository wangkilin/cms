<?php
/**
* @version $Id: component_item_link.menu.php,v 1.1 2004/10/04 16:20:57 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$types[] = mosHTML::makeOption( 'component_item_link',$adminLanguage->A_COMP_MENUS_LINK.$adminLanguage->A_COMP_MENUS_COMP_ITEM );

$reqpath = $mosConfig_absolute_path .'/administrator/components/com_menus/component_item_link';
require_once( $reqpath .'/component_item_link.class.php' );
require_once( $reqpath .'/component_item_link.menu.html.php' );

switch ( @$task ) {
	case 'component_item_link':
	// this is the new item, ie, the same name as the menu `type`
	component_item_link_menu::edit( 0, $menutype, $option );
	break;

	case 'edit':
	component_item_link_menu::edit( $cid[0], $menutype, $option );
	break;

	case 'save':
	saveMenu( $option );
	break;
}
?>
