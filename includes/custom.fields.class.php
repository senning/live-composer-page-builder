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

					/**
					 * Hardcoded values - true & false.
					 */
					array(
						'label' => __( 'Show extended margins', 'live-composer-page-builder' ),
						'id' => 'show_ext_margins',
						'std' => 'true',
						'type' => 'toggle_controls',
						'dependent_controls' => array(

							'true' => 'margin_left, margin_bottom, margin_right, margin_top',
							'false' => 'margin',
						),
						'refresh_on_change' => false,
					),
					array(
						'label' => __( 'All Sides', 'live-composer-page-builder' ),
						'id' => 'margin',
						'min' => -1000,
						'max' => 1000,
						'increment' => 1,
						'std' => 0,
						'css_class' => 'group-margin-common',
						'type' => 'slider',
						'refresh_on_change' => false,
						'affect_on_change_rule' => 'norule', // Control elements rule only with separate options.
						'ext' => 'px',
					),
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
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
						'label' => __( 'Right', 'live-composer-page-builder' ),
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
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
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
						'label' => __( 'Left', 'live-composer-page-builder' ),
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
				'icon' => 'cube',
				'prefix' => '<div class="lc-option-group-margin-wrapper">',
				'postfix' => '</div>',
			),
			'group_padding' => array(
				'fields' => array(

					/**
					 * Hardcoded values - true & false.
					 */
					array(
						'label' => __( 'Show extended paddings', 'live-composer-page-builder' ),
						'id' => 'show_ext_paddings',
						'std' => 'true',
						'type' => 'toggle_controls',
						'dependent_controls' => array(

							'true' => 'padding_left, padding_bottom, padding_right, padding_top',
							'false' => 'padding',
						),
						'refresh_on_change' => false,
					),
					array(
						'label' => __( 'All Sides', 'live-composer-page-builder' ),
						'id' => 'padding',
						'min' => -1000,
						'max' => 1000,
						'increment' => 1,
						'std' => 0,
						'css_class' => 'group-padding-common',
						'type' => 'slider',
						'refresh_on_change' => false,
						'affect_on_change_rule' => 'norule', // Control elements rule only with separate options.
						'ext' => 'px',
					),
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'id' => 'padding_top',
						'min' => -1000,
						'max' => 1000,
						'increment' => 1,
						'std' => 0,
						'type' => 'slider',
						'css_class' => 'group-padding-top',
						'refresh_on_change' => false,
						'affect_on_change_rule' => 'padding-top',
						'ext' => 'px',
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'id' => 'padding_right',
						'min' => -1000,
						'max' => 1000,
						'increment' => 1,
						'std' => 0,
						'type' => 'slider',
						'css_class' => 'group-padding-right',
						'refresh_on_change' => false,
						'affect_on_change_rule' => 'padding-right',
						'ext' => 'px',
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'id' => 'padding_bottom',
						'min' => -1000,
						'max' => 1000,
						'increment' => 1,
						'std' => 0,
						'css_class' => 'group-padding-bottom',
						'type' => 'slider',
						'refresh_on_change' => false,
						'affect_on_change_rule' => 'padding-bottom',
						'ext' => 'px',
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'id' => 'padding_left',
						'min' => -1000,
						'max' => 1000,
						'increment' => 1,
						'std' => 0,
						'css_class' => 'group-padding-left',
						'type' => 'slider',
						'refresh_on_change' => false,
						'affect_on_change_rule' => 'padding-left',
						'ext' => 'px',
					),
				),
				'icon' => 'cube',
				'prefix' => '<div class="lc-option-group-margin-wrapper">',
				'postfix' => '</div>',
			),
			'group_background' => array(
				'fields' => array(

					/**
					 * Hardcoded values - true & false.
					 */
					array(
						'label' => __( 'Show extended back', 'live-composer-page-builder' ),
						'id' => 'show_ext_backs',
						'std' => 'true',
						'type' => 'toggle_controls',
						'dependent_controls' => array(

							'true' => 'css_bg_img, css_bg_img_repeat, css_bg_img_pos, css_bg_img_attch',
						),
						'refresh_on_change' => false,
					),
					array(
						'label' => __( 'BG Color', 'live-composer-page-builder' ),
						'id' => 'bg_color',
						'std' => '',
						'type' => 'color',
						'refresh_on_change' => false,
						'affect_on_change_rule' => 'background-color',
					),
					array(
						'label' => __( 'BG Image', 'live-composer-page-builder' ),
						'id' => 'css_bg_img',
						'std' => '',
						'type' => 'image',
						'refresh_on_change' => false,
						'affect_on_change_rule' => 'background-image',
					),
					array(
						'label' => __( 'BG Image Repeat', 'live-composer-page-builder' ),
						'id' => 'css_bg_img_repeat',
						'std' => 'repeat',
						'type' => 'select',
						'choices' => array(
							array(
								'label' => __( 'Repeat', 'live-composer-page-builder' ),
								'value' => 'repeat',
							),
							array(
								'label' => __( 'Repeat Horizontal', 'live-composer-page-builder' ),
								'value' => 'repeat-x',
							),
							array(
								'label' => __( 'Repeat Vertical', 'live-composer-page-builder' ),
								'value' => 'repeat-y',
							),
							array(
								'label' => __( 'Do NOT Repeat', 'live-composer-page-builder' ),
								'value' => 'no-repeat',
							),
						),
						'refresh_on_change' => false,
						'affect_on_change_rule' => 'background-repeat',
					),
					array(
						'label' => __( 'BG Image Attachment', 'live-composer-page-builder' ),
						'id' => 'css_bg_img_attch',
						'std' => 'scroll',
						'type' => 'select',
						'choices' => array(
							array(
								'label' => __( 'Scroll', 'live-composer-page-builder' ),
								'value' => 'scroll',
							),
							array(
								'label' => __( 'Fixed', 'live-composer-page-builder' ),
								'value' => 'fixed',
							),
						),
						'refresh_on_change' => false,
						'affect_on_change_rule' => 'background-attachment',
					),
					array(
						'label' => __( 'BG Image Position', 'live-composer-page-builder' ),
						'id' => 'css_bg_img_pos',
						'std' => 'top left',
						'type' => 'select',
						'choices' => array(
							array(
								'label' => __( 'Top Left', 'live-composer-page-builder' ),
								'value' => 'left top',
							),
							array(
								'label' => __( 'Top Right', 'live-composer-page-builder' ),
								'value' => 'right top',
							),
							array(
								'label' => __( 'Top Center', 'live-composer-page-builder' ),
								'value' => 'Center Top',
							),
							array(
								'label' => __( 'Center Left', 'live-composer-page-builder' ),
								'value' => 'left center',
							),
							array(
								'label' => __( 'Center Right', 'live-composer-page-builder' ),
								'value' => 'right center',
							),
							array(
								'label' => __( 'Center', 'live-composer-page-builder' ),
								'value' => 'center center',
							),
							array(
								'label' => __( 'Bottom Left', 'live-composer-page-builder' ),
								'value' => 'left bottom',
							),
							array(
								'label' => __( 'Bottom Right', 'live-composer-page-builder' ),
								'value' => 'right bottom',
							),
							array(
								'label' => __( 'Bottom Center', 'live-composer-page-builder' ),
								'value' => 'center bottom',
							),
						),
						'refresh_on_change' => false,
						'affect_on_change_rule' => 'background-position',
					),
				),
				'icon' => 'cube',
				'prefix' => '<div class="lc-option-group-margin-wrapper">',
				'postfix' => '</div>',
			),
		);

		// Add third-party groups to groups list.
		$groups_list = apply_filters( 'dslc_filter_grouped_controls', $groups_list );

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
				$option['group_icon'] = $group['icon'];

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
