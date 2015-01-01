<?php
/**
* @version $Id: toolbar.mambots.html.php,v 1.3 2004/09/06 21:03:37 rcastley Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/**
* @package Mambo_4.5.1
*/
class TOOLBAR_modules {
	/**
	* Draws the menu for Editing an existing module
	*/
	function _EDIT() {
		mosMenuBar::startTable();
		mosMenuBar::save();
		mosMenuBar::cancel();
		mosMenuBar::endTable();
	}
	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::publishList();
		mosMenuBar::unpublishList();
		mosMenuBar::addNew();
		mosMenuBar::editList();
		mosMenuBar::deleteList();
		mosMenuBar::help( 'sect.mambots' );
		mosMenuBar::endTable();
	}
}
?>
