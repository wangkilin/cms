<?* update news / create a news *?>
<?if $action && ($action=='newsUpdate' || $action=='newsCreate')?>
<!-- TinyMCE -->
<script type="text/javascript" src="<?$smarty.const.MY_ROOT_URL?>../js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
    var editorSettings = {
    		// General options
    		add_unload_trigger : false,
    		add_form_submit_trigger : false,
    		mode : "exact",
    		elements : "intro_text,full_text",
    		theme : "advanced",
    		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist",

    		// Theme options
    		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
    		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
    		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
    		theme_advanced_toolbar_location : "top",
    		theme_advanced_toolbar_align : "left",
    		theme_advanced_statusbar_location : "bottom",
    		theme_advanced_resizing : true,

    		// Example content CSS (should be your site CSS)
    		//content_css : "css/content.css",

    		// Drop lists for link/image/media/template dialogs
    		//template_external_list_url : "lists/template_list.js",
    		//external_link_list_url : "lists/link_list.js",
    		external_image_list_url : "../js/tiny_mce/lists/image_list.js"
    		//media_external_list_url : "lists/media_list.js"
    	};
	var introEditorSettings = editorSettings,
	    fullEditorSettings  = editorSettings;
    //introEditorSettings.
	tinyMCE.init(editorSettings);
</script>
<!-- /TinyMCE -->
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo page_admin_create"><?$lang.news_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <div class="clearBoth">
        <p class="admin_title_nav on">
        <?if $action=='newsUpdate'?>
            <?$lang.news_update_tab_title?>
        <?else?>
            <?$lang.news_create_tab_title?>
        <?/if?>
        </p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?$lang.news_admin_description?>
          </p>
          <div class="admin_main_content">
              <div class="news_basic_information">
                  <p>
                      <label for="on_top"><?$lang.news_on_top?></label>:
                      <input type="hidden" name="on_top" value="0"/>
                      <input type="checkbox" name="on_top" id="on_top" value="1" <?if isset($newsInfo) && $newsInfo.on_top==1?>checked="checked"<?/if?>>
                      <label for="weight"><?$lang.news_weight?></label>:
                      <select name="news_weight">
                          <?html_options values=$news_weights output=$news_weights selected=$newsInfo.weight?>
                      </select>
                  </p>
                  <p>
                      <label><?$lang.news_publish?></label>:
                      <input type="radio" name="news_publish" id="news_publish_no" value="0" <?if isset($newsInfo) && $newsInfo.publish==0?>checked="checked"<?/if?>><label for="news_publish_no" class="noWidth"><?$lang.no?></label>
                      <input type="radio" name="news_publish" id="news_publish_yes" value="1" <?if !isset($newsInfo) || $newsInfo.publish==1?>checked="checked"<?/if?>><label for="news_publish_yes" class="noWidth"><?$lang.yes?></label>
                  </p>
                  <p>
                      <label for="news_title"><?$lang.news_title?></label>:
                      <input type="text" name="news_title" id="news_title" value="<?if isset($newsInfo)?><?$newsInfo.title?><?/if?>"/>
                  </p>
                  <p>
                      <label for="news_bold"><?$lang.news_bold?></label>:
                      <input type="hidden" name="news_bold" value="0"/>
                      <input type="checkbox" name="news_bold" id="news_bold" value="1" <?if isset($newsInfo) && $newsInfo.news_bold?>checked="checked"<?/if?>/>
                      <label for="news_italic"><?$lang.news_italic?></label>:
                      <input type="hidden" name="news_italic" value="0"/>
                      <input type="checkbox" name="news_italic" id="news_italic" value="1" <?if isset($newsInfo) && $newsInfo.news_italic?>checked="checked"<?/if?>/>
                      <label for="title_color"><?$lang.news_title_color?></label>:
                      <input type="text" name="title_color" id="title_color" value=" <?if isset($newsInfo) && $newsInfo.title_color?><?$newsInfo.title_color?><?/if?>">
                  </p>
                  <p>
                      <label><?$lang.news_title_media?></label>:
                      <input type="radio" name="news_title_media" id="news_title_no_media" value="0" <?if !isset($newsInfo) || $newsInfo.news_title_media==0?>checked="checked"<?/if?>/>
                      <label class="noWidth" for="news_title_no_media"><?$lang.news_title_no_media?></label>
                      <input type="radio" name="news_title_media" id="news_title_image" value="4" <?if isset($newsInfo) && $newsInfo.news_title_media==4?>checked="checked"<?/if?>/>
                      <label class="noWidth" for="news_title_image"><?$lang.news_title_image?></label>
                      <input type="radio" name="news_title_media" id="news_title_video" value="8" <?if isset($newsInfo) && $newsInfo.news_title_media==8?>checked="checked"<?/if?>/>
                      <label class="noWidth" for="news_title_video"><?$lang.news_title_video?></label>
                      <input type="radio" name="news_title_media" id="news_title_audio" value="15" <?if isset($newsInfo) && $newsInfo.news_title_media==15?>checked="checked"<?/if?>/>
                      <label class="noWidth" for="news_title_audio"><?$lang.news_title_audio?></label>
                  </p>
                  <p>
                      <label for="start_time"><?$lang.news_start_time?></label>:
                      <input type="text" name="start_time" id="start_time" value="<?if isset($newsInfo)?><?$newsInfo.start_time?><?/if?>"/>
                      <label for="end_time"><?$lang.news_end_time?></label>:
                      <input type="text" name="end_time" id="end_time" value="<?if isset($newsInfo)?><?$newsInfo.end_time?><?/if?>">
                  </p>
                  <p>
                      <label for="reference_url"><?$lang.news_reference_url?></label>:
                      <input type="text" name="reference_url" id="reference_url" value="<?if isset($newsInfo)?><?$newsInfo.reference_url?><?/if?>"/>
                  </p>
                  <p>
                      <label for="meta_key"><?$lang.news_meta_key?></label>:
                      <input type="text" name="meta_key" id="meta_key" value="<?if isset($newsInfo)?><?$newsInfo.meta_key?><?/if?>"/>
                      <label for="meta_desc"><?$lang.news_meta_desc?></label>:
                      <input type="text" name="meta_desc" id="meta_desc" value="<?if isset($newsInfo)?><?$newsInfo.meta_desc?><?/if?>">
                  </p>
                  <p>
                      <label><?$lang.news_intro_text?></label>:
                      <textarea id="intro_text" name="intro_text" rows="15" cols="80" style="width: 90%">
                      <?if isset($newsInfo)?><?$newsInfo.intro_text?><?/if?>
                      </textarea>
                  </p>
                  <p>
                      <label><?$lang.news_full_text?></label>:
                      <textarea id="full_text" name="full_text" rows="15" cols="80" style="width: 90%">
                      <?if isset($newsInfo)?><?$newsInfo.full_text?><?/if?>
                      </textarea>
                  </p>
                  <input type="hidden" name="category_id" value="<?$category_id?>"/>
                  <?if $newsInfo?>
                  <input type="hidden" name="news_id" value="<?$newsInfo.news_id?>"/>
                  <?/if?>
              </div>
              <div class="clearBoth"></div>
          </div>
          <div class="clearBoth"></div>
        </div>
      </div>
    </form>
