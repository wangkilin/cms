<?php
/**
* @version $Id: mod_newsflash.php,v 1.15 2004/09/23 22:07:56 prazgod Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'front_html', 'com_content') );


global $my, $mosConfig_shownoauth, $mosConfig_offset;

$access = !$mosConfig_shownoauth;

$now = date( "Y-m-d H:i:s", time()+$mosConfig_offset*60*60 );

$catid = intval( $params->get( 'catid' ) );
$style = $params->get( 'style' );
$image = $params->get( 'image' );
$readmore = $params->get( 'readmore' );
$items = intval( $params->get( 'items' ) );
$moduleclass_sfx = $params->get( 'moduleclass_sfx' );

$params->set( 'intro_only', 1 );
$params->set( 'hide_author', 1 );
$params->set( 'hide_createdate', 0 );
$params->set( 'hide_modifydate', 1 );

if ( $items ) {
	$limit = "LIMIT ". $items;
} else {
	$limit = "";
}

$database->setQuery( "SELECT a.id"
."\n FROM #__content AS a"
."\n INNER JOIN #__categories AS b ON b.id = a.catid"
."\n WHERE a.state = 1"
."\n AND a.access <= ". $my->gid .""
."\n AND (a.publish_up = '0000-00-00 00:00:00' OR a.publish_up <= '". $now ."') "
."\n AND (a.publish_down = '0000-00-00 00:00:00' OR a.publish_down >= '". $now ."')"
."\n AND catid='". $catid ."' "
."\n ORDER BY a.ordering"
."\n ". $limit ." "

);

$rows = $database->loadResultArray();
$numrows = count( $rows );

$row = new mosContent( $database );

switch ($style) {
	case 'horiz':
	echo "\n<table class=\"moduletable" . $moduleclass_sfx . "\">\n";
	echo "<tr>\n";
	foreach ($rows as $id) {
		$row->load( $id );
		$row->text = $row->introtext;
		echo '<td>';
		HTML_content::show( $row, $params, $access, 0, 'com_content' );
		echo "</td>\n";
	}
	echo "</tr>\n</table>\n";
	break;
	case 'vert':
	foreach ($rows as $id) {
		$row->load( $id );
		$row->text = $row->introtext;

		HTML_content::show( $row, $params, $access, 0, 'com_content' );
	}
	break;
	case 'flash':
	default:
	if ($numrows > 0) {
		srand ((double) microtime() * 1000000);
		$flashnum = $rows[rand( 0, $numrows-1 )];
	} else {
		$flashnum = 0;
	}
	$row->load( $flashnum );
	$row->text = $row->introtext;

	HTML_content::show( $row, $params, $access, 0, 'com_content' );
	break;
}
?>
