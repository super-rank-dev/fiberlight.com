<?php

/**
 * Class Qcformbuilder_Forms_Admin_Privacy
 *
 * Sets up privacy related fields in form editor
 */
class Qcformbuilder_Forms_Admin_Privacy{
	/**
	 * Fields to output the personally identifying info checkbox on
	 *
	 * @since 1.6.1
	 *
	 * @var array
	 */
	private $fields_to_show_personally_identifying_question;

	/**
	 * Form config
	 *
	 * @since 1.6.1
	 *
	 * @var array
	 */
	protected $form;

	/**
	 * Qcformbuilder_Forms_Admin_Privacy constructor.
	 *
	 * @since 1.6.1
	 *
	 * @param array $form
	 */
	public function __construct( array  $form )
	{
		$this->form = $form;

	}

	/**
	 * Output the field template for the privacy field as needed
	 *
	 * @since 1.6.1
	 *
	 * @uses "qcformbuilder_forms_field_wrapper_before_field_setup" action
	 *
	 * @param array $config Field config's config
	 * @param string $type Field Type
	 * @param string $field_id Field ID
 	 */
	public function add_personally_identifying_question($config, $type, $field_id ){
		if(in_array( $type, $this->fields_to_show_personally_identifying_question() )){
			$id_attr = $field_id . '_' . Qcformbuilder_Forms_Field_Util::CONFIG_PERSONAL;
			$description_id_attr = $id_attr . '_description';
			$is_personally_identifying = Qcformbuilder_Forms_Field_Util::is_personally_identifying($field_id, $this->form );
			/* translators: it's abbreviation for Personally Identifying Information */
			$pii_text = esc_html__( 'PII', 'qcformbuilder-forms' );
			printf( '
				<div class="qcformbuilder-config-group privacy-field personally-identifying-field">
					<label for="%s">
						%s
					</label>
					<div class="qcformbuilder-config-field">
						<input 
							type="checkbox" 
							class="field-config field-checkbox"
							id="%s"
							name="%s"
							value="1"
							aria-describedby="%s"
							%s
						/>
						<p id="%s" class="description">
							%s			
						</p>
					</div>
				</div>
			',
				esc_attr( $id_attr ),
				$pii_text,
				esc_attr( $id_attr ),
				sprintf( 'config[fields][%s][config][%s]',
					esc_attr($field_id),
					esc_attr( Qcformbuilder_Forms_Field_Util::CONFIG_PERSONAL )
				),
				esc_attr($description_id_attr),
				$is_personally_identifying ? 'checked=checked' : '',
				esc_attr($description_id_attr),
				sprintf( '%s <a href="%s" target="_blank">%s</a>',
					esc_html__( 'Does field contain Personally Identifying Information (PII)?', 'qcformbuilder-forms' ),
					'https://quantumcloud.com/gdpr#pii?utm_source=wp-admin&utm_medium=form-editor&utm_content=pii-learn-more',
					esc_html__( 'Learn More', 'qcformbuilder-forms' )
				)
			);
		}
	}

	/**
	 * Get the fields to show privacy field on
	 *
	 * Lazy-sets the $fields_to_show_personally_identifying_question property
	 *
	 * @since 1.6.1
	 *
	 * @return array
	 */
	protected function fields_to_show_personally_identifying_question(){
		if( ! $this->fields_to_show_personally_identifying_question ){
			$this->fields_to_show_personally_identifying_question = array();

			foreach( Qcformbuilder_Forms_Fields::get_all() as $field_type => $field_config ){
				if ( Qcformbuilder_Forms_Fields::not_support( $field_type, 'entry_list' ) ){
					continue;
				}
				if( in_array( $field_type, array( 'recaptcha', 'gdpr' ) ) ){
					continue;
				}
				$this->fields_to_show_personally_identifying_question[] = $field_type;
			}

		}

		return $this->fields_to_show_personally_identifying_question;
	}
}