<?php
/**
* @version $Id: toolbar.statistics.html.php,v 1.2 2004/08/26 05:20:49 rcastley Exp $
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
class TOOLBAR_statistics {
	function _SEARCHES() {
		mosMenuBar::startTable();
		mosMenuBar::help( 'sect.stats.searches' );
		mosMenuBar::endTable();
	}
}
?>