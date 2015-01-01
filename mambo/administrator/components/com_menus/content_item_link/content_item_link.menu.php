<?php
/**
* @version $Id: content_item_link.menu.php,v 1.6 2004/09/06 12:24:04 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$types[] = mosHTML::makeOption( 'content_item_link', 'Link - Content Item' );

$reqpath = $mosConfig_absolute_path .'/administrator/components/com_menus/content_item_link';
require_once( $reqpath. '/content_item_link.class.php' );
require_once( $reqpath. '/content_item_link.menu.html.php' );

switch ( $task ) {
	case 'content_item_link':
	// this is the new item, ie, the same name as the menu `type`
	content_item_link_menu::edit( 0, $menutype, $option );
	break;

	case 'edit':
	content_item_link_menu::edit( $cid[0], $menutype, $option );
	break;

	case 'save':
	saveMenu( $option );
	break;
}
?>
