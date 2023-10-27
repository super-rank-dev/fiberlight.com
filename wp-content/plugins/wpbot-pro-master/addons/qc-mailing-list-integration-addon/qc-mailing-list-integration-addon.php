<?php


// Exit if accessed directly
if (!defined('ABSPATH')){
	exit; 
}

if ( ! defined( 'QCLD_MAILING_LIST_INTEGRATION_ADDON_DIR' ) ) {
	define( 'QCLD_MAILING_LIST_INTEGRATION_ADDON_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'QCLD_MAILING_LIST_INTEGRATION_ADDON_URL' ) ) {
	define( 'QCLD_MAILING_LIST_INTEGRATION_ADDON_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'QCLD_MAILING_LIST_INTEGRATION_ADDON_VERSION' ) ) {
	define( 'QCLD_MAILING_LIST_INTEGRATION_ADDON_VERSION', '1.0.0' );
}


require_once( QCLD_MAILING_LIST_INTEGRATION_ADDON_DIR.'/mailchimp/init.php' );
require_once( QCLD_MAILING_LIST_INTEGRATION_ADDON_DIR.'/zapier/init.php' );
require_once( QCLD_MAILING_LIST_INTEGRATION_ADDON_DIR.'/plugin-upgrader/plugin-upgrader.php' );
require_once( QCLD_MAILING_LIST_INTEGRATION_ADDON_DIR.'/mailing-list-license.php' );

/**
 * Main Class
 */
class QCLD_MAILING_LIST_INTEGRATION_ADDON
{

    private static $instance;
    public $Mailing_List_Mailchimp;
    public $Mailing_List_Zapier;
    
    /**
     *  Get Instance creates a singleton class that's cached to stop duplicate instances
     */
    public static function get_instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
            self::$instance->qcld_mailing_list_integration_addon_init();
        }
        return self::$instance;
    }
	
	/**
	 * Empty Construct
	 */
	public function __construct(){}

	/**
     *  Init
     */
    public function qcld_mailing_list_integration_addon_init(){
    	add_action('admin_enqueue_scripts', array($this, 'qcld_mailing_list_integration_admin_script'));

    	add_action('admin_menu', array($this, 'qcld_mailing_list_integration_admin_menu'));

    	$this->Mailing_List_Mailchimp = new QCLD_MAILING_LIST_INTEGRATION_MAILCHIMP();
    	$this->Mailing_List_Zapier = new QCLD_MAILING_LIST_INTEGRATION_ZAPIER();
    	new QC_mailing_list_Help_License_Sub_Menu();
	}

	/**
	 * Enqueue Admin Scripts
	 */
	public function qcld_mailing_list_integration_admin_script(){
		wp_enqueue_style('qcld_mailing_list_integration_admin_style', QCLD_MAILING_LIST_INTEGRATION_ADDON_URL.'/admin/assets/css/admin.css', array(), QCLD_MAILING_LIST_INTEGRATION_ADDON_VERSION, 'all');

		wp_enqueue_script( 'qcld_mailing_list_integration_admin_script', QCLD_MAILING_LIST_INTEGRATION_ADDON_URL.'/admin/assets/js/admin.js', array('jquery'), QCLD_MAILING_LIST_INTEGRATION_ADDON_VERSION, true );
	}

	/**
     *  Admin Menu
     */
	public function qcld_mailing_list_integration_admin_menu(){

		add_menu_page(
			esc_html__('Mailing List Integration', 'qc-mailing-list-integration'),
			esc_html__('Mailing List Integration', 'qc-mailing-list-integration'),
			'manage_options',
			'qc-mailing-list-integration',
			array($this, 'qcld_mailing_list_integration_admin_page'),
			'dashicons-email',
			7
		);
	}

	/**
     *  No content for menu page
     */
	public function qcld_mailing_list_integration_admin_page(){}

}

/**
 * Instantiate plugin.
 *
 */
if (!function_exists('qcld_mailing_list_integration_addon_init')) {
    function qcld_mailing_list_integration_addon_init()
    {
        global $qcld_wb_chatbot;
        $qcld_wb_chatbot = QCLD_MAILING_LIST_INTEGRATION_ADDON::get_instance();
    }
}
add_action('plugins_loaded', 'qcld_mailing_list_integration_addon_init');