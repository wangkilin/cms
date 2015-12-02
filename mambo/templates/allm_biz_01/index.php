<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>

<?php defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title><?php echo $mosConfig_sitename; ?></title>

<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />

<?php include ("includes/metadata.php"); // include keywords, and such
	  include ("templates/allm_biz_01/menu_roll.php");  // include menu JS script


if ($my->id) {

	include ("editor/editor.php");

	initEditor();

}

?>

<link href="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/css/template_css.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="766" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="21" background="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/top_left_bck.gif">&nbsp;</td>
    <td width="268"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/logo.gif" width="268" height="70" /></td>
    <td valign="bottom" bgcolor="#E7EAF3"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/right_mid.gif" width="477" height="45" /></td>
  </tr>
</table>

<table width="766" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="21" background="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/top_left_bck.gif">&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="91" background="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/menu/menu_1.gif"><a href="index.php?option=com_frontpage" onMouseOver="JSFX.fadeIn('menu_1')" onMouseOut="JSFX.fadeOut('menu_1')"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/menu/menu_1.gif" name="menu_1" width="91" height="123" border="0" class="imgFader" /></a></td>
          <td width="89" background="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/menu/menu_2.gif"><a href="index.php?option=content&task=section&id=1&Itemid=2" onMouseOver="JSFX.fadeIn('menu_2')" onMouseOut="JSFX.fadeOut('menu_2')"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/menu/menu_2.gif" name="menu_2" width="89" height="123" border="0" class="imgFader" /></a></td>
          <td width="88" background="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/menu/menu_3.gif"><a href="index.php?option=content&task=section&id=2&Itemid=25" onMouseOver="JSFX.fadeIn('menu_3')" onMouseOut="JSFX.fadeOut('menu_3')"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/menu/menu_3.gif" name="menu_3" width="88" height="123" border="0" class="imgFader" /></a></td>
          <td width="90" background="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/menu/menu_4.gif"><a href="index.php?option=com_contact" onMouseOver="JSFX.fadeIn('menu_4')" onMouseOut="JSFX.fadeOut('menu_4')"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/menu/menu_4.gif" name="menu_4" width="90" height="123" border="0" class="imgFader" /></a></td>
        </tr>
      </table></td>
    <td width="387"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/menu_right.gif" width="387" height="123" /></td>
  </tr>
  <tr> 
    <td colspan="3"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/header_bott.gif" width="766" height="19" /></td>
  </tr>
</table>
<table width="766" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td width="21" background="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/left_bck.gif"><img src="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/left_img.gif" width="21" height="265" /></td>
    <td width="180" align="center" background="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/left_mod_bck.gif"> 
      <?php mosLoadModules ( 'left' ); ?>
      <?php mosLoadModules ( 'user1' ); ?>
    </td>
    <td width="178" align="center" background="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/right_mod_bck.gif"> 
      <?php mosLoadModules ( 'right' ); ?>
      <?php mosLoadModules ( 'user2' ); ?>
    </td>
    <td bgcolor="#E7EAF3">
      <?php include_once ("mainbody.php"); ?>
    </td>
    <td width="21" background="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/right_bck.gif">&nbsp;</td>
  </tr>
</table>
<table width="766" border="0" align="center" cellpadding="0" cellspacing="0" background="<?php echo $mosConfig_live_site;?>/templates/allm_biz_01/images/footer_bck.gif">
  <tr>
    <td height="51">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>