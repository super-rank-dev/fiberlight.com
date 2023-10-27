<?php


namespace QuantumCloud;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/** Include plugin autoloader for additional classes. */
require __DIR__ . '/includes/autoload.php';

use QuantumCloud\VoiceMessageAddon\Settings;
use QuantumCloud\VoiceMessageAddon\PluginHelper;
use QuantumCloud\VoiceMessageAddon\VoiceForm;
use QuantumCloud\VoiceMessageAddon\CheckCompatibility;

final class wpbotvoicemessage {

	public static $version;

	public static $suffix ;

	public static $url;

	public static $path;

	public static $basename;

	public static $menu_base;

	private static $instance;

	private function __construct() {
		require __DIR__ . '/includes/voice-functions.php';
		/** Initialize main variables. */
		$this->init();
	}

	public function plugin_setup() {
		if( ! qcld_check_compat() ) {
			return;
		}
		/** Send install Action to our host. */
		self::install_action();
		/** Define hooks that runs on front-end as well as the dashboard. */
		$this->all_hooks();
		/** Define public hooks. */
		$this->frontend_hooks();
		/** Define admin hooks. */
		$this->backend_hooks();
	}

	/**
	 * Return plugin version.
	 *
	 * @return string
	 * @since 1.0.0
	 * @access public
	 **/
	public function get_version() {
		return self::$version;
	}

	/**
	 * Define hooks that runs on both the front-end as well as the dashboard.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 **/
	private function all_hooks() {
		qcld_fnc_hook_setup();
	}

	/**
	 * Register all of the hooks related to the admin area functionality.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 **/
	private function backend_hooks() {
		/** Work only in admin area. */
		if ( ! is_admin() ) { return; }
		/** Initialize PluginHelper. */
		PluginHelper::get_instance();
		/** Add plugin settings page. */
		Settings::get_instance()->add_settings_page();
		qcld_load_backend_styles_scripts();
	}

	/**
	 * Register all of the hooks related to the frontend functionality.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 **/
	private function frontend_hooks() {
		/** Work only on frontend area. */
		if ( is_admin() ) { return; }
		/** Load CSS for Frontend Area. */
		add_action( 'wp_enqueue_scripts', [$this, 'styles'] ); // CSS.
		/** Load JavaScript for Frontend Area. */
		add_action( 'wp_enqueue_scripts', [$this, 'scripts'] ); // JS.
		/** Show Float button. */
		if ( 'on' === Settings::get_instance()->options['show_fbutton'] ) {
			add_action( 'wp_footer', 'qcld_voice_render_fbutton' );
		}
	}

