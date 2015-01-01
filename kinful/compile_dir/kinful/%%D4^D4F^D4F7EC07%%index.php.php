<?php /* Smarty version 2.6.6, created on 2010-09-24 05:39:40
         compiled from index.php */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE><?php echo $this->_tpl_vars['site_config']['site_name']; ?>
</TITLE>
<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="TEXT/HTML; CHARSET=UTF-8"/>
<link href="kinful/web/css/index.css" type=text/css rel=stylesheet>
<?php if ($this->_tpl_vars['MY_MODULE_NAME']): ?>
<link href="kinful/web/css/module_<?php echo $this->_tpl_vars['MY_MODULE_NAME']; ?>
.css" type=text/css rel=stylesheet>
<?php endif; ?>
<link rel="shortcut icon" href="kinful/web/image/favicon.ico" />
<script type="text/javascript" src="kinful/web/js/jquery.min.js"></script>
<script type="text/javascript"  src="kinful/web/js/jquery-ui.min.js"></script>
<script type="text/javascript"  src="kinful/web/js/kinful.js"></script>
</HEAD>

<BODY style="background:#f5f5f5">
<?php if ($this->_tpl_vars['top_menu']): ?>
<table id="top_menu">
  <tr>
    <td>
    <?php if (is_array ( $this->_tpl_vars['top_menu'] ) === true): ?>
        <?php if (count($_from = (array)$this->_tpl_vars['top_menu'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
            <div id="top_menu_<?php echo $this->_tpl_vars['key']; ?>
">
            <?php echo $this->_tpl_vars['item']; ?>

            </div>
        <?php endforeach; unset($_from); endif; ?>
    <?php elseif (is_string ( $this->_tpl_vars['top_menu'] )): ?>
        <?php echo $this->_tpl_vars['top_menu']; ?>

    <?php endif; ?>
    </td>
  </tr>
</table>
<?php endif; ?>

<?php if (( $this->_tpl_vars['logo'] || $this->_tpl_vars['banner'] || $this->_tpl_vars['banner_right'] || $this->_tpl_vars['head_menu'] )): ?>
<table class="head_content">
  <tr>
    <?php if ($this->_tpl_vars['logo']): ?>
    <td id="logo">
        <?php if (is_array ( $this->_tpl_vars['logo'] ) === true): ?>
            <?php if (count($_from = (array)$this->_tpl_vars['logo'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <div id="logo_<?php echo $this->_tpl_vars['key']; ?>
">
                <?php echo $this->_tpl_vars['item']; ?>

                </div>
            <?php endforeach; unset($_from); endif; ?>
        <?php elseif (is_string ( $this->_tpl_vars['logo'] )): ?>
            <?php echo $this->_tpl_vars['logo']; ?>

        <?php endif; ?>
    </td>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['banner']): ?>
    <td id="banner">
        <?php if (is_array ( $this->_tpl_vars['banner'] ) === true): ?>
            <?php if (count($_from = (array)$this->_tpl_vars['banner'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <div id="banner_<?php echo $this->_tpl_vars['key']; ?>
">
                <?php echo $this->_tpl_vars['item']; ?>

                </div>
            <?php endforeach; unset($_from); endif; ?>
        <?php elseif (is_string ( $this->_tpl_vars['banner'] )): ?>
            <?php echo $this->_tpl_vars['banner']; ?>

        <?php endif; ?>
    </td>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['banner_right']): ?>
    <td id="banner_right">
        <?php if (is_array ( $this->_tpl_vars['banner_right'] ) === true): ?>
            <?php if (count($_from = (array)$this->_tpl_vars['banner_right'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <div id="banner_right_<?php echo $this->_tpl_vars['key']; ?>
">
                <?php echo $this->_tpl_vars['item']; ?>

                </div>
            <?php endforeach; unset($_from); endif; ?>
        <?php elseif (is_string ( $this->_tpl_vars['banner_right'] )): ?>
            <?php echo $this->_tpl_vars['banner_right']; ?>

        <?php endif; ?>
    </td>
    <?php endif; ?>
  </tr>
</table>
<?php endif; ?>


<?php if ($this->_tpl_vars['head_menu']): ?>
<table id="head_menu">
  <tr>
    <td>
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
    </td>
  </tr>
</table>
<?php endif; ?>


<?php if (( $this->_tpl_vars['left_menu'] || $this->_tpl_vars['left_block'] || $this->_tpl_vars['body_content'] || $this->_tpl_vars['right_menu'] || $this->_tpl_vars['right_block'] || $this->_tpl_vars['my_main'] )): ?>
<table>
  <tr>
  <?php if (( $this->_tpl_vars['left_menu'] || $this->_tpl_vars['left_block'] )): ?>
    <td class="left_content">
    <?php if ($this->_tpl_vars['left_menu']): ?>
    <div id="left_menu">
        <?php if (is_array ( $this->_tpl_vars['left_menu'] ) === true): ?>
            <?php if (count($_from = (array)$this->_tpl_vars['left_menu'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <div id="left_menu_<?php echo $this->_tpl_vars['key']; ?>
">
                <?php echo $this->_tpl_vars['item']; ?>

                </div>
            <?php endforeach; unset($_from); endif; ?>
        <?php elseif (is_string ( $this->_tpl_vars['left_menu'] )): ?>
            <?php echo $this->_tpl_vars['left_menu']; ?>

        <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['left_block']): ?>
    <div id="left_block">
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
    </div>
    <?php endif; ?>
    </td>
  <?php endif; ?>

    <?php if ($this->_tpl_vars['body_content'] || $this->_tpl_vars['my_main']): ?>
    <td id="body_content">
        <?php if ($this->_tpl_vars['body_content'] && is_array ( $this->_tpl_vars['body_content'] ) === true): ?>
            <?php if (count($_from = (array)$this->_tpl_vars['body_content'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <div id="body_content_<?php echo $this->_tpl_vars['key']; ?>
">
                <?php echo $this->_tpl_vars['item']; ?>

                </div>
            <?php endforeach; unset($_from); endif; ?>
        <?php elseif ($this->_tpl_vars['body_content'] && is_string ( $this->_tpl_vars['body_content'] )): ?>
            <?php echo $this->_tpl_vars['body_content']; ?>

        <?php endif; ?>
        <?php if ($this->_tpl_vars['my_main']): ?>
            <div id="my_main_content">
            <?php echo $this->_tpl_vars['my_main']['my_main_content']; ?>

            </div>
        <?php endif; ?>
    </td>
    <?php endif; ?>
    <?php if (( $this->_tpl_vars['right_menu'] || $this->_tpl_vars['right_block'] )): ?>
    <td class="right_content">
     <?php if ($this->_tpl_vars['right_menu']): ?>
      <div id="right_menu">
        <?php if (is_array ( $this->_tpl_vars['right_menu'] ) === true): ?>
            <?php if (count($_from = (array)$this->_tpl_vars['right_menu'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <div id="right_menu_<?php echo $this->_tpl_vars['key']; ?>
">
                <?php echo $this->_tpl_vars['item']; ?>

                </div>
            <?php endforeach; unset($_from); endif; ?>
        <?php elseif (is_string ( $this->_tpl_vars['right_menu'] )): ?>
            <?php echo $this->_tpl_vars['right_menu']; ?>

        <?php endif; ?>
      </div>
     <?php endif; ?>
     <?php if ($this->_tpl_vars['right_block']): ?>
      <div id="right_block">
        <?php if (is_array ( $this->_tpl_vars['right_block'] ) === true): ?>
            <?php if (count($_from = (array)$this->_tpl_vars['right_block'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <div id="right_block_<?php echo $this->_tpl_vars['key']; ?>
">
                <?php echo $this->_tpl_vars['item']; ?>

                </div>
            <?php endforeach; unset($_from); endif; ?>
        <?php elseif (is_string ( $this->_tpl_vars['right_block'] )): ?>
            <?php echo $this->_tpl_vars['right_block']; ?>

        <?php endif; ?>
     </div>
     <?php endif; ?>
   </td>
   <?php endif; ?>
 </tr>
</table>
<?php endif; ?>

<?php if (( $this->_tpl_vars['body_banner'] )): ?>
<table class="body_banner_content">
  <tr>
    <td id="body_banner">
        <?php if (is_array ( $this->_tpl_vars['body_banner'] ) === true): ?>
            <?php if (count($_from = (array)$this->_tpl_vars['body_banner'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <div id="body_banner_<?php echo $this->_tpl_vars['key']; ?>
">
                <?php echo $this->_tpl_vars['item']; ?>

                </div>
            <?php endforeach; unset($_from); endif; ?>
        <?php elseif (is_string ( $this->_tpl_vars['body_banner'] )): ?>
            <?php echo $this->_tpl_vars['body_banner']; ?>

        <?php endif; ?>
    </td>
  </tr>
</table>
<?php endif; ?>

<?php if (( $this->_tpl_vars['bottom_menu'] )): ?>
<table class="bottom_content">
  <tr>
    <td id="bottom_menu">
        <?php if (is_array ( $this->_tpl_vars['bottom_menu'] ) === true): ?>
            <?php if (count($_from = (array)$this->_tpl_vars['bottom_menu'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <div id="bottom_menu_<?php echo $this->_tpl_vars['key']; ?>
">
                <?php echo $this->_tpl_vars['item']; ?>

                </div>
            <?php endforeach; unset($_from); endif; ?>
        <?php elseif (is_string ( $this->_tpl_vars['bottom_menu'] )): ?>
            <?php echo $this->_tpl_vars['bottom_menu']; ?>

        <?php endif; ?>
    </td>
  </tr>
</table>
<?php endif; ?>

</BODY>
</HTML>