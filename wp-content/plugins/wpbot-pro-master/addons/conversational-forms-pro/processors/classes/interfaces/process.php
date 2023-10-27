<?php

/**
 * Interface that all form processor add-ons should implement
 *
 * @package   Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
interface Qcformbuilder_Forms_Processor_Interface_Process {

	/**
	 * Validate the process if possible, and if not return errors.
	 *
	 * @since 1.3.5.3
	 *
	 * @param array $config Processor config
	 * @param array $form Form config
	 * @param string $proccesid Unique ID for this instance of the processor
	 *
	 * @return array Return if errors, do not return if not
	 */
	public function pre_processor( array $config, array $form, $proccesid );

	/**
	 * If validate do processing
	 *
	 * @since 1.3.5.3
	 *
	 * @param array $config Processor config
	 * @param array $form Form config
	 * @param string $proccesid Process ID
	 *
	 * @return array Return meta data to save in entry
	 */
	public function processor( array $config, array $form, $proccesid );

	/**
	 * Get fields for processor
	 *
	 * @since 1.3.5.3
	 *
	 * @return array
	 */
	public function fields();
}
