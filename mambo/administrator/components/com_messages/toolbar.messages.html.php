<?php
/**
* @version $Id: toolbar.messages.html.php,v 1.9 2004/09/03 01:41:07 eddieajau Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo_4.5.1
*/
class TOOLBAR_messages {
	function _VIEW() {
		mosMenuBar::startTable();
		mosMenuBar::back();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	function _EDIT() {
		mosMenuBar::startTable();
		mosMenuBar::save( 'save', 'Send' );
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::help( 'sect.messages.edit' );
		mosMenuBar::endTable();
	}
	
	function _CONFIG() {
		mosMenuBar::startTable();
		mosMenuBar::save( 'saveconfig' );
		mosMenuBar::cancel( 'cancelconfig' );
		mosMenuBar::help( 'sect.messages.conf' );
		mosMenuBar::endTable();
	}

	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::addNew();
		//mosMenuBar::editList();
		mosMenuBar::deleteList();
		mosMenuBar::help( 'sect.messages.inbox' );
		mosMenuBar::endTable();
	}
}
?>