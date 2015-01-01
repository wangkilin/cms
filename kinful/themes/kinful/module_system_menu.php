<?if $menus && is_array($menus)?>
    <?foreach item=menu from=$menus name=menuLoop?>
        <a href="<?$menu.menu_link?>"><?$menu.menu_name?></a>
        <?if $smarty.foreach.menuLoop.last!==true?>
        <i>|</i>
        <?/if?>
    <?/foreach?>
<?/if?>