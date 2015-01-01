/**
 * $Rev: 2352 $
 * $LastChangedDate: 2010-05-31 18:21:21 +0800 (Mon, 31 May 2010) $
 * $LastChangedBy: yaoli $
 *
 * @category   public
 * @package    js
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Lance LI <yaoli@streamwide.com>
 * @version    $Id: calendar.js 2352 2010-05-31 10:21:21Z yaoli $
 */
;(function($){

    /**
     * calendar extends jQuery Object
     */
    jQuery.extend({

        /**
         * calendar Object
         *
         * @var Object calendar
         */
        calendarNode: {

            /**
             * init
             *
             * @return Boolean false
             */
            init: function() {
                return this._event();
            },

            /**
             * JQuery default Event
             *
             * Attaching default event
             *
             * @return Object
             */
            _event: function() {
                var $self = this,
                    $uri = LOCAL,
                    $main = $('#main');
                
                //$('body').live('mouseover', function(event) {
                //    $('#calendar-edit-form, #calendar-create-form').mouseover($self._formEvent);
                //});
                $('.multi_one_level_menu u').live('click', function() {
                    if ($(this).parent().is('span')) {
                        $(this).parent().hide();
                        $(this).parent().siblings('div').hide();
                        $(this).parent().parent().parent().removeClass('on').find('u:first').trigger('click');
                    } else if ($(this).siblings('div, span').length<1) {
                        $('.multi_one_level_menu > u').trigger('click');
                        $self.showCalendar($(this).parent());
                        return;
                    } else {
                        var $parent = $(this).parent();                    
                        var $subMenu = $(this).siblings('div, span');
                        
                        $parent.toggleClass('on');
                        var expandFlag = $parent.hasClass('on');
                        if(expandFlag) {
                            $parent.children().hide();
                            $subMenu.removeClass('on').show();
                            $subMenu.find('u, i').show();
                            $subMenu.find('div, span').hide();
                            $parent.siblings().hide();
                        } else {
                            $subMenu.hide();
                            $subMenu.find('u, i').hide();
                            $parent.siblings().show();
                            $subMenu.children().removeClass('on').hide();
                        }
                        $('.multi_one_level_menu > u,.multi_one_level_menu > i').show();
                    }
                });

                /**
                 * add new output
                 */
                $('#add_calendar_output_button').live('click', function() {
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

                    $('#add_calendar_output_button').before($output);
                    $('.node_output').removeClass('on');
                    $output.addClass('on');
            
                    $('#td_resource_zone').append($table);
                    $('.resource_zone').removeClass('on').hide();
                    $table.addClass('on').show();
                    
                    $table.find('.date, .week-calendar').empty();
                    $table.find('.multi_one_level_menu.on > u').trigger('click');
                });

                // hide date range calendar popup, and hide "triangle" context-menu
                $('body').click(function(event) {
                    var $target = $(event.target);
                    if (
                        ! $target.is('.date-range-calendar') &&
                        ! $target.closest('.date-range-calendar').length &&
                        ! $target.closest('.ui-datepicker-calendar').length &&
                        $('.date-range-calendar.active').length
                    ) {
                        $('.date-range-calendar.active .cancel').trigger('click');
                    }

                    $('.triangle.active').length && $('.triangle.active').removeClass('active');
                });

                // hide time slot update popup
                $('body').mousedown(function(event) {
                    var $target = $(event.target);
                    if (
                        ! $target.is('.wc-cal-event') &&
                        ! $target.closest('.wc-cal-event').length &&
                        ! $target.is('#time-slot-update') &&
                        ! $target.closest('#time-slot-update').length &&
                        $('#time-slot-update.active').length
                    ) {
                        $('.wc-cal-event').removeData('selected');
                        $('#time-slot-update.active').removeClass('active');
                    }
                });

                // init "date range" datepicker
                $('.date-range').live('click', function() {
                    var $this = $(this),
                        $isUpdateForm = $this.closest('#calendar-update-form').length,
                        isEdit = ($('.node_output.on').attr('isEdit')=='1');
                    if (! $this.next().is('.date-range-calendar')) {
                        $this.after($(CALENDAR_DATE['dateRangeCalendar']));
                        if (! isEdit) {
                            $('.date-range-calendar-button').hide();
                        }
                        $this.next().addClass('active').find('.calendar-start-date, .calendar-end-date').datepicker({
                              dateFormat : 'yy-mm-dd',
                              onSelect   : function(selectedDate) {
                                  if ($(this).hasClass('calendar-start-date')) {
                                        $this.find('.start-date').val(selectedDate);
                                  }
                                  if ($(this).hasClass('calendar-end-date')) {
                                        $this.find('.end-date').val(selectedDate);
                                  }
                              }
                        });
                    } else {
                        $this.next().toggleClass('active');
                    }
                    if (isEdit) {
                        var $dateRow = $this.closest('.date-row');
                        $dateRow.data('start-date', $dateRow.find('input.start-date').val());
                        $dateRow.data('end-date', $dateRow.find('input.end-date').val());
                    }
                    return false;
                });

                // date range type, period day update
                $('.date-range-calendar-button .done').live('click', function() {
                    var $this = $(this),
                        $dialog = $this.closest('.dialog'),
                        $dateRow = $this.closest('.date-row'),
                        $act = 'update',
                        $params = {'StartDate' : $dateRow.find('input.start-date').val(),
                            'EndDate' : $dateRow.find('input.end-date').val()};
                    if (! $dateRow.attr('id')) {
                        $act = 'add';
                    } else {
                        $params['PeriodDaysId'] = $dateRow.attr('id').replace(/period-day-(\d*)/g, '$1');
                        $params['PeriodId'] = $dateRow.parent().attr('period');
                    }
                    $._growl(VIEW_DATA[0])._showMask($dialog);
                    $.post($uri + 'periodday/Act/' + $act, $params,
                        function(response) {
                            if ($(response).hasClass('error')) {
                                $._growl(response)._showMask($dialog);
                            } else {
                                if ('add' == $act) {
                                    $dateRow.attr('id', 'period-day-' + $(response).attr('period-day'));
                                }
                                $this.closest('.date-range-calendar.active').removeClass('active');
                                $._growl(response)._showMask($dialog);
                            }
                        }
                    );
                    return false;
                });

                // date range type, period day update
                $('.date-range-calendar-button .cancel').live('click', function() {
                    var $dateRow = $(this).closest('.date-row'),
                        isEdit = ($('.node_output.on').attr('isEdit')=='1');
                    if (isEdit) {
                        $dateRow.find('input.start-date').val($dateRow.data('start-date'));
                        $dateRow.find('input.end-date').val($dateRow.data('end-date'));
                        $dateRow.removeData('start-date').removeData('end-date');
                    }
                    $(this).closest('.date-range-calendar.active').removeClass('active');
                    return false;
                });

                // context menu click event
                $('.triangle').live('click', function() {
                    var $this = $(this);
                    $('.triangle.active').not($this).toggleClass('active');
                    $this.toggleClass('active');
                    return false;
                });

                // week view sun calendar click event
                $('.wv-calendar-row').live('click', function() {
                    var $this = $(this);
                    $this.addClass('active');
                    $this.siblings('.wv-calendar-row.active').removeClass('active');
                    return false;
                });

                // week view sun calendar delete event
                $('.delete-wv-calendar').live('click', function() {
                    var $this = $(this),
                        $parent = $this.closest('.wv-calendar-row'),
                        isEdit = ($('.node_output.on').attr('isEdit')=='1');

                    if (isEdit) {
                        var $dialog = $this.closest('.dialog');
                        $._growl(VIEW_DATA[0])._showMask($dialog);
                        $.post($uri + 'period/Act/delete',
                            {'PeriodId' : $parent.attr('period')},
                            function(response) {
                                if ($(response).hasClass('error')) {
                                    $._growl(response)._showMask($dialog);
                                } else {
                                    $('.' + $parent.attr('id')).remove();
                                    $parent.remove();
                                    $._growl(response)._showMask($dialog);
                                }
                            }
                        );
                    } else {
                        $.each($('.' + $parent.attr('id')), function(index, obj) {
                            var $obj = $(obj);
                            $('input.' + $obj.attr('id')).remove();
                            $obj.remove();
                        });
                        $parent.remove();
                    }
                    return false;
                });

                // week view sun calendar rename event
                $('.rename-wv-calendar').live('click', function() {
                    var $this = $(this),
                        $parent = $this.closest('.wv-calendar-row').addClass('rename'),
                        $period = $parent.children('input'),
                        $periodName = $period.val(),
                        isEdit = ($('.node_output.on').attr('isEdit')=='1');
                    $period.select();
                    $period.one('blur', function() {
                        var $value = $(this).val();
                        if ($periodName != $value) {
                            if (isEdit) {
                                var $dialog = $this.closest('.dialog');
                                $._growl(VIEW_DATA[0])._showMask($dialog);
                                $.post($uri + 'period/Act/update',
                                    {'PeriodId' : $parent.attr('period'), 'PeriodLabel' : $value},
                                    function(response) {
                                        if (! $(response).hasClass('error')) {
                                            $period.siblings('span').text($value);
                                        }
                                        $._growl(response)._showMask($dialog);
                                    }
                                );
                            } else {
                                $period.siblings('span').text($value);
                            }
                        }
                        $parent.removeClass('rename');
                    });
                    return false;
                });

                // add row event
                $('.row-add').live('click', function() {
                    var $this = $(this),
                        $dateRow = $this.closest('.date-row'),
                        $clone = $dateRow.clone().removeAttr('id'),
                        $calendarType = +$(this).closest('.resource_zone').find('.multi_one_level_menu').find('.selected').parent().attr('calendarType'),
                        isEdit = ($('.node_output.on').attr('isEdit')=='1');
                    
                    var itemId = +$('.node_output.on').attr('itemId');
                    $.each($clone.find('input'), function() {
                        $(this).attr('name', $(this).attr('name').replace(/params[\d*]/g, 'params[' + itemId + ']'));
                    });
                    
                    if (1 == $calendarType) {
                        var $dialog = $this.closest('.dialog');
                        var $onSelect = function(selectedDate, inst) {
                            var $input = inst.input;
                            if (isEdit) {
                                var $act = 'add',
                                    $params = {'StartDate' : selectedDate, 'EndDate' : selectedDate},
                                    $dateRowId = $input.closest('.date-row').attr('id');
                                if ($dateRowId) {
                                    $act = 'update';
                                    $params['PeriodDaysId'] = $dateRowId.replace(/period-day-(\d*)/g, '$1');
                                }
                                $params['PeriodId'] = $input.closest('#date').attr('period');
                                $._growl(VIEW_DATA[0])._showMask($dialog);
                                $.post($uri + 'periodday/Act/' + $act, $params,
                                    function(response) {
                                        if ($(response).hasClass('error')) {
                                            $._growl(response)._showMask($dialog);
                                        } else {
                                            if (! $dateRowId) {
                                                $dateRow.attr('id', 'period-day-' + $(response).attr('period-day'));
                                            }
                                            $._growl(response)._showMask($dialog);
                                        }
                                    }
                                );
                            }
                        }
                        $clone.children('input').val('').removeAttr('id').removeClass('hasDatepicker').datepicker({
                            dateFormat : 'yy-mm-dd',
                            showAnim   : 'blind',
                            onSelect   : $onSelect
                        });
                    }
                    if (2 == $calendarType) {
                        $clone.find('input').val('');
                        $clone.children('.date-range-calendar').remove();
                    }
                    $dateRow.after($clone);
                    return false;
                });

                // remove row event
                $('.row-remove').live('click', function() {
                    var $this = $(this),
                        $dateRow = $this.closest('.date-row'),
                        isEdit = ($('.node_output.on').attr('isEdit')=='1');
                    if ($('.row-remove').length > 1) {
                        var $dialog = $this.closest('.dialog');
                        if (isEdit && $dateRow.attr('id')) {
                            $._growl(VIEW_DATA[0])._showMask($dialog);
                            $.post($uri + 'periodday/Act/delete',
                                {'PeriodDaysId' : $dateRow.attr('id').replace(/period-day-(\d*)/g, '$1')},
                                function(response) {
                                    if ($(response).hasClass('error')) {
                                        $._growl(response)._showMask($dialog);
                                    } else {
                                        $dateRow.remove();
                                        $._growl(response)._showMask($dialog);
                                    }
                                }
                            );
                        } else {
                            $dateRow.remove();
                        }
                    }
                    return false;
                });

                return $self;
            },

            // caledar type change event
            showCalendar: function($obj) {
                var $self = $.calendarNode,
                    $output = $('.node_output.on'),
                    itemId  = $output.attr('itemId'),
                    $resourceZone = $('.resource_zone[itemId="' + itemId + '"]'),
                    $uri = LOCAL,
                    $dateContainer = $resourceZone.find('.date'),
                    $calendarTypeElement = $resourceZone.find('.calendar-type'),
                    $dialog = $calendarTypeElement.closest('.dialog'),
                    $calendarType = +$obj.parent().attr('calendarType'),
                    $isEditForm = $calendarTypeElement.closest('.calendar-edit-form').length,
                    eventData = {events : []},
                    $date = new Date(),
                    isEdit = ($('.node_output.on').attr('isEdit')=='1');
                

                // check if update calendar
                if (isEdit) {
                    var arr = new Array();
                    $.each(PERIODS, function(index, period) {
                        $.each(period['Frequencies'], function(i, frequenciy) {
                            var year = $date.getFullYear(),
                                month = $date.getMonth(),
                                day = $date.getDate(),
                                week = $date.getDay(),
                                startSecond = +frequenciy.StartSecond,
                                endSecond = +frequenciy.EndSecond,
                                startHour = Math.floor(startSecond / 3600),
                                startMinute = ((startSecond / 3600) - startHour) * 60,
                                endHour = Math.floor(endSecond / 3600),
                                endMinute = ((endSecond / 3600) - endHour) * 60;
                            arr.push({
                                "id"    : +frequenciy.PeriodFrequencyId * 100,
                                "start" :
                                    new Date(
                                        year, month,
                                        (startHour >= 24 ? day + Math.floor(startHour/24) - week + 1 : day - week + 1),
                                        (startHour >= 24 ? startHour % 24 : startHour), startMinute
                                    ),
                                "end"   :
                                    new Date(
                                        year, month,
                                        (endHour >= 24 ?
                                                day + (endHour < startHour
                                                            ? Math.floor(endHour/24) -1 - (endHour % 24 == 0 ? 1 : 0)
                                                            : Math.floor(endHour/24)) - week + 1 - (endHour % 24 == 0 ? 1 : 0)
                                                : day - week + 1),
                                        (endHour >= 24 ? (endHour % 24 == 0 ? 23 : endHour % 24) : endHour),
                                        (endHour % 24 == 0 ? 59 : endMinute)
                                    ),
                                "title" : '',
                                "frequencyId" : frequenciy.PeriodFrequencyId,
                                "periodId" : period.PeriodId,
                                "index" : index + 1
                            });
                        });
                        eventData = {
                            events : arr
                        };
                    });
                }
                
                var $desc = '<span class="desc">' + CALENDAR_DATE['calendarType'][$calendarType - 1] + '</span><br/>',
                    $daysToShow = 7,
                    $id = 10;
                // check if this option is selected
                if (! $obj.hasClass('selected')) {
                    // update each option 'selected' state
                    $obj.closest('.multi_one_level_menu').find('.selected').removeClass('selected');
                    $obj.addClass('selected');
                    
                    var $calendar = $resourceZone.find('.week-calendar');
                    if ($calendarType > 0) {
                        $dateContainer.children().remove();
                        $dateContainer.append($desc);
                        if (1 == $calendarType) {
                            $daysToShow = 1;
                        }
                        if (eventData && eventData['events'] && eventData['events'][0] && eventData['events'][0]['start']) {
                            $date = eventData['events'][0]['start'];
                        }
                        // init week calendar
                        $calendar.children().remove();
                        $calendar.weekCalendar({
                            date: $date,
                            timeslotsPerHour : 4,
                            allowCalEventOverlap : false,
                            overlapEventsSeparate: false,
                            firstDayOfWeek : 1,
                            businessHours :{start: 8, end: 18, limitDisplay: false },
                            daysToShow : $daysToShow,
                            timeSeparator : ' - ',
                            timeFormat : 'H:i',
                            dateFormat : '',
                            useShortDayNames: true,
                            use24Hour : true,
                            timeslotHeight: 10,
                            height : function($calendar) {
                                return 300;
                            },
                            draggable : function(calEvent, element) {
                            return false;
                            },
                            resizable : function(calEvent, element) {
                            return false;
                            },
                            eventNew : function(calEvent, element) {
                                if (3 == $calendarType && ! $('.wv-calendar-row.active').length) {
                                } else {
                                    if (isEdit) {
                                        $calendar.data('eventNew', 1);
                                    }
                                    calEvent.id = $id;
                                    $id++;
                                    $calendar.weekCalendar("removeUnsavedEvents");
                                    $calendar.weekCalendar("updateEvent", calEvent);
                                }
                            },
                            eventClick : function(calEvent, element) {
                                $calendar.find('.wc-cal-event').not(element).removeData('selected');

                                // check if the element is on selected
                                if (element.data('selected') && $('#time-slot-update').length) {
                                    return;
                                }

                                var $template = $self._setupStartAndEndTimeFields(calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start)),
                                    $offset = element.offset(),
                                    $top = $offset.top + 10 + 'px',
                                    $left = $offset.left - 180 + 'px';
                                    $template.find('select.start').trigger('change');
                                $template.addClass('active');
                                if (! $('#time-slot-update').length) {
                                    $('body').append($template.css({
                                        'top' : $top,
                                        'left': $left
                                    }));
                                } else {
                                    $('#time-slot-update').replaceWith($template);
                                    var $template = $('#time-slot-update');
                                    $template.css({
                                        'top' : $top,
                                        'left': $left
                                    });
                                }

                                element.data('selected', 1);
                                $template.find('button.cancel').click(function() {
                                    $calendar.removeData('updateTimeSlot');
                                    element.removeData('selected');
                                    $template.removeClass('active');
                                });

                                $template.find('button.done').click(function() {
                                    if (element.filter('[class*="wv-calendar-"]').length) {
                                        $calendar.data('weekViewTimeSlotClassName', element.attr('class'));
                                    }
                                    calEvent.start = new Date($template.find('select.start').val());
                                    calEvent.end = new Date($template.find('select.end').val());
                                    $calendar.weekCalendar("updateEvent", calEvent);
                                    element.removeData('selected');
                                    $template.removeClass('active');
                                    if (isEdit) {
                                        var itemId=+$('.node_output.on').attr('itemId');
                                        var $startSecond = $('input.' + element.attr('id') + '[name^="params['+itemId+'][StartSecond"]').val(),
                                            $endSecond = $('input.' + element.attr('id') + '[name^="params['+itemId+'][EndSecond"]').val();
                                        $._growl(VIEW_DATA[0])._showMask($dialog);
                                        $.post($uri + 'frequency/Act/update',
                                            {'PeriodFrequencyId' : calEvent.frequencyId, 'StartSecond' : $startSecond, 'EndSecond' : $endSecond},
                                            function(response) {
                                                $._destroyGrowl();
                                                if ($(response).hasClass('error')) {
                                                    $._growl(response)._showMask($dialog);
                                                } else {
                                                    $._growl(response)._showMask($dialog);
                                                }
                                            }
                                        );
                                    }
                                });

                                $template.find('button.delete').click(function() {
                                    $calendar.weekCalendar('removeEvent', calEvent.id);
                                    $template.removeClass('active');
                                    if (isEdit) {
                                        $._growl(VIEW_DATA[0])._showMask($dialog);
                                        $.post($uri + 'frequency/Act/delete',
                                            {'PeriodFrequencyId' : calEvent.frequencyId},
                                            function(response) {
                                                if (! $(response).hasClass('error')) {
                                                    $('input.' + element.attr('id')).remove();
                                                }
                                                $._growl(response)._showMask($dialog);
                                            }
                                        );
                                    } else {
                                        $('input.' + element.attr('id')).remove();
                                    }
                                });
                            },
                            eventRender : function(calEvent, element) {
                                return element;
                            },
                            eventAfterRender : function(calEvent, element) {
                                // for week view calender
                                var $activeCalendar = $('.wv-calendar-row.active');
                                if (3 == $calendarType && ! $activeCalendar.length && $calendar.find('.wc-cal-event').length
                                    && ! isEdit || calEvent.start.getTime() == calEvent.end.getTime()) {
                                    $calendar.weekCalendar("removeUnsavedEvents");
                                    return false;
                                }

                                if ($calendar.data('weekViewTimeSlotClassName')) {
                                    element.attr('class', $calendar.data('weekViewTimeSlotClassName'));
                                    $calendar.removeData('weekViewTimeSlotClassName');
                                } else if ($activeCalendar.length) {
                                    element.addClass($activeCalendar.attr('id'));

                                    // time slot title , like 'Calendar 1'
                                    //element.children('.wc-title').text($activeCalendar.children('input').val());
                                }

                                if (calEvent.id) {
                                    $self._setTimeSlotValue($calendar, $dateContainer, $calendarType, isEdit, calEvent, element);
                                    // check if update calendar
                                    if (isEdit) {
                                        // check if create new frequency
                                        if ($calendar.data('eventNew')) {
                                            var $startSecond = $('input.' + element.attr('id') + '[name^="StartSecond"]').val(),
                                                $endSecond = $('input.' + element.attr('id') + '[name^="EndSecond"]').val(),
                                                $periodId = $dateContainer.attr('period');
                                            if (3 == $calendarType) {
                                                $periodId = $('.wv-calendar-row.active').attr('period');
                                            }
                                            $._growl(VIEW_DATA[0])._showMask($dialog);
                                            $.post($uri + 'frequency/Act/add',
                                                {'PeriodId' : $periodId, 'StartSecond' : $startSecond, 'EndSecond' : $endSecond},
                                                function(response) {
                                                    $._destroyGrowl();
                                                    if ($(response).hasClass('error')) {
                                                        $._growl(response)._showMask($dialog);
                                                    } else {
                                                        calEvent.frequencyId = +$(response).attr('frequency');
                                                        $._growl(response)._showMask($dialog);
                                                    }
                                                }
                                            );
                                            $calendar.removeData('eventNew');
                                        }

                                        // check if is week view calendar
                                        if (3 == $calendarType) {
                                            element.addClass('wv-calendar-' + calEvent.index);
                                        }
                                    }
                                }
                                return element;
                            },
                            eventDrag : function(calEvent, element) {
                            },
                            eventDrop : function(calEvent, element) {
                            },
                            eventResize : function(calEvent, element) {
                            },
                            eventMouseover : function(calEvent, $event) {
                            },
                            eventMouseout : function(calEvent, $event) {
                            },
                            calendarBeforeLoad : function(calendar) {
                            },
                            calendarAfterLoad : function(calendar) {
                            },
                            noEvents : function() {
                            },
                            data : function(start, end, callback) {
                               callback(eventData);
                            },
                            shortMonths : CALENDAR_DATE['shortMonths'],
                            shortDays : CALENDAR_DATE['shortDays']
                        }).find('.wc-today').removeClass('wc-today');
                    } else {
                        $calendar.children().remove();
                        $dateContainer.children().remove();
                    }
                    switch ($calendarType)
                    {
                        case 1:
                            var $dateItems = $(CALENDAR_DATE['specificDateTemplate']).children();
                            var itemId = +$('.node_output.on').attr('itemId');
                            $.each($dateItems.find('input'), function() {
                                $(this).attr('name', $(this).attr('name').replace(/params\[\d*\]/g, 'params[' + itemId + ']'));
                            });
                            
                            $dateContainer.append($dateItems);
                            $dateContainer.find('.date-row .row-add').trigger('click');
                            $dateContainer.find('.date-row:first').remove();
                            break;
                        case 2:
                            var $dateItems = $(CALENDAR_DATE['dateRangeTemplate']).children();
                            var itemId = +$('.node_output.on').attr('itemId');
                            $.each($dateItems.find('input'), function() {
                                $(this).attr('name', $(this).attr('name').replace(/params\[\d*\]/g, 'params[' + itemId + ']'));
                            });
                            
                            $dateContainer.append($dateItems);
                            break;
                        case 3:
                            $dateContainer.append($(CALENDAR_DATE['weekViewTemplate']).children());

                            // create sub-calendar in week view calendar
                            var $row = 1;
                            $('#create-wv-calendar').click(function() {
                                var $this = $(this),
                                    $calendarRow = $(CALENDAR_DATE['weekViewRowTemplate']),
                                    $calendarName = $calendarRow.find('span').text()  + ' ' + $row;
                                if (isEdit && ! $dateContainer.data('initPeriod')) {
                                    $._growl(VIEW_DATA[0])._showMask($dialog);
                                    $.post($uri + 'period/Act/add',
                                        {'CalendarId' : PERIODS[0]['CalendarId'], 'PeriodLabel' : $calendarName},
                                        function(response) {
                                            if ($(response).hasClass('error')) {
                                                $._growl(response)._showMask($dialog);
                                            } else {
                                                $calendarRow.find('span').text($calendarName);
                                                $calendarRow.append('<input type="text" name="PeriodLabel['
                                                    + $row + ']" value="' + $calendarName + '"/>');
                                                $calendarRow.attr('id',
                                                    'wv-calendar-' + $row).attr('period', $(response).attr('period'));
                                                $row++;
                                                $this.closest('#calendar-week-view').append($calendarRow);
                                                if (1 == $('.wv-calendar-row').length) {
                                                    $('.wv-calendar-row').addClass('active');
                                                }
                                                $this.closest('.triangle').removeClass('active');
                                                $._growl(response)._showMask($dialog);
                                            }
                                        }
                                    );
                                } else {
                                    $calendarRow.find('span').text($calendarName);
                                    $calendarRow.append('<input type="text" name="PeriodLabel['
                                        + $row + ']" value="' + $calendarName + '"/>');
                                    $calendarRow.attr('id', 'wv-calendar-' + $row);
                                    $row++;
                                    $this.closest('#calendar-week-view').append($calendarRow);
                                    if (1 == $('.wv-calendar-row').length) {
                                        $('.wv-calendar-row').addClass('active');
                                    }
                                    $this.closest('.triangle').removeClass('active');
                                    $dateContainer.removeData('initPeriod');
                                }
                                return false;
                            });
                            break;
                        default :
                            $key = '';
                            break;
                    }
                }

                return false;
            },
            
            _changeOutputFocus: function() {
                var $self = this;              
                /**
                * change output focus
                */
                $('.node_output > i').die('click').live('click', function() {
                    var $output = $(this).parent();
                    var itemId = $output.attr('itemId');
                    var resourceId = $output.attr('calendarId');
                    var url = $('#output_zone').attr('action') + '/edit/type/calendar/resourceId/' + resourceId;
                    var $dialog = $(this).closest('.dialog');
                    if (!$output.hasClass('on')) {
                        $output.siblings().removeClass('on');
                        $output.addClass('on');
                        /* related origin resource has not loaded, Ajax request */
                        if ($('.resource_zone[itemId="' + itemId + '"]').length<1 && ''!=resourceId) {
                            $.get(url, function(response){
                                $._destroyGrowl();
                                if ($(response).hasClass('error')) {
                                    //$._growl(response)._showMask($dialog);
                                } else {
                                    //$._growl(response)._showMask($dialog);
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
                                    
                                    eval($(response).filter('script').text().substr(4));
                                    $self.showCalendar($output)
                                    $self._formEvent();
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
            },

            _formEvent: function() {
                
                var $self = this,
                $output = $('.node_output.on'),
                itemId  = $output.attr('itemId'),
                $resourceZone = $('.resource_zone[itemId="' + itemId + '"]'),
                $uri = LOCAL,
                $dateContainer = $resourceZone.find('.date'),
                $calendarTypeElement = $resourceZone.find('.calendar-type'),
                $dialog = $calendarTypeElement.closest('.dialog'),
                $calendarType = +$output.attr('calendarType'),
                isEdit = ($('.node_output.on').attr('isEdit')=='1');
                //eventData = {events : []},
                $date = new Date();

                // check if update calendar
                if (isEdit) {
                    var $menuRoot = $resourceZone.find('.multi_one_level_menu').removeClass('on');
                    $menuRoot.find('u:first').trigger('click');
                    $menuRoot = $menuRoot.find('div[calendarType="' + $calendarType + '"]');
                    $menuRoot.find('u:first').trigger('click');
                    $menuRoot = $menuRoot.find('div[resourceType="1"]');
                    $menuRoot.find('u:first').trigger('click');

                    $.each(PERIODS, function(index, period) {
                        if (3 > $calendarType) {
                            $dateContainer.attr('period', period['PeriodId']);
                        } else {
                            $dateContainer.data('initPeriod', 1);
                            $resourceZone.find('.date #create-wv-calendar').trigger('click');
                            var $wvCalendar = $resourceZone.find('.date .wv-calendar-row:last');
                            $wvCalendar.attr('period', period['PeriodId']);
                            $wvCalendar.children('span').text(period['Label']);
                            $wvCalendar.children('input').val(period['Label']);
                        }
                        $.each(period['PeriodDays'], function(i, periodDay) {
                            if (1 == $calendarType) {
                                $resourceZone.find('.date input.hasDatepicker:last').val(periodDay['StartDate'].substr(0, 10));
                            }

                            if (2 == $calendarType) {
                                $resourceZone.find('.date input.start-date:last').val(periodDay['StartDate'].substr(0, 10));
                                $resourceZone.find('.date input.end-date:last').val(periodDay['EndDate'].substr(0, 10));
                            }

                            if (3 > $calendarType) {
                                $resourceZone.find('.date .date-row:last').attr('id', 'period-day-' + periodDay['PeriodDaysId']);
                                if (period['PeriodDays'][i + 1]) {
                                    $resourceZone.find('.date .row-add:last').trigger('click');
                                }
                            }
                        });
                    });
                }
                return $self;
            },

            _setupStartAndEndTimeFields: function(calEvent, timeslotTimes) {
                var $timeSlotUpdate = $(CALENDAR_DATE['timeSlotUpdateTemplate']);
                for (var i = 0; i < timeslotTimes.length; i++) {
                    var startTime = timeslotTimes[i].start;
                    var endTime = timeslotTimes[i].end;
                    var startSelected = "";
                    if (startTime.getTime() === calEvent.start.getTime()) {
                        startSelected = "selected=\"selected\"";
                    }
                    var endSelected = "";
                    if (endTime.getTime() === calEvent.end.getTime()) {
                        endSelected = "selected=\"selected\"";
                    }
                    $timeSlotUpdate.find('select.start').append(
                        "<option value=\"" + startTime + "\" " + startSelected
                        + ">" + timeslotTimes[i].startFormatted + "</option>"
                    );
                    $timeSlotUpdate.find('select.end').append(
                        "<option value=\"" + endTime + "\" " + endSelected
                        + ">" + timeslotTimes[i].endFormatted + "</option>"
                    );
                }

                var $endTimeField = $timeSlotUpdate.find('select.end');
                var $endTimeOptions = $endTimeField.find("option");

                //reduces the end time options to be only after the start time options.
                $timeSlotUpdate.find('select.start').change(function() {
                    var startTime = $(this).find(":selected").val();
                    var currentEndTime = $endTimeField.find("option:selected").val();
                    $endTimeField.html(
                        $endTimeOptions.filter(function() {
                            return startTime < $(this).val();
                        })
                    );

                    var endTimeSelected = false;
                    $endTimeField.find("option").each(function() {
                        if ($(this).val() === currentEndTime) {
                            $(this).attr("selected", "selected");
                            endTimeSelected = true;
                            return false;
                        }
                    });

                    if (!endTimeSelected) {
                        //automatically select an end date 2 slots away.
                        $endTimeField.find("option:eq(1)").attr("selected", "selected");
                    }

                });
                return $timeSlotUpdate;
            },
            _setTimeSlotValue: function($calendar, $dateContainer, $calendarType, isEdit, calEvent, element) {
                var itemId = +$('.node_output.on').attr('itemId');
                var MINUTE = 60,
                    HOUR = MINUTE * 60,
                    DAY = HOUR * 24,
                    WEEK = DAY * 7,
                    TIME = calEvent.start.getTime(),
                    index = '',
                    startSecond =
                        ((element.closest('td').attr('class').replace(/wc-day-column day-(\d*)/g,'$1') - 1) * DAY)
                        + (calEvent.start.getHours() * HOUR)
                        + (calEvent.start.getMinutes() * MINUTE),
                    endSecond =
                        ((element.closest('td').attr('class').replace(/wc-day-column day-(\d*)/g,'$1') - 1) * DAY)
                        + ((calEvent.end.getHours() < calEvent.start.getHours() ? 24 : calEvent.end.getHours()) * HOUR)
                        + (calEvent.end.getMinutes() * MINUTE);
                element.attr('id', TIME);
                $('.' + TIME).length && $('.' + TIME).remove();
                if (3 == $calendarType) {
                    if (isEdit) {
                        index = '[' + element.attr('class').replace(/(.*)wv-calendar-(\d*)/g, '$2') + ']';
                    } else {
                        index = '[' + $('.wv-calendar-row.active').attr('id').replace(/wv-calendar-(\d*)/g, '$1') + ']';
                    }
                }

                $dateContainer.append(
                    '<input type="hidden" class="' + TIME + '" name="params[' + itemId + '][StartSecond]' + index + '['
                        + (! $('input:hidden[name^="params[' + itemId + '][StartSecond"]').length ? 0
                            : +($('input:hidden:last[name^="params[' + itemId + '][StartSecond"]').attr('name').replace(/(.*)\[(\d*)\]\[StartSecond\]\[(\d*)\]/g, '$3')) + 1)
                        + ']" value="' + startSecond + '">',
                    '<input type="hidden" class="' + TIME + '" name="params[' + itemId + '][EndSecond]' + index + '['
                        + (! $('input:hidden[name^="params[' + itemId + '][EndSecond"]').length ? 0
                            : +($('input:hidden:last[name^="params[' + itemId + '][EndSecond"]').attr('name').replace(/(.*)\[(\d*)\]\[EndSecond\]\[(\d*)\]/g, '$3')) + 1)
                        + ']" value="' + endSecond + '">'
                );
            }
        }
    });
    
})(jQuery);

/* EOF */