/**
 * $Rev: 2617 $
 * $LastChangedDate: 2010-06-21 16:13:16 +0800 (Mon, 21 Jun 2010) $
 * $LastChangedBy: yaoli $
 *
 * @category   public
 * @package    styles
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Kilin WANG <zwang@streamwide.com>
 * @version    $Id: blacklist.js 2617 2010-06-21 08:13:16Z yaoli $
 */
;(function($){
    $.extend({
    	blacklist: {
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
                            $._drawDialog($dialog, [600, 100]);
                            $dialog.submit(function() {
                                $._growl(VIEW_DATA[0])._showMask($dialog);
                                var $pagination = $('#blacklist-lists tfoot'),
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

                // dynamic checkbok click event
                $('#dynamic-container input').live('click', function() {
                    var $dtmfContainer = $('#dtmf-container');
                    if ($(this).attr('checked')) {
                        $dtmfContainer.removeClass('unactive').find('select').attr('disabled', false);
                    } else {
                        $dtmfContainer.addClass('unactive').find('select').attr('disabled', true);
                    }
                });

                // update blacklist
                $('.manager-edit').live('click', function() {
                    var $this = $(this),
                        $uri = $this.attr('href'),
                        $container = $this.closest('.dialog'),
                        $width = 400;
                    if (! $container.length) {
                        $container = undefined;
                        $width = 600;
                    }
                    $._growl(VIEW_DATA[0])._showMask($container);
                    $.get($uri, function(response) {
                        $._destroyGrowl();
                        if ($(response).hasClass('error')) {
                            $._growl(response)._showMask($container);
                        } else {
                            var $dialog = $(response);
                            $._drawDialog($dialog, [$width, 100], $container);
                            $self._formEvent($dialog);
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

                // delete blacklist
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
                                            var $response = $(response).filter('table').children();
                                            if (! $container.length) {
                                                $this.closest('.list-body').find('tbody, tfoot')
                                                    .replaceWith($response);
                                            } else {
                                                $this.closest('.list-body').children()
                                                    .replaceWith($response);
                                            }
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
                return $self;
            },

            _formEvent: function($dialog) {
                var $blacklistId = $dialog.find('input[name="BlacklistId"]').val();
                $dialog.find('#add-phone-number').click(function() {
                    var $uri = LOCAL + 'addnumber';
                    $._growl(VIEW_DATA[0])._showMask($dialog);
                    $.post($uri,
                        {'BlacklistId' : $blacklistId,
                         'PhoneNumber' : $(this).parent().find('input[name="PhoneNumber"]').val()},
                        function(response) {
                            if (! $(response).hasClass('error')) {
                                $('#blacklist-number-list').find('tbody, tfoot')
                                    .replaceWith($(response).find('tbody, tfoot'));
                            }
                            $._growl(response)._showMask($dialog);
                        }
                    );
                    return false;
                });

            	$dialog.find('.search-box .search').click(function() {
            		var $this = $(this),
            		    $url = LOCAL + 'listnumber',
                        $keyword = $(this).parent().find('.keyword');
                    if (! $keyword.hasClass('input_default')) {
                        $._growl(VIEW_DATA[0])._showMask($dialog);
                        $.post($url,
                            {'BlacklistId' : $blacklistId,
                             'BlacklistNumberPart' : $keyword.val()},
                            function(response) {
                                if (! $(response).hasClass('error')) {
                                            $this.closest('.list-body').find('tbody, tfoot').replaceWith($(response));
                                }
                                $._destroyGrowl()._growl(response)._showMask($dialog);
                            }
                        );
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
        $.blacklist.init();
    });
})(jQuery);

/* EOF */