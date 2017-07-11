<?php
/**
* @version $Id: admin.admin.php,v 1.1 2004/09/27 08:33:20 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
require_once( $mainframe->getPath( 'admin_html' ) );

switch ($task) {
	
	case "redirect":
		$goto = trim( strtolower( mosGetParam( $_REQUEST, 'link' ) ) );
		if ($goto == "null"){
			mosRedirect("index2.php?option=com_admin&task=listcomponents",$adminLanguage->A_COMP_ALERT_NO_LINK);
			exit();
		}
		$goto = str_replace( "'", '', $goto );
		mosRedirect($goto);
		break;
		
	case "listcomponents":
		HTML_admin_misc::ListComponents();
		break;
	
	case 'sysinfo':
		HTML_admin_misc::system_info( $version, $option );
		break;

	case 'help':
		HTML_admin_misc::help();
		break;

	case 'preview':
		HTML_admin_misc::preview();
		break;

	case 'preview2':
		HTML_admin_misc::preview( 1 );
		break;

	case 'credits':
		HTML_admin_misc::credits( $version );
		break;

	case 'cpanel':
    default:
		HTML_admin_misc::controlPanel();
		break;

}
?>