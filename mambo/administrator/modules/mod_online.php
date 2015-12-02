<?php
/**
* @version $Id: mod_online.php,v 1.1 2004/09/27 08:28:31 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$session_id = mosGetParam( $_SESSION, 'session_id', '' );

// Get no. of users online not including current session
$query = "SELECT count(session_id) FROM #__session"
."\n WHERE session_id <> '$session_id'";

$database->setQuery($query);
$online_num = intval( $database->loadResult() );

echo $online_num . " <img src=\"images/users.png\" align=\"middle\" alt=".$adminLanguage->A_ONLINE_USERS." />";
?>