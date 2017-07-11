<?php
/**
* @version $Id: mod_components.php,v 1.2 2004/10/11 03:36:33 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// cache some acl checks
$canConfig = $acl->acl_check( 'administration', 'config', 'users', $my->usertype );

$manageTemplates = $acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_templates' );
$manageLanguages = $acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_languages' );
$installModules = $acl->acl_check( 'administration', 'install', 'users', $my->usertype, 'modules', 'all' );
$editAllModules = $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'modules', 'all' );
$installComponents = $acl->acl_check( 'administration', 'install', 'users', $my->usertype, 'components', 'all' );
$editAllComponents = $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' );

$canMassMail = $acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_massmail' );
$canManageUsers = $acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_users' );

$database->setQuery( "SELECT * FROM #__components ORDER BY ordering,name" );
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

echo '<div align="'.($adminLanguage->RTLsupport ? 'right' : 'left').'">'; /* rtl change */

$topLevelLimit = 100;
$i = 0;
foreach ($comps as $row) {

	if ($editAllComponents | $acl->acl_check( 'administration', 'edit', 'users', $my->usertype,
	'components', $row->option )) {

		if ($row->parent == 0 && (trim( $row->admin_menu_link ) || array_key_exists( $row->id, $subs ))) {

			if ($i >= $topLevelLimit) {
				if ($i == $topLevelLimit) {

					echo $adminLanguage->A_ERROR."<br />";
					$i = 1000;
				}
			} else {
				if ($i < $topLevelLimit ) {
					$i++;
					$name = htmlspecialchars( $row->name );
					$alt = htmlspecialchars( $row->admin_menu_alt );
					if ($row->admin_menu_link) {
						echo "\n<a href=\"index2.php?$row->admin_menu_link\"><strong>$name</strong></a> <br />";
					} else {
						echo "\n<strong>$name</strong><br />";
					}
					if (array_key_exists( $row->id, $subs )) {

						foreach ($subs[$row->id] as $sub) {//print_r($row);
						$name = htmlspecialchars( $sub->name );
						$alt = htmlspecialchars( $sub->admin_menu_alt );
						$link = $sub->admin_menu_link ? "" : "null";
						//$img = $sub->admin_menu_img ? "<img src=\"../includes/$sub->admin_menu_img\" />" : '';
						if ($sub->admin_menu_link) {
							echo "\n&nbsp;&nbsp;- <a href=\"index2.php?$sub->admin_menu_link\">$name</a> <br />";
						} else {
							echo "\n- $name<br />";
						}
						}
					}
				}
			}
		}
	}
}
echo "</div>";
?>