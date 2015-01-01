<?php
/**
* @version $Id: toolbar.newsfeeds.php,v 1.6 2004/08/26 05:20:47 rcastley Exp $
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
		TOOLBAR_newsfeeds::_NEW();
		break;
	case "edit":
		TOOLBAR_newsfeeds::_EDIT();
		break;
	default:
		TOOLBAR_newsfeeds::_DEFAULT();
		break;
}
?>