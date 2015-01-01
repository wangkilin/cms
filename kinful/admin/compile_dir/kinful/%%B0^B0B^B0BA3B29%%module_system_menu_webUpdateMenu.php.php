<?php /* Smarty version 2.6.6, created on 2011-05-16 13:42:26
         compiled from module_system_menu_webUpdateMenu.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'module_system_menu_webUpdateMenu.php', 37, false),array('modifier', 'replace', 'module_system_menu_webUpdateMenu.php', 39, false),)), $this); ?>
<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'menu'): ?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo menu_admin_update"><?php echo $this->_tpl_vars['lang']['menu_admin_title']; ?>
</div>
    <?php if ($this->_tpl_vars['form_action']): ?>
       <?php echo $this->_tpl_vars['form_action']; ?>

    <?php endif; ?>
      <?php if ($this->_tpl_vars['menu']): ?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?php echo $this->_tpl_vars['lang']['menu_update_tab_title']; ?>
</p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?php echo $this->_tpl_vars['lang']['menu_admin_description']; ?>

          </p>
          <div class="admin_main_content">
              <p>
                  <label for="menu_name"><?php echo $this->_tpl_vars['lang']['menu_name']; ?>
</label>: 
                  <input type="text" name="menu_name" id="menu_name" value="<?php echo $this->_tpl_vars['menu']['menu_name']; ?>
">
              </p>
              <p>
                  <label for="menu_link"><?php echo $this->_tpl_vars['lang']['menu_link']; ?>
</label>: 
                  <input type="text" name="menu_link" id="menu_link" value="<?php echo $this->_tpl_vars['menu']['menu_link']; ?>
" size="50">
              </p>
              <p>
                  <label for="open_mode"><?php echo $this->_tpl_vars['lang']['menu_open_mode']; ?>
</label>: 
                  <select name="open_mode" id="open_mode">
                      <option value="0" <?php if ('0' == $this->_tpl_vars['menu']['open_mode']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['open_link_mode']; ?>
</option>
                      <option value="1" <?php if ('1' == $this->_tpl_vars['menu']['open_mode']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['open_link_in_window_with_bar']; ?>
</option>
                      <option value="2" <?php if ('2' == $this->_tpl_vars['menu']['open_mode']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['open_link_in_window_without_bar']; ?>
</option>
                  </select>
              </p>
              <p>
                  <label for="parent_menu"><?php echo $this->_tpl_vars['lang']['menu_parent_menu']; ?>
</label>: 
                  <select name="parent_menu" id="parent_menu">
                      <option value="0"><?php echo $this->_tpl_vars['lang']['parent_menu_top']; ?>
</option>
                   <?php $this->assign('id_mode', ((is_array($_tmp=((is_array($_tmp='|')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['menu']['menu_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['menu']['menu_id'])))) ? $this->_run_mod_handler('cat', true, $_tmp, '|') : smarty_modifier_cat($_tmp, '|'))); ?>
                   <?php if (count($_from = (array)$this->_tpl_vars['menus'])):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                     <?php $this->assign('id_tree', ((is_array($_tmp=$this->_tpl_vars['item']['id_tree'])) ? $this->_run_mod_handler('replace', true, $_tmp, $this->_tpl_vars['id_mode'], '') : smarty_modifier_replace($_tmp, $this->_tpl_vars['id_mode'], ''))); ?>
                                          <?php if ($this->_tpl_vars['item']['menu_id'] <> $this->_tpl_vars['menu']['menu_id'] && $this->_tpl_vars['item']['id_tree'] == $this->_tpl_vars['id_tree']): ?>
                      <option value="<?php echo $this->_tpl_vars['item']['menu_id']; ?>
" <?php if ($this->_tpl_vars['item']['menu_id'] == $this->_tpl_vars['menu']['parent_id']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']['menu_name']; ?>
</option>
                     <?php endif; ?>
                   <?php endforeach; unset($_from); endif; ?>
                  </select>
              </p>
              <!--<p>
                  <label for="menu_order"><?php echo $this->_tpl_vars['lang']['menu_order']; ?>
</label>
                  <input type="text" name="menu_order" id="menu_order" value="<?php echo $this->_tpl_vars['menu']['menu_order']; ?>
">
              </p>-->
              <!--<p>
                  <label for="menu_name"><?php echo $this->_tpl_vars['lang']['menu_access_level']; ?>
</label>
                  <input type="text" name="menu_name" id="menu_name" value="<?php echo $this->_tpl_vars['menu']['menu_access_level']; ?>
">
              </p>-->
              <p>
                  <label><?php echo $this->_tpl_vars['lang']['publish']; ?>
</label>: 
                  <input type="radio" name="menu_publish" id="menu_publish_no" value="0" <?php if ('0' == $this->_tpl_vars['menu']['publish']): ?> checked="checked"<?php endif; ?>><label for="menu_publish_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                  <input type="radio" name="menu_publish" id="menu_publish_yes" value="1" <?php if ('1' == $this->_tpl_vars['menu']['publish']): ?> checked="checked"<?php endif; ?>><label for="menu_publish_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
              </p>
              <input type="hidden" name="menu_id" value="<?php echo $this->_tpl_vars['menu']['menu_id']; ?>
">
              <input type="hidden" name="menu_list_id" value="<?php echo $this->_tpl_vars['menu']['menu_list_id']; ?>
">
          </div>
      </div>
      <?php endif; ?>
    </form>
<?php endif; ?>

<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'menuCreate'): ?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo menu_admin_create"><?php echo $this->_tpl_vars['lang']['menu_admin_title']; ?>
</div>
    <?php if ($this->_tpl_vars['form_action']): ?>
       <?php echo $this->_tpl_vars['form_action']; ?>

    <?php endif; ?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?php echo $this->_tpl_vars['lang']['menu_create_tab_title']; ?>
</p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?php echo $this->_tpl_vars['lang']['menu_admin_description']; ?>

          </p>
          <div class="admin_main_content">
              <p>
                  <label for="menu_name"><?php echo $this->_tpl_vars['lang']['menu_name']; ?>
</label>: 
                  <input type="text" name="menu_name" id="menu_name" value="">
              </p>
              <p>
                  <label for="menu_link"><?php echo $this->_tpl_vars['lang']['menu_link']; ?>
</label>: 
                  <input type="text" name="menu_link" id="menu_link" value="" size="50">
              </p>
              <p>
                  <label for="open_mode"><?php echo $this->_tpl_vars['lang']['menu_open_mode']; ?>
</label>: 
                  <select name="open_mode" id="open_mode">
                      <option value="0"><?php echo $this->_tpl_vars['lang']['open_link_mode']; ?>
</option>
                      <option value="1"><?php echo $this->_tpl_vars['lang']['open_link_in_window_with_bar']; ?>
</option>
                      <option value="2"><?php echo $this->_tpl_vars['lang']['open_link_in_window_without_bar']; ?>
</option>
                  </select>
              </p>
              <p>
                  <label for="parent_menu"><?php echo $this->_tpl_vars['lang']['menu_parent_menu']; ?>
</label>: 
                  <select name="parent_menu" id="parent_menu">
                      <option value="0"><?php echo $this->_tpl_vars['lang']['parent_menu_top']; ?>
</option>
                   <?php if (count($_from = (array)$this->_tpl_vars['menus'])):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                      <option value="<?php echo $this->_tpl_vars['item']['menu_id']; ?>
" ><?php echo $this->_tpl_vars['item']['menu_name']; ?>
</option>
                   <?php endforeach; unset($_from); endif; ?>
                  </select>
              </p>
              <p>
                  <label><?php echo $this->_tpl_vars['lang']['publish']; ?>
</label>: 
                  <input type="radio" name="menu_publish" id="menu_publish_no" value="0"><label for="menu_publish_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                  <input type="radio" name="menu_publish" id="menu_publish_yes" value="1" checked="checked"><label for="menu_publish_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
              </p>
              <input type="hidden" name="menu_list_id" value="<?php echo $this->_tpl_vars['menu_list_id']; ?>
">
          </div>
      </div>
    </form>
<?php endif; ?>

<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'list'): ?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo menu_list_admin_update"><?php echo $this->_tpl_vars['lang']['menu_list_admin_title']; ?>
</div>
    <?php if ($this->_tpl_vars['form_action']): ?>
       <?php echo $this->_tpl_vars['form_action']; ?>

    <?php endif; ?>
      <?php if ($this->_tpl_vars['menu_list']): ?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?php echo $this->_tpl_vars['lang']['menu_list_update_tab_title']; ?>
</p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?php echo $this->_tpl_vars['lang']['menu_list_admin_description']; ?>

          </p>
          <div class="admin_main_content">
              <p>
                  <label for="menu_list_name"><?php echo $this->_tpl_vars['lang']['menu_list_name']; ?>
</label>: 
                  <input type="text" name="menu_list_name" id="menu_list_name" value="<?php echo $this->_tpl_vars['menu_list']['menu_list_name']; ?>
">
              </p>
              <p>
                  <label><?php echo $this->_tpl_vars['lang']['publish']; ?>
</label>: 
                  <input type="radio" name="publish" id="publish_no" value="0" <?php if ('0' == $this->_tpl_vars['menu_list']['publish']): ?> checked="checked"<?php endif; ?>><label for="publish_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                  <input type="radio" name="publish" id="publish_yes" value="1" <?php if ('1' == $this->_tpl_vars['menu_list']['publish']): ?> checked="checked"<?php endif; ?>><label for="publish_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
              </p>
              <input type="hidden" name="menu_list_id" value="<?php echo $this->_tpl_vars['menu_list']['menu_list_id']; ?>
">
          </div>
      </div>
      <?php endif; ?>
    </form>
<?php endif; ?>

<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'listCreate'): ?>
    <form id="admin_main_content" method=post action=''>
    <div class="admin_title_logo menu_list_admin_create"><?php echo $this->_tpl_vars['lang']['menu_list_admin_title']; ?>
</div>
    <?php if ($this->_tpl_vars['form_action']): ?>
       <?php echo $this->_tpl_vars['form_action']; ?>

    <?php endif; ?>
      <div class="clearBoth">
        <p class="admin_title_nav on"><?php echo $this->_tpl_vars['lang']['menu_list_create_tab_title']; ?>
</p>
      </div>
      <div class="admin_main_zone">
          <p class="admin_main_desc">
          <?php echo $this->_tpl_vars['lang']['menu_list_admin_description']; ?>

          </p>
          <div class="admin_main_content">
              <p>
                  <label for="menu_list_name"><?php echo $this->_tpl_vars['lang']['menu_list_name']; ?>
</label>: 
                  <input type="text" name="menu_list_name" id="menu_list_name" value="">
              </p>
              <p>
                  <label><?php echo $this->_tpl_vars['lang']['publish']; ?>
</label>: 
                  <input type="radio" name="publish" id="publish_no" value="0"><label for="publish_no" class="noWidth"><?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
                  <input type="radio" name="publish" id="publish_yes" value="1" checked="checked"><label for="publish_yes" class="noWidth"><?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
              </p>
          </div>
      </div>
    </form>
<?php endif; ?>