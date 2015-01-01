<?php
/**
* @version $Id: mosimage.php,v 1.15 2004/09/28 14:21:30 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onPrepareContent', 'botMosImage' );

/**
*/
function botMosImage( $published, &$row, &$params, $page=0  ) {
	global $mosConfig_absolute_path, $mosConfig_live_site;

	if (!$published || !$params->get( 'image' )) {
	    $row->text	 	= str_replace( '{mosimage}', '', $row->text );
	    return true;
	}

	// assemble the images
	$images 			= array();

	// split on \n the images fields into an array
	$row->images 		= explode( "\n", $row->images );

	// needed to stopping loading of images for the introtext
	$start = 0;
	if ( !$params->get( 'introtext' ) && strstr( $row->introtext, '{mosimage}' ) ) {
		$search 		= explode( '{mosimage}', $row->introtext );
		$start 		= count( $search ) - 1;
	}
	$total 			= count( $row->images );

//	foreach ($row->images as $img) {
	for ( $i = $start; $i < $total; $i++ ) {
		$img = trim( $row->images[$i] );

		// split on pipe the attributes of the image
		if ($img) {
			$temp = explode( '|', trim( $img ) );
			if ( !isset($temp[1]) || !$temp[1] ) {
				$temp[1] = '';
			}
			if ( !isset($temp[2]) || !$temp[2] ) {
				$temp[2] = 'Image';
			} else {
				$temp[2] = htmlspecialchars( $temp[2] );
			}
			if ( !isset($temp[3]) || !$temp[3] ) {
				$temp[3] = '0';
			}
			$size = '';
			// assemble the image tag
			if (function_exists( 'getimagesize' )) {
				$size = @getimagesize( $mosConfig_absolute_path .'/images/stories/'. $temp[0] );
				if (is_array( $size )) {
					$size = 'width="'. $size[0] .'" height="'. $size[1] .'"';
				}
			}
			 $img = '<img src="'. $mosConfig_live_site .'/images/stories/'. $temp[0] .'"'. $size;
       $img .= $temp[1] ? ' align="'. $temp[1] .'" ' : '';
       $img .='  hspace="6" alt="'. $temp[2] .'" title="'. $temp[2] .'" border="'. $temp[3] .'" />';
       $images[] = $img;
		}
	}

	// define the regular expression for the bot
	$regex = '#{mosimage}#s';

	// store some vars in globals to access from the replacer
	$GLOBALS['botMosImageCount'] 	= 0;
	$GLOBALS['botMosImageParams'] =& $params;
	$GLOBALS['botMosImageArray'] 	=& $images;

	// perform the replacement
	$row->text = preg_replace_callback( $regex, 'botMosImage_replacer', $row->text );

	// clean up globals
	unset( $GLOBALS['botMosImageCount'] );
	unset( $GLOBALS['botMosImageMask'] );
	unset( $GLOBALS['botMosImageArray'] );

	return true;
}
/**
* Replaces the matched tags an image
* @param array An array of matches (see preg_match_all)
* @return string
*/
function botMosImage_replacer( &$matches ) {
	$i = $GLOBALS['botMosImageCount']++;
	return @$GLOBALS['botMosImageArray'][$i];
}
?>
