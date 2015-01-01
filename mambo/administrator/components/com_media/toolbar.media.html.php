<?php
/**
* @version $Id: toolbar.media.html.php,v 1.7 2004/08/26 06:54:54 eddieajau Exp $
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
class TOOLBAR_media {
	/**
	* Draws the menu for a New Media
	*/

	function _DEFAULT() {
		global $adminLanguage;
		mosMenuBar::startTable();
		mosMenuBar::custom('upload','upload.png','upload_f2.png',$adminLanguage->A_COMP_MEDIA_UPLOAD,false);
		mosMenuBar::custom('newdir','new.png','new_f2.png',$adminLanguage->A_COMP_MEDIA_CREATE ,false);
		mosMenuBar::help( 'sect.mediamanger' );
		mosMenuBar::endTable();
	}

}
?>