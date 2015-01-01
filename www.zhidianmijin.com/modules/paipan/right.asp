<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
  <TBODY>
       <tr>
      <TD class=ttop style="PADDING-BOTTOM: 1px" vAlign=top>黄道查询</TD>
    </tr>  <tr>
      <TD class=new3 vAlign=top><div class="date">			<select id="CalYear" onChange="javascript:ChgYear(this);">
									<script language="javascript" type="text/javascript">InitCalYear();</script>
								  </select>
									年
									<select id="CalMonth" onChange="javascript:ChgMonth(this);">
										<script language="javascript" type="text/javascript">InitCalMonth();</script>
									</select>
									月	
								</div></TD>
    </tr><tr>
      <TD class=new3 vAlign=top><div class="date">	
	
								<div id="CalBody"><script language="javascript" type="text/javascript">InitCalendar();</script></div></div></TD>
    </tr>
  </TBODY>
</TABLE><table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
  <TBODY>
       <tr>
      <TD colspan="2" vAlign=top class=ttop style="PADDING-BOTTOM: 1px">星座运程</TD>
    </tr> <tr>
      <TD colspan="2" vAlign=top class=new style="PADDING-BOTTOM: 8px"><div class="date">选择星座:
          <select id="obSelect" name="select">
            <option value="1">白羊座</option>
            <option value="2">金牛座</option>
            <option value="3">双子座</option>
            <option value="4">巨蟹座</option>
            <option value="5">狮子座</option>
            <option value="6">处女座</option>
            <option value="7">天秤座</option>
            <option value="8">天蝎座</option>
            <option value="9">射手座</option>
            <option value="10">摩羯座</option>
            <option value="11">水瓶座</option>
            <option value="12">双鱼座</option>
			    </select>
				  <script>
				function setSelect()
				{
						var v=getcookie('default_astro');
						var astro_id= v.substr(3,v.length);
						if (astro_id == "") astro_id=1;
						document.getElementById("ob_"+astro_id).selected = true;
				}
				setSelect();
			</script>
</div></TD>
    </tr>
    <tr>
      <TD class=new style="PADDING-BOTTOM: 8px" vAlign=top>·<A href="javascript:lucktoday()">今日运势</A></TD>
      <TD class=new style="PADDING-BOTTOM: 8px" vAlign=top>·<A href="javascript:lucktommorrow()">明日运势</A></TD>
    </tr>
    <tr>
      <TD class=new style="PADDING-BOTTOM: 8px" vAlign=top>·<A href="javascript:luckweek()">本周运势</A></TD>
      <TD class=new style="PADDING-BOTTOM: 8px" vAlign=top>·<A href="javascript:luckmonth()">本月运势</A></TD>
    </tr>
    <tr>
      <TD class=new style="PADDING-BOTTOM: 8px" vAlign=top>·<A href="javascript:luckyear()">本年运势</A></TD>
      <TD class=new style="PADDING-BOTTOM: 8px" vAlign=top>·<A href="../tarot.asp" target="_blank">塔罗占卜</A></TD>
    </tr>
  </TBODY>
