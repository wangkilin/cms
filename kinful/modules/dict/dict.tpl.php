<?if $action && ($action=='showDict' || $action=='showDictList')?>
<?* show media detail information OR media list*?>
    <div class="dict_information">
    <?if (count($dictList))?>
    <?foreach item=dict from=$dictList?>
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
        <div class="dict_title">
          <?if $action!='showDict'?>
          <a href="?yemodule=dict&dict_id=<?$dict.dict_id?>">
          <?/if?>
              <?if $options.length?><?$dict.title|truncate:$options.length:"..."?><?else?><?$dict.title?><?/if?>
          <?if $action!='showDict'?>
          </a>
          <?/if?>
        </div>
        <?/if?>
        <?if $options.showCreateAuthor || $options.showCreateUser?>
        <div class="dict_create_author">作者：<?$dict.created_by_name?></div>
        <?/if?>
        <?if $options.showCreateTime?>
        <div class="dict_create_time"><?$dict.created_time?></div>
        <?/if?>
        <?if $options.showReferenceUrl && $dict.reference_url?>
        <div class="dict_reference_url">参考网址：<?$dict.reference_url?></div>
        <?/if?>
        <?if $options.showIntroText?>
        <div class="dict_intro_text"><?$dict.intro_text?></div>
        <?/if?>
        <?if $options.showModifyAuthor && $dict.modified_by_name?>
        <div class="dict_modify_author"><?$dict.modified_by_name?></div>
        <?/if?>
        <?if $options.showModifyTime && $dict.modified_time?>
        <div class="dict_modify_time"><?$dict.modified_time?></div>
        <?/if?>
        <?if $options.showFullText?>
        <div class="dict_full_text"><?$dict.full_text?></div>
        <?/if?>
      </div>
    <?/foreach?>
    <?/if?>
    </div>
<?/if?>
<?if $action && ($action=='showDictCategories')?>
<?* show media categories*?>
    <div id="dict_categoriy_information">
    <?if (count($dictList))?>
    <?foreach item=dict from=$dictList?>
        <div class="dict_title">
          <a href="?yemodule=dict&category_id=<?$dict.category_id?>">
              <?if $options.length?><?$dict.title|truncate:$options.length:"..."?><?else?><?$dict.title?><?/if?>
          </a>
        </div>
        <div class="dict_create_time"><?$dict.item_count?></div>
    <?/foreach?>
    <?/if?>
    </div>
<?/if?>
<?if $action && $action=='listCategory'?>
    <?$dict_categories?>
<?/if?>