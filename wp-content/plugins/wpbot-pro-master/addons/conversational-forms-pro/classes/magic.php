<?php
/**
 * Main class for magic tag parsing (or will be someday)
 *
 * @package   Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 QcformbuilderWP LLC
 */
class Qcformbuilder_Forms_Magic {

	/**
	 * Qcformbuilder_Forms_Magic constructor.
	 *
	 * @since 1.5.0
	 */
	public function __construct() {
		add_filter( 'qcformbuilder_forms_pre_do_field_magic', array( $this, 'field_magic' ), 10,  5 );

	}


	/**
	 * Add special magic tags
	 *
	 * @uses "qcformbuilder_forms_pre_do_field_magic"
	 *
	 * @since 1.5.0
	 *
	 * @param $_value
	 * @param $value
	 * @param $matches
	 * @param $entry_id
	 * @param $form
	 *
	 * @return mixed
	 */
	public function field_magic( $_value, $value, $matches, $entry_id, $form ){
		if( empty( $form ) ){
			global  $form;
		}

		if( ! empty( $matches ) && ! empty( $matches[1] ) && ! empty( $matches[1][0]) ){

			//Set default $form value to be an empty array (prevents option labels that use magic tags to break entry viewer)
			if ( $form === null ){
				$form = array();
			}

			if ( Qcformbuilder_Forms_Field_Util::has_field_type( 'credit_card_exp', $form ) ) {
				$split = Qcformbuilder_Forms_Magic_Util::split_tags( $matches[1][0] );
				if( is_array( $split ) && ! empty( $split[1] ) && in_array( $split[1], array( 'month', 'year' ) ) ){
					$field = Qcformbuilder_Forms_Field_Util::get_field_by_slug( $split[0], $form );
					$type = Qcformbuilder_Forms_Field_Util::get_type( $field, $form );
					if ( 'credit_card_exp' == $type ) {
						$_value = $this->expiration_magic( $value, $matches, $entry_id, $form );
					}
				}

			}

		}

		return $_value;

	}

	/**
	 * Allows use of %field_slug:year% and %field_slug"month% magic tags for credit card expiration fields
	 *
	 * @since 1.5.0
	 *
	 * @param string $value Content to act on
	 * @param array $matches Preg matches
	 * @param int $entry_id Entry ID
	 * @param array $form Form config
	 *
	 * @return mixed
	 */
	protected function expiration_magic( $value, $matches, $entry_id, $form ) {
		$_value = '';
		foreach ( $matches[ 1 ] as $match ) {
			foreach (
				array(
					':year',
					':month'
				) as $semi
			) {
				if ( false !== strpos( $value, $semi ) ) {
					$split = Qcformbuilder_Forms_Magic_Util::split_tags( $match );
					$field = Qcformbuilder_Forms_Field_Util::get_field_by_slug( $split[ 0 ], $form );
					if ( ! empty( $field ) ) {
						$field_value = Qcformbuilder_Forms::get_field_data( $field[ 'ID' ], $form, $entry_id );
						if ( is_string( $field_value ) && false !== strpos( $field_value, '/' ) ) {
							$parts = explode( '/', $field_value );
							switch ( $semi ) {
								case ':year':
									$tag    = '%' . $field[ 'slug' ] . ':year' . '%';
									$_value = str_replace( $tag, trim( $parts[ 1 ] ), $value );
									break;
								case ':month':
									$tag    = '%' . $field[ 'slug' ] . ':month' . '%';
									$_value = str_replace( $tag, trim( $parts[ 0 ] ), $value );
									break;
							}
						}
					}
				}
			}
		}

		return $_value;
	}




}