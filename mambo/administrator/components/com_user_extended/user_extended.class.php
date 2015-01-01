<?php
// $Id: user_extended.class.php,v 1.1 2004/08/30 21:40:52 bzechmann Exp $
/**
* @ Autor   : Bernhard Zechmann (MamboZ)
* @ Website : www.zechmann.com
* @ Download: www.mosforge.net/projects/userextended
* @ Routine : Based on addon hack by Phil Taylor
* @ Website : www.phil-taylor.com
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );


class mosUser_Extended extends mosDBTable {
  var $id=null;
  var $user_id=null;

  var $user1=null;
  var $user2=null;
  var $user3=null;
  var $user4=null;
  var $user5=null;
  var $user6=null;
  var $user7=null;
  var $user8=null;
  var $user9=null;
  var $user10=null;
  var $user11=null;
  var $user12=null;
  var $user13=null;
  var $user14=null;
  var $user15=null;

  /**
  * @param database A database connector object
  */
  function mosUser_Extended( &$db ) {
    $this->mosDBTable( '#__user_extended', 'id', $db );
  } //end func


  function storeExtended( $id, $updateNulls=false) {
    global $acl, $migrate, $database;

    $sql="Select count(*) from #__user_extended where id = '". $_POST['id'] ."'";
    $database->SetQuery($sql);
    $total = $database->LoadResult();

    //echo "<script> alert(\"".$_POST['id']."\"); window.history.go; </script>\n";
    if ($_POST['id']>0) {
      if( $total > 0 ) {
        // existing record
        $ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );
      } else {
        // new user but not in user extended table
        $last_id = $_POST['id'];
        $this->id = $last_id;
        $this->user_id = $last_id;
        $ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
      }
    } else {
      // new record
      $sql="Select max(id) from #__users";
      $database->SetQuery($sql);
      $last_id = $database->LoadResult();
      $this->id = $last_id;
      $this->user_id = $last_id;
      $ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
    }

    if( !$ret ) {
      $this->_error = get_class( $this )."::store failed <br />" . $this->_db->getErrorMsg();
      return false;
    } else {
      return true;
    }
  } //end func
} //end class


class mosUser_Extended_Config extends mosDBTable {
  var $id=null;

  var $user1_name=null;
  var $user1_show=null;
  var $user1_must=null;
  var $user1_size=null;

  var $user2_name=null;
  var $user2_show=null;
  var $user2_must=null;
  var $user2_size=null;

  var $user3_name=null;
  var $user3_show=null;
  var $user3_must=null;
  var $user3_size=null;

  var $user4_name=null;
  var $user4_show=null;
  var $user4_must=null;
  var $user4_size=null;

  var $user5_name=null;
  var $user5_show=null;
  var $user5_must=null;
  var $user5_size=null;

  var $user6_name=null;
  var $user6_show=null;
  var $user6_must=null;
  var $user6_size=null;

  var $user7_name=null;
  var $user7_show=null;
  var $user7_must=null;
  var $user7_size=null;

  var $user8_name=null;
  var $user8_show=null;
  var $user8_must=null;
  var $user8_size=null;

  var $user9_name=null;
  var $user9_show=null;
  var $user9_must=null;
  var $user9_size=null;

  var $user10_name=null;
  var $user10_show=null;
  var $user10_must=null;
  var $user10_size=null;

  var $user11_name=null;
  var $user11_show=null;
  var $user11_must=null;
  var $user11_size=null;

  var $user12_name=null;
  var $user12_show=null;
  var $user12_must=null;
  var $user12_size=null;

  var $user13_name=null;
  var $user13_show=null;
  var $user13_must=null;
  var $user13_size=null;

  var $user14_name=null;
  var $user14_show=null;
  var $user14_must=null;
  var $user14_size=null;

  var $user15_name=null;
  var $user15_show=null;
  var $user15_must=null;
  var $user15_size=null;

  /**
  * @param database A database connector object
  */
  function mosUser_Extended_Config( &$db ) {
    $this->mosDBTable( '#__user_extended_config', 'id', $db );
  } //end func

} //end class


class oClass {

  function o_version() {
    DEFINE( '_oRELEASE', '1.0' );
    DEFINE( '_oDEV_STATUS', '' );
    DEFINE( '_oDEV_LEVEL', '.4' );
    DEFINE( '_oCODENAME', '' );
    DEFINE( '_oRELDATE', '06.05.2004' );
    DEFINE( '_oRELTIME', '23:59' );
    DEFINE( '_oRELTZ', 'GMT' );
    $version = ""._oRELEASE." "._oDEV_STATUS."-". _oDEV_LEVEL."
        ["._oCODENAME."] "._oRELDATE." "._oRELTIME." "._oRELTZ."";
    return $version;
  } //end function o_version


  function o_version_number() {
    $vernumber = '0.4';
    return $vernumber;
  } //end function o_version


  function footer(){
    global $mosConfig_absolute_path;
    include ($mosConfig_absolute_path . '/components/'._COM_PTDIR_DIR.'/' . _COM_PTDIR_APPNAME .'.config.php');
    echo oClass::o_version();
    echo "<BR>&copy; 2004 <a href=\"http://www.zechmann.com/\" target=_blank>MamboZ</A> and <a href=\"http://www.phil-taylor.com/\" target=_blank>Phil Taylor</A>";
  }


  function findUsername($id){
    if ($id=="0"){
      $name=null;
      return $name;
    } else {
      global $database;
      $sql = "SELECT id, name FROM `#__users` WHERE id = $id LIMIT 1";
      $database->setQuery( $sql );
      $u_rows = $database->loadObjectList();
      $name = $u_rows[0]->name;
      return $name;
    }
  }//end func

  function findGroup($id){
    global $database;
    $sql = "SELECT id, name FROM `#__groups` WHERE id = $id LIMIT 1";
    $database->setQuery( $sql );
    $u_rows = $database->loadObjectList();
    $name = $u_rows[0]->name;
    return $name;
  }//end func

}// end class

?>
