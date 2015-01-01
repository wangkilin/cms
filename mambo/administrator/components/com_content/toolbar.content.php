<?php
/**
* @version $Id: toolbar.content.php,v 1.6 2004/09/17 01:58:28 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ($task) {
	case "new":
	case "new_content_typed":
	case "new_content_section":
		TOOLBAR_content::_NEW();
		break;

	case "edit":
	case "editA":
	case "edit_content_typed":
		TOOLBAR_content::_EDIT( );
		break;

	case "showarchive":
		TOOLBAR_content::_ARCHIVE();
		break;

	case "movesect":
		TOOLBAR_content::_MOVE();
		break;

	case "copy":
		TOOLBAR_content::_COPY();
		break;

	default:
		TOOLBAR_content::_DEFAULT();
		break;
}
?>