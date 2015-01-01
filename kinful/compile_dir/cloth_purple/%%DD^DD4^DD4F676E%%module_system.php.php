<?php /* Smarty version 2.6.6, created on 2010-09-26 12:53:30
         compiled from module_system.php */ ?>
<?php if (isset ( $this->_tpl_vars['RENDER_TYPE'] )):  if ('flash_mp3' == $this->_tpl_vars['RENDER_TYPE']): ?>
<p id="flash_mp3">&nbsp;</p>
<script src="./themes/kinful/js/jquery-swfobject.js"></script>
<script src="./themes/kinful/js/1pixelout-player.js"></script>
<script language="javascript">
// Initialized AudioPlayer instance
AudioPlayer.setup('./themes/kinful/js/1pixelout-player.swf?ver=2.0.4.1', {
    width: '80',
    height:'16',
    bg: 'EEFFCC',
    text: '333333',
    leftbg: '965bd9',
    lefticon: 'FFFFFF',
    volslider: 'FFFFFF',
    voltrack: 'A5D416',
    rightbg: '965bd9',
    rightbghover: '995bd9',
    righticon: 'FFFFFF',
    righticonhover: 'FFFFFF',
    track: 'EEFFCC',
    loader: 'D3E718',
    border: 'BDE126',
    tracker: 'D3E718',
    skip: '666666',
    pagebg: 'FFFFFF',
    transparentpagebg: 'yes',
    autostart: 'yes'
});
AudioPlayer.embed("flash_mp3", {soundFile: './themes/kinful/js/music.mp3'});
</script>
<?php elseif ('themeListTheme' == $this->_tpl_vars['RENDER_TYPE']): ?>
<p class="blockTitle">
  <?php echo $this->_tpl_vars['lang']['please_choose_theme']; ?>

</p>
<p id="thumbnailContainer">
  <?php if (count($_from = (array)$this->_tpl_vars['themeList'])):
    foreach ($_from as $this->_tpl_vars['themeInfo']):
?>
  <img class="thumbnail" id="thumbnail_<?php echo $this->_tpl_vars['themeInfo']['theme_id']; ?>
" src="<?php echo $this->_tpl_vars['themeInfo']['thumbnail']; ?>
"/>
  <?php endforeach; unset($_from); endif; ?>
</p>
<form action="<?php echo @constant('MY_ROOT_URL'); ?>
index.php?yemodule=system&type=theme" method="post">
<select id="themeThumbnail" name="themeId">
  <?php if (count($_from = (array)$this->_tpl_vars['themeList'])):
    foreach ($_from as $this->_tpl_vars['themeInfo']):
?>
  <option <?php if ($this->_tpl_vars['defaultThemeId'] == $this->_tpl_vars['themeInfo']['theme_id']): ?>selected="selected" <?php endif; ?>value="<?php echo $this->_tpl_vars['themeInfo']['theme_id']; ?>
"><?php echo $this->_tpl_vars['themeInfo']['theme_name']; ?>
</option>
  <?php endforeach; unset($_from); endif; ?>
</select>
<input type="hidden" name="action" value="change"/>
<input type="submit" value="<?php echo $this->_tpl_vars['lang']['choose']; ?>
"/>
</form>
<script language="javascript">
;(function($) {
    $('#themeThumbnail').change(function() {
        $('img.thumbnail').hide();
        $('#thumbnail_' + $(this).val()).show();
    });
    $('#themeThumbnail').trigger('change');
})(jQuery);
</script>
<?php endif; ?>

<?php else: ?>
<a href="<?php echo @constant('MY_ROOT_URL'); ?>
"><img src="kinful/web/images/logo_5.png" title="Logo" border="0"></a>
<?php endif; ?>