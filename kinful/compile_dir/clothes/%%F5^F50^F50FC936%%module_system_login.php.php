<?php /* Smarty version 2.6.6, created on 2010-08-21 01:53:45
         compiled from module_system_login.php */ ?>
<form method=post action="?yemodule=<?php echo $this->_tpl_vars['module_name']; ?>
">
 <p>
     <label for="user_name"><?php echo $this->_tpl_vars['lang']['enter_user_name']; ?>
</label>
     <input type="text" name="user_name" id="user_name"/>
 </p>
 <p>
     <label for="user_password"><?php echo $this->_tpl_vars['lang']['enter_user_password']; ?>
</label>
     <input type="password" name="user_password" id="user_password"/>
 </p>
 <p>
     <input type="hidden" name="back_page" value="<?php echo $this->_tpl_vars['back_page']; ?>
"/>
     <input type="submit" value="<?php echo $this->_tpl_vars['lang']['button_user_login']; ?>
"/>
     <input type="reset" value="<?php echo $this->_tpl_vars['lang']['button_reset_form']; ?>
"/>
 </p>
</form>