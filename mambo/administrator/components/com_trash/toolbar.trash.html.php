<?php
/**
* @version $Id: toolbar.trash.html.php,v 1.6 2004/08/26 05:20:49 rcastley Exp $
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
class TOOLBAR_Trash {
	function _DEFAULT() {
		global $adminLanguage;
		mosMenuBar::startTable();
		mosMenuBar::custom('restoreconfirm','restore.png','restore_f2.png',$adminLanguage->A_COMP_TRASH_REST, true);
		mosMenuBar::custom('deleteconfirm','delete.png','delete_f2.png',$adminLanguage->A_COMP_TRASH_DEL, true);
		mosMenuBar::spacer();
		mosMenuBar::help( 'sect.trashmanager' );
		mosMenuBar::endTable();
	}

	function _DELETE() {
		mosMenuBar::startTable();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	function _SETTINGS() {
		mosMenuBar::startTable();
		mosMenuBar::save();
		mosMenuBar::back();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

}
?>