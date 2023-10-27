<?php

/**
 * Initialize core settings
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 QcformbuilderWP LLC
 */
class Qcformbuilder_Forms_Settings_Init {

	/**
	 * Load core settings objects
	 *
	 * Called in Qcformbuilder_Forms constructor
	 *
	 * @since 1.5.3
	 */
	public static function load(){
		//Call the Qcformbuilder_Forms::setings() method to trigger "qcformbuilder_forms_settings_registered" action
		add_action( 'qcformbuilder_forms_core_init', array( 'Qcformbuilder_Forms', 'settings' ) );
		add_action( 'qcformbuilder_forms_settings_registered', array( __CLASS__, 'add_core_settings' ) );
		if( ! is_admin() ){
			add_action( 'qcformbuilder_forms_settings_registered', array( 'Qcformbuilder_Forms_CDN_Init', 'init' ), 15 );
		}
	}

	/**
	 * Register the core settings
	 *
	 * CDN
	 * Email (@todo)
	 * General (@todo)
	 *
	 * @uses "qcformbuilder_forms_settings_registered" action
	 *
	 * @since 1.5.3
	 */
	public static function add_core_settings(){
		Qcformbuilder_Forms::settings()->add( new Qcformbuilder_Forms_CDN_Settings() );
	}


}