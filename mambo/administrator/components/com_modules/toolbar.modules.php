<?php
/**
* @version $Id: toolbar.modules.php,v 1.4 2004/09/02 12:21:49 eddieajau Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( "toolbar_html" ) );
switch ($task) {

	case "edit":
		$cid = mosGetParam( $_POST, "cid", array() );

		$published = 0;
		if (@$cid[0]){
			$database->setQuery( "SELECT published FROM #__modules WHERE id='$cid[0]'" );
			$published = $database->loadResult();
		}

		$cur_template = $mainframe->getTemplate();

		TOOLBAR_modules::_EDIT( $cur_template, $published );
		break;

	case "new":
		TOOLBAR_modules::_NEW();
		break;

	default:
		TOOLBAR_modules::_DEFAULT();
		break;
}
?>