<SCRIPT language=javascript>
    <!--
    function valid_checkdream(){
        if(  document.form1.word.value.length==""  )
        {window.alert("对不起，请输入梦的关键字！");
            document.form1.word.focus();
            return false;
        } ;
        if(  document.form1.word.value.length>20  )
        {window.alert("对不起，请将描述控制在20个字以内！");
            document.form1.word.focus();
            return false;
        } ;
        win = window.open('','dream','scrollbars=yes,top=0,left=0,width=580,height=510');
        form1.submit();
        return ;
    }
    //-->
</SCRIPT>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <tbody><tr>
        <td width="79%" class="ttd"><span class="red">周公解梦:</span><br>
            <br>
            周公，即周公旦，他是周成王的叔父，对于建立和完善周代的封建制度他有很大贡献。周公在儒家文化中享有崇高的地位，孔子以“吾不复梦见周公矣”之言，隐喻周代礼仪文化的失落。
        　　周公是一个在孔子梦中频频出现的人物，在儒教长期主导文化的中国，周公也就不可避免的直接与梦联系起来。梦，经常被成为“周公之梦”,或“梦见周公”。因此，周公解梦中的周公，即是周公旦。</td>
        <td width="21%" class="ttd"><img src="<? $siteTheme ?>/images/zg.gif" width="150" height="218"></td>
    </tr>
    <form method="post" action="?m=3&sm=8" name="form1" onSubmit="return valid_checkdream()" target="dream">
        <input type="hidden" name="act" value="ok" />
        <tr>
            <td colspan="2" class="new">
                请输入做梦内容的关键字 ：<input name="word" type="text" id="word" size="20" onKeyUp="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" maxLength="20">
                <select size="1" name="act">
                    <option selected="" value="1">简明</option>
                    <option value="2">详细</option>
                </select>  <input type="submit" name="Submit1" value="开始解梦" style="cursor:hand;">
            </form></td>
        </tr>
    </tbody>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <tbody><? section name=id loop=$list ?>
        <tr>
            <td width="12%" class="new">&nbsp;<strong><? $list[id][0] ?></strong></td><td width="88%" class="new">
			<? section name=id1 loop=$list[id][1] ?><A onClick="window.open(this.href,'','location=no,menu=no,scrollbars=yes,resizable=no,top=0,left=0,width=580,height=510');return false;" href="?m=3&sm=8&act=1&word=<? $list[id][1][id1] ?>" target="_blank"><? $list[id][1][id1] ?></A>&nbsp;
                <? /section ?>
            </td>
        </tr><? /section ?>
    </table>

