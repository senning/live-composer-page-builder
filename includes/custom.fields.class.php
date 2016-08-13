<?php
/**
 * Class-container for custom options in settings panel
 */
class LC_Custom_Settings_Fields {

	/**
	 * Init actions.
	 * Filters methods with preg pattern, so future util
	 * functions won't mess up with custom fields output.
	 */
	static public function init() {

		add_filter( 'dslc_module_options', array( __CLASS__, 'filter_options_list' ), 1, 2 );
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

		$groups_list = array(
			/**
			 * Margin group definition
			 * array(
				'label' => __( 'Group margin H6', 'live-composer-page-builder' ),
				'id' => 'first_group',
				'type' => 'group_margin',
				'tab' => __( 'Some thing', 'live-composer-page-builder' ),
				'section' => 'styling',
				'affect_on_change_el' => '.dslc-button'
			),
			 */
			'group_margin' => array(
				array(
					'label' => __( 'Margin', 'live-composer-page-builder' ),
					'id' => 'margin',
					'min' => -1000,
					'max' => 1000,
					'increment' => 1,
					'std' => '15',
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
					'std' => '15',
					'type' => 'slider',
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
					'std' => '15',
					'type' => 'slider',
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
					'std' => '15',
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
					'std' => '15',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_rule' => 'margin-left',
					'ext' => 'px',
				),
			),
		);

		$out_group = array();

		if ( ! empty( $groups_list[ $group_def['type'] ] ) ) {

			$group = $groups_list[ $group_def['type'] ];

			foreach ( $group as $option ) {

				$option['id'] = $option['id'] . '_' . $group_def['id'];
				$option['tab'] = $group_def['tab'];
				$option['section'] = $group_def['section'];
				$option['group_label'] = $group_def['label'];
				$option['group_id'] = $group_def['id'];
				$option['group_type'] = $group_def['type'];
				$option['affect_on_change_el'] = $group_def['affect_on_change_el'];

				$out_group[] = $option;
			}
		}

		return $out_group;
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
