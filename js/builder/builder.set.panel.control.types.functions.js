/**
 * Control types separated functions
 */

;'use strict';

jQuery(function(){

	var controls = {

		toggle_controls: function() {

			jQuery(document).on('LC.optionDepsDone', function(e) {

				var data = e.message.details;

				if ( ! jQuery(data.optElem).hasClass('toggle_controls') ) return false; /// Not toggle triggered

				if ( data.eventProps.currentDepState.show == 'false' || data.eventProps.currentDepState.hide == 'true' ) {

					/// Closed
					if ( jQuery(data.eventProps.optionControls.false).eq(0).hasClass('dslca-option-off') ) {

						jQuery(data.eventProps.optionControls.false).find('.dslc-control-toggle').click();
					}

					if ( ! jQuery(data.eventProps.optionControls.true).eq(0).hasClass('dslca-option-off') ) {

						jQuery(data.eventProps.optionControls.true).find('.dslc-control-toggle').click();
					}
				} else {

					if ( ! jQuery(data.eventProps.optionControls.false).eq(0).hasClass('dslca-option-off') ) {

						jQuery(data.eventProps.optionControls.false).find('.dslc-control-toggle').click();
					}

					if ( jQuery(data.eventProps.optionControls.true).eq(0).hasClass('dslca-option-off') ) {

						jQuery(data.eventProps.optionControls.true).find('.dslc-control-toggle').click();
					}
				}
			});

			jQuery(document).on('click', '.dslca-module-edit-option-toggle_controls .dslca-module-edit-option-checkbox-single', function(e) {

				var lock = jQuery('.dslc-icon', this);
				var checked = jQuery('input', this).is(':checked');

				// If control opened
				if ( checked ) {

					jQuery('input', this)[0].checked = false;

					lock.addClass('dslc-icon-link')
						.removeClass('dslc-icon-unlink');
					// Now closed
				} else {

					jQuery('input', this)[0].checked = true;

					lock.removeClass('dslc-icon-link')
						.addClass('dslc-icon-unlink');
					// Now opened
				}

				jQuery('input', this).trigger('change');
			});
		},
		minify_controls: function() {

			var commonHandlerInitiated = {};

			jQuery(document).on('LC.optionDepsDone', function(e) {

				var data = e.message.details;

				if ( ! jQuery(data.optElem).hasClass('minify_controls') ) return false; /// Not minify triggered


				var optID = data.optID;
				var common = jQuery(data.eventProps.optionControls.false).find('input');
				var separated = jQuery(data.eventProps.optionControls.true).find('input');

				if ( commonHandlerInitiated[optID] != undefined ) {

					if ( data.eventProps.currentDepState.show == 'false' ) {

						// Closed
						if ( common.closest('.lc-option-group').find('.lc-group-header').hasClass('dslca-option-off') ) {

							var bckpVal = separated.eq(0).data('val-bckp');
							common.data('val-bckp', bckpVal );
							separated.data('val-bckp', bckpVal);
						} else {

							var commonValue = separated.eq(0).val();
							common.val(commonValue).trigger('change');
							separated.val(commonValue).trigger('change');
						}
					} else {

						// Opened
						var commonValue = common.val();
						separated.val(commonValue).trigger('change');
						common.val('').trigger('change');
					}
				}

				if ( commonHandlerInitiated[optID] == undefined ) {

					commonHandlerInitiated[optID] = true;

					// Copy every setting to separate controls.
					jQuery(document).on('change', data.eventProps.optionControls.false + ' input', function(){

						if ( this.value == '') return false;

						var group = jQuery(this).closest('.lc-option-group-inner-wrapper');
						separated.val(this.value).trigger('change');
					});
				}
			});

			jQuery(document).on('click', '.dslca-module-edit-option-minify_controls .dslca-module-edit-option-checkbox-single', function(e) {

				var lock = jQuery('.dslc-icon', this);
				var checked = jQuery('input', this).is(':checked');

				// If control opened
				if ( checked ) {

					jQuery('input', this)[0].checked = false;

					lock.addClass('dslc-icon-link')
						.removeClass('dslc-icon-unlink');
					// Now closed
				} else {

					jQuery('input', this)[0].checked = true;

					lock.removeClass('dslc-icon-link')
						.addClass('dslc-icon-unlink');
					// Now opened
				}

				jQuery('input', this).trigger('change');
			});
		}
	};

	// Fire all functions
	for( var i in controls ) {

		if ( typeof controls[i] == 'function' ) {

			controls[i]();
		}
	}
});