/**
 * $Rev: 2659 $
 * $LastChangedDate: 2010-06-23 15:44:52 +0800 (Wed, 23 Jun 2010) $
 * $LastChangedBy: yaoli $
 *
 * @category   public
 * @package    js
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: tree.js 2659 2010-06-23 07:44:52Z yaoli $
 */
;(function($){
    $.extend({
        tree: {
            init: function(){
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

                // create
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
                                var $pagination = $('.list-body tfoot'),
                                    $params = $(this).find('form').serialize()
                                        + '&Act=create'
                                        + '&CurrentPage='
                                        + $pagination.find('.current-page').text()
                                        + '&ItemsPerPage='
                                        + $pagination.find('.selected').text();
                                $.post($uri, $params, function(result){
                                    var _result = $(result);
                                    if (!_result.hasClass('error')) {
                                        $pagination.siblings('tbody').andSelf()
                                            .replaceWith(_result.filter('table').children());
                                        $dialog.find('.heading-close').trigger('click');
                                    }
                                    $._growl(_result.filter('.notification'))._showMask($dialog);
                                });
                                return false;
                            });
                        }
                    });
                    return false;
                });

                // delete
                $('.list-items .manager-delete').live('click', function(){
                    var _handler = $(this),
                        _container = _handler.closest('tr');
                    _container.siblings().find('input[type="checkbox"]').removeAttr('checked');
                    _container.find('input[type="checkbox"]').attr('checked', 'checked');
                    $('.list-header .batch-delete').trigger('click');
                    return false;
                });

                // copy
                $('.list-items .manager-copy').live('click', function(){
                    var _handler = $(this),
                        _pagination = $('.list-body tfoot'),
                        _params = $(this).find('form').serialize()
                            + '&Act=copy'
                            + '&CurrentPage='
                            + _pagination.find('.current-page').text()
                            + '&ItemsPerPage='
                            + _pagination.find('.selected').text();
                    $._growl(VIEW_DATA[0])._showMask();
                    $.post(_handler.attr('href'), _params, function(result){
                        var _result = $(result),
                            _msg = _result.filter('.notification'),
                            _newId = _msg.attr('id');
                        if (!_result.hasClass('error')) {
                            _pagination.siblings('tbody').andSelf()
                                .replaceWith(_result.filter('table').children());
                            var _target = $('.list-items #row-' + _newId).addClass('ui-state-highlight');
                            $(window).one('click', function(){
                                _target.removeClass('ui-state-highlight');
                            });
                        }
                        $._growl(_msg)._showMask();
                    });
                    return false;
                });
            }
        }
    });

    /**
     * Initialization after DOM ready
     */
    $(function() {
        $.tree.init();
    });
})(jQuery);

/* EOF */