</TABLE>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
  <TBODY>
    <tr>
      <TD colspan="3" vAlign=top class=ttop style="PADDING-BOTTOM: 1px">情侣配对</TD>
    </tr>
  <form action=../astro/astro_show.asp method=post target=_blank>
    <tr>
      <TD width="37%" vAlign=top class=new3 style="PADDING-BOTTOM: 8px"><input type=hidden name=flag value=1>
        <span class="new3" style="PADDING-BOTTOM: 8px">
        <select name="astro_m" id="astro_m"  style="width:65px">
          <option value="牡羊座">男白羊</option>
          <option>金牛座</option>
          <option>双子座</option>
          <option>巨蟹座</option>
          <option>狮子座</option>
          <option>处女座</option>
          <option>天秤座</option>
          <option>天蝎座</option>
          <option>射手座</option>
          <option>魔羯座</option>
          <option>水瓶座</option>
          <option>双鱼座</option>
        </select>
        </span></TD>
      <TD width="35%" vAlign=top class=new3 style="PADDING-BOTTOM: 8px"><span class="new" style="PADDING-BOTTOM: 8px">
        <select name="astro_f" style="width:65px">
          <option value="牡羊座">女白羊</option>
          <option>金牛座</option>
          <option>双子座</option>
          <option>巨蟹座</option>
          <option>狮子座</option>
          <option>处女座</option>
          <option>天秤座</option>
          <option>天蝎座</option>
          <option>射手座</option>
          <option>魔羯座</option>
          <option>水瓶座</option>
          <option>双鱼座</option>
        </select>
      </span></TD>
      <TD width="28%" vAlign=top class=new style="PADDING-BOTTOM: 8px"><span class="new" style="PADDING-BOTTOM: 8px">
        <input name="Input" type="submit" value="速配"/>
      </span></TD>
    </tr>
  </form>
  <form action=../astro/astro_show.asp method=post target=_blank>
    <tr>
      <TD class=new3 style="PADDING-BOTTOM: 8px" vAlign=top><input type=hidden name=flag value=2>
          <select name="astro_m">
            <option value="白羊座"  style="width:65px">男白羊</option>
            <option>金牛座</option>
            <option>双子座</option>
            <option>巨蟹座</option>
            <option>狮子座</option>
            <option>处女座</option>
            <option>天秤座</option>
            <option>天蝎座</option>
            <option>射手座</option>
            <option>魔羯座</option>
            <option>水瓶座</option>
            <option>双鱼座</option>
        </select></TD>
      <TD class=new3 style="PADDING-BOTTOM: 8px" vAlign=top><span class="new" style="PADDING-BOTTOM: 8px">
        <select name="astro_f">
          <option value="白羊座" style="width:65px">女白羊</option>
          <option>金牛座</option>
          <option>双子座</option>
          <option>巨蟹座</option>
          <option>狮子座</option>
          <option>处女座</option>
          <option>天秤座</option>
          <option>天蝎座</option>
          <option>射手座</option>
          <option>魔羯座</option>
          <option>水瓶座</option>
          <option>双鱼座</option>
        </select>
      </span></TD>
      <TD class=new style="PADDING-BOTTOM: 8px" vAlign=top><span class="new" style="PADDING-BOTTOM: 8px">
        <input name="Input" type="submit" value="互动"/>
      </span></TD>
    </tr>
  </form>
  <form action=../astro/astro_show.asp method=post target=_blank>
    <tr>
      <TD class=new3 style="PADDING-BOTTOM: 8px" vAlign=top><input type=hidden name=flag value=3>
          <span class="new3" style="PADDING-BOTTOM: 8px">
          <select name="xiao_m"  style="width:65px">
            <option value=鼠 selected>男鼠</option>
            <option>牛</option>
            <option>虎</option>
            <option>兔</option>
            <option>龙</option>
            <option>蛇</option>
            <option>马</option>
            <option>羊</option>
            <option>猴</option>
            <option>鸡</option>
            <option>狗</option>
            <option value=猪>猪</option>
          </select>
        </span></TD>
      <TD class=new3 style="PADDING-BOTTOM: 8px" vAlign=top><span class="new" style="PADDING-BOTTOM: 8px">
        <select name="xiao_f" style="width:65px">
          <option value=鼠 selected>女鼠</option>
          <option>牛</option>
          <option>虎</option>
          <option>兔</option>
          <option>龙</option>
          <option>蛇</option>
          <option>马</option>
          <option>羊</option>
          <option>猴</option>
          <option>鸡</option>
          <option>狗</option>
          <option value=猪>猪</option>
        </select>
      </span></TD>
      <TD class=new style="PADDING-BOTTOM: 8px" vAlign=top><span class="new" style="PADDING-BOTTOM: 8px">
        <input name="Input" type="submit" value="速配"/>
      </span></TD>
    </tr>
  </form>
  <tr>
    <td colspan="3"></TBODY>
</TABLE>