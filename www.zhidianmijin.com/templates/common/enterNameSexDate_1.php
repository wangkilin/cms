<input name="name1" type="text" value="<?$xing1?><?$xing2?><?$ming1?><?$ming2?>" />
          &nbsp;
          <select size="1" name="xing1">
<option value="1" <?if (!$xing2) { ?>selected="selected"<?/if?>>单姓</option>
<option value="2"<?if ($xing2<>"") { ?>selected="selected"<?/if?>>复姓</option>
          </select>
          &nbsp;
          <select size="1" name="sex1">
<option value="男" <?if ($xingbie=="男") { ?>selected="selected"<?} ?>>男性</option>
<option value="女" <?if ($xingbie=="女") { ?>selected="selected"<?} ?>>女性</option>
          </select><br /><br /><div id="fs11" style="display:none">
<div class="divh2"></div>公历/阳历生日：<select size="1" name="y1"><?for ($i=1900; $i<=date("Y", time()); $i++) { ?><option value="<?$i?>" <?if ($nian1<>'' ) { ?><?if ($i==$nian1) { ?> selected<?} ?><?} else { ?><?if ($i==date("Y", time())) { ?> selected<?} ?><?} ?>><?$i?></option><?} ?></select>年<select name="m1" size="1"><?for ($i=1; $i<=12; $i++) {?><option value="<?$i?>" <?if ($yue1<>'' ) { ?><?if ($i==$yue1) { ?> selected<?} ?><?} else { ?><?if ($i==date("n", time())) { ?> selected<?} ?><?} ?>><?$i?></option><?} ?></select>月<select name="d1" size="1"><?for ($i=1; $i<=31; $i++) {?><option value="<?$i?>" <?if ($ri1<>'' ) { ?><?if ($i==$ri1) { ?> selected<?} ?><?} else { ?><?if ($i=date("j", time())) { ?> selected<?} ?><?} ?>><?$i?></option><?} ?></select>日<select size="1" name="h1"> <?for ($i=0; $i<=23; $i++) {?><option value="<?$i?>" <?if ($hh1<>'' ) { ?><?if ($i==$hh1) { ?> selected<?} ?><?} ?>><?DiZhi($i)?><?$i?></option><?} ?> </select>点<select size="1" name="f1"><option value="0">未知</option>
		<?for ($i=0; $i<=59; $i++) {?><option value="<?$i?>" <?if ($mm1<>'' ) { ?><?if ($i==$mm1) { ?> selected<?} ?><?} ?>><?$i?></option><?} ?>
		</select>分&nbsp;<a title="如果您只知道生日的农历日期，不要紧，请点这里去查询公历日期" style="CURSOR: hand" onClick="window.open('../wannianli.htm','httpcnnongli','left=0,top=0,width=680,height=480,scrollbars=no,resizable=no,status=no')" href="#wnl1"><font color="#008000">只知道农历生日请点此查询公历</font></a>
<hr size="1">
</div>