<?/if?>

<?* update a news category *?>
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
                      <label for="news_category_name"><?$lang.news_category_name?></label>:
                      <input type="text" name="news_category_name" id="news_category_name" value="<?$category.title?>">
                  </p>
                  <p>
                      <label><?$lang.publish?></label>:
                      <label for="news_category_publish" class="noWidth"><?$lang.yes?></label>
                      <input type="radio" name="news_category_publish" id="news_category_publish" value="1" <?if $category.publish=='1'?>checked="checked"<?/if?>>
                      &nbsp; <label for="news_category_unpublish" class="noWidth"><?$lang.no?></label>
                      <input type="radio" name="news_category_publish" id="news_category_unpublish" value="0" <?if $category.publish=='0'?>checked="checked"<?/if?>>
                  </p>
                  <p>
                      <label><?php $lang.category_image?></label>
                      <input name="category_image" type="file"/>
                      <?if $category.image_path ?>
                      <img id="categoryImage" src="<?$category.image_path?>"/>
                      <?/if?>
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
                              <input type="radio" name="news_category_publish" id="news_category_publish" value="1" checked="checked">

                              <label for="news_category_publish" class="noWidth"><?$lang.yes?></label>
                              <input type="radio" name="news_category_publish" id="news_category_unpublish" value="0">
                              <label for="news_category_unpublish" class="noWidth"><?$lang.no?></label>
                          </p>
                          <p>&nbsp;</p>
                          <p>
                              <label for="news_">新闻条数</label>:
                              <input type="text" name="news_items" id="news_items" value="8" class="width80"/>
                          </p>
                          <p>
                              <label for="news_">每条字数</label>:
                              <input type="text" name="news_chars" id="news_items" value="20" class="width80"/>
                          </p>
                          <p>
                              <label>显示时间</label>:
                              <input type="radio" name="news_show_time" id="news_show_time_yes" value="1" checked="checked">

                              <label for="news_show_time_yes" class="noWidth"><?$lang.yes?></label>
                              <input type="radio" name="news_show_time" id="news_show_time_no" value="0">
                              <label for="news_show_time_no" class="noWidth"><?$lang.no?></label>
                          </p>
                          <p>
                              <label for="news_">显示作者</label>:
                              <input type="radio" name="news_show_author" id="news_show_author_yes" value="1">

                              <label for="news_show_time_yes" class="noWidth"><?$lang.yes?></label>
                              <input type="radio" name="news_show_author" id="news_show_author_no" value="0" checked="checked">
                              <label for="news_show_time_no" class="noWidth"><?$lang.no?></label>
                          </p>
                          <p>
                              <label for="news_">显示“更多”</label>:
                              <input type="radio" name="news_show_more" id="news_show_more_yes" value="1" checked="checked">

                              <label for="news_show_more_yes" class="noWidth"><?$lang.yes?></label>
                              <input type="radio" name="news_show_more" id="news_show_more_no" value="0">
                              <label for="news_show_time_no" class="noWidth"><?$lang.no?></label>
                          </p>
                          <p>
                              <label for="news_">显示分类名称</label>:
                              <input type="radio" name="news_show_category" id="news_show_category_yes" value="1">

                              <label for="news_show_category_yes" class="noWidth"><?$lang.yes?></label>
                              <input type="radio" name="news_show_category" id="news_show_category_no" value="0" checked="checked">
                              <label for="news_show_category_no" class="noWidth"><?$lang.no?></label>
                          </p>

                      <div>&nbsp;</div>
                      </div>
                  </div>
              </div>
                  </div>
              </div>
          </div>
          <?else?>
          <div><?$lang.no_news_category_selected?></div>
          <?/if?>
      </div>
    </form>
