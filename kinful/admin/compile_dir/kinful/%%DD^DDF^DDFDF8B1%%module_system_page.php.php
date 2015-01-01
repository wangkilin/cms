<?php /* Smarty version 2.6.6, created on 2010-10-22 14:20:47
         compiled from module_system_page.php */ ?>
<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'page'): ?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo page_admin_update"><?php echo $this->_tpl_vars['lang']['page_admin_title']; ?>
</div>
    <?php if ($this->_tpl_vars['form_action']): ?>
       <?php echo $this->_tpl_vars['form_action']; ?>

    <?php endif; ?>
      <?php if ($this->_tpl_vars['page']): ?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?php echo $this->_tpl_vars['lang']['page_update_tab_title']; ?>
</p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?php echo $this->_tpl_vars['lang']['page_admin_description']; ?>

          </p>
          <div class="admin_main_content">
              <div class="page_basic_information">
              <?php if ($this->_tpl_vars['page']['page_id'] > 0): ?>
                  <p>
                      <label for="page_name"><?php echo $this->_tpl_vars['lang']['page_name']; ?>
</label>:
                      <input type="text" name="page_name" id="page_name" value="<?php echo $this->_tpl_vars['page']['page_name']; ?>
">
                  </p>
                  <p>
                      <label><?php echo $this->_tpl_vars['lang']['has_main_block']; ?>
</label>:
                      <input type="radio" name="has_main_block" id="has_main_block_no" value="0" <?php if ($this->_tpl_vars['page']['has_main_block'] == 0): ?>checked="checked"<?php endif; ?>><label for="has_main_block_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                      <input type="radio" name="has_main_block" id="has_main_block_yes" value="1" <?php if ($this->_tpl_vars['page']['has_main_block'] == 1): ?>checked="checked"<?php endif; ?>><label for="has_main_block_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                  </p>
                  <p>
                      <label><?php echo $this->_tpl_vars['lang']['publish']; ?>
</label>:
                      <input type="radio" name="page_publish" id="page_publish_no" value="0" <?php if ($this->_tpl_vars['page']['publish'] == 0): ?>checked="checked"<?php endif; ?>><label for="page_publish_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                      <input type="radio" name="page_publish" id="page_publish_yes" value="1" <?php if ($this->_tpl_vars['page']['publish'] == 1): ?>checked="checked"<?php endif; ?>><label for="page_publish_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                  </p>
                  <p>
                      <label for="use_style"><?php echo $this->_tpl_vars['lang']['use_style']; ?>
</label>:
                      <select name="use_style" id="use_style">
                          <option value=""><?php echo $this->_tpl_vars['lang']['page_use_default_theme']; ?>
</option>
                      <?php if (count($_from = (array)$this->_tpl_vars['themes'])):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                          <option value="<?php echo $this->_tpl_vars['item']['theme_id']; ?>
"  <?php if ($this->_tpl_vars['page']['template_id'] == $this->_tpl_vars['item']['theme_id']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']['theme_name']; ?>
</option>
                      <?php endforeach; unset($_from); endif; ?>
                      </select>
                  </p>
                  <p>
                      <label><?php echo $this->_tpl_vars['lang']['page_support_type']; ?>
</label>:
                      <input type="checkbox" name="page_support_type[]" value="<?php echo @constant('MY_SUPPORT_ALL'); ?>
" onclick="javascript:$.yeaheasy.checkOneCheckAll(this, this.name)"  <?php if ($this->_tpl_vars['page']['support_type'] == @constant('MY_SUPPORT_ALL')): ?>checked="checked"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['page_support_all']; ?>

                      <input type="checkbox" name="page_support_type[]" value="<?php echo @constant('MY_SUPPORT_WEB'); ?>
"   <?php if ($this->_tpl_vars['page']['support_type'] & @constant('MY_SUPPORT_WEB')): ?>checked="checked"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['page_support_web']; ?>

                      <input type="checkbox" name="page_support_type[]" value="<?php echo @constant('MY_SUPPORT_WAP'); ?>
