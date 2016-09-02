/**
 * Group options functions.
 *
 * Organized like object fields
 * to prevent functions mixing.
 */

;'use strict';

jQuery(document).ready(function(){

	var option_group_functions = {

		padding_group: function(){

			// Toggle controls in padding group from opened to closed & visa-versa
			jQuery(document).on('moduleChanged', function(e){

				var data = e.message.details;

				if ( data.optionType != 'toggle_controls' ||
					( jQuery('.dslca-module-edit-option-' + data.optionID) != null &&
					jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_padding').length == 0 )
				 ) return false;

				// Padding group only here
				var group = jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_padding');

				if ( jQuery('.dslca-module-edit-option-' + data.optionID + ' input')[0].checked ) {

					// Opened
					var commonValue = group.find('.group-padding-common input').val();
					group.find('.group-padding-left input, .group-padding-top input, .group-padding-bottom input, .group-padding-right input').val(commonValue).trigger('change');
					group.find('.group-padding-common input').val('').trigger('change');
				} else {

					// Closed
					var commonValue = group.find('.group-padding-top input').val();

					if ( jQuery(this).closest('.lc-option-group').find('.lc-group-header').hasClass('dslca-option-off') ) {

						var bckpVal = group.find('.group-padding-top input').data('val-bckp');
						group.find('.group-padding-common input').data('val-bckp', bckpVal );
						group.find('.group-padding-left input, .group-padding-top input, .group-padding-bottom input, .group-padding-right input').data('val-bckp', bckpVal);
					}

					group.find('.group-padding-common input').val(commonValue).trigger('change');
					group.find('.group-padding-left input, .group-padding-top input, .group-padding-bottom input, .group-padding-right input').val(commonValue).trigger('change');
				}
			});

			// Copy every setting to separate controls.
			jQuery(document).on('change', '.group-padding-common input', function(){

				if ( this.value == '') return false;

				var group = jQuery(this).closest('.lc-option-group-inner-wrapper');
				group.find('.group-padding-left input, .group-padding-top input, .group-padding-bottom input, .group-padding-right input').val(this.value).trigger('change');
			});
		},
		background_group: function(){

			// Toggle controls in background group from opened to closed & visa-versa
			jQuery(document).on('moduleChanged', function(e){

				var data = e.message.details;

				if ( data.optionType != 'toggle_controls' ||
					( jQuery('.dslca-module-edit-option-' + data.optionID) != null &&
					jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_background').length == 0 )
				 ) return false;

				// Background group only here
				var group = jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_background');

				if ( jQuery('.dslca-module-edit-option-' + data.optionID + ' input')[0].checked ) {

					// Opened
					group.find('.dslca-module-edit-option').not('.dslca-module-edit-option-color').each(function(){

						if ( this.classList.contains('dslca-option-off') ) {

							jQuery('.dslc-control-toggle', this).click();
						}
					});
				} else {

					// Closed
					group.find('.dslca-module-edit-option').not('.dslca-module-edit-option-color').each(function(){

						if ( ! this.classList.contains('dslca-option-off') ) {

							jQuery('.dslc-control-toggle', this).click();
						}
					});
				}
			});
		},
		border_group: function() {

			// Toggle controls in border group from opened to closed & visa-versa
			jQuery(document).on('moduleChanged', function(e){

				var data = e.message.details;

				if ( data.optionType != 'toggle_controls' ||
					( jQuery('.dslca-module-edit-option-' + data.optionID) != null &&
					jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_border').length == 0 )
				 ) return false;

				// Border group only here
				var group = jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_border');

				if ( jQuery('.dslca-module-edit-option-' + data.optionID + ' input')[0].checked ) {

					// Opened
					group.find('.dslca-module-edit-option').not('.dslca-module-edit-field-color, .dslca-module-edit-option-checkbox').each(function(){

						if ( this.classList.contains('dslca-option-off') && jQuery('.dslca-module-edit-field', this).data('affect-on-change-rule') != 'border-width' ) {

							jQuery('.dslc-control-toggle', this).click();
						}
					});


					// Process border_trbl
					group.find('.dslca-module-edit-option-checkbox .dslca-module-edit-field').each(function(){

						var bckp = jQuery(this).data('val-bckp');

						if ( bckp == undefined ) return false;

						this.checked = bckp;
						jQuery(this).trigger('change');
					});
				} else {

					// Closed
					group.find('.dslca-module-edit-option').not('.dslca-module-edit-option-color, .dslca-module-edit-option-checkbox').each(function(){

						if ( ! this.classList.contains('dslca-option-off') && jQuery('.dslca-module-edit-field', this).data('affect-on-change-rule') != 'border-width' ) {

							jQuery('.dslc-control-toggle', this).click();
						}
					});

					// Process border_trbl
					group.find('.dslca-module-edit-option-checkbox .dslca-module-edit-field').each(function(){

						jQuery(this).data('val-bckp', this.checked);

						this.checked = true;
						jQuery(this).trigger('change');
					});
				}
			});

			// Toggle controls in border radius group from opened to closed & visa-versa
			jQuery(document).on('moduleChanged', function(e){

				var data = e.message.details;
				var closestFront = jQuery('.dslca-module-edit-option-' + data.optionID).closest('.dslca-module-edit-option');

				if ( ! closestFront.next().hasClass('group-border-radius-common') ) return false;

				// Border radius group only here
				var group = jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_border');
				var separateOptions = group.find('.bradius-tr input, .bradius-br input, .bradius-bl input, .bradius-tl input');
				var commonOption = group.find('.border-radius-common input');

				if ( jQuery('.dslca-module-edit-option-' + data.optionID + ' input')[0].checked ) {

					// Opened
					var commonValue = commonOption.val();
					separateOptions.val(commonValue).trigger('change');
					commonOption.val('').trigger('change');
				} else {

					// Closed
					var commonValue = group.find('.bradius-tl input').val();

					if ( jQuery(this).closest('.lc-option-group').find('.lc-group-header').hasClass('dslca-option-off') ) {

						var bckpVal = group.find('.bradius-tl input').data('val-bckp');
						commonOption.data('val-bckp', bckpVal );
						separateOptions.data('val-bckp', bckpVal);
					}

					commonOption.val(commonValue).trigger('change');
					separateOptions.val(commonValue).trigger('change');
				}
			});

			// Copy every setting to separate controls.
			jQuery(document).on('change', '.group-border-radius-common input', function(){

				if ( this.value == '') return false;

				var group = jQuery(this).closest('.lc-option-group-inner-wrapper');
				group.find('.bradius-tr input, .bradius-br input, .bradius-bl input, .bradius-tl input').val(this.value).trigger('change');
			});
		},
		text_group: function() {

			// Toggle controls in text group from opened to closed & visa-versa
			jQuery(document).on('moduleChanged', function(e){

				var data = e.message.details;

				if ( data.optionType != 'toggle_controls' ||
					( jQuery('.dslca-module-edit-option-' + data.optionID) != null &&
					jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_text').length == 0 )
				 ) return false;

				// Border group only here
				var group = jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_text');

				if ( jQuery('.dslca-module-edit-option-' + data.optionID + ' input')[0].checked ) {

					// Opened
					group.find('.dslca-module-edit-option').not('.dslca-module-edit-field-color').each(function(){

						if ( this.classList.contains('dslca-option-off') && jQuery('.dslca-module-edit-field', this).data('affect-on-change-rule') != 'font-size' ) {

							jQuery('.dslc-control-toggle', this).click();
						}
					});
				} else {

					// Closed
					group.find('.dslca-module-edit-option').not('.dslca-module-edit-option-color').each(function(){

						if ( ! this.classList.contains('dslca-option-off') && jQuery('.dslca-module-edit-field', this).data('affect-on-change-rule') != 'font-size' ) {

							jQuery('.dslc-control-toggle', this).click();
						}
					});
				}
			});
		}
	};

	// Fire all functions
	/*for( var i in option_group_functions ) {

		if ( typeof option_group_functions[i] == 'function' ) {

			option_group_functions[i]();
		}*
	}*/
});
