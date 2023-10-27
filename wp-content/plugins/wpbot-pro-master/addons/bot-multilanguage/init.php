<?php


if (!defined('ABSPATH')) exit; // Exit if accessed directly

if(!class_exists('Qcld_Wpbot_Multilanguage')){

    /**
     * Main Class.
     */
    final class Qcld_Wpbot_Multilanguage
    {
        private $id = 'wpbot-multilanguage';

        /**
         * WPBot Pro version.
         *
         * @var string
         */
        public $version = '1.0.0';
        
        /**
         * WPBot Pro helper.
         *
         * @var string
         */
        public $helper;

        /**
         * WPBot languages
         *
         * @var [type]
         */
        public $languages;

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

        /**
         *  Constructor
         */
        private function __construct()
        {
            $this->define_constants();
            $this->includes();
            $this->init_hooks();
            $this->helper = new WPBotML_Helper();
            $this->languages = $this->getLanguages();
        }

        /**
         * Get users selected languages
         *
         * @return void
         */
        public function getLanguages(){
            $languages = get_option( 'wpbotml_languages' );
            if( $languages && is_array( $languages ) ){

                if (($key = array_search( get_locale(), $languages )) !== false) {
                    unset( $languages[$key] );
                }

                if( ! in_array( get_locale(), $languages ) ){
                    array_unshift( $languages , get_locale() );
                }
                return $languages;
            }else{
                return array( get_locale() );
            }
        }

        /**
         * get the language name by lan code
         * 
         * @since 1.0.0
         *
         * @param string $language
         * 
         * @return void
         */
        public function lanName( $language ) {
            $languages = qcld_wpbotml()->helper->languages();
            foreach( $languages as $lancode => $landetails ){
                if( $lancode == $language ){
                    return '<span class="qcld_lan_name">'.$landetails['english_name'].'</span>';
                }
            }

            if( $language == 'en_US' ){
                return '<span class="qcld_lan_name">'.'English (United States)'.'</span>';
            }
            return '<span class="qcld_lan_name">'.$language.'</span>';
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
            define('QCLD_WPBOTML_VERSION', $this->version);
            define('QCLD_WPBOTML_REQUIRED_BOT_VERSION', '10.2.2' );
            define('QCLD_WPBOTML_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
            define('QCLD_WPBOTML_PLUGIN_URL', plugin_dir_url(__FILE__));
            define('QCLD_WPBOTML_ASSETS_URL', QCLD_WPBOTML_PLUGIN_URL . "assets/");

        }

        /**
         * Include all required files
         *
         * since 1.0.0
         *
         * @return void
         */
        public function includes() {
            require_once( QCLD_WPBOTML_PLUGIN_DIR_PATH . 'includes/class-helper.php' );
            require_once( QCLD_WPBOTML_PLUGIN_DIR_PATH . 'includes/class-actions.php' );

            if ( is_admin() ) {
                require_once( QCLD_WPBOTML_PLUGIN_DIR_PATH . 'plugin-upgrader/plugin-upgrader.php' );
                require_once( QCLD_WPBOTML_PLUGIN_DIR_PATH . 'includes/admin/class-wpbotml-menu.php' );
            }
        }

        /**
         * Hook into actions and filters.
         *
         * @since 1.0.0
         */
        private function init_hooks() {
            register_activation_hook(__FILE__, array( $this, 'qcld_wb_chatbotml_defualt_options') );
            add_action( 'init', array( $this, 'wp_chatbotml_lang_init') );
            add_action( 'activated_plugin', array( $this, 'qc_wpbotproml_activation_redirect') );
        }

        /**
         * Triggers on plugin activation
         *
         * @param [type] $network_wide
         * @return void
         */
        public function qcld_wb_chatbotml_defualt_options($network_wide){
        
            global $wpdb;
            
        }

        /**
         *
         * Function to load translation files.
         *
         */
        public function wp_chatbotml_lang_init() {
            load_plugin_textdomain( 'wpchatbotml', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        //plugin activate redirect to license page
        public function qc_wpbotproml_activation_redirect( $plugin ) {
            if( $plugin == plugin_basename( __FILE__ ) ) {
                //exit( wp_redirect( admin_url('admin.php?page=wpbot_license_page') ) );
            }
        }

    }

    /**
     * @return Qcld_Wpbot_Multilanguage
     */
    function qcld_wpbotml() {
        return Qcld_Wpbot_Multilanguage::instance();
    }

    //fire off the plugin
    qcld_wpbotml();

}