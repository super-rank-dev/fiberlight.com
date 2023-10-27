<?php

/**
 * Multilanguage Menu Class
 */
class Wpbotml_Menu {

    /**
     * Constructor
     * 
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct(){
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'admin_init', array($this, 'register_plugin_settings') );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_script' ) );
        
    }

    
    function enqueue_script(){

        wp_enqueue_script('jquery');
        wp_enqueue_style('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' );
        wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array('jquery') );
    
        // please create also an empty JS file in your theme directory and include it too
        wp_enqueue_script('wpbotml-admin-script', QCLD_WPBOTML_ASSETS_URL . 'js/admin-script.js', array( 'jquery', 'select2' ), qcld_wpbotml()->version ); 
    
    }

    /**
     * Callback function for admin_menu hook
     * 
     * @since 1.0.0
     *
     * @return void
     */
    public function admin_menu(){
        add_menu_page( 'Bot - Multi-Language', 'Bot - Multi-Language', 'manage_options', 'wpbotml-settings-page', array( $this, 'render_settings' ), 'dashicons-networking', '9' );
       // add_submenu_page( 'wpbotml-settings-page', 'licensing', 'licensing', 'manage_options','wpbotml_licensing', 'wpbotml_license_callback' );
    }

    /**
     * License page callback
     *
     * @return void
     */
    public function ml_license_page(){

    }

    /**
     * Register settings field
     * 
     * @since 1.0.0
     *
     * @return void
     */
    public function register_plugin_settings(){
        register_setting( 'qc-wpbotml-settings-group', 'wpbotml_languages' );
        register_setting( 'qc-wpbotml-settings-group', 'wpbotml_Default_language' );
        register_setting( 'qc-wpbotml-settings-group', 'wpbotml_url_language' );
        register_setting( 'qc-wpbotml-settings-group', 'wpbotml_url_urls' );
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

}

new Wpbotml_Menu();
