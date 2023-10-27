<?php
namespace QuantumCloud\VoiceMessageAddon;

use QuantumCloud\wpbotvoicemessage;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

/**
 * SINGLETON: Class used for check plugin compatibility on early phase.
 *
 * @since 3.0.0
 **/
final class CheckCompatibility {

    /**
     * Array of messages to show in admin area if some checks fails.
     *
     * @var array
     * @since 3.0.0
     **/
    public $admin_messages = [];

    /**
     * The one true CheckCompatibility.
     *
     * @var CheckCompatibility
     * @since 3.0.0
     **/
    private static $instance;

    /**
     * Do initial hosting environment check: PHP version and critical extensions.
     *
     * @param bool $show_message - Show or hide messages in admin area.
     *
     * @since  3.0.0
     * @access public
     *
     * @return bool - true if all checks passed, false otherwise.
     **/
    public function do_initial_checks( $show_message = true ) {

        /** Flag to indicate failed checks. */
        $pass = true;

        /** Plugin require PHP 5.6 or higher. */
        $php_version = $this->check_php_version( $show_message );
        if ( false ===  $php_version ) { $pass = false; }

        /** Plugin require cURL extension. */
        $curl = $this->check_curl( $show_message );
        if ( false ===  $curl ) { $pass = false; }

        /** Add handler to show admin messages. */
        $this->admin_notices( $show_message );

        return $pass;

    }

    /**
     * Do environment checks for required extensions on plugin page, before show any settings.
     *
     * @param bool $show_message - Show or hide messages in admin area.
     *
     * @since  3.0.0
     * @access public
     *
     * @return bool - true if all checks passed, false otherwise.
     **/
    public function do_settings_checks( $show_message = true ) {

        /** Flag to indicate failed checks. */
        $pass = true;

        /** Plugin require cURL extension. */
        $curl = $this->check_curl( $show_message );
        if ( false ===  $curl ) { $pass = false; }

        /** Plugin require DOM extension. */
        $dom = $this->check_dom( $show_message );
        if ( false ===  $dom ) { $pass = false; }

        /** Plugin require XML extension. */
        $xml = $this->check_xml( $show_message );
        if ( false ===  $xml ) { $pass = false; }

        /** Plugin require BCMath extension. */
        $bcmath = $this->check_bcmath( $show_message );
        if ( false ===  $bcmath ) { $pass = false; }

        /** Plugin require mbstring extension. */
        $mbstring = $this->check_mbstring( $show_message );
        if ( false ===  $mbstring ) { $pass = false; }

        /** Plugin require correct Server Time. */
        $server_time = $this->check_server_time( $show_message );
        if ( false ===  $server_time ) { $pass = false; }

        /** Add handler to show admin messages. */
        $this->admin_notices( $show_message );

        return $pass;

    }

    /**
     * Add handler to show admin messages.
     *
     * @param $show_message
     *
     * @since  3.0.0
     * @access public
     *
     * @return void
     **/
    private function admin_notices( $show_message ) {

        /** If we need to show message in admin area. */
        if ( ! $show_message ) { return; }


        /** Too early to call get_current_screen(). */
        if ( ! function_exists( 'get_current_screen' ) ) {
            require_once(ABSPATH . 'wp-admin/includes/screen.php');
        }

        /** VoiceMessageAddon Settings Page. */
        $screen = get_current_screen(); // Get current screen.
        if ( null !== $screen && $screen->base === wpbotvoicemessage::$menu_base ) {

            /** Show messages as snackbars. */
            foreach ( $this->admin_messages as $message ) {
                $this->render_snackbar_message( $message, 'error' );
            }

        } else {

            /** Show messages as WordPress admin messages. */
            add_action( 'admin_notices', [$this, 'show_admin_messages'] );

        }

    }

    /**
     * Show messages in Admin area.
     *
     * @since 3.0.0
     * @access public
     *
     * @return void
     **/
    public function show_admin_messages() {

        /** Show messages as WordPress admin messages. */
        foreach ( $this->admin_messages as $message ) {
            $this->render_classic_message( $message, 'error' );
        }

    }

    /**
     * Render message in snackbar style.
     *
     * @param        $message   - Message to show
     * @param string $type      - Type of message: info|error|warning
     *
     * @since  3.0.0
     * @access public
     *
     * @return void
     **/
    private function render_snackbar_message( $message, $type = 'warning' ) {

        /** Render message in snackbar style. */
        UI::get_instance()->render_snackbar(
            $message,
            $type,
            -1,
            true
        );

    }

    /**
     * Render message in classic WordPress style.
     *
     * @param        $message   - Message to show
     * @param string $type      - Type of message: info|error|warning
     *
     * @since  3.0.0
     * @access public
     *
     * @return void
     **/
    private function render_classic_message( $message, $type = 'warning' ) {

        /** Render message in old fashion style. */
        ?>
        <div class="settings-error notice notice-<?php esc_attr_e( $type ); ?>">
            <h4><?php esc_html_e( 'VoiceMessageAddon', 'wpbotvoicemessage' ); ?></h4>
            <p><?php esc_html_e( $message ); ?></p>
        </div>
        <?php

    }

