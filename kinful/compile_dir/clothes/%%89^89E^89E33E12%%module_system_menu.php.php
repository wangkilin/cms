<?php /* Smarty version 2.6.6, created on 2010-10-23 14:01:30
         compiled from module_system_menu.php */ ?>
<?php if ($this->_tpl_vars['menus'] && is_array ( $this->_tpl_vars['menus'] )): ?>
    <?php if (isset($this->_foreach['menuLoop'])) unset($this->_foreach['menuLoop']);
$this->_foreach['menuLoop']['total'] = count($_from = (array)$this->_tpl_vars['menus']);
$this->_foreach['menuLoop']['show'] = $this->_foreach['menuLoop']['total'] > 0;
if ($this->_foreach['menuLoop']['show']):
$this->_foreach['menuLoop']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['menu']):
        $this->_foreach['menuLoop']['iteration']++;
        $this->_foreach['menuLoop']['first'] = ($this->_foreach['menuLoop']['iteration'] == 1);
        $this->_foreach['menuLoop']['last']  = ($this->_foreach['menuLoop']['iteration'] == $this->_foreach['menuLoop']['total']);
?>
        <a href="<?php echo $this->_tpl_vars['menu']['menu_link']; ?>
"><?php echo $this->_tpl_vars['menu']['menu_name']; ?>
</a>
        <?php if ($this->_foreach['menuLoop']['last'] !== true): ?>
        <i>|</i>
        <?php endif; ?>
    <?php endforeach; unset($_from); endif;  endif; ?>