<?php
namespace QuantumCloud\VoiceMessageAddon;

use DateTime;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * SINGLETON: Used to implement System report handler class
 * responsible for generating a report for the server environment.
 *
 * @since 1.0.0
 **/
final class ServerReporter {

	/**
	 * The one true ServerReporter.
	 *
	 * @var ServerReporter
	 * @since 1.0.0
	 **/
	private static $instance;

	/**
	 * Sets up a new ServerReporter instance.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	private function __construct() {

	}

	/**
	 * Get server environment reporter title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Report title.
	 **/
	public function get_title() {
		return 'Server Environment';
	}

	/**
	 * Retrieve the required fields for the server environment report.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Required report fields with field ID and field label.
	 **/
	public function get_fields() {
		return [
			'os'                    => esc_html__( 'Operating System', 'wpbotvoicemessage' ),
			'software'              => esc_html__( 'Software','wpbotvoicemessage' ),
			'mysql_version'         => esc_html__( 'MySQL version','wpbotvoicemessage' ),
			'php_version'           => esc_html__( 'PHP Version','wpbotvoicemessage' ),
			'write_permissions'     => esc_html__( 'Write Permissions','wpbotvoicemessage' ),
			'zip_installed'         => esc_html__( 'ZIP Installed','wpbotvoicemessage' ),
			'curl_installed'        => esc_html__( 'cURL Installed','wpbotvoicemessage' ),
			'dom_installed'         => esc_html__( 'DOM Installed','wpbotvoicemessage' ),
			'xml_installed'         => esc_html__( 'XML Installed','wpbotvoicemessage' ),
			/** 'bcmath_installed'      => esc_html__( 'BCMath Installed','wpbotvoicemessage' ), */
			/** 'allow_url_fopen'       => esc_html__( 'allow_url_fopen','wpbotvoicemessage' ),*/
			'fileinfo'              => esc_html__( 'Fileinfo Installed','wpbotvoicemessage' ),
			'server_time'           => esc_html__( 'Server Time Sync','wpbotvoicemessage' ),
		];
	}

	/** @noinspection PhpUnused */
	/**
	 * Get server operating system.
	 * Retrieve the server operating system.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array {
	 *    Report data.
	 *
	 *    @type string $value Server operating system.
	 * }
	 **/
	public function get_os() {
		return [
			'value' => PHP_OS,
		];
	}

	/** @noinspection PhpUnused */
	/**
	 * Get server software.
	 * Retrieve the server software.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array {
	 *    Report data.
	 *
	 *    @type string $value Server software.
	 * }
	 **/
	public function get_software() {
		return [
			'value' => $_SERVER['SERVER_SOFTWARE'],
		];
	}

	/** @noinspection PhpUnused */
	/**
	 * Get PHP version.
	 * Retrieve the PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array {
	 *    Report data.
	 *
	 *    @type string $value          PHP version.
	 *    @type string $recommendation Minimum PHP version recommendation.
	 *    @type bool   $warning        Whether to display a warning.
	 * }
	 **/
	public function get_php_version() {
		$result = [
			'value' => PHP_VERSION,
		];

		if ( version_compare( $result['value'], '5.6', '<' ) ) {
			$result['recommendation'] = esc_html__( 'We recommend to use php 5.6 or higher', 'wpbotvoicemessage' );

			$result['warning'] = true;
		}

		return $result;
	}

	/** @noinspection PhpUnused */
	/**
	 * Get ZIP installed.
	 * Whether the ZIP extension is installed.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array {
	 *    Report data.
	 *
	 *    @type string $value   Yes if the ZIP extension is installed, NO otherwise.
	 *    @type bool   $warning Whether to display a warning. True if the ZIP extension is installed, False otherwise.
	 * }
	 **/
	public function get_zip_installed() {
		$zip_installed = extension_loaded( 'zip' );

		return [
			'value' => $zip_installed ? '<i class="material-icons mdc-system-yes">check_circle</i>' . esc_html__('YES', 'wpbotvoicemessage') : '<i class="material-icons mdc-system-no">error</i>' . esc_html__('NO', 'wpbotvoicemessage' ),
			'warning' => ! $zip_installed,
		];
	}

