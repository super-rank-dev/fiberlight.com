<?php

if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Qcld_Wpbot_Telegram' ) ) {

    /**
     * Main Class.
     */
    final class Qcld_Wpbot_Telegram {
        private $id = 'wpbot-telegram';

        /**
         * Telegram version.
         *
         * @var string
         */
        public $version = '0.0.9';
        

        /**
         * The single instance of the class.
         *
         * @var Qcld_Wpbot_Telegram
         * @since 1.0.0
         */
        protected static $_instance = null;

        /**
         * Main Telegram Instance.
         *
         * Ensures only one instance of telegra, is loaded or can be loaded.
         *
         * @return Qcld_Wpbot_Telegram - Main instance.
         * @since 1.0.0
         * @static
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         *  Constructor
         */
        private function __construct() {
            $this->define_constants();
            $this->includes();
            $this->init_hooks();
        }


        /**
         * Cloning is forbidden.
         *
         * @since 1.0.0
         */
        public function __clone() {
            _doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'wpbot-telegram' ), '1.0.0' );
        }

        /**
         * Universalizing instances of this class is forbidden.
         *
         * @since 1.0.0
         */
        public function __wakeup() {
            _doing_it_wrong( __FUNCTION__, __( 'Universalizing instances of this class is forbidden.', 'wpbot-telegram' ), '1.0.0' );
        }
        
        /**
         * Define wpbot Constants.
         *
         * @return void
         * @since 1.0.0
         */
        public function define_constants() {
            define( 'QCLD_TELEGRAM_VERSION', $this->version );
            define( 'QCLD_TELEGRAM_REQUIRED_BOT_VERSION', '10.8.2' );
            define( 'QCLD_TELEGRAM_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
            define( 'QCLD_TELEGRAM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
            define( 'QCLD_TELEGRAM_ASSETS_URL', QCLD_TELEGRAM_PLUGIN_URL . "assets/" );

        }

        /**
         * Include all required files
         *
         * since 1.0.0
         *
         * @return void
         */
        public function includes() {
            require_once( QCLD_TELEGRAM_PLUGIN_DIR_PATH . 'includes/class-helper.php' );
            require_once( QCLD_TELEGRAM_PLUGIN_DIR_PATH . 'includes/class-actions.php' );
            require_once( QCLD_TELEGRAM_PLUGIN_DIR_PATH . 'includes/class-webhook.php' );
            require_once( QCLD_TELEGRAM_PLUGIN_DIR_PATH . 'includes/class-handle-request.php' );
            require_once( QCLD_TELEGRAM_PLUGIN_DIR_PATH . 'includes/class-handle-response.php' );
            require_once( QCLD_TELEGRAM_PLUGIN_DIR_PATH . 'includes/functions.php' );
            if ( is_admin() ) {
                //admin classes will load here
                require_once( QCLD_TELEGRAM_PLUGIN_DIR_PATH . 'includes/admin/menu.php' );
            }

            

        }

        /**
         * Hook into actions and filters.
         *
         * @since 1.0.0
         */
        private function init_hooks() {
            register_activation_hook( __FILE__, array( $this, 'qcld_wb_chatbotml_defualt_options') );
            add_action( 'init', array( $this, 'wp_chatbotml_lang_init' ) );
            add_action( 'activated_plugin', array( $this, 'qc_wpbotproml_activation_redirect' ) );
        }

        /**
         * Triggers on plugin activation
         *
         * @param [type] $network_wide
         * @return void
         */
        public function qcld_wb_chatbotml_defualt_options($network_wide) {
        
            global $wpdb;
            
        }

        /**
         *
         * Function to load translation files.
         *
         */
        public function wp_chatbotml_lang_init() {
            load_plugin_textdomain( 'wpbot-telegram', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

    }

    /**
     * @return Qcld_Wpbot_Telegram
     */
    function qcld_telegram() {
        return Qcld_Wpbot_Telegram::instance();
    }

    //fire off the plugin
    qcld_telegram();

}