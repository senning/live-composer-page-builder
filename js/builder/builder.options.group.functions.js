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

					jQuery(this).children().eq(0)
						.removeClass('dslc-icon-lock')
						.addClass('dslc-icon-unlock');

					group.removeClass('group-locked')
						.addClass('group-unlocked');
				} else {

					jQuery(this).children().eq(0)
						.removeClass('dslc-icon-unlock')
						.addClass('dslc-icon-lock');

					group.removeClass('group-unlocked')
						.addClass('group-locked');
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
