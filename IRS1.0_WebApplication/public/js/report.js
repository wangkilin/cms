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
    	report: {
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
                            $._drawDialog($dialog, [500, 100]);
                            $self._formEvent($dialog);
                            $dialog.submit(function() {
                                $._growl(VIEW_DATA[0])._showMask($dialog);
                                var $pagination = $('#report-list tfoot'),
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

                // tabs switch event
                $('.tabs .tab-title:not(.active)').live('click', function() {
                    var $this = $(this),
                        $tabPanel = $('#report-' + $this.attr('id'));
                    $this.addClass('active').siblings('.tab-title.active').removeClass('active');
                    $tabPanel.addClass('active').siblings('.tab-panel.active').removeClass('active');
                    return false;
                });

                // update report
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
                            $._drawDialog($dialog, [500, 100]);
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

                // delete report
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
                return $self;
            },

            _formEvent: function($dialog) {
                var $self = this;
                $dialog.find('#report-type').change(function() {
                    if ('ORIGIN' == $(this).val()) {
                        $dialog.find('.group-by').show();
                    } else {
                        $dialog.find('.group-by:visible').hide();
                    }
                });
                $dialog.find('#timeframe').change(function() {
                    var $this = $(this),
                        $timeframeId = $this.val(),
                        $datePeriod = $dialog.find('#date-period'),
                        $dateRange = $dialog.find('#date-period-date-range'),
                        $days = $dialog.find('#date-period-value');
                    if ('0' == $timeframeId) {
                        $dateRange.show();
                        $days.hide();
                    } else {
                        $days.show();
                        $dateRange.hide();
                    }
                    if ('-1' == $timeframeId) {
                        $datePeriod.hide();
                    } else {
                        $datePeriod.show();
                    }
                    if ('-1' != $timeframeId && '0' != $timeframeId) {
                        var $options = '';
                        for (var i = 1; i < +$this.find('option:selected').attr('max') + 1; i++) {
                            $options += '<option value="' + i +'">' + i + '</option>';
                        }
                        $dialog.find('#timeframe-value').children().replaceWith($($options));
                        $dialog.find('.date-period-values:visible').hide();
                        if ('5' == $timeframeId) {
                            $dialog.find('#date-period-weeks').show();
                        }
                        if ('6' == $timeframeId) {
                            $dialog.find('#date-period-months').show();
                        }
                        if ('6' != $timeframeId && '5' != $timeframeId) {
                            $dialog.find('#date-period-days').show();
                        }
                    }
                });
                return $self;
            }
        }
    });

    /**
     * Initialization after DOM ready
     */
    $(function() {
        $.report.init();
    });
})(jQuery);

/* EOF */
