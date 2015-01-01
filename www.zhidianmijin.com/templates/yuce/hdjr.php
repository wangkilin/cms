
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
  <TBODY>
    <tr> <form name="form1" method="post" action="?m=6&sm=6">
    <input name="act" type="hidden" value="crz">
      <TD vAlign=top class=new style="PADDING-BOTTOM: 8px;width:100%">黄历查询:<select name="yy" size="1" id="yy" style="font-size: 9pt">
          >
          <?selectStepOptions start=$_thisYear end=2020 selected=$_thisYear?>
        </select>年
<select name="mm" size="1" id="mm" style="font-size: 9pt">
  <?selectStepOptions start=1 end=12 selected=$_thisMonth?>
</select>月
<select name="dd" size="1" id="dd" style="font-size: 9pt">
  <?selectStepOptions start=1 end=31 selected=$_thisDay?>
</select>日 <input type="submit" name="Submit" value="查询">        </TD></form>
    </tr>
    <tr>
       <form name="form1" method="post" action="?m=6&sm=6">
         <TD vAlign=top class=new style="PADDING-BOTTOM: 8px">选日子:<select name="upto" >
                <option value="3">3天以内</option>
                <option value="7">一周以内</option>
                <option value="30">一月以内</option>
                <option value="90">三月以内</option>
                <option value="180">半年内</option>
                <option value="365">今年内</option>
            </select>
            <select name="weekday" >
                <option value="-">星期？</option>
                <? foreach name=name key=i item=weekday from=$weeklyInfo ?>
                  <option value="<?$i?>"><?$weekday?></option>
                <? /foreach ?>
            </select>
           <select name="tp" size="1">
             <option value="0" ="">宜</option>
             <option value="1" ="">忌</option>
           </select>
           <select name="word" size="1">
<option value="开市" ="">开市</option>
<option value="交易" ="">交易</option>
<option value="嫁娶" ="">嫁娶</option>
<option value="入宅" ="">入宅</option>
<option value="入学" ="">入学</option>
<option value="纳财" ="">纳财</option>
<option value="订盟" ="">订盟</option>
<option value="安门" ="">安门</option>
<option value="出行" ="">出行</option>
<option value="开光" ="">开光</option>
<option value="求嗣" ="">求嗣</option>
<option value="祈福" ="">祈福</option>
<option value="破土" ="">破土</option>
<option value="祭祀" ="">祭祀</option>
<option value="安葬" ="">安葬</option>
</select>
<input type="submit" name="Submit2" value="查询">
<input name="Submit22" type="button" style="color:#FF0000" onClick="(location='?m=6&sm=6&act=xrz&word=嫁娶&upto=365&tp=0')" value="结婚吉日">
<input name="act" type="hidden" value="xrz"></TD>
       </form>
    </tr>
<?	if (isset($smarty.request.act) && $smarty.request.act=="crz") ?>
<tr>
      <TD colspan="2" vAlign=top class=new style="PADDING-BOTTOM: 8px"><strong>当日统览：</strong><span class="red"><? $cxdate ?> 农历:<? $rs.nn ?> <? $weeklyInfo[$rs.xq] ?> <?assign var="rsxz" value="`$rs.xz-1`"?><? $astroInfo[$rsxz] ?></span></TD>
        </tr>
 </TBODY>
