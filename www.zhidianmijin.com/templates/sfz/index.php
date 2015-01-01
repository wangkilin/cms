<?php
require_once('../inc/conn.php');
require_once('../inc/function.php');
?>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<TITLE>身份证算命 -- 在线算命 电脑算命 姓名测试 免费占卜 星座运程 姓名测试</TITLE>
<?php include('./top.php'); ?>
<div id="right">
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
      <TD class=new style="PADDING-BOTTOM: 8px" vAlign=top>·<A href="../tarot.php" target="_blank">塔罗占卜</A></TD>
    </tr>
  </TBODY>
</TABLE>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
  <TBODY>
    <tr>
      <TD colspan="3" vAlign=top class=ttop style="PADDING-BOTTOM: 1px">情侣配对</TD>
    </tr>
  <form action=../astro/astro_show.php method=post target=_blank>
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
  <form action=../astro/astro_show.php method=post target=_blank>
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
  <form action=../astro/astro_show.php method=post target=_blank>
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
</div>
<div id="left">
<div style="width:100%">

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
<tbody><tr>
  <td width="100%" class="new">
<link type="text/css" rel="stylesheet" href="../images/css.css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
.style3 {
	color: #FFFFFF;
	font-weight: bold;
}
.style5 {color: #FFFFFF}
.style6 {color: #000000}
-->
</style>
<table width=760 align=center >
<tr>
  <td align=left valign="top"><form action="index.php" name=form1 method=post>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="30" ><p>　　自古有云：谋事在人，成事在天。究竟我们可否争取主动，反过来操控自己的命运呢？答案是肯定的。现在我们就提供身份证来测试你的性格、爱情、事业与未来，让你更能掌握未来，迈出成功的第一步。<br />
        　　只要凭身份证上的号码，便可推算出你一生的命运，十分奇妙！<br />
        <br /></td>
    </tr>
    <tr>
        <td width="37%" height="30" valign="middle" align=center><p>
          身份证号码:
          <input name=xian size=18 type=text>
          <input name=submit type=submit value="开始测试">
          (请输入15位或者18位号码)</p>
          <p>&nbsp;</p></td>
    </tr>
  </table>
</form>

</td></tr>
</table>

<table align=center border="0" cellpadding="3" cellspacing="1" width="450"  bgcolor="#0099FF">

<?php

$xian=$_REQUEST['xian'];
$lenx=strlen($xian);
if ($xian>0) {

if (!is_numeric(substr($xian, 0, 15))) {
  echo( "<script>alert('请输入正确身份证号码!');window.history.back();</script>");
}

if ($lenx==15 or $lenx==18) { 
    if ($lenx==15) { 
        $yy="19" . substr($xian,6,2);
        $mm=substr($xian,8,2);
        $dd=substr($xian,10,2);
        $aa=substr($xian,14,1);
    } else { 
        $yy=substr($xian,6,4);
        $mm=substr($xian,10,2);
        $dd=substr($xian,12,2);
        $aa=substr($xian,16,1);
    } 
    if (intval($mm)>12 or intval($dd)>31) {
      echo "<script>alert('请输入正确的身份证号码!');window.history.back();</script>";
    }  
} else {
  echo "<script>alert('请输入正确的身份证号码!');window.history.back();</script>";
}



      $sql="select * from sfz where bm=" . substr($xian,0, 6);
      rs.open sql,conn,3,3
     
      if not rs.eof then
     
   
%>
<%
if aa mod 2=0 then 
  xb="女"
  else
  xb="男"
end if 

%>
<tr><td bgcolor=ffffff>
查询号码：<%=xian%></td></tr><td bgcolor=ffffff>
原户籍地：<%=rs("dq")%><br></td></tr><td bgcolor=ffffff>
出生年月：<%=yy&"年"&mm&"月"&dd&"日"%><br></td></tr><td bgcolor=ffffff>
性&nbsp;&nbsp;&nbsp;&nbsp;别：<%=xb%>
<%
if lenx=18 then
if substr($xian,18,1)<>cstr(sfzjy(xian)) then
  response.write "</td></tr><td bgcolor=ffffff>"
  response.write "<font color='#FF0000'>提示：身份证校验错误!可能为假！</font>"
  xian=""
  else
   response.write "</td></tr><td bgcolor=ffffff>"
   response.write "结果：身份证号码校验为合法号码!"
   'response.write xian 
end if
  else
  response.write "</td></tr><td bgcolor=ffffff>"
  response.write "新身份证："&left(xian,6)&"19"&right(xian,9)&cstr(sfzjy(xian))
  xian=left(xian,6)&"19"&right(xian,9)&cstr(sfzjy(xian))
  'response.write xian
end if
%>
</td>
</tr>
<%
     n1=substr($xian,7,1)
	 n2=substr($xian,8,1)
	 y1=substr($xian,9,1)
	 y2=substr($xian,10,1)
	 r1=substr($xian,11,1)
	 r2=substr($xian,12,1)
	'年的单双取值 
	  n=cInt(n1)+cInt(n2) 
	  if len(n)=2 then
	     n=cInt(substr($n,1,1))+cInt(substr($n,2,1))
	  end if
	 
	  n=n mod 2
	  if n=0 then 
	    n="双"
	  else 
	    n="单"
	  end if
	  '月的单双取值
	  	  y=cInt(y1)+cInt(y2) 
	  if len(y)=2 then
	     y=cInt(substr($y,1,1))+cInt(substr($y,2,1))
	  end if
	 ' response.Write "这是日的结果"&r
	  y=y mod 2
	  if y=0 then 
	    y="双"
	  else 
	    y="单" 
	  end if
	  '日的单双取值
	  r=cInt(r1)+cInt(r2) 
	  if len(r)=2 then
	     r=cInt(substr($r,1,1))+cInt(substr($r,2,1))
	  end if
	  
	  r=r mod 2
	  if r=0 then 
	    r="双"
	  else 
	    r="单" 
	  end if
	  testnum=n+y+r
	 'response.Write "这是数据的结果"&testnum
	set rs1=server.createobject("adodb.recordset")
      sql="select * from test where testnum='"&testnum&"'"
      rs1.open sql,conn,1,1
     response.write "<tr><td bgcolor=ffffff>测试结果：</td></tr>"
      if not rs1.eof then
	  response.write "<tr><td bgcolor=ffffff>"&rs1("content")&"</td></tr>"
	  else
	  response.write "<tr><td bgcolor=ffffff>　　芸芸众生，竟无此人，无从进行命运推理！请施主输入正确的身份证再行测运，实诚功德无量！</td></tr>"
	  end if
  %>
</table>
<%
          end if 
rs.close
set rs=nothing
  conn.close
set conn=nothing
end if 

FUNCTION sfzjy(num)

 if len(num)=15 then
cID = left(num,6)&"19"&right(num,9)
  elseif len(num)=17 or len(num)=18 then
cID = left(num,17)
  end if 

nSum=substr($cID,1,1) * 7
nSum=nsum+substr($cID,2,1) * 9 
nSum=nsum+substr($cID,3,1) * 10 
nSum=nsum+substr($cID,4,1) * 5 
nSum=nsum+substr($cID,5,1) * 8 
nSum=nsum+substr($cID,6,1) * 4
nSum=nsum+substr($cID,7,1) * 2
nSum=nsum+substr($cID,8,1) * 1
nSum=nsum+substr($cID,9,1) * 6
nSum=nsum+substr($cID,10,1) * 3
nSum=nsum+substr($cID,11,1) * 7
nSum=nsum+substr($cID,12,1) * 9
nSum=nsum+substr($cID,13,1) * 10
nSum=nsum+substr($cID,14,1) * 5
nSum=nsum+substr($cID,15,1) * 8
nSum=nsum+substr($cID,16,1) * 4
nSum=nsum+substr($cID,17,1) * 2
'*计算校验位
 check_number=12-nsum mod 11
 If check_number=10 then
     check_number="X"
  elseIf check_number=12 then
     check_number="1"
  elseif check_number=11 then
     check_number="0"
 End if
 sfzjy=check_number
End function
%>
</td>
    </tr>
</table>
</td>
    </tr>  <TBODY>
</table>  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
  <TBODY>
    <tr>
      <TD align="left" class=new style="PADDING-BOTTOM:5px"><script src="../images/urlcopy.js"></script></TD>
    </tr>
  </TBODY>
</TABLE>
</div>
</div>
<!--#include file="../foot.php"-->

</body></html>