<?php
/**
* @version $Id: toolbar.poll.html.php,v 1.1 2004/10/02 18:26:34 mibi Exp $
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
class TOOLBAR_poll {
	/**
	* Draws the menu for a New category
	*/
	function _NEW() {
		mosMenuBar::startTable();
		mosMenuBar::save();
		mosMenuBar::cancel();
		mosMenuBar::help( 'sect.polls.edit' );
		mosMenuBar::endTable();
	}
	/**
	* Draws the menu for Editing an existing category
	*/
	function _EDIT( $pollid, $cur_template ) {
		global $database, $adminLanguage;
		$sql = "SELECT template FROM #__templates_menu WHERE client_id='0' AND menuid='0'";
		$database->setQuery( $sql );
		$cur_template = $database->loadResult();
		mosMenuBar::startTable();
		$popup='pollwindow';
    	?>
		<td><a class="toolbar" href="#" onclick="window.open('popups/<?php echo $popup;?>.php?pollid=<?php echo $pollid; ?>&t=<?php echo $cur_template; ?>', 'win1', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('preview','','images/preview_f2.png',1);"><img src="images/preview.png" alt="Preview" border="0" name="<?php echo $adminLanguage->A_COMP_PREVIEW;?>" align="middle" />&nbsp;<?php echo $adminLanguage->A_COMP_PREVIEW;?></a></td>
    <?php
    mosMenuBar::save();
    mosMenuBar::cancel();
    mosMenuBar::help( 'sect.polls.edit' );
    mosMenuBar::endTable();
	}
	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::publishList();
		mosMenuBar::unpublishList();
		mosMenuBar::addNew();
		mosMenuBar::editList();
		mosMenuBar::deleteList();
		mosMenuBar::help( 'sect.polls' );
		mosMenuBar::endTable();
	}
}
?>
