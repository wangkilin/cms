<?php
// $Id: toolbar.user_extended.html.php,v 1.2 2004/09/27 21:43:13 bzechmann Exp $
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


class menuuserextended {

  function SAVE_ONLY() {
    mosMenuBar::startTable();
    mosMenuBar::save('saveconfig');
    mosMenuBar::divider();
    mosMenuBar::cancel();
    mosMenuBar::spacer();
    mosMenuBar::endTable();
  }

  function NEW_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::preview( 'contentwindow' );
    mosMenuBar::divider();
    mosMenuBar::save();
    mosMenuBar::divider();
    mosMenuBar::cancel();
    mosMenuBar::spacer();
    mosMenuBar::endTable();
  }

  function EDIT_MENU() {
    mosMenuBar::startTable();
//    if ($state == 0) {
//      mosMenuBar::publish();
//    } else {
//      mosMenuBar::unpublish();
//    }
//    mosMenuBar::divider();
//    mosMenuBar::preview( 'contentwindow' );
//    mosMenuBar::divider();
    mosMenuBar::save();
    mosMenuBar::divider();
    mosMenuBar::cancel();
    mosMenuBar::spacer();
    mosMenuBar::endTable();
  }

  function ARCHIVE_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::unarchiveList();
    mosMenuBar::divider();
    mosMenuBar::addNew();
    mosMenuBar::deleteList();
    mosMenuBar::spacer();
    mosMenuBar::endTable();
  }

  function MOVE_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::divider();
    mosMenuBar::cancel();
    mosMenuBar::spacer();
    mosMenuBar::endTable();
  }

  function ABOUT_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::back();
    mosMenuBar::spacer();
    mosMenuBar::endTable();
  }

  function DEFAULT_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::addNew();
    mosMenuBar::editList();
    mosMenuBar::deleteList();
    mosMenuBar::spacer();
    mosMenuBar::endTable();
  }

}
?>
