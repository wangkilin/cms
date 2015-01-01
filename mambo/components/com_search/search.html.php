<?php
/**
* @version $Id: search.html.php,v 1.15 2004/09/07 04:30:03 eddieajau Exp $
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
class search_html {
	function openhtml( $searchword ) {
		?>
<table class="contentpaneopen">
	<tr>
		<td class="contentheading" width="100%"><?php echo _SEARCH_TITLE; ?></td>
	</tr>
</table>
	<?php
	}

	function searchbox( $searchword, &$lists ) {
		?>
<form action="index.php" method="post">
	<table class="contentpaneopen">
		<tr>
			<td nowrap="nowrap"><?php echo _PROMPT_KEYWORD; ?>:</td>
			<td nowrap="nowrap">
			<input type="text" name="searchword"size="15" value="<?php echo stripslashes($searchword);?>" class="inputbox" />
			</td>
			<td width="100%" nowrap="nowrap">
			<input type="submit" name="submit" value="<?php echo _SEARCH_TITLE;?>" class="button" />
			</td>
		</tr>
		<tr>
			<td colspan="3">
			<input type="radio" name="searchphrase" value="any" checked="checked" />
			<?php echo _SEARCH_ANYWORDS;?>
			<input type="radio" name="searchphrase" value="all" />
			<?php echo _SEARCH_ALLWORDS;?>
			<input type="radio" name="searchphrase" value="exact" />
			<?php echo _SEARCH_PHRASE;?>
			</td>
		</tr>
		<tr>
			<td colspan="3"><?php echo _CMN_ORDERING;?>: <?php echo $lists['ordering'];?></td>
		</tr>
	</table>
	<input type="hidden" name="option" value="com_search" />
</form>
		<?php
	}

	function searchintro( $searchword ) {
		?>
<table class="searchintro">
	<tr>
		<td colspan="3" align="left"><?php echo _PROMPT_KEYWORD . ' <b>' . stripslashes($searchword) . '</b>'; ?>

	<?php
	}

	function message( $message ) {
		?>
<table class="searchintro">
	<tr>
		<td colspan="3" align="left"><?php eval ('echo "'.$message.'";');	?></td>
	</tr>
</table>
	<?php
	}

	function displaynoresult() {
		?>
		</td>
	</tr>
	<?php
	}

	function display( &$rows ) {
		global $mosConfig_offset;
		$c = count ($rows);
		printf( _SEARCH_MATCHES, count( $rows ) );
		?>
		</td>
	</tr>
</table>
<br />
		<?php
		$tabclass = array("sectiontableentry1", "sectiontableentry2");
		$k = 0;
		?>
<table class="contentpaneopen">
		<?php
		foreach ($rows as $row) {
			if ($row->created) {
				$created = mosFormatDate ($row->created, '%d %B, %Y');
			} else {
				$created = '';
			}
			?>
	<tr class="<?php echo $tabclass[$k]; ?>">
		<td>
				<?php
				if ($row->browsernav == 1) {
					?>
				<a href="<?php echo sefRelToAbs($row->href); ?>" target="_blank">
				<?php
				} else {
					?>
				<a href="<?php echo sefRelToAbs($row->href); ?>">
				<?php
				}
				echo $row->title;
				?>
				</a>
				<span class="small">
				(<?php echo $row->section; ?>)
				</span>
		</td>
	</tr>
	<tr class="<?php echo $tabclass[$k]; ?>">
		<td><?php echo $row->text;?> &#133;</td>
	</tr>
	<tr>
		<td class="small"><?php echo $created; ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
			<?php
			$k = 1 - $k;
		}
	}

	function conclusion( $totalRows, $searchword ) {
		global $mosConfig_live_site;
		?>
	<tr>
		<td colspan="3">&nbsp;</td>
		</tr>
	<tr>
		<td colspan="3">
			<?php
			eval ('echo "'._CONCLUSION.'";');
			?>
			<a href="http://www.google.com/search?q=<?php echo stripslashes($searchword);?>" target="_blank">
			<img src="<?php echo $mosConfig_live_site;?>/images/M_images/google.png" border="0" align="texttop" />
			</a>
		</td>
	</tr>
</table>
		<?php
	}
}
?>