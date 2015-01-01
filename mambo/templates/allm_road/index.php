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
<link href="<?php echo $mosConfig_live_site;?>/templates/allm_road/css/template_css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<a name="up" id="up"></a> 
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="314"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_road/images/path_left.gif" width="314" height="22" /></td>
          <td background="<?php echo $mosConfig_live_site;?>/templates/allm_road/images/path_bck.gif" class="pathway">
            <?php include "pathway.php"; ?>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="444"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_road/images/logo.gif" width="444" height="59" /></td>
          <td width="336"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_road/images/logo_right.gif" width="336" height="59" /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="185" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_road/images/left_bck.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top" class="left"> 
                  <?php mosLoadModules ( 'left' ); ?>
                  <?php mosLoadModules ( 'user1' ); ?>
                </td>
              </tr>
            </table></td>
          <td valign="top"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_road/images/menu_mid.gif" width="259" height="150" /><img src="<?php echo $mosConfig_live_site;?>/templates/allm_road/images/menu_right.gif" width="336" height="150" />
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="259" height="33" align="center" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_road/images/search_bck.gif" class="search"> 
                  <table width="180" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td valign="top"> <form action='<?php echo sefRelToAbs("index.php"); ?>' method='post'>
                          <input class="inputbox" type="text" name="searchword" size="18" value="<?php echo _SEARCH_BOX; ?>"  onblur="if(this.value=='') this.value='<?php echo _SEARCH_BOX; ?>';" onfocus="if(this.value=='<?php echo _SEARCH_BOX; ?>') this.value='';" />
                          <input type="submit" name="option" class="button" value="Go!" />
                          <input type="hidden" name="option" value="search" />
                        </form></td>
                    </tr>
                  </table>
                </td>
                <td width="185" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_road/images/date_bck.gif" class="date"><?php echo (strftime (_DATE_FORMAT_LC, time()+($mosConfig_offset*60*60))); ?></td>
                <td width="151" background="<?php echo $mosConfig_live_site;?>/templates/allm_road/images/right_top.gif">&nbsp;</td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td valign="top" class="content"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td valign="top"> 
                        <?php include_once ("mainbody.php"); ?>
                      </td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="185"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_road/images/footer_left.gif" width="185" height="41" border="0" usemap="#Map2" /></td>
          <td background="<?php echo $mosConfig_live_site;?>/templates/allm_road/images/footer_mid.gif">&nbsp;</td>
          <td width="151"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_road/images/footer_right.gif" width="151" height="41" /></td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
<map name="Map2" id="Map2">
  <area shape="rect" coords="8,21,158,47" href="http://www.allmambo.com" target="_blank" alt="allmambo.com" />
</map>
</body>
</html>
