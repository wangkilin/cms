<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
// needed to seperate the ISO number from the language file constant _ISO
$iso = split( '=', _ISO );
// xml prolog
echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php mosShowHead(); ?>
<?php
if ( $my->id ) {
	initEditor();
}
$collspan_offset = ( mosCountModules( 'right' ) + mosCountModules( 'user2' ) ) ? 2 : 1;
//script to determine which div setup for layout to use based on module configuration
$user1 = 0;
$user2 = 0;
$sandbox_area = 0;
// banner combos

//user1 combos
if ( mosCountModules( 'user1' ) + mosCountModules( 'user2' ) == 2) {
	$user1 = 2;
	$user2 = 2;
} elseif ( mosCountModules( 'user1' ) == 1 ) {
	$user1 = 1;
} elseif ( mosCountModules( 'user2' ) == 1 ) {
	$user2 = 1;
}

//right based combos
if ( mosCountModules( 'right' ) and ( empty( $_REQUEST['task'] ) || $_REQUEST['task'] != 'edit' ) ) {
	$sandbox_area = 2;
} else {
	$sandbox_area = 1;
	$user1 = $user1 == 1 ? 3 : 4;
	$user2 = $user2 == 1 ? 3 : 4;
}
?>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<link href="<?php echo $mosConfig_live_site;?>/templates/rhuk_solarflare/css/template_css.css" rel="stylesheet" type="text/css"/>
<link rel="shortcut icon" href="<?php echo $mosConfig_live_site;?>/images/favicon.ico"/>
</head>
<body>

<div align="center">
	<div id="main_outline">
		<div id="pathway_outline">
			<div id="pathway">
			<?php mosPathWay(); ?>
			</div>
			<div id="buttons">
			<?php mosLoadModules ( 'user3', -1); ?>
			</div>
		</div>
		<div id="search">
		<?php mosLoadModules ( 'user4', -1 ); ?>
		</div>
		<div class="clr"></div>
		<div id="header_area">
			<div id="header">
			<img src="<?php echo $mosConfig_live_site;?>/templates/rhuk_solarflare/images/title_back.png" width="500" height="100" alt="SolarFlare"/>
			</div>
			<div id="top_outline">
			<?php
			if ( mosCountModules( 'top' ) ) {
				mosLoadModules ( 'top' );
			} else {
				?>
				<span class="error">Top Module Empty</span>
				<?php
			}
			?>
			</div>
		</div>
		<div id="left_outline">
			<div id="left">
			<?php mosLoadModules ( 'left' ); ?>
			</div>
		</div>
		<div id="content_area">
			<div id="content">
			<?php
			if ( mosCountModules ('banner') ) {
				?>
				<div id="banner_area">
					<div id="banner">
                <img src="<?php echo $mosConfig_live_site;?>/templates/rhuk_solarflare/images/advertisement.png" alt="advertisement.png, 0 kB" title="advertisement" border="0" height="8" width="468"/><br />
					<?php mosLoadModules( 'banner', -1 ); ?>
					</div>
					<div id="poweredby">
					<img src="<?php echo $mosConfig_live_site;?>/templates/rhuk_solarflare/images/powered_by.png" alt="powered_by.png, 1 kB" title="powered_by" border="0" height="68" width="165"/><br />
					</div>
				</div>
				<?php
			}
			if ( mosCountModules( 'right' ) and ( empty ($_REQUEST['task'] ) || $_REQUEST['task']!='edit' ) ) {
				?>
				<div id="right_outline">
					<div id="right">
					<?php mosLoadModules ( 'right' ); ?>
					</div>
				</div>
				<?php
			}
			?>
			<div id="sandbox_area_<?php echo $sandbox_area ?>">
				<div class="sandbox_area">
					<?php
					if ( mosCountModules( 'user1' ) ) {
						?>
						<div id="user1_<?php echo $user1; ?>">
							<div class="user1_outline">
							<?php mosLoadModules ( 'user1' ); ?>
							</div>
						</div>
						<?php
					}
					if (mosCountModules( 'user2' )) {
						?>
						<div id="user2_<?php echo $user2; ?>">
							<div class="user2_outline">
							<?php mosLoadModules ( 'user2' ); ?>
							</div>
						</div>
						<?php
					}
					?>
					<div class="clr"></div>
					<div class="content_outline">
					<?php mosMainBody(); ?>
					</div>
					<div class="clr"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="clr"></div>
	</div>
</div>
<?php include_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/footer.php' ); ?>
<?php mosLoadModules( 'debug', -1 );?>
</body>
</html>
