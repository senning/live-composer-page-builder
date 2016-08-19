<?php
/**
 * Class-container for custom options in settings panel
 */
class LC_Custom_Settings_Fields {

	/**
	 * Array contains options to be hidden
	 *
	 * @var array
	 */
	static private $hide_options = array();

	/**
	 * Init actions.
	 * Filters methods with preg pattern, so future util
	 * functions won't mess up with custom fields output.
	 */
	static public function init() {

		add_filter( 'dslc_module_options', array( __CLASS__, 'filter_options_list' ), 1, 2 );
		add_filter( 'dslc_module_options', array( __CLASS__, 'disable_changed_options' ), 2, 2 );
		add_filter( 'dslc_filter_settings', array( __CLASS__, 'move_options_values' ), 1, 1 );
	}

	/**
	 * Set dependencies of group options & values
	 *
	 * @param  array $options_values option values.
	 *
	 * @return array
	 */
	static public function move_options_values( $options_values ) {

		if ( ! empty( self::$hide_options ) ) {

			foreach ( self::$hide_options as $new_id => $old_id ) {

				if ( ! empty( $options_values[ $old_id ] ) ) {

					$options_values[ $new_id ] = $options_values[ $old_id ];
					$options_values[ $old_id ] = '';
				}
			}
		}

		return $options_values;
	}

	/**
	 * Sets to chosen options visibility hidden
	 *
	 * @param  array  $module_options options.
	 * @param  string $module_id option.
	 *
	 * @return array
	 */
	static public function disable_changed_options( $module_options, $module_id ) {

		$out = array();

		foreach ( $module_options as $option ) {

			if ( in_array( $option['id'], self::$hide_options, true ) ) {

				$option['visibility'] = 'hidden';
			}

			$out[] = $option;
		}

		return $out;
	}

	/**
	 * Live Composer Custom Field definition
	 *
	 * @param array $module_options all module options.
	 */
	static public function filter_options_list( $module_options, $module_id ) {

		$arr_out = array();

		foreach ( $module_options as $key => $option ) {

			$temp = $option;

			if ( preg_match( '/group_.*/', $option['type'] ) ) {

				$option = self::custom_groups_definition( $option );
			} else {

				$option = array( $option );
			}

			$arr_out = array_merge( $arr_out, $option );
		}

		return $arr_out;
	}

