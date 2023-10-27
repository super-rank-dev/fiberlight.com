<?php

/**
 * Interface that payment processor add-ons should implement
 *
 * @package   Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
interface Qcformbuilder_Forms_Processor_Interface_Payment {
	/**
	 * Do Payment
	 *
	 * @since 1.3.5.3
	 *
	 * @param array $config Processor config
	 * @param array $form Form config
	 * @param string $proccesid Unique ID for this instance of the processor
	 * @param Qcformbuilder_Forms_Processor_Get_Data $data_object Processor data
	 *
	 * @return Qcformbuilder_Forms_Processor_Get_Data
	 */
	public function do_payment( array $config, array $form, $proccesid, Qcformbuilder_Forms_Processor_Get_Data $data_object );
}
