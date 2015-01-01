<?php /* Smarty version 2.6.6, created on 2009-10-15 11:23:05
         compiled from common/displayUserInfo.php */ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
  <TBODY>
    <tr>
      <TD style="PADDING-BOTTOM: 10px" vAlign=top>当前算命者信息 (<font color="#FF0000">右侧菜单查看详细</font>)</TD>
    </tr>
    <tr>
      <TD style="PADDING-BOTTOM: 8px" vAlign=top>姓名:<font color="#FF0000"><?php echo $this->_tpl_vars['xing'];  echo $this->_tpl_vars['ming']; ?>
</font> 性别:<?php echo $this->_tpl_vars['xingbie']; ?>

          <?php if (( $this->_tpl_vars['xuexing'] <> '' )): ?>
血型:<?php echo $this->_tpl_vars['xuexing']; ?>
 
          <?php endif; ?>
出生:<font color="#0000ff"><?php echo $this->_tpl_vars['nian1']; ?>
年<?php echo $this->_tpl_vars['yue1']; ?>
月<?php echo $this->_tpl_vars['ri1']; ?>
日<?php echo $this->_tpl_vars['hh1']; ?>
时<?php echo $this->_tpl_vars['mm1']; ?>
分</font> 今年<?php echo $this->_tpl_vars['_thisYear']-$this->_tpl_vars['nian1']; ?>
岁 属相:<?php echo $this->_tpl_vars['sx']; ?>
&nbsp;星座:<?php echo $this->_tpl_vars['xingzuo']; ?>
&nbsp;
<input name="button2" type="button" class="button" style="cursor:hand;COLOR: #ff0000;FONT-WEIGHT: bold;" onClick="(location='?clearCookie')" value="重新测算" />
     </TD>
    </tr>
  </TBODY>
</TABLE>