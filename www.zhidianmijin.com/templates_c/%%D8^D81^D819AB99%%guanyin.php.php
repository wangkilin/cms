<?php /* Smarty version 2.6.6, created on 2009-06-28 00:17:20
         compiled from chouqian/guanyin.php */ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <tbody>
        <?php if (( isset ( $_REQUEST['act'] ) && $_REQUEST['act'] == 'jq' )): ?>
        <tr>
            <td align="center" class="new">
                <img src="diary_book/images/gy/<?php echo $this->_tpl_vars['gyqid']; ?>
.gif">
                <br>
                <hr>
            </td>
        </tr>
        <tr>
            <td class="new">
                观音解签：<?php echo $this->_tpl_vars['jieqian']; ?>

                <br>
                <br>
                <A href="?m=3">
                    <font color=red>
                    点击这里返回抽签首页！</font>
                </A>
            </td>
        </tr>
        <?php else: ?>
        <tr>
            <td align="center" class="new">
                <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="152" height="240">
                    <param name="movie" value="diary_book/images/gy.swf" />
                    <param name="quality" value="high" />
                    <embed src="diary_book/images/gy.swf" quality="high" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="152" height="240">
                    </embed>
                </object>
            </td>
            <td width="50%" align="center" class="new">
                <?php if (( isset ( $_REQUEST['act'] ) && $_REQUEST['act'] == 'ok' )): ?>
                您刚抽了第&nbsp;<font style="color: #FF0000;FONT-SIZE: 26px;font-weight: bold;">
                <?php echo $this->_tpl_vars['num']; ?>
</font>
                &nbsp;签<br>
                <br>
                <?php if (( $this->_tpl_vars['gyclicknum'] == "" )): ?>
                <a href="?m=3&sm=2&act=ok&gyclicknum=<?php echo $this->_tpl_vars['gyclicknum']+1; ?>
&gyqid=<?php echo $this->_tpl_vars['num']; ?>
" title="首先请您心无杂念，然后点这里开始擲出聖杯">
                    <img src=diary_book/images/sign<?php echo $this->_tpl_vars['picnum']; ?>
.gif width=100 height=77 border=0>
                </a>
                <br>
                <br>
                需连续掷出三次圣杯，才是灵签！请点上面图标开始掷出圣杯
                <?php else: ?>
                <?php if (( $this->_tpl_vars['gyclicknum'] < 3 && $this->_tpl_vars['gysmile'] <> '4' )): ?><a href="?m=3&sm=2&act=ok&gyclicknum=<?php echo $this->_tpl_vars['gyclicknum']+1; ?>
&gyqid=<?php echo $this->_tpl_vars['num']; ?>
" title="首先请您心无杂念，然后点这里开始擲出聖杯">
                    <?php endif; ?><img src=diary_book/images/sign<?php echo $this->_tpl_vars['picnum']; ?>
.gif width=100 height=77 border=0>
                </a>
                <br>
                <br>
                <?php if (( $this->_tpl_vars['gyclicknum'] <> "" )):  if (( $this->_tpl_vars['gysmile'] <> '4' )):  echo $this->_tpl_vars['gyclicknum']; ?>
次 圣杯<br>
                <?php else: ?>笑杯<br>
                <?php endif; ?>
                <?php endif; ?><br>
                <?php if (( $this->_tpl_vars['gyclicknum'] == 3 && $this->_tpl_vars['gysmile'] <> '4' )): ?><a href="?m=3&sm=2&act=jq&gyqid=<?php echo $this->_tpl_vars['num']; ?>
">
                    <font color=blue>
                    恭喜，您连续掷出了三次圣杯，请点这里察看签词！</font>
                </a>
                <?php else: ?>需连续掷出三次圣杯，才是灵签！目前，您已经掷出<?php echo $this->_tpl_vars['gyclicknum']; ?>
次<?php if (( $this->_tpl_vars['gysmile'] == '4' )): ?><br>
                <a href="?m=3&sm=2">
                    <font color=red>
                    但是，您掷出笑杯了，此签不准，请点这里重新抽签！</font>
                </a>
                <br>
                <?php endif; ?>
                <?php endif;  endif; ?>
                <?php else: ?>
                <br>
                <a href="?m=3&sm=2&act=ok" title="首先请您心无杂念，然后点这里开始抽签">
                    <img src="diary_book/images/qian.gif" width="97" height="189" border="0" />
                </a>
                <DIV align="left" class="new2">
                    1.抽签前先合手默念“救苦救难 观音菩萨”三遍。
                    <br />
                    2.默念自己姓名，出生时辰，年龄，现在居住地址。
                    <br />
                    3.请求指点事情，如婚姻、事业、运程、流年、工作、财运......等。
                    <br />
                4.点上面的签筒开始抽签！</DIV>
                <?php endif; ?>
            </td>
            <td class="new" align="center">
                <img src="diary_book/images/guanyin.jpg" width="145" height="240" border="0" />
            </td>
        </tr>

        <?php endif; ?>
    </tbody>
</table>