	/** @noinspection PhpUnused */
	/**
	 * Get cURL installed.
	 * Whether the cURL extension is installed.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array {
	 *    Report data.
	 *
	 *    @type string $value   YES if the cURL extension is installed, NO otherwise.
	 *    @type bool   $warning Whether to display a warning. True if the cURL extension is installed, False otherwise.
	 * }
	 **/
	public function get_curl_installed() {

		$curl_installed = extension_loaded( 'curl' );

		return [
			'value' => $curl_installed ? '<i class="material-icons mdc-system-yes">check_circle</i>' . esc_html__('YES', 'wpbotvoicemessage') : '<i class="material-icons mdc-system-no">error</i>' . esc_html__('NO', 'wpbotvoicemessage' ),
			'warning' => ! $curl_installed,
			'recommendation' => esc_html__('You must enable CURL (Client URL Library) in PHP. Contact the support service of your hosting provider. They know what to do.', 'wpbotvoicemessage' )
		];
	}

	/** @noinspection PhpUnused */
	/**
	 * Get DOM installed.
	 * Whether the DOM extension is installed.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array {
	 *    Report data.
	 *
	 *    @type string $value   YES if the DOM extension is installed, NO otherwise.
	 *    @type bool   $warning Whether to display a warning. True if the DOM extension is installed, False otherwise.
	 * }
	 **/
	public function get_dom_installed() {

		$dom_installed = extension_loaded( 'dom' );

		return [
			'value' => $dom_installed ? '<i class="material-icons mdc-system-yes">check_circle</i>' . esc_html__('YES', 'wpbotvoicemessage') : '<i class="material-icons mdc-system-no">error</i>' . esc_html__('NO', 'wpbotvoicemessage' ),
			'warning' => ! $dom_installed,
			'recommendation' => esc_html__('You must enable DOM extension (Document Object Model) in PHP. It\'s used for HTML processing. Contact the support service of your hosting provider. They know what to do.', 'wpbotvoicemessage' )
		];
	}

	/** @noinspection PhpUnused */
	/**
	 * Get Fileinfo installed.
	 * Whether the File Information extension is installed.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array {
	 *    Report data.
	 *
	 *    @type string $value   YES if the Fileinfo extension is installed, NO otherwise.
	 *    @type bool   $warning Whether to display a warning. True if the Fileinfo extension is installed, False otherwise.
	 * }
	 **/
	public function get_fileinfo() {

		$fileinfo_installed = extension_loaded( 'fileinfo' );

		return [
			'value' => $fileinfo_installed ? '<i class="material-icons mdc-system-yes">check_circle</i>' . esc_html__('YES', 'wpbotvoicemessage') : '<i class="material-icons mdc-system-no">error</i>' . esc_html__('NO', 'wpbotvoicemessage' ),
			'warning' => ! $fileinfo_installed,
			'recommendation' => esc_html__('You must enable fileinfo extension (File Information) in PHP. It\'s used for audio files processing. Contact the support service of your hosting provider. They know what to do.', 'wpbotvoicemessage' )
		];
	}

	/** @noinspection PhpUnused */
	/**
	 * Get XML installed.
	 * Whether the XML extension is installed.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array {
	 *    Report data.
	 *
	 *    @type string $value   YES if the XML extension is installed, NO otherwise.
	 *    @type bool   $warning Whether to display a warning. True if the XML extension is installed, False otherwise.
	 * }
	 **/
	public function get_xml_installed() {

		$xml_installed = extension_loaded( 'xml' );

		return [
			'value' => $xml_installed ? '<i class="material-icons mdc-system-yes">check_circle</i>' . esc_html__('YES', 'wpbotvoicemessage') : '<i class="material-icons mdc-system-no">error</i>' . esc_html__('NO', 'wpbotvoicemessage' ),
			'warning' => ! $xml_installed,
			'recommendation' => esc_html__('You must enable XML extension in PHP. It\'s used for XML processing. Contact the support service of your hosting provider. They know what to do.', 'wpbotvoicemessage' )
		];
	}

