/**
 * $Rev$
 * $LastChangedDate$
 * $LastChangedBy$
 *
 * @category   public
 * @package    styles
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Lance LI <yaoli@streamwide.com>
 * @version    $Id$
 */
;(function($){
    $.extend({
    	numbergroup: {
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
                        }
                    }
                });

                // hide date assigned dates popup
                $('body').click(function(event) {
                    var $target = $(event.target);
                    if (
                        ! $target.is('.assigned-dates-calendar') &&
                        ! $target.closest('.assigned-dates-calendar').length &&
                        ! $target.closest('.ui-datepicker-calendar').length &&
                        $('.assigned-dates-calendar.active').length
                    ) {
                        $('.assigned-dates-calendar.active .cancel-calendar').trigger('click');
                    }
                });

                $('#create').click(function() {
                    $._growl(VIEW_DATA[0])._showMask();
                    $.get(LOCAL + 'create', function(response) {
                        $._destroyGrowl();
                        if ($(response).hasClass('error')) {
                            $._growl(response)._showMask();
                        } else {
                            var $dialog = $(response),
                                $nextAll = $dialog.find('#tr-solution').nextAll(':not(:last)'),
                                $solutionIdElement = $dialog.find('#solution-id');
                            $._drawDialog($dialog, [550, 100]);
                            $nextAll.hide();
                            $solutionIdElement.change(function() {
                                if ('-1' != $(this).val()) {
                                    $._growl(VIEW_DATA[0])._showMask($dialog);
                                    $.post(LOCAL + 'create/Act/change-solution',
                                        {'SolutionId' : $(this).val()},
                                        function(response) {
                                            if (! $(response).hasClass('error')) {
                                                var $numbers = $($dialog).find('#numbers ul');
                                                $numbers.children().remove();
                                                $numbers.append($(response).filter('li'));
                                                $.each($($dialog).find('select.routing-tree'), function(i, obj) {
                                                    $(obj).children(':not(:first)').remove();
                                                    $(obj).append($(response).filter('select').children());
                                                });
                                                $nextAll.show();
                                            }
                                            $._destroyGrowl()._growl(response)._showMask($dialog);
                                        }
                                    );
                                } else {
                                    $nextAll.hide();
                                }
                            });
                            $dialog.submit(function() {
                                if ('-1' == $solutionIdElement.val()) {
                                    return false;
                                }
                                $._growl(VIEW_DATA[0])._showMask($dialog);
                                $.each($dialog.find('.row-assigned-dates'), function(i, obj) {
                                    if (
                                        '-1' == $(obj).find('select.routing-tree').val() ||
                                        '' == $.trim($(obj).find('input.start-date').val()) ||
                                        '' == $.trim($(obj).find('input.end-date').val())
                                    ) {
                                        $(obj).find('input, select').attr('disabled', true);
                                    }
                                });
                                var $emergency = $dialog.find('select[name="EmergencyTreeId"]');
                                if ('-1' == $emergency.val()) {
                                    $emergency.add($dialog.find('input#emergency')).attr('disabled', true);

                                }
                                $dialog.find('input.input_default').attr('disabled', true);
                                var $params = $(this).find('form').serialize() + '&';
                                $dialog.find('input:disabled, select:disabled').attr('disabled', false);
                                $.each($dialog.find('#numbers-assigned li'), function(i, obj) {
                                    $params += 'PremiumNumberIds[]=' + $(obj).attr('id').replace(/number-(\d*)/g, '$1') + '&';
                                });

                                var $pagination = $('#number-list').siblings();
                                $params = '&Act=create' +
                                    '&CurrentPage=' + $pagination.find('.current-page').text() +
                                    '&ItemsPerPage=' + $pagination.find('.selected').text();
                                $.post(LOCAL + 'create/Act/create', $params, function(response) {
                                    if (!$(response).hasClass('error')) {
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
                });
                return $self;
            },

            /**
             * event listener
             */
            _liveEvent: function() {
                var $self = this;

                // edit number group
                $('.manager-edit').live('click', function() {
                    var $this = $(this),
                        LOCAL = $this.attr('href');
                    $._growl(VIEW_DATA[0])._showMask();
                    $.get(LOCAL, function(response) {
                        $._destroyGrowl();
                        if ($(response).hasClass('error')) {
                            $._growl(response)._showMask();
                        } else {
                            var $dialog = $(response);
                            $._drawDialog($dialog, [550, 100]);
                            $self._routingPlanChangeEvent($dialog.find('.row-assigned-dates'));
                            $('#emergency-tree').change(function() {
                                var $this = $(this),
                                    $emergencyTreeId = +$this.val();
                                if (-1 != $emergencyTreeId) {
                                    $._growl(VIEW_DATA[0])._showMask($dialog);
                                    $.post(LOCAL + '/Act/update',
                                        {'PremiumNumberGroupId' : $dialog.find('input[name="PremiumNumberGroupId"]').val(),
                                         'EmergencyTreeId' : $emergencyTreeId},
                                        function(response) {
                                            if (! $(response).hasClass('error')) {
                                                $this.closest('.row-item').children().replaceWith($(response).filter('table').find('td'));
                                                $dialog.find('.heading-close').trigger('click');
                                            }
                                            $._growl(response)._showMask($dialog);
                                        }
                                    );
                                }
                            });
                            $dialog.submit(function() {
                                $._growl(VIEW_DATA[0])._showMask($dialog);
                                $.post(LOCAL + '/Act/update',
                                    {'PremiumNumberGroupName' : $dialog.find('input[name="PremiumNumberGroupName"]').val()},
                                    function(response) {
                                        if (! $(response).hasClass('error')) {
                                            $this.closest('.row-item').children().replaceWith($(response).filter('table').find('td'));
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

                // delete number group
                $('.manager-delete').live('click', function() {
                    var $this = $(this),
                        LOCAL = $this.attr('href'),
                        $container = $this.closest('.dialog');
                    if (! $container.length) {
                        $container = undefined;
                    }
                    $._growl(VIEW_DATA[0])._showMask($container);
                    $.get(LOCAL, function(response) {
                        $._destroyGrowl();
                        if ($(response).hasClass('error')) {
                            $._growl(response)._showMask($container);
                        } else {
                            var $dialog = $(response),
                                $pagination = $this.closest('.list-body');
                            $._drawDialog($dialog, [400, 200], $container);
                            $dialog.submit(function() {
                                $._growl(VIEW_DATA[0])._showMask($dialog);
                                $.post(LOCAL + '&Act=delete',
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

                // assign number
                $('.numbers li').live('mousedown', function() {
                    $(this).toggleClass('on');
                    return false;
                });

                // assign number
                $('#ass').live('click', function() {
                    var $this = $(this),
                        $parent = $this.closest('.dialog'),
                        $url = $this.attr('href'),
                        $numberSelected = $parent.find('#numbers li.on');
                    if ($numberSelected.length && 'numbergroup-update-dialog' == $parent.attr('id')) {
                        $._growl(VIEW_DATA[0]);
                        var $params = '';
                        $.each($numberSelected, function(index, obj) {
                            $params += '&PremiumNumberIds[]=' + $(obj).attr('id').replace(/number-(\d*)/g, '$1')
                                    + '&PremiumNumbers[]=' + $(obj).text();
                        });
                        $.post($url, $params, function(response) {
                            $._destroyGrowl();
                            if ($(response).hasClass('error')) {
                                $._growl(response);
                            } else {
                                $._growl(response);
                                $parent.find('#numbers-assigned ul').append($numberSelected.removeClass('on'));

                                // update Number of Contact
                                var $numberContacts = $('#numbers-assigned li').length;
                                $('#my_number_groups .active').find(':last').text($numberContacts);

                                if ($parent.find('#numbers-assigned li').length) {
                                    $this.siblings('#unass').removeClass('unactive');
                                }
                                if (! $parent.find('#numbers li').length) {
                                    $this.addClass('unactive');
                                }
                            }
                        });
                    } else {
                        $parent.find('#numbers-assigned ul').append($numberSelected.removeClass('on'));
                        if ($parent.find('#numbers-assigned li').length) {
                            $this.siblings('#unass').removeClass('unactive');
                        }
                        if (! $parent.find('#numbers li').length) {
                            $this.addClass('unactive');
                        }
                    }
                    return false;
                });

                // unassign number
                $('#unass').live('click', function() {
                    var $this = $(this),
                        $parent = $this.closest('.dialog'),
                        $url = $this.attr('href'),
                        $numberSelected = $parent.find('#numbers-assigned li.on');
                    if ($numberSelected.length && 'numbergroup-update-dialog' == $parent.attr('id')) {
                        $._growl(VIEW_DATA[0]);
                        var $params = '';
                        $.each($numberSelected, function(index, obj) {
                            $params += '&PremiumNumberIds[]=' + $(obj).attr('id').replace(/number-(\d*)/g, '$1')
                                    + '&PremiumNumbers[]=' + $(obj).text();
                        });
                        $.post($url, $params, function(response) {
                            $._destroyGrowl();
                            if ($(response).hasClass('error')) {
                                $._growl(response);
                            } else {
                                $._growl(response);
                                $parent.find('#numbers ul').append($numberSelected.removeClass('on'));

                                // update Number of Contact
                                var $numberContacts = $('#numbers-assigned li').length;
                                $('#my_number_groups .active').find(':last').text($numberContacts);

                                if ($parent.find('#numbers li').length) {
                                    $this.siblings('#ass').removeClass('unactive');
                                }
                                if (! $parent.find('#numbers-assigned li').length) {
                                    $this.addClass('unactive');
                                }
                            }
                        });
                    } else {
                        $parent.find('#numbers ul').append($numberSelected.removeClass('on'));
                        if ($parent.find('#numbers li').length) {
                            $this.siblings('#ass').removeClass('unactive');
                        }
                        if (! $parent.find('#numbers-assigned li').length) {
                            $this.addClass('unactive');
                        }
                    }
                    return false;
                });

                // emergency activated toggle
                $('#emergency-active').live('click', function() {
                    var $this = $(this),
                        $active = $this.children('input[name="EmergencyActivated"]');
                    if ('-1' != $this.next().val()) {
                        if ($this.closest('#numbergroup-update-form').length) {
                            var $dialog = $this.closest('.dialog');
                            $._growl(VIEW_DATA[0])._showMask($dialog);
                            $.post(LOCAL + 'update/Act/update',
                                {'EmergencyActivated' : $active.val(),
                                'PremiumNumberGroupId' : $active.siblings('input[name="PremiumNumberGroupId"]').val()},
                                function(response) {
                                    if (! $(response).hasClass('error')) {
                                        if ('1' == $active.val()) {
                                            $active.val(0);
                                            $this.removeClass('active');
                                        } else {
                                            $active.val(1);
                                            $this.addClass('active');
                                        }
                                    }
                                    $._growl(response)._showMask($dialog);
                                }
                            );
                        } else {
                            if ('1' == $active.val()) {
                                $active.val(0);
                                $this.removeClass('active');
                            } else {
                                $active.val(1);
                                $this.addClass('active');
                            }
                        }
                    }
                });

                // init "assigned dates" datepicker
                $('.assigned-dates').live('click', function() {
                    var $this = $(this),
                        $calendar = $this.next(),
                        $isEditForm = $this.closest('#numbergroup-update-form').length;
                    if (! $calendar.find('.hasDatePicker').length) {
                        $calendar.find('.calendar-start-date, .calendar-end-date').datepicker({
                              dateFormat : 'yy-mm-dd',
                              onSelect   : function(selectedDate) {
                                  if ($(this).hasClass('calendar-start-date')) {
                                        $this.find('.start-date').val(selectedDate + ' ' + $calendar.find('.start-time option:selected').text());
                                  }
                                  if ($(this).hasClass('calendar-end-date')) {
                                        $this.find('.end-date').val(selectedDate + ' ' + $calendar.find('.end-time option:selected').text());
                                  }
                              }
                        });
                    }
                    $calendar.toggleClass('active');
                    if (! $isEditForm) {
//                        $('.assigned-dates-calendar-button').hide();
                    }
                    if ($isEditForm) {
                        var $dateRow = $this.closest('.date-row');
                        $dateRow.data('start-date', $dateRow.find('input.start-date').val());
                        $dateRow.data('end-date', $dateRow.find('input.end-date').val());
                    }
                    return false;
                });

                //
                $('.start-time, .end-time').live('click', function() {
                    return false;
                });

                //
                $('.assigned-dates-calendar-button .cancel-calendar').live('click', function() {
                    var $dateRow = $(this).closest('.date-row');
                    $(this).closest('.assigned-dates-calendar.active').removeClass('active');
                    return false;
                });

                //
                $('.assigned-dates-calendar-button .done').live('click', function() {
                    var $dateRow = $(this).closest('.date-row');
                    $(this).closest('.assigned-dates-calendar.active').removeClass('active');
                    return false;
                });

                // add row event
                $('.row-add').live('click', function() {
                    var $this = $(this),
                        $row = $this.closest('.row-assigned-dates'),
                        $clone = $row.clone().removeAttr('tree');

                    $clone.find('input').val('');
                    $clone.find('.assigned-dates-calendar.active').removeClass('active');
                    $clone.find('.hasDatepicker').removeAttr('id').removeClass('hasDatepicker').children().remove();
                    $clone.find('select option:selected').removeAttr('selected');
                    $row.after($clone);
                    if ($this.closest('#numbergroup-update-form').length) {
                        $self._routingPlanChangeEvent($clone);
                        $clone.children('td:eq(2)').children().replaceWith('<span class="row-create">C</span>');
                    }
                    return false;
                });

                // remove row event
                $('.row-remove').live('click', function() {
                    var $this = $(this),
                        $row = $this.closest('.row-assigned-dates');
                    if ($('.row-remove').length > 1) {
                        var $dialog = $this.closest('.dialog'),
                            $routingPlanId = $row.attr('routingplan');
                        if ($this.closest('#numbergroup-update-form').length && $routingPlanId) {
                            $._growl(VIEW_DATA[0])._showMask($dialog);
                            $.post(LOCAL + 'allocatedtree/Act/delete',
                                {'TreeId' : $routingPlanId},
                                function(response) {
                                    if (! $(response).hasClass('error')) {
                                        $row.remove();
                                    }
                                    $._growl(response)._showMask($dialog);
                                }
                            );
                        } else {
                            $row.remove();
                        }
                    }
                    return false;
                });

                // remove row event
                $('.row-update').live('click', function() {
                    var $this = $(this),
                        $row = $this.closest('.row-assigned-dates'),
                        $dialog = $this.closest('.dialog'),
                        $routingPlanId = $row.attr('routingplan');
                    if ($this.closest('#numbergroup-update-form').length && $routingPlanId) {
                        $._growl(VIEW_DATA[0])._showMask($dialog);
                        $.post(LOCAL + 'allocatedtree/Act/update',
                            {'TreeId' : $row.find('.routing-tree').val(),
                             'RoutingPlanId' : $routingPlanId,
                             'StartDatetime' : $row.find('.start-date').val(),
                             'EndDatetime' : $row.find('.end-date').val()},
                            function(response) {
                                if (! $(response).hasClass('error')) {
                                    $this.hide();
                                }
                                $._growl(response)._showMask($dialog);
                            }
                        );
                    } else {
                        $row.hide();
                    }
                    return false;
                });

                // create row event
                $('.row-create').live('click', function() {
                    var $this = $(this),
                        $row = $this.closest('.row-assigned-dates'),
                        $dialog = $this.closest('.dialog');
                    $._growl(VIEW_DATA[0])._showMask($dialog);
                    $.post(LOCAL + 'allocatedtree/Act/add',
                        {'TreeId' : $row.find('.routing-tree').val(),
                         'PremiumNumberGroupId' : $dialog.find('input[name="PremiumNumberGroupId"]').val(),
                         'StartDatetime' : $row.find('.start-date').val(),
                         'EndDatetime' : $row.find('.end-date').val()},
                        function(response) {
                            if (! $(response).hasClass('error')) {
                                $row.attr('routingplan', $(response).attr('routingplan'));
                            }
                            $._growl(response)._showMask($dialog);
                        }
                    );
                    return false;
                });

            },

            _routingPlanChangeEvent: function($container) {
                $container.find('.routing-tree').change(function() {
                var $this = $(this),
                    $dialog = $('#numbergroup-update-dialog'),
                    $row = $this.closest('.row-assigned-dates'),
                    $routingPlanId = +$this.val(),
                    $startDate = $.trim($row.find('input.start-date').val()),
                    $endDate = $.trim($row.find('input.end-date').val());
                    if ($row.attr('routingplan') && -1 != +$row.attr('routingplan')) {
                        var $rowUpdate = $row.find('.row-update');
                        if (
                            -1 != $routingPlanId &&
                            ! $this.find('option:selected').attr('defaultSelected') &&
                            '' != $startDate && '' != $endDate
                        ) {
                            $rowUpdate.addClass('active');
                        } else {
                            $rowUpdate.removeClass('active');
                        }
                    } else {
                        // TODO
                        var $rowCreate = $row.find('.row-create');
                        if (
                            -1 != $routingPlanId &&
                            '' != $startDate && '' != $endDate
                        ) {
                            $rowCreate.addClass('active');
                        } else {
                            $rowCreate.removeClass('active');
                        }
                    }
                });
            }

        }
    });

    /**
     * Initialization after DOM ready
     */
    $(function() {
        $.numbergroup.init();
    });
})(jQuery);

/* EOF */
