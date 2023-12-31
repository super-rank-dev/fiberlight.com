<?php

/**
 * A class for adding non-removable hooks to prevent saving of credit card details.
 *
 * Sorry, but these numbers don't belong in WordPress database.
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
class Qcformbuilder_Forms_Field_Credit {

	/**
	 * Qcformbuilder_Forms_Field_Credit constructor.
	 *
	 * Adds hooks
	 *
	 * @since 1.5.0
	 *
	 */
	public function __construct() {
		add_filter( 'qcformbuilder_forms_save_field_credit_card_number', array( $this, 'credit_card_number' ) );
		add_filter( 'qcformbuilder_forms_save_field_credit_card_cvc', array( $this, 'credit_card_cvc' ) );
	}

	/**
	 * Replace all but last 4 of credit card with Xs
	 *
	 * @uses "qcformbuilder_forms_save_field_credit_card_number" filter.
	 *
	 * @since 1.5.0
	 *
	 * @param string $number Credit card number
	 *
	 * @return string
	 */
	public function credit_card_number( $number ){
		return  substr_replace($number, str_repeat('X', strlen( $number ) - 4), 0, strlen( $number ) - 4);
	}

	/**
	 * Replace credit card secret code with Xs
	 *
	 * @uses "qcformbuilder_forms_save_field_credit_card_cvc"
	 *
	 * @since 1.5.0
	 *
	 * @param string $number Secret code
	 *
	 * @return string
	 */
	public function credit_card_cvc( $number ){
		return str_repeat('X', strlen( $number ) );
	}

}