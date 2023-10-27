<?php

/**
 * Interface settings objects must implement
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 QcformbuilderWP LLC
 */
interface Qcformbuilder_Forms_Settings_Contract {

	/**
	 * Get name for setting
	 *
	 * @since 1.5.3
	 *
	 * @return string
	 */
	public function get_name();

}