<?php
/**
* @version $Id: mospaging.php,v 1.20 2004/09/19 14:00:44 prazgod Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onPrepareContent', 'botMosPaging' );

/**
* Page break mambot
*
* <b>Usage:</b>
* <code>{mospagebreak}</code>
* <code>{mospagebreak title="The page title"}</code>
* <code>{mospagebreak title="The page title" toc="1"}</code>
*
* Note that the following syntax is deprecated
* <code>{mospagebreak title=The page title&toc=1}</code>
*
* If <i>title</i> is specified, then a page sub-title is included
*
* If <i>toc</i> is specified, then a table of contents is included
*/
function botMosPaging( $published, &$row, &$params, $page=0 ) {
	global $mosConfig_live_site;
	global $mainframe, $Itemid;

	if (!$published || $params->get( 'intro_only' )|| $params->get( 'popup' )) {
		$row->text = preg_replace( '/{mospagebreak\s*.*?}/i', '', $row->text );
		return;
	}

	// $bots holds all the mospagebreak mambots
	preg_match_all( '/{(mospagebreak)\s*(.*?)}/i', $row->text, $bots, PREG_SET_ORDER );

	// split the text around the mambot
	$text = preg_split( '/{(mospagebreak)\s*(.*?)}/i', $row->text );

	// count the number of pages
	$n = count( $text );
	if ($n > 1) {
		// we have found at least one mambot, therefore at least 2 pages

		// reset the text, we already hold it in the $text array
		$row->text = "";

		$hasToc = false;
		$hasTitle = false;

		$args = array();
		if (@$bots[$page-1]) {
			// we have a mambot for this page
			if (@$bots[$page-1][2]) {
				// the mambot has arguments
				parse_str( str_replace( '&amp;', '&', $bots[$page-1][2] ), $args );
				if (@$args['toc'] == '1' || @$args['toc'] == 'yes') {
					$hasToc = true;
				}
				if (@$args['title']) {
					$hasTitle = true;
				}
			}
		}
		$hasToc = $mainframe->getCfg( 'multipage_toc' );

		if ($hasToc) {
			$link = 'index.php?option=com_content&amp;task=view&amp;id='. $row->id .'&amp;Itemid='. $Itemid;

			$row->toc = '<table cellpadding="0" cellspacing="0" class="contenttoc" align="right">';
			$row->toc .= '<tr>';
			$row->toc .= '<th>' . _TOC_JUMPTO . '</th>';
			$row->toc .= '</tr>';
			$row->toc .= '<tr>';
			$row->toc .= '<td><a href="' .sefRelToAbs( $link ) .'" class="toclink">'. $row->title .'</a></td>';
			$row->toc .= '</tr>';

			$i = 2;
			$nextTitle = _PN_PAGE.' '.($page+2);
			foreach ( $bots as $bot ) {
				$link2 = $link .'&amp;limit=1&amp;limitstart='. ($i-1);
				if (@$bot[2]) {
					parse_str( str_replace( '&amp;', '&', $bot[2] ), $args2 );
					if (@$args2['title']) {
						$row->toc .= '<tr><td><a href="' .sefRelToAbs( $link2 ) .'" class="toclink">'. $args2['title'] .'</a></td></tr>';
						if ($page == $i-2) {
							$nextTitle = $args2['title'];
						}
					} else {
						$row->toc .= '<tr><td><a href="'. sefRelToAbs( $link2 ). '" class="toclink">'. _PN_PAGE .' '. $i .'</a></td></tr>';
					}
				} else {
					$row->toc .= '<tr><td><a href="'. sefRelToAbs( $link2 ) .'" class="toclink">'. _PN_PAGE .' '. $i .'</a></td></tr>';
				}
				$i++;
			}

			$row->toc .= '</table>';

		} else {
			$row->toc = '';
		}

		// traditional mos page navigation
	require_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/pageNavigation.php' );
		$pageNav = new mosPageNav( $n, $page, 1 );

		// page counter
		$row->text .= '<div class="pagenavcounter">';
		$row->text .= $pageNav->writeLeafsCounter();
		$row->text .= '</div>';

		// the page text
		$row->text .= $text[$page];
		$row->text .= '<br />';
		$row->text .= '<div class="pagenavbar">';


		if ($hasToc) {
			$link = 'index.php?option=com_content&amp;task=view&amp;id='. $row->id .'&amp;Itemid='. $Itemid;
			if ($page < $n-1) {
				$link_next = $link .'&amp;limit=1&amp;limitstart='. ( $page + 1 );
				//$nextTitle  = mosGetParam( $_REQUEST, 'nextTitle ', 0 ); // hack to hide undefined var when error reporting on max
				//$name = isset($args2['title']) ? $nextTitle : "";
				$next = "<a href=\"".sefRelToAbs( $link_next )."\">" ._CMN_NEXT . _CMN_NEXT_ARROW ."</a>";
			} else {
				$next = _CMN_NEXT;
			}
			
			if ($page > 0) {
				$link_prev = $link .'&amp;limit=1&amp;limitstart='. ( $page - 1 );
				$prev = "<a href=\"".sefRelToAbs( $link_prev )."\">" . _CMN_PREV_ARROW . _CMN_PREV ."</a>";
			} else {
				$prev = _CMN_PREV;
			}
			$row->text .= '<div>' . $prev . " - " . $next .'</div>';
		}

		// the page links
		if (!$hasToc) {
			$row->text .= $pageNav->writePagesLinks( 'index.php?option=com_content&amp;task=view&amp;id='. $row->id .'&amp;Itemid='. $Itemid );
		}

		$row->text .= '</div><br />';
	}

	return true;
}
?>
