  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
      <tr>
        <TD class=new style="PADDING-BOTTOM: 1px" vAlign=top>点击星座查看运程
          (<a href="?m=2&sm=9&type=today&xz=<?$xz?>">今日</a> <a href="?m=2&sm=9&type=nextday&xz=<?$xz?>">明日</a> <a href="?m=2&sm=9&type=week&xz=<?$xz?>">本周</a> <a href="?m=2&sm=9&type=month&xz=<?$xz?>">本月</a> <a href="?m=2&sm=9&type=year&xz=<?$xz?>">今年</a> <a href="?m=2&sm=9&type=yearlove&xz=<?$xz?>">今年爱情运势</a>) </TD>
      </tr>
      <tr>
        <TD class=new style="PADDING-BOTTOM: 1px" vAlign=top><span class="new" style="PADDING-BOTTOM: 1px">·<a href="?m=2&sm=9&type=<?$yctype ?>&xz=1">牡羊座</a>·<a href="?m=2&sm=9&type=<?$yctype ?>&xz=2">金牛座</a>·<a href="?m=2&sm=9&type=<?$yctype ?>&xz=3">双子座</a>·<a href="?m=2&sm=9&type=<?$yctype ?>&xz=4">巨蟹座</a>·<a href="?m=2&sm=9&type=<?$yctype ?>&xz=5">狮子座</a>·<a href="?m=2&sm=9&type=<?$yctype ?>&xz=6">处女座</a>·<a href="?m=2&sm=9&type=<?$yctype ?>&xz=7">天秤座</a>·<a href="?m=2&sm=9&type=<?$yctype ?>&xz=8">天蝎座</a>·<a href="?m=2&sm=9&type=<?$yctype ?>&xz=9">射手座</a>·<a href="?m=2&sm=9&type=<?$yctype ?>&xz=10">魔羯座</a>·<a href="?m=2&sm=9&type=<?$yctype ?>&xz=11">水瓶座</a>·<a href="?m=2&sm=9&type=<?$yctype ?>&xz=12">双鱼座</a></span></TD>
      </tr>
    </TBODY>
  </TABLE>

  <? if ($yctype=="today") ?>
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td colspan="6" class="ttop">
<? if ($xing<>"") ?>
<?$xing?><?$ming?>(<?$nian1 ?>-<?$yue1 ?>-<?$ri1 ?>) 我的星座：<?$myxz?>
<?/if?>

 当前星座：<?$rs.xzmc?>今日运程</td>
    </tr>
  <tr>
    <td width="17%" rowspan="4" class="new"><img src="<? $siteTheme ?>/images/xz_<?$rs.id ?>.gif" width="100" height="100"><br>      </td>
    <td width="14%" rowspan="4" class="new"><span class="red"><?$rs.xzmc?><br>
        <?$rs.xzrq?></span></td>
    <td width="16%" bgcolor="e7e7e7" class="new">爱情运势:</td>
    <td width="24%" class="new"><img src="<? $siteTheme ?>/images/x_<?$rs.aqys?>.gif"></td>
    <td width="14%" bgcolor="e7e7e7" class="new">综合运势:</td>
    <td width="15%" class="new"><img src="<? $siteTheme ?>/images/x_<?$rs.zhys?>.gif"></td>
  </tr>
  <tr>
    <td bgcolor="e7e7e7" class="new">工作状况:</td>
    <td class="new"><img src="<? $siteTheme ?>/images/x_<?$rs.gzzk?>.gif"></td>
    <td bgcolor="e7e7e7" class="new">理财投资:</td>
    <td class="new"><img src="<? $siteTheme ?>/images/x_<?$rs.nctz?>.gif"></td>
  </tr>
  <tr>
    <td bgcolor="e7e7e7" class="new">健康指数:</td>
    <td class="new"><?$rs.jkzs?></td>
    <td bgcolor="e7e7e7" class="new">商谈指数:<br>    </td>
    <td class="new"><?$rs.stzs?></td>
  </tr>
  <tr>
    <td bgcolor="e7e7e7" class="new">幸运数字:</td>
    <td class="new"><?$rs.xysz?></td>
    <td bgcolor="e7e7e7" class="new">速配星座:</td>
    <td class="new"><?$rs.spxz?></td>
  </tr>
  <tr>
    <td colspan="6" class="new"><?$rs.zhpg?><div align="right"><br>
      有效日期：<?$rs.yxqx?></div></td>
    </tr>
