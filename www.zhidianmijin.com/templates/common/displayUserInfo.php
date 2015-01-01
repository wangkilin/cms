<table width="100%" border="0" cellspacing="0" cellpadding="0" class="b1" style="table-layout:fixed;word-wrap:break-word;">
  <TBODY>
    <tr>
      <TD style="PADDING-BOTTOM: 10px" vAlign=top>当前算命者信息 (<font color="#FF0000">右侧菜单查看详细</font>)</TD>
    </tr>
    <tr>
      <TD style="PADDING-BOTTOM: 8px" vAlign=top>姓名:<font color="#FF0000"><?$xing?><? $ming?></font> 性别:<?$xingbie?>
          <? if ($xuexing<>'') ?>
血型:<?$xuexing?> 
          <?/if?>
出生:<font color="#0000ff"><?$nian1?>年<?$yue1 ?>月<?$ri1?>日<?$hh1?>时<?$mm1?>分</font> 今年<?$_thisYear-$nian1?>岁 属相:<?$sx?>&nbsp;星座:<?$xingzuo?>&nbsp;
<input name="button2" type="button" class="button" style="cursor:hand;COLOR: #ff0000;FONT-WEIGHT: bold;" onClick="(location='?clearCookie')" value="重新测算" />
     </TD>
    </tr>
  </TBODY>
</TABLE>