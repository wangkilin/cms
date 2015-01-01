function checkbz()
{
var year=document.sm.nian.value;
var month=document.sm.yue.value;
var day=document.sm.ri.value;
var hour=document.sm.hh.value;
var now=new Date();
var nowyear=now.getYear();
var nowmonth=now.getMonth();
if (year=='')
{
alert('请选择出生年份！');
document.sm.nian.focus()
return false;
}
//if (year>nowyear || year <=nowyear-100 || isNaN(year))
if (year <=nowyear-100 || isNaN(year))
{
alert('请选择正确的出生年份！');
document.sm.nian.focus()
return false;
}
if ( month=='')
{
alert('请选择出生月份！');
document.sm.yue.focus()
return false;
}
if (day=='')
{
alert('请选择出生日期！');
document.sm.ri.focus()
return false;
}
if ((month==2 && day>29) || ((month==1 || month==3 || month==5 || month==7 || month==8 || month==10|| month==12) && day>31) || ((month==4 || month==6 || month==9 || month==11 ) && day>30))
{
alert('请选择正确的出生日期！');
document.sm.ri.focus()
return false;
}
if ( hour=='')
{
alert('请选择出生时间！');
document.sm.hh.focus()
return false;
}
while(document.sm.xing.value.indexOf(" ")!=-1){
document.sm.xing.value=document.sm.xing.value.replace(" ","");
}
while(document.sm.xing.value.indexOf("	")!=-1){
document.sm.xing.value=document.sm.xing.value.replace("	","");
}
if (document.sm.xing.value=='')
{
alert('请输入您的姓氏！');
document.sm.xing.focus()
return false;
}
if (document.sm.xing.value.length < 1 || document.sm.xing.value.length>2)
{
alert("错误：姓氏应在1-2个字之间！");
document.sm.xing.focus();
return (false);
}

while(document.sm.ming.value.indexOf(" ")!=-1){
document.sm.ming.value=document.sm.ming.value.replace(" ","");
}
while(document.sm.ming.value.indexOf("	")!=-1){
document.sm.ming.value=document.sm.ming.value.replace("	","");
}
if (document.sm.ming.value=='')
{
alert('请输入您的名字！');
document.sm.ming.focus()
return false;
}
if (document.sm.ming.value.length < 1 || document.sm.ming.value.length>2)
{
alert("错误：名字应在1-2个字之间！");
document.sm.ming.focus();
return (false);
}
var b=document.sm.xingbie.value;
if (b=='')
{
alert('请选择您的性别！');
document.sm.xingbie.focus()
return false;
}
}

/*
(function($) {
    jQuery.extend({
        masterFox: {
			setCss: function () {
			}

			        }
    });

    //
    // Initialization after DOM ready
    //
    $(function() {
        $.each($('.rootMenu'), function() {
			$(this).click(function(){
				$.each($('.rootMenu > ul'), function(){$(this).hide();});
				$(this).find('ul:first').show();
			});
		});
    });
})(jQuery);
*/