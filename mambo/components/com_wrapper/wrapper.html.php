<?php
/**
* @version $Id: wrapper.html.php,v 1.4 2004/09/26 08:16:54 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class HTML_wrapper {

	function displayWrap( &$row, &$params, &$menu ) {
		?>
		<script language="javascript" type="text/javascript">
		//onload = iFrameHeight;
		function iFrameHeight() {
			var h = 0;
			if ( !document.all ) {
				h = document.getElementById('blockrandom').contentDocument.height;
				document.getElementById('blockrandom').style.height = h + 60 + 'px';
			} else if( document.all ) {
				h = document.frames('blockrandom').document.body.scrollHeight;
				document.all.blockrandom.style.height = h + 20 + 'px';
			}
		}
		</script>
		<div class="contentpane<?php echo $params->get( 'pageclass_sfx' ); ?>">

		<?php
		if ( $params->get( 'page_title' ) ) {
			?>
			<div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
			<?php echo $params->get( 'header' ); ?>
			</div>
			<?php
		}
		?>
		<iframe   
		<?php echo $row->load ."\n"; ?>
		id="blockrandom"
		src="<?php echo $row->url; ?>" 
		width="<?php echo $params->get( 'width' ); ?>" 
		height="<?php echo $params->get( 'height' ); ?>" 
		scrolling="<?php echo $params->get( 'scrolling' ); ?>" 
		align="top"
		frameborder="0"
		class="wrapper<?php echo $params->get( 'pageclass_sfx' ); ?>">
		<?php echo _CMN_IFRAMES; ?>
		</iframe>

		</div>
		<?php
		// displays back button
		mosHTML::BackButton ( $params );
	}

}
?>