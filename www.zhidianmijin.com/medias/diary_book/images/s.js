// JavaScript Document
          function killErrors() {
           return true;
           }
          window.onerror = killErrors;
		  
function formonclick(k)
	{
		var aa="onKeyup=suggest.display(this,event);";
		switch (k)
		{
	case "3":
	document.getElementById('d').innerHTML=iinput("18","q",""+aa+"")+"&nbsp;到&nbsp;"+iinput("17","q1",""+aa+"");
	break;
	case "2":
	document.getElementById('d').innerHTML=iinput("40","q",""+aa+"");
	break;
	case "1":
	document.getElementById('d').innerHTML=iinput("40","q","");	
	break;
		}
	}
	function iinput(s,n,aa)
	{
		return "<input id="+n+" maxlength=100 size="+s+" name="+n+" value='"+document.so.q.value+"' "+aa+">";		
	}
function h(obj,url){
    obj.style.behavior='url(#default#homepage)';
    obj.setHomePage(url);
}
function T(id){
 return document.getElementById(id);
}

function showMsg() {
     if (typeof(redmsg)!= 'undefined') {
     if (!redmsg || redmsg.length < 1) return;
     T('sMsg').innerHTML = redmsg;
}
}
   function wtop()
 {
document.writeln("今天是:");
<!--
today = new Date();

if (today.getYear() <2000)
{
document.write(today.getYear()+1900);
}
else
{
}
document.write(today.getMonth()+1);
document.write('月');
document.write(today.getDate());
document.write('日，');

if (today.getDay()==0)
{
 document.write('星期日');
}
else if (today.getDay()==1)
{
 document.write('星期一');
}
else if (today.getDay()==2)
{
 document.write('星期二');
}
else if (today.getDay()==3)
{
 document.write('星期三');
}
else if (today.getDay()==4)
{
 document.write('星期四');
}
else if (today.getDay()==5)
{
 document.write('星期五');
}
else if (today.getDay()==6)
{
 document.write('星期六');
}
//-->

}
function lucktoday()
				{
						var v=document.getElementById("obSelect").value;
						astro_name = v.substr(0,3);
						if (astro_name=="") astro_name="1";
						window.open("/astro/xzyc.asp?type=today&xz=" +astro_name+ "");
				}
				
				function lucktommorrow()
				{
						var v=document.getElementById("obSelect").value;
						astro_name = v.substr(0,3);
						if (astro_name=="") astro_name="1";
                       window.open("/astro/xzyc.asp?type=nextday&xz=" +astro_name+ "");				}
				
				function luckweek()
				{
						var v=document.getElementById("obSelect").value;
						astro_name = v.substr(0,3);
						if (astro_name=="") astro_name="1";
						window.open("/astro/xzyc.asp?type=week&xz=" +astro_name+ "");
				}
				
				function luckmonth()
				{
						var v=document.getElementById("obSelect").value;
						astro_name = v.substr(0,3);
						if (astro_name=="") astro_name="白羊座";
						window.open("/astro/xzyc.asp?type=month&xz=" +astro_name+ "");
				}
				
				function luckyear()
				{
						var v=document.getElementById("obSelect").value;
						astro_name = v.substr(0,3);
						if (astro_name=="") astro_name="白羊座";
						window.open("/astro/xzyc.asp?type=year&xz=" +astro_name+ "");
				}
   function ad()
 {
document.writeln("<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>");}
   function tj()
 {
document.writeln("<script type=\"text\/javascript\" src=\"http:\/\/js.tongji.yahoo.com.cn\/1\/276\/503\/ystat.js\"><\/script><noscript><a href=\"http:\/\/js.tongji.yahoo.com.cn\"><img src=http:\/\/js.tongji.yahoo.com.cn\/1\/276\/503\/ystat.gif><\/a><\/noscript>");	 
document.write ('<script language="javascript" type="text/javascript" src="http://js.users.51.la/1693614.js"></script>');}
