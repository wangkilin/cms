<?php
/**
* @version $Id: mod_stats.php,v 1.1 2004/10/03 22:26:18 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$database->setQuery( "SELECT menutype,COUNT(id) AS numitems"
. "\nFROM #__menu"
. "\nGROUP BY menutype"
);
$rows = $database->loadObjectList();
?>
<table class="adminlist">
	<tr>
		<th class="title"><?php $adminLanguage->A_COMP_MENU;?></th>
		<th class="title"># <?php $adminLanguage->A_MENU_ITEMS;?></th>
	</tr>
<?php
foreach ($rows as $row) { ?>
	<tr>
		<td><a href="index2.php?option=com_menus&menutype=<?php echo $row->menutype;?>"><?php echo $row->menutype;?></a></td>
		<td><?php echo $row->numitems;?></td>
	</tr>
<?php
}
?>
</table>