"  <?php if ($this->_tpl_vars['page']['support_type'] & @constant('MY_SUPPORT_WAP')): ?>checked="checked"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['page_support_wap']; ?>

                      <input type="checkbox" name="page_support_type[]" value="<?php echo @constant('MY_SUPPORT_RSS'); ?>
"  <?php if ($this->_tpl_vars['page']['support_type'] & @constant('MY_SUPPORT_RSS')): ?>checked="checked"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['page_support_rss']; ?>

                  </p>
                  <p>
                      <label><?php echo $this->_tpl_vars['lang']['page_admin_note']; ?>
</label>:
                      <input type="text" id="page_admin_note" name="page_admin_note" value="<?php echo $this->_tpl_vars['page']['notes']; ?>
">
                  </p>
              <?php elseif ($this->_tpl_vars['page']['page_id'] == 0): ?>
                  <p>
                      <label for="page_name">首页管理</label>
                  </p>
                  <input type="hidden" name="homePageFlag" value="1">
              <?php endif; ?>
                  <input type="hidden" name="page_list_id" value="<?php echo $this->_tpl_vars['page']['page_category_id']; ?>
">
                  <input type="hidden" name="page_id" value="<?php echo $this->_tpl_vars['page']['page_id']; ?>
">
              </div>
              <div class="page_module_selection">
                  <div class="page_module_list">
                    <?php if (isset($this->_foreach['moduleItem'])) unset($this->_foreach['moduleItem']);
$this->_foreach['moduleItem']['total'] = count($_from = (array)$this->_tpl_vars['modules']);
$this->_foreach['moduleItem']['show'] = $this->_foreach['moduleItem']['total'] > 0;
if ($this->_foreach['moduleItem']['show']):
$this->_foreach['moduleItem']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['moduleItem']['iteration']++;
        $this->_foreach['moduleItem']['first'] = ($this->_foreach['moduleItem']['iteration'] == 1);
        $this->_foreach['moduleItem']['last']  = ($this->_foreach['moduleItem']['iteration'] == $this->_foreach['moduleItem']['total']);
?>
                      <a moduleId="<?php echo $this->_tpl_vars['item']['module_id']; ?>
" class="admin_title_nav <?php if ($this->_foreach['moduleItem']['first']): ?>on<?php endif; ?>"><?php echo $this->_tpl_vars['item']['module_name']; ?>
</a>
                    <?php endforeach; unset($_from); endif; ?>
                  </div>
                  <div class="page_module_parameters">
                      <?php if (count($_from = (array)$this->_tpl_vars['blocks'])):
    foreach ($_from as $this->_tpl_vars['module_id'] => $this->_tpl_vars['item']):
?>
                      <div class="page_block_info" moduleId="<?php echo $this->_tpl_vars['module_id']; ?>
">
                        <div class="blockList">
                          <label >块：</label>
                          <select name="blockList">
                          <option value="0">--选择块--</option>
                          <?php if (count($_from = (array)$this->_tpl_vars['item'])):
    foreach ($_from as $this->_tpl_vars['blockItem']):
?>
                          <option value="<?php echo $this->_tpl_vars['blockItem']['block_id']; ?>
"><?php echo $this->_tpl_vars['blockItem']['block_name']; ?>
</option>
                          <?php endforeach; unset($_from); endif; ?>
                          </select>
                        </div>
                        <div class="block_description">
                          <?php if (count($_from = (array)$this->_tpl_vars['item'])):
    foreach ($_from as $this->_tpl_vars['blockItem']):
?>
                          <b blockId="<?php echo $this->_tpl_vars['blockItem']['block_id']; ?>
"><?php echo $this->_tpl_vars['blockItem']['block_name']; ?>
:</b>&nbsp;
                          <i blockId="<?php echo $this->_tpl_vars['blockItem']['block_id']; ?>
