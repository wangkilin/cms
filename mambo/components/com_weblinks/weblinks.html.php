<?php
/**
* @version $Id: weblinks.html.php,v 1.33 2004/09/26 09:11:18 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/HTML_toolbar.php' );

/**
* @package Mambo_4.5.1
*/
class HTML_weblinks {

	function displaylist( &$categories, &$rows, $catid, $currentcat=NULL, &$params, $tabclass ) {
		global $Itemid, $mosConfig_live_site, $hide_js;
		if ( $params->get( 'page_title' ) ) {
			?>
			<div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
			<?php echo $currentcat->header; ?>
			</div>
			<?php
		}
		?>
		<form action="index.php" method="post" name="adminForm">

		<table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" class="contentpane<?php echo $params->get( 'pageclass_sfx' ); ?>">
		<tr>
			<td width="60%" valign="top" class="contentdescription<?php echo $params->get( 'pageclass_sfx' ); ?>" colspan="2">
			<?php 
			// show image
			if ( $currentcat->img ) {
				?>
				<img src="<?php echo $currentcat->img; ?>" align="<?php echo $currentcat->align; ?>" hspace="6" alt="<?php echo _WEBLINKS_TITLE; ?>" />
				<?php 
			}
			echo $currentcat->descrip;
			?>
			</td>
		</tr>
		<tr>
			<td>
			<?php
			if ( count( $rows ) ) {
				HTML_weblinks::showTable( $params, $rows, $catid, $tabclass );
			}
			?>
			</td>
		</tr>
		<tr>	
			<td>&nbsp;
						
			</td>
		</tr>
		<tr>
			<td>
			<?php 
			if ( $params->get( 'other_cat' ) ) {
				HTML_weblinks::showCategories( $params, $categories, $catid );
			}
			?>
			</td>
		</tr>
		</table>
		</form>
		<?php
		// displays back button
		mosHTML::BackButton ( $params, $hide_js );
	}

	/**
	* Display Table of items
	*/
	function showTable( &$params, &$rows, $catid, $tabclass ) {
		global $mosConfig_live_site;
		// icon in table display
		$img = mosAdminMenus::ImageCheck( 'weblink.png', '/images/M_images/',$params->get( 'weblink_icons' ) );
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<?php
		if ( $params->get( 'headings' ) ) {
			?>
			<tr>
				<?php 
				if ( $img ) {
					?>
					<td class="sectiontableheader<?php echo $params->get( 'pageclass_sfx' ); ?>">&nbsp;
													
					</td>
					<?php 
				}
				?>
				<td width="90%" height="20" class="sectiontableheader<?php echo $params->get( 'pageclass_sfx' ); ?>">
				<?php echo _HEADER_TITLE_WEBLINKS; ?>
				</td>
				<?php 
				if ( $params->get( 'hits' ) ) {
					?>
					<td width="30px" height="20" class="sectiontableheader<?php echo $params->get( 'pageclass_sfx' ); ?>" align="right">
					<?php echo _HEADER_HITS; ?>
					</td>
					<?php 
				}
				?>
			</tr>
			<?php 
		} 

		$k = 0;
		foreach ($rows as $row) {
			$link = 'index.php?option=com_weblinks&amp;task=view&amp;catid='. $catid .'&amp;id='. $row->id;
			?>
			<tr class="<?php echo $tabclass[$k]; ?>">
				<?php 
				if ( $img ) {
					?>
					<td width="100px" height="20" align="center"> 
					&nbsp;&nbsp;<?php echo $img;?>&nbsp;&nbsp;
					</td>
					<?php 
				} 
				?>
				<td height="20"> 
				<a href="<?php echo sefRelToAbs( $link ); ?>" target="_blank" class="category<?php echo $params->get( 'pageclass_sfx' ); ?>">
				<?php echo $row->title; ?> 
				</a> 
				<?php 
				if ( $params->get( 'item_description' ) ) {
					?>
					<br /> 
					<?php echo $row->description; ?>
					<?php 
				} 
				?>
				</td>
				<?php 
				if ( $params->get( 'hits' ) ) {
					?>
					<td align="center">
					<?php echo $row->hits; ?>
					</td>
					<?php 
				} 
				?>
			</tr>
			<?php	
			$k = 1 - $k;
		} 
		?>
		</table>
		<?php 
	}