</TABLE> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY><tr>
        <TD width="17%" vAlign=top class=new style="PADDING-BOTTOM: 8px"><strong>岁次</strong></TD>
        <TD width="83%" vAlign=top class=new style="PADDING-BOTTOM: 8px"><? $rs.suici ?></TD>
      </tr>
      <tr>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><STRONG>诸神方位</STRONG></TD>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px">喜神<? $zsfw.xs ?>
                                                             财神<? $zsfw.cs ?>
                                                             福神<? $zsfw.fs ?>
                                                             鹤神<? $zsfw.hs ?>
                                                             <br><? $zsfw.jxrsdj ?>
                                                             <br>凡喜神财神之位宜向之．鹤神宜避之．吉时宜用之．空亡时不可用．
        </TD>
      </tr>
      <tr>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><STRONG>每日胎神占方</STRONG></TD>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><? $rs.tszf ?></TD>
      </tr>
      <tr>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><STRONG>五行</STRONG></TD>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><? $rs.wuhang ?></TD>
      </tr>
      <tr>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><img src="<? $siteTheme ?>/images/ic01.gif" width="26" height="23"></TD>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><? $rs.cong ?></TD>
      </tr>
      <tr>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><STRONG>彭祖百忌</STRONG></TD>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><? $rs.pzbj ?></TD>
      </tr>
      <tr>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><STRONG>吉神宜趋</STRONG></TD>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><? $rs.jsyq ?></TD>
      </tr>
      <tr>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><img src="<? $siteTheme ?>/images/ic02.gif" width="26" height="23"></TD>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><? $rs.yi|replace:$word:"<font color=red><b>$word</b></font>" ?></TD>
      </tr>
      <tr>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><STRONG>凶神宜忌</STRONG></TD>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><? $rs.xsyq ?></TD>
      </tr>
      <tr>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><img src="<? $siteTheme ?>/images/ic03.gif" width="26" height="23"></TD>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><? $rs.ji|replace:$word:"<font color=blue><b>$word</b></font>" ?></TD>
      </tr>
      <tr>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><STRONG>详细时辰</STRONG></TD>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><? $rs.xx ?></TD>
      </tr>
      </TBODY>
  </TABLE>
  <? elseif (isset($smarty.request.act) && $smarty.request.act=="xrz") ?>
  <? if (!$allshu)  ?><tr>
      <TD colspan="2" vAlign=top class=new style="PADDING-BOTTOM: 8px"><strong>从<? $_nowDate ?>开始<? $upto ?>天内，没有符合要求 "<? $word ?>" 的记录</strong></TD>
        </tr>
 </TBODY>
</TABLE>
<? else ?>
<tr>
      <TD colspan="2" vAlign=top class=new style="PADDING-BOTTOM: 8px"><strong>从<? $_nowDate ?>开始<? $upto ?>天内，共有<? $allshu ?>个日子符合要求 "<? $word ?>"  <? if ($allshu>20)  ?>程序只列出最近20个记录<? /if ?></strong></TD>
        </tr>
 </TBODY>
</TABLE> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
    <? foreach name=name key=i item=rs from=$list ?>
      <tr>
        <TD width="6%" vAlign=top class=new style="PADDING-BOTTOM: 8px"><div align="center"><STRONG><? $i+1 ?></STRONG></div></TD>
        <TD width="94%" vAlign=top class=new style="PADDING-BOTTOM: 8px"><a href=?m=6&sm=6&yy=<?php?> echo substr($this->_tpl_vars['rs']['gn'],0, 4) <?/php?>&mm=<?php?> echo substr($this->_tpl_vars['rs']['gn'],5, 2) <?/php?>&dd=<?php?> echo substr($this->_tpl_vars['rs']['gn'],8, 2) <?/php?>&act=crz&word=<? $word ?>><font color=red>公元<? $rs.gn ?> , 农历 <? $rs.nn ?> <? $weeklyInfo[$rs.xq] ?> <?assign var="rsxz" value="`$rs.xz-1`"?><? $astroInfo[$rsxz] ?></font></a> </TD>
      </tr>
      <tr>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><img src="<? $siteTheme ?>/images/ic01.gif" width="26" height="23"></TD>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><? $rs.cong ?></TD>
      </tr>

      <tr>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><img src="<? $siteTheme ?>/images/ic02.gif" width="26" height="23"></TD>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><? $rs.yi|replace:$word:"<font color=red><b>$word</b></font>" ?></TD>
      </tr>
      <tr>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><img src="<? $siteTheme ?>/images/ic03.gif" width="26" height="23"></TD>
        <TD vAlign=top class=new style="PADDING-BOTTOM: 8px"><?$rs.ji|replace:$word:"<font color=blue><b>$word</b></font>" ?></TD>
      </tr>
      <tr>
        <TD colspan="2" vAlign=top class=new><hr noshade color="#CCCCCC"></TD>
        </tr>
        <? /foreach ?>