" class="page_block_note"><?php echo $this->_tpl_vars['blockItem']['block_note']; ?>
</i>
                          <?php endforeach; unset($_from); endif; ?>
                        </div>
                      </div>
                      <?php endforeach; unset($_from); endif; ?>
                      <div class="page_block_position">
                          <label>显示位置</label>
                          <select name="positionId">
                              <option value="0">--选择显示位置--</option>
                              <?php if (count($_from = (array)$this->_tpl_vars['positions'])):
    foreach ($_from as $this->_tpl_vars['positionItem']):
?>
                              <option value="<?php echo $this->_tpl_vars['positionItem']['position_id']; ?>
"><?php echo $this->_tpl_vars['positionItem']['position_name']; ?>
</option>
                              <?php endforeach; unset($_from); endif; ?>
                          </select>
                      </div>

                      <div class="page_module_switch">
                          <a class="page_add_module" title="add">&nbsp;</a>
                      </div>
                  </div>
                  <div class="page_seleted_modules">
                      <div class="page_seleted_modules_title">
                          <a class="admin_title_nav on">页面内容</a>
                      </div>
                      <div class="page_selected_modules_list">
                      <?php if (count($_from = (array)$this->_tpl_vars['common_blocks'])):
    foreach ($_from as $this->_tpl_vars['block']):
?>
                      <p>
                        <u class="page_existing_block">
                          <i class="page_selected_module"><?php echo $this->_tpl_vars['block']['module_name']; ?>
</i>
                          <i>-&gt;</i>
                          <i class="page_selected_block"><?php echo $this->_tpl_vars['block']['block_show_name']; ?>
</i>
                          <i>@</i>
                          <i class="page_selected_position"><?php echo $this->_tpl_vars['block']['position_name']; ?>
</i>
                        </u>
                        <a blockId="<?php echo $this->_tpl_vars['block']['using_block_id']; ?>
" pageId="<?php echo $this->_tpl_vars['block']['using_page_id']; ?>
" link="#" class="remove remove_parent" title="Remove">&nbsp;</a>
                      </p>
                      <?php endforeach; unset($_from); endif; ?>
                      <div>&nbsp;</div>
                      </div>
                  </div>
              </div>
              <div class="clearBoth"></div>
          </div>
      </div>
      <?php endif; ?>
    </form>
<?php endif; ?>

<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'pageCreate'): ?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo page_admin_create"><?php echo $this->_tpl_vars['lang']['page_admin_title']; ?>
</div>
    <?php if ($this->_tpl_vars['form_action']): ?>
       <?php echo $this->_tpl_vars['form_action']; ?>

    <?php endif; ?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?php echo $this->_tpl_vars['lang']['page_create_tab_title']; ?>
</p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?php echo $this->_tpl_vars['lang']['page_admin_description']; ?>

          </p>
          <div class="admin_main_content">
              <div class="page_basic_information">
                  <p>
                      <label for="page_name"><?php echo $this->_tpl_vars['lang']['page_name']; ?>
</label>:
                      <input type="text" name="page_name" id="page_name" value="">
                  </p>
                  <p>
                      <label><?php echo $this->_tpl_vars['lang']['has_main_block']; ?>
</label>:
                      <input type="radio" name="has_main_block" id="has_main_block_no" value="0"><label for="has_main_block_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                      <input type="radio" name="has_main_block" id="has_main_block_yes" value="1" checked="checked"><label for="has_main_block_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                  </p>
                  <p>
                      <label><?php echo $this->_tpl_vars['lang']['publish']; ?>
</label>:
                      <input type="radio" name="page_publish" id="page_publish_no" value="0"><label for="page_publish_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                      <input type="radio" name="page_publish" id="page_publish_yes" value="1" checked="checked"><label for="page_publish_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                  </p>
                  <p>
                      <label for="use_style"><?php echo $this->_tpl_vars['lang']['use_style']; ?>
</label>:
                      <select name="use_style" id="use_style">
                          <option value=""<?php echo '?>';  echo $this->_tpl_vars['lang']['page_use_default_theme']; ?>