<?/if?>

<?* create a news category *?>
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
                      <label for="news_category_name"><?$lang.news_category_name?></label>:
                      <input type="text" name="news_category_name" id="news_category_name" value="">
                  </p>
                  <p>
                      <label><?$lang.publish?></label>:
                      <input type="radio" name="news_category_publish" id="news_category_publish" value="1" checked="checked">

                      <label for="news_category_publish" class="noWidth"><?$lang.yes?></label>
                      <input type="radio" name="news_category_publish" id="news_category_unpublish" value="0">
                      <label for="news_category_unpublish" class="noWidth"><?$lang.no?></label>
                  </p>
                  <p>
                      <label><?php $lang.category_image?></label>
                      <input name="category_image" type="file"/>
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
                              <input type="radio" name="news_category_publish" id="news_category_publish" value="1" checked="checked">

                              <label for="news_category_publish" class="noWidth"><?$lang.yes?></label>
                              <input type="radio" name="news_category_publish" id="news_category_unpublish" value="0">
                              <label for="news_category_unpublish" class="noWidth"><?$lang.no?></label>
                          </p>
                          <p>&nbsp;</p>
                          <p>
                              <label for="news_">新闻条数</label>:
                              <input type="text" name="news_items" id="news_items" value="8" class="width80"/>
                          </p>
                          <p>
                              <label for="news_">每条字数</label>:
                              <input type="text" name="news_chars" id="news_items" value="20" class="width80"/>
                          </p>
                          <p>
                              <label>显示时间</label>:
                              <input type="radio" name="news_show_time" id="news_show_time_yes" value="1" checked="checked">

                              <label for="news_show_time_yes" class="noWidth"><?$lang.yes?></label>
                              <input type="radio" name="news_show_time" id="news_show_time_no" value="0">
                              <label for="news_show_time_no" class="noWidth"><?$lang.no?></label>
                          </p>
                          <p>
                              <label for="news_">显示作者</label>:
                              <input type="radio" name="news_show_author" id="news_show_author_yes" value="1">

                              <label for="news_show_time_yes" class="noWidth"><?$lang.yes?></label>
                              <input type="radio" name="news_show_author" id="news_show_author_no" value="0" checked="checked">
                              <label for="news_show_time_no" class="noWidth"><?$lang.no?></label>
                          </p>
                          <p>
                              <label for="news_">显示“更多”</label>:
                              <input type="radio" name="news_show_more" id="news_show_more_yes" value="1" checked="checked">

                              <label for="news_show_more_yes" class="noWidth"><?$lang.yes?></label>
                              <input type="radio" name="news_show_more" id="news_show_more_no" value="0">
                              <label for="news_show_time_no" class="noWidth"><?$lang.no?></label>
                          </p>
                          <p>
                              <label for="news_">显示分类名称</label>:
                              <input type="radio" name="news_show_category" id="news_show_category_yes" value="1">

                              <label for="news_show_category_yes" class="noWidth"><?$lang.yes?></label>
                              <input type="radio" name="news_show_category" id="news_show_category_no" value="0" checked="checked">
                              <label for="news_show_category_no" class="noWidth"><?$lang.no?></label>
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


<?if $action && $action=='listNews'?>
    <form id="admin_main_content" method=post action="#">
    <div class="admin_title_logo page_admin"><?$page_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <?if $news?>
          <?$news?>
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