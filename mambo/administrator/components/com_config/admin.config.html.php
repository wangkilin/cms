<?php
/**
* @version $Id: admin.config.html.php,v 1.5 2004/10/11 03:36:32 dappa Exp $
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
class HTML_config {

	function showconfig( &$row, &$lists, $option) {
		global $mosConfig_absolute_path, $mosConfig_live_site, $adminLanguage;
		$tabs = new mosTabs(0);
		?>

		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<table class="adminheading">
		<tr>
			<th class="config">
			<?php echo $adminLanguage->A_COMP_CONF_GC;?> :
			<span class="componentheading">
			configuration.php <?php echo $adminLanguage->A_COMP_CONF_IS;?> :
			 <?php echo is_writable( '../configuration.php' ) ? '<b><font color="green">'. $adminLanguage->A_COMP_CONF_WRT .'</font></b>' : '<b><font color="red">'. $adminLanguage->A_COMP_CONF_UNWRT .'</font></b>' ?>
			</span>
			</th>
		</tr>
		</table>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'save') {
				//if (confirm ("Are you sure?")) {
				submitform( pressbutton );
				//}
			} else {
				document.location.href = 'index2.php';
			}
		}
		</script>
		<form action="index2.php" method="post" name="adminForm">
		<?php
		$tabs->startPane("configPane");
		$tabs->startTab($adminLanguage->A_COMP_MAMB_SITE, "site-page" );
		?>
		<table class="adminform">
		<tr>
			<td width="185">
			<?php echo $adminLanguage->A_COMP_CONF_OFFLINE;?>:
			</td>
			<td><?php echo $lists['offline']; ?></td>
		</tr>
		<tr>
			<td valign="top">
			<?php echo $adminLanguage->A_COMP_CONF_OFFMESSAGE;?>:
			</td>
			<td> 
			<textarea class="text_area" cols="60" rows="2" style="width:500px; height:40px" name="config_offline_message"><?php echo $row->config_offline_message; ?></textarea>
			</td>
		</tr>
		<tr>
			<td valign="top">
			<?php echo $adminLanguage->A_COMP_CONF_ERR_MESSAGE;?>:
			</td>
			<td> 
			<textarea class="text_area" cols="60" rows="2" style="width:500px; height:40px" name="config_error_message"><?php echo $row->config_error_message; ?></textarea>
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_SITE_NAME;?>:
			</td>
			<td>
			<input class="text_area" type="text" name="config_sitename" size="50" value="<?php echo $row->config_sitename; ?>">
			</td>
		</tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_UN_LINKS;?>:
			</td>
			<td> 
			<?php echo $lists['auth']; ?> 
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_USER_REG;?>:
			</td>
			<td> 
			<?php echo $lists['allowuserregistration']; ?> 
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_AC_ACT;?>:
			</td>
			<td> 
			<?php echo $lists['useractivation']; ?> 
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_REQ_EMAIL;?>:
			</td>
			<td> 
			<?php echo $lists['uniquemail']; ?> 
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_DEBUG;?>:
			</td>
			<td> 
			<?php echo $lists['debug']; ?> 
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_EDITOR;?>:
			</td>
			<td> 
			<?php echo $lists['editor']; ?> 
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_LENGTH;?>:
			</td>
			<td>
			<?php echo $lists['list_length']; ?>
			</td>
		</tr>
		</table>
		<?php
		$tabs->endTab();
		$tabs->startTab($adminLanguage->A_COMP_CONF_LOCALE, "Locale-page" );
		?>
		<table class="adminform">
		<tr>
			<td width="185">
			<?php echo $adminLanguage->A_COMP_CONF_LANG;?>:
			</td>
			<td> 
			<?php echo $lists['lang']; ?> 
			</td>
		</tr>
			<td width="185">
			<?php echo $adminLanguage->A_COMP_CONF_ALANG;?>:
			</td>
			<td> 
			<?php echo $lists['alang']; ?> 
			</td>
		</tr>
		<tr>
			<td width="185">
			<?php echo $adminLanguage->A_COMP_CONF_TIME_SET;?>:
			</td>
			<td>
			<?php echo $lists['offset']; ?>
<?php
			$tip = $adminLanguage->A_COMP_CONF_DATE .": ". mosCurrentDate(_DATE_FORMAT_LC2);
			echo mosToolTip($tip);
			?>
			</td>
		</tr>
		<tr>
			<td width="185">
			<?php echo $adminLanguage->A_COMP_CONF_LOCAL;?>:
			</td>
			<td>
			<input class="text_area" type="text" name="config_locale" size="15" value="<?php echo $row->config_locale; ?>">
			</td>
		</tr>
		</table>
		<?php
		$tabs->endTab();
		$tabs->startTab($adminLanguage->A_COMP_MOD_CONTENT, "content-page" );
		?>
		<table class="adminform">
		<tr>
			<td colspan="2">
			<?php echo $adminLanguage->A_COMP_CONF_CONTROL;?>
			<br /><br />
			</td>
		</tr>
		<tr>
			<td width="200">
			<?php echo $adminLanguage->A_COMP_CONF_LINK_TITLES;?>:
			</td>
			<td width="100">
			<?php echo $lists['link_titles']; ?> 
			</td>
			<td width="*" align="left">
			<?php echo mosToolTip( $adminLanguage->A_COMP_CONF_HYPER ); ?>
			</td>
		</tr>
		<tr>
			<td width="200">
			<?php echo $adminLanguage->A_COMP_CONF_MORE_LINK;?>:
			</td>
			<td width="100">
			<?php echo $lists['readmore']; ?> 
			</td>
			<td align="left">&nbsp;
						
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_RATE_VOTE;?>:
			</td>
			<td>
			<?php echo $lists['vote']; ?>
			</td>
			<td align="left">&nbsp;
						
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_AUTHOR;?>:
			</td>
			<td>
			<?php echo $lists['hideauthor']; ?>
			</td>
			<td align="left">&nbsp;
						
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_CREATED;?>:
			</td>
			<td>
			<?php echo $lists['hidecreate']; ?>
			</td>
			<td align="left">&nbsp;
						
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_MOD_DATE;?>:
			</td>
			<td>
			<?php echo $lists['hidemodify']; ?>
			</td>
			<td align="left">&nbsp;
						
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_HITS;?>:
			</td>
			<td>
			<?php echo $lists['hits']; ?>
			</td>
			<td align="left">&nbsp;
						
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_PDF;?>:
			</td>
			<td>
			<?php echo $lists['hidepdf']; ?>
			</td>
			<?php
			if (!is_writable( "$mosConfig_absolute_path/media/" )) {
				echo "<td align=\"left\">";
				echo mosToolTip( $adminLanguage->A_COMP_CONF_OPT_MEDIA );
				echo "</td>";
			} else {
				?>
				<td align="left">&nbsp;
							
				</td>
				<?php
			}
			?>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_PRINT_ICON;?>:
			</td>
			<td>
			<?php echo $lists['hideprint']; ?>
			</td>
			<td align="left">&nbsp;
						
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_EMAIL_ICON;?>:
			</td>
			<td>
			<?php echo $lists['hideemail']; ?>
			</td>
			<td align="left">&nbsp;
						
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_ICONS;?>:
			</td>
			<td>
			<?php echo $lists['icons']; ?>
			</td>
			<td align="left">
			<?php echo mosToolTip( $adminLanguage->A_COMP_CONF_USE_OR_TEXT ); ?>
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_TBL_CONTENTS;?>:
			</td>
			<td>
			<?php echo $lists['multipage_toc']; ?>
			</td>
			<td align="left">&nbsp;
						
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_BACK_BUTTON;?>:
			</td>
			<td>
			<?php echo $lists['back_button']; ?>
			</td>
			<td align="left">&nbsp;
						
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_CONTENT_NAV;?>
			</td>
			<td>
			<?php echo $lists['item_navigation']; ?>
			</td>
			<td align="left">&nbsp;
						
			</td>
		</tr>
		</table>
		<?php
		$tabs->endTab();
		$tabs->startTab($adminLanguage->A_COMP_CONF_DB_NAME, "db-page" );
		?>
		<table class="adminform">
		<tr>
			<td width="185">
			<?php echo $adminLanguage->A_COMP_CONF_HOSTNAME;?>:
			</td>
			<td width="786">
			<input class="text_area" type="text" name="config_host" size="25" value="<?php echo $row->config_host; ?>">
			</td>
		</tr>
		<tr>
			<td width="185">
			MySQL <?php echo $adminLanguage->A_COMP_CONF_DB_USERNAME;?>:
			</td>
			<td>
			<input class="text_area" type="text" name="config_user" size="25" value="<?php echo $row->config_user; ?>">
			</td>
		</tr>
		<tr>
			<td width="185">
			MySQL <?php echo $adminLanguage->A_COMP_CONF_DB_PW;?>:
			</td>
			<td>
			<input class="text_area" type="text" name="config_password" size="25" value="<?php echo $row->config_password; ?>">
			</td>
		</tr>
		<tr>
			<td width="185">
			MySQL <?php echo $adminLanguage->A_COMP_CONF_DB_NAME;?>:
			</td>
			<td>
			<input class="text_area" type="text" name="config_db" size="25" value="<?php echo $row->config_db; ?>">
			</td>
		</tr>
		<tr>
			<td width="185">
			MySQL <?php echo $adminLanguage->A_COMP_CONF_DB_PREFIX;?>:
			</td>
			<td>
			<input class="text_area" type="text" name="config_dbprefix" size="10" value="<?php echo $row->config_dbprefix; ?>">
			&nbsp;<?php echo mosWarning( $adminLanguage->A_COMP_CONF_NOT_CH ); ?>
			</td>
		</tr>
		</table>
		<?php
		$tabs->endTab();
		$tabs->startTab($adminLanguage->A_COMP_CONF_SERVER, "server-page" );
		?>
		<table class="adminform">
		<tr>
			<td width="185">
			<?php echo $adminLanguage->A_COMP_CONF_ABS_PATH;?>:
			</td>
			<td>
			<strong>
			<?php echo $row->config_path; ?>
			</strong>
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_LIVE;?>:
			</td>
			<td>
			<strong>
			<?php echo $row->config_live_site; ?>
			</strong>
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_SECRET;?>:
			</td>
			<td>
			<strong>
			<?php echo $row->config_secret; ?>
			</strong>
			</td>
		</tr>
		<tr>
			<td width="185">
			<?php echo $adminLanguage->A_COMP_CONF_GZIP;?>:
			</td>
			<td> 
			<?php echo $lists['gzip']; ?>
<?php echo mosToolTip( $adminLanguage->A_COMP_CONF_CP_BUFFER ); ?>
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_SESSION_TIME;?>:
			</td>
			<td>
			<input class="text_area" type="text" name="config_lifetime" size="10" value="<?php echo $row->config_lifetime; ?>">
			&nbsp;<?php echo $adminLanguage->A_COMP_CONF_SEC;?>&nbsp;
			<?php echo mosToolTip( $adminLanguage->A_COMP_CONF_AUTO_LOGOUT ); ?>
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_ERR_REPORT;?>:
			</td>
			<td> 
			<?php echo $lists['error_reporting']; ?> 
			</td>
		</tr>
		</table>
		<?php
		$tabs->endTab();
		$tabs->startTab($adminLanguage->A_COMP_CONF_METADATA, "metadata-page" );
		?>
		<table class="adminform">
		<tr>
			<td width="185" valign="top">
			<?php echo $adminLanguage->A_COMP_CONF_META_DESC;?>:
			</td>
			<td> 
			<textarea class="text_area" cols="50" rows="3" style="width:500px; height:50px" name="config_metadesc"><?php echo $row->config_metadesc; ?></textarea>
			</td>
		</tr>
		<tr>
			<td width="185" valign="top">
			<?php echo $adminLanguage->A_COMP_CONF_META_KEY;?>:
			</td>
			<td> 
			<textarea class="text_area" cols="50" rows="3" style="width:500px; height:50px" name="config_metakeys"><?php echo $row->config_metakeys; ?></textarea>
			</td>
		</tr>
		<tr>
			<td valign="top">
			<?php echo $adminLanguage->A_COMP_CONF_META_TITLE;?>:
			</td>
			<td>
			<?php echo $lists['metatitle']; ?>
			&nbsp;&nbsp;&nbsp; 
			<?php echo mosToolTip( $adminLanguage->A_COMP_CONF_META_ITEMS ); ?>
			</td>
		  	</tr>
		<tr>
			<td valign="top">
			<?php echo $adminLanguage->A_COMP_CONF_META_AUTHOR;?>:
			</td>
			<td>
			<?php echo $lists['metaauthor']; ?>
			&nbsp;&nbsp;&nbsp; 
			<?php echo mosToolTip( $adminLanguage->A_COMP_CONF_META_AUTHOR ); ?>
			</td>
		</tr>
		</table>
		<?php
		$tabs->endTab();
		$tabs->startTab($adminLanguage->A_COMP_CONF_EMAIL, "mail-page" );
		?>
		<table class="adminform">
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_MAIL;?>:
			</td>
			<td>
			<?php echo $lists['mailer']; ?>
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_MAIL_FROM;?>:
			</td>
			<td>
			<input class="text_area" type="text" name="config_mailfrom" size="25" value="<?php echo $row->config_mailfrom; ?>">
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_MAIL_FROM_NAME;?>:
			</td>
			<td>
			<input class="text_area" type="text" name="config_fromname" size="25" value="<?php echo $row->config_fromname; ?>">
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_MAIL_SMTP_AUTH;?>:
			</td>
			<td>
			<?php echo $lists['smtpauth']; ?>
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_MAIL_SMTP_USER;?>:
			</td>
			<td>
			<input class="text_area" type="text" name="config_smtpuser" size="15" value="<?php echo $row->config_smtpuser; ?>">
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_MAIL_SMTP_PASS;?>:
			</td>
			<td>
			<input class="text_area" type="text" name="config_smtppass" size="12" value="<?php echo $row->config_smtppass; ?>">
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_MAIL_SMTP_HOST;?>:
			</td>
			<td>
			<input class="text_area" type="text" name="config_smtphost" size="20" value="<?php echo $row->config_smtphost; ?>">
			</td>
		</tr>
		</table>
		<?php
		$tabs->endTab();
		$tabs->startTab($adminLanguage->A_COMP_CONF_CACHE_TAB, "cache-page" );
		?>
		<table class="adminform" border="0">
		<?php
		if (is_writeable($row->config_cachepath)) {
			?>
			<tr>
				<td width="100">
				<?php echo $adminLanguage->A_COMP_CONF_CACHE;?>:
				</td>
				<td width="500"> 	
				<?php echo $lists['caching']; ?> 
				</td>
				<td width="*">&nbsp;
												
				</td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_CACHE_FOLDER;?>:
			</td>
			<td>
			<input class="text_area" type="text" name="config_cachepath" size="50" value="<?php echo $row->config_cachepath; ?>" />
			<?php 
			if (is_writeable($row->config_cachepath)) {
				echo mosToolTip( $adminLanguage->A_COMP_CONF_CACHE_DIR ." <b>". $adminLanguage->A_COMP_CONF_WRT ."</b>");
			} else {
				echo mosWarning( $adminLanguage->A_COMP_CONF_CACHE_DIR_UNWRT );
			}
			?>
			</td>
			<td align="left">&nbsp;
						
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_CACHE_TIME; ?>:
			</td>
			<td>
			<input class="text_area" type="text" name="config_cachetime" size="5" value="<?php echo $row->config_cachetime; ?>" /> 	
			<?php echo $adminLanguage->A_COMP_CONF_SEC;?>
			</td>
			<td align="left">&nbsp;
						
			</td>
		</tr>
		</table>
		<?php
		$tabs->endTab();
		$tabs->startTab($adminLanguage->A_MENU_STATISTICS, "stats-page" );
		?>
		<table class="adminform">
		<tr>
			<td width="200">
			<?php echo $adminLanguage->A_COMP_CONF_STATS;?>:
			</td>
			<td width="100">
			<?php echo $lists['enable_stats']; ?>
			</td>
			<td width="*" align="left">
			<?php echo mostooltip( $adminLanguage->A_COMP_CONF_STATS_ENABLE ); ?>
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_STATS_LOG_HITS;?>:
			</td>
			<td>
			<?php echo $lists['log_items']; ?>
			</td>
			<td align="left">
			<span class="error">
			<?php echo mosWarning( $adminLanguage->A_COMP_CONF_STATS_WARN_DATA ); ?>
			</span>
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_STATS_LOG_SEARCH;?>:
			</td>
			<td>
			<?php echo $lists['log_searches']; ?>
			</td>
			<td align="left">&nbsp;
						
			</td>
		</tr>
		</table>
		<?php
		$tabs->endTab();
		$tabs->startTab($adminLanguage->A_COMP_CONF_SEO_LBL, "seo-page" );
		?>
		<table class="adminform">
		<tr>
			<td width="200">
			<strong> 
			<?php echo $adminLanguage->A_COMP_CONF_SEO;?>
			</strong>
			</td>
			<td width="100">&nbsp;
			  
			</td>
			<td width="*" align="left">&nbsp;
			  
			</td>
		</tr>
		<tr>
			<td> 
			<?php echo $adminLanguage->A_COMP_CONF_SEO_SEFU;?>:
			</td>
			<td> 
			<?php echo $lists['sef']; ?>&nbsp; 
			</td>
			<td align="left">
			<span class="error">
			<?php echo mosWarning( $adminLanguage->A_COMP_CONF_SEO_APACHE ); ?>
			</span> 
			</td>
		</tr>
		<tr>
			<td>
			<?php echo $adminLanguage->A_COMP_CONF_SEO_DYN;?>:
			</td>
			<td>
			<?php echo $lists['pagetitles']; ?> 
			</td>
			<td align="left">
			<?php echo mosToolTip( $adminLanguage->A_COMP_CONF_SEO_DYN_TITLE ); ?>
			</td>
		</tr>
		</table>
		<?php
		$tabs->endTab();
		$tabs->endPane();
		?>

		<input type="hidden" name="option" value="<?php echo $option; ?>">
		<input type="hidden" name="config_path" value="<?php echo $row->config_path; ?>">
		<input type="hidden" name="config_live_site" value="<?php echo $row->config_live_site; ?>">
		<input type="hidden" name="config_secret" value="<?php echo $row->config_secret; ?>">
		<input type="hidden" name="task" value="">
		</form>
		<script language="Javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
		<?php
	}

}
?>
