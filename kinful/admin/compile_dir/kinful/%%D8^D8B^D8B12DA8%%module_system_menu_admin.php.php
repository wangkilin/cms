<?php /* Smarty version 2.6.6, created on 2011-05-16 13:42:21
         compiled from module_system_menu_admin.php */ ?>
<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'default'): ?>
    <form id="admin_main_content" method=post action="#">
    <div class="admin_title_logo menu_list_admin"><?php echo $this->_tpl_vars['lang']['menu_list_admin_title']; ?>
</div>
    <?php if ($this->_tpl_vars['form_action']): ?>
       <?php echo $this->_tpl_vars['form_action']; ?>

    <?php endif; ?>
      <?php if ($this->_tpl_vars['menus']): ?>
          <?php echo $this->_tpl_vars['menus']; ?>

      <?php endif; ?>
    </form>
<?php endif; ?>

<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'list_menu'): ?>
    <form id="admin_main_content" method=post action="#">
    <div class="admin_title_logo menu_admin"><?php echo $this->_tpl_vars['lang']['menu_admin_title']; ?>
</div>
    <?php if ($this->_tpl_vars['form_action']): ?>
       <?php echo $this->_tpl_vars['form_action']; ?>

    <?php endif; ?>
      <?php if ($this->_tpl_vars['menus']): ?>
          <?php echo $this->_tpl_vars['menus']; ?>

      <?php endif; ?>
    </form>
<?php endif; ?>

<?php if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'list'): ?>
    <div id="menu_type_list">
      <div id="menu_type_list_header">
      </div>
      <div id="menu_list">
       
        <?php if (count($_from = (array)$this->_tpl_vars['menus'])):
    foreach ($_from as $this->_tpl_vars['menuType']):
?>
            <a href="?yemodule=<?php echo $this->_tpl_vars['module_name']; ?>
&admin=menu&action=update&menu=<?php echo $this->_tpl_vars['menuType']['menu_id']; ?>
"><?php echo $this->_tpl_vars['menuType']['menu_name']; ?>
</a>
        <?php endforeach; unset($_from); endif; ?>
       
      </div>
      <div id="menu_type_list_foot">
      </div>
    </div>
<?php endif; ?>