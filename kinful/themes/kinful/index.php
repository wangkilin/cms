<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE><?$site_config.site_name?></TITLE>
<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="TEXT/HTML; CHARSET=UTF-8"/>
<link href="kinful/web/css/index.css" type=text/css rel=stylesheet>
<?if $MY_MODULE_NAME?>
<link href="kinful/web/css/module_<?$MY_MODULE_NAME?>.css" type=text/css rel=stylesheet>
<?/if?>
<link rel="shortcut icon" href="kinful/web/image/favicon.ico" />
<script type="text/javascript" src="kinful/web/js/jquery.min.js"></script>
<script type="text/javascript"  src="kinful/web/js/jquery-ui.min.js"></script>
<script type="text/javascript"  src="kinful/web/js/kinful.js"></script>
</HEAD>

<BODY style="background:#f5f5f5">
<?if $top_menu?>
<table id="top_menu">
  <tr>
    <td>
    <?if is_array($top_menu)===true?>
        <?foreach key=key item=item from=$top_menu?>
            <div id="top_menu_<?$key?>">
            <?$item?>
            </div>
        <?/foreach?>
    <?elseif is_string($top_menu)?>
        <?$top_menu?>
    <?/if?>
    </td>
  </tr>
</table>
<?/if?>

<?if ($logo || $banner || $banner_right || $head_menu)?>
<table class="head_content">
  <tr>
    <?if $logo?>
    <td id="logo">
        <?if is_array($logo)===true?>
            <?foreach key=key item=item from=$logo?>
                <div id="logo_<?$key?>">
                <?$item?>
                </div>
            <?/foreach?>
        <?elseif is_string($logo)?>
            <?$logo?>
        <?/if?>
    </td>
    <?/if?>
    <?if $banner?>
    <td id="banner">
        <?if is_array($banner)===true?>
            <?foreach key=key item=item from=$banner?>
                <div id="banner_<?$key?>">
                <?$item?>
                </div>
            <?/foreach?>
        <?elseif is_string($banner)?>
            <?$banner?>
        <?/if?>
    </td>
    <?/if?>
    <?if $banner_right?>
    <td id="banner_right">
        <?if is_array($banner_right)===true?>
            <?foreach key=key item=item from=$banner_right?>
                <div id="banner_right_<?$key?>">
                <?$item?>
                </div>
            <?/foreach?>
        <?elseif is_string($banner_right)?>
            <?$banner_right?>
        <?/if?>
    </td>
    <?/if?>
  </tr>
</table>
<?/if?>


<?if $head_menu?>
<table id="head_menu">
  <tr>
    <td>
    <?if is_array($head_menu)===true?>
        <?foreach key=key item=item from=$head_menu?>
            <div id="head_menu_<?$key?>">
            <?$item?>
            </div>
        <?/foreach?>
    <?elseif is_string($head_menu)?>
        <?$head_menu?>
    <?/if?>
    </td>
  </tr>
</table>
<?/if?>


<?if ($left_menu || $left_block || $body_content || $right_menu || $right_block || $my_main)?>
<table>
  <tr>
  <?if ($left_menu || $left_block)?>
    <td class="left_content">
    <?if $left_menu?>
    <div id="left_menu">
        <?if is_array($left_menu)===true?>
            <?foreach key=key item=item from=$left_menu?>
                <div id="left_menu_<?$key?>">
                <?$item?>
                </div>
            <?/foreach?>
        <?elseif is_string($left_menu)?>
            <?$left_menu?>
        <?/if?>
    </div>
    <?/if?>
    <?if $left_block?>
    <div id="left_block">
        <?if is_array($left_block)===true?>
            <?foreach key=key item=item from=$left_block?>
                <div id="left_block_<?$key?>">
                <?$item?>
                </div>
            <?/foreach?>
        <?elseif is_string($left_block)?>
            <?$left_block?>
        <?/if?>
    </div>
    <?/if?>
    </td>
  <?/if?>

    <?if $body_content || $my_main?>
    <td id="body_content">
        <?if $body_content && is_array($body_content)===true?>
            <?foreach key=key item=item from=$body_content?>
                <div id="body_content_<?$key?>">
                <?$item?>
                </div>
            <?/foreach?>
        <?elseif $body_content && is_string($body_content)?>
            <?$body_content?>
        <?/if?>
        <?if $my_main?>
            <div id="my_main_content">
            <?$my_main.my_main_content?>
            </div>
        <?/if?>
    </td>
    <?/if?>
    <?if ($right_menu || $right_block)?>
    <td class="right_content">
     <?if $right_menu?>
      <div id="right_menu">
        <?if is_array($right_menu)===true?>
            <?foreach key=key item=item from=$right_menu?>
                <div id="right_menu_<?$key?>">
                <?$item?>
                </div>
            <?/foreach?>
        <?elseif is_string($right_menu)?>
            <?$right_menu?>
        <?/if?>
      </div>
     <?/if?>
     <?if $right_block?>
      <div id="right_block">
        <?if is_array($right_block)===true?>
            <?foreach key=key item=item from=$right_block?>
                <div id="right_block_<?$key?>">
                <?$item?>
                </div>
            <?/foreach?>
        <?elseif is_string($right_block)?>
            <?$right_block?>
        <?/if?>
     </div>
     <?/if?>
   </td>
   <?/if?>
 </tr>
</table>
<?/if?>

<?if ($body_banner)?>
<table class="body_banner_content">
  <tr>
    <td id="body_banner">
        <?if is_array($body_banner)===true?>
            <?foreach key=key item=item from=$body_banner?>
                <div id="body_banner_<?$key?>">
                <?$item?>
                </div>
            <?/foreach?>
        <?elseif is_string($body_banner)?>
            <?$body_banner?>
        <?/if?>
    </td>
  </tr>
</table>
<?/if?>

<?if ($bottom_menu)?>
<table class="bottom_content">
  <tr>
    <td id="bottom_menu">
        <?if is_array($bottom_menu)===true?>
            <?foreach key=key item=item from=$bottom_menu?>
                <div id="bottom_menu_<?$key?>">
                <?$item?>
                </div>
            <?/foreach?>
        <?elseif is_string($bottom_menu)?>
            <?$bottom_menu?>
        <?/if?>
    </td>
  </tr>
</table>
<?/if?>

</BODY>
</HTML>
