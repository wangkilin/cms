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
<link href="<?php echo $mosConfig_live_site;?>/templates/allm_mos_underground/css/template_css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<a name="up" id="up"></a> 
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="198"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_mos_underground/images/top_left.gif" width="198" height="33" /></td>
          <td background="<?php echo $mosConfig_live_site;?>/templates/allm_mos_underground/images/top_var.gif"><?php echo (strftime (_DATE_FORMAT_LC, time()+($mosConfig_offset*60*60))); ?></td>
          <td width="37"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_mos_underground/images/top_right.gif" width="37" height="33" /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="198" rowspan="2" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_mos_underground/images/left_bck.gif">
<table width="198" border="0" cellspacing="0" cellpadding="0" class="right">
              <tr> 
                <td align="center" valign="top" class="right"> <img src="<?php echo $mosConfig_live_site;?>/templates/allm_mos_underground/images/spacer.gif" width="198" height="1" /> 
                  <br />
                  <br />
                  <?php mosLoadModules ( 'left' ); ?>
                  <?php mosLoadModules ( 'user1' ); ?>
                </td>
              </tr>
            </table>
          </td>
          <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="557"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_mos_underground/images/logo.gif" width="557" height="123" /></td>
                <td background="<?php echo $mosConfig_live_site;?>/templates/allm_mos_underground/images/logo_var.gif">&nbsp;</td>
                <td width="36"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_mos_underground/images/logo_right.gif" width="36" height="123" /></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_mos_underground/images/pathway_bck.gif" class="pathway"> 
                  <?php include "pathway.php"; ?>
                </td>
                <td width="32"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_mos_underground/images/pathway_right.gif" width="32" height="31" /></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr> 
          <td width="100%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="content">
              <tr> 
                <td valign="top" class="content"> 
                  <?php include_once ("mainbody.php"); ?>
                </td>
              </tr>
            </table></td>
          <td width="32" background="<?php echo $mosConfig_live_site;?>/templates/allm_mos_underground/images/right_col_bck.gif"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_mos_underground/images/spacer.gif" width="32" height="1" /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="198"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_mos_underground/images/footer_left.gif" width="198" height="38" border="0" usemap="#Map" /></td>
          <td background="<?php echo $mosConfig_live_site;?>/templates/allm_mos_underground/images/footer_var.gif">&nbsp;</td>
          <td width="112"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_mos_underground/images/footer_right.gif" width="112" height="38" /></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<map name="Map" id="Map">
  <area shape="rect" coords="9,21,187,38" href="http://www.allmambo.com" target="_blank" alt="allmambo.com" />
</map>
</body>
</html>
