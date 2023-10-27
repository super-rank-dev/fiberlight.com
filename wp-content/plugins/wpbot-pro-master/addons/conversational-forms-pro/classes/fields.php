<?php
/**
 * Access to field definitions
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
class Qcformbuilder_Forms_Fields {

	/**
	 * Get all field definitions
	 *
	 * @since 1.5.0
	 *
	 * @return array
	 */
	public static function get_all() {

		/**
		 * Register or remove field types
		 *
		 * @since unknown
		 *
		 * @param array $field_types Field types
		 */
		$field_types = apply_filters( 'qcformbuilder_forms_get_field_types', self::internal_types() );


		if ( ! empty( $field_types ) ) {
			foreach ( $field_types as $fieldType => $fieldConfig ) {
				// check for a viewer
				if ( isset( $fieldConfig[ 'viewer' ] ) ) {
					add_filter( 'qcformbuilder_forms_view_field_' . $fieldType, $fieldConfig[ 'viewer' ], 10, 3 );
				}
			}
		}

		return $field_types;

	}

	/**
	 * Get definition of one field
	 *
	 * @since 1.5.0
	 *
	 * @param string $type Field type
	 *
	 * @return array
	 */
	public static function definition( $type ){
		$fields = self::get_all();
		if( array_key_exists( $type, $fields ) ){
			return $fields[ $type ];
		}

		return array();

	}

	/**
	 * Check if a field definition has defined a specific "not support" argument
	 *
	 * Use to check if field of $type does $not_support
	 *
	 * @since 1.5.0
	 *
	 * @param string $type The field type
	 * @param string $not_support The not support argument, for example "entry_list"
	 *
	 * @return bool|null True if not supported, false if not not supported. Null if invalid field type
	 */
	public static function not_support( $type, $not_support ){
		$field = self::definition( $type );
		if( ! empty( $field ) ){
			if( ! isset( $field[ 'setup' ], $field[ 'setup' ][ 'not_supported' ] )  ){
				return false;
			}
			if( ! empty(  $field[ 'setup' ][ 'not_supported' ] ) &&  in_array( $not_support, $field[ 'setup' ][ 'not_supported' ] )  ){
				return true;
			}

			return false;
		}

		return null;

	}

	/**
	 * Get internal field types without filter
	 *
	 * @since 1.5.0
	 *
	 * @return array
	 */
	public static function internal_types() {
		$deprecated = __( 'Discontinued', 'qcformbuilder-forms' );
		$internal_fields = array(
			//basic
			'text'             => array(
				"field"       => __( 'Simple Text', 'qcformbuilder-forms' ),
				"description" => __( 'Simple Text', 'qcformbuilder-forms' ),
				"file"        => WFBCORE_PATH . "fields/generic-input.php",
				"category"    => __( 'Basic', 'qcformbuilder-forms' ),
				"setup"       => array(
					"template" => WFBCORE_PATH . "fields/text/config.php",
					"preview"  => WFBCORE_PATH . "fields/text/preview.php"
				),

			),
			
			'hidden'           => array(
				"field"       => __( 'Hidden', 'qcformbuilder-forms' ),
				"description" => __( 'Hidden', 'qcformbuilder-forms' ),
				"file"        => WFBCORE_PATH . "fields/hidden/field.php",
				"category"    => __( 'Basic', 'qcformbuilder-forms' ),
				"static"      => true,
				"setup"       => array(
					"preview"       => WFBCORE_PATH . "fields/hidden/preview.php",
					"template"      => WFBCORE_PATH . "fields/hidden/setup.php",
					"not_supported" => array(
						'hide_label',
						'caption',
						'required',
					)
				)
			),
			
			'email'            => array(
				"field"       => __( 'Email Address', 'qcformbuilder-forms' ),
				"description" => __( 'Email Address', 'qcformbuilder-forms' ),
				'icon'          => WFBCORE_URL . 'assets/build/images/envelope-o.svg',
				"file"        => WFBCORE_PATH . "fields/generic-input.php",
				"category"    => __( 'Basic', 'qcformbuilder-forms' ),
				"setup"       => array(
					"preview"  => WFBCORE_PATH . "fields/email/preview.php",
					"template" => WFBCORE_PATH . "fields/email/config.php"
				)
			),

			'number'            => array(
				"field"       => __( 'Number', 'qcformbuilder-forms' ),
				"description" => __( 'Number', 'qcformbuilder-forms' ),
				"file"        => WFBCORE_PATH . "fields/generic-input.php",
				"category"    => __( 'Basic', 'qcformbuilder-forms' ),
				"setup"       => array(
					"preview"  => WFBCORE_PATH . "fields/number/preview.php",
					"template" => WFBCORE_PATH . "fields/number/config.php"
				)
			),

			'phone'            => array(
				"field"       => __( 'Phone Number (Basic)', 'qcformbuilder-forms' ),
				"description" => __( 'Format: (999)999-9999', 'qcformbuilder-formss' ),
				'icon'          => WFBCORE_URL . 'assets/build/images/volume-control-phone.svg',
				"file"        => WFBCORE_PATH . "fields/generic-input.php",
				"category"    => __( 'Basic', 'qcformbuilder-forms' ),
				"setup"       => array(
					"template" => WFBCORE_PATH . "fields/phone/config.php",
					"preview"  => WFBCORE_PATH . "fields/phone/preview.php",
					"default"  => array(
						'default' => '',
						'type'    => 'local',
						'custom'  => '(999)999-9999'
					)
				)
			),
			
			'url'            => array(
				"field"       => __( 'URL', 'qcformbuilder-forms' ),
				'icon'          => WFBCORE_URL . 'assets/build/images/chain.svg',
				"description" => __( 'URL input for website addresses', 'qcformbuilder-forms' ),
				"file"        => WFBCORE_PATH . "fields/generic-input.php",
				"category"    => __( 'Basic', 'qcformbuilder-forms' ),
				"setup"       => array(
					"preview"  => WFBCORE_PATH . "fields/url/preview.php",
					"template" => WFBCORE_PATH . "fields/url/config.php"
				)
			),
			
			'calculation'      => array(
				"field"       => __( 'Calculation', 'qcformbuilder-forms' ),
				"file"        => WFBCORE_PATH . "fields/calculation/field.php",
				"handler"     => array( Qcformbuilder_Forms::get_instance(), "run_calculation" ),
				'icon'          => WFBCORE_URL . 'assets/build/images/calculator.svg',
				"category"    => __( 'Basic', 'qcformbuilder-forms' ),
				"description" => __( 'Calculate values', 'qcformbuilder-forms' ),
				"setup"       => array(
					"template" => WFBCORE_PATH . "fields/calculation/config.php",
					"preview"  => WFBCORE_PATH . "fields/calculation/preview.php",
					"default"  => array(
						'element' => 'h3',
						'classes' => 'total-line',
						'before'  => __( 'Total', 'qcformbuilder-forms' ) . ':',
						'after'   => ''
					),

				),
			),
			
			'file'             => array(
				"field"       => __( 'File', 'qcformbuilder-forms' ),
				"description" => __( 'Basic HTML5 File Uploader', 'qcformbuilder-forms' ),
				"file"        => WFBCORE_PATH . "fields/file/field.php",
				'icon'          => WFBCORE_URL . 'assets/build/images/cloud-upload.svg',
				"viewer"      => array( Qcformbuilder_Forms::get_instance(), 'handle_file_view' ),
				"category"    => __( 'File', 'qcformbuilder-forms' ),
				"setup"       => array(
					"preview"  => WFBCORE_PATH . "fields/file/preview.php",
					"template" => WFBCORE_PATH . "fields/file/config_template.php"
				)
			),
			
			//content
			'html'             => array(
				"field"       => __( 'HTML', 'qcformbuilder-forms' ),
				"description" => __( 'Add text/html content', 'qcformbuilder-forms' ),
				"file"        => WFBCORE_PATH . "fields/html/field.php",
				"category"    => __( 'Content', 'qcformbuilder-forms' ),
				"icon"        => WFBCORE_URL . "fields/html/icon.png",
				"capture"     => false,
				"setup"       => array(
					"preview"       => WFBCORE_PATH . "fields/html/preview.php",
					"template"      => WFBCORE_PATH . "fields/html/config_template.php",
					"not_supported" => array(
						'hide_label',
						'caption',
						'required',
						'entry_list'
					)
				)
			),

			//select
			'dropdown'         => array(
				"field"       => __( 'Select Option', 'qcformbuilder-forms' ),
				"description" => __( 'Display Options as button', 'qcformbuilder-forms' ),
				'icon'          => WFBCORE_URL . 'assets/build/images/plus.svg',
				"file"        => WFBCORE_PATH . "fields/dropdown/field.php",
				"category"    => __( 'Select', 'qcformbuilder-forms' ),
				"options"     => "single",
				"static"      => true,
				"viewer"      => array( Qcformbuilder_Forms::get_instance(), 'filter_options_calculator' ),
				"setup"       => array(
					"template" => WFBCORE_PATH . "fields/dropdown/config_template.php",
					"preview"  => WFBCORE_PATH . "fields/dropdown/preview.php",
					"default"  => array(),
				)
			),
			
			'checkbox'         => array(
				"field"       => __( 'Checkbox', 'qcformbuilder-forms' ),
				"description" => __( 'Checkbox', 'qcformbuilder-forms' ),
				'icon'          => WFBCORE_URL . 'assets/build/images/plus.svg',
				"file"        => WFBCORE_PATH . "fields/checkbox/field.php",
				"category"    => __( 'Select', 'qcformbuilder-forms' ),
				"options"     => "multiple",
				"static"      => true,
				"viewer"      => array( Qcformbuilder_Forms::get_instance(), 'filter_options_calculator' ),
				"setup"       => array(
					"preview"  => WFBCORE_PATH . "fields/checkbox/preview.php",
					"template" => WFBCORE_PATH . "fields/checkbox/config_template.php",

				),
			),
			
			'date_picker'      => array(
				"field"       => __( 'DateTime Picker', 'qcformbuilder-forms' ),
				"description" => __( 'DateTime Picker', 'qcformbuilder-forms' ),
				'icon'          => WFBCORE_URL . 'assets/build/images/plus.svg',
				"file"        => WFBCORE_PATH . "fields/date_picker/datepicker.php",
				"category"    => __( 'Select', 'qcformbuilder-forms' ),
				"setup"       => array(
					"preview"  => WFBCORE_PATH . "fields/date_picker/preview.php",
					"template" => WFBCORE_PATH . "fields/date_picker/setup.php",
					"default"  => array(
						'format' => 'yyyy-mm-dd'
					),
				),
				"styles"     => array(
					WFBCORE_URL . "fields/date_picker/css/datepicker.css",
				),
				"scripts"      => array(
					WFBCORE_URL . "fields/date_picker/wfb-datepicker.js",
				)
			),


		);

		return $internal_fields;
	}

}
