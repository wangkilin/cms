/**
 * $Rev: 2626 $
 * $LastChangedDate: 2010-06-21 18:36:45 +0800 (Mon, 21 Jun 2010) $
 * $LastChangedBy: junzhang $
 *
 * @category   public
 * @package    styles
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Kilin WANG <zwang@streamwide.com>
 * @version    $Id: resource.js 2626 2010-06-21 10:36:45Z junzhang $
 */

/**
 * global resource management behaviors
 */
;(function($){
    $.extend({
        resourceCommon: {
            /**
             * init
             *
             * @return Boolean false
             */
            init: function() {
                return this._event()._liveEvent();
            },

            _event: function() {
                var $self = this;
                $self['import']();
                return $self;
            },

            /**
             * event listener
             */
            _liveEvent: function() {
                var $self = this;

                /**
                 * edit menu in list item
                 */
                $('.list_edit').live('click', $.resourceCommon.editAction);

                /**
                 * delete menu in list item
                 */
                $('.list_delete').live('click', $.resourceCommon.deleteAction);

                /**
                 * check/uncheck all
                 */
                $('.list_checkbox_switch').live('click', function() {
                    var bind = $(this).attr('bind');
                    if ($(this).attr('checked')) {
                        $('.list_item input[type="checkbox"][bind="' + bind + '"]').attr('checked', 'checked');
                    } else {
                        $('.list_item input[type="checkbox"][bind="' + bind + '"]').removeAttr('checked');
                    }
                });

                /**
                 * uncheck an item, uncheck checkAll.
                 */
                $('.list_item input[type="checkbox"]').live('click', function() {
                    if (! $(this).attr('checked')) {
                        if ($(this).closest('.list_checkbox_switch').length) {
                            $(this).closest('.list_checkbox_switch').removeAttr('checked');
                        } else {
                            $('#list_checkbox_switch').removeAttr('checked');
                        }
                    }
                });

                // check/uncheck all
                $('.column-1 input[type="checkbox"]').live('click', function() {
                    var $this = $(this),
                        $content = $this.closest('.list-content'),
                        $checkboxSwitch = $content.find('.checkbox-switch'),
                        $items = $content.find('.list-body tbody .column-1 input[type="checkbox"]');
                    if ($this.hasClass('checkbox-switch')) {
                        $items.attr('checked', $this.attr('checked'));
                    } else {
                        if (
                            ! $this.attr('checked')
                            && ! $items.find('input:checked').length
                        ) {
                            $checkboxSwitch.attr('checked', false);
                        } else if ($items.filter(':checked').length == $items.length) {
                            $checkboxSwitch.attr('checked', true);
                        }
                    }
                });

                /**
                 * batch delete
                 */
                $('.batch-delete').live('click', function() {
                    var $this = $(this),
                    $items = $this.closest('.list-content').find('.list-body input[type="checkbox"]:checked'),
                    $container = $this.closest('.dialog');
                    if (! $container.length) {
                        $container = undefined;
                    }
                    if ($items.length) {
                        var url = LOCAL + $this.attr('id'),
                            $params = '';
                        $.each($items.parent().next().find('.manager-delete'), function(i, obj) {
                            $params += $(obj).attr('href').replace(/(.*)\?(.*)/g, '$2') + '&';
                        });
                        $._growl(VIEW_DATA[0])._showMask($container);
                        $.post(url, $params, function(response){
                            $._destroyGrowl();
                            if ($(response).hasClass('error')) {
                                $._growl(response)._showMask($container);
                            } else {
                                var $dialog = $(response);
                                $._drawDialog($dialog, [400, 200], $container);
                                $dialog.submit(function() {
                                    $._growl(VIEW_DATA[0]);
                                    $params = $params + '&Act=delete';
                                    $.post(url, $params, function(response) {
                                        $._growl(response, $(response).hasClass('error') ? true : false);
                                        if (! $(response).hasClass('error')) {
                                            $dialog.find('.heading-close').trigger('click');
                                            $items.closest('.row-item').remove();
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
                 * list refresh
                 */
                $('.list-refresh').live('click', function() {
                    var $this = $(this);
                    $._growl(VIEW_DATA[0])._showMask();
                    $.post($this.attr('href'), function(response){
                        $._destroyGrowl();
                        if ($(response).hasClass('error')) {
                            $._growl(response)._showMask();
                        } else {
                            if (! $(response).hasClass('error')) {
                                $('.list-content').find('.list-body tbody, .list-body tfoot').replaceWith($(response));
                            }
                            $._growl(response)._showMask();
                        }
                    });
                    return false;
                });

                /**
                 * sort list
                 */
                $('#main_content_list_header .list_column').live('click', function() {
                    $self.sortList($(this).attr('class').replace(/list_column\s(.+)/, '$1'));

                    return false;
                });

                /**
                 * sort list
                 */
                $('.list-title td:not(.column-1)').live('click', function() {
                    $self.sorter($(this).closest('.list-content').find('.list-items .row-item'), $(this).attr('class'));

                    return false;
                });

                /**
                 * page link
                 */
                $('.pagination a').live('click', function () {
                    var $this = $(this);
                    $._growl(VIEW_DATA[0])._showMask();
                    $.get($this.attr('href'), function(response){
                        if (! $(response).hasClass('error')) {
                            $this.closest('.list-content').find('.list-body tbody, .list-body tfoot').replaceWith($(response));
                        }
                        $._destroyGrowl()._growl(response)._showMask();
                    });

                    return false;
                });

                /**
                 * search resource
                 */
                $('.search-box form').live('submit', function() {
                    var $this = $(this),
                        $url    = $this.attr('action'),
                        $content = $this.closest('.list-content'),
                        $params  = $this.serialize();
                    if ($content.find('.pagination').children().length) {
                        $params  += '&CurrentPage='
                            + $content.find('.current-page').text()
                            + '&ItemsPerPage='
                            + $content.find('.selected').text();
                    }
                    if (! $this.find('.keyword').hasClass('input_default')) {
                        $._growl(VIEW_DATA[0])._showMask();
                        $.post($url, $params, function(response) {
                            if (! $(response).hasClass('error')) {
                                $this.closest('.list-content').find('.list-body tbody, .list-body tfoot').replaceWith($(response));
                            }
                            $._destroyGrowl()._growl(response)._showMask();
                        });
                    }
                    return false;
                });

                /**
                 * cancel form submit. only ajax is able to send request.
                 */
                $('#resouce_list_form, #search_resource_form').submit(function() {
                    return false;
                });
            },

            /**
             * sort list
             */
            sortList: function (sortClass) {
                var sortList = sortKeyList = new Array(),
                    index = 0;

                $.each($('.list_item .' + sortClass), function() {
                    sortKeyList.push($.trim($(this).text()) + '_' + index);
                    sortList[$.trim($(this).text()) + '_' + index++] = $(this).closest('.list_item');
                });

                sortKeyList = sortKeyList.sort();

                for (index in sortKeyList) {
                    $('#main_content_block_content').append(sortList[sortKeyList[index]]);
                }
            },


            /**
             * sort list
             */
            sorter: function (items, sortClass) {
                var sortList = [],
                    sortKeyList = [],
                    index = 0;

                $.each(items.find('td.' + sortClass), function() {
                    var key = $.trim($(this).attr('title')) + '_';
                    sortKeyList.push(key + index);
                    sortList[key + index++] = $(this).closest('.row-item');
                });
                sortKeyList = sortKeyList.sort();

                for(index in sortKeyList) {
                    var item = $(sortList[sortKeyList[index]]);
                    item.removeClass('leaper');
                    if (index%2) {
                        item.addClass('leaper');
                    }
                    items.parent().append(item);
                }
            },

            /**
             * crud menu action
             */
            crudAction: function($size, act, url, enableSubmit, submitFunc, submitFuncParam) {
                if(typeof $size == 'object' && typeof act == 'string' && typeof url=='string' && url.length) {
                    $._growl(VIEW_DATA[0])._showMask();

                    $.get(url, function(response){
                        $._destroyGrowl();
                        if ($(response).hasClass('error')) {
                            $._growl(response)._showMask();
                        } else {
                            var $dialog = $(response);
                            $._drawDialog($dialog, $size);
                            if(enableSubmit==undefined || enableSubmit==true) {
                                $dialog.submit(function() {
                                    $._growl(VIEW_DATA[0])._showMask($dialog);
                                    var $params = $(this).find('form').serialize() + '&act=' + act;
                                    $.post(url , $params, function(response) {
                                        $._growl(response, $(response).hasClass('error') ? true : false);
                                        if (! $(response).hasClass('error')) {
                                            $dialog.find('.heading-close').trigger('click');
                                            if(typeof submitFunc =='function') {
                                                submitFunc(submitFuncParam);
                                            }
                                        }
                                    });
                                    return false;
                                });
                            }
                        }
                    });
                }

                return false;
            },

            /**
             * create menu action
             */
            createAction: function($item) {
                var url;

                if($item) {
                    url = $item.attr('href');
                } else if($(this).attr('href')) {
                    url = $(this).attr('href');
                }

                return $.resourceCommon.crudAction([400,200], 'create', url);
            },

            /**
             * edit menu action
             */
            editAction: function() {

                return $.resourceCommon.crudAction([400,200], 'edit', $(this).attr('href'));
            },

            /**
             * delete menu action
             */
            deleteAction: function () {
                return $.resourceCommon.crudAction([400,200], 'delete', $(this).attr('href'));
            },

            'import': function() {
                if ($('#import').lenght) {
                    $('#import').click(function() {
                        return false;
                    }).append('<div id="import-flash" class="upload-flash"></div>');
                    var $upload = $('.upload-flash');

                    // check the browser has installed flash pulgin
                    if ($.flash.available) {
                        $upload.uploadify({
                            'uploader'       : '/irs/swf/uploadify.swf'
                          , 'script'         : LOCAL + 'import'
                          , 'scriptData'     : {
                                   'Act'           : 'import'
                                 , 'PHPSESSID'     : $.trim($.grep(window.document.cookie.split(';'), function(n){
                                                          return -1 !== (n||'').indexOf('PHPSESSID=')
                                                      })[0].replace('PHPSESSID=', ''))
                               }
                          , 'queueID'        : 'file-queue'
                          , 'fileDesc'       : '*.csv'
                          , 'fileExt'        : '*.csv'
                          , 'simUploadLimit' : 1
                          , 'height'         : 25
                          , 'width'          : 150
                          , 'auto'           : true
                          , 'multi'          : false
                          , 'sizeLimit'      : 62914560
                          , onProgress       : function (event, ID, fileObj, data) {
                                $._growl(VIEW_DATA[0]);
                          }
                          , onComplete       : function(event, ID, fileObj, response, data) {
                                $._destroyGrowl();
                                $('.list-content').find('.list-body tbody, .list-body tfoot').replaceWith($(response).find('tbody, tfoot'));
                            }
                        });
                    } else {
                    }

                }
                return this;
            },

            /**
             * to be extended
             */
            loadTrigger : {
                leftMenuClick: function(obj) {
                    return true;
                }
            }

        }
    });

    /**
     * Initialization after DOM ready
     */
    $(function() {
        $.resourceCommon.init();
    });
})(jQuery);

/* EOF */