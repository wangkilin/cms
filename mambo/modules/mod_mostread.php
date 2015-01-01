<?php
/**
* @version $Id: mod_mostread.php,v 1.18 2004/09/14 14:20:44 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_offset, $mosConfig_live_site;

$count = intval( $params->get( 'count', 5 ) );
$catid = trim( $params->get( 'catid' ) );
$secid = trim( $params->get( 'secid' ) );
$moduleclass_sfx = $params->get( 'moduleclass_sfx' );

$now = date( 'Y-m-d H:i:s', time()+$mosConfig_offset*60*60 );

$query = "SELECT a.id, a.title, a.created, a.hits"
. "\n FROM #__content AS a"
. "\n WHERE ( a.state = '1' AND a.checked_out = '0' AND a.sectionid > '0' )"
. "\n AND ( a.publish_up = '0000-00-00 00:00:00' OR a.publish_up <= '$now' )"
. "\n AND ( a.publish_down = '0000-00-00 00:00:00' OR a.publish_down >= '$now' )"
. ($catid ? "\n AND ( a.catid IN (". $catid .") )" : '')
. ($secid ? "\n AND ( a.sectionid IN (". $secid .") )" : '')
. "\n ORDER BY a.hits DESC LIMIT $count"
;
$database->setQuery($query);
$rows =$database->loadObjectList();

// needed to reduce queries used by getItemid
$bs = $mainframe->getBlogSectionCount();
$bc = $mainframe->getBlogCategoryCount();
$gbs = $mainframe->getGlobalBlogSectionCount();

echo '<ul>';
foreach ($rows as $row) {
	$Itemid = $mainframe->getItemid( $row->id, 0, 0, $bs, $bc, $gbs );
	// Blank itemid checker for SEF
	if ($Itemid == NULL) {
		$Itemid = "";
	} else {
		$Itemid = "&amp;Itemid=".$Itemid;
	}
	echo '<li><a href="' .sefRelToAbs( 'index.php?option=com_content&amp;task=view&amp;id='. $row->id . $Itemid ) .'">'. $row->title .'</a></li>';
}
echo '</ul>';
?>