<?php


if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Qcld_Wpbot_Whatsapp' ) ) {

    /**
     * Main Class.
     */
    final class Qcld_Wpbot_Whatsapp {
        private $id = 'wpbot-whatsapp';

        /**
         * Whatsapp version.
         *
         * @var string
         */
        public $version = '0.0.9';
        

        /**
         * The single instance of the class.
         *
         * @var Qcld_Wpbot_Whatsapp
         * @since 1.0.0
         */
        protected static $_instance = null;

        /**
         * Main Whatsapp Instance.
         *
         * Ensures only one instance of whatsapp, is loaded or can be loaded.
         *
         * @return Qcld_Wpbot_Whatsapp - Main instance.
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
            _doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'wpbot-wa' ), '1.0.0' );
        }

        /**
         * Universalizing instances of this class is forbidden.
         *
         * @since 1.0.0
         */
        public function __wakeup() {
            _doing_it_wrong( __FUNCTION__, __( 'Universalizing instances of this class is forbidden.', 'wpbot-wa' ), '1.0.0' );
        }
        
        /**
         * Define whatsapp Constants.
         *
         * @return void
         * @since 1.0.0
         */
        public function define_constants() {
            
            define( 'QCLD_WA_VERSION', $this->version );
            define( 'QCLD_WA_REQUIRED_BOT_VERSION', '10.8.2' );
            define( 'QCLD_WA_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
            define( 'QCLD_WA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
            define( 'QCLD_WA_ASSETS_URL', QCLD_WA_PLUGIN_URL . "assets/" );
            
        }

        /**
         * Include all required files
         *
         * since 1.0.0
         *
         * @return void
         */
        public function includes() {
            require_once QCLD_WA_PLUGIN_DIR_PATH . 'vendor/autoload.php';
            require_once QCLD_WA_PLUGIN_DIR_PATH . 'includes/functions.php';
            require_once QCLD_WA_PLUGIN_DIR_PATH . 'includes/action_filter.php';
            require_once QCLD_WA_PLUGIN_DIR_PATH . 'includes/webhook.php';
            require_once( QCLD_WA_PLUGIN_DIR_PATH . 'includes/request.php' );
            require_once( QCLD_WA_PLUGIN_DIR_PATH . 'includes/response.php' );
            if ( is_admin() ) {
                //admin classes will load here
                require_once QCLD_WA_PLUGIN_DIR_PATH . 'includes/menu.php';
            }

        }

        /**
         * Hook into actions and filters.
         *
         * @since 1.0.0
         */
        private function init_hooks() {
            register_activation_hook( __FILE__, array( $this, 'activation') );
            add_action( 'init', array( $this, 'localization' ) );
        }

        /**
         * Triggers on plugin activation
         *
         * @param [type] $network_wide
         * @return void
         */
        public function activation($network_wide) {
        
            global $wpdb;
            
        }

        /**
         *
         * Function to load translation files.
         *
         */
        public function localization() {
            load_plugin_textdomain( 'wpbot-wa', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

    }

    /**
     * @return Qcld_Wpbot_Whatsapp
     */
    function qcld_whatsapp() {
        return Qcld_Wpbot_Whatsapp::instance();
    }

    //fire off the plugin
    qcld_whatsapp();

}