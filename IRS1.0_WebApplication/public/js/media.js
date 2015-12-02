/**
 * $Rev: 2166 $
 * $LastChangedDate: 2010-05-20 18:35:22 +0800 (Thu, 20 May 2010) $
 * $LastChangedBy: zwang $
 *
 * @category   public
 * @package    styles
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Kilin WANG <zwang@streamwide.com>
 * @version    $Id$
 */

/**
 * sitemap behaviors
 */
;(function($){
    $.extend({
    	media: {
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
                            $._drawDialog($dialog, [550, 100]);
                            $self._upload();
                            $dialog.submit(function() {
                                $._growl(VIEW_DATA[0])._showMask($dialog);
                                var $pagination = $('#media-list tfoot'),
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

            	$('#media-edit-dialog, #media-create-dialog').live('mouseover', function() {
                    if (!$(this).find('object').length) {
                        $self._upload();
                        if ('media-edit-dialog' == $(this).attr('id')) {
                            $self._liveAudioPlayer();
                        }
                    }
                });

                // update media
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
                            $._drawDialog($dialog, [550, 100]);
                            $self._upload()._liveAudioPlayer();
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

                // delete media
                $('.manager-delete').live('click', function() {
                    var $this = $(this),
                        $uri = $this.attr('href');
                    $._growl(VIEW_DATA[0])._showMask();
                    $.get($uri, function(response) {
                        $._destroyGrowl();
                        if ($(response).hasClass('error')) {
                            $._growl(response)._showMask();
                        } else {
                            var $dialog = $(response),
                                $pagination = $this.closest('.list-body');
                            $._drawDialog($dialog, [400, 200]);
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

            	/**
            	 * submit edit media form
            	 */
            	$('#edit_button').live('click', function() {
            		var $item = $(this);
            		var $dialog = $item.closest('.dialog');
                    $._growl(VIEW_DATA[0])._showMask($dialog);
        			var url = $('#media-edit-dialog form').attr('action');
        			var paramList = $('#media-edit-dialog form').serialize() + '&act=edit';;

    		        $.post(url, paramList, function(response){
            			$._destroyGrowl();
                        if ($(response).hasClass('error')) {
                            $._growl(response)._showMask($dialog);
                        } else {
                        	$dialog.find('.heading-close').trigger('click');
                        	$('.list_item[itemId="' + $item.attr('itemId') + '"]').html($(response).find('tr').html());
                        }

    		        });

            		return false;
            	});

            	/**
            	 * submit create media form
            	 */
            	$('#create_button').live('click', function() {
            		var $item = $(this);
            		var $dialog = $item.closest('.dialog');
                    $._growl(VIEW_DATA[0])._showMask($dialog);
        			var url = $('#media-create-dialog form').attr('action');
        			var paramList = $('#media-create-dialog form').serialize() + '&act=create';;

                    $.post(url, paramList, function(response){
            			$._destroyGrowl();
                        if ($(response).hasClass('error')) {
                            $._growl(response)._showMask($dialog);
                        } else {
                        	$dialog.find('.heading-close').trigger('click');
                        	$('#main_content').replaceWith($(response).filter('#main_content'));
                        	$('#left_menu a').removeClass('on');
                        	$('#list_media_menu').addClass('on');
                        	$._growl(response)._showMask($dialog);
                        }

    		        });

            		return false;
            	});
            },

            _upload: function() {
                var $upload = $('#upload-flash');
            	if($upload.attr('IsFlashLoad')=='true') {
            		return;
            	}
                // check the browser has installed flash pulgin
                if ($.flash.available) {
                	$upload.attr('IsFlashLoad','true');
                    $upload.uploadify({
                        'uploader'       : '/irs/swf/uploadify.swf'
                      , 'script'         : '/irs/media/upload'
                      , 'scriptData'     : {
                               'Act'           : 'upload'
                             , 'PHPSESSID'     : $.trim($.grep(window.document.cookie.split(';'), function(n){
                                                      return -1 !== (n||'').indexOf('PHPSESSID=')
                                                  })[0].replace('PHPSESSID=', ''))
                           }
                      , 'queueID'        : 'file-queue'
                      , 'fileDesc'       : '*.al;*.wav'
                      , 'fileExt'        : '*.al;*.wav'
                      , 'simUploadLimit' : 1
                      , 'height'         : 25
                      , 'width'          : 150
                      , 'auto'           : true
                      , 'multi'          : false
                      , 'sizeLimit'      : 62914560
                      , onProgress       : function (event, ID, fileObj, data) {
                            $._growl(VIEW_DATA[0]);
                      }
                      , onComplete       : function(event, ID, fileObj, response, data) {
                            $._destroyGrowl();
                    	    $('#FileKey').val($(response).attr('filekey'));
                            $('#media_file_zone span').text(fileObj.name);
                            $('#media_file_zone i').text((fileObj.size/1024).toFixed(2) + 'KB');
                        }
                    });
                } else {
              	  //mediaForm.find('.ui-title s').trigger('click');
                  //  $.MediaLibraries.DisplayError('<p class="error">' + form.attr('flash') + '</p>');
                }

                return this;
            },


            _liveAudioPlayer : function () {
                // available the audio player
                $('#media_file_zone b').hide().each(function(){
                    var $dom  = $(this),
                        $id   = $dom.attr('id'),
                        $musc = $dom.siblings('u:first'),
                        $src  = $musc.attr('media');
                    AudioPlayer.embed($id, {soundFile: $src});
                    $dom.find('.ui-icon-close').click(function(){
                    	   $dom.prev().show();
                        try{
                            AudioPlayer['close']($id + '_player');
                            $dom.hide();
                        }catch(err){
                            //do nothing
                            window.console && window.console.debug(err);
                        }
                    });
                });
                // click event
                $('#media_file_zone u').live('click', function(){
                    var $dom  = $(this),
                        $wrap = $dom.siblings('b'),
                        $id   = $wrap.attr('id');
                    //stop first
                    $dom.next().filter(':visible').find('.ui-icon-close').trigger('click');
                    $wrap.show();
                    $dom.hide();
                    return false;
                });

                return this;
            }

        }
    });

    /**
     * Initialization after DOM ready
     */
    $(function() {
        $.media.init();

        // Initialized AudioPlayer instance
        AudioPlayer.setup($.getBaseUrl() + '/js/1pixelout-player.swf?ver=2.0.4.1', {
            width: '80',
            bg: 'EEFFCC',
            text: '333333',
            leftbg: 'BDE126',
            lefticon: 'FFFFFF',
            volslider: 'FFFFFF',
            voltrack: 'A5D416',
            rightbg: '7DD6F9',
            rightbghover: '55CAF8',
            righticon: 'FFFFFF',
            righticonhover: 'FFFFFF',
            track: 'EEFFCC',
            loader: 'D3E718',
            border: 'BDE126',
            tracker: 'D3E718',
            skip: '666666',
            pagebg: 'FFFFFF',
            transparentpagebg: 'yes',
            autostart: 'yes'
        });
    });
})(jQuery);

/* EOF */
