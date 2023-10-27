<?php

/**
 * Base class for adding auto-populate options to select fields
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
abstract class Qcformbuilder_Forms_Admin_APSetup implements  Qcformbuilder_Forms_Admin_APSetupInterface {

	/**
	 * Qcformbuilder_Forms_Admin_APSetup constructor.
	 *
	 * @since 1.4.3
	 */
	public function __construct() {
		$this->add_hooks();
	}

	/**
	 * Add hooks
	 *
	 * @since 1.4.3
	 */
	protected function add_hooks(){
		add_action( 'qcformbuilder_forms_autopopulate_types', array( $this, 'add_type' ) );
		add_action( 'qcformbuilder_forms_autopopulate_type_config', array( $this, 'add_options' ) );
	}

	/**
	 * Remove hooks
	 *
	 * @since 1.4.3
	 */
	public function remove_hooks(){
		remove_action( 'qcformbuilder_forms_autopopulate_types', array( $this, 'add_type' ) );
		remove_action( 'qcformbuilder_forms_autopopulate_type_config', array( $this, 'add_options' ) );
	}


}