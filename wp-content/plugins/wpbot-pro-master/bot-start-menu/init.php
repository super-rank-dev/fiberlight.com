<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if(!class_exists('qcld_bot_start_menu')){

    /**
     * Main Class.
     */
    final class qcld_bot_start_menu
    {
        private $id = 'start-menu';
        /**
         * Start Menu version.
         *
         * @var string
         */
        public $version = '1.0.0';
        
        /**
         * Start Menu helper.
         *
         * @var string
         */
        public $helper;
        
        /**
         * Start Menu Settings.
         *
         * @var string
         */
        public $settings;

        /**
         * The single instance of the class.
         *
         * @var qcld_bot_start_menu
         * @since 1.0.0
         */
        protected static $_instance = null;
        
        /**
         * Main Start Menu Instance singleton.
         *
         * Ensures only one instance of wpbot is loaded or can be loaded.
         *
         * @return qcld_bot_start_menu - Main instance.
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
            $this->init_hooks();
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
         * Define Start Menu Constants.
         *
         * @return void
         * @since 1.0.0
         */
        public function define_constants() {
            define('QCLD_STRTMENU_VERSION', $this->version);
            define('QCLD_STRTMENU_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
            define('QCLD_STRTMENU_PLUGIN_URL', plugin_dir_url(__FILE__));
            define('QCLD_STRTMENU_IMG_URL', QCLD_STRTMENU_PLUGIN_URL . "images/");
            define('QCLD_STRTMENU_IMG_ABSOLUTE_PATH', plugin_dir_path(__FILE__) . "images");
        }

        /**
         * Hook into actions and filters.
         *
         * @since 1.0.0
         */
        private function init_hooks() {
            add_action( 'init', array( $this, 'start_menu_lang_init') );
            add_action( 'plugins_loaded', array( $this, 'load_require_files' ) );
        }

        function load_require_files(){
            require_once( QCLD_STRTMENU_PLUGIN_DIR_PATH . 'includes/class-helper.php' );
            $settings = include QCLD_STRTMENU_PLUGIN_DIR_PATH . 'includes/global.php';
            $this->helper = new Qcld_bot_startmenu_helper();
            $this->settings = $settings;
            if( $this->helper->is_wpbot_active() ){
                $this->includes();
            }else{
                add_action('admin_notices', array( $this, 'plugin_require_notice' ) );
            }

            if( ! get_option( 'bot_startmenu_v' ) ){
                $settings = include QCLD_STRTMENU_PLUGIN_DIR_PATH . 'includes/global.php';
                update_option('bot_startmenu_v', $this->version);
                foreach( $settings as $setting ){
                    if( ! get_option( $setting['key'] ) ){
                        update_option( $setting['key'], $setting['db'] );
                    }
                }
            }
            
        }

        /**
         * show required plugin notice
         *
         * @return void
         */
        public function plugin_require_notice(){
        ?>
            <div id="message" class="error">
                <p>
                    <?php echo esc_html__('Please install & activate WPBot Pro plugin in order to get the start menu Addon work.', 'botstartmenu'); ?>
                </p>
            </div>
        <?php
        }

        /**
         * Includes require file
         *
         * @return void
         */
        public function includes(){
            if( get_option( 'enable_extended_interface' ) == 1 ){
                require_once( QCLD_STRTMENU_PLUGIN_DIR_PATH . 'includes/class-actions.php' );
            }
            if ( is_admin() ) {
                require_once( QCLD_STRTMENU_PLUGIN_DIR_PATH . 'includes/admin/class-menu.php' );
            }

        }

        /**
         *
         * Function to load translation files.
         *
         */
        public function start_menu_lang_init() {
            load_plugin_textdomain( 'botstartmenu', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

    }

    /**
     * @return qcld_bot_start_menu
     */
    function qcld_bot_startmenu() {
        return qcld_bot_start_menu::instance();
    }

    //fire off the plugin
    qcld_bot_startmenu();
}