    /**
     * Check minimal required php version.
     *
     * @param bool $show_message - Show or hide messages in admin area.
     *
     * @since  3.0.0
     * @access private
     *
     * @return bool - true if php version is 5.6 or higher, false otherwise.
     **/
    private function check_php_version( $show_message = true ) {

        /** Plugin require PHP 5.6 or higher. */
        $res = ! ( ! defined( 'PHP_VERSION_ID' ) || PHP_VERSION_ID < 50600 );

        /** If we need to show message in admin area. */
        if ( false === $res && $show_message ) {

            $this->admin_messages[] = esc_html__( 'The minimum PHP version required for VoiceMessageAddon plugin is 5.6.0.', 'wpbotvoicemessage' );

        }

        return $res;

    }

    /**
     * Check whether the cURL extension is installed.
     *
     * @param bool $show_message - Show or hide messages in admin area.
     *
     * @since  3.0.0
     * @access private
     *
     * @return bool - true if curl extension is loaded, false otherwise.
     **/
    private function check_curl( $show_message = true ) {

        /** Whether the cURL extension is installed. */
        $curl = ServerReporter::get_instance()->get_curl_installed();
        $check = ! $curl['warning'];

        /** If we need to show message in admin area. */
        if ( false === $check && $show_message ) {
            $this->admin_messages[] = $curl['recommendation'];
        }

        return $check;

    }

    /**
     * Check whether the DOM extension is installed.
     *
     * @param bool $show_message - Show or hide messages in admin area.
     *
     * @since  3.0.0
     * @access private
     *
     * @return bool - true if DOM extension is loaded, false otherwise.
     **/
    private function check_dom( $show_message = true ) {

        /** Whether the DOM extension is installed. */
        $dom = ServerReporter::get_instance()->get_dom_installed();
        $check = ! $dom['warning'];

        /** If we need to show message in admin area. */
        if ( false === $check && $show_message ) {
            $this->admin_messages[] = $dom['recommendation'];
        }

        return $check;

    }

    /**
     * Check whether the xml extension is installed.
     *
     * @param bool $show_message - Show or hide messages in admin area.
     *
     * @since  3.0.0
     * @access private
     *
     * @return bool - true if xml extension is loaded, false otherwise.
     **/
    private function check_xml( $show_message = true ) {

        /** Whether the XML extension is installed. */
        $xml = ServerReporter::get_instance()->get_xml_installed();
        $check = ! $xml['warning'];

        /** If we need to show message in admin area. */
        if ( false === $check && $show_message ) {
            $this->admin_messages[] = $xml['recommendation'];
        }

        return $check;

    }

    /**
     * Check whether the BCMath extension is installed.
     *
     * @param bool $show_message - Show or hide messages in admin area.
     *
     * @since  3.0.0
     * @access private
     *
     * @return bool - true if bcmath extension is loaded, false otherwise.
     **/
    private function check_bcmath( $show_message = true ) {

        /** Whether the BCMath extension is installed. */
        $bcmath = ServerReporter::get_instance()->get_bcmath_installed();
        $check = ! $bcmath['warning'];

        /** If we need to show message in admin area. */
        if ( false === $check && $show_message ) {
            $this->admin_messages[] = $bcmath['recommendation'];
        }

        return $check;

    }

    /**
     * Check whether the mbstring extension is installed.
     *
     * @param bool $show_message - Show or hide messages in admin area.
     *
     * @since  3.0.0
     * @access private
     *
     * @return bool - true if mbstring extension is loaded, false otherwise.
     **/
    private function check_mbstring( $show_message = true ) {

        /** Whether the mbstring extension is installed. */
        $mbstring = ServerReporter::get_instance()->get_mbstring_installed();
        $check = ! $mbstring['warning'];

        /** If we need to show message in admin area. */
        if ( false === $check && $show_message ) {
            $this->admin_messages[] = $mbstring['recommendation'];
        }

        return $check;

    }

    /**
     * Check server time and compare it with NTP.
     *
     * @param bool $show_message - Show or hide messages in admin area.
     *
     * @since  3.0.0
     * @access private
     *
     * @return bool - true if time is synced, false otherwise.
     **/
    private function check_server_time( $show_message = true ) {

        /** Get server time and compare it with NTP. */
        $server_time = ServerReporter::get_instance()->get_server_time();
        $check = ! $server_time['warning'];

        /** If we need to show message in admin area. */
        if ( false === $check && $show_message ) {
            $this->admin_messages[] = $server_time['recommendation'];
        }

        return $check;

    }

    /**
     * Main CheckCompatibility Instance.
     *
     * Insures that only one instance of CheckCompatibility exists in memory at any one time.
     *
     * @static
     * @since 3.0.0
     *
     * @return CheckCompatibility
     **/
    public static function get_instance() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

            self::$instance = new self;

        }

        return self::$instance;

    }

} // End Class CheckCompatibility.
