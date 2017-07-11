<?php
/**
* @version $Id: admin.php,v 1.1 2004/10/03 04:01:53 mibi Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @param string THe template position
*/
function mosCountAdminModules(  $position='left' ) {
	global $database, $my, $Itemid, $adminLanguage;

	$query = "SELECT COUNT(m.id)"
	. "\nFROM #__modules AS m"
	. "\nWHERE m.published='1' AND m.position='$position' AND m.client_id='1'";

	$database->setQuery( $query );
	return $database->loadResult();
}
/**
* Loads admin modules via module position
* @param string The position
* @param int 0 = no style, 1 = tabbed
*/
function mosLoadAdminModules( $position='left', $style=0 ) {
	global $database, $adminLanguage;

	$cache =& mosCache::getCache( 'com_content' );

	$query = "SELECT id, title, module, position, content, showtitle, params"
	. "\n FROM #__modules AS m"
	. "\n WHERE m.published = '1'"
	. "\n AND m.position='$position'"
	. "\n AND (m.client_id = 1)"
	. "\n ORDER BY m.ordering";

	$database->setQuery( $query );
	$modules = $database->loadObjectList();
	if($database->getErrorNum()) {
		echo "MA ".$database->stderr(true);
		return;
	}

	switch ($style) {
	    case 0:
	    default:
			foreach ($modules as $module) {
				$params =& new mosParameters( $module->params );
				if ( $module->module == '' ) {
					mosLoadCustomModule( $module, $params );
				} else {
					mosLoadAdminModule( substr( $module->module, 4 ), $params );
				}
			}
			break;

		case 1:
		    // Tabs
			$tabs = new mosTabs(0);
			$tabs->startPane( 'modules-' . $position );
			foreach ($modules as $module) {
				$params =& new mosParameters( $module->params );
				$tabs->startTab( $module->title, 'module' . $module->id );
				if ( $module->module == '' ) {
					mosLoadCustomModule( $module, $params );
				} else {
					mosLoadAdminModule( substr( $module->module, 4 ), $params );
				}
				$tabs->endTab();
			}
			$tabs->endPane();
			break;

		case 2:
		    // Div'd
			foreach ($modules as $module) {
				$params =& new mosParameters( $module->params );
				echo '<div>';
				if ( $module->module == '' ) {
					mosLoadCustomModule( $module, $params );
				} else {
					mosLoadAdminModule( substr( $module->module, 4 ), $params );
				}
				echo '</div>';
			}
			break;
	}
}
/**
* Loads an admin module
*/
function mosLoadAdminModule( $name, $params=NULL ) {
	global $mosConfig_absolute_path, $mosConfig_live_site;
	global $database, $acl, $my, $mainframe, $option, $adminLanguage;

	$task = mosGetParam( $_REQUEST, 'task', '' );
	// legacy support for $act
	$act = mosGetParam( $_REQUEST, 'act', '' );

	$name = str_replace( '/', '', $name );
	$name = str_replace( '\\', '', $name );
	$path = "$mosConfig_absolute_path/administrator/modules/mod_$name.php";
	if (file_exists( $path )) {
	    require $path;
	}
}

function mosLoadCustomModule( &$module, &$params ) {
	global $mosConfig_absolute_path, $adminLanguage;

	$rssurl = $params->get( 'rssurl', '' );
	$rssitems = $params->get( 'rssitems', '' );
	$rssdesc = $params->get( 'rssdesc', '' );
	$moduleclass_sfx = $params->get( 'moduleclass_sfx', '' );

	echo '<table cellpadding="0" cellspacing="0" class="moduletable' . $moduleclass_sfx . '">';

	if ($module->content) {
		echo '<tr>';
		echo '<td>' . $module->content . '</td>';
		echo '</tr>';
	}

	// feed output
	if ( $rssurl ) {
		$cacheDir = $mosConfig_absolute_path .'/cache/';
		if (!is_writable( $cacheDir )) {
			echo '<tr>';
			echo '<td>Please make cache directory writable.</td>';
			echo '</tr>';
		} else {
			$LitePath = $mosConfig_absolute_path .'/includes/Cache/Lite.php';
			require_once( $mosConfig_absolute_path .'/includes/domit/xml_domit_rss_lite.php');
			$rssDoc =& new xml_domit_rss_document_lite();
			$rssDoc->useCacheLite(true, $LitePath, $cacheDir, 3600);
			$rssDoc->loadRSS( $rssurl );
			$totalChannels = $rssDoc->getChannelCount();

			for ($i = 0; $i < $totalChannels; $i++) {
				$currChannel =& $rssDoc->getChannel($i);
				echo '<tr>';
				echo '<td><strong><a href="'. $currChannel->getLink() .'" target="_child">';
				echo $currChannel->getTitle() .'</a></strong></td>';
				echo '</tr>';
				if ($rssdesc) {
					echo '<tr>';
					echo '<td>'. $currChannel->getDescription() .'</td>';
					echo '</tr>';
				}

				$actualItems = $currChannel->getItemCount();
				$setItems = $rssitems;

				if ($setItems > $actualItems) {
					$totalItems = $actualItems;
				} else {
					$totalItems = $setItems;
				}

				for ($j = 0; $j < $totalItems; $j++) {
					$currItem =& $currChannel->getItem($j);

					echo '<tr>';
					echo '<td><strong><a href="'. $currItem->getLink() .'" target="_child">';
					echo $currItem->getTitle() .'</a></strong> - '. $currItem->getDescription() .'</td>';
					echo '</tr>';
				}
			}
		}
	}
	echo '</table>';
}

function mosShowSource( $filename, $withLineNums=false ) {
	ini_set('highlight.html', '000000');
	ini_set('highlight.default', '#800000');
	ini_set('highlight.keyword','#0000ff');
	ini_set('highlight.string', '#ff00ff');
	ini_set('highlight.comment','#008000');

	if (!($source = @highlight_file( $filename, true ))) {
		return 'Operation Failed';
	}
	$source = explode("<br />", $source);

	$ln = 1;

	$txt = '';
	foreach( $source as $line ) {
		$txt .= "<code>";
		if ($withLineNums) {
			$txt .= "<font color=\"#aaaaaa\">";
			$txt .= str_replace( ' ', '&nbsp;', sprintf( "%4d:", $ln ) );
			$txt .= "</font>";
		}
		$txt .= "$line<br /><code>";
		$ln++;
	}
	return $txt;
}
?>