<?php /* Smarty version 2.6.6, created on 2009-07-10 01:57:08
         compiled from chouqian/mazu.php */ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <tbody>
        <?php if (( isset ( $_REQUEST['act'] ) && $_REQUEST['act'] == 'jq' )): ?>
            <tr>
                <td align="center" class="new">
                    <img src="diary_book/images/th/<?php echo $this->_tpl_vars['thlqid']; ?>
.gif">
                </td>
            </tr>
            <tr>
                <td class="new">
                    <A href="?m=3">
                        <font color=red>
                        点击这里返回抽签首页！</font>
                    </A>
                </td>
            </tr>
            <?php else: ?>
            <tr>
                <td align="center" class="new">
                    <img src="diary_book/images/mz1.gif" width="160" height="240">
                </td>
                <td width="50%" align="center" class="new">
                    <?php if (( isset ( $_REQUEST['act'] ) && $_REQUEST['act'] == 'ok' )): ?>
                        您刚抽了第&nbsp;<font style="color: #FF0000;FONT-SIZE: 26px;font-weight: bold;">
                        <?php echo $this->_tpl_vars['num']; ?>
</font>
                        &nbsp;签<br>
                        <br>
                        <?php if (( $this->_tpl_vars['mzclicknum'] == "" )): ?>
                            <a href="?m=3&sm=5&act=ok&mzclicknum=<?php echo $this->_tpl_vars['mzclicknum']+1; ?>
&thlqid=<?php echo $this->_tpl_vars['num']; ?>
" title="首先请您心无杂念，然后点这里开始擲出聖杯">
                                <img src=diary_book/images/qian.gif width=97 height=189 border=0>
                            </a>
                            <br>
                            <br>
                            需连续掷出三次圣杯，才是灵签！请点上面图标开始掷出圣杯
                        <?php else: ?>
                            <?php if (( $this->_tpl_vars['mzclicknum'] < 3 && $this->_tpl_vars['gysmile'] <> '4' )): ?><a href="?m=3&sm=5&act=ok&mzclicknum=<?php echo $this->_tpl_vars['mzclicknum']+1; ?>
&thlqid=<?php echo $this->_tpl_vars['num']; ?>
" title="首先请您心无杂念，然后点这里开始擲出聖杯">
                                <?php endif; ?><img src=diary_book/images/sign<?php echo $this->_tpl_vars['picnum']; ?>
.gif width=100 height=77 border=0>
                            </a>
                            <br>
                            <br>
                            <?php if (( $this->_tpl_vars['mzclicknum'] <> "" )):  if (( $this->_tpl_vars['gysmile'] <> '4' )): ?>圣杯<br>
                            <?php else: ?>笑杯<br>
                            <?php endif; ?>
                            <?php endif; ?><br>
                            <?php if (( $this->_tpl_vars['mzclicknum'] == 3 && $this->_tpl_vars['gysmile'] <> '4' )): ?><a href="?m=3&sm=5&act=jq&thlqid=<?php echo $this->_tpl_vars['num']; ?>
">
                                <font color=blue>
                                恭喜，您连续掷出了三次圣杯，请点这里察看签词！</font>
                            </a>
                            <?php else: ?>需连续掷出三次圣杯，才是灵签！目前，您已经掷出<?php echo $this->_tpl_vars['mzclicknum']; ?>
次<?php if (( $this->_tpl_vars['gysmile'] == '4' )): ?><br>
                            <a href="?m=3&sm=5">
                                <font color=red>
                                但是，您掷出笑杯了，此签不准，请点这里重新抽签！</font>
                            </a>
                            <br>
                            <?php endif; ?>
                            <?php endif;  endif; ?>
                        <?php else: ?>
                            <br>
                            <br>
                            <a href="?m=3&sm=5&act=ok" title="首先请您心无杂念，然后点这里开始抽签">
                                <img src="diary_book/images/qian.gif" width="97" height="189" border="0" />
                            </a>
                            <br />
                            <DIV align="left" class="new2">
                            天后是在約一千多年以前，出生於中國福建莆田的一個沿海漁村喚作林默的一個女子。相傳天后從小已有預知能力來幫助當地居民，驅邪消災。</DIV>
                        <?php endif; ?></td>
                        <td class="new" align="center">
                            <img src="diary_book/images/mz2.gif" width="160" height="240" border="0" />
                        </td>
                    </tr>

                    <?php endif; ?>
                </tbody>
            </table>