</option>
                      <?php if (count($_from = (array)$this->_tpl_vars['themes'])):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                          <option value="<?php echo $this->_tpl_vars['item']['theme_id']; ?>
"><?php echo $this->_tpl_vars['item']['theme_name']; ?>
</option>
                      <?php endforeach; unset($_from); endif; ?>
                      </select>
                  </p>
                  <p>
                      <label><?php echo $this->_tpl_vars['lang']['page_support_type']; ?>
</label>:
                      <input type="checkbox" name="page_support_type[]" value="<?php echo @constant('MY_SUPPORT_ALL'); ?>
" onclick="javascript:$.yeaheasy.checkOneCheckAll(this, this.name)"><?php echo $this->_tpl_vars['lang']['page_support_all']; ?>

                      <input type="checkbox" name="page_support_type[]" value="<?php echo @constant('MY_SUPPORT_WEB'); ?>
" checked="checked"><?php echo $this->_tpl_vars['lang']['page_support_web']; ?>

                      <input type="checkbox" name="page_support_type[]" value="<?php echo @constant('MY_SUPPORT_WAP'); ?>
"><?php echo $this->_tpl_vars['lang']['page_support_wap']; ?>

                      <input type="checkbox" name="page_support_type[]" value="<?php echo @constant('MY_SUPPORT_RSS'); ?>
"><?php echo $this->_tpl_vars['lang']['page_support_rss']; ?>

                  </p>
                  <p>
                      <label><?php echo $this->_tpl_vars['lang']['page_admin_note']; ?>
</label>:
                      <input type="text" id="page_admin_note" name="page_admin_note" value="">
                  </p>
                  <input type="hidden" name="page_list_id" value="<?php echo $this->_tpl_vars['page_list_id']; ?>
">
              </div>
              <div class="page_module_selection">
                  <div class="page_module_list">
                    <?php if (isset($this->_foreach['moduleItem'])) unset($this->_foreach['moduleItem']);
$this->_foreach['moduleItem']['total'] = count($_from = (array)$this->_tpl_vars['modules']);
$this->_foreach['moduleItem']['show'] = $this->_foreach['moduleItem']['total'] > 0;
if ($this->_foreach['moduleItem']['show']):
$this->_foreach['moduleItem']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['moduleItem']['iteration']++;
        $this->_foreach['moduleItem']['first'] = ($this->_foreach['moduleItem']['iteration'] == 1);
        $this->_foreach['moduleItem']['last']  = ($this->_foreach['moduleItem']['iteration'] == $this->_foreach['moduleItem']['total']);
?>
                      <a moduleId="<?php echo $this->_tpl_vars['item']['module_id']; ?>
" class="admin_title_nav <?php if ($this->_foreach['moduleItem']['first']): ?>on<?php endif; ?>"><?php echo $this->_tpl_vars['item']['module_name']; ?>
</a>
                    <?php endforeach; unset($_from); endif; ?>
                  </div>
                  <div class="page_module_parameters">
                      <?php if (count($_from = (array)$this->_tpl_vars['blocks'])):
    foreach ($_from as $this->_tpl_vars['module_id'] => $this->_tpl_vars['item']):
?>
                      <div class="page_block_info" moduleId="<?php echo $this->_tpl_vars['module_id']; ?>
">
                        <div class="blockList">
                          <label >块：</label>
                          <select name="blockList">
                          <option value="0">--选择块--</option>
                          <?php if (count($_from = (array)$this->_tpl_vars['item'])):
    foreach ($_from as $this->_tpl_vars['blockItem']):
?>
                          <option value="<?php echo $this->_tpl_vars['blockItem']['block_id']; ?>
"><?php echo $this->_tpl_vars['blockItem']['block_name']; ?>
</option>
                          <?php endforeach; unset($_from); endif; ?>
                          </select>
                        </div>
                        <div class="block_description">
                          <?php if (count($_from = (array)$this->_tpl_vars['item'])):
    foreach ($_from as $this->_tpl_vars['blockItem']):
