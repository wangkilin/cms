<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<?php defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $mosConfig_sitename; ?></title>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<?php include ("includes/metadata.php"); // include keywords, and such

if ($my->id) {
	include ("editor/editor.php");
	initEditor();
}
?>
<link href="<?php echo $mosConfig_live_site;?>/templates/my_template/css/template_css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="151"><img src="<?php echo $mosConfig_live_site;?>/templates/my_template/images/top_left.gif" width="151" height="180" /></td>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="297"><img src="<?php echo $mosConfig_live_site;?>/templates/my_template/images/logo.gif" width="297" height="158" /></td>
          <td background="<?php echo $mosConfig_live_site;?>/templates/my_template/images/top_var.gif">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="76"><img src="<?php echo $mosConfig_live_site;?>/templates/my_template/images/path_left.gif" width="76" height="22" /></td>
          <td background="<?php echo $mosConfig_live_site;?>/templates/my_template/images/path_var.gif" class="pathway">
            <span style="pathway"><?php include "pathway.php"; ?></span>
          </td>
          <td width="151"><img src="<?php echo $mosConfig_live_site;?>/templates/my_template/images/path_right.gif" width="151" height="22" /></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="100">
  <tr align="center" valign="top"> 
    <td width="151" background="<?php echo $mosConfig_live_site;?>/templates/my_template/images/left_bck.gif"> 
      <?php mosLoadModules ( 'left' ); ?>
      <?php mosLoadModules ( 'user1' ); ?>
    </td>
    <td class="content"><table width="98%" border="0" cellspacing="0" cellpadding="0" class="content">
        <tr>
          <td valign="top"> 
            <?php include_once ("mainbody.php"); ?>
          </td>
        </tr>
      </table></td>
    <td width="151" background="<?php echo $mosConfig_live_site;?>/templates/my_template/images/right_bck.gif"> 
      <?php mosLoadModules ( 'right' ); ?>
      <?php mosLoadModules ( 'user2' ); ?>
    </td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="151"><a href="http://mamboserver.com" target="_blank"><img src="<?php echo $mosConfig_live_site;?>/templates/my_template/images/powered_by.gif" alt="MOS" width="151" height="31" border="0" /></a></td>
    <td background="<?php echo $mosConfig_live_site;?>/templates/my_template/images/footer_bck.gif">&nbsp;</td>
    <td width="165"><a href="http://allmambo.com" target="_blank"><img src="<?php echo $mosConfig_live_site;?>/templates/my_template/images/designed_by.gif" alt="allmambo.com" width="165" height="31" border="0" /></a></td>
  </tr>
</table>
</body>
</html>