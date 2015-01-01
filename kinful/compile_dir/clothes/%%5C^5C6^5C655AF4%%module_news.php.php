<?php /* Smarty version 2.6.6, created on 2010-08-29 10:54:14
         compiled from module_news.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'module_news.php', 12, false),)), $this); ?>
<?php if ($this->_tpl_vars['action'] && ( $this->_tpl_vars['action'] == 'showNews' || $this->_tpl_vars['action'] == 'showNewsList' )): ?>
    <div class="news_information">
    <?php if (( count ( $this->_tpl_vars['newsList'] ) )): ?>
    <?php if (count($_from = (array)$this->_tpl_vars['newsList'])):
    foreach ($_from as $this->_tpl_vars['news']):
?>
      <div>
        <?php if ($this->_tpl_vars['options']['showTitle'] !== false): ?>
        <div class="news_title">
          <?php if ($this->_tpl_vars['action'] != 'showNews'): ?>
          <a href="?yemodule=news&news_id=<?php echo $this->_tpl_vars['news']['news_id']; ?>
">
          <?php endif; ?>
              <?php if ($this->_tpl_vars['options']['length']):  echo ((is_array($_tmp=$this->_tpl_vars['news']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, $this->_tpl_vars['options']['length'], "...") : smarty_modifier_truncate($_tmp, $this->_tpl_vars['options']['length'], "..."));  else:  echo $this->_tpl_vars['news']['title'];  endif; ?>
          <?php if ($this->_tpl_vars['action'] != 'showNews'): ?>
          </a>
          <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['options']['showCreateAuthor'] || $this->_tpl_vars['options']['showCreateUser']): ?>
        <div class="news_create_author">作者：<?php echo $this->_tpl_vars['news']['created_by_name']; ?>
</div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['options']['showCreateTime']): ?>
        <div class="news_create_time"><?php echo $this->_tpl_vars['news']['created_time']; ?>
</div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['options']['showReferenceUrl'] && $this->_tpl_vars['news']['reference_url']): ?>
        <div class="news_reference_url">参考网址：<?php echo $this->_tpl_vars['news']['reference_url']; ?>
</div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['options']['showIntroText']): ?>
        <div class="news_intro_text"><?php echo $this->_tpl_vars['news']['intro_text']; ?>
</div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['options']['showModifyAuthor'] && $this->_tpl_vars['news']['modified_by_name']): ?>
        <div class="news_modify_author"><?php echo $this->_tpl_vars['news']['modified_by_name']; ?>
</div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['options']['showModifyTime'] && $this->_tpl_vars['news']['modified_time']): ?>
        <div class="news_modify_time"><?php echo $this->_tpl_vars['news']['modified_time']; ?>
</div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['options']['showFullText']): ?>
        <div class="news_full_text"><?php echo $this->_tpl_vars['news']['full_text']; ?>
</div>
        <?php endif; ?>
      </div>
    <?php endforeach; unset($_from); endif; ?>
    <?php endif; ?>
    </div>
<?php endif;  if ($this->_tpl_vars['action'] && ( $this->_tpl_vars['action'] == 'showNewsCategories' )): ?>
    <div id="news_categoriy_information">
    <?php if (( count ( $this->_tpl_vars['newsList'] ) )): ?>
    <?php if (count($_from = (array)$this->_tpl_vars['newsList'])):
    foreach ($_from as $this->_tpl_vars['news']):
?>
        <div class="news_title">
          <a href="?yemodule=news&category_id=<?php echo $this->_tpl_vars['news']['category_id']; ?>
">
              <?php if ($this->_tpl_vars['options']['length']):  echo ((is_array($_tmp=$this->_tpl_vars['news']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, $this->_tpl_vars['options']['length'], "...") : smarty_modifier_truncate($_tmp, $this->_tpl_vars['options']['length'], "..."));  else:  echo $this->_tpl_vars['news']['title'];  endif; ?>
          </a>
        </div>
        <div class="news_create_time"><?php echo $this->_tpl_vars['news']['item_count']; ?>
</div>
    <?php endforeach; unset($_from); endif; ?>
    <?php endif; ?>
    </div>
<?php endif;  if ($this->_tpl_vars['action'] && $this->_tpl_vars['action'] == 'listCategory'): ?>
    <?php echo $this->_tpl_vars['news_categories']; ?>

<?php endif; ?>