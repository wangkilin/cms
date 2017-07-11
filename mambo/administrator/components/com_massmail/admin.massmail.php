<?php
/**
* @version $Id: admin.massmail.php,v 1.1 2004/10/01 20:09:35 mibi Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if (!$acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_massmail' )) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'admin_html' ) );

switch ($task) {
	case 'send':
	sendMail();
	break;

	case 'cancel':
	mosRedirect( "index2.php" );
	break;

	default:
	messageForm( $option );
	break;
}

function messageForm( $option ) {
	global $database, $acl;

	$gtree = array(
	mosHTML::makeOption( 0, $adminLanguage->A_COMP_MASS_ALL )
	);

	// get list of groups
	$lists = array();
	$gtree = array_merge( $gtree, $acl->get_group_children_tree( null, 'USERS', false ) );
	$lists['gid'] = mosHTML::selectList( $gtree, 'mm_group', 'size="10"', 'value', 'text', 0 );

	HTML_massmail::messageForm( $lists, $option );
}

function sendMail() {
	global $database, $my, $acl, $adminLanguage;
	global $mosConfig_sitename, $mosConfig_debug;
	global $mosConfig_mailfrom, $mosConfig_fromname;

	$n=0;
	$message_body		= mosGetParam( $_POST, 'mm_message', '' );
	$message_body 		= stripslashes( $message_body );
	$subject			= mosGetParam( $_POST, 'mm_subject', '' );
	$gou				= mosGetParam( $_POST, 'mm_group', NULL );
	$recurse			= mosGetParam( $_POST, 'mm_recurse', 'NO_RECURSE' );

	if (!$message_body || !$subject || $gou === null) {
		mosRedirect( "index2.php?option=com_massmail&mosmsg=". $adminLanguage->A_COMP_MASS_FILL );
	}

	// get users in the group out of the acl
	$to = $acl->get_group_objects( $gou, 'ARO', $recurse );

	$rows = array();
	if (count( $to['users'] ) || $gou === '0') {
		// Get sending email address
		$database->setQuery( "SELECT email FROM #__users WHERE id='$my->id'" );
		$my->email = $database->loadResult();

		// Get all users email and group except for senders
		$database->setQuery( "SELECT email FROM #__users"
		. "\n WHERE id != '$my->id'"
		. ($gou !== '0' ? " AND id IN (" . implode( ',', $to['users'] ) . ")" : "")
		);
		$rows = $database->loadObjectList();

		// Build e-mail message format
		$message_header 	= sprintf( _MASSMAIL_MESSAGE, $mosConfig_sitename );
		$message 			= $message_header . $message_body;
		$subject 			= $mosConfig_sitename. ' / '. stripslashes( $subject);

		//Send email
		foreach ($rows as $row) {
			mosMail($mosConfig_mailfrom, $mosConfig_fromname, $row->email, $subject, $message);
		}
	}
	mosRedirect( "index2.php", $adminLanguage->A_COMP_MASS_SENT ." ". count( $rows ) ." ". $adminLanguage->A_COMP_MASS_USERS );
}
?>
