<?php
/**
 * Plugin Name: WPBot Pro Wordpress Chatbot (Master)
 * Plugin URI: https://wordpress.org/plugins/wpbot-wordpress-chatbot/
 * Description: Wordpress Chatbot by QuantumCloud.
 * Donate link: http://www.quantumcloud.com
 * Version: 13.4.2
 * @author    QuantumCloud
 * Author: QuantumCloud
 * Author URI: https://www.quantumcloud.com/
 * Requires at least: 4.6
 * Tested up to: 6.2
 * Text Domain: wpchatbot
 * Domain Path: /languages
 * License: GPL2
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_wpbot_pro_master() {
    if ( ! class_exists( 'Appsero\Client' ) ) {
      require_once __DIR__ . '/appsero/src/Client.php';
    }
    $client = new Appsero\Client( 'd74e64e9-e111-4f7d-b382-8d339b3909f5', 'WPBot pro master', __FILE__ );
    // Active insights
    $client->insights()->init();
    // Active automatic updater
    $client->updater();
    // Active license page and checker
    $args = array(
        'type'       => 'submenu',
        'menu_title' => 'WPBot pro master license',
        'page_title' => 'WPBot pro master license Settings',
        'menu_slug'  => 'wpbot_pro_master_license_settings',
        'parent_slug' => 'wpbot-panel',
    );
    global $wpchatbot_pro_master_init;
    $wpchatbot_pro_master_init = $client->license();
    $wpchatbot_pro_master_init->add_settings_page( $args );

    if ( $wpchatbot_pro_master_init->is_valid()  ) {
        
    }

}
appsero_init_tracker_wpbot_pro_master();
/*****************************************************
 * Initialize the plugin
 *****************************************************/