</tbody>
</table><?elseif ($yctype=="nextday") ?>  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td colspan="6" class="ttop">
<?if ($xing<>"") ?>
<?$xing?><?$ming?>
(<?$nian1 ?>-<?$yue1 ?>-<?$ri1 ?>) 我的星座：<?$myxz ?>
<?/if?>
 当前星座：<?$rs.xzmc?>明日运程</td>
    </tr>
  <tr>
    <td width="17%" rowspan="4" class="new"><img src="<? $siteTheme ?>/images/xz_<?$rs.id?>.gif" width="100" height="100"><br>      </td>
    <td width="14%" rowspan="4" class="new"><span class="red"><?$rs.xzmc?><br>
        <?$rs.xzrq?></span></td>
    <td width="16%" bgcolor="e7e7e7" class="new">爱情运势:</td>
    <td width="24%" class="new"><img src="<? $siteTheme ?>/images/x_<?$rs.aqys?>.gif"></td>
    <td width="14%" bgcolor="e7e7e7" class="new">综合运势:</td>
    <td width="15%" class="new"><img src="<? $siteTheme ?>/images/x_<?$rs.zhys?>.gif"></td>
  </tr>
  <tr>
    <td bgcolor="e7e7e7" class="new">工作状况:</td>
    <td class="new"><img src="<? $siteTheme ?>/images/x_<?$rs.gzzk?>.gif"></td>
    <td bgcolor="e7e7e7" class="new">理财投资:</td>
    <td class="new"><img src="<? $siteTheme ?>/images/x_<?$rs.nctz?>.gif"></td>
  </tr>
  <tr>
    <td bgcolor="e7e7e7" class="new">健康指数:</td>
    <td class="new"><?$rs.jkzs?></td>
    <td bgcolor="e7e7e7" class="new">商谈指数:<br>    </td>
    <td class="new"><?$rs.stzs?></td>
  </tr>
  <tr>
    <td bgcolor="e7e7e7" class="new">幸运数字:</td>
    <td class="new"><?$rs.xysz?></td>
    <td bgcolor="e7e7e7" class="new">速配星座:</td>
    <td class="new"><?$rs.spxz?></td>
  </tr>
  <tr>
    <td colspan="6" class="new"><?$rs.zhpg?><div align="right"><br>
      有效日期：<? $rs.yxqx?></div></td>
    </tr>
</tbody>
</table><? elseif ($yctype=="week")  ?>  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td class="ttop">
<? if ($xing<>'')?>
<?$xing?><?$ming?>(<?$nian1 ?>-<?$yue1 ?>-<?$ri1 ?>) 我的星座：<?$myxz ?>
<?/if?>
 当前星座：<?$rs.xzmc?>本周运程</td>
    </tr>
  <tr>
    <td class="new">
      <table width="100%" border="0">
        <tr>
          <td width="16%"><img src="<? $siteTheme ?>/images/xz_<?$rs.id?>.gif" width="100" height="100"></td>
          <td width="20%" class="new">  <span class="red"> <?$rs.xzmc?><br>
        <?$rs.xzrq?></span></td>
          <td width="64%" class="new"><span class="red"><?$rs.title?>(<?$rs.yxqx?>)</span></td>
        </tr>
      </table>
    </td>
    </tr>
  <tr>
    <td class="new"><strong>整体运势</strong>:<img src="<? $siteTheme ?>/images/x_<?$rs.ztzs?>.gif"><BR>
      <?$rs.ztys?>
      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>爱情运势</strong>:<br>
      有对象:<img src="<? $siteTheme ?>/images/x_<?$rs.aqzs1?>.gif"><BR>
      <?$rs.aqys1?><br>
      没对象:<img src="<? $siteTheme ?>/images/x_<?$rs.aqzs2?>.gif"><BR>
      <?$rs.aqys2?>
      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>健康运势</strong>:<img src="<? $siteTheme ?>/images/x_<?$rs.jkzs?>.gif"><BR>
      <?$rs.jkys?>
      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>工作学业运</strong>:<img src="<? $siteTheme ?>/images/x_<?$rs.gzzs?>.gif"><BR>
      <?$rs.gzys?>
      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>性欲指数</strong>:<img src="<? $siteTheme ?>/images/x_<?$rs.xyzs?>.gif"><BR>
      <?$rs.xyys?>
      <hr noshade color="#CCCCCC"></td>
  </tr>
  <tr>
    <td class="new"><strong>红心日</strong>: <?$rs.hxri?><BR>
      <?$rs.hxsm?>
      <hr noshade color="#CCCCCC"></td>
  </tr>
  <tr>
    <td class="new"><strong>黑梅日</strong>: <?$rs.hmri?><BR>
      <?$rs.hmsm?></td>
  </tr>
