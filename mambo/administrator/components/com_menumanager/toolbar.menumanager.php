<?php
/**
* @version $Id: toolbar.menumanager.php,v 1.4 2004/09/19 18:17:37 akede Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );
//require_once( $mainframe->getPath( 'toolbar_default' ) );

$act = mosGetParam( $_REQUEST, 'act', '' );
if ($act) {
	$task = $act;
}

switch ($task) {
	case "new":
	case "edit":
		TOOLBAR_menumanager::_NEWMENU();
		break;

	case "copyconfirm":
		TOOLBAR_menumanager::_COPYMENU();
		break;

	case "deleteconfirm":
		TOOLBAR_menumanager::_DELETE();
		break;

	default:
		TOOLBAR_menumanager::_DEFAULT();
		break;
}
?>