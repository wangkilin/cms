<?if $action?>
 <div id="form_action" class="form_action">
 <?foreach item=act from=$action?>
    <?if $act=='new'?>
      <a action="<?$act?>" href="#<?if $pre_action && $pre_action.new?><?$pre_action.new?><?/if?>" class="form_action_new submitable"><?$lang.new?></a>
    <?elseif $act=='edit'?>
      <a action="<?$act?>" href="#<?if $pre_action && $pre_action.edit?><?$pre_action.edit?><?/if?>"  class="form_action_edit selectOne"<?if $warning && $warning.edit?> warning="<?$warning.edit?>"<?/if?> ><?$lang.edit?></a>
    <?elseif $act=='save'?>
      <a action="<?$act?>" href="#<?if $pre_action && $pre_action.save?><?$pre_action.save?><?/if?>"  class="form_action_save submitable"><?$lang.save?></a>
    <?elseif $act=='create'?>
      <a action="create" href="#<?if $pre_action && $pre_action.save?><?$pre_action.save?><?/if?>"  class="form_action_save submitable"><?$lang.save?></a>
    <?elseif $act=='copy'?>
      <a action="<?$act?>" href="#<?if $pre_action && $pre_action.copy?><?$pre_action.copy?><?/if?>"  class="form_action_copy selectOne"<?if $warning && $warning.copy?> warning="<?$warning.copy?>"<?/if?> ><?$lang.copy?></a>
    <?elseif $act=='publish'?>
      <a action="<?$act?>" href="#<?if $pre_action && $pre_action.publish?><?$pre_action.publish?><?/if?>"  class="form_action_publish selectOne"<?if $warning && $warning.publish?> warning="<?$warning.publish?>"<?/if?> ><?$lang.publish?></a>
    <?elseif $act=='unpublish'?>
      <a action="<?$act?>" href="#<?if $pre_action && $pre_action.unpublish?><?$pre_action.unpublish?><?/if?>"  class="form_action_unpublish selectOne"<?if $warning && $warning.unpublish?> warning="<?$warning.unpublish?>"<?/if?> ><?$lang.unpublish?></a>
    <?elseif $act=='move'?>
      <a action="<?$act?>" href="#<?if $pre_action && $pre_action.move?><?$pre_action.move?><?/if?>"  class="form_action_move selectOne"<?if $warning && $warning.move?> warning="<?$warning.move?>"<?/if?> ><?$lang.move?></a>
    <?elseif $act=='delete'?>
      <a action="<?$act?>" href="#<?if $pre_action && $pre_action.delete?><?$pre_action.delete?><?/if?>"  class="form_action_delete selectOne"<?if $warning && $warning.delete?> warning="<?$warning.delete?>"<?/if?> ><?$lang.delete?></a>
    <?elseif $act=='help'?>
      <a href="#<?if $pre_action && $pre_action.help?><?$pre_action.help?><?/if?>"  class="form_action_help"<?if $warning && $warning.help?> warning="<?$warning.help?>"<?/if?> target="blank"><?$lang.help?></a>
    <?elseif $act=='next'?>
      <a href="#<?if $pre_action && $pre_action.next?><?$pre_action.next?><?/if?>"  class="form_action_next submitable"><?$lang.next?></a>
    <?elseif $act=='return'?>
      <a href="#<?if $pre_action && $pre_action.return?><?$pre_action.return?><?/if?>"  class="form_action_return"<?if $warning && $warning.return?> warning="<?$warning.return?>"<?/if?> ><?$lang.return?></a>
    <?/if?>
 <?/foreach?>
 </div>

<?/if?>
<script language="JavaScript">
<!--
(function($) {
    //$('form[id="<?$form?>"]').submit(function(){return false;});
    // return button
    $('#form_action .form_action_return').live('click', function(){
        if ($(this).attr('warning') != undefined) {
            window.location.href = $(this).attr('warning');
        } else {
            window.history.go(-1);
        }
    });

    // help button
    $('#form_action .form_action_help').live('click', function(){
        if ($(this).attr('warning') != undefined) {
            $(this).attr('href', $(this).attr('warning'));
        }
    });

    // delete button
    //$('#form_action .form_action_delete').live('click', function(){
    //    alert('hello');
    //});

    $('#form_action  .submitable').live('click', $.yeaheasy.formAction.init('formId', '<?$form?>').callUserFuncAndSubmit);

    $('#form_action .selectOne').live('click', $.yeaheasy.formAction.checkOneChecked);

})(jQuery);
//-->
</script>