<? /if ?> 
      </TBODY>
  </TABLE>
  <? /if ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
  <TBODY>
    <tr>
      <TD align="left" class=new style="PADDING-BOTTOM:5px">黄历名词解释：<BR>
        <STRONG>嫁娶 </STRONG>：男娶女嫁，举行结婚大典的吉日 <STRONG><BR>
        祭祀 </STRONG>：指祠堂之祭祀、即拜祭祖先或庙寺的祭拜、神明等事 <STRONG><BR>
        安葬 </STRONG>：举行埋葬等仪式 <STRONG><BR>
        出行 </STRONG>：指外出旅行、观光游览 <STRONG><BR>
        祈福 </STRONG>：祈求神明降福或设醮还愿之事 <STRONG><BR>
        动土 </STRONG>：建筑时、第一次动起锄头挖土 <STRONG><BR>
        安床 </STRONG>：指安置睡床卧铺之意 <STRONG><BR>
        开光 </STRONG>：佛像塑成后、供奉上位之事 <STRONG><BR>
        纳采 </STRONG>：缔结婚姻的仪式、受授聘金 <STRONG><BR>
        入殓 </STRONG>：将尸体放入棺材之意 <STRONG><BR>
        移徙 </STRONG>：指搬家迁移住所之意 <STRONG><BR>
        破土 </STRONG>：仅指埋葬用的破土、与一般建筑房屋的“动土”不同，即“破土”属阴宅，“动土”属阳宅也。现今社会上多已滥用属阴宅择日时属阴宅须辨别之。 <STRONG><BR>
        解除 </STRONG>：指冲洗清扫宅舍、解除灾厄等事 <STRONG><BR>
        入宅 </STRONG>：即迁入新宅、所谓“新居落成典礼”也 <STRONG><BR>
        修造 </STRONG>：指阳宅之造与修理 <STRONG><BR>
        栽种 </STRONG>：种植物“接果”“种田禾”同 <STRONG><BR>
        开市 </STRONG>：“开业”之意，商品行号开张做生意“开幕典礼”“开工”同。包括：(1)年头初开始营业或开工等事(2)新设店铺商行或新厂开幕等事 <STRONG><BR>
        移柩 </STRONG>：行葬仪时、将棺木移出屋外之事 <STRONG><BR>
        订盟 </STRONG>：订婚仪式的一种，俗称小聘(订) <STRONG><BR>
        拆卸 </STRONG>：拆掉建筑物 <STRONG><BR>
        立卷 </STRONG>：订立各种契约互相买卖之事 <STRONG><BR>
        交易 </STRONG>：订立各种契约互相买卖之事 <STRONG><BR>
        求嗣 </STRONG>：指向神明祈求后嗣(子孙)之意 <STRONG><BR>
        上梁 </STRONG>：装上建筑物屋顶的梁，同架马 <STRONG><BR>
        纳财 </STRONG>：购屋产业、进货、收帐、收租、讨债、贷款、五谷入仓等 <STRONG><BR>
        起基 </STRONG>：建筑时、第一次动起锄头挖土 <STRONG><BR>
        斋醮 </STRONG>：庙宇建醮前需举行的斋戒仪式 <STRONG><BR>
        赴任 </STRONG>：走马上任 <STRONG><BR>
        冠笄 </STRONG>：男女年满二十岁所举行的成年礼仪式 <STRONG><BR>
        安门 </STRONG>：放置正门门框 <STRONG><BR>
        修坟 </STRONG>：修理坟墓 <STRONG><BR>
        挂匾 </STRONG>：指悬挂招牌或各种匾额 </TD>
    </tr>
  </TBODY>
</TABLE>