<?php
namespace QuantumCloud\VoiceMessageAddon;

use QuantumCloud\wpbotvoicemessage;
use WP_Filesystem_Direct;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * SINGLETON: Class used to implement work with WordPress filesystem.
 *
 * @since 1.0.0
 **/
final class Helper {

	/**
	 * The one true Helper.
	 *
	 * @var Helper
	 * @since 1.0.0
	 **/
	private static $instance;

	/**
	 * Remove all wpbotvoicemessage audio files.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 **/
	public function remove_audio_files() {

		/** Remove /wp-content/uploads/wpbotvoicemessage/ folder. */
		$dir = trailingslashit( wp_upload_dir()['basedir'] ) . 'wpbotvoicemessage';
		$this->remove_directory( $dir );

	}

	/**
	 * Delete Plugin Options.
	 *
	 * @since 1.0.5
	 * @access public
	 **/
	public static function remove_settings() {

		$settings = [
			'qcld_wpvm_vmwbmdp_contacter_envato_id',
			'qcld_wpvm_vmwbmdp_contacter_settings',
			'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings',
			'qcld_wpvm_vmwbmdp_contacter_modalpopup_settings',
			'qcld_wpvm_vmwbmdp_contacter_messages_settings',
			'qcld_wpvm_vmwbmdp_contacter_assignments_settings',
			'qcld_wpvm_vmwbmdp_contacter_css_settings',
			'qcld_wpvm_vmwbmdp_contacter_uninstall_settings',
			'qcld_wpvm_vmwbmdp_contacter_default_form_id',
			'qcld_wpvm_vmwbmdp_wpbotvoicemessage_send_action_install',
		];

		/** For Multisite. */
		if ( is_multisite() ) {

			foreach ( $settings as $key ) {

				if ( ! get_site_option( $key ) ) { continue; }

				delete_site_option( $key );

			}

			/** For Singular site. */
		} else {

			foreach ( $settings as $key ) {

				if ( ! get_option( $key ) ) { continue; }

				delete_option( $key );

			}

		}

	}

	/**
	 * Remove directory with all contents.
	 *
	 * @param $dir - Directory path to remove.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function remove_directory( $dir ) {

		require_once ( ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php' );
		require_once ( ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php' );
		$fileSystemDirect = new WP_Filesystem_Direct( false );
		$fileSystemDirect->rmdir( $dir, true );

	}

	/**
	 * Render inline svg by id or icon name.
	 *
	 * @param int|string $icon - media id, or icon name.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void|string
	 **/
	public function inline_svg_e( $icon ) {

		/** If this users custom svg. */
		if ( is_numeric( $icon ) ) {
			$icon = get_attached_file( $icon );

		/** If icon from library. */
		} else {
			$icon = wpbotvoicemessage::$path . 'images/mdc-icons/' . $icon;
		}

		if ( ! is_file( $icon ) ) { return ''; }

		$svg_icon = file_get_contents( $icon );

		/** Escaping SVG with KSES. */
		$kses_defaults = wp_kses_allowed_html( 'post' );

		$svg_args = [
			'svg'   => [
				'class' => true,
				'aria-hidden' => true,
				'aria-labelledby' => true,
				'role' => true,
				'xmlns' => true,
				'width' => true,
				'height' => true,
				'viewbox' => true, // <= Must be lower case!
			],
			'g'     => [ 'fill' => true ],
			'title' => [ 'title' => true ],
			'path'  => [ 'd' => true, 'fill' => true, ],
		];

		$allowed_tags = array_merge( $kses_defaults, $svg_args );

		echo wp_kses( $svg_icon, $allowed_tags );

	}

