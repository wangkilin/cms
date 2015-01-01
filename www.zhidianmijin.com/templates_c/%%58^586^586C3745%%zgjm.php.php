<?php /* Smarty version 2.6.6, created on 2009-06-28 04:29:47
         compiled from chouqian/zgjm.php */ ?>
<SCRIPT language=javascript>
    <!--
    function valid_checkdream(){
        if(  document.form1.word.value.length==""  )
        {window.alert("对不起，请输入梦的关键字！");
            document.form1.word.focus();
            return false;
        } ;
        if(  document.form1.word.value.length>20  )
        {window.alert("对不起，请将描述控制在20个字以内！");
            document.form1.word.focus();
            return false;
        } ;
        win = window.open('','dream','scrollbars=yes,top=0,left=0,width=580,height=510');
        form1.submit();
        return ;
    }
    //-->
</SCRIPT>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <tbody><tr>
        <td width="79%" class="ttd"><span class="red">周公解梦:</span><br>
            <br>
            周公，即周公旦，他是周成王的叔父，对于建立和完善周代的封建制度他有很大贡献。周公在儒家文化中享有崇高的地位，孔子以“吾不复梦见周公矣”之言，隐喻周代礼仪文化的失落。
        　　周公是一个在孔子梦中频频出现的人物，在儒教长期主导文化的中国，周公也就不可避免的直接与梦联系起来。梦，经常被成为“周公之梦”,或“梦见周公”。因此，周公解梦中的周公，即是周公旦。</td>
        <td width="21%" class="ttd"><img src="diary_book/images/zg.gif" width="150" height="218"></td>
    </tr>
    <form method="post" action="?m=3&sm=8" name="form1" onSubmit="return valid_checkdream()" target="dream">
        <input type="hidden" name="act" value="ok" />
        <tr>
            <td colspan="2" class="new">
                请输入做梦内容的关键字 ：<input name="word" type="text" id="word" size="20" onKeyUp="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" maxLength="20">
                <select size="1" name="act">
                    <option selected="" value="1">简明</option>
                    <option value="2">详细</option>
                </select>  <input type="submit" name="Submit1" value="开始解梦" style="cursor:hand;">
            </form></td>
        </tr>
    </tbody>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <tbody><?php unset($this->_sections['id']);
$this->_sections['id']['name'] = 'id';
$this->_sections['id']['loop'] = is_array($_loop=$this->_tpl_vars['list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['id']['show'] = true;
$this->_sections['id']['max'] = $this->_sections['id']['loop'];
$this->_sections['id']['step'] = 1;
$this->_sections['id']['start'] = $this->_sections['id']['step'] > 0 ? 0 : $this->_sections['id']['loop']-1;
if ($this->_sections['id']['show']) {
    $this->_sections['id']['total'] = $this->_sections['id']['loop'];
    if ($this->_sections['id']['total'] == 0)
        $this->_sections['id']['show'] = false;
} else
    $this->_sections['id']['total'] = 0;
if ($this->_sections['id']['show']):

            for ($this->_sections['id']['index'] = $this->_sections['id']['start'], $this->_sections['id']['iteration'] = 1;
                 $this->_sections['id']['iteration'] <= $this->_sections['id']['total'];
                 $this->_sections['id']['index'] += $this->_sections['id']['step'], $this->_sections['id']['iteration']++):
$this->_sections['id']['rownum'] = $this->_sections['id']['iteration'];
$this->_sections['id']['index_prev'] = $this->_sections['id']['index'] - $this->_sections['id']['step'];
$this->_sections['id']['index_next'] = $this->_sections['id']['index'] + $this->_sections['id']['step'];
$this->_sections['id']['first']      = ($this->_sections['id']['iteration'] == 1);
$this->_sections['id']['last']       = ($this->_sections['id']['iteration'] == $this->_sections['id']['total']);
?>
        <tr>
            <td width="12%" class="new">&nbsp;<strong><?php echo $this->_tpl_vars['list'][$this->_sections['id']['index']][0]; ?>
</strong></td><td width="88%" class="new">
			<?php unset($this->_sections['id1']);
$this->_sections['id1']['name'] = 'id1';
$this->_sections['id1']['loop'] = is_array($_loop=$this->_tpl_vars['list'][$this->_sections['id']['index']][1]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['id1']['show'] = true;
$this->_sections['id1']['max'] = $this->_sections['id1']['loop'];
$this->_sections['id1']['step'] = 1;
$this->_sections['id1']['start'] = $this->_sections['id1']['step'] > 0 ? 0 : $this->_sections['id1']['loop']-1;
if ($this->_sections['id1']['show']) {
    $this->_sections['id1']['total'] = $this->_sections['id1']['loop'];
    if ($this->_sections['id1']['total'] == 0)
        $this->_sections['id1']['show'] = false;
} else
    $this->_sections['id1']['total'] = 0;
if ($this->_sections['id1']['show']):

            for ($this->_sections['id1']['index'] = $this->_sections['id1']['start'], $this->_sections['id1']['iteration'] = 1;
                 $this->_sections['id1']['iteration'] <= $this->_sections['id1']['total'];
                 $this->_sections['id1']['index'] += $this->_sections['id1']['step'], $this->_sections['id1']['iteration']++):
$this->_sections['id1']['rownum'] = $this->_sections['id1']['iteration'];
$this->_sections['id1']['index_prev'] = $this->_sections['id1']['index'] - $this->_sections['id1']['step'];
$this->_sections['id1']['index_next'] = $this->_sections['id1']['index'] + $this->_sections['id1']['step'];
$this->_sections['id1']['first']      = ($this->_sections['id1']['iteration'] == 1);
$this->_sections['id1']['last']       = ($this->_sections['id1']['iteration'] == $this->_sections['id1']['total']);
?><A onClick="window.open(this.href,'','location=no,menu=no,scrollbars=yes,resizable=no,top=0,left=0,width=580,height=510');return false;" href="?m=3&sm=8&act=1&word=<?php echo $this->_tpl_vars['list'][$this->_sections['id']['index']][1][$this->_sections['id1']['index']]; ?>
" target="_blank"><?php echo $this->_tpl_vars['list'][$this->_sections['id']['index']][1][$this->_sections['id1']['index']]; ?>
</A>&nbsp;
                <?php endfor; endif; ?>
            </td>
        </tr><?php endfor; endif; ?>
    </table>
