<?php
/**
* @version $Id: admin.categories.html.php,v 1.3 2004/10/05 15:07:49 dappa Exp $
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
class categories_html {

	/**
	* Writes a list of the categories for a section
	* @param array An array of category objects
	* @param string The name of the category section
	*/
	function show( &$rows, $section, $section_name, $myid, &$pageNav, &$lists, $type ) {
		global $my, $adminLanguage;
		/*echo "<pre>";
		print_R($rows);		*/
		?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<?php
			if ( $section == 'content') {
				?>
				<th class="categories">
				<?php echo $adminLanguage->A_COMP_CATEG_MANAGER;?>
				</th>
				<td>
				<?php echo $adminLanguage->A_COMP_FILTER;?>:
				</td>
				<td width="right"> 
				<?php echo $lists['sectionid'];?> 
				</td>
				<?php
			} else {
				?>
				<th class="categories">
				<?php echo $section_name;?>
<?php echo $adminLanguage->A_COMP_CATEG_CATEGS;?>
				</th>
				<?php
			}
			?>
		</tr>
		</table>
		
		<table class="adminlist">
		<tr>
			<th width="20">
			#
			</th>
			<th width="20">
			<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows );?>);" />
			</th>
			<th class="title">
			<?php echo $adminLanguage->A_COMP_CATEG_NAME;?>
			</th>
			<th width="10%">
            <?php echo $adminLanguage->A_COMP_PUBLISHED;?>
			</th>
			<?php
			if ( $section <> 'content') {
				?>
				<th colspan="2">
                <?php echo $adminLanguage->A_COMP_REORDER;?>
				</th>
				<?php
			}
			?>
			<th width="10%">
            <?php echo $adminLanguage->A_COMP_ACCESS;?>
			</th>
			<?php
			if ( $section == 'content') {
				?>
				<th width="12%" align="left">
                <?php echo $adminLanguage->A_COMP_SECTION;?>
				</th>
				<?php
			}
			?>
			<th width="12%">
            <?php echo $adminLanguage->A_COMP_CATEG_ID;?>
			</th>
			<th width="12%">
            <?php echo $adminLanguage->A_COMP_ACTIVE;?>
			</th>
			<?php
			if ( $type == 'content') {
				?>
				<th width="12%">
                <?php echo $adminLanguage->A_COMP_TRASH;?>
				</th>
				<?php
			}
			?>
			<th width="12%">
            <?php echo $adminLanguage->A_COMP_CHECKED_OUT;?>
			</th>
		  </tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];
			$img = $row->published ? 'tick.png' : 'publish_x.png';
			$task = $row->published ? 'unpublish' : 'publish';
			$alt = $row->published ? 'Published' : 'Unpublished';
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
				<td width="20" align="right">
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td width="20">
				<?php echo mosHTML::idBox( $i, $row->id, ($row->checked_out_contact_category && $row->checked_out_contact_category != $my->id ) ); ?>
				</td>
				<td width="35%">
				<?php
				if ( $row->checked_out_contact_category && ( $row->checked_out_contact_category != $my->id ) ) {
					?>
<?php echo $row->name .' ( '. $row->title .' )'; ?>
					&nbsp;[ <i><?php echo $adminLanguage->A_COMP_CHECKED_OUT;?></i> ]
					<?php
				} else {
					?>
					<a href="#edit" onClick="return listItemTask('cb<?php echo $i;?>','edit')">
					<?php echo $row->name .' ( '. $row->title .' )'; ?>
					</a>
					<?php
				}
				?>
				</td>
				<td align="center">
				<a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
				<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt;?>" />
				</a>
				</td>
				<?php
				if ( $section <> 'content' ) {
					?>
					<td>
					<?php echo $pageNav->orderUpIcon( $i ); ?>
					</td>
					<td>
					<?php echo $pageNav->orderDownIcon( $i, $n ); ?>
					</td>
					<?php
				}
				?>
				<td align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task_access;?>')" <?php echo $color_access; ?>>
				<?php echo $row->groupname;?>
				</a>
				</td>
				<?php
				if ( $section == 'content' ) {
					?>
					<td align="left">
					<?php echo $row->section_name; ?>
					</td>
					<?php
				}
				?>
				<td align="center">
				<?php echo $row->id; ?>
				</td>
				<td align="center">
				<?php echo $row->active; ?>
				</td>
				<?php
				if ( $type == 'content') {
					?>
					<td align="center">
					<?php echo $row->trash; ?>
					</td>
					<?php 
				} ?>
				<td align="center">
				<?php  echo $row->checked_out_contact_category ? $row->editor : ""; ?>				
				</td>
				<?php		
				$k = 1 - $k; 
				?>
			</tr>
			<?php	
		} 
		?>
		</table>
		<?php echo $pageNav->getListFooter(); ?>
	
		<input type="hidden" name="option" value="com_categories" />
		<input type="hidden" name="section" value="<?php echo $section;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="chosen" value="" />
		<input type="hidden" name="act" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="type" value="<?php echo $type; ?>" />
		</form>
		<?php
	}

	/**
	* Writes the edit form for new and existing categories
	* @param mosCategory The category object
	* @param string
	* @param array
	*/
	function edit( &$row, $section, &$lists, $redirect, $menus ) {
		global $mosConfig_live_site, $adminLanguage;
		if ($row->image == "") {
			$row->image = 'blank.png';
		}
		mosMakeHtmlSafe( $row, ENT_QUOTES, 'description' );
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton, section) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			if ( pressbutton == 'menulink' ) {
				if ( form.menuselect.value == "" ) {
					alert( "<?php echo $adminLanguage->A_COMP_SELECT_MENU;?>" );
					return;
				} else if ( form.link_type.value == "" ) {
					alert( "<?php echo $adminLanguage->A_COMP_SELECT_MENU_TYPE;?>" );
					return;
				} else if ( form.link_name.value == "" ) {
					alert( "<?php echo $adminLanguage->A_COMP_ENTER_MENU_NAME;?>" );
					return;
				} else if ( confirm("<?php echo $adminLanguage->A_COMP_CREATE_MENU_LINK;?>" ) ){
					submitform( pressbutton );
				} else {
					return;
				}
			}

			if ( form.name.value == "" ) {
				alert("<?php echo $adminLanguage->A_COMP_CATEG_MUST_NAME;?>");
			} else {
				<?php getEditorContents( 'editor1', 'description' ) ; ?>
				submitform(pressbutton);
			}
		}
		</script>
	
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th class="categories">
			<?php echo $row->id ? $adminLanguage->A_COMP_EDIT : $adminLanguage->A_COMP_ADD;?> <?php echo $adminLanguage->A_COMP_CATEG;?> <?php echo $row->name; ?>
			</th>
		</tr>
		</table>

		<table width="100%">
		<tr>
			<td valign="top">
				<table class="adminform">
				<tr>
					<th colspan="3">
                    <?php echo $adminLanguage->A_COMP_CATEG_DETAILS;?>
					</th>
				<tr>
				<tr>
					<td>
					<?php echo $adminLanguage->A_COMP_CATEG_TITLE;?>
					</td>
					<td colspan="2">
					<input class="text_area" type="text" name="title" value="<?php echo $row->title; ?>" size="50" maxlength="50" title="<?php echo $adminLanguage->A_COMP_SECT_SHORT_NAME;?>" />
					</td>
				</tr>
				<tr>
					<td>
					<?php echo $adminLanguage->A_COMP_CATEG_NAME;?>:
					</td>
					<td colspan="2">
					<input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255" title="<?php echo $adminLanguage->A_COMP_SECT_LONG_NAME;?>" />
					</td>
				</tr>
				<tr>
					<td>
					<?php echo $adminLanguage->A_COMP_SECTION;?>:
					</td>
					<td colspan="2">
					<?php echo $lists['section']; ?>
					</td>
				</tr>
				<tr>
					<td>
					<?php echo $adminLanguage->A_COMP_IMAGE;?>:
					</td>
					<td>
					<?php echo $lists['image']; ?>
					</td>
					<td rowspan="4" width="50%">
					<script language="javascript" type="text/javascript">
					if (document.forms[0].image.options.value!=''){
					  jsimg='../images/stories/' + getSelectedValue( 'adminForm', 'image' );
					} else {
					  jsimg='../images/M_images/blank.png';
					}
					document.write('<img src=' + jsimg + ' name="imagelib" width="80" height="80" border="2" alt="Preview" />');
					</script>
					</td>
				</tr>
				<tr>
					<td>
					<?php echo $adminLanguage->A_COMP_IMAGE_POSITION;?>:
					</td>
					<td>
					<?php echo $lists['image_position']; ?>
					</td>
				</tr>
				<tr>
					<td>
					<?php echo $adminLanguage->A_COMP_ORDERING;?>:
					</td>
					<td>
					<?php echo $lists['ordering']; ?>
					</td>
				</tr>
				<tr>
					<td>
					<?php echo $adminLanguage->A_COMP_ACCESS_LEVEL;?>:
					</td>
					<td>
					<?php echo $lists['access']; ?>
					</td>
				</tr>
				<tr>
					<td>
					<?php echo $adminLanguage->A_COMP_PUBLISHED;?>:
					</td>
					<td>
					<?php echo $lists['published']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top">
					<?php echo $adminLanguage->A_COMP_DESCRIPTION;?>:
					</td>
					<td colspan="2">
					<?php
					// parameters : areaname, content, hidden field, width, height, rows, cols
					editorArea( 'editor1',  $row->description , 'description', '500', '200', '50', '5' ) ; ?>
					</td>
				</tr>
				</table>
			</td>
			<td valign="top">
			<?php
			if ( $row->section > 0 ) {
    				?>				
				<table class="adminform">
				<tr>
					<th colspan="2">
					<?php echo $adminLanguage->A_COMP_LINK_TO_MENU;?>
					</th>
				<tr>
				<tr>
					<td colspan="2">
					<?php echo $adminLanguage->A_COMP_CREATE_MENU;?>
					<br /><br />
					</td>
				<tr>
				<tr>
					<td valign="top" width="100px">
					<?php echo $adminLanguage->A_COMP_SELECT_MENU;?>
					</td>
					<td>
					<?php echo $lists['menuselect']; ?>
					</td>
				<tr>
				<tr>
					<td valign="top" width="100px">
					<?php echo $adminLanguage->A_COMP_MENU_TYPE;?>
					</td>
					<td>
					<?php echo $lists['link_type']; ?>
					</td>
				<tr>
				<tr>
					<td valign="top" width="100px">
					<?php echo $adminLanguage->A_COMP_MENU_NAME;?>
					</td>
					<td>
					<input type="text" name="link_name" class="inputbox" value="" size="25" />
					</td>
				<tr>
				<tr>
					<td>
					</td>
					<td>
					<input name="menu_link" type="button" class="button" value="<?php echo $adminLanguage->A_COMP_LINK_TO_MENU;?>" onClick="submitbutton('menulink');" />
					</td>
				<tr>
				<tr>
					<th colspan="2">
					<?php echo $adminLanguage->A_COMP_MENU_LINKS;?>
					</th>
				</tr>
				<?php
				if ( $menus == NULL ) {
					?>
					<tr>
						<td colspan="2">
						<?php echo $adminLanguage->A_COMP_NONE;?>
						</td>
					</tr>
					<?php
				} else {
					foreach( $menus as $menu ) {
						?>
						<tr>
							<td colspan="2">
							<hr/>
							</td>
						</tr>
						<tr>
							<td width="90px" valign="top" align="right">
							<strong>
							<?php echo $adminLanguage->A_COMP_MENU;?>
							</strong>
							</td>
							<td>
							<?php echo $menu->menutype; ?>  
							</td>
						</tr>
						<tr>
							<td width="90px" valign="top" align="right">
							<strong>
							<?php echo $adminLanguage->A_COMP_TYPE;?>
							</strong>
							</td>
							<td>
							<?php echo $menu->type; ?>  
							</td>
						</tr>
						<tr>
							<td width="90px" valign="top" align="right">
							<strong>
							<?php echo $adminLanguage->A_COMP_ITEM_NAME;?>
							</strong>
							</td>
							<td>
							<strong>
							<?php echo $menu->name; ?>  
							</strong>
							</td>
						</tr>
						<tr>
							<td width="90px" valign="top" align="right">
							<strong>
							<?php echo $adminLanguage->A_COMP_STATE;?>
							</strong>
							</td>
							<td>
							<?php 
							switch ( $menu->published ) {
								case -2:
									echo "<font color=\"red\">".$adminLanguage->A_COMP_TRASHED."</font>";
									break;
								case 0:
									echo $adminLanguage->A_COMP_UNPUBLISHED;
									break;
								case 1:
								default:
									echo "<font color=\"green\">".$adminLanguage->A_COMP_PUBLISHED."</font>";
									break;
							}	
							?>
							</td>
						</tr>
						<?php
					}
				}
				?>
				<tr>
					<td colspan="2">
					</td>
				</tr>
				</table>
				<?php
			}
			?>
			</td>
		</tr>
		</table>

		<input type="hidden" name="option" value="com_categories" />
		<input type="hidden" name="oldtitle" value="<?php echo $row->title ; ?>" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="sectionid" value="<?php echo $row->section; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
		</form>
		<?php 
	}


	/**
	* Form to select Section to move Category to
	*/
	function moveCategorySelect( $option, $cid, $SectionList, $items, $sectionOld, $contents, $redirect ) {
        global $adminLanguage;
		?>
		<form action="index2.php" method="post" name="adminForm">
		<br />
		<table class="adminheading">
		<tr>
			<th class="categories">
			<?php echo $adminLanguage->A_COMP_CATEG_MOVE;?>
			</th>
		</tr>
		</table>
		
		<br />
		<table class="adminform">
		<tr>
			<td width="3%"></td>
			<td align="left" valign="top" width="30%">
			<strong><?php echo $adminLanguage->A_COMP_CATEG_MOVE_TO_SECTION;?>:</strong>
			<br />
			<?php echo $SectionList ?>
			<br /><br />
			</td>
			<td align="left" valign="top" width="20%">
			<strong><?php echo $adminLanguage->A_COMP_CATEG_BEING_MOVED;?>:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $items as $item ) {
				echo "<li>". $item->name ."</li>"; 
			}
			echo "</ol>";
			?>
			</td>
			<td valign="top" width="20%">
			<strong><?php echo $adminLanguage->A_COMP_CATEG_CONTENT;?>:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $contents as $content ) {
				echo "<li>". $content->title ."</li>"; 
			}
			echo "</ol>";
			?>
			</td>
			<td valign="top">
			<?php echo $adminLanguage->A_COMP_CATEG_MOVE_CATEG;?>
			<br />
			<?php echo $adminLanguage->A_COMP_CATEG_ALL_ITEMS;?>
			<br />
			<?php echo $adminLanguage->A_COMP_CATEG_TO_SECTION;?>
			</td>.
		</tr>
		</table>
		<br /><br />
		
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="section" value="<?php echo $sectionOld;?>" />
		<input type="hidden" name="boxchecked" value="1" />
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
		<input type="hidden" name="task" value="" />
		<?php
		foreach ( $cid as $id ) {
			echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
		}
		?>
		</form>
		<?php
	}


	/**
	* Form to select Section to copy Category to
	*/
	function copyCategorySelect( $option, $cid, $SectionList, $items, $sectionOld, $contents, $redirect ) {
        global $adminLanguage;
		?>
		<form action="index2.php" method="post" name="adminForm">
		<br />
		<table class="adminheading">
		<tr>
			<th class="categories">
			<?php echo $adminLanguage->A_COMP_CATEG_COPY;?>
			</th>
		</tr>
		</table>
		
		<br />
		<table class="adminform">
		<tr>
			<td width="3%"></td>
			<td align="left" valign="top" width="30%">
			<strong><?php echo $adminLanguage->A_COMP_CATEG_COPY_TO_SECTION;?>:</strong>
			<br />
			<?php echo $SectionList ?>
			<br /><br />
			</td>
			<td align="left" valign="top" width="20%">
			<strong><?php echo $adminLanguage->A_COMP_CATEG_BEING_COPIED;?>:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $items as $item ) {
				echo "<li>". $item->name ."</li>"; 
			}
			echo "</ol>";
			?>
			</td>
			<td valign="top" width="20%">
			<strong><?php echo $adminLanguage->A_COMP_CATEG_ITEMS_COPIED;?>:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $contents as $content ) {
				echo "<li>". $content->title ."</li>"; 
				echo "\n <input type=\"hidden\" name=\"item[]\" value=\"$content->id\" />";
			}
			echo "</ol>";
			?>
			</td>
			<td valign="top">
			<?php echo $adminLanguage->A_COMP_CATEG_COPY_CATEGS;?>
			<br />
			<?php echo $adminLanguage->A_COMP_CATEG_ALL_ITEMS;?>
			<br />
			<?php echo $adminLanguage->A_COMP_CATEG_TO_SECTION;?>
			</td>.
		</tr>
		</table>
		<br /><br />
		
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="section" value="<?php echo $sectionOld;?>" />
		<input type="hidden" name="boxchecked" value="1" />
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
		<input type="hidden" name="task" value="" />
		<?php
		foreach ( $cid as $id ) {
			echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
		}
		?>
		</form>
		<?php
	}

} 
?>
