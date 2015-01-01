<?if $action && ($action=='showNews' || $action=='showNewsList')?>
<?* show news detail information OR news list*?>
    <div class="news_information">
    <?if $category_info?>
      <div class="news_category_info">
        <?if $category_info.image_path?>
        <p><img src="<?$category_info.image_path?>"/></p>
        <u><?$category_info.title?></u><a href="?yemodule=news&category_id=<?$category_info.category_id?>"></a>
        <?/if?>
      </div>
    <?/if?>
    <?if (count($newsList))?>
    <?foreach item=news from=$newsList?>
      <div<?if $action=='showNewsList'?> class="<?cycle values="itemOddLine,itemEvenLine"?>"<?/if?>>
        <?if $options.showTitle!==false?>
        <div class="news_title">
          <?if $action!='showNews'?>
          <a href="?yemodule=news&news_id=<?$news.news_id?>">
          <?/if?>
              <?if $options.length?><?$news.title|truncate:$options.length:"..."?><?else?><?$news.title?><?/if?>
          <?if $action!='showNews'?>
          </a>
          <?/if?>
        </div>
        <?/if?>
        <?if $options.showCreateAuthor || $options.showCreateUser?>
        <div class="news_create_author">作者：<?$news.created_by_name?></div>
        <?/if?>
        <?if $options.showCreateTime?>
        <div class="news_create_time"><?$news.created_time?></div>
        <?/if?>
        <?if $options.showReferenceUrl && $news.reference_url?>
        <div class="news_reference_url">参考网址：<?$news.reference_url?></div>
        <?/if?>
        <?if $options.showIntroText?>
        <div class="news_intro_text"><?$news.intro_text?></div>
        <?/if?>
        <?if $options.showModifyAuthor && $news.modified_by_name?>
        <div class="news_modify_author"><?$news.modified_by_name?></div>
        <?/if?>
        <?if $options.showModifyTime && $news.modified_time?>
        <div class="news_modify_time"><?$news.modified_time?></div>
        <?/if?>
        <?if $options.showFullText?>
        <div class="news_full_text"><?$news.full_text?></div>
        <?/if?>
      </div>
    <?/foreach?>
    <?/if?>
    </div>
<?/if?>
<?if $action && ($action=='showNewsCategories')?>
<?* show news categories*?>
    <div id="news_categoriy_information">
    <?if $category_info?>
      <div class="news_category_info">
        <?if $category_info.image_path?>
        <p><img src="<?$category_info.image_path?>"/></p>
        <u><?$category_info.title?></u><a href="?yemodule=news&category_id=<?$category_info.category_id?>"></a>
        <?/if?>
      </div>
    <?/if?>
    <?if (count($newsList))?>
    <?foreach item=news from=$newsList?>
      <div class="<?cycle values="itemOddLine,itemEvenLine"?>">
        <div class="news_title">
          <a href="?yemodule=news&category_id=<?$news.category_id?>">
              <?if $options.length?><?$news.title|truncate:$options.length:"..."?><?else?><?$news.title?><?/if?>
          </a>
        </div>
        <div class="news_create_time"><?$news.item_count?></div>
      </div>
    <?/foreach?>
    <?/if?>
    </div>
<?/if?>
<?if $action && $action=='listCategory'?>
    <?if $category_info?>
      <div class="news_category_info">
        <u><?$category_info.title?></u><a href="?yemodule=news&category_id=<?$category_info.category_id?>"></a>
        <?if $category_info.image_path?>
        <p><img src="<?$category_info.image_path?>"/></p>
        <?/if?>
      </div>
    <?/if?>
    <?$news_categories?>
<?/if?>