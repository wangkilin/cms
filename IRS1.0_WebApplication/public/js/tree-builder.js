/**
 * $Rev: 2648 $
 * $LastChangedDate: 2010-06-22 18:39:09 +0800 (Tue, 22 Jun 2010) $
 * $LastChangedBy: junzhang $
 *
 * @category   public
 * @package    js
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: tree-builder.js 2648 2010-06-22 10:39:09Z junzhang $
 */

/**
 * tree builder behaviors
 */
;(function($){
    var 
        // Storing the stage actual size, eg. {width: 10, height:10}
        __stageSize__ = {},
        // Binding the effect draggable onto the DOM '#stage'
        _stageDraggable = function(){
            $('#stage').draggable();
        }, 
        // Binding the effect leftClick Contextmenu onto the DOM '.node' and '#start'
        _contextmenu = function(){
            $('#stage table tbody td > div, .output-to-node').live('hover', function(ev){
                $('.contextmenu > dl,a.trigger >.ui-icon, > dl', this).removeAttr('style');
            },function(ev){
                $('.contextmenu > dl,a.trigger >.ui-icon, > dl', this).removeAttr('style');
            });
            $('.contextmenu > a.trigger').live('click', function(ev){
                $('.ui-icon', this).css({
                    zIndex: 99
                });
                $(this).next('dl').css({
                    left: $(this).offsetParent().outerWidth(true) - 22
                }).toggle(100);
                ev.preventDefault();
            });
            //live clickable on the contextmenu items
            $('.contextmenu > dl a').live('click', function(ev){
                var _this = $(this),
                    _type = _this.attr('class'),
                    _nodeId = _this.parent().attr('id'),
                    _action = _this.closest('dl').siblings('.trigger').attr('id'),
                    _nodeType = _type.split('-').pop(),
                    _actionUrl = $.getBaseUrl() + '/node/' + _action + '/' + _type.replace('-', '/'),
                    _nodeTypeId = _this.attr('id');

                // Showing the notification and overlay masker
                $._growl(VIEW_DATA[0])._showMask();

                if (_this.parent().is('dd')) {
                    //TODO:
                    $.post(_actionUrl, {NodeId: 1, act: _type}, function(response){
                    });
                } else {
                    if (_nodeId) {
                        _actionUrl += '/' + _nodeId.replace('-', '/');
                    }
                    //window.console && window.console.debug(_nodeType);
                    $.get(_actionUrl, function(response){
                        $._destroyGrowl();
                        if ($(response).hasClass('error')) {
                            $._growl(response)._showMask();
                        } else {
                            var $dialog = $(response);
                            $dialog.submit(function(){
                                $._growl(VIEW_DATA[0])._showMask($dialog);
                                var _treeId = $('.tree').attr('id').replace('-', '='),
                                    _defaultInputs = $dialog.find('.input_default').attr('disabled', 'disabled'),
                                    _param = $(this).find('form').serialize();
                                _defaultInputs.removeAttr('disabled');
                                //window.console && window.console.debug(_param);
                                _param += '&NodeTypeId=' + _nodeTypeId + '&' + _treeId;
                                $.post(_actionUrl, _param, function(response) {
                                    if ($(response).hasClass('error')) {
                                        $._growl(response)._showMask($dialog);
                                    } else {
                                        $._growl(response)._showMask($dialog);
                                    }
                                });
                                return false;
                            });
                            $._drawDialog($dialog, [750, 100]);
                            _eventsOnForm[_nodeType] && _eventsOnForm[_nodeType]($dialog);
                        }
                        //window.console && window.console.debug(_actionUrl);
                    });
                }
                ev.preventDefault();
            });
        },
        _eventsOnForm = {
            origin: function(dom){
                $.builder.isOriginEverLoaded = ($.builder.isOriginEverLoaded == undefined ? false : true);
                
                /**
                * change output focus
                */
                $('.node_output > i').die('click').live('click', function() {
                    var $output = $(this).parent();
                    var itemId = $output.attr('itemId');
                    var resourceType = $output.attr('type');
                    var resourceId = $output.attr('resourceId');
                    var url = $('#output_zone').attr('action') + '/edit/type/'+resourceType+'/outputId/' + resourceId;
                    var $dialog = $(this).closest('.dialog');
                    if (!$output.hasClass('on')) {
                        $output.siblings().removeClass('on');
                        /* related origin resource has not loaded, Ajax request */
                        if ($('.resource_zone[itemId="' + itemId + '"]').length<1 && ''!=resourceId) {
                            $.get(url, function(response){
                                $._destroyGrowl();
                                if ($(response).hasClass('error')) {
                                    $._growl(response)._showMask($dialog);
                                } else {
                                    $._growl(response)._showMask($dialog);
                                    var $resourceZone = $(response).find('.resource_zone');
                                    $resourceZone.attr('itemId', itemId);
                                    /* change param name */
                                    $.each($resourceZone.find('input, select'), function() {
                                        var name = $(this).attr('name');
            
                                        $(this).attr('name', name.replace('params[1]', 'params['+itemId+']'));
                                    });
                                    $('#td_resource_zone').append($resourceZone);
                                    $('.resource_zone').hide();
                                    $('.resource_zone[itemId="' + itemId + '"]').show();
                                }

                                return false;
            
                            });
                        } else {
                            $('.resource_zone').hide();
                            $('.resource_zone[itemId="' + itemId + '"]').show();
                        }
                        $output.addClass('on');
                        $('.output_menu').removeClass('on');
                    }

                    return false;
                });

                if (!$.builder.isOriginEverLoaded) {
                
                    /**
                    * click plus icon, show origins
                    */
                    $('#table_origin_node dt i').live('click', function() {
                        $(this).closest('dl').toggleClass('collapse');
                        $(this).closest('dl').removeClass('on');
                        $(this).closest('dl').find('.on').removeClass('on');
                    });
                
                    /**
                    * click dd add class 'on'
                    */
                    $('#table_origin_node dd').live('click', function() {
                        $(this).toggleClass('on');
                    });
                
                    /**
                    * click dd, dl.collapse, add class 'on'
                    */
                    $('#table_origin_node dl.collapse u').live('click', function() {
                        $(this).closest('dl').toggleClass('on');
                        $(this).closest('dl').find('.on').removeClass('on');
                    });
                
                    /**
                    * change resource, refresh origin list
                    */
                    $('#table_origin_node .origin_resource_list').live('change', function() {
                        var originId = $(this).val(),
                            url= $(this).attr('action') + '/edit/id/' + originId,
                            $dialog = $(this).closest('.dialog'),
                            $table = $(this).closest('table');

                        $._growl(VIEW_DATA[0])._showMask($dialog);

                        $.get(url, function(response) {
                            $._destroyGrowl();
                            if ($(response).hasClass('error')) {
                                $._growl(response)._showMask($dialog);
                            } else {
                                $._growl(response)._showMask($dialog);
                                $table.find('.resource_origin_list').html($(response).find('#user_origin_list').html());
                            }
                        });
                
                    });
                
                    /**
                    * add/remove origin into/from resource
                    */
                    $('.go_right, .go_left').live('click', function() {
                        var isLeft = $(this).hasClass('left_arrow'),
                            $table = $(this).closest('table');
                            $to    = isLeft ? $table.find('.system_origin_list') : $table.find('.user_origin_list'),
                            $from  = isLeft ? $table.find('.user_origin_list') : $table.find('.system_origin_list'),
                            $items = $from.find('.on'),
                            $cloneItems = null,
                            removeAble = true,
                            itemId = $table.attr('itemId');

                        if ($items.length<1) {
                            return false;
                        }

                        // edit origin, change origin prefix in time
                        if($table.find('.CustomOriginId').length) {
                            removeAble = false;
                            var url = $(this).attr('action') + (isLeft ? '/removeitem' : '/associate');
                            var $item = $(this);
                            var $dialog = $item.closest('.dialog');
                            var origins  = '';
                            var prefixes = '';
                            var $originItems;
                            var originId = $table.find('.CustomOriginId').val();
                            var paramList = 'originId' + originId;

                            $originItems = $items.find('.origin_item');

                            $.each($originItems, function() {
                                var itemName = $(this).attr('name');
                                if (itemName.indexOf('SysOriginIds')>-1) {
                                    paramList = paramList + '&NewOriginIds[]=' + $(this).val();
                                } else if (itemName.indexOf('OriginIds')>-1) {
                                    paramList = paramList + '&RemoveOriginIds[]=' + $(this).val();
                                } else if (itemName.indexOf('Prefixes')>-1) {
                                    paramList = paramList + '&RemovePrefixes[]=' + $(this).val();
                                } else {
                                }
                            });

                            $._growl(VIEW_DATA[0])._showMask($dialog);
                            paramList = paramList + '&act=' + (isLeft ? 'removeitem' : 'associate');

                            $.post(url, paramList, function(response){
                                $._destroyGrowl();
                                if ($(response).hasClass('error')) {
                                    $._growl(response)._showMask($dialog);
                                } else {
                                    $._growl(response)._showMask($dialog);

                                    $items.removeClass('on').find('.on').removeClass('on');
                                    if(isLeft) {
                                        $items.remove();
                                    } else { // add user origin
                                        $cloneItems = $items.clone();
                                        $cloneItems.find('.origin_item').attr('name', 'OriginIds[]');
                                        $to.append($cloneItems);
                                        $to.append($('.user_prefix_list'));
                                    }
                                }
                                return false;
                            });
                        }

                        if(removeAble) {
                            $items.removeClass('on').find('.on').removeClass('on');
                            if(isLeft) {
                                $items.remove();
                            } else { // add user origin
                                $cloneItems = $items.clone();
                                $cloneItems.find('.origin_item').attr('name', 'params[' + itemId + '][OriginIds][]');
                                $to.append($cloneItems);
                            }
                        }

                        return false;
                    });
                
                    /**
                    * add prefix
                    */
                    $('.add_prefix').live('click', function() {
                        var append = true;
                        var $table = $(this).closest('table');
                
                        // edit origin, change origin prefix in time
                        if($table.find('.CustomOriginId').length) {
                            append = false;
                            var url = $(this).attr('action');
                            var $item = $(this);
                            var $dialog = $item.closest('.dialog');
                            $._growl(VIEW_DATA[0])._showMask($dialog);
                            var paramList = {'PrefixPhoneNumber':$.trim($table.find('.phone_prefix').val()),
                                'act':'add',
                                'OriginId':$table.find('.CustomOriginId').val()
                            };

                            $.post(url, paramList, function(response){
                                $._destroyGrowl();
                                if ($(response).hasClass('error')) {
                                    $._growl(response)._showMask($dialog);
                                } else {
                                    $._growl(response)._showMask($dialog);
                                    var html ='<dd>'
                                        + $.trim($table.find('.phone_prefix').val())
                                        + '<input type="hidden" value="'
                                        + $.trim($table.find('.phone_prefix').val())
                                        +'" name="Prefixes[]" class="origin_item">'
                                        + '</dd>';

                                    $table.find('.user_prefix_list').append(html);
                                    $table.find('.user_prefix_list').show();
                                }

                                return false;

                            });
                        }
                
                        if (append) {
                            var itemId = $('.node_output.on').attr('itemId');
                            var html ='<dd>'
                                + $.trim($table.find('.phone_prefix').val())
                                + '<input type="hidden" value="'
                                + $.trim($table.find('.phone_prefix').val())
                                +'" name="params[' + itemId + '][Prefixes][]" class="origin_item">'
                                +'</dd>';

                            $table.find('.user_prefix_list').append(html);
                            $table.find('.user_prefix_list').show();
                        }

                        return false;
                    });

                    /**
                    * add new output
                    */
                    $('#add_origin_output_button').live('click', function() {
                        var itemId = +$('.node_output:last').attr('itemId') + 1;
                        var $output = $('#output_template').clone().removeAttr('id').attr('itemId', itemId).addClass('node_output');
                        var $table = $('.resource_zone:first').clone();
                        var replaceName = 'params[' + $('.resource_zone:first').attr('itemId') + ']';
                        $output.append('<input class="node_output_name" type="hidden" name="params['+itemId+'][OutputName][]" value="Output '+itemId+'"/>');
                        $output.prepend('<input class="node_output_isactive" type="checkbox" checked="checked" name="params['+itemId+'][IsActive][]" value="1"/>');
                        $output.find('i').text($output.find('.node_output_name').val());
                        /** set resource table property */
                        $table.attr('itemId', itemId);
                        /* change param name */
                        $.each($table.find('input, select'), function() {
                            var name = $(this).attr('name');
                
                            $(this).attr('name', name.replace(replaceName, 'params['+itemId+']'));
                        });

                        $('#add_origin_output_button').before($output);
                        $('.node_output').removeClass('on');
                        $output.addClass('on');
                
                        $('#td_resource_zone').append($table);
                        $('.resource_zone').removeClass('on').hide();
                        $table.addClass('on').show();
                
                        $table.find('.CustomOriginId').remove();
                
                        if($table.find('.origin_resource_list option').length) {
                            $table.find('.OriginTypeResource').attr('checked', 'checked');
                            $table.find('.OriginTypeCustome').removeAttr('checked');
                            $table.find('.resource_list').show();
                            $table.find('.custom_list').hide();
                        } else {
                            $table.find('.OriginTypeCustome').attr('checked', 'checked');
                            $table.find('.OriginTypeResource').removeAttr('checked');
                            $table.find('.custom_list').show();
                            $table.find('.resource_list').hide();
                        }
                    });

                    /**
                    * toggle User defined resource list
                    */
                    $('.OriginTypeResource').live('click', function() {
                        if ($(this).attr('checked')=='checked') {
                            $(this).closest('.resource_zone').find('.custom_list').show();
                            $(this).closest('.resource_zone').find('.resource_list').hide();
                        } else {
                            $(this).closest('.resource_zone').find('.custom_list').hide();
                            $(this).closest('.resource_zone').find('.resource_list').show();
                        }
                    });

                    /**
                    * toggle Custom origin
                    */
                    $('.OriginTypeCustom').live('click', function() {
                        if ($(this).attr('checked')=='checked') {
                            $(this).closest('.resource_zone').find('.custom_list').hide();
                            $(this).closest('.resource_zone').find('.resource_list').show();
                        } else {
                            $(this).closest('.resource_zone').find('.custom_list').show();
                            $(this).closest('.resource_zone').find('.resource_list').hide();
                        }
                    });
                }
            },
            calendar: function(dom){
                //$(dom).ready(function() {
                //    $.calendarNode._formEvent();
                //});
                $.builder.isCalendarEverLoaded = ($.builder.isCalendarEverLoaded == undefined ? false : true);

                if (!$.builder.isCalendarEverLoaded) {
                    $.calendarNode.init();
                }
                $.calendarNode._changeOutputFocus();
                $.calendarNode._formEvent();
            },
            link: function(dom){
                var $form = $(dom),
                    _linkedNodeId = $form.find('input[name="LinkedNodeId"]'),
                    _treeLists = $form.find('#TreeList'),
                    _queryNodeHandler = $form.find('#QueryNodes'),
                    _oldValues = [_linkedNodeId.val(), _treeLists.val(), _queryNodeHandler.val()],
                    _availableNodes = $.map($('div.node[id^="node"]'), function(dom){
                        var _dom = $(dom),
                            _id = _dom.attr('id').replace('node-', ''),
                            _value = _dom.children('b').text();
                        return {id: _id, value: _value};
                    });
                $form.find('div[class^="IsInternal"]').not(
                    '.IsInternal-' + $form.find('input[name="IsInternal"]').val()
                ).hide();
                $form.find('input[name="IsInternal"]').click(function(){
                    var _this = $(this),
                        _target = _this.attr('id');
                    _linkedNodeId.val(_oldValues[0]);
                    _treeLists.val(_oldValues[1]);
                    _queryNodeHandler.val(_oldValues[2]);
                    $form.find('div[class^="IsInternal"]').hide().filter('.' + _target).show();
                });
                _treeLists.change(function(){
                    _linkedNodeId.val($(this).val());
                });
                _queryNodeHandler.autocomplete({
                    source: _availableNodes,
                    select: function(ev,ui){
                        _linkedNodeId.val(ui.item.id);
                        //window.console && window.console.debug(ui.item.id);
                    }
                });
                //window.console && window.console.debug(dom);
            },
            menu: function(dom){
                var $form = $(dom),
                    _keyBoard = $form.find('.keyboard > label').not('.locked'),
                    _keyActived = _keyBoard.filter('.assigned'),
                    _keyOptions = _keyBoard.not(_keyActived),
                    _keyClickEvent = function($key){
                        return $key.hover(function(){
                            $(this).addClass('ui-state-hover');
                        }, function(){
                            $(this).removeClass('ui-state-hover');
                        }).click(function(){
                            var _this = $(this),
                                _input = _this.children('input'),
                                _isAvailabled = $(this).is('.ui-state-active');
                            _this.toggleClass('ui-state-active');
                            _isAvailabled && _input.attr('disabled', 'disabled') || _input.removeAttr('disabled');
                            //window.console && window.console.debug(_state);
                            return false;
                        });
                    };
                _keyActived.click(function(){
                    var _thisKey = $(this),
                        _thisInput = _thisKey.children('input');
                    $.post($.getBaseUrl() + '/node/cell/act/remove', {
                        NodeOutputId: _thisInput.val()
                    }, function(response){
                        // while success 
                        _thisInput.attr('disabled', 'disabled').val('');
                        _thisKey.removeClass('ui-state-active assigned').unbind('click').siblings('.keyboard-state').remove();
                        _keyActived = _keyActived.not(_thisKey);
                        _keyOptions = _keyOptions.add(_keyClickEvent(_thisKey));
                        //window.console && window.console.debug(_keyOptions);
                    });
                    return false;
                });
                _keyClickEvent(_keyOptions);
                //window.console && window.console.debug(_keyOptions);
            },
            destination: function(dom){
                var $form = $(dom);

                $form.find('.destination-type input[type="radio"]').click(function(){
                    var _this = $(this),
                        _id = _this.attr('id'),
                        _currentContainer = $form.find('.destination-parameters > .' + _id).show();
                    _currentContainer.find('input,select').removeAttr('disabled');
                    $form.find('.destination-parameters').children().not(
                        _currentContainer
                    ).hide().find('input,select').attr('disabled','disabled');
                }).filter(':checked').trigger('click');

                $form.find('dl > dt > label > input').click(function(){
                    var _input = $(this),
                        _label = _input.parent(),
                        _container = _label.closest('dl'),
                        _oldState = _input.is(':checked');

                    if (_input.is(':disabled')) {
                        return false;
                    }

                    if (_oldState) {
                        _container.find('input,select').not(_input).not(_input.siblings('input')).removeAttr('disabled');
                    } else {
                        _container.find('input,select').not(_input).not(_input.siblings('input')).attr('disabled', 'disabled');
                    }
                });

                $form.find('.destination-parameters-failover-contact .ui-icon').click(function(){
                    var _icon = $(this),
                        _container = _icon.closest('.destination-parameters-failover-contact');
                    if (_icon.is('.ui-icon-minus')) {
                        _container.siblings('div').length && _container.remove();
                    } else {
                        _container.siblings('div').length < 9 && _container.after(
                            _container.clone(true)
                        );
                    }
                });

                var _outputs = $form.find('.destination-outputs-option > label');
                _outputs.hover(function(){
                    $(this).triggerHandler('mousemove').addClass('ui-state-hover').next('.description').show();
                }, function(){
                    $(this).removeClass('ui-state-hover').next('.description').hide();
                }).click(function(){
                    var _this = $(this),
                        _input = _this.children('input'),
                        _isAvailabled = $(this).is('.ui-state-active');
                    _this.toggleClass('ui-state-active');
                    _isAvailabled && _input.attr('disabled', 'disabled') || _input.removeAttr('disabled');
                    //window.console && window.console.debug(_state);
                    return false;
                }).mousemove(function(ev){
                    $(this).next('.description').show().css({
                        left: (ev.layerX ? ev.layerX : 0) + 20,
                        top: (ev.layerY ? ev.layerY : 0) - 11
                    });
                    //window.console && window.console.debug(ev);
                });
            },
            distribution: function(dom){
                var $form = $(dom),
                    $outputs = $form.find('.outputs');
                $form.find('input[name="DistributionTypeId"]').click(function(){
                    var _this = $(this),
                        _theTpe = +(_this.val());
                    if (1 == _theTpe) {
                        $outputs.find('.percentage').show();
                    } else {
                        $outputs.find('.percentage').hide();
                    }
                }).filter(':checked').trigger('click');
                $outputs.find('tr td input[type="checkbox"]').click(function(){
                    var _handler = $(this),
                        _oldState = _handler.is(':checked');
                    if (_oldState) {
                        _handler.closest('tr').find('input').not(_handler).removeAttr('disabled');
                    } else {
                        _handler.closest('tr').find('input').not(_handler).attr('disabled', 'disabled');
                    }
                }).filter(':checked').trigger('click');
            },
            blacklist: function(dom){
                var $form = $(dom),
                    _handlers = $form.find('input[type="checkbox"]');
                $.each(_handlers, function(){
                    var _this = $(this),
                        _targetElements = $form.find('.' + _this.attr('id') + ' select');
                    _this.click(function(){
                        _targetElements.attr('disabled','disabled');
                        _this.is(':checked') && _targetElements.removeAttr('disabled');
                        //window.console && window.console.debug(_targetElements);
                    }).triggerHandler('click');
                });
            },
            hangup: function(dom){
            },
            prompt: function(dom){
                var $form = $(dom);
                $form.find('div[class^="IsStandard"]').not(
                    '.IsStandard-' + $form.find('input[name="IsStandard"]:checked').val()
                ).hide();
                $form.find('input[name="IsStandard"]').click(function(){
                    var _this = $(this),
                        _target = _this.attr('id');
                    $form.find('div[class^="IsStandard"]').hide().filter('.' + _target).show();
                });
            }
        },
        // Binding the effect resizing onto the DOM '#panel'
        _panelResize = function(ev){
            var _panel = $('#panel'),
                _boards = $('#panel .items'),
                _titles = _boards.children('dt'),
                _items = _boards.children('dd'),
                _tHeight = _titles.height(),
                _iHeight = _items.height();
            if (_panel.width()) {
                var _visibleItems = _items.filter(':visible'),
                    _eachHeight = __stageSize__.height/_visibleItems.length;
                if (_eachHeight > (_tHeight + 100)) {
                    var _actualHeight = _eachHeight - _tHeight * ( 1 + _items.not(_visibleItems).length );
                    _visibleItems.animate({height: _actualHeight}, 100);
                } else {
                    _visibleItems.attr('style') && _visibleItems.removeAttr('style');
                }
                //window.console && window.console.debug(_eachHeight);
            }
            // make sure only bind the below effects once
            !_panel.data('resizable') && _panel.resizable({
                minWidth: 0,
                maxWidth: 500,
                handles: 'w',
                helper: 'ui-widget-overlay',
                start: function(ev, ui){ui.helper.appendTo(_panel);},
                resize: function(ev, ui){
                    ui.helper.css({left: 0, top: 0, width: '110%'});
                    _panel.css({left:0, top: 0, width: ui.size.width});
                },
                stop: function(ev, ui){
                    var _width = ui.size.width < 0 ? 0 : ui.size.width;
                    _panel.removeAttr('style').width(_width);
                    __stageSize__ = _calculateStageSize();
                    //window.console && window.console.debug(ui);
                }
            }) && _panel.find('.ui-resizable-w').append(
                $('<span class="ui-icon ui-icon-grip-solid-vertical" />').click(function(ev){
                    _panel.width() ? _panel.width(0) : _panel.removeAttr('style');
                    __stageSize__ = _calculateStageSize();
                    ev.preventDefault();
                })
            ) && _titles.click(function(ev){
                var _title = $(this),
                    _icon = _title.children('.ui-icon').toggleClass('ui-icon-plus ui-icon-minus');
                _title.next('dd').toggle(200, function(){_panelResize();});
                ev.preventDefault();
            }).children('a').click(function(){
                $._growl(VIEW_DATA[0])._showMask();
                $(ev.target).one('click', function(ev){
                    //TODO: coding the add sub-tree handling
                    $._destroyGrowl()._showMask();
                });
                return false;
            }) && _titles.next('dd').find('.root .ui-icon').click(function(ev){
                $(this).toggleClass('ui-icon-minus ui-icon-plus').closest('.root').siblings().toggle(100);
                ev.preventDefault();
            });
            ev && ev.preventDefault();
        }, 
        // Calculating the stage actual size
        _calculateStageSize = function(){
            var _m = $('#main'),
                _p = $('#panel'),
                _h = $('#header'),
                _f = $('#footer'),
                _width = _m.width() - _p.width(),
                _height = _m.height() - _h.height() - _f.height();
            return {width: _width, height: _height};
        }, 
        // Moving the DOM '#stage' position with the effect animate
        _stageMovable = function(opt){
            var _m = __stageSize__,
                _t = $('#stage'),
                _c = {width: _t.width(), height: _t.height()};
            _t.animate({
                left: (_m.width - _c.width)/2,
                top: opt ? opt : (_m.height - _c.height)/2
            }, 200);
        }, 
        // Binding the live click event onto the DOM '#bottom > a'
        _buttomButtons = function(){
            $('#bottom > a').live('click', function(ev){
                ev.preventDefault();
                var _a = $(this),
                    _offsetHeihgt,
                    _flag;
                _offsetHeihgt = _a.is('.valign') ? 70 : 0;
                _flag = _a.is('.expend') ? 1 : 0;
                if (!_offsetHeihgt) {
                    $(
                        '#stage' + (_flag ? ' .ui-icon-plus' : ' .ui-icon-minus')
                    ).toggleClass(
                        'ui-icon-plus ui-icon-minus'
                    ).closest(
                        '.parent-to-child'
                    ).toggleClass('minus');
                    $(
                        '#stage table'
                    ).not(
                        $('#stage > table')
                    ).filter(
                        _flag ? ':hidden' : ':visible'
                    ).toggle().toggleClass('locked');
                }
                _stageMovable(_offsetHeihgt);
                //window.console && window.console.debug(_flag);
            });
        }, 
        // Binding the resize event onto the DOM 'window'
        _windowResize = function(){
            var _window = $(window);
            !_window.data('resize') && _window.bind('resize', function(ev){
                __stageSize__ = _calculateStageSize();
                _panelResize(ev);
            });
            _window.triggerHandler('resize');
        }, 
        // Binding the live click event onto the DOM '#stage .parent-to-child i a.ui-icon'
        _toggleNodes = function(){
            $('#stage .parent-to-child i a.ui-icon').live('click', function(ev){
                var _a = $(this),
                    _c = _a.closest('.parent-to-child').toggleClass('minus'),
                    _t = _c.siblings('table'),
                    _e = function(){
                        _t.toggleClass('locked');
                        _stageMovable();
                    };
                _a.toggleClass('ui-icon-plus ui-icon-minus');
                _a.is('.ui-icon-plus') && _t.animate({
                    width:'hide', height: 'hide'
                }, 300, _e) || _t.animate({
                    width:'show', height: 'show'
                }, 400, _e);
                ev.preventDefault();
            });
        },
        /**
         * 
         */
        _itemMenu = function() {
            /**
             * output menu
             */
             $('.output_menu_item').live('click', function() {
                 var url = $('#output_zone').attr('action');
                 var $nodeOutput = $(this).closest('.node_output');
                 var isNew = ($nodeOutput.find('.node_output_id').length < 1);
                 var $dialog = $(this).closest('.dialog');
         
                 if ($(this).hasClass('rename')) {
                     var $input = $nodeOutput.find('.node_output_name').clone();
                     var doUpdate = false;
                     $input.attr('type', 'text');
                     $input.removeAttr('class').removeAttr('name');
                     $input.width($nodeOutput.find('i').width());
                     $nodeOutput.find('i').html($input);
                     $input.focus();
                     $input.blur(function() {
                         doUpdate = ($nodeOutput.find('i').html() != $nodeOutput.find('.node_output_name').val());

                         if(doUpdate) {
                             if(isNew) {
                                 $nodeOutput.find('.node_output_name').val($input.val());
                                 $nodeOutput.find('i').html($input.val());
                             } else if($input.val().length) {// update output name
                                 $._growl(VIEW_DATA[0])._showMask($dialog);
                                 var outputId = $nodeOutput.find('.node_output_id').val();
                                 var param = {'OutputId':outputId, 'Label':$input.val()};
                                 $.post(url+'/updateoutput', param, function(response) {
                                     $._destroyGrowl();
                                     if ($(response).hasClass('error')) {
                                         $._growl(response)._showMask($dialog);
                                     } else {
                                         $._growl(response)._showMask($dialog);
                                         $nodeOutput.find('.node_output_name').val($input.val());
                                         $nodeOutput.find('i').html($input.val());
                                     }
                                 });
                             }
                         }
                     });
                     $input.keypress(function(event) {
                         if(event.keyCode==13) {
                             doUpdate = ($nodeOutput.find('i').html() != $nodeOutput.find('.node_output_name').val());

                             if(doUpdate) {
                                 if(isNew) {
                                     $nodeOutput.find('.node_output_name').val($input.val());
                                     $nodeOutput.find('i').html($input.val());
                                 } else if($input.val().length) {// update output name
                                     $._growl(VIEW_DATA[0])._showMask($dialog);
                                     var outputId = $nodeOutput.find('.node_output_id').val();
                                     var param = {'OutputId':outputId, 'Label':$input.val()};
                                     $.post(url+'/updateoutput', param, function(response) {
                                         $._destroyGrowl();
                                         if ($(response).hasClass('error')) {
                                             $._growl(response)._showMask($dialog);
                                         } else {
                                             $._growl(response)._showMask($dialog);
                                             $nodeOutput.find('.node_output_name').val($input.val());
                                             $nodeOutput.find('i').html($input.val());
                                         }
                                     });
                                 }
                             }
                         }
                     });
                 } else if ($(this).hasClass('active')) {
                     if (isNew) {
                         $nodeOutput.find('.node_output_isactive').attr('checked', 'checked');
                     } else {// update output status
                         $._growl(VIEW_DATA[0])._showMask($dialog);
                         var outputId = $nodeOutput.find('.node_output_id').val();
                         var param = {'OutputId':outputId, 'IsActive':1};
                         $.post(url+'/updateoutput', param, function(response) {
                             $._destroyGrowl();
                             if ($(response).hasClass('error')) {
                                 $._growl(response)._showMask($dialog);
                             } else {
                                 $._growl(response)._showMask($dialog);
                                 $nodeOutput.find('.node_output_isactive').attr('checked', 'checked');
                             }
                         });
                     }
                 } else if ($(this).hasClass('deactive')) {
                     if (isNew) {
                         $nodeOutput.find('.node_output_isactive').removeAttr('checked');
                     } else {// update output status
                         $._growl(VIEW_DATA[0])._showMask($dialog);
                         var outputId = $nodeOutput.find('.node_output_id').val();
                         var param = {'OutputId':outputId, 'IsActive':0};
                         $.post(url+'/updateoutput', param, function(response) {
                             $._destroyGrowl();
                             if ($(response).hasClass('error')) {
                                 $._growl(response)._showMask($dialog);
                             } else {
                                 $._growl(response)._showMask($dialog);
                                 $nodeOutput.find('.node_output_isactive').removeAttr('checked');
                             }
                         });
                     }
                 } else if ($(this).hasClass('delete')) {
                     if ($('.node_output').length>1) {
                         var itemId = $nodeOutput.attr('itemId');
                         if (isNew) {
                             $nodeOutput.remove();
                             $('.resource_zone[itemId="' + itemId + '"]').remove();
                             $('.node_output:first > i').trigger('click');
                         } else {// update output status
                             $._growl(VIEW_DATA[0])._showMask($dialog);
                             var outputId = $nodeOutput.find('.node_output_id').val();
                             var param = {'NodeOutputId':outputId, 'act':'remove'};
                             $.post(url+'/cell', param, function(response) {
                                 $._destroyGrowl();
                                 if ($(response).hasClass('error')) {
                                     $._growl(response)._showMask($dialog);
                                 } else {
                                     $._growl(response)._showMask($dialog);
                                     $nodeOutput.remove();
                                     $('.resource_zone[itemId="' + itemId + '"]').remove();
                                     $('.node_output:first > i').trigger('click');
                                 }
                             });
                         }
                     } else {
                         $._growl('<div class="notification">' + $('#output_zone').attr('deleteWarning') + '</div>');
                     }
                 }

                 $('.output_menu').removeClass('on');
             });

             /**
             * toggle output management menu
             */
             $('.output_menu u').live('click', function() {
                 var $outputMenu = $(this).closest('.output_menu');
                 var $output     = $(this).closest('.node_output');
                 if($output.find('.node_output_isactive').attr('checked')) {
                     $output.find('.active').hide();
                     $output.find('.deactive').removeAttr('style');
                 } else {
                     $output.find('.active').removeAttr('style');
                     $output.find('.deactive').hide();
                 }
                 $outputMenu.toggleClass('on');
             });
        };

    // Public API
    $.extend({/* Namespace */ builder: {
        init: function(){
            this.stageSize(_calculateStageSize());
            _stageDraggable();
            _stageMovable();
            _contextmenu();
            _buttomButtons();
            _windowResize();
            _toggleNodes();
            _itemMenu();
        },
        stageSize: function(options){
            if (options) {
                __stageSize__ = options;
            }
            return __stageSize__;
        }
    }});

    // Initializing after DOM ready
    $(function(){$.builder.init();});
})(jQuery);

/* EOF */