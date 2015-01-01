<table cellspacing="1" cellpadding="0" border="0" class="tablebgcolor4">
    <TBODY>
        <? if (!isset($list) && !count($list)) ?>
        <script>
        alert('没有找到相关解梦内容');window.close()</script>
        <? else ?>

        <TR class="tdbgcolor">
            <TD height="25" align="right" width="100%">
                共找到<FONT COLOR="#FF0000">
                <? $allshu ?></FONT>
                个解梦结果，分为<font color="#FF0000">
                <? $mpage ?></font>
                页，目前是第<font color="#FF0000">
                <? $currentPage ?></font>
            页</TD>
        </TR>
        <TR class="tdbgcolor2">
            <TD>

                <div align="center">
                    <table border="0" width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                            <? foreach key=i name=name item=item from=$list ?>
                            <tr>
                                <td style="line-height:200%">
                                    <font color="green">
                                    ［<? $i+1 ?>.<? $item.jmlb ?>］</font>
                                    <font color="red">
                                    （<? $item.title ?>）</font>
                                    <br />

                                    <? $item.content|replace:$word:"<font color=red>
                                    $word</font>
                                    " ?>
                                </td>
                            </tr>
                            <? /foreach ?>
                        </tbody>
                    </table>
                </div>
                <hr size="1" color="#d2d0d0" />

                <!--分页开始-->
                <div align="center">
                    <script>
                        PageCount=<? $mpage ?> //总页数
                        topage=<? $currentPage ?>   //当前停留页
                        if (topage>1){document.write("<a href='?m=3&sm=8&act=<? $smarty.request.act ?>&word=<? $smarty.request.word ?>&page=<? $currentPage-1 ?>' title='上一页'> 上一页</a>");}
                            for (var i=1; i <= PageCount; i++) {
                                if (i <= topage+6 && i >= topage-6 || i==1 || i==PageCount){
                                    if (i > topage+7 || i < topage-5 && i!=1 && i!=2 ){document.write(" ... ");}
                                    if (topage==i){document.write("<font color=#d2d0d0> "+ i +" </font> ");}
                                        else{
                                            document.write(" <a href='?m=3&sm=8&act=<? $smarty.request.act ?>&word=<? $smarty.request.word ?>&page="+i+"'> ["+ i +"]</a> ");
                                        }
                                    }
                                }
                                if (PageCount-topage>=1){document.write("<a href='?m=3&sm=8&act=<? $smarty.request.act ?>&word=<? $smarty.request.word ?>&page=<? $currentPage+1 ?>' title='下一页'>下一页</a>");}
                                </script>
                            </div>
                            <!--分页结束-->
                        </TD>
                    </TR>
                    <? /if ?>
                </TBODY>
            </table>
            <br />
            <a href="javascript:window.close()">
            [关闭页面]</a>