	/** @noinspection PhpUnused */
	/**
	 * Get allow_url_fopen status.
	 * Whether the allow_url_fopen directive is enabled.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array {
	 *    Report data.
	 *
	 *    @type string $value   YES if allow_url_fopen is enabled, NO otherwise.
	 *    @type bool   $warning Whether to display a warning. True if allow_url_fopen is enabled, False otherwise.
	 * }
	 **/
	public function get_allow_url_fopen() {

		$allow_url_fopen = ini_get( 'allow_url_fopen' );

		return [
			'value' => $allow_url_fopen ? '<i class="material-icons mdc-system-yes">check_circle</i>' . esc_html__('YES', 'wpbotvoicemessage') : '<i class="material-icons mdc-system-no">error</i>' . esc_html__('NO', 'wpbotvoicemessage' ),
			'warning' => ! $allow_url_fopen,
			'recommendation' => esc_html__('You need to enable allow_url_fopen directive in PHP. It\'s used for download updates and other data from our server. Contact the support service of your hosting provider. They know what to do.', 'wpbotvoicemessage' )
		];
	}

	/** @noinspection PhpUnused */
	/**
	 * Get BCMath installed.
	 * Whether the BCMath extension is installed.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array {
	 *    Report data.
	 *
	 *    @type string $value   YES if the BCMath extension is installed, NO otherwise.
	 *    @type bool   $warning Whether to display a warning. True if the BCMath extension is installed, False otherwise.
	 * }
	 **/
	public function get_bcmath_installed() {

		$bcmath_installed = extension_loaded( 'bcmath' );

		return [
			'value' => $bcmath_installed ? '<i class="material-icons mdc-system-yes">check_circle</i>' . esc_html__('YES', 'wpbotvoicemessage') : '<i class="material-icons mdc-system-no">error</i>' . esc_html__('NO', 'wpbotvoicemessage' ),
			'warning' => ! $bcmath_installed,
			'recommendation' => esc_html__('You must enable BCMath extension (Arbitrary Precision Mathematics) in PHP. Contact the support service of your hosting provider. They know what to do.', 'wpbotvoicemessage' )
		];
	}

	/** @noinspection PhpUnused */
	/**
	 * Get MySQL version.
	 * Retrieve the MySQL version.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array {
	 *    Report data.
	 *
	 *    @type string $value MySQL version.
	 * }
	 **/
	public function get_mysql_version() {
		global $wpdb;

		$db_server_version = $wpdb->get_results( "SHOW VARIABLES WHERE `Variable_name` IN ( 'version_comment', 'innodb_version' )", OBJECT_K );

		return [
			'value' => $db_server_version['version_comment']->Value . ' v' . $db_server_version['innodb_version']->Value,
		];
	}

