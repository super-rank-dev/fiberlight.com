<?php

/**
 * Callbacks functions used to hook in and replace default mailer at "qcformbuilder_forms_mailer"
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
class Qcformbuilder_Forms_Email_Callbacks {

	/**
	 * Send email via SendGrid API
	 *
	 * @since 1.4.0
	 *
	 * @uses "qcformbuilder_forms_mailer"
	 *
	 * @param $mail
	 * @param $data
	 * @param $form
	 *
	 * @return mixed
	 */
	public static function sendgrid( $mail, $data, $form ){
		$client = new Qcformbuilder_Forms_Email_SendGrid( $mail );
		$key = Qcformbuilder_Forms_Email_Settings::get_key( 'sendgrid' );
		if ( ! empty( $key ) ) {
			$client->set_api( array( $key ) );
			$response = $client->send();
			if( in_array( $response, array( 202, 201, 200 ) ) ){
				Qcformbuilder_Forms_Save_Final::after_send_email( $form, $data, true, $mail[ 'csv' ], $mail, 'sendgrid' );
				//prevent send
				return null;
			}else{
				/**
				 * Action documented in Qcformbuilder_Forms_Save_Final::after_send_email()
				 */
				do_action( 'qcformbuilder_forms_mailer_failed', $mail, $data, $form, 'sendgrid' );
				//fallback to default
				return $mail;
			}
			
		}
		
	}
	
}
