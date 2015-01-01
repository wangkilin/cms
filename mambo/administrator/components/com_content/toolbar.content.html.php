<?php
/**
* @version $Id: toolbar.content.html.php,v 1.2 2004/10/12 03:21:44 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/**
* @package Mambo_4.5.1
*/
class TOOLBAR_content {
	function _NEW() {
		mosMenuBar::startTable();
		mosMenuBar::preview( 'contentwindow', true );
		mosMenuBar::media_manager();
		mosMenuBar::save();
		mosMenuBar::cancel();
		mosMenuBar::help( 'sect.content.edit' );
		mosMenuBar::endTable();
	}

	function _EDIT() {
		mosMenuBar::startTable();
		mosMenuBar::preview( 'contentwindow', true );
		mosMenuBar::media_manager();
		mosMenuBar::save();
		mosMenuBar::cancel();
		mosMenuBar::help( 'sect.content.edit' );
		mosMenuBar::endTable();
	}

	function _ARCHIVE() {
       global $adminLanguage;
		mosMenuBar::startTable();
		mosMenuBar::unarchiveList();
		mosMenuBar::custom( 'remove', 'delete.png', 'delete_f2.png', '&nbsp;'. $adminLanguage->A_COMP_CONTENT_BAR_TRASH, false );
		mosMenuBar::endTable();
	}

	function _MOVE() {
       global $adminLanguage;
		mosMenuBar::startTable();
		mosMenuBar::custom( 'movesectsave', 'save.png', 'save_f2.png', '&nbsp;'. $adminLanguage->A_COMP_CONTENT_BAR_SAVE, false );
		mosMenuBar::cancel();
		mosMenuBar::help( 'sect.content.move' );
		mosMenuBar::endTable();
	}

	function _COPY() {
       global $adminLanguage;
		mosMenuBar::startTable();
		mosMenuBar::custom( 'copysave', 'save.png', 'save_f2.png', '&nbsp;'. $adminLanguage->A_COMP_CONTENT_BAR_SAVE, false );
		mosMenuBar::cancel();
		mosMenuBar::help( 'sect.content.move' );
		mosMenuBar::endTable();
	}

	function _DEFAULT() {
       global $adminLanguage;
		mosMenuBar::startTable();
		mosMenuBar::addNew();
		mosMenuBar::editList( 'editA' );
		mosMenuBar::publishList();
		mosMenuBar::unpublishList();
		mosMenuBar::custom( 'movesect', 'move.png', 'move_f2.png', '&nbsp;'. $adminLanguage->A_COMP_CONTENT_BAR_MOVE );
		mosMenuBar::custom( 'copy', 'copy.png', 'copy_f2.png', '&nbsp;'. $adminLanguage->A_COMP_CONTENT_BAR_COPY );
		mosMenuBar::archiveList();
		mosMenuBar::trash();
		mosMenuBar::help( 'sect.content' );
		mosMenuBar::endTable();
	}
}
?>