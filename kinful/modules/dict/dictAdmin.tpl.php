<?* update media / create a media *?>
<?if $action && ($action=='dictUpdate' || $action=='dictCreate')?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo page_admin_create"><?$lang.dict_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <div class="clearBoth">
        <p class="admin_title_nav on">
        <?if $action=='dictUpdate'?>
            <?$lang.dict_update_tab_title?>
        <?else?>
            <?$lang.dict_create_tab_title?>
        <?/if?>
        </p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?$lang.dict_admin_description?>
          </p>
          <div class="admin_main_content">
              <div class="dict_basic_information">
                  <p>
                      <label for="on_top"><?$lang.dict_on_top?></label>:
                      <input type="hidden" name="on_top" value="0"/>
                      <input type="checkbox" name="on_top" id="on_top" value="1" <?if isset($dictInfo) && $dictInfo.on_top==1?>checked="checked"<?/if?>>
                      <label for="weight"><?$lang.dict_weight?></label>:
                      <select name="dict_weight">
                          <?html_options values=$dict_weights output=$dict_weights selected=$dictInfo.weight?>
                      </select>
                  </p>
                  <p>
                      <label><?$lang.dict_publish?></label>:
                      <input type="radio" name="dict_publish" id="dict_publish_no" value="0" <?if isset($dictInfo) && $dictInfo.publish==0?>checked="checked"<?/if?>><label for="dict_publish_no" class="noWidth"><?$lang.no?></label>
                      <input type="radio" name="dict_publish" id="dict_publish_yes" value="1" <?if !isset($dictInfo) || $dictInfo.publish==1?>checked="checked"<?/if?>><label for="dict_publish_yes" class="noWidth"><?$lang.yes?></label>
                  </p>
                  <p>
                      <label for="dict_title"><?$lang.dict_title?></label>:
                      <input type="text" name="dict_title" id="dict_title" value="<?if isset($dictInfo)?><?$dictInfo.title?><?/if?>"/>
                  </p>
                  <p>
                      <label for="dict_bold"><?$lang.dict_bold?></label>:
                      <input type="hidden" name="dict_bold" value="0"/>
                      <input type="checkbox" name="dict_bold" id="dict_bold" value="1" <?if isset($dictInfo) && $dictInfo.dict_bold?>checked="checked"<?/if?>/>
                      <label for="dict_italic"><?$lang.dict_italic?></label>:
                      <input type="hidden" name="dict_italic" value="0"/>
                      <input type="checkbox" name="dict_italic" id="dict_italic" value="1" <?if isset($dictInfo) && $dictInfo.dict_italic?>checked="checked"<?/if?>/>
                      <label for="title_color"><?$lang.dict_title_color?></label>:
                      <input type="text" name="title_color" id="title_color" value=" <?if isset($dictInfo) && $dictInfo.title_color?><?$dictInfo.title_color?><?/if?>">
                  </p>
                  <p>
                      <label><?$lang.dict_title_media?></label>:
                      <input type="radio" name="dict_title_media" id="dict_title_no_media" value="0" <?if !isset($dictInfo) || $dictInfo.dict_title_media==0?>checked="checked"<?/if?>/>
                      <label class="noWidth" for="dict_title_no_media"><?$lang.dict_title_no_media?></label>
                      <input type="radio" name="dict_title_media" id="dict_title_image" value="4" <?if isset($dictInfo) && $dictInfo.dict_title_media==4?>checked="checked"<?/if?>/>
                      <label class="noWidth" for="dict_title_image"><?$lang.dict_title_image?></label>
                      <input type="radio" name="dict_title_media" id="dict_title_video" value="8" <?if isset($dictInfo) && $dictInfo.dict_title_media==8?>checked="checked"<?/if?>/>
                      <label class="noWidth" for="dict_title_video"><?$lang.dict_title_video?></label>
                      <input type="radio" name="dict_title_media" id="dict_title_audio" value="15" <?if isset($dictInfo) && $dictInfo.dict_title_media==15?>checked="checked"<?/if?>/>
                      <label class="noWidth" for="dict_title_audio"><?$lang.dict_title_audio?></label>
                  </p>
                  <p>
                      <label for="start_time"><?$lang.dict_start_time?></label>:
                      <input type="text" name="start_time" id="start_time" value="<?if isset($dictInfo)?><?$dictInfo.start_time?><?/if?>"/>
                      <label for="end_time"><?$lang.dict_end_time?></label>:
                      <input type="text" name="end_time" id="end_time" value="<?if isset($dictInfo)?><?$dictInfo.end_time?><?/if?>">
                  </p>
                  <p>
                      <label for="reference_url"><?$lang.dict_reference_url?></label>:
                      <input type="text" name="reference_url" id="reference_url" value="<?if isset($dictInfo)?><?$dictInfo.reference_url?><?/if?>"/>
                  </p>
                  <p>
                      <label for="meta_key"><?$lang.dict_meta_key?></label>:
                      <input type="text" name="meta_key" id="meta_key" value="<?if isset($dictInfo)?><?$dictInfo.meta_key?><?/if?>"/>
                      <label for="meta_desc"><?$lang.dict_meta_desc?></label>:
                      <input type="text" name="meta_desc" id="meta_desc" value="<?if isset($dictInfo)?><?$dictInfo.meta_desc?><?/if?>">
                  </p>
                  <p>
                      <label><?$lang.dict_intro_text?></label>:
                      <textarea id="intro_text" name="intro_text" rows="15" cols="80" style="width: 90%">
                      <?if isset($dictInfo)?><?$dictInfo.intro_text?><?/if?>
                      </textarea>
                  </p>
                  <p>
                      <label><?$lang.dict_full_text?></label>:
                      <textarea id="full_text" name="full_text" rows="15" cols="80" style="width: 90%">
                      <?if isset($dictInfo)?><?$dictInfo.full_text?><?/if?>
                      </textarea>
                  </p>
                  <input type="hidden" name="category_id" value="<?$category_id?>"/>
                  <?if $dictInfo?>
                  <input type="hidden" name="dict_id" value="<?$dictInfo.dict_id?>"/>
                  <?/if?>
              </div>
              <div class="clearBoth"></div>
          </div>
          <div class="clearBoth"></div>
        </div>
      </div>
    </form>
