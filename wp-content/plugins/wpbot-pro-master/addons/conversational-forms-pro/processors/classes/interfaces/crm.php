<?php

/**
 * Interface that CRM add-ons should implement
 *
 * @package   Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
interface Qcformbuilder_Forms_Processor_Interface_CRM extends Qcformbuilder_Forms_Processor_Interface_Process {

	/**
	 * Update CRM Records using an Email Address as the lookup key
	 *
	 * @since 1.5.1
	 *
	 * @param string $email The e-mail address to lookup in the CRM
	 * @param array $form_data An array containing the fields to be updated
	 *
	 * @return mixed
	 */
	public function update_by_email( $email, array $form_data );

}