?>
                          <b blockId="<?php echo $this->_tpl_vars['blockItem']['block_id']; ?>
"><?php echo $this->_tpl_vars['blockItem']['block_name']; ?>
:</b>&nbsp;
                          <i blockId="<?php echo $this->_tpl_vars['blockItem']['block_id']; ?>
" class="page_block_note"><?php echo $this->_tpl_vars['blockItem']['block_note']; ?>
</i>
                          <?php endforeach; unset($_from); endif; ?>
                        </div>
                      </div>
                      <?php endforeach; unset($_from); endif; ?>
                      <div class="page_block_position">
                          <label>显示位置</label>
                          <select name="positionId">
                              <option value="0">--选择显示位置--</option>
                              <?php if (count($_from = (array)$this->_tpl_vars['positions'])):
    foreach ($_from as $this->_tpl_vars['positionItem']):
?>
                              <option value="<?php echo $this->_tpl_vars['positionItem']['position_id']; ?>
"><?php echo $this->_tpl_vars['positionItem']['position_name']; ?>
</option>
                              <?php endforeach; unset($_from); endif; ?>
                          </select>
                      </div>

                      <div class="page_module_switch">
                          <a class="page_add_module" title="add">&nbsp;</a>
                      </div>
                  </div>
                  <div class="page_seleted_modules">
                      <div class="page_seleted_modules_title">
                          <a class="admin_title_nav on">页面内容</a>
                      </div>
                      <div class="page_selected_modules_list">
                      <?php if (count($_from = (array)$this->_tpl_vars['common_blocks'])):
    foreach ($_from as $this->_tpl_vars['block']):
?>
                      <p>
                        <u class="page_existing_block">
                          <i class="page_selected_module"><?php echo $this->_tpl_vars['block']['module_name']; ?>
</i>
                          <i>-&gt;</i>
                          <i class="page_selected_block"><?php echo $this->_tpl_vars['block']['block_show_name']; ?>
</i>
                          <i>@</i>
                          <i class="page_selected_position"><?php echo $this->_tpl_vars['block']['position_name']; ?>
</i>
                        </u>
                        <a blockId="<?php echo $this->_tpl_vars['block']['using_block_id']; ?>
" pageId="<?php echo $this->_tpl_vars['block']['using_page_id']; ?>
" link="#" class="remove remove_parent" title="Remove">&nbsp;</a>
                      </p>
                      <?php endforeach; unset($_from); endif; ?>
                      <div>&nbsp;</div>
                      </div>
                  </div>
              </div>
              <div class="clearBoth"></div>
          </div>
      </div>
    </form>
