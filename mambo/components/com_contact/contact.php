<?php
/**
* @version $Id: contact.php,v 1.34 2004/09/25 18:43:54 saka Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// load the html drawing class
require_once( $mainframe->getPath( 'front_html' ) );
require_once( $mainframe->getPath( 'class' ) );
$mainframe->setPageTitle( _CONTACT_TITLE );

if ( !isset( $op ) ) {
	$op = '';
}

//Load Vars
$con_id = intval( mosGetParam( $_REQUEST ,'con_id', 0 ) );
$contact_id = intval( mosGetParam( $_REQUEST ,'contact_id', 0 ) );
$catid = intval( mosGetParam( $_REQUEST ,'catid', 0 ) );

switch( $task ) {
	case 'view':
		contactpage( $option, $contact_id );
		break;

	default:
		//contactpage( $option, $contact_id );
		listContacts( $option, $catid );
		break;
}

switch( $op ) {
	case 'sendmail':
		sendmail( $con_id, $option );
		break;

}


function listContacts( $option, $catid ) {
	global $mainframe, $database, $my;
	global $mosConfig_shownoauth, $mosConfig_live_site, $mosConfig_absolute_path;
	global $cur_template, $Itemid;

	/* Query to retrieve all categories that belong under the contacts section and that are published. */
	$query = "SELECT *, COUNT(a.id) AS numlinks"
	. "\n FROM #__categories AS cc"
	. "\n LEFT JOIN #__contact_details AS a ON a.catid = cc.id"
	. "\n WHERE a.published='1'"
	. "\n AND cc.section='com_contact_details'"
	. "\n AND cc.published='1'"
	. "\n AND a.access <= '". $my->gid ."'"
	. "\n AND cc.access <= '". $my->gid ."'"
	. "\n GROUP BY cc.id"
	. "\n ORDER BY cc.ordering"
	;
	$database->setQuery( $query );
	$categories = $database->loadObjectList();

	$count = count( $categories );
	if ( ( $count < 2 ) && ( @$categories[0]->numlinks == 1 ) ) {
		// if only one record exists loads that record, instead of displying category list
		contactpage( $option, 0 );
	} else {
		$rows = array();
		$currentcat = NULL;
		if ( $catid ) {
			// url links info for category
			$query = "SELECT *"
			. "\n FROM #__contact_details"
			. "\n WHERE catid = '". $catid."'"
			 . "\n AND published='1'"
			 . "\n AND access <= '". $my->gid ."'"
			. "\n ORDER BY ordering"
			;
			$database->setQuery( $query );
			$rows = $database->loadObjectList();

			// current category info
			$query = "SELECT name, description, image, image_position"
			. "\n FROM #__categories"
			. "\n WHERE id = '". $catid ."'"
			. "\n AND published = '1'"
			. "\n AND access <= '". $my->gid ."'"
			;
			$database->setQuery( $query );
			$database->loadObject( $currentcat );
		}

		// Parameters
		$menu =& new mosMenu( $database );
		$menu->load( $Itemid );
		$params =& new mosParameters( $menu->params );

		$params->def( 'page_title', 1 );
		$params->def( 'header', $menu->name );
		$params->def( 'pageclass_sfx', '' );
		$params->def( 'headings', 1 );
		$params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );
		$params->def( 'description_text', _CONTACTS_DESC );
		$params->def( 'image', -1 );
		$params->def( 'image_align', 'right' );
		// Category List Display control
		$params->def( 'other_cat', 1 );
		$params->def( 'cat_description', 1 );
		$params->def( 'cat_items', 1 );
		// Table Display control
		$params->def( 'headings', 1 );
		$params->def( 'position', '1' );
		$params->def( 'email', '1' );
		$params->def( 'phone', '1' );
		$params->def( 'fax', '1' );
		$params->def( 'telephone', '1' );

		// page description
		$currentcat->descrip = '';
		if( ( @$currentcat->description ) <> '' ) {
			$currentcat->descrip = $currentcat->description;
		} else if ( !$catid ) {
			// show description
			if ( $params->get( 'description' ) ) {
				$currentcat->descrip = $params->get( 'description_text' );
			}
		}

		// page image
		$currentcat->img = '';
		$path = $mosConfig_live_site .'/images/stories/';
		if ( ( @$currentcat->image ) <> '' ) {
			$currentcat->img = $path . $currentcat->image;
			$currentcat->align = $currentcat->image_position;
		} else if ( !$catid ) {
			if ( $params->get( 'image' ) <> -1 ) {
				$currentcat->img = $path . $params->get( 'image' );
				$currentcat->align = $params->get( 'image_align' );
			}
		}

		// page header
		$currentcat->header = '';
		if ( @$currentcat->name <> '' ) {
			$currentcat->header = $currentcat->name;
		} else {
			$currentcat->header = $params->get( 'header' );
		}

		// used to show table rows in alternating colours
		$tabclass = array( 'sectiontableentry1', 'sectiontableentry2' );

		HTML_contact::displaylist( $categories, $rows, $catid, $currentcat, $params, $tabclass );
	}
}


