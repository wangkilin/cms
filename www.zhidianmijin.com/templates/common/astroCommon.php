
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
      <tr>
        <TD align="left" class=new style="PADDING-BOTTOM: 1px">
<?if ($xing<>"")?>
<?include file="common/astroIndexLink.php"?>
<?else?>
  <? if ($currentAstro) ?><p>当前星座：<font color=#990000><? $currentAstro ?></font></p> <? /if ?>
<form action="" method="post">查询我的星座:<select name="y" size="1" id="y" style="font-size: 9pt"> 
           <?selectStepOptions start=1900 end=$_thisYear selected=1980?>
          </select>年
<select name="m" size="1" id="m" style="font-size: 9pt">
  <?selectStepOptions start=1 end=12 selected=$_thisMonth?>
</select>月
<select name="d" size="1" id="d" style="font-size: 9pt">
  <?selectStepOptions start=1 end=31 selected=$_thisDay?>
</select>日(公历生日)
<input name="Input2" type="submit" value="查询" class="bot01"   /><input name="act" type="hidden" value="xzcx"><?if (isset($smarty.request.act) && $smarty.request.act=="xzcx")?>&nbsp;查询结果:<?$smarty.request.y|cat:"-"|cat:$smarty.request.m|cat:"-"|cat:$smarty.request.d|Constellation?></form>
<?/if?><?/if?></TD>
      </tr>
      <tr>
        <TD align="left" class=new style="PADDING-BOTTOM: 1px"><span class="red">星座详解</span>·<a href="?m=2&sm=1&flag=4&astro=白羊座">牡羊座</a>·<a href="?m=2&sm=1&flag=4&astro=金牛座">金牛座</a>·<a href="?m=2&sm=1&flag=4&astro=双子座">双子座</a>·<a href="?m=2&sm=1&flag=4&astro=巨蟹座">巨蟹座</a>·<a href="?m=2&sm=1&flag=4&astro=狮子座">狮子座</a>·<a href="?m=2&sm=1&flag=4&astro=处女座">处女座</a>·<a href="?m=2&sm=1&flag=4&astro=天秤座">天秤座</a>·<a href="?m=2&sm=1&flag=4&astro=天蝎座">天蝎座</a>·<a href="?m=2&sm=1&flag=4&astro=射手座">射手座</a>·<a href="?m=2&sm=1&flag=4&astro=魔羯座">魔羯座</a>·<a href="?m=2&sm=1&flag=4&astro=水瓶座">水瓶座</a>·<a href="?m=2&sm=1&flag=4&astro=双鱼座">双鱼座</a></TD>
      </tr>
    </TBODY>
  </TABLE>

