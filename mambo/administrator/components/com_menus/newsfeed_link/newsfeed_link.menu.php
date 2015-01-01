<?php
/**
* @version $Id: newsfeed_link.menu.php,v 1.1 2004/09/20 22:52:48 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$types[] = mosHTML::makeOption( 'newsfeed_link', 'Link - <?php echo $adminLanguage->A_COMP_MENUS_NEWSFEED;?>' );

$reqpath = $mosConfig_absolute_path .'/administrator/components/com_menus/newsfeed_link';
require_once( $reqpath. '/newsfeed_link.class.php' );
require_once( $reqpath. '/newsfeed_link.menu.html.php' );

switch ( $task ) {
	case 'newsfeed_link':
	// this is the new item, ie, the same name as the menu `type`
	newsfeed_link_menu::edit( 0, $menutype, $option );
	break;

	case 'edit':
	newsfeed_link_menu::edit( $cid[0], $menutype, $option );
	break;

	case 'save':
	saveMenu( $option );
	break;
}
?>
