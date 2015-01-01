<?* update page *?>
<?if $action && $action=='page'?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo page_admin_update"><?$lang.page_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <?if $page?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?$lang.page_update_tab_title?></p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?$lang.page_admin_description?>
          </p>
          <div class="admin_main_content">
              <div class="page_basic_information">
              <?if $page.page_id>0?>
                  <p>
                      <label for="page_name"><?$lang.page_name?></label>:
                      <input type="text" name="page_name" id="page_name" value="<?$page.page_name?>">
                  </p>
                  <p>
                      <label><?$lang.has_main_block?></label>:
                      <input type="radio" name="has_main_block" id="has_main_block_no" value="0" <?if $page.has_main_block==0?>checked="checked"<?/if?>><label for="has_main_block_no" class="noWidth"><?$lang.no?></label>
                      <input type="radio" name="has_main_block" id="has_main_block_yes" value="1" <?if $page.has_main_block==1?>checked="checked"<?/if?>><label for="has_main_block_yes" class="noWidth"><?$lang.yes?></label>
                  </p>
                  <p>
                      <label><?$lang.publish?></label>:
                      <input type="radio" name="page_publish" id="page_publish_no" value="0" <?if $page.publish==0?>checked="checked"<?/if?>><label for="page_publish_no" class="noWidth"><?$lang.no?></label>
                      <input type="radio" name="page_publish" id="page_publish_yes" value="1" <?if $page.publish==1?>checked="checked"<?/if?>><label for="page_publish_yes" class="noWidth"><?$lang.yes?></label>
                  </p>
                  <p>
                      <label for="use_style"><?$lang.use_style?></label>:
                      <select name="use_style" id="use_style">
                          <option value=""><?$lang.page_use_default_theme?></option>
                      <?foreach item=item from=$themes?>
                          <option value="<?$item.theme_id?>"  <?if $page.template_id==$item.theme_id?>selected="selected"<?/if?>><?$item.theme_name?></option>
                      <?/foreach?>
                      </select>
                  </p>
                  <p>
                      <label><?$lang.page_support_type?></label>:
                      <input type="checkbox" name="page_support_type[]" value="<?$smarty.const.MY_SUPPORT_ALL?>" onclick="javascript:$.yeaheasy.checkOneCheckAll(this, this.name)"  <?if $page.support_type==$smarty.const.MY_SUPPORT_ALL?>checked="checked"<?/if?>><?$lang.page_support_all?>
                      <input type="checkbox" name="page_support_type[]" value="<?$smarty.const.MY_SUPPORT_WEB?>"   <?if $page.support_type&$smarty.const.MY_SUPPORT_WEB?>checked="checked"<?/if?>><?$lang.page_support_web?>
                      <input type="checkbox" name="page_support_type[]" value="<?$smarty.const.MY_SUPPORT_WAP?>"  <?if $page.support_type&$smarty.const.MY_SUPPORT_WAP?>checked="checked"<?/if?>><?$lang.page_support_wap?>
                      <input type="checkbox" name="page_support_type[]" value="<?$smarty.const.MY_SUPPORT_RSS?>"  <?if $page.support_type&$smarty.const.MY_SUPPORT_RSS?>checked="checked"<?/if?>><?$lang.page_support_rss?>
                  </p>
                  <p>
                      <label><?$lang.page_admin_note?></label>:
                      <input type="text" id="page_admin_note" name="page_admin_note" value="<?$page.notes?>">
                  </p>
              <?elseif $page.page_id==0?>
                  <p>
                      <label for="page_name">首页管理</label>
                  </p>
                  <input type="hidden" name="homePageFlag" value="1">
              <?/if?>
                  <input type="hidden" name="page_list_id" value="<?$page.page_category_id?>">
                  <input type="hidden" name="page_id" value="<?$page.page_id?>">
              </div>
              <div class="page_module_selection">
                  <div class="page_module_list">
                    <?foreach name=moduleItem item=item from=$modules?>
                      <a moduleId="<?$item.module_id?>" class="admin_title_nav <?if $smarty.foreach.moduleItem.first?>on<?/if?>"><?$item.module_name?></a>
                    <?/foreach?>
                  </div>
                  <div class="page_module_parameters">
                      <?foreach key=module_id item=item from=$blocks?>
                      <div class="page_block_info" moduleId="<?$module_id?>">
                        <div class="blockList">
                          <label >块：</label>
                          <select name="blockList">
                          <option value="0">--选择块--</option>
                          <?foreach item=blockItem from=$item?>
                          <option value="<?$blockItem.block_id?>"><?$blockItem.block_name?></option>
                          <?/foreach?>
                          </select>
                        </div>
                        <div class="block_description">
                          <?foreach item=blockItem from=$item?>
                          <b blockId="<?$blockItem.block_id?>"><?$blockItem.block_name?>:</b>&nbsp;
                          <i blockId="<?$blockItem.block_id?>" class="page_block_note"><?$blockItem.block_note?></i>
                          <?/foreach?>
                        </div>
                      </div>
                      <?/foreach?>
                      <div class="page_block_position">
                          <label>显示位置</label>
                          <select name="positionId">
                              <option value="0">--选择显示位置--</option>
                              <?foreach item=positionItem from=$positions?>
                              <option value="<?$positionItem.position_id?>"><?$positionItem.position_name?></option>
                              <?/foreach?>
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
                      <?foreach item=block from=$common_blocks?>
                      <p>
                        <u class="page_existing_block">
                          <i class="page_selected_module"><?$block.module_name?></i>
                          <i>-&gt;</i>
                          <i class="page_selected_block"><?$block.block_show_name?></i>
                          <i>@</i>
                          <i class="page_selected_position"><?$block.position_name?></i>
                        </u>
                        <a blockId="<?$block.using_block_id?>" pageId="<?$block.using_page_id?>" link="#" class="remove remove_parent" title="Remove">&nbsp;</a>
                      </p>
                      <?/foreach?>
                      <div>&nbsp;</div>
                      </div>
                  </div>
              </div>
              <div class="clearBoth"></div>
          </div>
      </div>
      <?/if?>
    </form>
