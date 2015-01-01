<?php
/**
* @version $Id: toolbar.typedcontent.php,v 1.2 2004/09/17 01:58:28 stingrey Exp $
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
		TOOLBAR_typedcontent::_NEW();
		break;

	case "edit":
	case "editA":
		TOOLBAR_typedcontent::_EDIT( );
		break;

	default:
		TOOLBAR_typedcontent::_DEFAULT();
		break;
}
?>