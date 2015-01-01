<SCRIPT language=javascript>
    <!--
    function valid_checkdream(){
        if(  document.formjm.word.value.length==""  )
        {window.alert("对不起，请输入梦的关键字！");
            document.formjm.word.focus();
            return false;
        } ;
        if(  document.formjm.word.value.length>20  )
        {window.alert("对不起，请将描述控制在20个字以内！");
            document.formjm.word.focus();
            return false;
        } ;
        win = window.open('','dream','scrollbars=yes,top=0,left=0,width=580,height=510');
        formjm.submit();
        return ;
    }
    function submitchecken() {
        if (document.formzw.zwdm.value == "") {
            alert("请输入您的指纹代码！");
            document.formzw.zwdm.focus();
            return false;
        }
        if (document.formzw.zwdm.value.length != 5) {
            alert("指纹代码输入出错，应该为5个X或O的字母！");
            document.formzw.zwdm.focus();
            return false;
        }
        return true;
    }
    function Check(theForm)
    {
        var name1 = theForm.name1.value;
        if (name1 == "")
        {
            alert("请输入三个简体汉字进行测算！");
            theForm.name1.value="";
            theForm.name1.focus();
            return false;
        }
        if (name1.search(/[`1234567890-=\~!@#$%^&*()_+|<>;':",.?/ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz]/) != -1)
        {
            alert("请务必输入简体汉字！");
            theForm.name1.value = "";
            theForm.name1.focus();
            return false;
        }
    }
    function Check2(theForm)
    {
        var name2 = theForm.name2.value;
        if (name2 == "")
        {
            alert("请输入三个繁体汉字进行测算！");
            theForm.name2.value="";
            theForm.name2.focus();
            return false;
        }
        if (name2.search(/[`1234567890-=\~!@#$%^&*()_+|<>;':",.?/ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz]/) != -1)
        {
            alert("请务必输入繁体汉字！");
            theForm.name2.value = "";
            theForm.name2.focus();
            return false;
        }
    }
    function checkjx()
    {
        var word=document.theform.word.value;
        if (word=='' || word.length>20)
        {
            alert('请输入20位以内的数字！');
            document.theform.word.focus()
            return false;
        }
    }
    //-->
</SCRIPT>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
        <tr>
            <TD vAlign=top class=new style="PADDING-BOTTOM: 8px">介绍：本类测试主要是有关于在线算命的内容。包括观音灵签、黄大仙灵签、吕祖灵签、妈祖灵签、关帝灵签五大在线占卜测试。你可以从本类测试到各种类型的在线占卜。免费网上求签、免费在线解签、占卜算命。这是一个综合类的在线占卜大全，各种灵签占卜一应俱全，你一定能在这里找到自己需要的测试。</TD>
        </tr>
    </TBODY>
</TABLE>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
        <tr>
            <TD colspan="3"  vAlign=top class=ttop style="PADDING-BOTTOM: 1px">求神问卦</TD>
        </tr>
        <tr>
            <TD align="center" vAlign=top class=new style="PADDING-BOTTOM: 1px"><a href="?m=3&sm=2"><img src="<? $siteTheme ?>/images/gylq.gif" width="176" height="89" border="0"></a></TD>
            <TD align="center" vAlign=top class=new style="PADDING-BOTTOM: 1px"><a href="?m=3&sm=4"><img src="<? $siteTheme ?>/images/yzlq.gif" width="172" height="88" border="0"></a></TD>
            <TD align="center" vAlign=top class=new style="PADDING-BOTTOM: 1px"><a href="?m=3&sm=3"><img src="<? $siteTheme ?>/images/dxlq.gif" width="174" height="88" border="0"></a></TD>
        </tr>
        <tr>
            <TD align="center" vAlign=top class=new style="PADDING-BOTTOM: 1px"><a href="?m=3&sm=1"><img src="<? $siteTheme ?>/images/dmgdm.gif" width="174" height="88" border="0"></a></TD>
            <TD align="center" vAlign=top class=new style="PADDING-BOTTOM: 1px"><a href="?m=3&sm=5"><img src="<? $siteTheme ?>/images/thlq.gif" width="174" height="86" border="0"></a></TD>
            <TD align="center" vAlign=top class=new style="PADDING-BOTTOM: 1px">&nbsp;</TD>
        </tr>
    </TBODY>
</TABLE>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
    <TBODY>
        <tr>
            <TD  vAlign=top class=ttop style="PADDING-BOTTOM: 1px">测字解梦</TD>
        </tr>
        <tr>
            <TD vAlign=top class=new style="PADDING-BOTTOM: 1px"><span class="red">诸葛神数:</span>(诸葛神数相传为汉诸武侯所作，共有三百八十四签，按照笔划以大易三百八十四爻之数占出卦象，签文句法长短不一，寓意深远，变化无穷，判断吉凶，相当准绳。 )</TD>
        </tr><form name="form1" onSubmit="return Check(this)" method="post" action="?m=3&sm=6">
            <input type="hidden" name="act" value="ok" />
            <tr>
                <td class="new">
                请输入三个简体汉字抽签占卜：<input name="name1" type="text" id="name1" size="20" onKeyUp="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" maxLength="3">（多输入只取前三个） <input type="submit" name="Submit1" value="提交" style="cursor:hand;"><hr noshade color="#CCCCCC"></td>
            </tr></form> <tr>
                <TD vAlign=top class=new style="PADDING-BOTTOM: 1px"><span class="red">周公解梦:</span></TD>
            </tr><form method="post" action="?m=3&sm=8" name="formjm" onSubmit="return valid_checkdream()" target="dream">

                <input type="hidden" name="act" value="ok" />
                <tr>
                    <td class="new">
                        请输入做梦内容的关键字 ：<input name="word" type="text" id="word" size="20" onKeyUp="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" maxLength="20">
                        <select size="1" name="act">
                            <option selected="" value="1">简明</option>
                            <option value="2">详细</option>
                        </select>  <input type="submit" name="Submit1" value="开始解梦" style="cursor:hand;"></td>
                    </tr></form><form name="formzw" onSubmit="return submitchecken()" method="post" action="zwsm.php">
                        <input type="hidden" name="act" value="ok" />
                    </form>
                    <form name="theform" onSubmit="return checkjx();" method="post" action="?m=3&sm=9">
                        <input type="hidden" name="act" value="ok" />
                    </form>
                </TABLE>

