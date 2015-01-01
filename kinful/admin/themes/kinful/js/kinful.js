/*
 * jQuery JavaScript Library v1.3.2
 * http://jquery.com/
 *
 * Copyright (c) 2009 John Resig
 * Dual licensed under the MIT and GPL licenses.
 * http://docs.jquery.com/License
 *
 * Date: 2009-02-19 17:34:21 -0500 (Thu, 19 Feb 2009)
 * Revision: 6246
 */
(function($){
	$.extend ({
		yeaheasy: {
			displayError: function (message) {
				alert(message);
			},

			formAction: {
				formId:null,
				init: function (property, value) {
					if (property=='formId') {
						this.formId = value;
					}
					return this;
				},

				checkOneChecked: function () {
					if (undefined!=$(this).attr('warning') && $('#' + $.yeaheasy.formAction.formId + ' input:checked').length<1) {
						$.yeaheasy.displayError($(this).attr('warning'));

						return false;

					}

					if ($(this).attr('href')!='#') {
						var funcReturn;
						try {
							var funcName = eval($(this).attr('href').replace(/#(.+)/, '$1'));
							if(! funcName()) {
								return false;
							}
						} catch (e) {
							$.yeaheasy.displayError($(this).attr('href').replace(/#(.+)/, '$1') + ' not defined');
							return false;
						}
					}

					if ($('form[id="' + $.yeaheasy.formAction.formId + '"]').length) {
						if (0 == $('form[id="' + $.yeaheasy.formAction.formId + '"]').find('input:hidden[name="form_action"]').length) {
							$('form[id="' + $.yeaheasy.formAction.formId + '"]').append('<input type="hidden" name="form_action" value=""');
						}
						$('form[id="' + $.yeaheasy.formAction.formId + '"]').find('input:hidden[name="form_action"]').attr('value', $(this).attr('action'));
						$('form[id="' + $.yeaheasy.formAction.formId + '"]').submit();
					}

					return false;
				}, // end checkSelectOne

				callUserFuncAndSubmit: function () {
					if ($(this).attr('href')!='#') {
						try {
							var funcName = eval($(this).attr('href').replace(/#(.+)/, '$1'));
							if(! funcName()) {

								return false;
							}
						} catch (e) {
							$.yeaheasy.displayError($(this).attr('href').replace(/#(.+)/, '$1') + ' not defined');

							return false;
						}
					}

					if ($('form[id="' + $.yeaheasy.formAction.formId + '"]').length) {
						if (0 == $('form[id="' + $.yeaheasy.formAction.formId + '"]').find('input:hidden[name="form_action"]').length) {
							$('form[id="' + $.yeaheasy.formAction.formId + '"]').append('<input type="hidden" name="form_action" value=""');
						}
						$('form[id="' + $.yeaheasy.formAction.formId + '"]').find('input:hidden[name="form_action"]').attr('value', $(this).attr('action'));
						$('form[id="' + $.yeaheasy.formAction.formId + '"]').submit();
					}

					return false;
				}
			}, // end formAction

            checkOneCheckAll: function (checkOneObj, checkboxName) {
				if($(checkOneObj).attr('checked')) {
					$(':checkbox[name="' + checkboxName + '"]').attr('checked', 'checked');

    				return false;
				}
			} // end checkOneCheckAll
		}
	});
})(jQuery);