	/** @noinspection PhpUnused */
	/**
	 * Get write permissions.
	 * Check whether the required folders has writing permissions.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array {
	 *    Report data.
	 *
	 *    @type string $value   Writing permissions status.
	 *    @type bool   $warning Whether to display a warning. True if some required
	 *                          folders don't have writing permissions, False otherwise.
	 * }
	 **/
	public function get_write_permissions() {

		$paths_to_check = [
			ABSPATH => esc_html__('WordPress root directory', 'wpbotvoicemessage' )
		];

		$write_problems = [];

		$wp_upload_dir = wp_upload_dir();

		if ( $wp_upload_dir['error'] ) {
			$write_problems[] = esc_html__('WordPress root uploads directory', 'wpbotvoicemessage' );
		}

		$contacter_uploads_path = $wp_upload_dir['basedir'] . '/wpbotvoicemessage';

		if ( is_dir( $contacter_uploads_path ) ) {
			$paths_to_check[ $contacter_uploads_path ] = esc_html__('VoiceMessageAddon uploads directory', 'wpbotvoicemessage' );
		}

		$htaccess_file = ABSPATH . '/.htaccess';

		if ( file_exists( $htaccess_file ) ) {
			$paths_to_check[ $htaccess_file ] = esc_html__('.htaccess file', 'wpbotvoicemessage' );
		}

		foreach ( $paths_to_check as $dir => $description ) {

			if ( ! is_writable( $dir ) ) {
				$write_problems[] = $description;
			}
		}

		if ( $write_problems ) {
			$value = '<i class="material-icons mdc-system-no">error</i>' . esc_html__('There are some writing permissions issues with the following directories/files:', 'wpbotvoicemessage' ) . "<br> &nbsp;&nbsp;&nbsp;&nbsp;– ";

			$value .= implode( "<br> &nbsp;&nbsp;&nbsp;&nbsp;– ", $write_problems );
		} else {
			$value = '<i class="material-icons mdc-system-yes">check_circle</i>' . esc_html__('All right', 'wpbotvoicemessage' );
		}

		return [
			'value' => $value,
			'warning' => (bool) $write_problems,
		];
	}

	/** @noinspection PhpUnused */
	/**
	 * Get report.
	 * Retrieve the report with all it's containing fields.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array {
	 *    Report fields.
	 *
	 *    @type string $name Field name.
	 *    @type string $label Field label.
	 * }
	 **/
	 public function get_report() {

		$result = [];

		foreach ( $this->get_fields() as $field_name => $field_label ) {
			$method = 'get_' . $field_name;

			$reporter_field = [
				'name' => $field_name,
				'label' => $field_label,
			];

			/** @noinspection SlowArrayOperationsInLoopInspection */
			$reporter_field        = array_merge( $reporter_field, $this->$method() );
			$result[ $field_name ] = $reporter_field;
		}

		return $result;
	}

	/**
	 * Get mbstring installed.
	 * Whether the mbstring extension is installed.
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @return array {
	 *    Report data.
	 *
	 *    @type string $value   YES if the mbstring extension is installed, NO otherwise.
	 *    @type bool   $warning Whether to display a warning. True if the mbstring extension is installed, False otherwise.
	 * }
	 **/
	public function get_mbstring_installed() {

		$mbstring_installed = extension_loaded( 'mbstring' );

		return [
			'value' => $mbstring_installed ? '<i class="material-icons mdc-system-yes">check_circle</i>' . esc_html__('YES', 'wpbotvoicemessage') : '<i class="material-icons mdc-system-no">error</i>' . esc_html__('NO', 'wpbotvoicemessage' ),
			'warning' => ! $mbstring_installed,
			'recommendation' => esc_html__('You must enable mbstring extension (Multibyte String) in PHP. Contact the support service of your hosting provider. They know what to do.', 'wpbotvoicemessage' )
		];
	}

