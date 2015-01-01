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

<link href="<?php echo $mosConfig_live_site;?>/templates/allm_digitaldream/css/template_css.css" rel="stylesheet" type="text/css" />





<style>

.border

{

	background-color: #ffffff;

	border-color: ;

	border-left: 1px solid #000000;

	border-right: 1px solid #000000;





</style>

</head>

<body topmargin=0 bottommargin=0><div align="center">

<table border="0" cellpadding="0" cellspacing="0" width="700" class="border">

  <tr>

    <td>

    <table border="0" cellpadding="0" cellspacing="0" width="700">

      <tr>

            <td background="<?php echo $mosConfig_live_site;?>/templates/allm_digitaldream/images/topleft.gif" WIDTH=266 HEIGHT=35><?php echo (strftime (_DATE_FORMAT_LC, time()+($mosConfig_offset*60*60))); ?></td>

        <td><A HREF="index.htm">

				<IMG SRC="<?php echo $mosConfig_live_site;?>/templates/allm_digitaldream/images/home.gif" WIDTH=95 HEIGHT=35 BORDER=0 ALT=""></A></td>

            <td><A HREF="<?php echo $mosConfig_live_site;?>/index.php/component/option,com_newsfeeds"> 

              <IMG SRC="<?php echo $mosConfig_live_site;?>/templates/allm_digitaldream/images/news.gif" WIDTH=128 HEIGHT=35 BORDER=0 ALT=""></A></td>

            <td><A HREF="<?php echo $mosConfig_live_site;?>/index.php/component/option,com_links"> 

              <IMG SRC="<?php echo $mosConfig_live_site;?>/templates/allm_digitaldream/images/links.gif" WIDTH=122 HEIGHT=35 BORDER=0 ALT=""></A></td>

            <td><A HREF="<?php echo $mosConfig_live_site;?>/index.php/component/option,com_contact"> 

              <IMG SRC="<?php echo $mosConfig_live_site;?>/templates/allm_digitaldream/images/contact.gif" WIDTH=89 HEIGHT=35 BORDER=0 ALT=""></A></td>

      </tr>

    </table>

    </td>

  </tr>

  <tr>

    <td><IMG SRC="<?php echo $mosConfig_live_site;?>/templates/allm_digitaldream/images/header.gif" WIDTH=700 HEIGHT=129 ALT=""></td>

  </tr>

  <tr>

      <td><!--DWLayoutEmptyCell-->&nbsp;</td>

  </tr>

  <tr>

    <td valign="top">

    <table border="0" cellpadding="0" cellspacing="0" width="700">

          <!--DWLayoutTable-->

          <tr> 

            <td width="186" height="394" valign="top"> <table border="0" cellpadding="0" cellspacing="0" width="186">

                <!--DWLayoutTable-->

                <tr> 

                  <td WIDTH=186 HEIGHT=343 valign="top" BACKGROUND="<?php echo $mosConfig_live_site;?>/templates/allm_digitaldream/images/newstxt.gif" style="padding:5px;"> 

                    <?php mosLoadModules ( 'left' ); ?>

                    <?php mosLoadModules ( 'user1' ); ?>

                    <BR> </td>

                </tr>

                <tr> 

                  <td><!--DWLayoutEmptyCell-->&nbsp;</td>

                </tr>

                <tr> 

                  <td><IMG SRC="<?php echo $mosConfig_live_site;?>/templates/allm_digitaldream/images/index_24.gif" WIDTH=186 HEIGHT=32 ALT=""></td>

                </tr>

              </table></td>

            <td rowspan="2" valign="top"> <table border="0" cellpadding="0" cellspacing="0" width="514">

                <!--DWLayoutTable-->

                <tr> 

                  <td width="514" height="1" valign="top"> <table border="0" cellpadding="0" cellspacing="0" width="514">

                      <!--DWLayoutTable-->

                      <tr> 

                        <td WIDTH=514 HEIGHT=1></td>

                      </tr>

                    </table></td>

                </tr>

                <tr> 

                  <td height="8" valign="top"><IMG SRC="<?php echo $mosConfig_live_site;?>/templates/allm_digitaldream/images/yellowbar.gif" WIDTH=514 HEIGHT=8 ALT=""></td>

                </tr>

                <tr> 



                    <p><b><font color="#DF0100" face="Verdana" size="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 

                      <?php include_once ("mainbody.php"); ?>

                      </font></b></p>

                    <p>&nbsp;</p>

                    <p>&nbsp; </p>

                    <p>&nbsp;</p>

                    <p>&nbsp;</p>

                    <p>&nbsp;</p>

                    <p align="center"><span class="pathway"> 

                      <?php include "pathway.php"; ?>

                      </span></p>

                    <form action='<?php echo sefRelToAbs("index.php"); ?>' method='post'>

                      <div align="center">

                        <input class="inputbox" type="text" name="searchword" size="18" value="<?php echo _SEARCH_BOX; ?>"  onblur="if(this.value=='') this.value='<?php echo _SEARCH_BOX; ?>';" onfocus="if(this.value=='<?php echo _SEARCH_BOX; ?>') this.value='';" />

                        <input type="submit" name="option" class="button" value="Go!" />

                        <input type="hidden" name="option" value="search" />

                      </div>

                    </form>

                    <p align="center"><span class="pathway"> 

                    <div align="center"><span class="pathway"> </span> </div>

                    </span><BR>

                    </p></td>

                </tr>

              </table></td>

          </tr>

          <tr> 

            <td height="59">&nbsp;</td>

          </tr>

        </table>

    </td>

  </tr>

  <tr>

      <td background="<?php echo $mosConfig_live_site;?>/templates/allm_digitaldream/images/footer.gif" WIDTH=700 HEIGHT=39 align="center" style="padding-top:10px;"><strong><font color="#FFFFFF" size="1" face="Verdana, Arial, Helvetica, sans-serif">Designed 

        by <a href="http://www.allmambo.com">Allmambo.com</a></font></strong></td>

  </tr>

</table>

</div>

</body>

</html>