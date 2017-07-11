<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?$site_config.site_name?></title>
<link href="<?$MY_THEME_PATH?>css/index.css" type=text/css rel=stylesheet>
<?if $MY_MODULE_NAME?>
<link href="<?$MY_THEME_PATH?>css/module_<?$MY_MODULE_NAME?>.css" type=text/css rel=stylesheet>
<?/if?>
<link rel="shortcut icon" href="<?$MY_THEME_PATH?>image/favicon.ico" />
<script type="text/javascript" src="<?$MY_THEME_PATH?>js/jquery.min.js"></script>
<script type="text/javascript"  src="<?$MY_THEME_PATH?>js/jquery-ui.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body bgcolor="#e1d7ee" bgcolor="#f8f5f0">
<table width="770" border="0" align="center" cellpadding="0" cellspacing="0"  background="<?$MY_THEME_PATH?>images/page_bg_purple_radius.png">
  <?if $smarty.const.MY_HOME_REQUEST===$MY_REQUEST_TYPE?>
  <tr>
    <td>
      <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="90" background="<?$MY_THEME_PATH?>images/clothes_r1_c1.jpg">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
  <?/if?>
  <tr>
    <td><table width="750" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F8F5F0">
      <tr>
        <td><img  src="<?$MY_THEME_PATH?>images/clothes_r2_c1.jpg" width="285" height="73" border="0" /></td>
        <td><img  src="<?$MY_THEME_PATH?>images/clothes_r2_c7.jpg" width="51" height="73" border="0" /></td>
        <td><table align="left" border="0" cellpadding="0" cellspacing="0" width="414">
            <tr>
              <td height="46">&nbsp;</td>
            </tr>
            <tr>
              <td><table align="left" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="11"><img  src="<?$MY_THEME_PATH?>images/clothes_r3_c9.jpg" width="11" height="27" border="0" /></td>
                    <td background="<?$MY_THEME_PATH?>images/clothes_r3_c10.jpg">
                <?if $head_menu?>
                <div id="head_menu">
                    <?if is_array($head_menu)===true?>
                        <?foreach key=key item=item from=$head_menu?>
                            <div id="head_menu_<?$key?>">
                            <?$item?>
                            </div>
                        <?/foreach?>
                    <?elseif is_string($head_menu)?>
                        <?$head_menu?>
                    <?/if?>
                </div>
                <?/if?>
                    </td>
                    <td width="15"><img  src="<?$MY_THEME_PATH?>images/clothes_r3_c14.jpg" width="15" height="27" border="0" /></td>
                    </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>      <table width="750" border="0" align="center" cellpadding="0" cellspacing="0" background="<?$MY_THEME_PATH?>images/clothes_r4_c1.jpg">
        <tr>
          <td height="40">&nbsp;</td>
        </tr>
            </table></td></tr>

<?if !$my_main && ($right_block || $left_block)?>
  <tr>
    <td><table width="750" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8f5f0">
        <tr>
          <td width="260" height="160" valign="top">
            <div id="fortune_cloud"><img  src="<?$MY_THEME_PATH?>images/fortune_cloud.png" width="345" height="276" border="0" /></div>
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
                <?if $left_block?>
                <div id="left_block">
                    <?if is_array($left_block)===true?>
                        <?foreach key=key item=item from=$left_block?>
                            <div id="left_block_<?$key?>">
                            <?$item?>
                            </div>
                        <?/foreach?>
                    <?elseif is_string($left_block)?>
                        <?$left_block?>
                    <?/if?>
                </div>
                <?/if?>
               </td>
             </tr>
           </table>
          </td>
          <td width="158"><div id="fortune_cloud"><img src="<?$MY_THEME_PATH?>images/bloom.png"  width="165" height="240" border="0"/></div></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="750" border="0" align="center" cellpadding="0" cellspacing="0" background="<?$MY_THEME_PATH?>images/clothes_r6_c7.jpg">
      <tr>
        <td><img  src="<?$MY_THEME_PATH?>images/clothes_r6_c1.jpg" width="110" height="273" border="0" /></td>
        <td width="113" bgcolor="#F8F5F0">&nbsp;</td>
        <td><img  src="<?$MY_THEME_PATH?>images/clothes_r6_c5.jpg" width="62" height="273" border="0" /></td>
        <td width="307">
            <div class="companyWish">
               公司追求信仰<br>各种描述信息介绍
            </div>
          <?if $right_block?>
            <div id="left_block">
                <?if is_array($right_block)===true?>
                    <?foreach key=key item=item from=$right_block?>
                        <div id="left_block_<?$key?>">
                        <?$item?>
                        </div>
                    <?/foreach?>
                <?elseif is_string($right_block)?>
                    <?$right_block?>
                <?/if?>
            </div>
            <?/if?>
         </td>
        <td width="7" background="<?$MY_THEME_PATH?>images/clothes_r6_c11.jpg">&nbsp;</td>
        <td width="151" background="<?$MY_THEME_PATH?>images/clothes_r6_c12.jpg">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
