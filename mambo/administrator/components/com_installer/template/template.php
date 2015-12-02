<?php
/**
* @version $Id: template.php,v 1.1 2004/10/13 08:16:15 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
* @subpackage Installer
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if ( !$acl->acl_check( 'administration', 'install', 'users', $my->usertype, $element . 's', 'all' ) ) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

$client = mosGetParam( $_REQUEST, 'client', '' );

$userfile = mosGetParam( $_REQUEST, 'userfile', dirname( __FILE__ ) );
$userfile = mosPathName( $userfile );

HTML_installer::showInstallForm( $adminLanguage->A_INSTALL_TEMPL_INSTALL . ($client == 'admin' ? $adminLanguage->A_INSTALL_TEMPL_ADMIN_TEMPL : $adminLanguage->A_INSTALL_TEMPL_SITE_TEMPL) ,
	$option, 'template', $client, $userfile,
	'<a href="index2.php?option=com_templates&client='.$client.'">'.$adminLanguage->A_INSTALL_TEMPL_BACKTTO_TEMPL.'</a>'
);
?>
<table class="content">
<?php
writableCell( 'media' );
writableCell( 'administrator/templates' );
writableCell( 'templates' );
writableCell( 'images/stories' );
?>
</table>
