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
<link href="<?php echo $mosConfig_live_site;?>/templates/allm_lime/css/template_css.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="<?php echo $mosConfig_live_site;?>/templates/allm_lime/images/index_01.gif" width="428" height="154" /><img src="<?php echo $mosConfig_live_site;?>/templates/allm_lime/images/index_02.gif" width="332" height="154" />
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="37" align="center" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_lime/images/index_03.gif" class="pathway">
        <?php include "pathway.php"; ?></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="158" height="414" align="center" valign="top" class="left"> 
            <?php mosLoadModules ( 'left' ); ?>
            <?php mosLoadModules ( 'user1' ); ?>
          </td>
          <td valign="top" bgcolor="#FFFFFF" class="content">
            <?php include_once ("mainbody.php"); ?>
          </td>
          <td width="159" align="center" valign="top" class="right"> 
            <?php mosLoadModules ( 'right' ); ?>
            <?php mosLoadModules ( 'user2' ); ?>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="<?php echo $mosConfig_live_site;?>/templates/allm_lime/images/index_07.gif" width="760" height="35" border="0" usemap="#Map" /></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<map name="Map" id="Map">
  <area shape="rect" coords="612,10,754,27" href="http://www.allmambo.com" target="_blank" alt="allmambo.com" />
</map>
</body>
</html>