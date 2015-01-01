<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE><?$site_config.site_name?></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link href="<?$MY_THEME_PATH?>css/index.css" type=text/css rel=stylesheet>
<?if $MY_MODULE_NAME?>
<link href="<?$MY_THEME_PATH?>css/module_<?$MY_MODULE_NAME?>.css" type=text/css rel=stylesheet>
<?/if?>
<link rel="shortcut icon" href="<?$MY_THEME_PATH?>image/favicon.ico" />
<script type="text/javascript" src="<?$MY_THEME_PATH?>js/jquery.min.js"></script>
<script type="text/javascript"  src="<?$MY_THEME_PATH?>js/jquery-ui.min.js"></script>
<script type="text/javascript"  src="<?$MY_THEME_PATH?>js/kinful.js"></script>
</head>
<body class="body">
<div height="84px" id='header_zone' valign='top'>
    <img src="<?$MY_THEME_PATH?>images/admin_logo.jpg" border="0" alt="">
    <div id="logout_zone">
        <a href="?yemodule=system&admin=logout">Logout</a>
    </div>
</div>
<!-- start top -->
<div id="menu_zone">

<!-- start::head menu -->
<?if $head_menu?>
    <?if is_array($head_menu)===true?>
        <?foreach key=key item=item from=$head_menu?>
            <?$item?>
        <?/foreach?>
    <?/if?>
<?/if?>
<!-- end::head menu -->
</div>
<!-- end top -->
<?if $logo_zone?>
<div id="logo_zone">
    <?if is_array($logo_zone)===true?>
        <?foreach key=key item=item from=$head_menu?>
            <div id="logo_zone_<?$key?>">
            <?$key?>: <?$item?>
            </div>
        <?/foreach?>
    <?elseif is_string($logo_zone)?>
        <?$logo_zone?>
    <?/if?>
</div>
<?/if?>

<?if $left_menu?>
<div id="left_menu">
    <?if is_array($left_menu)===true?>
        <?foreach key=key item=item from=$left_menu?>
            <div id="left_menu_<?$key?>">
            <?$key?>: <?$item?>
            </div>
        <?/foreach?>
    <?elseif is_string($left_menu)?>
        <?$left_menu?>
    <?/if?>
</div>
<?/if?>

<div id="admin_main_content" class="border_1">
        <!-- start main content -->
   <?$my_main.my_main_content?>
        <!-- end main content -->
</div>

<!-- start bottom -->
<div class="page_bottom">
  <p class="body_text" align="center">
    	Copyright 2000-<?$smarty.now|date_format:"%Y"?> &copy; Kinful.com.  All rights reserved.<br>
      Kinful CMS is Free Software released under the GNU/GPL License.<br>
  </p>
</div>
<!-- end bottom -->
</body>
</html>

