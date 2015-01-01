<?php
/**
* @version $Id: newsfeeds.class.php,v 1.5 2004/08/26 05:20:47 rcastley Exp $
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
class mosNewsFeed extends mosDBTable {
/** @var int Primary key */
	var $id=null;
/** @var int */
	var $catid=null;
/** @var string */
	var $name=null;
/** @var string */
	var $link=null;
/** @var string */
	var $filename=null;
/** @var int */
	var $published=null;
/** @var int */
	var $numarticles=null;
/** @var int */
	var $cache_time=null;
/** @var int */
	var $checked_out=null;
/** @var time */
	var $checked_out_time=null;
/** @var int */
	var $ordering=null;

/**
* @param database A database connector object
*/
	function mosNewsFeed( &$db ) {
		$this->mosDBTable( '#__newsfeeds', 'id', $db );
	}

}
?>