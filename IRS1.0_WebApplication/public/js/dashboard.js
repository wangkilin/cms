/**
 * $Rev: 2637 $
 * $LastChangedDate: 2010-06-22 15:00:36 +0800 (Tue, 22 Jun 2010) $
 * $LastChangedBy: junzhang $
 *
 * @category   public
 * @package    js
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: dashboard.js 2637 2010-06-22 07:00:36Z junzhang $
 */

/**
 * dashboard behaviors
 */
;(function($){
    //add autocomplete to account connection:
    var makeAutocompleteForm = function(){
        $('#form-search-customer').submit(function(){
            return false;
        }).find('.keyword').autocomplete({
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
                sudoUser(ui.item.id, true);
                return false;
            }
        });
    }

    /**
     * add slideDown/Up to action
     *
     * @param   String  handle          jQuery selector   the slideaction trigger
     * @param   String  targetElement   jQuery selector   element to slide
     * @return  Boolean false
     */
    var clickToSlide = function(handle){
        $(handle).click(function(){
            targetElement  = $(this).attr('href');
            _targetElement = $(targetElement);
            if(_targetElement.is(":hidden")){
                _targetElement.slideDown(500);
            } else {
                _targetElement.slideUp(500);
            }
            return false;
        });
    }



    /**
     * sudo user
     *
     * @param   String    customerId    assigned Customer Account ID
     * @return  Boolean   false
     */
    var sudoUser = function(customerId, isShowMask){
        $.post($.getBaseUrl() + '/admin/sudo', {AssignedCustomerAccountId: customerId}, function(data){
            if(isShowMask) { $._growl(data)._showMask();}
            window.location.replace($.getBaseUrl());
            return false;
        });
    }

    //DOM ready
    $(function(){
        makeAutocompleteForm();
        clickToSlide('#customer-switcher-handle');
        clickToSlide('#tree-last-modified-handle');
    });

})(jQuery);

/* EOF */
