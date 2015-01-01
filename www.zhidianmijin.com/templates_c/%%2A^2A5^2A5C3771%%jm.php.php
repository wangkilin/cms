<?php /* Smarty version 2.6.6, created on 2009-06-28 04:56:39
         compiled from chouqian/jm.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'chouqian/jm.php', 33, false),)), $this); ?>
<table cellspacing="1" cellpadding="0" border="0" class="tablebgcolor4">
    <TBODY>
        <?php if (( ! isset ( $this->_tpl_vars['list'] ) && ! count ( $this->_tpl_vars['list'] ) )): ?>
        <script>
        alert('没有找到相关解梦内容');window.close()</script>
        <?php else: ?>

        <TR class="tdbgcolor">
            <TD height="25" align="right" width="100%">
                共找到<FONT COLOR="#FF0000">
                <?php echo $this->_tpl_vars['allshu']; ?>
</FONT>
                个解梦结果，分为<font color="#FF0000">
                <?php echo $this->_tpl_vars['mpage']; ?>
</font>
                页，目前是第<font color="#FF0000">
                <?php echo $this->_tpl_vars['currentPage']; ?>
</font>
            页</TD>
        </TR>
        <TR class="tdbgcolor2">
            <TD>

                <div align="center">
                    <table border="0" width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                            <?php if (isset($this->_foreach['name'])) unset($this->_foreach['name']);
$this->_foreach['name']['total'] = count($_from = (array)$this->_tpl_vars['list']);
$this->_foreach['name']['show'] = $this->_foreach['name']['total'] > 0;
if ($this->_foreach['name']['show']):
$this->_foreach['name']['iteration'] = 0;
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
        $this->_foreach['name']['first'] = ($this->_foreach['name']['iteration'] == 1);
        $this->_foreach['name']['last']  = ($this->_foreach['name']['iteration'] == $this->_foreach['name']['total']);
?>
                            <tr>
                                <td style="line-height:200%">
                                    <font color="green">
                                    ［<?php echo $this->_tpl_vars['i']+1; ?>
.<?php echo $this->_tpl_vars['item']['jmlb']; ?>
］</font>
                                    <font color="red">
                                    （<?php echo $this->_tpl_vars['item']['title']; ?>
）</font>
                                    <br />

                                    <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['content'])) ? $this->_run_mod_handler('replace', true, $_tmp, $this->_tpl_vars['word'], "<font color=red>
                                    ".($this->_tpl_vars['word'])."</font>
                                    ") : smarty_modifier_replace($_tmp, $this->_tpl_vars['word'], "<font color=red>
                                    ".($this->_tpl_vars['word'])."</font>
                                    ")); ?>

                                </td>
                            </tr>
                            <?php endforeach; unset($_from); endif; ?>
                        </tbody>
                    </table>
                </div>
                <hr size="1" color="#d2d0d0" />

                <!--分页开始-->
                <div align="center">
                    <script>
                        PageCount=<?php echo $this->_tpl_vars['mpage']; ?>
 //总页数
                        topage=<?php echo $this->_tpl_vars['currentPage']; ?>
   //当前停留页
                        if (topage>1){document.write("<a href='?m=3&sm=8&act=<?php echo $_REQUEST['act']; ?>
&word=<?php echo $_REQUEST['word']; ?>
&page=<?php echo $_REQUEST['page']-1; ?>
' title='上一页'> 上一页</a>");}
                            for (var i=1; i <= PageCount; i++) {
                                if (i <= topage+6 && i >= topage-6 || i==1 || i==PageCount){
                                    if (i > topage+7 || i < topage-5 && i!=1 && i!=2 ){document.write(" ... ");}
                                    if (topage==i){document.write("<font color=#d2d0d0> "+ i +" </font> ");}
                                        else{
                                            document.write(" <a href='?m=3&sm=8&act=<?php echo $_REQUEST['act']; ?>
&word=<?php echo $_REQUEST['word']; ?>
&page="+i+"'> ["+ i +"]</a> ");
                                        }
                                    }
                                }
                                if (PageCount-topage>=1){document.write("<a href='?m=3&sm=8&act=<?php echo $_REQUEST['act']; ?>
&word=<?php echo $_REQUEST['word']; ?>
&page=<?php echo $_REQUEST['page']+1; ?>
' title='下一页'>下一页</a>");}
                                </script>
                            </div>
                            <!--分页结束-->
                        </TD>
                    </TR>
                    <?php endif; ?>
                </TBODY>
            </table>
            <br />
            <a href="javascript:window.close()">
            [关闭页面]</a>