	/**
	 * Settings groups definition
	 *
	 * @param array $group_def group option.
	 * @return array
	 */
	static public function custom_groups_definition( $group_def ) {

		// Clear options to hide.
		self::$hide_options = array();

		$groups_list = array(
			/**
			 * Margin group definition
			 * array(
				'label' => __( 'Group margin H6', 'live-composer-page-builder' ),
				'id' => 'first_group',
				'type' => 'group_margin',
				'tab' => __( 'Some thing', 'live-composer-page-builder' ),
				'section' => 'styling',
				'affect_on_change_el' => '.dslc-button',
				'values' => array(
					'margin' => 'post_var_id1'
					'margin_top' => 'post_var_id2',
					'margin_left' => 'post_var_id3'
					'margin_bottom' => 'post_var_id4'
					'margin_right' => 'post_var_id5'
				),
				'prefix' => {HTML code},
				'postfix' => {HTML code}
			),
			 */
			'group_margin' => array(
				'fields' => array(
					array(
						'label' => __( 'Margin', 'live-composer-page-builder' ),
						'id' => 'margin',
						'min' => -1000,
						'max' => 1000,
						'increment' => 1,
						'std' => 0,
						'css_class' => 'group-margin-common',
						'type' => 'slider',
						'refresh_on_change' => false,
						'affect_on_change_rule' => 'margin',
						'ext' => 'px',
					),
					array(
						'label' => __( 'Margin Top', 'live-composer-page-builder' ),
						'id' => 'margin_top',
						'min' => -1000,
						'max' => 1000,
						'increment' => 1,
						'std' => 0,
						'type' => 'slider',
						'css_class' => 'group-margin-top',
						'refresh_on_change' => false,
						'affect_on_change_rule' => 'margin-top',
						'ext' => 'px',
					),
					array(
						'label' => __( 'Margin Right', 'live-composer-page-builder' ),
						'id' => 'margin_right',
						'min' => -1000,
						'max' => 1000,
						'increment' => 1,
						'std' => 0,
						'type' => 'slider',
						'css_class' => 'group-margin-right',
						'refresh_on_change' => false,
						'affect_on_change_rule' => 'margin-right',
						'ext' => 'px',
					),
					array(
						'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
						'id' => 'margin_bottom',
						'min' => -1000,
						'max' => 1000,
						'increment' => 1,
						'std' => 0,
						'css_class' => 'group-margin-bottom',
						'type' => 'slider',
						'refresh_on_change' => false,
						'affect_on_change_rule' => 'margin-bottom',
						'ext' => 'px',
					),
					array(
						'label' => __( 'Margin Left', 'live-composer-page-builder' ),
						'id' => 'margin_left',
						'min' => -1000,
						'max' => 1000,
						'increment' => 1,
						'std' => 0,
						'css_class' => 'group-margin-left',
						'type' => 'slider',
						'refresh_on_change' => false,
						'affect_on_change_rule' => 'margin-left',
						'ext' => 'px',
					),
				),
				'postfix' => '<div class="lc-option-group-margin-locker"><i class="group-margin-lock-icon dslc-icon-unlock" aria-hidden="true"></i></div></div>',
				'prefix' => '<div class="lc-option-group-margin-wrapper group-unlocked">',
			),
		);

		$out_group = array();

		if ( ! empty( $groups_list[ $group_def['type'] ] ) ) {

			$group = $groups_list[ $group_def['type'] ];

			foreach ( $group['fields'] as $option ) {

				if ( ! is_array( $option ) ) {

					continue;
				}

				// Change old & new values.
				self::move_values_post( $group_def, $option );

				if ( isset( $group_def['values'] ) && ! empty( $group_def['values'][ $option['id'] ] ) ) {

					self::$hide_options[ $option['id'] . '_' . $group_def['id'] ] = $group_def['values'][ $option['id'] ];
				}

				$option['id'] = $option['id'] . '_' . $group_def['id'];
				$option['tab'] = $group_def['tab'];
				$option['section'] = $group_def['section'];
				$option['group_label'] = $group_def['label'];
				$option['group_id'] = $group_def['id'];
				$option['group_type'] = $group_def['type'];
				$option['affect_on_change_el'] = $group_def['affect_on_change_el'];
				$option['prefix'] = isset( $group['prefix'] ) ? $group['prefix'] : '';
				$option['postfix'] = isset( $group['postfix'] ) ? $group['postfix'] : '';

				$out_group[] = $option;
			}
		}

		return $out_group;
	}

	/**
	 * Move option values in POST-array
	 *
	 * @param  array $group_def defines group.
	 * @param  array $option  defines option array.
	 */
	static public function move_values_post( $group_def, $option ) {

		if ( (
				! isset( $_POST[ $option['id'] . '_' . $group_def['id'] ] ) || (
					isset( $group_def['values'] ) && isset( $group_def['values'][ $option['id'] ] ) &&
					! empty( $_POST[ $group_def['values'][ $option['id'] ] ] )
					)
				) &&
			isset( $group_def['values'] ) &&
			! empty( $group_def['values'][ $option['id'] ] )
		 )  {

			$_POST[ $option['id'] . '_' . $group_def['id'] ] = $_POST[ $group_def['values'][ $option['id'] ] ];
			$_POST[ $group_def['values'][ $option['id'] ] ] = '';
		}
	}

	/**
	 * Update custom fields values with old ones
	 *
	 * @param $_POST
	 */
	public static function update_custom_fields() {

	}
}

LC_Custom_Settings_Fields::init();
