<?php /* Smarty version 2.6.6, created on 2010-09-23 05:22:28
         compiled from plugin_form_action.php */ ?>
<?php if ($this->_tpl_vars['action']): ?>
 <div id="form_action" class="form_action">
 <?php if (count($_from = (array)$this->_tpl_vars['action'])):
    foreach ($_from as $this->_tpl_vars['act']):
?>
    <?php if ($this->_tpl_vars['act'] == 'new'): ?>
      <a action="<?php echo $this->_tpl_vars['act']; ?>
" href="#<?php if ($this->_tpl_vars['pre_action'] && $this->_tpl_vars['pre_action']['new']):  echo $this->_tpl_vars['pre_action']['new'];  endif; ?>" class="form_action_new submitable"><?php echo $this->_tpl_vars['lang']['new']; ?>
</a>
    <?php elseif ($this->_tpl_vars['act'] == 'edit'): ?>
      <a action="<?php echo $this->_tpl_vars['act']; ?>
" href="#<?php if ($this->_tpl_vars['pre_action'] && $this->_tpl_vars['pre_action']['edit']):  echo $this->_tpl_vars['pre_action']['edit'];  endif; ?>"  class="form_action_edit selectOne"<?php if ($this->_tpl_vars['warning'] && $this->_tpl_vars['warning']['edit']): ?> warning="<?php echo $this->_tpl_vars['warning']['edit']; ?>
"<?php endif; ?> ><?php echo $this->_tpl_vars['lang']['edit']; ?>
</a>
    <?php elseif ($this->_tpl_vars['act'] == 'save'): ?>
      <a action="<?php echo $this->_tpl_vars['act']; ?>
" href="#<?php if ($this->_tpl_vars['pre_action'] && $this->_tpl_vars['pre_action']['save']):  echo $this->_tpl_vars['pre_action']['save'];  endif; ?>"  class="form_action_save submitable"><?php echo $this->_tpl_vars['lang']['save']; ?>
</a>
    <?php elseif ($this->_tpl_vars['act'] == 'create'): ?>
      <a action="create" href="#<?php if ($this->_tpl_vars['pre_action'] && $this->_tpl_vars['pre_action']['save']):  echo $this->_tpl_vars['pre_action']['save'];  endif; ?>"  class="form_action_save submitable"><?php echo $this->_tpl_vars['lang']['save']; ?>
</a>
    <?php elseif ($this->_tpl_vars['act'] == 'copy'): ?>
      <a action="<?php echo $this->_tpl_vars['act']; ?>
" href="#<?php if ($this->_tpl_vars['pre_action'] && $this->_tpl_vars['pre_action']['copy']):  echo $this->_tpl_vars['pre_action']['copy'];  endif; ?>"  class="form_action_copy selectOne"<?php if ($this->_tpl_vars['warning'] && $this->_tpl_vars['warning']['copy']): ?> warning="<?php echo $this->_tpl_vars['warning']['copy']; ?>
"<?php endif; ?> ><?php echo $this->_tpl_vars['lang']['copy']; ?>
</a>
    <?php elseif ($this->_tpl_vars['act'] == 'publish'): ?>
      <a action="<?php echo $this->_tpl_vars['act']; ?>
" href="#<?php if ($this->_tpl_vars['pre_action'] && $this->_tpl_vars['pre_action']['publish']):  echo $this->_tpl_vars['pre_action']['publish'];  endif; ?>"  class="form_action_publish selectOne"<?php if ($this->_tpl_vars['warning'] && $this->_tpl_vars['warning']['publish']): ?> warning="<?php echo $this->_tpl_vars['warning']['publish']; ?>
"<?php endif; ?> ><?php echo $this->_tpl_vars['lang']['publish']; ?>
</a>
    <?php elseif ($this->_tpl_vars['act'] == 'unpublish'): ?>
      <a action="<?php echo $this->_tpl_vars['act']; ?>