</tbody>
</table>
<? elseif ($yctype=="month")  ?>  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td class="ttop">
<?if ($xing<>'') ?>
<?$xing?><?$ming?>(<?$nian1 ?>-<?$yue1 ?>-<?$ri1 ?>) 我的星座：<?$myxz ?>
<?/if?>
 当前星座：<?$rs.xzmc?>本月运程</td>
    </tr>
  <tr>
    <td class="new">
      <table width="100%" border="0">
        <tr>
          <td width="16%"><img src="<? $siteTheme ?>/images/xz_<?$rs.id?>.gif" width="100" height="100"></td>
          <td width="20%" class="new">  <span class="red"> <?$rs.xzmc?><br>
        <?$rs.xzrq?></span></td>
          <td width="64%" class="new"><span class="red">有效日期:(<?$rs.yxqx?>)</span></td>
        </tr>
      </table>
    </td>
    </tr>
  <tr>
    <td class="new"><strong>整体运势</strong>:<img src="<? $siteTheme ?>/images/x_<?$rs.ztzs?>.gif"><BR>
      <?$rs.ztys?>
      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>爱情运势</strong>:<img src="<? $siteTheme ?>/images/x_<?$rs.aqzs?>.gif"><BR>
      <?$rs.aqys?>
      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>投资理财运</strong>:<img src="<? $siteTheme ?>/images/x_<?$rs.tzzs?>.gif"><BR>
      <?$rs.tzys?>
      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>解压方式</strong>:<BR>
      <?$rs.jyfs?>
      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>幸运物</strong>:<BR>
      <?$rs.xyw?></td>
  </tr>
  
</tbody>
</table>
<? elseif ($yctype=="year")  ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
  <tbody>
    <tr>
      <td class="ttop"><? if ($xing<>'') ?>

          <?$xing?><?$ming?>(<?$nian1 ?>-<?$yue1 ?>-<?$ri1 ?>) 我的星座：<?$myxz ?>
        <?/if?>
        当前星座：<?$rs.xzmc?>今年运程</td>
    </tr>
    <tr>
      <td class="new"><table width="100%" border="0">
        <tr>
          <td width="16%"><img src="<? $siteTheme ?>/images/xz_<?$rs.id?>.gif" width="100" height="100"></td>
          <td width="18%" class="new"><span class="red"> <?$rs.xzmc?><br>
                  <?$rs.xzrq?></span></td>
          <td width="66%" class="new"><span class="red"><?$rs.title?>(<?$rs.yxqx?>)</span></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td class="new"><strong>整体概况</strong>:<img src="<? $siteTheme ?>/images/x_<?$rs.ztzs?>.gif"><br>
          <?$rs.ztzk?>
          <hr noshade color="#CCCCCC"></td>
    </tr>
    <tr>
      <td class="new"><strong>功课学业</strong>:<img src="<? $siteTheme ?>/images/x_<?$rs.gkzs?>.gif"><br>
          <?$rs.gkxy?>
          <hr noshade color="#CCCCCC"></td>
    </tr>
    <tr>
      <td class="new"><strong>工作职场</strong>:<img src="<? $siteTheme ?>/images/x_<?$rs.gzzs?>.gif"><br>
          <?$rs.gzzc?>
          <hr noshade color="#CCCCCC"></td>
    </tr>
    <tr>
      <td class="new"><strong>金钱理财</strong>:<img src="<? $siteTheme ?>/images/x_<?$rs.jqzs?>.gif"><br>
          <?$rs.zqlc?>
          <hr noshade color="#CCCCCC"></td>
    </tr>
    <tr>
      <td class="new"><strong>恋爱婚姻</strong>:<img src="<? $siteTheme ?>/images/x_<?$rs.lazs?>.gif"><br>
          <?$rs.lzfy?></td>
    </tr>
  </tbody>
</table>
<? elseif ($yctype=="yearlove")  ?>  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td class="ttop">
<?if ($xing<>'')?><?$xing?><?$ming?>(<?$nian1 ?>-<?$yue1 ?>-<?$ri1 ?>) 我的星座：<?$myxz ?>
<?/if?>
 当前星座：<?$rs.xzmc?>今年爱情运势</td>
    </tr>
  <tr>
    <td class="new">
      <table width="100%" border="0">
        <tr>
          <td width="16%"><img src="<? $siteTheme ?>/images/xz_<?$rs.id?>.gif" width="100" height="100"></td>
          <td width="18%" class="new">  <span class="red"> <?$rs.xzmc?><br>
        <?$rs.xzrq?></span></td>
          <td width="66%" class="new"><span class="red">有效期限:(<?$rs.yxqx?>)</span></td>
        </tr>
      </table>
    </td>
    </tr>
  <tr>
    <td class="new"><strong>整体概况</strong>:<BR>
      <?$rs.ztzk?>
      <hr noshade color="#CCCCCC"></td>
    </tr>
  <tr>
    <td class="new"><strong>女生篇</strong>:<BR>
      <?$rs.nv?>
      <hr noshade color="#CCCCCC"></td>
    </tr><tr>
    <td class="new"><strong>男生篇</strong>:<BR>
      <?$rs.nan?>
     </td>
    </tr>
  <tr>

  
</tbody>
</table>
<?/if?>