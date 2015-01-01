<?php /* Smarty version 2.6.6, created on 2010-07-26 10:04:45
         compiled from index.php */ ?>
<?php if (( $this->_tpl_vars['xing'] <> '' )): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/crackBorder.php", 'smarty_include_vars' => array('includePage' => 'common/displayUserInfo.php')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/crackBorder.php", 'smarty_include_vars' => array('includePage' => 'common/enterAllInfoForm.php')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
  <TBODY>   <tr>
      <TD class=ttop style="PADDING-BOTTOM: 1px" vAlign=top>今日黄历 &nbsp; <a href="?m=6&sm=6&yy=<?php echo $this->_tpl_vars['_thisYear']; ?>
&mm=<?php echo $this->_tpl_vars['_thisMonth']; ?>
&dd=<?php echo $this->_tpl_vars['_thisDay']; ?>
&act=crz">详细内容</a></TD>
    </tr> 
    <tr>
      <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><font color=red><?php echo $this->_tpl_vars['_nowDate']; ?>
</font> <?php echo $this->_tpl_vars['nn']; ?>
  <?php echo $this->_tpl_vars['weeklyInfo'][$this->_tpl_vars['rs']['xq']]; ?>
 <?php echo $this->_tpl_vars['suici']; ?>
 <font color=red><?php echo $this->_tpl_vars['cong']; ?>
</font></TD>
    </tr>
    <tr>
      <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><strong>宜</strong> <font color=red> <?php echo $this->_tpl_vars['yi']; ?>
</font></TD>
    </tr>
    <tr>
      <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><strong>忌</strong> <font color=blue> <?php echo $this->_tpl_vars['ji']; ?>
 </font></TD>
    </tr>
  </TBODY>
</TABLE>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
  <TBODY>
    <tr>
      <TD class=new style="PADDING-BOTTOM: 8px" vAlign=top>
         <script type="text/javascript"> 
        alimama_pid="mm_13920027_1973813_8523667"; 
        alimama_type="f";
        alimama_sizecode ="tl_3x4_12"; 
        alimama_fontsize=12; 
        alimama_bordercolor="FFFFFF"; 
        alimama_bgcolor="F8F5E6"; 
        alimama_titlecolor="553300"; 
        alimama_underline=0; 
        alimama_height=62; 
        alimama_width=670; 
        </script> 
        <script src="http://a.alimama.cn/inf.js" type="text/javascript"> 
        </script>
       </TD>
    </tr>
  </TBODY>
</TABLE>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
  <TBODY>
    <tr>
      <TD class=new style="PADDING-BOTTOM: 8px" vAlign=top><p class="red">免费在线算命测算项目： 
        </p>
        <p>指点迷津算命系统目前可以进行：姓名测试、姓氏起源、周公解梦、号码吉凶分析、每日运程、今日命理、今日运程、本周运程、本月运程、本年运程、心理测试、婚姻试配、属相配对、事业测试、爱情测试、财运测试、观音灵签（观音神签）、吕祖灵签、诸葛神算（诸葛神签、诸葛灵签）、关公灵签、塔罗占卜、黄历查询、EQ测试、个性、情绪测试、人际关系、特性、心灵成长、性格、特性破解、优缺点、心智、休闲、大师点拨、为人父母、身为子女、小建议、在线抽签、生日密码、身体保健、血型属相、血型特性、星座运程、星座名人、星座分析、生男生女、指纹测算、八字分析、称骨论命、上辈为人、星相命理、八字排盘、眼跳预测、耳鸣预测、面热预测、喷嚏预测、心惊预测等与您命运休戚相关的内容。 </p>
       </TD>
    </tr>
  </TBODY>
</TABLE>