<?/if?>

<?* create a page *?>
<?if $action && $action=='pageCreate'?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo page_admin_create"><?$lang.page_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?$lang.page_create_tab_title?></p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?$lang.page_admin_description?>
          </p>
          <div class="admin_main_content">
              <div class="page_basic_information">
                  <p>
                      <label for="page_name"><?$lang.page_name?></label>:
                      <input type="text" name="page_name" id="page_name" value="">
                  </p>
                  <p>
                      <label><?$lang.has_main_block?></label>:
                      <input type="radio" name="has_main_block" id="has_main_block_no" value="0"><label for="has_main_block_no" class="noWidth"><?$lang.no?></label>
                      <input type="radio" name="has_main_block" id="has_main_block_yes" value="1" checked="checked"><label for="has_main_block_yes" class="noWidth"><?$lang.yes?></label>
                  </p>
                  <p>
                      <label><?$lang.publish?></label>:
                      <input type="radio" name="page_publish" id="page_publish_no" value="0"><label for="page_publish_no" class="noWidth"><?$lang.no?></label>
                      <input type="radio" name="page_publish" id="page_publish_yes" value="1" checked="checked"><label for="page_publish_yes" class="noWidth"><?$lang.yes?></label>
                  </p>
                  <p>
                      <label for="use_style"><?$lang.use_style?></label>:
                      <select name="use_style" id="use_style">
                          <option value=""?><?$lang.page_use_default_theme?></option>
                      <?foreach item=item from=$themes?>
                          <option value="<?$item.theme_id?>"><?$item.theme_name?></option>
                      <?/foreach?>
                      </select>
                  </p>
                  <p>
                      <label><?$lang.page_support_type?></label>:
                      <input type="checkbox" name="page_support_type[]" value="<?$smarty.const.MY_SUPPORT_ALL?>" onclick="javascript:$.yeaheasy.checkOneCheckAll(this, this.name)"><?$lang.page_support_all?>
                      <input type="checkbox" name="page_support_type[]" value="<?$smarty.const.MY_SUPPORT_WEB?>" checked="checked"><?$lang.page_support_web?>
                      <input type="checkbox" name="page_support_type[]" value="<?$smarty.const.MY_SUPPORT_WAP?>"><?$lang.page_support_wap?>
                      <input type="checkbox" name="page_support_type[]" value="<?$smarty.const.MY_SUPPORT_RSS?>"><?$lang.page_support_rss?>
                  </p>
                  <p>
                      <label><?$lang.page_admin_note?></label>:
                      <input type="text" id="page_admin_note" name="page_admin_note" value="">
                  </p>
                  <input type="hidden" name="page_list_id" value="<?$page_list_id?>">
              </div>
              <div class="page_module_selection">
                  <div class="page_module_list">
                    <?foreach name=moduleItem item=item from=$modules?>
                      <a moduleId="<?$item.module_id?>" class="admin_title_nav <?if $smarty.foreach.moduleItem.first?>on<?/if?>"><?$item.module_name?></a>
                    <?/foreach?>
                  </div>
                  <div class="page_module_parameters">
                      <?foreach key=module_id item=item from=$blocks?>
                      <div class="page_block_info" moduleId="<?$module_id?>">
                        <div class="blockList">
                          <label >块：</label>
                          <select name="blockList">
                          <option value="0">--选择块--</option>
                          <?foreach item=blockItem from=$item?>
                          <option value="<?$blockItem.block_id?>"><?$blockItem.block_name?></option>
                          <?/foreach?>
                          </select>
                        </div>
                        <div class="block_description">
                          <?foreach item=blockItem from=$item?>
                          <b blockId="<?$blockItem.block_id?>"><?$blockItem.block_name?>:</b>&nbsp;
                          <i blockId="<?$blockItem.block_id?>" class="page_block_note"><?$blockItem.block_note?></i>
                          <?/foreach?>
                        </div>
                      </div>
                      <?/foreach?>
                      <div class="page_block_position">
                          <label>显示位置</label>
                          <select name="positionId">
                              <option value="0">--选择显示位置--</option>
                              <?foreach item=positionItem from=$positions?>
                              <option value="<?$positionItem.position_id?>"><?$positionItem.position_name?></option>
                              <?/foreach?>
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
                      <?foreach item=block from=$common_blocks?>
                      <p>
                        <u class="page_existing_block">
                          <i class="page_selected_module"><?$block.module_name?></i>
                          <i>-&gt;</i>
                          <i class="page_selected_block"><?$block.block_show_name?></i>
                          <i>@</i>
                          <i class="page_selected_position"><?$block.position_name?></i>
                        </u>
                        <a blockId="<?$block.using_block_id?>" pageId="<?$block.using_page_id?>" link="#" class="remove remove_parent" title="Remove">&nbsp;</a>
                      </p>
                      <?/foreach?>
                      <div>&nbsp;</div>
                      </div>
                  </div>
              </div>
              <div class="clearBoth"></div>
          </div>
      </div>
    </form>
