/**
 * JQuery Plugin for exchange two elements.
 * How it works:
 * It exchange two element contents.
 *
 * $Id: jquery-plugin-swexchange.js 2140 2010-05-19 08:41:31Z junzhang $
 *
 * $Rev: 2140 $
 *
 * $LastChangedBy: junzhang $
 *
 * $LastChangedDate: 2010-05-19 16:41:31 +0800 (Wed, 19 May 2010) $
 *
 * @copyright 2008 Streamwide SAS
 * @author Kilin WANG <zwang@streamwide.com>
 * @package Convergence
 * @subpackage Tools
 * @version 1.0
 */

// Copyright (c) 2009 StreamWide, http://www.streamwide.com
;(function($) {
    if (! $) return;

    /**
     * build class to package all the exchange functions
     */
	$._swExchange = function (itemExpression, options) {
	    // the dragging obj
	    this.fromObj = null;

	    // the target obj. (mouse stop at)
	    this.toObj   = null;

	    // copy HTML from
	    this.fromHTML = '';

	    // copy HTML to
	    this.toHTML = '';

	    // callback after mouse up
	    this.stopCallBack = null;

	    // callback after exchange content
	    this.finishCallBack = null;

	    // expression to find object
	    this.itemExpression = itemExpression;

        // check if options set
	    if (options) {
	        if (options.stop) { // set stop callback
	            this.stopCallBack = options.stop;
	        }

	        if (options.finish) { // set finish callback
	            this.finishCallBack = options.finish;
	        }
	    }

	    /**
	     * Initialize
	     */
	    this.init = function () {
	        var $self = this;
	        // find target, make it draggable
	        $.each($.find($self.itemExpression), function () {
		        $(this).draggable( {
		            axis: 'y',
		            stop: function() {// stop callback
		                $self.fromObj = $(this);
		                $self.toObj   = $(this).parent().find('.sw:eq(0)');
		                $self.fromHTML = $(this).html();
		                $self.toHTML = $(this).parent().find('.sw:eq(0)').html();

		                // check if selected from target and To target
		                if ($.trim($self.toHTML)!='' && $self.fromHTML!=$self.toHTML) {
    		               if ($self.stopCallBack) { // check if has user defined callback
    		                   $self.stopCallBack($self.fromObj, $self.toObj, $self);
    		               }
                        } else {
                            $(this).attr('style', 'position:relative');
                        }

		                $(this).removeClass('sw_dragging');
		             },
		           start: function() {// start callback. set class to identify the target
		                $(this).removeClass('sw');
		                $(this).addClass('sw_dragging');
		                $.each($(this).siblings($self.itemExpression), function() {
		                    $(this).bind('mouseover', $self.mouseover);
		                    $(this).bind('mouseout', $self.mouseout);
		                });
		             }
		       });
		   });
	    };

        /**
         * callback for mouse over
         */
	    this.mouseover = function () {
	        $(this).addClass('sw');
	    };

        /**
         * callback for mouse over
         */
	    this.mouseout = function () {
	        $(this).removeClass('sw');
	    };

        /**
         * callback for finish exchanging content
         */
	    this.finish = function (doChange) {
	         $self = this;
	         if (doChange) {
	             var newY = 0 - parseInt($self.fromObj.css('top'));
                 $self.toObj.animate({top:newY, left:'0px'}
                              , { duration:'fast'
                                , complete:function(){
                                              $self.fromObj.html($self.toHTML).attr('style', 'position:relative');
                                              $self.toObj.html($self.fromHTML).attr('style', 'position:relative');
                                   }
                              }
                 );
                 $self.fromObj.animate({left:'0px'}
                              , { duration:'fast'
                                , complete:function(){
                                              $self.fromObj.html($self.toHTML).attr('style', 'position:relative');
                                              $self.toObj.html($self.fromHTML).attr('style', 'position:relative');
                                              if ($self.finishCallBack) {
                                                  $self.finishCallBack();
                                              }
                                   }
                              }
                 );
             } else {
                 $self.fromObj.attr('style', 'position:relative');
                 $self.toObj.attr('style', 'position:relative');
             }
	    };

	};

    // add exchange to jQuery
    $.extend({
      swExchange : function (itemExpression, options) {
        if (itemExpression == 'undefined' ) {
			console.error('swExchange missing parameter. You have to give one at least!');
			return false;
		}

        return new $._swExchange(itemExpression, options);
	  }
	});

	var expression = '.swExchange';
	var options = {stop:null, finish:null};

	if ($.swExchangeSettings) {
	// user defined exchange settings
	    if ($.swExchangeSettings.swExchangeStop) {
	        options.stop = $.swExchangeSettings.swExchangeStop;
	    }

	    if ($.swExchangeSettings.swExchangeFinish) {
	        options.finish = $.swExchangeSettings.swExchangeFinish;
	    }

	    if ($.swExchangeSettings.swExchangeExpression) {
	        expression = $.swExchangeSettings.swExchangeExpression;
	    }
	}

	$.swExchange(expression, options).init();// start the exchange function

})(jQuery);
