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

			jQuery(document).on('click', '.lc-option-group-margin-locker', function(){

				var group = jQuery(this).closest('.lc-option-group-margin-wrapper');

				if( group.hasClass('group-locked') ) {

					var commonValue = group.find('.group-margin-common input').val();
					group.find('.group-margin-left input, .group-margin-top input, .group-margin-bottom input, .group-margin-right input').val(commonValue).trigger('change');
					group.find('.group-margin-common input').val('').trigger('change');

					jQuery(this).children().eq(0)
						.removeClass('dslc-icon-lock')
						.addClass('dslc-icon-unlock');

					group.removeClass('group-locked')
						.addClass('group-unlocked');
				} else {

					var commonValue = group.find('.group-margin-top input').val();

					if ( jQuery(this).closest('.lc-option-group').find('.lc-group-header').hasClass('dslca-option-off') ) {

						var bckpVal = group.find('.group-margin-top input').data('val-bckp');
						group.find('.group-margin-common input').data('val-bckp', bckpVal );
						group.find('.group-margin-left input, .group-margin-top input, .group-margin-bottom input, .group-margin-right input').data('val-bckp', bckpVal);
					}

					group.find('.group-margin-common input').val(commonValue).trigger('change');
					group.find('.group-margin-left input, .group-margin-top input, .group-margin-bottom input, .group-margin-right input').val(commonValue).trigger('change');

					jQuery(this).children().eq(0)
						.removeClass('dslc-icon-unlock')
						.addClass('dslc-icon-lock');

					group.removeClass('group-unlocked')
						.addClass('group-locked');
				}
			});

			jQuery(document).on('change', '.group-margin-common input', function(){

				if ( this.value == '') return false;

				var group = jQuery(this).closest('.lc-option-group-margin-wrapper');
				group.find('.group-margin-left input, .group-margin-top input, .group-margin-bottom input, .group-margin-right input').val(this.value).trigger('change');
			});
		}
	};

	for( var i in option_group_functions ) {

		if ( typeof option_group_functions[i] == 'function' ) {

			option_group_functions[i]();
		}
	}
});
