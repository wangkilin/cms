<?php /* Smarty version 2.6.6, created on 2010-09-26 12:53:30
         compiled from index.php */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->_tpl_vars['site_config']['site_name']; ?>
</title>
<link href="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
css/index.css" type=text/css rel=stylesheet>
<?php if ($this->_tpl_vars['MY_MODULE_NAME']): ?>
<link href="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
css/module_<?php echo $this->_tpl_vars['MY_MODULE_NAME']; ?>
.css" type=text/css rel=stylesheet>
<?php endif; ?>
<link rel="shortcut icon" href="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
image/favicon.ico" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
js/jquery.min.js"></script>
<script type="text/javascript"  src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
js/jquery-ui.min.js"></script>
<script language="javascript">
var startX = 0
   ,startY = 0
   ,objWidth = 0
   ,objHeight = 0
   ,background;

function moveBackground()
{
    startX = startX > objWidth ? 0 : (startX+2);
    startY = startY > objHeight ? 0 : (startY+0.5);
    background = startX + 'px ' + startY + 'px';
    jQuery('#fortune_cloud_banner').css('background-position', background);
    setTimeout('moveBackground()', 300);
}
(function($){
    $(document).ready(function(){
        objWidth = $('#fortune_cloud_banner').width();
        objHeight = $('#fortune_cloud_banner').height();
        moveBackground();
    });
})(jQuery);
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body bgcolor="#e1d7ee" bgcolor="#f8f5f0">
<table width="770" border="0" align="center" cellpadding="0" cellspacing="0"  background="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/page_bg_purple_radius.png">
  <?php if (@constant('MY_HOME_REQUEST') === $this->_tpl_vars['MY_REQUEST_TYPE']): ?>
  <tr>
    <td>
      <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td id="fortune_cloud_banner" style="height:90px;width:750px;background-image:url(<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r1_c1.jpg)">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
  <?php endif; ?>
  <tr>
    <td><table width="750" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F8F5F0">
      <tr>
        <td><img  src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r2_c1.jpg" width="285" height="73" border="0" /></td>
        <td><img  src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r2_c7.jpg" width="51" height="73" border="0" /></td>
        <td><table align="left" border="0" cellpadding="0" cellspacing="0" width="414">
            <tr>
              <td height="46">&nbsp;</td>
            </tr>
            <tr>
              <td><table align="left" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="11"><img  src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r3_c9.jpg" width="11" height="27" border="0" /></td>
                    <td background="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r3_c10.jpg">
                <?php if ($this->_tpl_vars['head_menu']): ?>
                <div id="head_menu">
                    <?php if (is_array ( $this->_tpl_vars['head_menu'] ) === true): ?>
                        <?php if (count($_from = (array)$this->_tpl_vars['head_menu'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                            <div id="head_menu_<?php echo $this->_tpl_vars['key']; ?>
">
                            <?php echo $this->_tpl_vars['item']; ?>

                            </div>
                        <?php endforeach; unset($_from); endif; ?>
                    <?php elseif (is_string ( $this->_tpl_vars['head_menu'] )): ?>
                        <?php echo $this->_tpl_vars['head_menu']; ?>

                    <?php endif; ?>
                </div>
                <?php endif; ?>
                    </td>
                    <td width="15"><img  src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r3_c14.jpg" width="15" height="27" border="0" /></td>
                    </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>      <table width="750" border="0" align="center" cellpadding="0" cellspacing="0" background="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r4_c1.jpg">
        <tr>
          <td height="40">&nbsp;</td>
        </tr>
            </table></td></tr>

<?php if (! $this->_tpl_vars['my_main'] && ( $this->_tpl_vars['right_block'] || $this->_tpl_vars['left_block'] )): ?>
  <tr>
    <td><table width="750" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8f5f0">
        <tr>
          <td width="260" height="160" valign="top">
            <div id="fortune_cloud"><img  src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/fortune_cloud.png" width="345" height="276" border="0" /></div>
          </td>
          <td valign="top"><table width="100%" height="14" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="8" bgcolor="#D1D0CB"></td>
              <td width="1" bgcolor="#FFFFFF"></td>
              <td width="120" bgcolor="#965BD9"><div align="center"><span style="color:#ffffff">新闻动态</span></div></td>
              <td width="1" bgcolor="#FFFFFF"></td>
              <td width="8" bgcolor="#D1D0CB"></td>
              <td align="center"><a href="?yemodule=news" style="color:#965BD9;font-size:10px;font-weight:bold;">more&gt;&gt;</a></td>
              <td>&nbsp;</td>
            </tr>
          </table>
          <table class="newsList latestNewsList">
            <tr>
              <td>
                <?php if ($this->_tpl_vars['left_block']): ?>
                <div id="left_block">
                    <?php if (is_array ( $this->_tpl_vars['left_block'] ) === true): ?>
                        <?php if (count($_from = (array)$this->_tpl_vars['left_block'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                            <div id="left_block_<?php echo $this->_tpl_vars['key']; ?>
">
                            <?php echo $this->_tpl_vars['item']; ?>

                            </div>
                        <?php endforeach; unset($_from); endif; ?>
                    <?php elseif (is_string ( $this->_tpl_vars['left_block'] )): ?>
                        <?php echo $this->_tpl_vars['left_block']; ?>

                    <?php endif; ?>
                </div>
                <?php endif; ?>
               </td>
             </tr>
           </table>
          </td>
          <td width="158"><div id="fortune_cloud"><img src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/bloom.png"  width="165" height="240" border="0"/></div></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="750" border="0" align="center" cellpadding="0" cellspacing="0" background="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r6_c7.jpg">
      <tr>
        <td><img  src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r6_c1.jpg" width="110" height="273" border="0" /></td>
        <td width="113" bgcolor="#F8F5F0">&nbsp;</td>
        <td><img  src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r6_c5.jpg" width="62" height="273" border="0" /></td>
        <td width="307">
            <div class="companyWish">
               公司追求信仰<br>各种描述信息介绍
            </div>
          <?php if ($this->_tpl_vars['right_block']): ?>
            <div id="left_block">
                <?php if (is_array ( $this->_tpl_vars['right_block'] ) === true): ?>
                    <?php if (count($_from = (array)$this->_tpl_vars['right_block'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                        <div id="left_block_<?php echo $this->_tpl_vars['key']; ?>
">
                        <?php echo $this->_tpl_vars['item']; ?>

                        </div>
                    <?php endforeach; unset($_from); endif; ?>
                <?php elseif (is_string ( $this->_tpl_vars['right_block'] )): ?>
                    <?php echo $this->_tpl_vars['right_block']; ?>

                <?php endif; ?>
            </div>
            <?php endif; ?>
         </td>
        <td width="7" background="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r6_c11.jpg">&nbsp;</td>
        <td width="151" background="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r6_c12.jpg">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
<?php endif; ?>

<?php if ($this->_tpl_vars['my_main']): ?>
  <tr>
   <td><table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
       <tr>
         <td height="209" align="left" valign="top" background="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_content_r3_c1.jpg">
           <div id="fortune_cloud_banner" style="position:absolute;height:204px;width:750px;"></div>
         </td>
       </tr>
     </table></td>
  </tr>
  <tr>
   <td><div align="center"><img name="clothes_content_r4_c1" src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_content_r4_c1.jpg" width="750" height="8" border="0" id="clothes_content_r4_c1" alt="" /></div></td>
  </tr>
  <tr>
   <td>
     <table width="750" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F8F5F0">
       <tr>
         <td width="15"></td>
         <td width="220" valign="top" background="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_content_r5_c3.jpg" bgcolor="#F0F0F0" class="newsList"><p class="newsListTitle">新闻列表 / News <i>more&gt;&gt;</i> </p>
            <?php if ($this->_tpl_vars['left_block']): ?>
            <div id="left_block">
                <?php if (is_array ( $this->_tpl_vars['left_block'] ) === true): ?>
                    <?php if (count($_from = (array)$this->_tpl_vars['left_block'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                        <div id="left_block_<?php echo $this->_tpl_vars['key']; ?>
">
                        <?php echo $this->_tpl_vars['item']; ?>

                        </div>
                    <?php endforeach; unset($_from); endif; ?>
                <?php elseif (is_string ( $this->_tpl_vars['left_block'] )): ?>
                    <?php echo $this->_tpl_vars['left_block']; ?>

                <?php endif; ?>
            </div>
            <?php endif; ?>

         </td>
         <td valign="top">
          <?php if ($this->_tpl_vars['my_main']): ?>
            <div id="my_main_content">
            <?php echo $this->_tpl_vars['my_main']['my_main_content']; ?>

            </div>
          <?php endif; ?>
         </td>
       </tr>
     </table></td>
  </tr>
<?php endif; ?>
  <tr>
    <td><table width="750" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8f5f0">
      <tr>
        <td><table align="left" border="0" cellpadding="0" cellspacing="0" width="152">
            <tr>
              <td><img  src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r7_c1.jpg" width="152" height="106" border="0" /></td>
            </tr>
            <tr>
              <td><table align="left" border="0" cellpadding="0" cellspacing="0" width="152">
                  <tr>
                    <td><img  src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r9_c1.jpg" width="8" height="23" border="0" /></td>
                    <td><img  src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r9_c2.jpg" width="144" height="23" border="0" /></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
        <td><table align="left" border="0" cellpadding="0" cellspacing="0" width="598">
            <tr>
              <td height="84">&nbsp;</td>
            </tr>
            <tr>
              <td><table align="left" border="0" cellpadding="0" cellspacing="0" width="598">
                  <tr>
                    <td><img  src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r8_c4.jpg" width="71" height="45" border="0" /></td>
                    <td><img  src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r8_c5.jpg" width="11" height="45" border="0" /></td>
                    <td background="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/clothes_r8_c6.jpg" width="516" height="45"><br/>版权所有  &copy; 新雨紫归缘制衣厂Copyright Reserved 2010</td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" class="pageFoot">
        <?php if (isset ( $this->_tpl_vars['page_foot'] )): ?>
            <div id="page_foot">
                <?php if (is_array ( $this->_tpl_vars['page_foot'] ) === true): ?>
                    <?php if (count($_from = (array)$this->_tpl_vars['page_foot'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                        <div id="page_foot_<?php echo $this->_tpl_vars['key']; ?>
">
                        <?php echo $this->_tpl_vars['item']; ?>

                        </div>
                    <?php endforeach; unset($_from); endif; ?>
                <?php elseif (is_string ( $this->_tpl_vars['page_foot'] )): ?>
                    <?php echo $this->_tpl_vars['page_foot']; ?>

                <?php endif; ?>
            </div>
        <?php endif; ?>
        <a href="http://www.kinful.com" target="blank">技术支持：金福科技</a>
    </td>
  </tr>
</table>
</body>
</html>