<?/if?>
<?if $action && ($action=='page' || $action=='pageCreate')?>
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
<?/if?>

<?* update a page list *?>
<?if $action && $action=='list'?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo page_list_admin_update"><?$lang.page_list_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <?if $page_list?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?$lang.page_list_update_tab_title?></p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?$lang.page_list_admin_description?>
          </p>
          <div class="admin_main_content">
              <input type="hidden" name="page_list_id" value="<?$page_list.page_category_id?>">
              <p>
                  <label for="page_list_name"><?$lang.page_list_name?></label>:
                  <input type="text" name="page_list_name" id="page_list_name" value="<?$page_list.page_category_name?>">
              </p>
          </div>
      </div>
      <?/if?>
    </form>
<?/if?>

<?* create a page list *?>
<?if $action && $action=='listCreate'?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo page_list_admin_create"><?$lang.page_list_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?$lang.page_list_create_tab_title?></p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?$lang.page_list_admin_description?>
          </p>
          <div class="admin_main_content">
              <p>
                  <label for="page_list_name"><?$lang.page_list_name?></label>:
                  <input type="text" name="page_list_name" id="page_list_name" value="">
              </p>
          </div>
      </div>
    </form>
<?/if?>


<?if $action && $action=='default'?>
    <form id="admin_main_content" method=post action="#">
    <div class="admin_title_logo page_list_admin"><?$page_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <?if $pages?>
          <?$pages?>
      <?/if?>
    </form>
<?/if?>


<?if $action && $action=='list_page'?>
    <form id="admin_main_content" method=post action="#">
    <div class="admin_title_logo page_admin"><?$page_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <?if $pages?>
          <?$pages?>
      <?/if?>
    </form>
<?/if?>

<?if $action && $action=='list'?>
    <div id="page_type_list">
      <div id="page_type_list_header">
      </div>
      <div id="page_list">

        <?foreach item=pageType from=$pages?>
            <a href="?yemodule=<?$module_name?>&admin=page&action=update&page=<?$pageType.page_id?>"><?$pageType.page_name?></a>
        <?/foreach?>

      </div>
      <div id="page_type_list_foot">
      </div>
    </div>
<?/if?>