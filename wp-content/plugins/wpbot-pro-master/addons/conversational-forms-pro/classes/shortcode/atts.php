<?php

/**
 * Filters shortcode attributes
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 QcformbuilderWP LLC
 */
class Qcformbuilder_Forms_Shortcode_Atts {

	/**
	 * Setup field defaults form shortocde attributes
	 *
	 * @since 1.5.0.7
	 *
	 * @uses "shortcode_atts_qcformbuilder_form" filter
	 * @uses "shortcode_atts_qcformbuilder_form_modal" filter
	 *
	 * @param array $out
	 * @param array $pairs
	 * @param array $atts
	 * @param string $shortcode
	 *
	 * @return array
	 */
	public static function allow_default_set( $out, $pairs, $atts, $shortcode ){
		$form = array();
		if ( isset( $atts[ 'id' ] ) ) {
			$form = Qcformbuilder_Forms_Forms::get_form( $atts[ 'id' ] );

		}

		if ( empty( $form ) && isset( $atts[ 'ID' ] ) ) {
			$form = Qcformbuilder_Forms_Forms::get_form( $atts[ 'ID' ] );

		}

		if ( empty( $form ) && isset( $form[ 'name' ] ) ) {
			$form = Qcformbuilder_Forms_Forms::get_form( $atts[ 'name' ] );
		}

		$defaults = array();

		if( ! empty( $form ) ){
			$fields = Qcformbuilder_Forms_Forms::get_fields( $form );
			$field_ids = array_keys( $fields );

			if( ! empty( $field_ids ) ){
				foreach ( $atts as $att => $value ){
					if( in_array( $att, $field_ids ) ){
						$defaults[ $att ] = $value;
						$out[ $att ] = $value;
					}
				}
			}
		}

		if( ! empty( $defaults ) ){
			$obj = new Qcformbuilder_Forms_Shortcode_Defaults( $form[ 'ID' ], $defaults );
			$obj->add_hooks();
			add_action( 'qcformbuilder_forms_render_end', array( $obj, 'remove_hooks' ) );

		}

		return $out;

	}

	/**
	 * Whitleist revision shortcode arg if user has permissions
	 *
	 * @since 1.5.3
	 *
	 * @uses "shortcode_atts_qcformbuilder_form" filter
	 * @uses "shortcode_atts_qcformbuilder_form_modal" filter
	 *
	 * @param array $out
	 * @param array $pairs
	 * @param array $atts
	 * @param string $shortcode
	 *
	 * @return array
	 */
	public static  function  maybe_allow_revision(  $out, $pairs, $atts, $shortcode ){
		if( current_user_can( Qcformbuilder_Forms::get_manage_cap( 'admin' ) ) ){
			if( isset( $atts[ 'revision' ] ) ){
				$out[  'revision' ] = $atts[ 'revision' ];
			}
		}

		return $out;
	}

}