<?php endif;  if ($this->_tpl_vars['action'] && ( $this->_tpl_vars['action'] == 'page' || $this->_tpl_vars['action'] == 'pageCreate' )): ?>
<script language="javascript">
<!--
(function($){
    $.extend({
        page:{
            init: function() {
                $('.page_block_info').hide();
                var moduleId = $('.page_module_list .admin_title_nav.on').attr('moduleId');
                $('.page_block_info[moduleId="'+moduleId+'"]').show();
            },

            /**
             * change block, show related block information.
             */
            showBlockInfo: function() {
                var blockId = $(this).val();
                $('.block_description i, .block_description b').hide();
                $('.block_description i[blockId="'+blockId+'"],.block_description b[blockId="'+
                        blockId + '"]').show();

                return false;
            },

            /**
             * click module name, change blocks list
             */
            showModuleBlocks: function() {
                if($(this).hasClass('on')) {
                    return false;
                }
                var moduleId = $(this).attr('moduleId');
                var $pageBlockInfo = $('.page_block_info[moduleId="'+moduleId+'"]');
                $(this).siblings().removeClass('on');
                $(this).addClass('on');
                $('.page_block_info').hide();
                $pageBlockInfo.show();
                $pageBlockInfo.find('select[name="blockList"]').val('0');
                $pageBlockInfo.find('select[name="blockList"]').trigger('change');

                return false;
            },

            /**
             * Click Add block, block information will be added into page blocks list
             */
            addBlock: function() {
                var $module = $('.page_module_list .admin_title_nav.on'),
                    moduleId = +$module.attr('moduleId'),
                    moduleName = $module.text(),
                    $block = $('.page_block_info:visible'),
                    blockId = +$block.find('select').val(),
                    blockName = $block.find('.blockList option:selected').text(),
                    positionId = +$('.page_block_position select').val(),
                    positionName = $('.page_block_position select option:selected').text();
                if(blockId<1 || moduleId<1 || positionId<1) {
                    return false;
                }

                $('.page_selected_modules_list').prepend(
                        '<p>'
                      + ' <u class="page_existing_block">'
                      + ' <i class="page_selected_module">' + moduleName + '</i>'
                      + ' <i>-&gt;</i>'
                      + ' <i class="page_selected_block">' + blockName + '</i>'
                      + ' <i>@</i>'
                      + ' <i class="page_selected_position">' + positionName + '</i>'
                      + ' </u>'
                      + ' <a title="Remove" class="remove isNew" link="#" blockId="' + blockId + '" pageId="">&nbsp;</a>'
                      + ' <input type="hidden" name="newBlockId[]" value="' + blockId + '"/>'
                      + ' <input type="hidden" name="newBlockName[]" value="' + blockName + '"/>'
                      + ' <input type="hidden" name="newPositionId[]" value="' + positionId + '"/>'
                      + '</p>'
                        );
                $block.find('select').val('0');
                $block.find('select').trigger('change');
                $('.page_block_position select').val('0');

                return false;
            },

            /**
             * click Remove block icon, remove block from page blocks list
             */
            removeBlock: function() {
                var blockId = $(this).attr('blockId'),
                    pageId = $(this).attr('pageId'),
                    isNew = $(this).hasClass('isNew'),
                    $block = $(this).parent();
                //$(this).parent().remove();
                $(this).siblings('u').addClass('page_deleted_block');
                $(this).removeClass('remove').addClass('cancelRemove');
                if (isNew) {
                    $.each($block.find('input:hidden'), function(){
                        $(this).attr('name', $(this).attr('name').replace(/^new(.+)/, 'removeNew$1'));
                    });
                } else {
                    $(this).parent().append('<input type="hidden" name="toRemoveBlock[]" value="'+blockId+'"/>' +
                            '<input type="hidden" name="toRemovePage[]" value="' + pageId + '"/>');
                }

                return false;
            },


            /**
             * click Cancel Remove block icon
             */
            cancelRemoveBlock: function() {
                var blockId = $(this).attr('blockId'),
                    isNew = $(this).hasClass('isNew'),
                    $block = $(this).parent();
                //$(this).parent().remove();
                $(this).siblings('u').removeClass('page_deleted_block');
                $(this).addClass('remove').removeClass('cancelRemove');
                if (isNew) {
                    $.each($block.find('input:hidden'), function(){
                        $(this).attr('name', $(this).attr('name').replace(/^removeNew(.+)/, 'new$1'));
                    });
                } else {
                    $(this).parent().find('input[name="toRemoveBlock[]"]').remove();
                    $(this).parent().find('input[name="toRemovePage[]"]').remove();
                }

                return false;
            },

            liveEvent:function() {
                var $page = this;
                /**
                 * click module name, change module blocks list
                 */
                $('.page_module_list .admin_title_nav').live('click', $page.showModuleBlocks);

                /**
                 * change block, show related block information
                */
               $('select[name="blockList"]').live('change', $page.showBlockInfo);

               /**
                * remove block from page
                */
               $('.page_selected_modules_list .remove').live('click', $page.removeBlock);

               /**
                * add block into page
                */
               $('.page_add_module').live('click', $page.addBlock);

               /**
                * cancel remove block
                */
               $('.page_selected_modules_list .cancelRemove').live('click', $page.cancelRemoveBlock);
            }
        }
    });

    $.page.init();
    $.page.liveEvent();
})(jQuery);
-->
</script>
<?php endif; ?>