if(!class_exists('qcld_wb_Chatbot')){

    /**
     * Main Class.
     */
    final class qcld_wb_Chatbot
    {
        private $id = 'wpbot';

        /**
         * WPBot Pro version.
         *
         * @var string
         */

        public $version = '13.4.3';
        
        /**
         * WPBot Pro helper.
         *
         * @var object
         */
        public $helper;

        /**
         * The single instance of the class.
         *
         * @var qcld_wb_Chatbot
         * @since 1.0.0
         */
        protected static $_instance = null;
        
        /**
         * Main wpbot Instance.
         *
         * Ensures only one instance of wpbot is loaded or can be loaded.
         *
         * @return qcld_wb_Chatbot - Main instance.
         * @since 1.0.0
         * @static
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public $response_list;

        /**
         *  Constructor
         */
        private function __construct()
        {
            $this->define_constants();
            $this->includes();
            $this->init_hooks();
            $this->helper = new Qcld_WPBot_Helper();
        }

        /**
         * Cloning is forbidden.
         *
         * @since 1.0.0
         */
        public function __clone() {
            _doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'wpbot-pro' ), '1.0.0' );
        }

        /**
         * Universalizing instances of this class is forbidden.
         *
         * @since 1.0.0
         */
        public function __wakeup() {
            _doing_it_wrong( __FUNCTION__, __( 'Universalizing instances of this class is forbidden.', 'wpbot' ), '1.0.0' );
        }
        
        /**
         * Define wpbot Constants.
         *
         * @return void
         * @since 1.0.0
         */
        public function define_constants() {
            define('QCLD_wpCHATBOT_VERSION', $this->version);
            define('QCLD_wpCHATBOT_REQUIRED_wpCOMMERCE_VERSION', 2.2);
            if( ! defined( 'QCLD_wpCHATBOT_FILE_URL' ) ){
                define('QCLD_wpCHATBOT_FILE_URL', __FILE__);
            }
            if( ! defined( 'QCLD_wpCHATBOT_PLUGIN_DIR_PATH' ) ){
                define('QCLD_wpCHATBOT_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
            }
            if( ! defined( 'QCLD_wpCHATBOT_PLUGIN_URL' ) ){
                define('QCLD_wpCHATBOT_PLUGIN_URL', plugin_dir_url(__FILE__));
            }
            if( ! defined( 'QCLD_wpCHATBOT_IMG_URL' ) ){
                define('QCLD_wpCHATBOT_IMG_URL', QCLD_wpCHATBOT_PLUGIN_URL . "images/");
            }
            if( ! defined( 'QCLD_wpCHATBOT_IMG_ABSOLUTE_PATH' ) ){
                define('QCLD_wpCHATBOT_IMG_ABSOLUTE_PATH', plugin_dir_path(__FILE__) . "images");
            }
            
            define('QCLD_wpCHATBOT_INDEX_TABLE', 'wpwbot_index');
            $gcdirpath = WP_CONTENT_DIR.'/wpbot-dfv2-client';
            define('QCLD_wpCHATBOT_GC_DIRNAME', $gcdirpath);
            $wpcontentpath = WP_CONTENT_DIR;
            define('QCLD_wpCHATBOT_GC_ROOT', $wpcontentpath);
        }

        /**
         * Include all required files
         *
         * since 1.0.0
         *
         * @return void
         */
        public function includes() {
            require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "includes/openai/qcld-bot-openai.php");
            require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "qcld-wpwbot-search.php" );
            require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "functions.php" );
            require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'qcld_df_api.php' );
            require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'qcld-df-webhook.php' );
            require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'includes/class-wpbot-gc-download.php' );
            require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'includes/class-wpbot-install.php' );
            require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'includes/class-frontend-resources.php' );
            require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'includes/class-wpbot-helper.php' );
            require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'bot-start-menu/init.php' );
            require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'includes/class-chatbot-floating-button.php' );
            if ( file_exists( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'managepackage.php' ) ) {
                require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'managepackage.php' );
            }


            if ( is_admin() ) {
                require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'includes/admin/class-wpbot-menu.php' );
                require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'includes/admin/class-admin-resources.php' );
                require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'includes/class-response-list.php' );
                require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'includes/class-chatbot-option-save.php' );
                require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "qc-support-promo-page/class-qc-support-promo-page.php" );
             //   require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'plugin-upgrader/plugin-upgrader.php' );
                require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'includes/class-wpbot-maybe-upgrade.php' );
            }
        }

        /**
         * Hook into actions and filters.
         *
         * @since 1.0.0
         */
        private function init_hooks() {
            add_filter( 'set-screen-option', [ $this, 'set_screen' ], 10, 3 );
            add_action( 'init', array( $this, 'wp_chatbot_lang_init') );
            add_action( 'activated_plugin', array( $this, 'qc_wpbotpro_activation_redirect') );
            /*
            * Registering custom end point for Webhook
            * @Since 9.3.8
            */
            add_action( 'rest_api_init', function () {
                register_rest_route( 'wpbot/v1', '/dialogflow_webhook/', array(
                'methods' => 'POST',
                'callback' => 'qcld_wpbot_dfwebhookcallback',
                'permission_callback' => '__return_true'
                ) );
            } );

            add_action( 'wp_print_scripts', array( $this, 'qc_apppage_remove_all_scripts' ), 99 );

        }

        /**
         * Set Response_list object to response_list property
         *
         * @return void
         */
        public function set_response_list() {
            $this->response_list = new Response_list();
        }

        /**
         * Callback function for set-screen-option hook
         *
         * @param [type] $status
         * @param [type] $option
         * @param [type] $value
         * @return void
         */
        public static function set_screen( $status, $option, $value ){
            return $value;
        }

        public function get_settings(){
            include_once QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/includes/admin/settings-fields.php';
            return array_merge( $wpbot_settings, $wpbot_languages );
        }


        /**
         *
         * Function to load translation files.
         *
         */
        public function wp_chatbot_lang_init() {
            load_plugin_textdomain( 'wpchatbot', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
            
			//echo preg_replace('#[^0-9\.]#', '', $content);
        }

        //plugin activate redirect to license page
        public function qc_wpbotpro_activation_redirect( $plugin ) {
            if( $plugin == plugin_basename( __FILE__ ) ) {
                exit( wp_redirect( admin_url('admin.php?page=wpbot_license_page') ) );
            }
        }

        /**
         * Remove script for mobile app page
         *
         * @return void
         */
        public function qc_apppage_remove_all_scripts() {
            global $wp_scripts;
            $wpbot_script = array('qcld-wp-chatbot-slimsqccrl-js', 'qcld-wp-chatbot-qcquery-cake', 'qcld-wp-chatbot-magnifict-qcpopup', 'qcld-wp-chatbot-plugin', 'qcld-wp-chatbot-front-js', 'wbca_ajax');
            $current_script = $wp_scripts->queue;
            if (is_page('wpwbot-mobile-app')) {
                foreach($current_script as $key=>$value){
                    if(!in_array($value, $wpbot_script)){
                        unset($current_script[$key]);
                    }
                }
                $wp_scripts->queue = array_values($current_script);
            }
            
        }

    }

    /**
     * @return qcld_wb_Chatbot
     */
    function qcld_wpbot() {
        return qcld_wb_Chatbot::instance();
    }

    //fire off the plugin
    qcld_wpbot();

}

