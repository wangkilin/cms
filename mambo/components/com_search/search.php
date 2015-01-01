<?php
/**
* @version $Id: search.php,v 1.22 2004/09/13 11:34:43 eddieajau Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @todo To be implemented in Version 4.6
*/
function mosLogSearch( $search_term ) {
	global $database;
	global $mosConfig_enable_log_searches;

	if (@$mosConfig_enable_log_searches) {
		$database->setQuery( "SELECT hits"
		. "\nFROM #__core_log_searches"
		. "\nWHERE LOWER(search_term)='$search_term'" );
		$hits = intval( $database->loadResult() );
		if ($hits) {
			$database->setQuery( "UPDATE #__core_log_searches SET hits=(hits+1)"
			. "\nWHERE LOWER(search_term)='$search_term'" );
			$database->query();
		} else {
			$database->setQuery( "INSERT INTO #__core_log_searches VALUES"
			. "\n('$search_term','1')" );
			$database->query();
		}
	}
}


require_once( $mainframe->getPath( 'front_html' ) );
$mainframe->setPageTitle( _SEARCH_TITLE );

$gid = $my->gid;

@search_html::openhtml( htmlspecialchars( $searchword ) );

$searchword = mosGetParam( $_REQUEST, 'searchword', '' );
$searchword = $database->getEscaped( trim( $searchword ) );

$search_ignore = array();
@include "$mosConfig_absolute_path/language/$mosConfig_lang.ignore.php";

$orders = array();
$orders[] = mosHTML::makeOption( 'newest', _SEARCH_NEWEST );
$orders[] = mosHTML::makeOption( 'oldest', _SEARCH_OLDEST );
$orders[] = mosHTML::makeOption( 'popular', _SEARCH_POPULAR );
$orders[] = mosHTML::makeOption( 'alpha', _SEARCH_ALPHABETICAL );
$orders[] = mosHTML::makeOption( 'category', _SEARCH_CATEGORY );
$ordering = mosGetParam( $_REQUEST, 'ordering', 'newest');
$lists = array();
$lists['ordering'] = mosHTML::selectList( $orders, 'ordering', 'class="inputbox"', 'value', 'text', $ordering );

search_html::searchbox( htmlspecialchars( $searchword ), $lists );
if (!$searchword) {
	search_html::message( _NOKEYWORD );
} else if (in_array( $searchword, $search_ignore )) {
	search_html::message( _IGNOREKEYWORD );
} else {
	search_html::searchintro( htmlspecialchars( $searchword ) );

	mosLogSearch( $searchword );
	$phrase = mosGetParam( $_REQUEST, 'searchphrase', '' );
	$ordering = mosGetParam( $_REQUEST, 'ordering', '' );

	$_MAMBOTS->loadBotGroup( 'search' );
	$results = $_MAMBOTS->trigger( 'onSearch', array( $searchword, $phrase, $ordering ) );
	$totalRows = 0;

	$rows = array();
	for ($i = 0, $n = count( $results); $i < $n; $i++) {
		$rows = array_merge( $rows, $results[$i] );
	}

	$totalRows = count( $rows );

	for ($i=0; $i < $totalRows; $i++) {
		$row = &$rows[$i]->text;
		$row = preg_replace( "'<script[^>]*>.*?</script>'si", "", $row );
		$row = str_replace( '{mosimage}', '', $row );
		$row = preg_replace( '/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is','\2 (\1)', $row );
		$row = preg_replace( '/<!--.+?-->/', '', $row);
		$row = preg_replace( '/{.+?}/', '', $row);
		$row = substr( strip_tags( $row ), 0, 200 );
		$row = eregi_replace( $searchword, "<span class=\"highlight\">\\0</span>", $row);

		// determines Itemid for Content items
		if ( strstr( $rows[$i]->href, "view" ) ) {
			// tests to see if itemid has already been included - this occurs for typed content items
			if ( !strstr( $rows[$i]->href, "Itemid" ) ) {
				$temp = explode( "id=", $rows[$i]->href );
				$rows[$i]->href = $rows[$i]->href. "&amp;Itemid=". $mainframe->getItemid($temp[1]);
			}
		}
	}

	if ($n) {
		search_html::display( $rows );
	} else {
		search_html::displaynoresult();
	}

	search_html::conclusion( $totalRows, htmlspecialchars( $searchword ) );
}
?>