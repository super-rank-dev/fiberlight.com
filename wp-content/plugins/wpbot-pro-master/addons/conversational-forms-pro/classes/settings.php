<?php


/**
 * Container for all settings
 *
 * Access main instance via Qcformbuilder_Forms::settings()
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 QcformbuilderWP LLC
 */
class Qcformbuilder_Forms_Settings {

	/**
	 * Stored settings object
	 *
	 * @since 1.5.3
	 *
	 * @var array
	 */
	protected $settings;

	/**
	 * Add a setting
	 *
	 * @since 1.5.3
	 *
	 * @param Qcformbuilder_Forms_Settings_Contract $setting
	 *
	 * @return $this
	 */
	public function add( Qcformbuilder_Forms_Settings_Contract $setting ){
		$this->settings[ $setting->get_name() ] = $setting;
		return $this;

	}

	/**
	 * Get stored setting
	 *
	 * @since 1.5.3
	 *
	 * @param string $name Setting name
	 *
	 * @return Qcformbuilder_Forms_Settings_Contract
	 */
	public function get( $name ){
		if( $this->has( $name ) ){
			return $this->settings[ $name ];
		}

	}

	/**
	 * Check if setting is in container
	 *
	 * @since 1.5.3
	 *
	 * @param string $name Setting name
	 *
	 * @return bool
	 */
	public function has( $name ){
		return isset( $this->settings[ $name ] );

	}

	/**
	 * Get CDN settings
     *
     * @since 1.5.3
	 *
	 * @return Qcformbuilder_Forms_CDN_Settings|WP_Error|Qcformbuilder_Forms_Settings_Contract
	 */
	public function get_cdn(){
		if( ! did_action( 'qcformbuilder_forms_settings_registered' ) ){
			return new WP_Error( 500 );
		}

		return $this->get( 'cdn' );
	}

}