	/**
	 * Replication of file_get_contents that uses cURL instead.
	 *
	 * @param $url
	 *
	 * @since  3.0.0
	 * @access public
	 *
	 * @return bool|string
	 **/
	public function file_get_contents_curl( $url ) {

		$curl = curl_init();

		curl_setopt( $curl, CURLOPT_AUTOREFERER, TRUE );
		curl_setopt( $curl, CURLOPT_HEADER, 0 );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $curl, CURLOPT_URL, $url);
		curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, TRUE );

		$data = curl_exec( $curl );

		/**
		 * Handle connection errors.
		 * Try to connect to mirror in Soviet Russia.
		 **/
		if ( curl_errno( $curl ) > 0 ) {

			curl_close( $curl );

			$data = $this->file_get_contents_curl_mirror( $url );

		}

		return $data;

	}

	/**
	 * Use mirror in Russia for countries under US sanctions.
	 *
	 * @param $url
	 *
	 * @since  3.0.0
	 * @access public
	 *
	 * @return bool|string
	 **/
	private function file_get_contents_curl_mirror( $url ) {

		$curl = curl_init();

		curl_setopt( $curl, CURLOPT_AUTOREFERER, TRUE );
		curl_setopt( $curl, CURLOPT_HEADER, 0 );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $curl, CURLOPT_URL, $url);
		curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, TRUE );

		$data = curl_exec( $curl );

		/** Error handler. */
		if ( curl_errno( $curl ) > 0 ) { return false; }

		return $data;

	}

	/**
	 * Get remote contents.
	 *
	 * @access public
	 * @since 1.0.0
	 * @param  string $url  The URL we're getting our data from.
	 * @return false|string The contents of the remote URL, or false if we can't get it.
	 **/
	public function get_remote( $url ) {

		$args = [
			'timeout'    => 30,
			'user-agent' => 'wpbotvoicemessage-user-agent',
		];

		$response = wp_remote_get( $url, $args );
		if ( is_array( $response ) ) {
			return $response['body'];
		}

		// TODO: Add a message so that the user knows what happened.
		/** Error while downloading remote file. */
		return false;

	}

	/**
	 * Parser function to get formatted headers with response code.
	 *
	 * @param $headers - HTTP response headers.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 **/
	public function parse_headers( $headers ) {
		$head = [];
		foreach( $headers as $k => $v ) {
			$t = explode( ':', $v, 2 );
			if ( isset( $t[1] ) ) {
				$head[ trim($t[0]) ] = trim( $t[1] );
			} else {
				$head[] = $v;
				if ( preg_match( "#HTTP/[0-9.]+\s+([0-9]+)#",$v, $out ) ) {
					$head['response_code'] = (int) $out[1];
				}
			}
		}

		return $head;
	}

	/**
	 * Initializes WordPress filesystem.
	 *
	 * @static
	 * @access public
	 * @since 1.0.5
	 *
	 * @return object WP_Filesystem
	 **/
	public static function init_filesystem() {

		$credentials = [];

		if ( ! defined( 'FS_METHOD' ) ) {
			define( 'FS_METHOD', 'direct' );
		}

		$method = defined( 'FS_METHOD' ) ? FS_METHOD : false;

		/** FTP */
		if ( 'ftpext' === $method ) {

			/** If defined, set credentials, else set to NULL. */
			$credentials['hostname'] = defined( 'FTP_HOST' ) ? preg_replace( '|\w+://|', '', FTP_HOST ) : null;
			$credentials['username'] = defined( 'FTP_USER' ) ? FTP_USER : null;
			$credentials['password'] = defined( 'FTP_PASS' ) ? FTP_PASS : null;

			/** FTP port. */
			if ( null !== $credentials['hostname'] && strpos( $credentials['hostname'], ':' )  ) {
				list( $credentials['hostname'], $credentials['port'] ) = explode( ':', $credentials['hostname'], 2 );
				if ( ! is_numeric( $credentials['port'] ) ) {
					unset( $credentials['port'] );
				}
			} else {
				unset( $credentials['port'] );
			}

			/** Connection type. */
			if ( ( defined( 'FTP_SSL' ) && FTP_SSL ) ) {
				$credentials['connection_type'] = 'ftps';
			} elseif ( ! array_filter( $credentials ) ) {
				$credentials['connection_type'] = null;
			} else {
				$credentials['connection_type'] = 'ftp';
			}
		}

		/** The WordPress filesystem. */
		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			/** @noinspection PhpIncludeInspection */
			require_once wp_normalize_path( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem( $credentials );
		}

		return $wp_filesystem;
	}

	/**
	 * Main Helper Instance.
	 *
	 * Insures that only one instance of Helper exists in memory at any one time.
	 *
	 * @static
	 * @return Helper
	 * @since 1.0.0
	 **/
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

			self::$instance = new self;

		}

		return self::$instance;

	}

} // End Class Helper.
