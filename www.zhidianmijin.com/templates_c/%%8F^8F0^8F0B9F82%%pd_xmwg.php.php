<?php /* Smarty version 2.6.6, created on 2009-06-28 07:31:51
         compiled from qinglv/pd_xmwg.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'GbToBig', 'qinglv/pd_xmwg.php', 98, false),array('modifier', 'truncate', 'qinglv/pd_xmwg.php', 99, false),array('modifier', 'c', 'qinglv/pd_xmwg.php', 99, false),array('modifier', 'getzywh', 'qinglv/pd_xmwg.php', 101, false),array('modifier', 'getsancai', 'qinglv/pd_xmwg.php', 126, false),)), $this); ?>
<SCRIPT language=javascript>
<!--
function Check(theForm)
{
var name1 = theForm.name1.value;
if (name1 == "") 
{
alert("请输入您的姓名！");
theForm.name1.value="";
theForm.name1.focus();
return false;
}
if (theForm.name1.value.length < 2 || theForm.name1.value.length>4)
{
alert("错误：名字应在2-4个字之间！");
theForm.name1.focus();
return (false);
}
if (name1.search(/[`1234567890-=\~!@#$%^&*()_+|<>;':",.?/ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz]/) != -1) 
{
alert("请务必输入简体汉字！");
theForm.name1.value = "";
theForm.name1.focus();
return false;
}
var name2 = theForm.name2.value;
if (name2 == "") 
{
alert("请输入您爱人的名字！");
theForm.name2.value="";
theForm.name2.focus();
return false;
}
if (theForm.name2.value.length < 2 || theForm.name2.value.length>4)
{
alert("错误：名字应在2-4个字之间！");
theForm.name2.focus();
return (false);
}
if (name2.search(/[`1234567890-=\~!@#$%^&*()_+|<>;':",.?/ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz]/) != -1) 
{
alert("请务必输入简体汉字！");
theForm.name2.value = "";
theForm.name2.focus();
return false;
}

}

//-->
</SCRIPT> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="81%" class="ttd"><span class="red">姓名五格配对评分:</span><br>
    根据《易经》的"象"、"数"理论，依据姓名的笔画数和一定规则建立起来天格、地格、人格、总格、外格等五格数理关系，并运用阴阳五行相生相克理论，来推算的各方面运势。 </td>
    <td width="19%" class="ttd"><img src="../images/xmpd.jpg" width="105" height="140"></td>
</tr>
<form name="form1" onSubmit="return Check(this)" method="post" action="">
<input type="hidden" name="act" value="ok" />
  <tr>
    <td colspan="2" class="new">
请输入您的姓名：<input name="name1" type="text" id="name1" size="20" onKeyUp="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" maxLength="4">&nbsp;<select size="1" name="xing1">
<option value="1" <?php if (( $this->_tpl_vars['xing2'] == "" )): ?>selected="selected"<?php endif; ?>>单姓</option>
<option value="2"<?php if (( $this->_tpl_vars['xing2'] <> "" )): ?>selected="selected"<?php endif; ?>>复姓</option>
          </select>&nbsp;<select size="1" name="sex1">
<option value="男" <?php if (( $this->_tpl_vars['xingbie'] == "男" )): ?>selected="selected"<?php endif; ?>>男性</option>
<option value="女" <?php if (( $this->_tpl_vars['xingbie'] == "女" )): ?>selected="selected"<?php endif; ?>>女性</option>
          </select>
  <tr>
    <td colspan="2" class="new">输入另一个姓名:  <input name="name2" type="text" id="name2" size="20" onKeyUp="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" maxLength="4">&nbsp;<select size="1" name="xing2">
<option value="1">单姓</option>
<option value="2">复姓</option>
</select>&nbsp;<select size="1" name="sex2">
<option value="男" <?php if (( $this->_tpl_vars['xingbie'] == "女" )): ?>selected="selected"<?php endif; ?>>男性</option>
<option value="女" <?php if (( $this->_tpl_vars['xingbie'] == "男" )): ?>selected="selected"<?php endif; ?>>女性</option>
</select>
<input type="submit" name="Submit1" value="开始测试" style="cursor:hand;">
  </form>
    </tr></tbody>
</table>
<?php if (( isset ( $_POST['act'] ) && $_POST['act'] == 'ok' )): ?>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#5391EE"  style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">  
  <tbody>    <tr>
      <td colspan="3" class=new bgcolor="#FFFFFF">姓名：<?php echo $this->_tpl_vars['name1']; ?>
  性别：<?php echo $this->_tpl_vars['sex1']; ?>
  </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="2" cellspacing="1"  style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">
        <tbody>
          <tr>
            <td bgcolor="#FFFFFF"></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">繁体</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">拼音</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">笔划</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">五行</font></td>
            </tr>
          <tr>
            <td  align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['nxing1']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['nxing1'])) ? $this->_run_mod_handler('GbToBig', true, $_tmp) : GbToBig($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['nxing11'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 2) : smarty_modifier_truncate($_tmp, 2)))) ? $this->_run_mod_handler('c', true, $_tmp) : c($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['bihua1']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo ((is_array($_tmp=$this->_tpl_vars['nxing11'])) ? $this->_run_mod_handler('getzywh', true, $_tmp) : getzywh($_tmp)); ?>
</td>
          </tr>
          <tr>
         <?php if (( $this->_tpl_vars['nxing2'] <> "" )): ?>   <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['nxing2']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['nxing2'])) ? $this->_run_mod_handler('GbToBig', true, $_tmp) : GbToBig($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['nxing22'])) ? $this->_run_mod_handler('c', true, $_tmp) : c($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['bihua2']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo ((is_array($_tmp=$this->_tpl_vars['nxing22'])) ? $this->_run_mod_handler('getzywh', true, $_tmp) : getzywh($_tmp)); ?>
</td>
          </tr><?php endif; ?>
          <tr>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['nming1']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['nming1'])) ? $this->_run_mod_handler('GbToBig', true, $_tmp) : GbToBig($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['nming12'])) ? $this->_run_mod_handler('c', true, $_tmp) : c($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['bihua3']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo ((is_array($_tmp=$this->_tpl_vars['nming12'])) ? $this->_run_mod_handler('getzywh', true, $_tmp) : getzywh($_tmp)); ?>
</td>
          </tr>
          <?php if (( $this->_tpl_vars['nming2'] <> "" )): ?><tr>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['nming2']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['nming2'])) ? $this->_run_mod_handler('GbToBig', true, $_tmp) : GbToBig($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['nming22'])) ? $this->_run_mod_handler('c', true, $_tmp) : c($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['bihua4']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo ((is_array($_tmp=$this->_tpl_vars['nming22'])) ? $this->_run_mod_handler('getzywh', true, $_tmp) : getzywh($_tmp)); ?>
</td>
          </tr><?php endif; ?>
        </tbody>
      </table></td>
      <td width="25%" colspan="-3" align="center" bgcolor="#FFFFFF"  class="new2">天格-&gt; <?php echo $this->_tpl_vars['tiange1']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['tiange1'])) ? $this->_run_mod_handler('getsancai', true, $_tmp) : getsancai($_tmp)); ?>
) 
 ->(<font color=red><?php echo $this->_tpl_vars['tgjx']; ?>
</font>)<br />
      <p>人格-&gt; <?php echo $this->_tpl_vars['renge1']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['renge1'])) ? $this->_run_mod_handler('getsancai', true, $_tmp) : getsancai($_tmp)); ?>
)
 ->(<font color=red><?php echo $this->_tpl_vars['rgjx']; ?>
</font>)</p>        <p>地格-&gt; <?php echo $this->_tpl_vars['dige1']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['dige1'])) ? $this->_run_mod_handler('getsancai', true, $_tmp) : getsancai($_tmp)); ?>
)
 ->(<font color=red><?php echo $this->_tpl_vars['dgjx']; ?>
</font>)</p></td>
      <td width="25%"  class="new2" align="center" bgcolor="#FFFFFF">外格-&gt; <?php echo $this->_tpl_vars['waige1']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['waige1'])) ? $this->_run_mod_handler('getsancai', true, $_tmp) : getsancai($_tmp)); ?>
)
 ->(<font color=red><?php echo $this->_tpl_vars['wgjx']; ?>
</font>)<br />
      <p>　</p>        <p>总格-&gt; <?php echo $this->_tpl_vars['zhongge1']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['zhongge1'])) ? $this->_run_mod_handler('getsancai', true, $_tmp) : getsancai($_tmp)); ?>
)
 ->(<font color=red><?php echo $this->_tpl_vars['zgjx']; ?>
</font>)</p></td>
    </tr>
    <tr>
      <td colspan="3" class=new bgcolor="#FFFFFF">姓名蕴含的个性分析：<?php echo $this->_tpl_vars['xg1'];  echo $this->_tpl_vars['tiangee1']; ?>
=<?php echo $this->_tpl_vars['rengee1']; ?>
=<?php echo $this->_tpl_vars['digee1']; ?>
</td>
    </tr>
  </tbody>
</table>

<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#5391EE"  style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">  
  <tbody> <tr>
      <td colspan="3" class=new bgcolor="#FFFFFF">姓名：<?php echo $this->_tpl_vars['name2']; ?>
  性别：<?php echo $this->_tpl_vars['sex2']; ?>
  </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="2" cellspacing="1"  style="MARGIN-BOTTOM: 10px; table-layout:fixed;word-wrap:break-word;">
        <tbody>
          <tr>
            <td bgcolor="#FFFFFF"></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">繁体</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">拼音</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">笔划</font></td>
            <td align="center" bgcolor="#FFFFFF"><font color="ababab">五行</font></td>
            </tr>
          <tr>
            <td  align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['n2xing1']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['n2xing1'])) ? $this->_run_mod_handler('GbToBig', true, $_tmp) : GbToBig($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['n2xing11'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 2) : smarty_modifier_truncate($_tmp, 2)))) ? $this->_run_mod_handler('c', true, $_tmp) : c($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['nbihua1']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo ((is_array($_tmp=$this->_tpl_vars['n2xing11'])) ? $this->_run_mod_handler('getzywh', true, $_tmp) : getzywh($_tmp)); ?>
</td>
          </tr>
          <tr>
         <?php if (( $this->_tpl_vars['n2xing2'] <> "" )): ?>   <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['n2xing2']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['n2xing2'])) ? $this->_run_mod_handler('GbToBig', true, $_tmp) : GbToBig($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['n2xing22'])) ? $this->_run_mod_handler('c', true, $_tmp) : c($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['nbihua2']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo ((is_array($_tmp=$this->_tpl_vars['n2xing22'])) ? $this->_run_mod_handler('getzywh', true, $_tmp) : getzywh($_tmp)); ?>
</td>
          </tr><?php endif; ?>
          <tr>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['n2ming1']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['n2ming1'])) ? $this->_run_mod_handler('GbToBig', true, $_tmp) : GbToBig($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['n2ming12'])) ? $this->_run_mod_handler('c', true, $_tmp) : c($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['nbihua3']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo ((is_array($_tmp=$this->_tpl_vars['n2ming12'])) ? $this->_run_mod_handler('getzywh', true, $_tmp) : getzywh($_tmp)); ?>
</td>
          </tr>
          <?php if (( $this->_tpl_vars['n2ming2'] <> "" )): ?><tr>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['n2ming2']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['n2ming2'])) ? $this->_run_mod_handler('GbToBig', true, $_tmp) : GbToBig($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><font color="aaaaaa"><?php echo ((is_array($_tmp=$this->_tpl_vars['n2ming22'])) ? $this->_run_mod_handler('c', true, $_tmp) : c($_tmp)); ?>
</font></td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo $this->_tpl_vars['nbihua4']; ?>
</td>
            <td align="center" bgcolor="#FFFFFF" class="new2"><?php echo ((is_array($_tmp=$this->_tpl_vars['n2ming22'])) ? $this->_run_mod_handler('getzywh', true, $_tmp) : getzywh($_tmp)); ?>
</td>
          </tr><?php endif; ?>
        </tbody>
      </table></td>
      <td width="25%" colspan="-3" align="center" bgcolor="#FFFFFF"  class="new2">天格-&gt; <?php echo $this->_tpl_vars['ntiange1']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['ntiange1'])) ? $this->_run_mod_handler('getsancai', true, $_tmp) : getsancai($_tmp)); ?>
) 
 ->(<font color=red><?php echo $this->_tpl_vars['tgjx']; ?>
</font>)<br />
      <p>人格-&gt; <?php echo $this->_tpl_vars['nrenge1']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['nrenge1'])) ? $this->_run_mod_handler('getsancai', true, $_tmp) : getsancai($_tmp)); ?>
)
 ->(<font color=red><?php echo $this->_tpl_vars['rgjx']; ?>
</font>)</p>        <p>地格-&gt; <?php echo $this->_tpl_vars['ndige1']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['ndige1'])) ? $this->_run_mod_handler('getsancai', true, $_tmp) : getsancai($_tmp)); ?>
)
 ->(<font color=red><?php echo $this->_tpl_vars['dgjx']; ?>
</font>)</p></td>
      <td width="25%"  class="new2" align="center" bgcolor="#FFFFFF">外格-&gt; <?php echo $this->_tpl_vars['nwaige1']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['nwaige1'])) ? $this->_run_mod_handler('getsancai', true, $_tmp) : getsancai($_tmp)); ?>
)
 ->(<font color=red><?php echo $this->_tpl_vars['wgjx']; ?>
</font>)<br />
      <p>　</p>        <p>总格-&gt; <?php echo $this->_tpl_vars['nzhongge1']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['nzhongge1'])) ? $this->_run_mod_handler('getsancai', true, $_tmp) : getsancai($_tmp)); ?>
)
 ->(<font color=red><?php echo $this->_tpl_vars['zgjx']; ?>
</font>)</p></td>
    </tr>
    <tr>
      <td colspan="3" class=new bgcolor="#FFFFFF">姓名蕴含的个性分析：<?php echo $this->_tpl_vars['xg1']; ?>
</td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
      <tr>
        <TD class=ttd>经过分析，[<?php echo $this->_tpl_vars['name1']; ?>
]和[<?php echo $this->_tpl_vars['name2']; ?>
]的姓名配对评分如下：</TD>
      </tr>      <tr>
        <TD class=new>姓名缘份指数：<span class="pf"><?php echo $this->_tpl_vars['zf']; ?>
</span></TD>
        </tr>  <tr>
        <TD class=new><?php if (( $this->_tpl_vars['sex1'] == $this->_tpl_vars['sex2'] )): ?><font color=red>本站是按中国民俗学的一些测算方法来计算的，暂时不支持同性缘份的测试</font><?php else: ?><font color=green>
		 <?php if (( $this->_tpl_vars['zf'] < 60 )): ?>你们的姓名五格可能不是太合，不过八字配合所起的作用更大，另外彼此的努力也会让你们改善关系，记住：事在人为！
		<?php elseif (( $this->_tpl_vars['zf'] < 70 && $this->_tpl_vars['zf'] >= 60 )): ?>
		你们的姓名五格相合程度马马虎虎，不过八字配合所起的作用更大，继续努力改善关系，会对你们的关系有帮助的！ 
		<?php elseif (( $this->_tpl_vars['zf'] < 80 && $this->_tpl_vars['zf'] >= 70 )): ?>你们的姓名五格相合一般！ 
		<?php elseif (( $this->_tpl_vars['zf'] < 80 && $this->_tpl_vars['zf'] >= 70 )): ?>你们的姓名五格相合程度还不错哟！ 
		<?php elseif (( $this->_tpl_vars['zf'] < 90 && $this->_tpl_vars['zf'] >= 80 )): ?>
		你们的姓名五格相合程度相当棒！ 
		<?php elseif (( $this->_tpl_vars['zf'] >= 90 )): ?>
		你们的姓名五格相合程度太棒了！！恭喜！</font><?php if (( $this->_tpl_vars['name1'] == $this->_tpl_vars['name2'] )): ?><br /><font color=#0000ff>^_^ 你们俩同名同姓嘛，真巧哟！</font> <?php endif;  endif; ?>
		<?php endif; ?></TD>
        </tr>
    </TBODY>
</TABLE>
<?php endif; ?>