	/**
	 * Initialize main variables.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function init() {
		/** Get Plugin version. */
		$plugin_data = $this->get_plugin_data();
		self::$version = $plugin_data['Version'];
		/** Gets the plugin URL (with trailing slash). */
		self::$url = plugin_dir_url( __FILE__ );
		/** Gets the plugin PATH. */
		self::$path = plugin_dir_path( __FILE__ );
		/** Use minified libraries if SCRIPT_DEBUG is turned off. */
		self::$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		self::$suffix = '';
		/** Set plugin basename. */
		self::$basename = plugin_basename( __FILE__ );
		/** Plugin settings page base. */
		self::$menu_base = 'qcldwpbot_record_page_qcld_wpvm_vmwbmdp_contacter_settings';
		/** Create /wp-content/uploads/wpbotvoicemessage/ folder for audio files. */
		wp_mkdir_p( trailingslashit( wp_upload_dir()['basedir'] ) . 'wpbotvoicemessage' );
	}

	/**
	 * Return current plugin metadata.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function get_plugin_data() {
		if ( ! function_exists('get_plugin_data') ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		return get_plugin_data( __FILE__ );
	}

	/**
	 * Add CSS for the public-facing side of the site.
	 *
	 * @return void
	 * @since 1.0.0
	 **/
	public function styles() {
		/** Frontend CSS for shortcodes. */
		wp_register_style( 'vmwbmdp-wpbotvoicemessage', self::$url . 'css/wpbotvoicemessage' . self::$suffix . '.css', [], self::$version );
		$inline_css = qcld_get_contacter_inline_css();
		/** Add custom CSS. */
		wp_add_inline_style( 'vmwbmdp-wpbotvoicemessage', $inline_css . Settings::get_instance()->options['custom_css'] );
	}

	/**
	 * Add JavaScript for the public-facing side of the site.
	 *
	 * @return void
	 * @since 1.0.0
	 **/
	public function scripts() {
		/** Frontend JS for shortcodes. */
		wp_register_script( 'vmwbmdp-wpbotvoicemessage-recorder', self::$url . 'js/recorder' . self::$suffix . '.js', [], self::$version, true );
		wp_register_script( 'green-audio-player', self::$url . 'js/green-audio-player' . self::$suffix . '.js', [], self::$version, true );
		wp_register_script( 'vmwbwp-wpbotvoicemessage-scroller', self::$url . 'js/jquery.slimscroll' . self::$suffix . '.js', [], self::$version, true );
		wp_register_script( 'vmwbmdp-wpbotvoicemessage', self::$url . 'js/wpbotvoicemessage' . self::$suffix . '.js', ['vmwbmdp-wpbotvoicemessage-recorder', 'green-audio-player', 'vmwbwp-wpbotvoicemessage-scroller'], self::$version, true );
		/** Pass variables to frontend. */
		wp_localize_script( 'vmwbmdp-wpbotvoicemessage', 'vmwbmdpContacterWP', [
			'nonce' => wp_create_nonce( 'wpbotvoicemessage-nonce' ),
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'accentColor' => Settings::get_instance()->options['accent_color']
		] );
	}

	/**
	 * Run when the plugin is activated.
	 *
	 * @static
	 * @since 1.0.0
	 **/
	public static function on_plugin_active() {
		/** Security checks. */
		if ( ! current_user_can( 'activate_plugins' ) ) { return; }
		/** We need to know plugin to activate it. */
		if ( ! isset( $_REQUEST['plugin'] ) ) { return; }
		/** Get plugin. */
		$plugin = filter_var( $_REQUEST['plugin'], FILTER_SANITIZE_STRING );
		/** Checks that a user was referred from admin page with the correct security nonce. */
		check_admin_referer( "activate-plugin_{$plugin}" );
		/** Do critical initial checks. */
		if ( ! CheckCompatibility::get_instance()->do_initial_checks( false ) ) { return; }
		/** Send install Action to our host. */
		self::install_action();
		/** Create Default Form. */
		VoiceForm::create_default_form();
	}

	/**
	 * Run when the plugin is activated mater .
	 *
	 **/
	public static function on_plugin_active_master(){
	
			VoiceForm::create_default_form();
		
	}
	/**
	 * install Action
	 **/
	private static function install_action() {
		/** Plugin version. */
		$ver = self::get_instance()->get_version();
		/** Have we already sent 'install' for this version? */
		$opt_name = 'qcld_wpvm_vmwbmdp_wpbotvoicemessage_send_action_install';
		$ver_installed = get_option( $opt_name );
		/** Send install Action to our host. */
		if ( ! $ver_installed || $ver !== $ver_installed ) {
			/** Send install Action to our host. */
			update_option( $opt_name, $ver );
		}
	}

	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {
			self::$instance = new self;
		}
		return self::$instance;

	}
}
//var_dump(class_exists(wpbotvoicemessage::class));wp_die();
/** Run when the plugin is activated. */
register_activation_hook( __FILE__, [wpbotvoicemessage::class, 'on_plugin_active'] );
/** Run */
add_action( 'plugins_loaded', [wpbotvoicemessage::get_instance(), 'plugin_setup'] );
require_once( plugin_dir_path(__FILE__) . 'plugin-upgrader/plugin-upgrader.php' );

/** on_plugin_active_master **/
add_action( 'init', [wpbotvoicemessage::class, 'on_plugin_active_master'] );