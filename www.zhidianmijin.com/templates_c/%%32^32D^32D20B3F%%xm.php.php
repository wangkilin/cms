<?php /* Smarty version 2.6.6, created on 2009-07-03 14:22:03
         compiled from sm/xm.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'GbToBig', 'sm/xm.php', 16, false),array('modifier', 'c', 'sm/xm.php', 17, false),array('modifier', 'getzywh', 'sm/xm.php', 19, false),array('modifier', 'getsancai', 'sm/xm.php', 43, false),)), $this); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">  
  <tbody>
    <tr>
      <td colspan="5" bgcolor="#FFFFFF"><table height='100%' width="100%" border="0" cellpadding="0" cellspacing="0"  style="border:1px 0 1px 0; table-layout:fixed;word-wrap:break-word;">
        <tbody>
          <tr>
            <td bgcolor="#FFFFFF"></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">繁体</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">拼音</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">康熙笔划</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">字意五行</font></td>
            </tr>
          <tr>
            <td  align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['xing1']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['xing1'])) ? $this->_run_mod_handler('GbToBig', true, $_tmp) : GbToBig($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['xing1'])) ? $this->_run_mod_handler('c', true, $_tmp) : c($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['bihua1']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo ((is_array($_tmp=$this->_tpl_vars['xing11'])) ? $this->_run_mod_handler('getzywh', true, $_tmp) : getzywh($_tmp)); ?>
</td>
          </tr>
          <tr>
         <?php if (( $this->_tpl_vars['xing22'] <> "" )): ?>   <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['xing2']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['xing2'])) ? $this->_run_mod_handler('GbToBig', true, $_tmp) : GbToBig($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['xing22'])) ? $this->_run_mod_handler('c', true, $_tmp) : c($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['bihua2']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo ((is_array($_tmp=$this->_tpl_vars['xing22'])) ? $this->_run_mod_handler('getzywh', true, $_tmp) : getzywh($_tmp)); ?>
</td>
          </tr><?php endif; ?>
          <tr>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['ming1']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['ming1'])) ? $this->_run_mod_handler('GbToBig', true, $_tmp) : GbToBig($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['ming1'])) ? $this->_run_mod_handler('c', true, $_tmp) : c($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['bihua3']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo ((is_array($_tmp=$this->_tpl_vars['ming11'])) ? $this->_run_mod_handler('getzywh', true, $_tmp) : getzywh($_tmp)); ?>
</td>
          </tr>
          <?php if (( $this->_tpl_vars['ming22'] <> "" )): ?><tr>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['ming2']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['ming2'])) ? $this->_run_mod_handler('GbToBig', true, $_tmp) : GbToBig($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['ming22'])) ? $this->_run_mod_handler('c', true, $_tmp) : c($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['bihua4']; ?>
</td><td align="center" bgcolor="#FFFFFF" class="new2"><?php echo ((is_array($_tmp=$this->_tpl_vars['ming22'])) ? $this->_run_mod_handler('getzywh', true, $_tmp) : getzywh($_tmp)); ?>
</td>
          </tr><?php endif; ?>
        </tbody>
      </table></td>
      <td width="25%"  class="new2" align="center" bgcolor="#FFFFFF">天格-&gt; <?php echo $this->_tpl_vars['tiange']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['tiange'])) ? $this->_run_mod_handler('getsancai', true, $_tmp) : getsancai($_tmp)); ?>
)<br />
      <p>人格-&gt; <?php echo $this->_tpl_vars['renge']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['renge'])) ? $this->_run_mod_handler('getsancai', true, $_tmp) : getsancai($_tmp)); ?>
)</p>        <p>地格-&gt; <?php echo $this->_tpl_vars['dige']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['dige'])) ? $this->_run_mod_handler('getsancai', true, $_tmp) : getsancai($_tmp)); ?>
)</p></td>
      <td width="25%"  class="new2" align="center" bgcolor="#FFFFFF">外格-&gt; <?php echo $this->_tpl_vars['waige']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['waige'])) ? $this->_run_mod_handler('getsancai', true, $_tmp) : getsancai($_tmp)); ?>
)<br />
      <p>　</p>        <p>总格-&gt; <?php echo $this->_tpl_vars['zhongge']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['zhongge'])) ? $this->_run_mod_handler('getsancai', true, $_tmp) : getsancai($_tmp)); ?>
)</p></td>
    </tr>
  </tbody>
</table><table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
      <tr>
        <TD class=ttd><p><font color="#0000FF">天格<?php echo $this->_tpl_vars['tiangee']; ?>
的解析：</font><font color="#ff0000">天格数是先祖留传下来的，其数理对人影响不大。</font>
</TD>
      </tr>
<tr>
        <TD class=ttd>
<?php echo $this->_tpl_vars['tgyy']; ?>
&nbsp;<font color=red>(<?php echo $this->_tpl_vars['tgjx']; ?>
)</font></TD>
      </tr> <tr>
        <TD class=ttd>→ 详细解释：
<br />
<?php echo $this->_tpl_vars['tgxx']; ?>
</TD>
      </tr>      <tr>
        <TD class=ttd><p><font color="#0000FF">人格<?php echo $this->_tpl_vars['rengee']; ?>
的解析：</font><font color="#ff0000">人格数又称主运，是整个姓名的中心点，影响人的一生命运。</font>
</TD>
      </tr>
 <tr>
        <TD class=ttd>
<?php echo $this->_tpl_vars['rgyy']; ?>
&nbsp;<font color=red>(<?php echo $this->_tpl_vars['rgjx']; ?>
)</font></TD>
      </tr> <tr>
        <TD class=ttd>→ 详细解释：
<br />
<?php echo $this->_tpl_vars['rgxx']; ?>
</TD>
      </tr>  <tr>
        <TD class=ttd><p><font color="#0000FF">地格<?php echo $this->_tpl_vars['digee']; ?>
的解析：</font><font color="#ff0000">地格数又称前运，影响人中年（36岁）以前的活动力。</font>
</TD>
      </tr> 
<tr>
        <TD class=ttd>
<?php echo $this->_tpl_vars['dgyy']; ?>
&nbsp;<font color=red>(<?php echo $this->_tpl_vars['dgjx']; ?>
)</font></TD>
      </tr> <tr>
        <TD class=ttd>→ 详细解释：
<br />
<?php echo $this->_tpl_vars['dgxx']; ?>
</TD>
      </tr> <tr>
        <TD class=ttd><p><font color="#0000FF">总格<?php echo $this->_tpl_vars['zhonggee']; ?>
的解析：</font><font color="#ff0000">总格又称后运，影响人中年（36岁）以后的命运。</font>
</TD>
      </tr> 
<tr>
        <TD class=ttd>
<?php echo $this->_tpl_vars['zgyy']; ?>
&nbsp;<font color=red>(<?php echo $this->_tpl_vars['zgjx']; ?>
)</font></TD>
      </tr> <tr>
        <TD class=ttd>→ 详细解释：
<br />
<?php echo $this->_tpl_vars['zgxx']; ?>
</TD>
      </tr> <tr>
        <TD class=ttd><p><font color="#0000FF">外格<?php echo $this->_tpl_vars['waigee']; ?>
的解析：</font><font color="#ff0000">外格又称变格，影响人的社交能力、智慧等，其数理不用重点去看。</font>
</TD>
      </tr> 
 <tr>
        <TD class=ttd>
<?php echo $this->_tpl_vars['wgyy']; ?>
&nbsp;<font color=red>(<?php echo $this->_tpl_vars['wgjx']; ?>
)</font></TD>
      </tr> <tr>
        <TD class=new>→ 详细解释：
<br />
<?php echo $this->_tpl_vars['wgxx']; ?>
</TD>
      </tr>
    </TBODY>
</TABLE>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
      <tr>
        <TD class=ttd>

<font color="#0000FF">对三才数理的影响:</font> 您的姓名三才配置为：<font color="#ff0000"><?php echo $this->_tpl_vars['sancai']; ?>
</font>。它具有如下数理诱导力，据此会对人生产生一定的影响。</TD>
      </tr><tr><td class=ttd><?php echo $this->_tpl_vars['scyy']; ?>
 (<?php echo $this->_tpl_vars['scjx']; ?>
)
</td></tr><tr><td class=new><?php echo $this->_tpl_vars['sancaicontent']; ?>

</td></tr>
    </TBODY>
</TABLE>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
      <tr>
        <TD width="24%" class=ttd>
<font color="#0000FF">对基础运的影响:</font></TD>
        <TD width="76%" class=ttd><?php echo $this->_tpl_vars['jcy']; ?>
 <?php echo $this->_tpl_vars['jcyjx']; ?>
</TD>
      </tr><tr><td class=ttd>
<font color="#0000FF">对成功运的影响:</font></td>
        <td class=ttd><?php echo $this->_tpl_vars['cgy']; ?>
 <?php echo $this->_tpl_vars['cgyjx']; ?>
</td>
      </tr>
      <tr><td class=ttd>
<font color="#0000FF">对人际关系的影响:</font></td>
        <td class=ttd><?php echo $this->_tpl_vars['rjgx']; ?>
 <?php echo $this->_tpl_vars['rjgxjx']; ?>
</td>
      </tr><tr><td class=new>
<font color="#0000FF">对性格的影响:</font></td>
        <td class=new><?php echo $this->_tpl_vars['xg']; ?>
</td>
      </tr>
    </TBODY>
</TABLE><table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
      <tr>
        <TD width="24%" class=ttd>
<font color="#0000FF">人格<?php echo $this->_tpl_vars['rengee']; ?>
有以下数理暗示:</font></TD>
        <TD width="76%" class=ttd><?php echo $this->_tpl_vars['rgas']; ?>
</TD>
      </tr><tr><td class=ttd>
<font color="#0000FF">地格<?php echo $this->_tpl_vars['digee']; ?>
有以下数理暗示:</font></td>
        <td class=ttd><?php echo $this->_tpl_vars['dgas']; ?>
</td>
      </tr>
      <tr><td class=ttd>
<font color="#0000FF">总格<?php echo $this->_tpl_vars['zhonggee']; ?>
有以下数理暗示:</font></td>
        <td class=ttd><?php echo $this->_tpl_vars['zgas']; ?>
</td>
      </tr><tr><td class=new>
<font color="#0000FF">地格<?php echo $this->_tpl_vars['waigee']; ?>
有以下数理暗示:</font></td>
        <td class=new><?php echo $this->_tpl_vars['wgas']; ?>
</td>
      </tr>
    </TBODY>
</TABLE><table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
      <tr>

        <TD width="67%" class=new>总评及建议：<br /><br />
          <?php if (( $this->_tpl_vars['xmdf'] < 60 )): ?>你的名字可能不是很好。强烈建议你换个名字试试，也许人生会因此而改变的。
		<?php elseif (( $this->_tpl_vars['xmdf'] < 70 && $this->_tpl_vars['xmdf'] >= 60 )): ?>
		你的名字可能不太好，如果可能的话，不妨尝试改变一下，也许会有事半功倍之效。
		<?php elseif (( $this->_tpl_vars['xmdf'] < 80 && $this->_tpl_vars['xmdf'] >= 70 )): ?>你的名字可能不太理想，要想赢得成功，必须比别人付出更多的艰辛和汗水。如果有条件，改个名字也未尝不可。
		<?php elseif (( $this->_tpl_vars['xmdf'] < 80 && $this->_tpl_vars['xmdf'] >= 70 )): ?>你的名字一般。虽然人生路途中会遇到一些困难，但只要努力，还是会有很多收获的。如果有条件，改个名字也未尝不可。
		<?php elseif (( $this->_tpl_vars['xmdf'] < 90 && $this->_tpl_vars['xmdf'] >= 80 )): ?>
		你的名字取得不错，如果与命理搭配得当，相信它会助你一生顺利的，祝你好运！
		<?php elseif (( $this->_tpl_vars['xmdf'] >= 90 )): ?>
		你的名字取得非常棒，如果与命理搭配得当，成功与惊喜将会伴随你的一生。但千万注意不要失去上进心。<?php endif; ?>
		<br><br>
		姓名五格评分：</font><span class=pf><?php echo $this->_tpl_vars['xmdf']; ?>
分</span> </TD>
      </tr>
    </TBODY>
</TABLE>