<?php
// $Id: toolbar.user_extended.php,v 1.1 2004/08/30 21:40:52 bzechmann Exp $
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

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $task;

require_once( $mainframe->getPath( 'toolbar_html' ) );
require_once( $mainframe->getPath( 'toolbar_default' ) );


switch ($act) {
  case "config":
  menuuserextended::SAVE_ONLY();
  $task="null";
  break;
}

switch ($task) {

  case "null":
    //menuuserextended::DEFAULT_MENU();
    break;

  case "showproperties":
    menuuserextended::DEFAULT_MENU();
    break;

  case "new":
  case "newproperty":
  case "new_content_typed":
  case "new_content_section":
    menuuserextended::NEW_MENU();
    break;

  case "edit":
  case "edit_content_typed":
//    global $database;
//    // TODO: need better error capture here!
//    $id = mosGetParam( $_POST, "id", '0' );
//    //$database->setQuery( "SELECT published FROM #__properties WHERE id='$id'" );
//    $database->setQuery( "SELECT block FROM #__users WHERE id='$id'" );
//    $state = $database->loadResult();
//    menuuserextended::EDIT_MENU( $state );
      menuuserextended::EDIT_MENU();
    break;

  case "archives":
    menuuserextended::ARCHIVE_MENU();
    break;

  case "movesect":
    menuuserextended::MOVE_MENU();
    break;

  case "config":
    menuuserextended::SAVE_ONLY();
    break;

  case "about":
    menuuserextended::ABOUT_MENU();
    break;

  default:
    menuuserextended::DEFAULT_MENU();
    break;
}

?>
