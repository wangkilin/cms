<?php
/**
* @version $Id: frontpage.class.php,v 1.5 2004/08/26 05:20:55 rcastley Exp $
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
class mosFrontPage extends mosDBTable {
	/** @var int Primary key */
	var $content_id=null;
	/** @var int */
	var $ordering=null;
	
	/**
	* @param database A database connector object
	*/
	function mosFrontPage( &$db ) {
		$this->mosDBTable( '#__content_frontpage', 'content_id', $db );
	}
}
?>