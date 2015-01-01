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
<link href="<?php echo $mosConfig_live_site;?>/templates/allm_business_blues_var/css/template_css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<a name="up" id="up"></a> 
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
  <tr> 
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="370" height="30" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_business_blues_var/images/date_bck.gif" class="date"><?php echo (strftime (_DATE_FORMAT_LC, time()+($mosConfig_offset*60*60))); ?></td>
          <td height="30" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_business_blues_var/images/search_bck.gif" class="search"> 
            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top"> 
                  <form action='<?php echo sefRelToAbs("index.php"); ?>' method='post'>
                  <input class="inputbox" type="text" name="searchword" size="25" value="<?php echo _SEARCH_BOX; ?>"  onblur="if(this.value=='') this.value='<?php echo _SEARCH_BOX; ?>';" onfocus="if(this.value=='<?php echo _SEARCH_BOX; ?>') this.value='';" />
                    <input type="submit" name="option" class="button" value="Go!">
                    <input type="hidden" name="option" value="search" />
                </form>
				</td>
              </tr>
            </table>		  		  
		  </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="202"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_business_blues_var/images/logo_1.gif" width="202" height="163" /></td>
          <td width="221"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_business_blues_var/images/logo_2.gif" width="221" height="163" /></td>
          <td width="311"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_business_blues_var/images/logo.gif" width="311" height="163" /></td>
          <td background="<?php echo $mosConfig_live_site;?>/templates/allm_business_blues_var/images/logo_strech.gif">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="202" height="31" background="<?php echo $mosConfig_live_site;?>/templates/allm_business_blues_var/images/path_bck.gif">
           </td>
          <td valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_business_blues_var/images/path_bck.gif" class="pathway"> 
            <?php include "pathway.php"; ?>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="202" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_business_blues_var/images/left_bck.gif"> 
            <?php mosLoadModules ( 'left' ); ?>
            <?php mosLoadModules ( 'user1' ); ?>
          </td>
          <td valign="top" class="content"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr> 
                <td valign="top" class="arrow">
                  <?php include_once ("mainbody.php"); ?>
                </td>
                <td width="160" align="center" valign="top" class="right"> 
                  <?php mosLoadModules ( 'right' ); ?>
                  <?php mosLoadModules ( 'user2' ); ?>
                </td>
              </tr>
            </table></td>
          <td width="46" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_business_blues_var/images/right_col_bck.gif"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_business_blues_var/images/right_col_top.gif" width="46" height="62" /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="202"><a href="http://www.allmambo.com" target="_blank"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_business_blues_var/images/footer_left.gif" width="202" height="23" border="0" /></a></td>
          <td background="<?php echo $mosConfig_live_site;?>/templates/allm_business_blues_var/images/footer_bck.gif">&nbsp;</td>
          <td width="46"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_business_blues_var/images/footer_right.gif" width="46" height="23" /></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
