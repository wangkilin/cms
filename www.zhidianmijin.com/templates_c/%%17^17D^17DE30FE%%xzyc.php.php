<?php /* Smarty version 2.6.6, created on 2009-06-27 09:50:47
         compiled from astro/xzyc.php */ ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
      <tr>
        <TD class=new style="PADDING-BOTTOM: 1px" vAlign=top>点击星座查看运程
          (<a href="?m=2&sm=9&type=today&xz=<?php echo $this->_tpl_vars['xz']; ?>
">今日</a> <a href="?m=2&sm=9&type=nextday&xz=<?php echo $this->_tpl_vars['xz']; ?>
">明日</a> <a href="?m=2&sm=9&type=week&xz=<?php echo $this->_tpl_vars['xz']; ?>
">本周</a> <a href="?m=2&sm=9&type=month&xz=<?php echo $this->_tpl_vars['xz']; ?>
">本月</a> <a href="?m=2&sm=9&type=year&xz=<?php echo $this->_tpl_vars['xz']; ?>
">今年</a> <a href="?m=2&sm=9&type=yearlove&xz=<?php echo $this->_tpl_vars['xz']; ?>
">今年爱情运势</a>) </TD>
      </tr>
      <tr>
        <TD class=new style="PADDING-BOTTOM: 1px" vAlign=top><span class="new" style="PADDING-BOTTOM: 1px">·<a href="?m=2&sm=9&type=<?php echo $this->_tpl_vars['yctype']; ?>
&xz=1">牡羊座</a>·<a href="?m=2&sm=9&type=<?php echo $this->_tpl_vars['yctype']; ?>
&xz=2">金牛座</a>·<a href="?m=2&sm=9&type=<?php echo $this->_tpl_vars['yctype']; ?>
&xz=3">双子座</a>·<a href="?m=2&sm=9&type=<?php echo $this->_tpl_vars['yctype']; ?>
&xz=4">巨蟹座</a>·<a href="?m=2&sm=9&type=<?php echo $this->_tpl_vars['yctype']; ?>
&xz=5">狮子座</a>·<a href="?m=2&sm=9&type=<?php echo $this->_tpl_vars['yctype']; ?>
&xz=6">处女座</a>·<a href="?m=2&sm=9&type=<?php echo $this->_tpl_vars['yctype']; ?>
&xz=7">天秤座</a>·<a href="?m=2&sm=9&type=<?php echo $this->_tpl_vars['yctype']; ?>
&xz=8">天蝎座</a>·<a href="?m=2&sm=9&type=<?php echo $this->_tpl_vars['yctype']; ?>
&xz=9">射手座</a>·<a href="?m=2&sm=9&type=<?php echo $this->_tpl_vars['yctype']; ?>
&xz=10">魔羯座</a>·<a href="?m=2&sm=9&type=<?php echo $this->_tpl_vars['yctype']; ?>
&xz=11">水瓶座</a>·<a href="?m=2&sm=9&type=<?php echo $this->_tpl_vars['yctype']; ?>
&xz=12">双鱼座</a></span></TD>
      </tr>
    </TBODY>
  </TABLE><?php if (( $this->_tpl_vars['yctype'] == 'today' )): ?>
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td colspan="6" class="ttop">
<?php if (( $this->_tpl_vars['xing'] <> "" )): ?>
<?php echo $this->_tpl_vars['xing'];  echo $this->_tpl_vars['ming']; ?>
(<?php echo $this->_tpl_vars['nian1']; ?>
-<?php echo $this->_tpl_vars['yue1']; ?>
-<?php echo $this->_tpl_vars['ri1']; ?>
) 我的星座：<?php echo $this->_tpl_vars['myxz']; ?>

<?php endif; ?>

 当前星座：<?php echo $this->_tpl_vars['rs']['xzmc']; ?>
今日运程</td>
    </tr>
  <tr>
    <td width="17%" rowspan="4" class="new"><img src="diary_book/images/xz_<?php echo $this->_tpl_vars['rs']['id']; ?>
.gif" width="100" height="100"><br>      </td>
    <td width="14%" rowspan="4" class="new"><span class="red"><?php echo $this->_tpl_vars['rs']['xzmc']; ?>
<br>
        <?php echo $this->_tpl_vars['rs']['xzrq']; ?>
</span></td>
    <td width="16%" bgcolor="e7e7e7" class="new">爱情运势:</td>
    <td width="24%" class="new"><img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['aqys']; ?>
.gif"></td>
    <td width="14%" bgcolor="e7e7e7" class="new">综合运势:</td>
    <td width="15%" class="new"><img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['zhys']; ?>
.gif"></td>
  </tr>
  <tr>
    <td bgcolor="e7e7e7" class="new">工作状况:</td>
    <td class="new"><img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['gzzk']; ?>
.gif"></td>
    <td bgcolor="e7e7e7" class="new">理财投资:</td>
    <td class="new"><img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['nctz']; ?>
.gif"></td>
  </tr>
  <tr>
    <td bgcolor="e7e7e7" class="new">健康指数:</td>
    <td class="new"><?php echo $this->_tpl_vars['rs']['jkzs']; ?>
</td>
    <td bgcolor="e7e7e7" class="new">商谈指数:<br>    </td>
    <td class="new"><?php echo $this->_tpl_vars['rs']['stzs']; ?>
</td>
  </tr>
  <tr>
    <td bgcolor="e7e7e7" class="new">幸运数字:</td>
    <td class="new"><?php echo $this->_tpl_vars['rs']['xysz']; ?>
</td>
    <td bgcolor="e7e7e7" class="new">速配星座:</td>
    <td class="new"><?php echo $this->_tpl_vars['rs']['spxz']; ?>
</td>
  </tr>
  <tr>
    <td colspan="6" class="new"><?php echo $this->_tpl_vars['rs']['zhpg']; ?>
<div align="right"><br>
      有效日期：<?php echo $this->_tpl_vars['rs']['yxqx']; ?>
</div></td>
    </tr>
</tbody>
</table><?php elseif (( $this->_tpl_vars['yctype'] == 'nextday' )): ?>  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td colspan="6" class="ttop">
<?php if (( $this->_tpl_vars['xing'] <> "" )): ?>
<?php echo $this->_tpl_vars['xing'];  echo $this->_tpl_vars['ming']; ?>

(<?php echo $this->_tpl_vars['nian1']; ?>
-<?php echo $this->_tpl_vars['yue1']; ?>
-<?php echo $this->_tpl_vars['ri1']; ?>
) 我的星座：<?php echo $this->_tpl_vars['myxz']; ?>

<?php endif; ?>
 当前星座：<?php echo $this->_tpl_vars['rs']['xzmc']; ?>
明日运程</td>
    </tr>
  <tr>
    <td width="17%" rowspan="4" class="new"><img src="diary_book/images/xz_<?php echo $this->_tpl_vars['rs']['id']; ?>
.gif" width="100" height="100"><br>      </td>
    <td width="14%" rowspan="4" class="new"><span class="red"><?php echo $this->_tpl_vars['rs']['xzmc']; ?>
<br>
        <?php echo $this->_tpl_vars['rs']['xzrq']; ?>
</span></td>
    <td width="16%" bgcolor="e7e7e7" class="new">爱情运势:</td>
    <td width="24%" class="new"><img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['aqys']; ?>
.gif"></td>
    <td width="14%" bgcolor="e7e7e7" class="new">综合运势:</td>
    <td width="15%" class="new"><img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['zhys']; ?>
.gif"></td>
  </tr>
  <tr>
    <td bgcolor="e7e7e7" class="new">工作状况:</td>
    <td class="new"><img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['gzzk']; ?>
.gif"></td>
    <td bgcolor="e7e7e7" class="new">理财投资:</td>
    <td class="new"><img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['nctz']; ?>
.gif"></td>
  </tr>
  <tr>
    <td bgcolor="e7e7e7" class="new">健康指数:</td>
    <td class="new"><?php echo $this->_tpl_vars['rs']['jkzs']; ?>
</td>
    <td bgcolor="e7e7e7" class="new">商谈指数:<br>    </td>
    <td class="new"><?php echo $this->_tpl_vars['rs']['stzs']; ?>
</td>
  </tr>
  <tr>
    <td bgcolor="e7e7e7" class="new">幸运数字:</td>
    <td class="new"><?php echo $this->_tpl_vars['rs']['xysz']; ?>
</td>
    <td bgcolor="e7e7e7" class="new">速配星座:</td>
    <td class="new"><?php echo $this->_tpl_vars['rs']['spxz']; ?>
</td>
  </tr>
  <tr>
    <td colspan="6" class="new"><?php echo $this->_tpl_vars['rs']['zhpg']; ?>
<div align="right"><br>
      有效日期：<?php echo $this->_tpl_vars['rs']['yxqx']; ?>
</div></td>
    </tr>
</tbody>
</table><?php elseif (( $this->_tpl_vars['yctype'] == 'week' )): ?>  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td class="ttop">
<?php if (( $this->_tpl_vars['xing'] <> '' )): ?>
<?php echo $this->_tpl_vars['xing'];  echo $this->_tpl_vars['ming']; ?>
(<?php echo $this->_tpl_vars['nian1']; ?>
-<?php echo $this->_tpl_vars['yue1']; ?>
-<?php echo $this->_tpl_vars['ri1']; ?>
) 我的星座：<?php echo $this->_tpl_vars['myxz']; ?>

<?php endif; ?>
 当前星座：<?php echo $this->_tpl_vars['rs']['xzmc']; ?>
本周运程</td>
    </tr>
  <tr>
    <td class="new">
      <table width="100%" border="0">
        <tr>
          <td width="16%"><img src="diary_book/images/xz_<?php echo $this->_tpl_vars['rs']['id']; ?>
.gif" width="100" height="100"></td>
          <td width="20%" class="new">  <span class="red"> <?php echo $this->_tpl_vars['rs']['xzmc']; ?>
<br>
        <?php echo $this->_tpl_vars['rs']['xzrq']; ?>
</span></td>
          <td width="64%" class="new"><span class="red"><?php echo $this->_tpl_vars['rs']['title']; ?>
(<?php echo $this->_tpl_vars['rs']['yxqx']; ?>
)</span></td>
        </tr>
      </table>
    </td>
    </tr>
  <tr>
    <td class="new"><strong>整体运势</strong>:<img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['ztzs']; ?>
.gif"><BR>
      <?php echo $this->_tpl_vars['rs']['ztys']; ?>

      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>爱情运势</strong>:<br>
      有对象:<img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['aqzs1']; ?>
.gif"><BR>
      <?php echo $this->_tpl_vars['rs']['aqys1']; ?>
<br>
      没对象:<img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['aqzs2']; ?>
.gif"><BR>
      <?php echo $this->_tpl_vars['rs']['aqys2']; ?>

      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>健康运势</strong>:<img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['jkzs']; ?>
.gif"><BR>
      <?php echo $this->_tpl_vars['rs']['jkys']; ?>

      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>工作学业运</strong>:<img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['gzzs']; ?>
.gif"><BR>
      <?php echo $this->_tpl_vars['rs']['gzys']; ?>

      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>性欲指数</strong>:<img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['xyzs']; ?>
.gif"><BR>
      <?php echo $this->_tpl_vars['rs']['xyys']; ?>

      <hr noshade color="#CCCCCC"></td>
  </tr>
  <tr>
    <td class="new"><strong>红心日</strong>: <?php echo $this->_tpl_vars['rs']['hxri']; ?>
<BR>
      <?php echo $this->_tpl_vars['rs']['hxsm']; ?>

      <hr noshade color="#CCCCCC"></td>
  </tr>
  <tr>
    <td class="new"><strong>黑梅日</strong>: <?php echo $this->_tpl_vars['rs']['hmri']; ?>
<BR>
      <?php echo $this->_tpl_vars['rs']['hmsm']; ?>
</td>
  </tr>
</tbody>
</table>
<?php elseif (( $this->_tpl_vars['yctype'] == 'month' )): ?>  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td class="ttop">
<?php if (( $this->_tpl_vars['xing'] <> '' )): ?>
<?php echo $this->_tpl_vars['xing'];  echo $this->_tpl_vars['ming']; ?>
(<?php echo $this->_tpl_vars['nian1']; ?>
-<?php echo $this->_tpl_vars['yue1']; ?>
-<?php echo $this->_tpl_vars['ri1']; ?>
) 我的星座：<?php echo $this->_tpl_vars['myxz']; ?>

<?php endif; ?>
 当前星座：<?php echo $this->_tpl_vars['rs']['xzmc']; ?>
本月运程</td>
    </tr>
  <tr>
    <td class="new">
      <table width="100%" border="0">
        <tr>
          <td width="16%"><img src="diary_book/images/xz_<?php echo $this->_tpl_vars['rs']['id']; ?>
.gif" width="100" height="100"></td>
          <td width="20%" class="new">  <span class="red"> <?php echo $this->_tpl_vars['rs']['xzmc']; ?>
<br>
        <?php echo $this->_tpl_vars['rs']['xzrq']; ?>
</span></td>
          <td width="64%" class="new"><span class="red">有效日期:(<?php echo $this->_tpl_vars['rs']['yxqx']; ?>
)</span></td>
        </tr>
      </table>
    </td>
    </tr>
  <tr>
    <td class="new"><strong>整体运势</strong>:<img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['ztzs']; ?>
.gif"><BR>
      <?php echo $this->_tpl_vars['rs']['ztys']; ?>

      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>爱情运势</strong>:<img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['aqzs']; ?>
.gif"><BR>
      <?php echo $this->_tpl_vars['rs']['aqys']; ?>

      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>投资理财运</strong>:<img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['tzzs']; ?>
.gif"><BR>
      <?php echo $this->_tpl_vars['rs']['tzys']; ?>

      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>解压方式</strong>:<BR>
      <?php echo $this->_tpl_vars['rs']['jyfs']; ?>

      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>幸运物</strong>:<BR>
      <?php echo $this->_tpl_vars['rs']['xyw']; ?>
</td>
  </tr>
  
</tbody>
</table>
<?php elseif (( $this->_tpl_vars['yctype'] == 'year' )): ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
  <tbody>
    <tr>
      <td class="ttop"><?php if (( $this->_tpl_vars['xing'] <> '' )): ?>

          <?php echo $this->_tpl_vars['xing'];  echo $this->_tpl_vars['ming']; ?>
(<?php echo $this->_tpl_vars['nian1']; ?>
-<?php echo $this->_tpl_vars['yue1']; ?>
-<?php echo $this->_tpl_vars['ri1']; ?>
) 我的星座：<?php echo $this->_tpl_vars['myxz']; ?>

        <?php endif; ?>
        当前星座：<?php echo $this->_tpl_vars['rs']['xzmc']; ?>
今年运程</td>
    </tr>
    <tr>
      <td class="new"><table width="100%" border="0">
        <tr>
          <td width="16%"><img src="diary_book/images/xz_<?php echo $this->_tpl_vars['rs']['id']; ?>
.gif" width="100" height="100"></td>
          <td width="18%" class="new"><span class="red"> <?php echo $this->_tpl_vars['rs']['xzmc']; ?>
<br>
                  <?php echo $this->_tpl_vars['rs']['xzrq']; ?>
</span></td>
          <td width="66%" class="new"><span class="red"><?php echo $this->_tpl_vars['rs']['title']; ?>
(<?php echo $this->_tpl_vars['rs']['yxqx']; ?>
)</span></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td class="new"><strong>整体概况</strong>:<img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['ztzs']; ?>
.gif"><br>
          <?php echo $this->_tpl_vars['rs']['ztzk']; ?>

          <hr noshade color="#CCCCCC"></td>
    </tr>
    <tr>
      <td class="new"><strong>功课学业</strong>:<img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['gkzs']; ?>
.gif"><br>
          <?php echo $this->_tpl_vars['rs']['gkxy']; ?>

          <hr noshade color="#CCCCCC"></td>
    </tr>
    <tr>
      <td class="new"><strong>工作职场</strong>:<img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['gzzs']; ?>
.gif"><br>
          <?php echo $this->_tpl_vars['rs']['gzzc']; ?>

          <hr noshade color="#CCCCCC"></td>
    </tr>
    <tr>
      <td class="new"><strong>金钱理财</strong>:<img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['jqzs']; ?>
.gif"><br>
          <?php echo $this->_tpl_vars['rs']['zqlc']; ?>

          <hr noshade color="#CCCCCC"></td>
    </tr>
    <tr>
      <td class="new"><strong>恋爱婚姻</strong>:<img src="diary_book/images/x_<?php echo $this->_tpl_vars['rs']['lazs']; ?>
.gif"><br>
          <?php echo $this->_tpl_vars['rs']['lzfy']; ?>
</td>
    </tr>
  </tbody>
</table>
<?php elseif (( $this->_tpl_vars['yctype'] == 'yearlove' )): ?>  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td class="ttop">
<?php if (( $this->_tpl_vars['xing'] <> '' )):  echo $this->_tpl_vars['xing'];  echo $this->_tpl_vars['ming']; ?>
(<?php echo $this->_tpl_vars['nian1']; ?>
-<?php echo $this->_tpl_vars['yue1']; ?>
-<?php echo $this->_tpl_vars['ri1']; ?>
) 我的星座：<?php echo $this->_tpl_vars['myxz']; ?>

<?php endif; ?>
 当前星座：<?php echo $this->_tpl_vars['rs']['xzmc']; ?>
今年爱情运势</td>
    </tr>
  <tr>
    <td class="new">
      <table width="100%" border="0">
        <tr>
          <td width="16%"><img src="diary_book/images/xz_<?php echo $this->_tpl_vars['rs']['id']; ?>
.gif" width="100" height="100"></td>
          <td width="18%" class="new">  <span class="red"> <?php echo $this->_tpl_vars['rs']['xzmc']; ?>
<br>
        <?php echo $this->_tpl_vars['rs']['xzrq']; ?>
</span></td>
          <td width="66%" class="new"><span class="red">有效期限:(<?php echo $this->_tpl_vars['rs']['yxqx']; ?>
)</span></td>
        </tr>
      </table>
    </td>
    </tr>
  <tr>
    <td class="new"><strong>整体概况</strong>:<BR>
      <?php echo $this->_tpl_vars['rs']['ztzk']; ?>

      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>女生篇</strong>:<BR>
      <?php echo $this->_tpl_vars['rs']['nv']; ?>

      <hr noshade color="#CCCCCC"></td>
    </tr><tr>
    <td class="new"><strong>男生篇</strong>:<BR>
      <?php echo $this->_tpl_vars['rs']['nan']; ?>

     </td>
    </tr>
  <tr>

  
</tbody>
</table>
<?php endif; ?>