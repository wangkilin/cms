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

<link href="<?php echo $mosConfig_live_site;?>/templates/allm_flower/css/template_css.css" rel="stylesheet" type="text/css" />

</head>

<Center>

<body>

<table width="769" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="237" height="74" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_flower/images/header.gif" bgcolor="#FFFFFF"><!--DWLayoutEmptyCell-->&nbsp;</td>
    <td valign="top" bgcolor="#0099CC">
<p><?php echo (strftime (_DATE_FORMAT_LC, time()+($mosConfig_offset*60*60))); ?></p>
      <p><span class="pathway"> 
        <?php include "pathway.php"; ?>
        </span></p></td>
    <td width="21">&nbsp;</td>
  </tr>
  <tr> 
    <td rowspan="2" valign="top" bgcolor="#EEEEEE"> 
      <table width="250" border="0" cellspacing="0" cellpadding="0" class="flower">
        <tr>
          <td valign="top"> 
            <?php mosLoadModules ( 'left' ); ?>
            <?php mosLoadModules ( 'user1' ); ?>
          </td>
        </tr>
      </table> 
    </td>
    &nbsp; 
    <td rowspan="2" valign="top" bgcolor="#E0E0E0"> 
      <?php include_once ("mainbody.php"); ?>
    </td>
    <td height="200">&nbsp;</td>
    <!--DWLayoutEmptyCell-->
    &nbsp; </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>

</body>

</html>

