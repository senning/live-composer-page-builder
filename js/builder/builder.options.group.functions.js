/**
 * Group options functions.
 *
 * Organized like object fields
 * to prevent functions mixing.
 */

;'use strict';

jQuery(document).ready(function(){

	var option_group_functions = {

		margin_group: function(){

			// Toggle controls in margin group from collapsed to closed & visa-versa
			jQuery(document).on('moduleChanged', function(e){

				var data = e.message.details;

				if ( data.optionType != 'toggle_controls' ||
					( jQuery('.dslca-module-edit-option-' + data.optionID) != null &&
					jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_margin').length == 0 )
				 ) return false;

				// Margin group only here
				var group = jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_margin');

				if ( jQuery('.dslca-module-edit-option-' + data.optionID + ' input')[0].checked ) {

					var commonValue = group.find('.group-margin-common input').val();
					group.find('.group-margin-left input, .group-margin-top input, .group-margin-bottom input, .group-margin-right input').val(commonValue).trigger('change');
					group.find('.group-margin-common input').val('').trigger('change');
				} else {

					var commonValue = group.find('.group-margin-top input').val();

					if ( jQuery(this).closest('.lc-option-group').find('.lc-group-header').hasClass('dslca-option-off') ) {

						var bckpVal = group.find('.group-margin-top input').data('val-bckp');
						group.find('.group-margin-common input').data('val-bckp', bckpVal );
						group.find('.group-margin-left input, .group-margin-top input, .group-margin-bottom input, .group-margin-right input').data('val-bckp', bckpVal);
					}

					group.find('.group-margin-common input').val(commonValue).trigger('change');
					group.find('.group-margin-left input, .group-margin-top input, .group-margin-bottom input, .group-margin-right input').val(commonValue).trigger('change');
				}
			});

			// Copy every setting to separate controls.
			jQuery(document).on('change', '.group-margin-common input', function(){

				if ( this.value == '') return false;

				var group = jQuery(this).closest('.lc-option-group-margin-wrapper');
				group.find('.group-margin-left input, .group-margin-top input, .group-margin-bottom input, .group-margin-right input').val(this.value).trigger('change');
			});
		},
		padding_group: function(){

			// Toggle controls in padding group from collapsed to closed & visa-versa
			jQuery(document).on('moduleChanged', function(e){

				var data = e.message.details;

				if ( data.optionType != 'toggle_controls' ||
					( jQuery('.dslca-module-edit-option-' + data.optionID) != null &&
					jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_padding').length == 0 )
				 ) return false;

				// Padding group only here
				var group = jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_padding');

				if ( jQuery('.dslca-module-edit-option-' + data.optionID + ' input')[0].checked ) {

					var commonValue = group.find('.group-padding-common input').val();
					group.find('.group-padding-left input, .group-padding-top input, .group-padding-bottom input, .group-padding-right input').val(commonValue).trigger('change');
					group.find('.group-padding-common input').val('').trigger('change');
				} else {

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

				var group = jQuery(this).closest('.lc-group-type-group_padding');
				group.find('.group-padding-left input, .group-padding-top input, .group-padding-bottom input, .group-padding-right input').val(this.value).trigger('change');
			});
		},
		background_group: function(){

			// Toggle controls in background group from collapsed to closed & visa-versa
			jQuery(document).on('moduleChanged', function(e){

				var data = e.message.details;

				if ( data.optionType != 'toggle_controls' ||
					( jQuery('.dslca-module-edit-option-' + data.optionID) != null &&
					jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_background').length == 0 )
				 ) return false;

				// Background group only here
				var group = jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_background');

				if ( jQuery('.dslca-module-edit-option-' + data.optionID + ' input')[0].checked ) {

					// Collapsed
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

			// Toggle controls in border group from collapsed to closed & visa-versa
			jQuery(document).on('moduleChanged', function(e){

				var data = e.message.details;

				if ( data.optionType != 'toggle_controls' ||
					( jQuery('.dslca-module-edit-option-' + data.optionID) != null &&
					jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_border').length == 0 )
				 ) return false;

				// Border group only here
				var group = jQuery('.dslca-module-edit-option-' + data.optionID).closest('.lc-group-type-group_border');

				if ( jQuery('.dslca-module-edit-option-' + data.optionID + ' input')[0].checked ) {

					// Collapsed
					group.find('.dslca-module-edit-option').not('.dslca-module-edit-field-colorpicker').each(function(){

						if ( this.classList.contains('dslca-option-off') && jQuery(this).data('affect-on-change-rule') != 'border-width' ) {

							jQuery('.dslc-control-toggle', this).click();
						}
					});
				} else {

					// Closed
					group.find('.dslca-module-edit-option').not('.dslca-module-edit-option-color').each(function(){

						if ( ! this.classList.contains('dslca-option-off') && jQuery(this).data('affect-on-change-rule') != 'border-width' ) {

							jQuery('.dslc-control-toggle', this).click();
						}
					});
				}
			});
		}
	};

	for( var i in option_group_functions ) {

		if ( typeof option_group_functions[i] == 'function' ) {

			option_group_functions[i]();
		}
	}
});
