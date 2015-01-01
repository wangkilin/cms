<?php
/**
* @version $Id: toolbar.banners.html.php,v 1.11 2004/08/26 05:20:37 rcastley Exp $
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
class TOOLBAR_banners {
	/**
	* Draws the menu for to Edit a banner
	*/
	function _EDIT()
	{
		mosMenuBar::startTable();
		mosMenuBar::media_manager( "banners" );
		mosMenuBar::save();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::help( 'sect.banners.edit' );
		mosMenuBar::endTable();
	}
	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::publishList();
		mosMenuBar::unpublishList();
		mosMenuBar::media_manager( "banners" );
		mosMenuBar::addNew();
		mosMenuBar::editList();
		mosMenuBar::deleteList();
		mosMenuBar::spacer();
		mosMenuBar::help( 'sect.banners' );
		mosMenuBar::endTable();
	}
}

/**
* @package Mambo_4.5.1
*/
class TOOLBAR_bannerClient {
	/**
	* Draws the menu for to Edit a client
	*/
	function _EDIT()
	{
		mosMenuBar::startTable();
		mosMenuBar::save( 'saveclient' );
		mosMenuBar::cancel( 'cancelclient' );
		mosMenuBar::spacer();
		mosMenuBar::help( 'sect.banners.client.edit' );
		mosMenuBar::endTable();
	}
	/**
	* Draws the default menu
	*/
	function _DEFAULT()
	{
		mosMenuBar::startTable();
		mosMenuBar::addNew( 'newclient' );
		mosMenuBar::editList( 'editclient' );
		mosMenuBar::deleteList( '', 'removeclients' );
		mosMenuBar::spacer();
		mosMenuBar::help( 'sect.banners.client' );
		mosMenuBar::endTable();
	}
}
?>