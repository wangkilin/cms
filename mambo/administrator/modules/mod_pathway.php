<?php
/**
* @version $Id: mod_pathway.php,v 1.6 2004/08/26 05:20:53 rcastley Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_sitename;

if ($option != '') {
	$html = '';

	$html .= '<div class="pathway">';
	$html .= '<strong>' . $mosConfig_sitename . '</strong>';

	if ($option != '') {
		$html .= " / ";
		// try to miss edit functions
		if ($task != '' && !eregi( 'edit', $task )) {
			$html .= "<a href=\"index2.php?option=$option\">$option</a>";
		} else {
			$html .= $option;
		}
	}

	if ($task != '') {
		$html .= " / $task";
	}
	$html .= '</div>';
	echo $html;
}
?>