	/**
	 * Get server time and compare it with NTP.
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 **/
	public function get_server_time() {

		/** Get current time from google. */
		$url = 'https://www.google.com/';
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_NOBODY, true );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_HEADER, true );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0 );
		$header = curl_exec( $curl );
		$curl_errno = curl_errno( $curl );
		$curl_info = curl_getinfo( $curl );
		curl_close( $curl );

		/** On cURL Error. */
		if ( $curl_errno ) {
			$time_ok = false;
			return [
				'value' => $time_ok ? '<i class="material-icons mdc-system-yes">check_circle</i>' . esc_html__('YES', 'wpbotvoicemessage') : '<i class="material-icons mdc-system-no">error</i>' . esc_html__('NO', 'wpbotvoicemessage' ),
				'warning' => ! $time_ok,
				'recommendation' => esc_html__('Failed to check time synchronization on your server. Your server\'s clock must be in sync with network time protocol - NTP.', 'wpbotvoicemessage' )
			];
		}

		/** Error If cone not 200. */
		if ( 200 !== $curl_info['http_code'] ) {
			$time_ok = false;
			return [
				'value' => $time_ok ? '<i class="material-icons mdc-system-yes">check_circle</i>' . esc_html__('YES', 'wpbotvoicemessage') : '<i class="material-icons mdc-system-no">error</i>' . esc_html__('NO', 'wpbotvoicemessage' ),
				'warning' => ! $time_ok,
				'recommendation' => esc_html__('Failed to check time synchronization on your server. Your server\'s clock must be in sync with network time protocol - NTP.', 'wpbotvoicemessage' )
			];
		}

		/** Convert header to array. */
		$headers = $this->get_headers_from_curl_response( $header );

		$date = '';
		if ( isset( $headers['date'] ) ) {
			$date = $headers['date'];
		}

		$date = DateTime::createFromFormat( 'D, d M Y H:i:s e', $date );

		if ( ! $date ) {
			$time_ok = false;
			return [
				'value' => $time_ok ? '<i class="material-icons mdc-system-yes">check_circle</i>' . esc_html__('YES', 'wpbotvoicemessage') : '<i class="material-icons mdc-system-no">error</i>' . esc_html__('NO', 'wpbotvoicemessage' ),
				'warning' => ! $time_ok,
				'recommendation' => esc_html__('Failed to check time synchronization on your server. Your server\'s clock must be in sync with network time protocol - NTP.', 'wpbotvoicemessage' )
			];
		}

		/** Time from Google. */
		$google_time = $date->format( 'Y-m-d H:i:s e' );

		/** Your Server time in 'GMT' */
		$timezone = date_default_timezone_get();
		date_default_timezone_set( 'GMT' );
		$server_time = date('Y-m-d H:i:s e');
		date_default_timezone_set( $timezone );

		$to_time = strtotime( $google_time );
		$from_time = strtotime( $server_time );
		$diff = abs($to_time - $from_time);
		$diff = (int)$diff;

		/** If time difference more than 120 sec, show warning. */
		if ( $diff > 120 ) {
			$time_ok = false;
		} else {
			$time_ok = true;
		}

		return [
			'value' => $time_ok ? '<i class="material-icons mdc-system-yes">check_circle</i>' . esc_html__('YES', 'wpbotvoicemessage') : '<i class="material-icons mdc-system-no">error</i>' . esc_html__('NO', 'wpbotvoicemessage' ) . '<br>Google Time: ' . $google_time . '<br>&nbsp;&nbsp;&nbsp;Local Time: ' . $server_time,
			'warning' => ! $time_ok,
			'recommendation' => esc_html__( 'Your server\'s clock is not in sync with network time protocol - NTP. Contact the support service of your hosting provider. They know what to do.', 'wpbotvoicemessage' )
		];

	}

	/**
	 * Convert header string to array of header values.
	 * @see https://stackoverflow.com/a/10590242
	 *
	 * @param $header_text string - Header from cURL request.
	 *
	 * @return array
	 * @since 1.0.5
	 * @access private
	 **/
	private function get_headers_from_curl_response( $header_text ) {

		/** Everybody out of the dusk. */
		$header_text = json_encode( $header_text );

		$headers = [];
		foreach ( explode( '\\r\\n', $header_text ) as $i => $line ) {

			/** Skip garbage. */
			if (  strlen( $line ) < 3 ) { continue; }

			if ( $i === 0 ) {
				$headers['http_code'] = $line;
			} else {
				list ( $key, $value ) = explode( ': ', $line );
				$headers[strtolower( $key )] = $value;
			}
		}

		return $headers;

	}

	/**
	 * Main ServerReporter Instance.
	 *
	 * Insures that only one instance of ServerReporter exists in memory at any one time.
	 *
	 * @static
	 * @return ServerReporter
	 * @since 1.0.0
	 **/
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

			self::$instance = new self;

		}

		return self::$instance;

	}

} // End Class ServerReporter.
