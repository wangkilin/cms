<?php
/**
* @version $Id: toolbar.typedcontent.html.php,v 1.2 2004/09/17 01:58:28 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/**
* @package Mambo_4.5.1
*/
class TOOLBAR_typedcontent {
	function _NEW() {
		mosMenuBar::startTable();
		mosMenuBar::preview( 'contentwindow', true );
		mosMenuBar::media_manager();
		mosMenuBar::save();
		mosMenuBar::cancel();
		mosMenuBar::help( 'sect.typedcontent.edit' );
		mosMenuBar::endTable();
	}

	function _EDIT( ) {
		mosMenuBar::startTable();
		mosMenuBar::preview( 'contentwindow', true );
		mosMenuBar::media_manager();
		mosMenuBar::save();
		mosMenuBar::cancel();
		mosMenuBar::help( 'sect.typedcontent.edit' );
		mosMenuBar::endTable();
	}

	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::addNew();
		mosMenuBar::editList();
		mosMenuBar::publishList();
		mosMenuBar::unpublishList();
		mosMenuBar::trash();
		mosMenuBar::help( 'sect.typedcontent' );
		mosMenuBar::endTable();
	}
}
?>