/**
 * $Rev$
 * $LastChangedDate$
 * $LastChangedBy$
 *
 * @category   public
 * @package    styles
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Kilin WANG <zwang@streamwide.com>
 * @version    $Id$
 */
;(function($){
    $.extend({
    	admin: {
            /**
             * init
             *
             * @return Boolean false
             */
            init: function() {
                return this._event()._liveEvent();
            },

            /**
             * default event
             */
            _event: function() {
                var $self = this;

                // sort table
                $('.list-body > table').addClass('tablesorter').tablesorter({
                    widgets: ['zebra'],
                    widgetZebra: {css: ['','leaper']},
                    headers: {
                        0: {
                            sorter: false
                        },
                        7: {
                            sorter: false
                        }
                    }
                });

                // hide search result popup
                $('body').click(function(event) {
                    $('.search-result.active').length && $('.search-result.active').removeClass('active');
                });

                // create calendar event
                $('#create').click(function() {
                    $._growl(VIEW_DATA[0])._showMask();
                    var $uri = LOCAL + 'create';
                    $.get($uri, function(response) {
                        $._destroyGrowl();
                        if ($(response).hasClass('error')) {
                            $._growl(response)._showMask();
                        } else {
                            var $dialog = $(response);
                            $._drawDialog($dialog, [450, 100]);
                            $dialog.submit(function() {
                                $._growl(VIEW_DATA[0])._showMask($dialog);
                                var $pagination = $('#admin-list tfoot'),
                                    $params = $(this).find('form').serialize() + '&Act=create';
                                if ($pagination.find('.current-page').length) {
                                    $params += '&CurrentPage=' + $pagination.find('.current-page').text() +
                                    '&ItemsPerPage=' + $pagination.find('.selected').text();
                                }
                                $.post($uri, $params, function(response) {
                                    if (! $(response).hasClass('error')) {
                                        $pagination.siblings('tbody').andSelf()
                                            .replaceWith($(response).filter('table').children());
                                        $dialog.find('.heading-close').trigger('click');
                                    }
                                    $._growl(response)._showMask($dialog);
                                });
                                return false;
                            });
                        }
                    });
                    return false;
                });

                return $self;
            },

            /**
             * event listener
             */
            _liveEvent: function() {
                var $self = this;

                // update admin
                $('.manager-edit').live('click', function() {
                    var $this = $(this),
                        $uri = $this.attr('href');
                    $._growl(VIEW_DATA[0])._showMask();
                    $.get($uri, function(response) {
                        $._destroyGrowl();
                        if ($(response).hasClass('error')) {
                            $._growl(response)._showMask();
                        } else {
                            var $dialog = $(response);
                            $._drawDialog($dialog, [450, 100]);
                            $dialog.submit(function() {
                                $._growl(VIEW_DATA[0])._showMask($dialog);
                                var $params = $(this).find('form').serialize() + '&Act=update';
                                $.post($uri, $params, function(response) {
                                    if (! $(response).hasClass('error')) {
                                        $this.closest('.row-item').children().replaceWith($(response).filter('table').find('td'));
                                        $dialog.find('.heading-close').trigger('click');
                                    }
                                    $._growl(response)._showMask($dialog);
                                });
                                return false;
                            });
                        }
                    });
                    return false;
                });

                // delete admin
                $('.manager-delete').live('click', function() {
                    var $this = $(this),
                        $uri = $this.attr('href'),
                        $container = $this.closest('.dialog');
                    if (! $container.length) {
                        $container = undefined;
                    }
                    $._growl(VIEW_DATA[0])._showMask($container);
                    $.get($uri, function(response) {
                        $._destroyGrowl();
                        if ($(response).hasClass('error')) {
                            $._growl(response)._showMask($container);
                        } else {
                            var $dialog = $(response),
                                $pagination = $this.closest('.list-body');
                            $._drawDialog($dialog, [400, 200], $container);
                            $dialog.submit(function() {
                                $._growl(VIEW_DATA[0])._showMask($dialog);
                                $.post($uri + '&Act=delete',
                                    {'CurrentPage' : $pagination.find('.current-page').text(),
                                     'ItemsPerPage' : $pagination.find('.selected').text()},
                                    function(response) {
                                        if (! $(response).hasClass('error')) {
                                            $this.closest('.list-body').find('tbody, tfoot')
                                                .replaceWith($(response).filter('table').children());
                                            $dialog.find('.heading-close').trigger('click');
                                        }
                                        $._growl(response)._showMask($dialog);
                                    }
                                );
                                return false;
                            });
                        }
                    });
                    return false;
                });

                //
                $('.customer-account-search')
                    .live('focus', function(){
                        var $this = $(this);
                        $this.data('prev_value', $this.val());
                    }).live('focus', function(){
                        $(this).autocomplete({
                            source: function(request, response){
                                $.get($.getBaseUrl() + '/customer/list/CustomerAccountNamePart/' + request.term, function(data){
                                    //window.console && window.console.debug(response);
                                    // parse data (html) to JSON
                                    var $userFoundInfoNameColume = $(data).find('.row-item');
                                    _datas = $.map( $userFoundInfoNameColume, function(dom){
                                        var $dom   = $(dom),
                                            $id    = $dom.attr('id').replace(/row-item-(\d+)/, '$1'),
                                            $name  = $dom.find('.column-2').attr('title');
                                            return {id: $id, value: $name};
                                        } 
                                    );
                                    response(_datas);
                                });
                            },
                            select: function(event, ui) {
                                return false;
                            }
                        })
                    });
                            /*
                     * .live('keyup', function() {
                        var $this = $(this),
                            $value = $this.val();
                        if ($value != $this.data('prev_value')) {
                            $.get($.getBaseUrl() + '/customer/list/Act/search/CustomerAccountNamePart/' + $value,
                                function(response) {
                                    if (! $(response).hasClass('error')) {
                                        var $searchResult = $this.siblings('.search-result');
                                        if ($searchResult.length) {
                                            $searchResult.replaceWith($(response));
                                        } else {
                                            $this.after($(response));
                                        }
                                    }
                                }
                            );
                        }
                        $this.data('prev_value', $this.val());
                    });
                    *
                    */
                    ;

                $('.search-result td').live('click', function() {
                    var $this = $(this);
                    $this.closest('.search-result').siblings('input').val($this.text());
                    return false;
                });
                return $self;
            }
        }
    });

    /**
     * Initialization after DOM ready
     */
    $(function() {
        $.admin.init();
    });
})(jQuery);

/* EOF */
