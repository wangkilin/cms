<?php
/**
* @version $Id: admin.frontpage.html.php,v 1.2 2004/10/02 03:41:55 mibi Exp $
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
class HTML_content {
	/**
	* Writes a list of the content items
	* @param array An array of content objects
	*/
	function showList( &$rows, $search, $pageNav, $option ) {
		global $my, $adminLanguage;
		global $mosConfig_live_site;
		?>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th class="frontpage">
			<?php echo $adminLanguage->A_COMP_FRONT_PAGE_ITEMS;?>
			</th>
			<td>
			<?php echo $adminLanguage->A_COMP_FILTER;?>:
			</td>
			<td> 
			<input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
			</td>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="20"> 
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
			<th class="title" width="50%">
			<?php echo $adminLanguage->A_COMP_TITLE;?>
			</th>
			<th width="10%" nowrap="nowrap">
			<?php echo $adminLanguage->A_COMP_PUBLISHED;?>
			</th>
			<th colspan="2" nowrap="nowrap">
			<?php echo $adminLanguage->A_COMP_REORDER;?>
			</th>
			<th width="10%" nowrap="nowrap">
			<?php echo $adminLanguage->A_COMP_ACCESS;?>
			</th>
			<th width="15%" align="left">
			<?php echo $adminLanguage->A_COMP_CATEG;?>
			</th>
			<th>
			<?php echo $adminLanguage->A_COMP_FRONT_ORDER;?>
			</th>
			<th width="10%" nowrap="nowrap">
			<?php echo $adminLanguage->A_COMP_CHECKED_OUT;?>
			</th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td width="20">
				<?php echo mosHTML::idBox( $i, $row->id, ($row->checked_out && $row->checked_out != $my->id ) ); ?>
				</td>
				<td>
				<?php echo $row->title; ?> 
				</td>
				<?php
				$now = date( "Y-m-d h:i:s" );
				if ( $now <= $row->publish_up && $row->state == "1" ) {
					$img = 'publish_y.png';
					$alt = $adminLanguage->A_COMP_PUBLISHED;
				} else if ( ( $now <= $row->publish_down || $row->publish_down == "0000-00-00 00:00:00" ) && $row->state == "1" ) {
					$img = 'publish_g.png';
					$alt = $adminLanguage->A_COMP_PUBLISHED;
				} else if ( $now > $row->publish_down && $row->state == "1" ) {
					$img = 'publish_r.png';
					$alt = $adminLanguage->A_COMP_EXPIRED;
				} elseif ( $row->state == "0" ) {
					$img = "publish_x.png";
					$alt = $adminLanguage->A_COMP_UNPUBLISHED;
				}
				
				$times = '';
				    if ( isset( $row->publish_up ) ) {
						  if ( $row->publish_up == '0000-00-00 00:00:00' ) {
								$times .= "<tr><td>". $adminLanguage->A_COMP_CONTENT_START_ALWAYS ."</td></tr>";
						  } else {
								$times .= "<tr><td>". $adminLanguage->A_COMP_CONTENT_START .": ". $row->publish_up ."</td></tr>";
						  }
				    }
				    if ( isset( $row->publish_down ) ) {
						  if ( $row->publish_down == '0000-00-00 00:00:00' ) {
								$times .= "<tr><td>". $adminLanguage->A_COMP_CONTENT_FIN_NOEXP ."</td></tr>";
						  } else {
						  $times .= "<tr><td>". $adminLanguage->A_COMP_CONTENT_FINISH .": ". $row->publish_down ."</td></tr>";
						  }
				    }
				if ( $times ) {
					?>
					<td align="center">
					<a href="javascript: void(0);" onmouseover="return overlib('<table><?php echo $times; ?></table>', CAPTION, 'Publish Information', BELOW, RIGHT);" onMouseOut="return nd();" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $row->state ? "unpublish" : "publish";?>')">
					<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt;?>" />
					</a>
					</td>
					<?php
				}
				?>
				<td>
				<?php echo $pageNav->orderUpIcon( $i ); ?>
				</td>
				<td>
				<?php echo $pageNav->orderDownIcon( $i, $n ); ?>
				</td>
				<td align="center">
				<?php echo $row->groupname;?>
				</td>
				<td>
				<?php echo $row->name; ?>
				</td>
				<td align="center">
				<?php echo $row->fpordering;?>
				</td>
				<?php
				if (	$row->checked_out ) { 
					?>
					<td align="center">
					<?php echo $row->editor; ?>
					</td>
					<?php		
				} else { 
					?>
					<td align="center">&nbsp;</td>
					<?php		
				} 
				?>
			</tr>
			<?php		
			$k = 1 - $k; 
		} 
		?>
		</table>
		<?php echo $pageNav->getListFooter();?>

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		</form>
		<br />
	
		<?php
		mosCommonHTML::ContentLegend();
		?>
		<script language="Javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
		<?php
	}
}
?>
