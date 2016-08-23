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

				if ( checked ) {

					jQuery('input', this)[0].checked = false;
					jQuery('input', this).val(false);

					lock.addClass('dslc-icon-link')
						.removeClass('dslc-icon-unlink');
					// Closed
				} else {

					jQuery('input', this)[0].checked = true;
					jQuery('input', this).val(true);

					lock.removeClass('dslc-icon-link')
						.addClass('dslc-icon-unlink');
					// Opened
				}

				jQuery('input', this).trigger('change');
			});
		}
	};

	for( var i in controls ) {

		if ( typeof controls[i] == 'function' ) {

			controls[i]();
		}
	}
});