	/**
	* Display links to categories
	*/
	function showCategories( &$params, &$categories, $catid ) {
		global $mosConfig_live_site, $Itemid;
		?>
		<ul>
		<?php
		foreach ( $categories as $cat ) {
			if ( $catid == $cat->catid ) {
				?>	
				<li>
					<b>
					<?php echo $cat->name;?>
					</b>
					&nbsp;
					<span class="small">
					(<?php echo $cat->numlinks;?>)
					</span>
				</li>
				<?php		
			} else {
				$link = 'index.php?option=com_weblinks&amp;catid='. $cat->catid .'&amp;Itemid='. $Itemid;
				?>	
				<li>
					<a href="<?php echo sefRelToAbs( $link ); ?>" class="category<?php echo $params->get( 'pageclass_sfx' ); ?>">
					<?php echo $cat->name;?> 
					</a>
					&nbsp;
					<span class="small">
					(<?php echo $cat->numlinks;?>)
					</span>
				</li>
				<?php		
			}
		}
		?>
		</ul>
		<?php
	}

	/**
	* Writes the edit form for new and existing record (FRONTEND)
	*
	* A new record is defined when <var>$row</var> is passed with the <var>id</var>
	* property set to 0.
	* @param mosWeblink The weblink object
	* @param string The html for the categories select list
	*/
	function editWeblink( $option, &$row, &$lists ) {
		$Returnid = intval( mosGetParam( $_REQUEST, 'Returnid', 0 ) );
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
		
			// do field validation
			if (form.title.value == ""){
				alert( "Weblink item must have a title" );
			} else if (getSelectedValue('adminForm','catid') < 1) {
				alert( "You must select a category." );
			} else if (form.url.value == ""){
				alert( "You must have a url." );
			} else {
				submitform( pressbutton );
			}
		}
		</script>

		<form action="<?php echo sefRelToAbs("index.php"); ?>" method="post" name="adminForm" id="adminForm">
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="contentheading">
			<?php echo _SUBMIT_LINK;?>
			</td>
			<td width="10%">
			<?php
			mosToolBar::startTable();
			mosToolBar::spacer();
			mosToolBar::save();
			mosToolBar::cancel();
			mosToolBar::endtable();
			?>
			</td>
		</tr>
		</table>

		<table cellpadding="4" cellspacing="1" border="0" width="100%">
		<tr>
			<td width="20%" align="right">
			<?php echo _NAME; ?>
			</td>
			<td width="80%">
			<input class="inputbox" type="text" name="title" size="50" maxlength="250" value="<?php echo htmlspecialchars( $row->title, ENT_QUOTES );?>" />
			</td>
		</tr>
		<tr>
			<td valign="top" align="right">
			<?php echo _SECTION; ?>
			</td>
			<td>
			<?php echo $lists['catid']; ?>
			</td>
		</tr>
		<tr>
			<td valign="top" align="right">
			<?php echo _URL; ?>
			</td>
			<td>
			<input class="inputbox" type="text" name="url" value="<?php echo $row->url; ?>" size="50" maxlength="250" />
			</td>
		</tr>
		<tr>
			<td valign="top" align="right">
			<?php echo _URL_DESC; ?>
			</td>
			<td>
			<textarea class="inputbox" cols="30" rows="6" name="description" style="width:300px" width="300"><?php echo htmlspecialchars( $row->description, ENT_QUOTES );?></textarea>
			</td>
		</tr>
		</table>

		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="ordering" value="<?php echo $row->ordering; ?>" />
		<input type="hidden" name="approved" value="<?php echo $row->approved; ?>" />
		<input type="hidden" name="Returnid" value="<?php echo $Returnid; ?>" />
		</form>
		<?php
	}

}
?>