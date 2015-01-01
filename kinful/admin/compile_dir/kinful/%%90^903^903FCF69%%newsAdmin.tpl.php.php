<?php /* Smarty version 2.6.6, created on 2010-09-24 13:33:04
         compiled from newsAdmin.tpl.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'newsAdmin.tpl.php', 66, false),)), $this); ?>
<?php if ($this->_tpl_vars['action'] && ( $this->_tpl_vars['action'] == 'newsUpdate' || $this->_tpl_vars['action'] == 'newsCreate' )): ?>
<!-- TinyMCE -->
<script type="text/javascript" src="<?php echo @constant('MY_ROOT_URL'); ?>
../js/tiny_mce/tiny_mce.js"></script>
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
    <div class="admin_title_logo page_admin_create"><?php echo $this->_tpl_vars['lang']['news_admin_title']; ?>
</div>
    <?php if ($this->_tpl_vars['form_action']): ?>
       <?php echo $this->_tpl_vars['form_action']; ?>

    <?php endif; ?>
      <div class="clearBoth">
        <p class="admin_title_nav on">
        <?php if ($this->_tpl_vars['action'] == 'newsUpdate'): ?>
            <?php echo $this->_tpl_vars['lang']['news_update_tab_title']; ?>

        <?php else: ?>
            <?php echo $this->_tpl_vars['lang']['news_create_tab_title']; ?>

        <?php endif; ?>
        </p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?php echo $this->_tpl_vars['lang']['news_admin_description']; ?>

          </p>
          <div class="admin_main_content">
              <div class="news_basic_information">
                  <p>
                      <label for="on_top"><?php echo $this->_tpl_vars['lang']['news_on_top']; ?>
</label>:
                      <input type="hidden" name="on_top" value="0"/>
                      <input type="checkbox" name="on_top" id="on_top" value="1" <?php if (isset ( $this->_tpl_vars['newsInfo'] ) && $this->_tpl_vars['newsInfo']['on_top'] == 1): ?>checked="checked"<?php endif; ?>>
                      <label for="weight"><?php echo $this->_tpl_vars['lang']['news_weight']; ?>
</label>:
                      <select name="news_weight">
                          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['news_weights'],'output' => $this->_tpl_vars['news_weights'],'selected' => $this->_tpl_vars['newsInfo']['weight']), $this);?>

                      </select>
                  </p>
                  <p>
                      <label><?php echo $this->_tpl_vars['lang']['news_publish']; ?>
</label>:
                      <input type="radio" name="news_publish" id="news_publish_no" value="0" <?php if (isset ( $this->_tpl_vars['newsInfo'] ) && $this->_tpl_vars['newsInfo']['publish'] == 0): ?>checked="checked"<?php endif; ?>><label for="news_publish_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                      <input type="radio" name="news_publish" id="news_publish_yes" value="1" <?php if (! isset ( $this->_tpl_vars['newsInfo'] ) || $this->_tpl_vars['newsInfo']['publish'] == 1): ?>checked="checked"<?php endif; ?>><label for="news_publish_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                  </p>
                  <p>
                      <label for="news_title"><?php echo $this->_tpl_vars['lang']['news_title']; ?>
</label>:
                      <input type="text" name="news_title" id="news_title" value="<?php if (isset ( $this->_tpl_vars['newsInfo'] )):  echo $this->_tpl_vars['newsInfo']['title'];  endif; ?>"/>
                  </p>
                  <p>
                      <label for="news_bold"><?php echo $this->_tpl_vars['lang']['news_bold']; ?>
</label>:
                      <input type="hidden" name="news_bold" value="0"/>
                      <input type="checkbox" name="news_bold" id="news_bold" value="1" <?php if (isset ( $this->_tpl_vars['newsInfo'] ) && $this->_tpl_vars['newsInfo']['news_bold']): ?>checked="checked"<?php endif; ?>/>
                      <label for="news_italic"><?php echo $this->_tpl_vars['lang']['news_italic']; ?>
</label>:
                      <input type="hidden" name="news_italic" value="0"/>
                      <input type="checkbox" name="news_italic" id="news_italic" value="1" <?php if (isset ( $this->_tpl_vars['newsInfo'] ) && $this->_tpl_vars['newsInfo']['news_italic']): ?>checked="checked"<?php endif; ?>/>
                      <label for="title_color"><?php echo $this->_tpl_vars['lang']['news_title_color']; ?>
</label>:
                      <input type="text" name="title_color" id="title_color" value=" <?php if (isset ( $this->_tpl_vars['newsInfo'] ) && $this->_tpl_vars['newsInfo']['title_color']):  echo $this->_tpl_vars['newsInfo']['title_color'];  endif; ?>">
                  </p>
                  <p>
                      <label><?php echo $this->_tpl_vars['lang']['news_title_media']; ?>
</label>:
                      <input type="radio" name="news_title_media" id="news_title_no_media" value="0" <?php if (! isset ( $this->_tpl_vars['newsInfo'] ) || $this->_tpl_vars['newsInfo']['news_title_media'] == 0): ?>checked="checked"<?php endif; ?>/>
                      <label class="noWidth" for="news_title_no_media"><?php echo $this->_tpl_vars['lang']['news_title_no_media']; ?>
</label>
                      <input type="radio" name="news_title_media" id="news_title_image" value="4" <?php if (isset ( $this->_tpl_vars['newsInfo'] ) && $this->_tpl_vars['newsInfo']['news_title_media'] == 4): ?>checked="checked"<?php endif; ?>/>
                      <label class="noWidth" for="news_title_image"><?php echo $this->_tpl_vars['lang']['news_title_image']; ?>
</label>
                      <input type="radio" name="news_title_media" id="news_title_video" value="8" <?php if (isset ( $this->_tpl_vars['newsInfo'] ) && $this->_tpl_vars['newsInfo']['news_title_media'] == 8): ?>checked="checked"<?php endif; ?>/>
                      <label class="noWidth" for="news_title_video"><?php echo $this->_tpl_vars['lang']['news_title_video']; ?>
</label>
                      <input type="radio" name="news_title_media" id="news_title_audio" value="15" <?php if (isset ( $this->_tpl_vars['newsInfo'] ) && $this->_tpl_vars['newsInfo']['news_title_media'] == 15): ?>checked="checked"<?php endif; ?>/>
                      <label class="noWidth" for="news_title_audio"><?php echo $this->_tpl_vars['lang']['news_title_audio']; ?>
</label>
                  </p>
                  <p>
                      <label for="start_time"><?php echo $this->_tpl_vars['lang']['news_start_time']; ?>
</label>:
                      <input type="text" name="start_time" id="start_time" value="<?php if (isset ( $this->_tpl_vars['newsInfo'] )):  echo $this->_tpl_vars['newsInfo']['start_time'];  endif; ?>"/>
                      <label for="end_time"><?php echo $this->_tpl_vars['lang']['news_end_time']; ?>
</label>:
                      <input type="text" name="end_time" id="end_time" value="<?php if (isset ( $this->_tpl_vars['newsInfo'] )):  echo $this->_tpl_vars['newsInfo']['end_time'];  endif; ?>">
                  </p>
                  <p>
                      <label for="reference_url"><?php echo $this->_tpl_vars['lang']['news_reference_url']; ?>
</label>:
                      <input type="text" name="reference_url" id="reference_url" value="<?php if (isset ( $this->_tpl_vars['newsInfo'] )):  echo $this->_tpl_vars['newsInfo']['reference_url'];  endif; ?>"/>
                  </p>
                  <p>
                      <label for="meta_key"><?php echo $this->_tpl_vars['lang']['news_meta_key']; ?>
</label>:
                      <input type="text" name="meta_key" id="meta_key" value="<?php if (isset ( $this->_tpl_vars['newsInfo'] )):  echo $this->_tpl_vars['newsInfo']['meta_key'];  endif; ?>"/>
                      <label for="meta_desc"><?php echo $this->_tpl_vars['lang']['news_meta_desc']; ?>
</label>:
                      <input type="text" name="meta_desc" id="meta_desc" value="<?php if (isset ( $this->_tpl_vars['newsInfo'] )):  echo $this->_tpl_vars['newsInfo']['meta_desc'];  endif; ?>">
                  </p>
                  <p>
                      <label><?php echo $this->_tpl_vars['lang']['news_intro_text']; ?>
</label>:
                      <textarea id="intro_text" name="intro_text" rows="15" cols="80" style="width: 90%">
                      <?php if (isset ( $this->_tpl_vars['newsInfo'] )):  echo $this->_tpl_vars['newsInfo']['intro_text'];  endif; ?>
                      </textarea>
                  </p>
                  <p>
                      <label><?php echo $this->_tpl_vars['lang']['news_full_text']; ?>
</label>:
                      <textarea id="full_text" name="full_text" rows="15" cols="80" style="width: 90%">
                      <?php if (isset ( $this->_tpl_vars['newsInfo'] )):  echo $this->_tpl_vars['newsInfo']['full_text'];  endif; ?>
                      </textarea>
                  </p>
                  <input type="hidden" name="category_id" value="<?php echo $this->_tpl_vars['category_id']; ?>
"/>
                  <?php if ($this->_tpl_vars['newsInfo']): ?>
                  <input type="hidden" name="news_id" value="<?php echo $this->_tpl_vars['newsInfo']['news_id']; ?>
"/>
                  <?php endif; ?>
              </div>
              <div class="clearBoth"></div>
          </div>
          <div class="clearBoth"></div>
        </div>
      </div>
    </form>
<?php endif; ?>

<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'categoryUpdate'): ?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo page_list_admin_update"><?php echo $this->_tpl_vars['lang']['page_list_admin_title']; ?>
</div>
    <?php if ($this->_tpl_vars['form_action']): ?>
       <?php echo $this->_tpl_vars['form_action']; ?>

    <?php endif; ?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?php echo $this->_tpl_vars['lang']['page_list_update_tab_title']; ?>
</p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?php echo $this->_tpl_vars['lang']['page_list_admin_description']; ?>

          </p>
          <?php if ($this->_tpl_vars['category']): ?>
          <div class="admin_main_content">
              <div class="page_basic_information">
                  <input type="hidden" name="page_list_id" value="<?php echo $this->_tpl_vars['category']['category_id']; ?>
">
                  <p>
                      <label for="news_category_name"><?php echo $this->_tpl_vars['lang']['news_category_name']; ?>
</label>:
                      <input type="text" name="news_category_name" id="news_category_name" value="<?php echo $this->_tpl_vars['category']['title']; ?>
">
                  </p>
                  <p>
                      <label><?php echo $this->_tpl_vars['lang']['publish']; ?>
</label>:
                      <label for="news_category_publish" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                      <input type="radio" name="news_category_publish" id="news_category_publish" value="1" <?php if ($this->_tpl_vars['category']['publish'] == '1'): ?>checked="checked"<?php endif; ?>>
                      &nbsp; <label for="news_category_unpublish" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                      <input type="radio" name="news_category_publish" id="news_category_unpublish" value="0" <?php if ($this->_tpl_vars['category']['publish'] == '0'): ?>checked="checked"<?php endif; ?>>
                  </p>
                  <p>
                      <label></label>
                      <input name="category_image" type="file"/>
                      <?php if ($this->_tpl_vars['category']['image_path']): ?>
                      <img id="categoryImage" src="<?php echo $this->_tpl_vars['category']['image_path']; ?>
"/>
                      <?php endif; ?>
                  </p>
              </div>
              <div class="page_module_selection">
                  <div class="page_seleted_modules">
                      <div class="page_seleted_modules_title">
                          <a class="admin_title_nav on">区块设置</a>
                      </div>
                      <div class="page_selected_modules_list">
                          <p>
                              <label><?php echo $this->_tpl_vars['lang']['publish']; ?>
</label>:
                              <input type="radio" name="news_category_publish" id="news_category_publish" value="1" checked="checked">

                              <label for="news_category_publish" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                              <input type="radio" name="news_category_publish" id="news_category_unpublish" value="0">
                              <label for="news_category_unpublish" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
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

                              <label for="news_show_time_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                              <input type="radio" name="news_show_time" id="news_show_time_no" value="0">
                              <label for="news_show_time_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                          </p>
                          <p>
                              <label for="news_">显示作者</label>:
                              <input type="radio" name="news_show_author" id="news_show_author_yes" value="1">

                              <label for="news_show_time_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                              <input type="radio" name="news_show_author" id="news_show_author_no" value="0" checked="checked">
                              <label for="news_show_time_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                          </p>
                          <p>
                              <label for="news_">显示“更多”</label>:
                              <input type="radio" name="news_show_more" id="news_show_more_yes" value="1" checked="checked">

                              <label for="news_show_more_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                              <input type="radio" name="news_show_more" id="news_show_more_no" value="0">
                              <label for="news_show_time_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                          </p>
                          <p>
                              <label for="news_">显示分类名称</label>:
                              <input type="radio" name="news_show_category" id="news_show_category_yes" value="1">

                              <label for="news_show_category_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                              <input type="radio" name="news_show_category" id="news_show_category_no" value="0" checked="checked">
                              <label for="news_show_category_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                          </p>

                      <div>&nbsp;</div>
                      </div>
                  </div>
              </div>
                  </div>
              </div>
          </div>
          <?php else: ?>
          <div><?php echo $this->_tpl_vars['lang']['no_news_category_selected']; ?>
</div>
          <?php endif; ?>
      </div>
    </form>
<?php endif; ?>

<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'categoryCreate'): ?>
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
              <div class="page_basic_information">
                  <p>
                      <label for="news_category_name"><?php echo $this->_tpl_vars['lang']['news_category_name']; ?>
</label>:
                      <input type="text" name="news_category_name" id="news_category_name" value="">
                  </p>
                  <p>
                      <label><?php echo $this->_tpl_vars['lang']['publish']; ?>
</label>:
                      <input type="radio" name="news_category_publish" id="news_category_publish" value="1" checked="checked">

                      <label for="news_category_publish" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                      <input type="radio" name="news_category_publish" id="news_category_unpublish" value="0">
                      <label for="news_category_unpublish" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                  </p>
                  <p>
                      <label></label>
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
                              <label><?php echo $this->_tpl_vars['lang']['publish']; ?>
</label>:
                              <input type="radio" name="news_category_publish" id="news_category_publish" value="1" checked="checked">

                              <label for="news_category_publish" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                              <input type="radio" name="news_category_publish" id="news_category_unpublish" value="0">
                              <label for="news_category_unpublish" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
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

                              <label for="news_show_time_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                              <input type="radio" name="news_show_time" id="news_show_time_no" value="0">
                              <label for="news_show_time_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                          </p>
                          <p>
                              <label for="news_">显示作者</label>:
                              <input type="radio" name="news_show_author" id="news_show_author_yes" value="1">

                              <label for="news_show_time_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                              <input type="radio" name="news_show_author" id="news_show_author_no" value="0" checked="checked">
                              <label for="news_show_time_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                          </p>
                          <p>
                              <label for="news_">显示“更多”</label>:
                              <input type="radio" name="news_show_more" id="news_show_more_yes" value="1" checked="checked">

                              <label for="news_show_more_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                              <input type="radio" name="news_show_more" id="news_show_more_no" value="0">
                              <label for="news_show_time_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                          </p>
                          <p>
                              <label for="news_">显示分类名称</label>:
                              <input type="radio" name="news_show_category" id="news_show_category_yes" value="1">

                              <label for="news_show_category_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
                              <input type="radio" name="news_show_category" id="news_show_category_no" value="0" checked="checked">
                              <label for="news_show_category_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                          </p>

                      <div>&nbsp;</div>
                      </div>
                  </div>
              </div>
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


<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'listNews'): ?>
    <form id="admin_main_content" method=post action="#">
    <div class="admin_title_logo page_admin"><?php echo $this->_tpl_vars['page_admin_title']; ?>
</div>
    <?php if ($this->_tpl_vars['form_action']): ?>
       <?php echo $this->_tpl_vars['form_action']; ?>

    <?php endif; ?>
      <?php if ($this->_tpl_vars['news']): ?>
          <?php echo $this->_tpl_vars['news']; ?>

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

<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'deleteConfirm'): ?>

    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo delete_confirm"><?php echo $this->_tpl_vars['lang']['delete_confirm_title']; ?>
</div>
    <?php if ($this->_tpl_vars['form_action']): ?>
       <?php echo $this->_tpl_vars['form_action']; ?>

    <?php endif; ?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?php echo $this->_tpl_vars['lang']['delete_confirm_tab_title']; ?>
</p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?php echo $this->_tpl_vars['lang']['delete_confirm_description']; ?>

          </p>
          <div class="admin_main_content">
              <p>
              <?php if (count($_from = (array)$this->_tpl_vars['descItems'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
              <?php echo $this->_tpl_vars['key']; ?>
 : <font class="high_light_blue"><?php echo $this->_tpl_vars['item']; ?>
</font> <br>
              <?php endforeach; unset($_from); endif; ?>
              </p>
              <p id="form_delete_confirm">
                  <a  class="form_action_delete" href="#" action="delete"><?php echo $this->_tpl_vars['lang']['delete']; ?>
</a>
              </p>
              <input type="hidden" name="form_action" value="delete">
              <input type="hidden" name="form_delete_confirm" value="yes">
              <?php if (count($_from = (array)$this->_tpl_vars['hiddenItems'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
              <input type="hidden" name="<?php echo $this->_tpl_vars['key']; ?>
" value="<?php echo $this->_tpl_vars['item']; ?>
">
              <?php endforeach; unset($_from); endif; ?>
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
<?php endif; ?>