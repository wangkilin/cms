<?php
/**
* @version $Id: admin.newsfeeds.html.php,v 1.1 2004/10/02 17:52:29 mibi Exp $
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
class HTML_newsfeeds {

	function showNewsFeeds( &$rows, &$lists, $pageNav, $option ) {
		global $my, $adminLanguage;
		?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>
			<?php echo $adminLanguage->A_COMP_FEED_TITLE;?>
			</th>
			<td width="right"> 
			<?php echo $lists['category'];?> 
			</td>
		</tr>
		</table>
	
		<table class="adminlist">
		<tr>
			<th width="20">
			<?php echo $adminLanguage->A_COMP_NB;?>
			</th>
			<th width="20">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
			<th class="title" width="25%">
			<?php echo $adminLanguage->A_COMP_FEED_NEWS;?>
			</th>
			<th class="title">
			<?php echo $adminLanguage->A_COMP_CATEG;?>
			</th>
			<th>
			<?php echo $adminLanguage->A_COMP_FEED_ARTICLES;?>
			</th>
			<th>
			<?php echo $adminLanguage->A_COMP_FEED_CACHE;?>
			</th>
			<th>
			<?php echo $adminLanguage->A_COMP_PUBLISHED;?>
			</th>
			<th>
			<?php echo $adminLanguage->A_COMP_CHECKED_OUT;?>
			</th>
			<th colspan="2">
			<?php echo $adminLanguage->A_COMP_REORDER;?>
			</th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];
			$img = $row->published ? 'tick.png' : 'publish_x.png';
			$task = $row->published ? $adminLanguage->A_COMP_MAMB_UNPUB : $adminLanguage->A_COMP_MAMB_PUB;
			$alt = $row->published ? $adminLanguage->A_COMP_PUBLISHED : $adminLanguage->A_COMP_UNPUBLISHED;
			?>
			<tr class="<?php echo 'row'. $k; ?>">
				<td align="center">
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td>
				<?php echo mosHTML::idBox( $i, $row->id, ($row->checked_out && $row->checked_out != $my->id ) ); ?>
				</td>
				<td>
				<?php
				if ( $row->checked_out && ( $row->checked_out != $my->id ) ) {
					?>
					<?php echo $row->name; ?>
					&nbsp;[ <i><?php echo $adminLanguage->A_COMP_CHECKED_OUT;?></i> ]
					<?php
				} else {
					?>
					<a href="#edit" onclick="return listItemTask('cb<?php echo $i;?>','edit')">
					<?php echo $row->name; ?> 
					</a>
					<?php
				}
				?>
				</td>
				<td>
				<?php echo $row->catname;?>
				</td>
				<td align="center">
				<?php echo $row->numarticles;?>
				</td>
				<td align="center">
				<?php echo $row->cache_time;?>
				</td>
				<td width="10%" align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
				<img src="images/<?php echo $img;?>" border="0" alt="<?php echo $alt; ?>" />
				</a>
				</td>
				<td align="center">
				<?php echo $row->checked_out != '' ? $row->editor : "&nbsp;"; ?>
				</td>
				<td align="center">
				<?php echo $pageNav->orderUpIcon( $i ); ?>
				</td>
				<td align="center">
				<?php echo $pageNav->orderDownIcon( $i, $n ); ?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
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


	function editNewsFeed( &$row, &$lists, $option ) {
        global $adminLanguage;
        mosMakeHtmlSafe( $row, ENT_QUOTES );
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			if (form.name.value == '') {
				alert( "<?php echo $adminLanguage->A_COMP_FEED_FILL_NAME;?>" );
			} else if (form.catid.value == 0) {
				alert( "<?php echo $adminLanguage->A_COMP_FEED_SEL_CATEG;?>" );
			} else if (form.link.value == '') {
				alert( "<?php echo $adminLanguage->A_COMP_FEED_FILL_LINK;?>" );
			} else if (getSelectedValue('adminForm','catid') < 0) {
				alert( "<?php echo $adminLanguage->A_COMP_FEED_SEL_CATEG;?>" );
			} else if (form.numarticles.value == "" || form.numarticles.value == 0) {
				alert( "<?php echo $adminLanguage->A_COMP_FEED_FILL_NB;?>" );
			} else if (form.cache_time.value == "" || form.cache_time.value == 0) {
				alert( "<?php echo $adminLanguage->A_COMP_FEED_FILL_REFRESH;?>" );
			} else {
				submitform( pressbutton );
			}
		}
		</script>

		<form action="index2.php" method="post" name="adminForm">
		<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="sectionname">
			<?php echo $row->name;?> <?php echo $adminLanguage->A_COMP_FEED_NEWS;?>
			</td>
		</tr>
		</table>

		<table class="adminform">
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_NAME;?>
			</td>
			<td>
			<input class="inputbox" type="text" size="40" name="name" value="<?php echo $row->name; ?>">
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CATEG;?>
			</td>
			<td>
			<?php echo $lists['category']; ?>
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_FEED_LINK;?>
			</td>
			<td>
			<input class="inputbox" type="text" size="60" name="link" value="<?php echo $row->link; ?>">
			</td>
		</tr>
		<!--
		<tr>
			<td>
			File Name
			</td>
			<td>
			<input class="inputbox" type="text" size="60" name="filename" value="<?php //echo $row->filename; ?>">
			</td>
		</tr>
		-->
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_FEED_NB_ARTICLE;?>
			</td>
			<td>
			<input class="inputbox" type="text" size="2" name="numarticles" value="<?php echo $row->numarticles; ?>">
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_FEED_IN_SEC;?>
			</td>
			<td>
			<input class="inputbox" type="text" size="4" name="cache_time" value="<?php echo $row->cache_time; ?>">
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_ORDERING;?>
			</td>
			<td>
			<?php echo $lists['ordering']; ?>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">&nbsp;
			
			</td>
		</tr>
		</table>
	
		<input type="hidden" name="id" value="<?php echo $row->id; ?>">
		<input type="hidden" name="option" value="<?php echo $option; ?>">
		<input type="hidden" name="task" value="">
		</form>
	<?php
	}
}
?>
