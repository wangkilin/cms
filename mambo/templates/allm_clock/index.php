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

<link href="<?php echo $mosConfig_live_site;?>/templates/allm_clock/css/template_css.css" rel="stylesheet" type="text/css" />

</head>

<body>

<a name="up" id="up"></a> 

<table width="760" border="0" align="center" cellpadding="0" cellspacing="0" class="main">

  <tr>

    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td height="27" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_clock/images/path_bck.gif" class="pathway"><span class="pathway"> 

            <?php include "pathway.php"; ?>

            </span></td>

        </tr>

      </table>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td width="266" height="28" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_clock/images/date_bck.gif" class="date"><?php echo (strftime (_DATE_FORMAT_LC, time()+($mosConfig_offset*60*60))); ?></td>

          <td><img src="<?php echo $mosConfig_live_site;?>/templates/allm_clock/images/date_right.gif" width="494" height="28" /></td>

        </tr>

      </table>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td><img src="<?php echo $mosConfig_live_site;?>/templates/allm_clock/images/logo.gif" width="760" height="82" /></td>

        </tr>

      </table>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td width="266" height="28" align="center" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_clock/images/search_bck.gif" class="search">

            <table width="180" border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td valign="top"> 

                  <form action='<?php echo sefRelToAbs("index.php"); ?>' method='post'>

                  <input class="inputbox" type="text" name="searchword" size="18" value="<?php echo _SEARCH_BOX; ?>"  onblur="if(this.value=='') this.value='<?php echo _SEARCH_BOX; ?>';" onfocus="if(this.value=='<?php echo _SEARCH_BOX; ?>') this.value='';" />

                    <input type="submit" name="option" class="button" value="Go!">

                    <input type="hidden" name="option" value="search" />

                </form>

				</td>

              </tr>

            </table>		  

		  </td>

          <td><img src="<?php echo $mosConfig_live_site;?>/templates/allm_clock/images/search_right.gif" width="494" height="28" /></td>

        </tr>

      </table>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td width="171"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_clock/images/left_top.gif" width="171" height="21" /></td>

          <td background="<?php echo $mosConfig_live_site;?>/templates/allm_clock/images/middle_top.gif">&nbsp;</td>

          <td width="168"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_clock/images/right_top.gif" width="168" height="21" /></td>

        </tr>

      </table>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td width="171" align="center" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_clock/images/left_bck.gif"> 
            <?php mosLoadModules ( 'left' ); ?>
            <?php mosLoadModules ( 'user1' ); ?>
          </td>

          <td valign="top" class="content">

            <?php include_once ("mainbody.php"); ?>

          </td>

          <td width="168" align="center" valign="top" background="<?php echo $mosConfig_live_site;?>/templates/allm_clock/images/right_bck.gif"> 
            <?php mosLoadModules ( 'right' ); ?>
            <?php mosLoadModules ( 'user2' ); ?>
          </td>

        </tr>

      </table>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td width="171"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_clock/images/left_footer.gif" width="171" height="26" /></td>

          <td background="<?php echo $mosConfig_live_site;?>/templates/allm_clock/images/mid_footer.gif">&copy; 

            2004 allmambo.com</td>

          <td width="168"><a href="http://www.allmambo.com" target="_blank"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_clock/images/right_footer.gif" width="168" height="26" border="0" /></a></td>

        </tr>

      </table>

    </td>

  </tr>

</table>

</body>

</html>