<?/if?>

<?if $my_main?>
  <tr>
   <td><table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
       <tr>
         <td height="209" align="left" valign="top" background="<?$MY_THEME_PATH?>images/clothes_content_r3_c1.jpg"><div id="fortune_cloud_banner"></div></td>
       </tr>
     </table></td>
  </tr>
  <tr>
   <td><div align="center"><img name="clothes_content_r4_c1" src="<?$MY_THEME_PATH?>images/clothes_content_r4_c1.jpg" width="750" height="8" border="0" id="clothes_content_r4_c1" alt="" /></div></td>
  </tr>
  <tr>
   <td>
     <table width="750" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F8F5F0">
       <tr>
         <td width="15"></td>
         <td width="220" valign="top" background="<?$MY_THEME_PATH?>images/clothes_content_r5_c3.jpg" bgcolor="#F0F0F0" class="newsList"><p class="newsListTitle">新闻列表 / News <i>more&gt;&gt;</i> </p>
            <?if $left_block?>
            <div id="left_block">
                <?if is_array($left_block)===true?>
                    <?foreach key=key item=item from=$left_block?>
                        <div id="left_block_<?$key?>">
                        <?$item?>
                        </div>
                    <?/foreach?>
                <?elseif is_string($left_block)?>
                    <?$left_block?>
                <?/if?>
            </div>
            <?/if?>

         </td>
         <td valign="top">
          <?if $my_main?>
            <div id="my_main_content">
            <?$my_main.my_main_content?>
            </div>
          <?/if?>
         </td>
       </tr>
     </table></td>
  </tr>
<?/if?>
  <tr>
    <td><table width="750" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8f5f0">
      <tr>
        <td><table align="left" border="0" cellpadding="0" cellspacing="0" width="152">
            <tr>
              <td><img  src="<?$MY_THEME_PATH?>images/clothes_r7_c1.jpg" width="152" height="106" border="0" /></td>
            </tr>
            <tr>
              <td><table align="left" border="0" cellpadding="0" cellspacing="0" width="152">
                  <tr>
                    <td><img  src="<?$MY_THEME_PATH?>images/clothes_r9_c1.jpg" width="8" height="23" border="0" /></td>
                    <td><img  src="<?$MY_THEME_PATH?>images/clothes_r9_c2.jpg" width="144" height="23" border="0" /></td>
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
                    <td><img  src="<?$MY_THEME_PATH?>images/clothes_r8_c4.jpg" width="71" height="45" border="0" /></td>
                    <td><img  src="<?$MY_THEME_PATH?>images/clothes_r8_c5.jpg" width="11" height="45" border="0" /></td>
                    <td background="<?$MY_THEME_PATH?>images/clothes_r8_c6.jpg" width="516" height="45"><br/>版权所有  &copy; 新雨紫归缘制衣厂Copyright Reserved 2010</td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" class="pageFoot">
        <?if isset($page_foot)?>
            <div id="page_foot">
                <?if is_array($page_foot)===true?>
                    <?foreach key=key item=item from=$page_foot?>
                        <div id="page_foot_<?$key?>">
                        <?$item?>
                        </div>
                    <?/foreach?>
                <?elseif is_string($page_foot)?>
                    <?$page_foot?>
                <?/if?>
            </div>
        <?/if?>
        <a href="http://www.kinful.com" target="blank">技术支持：金福科技</a>
    </td>
  </tr>
</table>
</body>
</html>
