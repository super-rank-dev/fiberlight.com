<?php

/**
 * Admin menu class
 * 
 * @since 1.0.0
 */
class QCLD_WA_Menu {

    /**
     * Constructor
     * 
     * @since 1.0.0
     * 
     * @return null
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'admin_init', array($this, 'register_plugin_settings') );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_script' ) );
        //add_action( 'admin_post_qc_tg_connect', array($this, 'connect') );
    }

    /**
     * Enqueue styles and scripts for menu pages
     * 
     * @since 1.0.0
     *
     * @return void
     */
    function enqueue_script(){

        wp_enqueue_script('jquery');
    
        // please create also an empty JS file in your theme directory and include it too
        wp_enqueue_script('wpbotml-admin-script', QCLD_WA_ASSETS_URL . 'js/admin-script.js', array( 'jquery', ), qcld_whatsapp()->version ); 
    
    }

    /**
     * Register admin menus
     * 
     * @since 1.0.0
     *
     * @return null
     */
    public function admin_menu(){
        add_menu_page( 'Bot - WhatsApp', 'Bot - WhatsApp', 'manage_options', 'wpbotwa-settings-page', array( $this, 'render_settings' ), 'dashicons-whatsapp', '9' );

        if(class_exists('qcld_wb_Chatbot') && get_option( 'wa_disable_start_menu' ) != '1' ){
            add_submenu_page( 'wpbotwa-settings-page', 'Menu Setup', 'Menu Setup', 'manage_options','qcld-chatbot-wa-menu', array($this, 'menu_setup') );
        }

        //add_submenu_page( 'wpbotwa-settings-page', 'Help & Licensing', 'Help & Licensing', 'manage_options','wpbotwa_licensing', 'wpbotwa_license_callback' );
    }

    /**
     * Render settings page
     * 
     * @since 1.0.0
     *
     * @return void
     */
    public function render_settings(){
        include 'templates/settings.php';
    }

    /**
     * chatbot menu page for WhatsApp
     * 
     * @since 1.0.0
     *
     * @return void
     */
    function menu_setup(){
        include 'templates/menu.php';
    }

    /**
     * Register settings field
     * 
     * @since 1.0.0
     *
     * @return void
     */
    public function register_plugin_settings(){
        register_setting( 'qc-wpbotwa-settings-group', 'wa_account_sid' );
        register_setting( 'qc-wpbotwa-settings-group', 'wa_auth_token' );
        register_setting( 'qc-wpbotwa-settings-group', 'wa_whatsapp_number' );
        register_setting( 'qc-wpbotwa-settings-group', 'wa_disable_start_menu' );

        if(isset($_POST['qc_wpbot_wa_menu_order'])){
			update_option('qc_wpbot_wa_menu_order', $_POST['qc_wpbot_wa_menu_order']);
		}
    }
}
new QCLD_WA_Menu();