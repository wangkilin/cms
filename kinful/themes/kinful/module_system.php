<?if isset($RENDER_TYPE)?>
<?if 'flash_mp3'==$RENDER_TYPE?>
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
<?elseif 'themeListTheme'==$RENDER_TYPE?>
<p class="blockTitle">
  <?$lang.please_choose_theme?>
</p>
<p id="thumbnailContainer">
  <?foreach item=themeInfo from=$themeList?>
  <img class="thumbnail" id="thumbnail_<?$themeInfo.theme_id?>" src="<?$themeInfo.thumbnail?>"/>
  <?/foreach?>
</p>
<form action="<?$smarty.const.MY_ROOT_URL?>index.php?yemodule=system&type=theme" method="post">
<select id="themeThumbnail" name="themeId">
  <?foreach item=themeInfo from=$themeList?>
  <option <?if $defaultThemeId==$themeInfo.theme_id?>selected="selected" <?/if?>value="<?$themeInfo.theme_id?>"><?$themeInfo.theme_name?></option>
  <?/foreach?>
</select>
<input type="hidden" name="action" value="change"/>
<input type="submit" value="<?$lang.choose?>"/>
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
<?/if?>

<?else?>
<a href="<?$smarty.const.MY_ROOT_URL?>"><img src="kinful/web/images/logo_5.png" title="Logo" border="0"></a>
<?/if?>