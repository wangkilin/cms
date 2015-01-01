<?php
/**
* @version $Id: tinymce.php,v 1.8 2004/09/27 10:52:56 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onInitEditor', 'botTinymceEditorInit' );
$_MAMBOTS->registerFunction( 'onGetEditorContents', 'botTinymceEditorGetContents' );
$_MAMBOTS->registerFunction( 'onEditorArea', 'botTinymceEditorEditorArea' );

/**
* TinyMCE WYSIWYG Editor - javascript initialisation
*/
function botTinymceEditorInit() {
	global $mosConfig_live_site, $database;

	// load tinymce info
	$query = "SELECT id FROM #__mambots WHERE element = 'tinymce' AND folder = 'editors'";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$mambot = new mosMambot( $database );
	$mambot->load( $id );
	$params =& new mosParameters( $mambot->params );

	$theme = $params->get( 'theme', 'default' );

	return <<<EOD
<script type="text/javascript" src="$mosConfig_live_site/mambots/editors/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		theme : "$theme",
		language : "uk",
		mode : "specific_textareas",
		document_base_url: "$mosConfig_live_site/mambots/editors/tinymce/",
		invalid_elements: "script,object,applet,iframe",
		debug : false
	});
</script>
EOD;
}
/**
* TinyMCE WYSIWYG Editor - copy editor contents to form field
* @param string The name of the editor area
* @param string The name of the form field
*/
function botTinymceEditorGetContents( $editorArea, $hiddenField ) {
	return <<<EOD

		tinyMCE.triggerSave();
EOD;
}
/**
* TinyMCE WYSIWYG Editor - display the editor
* @param string The name of the editor area
* @param string The content of the field
* @param string The name of the form field
* @param string The width of the editor area
* @param string The height of the editor area
* @param int The number of columns for the editor area
* @param int The number of rows for the editor area
*/
function botTinymceEditorEditorArea( $name, $content, $hiddenField, $width, $height, $col, $row ) {
	global $mosConfig_live_site, $_MAMBOTS;

	$results = $_MAMBOTS->trigger( 'onCustomEditorButton' );
	$buttons = array();
	foreach ($results as $result) {
	    $buttons[] = '<img src="'.$mosConfig_live_site.'/mambots/editors-xtd/'.$result[0].'" onclick="tinyMCE.execCommand(\'mceInsertContent\',false,\''.$result[1].'\')" />';
	}
	$buttons = implode( "", $buttons );

	return <<<EOD

<textarea id="$hiddenField" name="$hiddenField" cols="$col" rows="$row" style="width:{$width}px; height:{$height}px;" mce_editable="true">$content</textarea>
<br />$buttons
EOD;
}
?>