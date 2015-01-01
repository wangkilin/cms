<?php
/**
* @version $Id: frontend.html.php,v 1.26 2004/09/23 06:02:48 stingrey Exp $
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
class modules_html {

	function module( &$module, &$params, $Itemid, $style=0 ) {
		global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_lang, $mosConfig_absolute_path;

		// custom module params
		$rssurl 			= $params->get( 'rssurl' );
		$rssitems 		= $params->get( 'rssitems' );
		$rssdesc 			= $params->get( 'rssdesc' );
		$moduleclass_sfx 	= $params->get( 'moduleclass_sfx' );

		?>
		<table cellpadding="0" cellspacing="0" class="moduletable<?php echo $moduleclass_sfx; ?>">
		<?php
		if ( $module->showtitle != 0 ) {	
			?>
			<tr>
				<th valign="top">
				<?php echo $module->title; ?>
				</th>
			</tr>
			<?php
		}

		if ( $module->content ) {
			?>
			<tr>
				<td>
				<?php echo $module->content; ?>
				</td>
			</tr>
			<?php
		}

		// feed output
		if ( $rssurl ) {
			$cacheDir = $mosConfig_absolute_path .'/cache/';
			$LitePath = $mosConfig_absolute_path .'/includes/Cache/Lite.php';
			require_once( $mosConfig_absolute_path .'/includes/domit/xml_domit_rss_lite.php' );
			$rssDoc =& new xml_domit_rss_document_lite();
			$rssDoc->useCacheLite(true, $LitePath, $cacheDir, 3600);
			$rssDoc->loadRSS( $rssurl );
			$totalChannels = $rssDoc->getChannelCount();
		
			for ( $i = 0; $i < $totalChannels; $i++ ) {
				$currChannel =& $rssDoc->getChannel($i);
				?>
				<tr>
					<td>
					<strong>
					<a href="<?php echo $currChannel->getLink(); ?>" target="_child">
					<?php echo $currChannel->getTitle(); ?>
					</a>
					</strong>
					</td>
				</tr>
				<?php
				if ( $rssdesc ) {
					?>
					<tr>
						<td>
						<?php echo $currChannel->getDescription(); ?>
						<br /><br />
						</td>
					</tr>
					<?php
				}
		
				$actualItems = $currChannel->getItemCount();
				$setItems = $rssitems;
		
				if ($setItems > $actualItems) {
					$totalItems = $actualItems;
				} else {
					$totalItems = $setItems;
				}
		
				?>
				<tr>
					<td>
					<ul class="newsfeed<?php echo $moduleclass_sfx; ?>">
					<?php
					for ($j = 0; $j < $totalItems; $j++) {
						$currItem =& $currChannel->getItem($j);
						?>
						<li class="newsfeed<?php echo $moduleclass_sfx; ?>">
						<strong>
						<a href="<?php echo $currItem->getLink(); ?>" target="_child">
						<?php echo $currItem->getTitle(); ?>
						</a>
						</strong>
						<div>
						<?php echo $currItem->getDescription(); ?>
						</div>
						</li>
						<?php
					}
					?>
					</ul>
					</td>
				</tr>
				<?php
			}
		}
		?>
		</table>
		<?php
	}

	/**
	* @param object
	* @param object
	* @param int The menu item ID
	* @param int -1=show without wrapper and title, -2=x-mambo style
	*/
	function module2( &$module, &$params, $Itemid, $style=0 ) {
		global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_lang, $mosConfig_absolute_path;
		global $mainframe, $database, $my;
		$moduleclass_sfx 		= $params->get( 'moduleclass_sfx' );

		// check for custom language file
		$path = $mosConfig_absolute_path . '/modules/' . $module->module.$mosConfig_lang . '.php';
		if (file_exists( $path )) {
			include( $path );
		} else {
			$path = $mosConfig_absolute_path .'/modules/'. $module->module .'.eng.php';
			if (file_exists( $path )) {
				include( $path );
			}
		}

		if ($style == -2) {
			// x-mambo (divs and font headder tags)
			?>
			<div class="moduletable<?php echo $moduleclass_sfx; ?>">
			<?php
			if ($module->showtitle != 0) {
				?>
				<h3>
				<?php echo $module->title; ?>
				</h3>
				<?php
			}
			include( $mosConfig_absolute_path .'/modules/'. $module->module .'.php' );

			if (isset( $content)) {
				echo $content;
			}
			?>
			</div>
			<?php
		} else if ($style == -1) {
			// show a naked module - no wrapper and no title
			include( $mosConfig_absolute_path .'/modules/'. $module->module .'.php' );

			if (isset( $content)) {
				echo $content;
			}
		} else {
			?>
			<table cellpadding="0" cellspacing="0" class="moduletable<?php echo $moduleclass_sfx; ?>">
			<?php
			if ( $module->showtitle != 0 ) {
				?>
				<tr>
					<th valign="top">
					<?php echo $module->title; ?>
					</th>
				</tr>
				<?php
			}
			?>
			<tr>
				<td>
				<?php
				include( $mosConfig_absolute_path . '/modules/' . $module->module . '.php' );
				if (isset( $content)) {
					echo $content;
				}
				?>
				</td>
			</tr>
			</table>
			<?php
		}
	}
}
?>