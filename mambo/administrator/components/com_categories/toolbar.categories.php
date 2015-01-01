<?php
/**
* @version $Id: toolbar.categories.php,v 1.3 2004/08/26 05:20:37 rcastley Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ($task){
	case "new":
		TOOLBAR_categories::_NEW();
		break;

	case "edit":
		TOOLBAR_categories::_EDIT();
		break;

	case "moveselect":
		TOOLBAR_categories::_MOVE();
		break;

	case "copyselect":
		TOOLBAR_categories::_COPY();
		break;

	default:
		TOOLBAR_categories::_DEFAULT();
		break;
}
?>