<?* update menu *?>
<?if $action && $action=='menu'?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo menu_admin_update"><?$lang.menu_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <?if $menu?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?$lang.menu_update_tab_title?></p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?$lang.menu_admin_description?>
          </p>
          <div class="admin_main_content">
              <p>
                  <label for="menu_name"><?$lang.menu_name?></label>: 
                  <input type="text" name="menu_name" id="menu_name" value="<?$menu.menu_name?>">
              </p>
              <p>
                  <label for="menu_link"><?$lang.menu_link?></label>: 
                  <input type="text" name="menu_link" id="menu_link" value="<?$menu.menu_link?>" size="50">
              </p>
              <p>
                  <label for="open_mode"><?$lang.menu_open_mode?></label>: 
                  <select name="open_mode" id="open_mode">
                      <option value="0" <?if "0"==$menu.open_mode?> selected="selected"<?/if?>><?$lang.open_link_mode?></option>
                      <option value="1" <?if "1"==$menu.open_mode?> selected="selected"<?/if?>><?$lang.open_link_in_window_with_bar?></option>
                      <option value="2" <?if "2"==$menu.open_mode?> selected="selected"<?/if?>><?$lang.open_link_in_window_without_bar?></option>
                  </select>
              </p>
              <p>
                  <label for="parent_menu"><?$lang.menu_parent_menu?></label>: 
                  <select name="parent_menu" id="parent_menu">
                      <option value="0"><?$lang.parent_menu_top?></option>
                   <?assign var='id_mode' value='|'|cat:$menu.menu_id|cat:'|'?>
                   <?foreach item=item from=$menus?>
                     <?assign var='id_tree' value=$item.id_tree|replace:$id_mode:''?>
                     <?* current parent, its children can not be the parent menu. *?>
                     <?if $item.menu_id<>$menu.menu_id && $item.id_tree==$id_tree?>
                      <option value="<?$item.menu_id?>" <?if  $item.menu_id==$menu.parent_id?>selected="selected"<?/if?>><?$item.menu_name?></option>
                     <?/if?>
                   <?/foreach?>
                  </select>
              </p>
              <!--<p>
                  <label for="menu_order"><?$lang.menu_order?></label>
                  <input type="text" name="menu_order" id="menu_order" value="<?$menu.menu_order?>">
              </p>-->
              <!--<p>
                  <label for="menu_name"><?$lang.menu_access_level?></label>
                  <input type="text" name="menu_name" id="menu_name" value="<?$menu.menu_access_level?>">
              </p>-->
              <p>
                  <label><?$lang.publish?></label>: 
                  <input type="radio" name="menu_publish" id="menu_publish_no" value="0" <?if "0"==$menu.publish?> checked="checked"<?/if?>><label for="menu_publish_no" class="noWidth"><?$lang.no?></label>
                  <input type="radio" name="menu_publish" id="menu_publish_yes" value="1" <?if "1"==$menu.publish?> checked="checked"<?/if?>><label for="menu_publish_yes" class="noWidth"><?$lang.yes?></label>
              </p>
              <input type="hidden" name="menu_id" value="<?$menu.menu_id?>">
              <input type="hidden" name="menu_list_id" value="<?$menu.menu_list_id?>">
          </div>
      </div>
      <?/if?>
    </form>
<?/if?>

<?* create a menu *?>
<?if $action && $action=='menuCreate'?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo menu_admin_create"><?$lang.menu_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?$lang.menu_create_tab_title?></p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?$lang.menu_admin_description?>
          </p>
          <div class="admin_main_content">
              <p>
                  <label for="menu_name"><?$lang.menu_name?></label>: 
                  <input type="text" name="menu_name" id="menu_name" value="">
              </p>
              <p>
                  <label for="menu_link"><?$lang.menu_link?></label>: 
                  <input type="text" name="menu_link" id="menu_link" value="" size="50">
              </p>
              <p>
                  <label for="open_mode"><?$lang.menu_open_mode?></label>: 
                  <select name="open_mode" id="open_mode">
                      <option value="0"><?$lang.open_link_mode?></option>
                      <option value="1"><?$lang.open_link_in_window_with_bar?></option>
                      <option value="2"><?$lang.open_link_in_window_without_bar?></option>
                  </select>
              </p>
              <p>
                  <label for="parent_menu"><?$lang.menu_parent_menu?></label>: 
                  <select name="parent_menu" id="parent_menu">
                      <option value="0"><?$lang.parent_menu_top?></option>
                   <?foreach item=item from=$menus?>
                      <option value="<?$item.menu_id?>" ><?$item.menu_name?></option>
                   <?/foreach?>
                  </select>
              </p>
              <p>
                  <label><?$lang.publish?></label>: 
                  <input type="radio" name="menu_publish" id="menu_publish_no" value="0"><label for="menu_publish_no" class="noWidth"><?$lang.no?></label>
                  <input type="radio" name="menu_publish" id="menu_publish_yes" value="1" checked="checked"><label for="menu_publish_yes" class="noWidth"><?$lang.yes?></label>
              </p>
              <input type="hidden" name="menu_list_id" value="<?$menu_list_id?>">
          </div>
      </div>
    </form>
<?/if?>

<?* update a menu list *?>
<?if $action && $action=='list'?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo menu_list_admin_update"><?$lang.menu_list_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <?if $menu_list?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?$lang.menu_list_update_tab_title?></p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?$lang.menu_list_admin_description?>
          </p>
          <div class="admin_main_content">
              <p>
                  <label for="menu_list_name"><?$lang.menu_list_name?></label>: 
                  <input type="text" name="menu_list_name" id="menu_list_name" value="<?$menu_list.menu_list_name?>">
              </p>
              <p>
                  <label><?$lang.publish?></label>: 
                  <input type="radio" name="publish" id="publish_no" value="0" <?if "0"==$menu_list.publish?> checked="checked"<?/if?>><label for="publish_no" class="noWidth"><?$lang.no?></label>
                  <input type="radio" name="publish" id="publish_yes" value="1" <?if "1"==$menu_list.publish?> checked="checked"<?/if?>><label for="publish_yes" class="noWidth"><?$lang.yes?></label>
              </p>
              <input type="hidden" name="menu_list_id" value="<?$menu_list.menu_list_id?>">
          </div>
      </div>
      <?/if?>
    </form>
<?/if?>

<?* create a menu list *?>
<?if $action && $action=='listCreate'?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo menu_list_admin_create"><?$lang.menu_list_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?$lang.menu_list_create_tab_title?></p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?$lang.menu_list_admin_description?>
          </p>
          <div class="admin_main_content">
              <p>
                  <label for="menu_list_name"><?$lang.menu_list_name?></label>: 
                  <input type="text" name="menu_list_name" id="menu_list_name" value="">
              </p>
              <p>
                  <label><?$lang.publish?></label>: 
                  <input type="radio" name="publish" id="publish_no" value="0"><label for="publish_no" class="noWidth"><?$lang.no?></label>
                  <input type="radio" name="publish" id="publish_yes" value="1" checked="checked"><label for="publish_yes" class="noWidth"><?$lang.yes?></label>
              </p>
          </div>
      </div>
    </form>
<?/if?>