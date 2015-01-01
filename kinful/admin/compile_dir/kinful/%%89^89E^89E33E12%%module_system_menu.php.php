<?php /* Smarty version 2.6.6, created on 2010-09-23 05:22:29
         compiled from module_system_menu.php */ ?>
<?php if ($this->_tpl_vars['menus'] && is_array ( $this->_tpl_vars['menus'] )): ?>
    <?php if (count($_from = (array)$this->_tpl_vars['menus'])):
    foreach ($_from as $this->_tpl_vars['menu']):
?>
        <a href="<?php echo $this->_tpl_vars['menu']['menu_link']; ?>
" menu_id="<?php echo $this->_tpl_vars['menu']['menu_id']; ?>
" ID="menu_<?php echo $this->_tpl_vars['menu']['menu_id']; ?>
" parent_id="<?php echo $this->_tpl_vars['menu']['parent_id']; ?>
" class="admin_menu_list<?php if ($this->_tpl_vars['menu']['parent_id']): ?> admin_submenu_list<?php endif; ?> <?php echo $this->_tpl_vars['menu']['menu_class']; ?>
" <?php if ($this->_tpl_vars['menu']['open_mode'] == 1): ?>target="blank"<?php endif; ?>><?php echo $this->_tpl_vars['menu']['menu_name']; ?>
</a>
    <?php endforeach; unset($_from); endif; ?>
    <script language="javascript">
    <!--
     (function($){
         $.extend({
             adminMenu: {
                 mouseInMenu:false,

                 start:function() {
                     $self = this;
                     $('#menu_zone').append($('a.admin_menu_list[parent_id!="0"]').hide());
                     $self.live();
                 },

                 hideMenu:function() {
                     window.console && window.console.debug(this.mouseInMenu);
                     if($.adminMenu.mouseInMenu==false){
                         $('.admin_children_menu_list').hide();
                     }
                     window.setTimeout('$.adminMenu.hideMenu',3000);
                 },

                 /*
                  * click menu or mouse over menu, show submenu
                  */
                 menuEvent: function() {
                     $self.mouseInMenu = true;
                     var parentIds = '';
                     var parentId  = $(this).attr('parent_id');
                     var $refObj    = $(this);
                     while(parentId!='0') { // find current tree. cache the ids.
                         parentIds = parentIds + '|' + parentId + '|';
                         $refObj = $('a.admin_menu_list[menu_id="' + parentId + '"]');
                         parentId = $refObj.attr('parent_id');
                     }

                     $.each($('.admin_children_menu_list'), function() { // hide all the sub menus except for its own tree
                         parentId = $(this).attr('id').replace(/admin_menu_list_(\d*)/, '$1');
                         if (parentIds.indexOf('|' + parentId + '|')<0) {
                             $(this).hide();
                         }
                     });

                     if ($('#admin_menu_list_' + $(this).attr('menu_id')).length) {
                         $('#admin_menu_list_' + $(this).attr('menu_id')).fadeIn('slow');
                     } else if ($('a.admin_menu_list[parent_id="' + $(this).attr('menu_id') + '"]').length) {
                         var offset = $(this).offset();
                         var offsetLeft = offset.left;
                         var offsetTop  = offset.top;
                         if ($(this).attr('parent_id')=='0') {
                             offsetTop += $(this).height();
                         } else {
                             offsetLeft += $(this).width() + parseInt($(this).css('margin-right'))
                                 + parseInt($(this).css('padding-left'))
                                 + parseInt($(this).css('padding-right'))
                                 ;
                         }

                         $('a.admin_menu_list[parent_id="' + $(this).attr('menu_id') + '"]').show();

                         $('#menu_zone').append($('<div id="admin_menu_list_' + $(this).attr('menu_id') + '" class="admin_children_menu_list"/>').append(
                             $('a.admin_menu_list[parent_id="' + $(this).attr('menu_id') + '"]')).css(
                              {"top":offsetTop, "left":offsetLeft, "z-index":"2", "position":"absolute"}
                             ).fadeIn('slow'));
                         // set sub link width
                         var aWidth = $('#admin_menu_list_' + $(this).attr('menu_id')).width();

                         // add <hr> after add new item link. to identify it from others menu
                         $.each($('#admin_menu_list_' + $(this).attr('menu_id') + ' .admin_menu_add_new_item'), function() {
                             $('<div align="center">').css({"width":aWidth-9}).insertAfter($(this));
                         });
                         if ($.browser.mozilla) {
                             aWidth -= parseInt($('#admin_menu_list_' + $(this).attr('menu_id') + ' a:first').css('padding-left'));
                         }
                         $('a.admin_menu_list[parent_id="' + $(this).attr('menu_id') + '"]').css(
                              {"width":aWidth}
                             );
                     }

                     return false;
                 },
                 live: function() {
                     $self = this;
                     $.each($('a.admin_menu_list'), function() {
                         if ($(this).attr('parent_id')!= '0' && $('a.admin_menu_list[parent_id="' + $(this).attr('menu_id') + '"]').length) {
                             $(this).append(' <font class="menu_admin_sub_menu_arrow"> &gt;&gt;</font>');
                         }

                         $(this).mouseout(function(){
                             $self.mouseInMenu = false;
                         });

                         if($(this).attr('parent_id')=='0') {
                             $(this).click($self.menuEvent);
                         } else {
                             $(this).mouseover($self.menuEvent);
                         }
                     });
                 }
             }// end adminMenu
         });

         $(document).click(function(event) {
             $('.admin_children_menu_list').hide();
         });
         $.adminMenu.start();
     })(jQuery);
    //-->
    </script>
<?php endif; ?>