register_activation_hook(__FILE__, 'qcld_wb_chatbot_default_options');
if( ! function_exists( 'qcld_wb_chatbot_default_options' ) ){
    function qcld_wb_chatbot_default_options() {
        global $wpdb;

        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        /**
         * Free version replace code.
         */
        $free = array( 'chatbot/qcld-wpwbot.php', 'woowbot-woocommerce-chatbot/qcld-woowbot.php' );
        $all_plugins = get_plugins();
        foreach( $all_plugins as $plugin => $plugin_details ){
            if( in_array( $plugin, $free ) ){
                if( is_plugin_active( $plugin ) ){
                    if( deactivate_plugins( array( $plugin ) ) ){
                        delete_plugins( array( $plugin ) );
                    }
                } else {
                    delete_plugins( array( $plugin ) );
                }
            }
        }

        /**
         * Free version replace code End.
         */

        define('QCLD_wpCHATBOT_ACTION', 'https://www.quantumcloud.com/custom-chatbot-services/');
        define('QCLD_theme_BANNER_LANDING', 'https://www.quantumcloud.com/products/themes/chatbot-theme/');
        define('QCLD_wpCHATBOT_ACTION_hook','wpqcld_chk_seft');
        require_once( plugin_dir_path(__FILE__) . 'includes/class-wpbot-install.php' );
        
        if ( is_multisite() && $network_wide ) {
            // Get all blogs in the network and activate plugin on each one
            $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
            foreach ( $blog_ids as $blog_id ) {
                switch_to_blog( $blog_id );
                Qcld_WPBot_Install::install();
                restore_current_blog();
            }
        } else {
            Qcld_WPBot_Install::install();
        }

        update_option( 'wpbot_plugin_activated', 1 );

        update_option('wpbot_main_plugin_installed', 1);
        set_transient( 'bot_clear_cache', 1, DAY_IN_SECONDS );
    }

    function wpbot_qc_upgrade_completed( $upgrader_object, $options ) {
        // The path to our plugin's main file
        $our_plugin = plugin_basename( __FILE__ );
        // If an update has taken place and the updated type is plugins and the plugins element exists
        if( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
            // Iterate through the plugins being updated and check if ours is there
            foreach( $options['plugins'] as $plugin ) {
                if( $plugin == $our_plugin ) {
                    //set_transient( 'bot_clear_cache', 1, DAY_IN_SECONDS );
                }
            }
        }
    }
    add_action( 'upgrader_process_complete', 'wpbot_qc_upgrade_completed', 10, 2 );
}

