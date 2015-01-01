<?php
/**
* @version $Id: mod_sections.php,v 1.12 2004/08/26 05:21:00 rcastley Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

//** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$count = intval( $params->get( 'count', 20 ) );
$access = !$mainframe->getCfg( 'shownoauth' );

$database->setQuery( "SELECT id AS id, title AS title FROM #__sections"
. "\nWHERE scope='content'"
. "\nAND published='1'"
. ($access ? "\n	AND access<='$my->gid'" : "" )
. "\nORDER BY ordering"
. "\nLIMIT $count"
);

$rows = $database->loadObjectList();
echo "<ul>\n";
if ($rows) {
	foreach ($rows as $row) {
		echo "  <li><a href=\"" . sefRelToAbs("index.php?option=com_content&task=blogsection&id=".$row->id) . "\">" . $row->title . "</a></li>\n";
	}
	echo "</ul>\n";
}
?>