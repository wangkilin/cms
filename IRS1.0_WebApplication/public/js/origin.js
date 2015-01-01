/**
 * $Rev: 2166 $
 * $LastChangedDate: 2010-05-20 18:35:22 +0800 (Thu, 20 May 2010) $
 * $LastChangedBy: zwang $
 *
 * @category   public
 * @package    styles
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Kilin WANG <zwang@streamwide.com>
 * @version    $Id: origin.js 2166 2010-05-20 10:35:22Z zwang $
 */

/**
 * sitemap behaviors
 */
;(function($){

	$.resourceCommon.createAction = function($item) {
		var url;

		if($item) {
			url = $item.attr('href');
		} else if($(this).attr('href')) {
			url = $(this).attr('href');
		}

		return $.resourceCommon.crudAction([500,200], 'create', url, false);

		//return false;
	};

	$.resourceCommon.editAction = function() {
		$.resourceCommon.crudAction([500,200], 'edit', $(this).attr('href'), false);

		return false;
	};

	$.resourceCommon.deleteAction = function() {
		$.resourceCommon.crudAction([400,200], 'delete', $(this).attr('href'), true, $.origin.deleteAction, $(this));

		return false;
	};


    $.extend({
    	origin: {
            local: window.location.pathname,

            /**
             * delete action
             */
            deleteAction:function($item) {
    	        $item.closest('tr').remove();
            },

            /**
            * init
            *
            * @return Boolean false
            */
            init: function() {
                var $self = this;
                $self._liveEvent();

                return false;
            },

            /**
             * event listener
             */
            _liveEvent: function() {

                var $self = this;

                /**
                 * click left menu link, change main content
                 */
                $('#left_menu a:not(.only-popup)').live('click', function() {
                    if (! $(this).hasClass('on')) {
                        $._growl(VIEW_DATA[0])._showMask();
                        var url = $(this).attr('href'),
                            aLink = this;

                        $.get(url, function(response) {
                            $._growl(response, $(response).hasClass('error') ? true : false);
                            if (! $(response).hasClass('error')) {
                                $('#main_content').replaceWith($(response).filter('#main_content'));
                                $._destroyGrowl()._showMask();
                            }
                        });

                        $('#left_menu a').removeClass('on');
                        $(this).addClass('on');
                    }

                    return false;
                });


                /**
                 * click left menu link, change main content
                 */
                $('#left_menu a.only-popup').live('click', function() {
                        $.resourceCommon.createAction($(this));

                        $('#left_menu a').removeClass('on');
                        $(this).addClass('on');
                        
                        return false;
                });


            	/**
            	 * edit menu in list item
            	 */
            	$('.list_edit').live('click', $.resourceCommon.editAction);

            	/**
            	 * delete menu in list item
            	 */
            	$('.list_delete').live('click', $.resourceCommon.deleteAction);

            	/**
            	 * submit edit origin form
            	 */
            	$('#edit_button').live('click', function() {
            		var $item = $(this);
            		var $dialog = $item.closest('.dialog').attr('id', 'edit_origin_dialog');
                    $._growl(VIEW_DATA[0])._showMask($dialog);
        			var url = $('#edit-origin-form').attr('action');
        			var paramList = $('#edit-origin-form').serialize() + '&act=edit';;
    		        $.post(url, paramList, function(response){
            			$._destroyGrowl();
                        if ($(response).hasClass('error')) {
                            $._growl(response)._showMask($dialog);
                        } else {
                        	$dialog.find('.heading-close').trigger('click');
                        	$('.list_item[itemId="' + $item.attr('itemId') + '"]').html($(response).find('tr').html());
                        	$._growl(response);
                        }

    		        });

            		return false;
            	});

            	/**
            	 * submit create origin form
            	 */
            	$('#create_button').live('click', function() {
            		var $item = $(this);
            		var $dialog = $item.closest('.dialog').attr('id', 'edit_origin_dialog');
                    $._growl(VIEW_DATA[0])._showMask($dialog);
        			var url = $('#create-origin-form').attr('action');
        			var paramList = $('#create-origin-form').serialize() + '&act=create';

    		        $.post(url, paramList, function(response){
            			$._destroyGrowl();
                        if ($(response).hasClass('error')) {
                            $._growl(response)._showMask($dialog);
                        } else {
                        	$dialog.find('.heading-close').trigger('click');
                        	$('#main_content').replaceWith($(response).filter('#main_content'));
                        	$('#left_menu a').removeClass('on');
                        	$('#list_origin_menu').addClass('on');
                        	$._growl(response);
                        }

    		        });

            		return false;
            	});

            	/**
            	 * cancel form submit. only ajax is able to send request.
            	 */
            	$('#edit-origin-form, #create-origin-form').live('submit', function() {

            		return false;

            	});

                /**
                 * cancel form submit. only ajax is able to send request.
                 */
                $('#edit-origin-form, #create-origin-form').live('mouseover', function() {
                    if($('#user_prefix_list dd').length) {
                        $('#user_prefix_list').show();
                    }else {
                        $('#user_prefix_list').hide();
                    }

                    return false;

                });

            	/**
            	 * click plus icon, show origins
            	 */
            	$('.dialog dt i').live('click', function() {
            		$(this).closest('dl').toggleClass('collapse');
            		$(this).closest('dl').removeClass('on');
            		$(this).closest('dl').find('.on').removeClass('on');
            	});

            	/**
            	 * click dd add class 'on'
            	 */
            	$('.dialog dd').live('click', function() {
            		$(this).toggleClass('on');
            	});

            	/**
            	 * click dd, dl.collapse, add class 'on'
            	 */
            	$('.dialog dl.collapse u').live('click', function() {
            		$(this).closest('dl').toggleClass('on');
            		$(this).closest('dl').find('.on').removeClass('on');
            	});

            	/**
            	 * add/remove origin
            	 */
            	$('#go_right, #go_left').live('click', function() {

            		var isLeft = $(this).hasClass('left_arrow'),
            		    $to    = isLeft ? $('#system_origin_list') : $('#user_origin_list'),
            		    $from    = isLeft ? $('#user_origin_list') : $('#system_origin_list'),
            		    $items = $from.find('.on'),
            		    $cloneItems,
            		    removeAble = true;

            		if ($items.length<1) {
            			return false;
            		}

            		// edit origin, change origin prefix in time
            		if($(this).closest('form').attr('id') == 'edit-origin-form') {
            			removeAble = false;
            			var url = $(this).attr('action') + (isLeft ? '/removeitem' : '/associate');
                		var $item = $(this);
                		var $dialog = $item.closest('.dialog').attr('id', 'edit-origin-form-dialog');
                		var origins  = '';
                		var prefixes = '';
                		var $originItems;

                		$originItems = $items.find('.origin_item');

                		$.each($originItems, function() {
                			var itemName = $(this).attr('name');
                			switch (itemName) {
                			    case 'SysOriginIds[]':
                			    	$(this).removeAttr('name').attr('name', 'NewOriginIds[]');
                				    break;
                			    case 'OriginIds[]':
                			    	$(this).removeAttr('name').attr('name', 'RemoveOriginIds[]');
                			    	break;
                			    case 'Prefixes[]':
                			    	$(this).removeAttr('name').attr('name', 'RemovePrefixes[]');
                			    	break;
                				default:
                					break;
                			}
                		});
                        $._growl(VIEW_DATA[0])._showMask($dialog);
            			var paramList = $('#edit-origin-form').serialize() + '&act=' + (isLeft ? 'removeitem' : 'associate');

        		        $.post(url, paramList, function(response){
                			$._destroyGrowl();
                            if ($(response).hasClass('error')) {
                                $._growl(response, true)._showMask($dialog);
                            } else {
                            	$._growl(response, false)._showMask($dialog);

                            	$items.removeClass('on').find('.on').removeClass('on');
                    			if(isLeft) {
                    				$items.remove();
                    			} else { // add user origin
                    				$cloneItems = $items.clone();
                    				$cloneItems.find('.origin_item').attr('name', 'OriginIds[]');
                    			    $to.append($cloneItems);
                    			    $to.append($('#user_prefix_list'));
                    			}
                            }

                    		$.each($originItems, function() {
                    			var itemName = $(this).attr('name');
                    			switch (itemName) {
                    			    case 'NewOriginIds[]':
                    			    	$(this).removeAttr('name').attr('name', 'SysOriginIds[]');
                    				    break;
                    			    case 'RemoveOriginIds[]':
                    			    	$(this).removeAttr('name').attr('name', 'OriginIds[]');
                    			    	break;
                    			    case 'RemovePrefixes[]':
                    			    	$(this).removeAttr('name').attr('name', 'Prefixes[]');
                    			    	break;
                    				default:
                    					break;
                    			}
                    		});

                            return false;

        		        });
            		}

            		if(removeAble) {
            			$items.removeClass('on').find('.on').removeClass('on');
            			if(isLeft) {
            				$items.remove();
            			} else { // add user origin
            				$cloneItems = $items.clone();
            				$cloneItems.find('.origin_item').attr('name', 'OriginIds[]');
            			    $to.append($cloneItems);
            			}
            		}

            		return false;
            	});

            	/**
            	 * add prefix
            	 */
            	$('#add_prefix').live('click', function() {
            		var append = true;

            		// edit origin, change origin prefix in time
            		if($(this).closest('form').attr('id') == 'edit-origin-form') {
            			append = false;
            			var url = $(this).attr('action');
                		var $item = $(this);
                		var $dialog = $item.closest('.dialog').attr('id', 'edit-origin-form-dialog');
                        $._growl(VIEW_DATA[0])._showMask($dialog);
            			var paramList = {'PrefixPhoneNumber':$.trim($('#phone_prefix').val()),
            					         'act':'add',
            					         'OriginId':$('#OriginId').val()
            					        };

        		        $.post(url, paramList, function(response){
                			$._destroyGrowl();
                            if ($(response).hasClass('error')) {
                                $._growl(response)._showMask($dialog);
                            } else {
                            	$._growl(response)._showMask($dialog);

                            	$('#user_prefix_list').append('<dd>' + $.trim($('#phone_prefix').val()) + '<input type="hidden" value="' + $.trim($('#phone_prefix').val())+'" name="Prefixes[]" class="origin_item"></dd>');
                    		    $('#user_prefix_list').show();
                            }

                            return false;

        		        });
            		}

            		if (append) {
            		    $('#user_prefix_list').append('<dd>' + $.trim($('#phone_prefix').val()) + '<input type="hidden" value="' + $.trim($('#phone_prefix').val())+'" name="Prefixes[]" class="origin_item"></dd>');
            		    $('#user_prefix_list').show();
            		}

            		return false;
            	});

            }

        }
    });

    /**
     * Initialization after DOM ready
     */
    $(function() {
        $.origin.init();
    });
})(jQuery);

/* EOF */