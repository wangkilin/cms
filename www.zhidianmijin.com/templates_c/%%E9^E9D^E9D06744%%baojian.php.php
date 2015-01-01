<?php /* Smarty version 2.6.6, created on 2009-06-15 06:43:39
         compiled from astro/baojian.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'selectStepOptions', 'astro/baojian.php', 10, false),array('modifier', 'cat', 'astro/baojian.php', 21, false),array('modifier', 'Constellation', 'astro/baojian.php', 21, false),)), $this); ?>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
      <tr>
        <TD align="left" class=new style="PADDING-BOTTOM: 1px">
<?php if (( $this->_tpl_vars['xing'] <> "" )): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/astroIndexLink.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>查询我的星座:
    <form action="" method="post"><select name="y" size="1" id="y" style="font-size: 9pt"> 
           <?php echo selectStepOptions(array('start' => 1900,'end' => $this->_tpl_vars['_thisYear'],'selected' => 1980), $this);?>

          </select>
年
<select name="m" size="1" id="m" style="font-size: 9pt">
  <?php echo selectStepOptions(array('start' => 1,'end' => 12,'selected' => $this->_tpl_vars['_thisMonth']), $this);?>

</select>
月
<select name="d" size="1" id="d" style="font-size: 9pt">
  <?php echo selectStepOptions(array('start' => 1,'end' => 31,'selected' => $this->_tpl_vars['_thisDay']), $this);?>

</select>
日(公历生日)
<input name="Input2" type="submit" value="查询" class="bot01"   /><input name="act" type="hidden" value="xzcx"><?php if (( isset ( $_REQUEST['act'] ) && $_REQUEST['act'] == 'xzcx' )): ?>&nbsp;查询结果:<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$_REQUEST['y'])) ? $this->_run_mod_handler('cat', true, $_tmp, "-") : smarty_modifier_cat($_tmp, "-")))) ? $this->_run_mod_handler('cat', true, $_tmp, $_REQUEST['m']) : smarty_modifier_cat($_tmp, $_REQUEST['m'])))) ? $this->_run_mod_handler('cat', true, $_tmp, "-") : smarty_modifier_cat($_tmp, "-")))) ? $this->_run_mod_handler('cat', true, $_tmp, $_REQUEST['d']) : smarty_modifier_cat($_tmp, $_REQUEST['d'])))) ? $this->_run_mod_handler('Constellation', true, $_tmp) : Constellation($_tmp)); ?>
</form>
<?php endif;  endif; ?></TD>
      </tr>
      <tr>
        <TD align="left" class=new style="PADDING-BOTTOM: 1px"><span class="red">星座详解</span>·<a href="?m=2&sm=1&flag=4&astro=白羊座">牡羊座</a>·<a href="?m=2&sm=1&flag=4&astro=金牛座">金牛座</a>·<a href="?m=2&sm=1&flag=4&astro=双子座">双子座</a>·<a href="?m=2&sm=1&flag=4&astro=巨蟹座">巨蟹座</a>·<a href="?m=2&sm=1&flag=4&astro=狮子座">狮子座</a>·<a href="?m=2&sm=1&flag=4&astro=处女座">处女座</a>·<a href="?m=2&sm=1&flag=4&astro=天秤座">天秤座</a>·<a href="?m=2&sm=1&flag=4&astro=天蝎座">天蝎座</a>·<a href="?m=2&sm=1&flag=4&astro=射手座">射手座</a>·<a href="?m=2&sm=1&flag=4&astro=魔羯座">魔羯座</a>·<a href="?m=2&sm=1&flag=4&astro=水瓶座">水瓶座</a>·<a href="?m=2&sm=1&flag=4&astro=双鱼座">双鱼座</a></TD>
      </tr>
    </TBODY>
  </TABLE>
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <tbody>
      <tr>
        <td width="100%" class="ttop"><?php echo $this->_tpl_vars['myxz']; ?>
之身体保健</td>
      </tr>
      <tr>
        <td class=new style="PADDING-BOTTOM: 1px" vAlign=top><?php echo $this->_tpl_vars['content']; ?>
</td>
      </tr>
         </tbody>
  </table>