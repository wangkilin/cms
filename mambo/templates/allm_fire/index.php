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
<link href="<?php echo $mosConfig_live_site;?>/templates/allm_fire/css/template_css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<a name="up" id="up"></a> 
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
  <tr>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="150" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_fire/images/date_bck.gif" class="date"><?php echo (strftime (_DATE_FORMAT_LC, time()+($mosConfig_offset*60*60))); ?></td>
          <td valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_fire/images/search_bck.gif" class="search"><table width="180" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td valign="top"> <form action='<?php echo sefRelToAbs("index.php"); ?>' method='post'>
                    <input class="inputbox" type="text" name="searchword" size="18" value="<?php echo _SEARCH_BOX; ?>"  onblur="if(this.value=='') this.value='<?php echo _SEARCH_BOX; ?>';" onfocus="if(this.value=='<?php echo _SEARCH_BOX; ?>') this.value='';" />
                    <input type="submit" name="option" class="button" value="Go!" />
                    <input type="hidden" name="option" value="search" />
                  </form></td>
              </tr>
            </table></td>
          <td width="172"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_fire/images/search_right.gif" width="172" height="36" /></td>
        </tr>
      </table>
	  <img src="<?php echo $mosConfig_live_site;?>/templates/allm_fire/images/logo.gif" /><table width="780" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="175"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_fire/images/path_left.gif" width="175" height="24" /></td>
          <td height="24" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_fire/images/path_mid.gif" class="pathway"> 
            <?php include "pathway.php"; ?>
          </td>
          <td width="172"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_fire/images/path_right.gif" width="172" height="24" /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="175" align="center" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_fire/images/mod_left.gif"> 
            <?php mosLoadModules ( 'left' ); ?>
            <?php mosLoadModules ( 'user1' ); ?>
          </td>
          <td valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_fire/images/content_bck.gif"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_fire/images/content_top.gif" width="433" height="25" /> 
            <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top">
                  <?php include_once ("mainbody.php"); ?>
                </td>
              </tr>
            </table> </td>
          <td width="172" align="center" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_fire/images/mod_right.gif"> 
            <?php mosLoadModules ( 'right' ); ?>
            <?php mosLoadModules ( 'user2' ); ?>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="175"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_fire/images/footer_left.gif" width="175" height="61" /></td>
          <td valign="bottom" background="<?php echo $mosConfig_live_site;?>/templates/allm_fire/images/footer_mid.gif">&nbsp;</td>
          <td width="172"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_fire/images/footer_right.gif" width="172" height="61" border="0" usemap="#Map" /></td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
<map name="Map" id="Map">
  <area shape="rect" coords="12,44,163,62" href="http://www.allmambo.com" target="_blank" alt="allmambo.com" />
</map>
</body>
</html>
