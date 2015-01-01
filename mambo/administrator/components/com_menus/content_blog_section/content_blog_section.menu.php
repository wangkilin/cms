<?php
/**
* @version $Id: content_blog_section.menu.php,v 1.8 2004/09/23 23:57:38 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

//$types[] = mosHTML::makeOption( 'new_item', 'Content Item' );
$types[] = mosHTML::makeOption( 'content_blog_section', 'Blog  - <?php echo $adminLanguage->A_COMP_MENUS_CONT_SEC;?> Multi' );

$reqpath = "$mosConfig_absolute_path/administrator/components/com_menus/content_blog_section";
require_once( "$reqpath/content_blog_section.class.php" );
require_once( "$reqpath/content_blog_section.menu.html.php" );

switch ($task) {
	case "content_blog_section":
		// this is the new item, ie, the same name as the menu `type`
		content_blog_section::edit( 0, $menutype, $option );
		break;

	case "edit":
		content_blog_section::edit( $cid[0], $menutype, $option );
		break;

	case "save":
		// no special handling
		content_blog_section::saveMenu( $option );
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
