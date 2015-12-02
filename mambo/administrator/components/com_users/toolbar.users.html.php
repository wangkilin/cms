<?php
/**
* @version $Id: toolbar.users.html.php,v 1.1 2004/10/03 03:19:24 mibi Exp $
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
class TOOLBAR_users {
	/**
	* Draws the menu to edit a user
	*/
	function _EDIT() {
		mosMenuBar::startTable();
		mosMenuBar::save();
		mosMenuBar::cancel();
		mosMenuBar::help( 'sect.users.edit' );
		mosMenuBar::endTable();
	}
	
	function _DEFAULT() {
        global $adminLanguage;
        mosMenuBar::startTable();
		mosMenuBar::addNew();
		mosMenuBar::editList();
		mosMenuBar::deleteList();
		mosMenuBar::custom( 'logout', 'cancel.png', 'cancel_f2.png', '&nbsp;'. $adminLanguage->A_COMP_USERS_LOGOUT );
		mosMenuBar::help( 'sect.users' );
		mosMenuBar::endTable();
	}
}
?>