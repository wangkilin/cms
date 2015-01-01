<?php
/**
* @version $Id: mod_toolbar.php,v 1.2 2004/08/26 05:20:53 rcastley Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( "$mosConfig_absolute_path/administrator/includes/menubar.html.php" );

if ($path = $mainframe->getPath( "toolbar" )) {
	include_once( $path );
}
?>