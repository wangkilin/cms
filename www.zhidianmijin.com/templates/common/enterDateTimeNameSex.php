<form method="POST" action="" onSubmit="return checkbz();" name="theform">   <tr>
        <TD class=new style="PADDING-BOTTOM: 8px" vAlign=top><strong>公历生日：</strong>
        <select size="1" name="y">
            <?selectStepOptions start=1950 end=$_thisYear selected=$nian1 default=1980?></select>年
        <select name="m" size="1"><?selectStepOptions start=1 end=12 selected=$yue1 default=$_thisMonth?></select>月
        
        <select name="d" size="1"><?selectStepOptions start=1 end=31 selected=$ri1 default=$_thisDay?></select>日
        
        <select size="1" name="hh"> <?selectStepOptions start=0 end=23 selected=$hh1?> </select>点
        
        <select size="1" name="fen"><option value="0">未知</option>
		<?selectStepOptions start=0 end=59 selected=$mm1?>
		</select>分
       </TD>
      </tr>  <tr>
        <TD class=new style="PADDING-BOTTOM: 8px" vAlign=top><strong>姓名：</strong>
          <input onkeyup="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" name="name" type="text" value="<?$xing?><?$ming ?>" />
          &nbsp;
          <select size="1" name="b">
<option value="男" <?if ($xingbie=="男")  ?>selected="selected"<?/if?>>男性</option>
<option value="女" <?if ($xingbie=="女")  ?>selected="selected"<?/if?>>女性</option>
          </select>&nbsp;<input type="hidden" name="act" value="ok" /><input name="cs" type="submit" value="开始测试" />
       </TD>
      </tr></form>