<?/if?>

<?* update a media category *?>
<?if $action && $action=='categoryUpdate'?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo page_list_admin_update"><?$lang.page_list_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?$lang.page_list_update_tab_title?></p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?$lang.page_list_admin_description?>
          </p>
          <?if $category?>
          <div class="admin_main_content">
              <div class="page_basic_information">
                  <input type="hidden" name="page_list_id" value="<?$category.category_id?>">
                  <p>
                      <label for="dict_category_name"><?$lang.dict_category_name?></label>:
                      <input type="text" name="dict_category_name" id="dict_category_name" value="<?$category.title?>">
                  </p>
                  <p>
                      <label><?$lang.publish?></label>:
                      <label for="dict_category_publish"><?$lang.yes?></label>
                      <input type="radio" name="dict_category_publish" id="dict_category_publish" value="1" <?if $category.publish=='1'?>checked="checked"<?/if?>>
                      <label for="dict_category_unpublish"><?$lang.no?></label>
                      <input type="radio" name="dict_category_publish" id="dict_category_unpublish" value="0" <?if $category.publish=='0'?>checked="checked"<?/if?>>
                  </p>
              </div>
              <div class="page_module_selection">
                  <div class="page_seleted_modules">
                      <div class="page_seleted_modules_title">
                          <a class="admin_title_nav on">区块设置</a>
                      </div>
                      <div class="page_selected_modules_list">
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
                      <div>&nbsp;</div>
                      </div>
                  </div>
              </div>
          </div>
          <?else?>
          <div><?$lang.no_media_category_selected?></div>
          <?/if?>
      </div>
    </form>
