<?if $action && $action=='default'?>
    <form id="admin_main_content" method=post action="#">
    <div class="admin_title_logo menu_list_admin"><?$lang.menu_list_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <?if $menus?>
          <?$menus?>
      <?/if?>
    </form>
<?/if?>

<?if $action && $action=='list_menu'?>
    <form id="admin_main_content" method=post action="#">
    <div class="admin_title_logo menu_admin"><?$lang.menu_admin_title?></div>
    <?if $form_action?>
       <?$form_action?>
    <?/if?>
      <?if $menus?>
          <?$menus?>
      <?/if?>
    </form>
<?/if?>

<?if $action && $action=='list'?>
    <div id="menu_type_list">
      <div id="menu_type_list_header">
      </div>
      <div id="menu_list">
       
        <?foreach item=menuType from=$menus?>
            <a href="?yemodule=<?$module_name?>&admin=menu&action=update&menu=<?$menuType.menu_id?>"><?$menuType.menu_name?></a>
        <?/foreach?>
       
      </div>
      <div id="menu_type_list_foot">
      </div>
    </div>
<?/if?>