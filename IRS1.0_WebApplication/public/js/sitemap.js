/**
 * $Rev: 2140 $
 * $LastChangedDate: 2010-05-19 16:41:31 +0800 (Wed, 19 May 2010) $
 * $LastChangedBy: junzhang $
 *
 * @category   public
 * @package    styles
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: sitemap.js 2140 2010-05-19 08:41:31Z junzhang $
 */

/**
 * sitemap behaviors
 */
;(function($){
    $(function(){
        var $tmpForm = $($('#parameters').get()).submit(function(){
            var $this = $(this), $uri = $this.attr('action');
            //$uri = '#';//debug
            $.post($uri, $this.serialize(), function(response){
                $this.after(
                    $('<fieldset class="response"/>').append(
                        $('<legend>Response(Click here to remove)</legend>').click(function(){
                            $(this).parent().remove();
                        })
                    ).append(
                        '<hr/>' + response
                    )
                );
            });
            return false;
        });
        !$('#main').data('__form__') && $('#main').data('__form__', $tmpForm.clone(true));
        $tmpForm.remove() && $('.navigation li a').click(function(){
            var $this = $(this).trigger('blur'),
                $wrap = $this.parent(),
                $flag = !$wrap.children('#parameters').length;
            $('#parameters,.response').remove() && $flag && $wrap.append(
                $('#main').data('__form__').clone(true).attr('action', $this.attr('href'))
            ) && $wrap.find('input:hidden').val($this.text());
            return false;
        });
        $('#submit').live('click', function(){
            $(this).parents('form').trigger('submit');
            return false;
        });
        $('#add').live('click', function(){
            $(this).parent().next().append($('#main').data('__form__').find('.group').clone(true));
            return false;
        });
        $('#remove').live('click', function(){
            var $wrap = $(this).parents('.group');
            $wrap.siblings('.group').length && $wrap.remove();
            return false;
        });
        $('#reset').live('click', function(){
            $(this).siblings('input').val(null);
            return false;
        });
    });
})(jQuery);

/* EOF */