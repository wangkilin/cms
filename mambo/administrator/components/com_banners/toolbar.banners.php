<?php
/**
* @version $Id: toolbar.banners.php,v 1.7 2004/08/26 05:20:37 rcastley Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );
require_once( $mainframe->getPath( 'toolbar_default' ) );

switch ($task) {

	case "newclient":
	case "editclient":
		TOOLBAR_bannerClient::_EDIT();
		break;

	case "listclients":
		TOOLBAR_bannerClient::_DEFAULT();
		break;

	case "new":
	case "edit":
		TOOLBAR_banners::_EDIT();
		break;

	default:
		TOOLBAR_banners::_DEFAULT();
		break;
}
?>