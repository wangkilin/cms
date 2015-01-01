<?php
/**
* @version $Id: admin.languages.html.php,v 1.1 2004/10/01 18:20:11 mibi Exp $
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
class HTML_languages {

	function showLanguages( $cur_lang, &$rows, &$pageNav, $option ) {
		global $my, $adminLanguage;
?>
	<form action="index2.php" method="post" name="adminForm">
	<table class="adminheading">
		<tr>
			<th class="langmanager"><?php echo $adminLanguage->A_COMP_LANG_INSTALL;?></th>
		</tr>
	</table>
	<table class="adminlist">
		<tr>
			<th width="20">#</th>
			<!--<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" /></th> -->
			<th width="30">&nbsp;</th>
			<th width="25%" class="title"><?php echo $adminLanguage->A_COMP_LANG_LANG;?></th>
			<th width="5%"><?php echo $adminLanguage->A_COMP_PUBLISHED;?></th>
			<th width="10%"><?php echo $adminLanguage->A_COMP_ADMIN_VERSION;?></th>
			<th width="10%"><?php echo $adminLanguage->A_COMP_DATE;?></th>
			<th width="20%"><?php echo $adminLanguage->A_COMP_AUTHOR;?></th>
			<th width="25%"><?php echo $adminLanguage->A_COMP_LANG_EMAIL;?></th>
		</tr>
<?php
$k = 0;
for ($i=0, $n=count( $rows ); $i < $n; $i++) {
	$row = &$rows[$i];
?>
		<tr class="<?php echo "row$k"; ?>">
			<td width="20"><?php echo $pageNav->rowNumber( $i ); ?></td>
			<td width="20">
			  <input type="radio" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->language; ?>" onClick="isChecked(this.checked);" />
			</td>
			<td width="25%">
			<a href="#edit" onclick="return listItemTask('cb<?php echo $i;?>','edit_source')"><?php echo $row->name;?></a></td>
			<td width="5%" align="center">
<?php		if ($row->published == 1) {	 ?>
				<img src="images/tick.png" alt="<?php echo $adminLanguage->A_COMP_PUBLISHED;?>">
<?php		} else { ?>
				&nbsp;
<?php		} ?>
			</td>
			<td align=center><?php echo $row->version; ?></td>
			<td align=center><?php echo $row->creationdate; ?></td>
			<td align=center><?php echo $row->author; ?></td>
			<td align=center><?php echo $row->authorEmail; ?></td>
		</tr>
<?php
}
	?>
	</table>
	<?php echo $pageNav->getListFooter(); ?>

	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	</form>
<?php
	}

	function editLanguageSource( $language, &$content, $option ) {
		global $mosConfig_absolute_path, $adminLanguage;
?>
	<form action="index2.php" method="post" name="adminForm">
	<table class="adminheading">
		<tr>
			<th class="langmanager"><?php echo $adminLanguage->A_COMP_LANG_EDITOR;?></th>
		</tr>
	</table>
	<table class="adminform">
		<tr>
			<th colspan="4"><?php echo $adminLanguage->A_COMP_LANG_FILE;?>/<?php echo "$language.php"; ?> <?php echo $adminLanguage->A_COMP_CONF_IS;?>:
			<?php echo is_writable( $mosConfig_absolute_path . "/language/" . $language . ".php" ) ? '<b><font color="green">'.
            $adminLanguage->A_COMP_CONF_WRT .'</font></b>' : '<b><font color="red">'. $adminLanguage->A_COMP_CONF_UNWRT .'</font></b>' ?>
			</th>
		</tr>
		<tr>
			<td><textarea cols="110" rows="22" name="filecontent" class="inputbox"><?php echo $content; ?></textarea></td>
		</tr>
	</table
	><input type="hidden" name="language" value="<?php echo $language; ?>" />
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="task" value="" />
	</form>
<?php
	}

}
?>