function contactpage( $option, $contact_id ) {
	global $mainframe, $database, $my, $Itemid;

	$query = "SELECT a.id AS value, CONCAT_WS( ' - ', a.name, a.con_position ) AS text"
	. "\n FROM #__contact_details AS a"
	. "\n LEFT JOIN #__categories AS cc ON cc.id = a.catid"
	. "\n WHERE a.published = '1'"
	. "\n AND cc.published = '1'"
	. "\n AND a.access <=". $my->gid
	. "\n AND cc.access <=". $my->gid
	. "\n ORDER BY a.default_con DESC, a.ordering ASC"
	;


	$database->setQuery( $query );
	$list = $database->loadObjectList();
	$count = count( $list );

	if ( $count ) {

		if ( $contact_id < 1 ) {
		    $contact_id = $list[0]->value;
		}

		$query = "SELECT *"
		. "\n FROM #__contact_details"
		. "\n WHERE published = '1'"
		. "\n AND id = ".$contact_id
		. "\n AND access <=". $my->gid;
		$database->SetQuery($query);
		$contacts = $database->LoadObjectList();

		if (!$contacts){
			echo _NOT_AUTH;
			return;
		}
		$contact = $contacts[0];
		// creates dropdown select list
		$contact->select = mosHTML::selectList( $list, 'contact_id', 'class="inputbox" onchange="ViewCrossReference(this);"', 'value', 'text', $contact_id );

		// Adds parameter handling
		$params =& new mosParameters( $contact->params );

		$params->set( 'page_title', 0 );
		$params->def( 'pageclass_sfx', '' );
		$params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );
		$params->def( 'print', !$mainframe->getCfg( 'hidePrint' ) );
		$params->def( 'name', '1' );
		$params->def( 'email', '0' );
		$params->def( 'street_address', '1' );
		$params->def( 'suburb', '1' );
		$params->def( 'state', '1' );
		$params->def( 'country', '1' );
		$params->def( 'postcode', '1' );
		$params->def( 'telephone', '1' );
		$params->def( 'fax', '1' );
		$params->def( 'misc', '1' );
		$params->def( 'image', '1' );
		$params->def( 'email_description', '1' );
		$params->def( 'email_description_text', _EMAIL_DESCRIPTION );
		$params->def( 'email_form', '1' );
		$params->def( 'email_copy', '1' );
		// global pront|pdf|email
		$params->def( 'icons', $mainframe->getCfg( 'icons' ) );
		// contact only icons
		$params->def( 'contact_icons', 0 );
		$params->def( 'icon_address', '' );
		$params->def( 'icon_email', '' );
		$params->def( 'icon_telephone', '' );
		$params->def( 'icon_fax', '' );
		$params->def( 'icon_misc', '' );
		$params->def( 'drop_down', '0' );


		if ( $contact->email_to && $params->get( 'email' )) {
			// email cloacking
			$contact->email = mosHTML::emailCloaking( $contact->email_to );
		}

		// loads current template for the pop-up window
		$pop = mosGetParam( $_REQUEST, 'pop', 0 );
		if ( $pop ) {
			$params->set( 'popup', 1 );
			$params->set( 'back_button', 0 );
		}

		if ( $params->get( 'email_description' ) ) {
			$params->set( 'email_description', $params->get( 'email_description_text' ) );
		} else {
			$params->set( 'email_description', '' );
		}

		// needed to control the display of the Address marker
		$temp = $params->get( 'street_address' )
		. $params->get( 'suburb' )
		. $params->get( 'state' )
		. $params->get( 'country' )
		. $params->get( 'postcode' )
		;
		$params->set( 'address_check', $temp );

		// determines whether to use Text, Images or nothing to highlight the different info groups
		switch ( $params->get( 'contact_icons' ) ) {
			case 1:
			// text
				$params->set( 'marker_address', _CONTACT_ADDRESS );
				$params->set( 'marker_email', _CONTACT_EMAIL );
				$params->set( 'marker_telephone', _CONTACT_TELEPHONE );
				$params->set( 'marker_fax', _CONTACT_FAX );
				$params->set( 'marker_misc', _CONTACT_MISC );
				$params->set( 'column_width', '100px' );
				break;
			case 2:
			// none
				$params->set( 'marker_address', '' );
				$params->set( 'marker_email', '' );
				$params->set( 'marker_telephone', '' );
				$params->set( 'marker_fax', '' );
				$params->set( 'marker_misc', '' );
				$params->set( 'column_width', '0px' );
				break;
			default:
			// icons
				$image1 = mosAdminMenus::ImageCheck( 'con_address.png', '/images/M_images/', $params->get( 'icon_address' ) );
				$image2 = mosAdminMenus::ImageCheck( 'emailButton.png', '/images/M_images/', $params->get( 'icon_email' ) );
				$image3 = mosAdminMenus::ImageCheck( 'con_tel.png', '/images/M_images/', $params->get( 'icon_telephone' ) );
				$image4 = mosAdminMenus::ImageCheck( 'con_fax.png', '/images/M_images/', $params->get( 'icon_fax' ) );
				$image5 = mosAdminMenus::ImageCheck( 'con_info.png', '/images/M_images/', $params->get( 'icon_misc' ) );
				$params->set( 'marker_address', $image1 );
				$params->set( 'marker_email', $image2 );
				$params->set( 'marker_telephone', $image3 );
				$params->set( 'marker_fax', $image4 );
				$params->set( 'marker_misc', $image5 );
				$params->set( 'column_width', '40px' );
				break;
		}

		HTML_contact::viewcontact( $contact, $params, $count, $list );
	} else {
		$params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );
		HTML_contact::nocontact( $params );
	}
}


