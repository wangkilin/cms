<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?$site_config.site_name?></title>
<link href="<?$MY_THEME_PATH?>css/index.css" type=text/css rel=stylesheet>
<?if $MY_MODULE_NAME?>
<link href="<?$MY_THEME_PATH?>css/module_<?$MY_MODULE_NAME?>.css" type=text/css rel=stylesheet>
<?/if?>
<link rel="shortcut icon" href="<?$MY_THEME_PATH?>image/favicon.ico" />
<script type="text/javascript" src="<?$MY_THEME_PATH?>js/jquery.min.js"></script>
<script type="text/javascript"  src="<?$MY_THEME_PATH?>js/jquery-ui.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<table id="container" align="center" cellpadding="0" cellspacing="0">
<tr>
<td class="leftBorder">
</td>
<td>
<table id="mainHead" class="blockTable" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200px">
    <?if $logo?>
    <div id="logo">
            <?$logo.0?>
    </div>
    <?/if?>
	</td>
	<td id="mainBanner"></td>
  </tr>
</table>
<table id="mainHeadMenu2" class="blockTable" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
    <div id="domainZone" class="blockFloatLeft">WWW.KINFUL.COM</div>
    <?if $head_menu?>
    <div id="head_menu">
        <?if is_array($head_menu)===true?>
            <?foreach key=key item=item from=$head_menu?>
                <div id="head_menu_<?$key?>">
                <?$item?>
                </div>
            <?/foreach?>
        <?elseif is_string($head_menu)?>
            <?$head_menu?>
        <?/if?>
    </div>
    <?/if?>
	</td>
  </tr>
</table>
<table id="menuLine" class="blockTable" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>
<table id="mainHeadMenu" class="blockTable" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	  <table class="blockWidth100">
	    <tr>
		  <td>菜单</td>
		  <td>菜单</td>
		  <td>菜单</td>
		  <td>菜单</td>
		  <td>菜单</td>
		  <td>菜单</td>
		</tr>
      </table>
	</td>
  </tr>
</table>

<table id="mainBody" class="blockTable" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td id="left_block">
    <?if $left_block?>
        <?if is_array($left_block)===true?>
            <?foreach key=key item=item from=$left_block?>
                <div id="left_block_<?$key?>">
                <?$item?>
                </div>
            <?/foreach?>
        <?elseif is_string($left_block)?>
            <?$left_block?>
        <?/if?>
    <?/if?>
	</td>
	<td id="mainContent">
      <?if $my_main?>
        <div id="my_main_content">
        <?$my_main.my_main_content?>
        </div>
      <?/if?>
	</td>
  </tr>
</table>

<table id="mainBodyBanner" class="blockTable" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	</td>
  </tr>
</table>

<table id="mainFoot" class="blockTable" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	</td>
  </tr>
</table>

<table id="pageBottom" class="blockTable" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	</td>
  </tr>
</table>
</td>
<td class="rightBorder">
</td>
</tr>
</table>
</body>
</html>
