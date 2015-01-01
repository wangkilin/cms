/**
 * $Rev: 2641 $
 * $LastChangedDate: 2010-06-22 16:46:33 +0800 (Tue, 22 Jun 2010) $
 * $LastChangedBy: junzhang $
 *
 * @category   public
 * @package    js
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 *             Lance LI <yaoli@streamwide.com>
 * @version    $Id: common.js 2641 2010-06-22 08:46:33Z junzhang $
 */

/**
 * Global javascript functions for web application
 */
;(function($) {
    /**
     * Basic Function extends
     */
    jQuery.extend({
        /**
         * Eval JSON String to Object
         *
         * @param String $jsonStr
         *
         * @return mixed|Object
         */
        evalJSON: function($jsonStr){
            // indead, jQuery 1.4.2 has function 'parseJson()'
            // work with this function
            return window['eval']('(' + $jsonStr + ')');
        },

        /**
         * get Base Url
         *
         * @param String $url
         *
         * @return String
         */
        getBaseUrl: function(){
            return ($._baseUrl || '');
        },

        /**
         * Set Base Url
         *
         * @param String $url
         *
         * @return jQuery Object
         */
        setBaseUrl: function($url){
            $._baseUrl = $url;
            return $;
        },

        /**
         * AJAX load a Plugin
         *
         * @param String $plugName
         *
         * @return jQuery Object
         */
        getPlugin: function($plugName){
            $.getScript(this.getBaseUrl() + '/js/jquery-' + $plugName.toLowerCase() + '.js');
            return $;
        },

        /**
         * draw dialog
         *
         * @return Object
         */
        _drawDialog: function($element, $position, $masker, zIndex){
            var $main = $('body'),
                $this = this,
                $width = $position[0],
                $top = $position[1]
            ;
            $element.draggable({containment : 'document', handle : '.dialog-heading'}).find('.cancel, .heading-close').click(function(){
                $('tr.active').removeClass('active');
                $element.remove();
                $this._showMask($masker);
            });
            $element.find('.heading-switcher').click(function(ev){
                var _this = $(this),
                    _table = _this.children('table'),
                    _width = -_this.find('td div').filter(':first').width(),
                    _tablePosition = _table.position();
                    
                _table.animate({left: _tablePosition.left < 0 ? 0 : _width}, 200, function(){
                    _this.find('input[type="radio"]:not(:checked)').attr('checked','checked');
                });
                return false;
            });
            $element.css({
                  'width'     : $width + 'px',
                  'position'  : 'fixed',
                  'top'       : $top + 'px',
                  'left'      : (($main.width() - $width) / 2) + 'px'
            });
            ! zIndex && $element.css({'z-index': zIndex});
            $main.append($element);

            // focus form element
            $element.find('.cancel,button').filter(':first').focus();
            return $this;
        },

        /**
         * show the Mask
         *
         * @return Object $.tone.Action
         */
        _showMask: function($masker){
            var $masker = $masker || $('body'),
                $maskerIndex = $masker.attr('id'),
                $mask   = $('#' + $maskerIndex + 'mask'),
                _w = [$('#main').width(), $(document).width()],
                _h = [$('#main').height(), $(document).height()],
                $width = _w[0] > _w[1] ? _w[0] : '100%',
                $height = _h[0] > _h[1] ? _h[0] : _h[1];
            //fixed $height
            $height = $masker.is('body') ? $height : $masker.outerHeight();
            // check if mask is existed OR not
            if ($mask.length) {
                $mask.filter(':hidden').removeAttr('style').hide();
                $mask.css({width : $width, height : $height}).toggle();
            } else {
                $masker.append(
                    $mask = $('<div id="' + $maskerIndex+ 'mask" class="mask"/>').css({
                        width: $width,
                        height: $height
                    })
                );
            }

            //fixed border-radius
            !$masker.is('body') && $mask.css('-moz-border-radius', 5);
            return this;
        },

        /**
         * show notifier instance
         *
         * @return Object
         */
        _growl: function(m, $position){
            if (! m.loading && ! $(m).filter('.notification').length) {
                return this;
            }
            var $isError = $(m).hasClass('error');
            if (m.loading || $isError) {
                $position = 'top-center';
            } else {
                $position = 'top-right';
            }
            var $container = '<div class="growl' + ($isError ? ' err' : '')+ '" id="' + $position + '"></div>';
            if (!$('.growl').length) {
                $('body').append($container);
            } else {
                $('.growl').replaceWith($container);
            }
            var $notification = $('<div class="growl-notification' + ($isError ? ' error' : '') + '"></div>'),
                $closer = m.loading ? '' : $('<span class="close">&times;</span>'),
                $msgText = m.loading ? m.loading : ($(m).length ? $(m).html() : m),
                $message = $('<span class="message">' + $msgText + '</span>'),
                $growl = $('.growl');
            $notification.data('create', new Date().getTime());
            $growl.find('.growl-notification').filter(':first').remove();
            $growl.append($notification.append($closer, $message));
            $growl.find('.close').click(function(){
                $(this).parent().fadeOut(1000);
            });
            if (! m.loading && ! $isError) {
                window.setTimeout(function() {
                    $growl.find('.growl-notification').eq(0).fadeOut(1000);
                }, 3000);
            }
            if ($(m).hasClass('session-expired')) {
                window.setTimeout(function() {
                    window.location.replace($.getBaseUrl());
                }, 3000);
            }
            return this;
        },

        /**
         * remove notifier instance
         *
         * @return Object
         */
        _destroyGrowl: function(){
            $('.growl-notification').filter(':first').remove();
            return this;
        }
    });

    // Set Base Url for Plugin Loader
    var _url = (
        $('head > script').filter(':first').attr('src') || ''
    ).replace('/js/jquery.js', '');
    $.setBaseUrl(_url);

    /**
     * add dropdown to  user menu 
     *
     */
    var addDropDown = function(){
        $('#header .status > span').click(function(ev){
            var _trigger = $(this);
            ev.preventDefault();
            _trigger.siblings('dl').css({
                right: _trigger.siblings('a').width() + 20
            }).toggle(100);
        }).siblings('dl').mouseleave(function(){
            $(this).removeAttr('style');
        });
    }

    // DOM ready
    $(function(){
        $(window).scroll(_reMask);
        $(window).resize(_reMask);

        function _reMask() {
            var $width = $('body').width() < 960 ? 960 : $('body').width();
            $('#mask').css({width : $width, height : $('#main').height()});
        }

        $('input.input_default').live('focus', function() {
            var $this = $(this),
                $defaultValue = $this.attr('defaultValue');
            if ($this.hasClass('password')) {
                this.type = 'password';
            }
            $this.removeClass('input_default').val('');
            $this.blur(function() {
                if ('' == $.trim($this.val())) {
                    if ($this.hasClass('password')) {
                        this.type = 'text';
                    }
                    $this.addClass('input_default').val($defaultValue);
                }
            });

        });

        $('q a').live('click', function() {
            $(this).closest('tr').addClass('active');
        });

        addDropDown(); 

        $('#header .status .go-back-super-admin').click(function(){
            $.get($(this).attr('href'), function(data){
                //$._growl(data)._showMask();
                if (!$(data).hasClass('error')) {
                    window.location.replace($.getBaseUrl());
                }
            });
            return false;
        });
    });
})(jQuery);

/* EOF */
