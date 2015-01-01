<?php
/**
* @version $Id: login.html.php,v 1.11 2004/09/19 09:52:45 stingrey Exp $
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
class loginHTML {

	function loginpage ( &$params, $image ) {
		global $mosConfig_lang; 

		$return = mosGetParam( $_SERVER, 'REQUEST_URI', null );
		?>
		<form action="<?php echo sefRelToAbs( 'index.php?option=login' ); ?>" method="post" name="login" id="login">
		<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" class="contentpane<?php echo $params->get( 'pageclass_sfx' ); ?>">
		<tr>
			<td colspan="2">
			<?php 
			if ( $params->get( 'page_title' ) ) {
				?>
				<div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
				<?php echo $params->get( 'header_login' ); ?>
				</div>
				<?php
			}
			?>
			<div>
			<?php echo $image; ?>
			<?php
			if ( $params->get( 'description_login' ) ) {
				 ?>
				<?php echo $params->get( 'description_login_text' ); ?>
				<br/><br/>
				<?php
			}
			?>
			</div>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"> 
				<br />
				<table>
				<tr>
					<td align="center">
					<?php echo _USERNAME; ?>
					<br /> 
					</td>
					<td align="center">
					<?php echo _PASSWORD; ?>
					<br /> 
					</td>
				</tr>
				<tr>
					<td align="center">
					<input name="username" type="text" class="inputbox" size="20" />
					</td>
					<td align="center">
					<input name="passwd" type="password" class="inputbox" size="20" />
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2">
					<?php echo _REMEMBER_ME; ?>
					<input type="checkbox" name="remember" class="inputbox" value="yes" /> 
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td> 
			<noscript>
			<?php echo _CMN_JAVASCRIPT; ?>
			</noscript>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
			<br />
			<input type="submit" name="submit" class="button" value="<?php echo _BUTTON_LOGIN; ?>" />
			</td>
		</tr>
		</table>
		<?php
		// displays back button
		mosHTML::BackButton ( $params );
		?>


		<input type="hidden" name="op2" value="login" />
		<input type="hidden" name="return" value="<?php echo sefRelToAbs( $params->get( 'login' ) ); ?>" />
		<input type="hidden" name="lang" value="<?php echo $mosConfig_lang; ?>" />
		<input type="hidden" name="message" value="<?php echo $params->get( 'login_message' ); ?>" />
		</form>
		<?php  
  	}
	
	function logoutpage( &$params, $image ) {
		global $mosConfig_lang; 

		?>
		<form action="<?php echo sefRelToAbs( 'index.php?option=logout' ); ?>" method="post" name="login" id="login">
        	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" class="contentpane<?php echo $params->get( 'pageclass_sfx' ); ?>">
		<tr>
			<td valign="top">
			<?php 
			if ( $params->get( 'page_title' ) ) {
				?>
				<div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
				<?php echo $params->get( 'header_logout' ); ?>
				</div>
				<?php
			}
			?>
			<div>
			<?php echo $image; ?>
			<?php
			if ( $params->get( 'description_logout' ) ) {
				 ?>
				<?php echo $params->get( 'description_logout_text' ); ?>
				<br/><br/>
				<?php
			}
			?>
			</div>
			</td>
		</tr>
		<tr>
			<td align="center">
			<input type="submit" name="Submit" class="button" value="<?php echo _BUTTON_LOGOUT; ?>" />
			</td>
		</tr>
        	</table>

		<input type="hidden" name="op2" value="logout" />
		<input type="hidden" name="return" value="<?php echo sefRelToAbs( $params->get( 'logout' ) ); ?>" />
		<input type="hidden" name="lang" value="<?php echo $mosConfig_lang; ?>" />
		<input type="hidden" name="message" value="<?php echo $params->get( 'logout_message' ); ?>" />
		</form>
	<?php
	}
}
?>
