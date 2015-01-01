<?php
/**
* @version $Id: contact.class.php,v 1.9 2004/08/26 05:20:54 rcastley Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo_4.5.1
*/
class mosContact extends mosDBTable {
	/** @var int Primary key */
	var $id=null;
	/** @var string */
	var $name=null;
	/** @var string */
	var $con_position=null;
	/** @var string */
	var $address=null;
	/** @var string */
	var $suburb=null;
	/** @var string */
	var $state=null;
	/** @var string */
	var $country=null;
	/** @var string */
	var $postcode=null;
	/** @var string */
	var $telephone=null;
	/** @var string */
	var $fax=null;
	/** @var string */
	var $misc=null;
	/** @var string */
	var $image=null;
	/** @var string */
	var $imagepos=null;
	/** @var string */
	var $email_to=null;
	/** @var int */
	var $default_con=null;
	/** @var int */
	var $published=null;
	/** @var int */
	var $checked_out=null;
	/** @var datetime */
	var $checked_out_time=null;
	/** @var int */
	var $ordering=null;
	/** @var string */
	var $params=null;
	/** @var int A link to a registered user */
	var $user_id=null;
	/** @var int A link to a category */
	var $catid=null;
	/** @var int */
	var $access=null;

	/**
	* @param database A database connector object
	*/
	function mosContact() {
	    global $database;
		$this->mosDBTable( '#__contact_details', 'id', $database );
	}
	
	function check() {
		$this->default_con = intval( $this->default_con );
		return true;
	}
}
?>