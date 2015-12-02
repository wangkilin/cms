<?php
/**
* @version $Id: toolbar.sections.html.php,v 1.1 2004/10/02 19:50:43 mibi Exp $
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
class TOOLBAR_sections {
	/**
	* Draws the menu for Editing an existing category
	*/
	function _EDIT() {
		mosMenuBar::startTable();
		mosMenuBar::media_manager();
		mosMenuBar::save();
		mosMenuBar::cancel();
		mosMenuBar::endTable();
	}
	/**
	* Draws the menu for Copying existing sections
	* @param int The published state (to display the inverse button)
	*/
	function _COPY() {
		mosMenuBar::startTable();
		mosMenuBar::save( 'copysave' );
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}
	/**
	* Draws the menu for Editing an existing category
	*/
	function _DEFAULT(){
		global $adminLanguage;
        mosMenuBar::startTable();
		mosMenuBar::publishList();
		mosMenuBar::unpublishList();
		mosMenuBar::addNew();
		mosMenuBar::custom( 'copyselect', 'copy.png', 'copy_f2.png', '&nbsp;'. $adminLanguage->A_COMP_CONTENT_BAR_COPY, true );
		mosMenuBar::editList();
		mosMenuBar::deleteList();
		mosMenuBar::endTable();
	}
}
?>