" href="#<?php if ($this->_tpl_vars['pre_action'] && $this->_tpl_vars['pre_action']['unpublish']):  echo $this->_tpl_vars['pre_action']['unpublish'];  endif; ?>"  class="form_action_unpublish selectOne"<?php if ($this->_tpl_vars['warning'] && $this->_tpl_vars['warning']['unpublish']): ?> warning="<?php echo $this->_tpl_vars['warning']['unpublish']; ?>
"<?php endif; ?> ><?php echo $this->_tpl_vars['lang']['unpublish']; ?>
</a>
    <?php elseif ($this->_tpl_vars['act'] == 'move'): ?>
      <a action="<?php echo $this->_tpl_vars['act']; ?>
" href="#<?php if ($this->_tpl_vars['pre_action'] && $this->_tpl_vars['pre_action']['move']):  echo $this->_tpl_vars['pre_action']['move'];  endif; ?>"  class="form_action_move selectOne"<?php if ($this->_tpl_vars['warning'] && $this->_tpl_vars['warning']['move']): ?> warning="<?php echo $this->_tpl_vars['warning']['move']; ?>
"<?php endif; ?> ><?php echo $this->_tpl_vars['lang']['move']; ?>
</a>
    <?php elseif ($this->_tpl_vars['act'] == 'delete'): ?>
      <a action="<?php echo $this->_tpl_vars['act']; ?>
" href="#<?php if ($this->_tpl_vars['pre_action'] && $this->_tpl_vars['pre_action']['delete']):  echo $this->_tpl_vars['pre_action']['delete'];  endif; ?>"  class="form_action_delete selectOne"<?php if ($this->_tpl_vars['warning'] && $this->_tpl_vars['warning']['delete']): ?> warning="<?php echo $this->_tpl_vars['warning']['delete']; ?>
"<?php endif; ?> ><?php echo $this->_tpl_vars['lang']['delete']; ?>
</a>
    <?php elseif ($this->_tpl_vars['act'] == 'help'): ?>
      <a href="#<?php if ($this->_tpl_vars['pre_action'] && $this->_tpl_vars['pre_action']['help']):  echo $this->_tpl_vars['pre_action']['help'];  endif; ?>"  class="form_action_help"<?php if ($this->_tpl_vars['warning'] && $this->_tpl_vars['warning']['help']): ?> warning="<?php echo $this->_tpl_vars['warning']['help']; ?>
"<?php endif; ?> target="blank"><?php echo $this->_tpl_vars['lang']['help']; ?>
</a>
    <?php elseif ($this->_tpl_vars['act'] == 'next'): ?>
      <a href="#<?php if ($this->_tpl_vars['pre_action'] && $this->_tpl_vars['pre_action']['next']):  echo $this->_tpl_vars['pre_action']['next'];  endif; ?>"  class="form_action_next submitable"><?php echo $this->_tpl_vars['lang']['next']; ?>
</a>
    <?php elseif ($this->_tpl_vars['act'] == 'return'): ?>
      <a href="#<?php if ($this->_tpl_vars['pre_action'] && $this->_tpl_vars['pre_action']['return']):  echo $this->_tpl_vars['pre_action']['return'];  endif; ?>"  class="form_action_return"<?php if ($this->_tpl_vars['warning'] && $this->_tpl_vars['warning']['return']): ?> warning="<?php echo $this->_tpl_vars['warning']['return']; ?>
"<?php endif; ?> ><?php echo $this->_tpl_vars['lang']['return']; ?>
</a>
    <?php endif; ?>
 <?php endforeach; unset($_from); endif; ?>
 </div>

<?php endif; ?>
<script language="JavaScript">
<!--
(function($) {
    //$('form[id="<?php echo $this->_tpl_vars['form']; ?>
"]').submit(function(){return false;});
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

    $('#form_action  .submitable').live('click', $.yeaheasy.formAction.init('formId', '<?php echo $this->_tpl_vars['form']; ?>
').callUserFuncAndSubmit);

    $('#form_action .selectOne').live('click', $.yeaheasy.formAction.checkOneChecked);

})(jQuery);
//-->
</script>