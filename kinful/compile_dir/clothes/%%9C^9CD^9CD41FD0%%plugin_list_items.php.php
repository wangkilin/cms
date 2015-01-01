<?php /* Smarty version 2.6.6, created on 2010-08-25 06:07:11
         compiled from plugin_list_items.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'plugin_list_items.php', 6, false),array('function', 'cycle', 'plugin_list_items.php', 23, false),array('function', 'my_print_item', 'plugin_list_items.php', 30, false),array('function', 'my_print_item_menu', 'plugin_list_items.php', 37, false),)), $this); ?>
<?php if ($this->_tpl_vars['container'] && $this->_tpl_vars['container']['pool']): ?>
<div <?php if ($this->_tpl_vars['container']['pool']['class']): ?>class="<?php echo $this->_tpl_vars['container']['pool']['class']; ?>
"<?php endif; ?>>
    <?php if ($this->_tpl_vars['container']['header']): ?>
    <div <?php if ($this->_tpl_vars['container']['header']['class']): ?>class="<?php echo $this->_tpl_vars['container']['header']['class']; ?>
"<?php endif; ?>>
        <?php if ($this->_tpl_vars['itemHeader']): ?>
        <?php echo smarty_function_counter(array('start' => -1,'skip' => 1,'print' => false), $this);?>

        <?php if (count($_from = (array)$this->_tpl_vars['itemHeader'])):
    foreach ($_from as $this->_tpl_vars['item']):
?>
        <p class="<?php if ($this->_tpl_vars['container']['subItem']['class']):  echo $this->_tpl_vars['container']['subItem']['class'];  endif; ?> LIST_<?php echo smarty_function_counter(array(), $this);?>
"><?php echo $this->_tpl_vars['item']; ?>
</p>
        <?php endforeach; unset($_from); endif; ?>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['itemMenu']): ?>
        <?php if (count($_from = (array)$this->_tpl_vars['itemMenu'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <p class="<?php if ($this->_tpl_vars['container']['subItem']['class']):  echo $this->_tpl_vars['container']['subItem']['class'];  endif; ?> <?php if ($this->_tpl_vars['item']['class']):  echo $this->_tpl_vars['item']['class'];  endif; ?>">
          <?php echo $this->_tpl_vars['key']; ?>

        </p>
        <?php endforeach; unset($_from); endif; ?>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['items'] && $this->_tpl_vars['listKeys']): ?>
    <?php if (count($_from = (array)$this->_tpl_vars['items'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <div class='<?php if ($this->_tpl_vars['container']['item']['class']):  echo $this->_tpl_vars['container']['item']['class'];  endif; ?> <?php echo smarty_function_cycle(array('values' => "itemOddLine,itemEvenLine"), $this);?>
'>
        <?php echo smarty_function_counter(array('start' => 0,'skip' => 1,'print' => false), $this);?>

        <p class="subItem LIST_0">
          <?php echo $this->_tpl_vars['numberOfPerPage']*$this->_tpl_vars['currentPage']-$this->_tpl_vars['numberOfPerPage']+$this->_tpl_vars['key']+1; ?>

        </p>
        <?php if (count($_from = (array)$this->_tpl_vars['listKeys'])):
    foreach ($_from as $this->_tpl_vars['listKey']):
?>
        <p class="subItem LIST_<?php echo smarty_function_counter(array(), $this);?>
">
          <?php echo MY_listItemsInTpl::my_print_item(array('listKey' => $this->_tpl_vars['listKey'],'item' => $this->_tpl_vars['item']), $this);?>

        </p>
        <?php endforeach; unset($_from); endif; ?>

        <?php if ($this->_tpl_vars['itemMenu']): ?>
        <?php if (count($_from = (array)$this->_tpl_vars['itemMenu'])):
    foreach ($_from as $this->_tpl_vars['menuKey'] => $this->_tpl_vars['menuOption']):
?>
        <p class="<?php if ($this->_tpl_vars['container']['subItem']['class']):  echo $this->_tpl_vars['container']['subItem']['class'];  endif; ?> <?php if ($this->_tpl_vars['item']['class']):  echo $this->_tpl_vars['item']['class'];  endif; ?>">
            <?php echo MY_listItemsInTpl::my_print_item_menu(array('menuKey' => $this->_tpl_vars['menuKey'],'menuOption' => $this->_tpl_vars['menuOption'],'item' => $this->_tpl_vars['item']), $this);?>

        </p>
        <?php endforeach; unset($_from); endif; ?>
        <?php endif; ?>
    </div>
    <?php endforeach; unset($_from); endif; ?>
    <?php else: ?>
    <div>
        there is no item to display!
    </div>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['totalItemNumber']): ?>
      <?php if ($this->_tpl_vars['enablePageGuide'] && $this->_tpl_vars['currentPage'] && $this->_tpl_vars['totalPage'] && $this->_tpl_vars['pageLink']): ?>
        <div class="itemPage">
        <?php if ($this->_tpl_vars['currentPage'] > 1): ?>
          <a href="<?php echo $this->_tpl_vars['pageLink']; ?>
&page=1"><?php echo $this->_tpl_vars['language']['first_page']; ?>
</a>
          <a href="<?php echo $this->_tpl_vars['pageLink']; ?>
&page=<?php echo $this->_tpl_vars['currentPage']-1; ?>
"><?php echo $this->_tpl_vars['language']['pre_page']; ?>
</a>
        <?php else: ?>
          <?php echo $this->_tpl_vars['language']['first_page']; ?>

          <?php echo $this->_tpl_vars['language']['pre_page']; ?>

        <?php endif; ?>
        <?php echo $this->_tpl_vars['currentPage']; ?>

        <?php if ($this->_tpl_vars['currentPage'] < $this->_tpl_vars['totalPage']): ?>
          <a href="<?php echo $this->_tpl_vars['pageLink']; ?>
&page=<?php echo $this->_tpl_vars['currentPage']+1; ?>
"><?php echo $this->_tpl_vars['language']['next_page']; ?>
</a>
          <a href="<?php echo $this->_tpl_vars['pageLink']; ?>
&page=<?php echo $this->_tpl_vars['totalPage']; ?>
"><?php echo $this->_tpl_vars['language']['last_page']; ?>
</a>
        <?php else: ?>
          <?php echo $this->_tpl_vars['language']['next_page']; ?>

          <?php echo $this->_tpl_vars['language']['last_page']; ?>

        <?php endif; ?>
        <?php echo $this->_tpl_vars['language']['jump_to']; ?>
<input type="text" size=3 id="____page"><?php echo $this->_tpl_vars['language']['page']; ?>

        <input type='hidden' id='____itemTotalPage' page='<?php echo $this->_tpl_vars['totalPage']; ?>
'>
        </div>
      <?php endif; ?>

      <?php if ($this->_tpl_vars['enableSelectNumberForPage']): ?>
        <div class="itemNumberForPage">
            <?php echo $this->_tpl_vars['language']['number_per_page']; ?>
<select name="number_per_page">
              <?php if (count($_from = (array)$this->_tpl_vars['numberListPerPage'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['numberPerPageIndex']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
              <?php endforeach; unset($_from); endif; ?>
            </select><?php echo $this->_tpl_vars['language']['item']; ?>

            <?php echo $this->_tpl_vars['language']['total_number'];  echo $this->_tpl_vars['totalItemNumber'];  echo $this->_tpl_vars['language']['item']; ?>

        </div>
      <?php endif; ?>
    <?php endif; ?>
</div>
<?php endif; ?>
<script language="JavaScript">
<!--
(function($){
    $('#____page').live('click', function(){
        $(this).attr('name', 'page');
    });
    $('#____page').blur(function(){
        $(this).removeAttr('name');
    });
})(jQuery);
//-->
</script>