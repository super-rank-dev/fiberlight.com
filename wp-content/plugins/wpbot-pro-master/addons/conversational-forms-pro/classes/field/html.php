<?php
/**
 * Base class for creating field element HTML
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
abstract  class Qcformbuilder_Forms_Field_HTML   {


	/**
	 * Create HTML form the field element (not the wrapper)
	 *
	 * This must be ovveriden in subclass
	 *
	 * @since 1.5.0
	 *
	 * @param array $field Field config
	 * @param array $field_structure Prepared field structure
	 * @param array $form Form config
	 *
	 * @return string
	 */
	public static function html( array $field, array $field_structure,array $form ){
		return '';
	}

	/**
	 * Create the aria attributes string
	 *
	 * @since 1.5.0
	 *
	 * @param array $field_structure Prepared field structure
	 *
	 * @return string
	 */
	protected static function aria_string( $field_structure ){
		if( is_string( $field_structure[ 'aria' ] ) ){
			return $field_structure[ 'aria' ];
		}elseif ( ! empty( $field_structure[ 'aria' ] ) ) {
			$attrs = qcformbuilder_forms_escape_field_attributes_array( $field_structure[ 'aria' ], 'aria-' );
			return qcformbuilder_forms_implode_field_attributes( $attrs );
		}

		return '';
	}


	/**
	 * Get placeholder string for field
	 *
	 * @since 1.5.0
	 *
	 * @param array $field Field config
	 * @param string $placeholder Optional. Ovveride for field's configured placeholder
	 *
	 * @return string
	 */
	protected static function place_holder_string( array  $field, $placeholder = '' ){
		if( empty( $placeholder ) && (   ! empty( $field[ 'config' ][ 'placeholder' ] ) || ( isset(  $field[ 'config' ][ 'placeholder' ] ) && is_numeric( $field[ 'config' ][ 'placeholder' ] ) ) )  ){
			$placeholder = $field[ 'config' ][ 'placeholder' ];
		}

		if ( ! empty( $placeholder ) || is_numeric( $placeholder ) ) {
			return 'placeholder="' . esc_attr( Qcformbuilder_Forms::do_magic_tags( $placeholder ) ) . '"';
		}

		return '';

	}

	/**
	 * Get field default value
	 *
	 * @since 1.5.0
	 *
	 * @param array $field
	 * @param array $form
	 *
	 * @return mixed
	 */
	public static function find_default( array $field, array $form ) {
		if ( isset( $field[ 'slug' ] ) && isset( $_GET[ $field[ 'slug' ] ] ) ) {
			$default = Qcformbuilder_Forms_Sanitize::sanitize( $_GET[ $field[ 'slug' ] ] );
		}elseif ( isset( $field[ 'config' ][ 'default' ] ) ){
			$default = Qcformbuilder_Forms::do_magic_tags( $field[ 'config' ][ 'default' ], null, $form );
		}else{
			$default = '';
		}

		return $default;
	}



}