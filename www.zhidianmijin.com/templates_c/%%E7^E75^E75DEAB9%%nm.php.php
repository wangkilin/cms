<?php /* Smarty version 2.6.6, created on 2009-07-09 06:50:02
         compiled from sm/nm.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'layin', 'sm/nm.php', 22, false),array('modifier', 'tgdzwh', 'sm/nm.php', 22, false),array('modifier', 'siji', 'sm/nm.php', 22, false),array('modifier', 'DiZhi', 'sm/nm.php', 31, false),)), $this); ?>
 
<table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">    <tbody>
<tr>
<td  width="6%" rowspan="6" bgcolor="#FFFFFF" class="new">

<b><?php echo $this->_tpl_vars['xing1']; ?>
</b><br /><br />
<?php if (( $this->_tpl_vars['xing2'] )): ?>
<b><?php echo $this->_tpl_vars['xing2']; ?>
</b> <br /><br />
<?php endif; ?>
<b><?php echo $this->_tpl_vars['ming1']; ?>
</b> <br /><br />
<?php if (( $this->_tpl_vars['ming2'] )): ?>
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
。）<br />八字五行个数 : <?php echo $this->_tpl_vars['wnum1']; ?>
个金，<?php echo $this->_tpl_vars['wnum2']; ?>
个木，<?php echo $this->_tpl_vars['wnum3']; ?>
个水，<?php echo $this->_tpl_vars['wnum4']; ?>
个火，<?php echo $this->_tpl_vars['wnum5']; ?>
个土
　</td>
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
</table>
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
      <td  width="16%"  bgcolor="#FFFFFF" class="new">性格分析</td>
      <td width="84%" colspan="6" bgcolor="#FFFFFF" class="new"> <?php echo $this->_tpl_vars['xgfx']; ?>
</td>
    </tr>
  </tbody>
</table><table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">
  <tbody>
    <tr>
      <td  width="16%"  bgcolor="#FFFFFF" class="new">爱情分析</td>
      <td width="84%" colspan="6" bgcolor="#FFFFFF" class="new"> <?php echo $this->_tpl_vars['aqfx']; ?>
</td>
    </tr>
  </tbody>
</table><table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">
  <tbody>
    <tr>
      <td  width="16%"  bgcolor="#FFFFFF" class="new">事业分析</td>
      <td width="84%" colspan="6" bgcolor="#FFFFFF" class="new"> <?php echo $this->_tpl_vars['syfx']; ?>
</td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">
  <tbody>
    <tr>
      <td  width="16%"  bgcolor="#FFFFFF" class="new">财运分析</td>
      <td width="84%" colspan="6" bgcolor="#FFFFFF" class="new"><?php echo $this->_tpl_vars['cyfx']; ?>
</td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0"   style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">
  <tbody>
    <tr>
      <td  width="16%"  bgcolor="#FFFFFF" class="new">健康分析</td>
      <td width="84%" colspan="6" bgcolor="#FFFFFF" class="new"><?php echo $this->_tpl_vars['jkfx']; ?>
</td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
  <tbody>
    <tr>
      <td class="new"><div id="ft">说明:日干论命仅对八字中日柱的信息进行分析，为片面的信息，仅供参考！</div></td>
    </tr>
  </tbody>
</table>