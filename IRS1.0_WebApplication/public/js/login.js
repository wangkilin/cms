/**
 * $Rev: 2585 $
 * $LastChangedDate: 2010-06-18 11:59:33 +0800 (Fri, 18 Jun 2010) $
 * $LastChangedBy: junzhang $
 *
 * @category   public
 * @package    js
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: login.js 2585 2010-06-18 03:59:33Z junzhang $
 */

/**
 * login form behaviors
 */
;(function($){
    var _loginFormEvent = function(){
        $('#form-login').submit(function(){
            var _this = $(this);
                _action = _this.attr('action'),
                _defaultInputs = _this.find('.input_default').attr('disabled', 'disabled'),
                _param = _this.serialize();
            _defaultInputs.removeAttr('disabled');
            $._growl(VIEW_DATA[0])._showMask();
            $.post(_action, _param, function(response){
                var _response = $(response);
                _this.find('.form-header q').text(_response.text());
                $._destroyGrowl()._showMask();
                if (_response.hasClass('ok')) {
                    $('#header .status').text(_response.text());
                    _this.find('input,button').attr('disabled', 'disabled');
                    _this.find('.goReset').hide();
                    _this.find('.form-content').slideUp(500, function(){
                        window.location.replace($.getBaseUrl());
                    });
                }
                //window.console && window.console.debug(response);
            });
            return false;
        }).find('.goReset').click(_switchForm);
    };
    var _resetFormEvent = function(){
        $('#form-reset').submit(function(){
            var _this = $(this);
                _goBack = _this.find('.goLogin'),
                _loginForm = $(_goBack.attr('href'));
                _action = _this.attr('action'),
                _defaultInputs = _this.find('.input_default').attr('disabled', 'disabled'),
                _param = _this.serialize();
            _defaultInputs.removeAttr('disabled');
            $._growl(VIEW_DATA[0])._showMask();
            $.post(_action, _param, function(response){
                var _response = $(response);
                $([]).add(_this).add(_loginForm).find('.form-header q').text(_response.text());
                $._destroyGrowl()._showMask();
                if (_response.hasClass('ok')) {
                    _this.find('.form-content').slideUp(500, function(){
                        _loginForm.find('input,button').removeAttr('disabled');
                        _goBack.triggerHandler('click');
                    });
                }
            });
            return false;
        }).find('.goLogin').click(_switchForm);
    };
    var _switchForm = function(ev){
        var _this = $(this);
        $([]).add(
            _this.closest('form')
        ).add(
            $(_this.attr('href'))
        ).toggle(200);
        return false;
    };

    $.ajaxSetup({
        error: function(xhr){
            $('form[action*="' + this.url + '"] .form-header q').text($(xhr.responseText).text());
            $._destroyGrowl();
            $('.mask').remove();
        }
    });

    //DOM ready
    $(function(){
        _loginFormEvent();
        _resetFormEvent();
    });
})(jQuery);
/* EOF */