function sendmail( $con_id, $option ) {
	global $database, $Itemid;
	global $mosConfig_sitename, $mosConfig_mailfrom, $mosConfig_fromname;

	$database->setQuery( "SELECT email_to FROM #__contact_details WHERE id='$con_id'" );
	$email_to = $database->loadResult();

	$default = $mosConfig_sitename.' '. _ENQUIRY;
	$email = trim( mosGetParam( $_POST, 'email', '' ) );
	$text = trim( mosGetParam( $_POST, 'text', '' ) );
	$name = trim( mosGetParam( $_POST, 'name', '' ) );
	$subject = trim( mosGetParam( $_POST, 'subject', $default ) );
	$email_copy = mosGetParam( $_POST, 'email_copy', 0 );

	if ( !$email || !$text || ( is_email( $email )==false ) ) {
		echo "<script>alert (\""._CONTACT_FORM_NC."\"); window.history.go(-1);</script>";
		exit(0);
	}
	$text = _ENQUIRY_TEXT.' '.$name. ' ('. $email .')' ."\r \n". stripslashes($text);

	mosMail( $mosConfig_mailfrom, $mosConfig_fromname, $email_to, $subject, $text );

	if ( $email_copy ) {
		$copy_text = sprintf( _COPY_TEXT, $mosConfig_sitename );
		$copy_text = $copy_text ."\n\n". $text .'';
		$copy_subject = _COPY_SUBJECT . $subject;
		mosMail( $mosConfig_mailfrom, $mosConfig_fromname, $email, $copy_subject, $copy_text );
	}
	?>
	<script>
	alert( "<?php echo _THANK_MESSAGE; ?>" );
	document.location.href='<?php echo sefRelToAbs( "index.php?option=$option&amp;Itemid=$Itemid" ); ?>';
	</script>
	<?php
}


function is_email($email){
	$rBool=false;

	if  ( preg_match( "/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/" , $email ) ){
		$rBool=true;
	}
	return $rBool;
}

?>
