<?php
namespace QuantumCloud;

/** Include plugin autoloader for additional classes. */
require __DIR__ . '/src/autoload.php';

use QuantumCloud\VoiceMessageAddon\VoiceForm;
use QuantumCloud\VoiceMessageAddon\VoiceRecord;
use QuantumCloud\VoiceMessageAddon\Helper;

/** Exit if uninstall.php is not called by WordPress. */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * SINGLETON: Class used to implement Uninstall of VoiceMessageAddon plugin.
 *
 * @since 1.0.0
 **/
final class Uninstall {

	/**
	 * The one true Uninstall.
	 *
	 * @var Uninstall
	 * @since 1.0.0
	 **/
	private static $instance;

	/**
	 * Sets up a new Uninstall instance.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	private function __construct() {

		/** Get Uninstall mode. */
		$uninstall_mode = $this->get_uninstall_mode();

		/** Remove Plugin and Settings. */
		if ( 'plugin+settings' === $uninstall_mode ) {

			/** Remove Plugin Settings. */
			Helper::remove_settings();

		/** Remove Plugin with Settings and Audio files. */
		} elseif ( 'plugin+settings+data' === $uninstall_mode ) {

			/** Remove Plugin Settings. */
			Helper::remove_settings();

			/** Remove Custom Post types. */
			$this->remove_all_records_and_forms();

			/** Remove Plugin Audio files. */
			Helper::get_instance()->remove_audio_files();

		}

	}

	/**
	 * Remove Custom Post types.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function remove_all_records_and_forms() {

		/** Remove all VoiceMessageAddon Forms. */
		$c_forms = get_posts( [
			'post_type' => VoiceForm::POST_TYPE,
			'numberposts' => - 1,
			'post_status' => ['publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash']
		] );

		foreach ( $c_forms as $c_form ) {
			wp_delete_post( $c_form->ID, true );
		}

		/** Remove all VoiceMessageAddon Records. */
		$c_records = get_posts( [
			'post_type' => VoiceRecord::POST_TYPE,
			'numberposts' => - 1,
			'post_status' => ['publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash']
		] );

		foreach ( $c_records as $c_record ) {
			wp_delete_post( $c_record->ID, true );
		}

	}
	/**
	 * Return uninstall mode.
	 * plugin - Will remove the plugin only. Settings and Audio files will be saved. Used when updating the plugin.
	 * plugin+settings - Will remove the plugin and settings. Audio files will be saved. As a result, all settings will be set to default values. Like after the first installation.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function get_uninstall_mode() {

		$uninstall_settings = get_option( 'qcld_wpvm_vmwbmdp_contacter_uninstall_settings' );

		if( isset( $uninstall_settings['qcld_wpvm_vmwbmdp_contacter_uninstall_settings'] ) && $uninstall_settings['qcld_wpvm_vmwbmdp_contacter_uninstall_settings'] ) { // Default value.
			$uninstall_settings = [
				'delete_plugin' => 'plugin'
			];
		}

		return $uninstall_settings['delete_plugin'];

	}

	/**
	 * Main Uninstall Instance.
	 *
	 * Insures that only one instance of Uninstall exists in memory at any one time.
	 *
	 * @static
	 * @return Uninstall
	 * @since 1.0.0
	 **/
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

			self::$instance = new self;

		}

		return self::$instance;

	}

}

/** Runs on Uninstall of VoiceMessageAddon plugin. */
Uninstall::get_instance();
