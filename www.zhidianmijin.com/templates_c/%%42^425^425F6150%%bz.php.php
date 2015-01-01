<?php /* Smarty version 2.6.6, created on 2009-07-09 06:49:49
         compiled from sm/bz.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'layin', 'sm/bz.php', 21, false),array('modifier', 'tgdzwh', 'sm/bz.php', 21, false),array('modifier', 'siji', 'sm/bz.php', 21, false),array('modifier', 'DiZhi', 'sm/bz.php', 29, false),)), $this); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">    <tbody>
<tr>
<td  width="6%" rowspan="6" bgcolor="#FFFFFF" class="new">
<b><?php echo $this->_tpl_vars['xing1']; ?>
</b><br /><br />
<?php if (( $this->_tpl_vars['xing2'] <> "" )): ?>
  <b><?php echo $this->_tpl_vars['xing2']; ?>
</b> <br /><br />
<?php endif; ?>

<b><?php echo $this->_tpl_vars['ming1']; ?>
</b> <br /><br />
<?php if (( $this->_tpl_vars['ming2'] <> "" )): ?>
    <b><?php echo $this->_tpl_vars['ming2']; ?>
</b> <br /><br />
<?php endif; ?>
</td>
<td  width="12%" rowspan="2" bgcolor="#FFFFFF" class="new">出生时间：</td>
  <td  width="9%" bgcolor="#FFFFFF" class="new">(公历)</td>
  <td  width="12%" bgcolor="#FFFFFF" class="new"><?php echo $this->_tpl_vars['nian1']; ?>
年</td>
  <td  width="10%" bgcolor="#FFFFFF" class="new"><?php echo $this->_tpl_vars['yue1']; ?>
月</td>
  <td  width="10%" bgcolor="#FFFFFF" class="new"><?php echo $this->_tpl_vars['ri1']; ?>
日</td>
  <td  width="11%" bgcolor="#FFFFFF" class="new"><?php echo $this->_tpl_vars['hh1']; ?>
点</td>
  <td width="30%"  rowspan="6" bgcolor="#FFFFFF" class="new" style="padding-left:4px;padding-right:4px;">本命属<?php echo $this->_tpl_vars['sx']; ?>
，<?php echo ((is_array($_tmp=$this->_tpl_vars['ygz'])) ? $this->_run_mod_handler('layin', true, $_tmp) : layin($_tmp)); ?>
命。五行<?php echo $this->_tpl_vars['mainw'];  echo $this->_tpl_vars['mainq']; ?>
；日主天干为<b><?php echo ((is_array($_tmp=$this->_tpl_vars['dg1'])) ? $this->_run_mod_handler('tgdzwh', true, $_tmp) : tgdzwh($_tmp)); ?>
</b>，生于<?php echo ((is_array($_tmp=$this->_tpl_vars['yue1'])) ? $this->_run_mod_handler('siji', true, $_tmp) : siji($_tmp)); ?>
季。<br />
    （同类<?php echo $this->_tpl_vars['tnwh']; ?>
；异类<?php echo $this->_tpl_vars['ynwh']; ?>
。）<br /><hr size="1"><font color="#aaaaaa" style="font-size:12px"><img src="images/icon.gif" width="9" height="9" border="0"> 重要说明：本结果为系统自动分析，仅供参考，八字缺什么与补什么无关，具体应由专业老师分析！</font>　</td>
 </tr>
 <tr>
  <td bgcolor="#FFFFFF" class="new" >(农历)</td>
  <td bgcolor="#FFFFFF" class="new" ><?php echo $this->_tpl_vars['nian2']; ?>
年</td>
  <td bgcolor="#FFFFFF" class="new" ><?php echo $this->_tpl_vars['yue2']; ?>
月</td>
  <td bgcolor="#FFFFFF" class="new" ><?php echo $this->_tpl_vars['ri2']; ?>
日</td>
  <td bgcolor="#FFFFFF" class="new" ><?php echo ((is_array($_tmp=$this->_tpl_vars['hh2'])) ? $this->_run_mod_handler('DiZhi', true, $_tmp) : DiZhi($_tmp)); ?>
时</td>
 </tr>

 <tr>
  <td  colspan="2" bgcolor="#FFFFFF" class="new">八字：</td>
  <td bgcolor="#FFFFFF" class="new" ><?php echo $this->_tpl_vars['ygz']; ?>
　</td>
  <td bgcolor="#FFFFFF" class="new" ><?php echo $this->_tpl_vars['mgz']; ?>
　</td>
  <td bgcolor="#FFFFFF" class="new" ><?php echo $this->_tpl_vars['dgz']; ?>
　</td>
  <td bgcolor="#FFFFFF" class="new" ><?php echo $this->_tpl_vars['tgz']; ?>
　</td>
 </tr>
 <tr>
  <td  colspan="2" bgcolor="#FFFFFF" class="new">五行：</td>
  <td bgcolor="#FFFFFF" class="new" ><?php echo ((is_array($_tmp=$this->_tpl_vars['yg1'])) ? $this->_run_mod_handler('tgdzwh', true, $_tmp) : tgdzwh($_tmp));  echo ((is_array($_tmp=$this->_tpl_vars['yz1'])) ? $this->_run_mod_handler('tgdzwh', true, $_tmp) : tgdzwh($_tmp)); ?>
</td>
  <td bgcolor="#FFFFFF" class="new" ><?php echo ((is_array($_tmp=$this->_tpl_vars['mg1'])) ? $this->_run_mod_handler('tgdzwh', true, $_tmp) : tgdzwh($_tmp));  echo ((is_array($_tmp=$this->_tpl_vars['mz1'])) ? $this->_run_mod_handler('tgdzwh', true, $_tmp) : tgdzwh($_tmp)); ?>
</td>
  <td bgcolor="#FFFFFF" class="new" ><?php echo ((is_array($_tmp=$this->_tpl_vars['dg1'])) ? $this->_run_mod_handler('tgdzwh', true, $_tmp) : tgdzwh($_tmp));  echo ((is_array($_tmp=$this->_tpl_vars['dz1'])) ? $this->_run_mod_handler('tgdzwh', true, $_tmp) : tgdzwh($_tmp)); ?>
</td>
  <td bgcolor="#FFFFFF" class="new" ><?php echo ((is_array($_tmp=$this->_tpl_vars['tg1'])) ? $this->_run_mod_handler('tgdzwh', true, $_tmp) : tgdzwh($_tmp));  echo ((is_array($_tmp=$this->_tpl_vars['tz1'])) ? $this->_run_mod_handler('tgdzwh', true, $_tmp) : tgdzwh($_tmp)); ?>
</td>
 </tr>
 <tr>
  <td  colspan="2" bgcolor="#FFFFFF" class="new">纳音：</td>
  <td bgcolor="#FFFFFF" class="new" ><?php echo ((is_array($_tmp=$this->_tpl_vars['ygz'])) ? $this->_run_mod_handler('layin', true, $_tmp) : layin($_tmp)); ?>
</td>
  <td bgcolor="#FFFFFF" class="new" ><?php echo ((is_array($_tmp=$this->_tpl_vars['mgz'])) ? $this->_run_mod_handler('layin', true, $_tmp) : layin($_tmp)); ?>
</td>
  <td bgcolor="#FFFFFF" class="new" ><?php echo ((is_array($_tmp=$this->_tpl_vars['dgz'])) ? $this->_run_mod_handler('layin', true, $_tmp) : layin($_tmp)); ?>
</td>
  <td bgcolor="#FFFFFF" class="new" ><?php echo ((is_array($_tmp=$this->_tpl_vars['tgz'])) ? $this->_run_mod_handler('layin', true, $_tmp) : layin($_tmp)); ?>
</td>
 </tr>
</tbody>
</table><table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
<tr>
  <td class=new>八字五行个数 : <?php echo $this->_tpl_vars['wnum1']; ?>
个金，<?php echo $this->_tpl_vars['wnum2']; ?>
个木，<?php echo $this->_tpl_vars['wnum3']; ?>
个水，<?php echo $this->_tpl_vars['wnum4']; ?>
个火，<?php echo $this->_tpl_vars['wnum5']; ?>
个土
</td>
</tr>
    </TBODY>
</TABLE><table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
<tr>
  <td class=new>四季用神参考 : 日主天干<?php echo ((is_array($_tmp=$this->_tpl_vars['dg1'])) ? $this->_run_mod_handler('tgdzwh', true, $_tmp) : tgdzwh($_tmp)); ?>
生于<?php echo ((is_array($_tmp=$this->_tpl_vars['yue1'])) ? $this->_run_mod_handler('siji', true, $_tmp) : siji($_tmp)); ?>
季,<?php echo $this->_tpl_vars['sjrs']; ?>
。
</td>
</tr><tr>
  <td class=new>穷通宝鉴调候用神参考 : <?php echo $this->_tpl_vars['dg1'];  echo ((is_array($_tmp=$this->_tpl_vars['dg1'])) ? $this->_run_mod_handler('tgdzwh', true, $_tmp) : tgdzwh($_tmp)); ?>
生于<?php echo $this->_tpl_vars['mz1']; ?>
月，<?php echo $this->_tpl_vars['qtbj']; ?>

</td>
</tr>
    </TBODY>
</TABLE>
<table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">
  <tbody>
    <tr>
      <td  width="16%"  bgcolor="#FFFFFF" class="new">生肖个性</td>
      <td width="84%" colspan="6" bgcolor="#FFFFFF" class="new">根据分析，您的生肖为“<?php echo $this->_tpl_vars['sx']; ?>
”<br /> <?php echo $this->_tpl_vars['sxgx']; ?>
</td>
    </tr>
  </tbody>
</table><table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">
  <tbody>
    <tr>
      <td  width="16%"  bgcolor="#FFFFFF" class="new">日干心性</td>
      <td width="84%" colspan="6" bgcolor="#FFFFFF" class="new"> <?php echo $this->_tpl_vars['rgxx']; ?>
</td>
    </tr>
  </tbody>
</table><table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">
  <tbody>
    <tr>
      <td  width="16%"  bgcolor="#FFFFFF" class="new">日干支层次</td>
      <td width="84%" colspan="6" bgcolor="#FFFFFF" class="new"> <?php echo $this->_tpl_vars['rgcz']; ?>
</td>
    </tr>
  </tbody>
</table><table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">
  <tbody>
    <tr>
      <td  width="16%"  bgcolor="#FFFFFF" class="new">日干支分析</td>
      <td width="84%" colspan="6" bgcolor="#FFFFFF" class="new"> <?php echo $this->_tpl_vars['rgzfx']; ?>
<br /><font color="#cccccc">* 根据四柱预测学部分专家学者提供的资料，归纳整理，个别字句有待考证，总体准确度较高！</font></td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">    <tbody>
<tr>
<td  width="16%"  bgcolor="#FFFFFF" class="new">五行生克制化宜忌</td>
<td width="84%" colspan="6" bgcolor="#FFFFFF" class="new"><?php echo $this->_tpl_vars['skzhyj']; ?>
</td>
  </tr>
<tr>
  <td  bgcolor="#FFFFFF" class="new">五行之性</td>
  <td colspan="6" bgcolor="#FFFFFF" class="new"><?php echo $this->_tpl_vars['whzx']; ?>
</td>
</tr>
<tr>
  <td  bgcolor="#FFFFFF" class="new">四柱五行生克中对应需补的脏腑和部位</td>
  <td colspan="6" bgcolor="#FFFFFF" class="new"><?php echo $this->_tpl_vars['szwh']; ?>
</td>
</tr>
<tr>
  <td  bgcolor="#FFFFFF" class="new">宜从事行业与方位</td>
  <td colspan="6" bgcolor="#FFFFFF" class="new"><?php echo $this->_tpl_vars['hyhw']; ?>
</td>
</tr>


</tbody>
</table><table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">
  <tbody>
    <tr>
      <td  width="4%"  bgcolor="#FFFFFF" class="new">三<br />命<br />通<br />会</td>
      <td width="96%" colspan="6" bgcolor="#FFFFFF" class="new"><?php echo $this->_tpl_vars['tf1']; ?>
<br /><font color="#006699"><?php echo $this->_tpl_vars['tf2']; ?>
</font></td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">
  <tbody>
    <tr>
      <td  width="4%" rowspan="3"  bgcolor="#FFFFFF" class="new">月<br /><br />日<br /><br />时<br /><br />命<br /><br />理</td>
      <td  width="12%"  bgcolor="#FFFFFF" class="new"><?php echo $this->_tpl_vars['yue2']; ?>
月生</td>
      <td width="84%" colspan="6" bgcolor="#FFFFFF" class="new"><?php echo $this->_tpl_vars['mingni1']; ?>
</td>
    </tr>
    <tr>
      <td  bgcolor="#FFFFFF" class="new"><?php echo $this->_tpl_vars['ri2']; ?>
日生</td>
      <td colspan="6" bgcolor="#FFFFFF" class="new"><?php echo $this->_tpl_vars['mingni2']; ?>
</td>
    </tr>
    <tr>
      <td  bgcolor="#FFFFFF" class="new"><?php echo ((is_array($_tmp=$this->_tpl_vars['hh2'])) ? $this->_run_mod_handler('DiZhi', true, $_tmp) : DiZhi($_tmp)); ?>
时时生</td>
      <td colspan="6" bgcolor="#FFFFFF" class="new"><?php echo $this->_tpl_vars['mingni3']; ?>
</td>
    </tr>
  </tbody>
</table>