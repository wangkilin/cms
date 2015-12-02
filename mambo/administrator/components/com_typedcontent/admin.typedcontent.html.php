<?php
/**
* @version $Id: admin.typedcontent.html.php,v 1.2 2004/10/11 03:36:33 dappa Exp $
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
class HTML_typedcontent {

	/**
	* Writes a list of the content items
	* @param array An array of content objects
	*/
	function showContent( &$rows, &$pageNav, $option, $search, &$lists ) {
		global $my, $mosConfig_live_site, $adminLanguage;
		?>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th class="edit">
			<?php echo $adminLanguage->A_COMP_TYPED_STATIC;?>
			</th>
			<td>
			<?php echo $adminLanguage->A_COMP_FILTER;?>:&nbsp;
			</td>
			<td>
			<input type="text" name="search" value="<?php echo $search;?>" class="text_area" onChange="document.adminForm.submit();" />
			</td>
			<td>
			&nbsp;&nbsp;&nbsp;<?php echo $adminLanguage->A_COMP_FRONT_ORDER;?>:&nbsp;
			</td>
			<td>
			<?php echo $lists['order']; ?>
			</td>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="5px">
			<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
			<th class="title" width="40%">
			<?php echo $adminLanguage->A_COMP_TITLE;?>
			</th>
			<th width="5%">
			<?php echo $adminLanguage->A_COMP_PUBLISHED;?>
			</th>
			<th width="10%">
			<?php echo $adminLanguage->A_COMP_ACCESS;?>
			</th>
			<th width="5%">
			<?php echo $adminLanguage->A_COMP_ID;?>
			</th>
			<th width="10%" align="left">
			<?php echo $adminLanguage->A_COMP_AUTHOR;?>
			</th>
			<th width="1%" align="left">
			<?php echo $adminLanguage->A_COMP_TYPED_LINKS;?>
			</th>
			<th width="10%" nowrap="nowrap" align="center">
			<?php echo $adminLanguage->A_COMP_CHECKED_OUT;?>
			</th>
			<th></th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];
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
			$link = 'index2.php?option=com_typedcontent&task=edit&id='. $row->id;
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo mosHTML::idBox( $i, $row->id, ($row->checked_out && $row->checked_out != $my->id ) ); ?>
				</td>
				<td>
				<?php
				if ( $row->checked_out && ( $row->checked_out != $my->id ) ) {
					?>
					<?php 
					echo $row->title; 
					if ( $row->title_alias ) {
						echo ' (<i>'. $row->title_alias .'</i>)'; 
					}
					?>
					[ <i><?php echo $adminLanguage->A_COMP_CHECKED_OUT;?></i> ]
					<?php
				} else {
					?>
					<a href="<?php echo $link; ?>">
					<?php 
					echo $row->title; 
					if ( $row->title_alias ) {
						echo ' (<i>'. $row->title_alias .'</i>)'; 
					}
					?>
					</a>
					<?php
				}
				?>
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
				if (isset($row->publish_up)) {
					if ($row->publish_up == '0000-00-00 00:00:00') {
						$times .= "<tr><td>". $adminLanguage->A_COMP_CONTENT_START_ALWAYS ."</td></tr>";
					} else {
						$times .= "<tr><td>". $adminLanguage->A_COMP_CONTENT_START .": ". $row->publish_up ."</td></tr>";
					}
				}
				if (isset($row->publish_down)) {
					if ($row->publish_down == '0000-00-00 00:00:00') {
						$times .= "<tr><td>". $adminLanguage->A_COMP_CONTENT_FIN_NOEXP ."</td></tr>";
					} else {
						$times .= "<tr><td>". $adminLanguage->A_COMP_CONTENT_FINISH .": ". $row->publish_down ."</td></tr>";
					}
				}
				if ( $times ) {
					?>
					<td align="center">
					<a href="javascript: void(0);" onMouseOver="return overlib('<table><?php echo $times; ?></table>', CAPTION, '<?php echo $adminLanguage->A_COMP_CONTENT_PUBLISH_INFO;?>', BELOW, RIGHT);" onMouseOut="return nd();" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $row->state ? $adminLanguage->A_COMP_UNPUBLISHED : $adminLanguage->A_COMP_PUBLISHED;?>')">
					<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
					</a>
					</td>
					<?php
				}
				?>
				<td align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task_access;?>')" <?php echo $color_access; ?>>
				<?php echo $row->groupname;?>
				</a>
				</td>
				<td align="center">
				<?php echo $row->id;?>
				</td>
				<td align="left">
				<?php echo $row->creator;?>
				</td>
				<td align="center">
				<?php echo $row->links;?>
				</td>
				<td align="left" colspan="2">
				<?php
				if ($row->checked_out) {
					?>
					<?php echo $row->editor; ?>
					<?php
				} else {
					?>
					&nbsp;
					<?php
				}
				?>
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
		<br />

		<?php
		mosCommonHTML::ContentLegend();
		?>
	    <script language="Javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
		<?php
	}

	function edit( &$row, &$images, &$lists, $myid, &$params, $option, &$menus ) {
		global $mosConfig_live_site, $adminLanguage;
		//mosMakeHtmlSafe( $row );
		$tabs = new mosTabs(0);
		// used to hide "Reset Hits" when hits = 0
		if ( !$row->hits ) {
			$visibility = "style='display: none; visbility: hidden;'";
		} else {
			$visibility = "";
		}
		?>

		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo $mosConfig_live_site; ?>/includes/js/calendar/calendar-mos.css" title="green" />
		<!-- import the calendar script -->
		<script type="text/javascript" src="<?php echo $mosConfig_live_site; ?>/includes/js/calendar/calendar.js"></script>
		<!-- import the language module -->
		<script type="text/javascript" src="<?php echo $mosConfig_live_site; ?>/includes/js/calendar/lang/calendar-en.js"></script>
		<script language="javascript" type="text/javascript">
		var folderimages = new Array;
		<?php
		$i = 0;
		foreach ($images as $k=>$items) {
			foreach ($items as $v) {
				echo "\n	folderimages[".$i++."] = new Array( '$k','".addslashes( $v->value )."','".addslashes( $v->text )."' );";
			}
		}
		?>

		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			if ( pressbutton ==' resethits' ) {
				if (confirm('<?php echo $adminLanguage->A_COMP_CONTENT_ZERO;?>')){
					submitform( pressbutton );
					return;
				} else {
					return;
				}
			}

			if ( pressbutton == 'menulink' ) {
				if ( form.menuselect.value == "" ) {
					alert( "<?php echo $adminLanguage->A_COMP_SECT_SEL_MENU;?>" );
					return;
				} else if ( form.link_name.value == "" ) {
					alert( "<?php echo $adminLanguage->A_COMP_ENTER_MENU_NAME;?>" );
					return;
				} else if ( confirm('<?php echo $adminLanguage->A_COMP_TYPED_ARE_YOU;?>') ){
					submitform( pressbutton );
				} else {
					return;
				}
			}

			var temp = new Array;
			for (var i=0, n=form.imagelist.options.length; i < n; i++) {
				temp[i] = form.imagelist.options[i].value;
			}
			form.images.value = temp.join( '\n' );

			try {
				document.adminForm.onsubmit();
			}
			catch(e){}
			if (trim(form.title.value) == ""){
				alert( "<?php echo $adminLanguage->A_COMP_TEMP;?>Content item must have a title" );
			} else if (trim(form.name.value) == ""){
				alert( "<?php echo $adminLanguage->A_COMP_TEMP;?>Content item must have a name" );
			} else {
				if ( form.reset_hits.checked ) {
					form.hits.value = 0;
				} else {
				}
				<?php getEditorContents( 'editor1', 'introtext' ) ; ?>
				submitform( pressbutton );
			}
		}

		</script>

		<table class="adminheading">
		<tr>
			<th>
			<?php echo $row->id ? $adminLanguage->A_COMP_EDIT : $adminLanguage->A_COMP_ADD;?>
            <?php echo $adminLanguage->A_COMP_TYPED_CONTENT;?>
			</th>
		</tr>
		</table>

		<form action="index2.php" method="post" name="adminForm">

		<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td width="60%" valign="top">
				<table class="adminform">
				<tr>
					<th colspan="3">
					<?php echo $adminLanguage->A_COMP_CONTENT_ITEM_DETAILS;?>
					</th>
				<tr>
				<tr>
					<td align="left">
					<?php echo $adminLanguage->A_COMP_TITLE;?>:
					</td>
					<td>
					<input class="inputbox" type="text" name="title" size="30" maxlength="100" value="<?php echo $row->title; ?>" />
					</td>
				</tr>
				<tr>
					<td align="left">
					<?php echo $adminLanguage->A_COMP_CONTENT_TITLE_ALIAS;?>:
					</td>
					<td>
					<input class="inputbox" type="text" name="title_alias" size="30" maxlength="100" value="<?php echo $row->title_alias; ?>" />
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" colspan="2">
					<?php echo $adminLanguage->A_COMP_TYPED_TEXT;?><br />
					<?php
					// parameters : areaname, content, hidden field, width, height, rows, cols
					editorArea( 'editor1',  $row->introtext, 'introtext', 500, 400, '65', '50' );
					?>
					</td>
				</tr>
				</table>
			</td>
			<td width="40%" valign="top">
				<?php
				$tabs->startPane("content-pane");
				$tabs->startTab($adminLanguage->A_COMP_CONT_PUB_TAB, "publish-page" );
				?>
				<table class="adminform">
				<tr>
					<th colspan="2">
					<?php echo $adminLanguage->A_COMP_CONT_PUBLISHING;?>
					</th>
				<tr>
				<tr>
					<td valign="top" align="right">
					<?php echo $adminLanguage->A_COMP_STATE;?>:
					</td>
					<td>
					<?php echo $row->state > 0 ? $adminLanguage->A_COMP_PUBLISHED : $adminLanguage->A_COMP_CONTENT_DRAFT_UNPUB; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<?php echo $adminLanguage->A_COMP_PUBLISHED;?>:
					</td>
					<td>
					<input type="checkbox" name="published" value="1" <?php echo $row->state ? 'checked="checked"' : ''; ?> />
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<?php echo $adminLanguage->A_COMP_ACCESS_LEVEL;?>:
					</td>
					<td>
					<?php echo $lists['access']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<?php echo $adminLanguage->A_COMP_CONTENT_AUTHOR;?>:
					</td>
					<td>
					<input type="text" name="created_by_alias" size="30" maxlength="100" value="<?php echo $row->created_by_alias; ?>" class="inputbox" />
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<?php echo $adminLanguage->A_COMP_CONTENT_CREATOR;?>:
					</td>
					<td>
					<?php echo $lists['created_by']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<?php echo $adminLanguage->A_COMP_CONTENT_OVERRIDE;?>
					</td>
					<td>
					<input class="inputbox" type="text" name="created" id="created" size="25" maxlength="19" value="<?php echo $row->created; ?>" />
					<input name="reset" type="reset" class="button" onClick="return showCalendar('created', 'y-mm-dd');" value="...">
					</td>
				</tr>
				<tr>
					<td width="20%" align="right">
					<?php echo $adminLanguage->A_COMP_CONTENT_START_PUB;?>:
					</td>
					<td width="80%">
					<input class="inputbox" type="text" name="publish_up" id="publish_up" size="25" maxlength="19" value="<?php echo $row->publish_up; ?>" />
					<input type="reset" class="button" value="..." onclick="return showCalendar('publish_up', 'y-mm-dd');">
					</td>
				</tr>
				<tr>
					<td width="20%" align="right">
					<?php echo $adminLanguage->A_COMP_CONTENT_FINISH_PUB;?>:
					</td>
					<td width="80%">
					<input class="inputbox" type="text" name="publish_down" id="publish_down" size="25" maxlength="19" value="<?php echo $row->publish_down; ?>" />
					<input type="reset" class="button" value="..." onclick="return showCalendar('publish_down', 'y-mm-dd');">
					</td>
				</tr>
				</table>
				<br />
				<table class="adminform">
				<tr>
					<td width="90px" valign="top" align="right">
					<strong><?php echo $adminLanguage->A_COMP_STATE;?></strong>
					</td>
					<td>
					<?php echo $row->state > 0 ? $adminLanguage->A_COMP_PUBLISHED : ($row->state < 0 ? $adminLanguage->A_COMP_ARCHIVED : $adminLanguage->A_COMP_CONTENT_DRAFT_UNPUB );?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<strong><?php echo $adminLanguage->A_COMP_HITS;?></strong>
					</td>
					<td>
					<?php echo $row->hits;?>
					<div <?php echo $visibility; ?>>
					<input name="reset_hits" type="button" class="button" value="<?php echo $adminLanguage->A_COMP_CONTENT_RESET_HIT;?>" onClick="submitbutton('resethits');">
					</div>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<strong><?php echo $adminLanguage->A_COMP_ADMIN_VERSION;?></strong>
					</td>
					<td>
					<?php echo "$row->version";?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<strong><?php echo $adminLanguage->A_CREATED;?></strong>
					</td>
					<td>
					<?php echo $row->created ? $row->created ."</td></tr><tr><td valign='top' align='right'><strong>". $adminLanguage->A_COMP_CONTENT_BY ."</strong></td><td>". $row->creator : $adminLanguage->A_COMP_CONTENT_NEW_DOC;?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<strong><?php echo $adminLanguage->A_COMP_TEMP;?>Last Modified</strong>
					</td>
					<td>
					<?php echo $row->modified ? $row->modified ."</td></tr><tr><td valign='top' align='right'><strong>". $adminLanguage->A_COMP_CONTENT_BY ."</strong></td><td>". $row->modifier : $adminLanguage->A_COMP_CONTENT_NOT_MOD;?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<strong><?php echo $adminLanguage->A_COMP_TYPED_EXPIRES;?></strong>
					</td>
					<td>
					<?php echo "$row->publish_down";?>
					</td>
				</tr>
				</table>
				<?php
				$tabs->endTab();
				$tabs->startTab($adminLanguage->A_COMP_CONT_IMG_TAB, "images-page" );
				?>
				<table class="adminform">
				<tr>
					<th colspan="2">
					<?php echo $adminLanguage->A_COMP_CONTENT_MOSIMAGE;?>
					</th>
				<tr>
				<tr>
					<td colspan="6">
					<?php echo $adminLanguage->A_COMP_CONTENT_SUB_FOLDER;?>: <?php echo $lists['folders'];?>
					</td>
				</tr>
				<tr>
					<td>
					<?php echo $adminLanguage->A_COMP_CONTENT_GALLERY;?>
					<br />
					<?php echo $lists['imagefiles'];?>
					<br />
					<input class="button" type="button" value="<?php echo $adminLanguage->A_COMP_ADD;?>" onClick="addSelectedToList('adminForm','imagefiles','imagelist')" />
					</td>
					<td valign="top">
					<img name="view_imagefiles" src="../images/M_images/blank.png" width="100" />
					</td>
				</tr>
				<tr>
					<td>
					<?php echo $adminLanguage->A_COMP_CONTENT_IMAGES;?>:
					<br />
					<?php echo $lists['imagelist'];?>
					<br />
					<input class="button" type="button" value="<?php echo $adminLanguage->A_COMP_CONTENT_UP;?>up" onClick="moveInList('adminForm','imagelist',adminForm.imagelist.selectedIndex,-1)" />
					<input class="button" type="button" value="<?php echo $adminLanguage->A_COMP_CONTENT_DOWN;?>" onClick="moveInList('adminForm','imagelist',adminForm.imagelist.selectedIndex,+1)" />
					<input class="button" type="button" value="<?php echo $adminLanguage->A_COMP_CONTENT_REMOVE;?>" onClick="delSelectedFromList('adminForm','imagelist')" />
					</td>
					<td valign="top">
					<img name="view_imagelist" src="../images/M_images/blank.png" width="100" />
					</td>
				</tr>
				<tr>
					<td>
					<?php echo $adminLanguage->A_COMP_CONTENT_EDIT_IMAGE;?>:
						<table>
						<tr>
							<td align="right">
							<?php echo $adminLanguage->A_COMP_SOURCE;?>
							</td>
							<td>
							<input type="text" name= "_source" value="" />
							</td>
						</tr>
						<tr>
							<td align="right">
							<?php echo $adminLanguage->A_COMP_CONTENT_ALIGN;?>
							</td>
							<td>
							<?php echo $lists['_align']; ?>
							</td>
						</tr>
						<tr>
							<td align="right">
							<?php echo $adminLanguage->A_COMP_CONTENT_ALT;?>
							</td>
							<td>
							<input type="text" name="_alt" value="" />
							</td>
						</tr>
						<tr>
							<td align="right">
							<?php echo $adminLanguage->A_COMP_CONTENT_BORDER;?>
							</td>
							<td>
							<input type="text" name="_border" value="" size="3" maxlength="1" />
							</td>
						</tr>
						<tr>
							<td align="right"></td>
							<td>
							<input class="button" type="button" value="<?php echo $adminLanguage->A_COMP_CONTENT_APPLY;?>" onClick="applyImageProps()" />
							</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
				<?php
				$tabs->endTab();
				$tabs->startTab($adminLanguage->A_COMP_CONT_PARAMETERS, "params-page" );
				?>
				<table class="adminform">
				<tr>
					<th colspan="2">
					<?php echo $adminLanguage->A_COMP_CONTENT_PARAM;?>
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
				$tabs->startTab($adminLanguage->A_COMP_CONTENT_META_INFO, $adminLanguage->A_COMP_CONF_META_PAGE );
				?>
				<table class="adminform">
				<tr>
					<th colspan="2">
					<?php echo $adminLanguage->A_COMP_CONTENT_META_DATA;?>
					</th>
				<tr>
				<tr>
					<td align="left">
					<?php echo $adminLanguage->A_COMP_DESCRIPTION;?>:<br />
					<textarea class="inputbox" cols="40" rows="5" name="metadesc" style="width:300px"><?php echo str_replace('&','&amp;',$row->metadesc); ?></textarea>
					</td>
				</tr>
				<tr>
					<td align="left">
					<?php echo $adminLanguage->A_COMP_CONTENT_KEYWORDS;?>:<br />
					<textarea class="inputbox" cols="40" rows="5" name="metakey" style="width:300px"><?php echo str_replace('&','&amp;',$row->metakey); ?></textarea>
					</td>
				</tr>
				</table>
				<?php
				$tabs->endTab();
				if ($row->id) {
				$tabs->startTab($adminLanguage->A_COMP_CONTENT_LINK_TO_MENU, "link-page" );
				?>
				<table class="adminform">
				<tr>
					<th colspan="2">
					<?php echo $adminLanguage->A_COMP_LINK_TO_MENU;?>
					</th>
				<tr>
				<tr>
					<td colspan="2">
					<?php echo $adminLanguage->A_COMP_TYPED_WILL;?>
					<br /><br />
					</td>
				<tr>
				<tr>
					<td valign="top" width="90px">
					<?php echo $adminLanguage->A_COMP_SELECT_MENU;?>
					</td>
					<td>
					<?php echo $lists['menuselect']; ?>
					</td>
				<tr>
				<tr>
					<td valign="top" width="90px">
					<?php echo $adminLanguage->A_COMP_MENU_NAME;?>
					</td>
					<td>
					<input type="text" name="link_name" class="inputbox" value="" size="30" />
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
							<hr />
							</td>
						</tr>
						<tr>
							<td width="90px" valign="top">
							<?php echo $adminLanguage->A_COMP_MENU;?>
							</td>
							<td>
							<?php echo $menu->menutype; ?>
							</td>
						</tr>
						<tr>
							<td width="90px" valign="top">
							<?php echo $adminLanguage->A_COMP_CONTENT_LINK_NAME;?>
							</td>
							<td>
							<strong>
							<?php echo $menu->name; ?>
							</strong>
							</td>
						</tr>
						<tr>
							<td width="90px" valign="top">
							<?php echo $adminLanguage->A_COMP_STATE;?>
							</td>
							<td>
							<?php
							switch ( $menu->published ) {
								case -2:
									echo '<font color="red">'. $adminLanguage->A_COMP_TRASHED .'</font>';
									break;
								case 0:
									echo $adminLanguage->A_COMP_UNPUBLISHED;
									break;
								case 1:
								default:
									echo '<font color="green">'. $adminLanguage->A_COMP_PUBLISHED .'</font>';
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
				$tabs->endTab();
				}
				$tabs->endPane();
				?>
		    </td>
		</tr>
		</table>

		<input type="hidden" name="images" value="" />
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="hits" value="<?php echo $row->hits; ?>" />
		<input type="hidden" name="task" value="" />
		</form>
				<script language="Javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
		<?php
	}
}
?>
