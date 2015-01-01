<?php /* Smarty version 2.6.6, created on 2010-09-23 05:22:29
         compiled from index.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'index.php', 73, false),)), $this); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE><?php echo $this->_tpl_vars['site_config']['site_name']; ?>
</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link href="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
css/index.css" type=text/css rel=stylesheet>
<?php if ($this->_tpl_vars['MY_MODULE_NAME']): ?>
<link href="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
css/module_<?php echo $this->_tpl_vars['MY_MODULE_NAME']; ?>
.css" type=text/css rel=stylesheet>
<?php endif; ?>
<link rel="shortcut icon" href="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
image/favicon.ico" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
js/jquery.min.js"></script>
<script type="text/javascript"  src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
js/jquery-ui.min.js"></script>
<script type="text/javascript"  src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
js/kinful.js"></script>
</head>
<body class="body">
<div height="84px" id='header_zone' valign='top'>
    <img src="<?php echo $this->_tpl_vars['MY_THEME_PATH']; ?>
images/admin_logo.jpg" border="0" alt="">
    <div id="logout_zone">
        <a href="?yemodule=system&admin=logout">Logout</a>
    </div>
</div>
<!-- start top -->
<div id="menu_zone">

<!-- start::head menu -->
<?php if ($this->_tpl_vars['head_menu']): ?>
    <?php if (is_array ( $this->_tpl_vars['head_menu'] ) === true): ?>
        <?php if (count($_from = (array)$this->_tpl_vars['head_menu'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
            <?php echo $this->_tpl_vars['item']; ?>

        <?php endforeach; unset($_from); endif; ?>
    <?php endif;  endif; ?>
<!-- end::head menu -->
</div>
<!-- end top -->
<?php if ($this->_tpl_vars['logo_zone']): ?>
<div id="logo_zone">
    <?php if (is_array ( $this->_tpl_vars['logo_zone'] ) === true): ?>
        <?php if (count($_from = (array)$this->_tpl_vars['head_menu'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
            <div id="logo_zone_<?php echo $this->_tpl_vars['key']; ?>
">
            <?php echo $this->_tpl_vars['key']; ?>
: <?php echo $this->_tpl_vars['item']; ?>

            </div>
        <?php endforeach; unset($_from); endif; ?>
    <?php elseif (is_string ( $this->_tpl_vars['logo_zone'] )): ?>
        <?php echo $this->_tpl_vars['logo_zone']; ?>

    <?php endif; ?>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['left_menu']): ?>
<div id="left_menu">
    <?php if (is_array ( $this->_tpl_vars['left_menu'] ) === true): ?>
        <?php if (count($_from = (array)$this->_tpl_vars['left_menu'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
            <div id="left_menu_<?php echo $this->_tpl_vars['key']; ?>
">
            <?php echo $this->_tpl_vars['key']; ?>
: <?php echo $this->_tpl_vars['item']; ?>

            </div>
        <?php endforeach; unset($_from); endif; ?>
    <?php elseif (is_string ( $this->_tpl_vars['left_menu'] )): ?>
        <?php echo $this->_tpl_vars['left_menu']; ?>

    <?php endif; ?>
</div>
<?php endif; ?>

<div id="admin_main_content" class="border_1">
        <!-- start main content -->
   <?php echo $this->_tpl_vars['my_main']['my_main_content']; ?>

        <!-- end main content -->
</div>

<!-- start bottom -->
<div class="page_bottom">
  <p class="body_text" align="center">
    	Copyright 2000-<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
 &copy; Kinful.com.  All rights reserved.<br>
      Kinful CMS is Free Software released under the GNU/GPL License.<br>
  </p>
</div>
<!-- end bottom -->
</body>
</html>
