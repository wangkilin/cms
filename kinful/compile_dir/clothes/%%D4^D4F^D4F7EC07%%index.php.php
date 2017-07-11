<?php /* Smarty version 2.6.6, created on 2010-10-23 14:01:30
         compiled from index.php */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->_tpl_vars['site_config']['site_name']; ?>
</title>
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<table id="container" align="center" cellpadding="0" cellspacing="0">
<tr>
<td class="leftBorder">
</td>
<td>
<table id="mainHead" class="blockTable" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200px">
    <?php if ($this->_tpl_vars['logo']): ?>
    <div id="logo">
            <?php echo $this->_tpl_vars['logo']['0']; ?>

    </div>
    <?php endif; ?>
	</td>
	<td id="mainBanner"></td>
  </tr>
</table>
<table id="mainHeadMenu2" class="blockTable" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
    <div id="domainZone" class="blockFloatLeft">WWW.KINFUL.COM</div>
    <?php if ($this->_tpl_vars['head_menu']): ?>
    <div id="head_menu">
        <?php if (is_array ( $this->_tpl_vars['head_menu'] ) === true): ?>
            <?php if (count($_from = (array)$this->_tpl_vars['head_menu'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <div id="head_menu_<?php echo $this->_tpl_vars['key']; ?>
">
                <?php echo $this->_tpl_vars['item']; ?>

                </div>
            <?php endforeach; unset($_from); endif; ?>
        <?php elseif (is_string ( $this->_tpl_vars['head_menu'] )): ?>
            <?php echo $this->_tpl_vars['head_menu']; ?>

        <?php endif; ?>
    </div>
    <?php endif; ?>
	</td>
  </tr>
</table>
<table id="menuLine" class="blockTable" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>
<table id="mainHeadMenu" class="blockTable" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	  <table class="blockWidth100">
	    <tr>
		  <td>菜单</td>
		  <td>菜单</td>
		  <td>菜单</td>
		  <td>菜单</td>
		  <td>菜单</td>
		  <td>菜单</td>
		</tr>
      </table>
	</td>
  </tr>
</table>

<table id="mainBody" class="blockTable" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td id="left_block">
    <?php if ($this->_tpl_vars['left_block']): ?>
        <?php if (is_array ( $this->_tpl_vars['left_block'] ) === true): ?>
            <?php if (count($_from = (array)$this->_tpl_vars['left_block'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <div id="left_block_<?php echo $this->_tpl_vars['key']; ?>
">
                <?php echo $this->_tpl_vars['item']; ?>

                </div>
            <?php endforeach; unset($_from); endif; ?>
        <?php elseif (is_string ( $this->_tpl_vars['left_block'] )): ?>
            <?php echo $this->_tpl_vars['left_block']; ?>

        <?php endif; ?>
    <?php endif; ?>
	</td>
	<td id="mainContent">
      <?php if ($this->_tpl_vars['my_main']): ?>
        <div id="my_main_content">
        <?php echo $this->_tpl_vars['my_main']['my_main_content']; ?>

        </div>
      <?php endif; ?>
	</td>
  </tr>
</table>

<table id="mainBodyBanner" class="blockTable" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	</td>
  </tr>
</table>

<table id="mainFoot" class="blockTable" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	</td>
  </tr>
</table>

<table id="pageBottom" class="blockTable" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	</td>
  </tr>
</table>
</td>
<td class="rightBorder">
</td>
</tr>
</table>
</body>
</html>