
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo delete_confirm"><?$lang.delete_confirm_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?$lang.delete_confirm_tab_title?></p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?$lang.delete_confirm_description?>
          </p>
          <div class="admin_main_content">
              <p>
              <?foreach item=item key=key from=$descItems?>
              <?$key?> : <font class="high_light_blue"><?$item?></font> <br>
              <?/foreach?>
              </p>
              <p id="form_delete_confirm">
                  <a  class="form_action_delete" href="#" action="delete"><?$lang.delete?></a>
              </p>
              <input type="hidden" name="form_action" value="delete">
              <input type="hidden" name="form_delete_confirm" value="yes">
              <?foreach item=item key=key from=$hiddenItems?>
              <input type="hidden" name="<?$key?>" value="<?$item?>">
              <?/foreach?>
          </div>
      </div>
    </form>

<script language="JavaScript">
<!--
(function($) {

    // delete button
    $('#form_delete_confirm .form_action_delete').live('click', function(){
        $('form[id="admin_main_content"]').submit();
    });

})(jQuery);
//-->
</script>