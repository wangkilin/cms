
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="inputInfoTable" style="table-layout:fixed;word-wrap:break-word;">
 <form method="post" action="" name="sm"  onSubmit="return checkbz();">  <TBODY>
       <tr>
      <TD class=ttop style="PADDING-BOTTOM: 1px" vAlign=top> 输入资料立刻开始免费电脑算命</TD>
    </tr> <tr>
      <TD class=new style="PADDING-BOTTOM: 8px" vAlign=top><font color=red><b>&nbsp;算命说明：</b></font>姓名必须输入中文，生日必须输入公历（公历即阳历/新历，农历即阴历/旧历。例如今天为<? $_thisYear ?>年<? $_thisMonth ?>月<? $_thisDay ?>日，这就是公历。）如果不分析血型，血型可任选；如果不分析八字等，出生时分可任选；不影响其它测试结果。进入系统后可体验数十种强大的算命功能！ <A href="javascript:;" class="red" onClick="window.external.AddFavorite('http://www.zhidianmijin.com','免费算命-指点迷津')">[<u>将【指点迷津】在线算命加入收藏夹！</u>]</A></TD>
    </tr>
    <tr>
      <TD class=new style="PADDING-BOTTOM: 8px" vAlign=top><div align="center"><a title="如果您只知道生日的农历日期，不要紧，请点这里去查询公历日期" style="CURSOR: hand" onClick="window.open('wannianli.htm','nongli','left=0,top=0,width=780,height=540,scrollbars=no,resizable=no,status=no')" href="#wnl"><font color="red">[只知道农历请点此查公历]</font></a>&nbsp;<a title="不知道出生时间怎么办" style="CURSOR: hand" onClick="window.open('htm_nobirth.htm','nobirth','left=0,top=0,width=600,height=480,scrollbars=yes,resizable=no,status=no')" href="#nobirth"><font color="red">[不知道出生时间怎么办]</font></a>&nbsp;</div></TD>
    </tr>
    <tr>
      <TD align="center" vAlign=top class=new style="PADDING-BOTTOM: 8px">姓：<input type="txt" name="xing" size="4" value="" onKeypress="if ((event.keyCode != 13 && event.keyCode < 160)) event.returnValue = false;">
  	名：<input type="txt" name="ming" size="4" value="" onKeypress="if ((event.keyCode != 13 && event.keyCode < 160)) event.returnValue = false;">
  	<select name="xingbie" size="1" style="font-size: 9pt">
	<option value="" selected>性别</option>
	<option value="男">男</option>
	<option value="女">女</option>
  	</select>
  	<select name="xuexing" size="1" style="font-size: 9pt">
  	<option value="">血型</option>
  	<option value="A">A型</option>
  	<option value="B">B型</option>
  	<option value="O">O型</option>
  	<option value="AB">AB型</option>
  	</select>
  	公历生日:
       <select name="nian" size="1" style="font-size: 9pt">
      ><?selectStepOptions start=1950 end=$_thisYear selected=1980?>
     </select>年
     <select size="1" name="yue" style="font-size: 9pt">
      <?selectStepOptions start=1 end=12 selected=$_thisMonth?>
     </select>月
     <select size="1" name="ri" style="font-size: 9pt">
      <?selectStepOptions start=1 end=31 selected=$_thisDay?>
     </select>日
     <select size="1" name="hh" style="font-size: 9pt">
       <?selectStepOptions start=1 end=23?>
     </select>点
     <select size="1" name="mm" style="font-size: 9pt">
       <option value="0">未知</option>
		<?selectStepOptions start=1 end=59?>
     </select>分 </TD>
    </tr>
    <tr>
      <TD align="center"  vAlign=middle class=new style="PADDING-BOTTOM: 8px">
	  &nbsp;<input type="submit" value="立刻算命" style='cursor:hand;COLOR: #ff0000;' class="button">
	  <input type="button" value="黄道查询" onClick="(location='?m=6&sm=6')" style="cursor:hand;" class="button" /> 
	  <input type="button" value="生肖运程" onClick="(location='?m=2')" style="cursor:hand;" class="button" />
	  <input type="button" value="星座运程" style='cursor:hand;' onClick="(location='?m=2&sm=9')" class="button"> <input type="button" value="灵签解运" onClick="(location='?m=3')" style="cursor:hand;COLOR: #0000ff;" class="button" />
	 <input type="button" value="解梦测字" onClick="(location='?m=3')" style="cursor:hand;COLOR: #0000ff;" class="button" />
</TD></tr>
  </TBODY></form>
</TABLE>