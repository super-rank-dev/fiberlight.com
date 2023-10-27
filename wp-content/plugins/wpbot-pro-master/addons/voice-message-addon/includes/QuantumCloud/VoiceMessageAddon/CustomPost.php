<?php
namespace QuantumCloud\VoiceMessageAddon;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * SINGLETON: Class used manipulate with custom post contacter_form and qcldwpbot_record.
 *
 * @since 1.0.0
 **/
final class CustomPost {

	/**
	 * The one true CustomPost.
	 *
	 * @var CustomPost
	 * @since 1.0.0
	 **/
	private static $instance;

	/**
	 * Sets up a new instance.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	private function __construct() {

		/** Register VoiceMessageAddon Form and VoiceMessageAddon Record post types. */
		add_action( 'init', [ $this, 'add_post_types' ] );


    }

	/**
	 * Register post types.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function add_post_types() {

		/** Register contacter_form post type. */
		VoiceForm::get_instance()->register_post_type();

		/** Register qcldwpbot_record post type. */
		VoiceRecord::get_instance()->register_post_type();

	}

	/**
	 * Main CustomPost Instance.
	 *
	 * Insures that only one instance of CustomPost exists in memory at any one time.
	 *
	 * @static
	 * @return CustomPost
	 * @since 1.0.0
	 **/
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof CustomPost ) ) {
			self::$instance = new CustomPost;
		}

		return self::$instance;
	}
	
} // End Class CustomPost.
