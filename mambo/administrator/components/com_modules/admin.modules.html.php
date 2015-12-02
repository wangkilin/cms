<?php
/**
* @version $Id: admin.modules.html.php,v 1.2 2004/10/11 03:36:33 dappa Exp $
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
class HTML_modules {

	/**
	* Writes a list of the defined modules
	* @param array An array of category objects
	*/
	function showModules( &$rows, $myid, $client, &$pageNav, $option ) {
		global $adminLanguage;
        ?>
		<form action="index2.php" method="post" name="adminForm">
	
		<table class="adminheading">
		<tr>
			<th class="modules">
			<?php echo $client == 'admin' ? $adminLanguage->A_COMP_MAMB_ADMIN : $adminLanguage->A_COMP_MAMB_SITE;?>
            <?php echo $adminLanguage->A_COMP_MOD_MANAGER;?>
			</th>
		</tr>
		</table>
	
		<table class="adminlist">
		<tr>
			<th width="20px">#</th>
			<th width="20px">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
			</th>
			<th class="title" width="30%">
			<?php echo $adminLanguage->A_COMP_MOD_NAME;?>
			</th>
			<th nowrap="nowrap" width="10%">
			<?php echo $adminLanguage->A_COMP_PUBLISHED;?>
			</th>
			<th colspan="2" nowrap="nowrap" width="5%">
			<?php echo $adminLanguage->A_COMP_REORDER;?>
			</th>
			<th nowrap="nowrap" width="7%">
			<?php echo $adminLanguage->A_COMP_ACCESS;?>
			</th>
			<th nowrap="nowrap" width="7%">
			<?php echo $adminLanguage->A_COMP_MOD_POSITION;?>
			</th>
			<th nowrap="nowrap" width="5%">
			<?php echo $adminLanguage->A_COMP_MOD_PAGES;?>
			</th>
			<th nowrap="nowrap" width="5%">
			<?php echo $adminLanguage->A_COMP_ID;?>
			</th>
			<th nowrap="nowrap" width="10%" align="left">
			<?php echo $adminLanguage->A_COMP_TYPE;?>
			</th>
			<th nowrap="nowrap" width="10%">
			<?php echo $adminLanguage->A_COMP_CHECKED_OUT;?>
			</th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];
			$img = $row->published ? 'publish_g.png' : 'publish_x.png';
			$task = $row->published ? 'unpublish' : 'publish';
			$alt = $row->published ? $adminLanguage->A_COMP_PUBLISHED : $adminLanguage->A_COMP_UNPUBLISHED;
			if ( !$row->access ) {
				$color_access = 'style="color: green;"';
				$task_access = 'accessregistered';
			} else if ( $row->access == 1 ) {
				$color_access = 'style="color: red;"';
				$task_access = 'accessspecial';
			} else {
				$color_access = 'style="color: black;"';
				$task_access = 'accesspublic';
			}
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="right">
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td><?php echo mosHTML::idBox( $i, $row->id, ($row->checked_out && $row->checked_out != $myid ) ); ?></td>
				<td>
				<a href="#edit" onclick="return listItemTask('cb<?php echo $i;?>','edit')">
				<?php echo $row->title; ?>
				</a>
				</td>
				<td align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
				<img src="images/<?php echo $img;?>" border="0" alt="<?php echo $alt; ?>" />
				</a>
				</td>
				<td><?php echo $pageNav->orderUpIcon( $i, ($row->position == @$rows[$i-1]->position) ); ?></td>
				<td><?php echo $pageNav->orderDownIcon( $i, $n, ($row->position == @$rows[$i+1]->position) ); ?>
				<td align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task_access;?>')" <?php echo $color_access; ?>>
				<?php echo $row->groupname;?>
				</a>
				</td>
				<td align="center">
				<?php echo $row->position; ?>
				</td>
				<td align="center">
				<?php
				if (is_null( $row->pages )) {
					echo $adminLanguage->A_COMP_NONE;
				} else if ($row->pages > 0) {
					echo $adminLanguage->A_COMP_MOD_VARIES;
				} else {
					echo $adminLanguage->A_COMP_MOD_ALL;
				}
				?>
				</td>
				<td align="center">
				<?php echo $row->id;?>
				</td>
				<td align="left">
				<?php echo $row->module ? $row->module : $adminLanguage->A_COMP_MOD_USER;?>
				</td>
				<td align="center">
				<?php echo $row->editor; ?>&nbsp;
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
		<input type="hidden" name="client" value="<?php echo $client;?>" />
		<input type="hidden" name="boxchecked" value="0" />
		</form>
		<?php
	}

	/**
	* Writes the edit form for new and existing module
	*
	* A new record is defined when <var>$row</var> is passed with the <var>id</var>
	* property set to 0.
	* @param mosCategory The category object
	* @param array <p>The modules of the left side.  The array elements are in the form
	* <var>$leftorder[<i>order</i>] = <i>label</i></var>
	* where <i>order</i> is the module order from the db table and <i>label</i> is a
	* text label associciated with the order.</p>
	* @param array See notes for leftorder
	* @param array An array of select lists
	* @param object Parameters
	*/
	function editModule( &$row, &$orders2, &$lists, &$params, $option ) {
		global $mosConfig_live_site;
		global $adminLanguage;
		$tabs = new mosTabs(0);
		?>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
	   
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			if ( ( pressbutton == 'save' ) && ( document.adminForm.title.value == "" ) ) {
				alert("<?php echo $adminLanguage->A_COMP_MOD_MUST_TITLE;?>");
			} else {
				<?php if ($row->module == "") {
					getEditorContents( 'editor1', 'content' );
				}?>
				submitform(pressbutton);
			}
			submitform(pressbutton);
		}
		<!--
		var originalOrder = '<?php echo $row->ordering;?>';
		var originalPos = '<?php echo $row->position;?>';
		var orders = new Array();	// array in the format [key,value,text]
		<?php	$i = 0;
		foreach ($orders2 as $k=>$items) {
			foreach ($items as $v) {
				echo "\n	orders[".$i++."] = new Array( \"$k\",\"$v->value\",\"$v->text\" );";
			}
		}
		?>
		//-->
		</script>
		<table class="adminheading">
		<tr>
			<th class="modules">
			<?php echo $row->id ? 'Edit' : 'New';?> 
			<?php echo $lists['client_id'] ? $adminLanguage->A_COMP_MAMB_ADMIN : $adminLanguage->A_COMP_MAMB_SITE;?>
			<?php echo $adminLanguage->A_COMP_MOD_MODULE;?> ->
			<?php echo $row->title; ?>
			</th>
		</tr>
		</table>
	
		<form action="index2.php" method="post" name="adminForm">
	
		<table cellspacing="0" cellpadding="0" width="100%">
		<tr valign="top">
			<td width="60%" valign="top">
				<table class="adminform">
					<tr>
						<th colspan="2">
						<?php echo $adminLanguage->A_COMP_MOD_DETAILS;?>
						</th>
					<tr>
					<tr>
						<td width="100" align="left">
						<?php echo $adminLanguage->A_COMP_TITLE;?>:
						</td>
						<td>
						<input class="text_area" type="text" name="title" size="35" value="<?php echo $row->title; ?>" />
						</td>
	
					</tr>
					<!-- START selectable pages -->
					<tr>
						<td width="100" align="left">
						<?php echo $adminLanguage->A_COMP_MOD_SHOW_TITLE;?>:
						</td>
						<td>
						<?php echo $lists['showtitle']; ?>
						</td>
					</tr>
					<tr>
						<td valign="top" align="left">
						<?php echo $adminLanguage->A_COMP_MOD_POSITION;?>:
						</td>
						<td>
						<?php echo $lists['position']; ?>
						</td>
					</tr>
					<tr>
						<td valign="top" align="left">
						<?php echo $adminLanguage->A_COMP_MOD_ORDER;?>:
						</td>
						<td>
						<script language="javascript" type="text/javascript">
						<!--
						writeDynaList( 'class="inputbox" name="ordering" size="1"', orders, originalPos, originalPos, originalOrder );
						//-->
						</script>
						</td>
					</tr>
					<tr>
						<td valign="top" align="left">
						<?php echo $adminLanguage->A_COMP_ACCESS_LEVEL;?>:
						</td>
						<td>
						<?php echo $lists['access']; ?>
						</td>
					</tr>
					<tr>
						<td valign="top">
						<?php echo $adminLanguage->A_COMP_PUBLISHED;?>:
						</td>
						<td>
						<?php echo $lists['published']; ?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
						</td>
					</tr>
					<tr>
						<td valign="top">
						<?php echo $adminLanguage->A_COMP_ID;?>:
						</td>
						<td>
						<?php echo $row->id; ?>
						</td>
					</tr>
					<!-- END selectable pages -->
					<?php
					if ($row->module == "") {
						?>
						<tr>
							<td valign="top" align="left">
							<?php echo $adminLanguage->A_COMP_MOD_CONTENT;?>:
							</td>
							<td>
							<?php
							// parameters : areaname, content, hidden field, width, height, rows, cols
							editorArea( 'editor1',  $row->content , 'content', '500', '350', '70', '15' ) ; ?>
							</td>
						</tr>
						<?php
					} ?>
					</table>
				</td>
				<td width="40%">
					<table width="100%">
					<tr>
						<td>
						<?php
						$tabs->startPane("module");
						$tabs->startTab($adminLanguage->A_COMP_MOD_TAB_LBL ,"location-page");
						?>
						<table width="100%" class="adminform">
						<tr>
							<th>
							<?php echo $adminLanguage->A_COMP_MOD_POSITION;?>
							</th>
						<tr>
						<tr>
							<td>
							<?php echo $adminLanguage->A_COMP_MOD_ITEM_LINK;?>:
							<br /><br />
							<?php echo $lists['selections']; ?>
							</td>
						</tr>
						</table>
						<?php
						$tabs->endTab();
						$tabs->startTab($adminLanguage->A_COMP_CONT_PARAMETERS, "params-page" );
						?>
						<table class="adminform">
						<tr>
							<th >
							<?php echo $adminLanguage->A_COMP_CONT_PARAMETERS;?>
							</th>
						<tr>
						<tr>
							<td>
							<?php echo $params->render();?>
							</td>
						</tr>
						</table>
						<?php
						$tabs->endTab();
						$tabs->endPane();
						?>
						</td>
					</tr>
					</table>
				</td>
			</tr>
		</table>
	
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="original" value="<?php echo $row->ordering; ?>" />
		<input type="hidden" name="module" value="<?php echo $row->module; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="client_id" value="<?php echo $lists['client_id']; ?>" />
		<?php
		if ( $row->client_id || $lists['client_id'] ) {
			echo '<input type="hidden" name="client" value="admin" />';
		}
		?>
		</form>
		<script language="Javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
		<?php
	}

}
?>