<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'list'): ?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo page_list_admin_update"><?php echo $this->_tpl_vars['lang']['page_list_admin_title']; ?>
</div>
    <?php if ($this->_tpl_vars['form_action']): ?>
       <?php echo $this->_tpl_vars['form_action']; ?>

    <?php endif; ?>
      <?php if ($this->_tpl_vars['page_list']): ?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?php echo $this->_tpl_vars['lang']['page_list_update_tab_title']; ?>
</p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?php echo $this->_tpl_vars['lang']['page_list_admin_description']; ?>

          </p>
          <div class="admin_main_content">
              <input type="hidden" name="page_list_id" value="<?php echo $this->_tpl_vars['page_list']['page_category_id']; ?>
">
              <p>
                  <label for="page_list_name"><?php echo $this->_tpl_vars['lang']['page_list_name']; ?>
</label>:
                  <input type="text" name="page_list_name" id="page_list_name" value="<?php echo $this->_tpl_vars['page_list']['page_category_name']; ?>
">
              </p>
          </div>
      </div>
      <?php endif; ?>
    </form>
<?php endif; ?>

<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'listCreate'): ?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo page_list_admin_create"><?php echo $this->_tpl_vars['lang']['page_list_admin_title']; ?>
</div>
    <?php if ($this->_tpl_vars['form_action']): ?>
       <?php echo $this->_tpl_vars['form_action']; ?>

    <?php endif; ?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?php echo $this->_tpl_vars['lang']['page_list_create_tab_title']; ?>
</p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?php echo $this->_tpl_vars['lang']['page_list_admin_description']; ?>

          </p>
          <div class="admin_main_content">
              <p>
                  <label for="page_list_name"><?php echo $this->_tpl_vars['lang']['page_list_name']; ?>
</label>:
                  <input type="text" name="page_list_name" id="page_list_name" value="">
              </p>
          </div>
      </div>
    </form>
<?php endif; ?>


<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'default'): ?>
    <form id="admin_main_content" method=post action="#">
    <div class="admin_title_logo page_list_admin"><?php echo $this->_tpl_vars['page_admin_title']; ?>
</div>
    <?php if ($this->_tpl_vars['form_action']): ?>
       <?php echo $this->_tpl_vars['form_action']; ?>

    <?php endif; ?>
      <?php if ($this->_tpl_vars['pages']): ?>
          <?php echo $this->_tpl_vars['pages']; ?>

      <?php endif; ?>
    </form>
<?php endif; ?>


<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'list_page'): ?>
    <form id="admin_main_content" method=post action="#">
    <div class="admin_title_logo page_admin"><?php echo $this->_tpl_vars['page_admin_title']; ?>
</div>
    <?php if ($this->_tpl_vars['form_action']): ?>
       <?php echo $this->_tpl_vars['form_action']; ?>

    <?php endif; ?>
      <?php if ($this->_tpl_vars['pages']): ?>
          <?php echo $this->_tpl_vars['pages']; ?>

      <?php endif; ?>
    </form>
<?php endif; ?>

<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'list'): ?>
    <div id="page_type_list">
      <div id="page_type_list_header">
      </div>
      <div id="page_list">

        <?php if (count($_from = (array)$this->_tpl_vars['pages'])):
    foreach ($_from as $this->_tpl_vars['pageType']):
?>
            <a href="?yemodule=<?php echo $this->_tpl_vars['module_name']; ?>
&admin=page&action=update&page=<?php echo $this->_tpl_vars['pageType']['page_id']; ?>
"><?php echo $this->_tpl_vars['pageType']['page_name']; ?>
</a>
        <?php endforeach; unset($_from); endif; ?>

      </div>
      <div id="page_type_list_foot">
      </div>
    </div>
<?php endif; ?>