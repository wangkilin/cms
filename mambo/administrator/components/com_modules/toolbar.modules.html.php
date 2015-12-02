<?php
/**
* @version $Id: toolbar.modules.html.php,v 1.1 2004/10/02 04:52:28 mibi Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/**
* @package Mambo_4.5.1
*/
class TOOLBAR_modules {
	/**
	* Draws the menu for a New module
	*/
	function _NEW()	{
		mosMenuBar::startTable();
		mosMenuBar::preview( 'modulewindow' );
		mosMenuBar::save();
		mosMenuBar::cancel();
		mosMenuBar::endTable();
	}

	/**
	* Draws the menu for Editing an existing module
	*/
	function _EDIT( $cur_template, $publish ) {
		mosMenuBar::startTable();
		?>
			<td><a class="toolbar" href="#" onClick="if (typeof document.adminForm.content == 'undefined') { alert('You can only preview typed modules.'); } else { var content = document.adminForm.content.value; content = content.replace('#', '');  var title = document.adminForm.title.value; title = title.replace('#', ''); window.open('popups/modulewindow.php?title=' + title + '&content=' + content + '&t=<?php echo $cur_template; ?>', 'win1', 'status=no,toolbar=no,scrollbars=auto,titlebar=no,menubar=no,resizable=yes,width=200,height=400,directories=no,location=no'); }" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('preview','','images/preview_f2.png',1);"><img src="images/preview.png" alt="Preview" border="0" name="preview" align="middle">&nbsp;Preview</a></td>
		<?php
		mosMenuBar::save();
		mosMenuBar::cancel();
		mosMenuBar::endTable();
	}
	function _DEFAULT() {
        global $adminLanguage;
        mosMenuBar::startTable();
		mosMenuBar::publishList();
		mosMenuBar::unpublishList();
		mosMenuBar::custom( 'copy', 'copy.png', 'copy_f2.png', '&nbsp;'. $adminLanguage->A_COMP_CONTENT_BAR_COPY, true );
		mosMenuBar::addNew();
		mosMenuBar::editList();
		mosMenuBar::deleteList();
		mosMenuBar::help( 'sect.modules' );
		mosMenuBar::endTable();
	}
}
?>