<?/if?>

<?* create a media category *?>
<?if $action && $action=='categoryCreate'?>
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
              <div class="page_basic_information">
                  <p>
                      <label for="dict_category_name"><?$lang.dict_category_name?></label>:
                      <input type="text" name="dict_category_name" id="dict_category_name" value="">
                  </p>
                  <p>
                      <label><?$lang.publish?></label>:
                      <input type="radio" name="dict_category_publish" id="dict_category_publish" value="1" checked="checked">

                      <label for="dict_category_publish" class="noWidth"><?$lang.yes?></label>
                      <input type="radio" name="dict_category_publish" id="dict_category_unpublish" value="0">
                      <label for="dict_category_unpublish" class="noWidth"><?$lang.no?></label>
                  </p>
              </div>
              <div class="page_module_selection">
                  <div class="page_seleted_modules">
                      <div class="page_seleted_modules_title">
                          <a class="admin_title_nav on">区块设置</a>
                      </div>
                      <div class="page_selected_modules_list">
                          <p>
                              <label><?$lang.publish?></label>:
                              <input type="radio" name="dict_category_publish" id="dict_category_publish" value="1" checked="checked">

                              <label for="dict_category_publish" class="noWidth"><?$lang.yes?></label>
                              <input type="radio" name="dict_category_publish" id="dict_category_unpublish" value="0">
                              <label for="dict_category_unpublish" class="noWidth"><?$lang.no?></label>
                          </p>
                          <p>&nbsp;</p>
                          <p>
                              <label for="dict_">新闻条数</label>:
                              <input type="text" name="dict_items" id="dict_items" value="8" class="width80"/>
                          </p>
                          <p>
                              <label for="dict_">每条字数</label>:
                              <input type="text" name="dict_chars" id="dict_items" value="20" class="width80"/>
                          </p>
                          <p>
                              <label>显示时间</label>:
                              <input type="radio" name="dict_show_time" id="dict_show_time_yes" value="1" checked="checked">

                              <label for="dict_show_time_yes" class="noWidth"><?$lang.yes?></label>
                              <input type="radio" name="dict_show_time" id="dict_show_time_no" value="0">
                              <label for="dict_show_time_no" class="noWidth"><?$lang.no?></label>
                          </p>
                          <p>
                              <label for="dict_">显示作者</label>:
                              <input type="radio" name="dict_show_author" id="dict_show_author_yes" value="1">

                              <label for="dict_show_time_yes" class="noWidth"><?$lang.yes?></label>
                              <input type="radio" name="dict_show_author" id="dict_show_author_no" value="0" checked="checked">
                              <label for="dict_show_time_no" class="noWidth"><?$lang.no?></label>
                          </p>
                          <p>
                              <label for="dict_">显示“更多”</label>:
                              <input type="radio" name="dict_show_more" id="dict_show_more_yes" value="1" checked="checked">

                              <label for="dict_show_more_yes" class="noWidth"><?$lang.yes?></label>
                              <input type="radio" name="dict_show_more" id="dict_show_more_no" value="0">
                              <label for="dict_show_time_no" class="noWidth"><?$lang.no?></label>
                          </p>
                          <p>
                              <label for="dict_">显示分类名称</label>:
                              <input type="radio" name="dict_show_category" id="dict_show_category_yes" value="1">

                              <label for="dict_show_category_yes" class="noWidth"><?$lang.yes?></label>
                              <input type="radio" name="dict_show_category" id="dict_show_category_no" value="0" checked="checked">
                              <label for="dict_show_category_no" class="noWidth"><?$lang.no?></label>
                          </p>

                      <div>&nbsp;</div>
                      </div>
                  </div>
              </div>
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


<?if $action && $action=='listDict'?>
    <form id="admin_main_content" method=post action="#">
    <div class="admin_title_logo page_admin"><?$page_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <?if $dict?>
          <?$dict?>
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

<?if $action && $action=='deleteConfirm'?>

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
<?/if?>