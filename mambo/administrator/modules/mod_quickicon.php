<?php
/**
* @version $Id: mod_quickicon.php,v 1.1 2004/09/27 08:28:31 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

?>
<table width="100%" class="cpanel">
<tr>
	<td align="center" height="100px">
	<a href="index2.php?option=com_menumanager" style="text-decoration:none;">
	<img src="images/menu.png" width="48px" height="48px" align="middle" border="0"/>
	<br />
	<?php echo $adminLanguage->A_MENU_MANAGER;?>
	</a>
	</td>
	<td align="center" height="100px">
	<a href="index2.php?option=com_frontpage" style="text-decoration:none;">
	<img src="images/frontpage.png" width="48px" height="48px" align="middle" border="0"/>
	<br />
	<?php echo $adminLanguage->A_FRONTPAGE_MANAGER;?>
	</a>
	</td>
	<td align="center" height="100px">
	<a href="index2.php?option=com_typedcontent" style="text-decoration:none;">
	<img src="images/addedit.png" width="48px" height="48px" align="middle" border="0"/>
	<br />
	<?php echo $adminLanguage->A_STATIC_MANAGER;?>
	</a>
	</td>
</tr>
<tr>
	<td align="center" height="100px">
	<a href="index2.php?option=com_sections&scope=content" style="text-decoration:none;">
	<img src="images/sections.png" width="48px" height="48px" align="middle" border="0"/>
	<br />
	<?php echo $adminLanguage->A_SECTION_MANAGER;?>
	</a>
	</td>
	<td align="center" height="100px">
	<a href="index2.php?option=com_categories&section=content" style="text-decoration:none;">
	<img src="images/categories.png" width="48px" height="48px" align="middle" border="0"/>
	<br />
	<?php echo $adminLanguage->A_CATEGORY_MANAGER;?>
	</a>
	</td>
	<td align="center" height="100px">
	<a href="index2.php?option=com_content&sectionid=0" style="text-decoration:none;">
	<img src="images/addedit.png" width="48px" height="48px" align="middle" border="0"/>
	<br />
	<?php echo $adminLanguage->A_ALL_MANAGER;?>
	</a>
	</td>
</tr>
<tr>
	<td align="center" height="100px">
	<a href="index2.php?option=com_trash" style="text-decoration:none;">
	<img src="images/trash.png" width="48px" height="48px" align="middle" border="0"/>
	<br />
	<?php echo $adminLanguage->A_TRASH_MANAGER;?>
	</a>
	</td>
	<td align="center" height="100px">
	<a href="index2.php?option=com_config" style="text-decoration:none;">
	<img src="images/config.png" width="48px" height="48px" align="middle" border="0"/>
	<br />
	<?php echo $adminLanguage->A_GLOBAL_CONF;?>
	</a>
	</td>
	<td align="center" height="100px">
	<a href="index2.php?option=com_admin&task=help" style="text-decoration:none;">
	<img src="images/support.png" width="48px" height="48px" align="middle" border="0"/>
	<br />
	<?php echo $adminLanguage->A_HELP;?>
	</a>
	</td>
</tr>
</table>
