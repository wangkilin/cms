<?php
/**
* @version $Id: mod_unread.php,v 1.1 2004/10/01 21:54:02 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$database->setQuery( "SELECT COUNT(*) FROM #__messages WHERE state='0' AND user_id_to='$my->id'" );
$unread = $database->loadResult();

if ($unread) {
	echo "<a href=\"index2.php?option=com_messages\" style=\"color: red; text-decoration: none;  font-weight: bold\">$unread <img src=\"images/mail.png\" align=\"middle\" border=\"0\" alt=\"".$adminLanguage->A_MAIL."\" /></a>";
} else {
    echo "<a href=\"index2.php?option=com_messages\" style=\"color: black; text-decoration: none;\">$unread <img src=\"images/nomail.png\" align=\"middle\" border=\"0\" alt=\"".$adminLanguage->A_MAIL."\" /></a>";
}
?>