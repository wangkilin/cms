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
<link href="<?php echo $mosConfig_live_site;?>/templates/allm_3d9/css/template_css.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#333300" text="#000000" topmargin="0" bottommargin="0">
<center>
<table width="630" border="0" cellpadding="0" cellspacing="0" background="<?php echo $mosConfig_live_site;?>/templates/allm_3d9/images/bg.jpg">
  <tr> 
      <td colspan="2" height="175" valign="top"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_3d9/images/header.jpg" width="630" height="175"></td>
  </tr>
  <tr> 
    <td width="145" height="186" valign="top"> 
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <!--DWLayoutTable-->
          <tr> 
            <td height="30" valign="top" colspan="2"> <table width="100%" border="0" cellpadding="0" cellspacing="0" background="<?php echo $mosConfig_live_site;?>/templates/allm_3d9/images/navcat.jpg">
                <tr> 
                  <td width="32" valign="top" rowspan="3">&nbsp;</td>
                  <td width="113" height="3"></td>
                </tr>
                <tr> 
                  <td valign="middle" height="19"><b><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Navigation</font></b></td>
                </tr>
                <tr> 
                  <td height="8"></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td width="31" height="103" valign="top">&nbsp;</td>
            <td valign="top" width="114"><font color="#333300" size="1" face="Arial, Helvetica, sans-serif"><b> 
              <?php mosLoadModules ( 'left' ); ?>
              <?php mosLoadModules ( 'user1' ); ?>
              </b></font></td>
          </tr>
          <tr> 
            <td height="31">&nbsp;</td>
            <td valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
          </tr>
          <tr> 
            <td height="23" valign="top">&nbsp;</td>
            <td valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
          </tr>
        </table>
    </td>
    <td width="485" valign="top"> 
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <!--DWLayoutTable-->
          <tr> 
            <td width="26" valign="top" rowspan="3">&nbsp;</td>
            <td valign="top" width="430" height="36"> <table width="100%" border="0" cellpadding="0" cellspacing="0" background="<?php echo $mosConfig_live_site;?>/templates/allm_3d9/images/contenthead.jpg">
                <!--DWLayoutTable-->
                <tr> 
                  <td width="6" height="4"></td>
                  <td width="424"></td>
                </tr>
                <tr> 
                  <td height="19"></td>
                  <td valign="top"><span class="pathway">
                    <?php include "pathway.php"; ?>
                    </span></td>
                </tr>
                <tr> 
                  <td height="13"></td>
                  <td></td>
                </tr>
              </table></td>
            <td width="29" rowspan="3" valign="top">&nbsp;</td>
          </tr>
          <tr> 
            <td valign="top" height="126">
              <?php include_once ("mainbody.php"); ?>
            </td>
          </tr>
          <tr> 
            <td valign="top" height="25"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_3d9/images/contentend.jpg" width="430" height="20"></td>
          </tr>
        </table>
    </td>
  </tr>
  <tr> 
    <td height="91" colspan="2" valign="top">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="630" height="91" valign="top"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_3d9/images/footer.jpg" width="630" height="115"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</center>
</body>

</html>
