<?php
// $Id: install.user_extended.php,v 1.1 2004/08/30 21:40:52 bzechmann Exp $
/**
* @ Autor   : Bernhard Zechmann (MamboZ)
* @ Website : www.zechmann.com
* @ Download: www.mosforge.net/projects/userextended
* @ Routine : Based on Install Routine by Arthur Konze (Ako)
* @ Website : www.konze.de
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/

function com_install() {
global $database;
global $mosConfig_absolute_path, $mosConfig_live_site;

# Set up new icons for admin menu
$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/user.png' WHERE admin_menu_link='option=com_user_extended'");
$iconresult[0] = $database->query();
$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/config.png' WHERE admin_menu_link='option=com_user_extended&task=config'");
$iconresult[1] = $database->query();
$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/credits.png' WHERE admin_menu_link='option=com_user_extended&task=about'");
$iconresult[2] = $database->query();

# Show installation result to user
?>
<center>
<table width="100%" border="0">
  <tr>
    <td><img src="components/com_user_extended/images/logo.png"></td>
    <td>
      <strong>UserExtended Component</strong><br/>
      <font class="small">&copy; Copyright 2004 by Bernhard Zechmann</font><br/>
      <br/>
      This component is released under the terms and conditions of the <a href="index2.php?option=com_admisc&task=license">GNU General Public License</a>.
    </td>
  </tr>
  <tr>
    <td>
      <code>Installation: <font color="green">succesfull</font></code>
    </td>
  </tr>
</table>
</center>
<?php
}
?>