<?if $container && $container.pool?>
<div <?if $container.pool.class ?>class="<?$container.pool.class?>"<?/if?>>
    <?if $container.header?>
    <div <?if $container.header.class ?>class="<?$container.header.class?>"<?/if?>>
        <?if $itemHeader?>
        <?counter start=-1 skip=1 print=false?>
        <?foreach item=item from=$itemHeader?>
        <p class="<?if $container.subItem.class?><?$container.subItem.class?><?/if?> LIST_<?counter?>"><?$item?></p>
        <?/foreach?>
        <?/if?>
        <?if $itemMenu?>
        <?foreach item=item key=key from=$itemMenu?>
        <p class="<?if $container.subItem.class?><?$container.subItem.class?><?/if?> <?if $item.class?><?$item.class?><?/if?>">
          <?$key?>
        </p>
        <?/foreach?>
        <?/if?>
    </div>
    <?/if?>

    <?if $items && $listKeys?>
    <?foreach item=item key=key from=$items?>
    <div class='<?if $container.item.class?><?$container.item.class?><?/if?> <?cycle values="itemOddLine,itemEvenLine"?>'>
        <?counter start=0 skip=1 print=false?>
        <p class="subItem LIST_0">
          <?$numberOfPerPage*$currentPage-$numberOfPerPage+$key+1?>
        </p>
        <?foreach item=listKey from=$listKeys?>
        <p class="subItem LIST_<?counter?>">
          <?my_print_item listKey=$listKey item=$item?>
        </p>
        <?/foreach?>

        <?if $itemMenu?>
        <?foreach item=menuOption key=menuKey from=$itemMenu?>
        <p class="<?if $container.subItem.class?><?$container.subItem.class?><?/if?> <?if $item.class?><?$item.class?><?/if?>">
            <?my_print_item_menu menuKey=$menuKey menuOption=$menuOption item=$item?>
        </p>
        <?/foreach?>
        <?/if?>
    </div>
    <?/foreach?>
    <?else?>
    <div>
        there is no item to display!
    </div>
    <?/if?>

    <?if $totalItemNumber?>
      <?if $enablePageGuide && $currentPage && $totalPage && $pageLink?>
        <div class="itemPage">
        <?if $currentPage>1?>
          <a href="<?$pageLink?>&page=1"><?$language.first_page?></a>
          <a href="<?$pageLink?>&page=<?$currentPage-1?>"><?$language.pre_page?></a>
        <?else?>
          <?$language.first_page?>
          <?$language.pre_page?>
        <?/if?>
        <?$currentPage?>
        <?if $currentPage<$totalPage?>
          <a href="<?$pageLink?>&page=<?$currentPage+1?>"><?$language.next_page?></a>
          <a href="<?$pageLink?>&page=<?$totalPage?>"><?$language.last_page?></a>
        <?else?>
          <?$language.next_page?>
          <?$language.last_page?>
        <?/if?>
        <?$language.jump_to?><input type="text" size=3 id="____page"><?$language.page?>
        <input type='hidden' id='____itemTotalPage' page='<?$totalPage?>'>
        </div>
      <?/if?>

      <?if $enableSelectNumberForPage?>
        <div class="itemNumberForPage">
            <?$language.number_per_page?><select name="number_per_page">
              <?foreach item=item key=key from=$numberListPerPage?>
                <option value="<?$key?>" <?if $key==$numberPerPageIndex?>selected="selected"<?/if?>><?$item?></option>
              <?/foreach?>
            </select><?$language.item?>
            <?$language.total_number?><?$totalItemNumber?><?$language.item?>
        </div>
      <?/if?>
    <?/if?>
</div>
<?/if?>
<script language="JavaScript">
<!--
(function($){
    $('#____page').live('click', function(){
        $(this).attr('name', 'page');
    });
    $('#____page').blur(function(){
        $(this).removeAttr('name');
    });
})(jQuery);
//-->
</script>