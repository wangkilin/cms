<?php
/**
* @version $Id: mod_fullmenu.php,v 1.3 2004/10/12 03:40:25 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Full DHTML Admnistrator Menus
* @package Mambo_4.5.1
*/
class mosFullAdminMenu {
	/**
	* Show the menu
	* @param string The current user type
	*/
	function show( $usertype='' ) {
		global $acl, $database;
		global $mosConfig_live_site, $mosConfig_enable_stats, $mosConfig_caching, $adminLanguage;

		// cache some acl checks
		$canConfig = $acl->acl_check( 'administration', 'config', 'users', $usertype );

		$manageTemplates = $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_templates' );
		$manageTrash = $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_trash' );
		$manageMenuMan = $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_menumanager' );
		$manageLanguages = $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_languages' );
		$installModules = $acl->acl_check( 'administration', 'install', 'users', $usertype, 'modules', 'all' );
		$editAllModules = $acl->acl_check( 'administration', 'edit', 'users', $usertype, 'modules', 'all' );
		$installMambots = $acl->acl_check( 'administration', 'install', 'users', $usertype, 'mambots', 'all' );
		$editAllMambots = $acl->acl_check( 'administration', 'edit', 'users', $usertype, 'mambots', 'all' );
		$installComponents = $acl->acl_check( 'administration', 'install', 'users', $usertype, 'components', 'all' );
		$editAllComponents = $acl->acl_check( 'administration', 'edit', 'users', $usertype, 'components', 'all' );

		$canMassMail = $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_massmail' );
		$canManageUsers = $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_users' );

		$database->setQuery( "SELECT title,params"
		. "\nFROM #__modules"
		. "\nWHERE module='mod_mainmenu'"
		. "\nORDER BY title"
		);
		$modMenus = $database->loadObjectList();
?>
<div id="myMenuID"></div>
<script language="JavaScript" type="text/javascript">
var myMenu =
[
	[null,'<?php echo $adminLanguage->A_MENU_HOME;?>','index2.php',null,'<?php echo $adminLanguage->A_MENU_HOME_PAGE;?>'],
	_cmSplit,
	[null,'<?php echo $adminLanguage->A_MENU_SITE;?>',null,null,'<?php echo $adminLanguage->A_MENU_SITE_MENU;?>',
		<?php if ($canConfig) { ?>
		['<img src="../includes/js/ThemeOffice/config.png" />','<?php echo $adminLanguage->A_GLOBAL_CONF;?>','index2.php?option=com_config',null,'<?php echo $adminLanguage->A_MENU_CONFIGURATION;?>'],
		<?php } ?>
<?php if ($manageLanguages) { ?>
		['<img src="../includes/js/ThemeOffice/language.png" />','<?php echo $adminLanguage->A_MENU_LANGUAGES;?>',null,null,'<?php echo $adminLanguage->A_MENU_MANAGE_LANG;?>',
			['<img src="../includes/js/ThemeOffice/language.png" />','<?php echo $adminLanguage->A_MENU_LANG_MANAGE;?>','index2.php?option=com_languages',null,'<?php echo $adminLanguage->A_MENU_MANAGE_LANG;?>'],
			['<img src="../includes/js/ThemeOffice/install.png" />','<?php echo $adminLanguage->A_MENU_INSTALL;?>','index2.php?option=com_installer&element=language',null,'<?php echo $adminLanguage->A_MENU_INSTALL_LANG;?>'],
		],
		<?php } ?>
		['<img src="../includes/js/ThemeOffice/media.png" />','<?php echo $adminLanguage->A_MENU_MEDIA_MANAGE;?>','index2.php?option=com_media',null,'<?php echo $adminLanguage->A_MENU_MANAGE_MEDIA;?>'],
		['<img src="../includes/js/ThemeOffice/preview.png" />', '<?php echo $adminLanguage->A_MENU_PREVIEW;?>', null, null, '<?php echo $adminLanguage->A_MENU_PREVIEW;?>',
		['<img src="../includes/js/ThemeOffice/preview.png" />','<?php echo $adminLanguage->A_MENU_NEW_WINDOW;?>','<?php echo $mosConfig_live_site; ?>','_blank','<?php echo $mosConfig_live_site; ?>'],
		['<img src="../includes/js/ThemeOffice/preview.png" />','<?php echo $adminLanguage->A_MENU_INLINE;?>','index2.php?option=com_admin&task=preview',null,'<?php echo $mosConfig_live_site; ?>'],
		['<img src="../includes/js/ThemeOffice/preview.png" />','<?php echo $adminLanguage->A_MENU_INLINE_POS;?>','index2.php?option=com_admin&task=preview2',null,'<?php echo $mosConfig_live_site; ?>'],
		],
		['<img src="../includes/js/ThemeOffice/globe1.png" />', '<?php echo $adminLanguage->A_MENU_STATISTICS;?>', null, null, '<?php echo $adminLanguage->A_MENU_STATISTICS_SITE;?>',
		<?php
		if ($mosConfig_enable_stats == 1) {
			?>
			['<img src="../includes/js/ThemeOffice/globe4.png" />', '<?php echo $adminLanguage->A_MENU_BROWSER;?>', 'index2.php?option=com_statistics', null, '<?php echo $adminLanguage->A_MENU_BROWSER;?>'],
			['<img src="../includes/js/ThemeOffice/globe3.png" />', '<?php echo $adminLanguage->A_MENU_PAGE_IMP;?>', 'index2.php?option=com_statistics&task=pageimp', null, '<?php echo $adminLanguage->A_MENU_PAGE_IMP;?>'],
			<?php
		}
		?>
		['<img src="../includes/js/ThemeOffice/search_text.png" />', '<?php echo $adminLanguage->A_MENU_SEARCH_TEXT;?>', 'index2.php?option=com_statistics&task=searches', null, '<?php echo $adminLanguage->A_MENU_SEARCH_TEXT;?>']
		],
		<?php if ($manageTemplates) { ?>
		['<img src="../includes/js/ThemeOffice/template.png" />','<?php echo $adminLanguage->A_MENU_TEMP_MANAGE;?>',null,null,'<?php echo $adminLanguage->A_MENU_TEMP_CHANGE;?>',
			['<img src="../includes/js/ThemeOffice/template.png" />','<?php echo $adminLanguage->A_MENU_SITE_TEMP;?>','index2.php?option=com_templates',null,'<?php echo $adminLanguage->A_MENU_TEMP_CHANGE;?>'],
			['<img src="../includes/js/ThemeOffice/install.png" />','<?php echo $adminLanguage->A_MENU_INSTALL;?>','index2.php?option=com_installer&element=template&client=',null,'<?php echo $adminLanguage->A_MENU_INSTALL;?>
<?php echo $adminLanguage->A_MENU_SITE_TEMP;?>'],
			_cmSplit,
			['<img src="../includes/js/ThemeOffice/template.png" />','<?php echo $adminLanguage->A_MENU_ADMIN_TEMP;?>','index2.php?option=com_templates&client=admin',null,'<?php echo $adminLanguage->A_MENU_ADMIN_CHANGE_TEMP;?>'],
			['<img src="../includes/js/ThemeOffice/install.png" />','<?php echo $adminLanguage->A_MENU_INSTALL;?>','index2.php?option=com_installer&element=template&client=admin',null,'<?php echo $adminLanguage->A_MENU_INSTALL;?>
<?php echo $adminLanguage->A_MENU_ADMIN_TEMP;?>'],
			_cmSplit,
			['<img src="../includes/js/ThemeOffice/template.png" />','<?php echo $adminLanguage->A_MENU_MODUL_POS;?>','index2.php?option=com_templates&task=positions',null,'<?php echo $adminLanguage->A_MENU_TEMP_POS;?>']
		],
		<?php } ?>
<?php if ($manageTrash) { ?>
		['<img src="../includes/js/ThemeOffice/trash.png" />','<?php echo $adminLanguage->A_MENU_TRASH_MANAGE;?>','index2.php?option=com_trash',null,'<?php echo $adminLanguage->A_MENU_MANAGE_TRASH;?>'],
		<?php } ?>
<?php if ($canManageUsers || $canMassMail) { ?>
		['<img src="../includes/js/ThemeOffice/users.png" />','<?php echo $adminLanguage->A_MENU_USER_MANAGE;?>',null,null,'<?php echo $adminLanguage->A_MENU_MANAGE_USER;?>',
		<?php	if ($canManageUsers) { ?>
		['<img src="../includes/js/ThemeOffice/users_add.png" />','<?php echo $adminLanguage->A_MENU_ADD_EDIT;?>','index2.php?option=com_users&task=view',null,'<?php echo $adminLanguage->A_MENU_ADD_EDIT;?>'],
		<?php	} ?>
<?php	if ($canMassMail) { ?>
		['<img src="../includes/js/ThemeOffice/mass_email.png" />','<?php echo $adminLanguage->A_MENU_MASS_MAIL;?>','index2.php?option=com_massmail',null,'<?php echo $adminLanguage->A_MENU_MAIL_USERS;?>']
		<?php	} ?>
		],
		<?php } ?>
		],
		_cmSplit,
		[null,'<?php echo $adminLanguage->A_COMP_MENU;?>',null,null,'<?php echo $adminLanguage->A_MENU_MANAGE_STR;?>',
		<?php	if ($manageMenuMan) { ?>
		['<img src="../includes/js/ThemeOffice/menus.png" />','<?php echo $adminLanguage->A_MENU_MANAGER;?>','index2.php?option=com_menumanager',null,'<?php echo $adminLanguage->A_MENU_MANAGER;?>'],
		_cmSplit,
		<?php	} ?>
<?php
		foreach ($modMenus as $modMenu) {
			mosMakeHtmlSafe($modMenu);
			$modParams = mosParseParams( $modMenu->params );
			$menuType = @$modParams->menutype;
			if (!$menuType) {
				$menuType = 'mainmenu';
			}
			?>
			['<img src="../includes/js/ThemeOffice/menus.png" />','<?php echo $modMenu->title;?>','index2.php?option=com_menus&menutype=<?php echo $menuType;?>',null,''],
			<?php
		}
		?>
	],
	_cmSplit,
	[null,'<?php echo $adminLanguage->A_MENU_CONTENT;?>',null,null,'<?php echo $adminLanguage->A_MENU_CONTENT_MANAGE;?>',
		['<img src="../includes/js/ThemeOffice/edit.png" />','<?php echo $adminLanguage->A_MENU_CONTENT_MANAGERS;?>',null,null,'<?php echo $adminLanguage->A_MENU_CONTENT_MANAGERS;?>',
			['<img src="../includes/js/ThemeOffice/edit.png" />','<?php echo $adminLanguage->A_ALL_MANAGER;?>','index2.php?option=com_content&sectionid=0',null,'<?php echo $adminLanguage->A_MENU_MANAGE_CONTENT;?>'],
			<?php $database->setQuery( "SELECT a.id, a.title, a.name,"
			. "\n	COUNT(DISTINCT c.id) AS numcat, COUNT(DISTINCT b.id) AS numarc"
			. "\nFROM #__sections AS a"
			. "\nLEFT JOIN #__categories AS c ON c.section=a.id"
			. "\nLEFT JOIN #__content AS b ON b.sectionid=a.id AND b.state=-1"
			. "\nWHERE a.scope='content'"
			. "\nGROUP BY a.id"
			. "\nORDER BY a.ordering"
			);
			$types = $database->loadObjectList();
			foreach ($types as $type) {
				$txt = addslashes( $type->title ? $type->title : $type->name );
				?>
				['<img src="../includes/js/ThemeOffice/document.png" />','<?php echo $txt;?>', null, null,'<?php echo $txt;?>',
				<?php if ($type->numcat) { ?>
				['<img src="../includes/js/ThemeOffice/edit.png" />', '<?php echo $txt;?> <?php echo $adminLanguage->A_MENU_ITEMS;?>', 'index2.php?option=com_content&sectionid=<?php echo $type->id;?>',null,null],
				<?php } ?>
				['<img src="../includes/js/ThemeOffice/add_section.png" />', '<?php echo $adminLanguage->A_MENU_ADDNEDIT;?> <?php echo $txt;?> <?php echo $adminLanguage->A_COMP_CATEG_CATEGS;?>', 'index2.php?option=com_categories&section=<?php echo $type->id;?>',null, null],
				<?php if ($type->numarc) { ?>
				['<img src="../includes/js/ThemeOffice/backup.png" />', '<?php echo $txt;?> <?php echo $adminLanguage->A_MENU_ARCHIVE;?>', 'index2.php?option=com_content&task=showarchive&sectionid=<?php echo $type->id;?>',null,null],
				<?php } ?>
				],
				<?php
			} ?>
		],
		_cmSplit,
		['<img src="../includes/js/ThemeOffice/edit.png" />','<?php echo $adminLanguage->A_MENU_OTHER_MANAGE;?>',null,null,'<?php echo $adminLanguage->A_MENU_OTHER_MANAGE;?>',
			['<img src="../includes/js/ThemeOffice/home.png" />','<?php echo $adminLanguage->A_FRONTPAGE_MANAGER;?>','index2.php?option=com_frontpage',null,'<?php echo $adminLanguage->A_MENU_ITEMS_FRONT;?>'],
			['<img src="../includes/js/ThemeOffice/edit.png" />','<?php echo $adminLanguage->A_STATIC_MANAGER;?>','index2.php?option=com_typedcontent',null,'<?php echo $adminLanguage->A_MENU_ITEMS_CONTENT;?>'],
			['<img src="../includes/js/ThemeOffice/edit.png" />','<?php echo $adminLanguage->A_MENU_ARCHIVE_MANAGE;?>','index2.php?option=com_content&task=showarchive&sectionid=0',null,'<?php echo $adminLanguage->A_MENU_ITEMS_ARCHIVE;?>'],
			['<img src="../includes/js/ThemeOffice/add_section.png" />','<?php echo $adminLanguage->A_SECTION_MANAGER;?>','index2.php?option=com_sections&scope=content',null,'<?php echo $adminLanguage->A_MENU_CONTENT_SEC;?>'],
			['<img src="../includes/js/ThemeOffice/add_section.png" />','<?php echo $adminLanguage->A_CATEGORY_MANAGER;?>','index2.php?option=com_categories&section=content',null,'<?php echo $adminLanguage->A_MENU_CONTENT_CAT;?>'],
		],
	],
	<?php 
	if ($installComponents) { 
		?>
		_cmSplit,
		[null,'<?php echo $adminLanguage->A_MENU_COMPONENTS;?>',null,null,'<?php echo $adminLanguage->A_MENU_INST_UNST;?>',
			<?php 
			if ($installComponents) { 
				?>
				['<img src="../includes/js/ThemeOffice/install.png" />','<?php echo $adminLanguage->A_MENU_INST_UNST;?>','index2.php?option=com_installer&element=component',null,'<?php echo $adminLanguage->A_MENU_INST_UNST;?>
<?php echo $adminLanguage->A_MENU_COMPONENTS;?>'],
				_cmSplit,
				<?php 
			} ?>
<?php 
			$database->setQuery( "SELECT * FROM #__components WHERE name <> 'frontpage' and name <> 'media manager' ORDER BY ordering,name" );
			$comps = $database->loadObjectList();	// component list
			$subs = array();	// sub menus
			// first pass to collect sub-menu items
			foreach ($comps as $row) {
				if ($row->parent) {
					if (!array_key_exists( $row->parent, $subs )) {
						$subs[$row->parent] = array();
					}
					$subs[$row->parent][] = $row;
				}
			}
			$topLevelLimit = 19; //You can get 19 top levels on a 800x600 Resolution
			$topLevelCount = 0;
			foreach ($comps as $row) {
				if ($editAllComponents | $acl->acl_check( 'administration', 'edit', 'users', $usertype, 'components', $row->option )) {
					if ($row->parent == 0 && (trim( $row->admin_menu_link ) || array_key_exists( $row->id, $subs ))) {
						$topLevelCount++;
						if ($topLevelCount > $topLevelLimit) {
							continue;
						}
						$name = addslashes( $row->name );
						$alt = addslashes( $row->admin_menu_alt );
						$link = $row->admin_menu_link ? "'index2.php?$row->admin_menu_link'" : "null";
						echo "\n	['<img src=\"../includes/$row->admin_menu_img\" />','$name',$link,null,'$alt'";
						if (array_key_exists( $row->id, $subs )) {
							echo ',';
							foreach ($subs[$row->id] as $sub) { 
								$name = addslashes( $sub->name );
								$alt = addslashes( $sub->admin_menu_alt );
								$link = $sub->admin_menu_link ? "'index2.php?$sub->admin_menu_link'" : "null";
								echo "\n		['<img src=\"../includes/$sub->admin_menu_img\" />','$name',$link,null,'$alt'],";
							}
						}
						echo "\n	],";
					}
				}
			}
			if ($topLevelLimit < $topLevelCount) {
				echo "\n	['<img src=\"../includes/js/ThemeOffice/sections.png\" />','<?php echo $adminLanguage->A_MENU_MORE_COMP;?>...','index2.php?option=com_admin&task=listcomponents',null,'<?php echo $adminLanguage->A_MENU_MORE_COMP;?>'],\n";
			}
			?>
		],
	<?php 
	if ($installModules | $editAllModules) { 
		?>
		_cmSplit,
		[null,'<?php echo $adminLanguage->A_MENU_MODULES;?>',null,null,null,
				<?php 
				if ($installModules) { 
					?>
					['<img src="../includes/js/ThemeOffice/install.png" />', '<?php echo $adminLanguage->A_MENU_INST_UNST;?>', 'index2.php?option=com_installer&element=module', null, '<?php echo $adminLanguage->A_MENU_INSTALL_CUST;?>'],
					_cmSplit,
					<?php 
				} ?>
<?php 
				if ($editAllModules) { 
					?>
					['<img src="../includes/js/ThemeOffice/module.png" />', '<?php echo $adminLanguage->A_MENU_SITE_MOD;?>', "index2.php?option=com_modules", null, '<?php echo $adminLanguage->A_MENU_SITE_MOD_MANAGE;?>'],
					['<img src="../includes/js/ThemeOffice/module.png" />', '<?php echo $adminLanguage->A_MENU_ADMIN_MOD;?>', "index2.php?option=com_modules&client=admin", null, '<?php echo $adminLanguage->A_MENU_ADMIN_MOD_MANAGE;?>'],
					<?php 
				} ?>
		],
		<?php 
	} ?>
<?php 
	} ?>
<?php 
	if ($installModules | $editAllModules) { 
		?>
		_cmSplit,
		[null,'<?php echo $adminLanguage->A_MENU_MAMBOTS;?>',null,null,null,
			<?php 
			if ($installModules) { 
				?>
				['<img src="../includes/js/ThemeOffice/install.png" />', '<?php echo $adminLanguage->A_MENU_INST_UNST;?>', 'index2.php?option=com_installer&element=mambot', null, '<?php echo $adminLanguage->A_MENU_CUSTOM_MAMBOT;?>'],
				_cmSplit,
				<?php 
			} ?>
<?php 
			if ($editAllModules) { 
				?>
				['<img src="../includes/js/ThemeOffice/module.png" />', '<?php echo $adminLanguage->A_MENU_SITE_MAMBOTS;?>', "index2.php?option=com_mambots", null, '<?php echo $adminLanguage->A_MENU_MAMBOT_MANAGE;?>'],
				//['<img src="../includes/js/ThemeOffice/module.png" />', 'Manage Administrator Modules', "index2.php?option=com_mambots&client=admin", null, 'Manage installed modules'],
				<?php 
			} ?>
			],
		<?php 
	} ?>
<?php 
	if ($canConfig) { 
		?>
		_cmSplit,
		[null,'<?php echo $adminLanguage->A_MENU_MESSAGES;?>',null,null,null,
			['<img src="../includes/js/ThemeOffice/messaging_inbox.png" />','<?php echo $adminLanguage->A_MENU_INBOX;?>','index2.php?option=com_messages',null,'<?php echo $adminLanguage->A_MENU_PRIV_MSG;?>'],
			['<img src="../includes/js/ThemeOffice/messaging_config.png" />','<?php echo $adminLanguage->A_MENU_CONFIGURATION;?>','index2.php?option=com_messages&task=config',null,'<?php echo $adminLanguage->A_MENU_CONFIGURATION;?>']
		],
		_cmSplit,
		[null,'<?php echo $adminLanguage->A_MENU_SYSTEM; ?>',null,null,null,
			<?php 
			if ($canConfig) { ?>
				['<img src="../includes/js/ThemeOffice/checkin.png" />', '<?php echo $adminLanguage->A_MENU_GLOBAL_CHECK;?>', 'index2.php?option=com_checkin', null,'<?php echo $adminLanguage->A_MENU_CHECK_INOUT;?>'],
				['<img src="../includes/js/ThemeOffice/sysinfo.png" />', '<?php echo $adminLanguage->A_MENU_SYSTEM_INFO;?>', 'index2.php?option=com_admin&task=sysinfo', null, '<?php echo $adminLanguage->A_MENU_SYSTEM_INFO;?>'],
				<?php 
				if ($mosConfig_caching) { ?>
					['<img src="../includes/js/ThemeOffice/config.png" />','<?php echo $adminLanguage->A_MENU_CLEAN_CACHE;?>','index2.php?option=com_content&task=clean_cache',null,'<?php echo $adminLanguage->A_MENU_CLEAN_CACHE_ITEMS;?>'],
					<?php 
				} ?>
<?php 
			} ?>
		],
		<?php 
	} ?>
	_cmSplit,
	[null,'<?php echo $adminLanguage->A_HELP; ?>',null,null,null,
		['<img src="../includes/js/ThemeOffice/help.png" />','<?php echo $adminLanguage->A_COMP_ADMIN_INDEX;?>','index2.php?option=com_admin&task=help',null,'<?php echo $adminLanguage->A_MENU_BIG_THANKS;?>'],
		['<img src="../includes/js/ThemeOffice/credits.png" />','<?php echo $adminLanguage->A_COMP_ADMIN_CREDITS;?>','index2.php?option=com_admin&task=credits',null,'<?php echo $adminLanguage->A_MENU_BIG_THANKS;?>'],
		['<img src="../includes/js/ThemeOffice/license.png" />','<?php echo $adminLanguage->A_COMP_ADMIN_LICENSE;?>','index2.php?option=com_admin&task=help&page=apdx.license',null,'GNU/GPL <?php echo $adminLanguage->A_COMP_ADMIN_LICENSE;?>'],
		['<img src="../includes/js/ThemeOffice/help.png" />', '<?php echo $adminLanguage->A_MENU_SUPPORT;?>', 'index2.php?option=com_admin&task=help&page=apdx.support', null, 'Mambo <?php echo $adminLanguage->A_MENU_SUPPORT;?>'],
	],
];
cmDraw ('myMenuID', myMenu, '<?php echo ($adminLanguage->RTLsupport ? "hbl" : "hbr"); ?>', cmThemeOffice, 'ThemeOffice'); <!-- rtl change -->
</script>
<?php
	}
}
$cache =& mosCache::getCache( 'mos_fullmenu' );

mosFullAdminMenu::show( $my->usertype );
//$cache->call( 'mosFullAdminMenu::show', $my->usertype );
?>