/**
 * $Rev: 2597 $
 * $LastChangedDate: 2010-06-18 18:50:10 +0800 (Fri, 18 Jun 2010) $
 * $LastChangedBy: junzhang $
 *
 * @category   public
 * @package    styles
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: admin-account.js 2597 2010-06-18 10:50:10Z junzhang $
 */
;(function($){
    /**
     * Initialization after DOM ready
     */
    $(function(){
        $('#form-admin-account').submit(function(){
            var _form = $(this),
                _pwd = _form.find('#Password'),
                _pwd2 = _form.find('#Password-Confirm'),
                _pwdVal = _pwd.val(),
                _pwd2Val = _pwd2.val();
            $._growl(VIEW_DATA[0])._showMask();
            if (_pwdVal.length && _pwdVal != _pwd2Val) {
                var _container = _pwd2.siblings('.description'),
                    _tip = _container.text();
                _container.text(ERR_PWD_CHECKING).effect('highlight', {}, 500, function(){
                    setTimeout(function(){
                        _container.removeAttr('style').text(_tip);
                    }, 500);
                });
                $._destroyGrowl()._showMask();
                return false;
            }
            $.post(_form.attr('action'), _form.serialize(), function(response){
                $._growl(response);
                setTimeout(function(){
                    window.location.replace($.getBaseUrl());
                }, 1000);
            });
            return false;
        });
    });
})(jQuery);

/* EOF */