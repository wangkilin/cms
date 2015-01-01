<?if $action && ($action=='showNews' || $action=='showNewsList')?>
<?* show media detail information OR media list*?>
    <div class="news_information">
    <?if (count($newsList))?>
    <?foreach item=news from=$newsList?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" rowspan="2"><img src="file:///D|/AppServ/www/kinful/themes/it_tech/images/second/aboutus.jpg" width="224" height="189" /></td>
    <td class="thumbnailTopRight">&nbsp;</td>
  </tr>
  <tr>
    <td class="thumbnailRight">&nbsp;</td>
  </tr>
  <tr>
    <td class="thumbnailBottomLeft">&nbsp;</td>
    <td class="thumbnailBottom">&nbsp;</td>
    <td class="thumbnailBottomRight">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">title:lady<br />
path:
    2009/10/01/3333.jpg<br />
size:20K<br />
link:index.php</td>
  </tr>
</table>
      <div>
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
<?* show media categories*?>
    <div id="news_categoriy_information">
    <?if (count($newsList))?>
    <?foreach item=news from=$newsList?>
        <div class="news_title">
          <a href="?yemodule=news&category_id=<?$news.category_id?>">
              <?if $options.length?><?$news.title|truncate:$options.length:"..."?><?else?><?$news.title?><?/if?>
          </a>
        </div>
        <div class="news_create_time"><?$news.item_count?></div>
    <?/foreach?>
    <?/if?>
    </div>
<?/if?>
<?if $action && $action=='listCategory'?>
    <?$news_categories?>
<?/if?>