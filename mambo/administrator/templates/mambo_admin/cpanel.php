<?php
/**
* @version $Id: cpanel.php,v 1.4 2004/09/23 14:27:57 rcastley Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
?>
<table class="adminform">
<tr>
	<td width="50%" valign="top">
	<?php mosLoadAdminModules( 'icon', 0 ); ?>
	</td>
	<td width="50%" valign="top">
	<div style="width=100%;">
	<form action="index2.php" method="post" name="adminForm">
	<?php mosLoadAdminModules( 'cpanel', 1 ); ?>
	<input type="hidden" name="sectionid" value="" />
	<input type="hidden" id="id" name="id" value="" />
	<input type="hidden" name="option" value="com_content" />
	<input type="hidden" name="task" value="" />
	</form>
	</div>
	</td>
</tr>
</table>