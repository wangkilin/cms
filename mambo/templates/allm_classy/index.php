<?php echo "<?xml version=\"1.0\"?".">"; ?>
<?php defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title><?php echo $mosConfig_sitename; ?></title>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<?php
if ($my->id) {
	include ("editor/editor.php");
	initEditor();
}
?>
<?php include ("includes/metadata.php"); ?>
<script language="JavaScript" type="text/javascript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<link href="<?php echo $mosConfig_live_site;?>/templates/allm_classy/css/template_css.css" rel="stylesheet" type="text/css" />

</head>
<body>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td background="<?php echo $mosConfig_live_site;?>/templates/allm_classy/images/logo_left.gif">&nbsp;</td>
          <td width="754" height="167" align="left" valign="bottom" background="<?php echo $mosConfig_live_site;?>/templates/allm_classy/images/logo.gif" class="date"> <?php echo (strftime (_DATE_FORMAT_LC, time()+($mosConfig_offset*60*60))); ?> </td>
          <td background="<?php echo $mosConfig_live_site;?>/templates/allm_classy/images/logo_right.gif">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="51"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_classy/images/menu_left.gif" width="51" height="24" /></td>
          <td valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_classy/images/menu_bck.gif">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="19" background="<?php echo $mosConfig_live_site;?>/templates/allm_classy/images/path.gif" class="pathway">
            <?php include "pathway.php"; ?> </td>
        </tr>
      </table>
<?php 
	  if ($option == "com_frontpage") { ?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="169" bgcolor="#7EA1BD">&nbsp;</td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="10" valign="top"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_classy/images/welcome_left.gif" width="10" height="76" /></td>
                <td valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_classy/images/welcome_bck.gif" class="welcome"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_classy/images/welcome_img.gif" width="307" height="20" /><br />
                  Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec 
                  diam. Morbi in justo. Quisque molestie volutpat sem. Duis in 
                  magna eget felis rutrum. Morbi et nibh vel arcu condimentum 
                  vestibulum. Vestibulum molestie augue vitae dui. </td>
                <td width="76" valign="top"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_classy/images/welcome_right.gif" width="83" height="76" /></td>
              </tr>
            </table></td>
          <td width="9" bgcolor="#7EA1BD">&nbsp;</td>
        </tr>
      </table>
<?php }
else {
} ?>	  
	  
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="169" align="center" valign="top" bgcolor="#7EA1BD"><table width="157" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td> 
                  <?php mosLoadModules ( 'left' ); ?>
                  <?php mosLoadModules ( 'user1' ); ?>
                </td>
              </tr>
            </table></td>
          <td width="25" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_classy/images/main_left.gif"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_classy/images/main_left.gif" width="25" height="14" /></td>
          <td valign="top" bgcolor="#DBE7F2">
            <?php include_once ("mainbody.php"); ?>
          </td>
          <td width="25" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_classy/images/main_right.gif"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_classy/images/main_right.gif" width="25" height="14" /></td>
          <?php if (mosCountModules( "right" )) { ?>
		  <td width="170" align="center" valign="top" bgcolor="#7EA1BD"><table width="157" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td> 
                  <?php mosLoadModules ( 'right' ); ?>
                  <?php mosLoadModules ( 'user2' ); ?>
                </td>
              </tr>
            </table></td>
			<?php } ?>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" background="<?php echo $mosConfig_live_site;?>/templates/allm_classy/images/footer_bck.gif">
        <tr>
          <td width="5">&nbsp;</td>
          <td width="157"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_classy/images/des_by.gif" width="157" height="39" border="0" usemap="#des_by" /></td>
          <td valign="top">&nbsp;</td>
        </tr>
      </table>

    </td>
  </tr>
</table>
<map name="des_by" id="des_by">
  <area shape="rect" coords="6,2,153,21" href="http://www.allmambo.com" target="_blank" alt="designed by allmambo.com" />
</map>
</body>
</html>
