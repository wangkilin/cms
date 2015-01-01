/**
 * $Rev: 2166 $
 * $LastChangedDate: 2010-05-20 18:35:22 +0800 (Thu, 20 May 2010) $
 * $LastChangedBy: zwang $
 *
 * @category   public
 * @package    styles
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Kilin WANG <zwang@streamwide.com>
 * @version    $Id: agentgroup.js 2166 2010-05-20 10:35:22Z zwang $
 */

/**
 * sitemap behaviors
 */
;(function($){	
	
    $.extend({
    	agentgroup: {
            local: window.location.pathname,
            message: '',
            
            /**
            * init
            *
            * @return Boolean false
            */
            init: function() {
                var $self = this;
                $self._liveEvent();
                
                $self.loadButtonCss();
                if($('#agent_group_list tr.on').length) {
                    $self.showSingleInfo('group_info_table');
                } else {
                    $self.showSingleInfo('agentgroup_usage_table');
                }

                return false;
            },
            
            /**
             * load button CSS
             */
            loadButtonCss: function() {
            	if($('#agent_list tr.on').length==1 || +$('#agent_group_list tr.on').attr('itemId')>0) {
            		$('#modify_button').addClass('on');
            	} else {
            		$('#modify_button').removeClass('on');
            	}
            	
            	if(+$('#agent_group_list tr.on').attr('itemId')>0 && $('#agent_list tr.on').length==0) {
            		$('#delete_group').show().addClass('on');
            	} else {
            		$('#delete_group').hide().removeClass('on');
            	}
            	
            	if ($('#agent_list tr.on').length>0) {
            		$('#delete_agent').show().addClass('on');
            		$('#change_group').show().addClass('on');
            	} else {
            		$('#delete_agent').hide().removeClass('on');
            		$('#change_group').hide().removeClass('on');
            	}
            	
            	return false;
            },
            
            /**
             * show single info table
             */
            showSingleInfo: function (tableId) {
    			$('#agent_info_table').hide();
    			$('#agents_info_table').hide();
    			$('#group_info_table').hide();
    			$('#edit_agent_table').hide();
    			$('#edit_group_table').hide();
    			$('#agentgroup_usage_table').hide();
            	
    			switch(tableId) {
    			    case 'agent_info_table':
    			    	$('#agent_info_table').show();
    			    	$('#agent_name_td').text($('#agent_list tr.on').attr('agentName'));
    			    	$('#agent_login_td').text($('#agent_list tr.on').attr('agentLogin'));
    			    	$('#agent_phone_td').text($('#agent_list tr.on').attr('agentPhone'));
    			    	$('#agent_email_td').text($('#agent_list tr.on').attr('agentEmail'));
    			    	break;

    			    case 'agents_info_table':
    			    	$('#agents_info_table').show();
    			    	$('#count_selected_agents').text($('#agent_list tr.on').length);
    			    	break;

    			    case 'group_info_table':
    			    	$('#group_info_table').show();
    			    	break;

    			    case 'edit_agent_table':
    			    	$('#edit_agent_table').show();
    			    	break;

    			    case 'edit_group_table':
    			    	$('#edit_group_table').show();
    			    	break;
    			    	
    			    default:
    			    	if($('#agent_list :checked').length==1) {
    			    		$('#agent_info_table').show();
    			    	} else if($('#agent_list :checked').length>1) {
    			    		$('#agents_info_table').show();
    			    	} else if($('#agent_group_list tr.on').length) {
    			    		$('#group_info_table').show();
    			    	} else {
    			    		$('#agentgroup_usage_table').show();
    			    	}
    			    	break;
    			}
    			
    			return false;
            },
            
            /**
             * load dropdown summary from checkbox
             */
            loadDropdownSummary: function() {
                $.each($('.dropdown_list > div:not(.dropdown_summary)'), function() {

                    var $summary = $(this).parent().find('.dropdown_summary');
                        summaryLength = 20,
                        summary = '';
                    $.each($(this).closest('.dropdown_list').parent().find('.dropdown_list div:not(.dropdown_summary)'), function() {
                        if($(this).find(':checkbox').attr('checked')) {
                            summary = summary + $(this).find('label').text() + '; ';
                        }
                    });
                    
                    if(summary.length) {
                        $summary.find('i').text(summary.substr(0, summaryLength));
                    } else {
                        $summary.find('i').text($summary.find('i').attr('defaultContent'));
                    }
                });
            },

            /**
             * event listener
             */
            _liveEvent: function() {

                var $self = this;


                // hide date range calendar popup, and hide "triangle" context-menu
                $('body').click(function(event) {
                    var $target = $(event.target);
                    if (! $target.is('.dropdown') &&
                        ! $target.parent().is('.dropdown') &&
                        ! $target.parent().parent().is('.dropdown')) {
                        $('.dropdown').removeClass('dropdown');
                    }
                });
            	
            	/**
            	 * search resource
            	 */
            	$('#search_resource_button').live('click', function() {
            		$._growl(VIEW_DATA[0])._showMask();
            		var params = $(this).closest('form').serialize(),
            		    url    = $(this).closest('form').attr('action');

                    $.post(url , params, function(response) {
                        
                        if (! $(response).hasClass('error')) {
                        	$('#agent_group_list').replaceWith($(response).filter('table'));
                        	$('#agent_group_list tr.on').removeClass('on').find('.agent_group_name').trigger('click');
                        } else {
                        	$._growl(response);
                        }
                        $._destroyGrowl()._showMask();
                    });
            		return false;
            	});
            	
            	/**
            	 * submit edit agentgroup form
            	 */
            	$('#edit_agent_button').live('click', function() {
                    $._growl(VIEW_DATA[0])._showMask();
                    var url = $('#agent_group_list').attr('url') + '/editagent';
                    var listUrl = $('#agent_group_list').attr('url') + '/list';
        			var paramList = $('#edit_agent_form').serialize() + '&act=edit';
        			
        			var groupId = $('#agent_group_list tr.on').attr('itemId');

    		        $.post(url, paramList, function(response){
                        if ($(response).hasClass('error')) {
                            $._destroyGrowl()._growl(response);
                        } else {
                            $self.message = response;
                            $.get(listUrl, function(response){
                                if($(response).hasClass('error')) {
                                    $self.message = '';
                                } else {
                                    $('#agent_group_list').replaceWith($(response).filter('#agent_group_list'));
                                    $('#agent_group_list tr').removeClass('on');
                                    $._showMask();
                                    $('#agent_group_list tr[itemId="'+groupId+'"]').find('.agent_group_name').trigger('click');
                                }
                            });
                        }
                        
    		        });
            		
            		return false;
            	});
            	
            	/**
            	 * submit create agentgroup form
            	 */
            	$('#create_agent_button').live('click', function() {
                    $._growl(VIEW_DATA[0])._showMask();
                    var url = $('#agent_group_list').attr('url') + '/createagent';
                    var listUrl = $('#agent_group_list').attr('url') + '/list';
        			var groupId = $('#agent_group_list tr.on').attr('itemId');
        			var paramList = $('#edit_agent_form').serialize() + '&groupId=' + groupId + '&act=create';

    		        $.post(url, paramList, function(response){
                        if ($(response).hasClass('error')) {
                            $._destroyGrowl()._growl(response);
                        } else {
                            $self.message = response;
                            $.get(listUrl, function(response){
                                if($(response).hasClass('error')) {
                                    $self.message = '';
                                } else {
                                    $('#agent_group_list').replaceWith($(response).filter('#agent_group_list'));
                                    $('#agent_group_list tr').removeClass('on');
                                    $._showMask();
                                    
                                    if(typeof groupId!='string' || groupId.length<1) {
                                        groupId = '0';
                                    }
                                    $('#agent_group_list tr[itemId="'+groupId+'"]').find('.agent_group_name').trigger('click');

                                }
                            });
                        }
                        
    		        });
            		
            		return false;
            	});
            	
            	/**
            	 * submit create group form
            	 */
            	$('#create_group_button').live('click', function() {
            		$._growl(VIEW_DATA[0])._showMask();
            		
        			var url = $('#agent_group_list').attr('url') + '/create';
        			var params = $('#edit_group_form').serialize();
        			
        			// add the selected agent into new group
        			$.each($('#agent_list :checked'), function() {
        				params = params + '&AgentIds[]=' + $(this).val();
        			});
        			
        			params = params + '&act=create'

    		        $.post(url, params, function(response){
            			$._destroyGrowl()._showMask();
                        if ($(response).hasClass('error')) {
                            $._growl(response);
                        } else {
                        	var $newItem = $(response).find('tr');
                        	$('#agent_group_list tbody').prepend($newItem);
                        	$newItem.find('.agent_group_name').trigger('click');
                        }
                        
    		        });
            		
            		return false;
            	});
            	
            	/**
            	 * submit edit group form
            	 */
            	$('#edit_group_button').live('click', function() {
            		$._growl(VIEW_DATA[0])._showMask();
            		
        			var url = $('#agent_group_list').attr('url') + '/edit';
        			var params = $('#edit_group_form').serialize() + '&act=edit';

    		        $.post(url, params, function(response){
            			$._destroyGrowl()._showMask();
                        if ($(response).hasClass('error')) {
                            $._growl(response);
                        } else {
                        	var $newItem = $(response).find('td.agent_group_name');
                        	$('#agent_group_list tr.on').find('td.agent_group_name').replaceWith($newItem);
                        	var $item = $('#agent_group_list tr.on');
                        	$item.removeClass('on');
                        	$item.find('.agent_group_name').trigger('click');
                        }
                        
    		        });
            		
            		return false;
            	});

            	/**
            	 * cancel form submit. only ajax is able to send request.
            	 */
            	$('#edit_group_form, #edit_agent_form').live('submit', function() {
            		
            		return false;
            		
            	});
            	
            	/**
            	 * click agent group name, show agents
            	 */
            	$('.agent_group_name').live('click', function() {
            		if ($(this).parent().hasClass('on')) {
            			return false;
            		}
            		var $item = $(this);
            		var groupId = $(this).attr('groupId');
        			var agentUrl = $('#agent_group_list').attr('url') + '/listagent/AgentGroupId/' + groupId;
        			var overviewUrl = $('#agent_group_list').attr('url') + '/overview/AgentGroupId/' + groupId;
        			
                    $._growl(VIEW_DATA[0])._showMask();

    		        $.get(overviewUrl, function(response){
                        if ($(response).hasClass('error')) {
                            $._growl(response);
                        } else {
                        	$('#agent_detail_zone').html($(response).filter('table, form'));
                        }
                        
    		        });

    		        $.get(agentUrl, function(response){
            			$._destroyGrowl()._showMask();
                        if ($(response).hasClass('error')) {
                            $._growl(response);
                        } else {
                            if($self.message.length) {
                                $._growl($self.message);
                                $self.message = '';
                            }
                        	$('#agent_list').replaceWith($(response).filter('#agent_list'));
            		        
            		        $item.parent().siblings().removeClass('on');
            		        
            		        $item.parent().addClass('on');
            		        
            		        $('#change_group').removeClass('dropdown');
            		        
            		        $self.loadButtonCss();
                        }
                        
    		        });
    		        
            		return false;
            	});
            	
            	/**
            	 * click agent, show agent information
            	 */
            	$('.agent_name_column, #agent_list :checkbox[name="agentIds[]"]').live('click', function() {
            		var $item = $(this).closest('tr');
            		$item.toggleClass('on');
            		
            		if($item.hasClass('on')) {
            			$item.find(':checkbox').attr('checked', 'checked');
            		} else {
            			$item.find(':checkbox').removeAttr('checked');
            		}
            		
            		if($('#edit_group_table:visible').length) {
            			return;
            		}
            		
            		if($('#agent_list :checked').length==1) {
            			$self.showSingleInfo('agent_info_table');
            		} else if($('#agent_list :checked').length==0) {
            			$self.showSingleInfo('group_info_table');
            		} else {
            			$self.showSingleInfo('agents_info_table');
            		}
            		
            		$self.loadButtonCss();
            	});
            	
            	/**
            	 * create agent/group
            	 */
            	$('#add_agent, #add_group').live('click', function() {
            		var url = $(this).attr('href');
            		    tableId = $(this).attr('id')=='add_agent' ? 'edit_agent_table' : 'edit_group_table';
            		
            		$._growl(VIEW_DATA[0])._showMask();

    		        $.get(url, function(response){
            			$._destroyGrowl()._showMask();
                        if ($(response).hasClass('error')) {
                            $._growl(response);
                        } else {
                        	$('#' + tableId).replaceWith($(response).filter('#' + tableId));
                        	$self.showSingleInfo(tableId);
                        }
                        
    		        });
    		        
            		return false;
            	});
            	
            	/**
            	 * click modify button: modify agent/group
            	 */
            	$('#modify_button').live('click', function() {
            		var url = $('#agent_group_list').attr('url');
            		$._growl(VIEW_DATA[0])._showMask();
            		
            		if ($('#agent_list :checked').length) {
            			var AgentId = $('#agent_list :checked').closest('tr').attr('itemId');
            			url = url + '/editagent/AgentId/' + AgentId;

        		        $.get(url, function(response){
                			$._destroyGrowl()._showMask();
                            if ($(response).hasClass('error')) {
                                $._growl(response);
                            } else {
                            	$('#edit_agent_table').replaceWith($(response).filter('#edit_agent_table'));
                            	$self.showSingleInfo('edit_agent_table');
                            	$self.loadDropdownSummary();
                            }
                            
        		        });
            		} else if ($('#agent_group_list tr.on').length) {
            			var GroupId = $('#agent_group_list tr.on').attr('itemId');
            			url = url + '/edit/AgentGroupId/' + GroupId;

        		        $.get(url, function(response){
                			$._destroyGrowl()._showMask();
                            if ($(response).hasClass('error')) {
                                $._growl(response);
                            } else {
                            	$('#edit_group_table').replaceWith($(response).filter('#edit_group_table'));
                            	$self.showSingleInfo('edit_group_table');
                            }
                            
        		        });
            		}
            		
            		return false;
            	});
            	
            	/**
            	 * dropdown list
            	 */
            	$('.dropdown_summary > u').live('click', function() {
            		$(this).parent().parent().toggleClass('dropdown');
            	});
            	
            	/**
            	 * change associate/unassociate agent group list to prepare new group association
            	 */
            	$('#change_group .dropdown_summary > u').live('click', function() {
            		var groupId = $('#agent_group_list tr.on').attr('itemId');
            		$('#bind_group .list_item,#unbind_group .list_item').remove();
            		
            		$.each($('#agent_group_list .list_item'), function() {
            		    var itemId = $(this).attr('itemId');
            		    if(+itemId<1) {
            		        return;
            		    }
            		    $item = $('<div>' + $(this).find('.agent_group_name').text()+'</div>').addClass('list_item').attr('groupId', itemId);
            		    if(itemId==groupId) {
            		        $('#unbind_group').append($item.addClass('unbind'));
            		    } else {
                            $('#bind_group').append($item.addClass('bind'));
            		    }
            		});
            	});
            	
            	/**
            	 * dropdown list
            	 */
            	$('.dropdown_list > div:not(.dropdown_summary)').live('click', function() {
            		var $summary = $(this).parent().find('.dropdown_summary');
            		    summaryLength = 20,
            		    summary = '';
            		
            		$.each($(this).closest('.dropdown_list').parent().find('.dropdown_list div:not(.dropdown_summary)'), function() {
            			if($(this).find(':checkbox').attr('checked')) {
            			    summary = summary + $(this).find('label').text() + '; ';
            			}
            		});
            		
            		if(summary.length) {
            		    $summary.find('i').text(summary.substr(0, summaryLength));
            		} else {
            			$summary.find('i').text($summary.find('i').attr('defaultContent'));
            		}
            	});
            	
            	/**
            	 * associate/unassociate agent with group
            	 */
            	$('#bind_group .list_item, #unbind_group .list_item').live('click', function() {
            		var isBind = $(this).parent().attr('id')=='bind_group';
            		var groupId= $(this).attr('groupId');
            		var params = $('#agent_list_form').serialize();
            		var url = $('#agent_group_list').attr('url');
            		
            		$._growl(VIEW_DATA[0])._showMask();
            		
            		url = url + (isBind ? '/addagent' : '/removeagent');
            		params = params + '&AgentGroupId=' + groupId + (isBind ? '&act=add' : '&act=remove');

    		        $.post(url, params, function(response){
            			$._destroyGrowl()._showMask();
                        if ($(response).hasClass('error')) {
                            $._growl(response);
                        } else {
                        		var $agentCount = $('#agent_group_list .list_item[itemId="'+groupId+'"]').find('.agent_count');
                    		    $agentCount.text($(response).filter('#query_result').attr('group'));
                    		    $agentCount = $('#agent_group_list tr[itemId="0"]').find('.agent_count');
                    		    $agentCount.text($(response).filter('#query_result').attr('unaffected'));
                		        
                        		var $agentGroup = $('#agent_group_list tr.on');
                        		$agentGroup.removeClass('on');
                        		$agentGroup.find('.agent_group_name').trigger('click');
                        	
                        	$('#change_group').removeClass('dropdown');
                        	$._growl(response, false);
                        }
                        
    		        });
            		
            		return false;
            		
            	});
            	
            	/**
            	 * delete agent; reload agent group
            	 */
            	$('#delete_agent').live('click', function() {
            		var url = $('#agent_group_list').attr('url');
            		$._growl(VIEW_DATA[0])._showMask();
            		
            		if ($('#agent_list :checked').length) {
            			var AgentId = $('#agent_list :checked').closest('tr').attr('itemId');
            			    url = url + '/deleteagent',
            			    params = $('#agent_list_form').serialize() + '&act=delete';
            			    
            			if($('#agent_list :checked').length>1) {
            			// batch delete
            			    url += '/isBatch/y'
            			} else {
            			    var agentName = $('#agent_list :checked').closest('tr').find('.agent_name_column').text();
            			    url = url + '/agentName/' + agentName;
            			}

                		$.get(url, function(response){
                			$._destroyGrowl();
                            if ($(response).hasClass('error')) {
                                $._growl(response)._showMask();
                            } else {
                                var $dialog = $(response);
                                $._drawDialog($dialog, [400,200]);
                                $dialog.submit(function() {
                                    $._growl(VIEW_DATA[0])._showMask($dialog);
                                    $.post(url , params, function(response) {
                                        $._growl(response, $(response).hasClass('error') ? true : false);
                                        if (! $(response).hasClass('error')) {
                                            $dialog.find('.heading-close').trigger('click');
                                            
                                    		$.each($(response).find('.minusGroup'), function() {// check group , agent count minus 1
                                    			var groupId = $(this).attr('id');
                                    			var $item = $('#agent_group_list tr[itemId="' + groupId + '"]').find('.agent_count');
                                    			$item.text(+$item.text() - 1);
                                    			$item = $('#agent_group_list tr[itemId="-1"]').find('.agent_count');
                                    			$item.text(+$item.text() - 1);
                                    			
                                    		});
                                    		
                                    		$('#agent_list tr.on').remove();
                                    		var $agentGroup = $('#agent_group_list tr.on');
                                    		$agentGroup.removeClass('on');
                                    		$agentGroup.find('.agent_group_name').trigger('click');
                                        }
                                    });
                                    return false;
                                });
                            }
                        });
            		}
            		
            		return false;
            	});
            	
            	/**
            	 * remove agent from group
            	 */
            	/*
            	$('.group_remove_agent').live('click', function() {
                	$._growl(VIEW_DATA[0])._showMask();
                	var groupId = $(this).attr('itemId');
                	var url = $('#agent_group_list').attr('url') + '/removeagent/';
                	var params = $('#agent_list_form').serialize() + '&AgentGroupId=' + groupId + '&act=remove';
                	
                	$.post(url, params, function(response){
            			$._destroyGrowl()._showMask();
                        if ($(response).hasClass('error')) {
                            $._growl(response);
                        } else {
                        	$('#agent_list tr.on').remove();
                        	$self.showSingleInfo();
                            $self.loadButtonCss();
                        }
                        
    		        });
                	
            		return false;
            	});
            	
            	/**
            	 * group add agent
            	 *
            	$('.group_add_agent').live('click', function() {
            		return false;
            	});*/
            	
            	/**
            	 * delete group
            	 */
            	$('#delete_group.on').live('click', function() {
            		if($('#agent_group_list tr.on').length) {
                    	$._growl(VIEW_DATA[0])._showMask();
                    	var groupId = $('#agent_group_list tr.on').attr('itemId');
                    	var url = $('#agent_group_list').attr('url') + '/remove/AgentGroupId/' + groupId;

                		$.get(url, function(response){
                			$._destroyGrowl();
                            if ($(response).hasClass('error')) {
                                $._growl(response)._showMask();
                            } else {
                                var $dialog = $(response);
                                $._drawDialog($dialog, [400,200]);
                                $dialog.submit(function() {
                                        $._growl(VIEW_DATA[0])._showMask($dialog);
                                        var $params = $(this).find('form').serialize() + '&act=remove';
                                        $.post(url , $params, function(response) {
                                            $._growl(response, $(response).hasClass('error') ? true : false);
                                            if (! $(response).hasClass('error')) {
                                                $dialog.find('.heading-close').trigger('click');
                                                $('#agent_group_list tr.on').remove();
                                                $('#agent_list > tbody').remove();
                                                $self.showSingleInfo();
                                                $self.loadButtonCss();

                                                var $agentCount = $('#agent_group_list tr[itemId="0"]').find('.agent_count');
                                                $agentCount.text($(response).attr('unaffected'));
                                            }
                                        });
                                        return false;
                                });
                            }
                        });
            		}

            		return false;
            	});
            	
            	/**
            	 * click cancel button
            	 */
            	$('.form_cancel').live('click', function() {
            		$self.showSingleInfo();
            		
            		return false;
            	});
            	
            }

        }
    });

    /**
     * Initialization after DOM ready
     */
    $(function() {
        $.agentgroup.init();
    });
})(jQuery);

/* EOF */