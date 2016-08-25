/**
 * Control types separated functions
 */

;'use strict';

jQuery(function(){

	var controls = {

		toggle_controls: function() {

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
		}
	};

	// Fire all functions
	for( var i in controls ) {

		if ( typeof controls[i] == 'function' ) {

			controls[i]();
		}
	}
});